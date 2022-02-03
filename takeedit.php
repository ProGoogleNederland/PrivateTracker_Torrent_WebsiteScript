<?php  
  
require_once("include/bittorrent.php");  
require_once("include/secrets.php");  
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;  
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);  
  
  
function bark($msg) {  
	genbark($msg, "Edit failed!");  
}  
  
if (!mkglobal("id:name:imdb:descr:type"))  
	bark("missing form data");  
  
$id = 0 + $id;  
if (!$id)  
	die();  
  
dbconn();  
  
  
  
loggedinorreturn();  
  
$res = mysqli_query($con_link, "SELECT owner, filename, save_as FROM torrents WHERE id = $id");  
$row = mysqli_fetch_array($res);  
if (!$row)  
	die();  
  
if ($CURUSER["id"] != $row["owner"] && get_user_class() < UC_MODERATOR)  
	bark("You're not the owner! How did that happen?\n");  
  
$updateset = array();  
  
$fname = $row["filename"];  
preg_match('/^(.+)\.torrent$/si', $fname, $matches);  
$shortfname = $matches[1];  
$dname = $row["save_as"];  
  
$nfoaction = @$_POST['nfoaction'];  
if ($nfoaction == "update")  
{  
  $nfofile = $_FILES['nfo'];  
  if (!$nfofile) die("No data " . var_dump($_FILES));  
  if ($nfofile['size'] > 200000000)  
    bark("NFO is te groot! Maximaal 20000,000 bytes.");  
  $nfofilename = $nfofile['tmp_name'];  
  if (@is_uploaded_file($nfofilename) && @filesize($nfofilename) > 0)  
    $updateset[] = "nfo = " . sqlesc(str_replace("\x0d\x0d\x0a", "\x0d\x0a", file_get_contents($nfofilename)));  
}  
else  
  if ($nfoaction == "remove")  
    $updateset[] = "nfo = ''";  
  
$updateset[] = "name = " . sqlesc($name);  
$updateset[] = "search_text = " . sqlesc(searchfield("$shortfname $dname"));  
$updateset[] = "imdb = " . sqlesc($imdb);  
$updateset[] = "descr = " . sqlesc($descr);  
$updateset[] = "ori_descr = " . sqlesc($descr);  
$updateset[] = "category = " . (0 + $type);  
if ($CURUSER["id"] == "yes") {  
	if ($_POST["banned"]) {  
		$updateset[] = "banned = 'yes'";  
		$_POST["visible"] = 0;  
	}  
	else  
		$updateset[] = "banned = 'no'";  
}  
  
  
if(isset($_POST["visible"])){  
	$temp="ÿes";  
}else{  
	$temp="no";  
}  
$updateset[] = "visible = '" . $temp . "'";  
  
mysqli_query($con_link, "UPDATE torrents SET " . join(",", $updateset) . " WHERE id = $id");  
  
write_log("Torrent $id ($name) is bewerkt door $CURUSER[username]");  
  
$returl = "details.php?id=$id&edited=1";  
if (isset($_POST["returnto"]))  
	$returl .= "&returnto=" . urlencode($_POST["returnto"]);  
header("Refresh: 0; url=$returl");  
  
?>