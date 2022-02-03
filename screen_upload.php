<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();
//error_reporting(0);

if (get_user_class() < UC_UPLOADER)
	site_error_message("Foutmelding", "U ben niet bevoegd om deze pagina te bekijken.");

$serverpath = "screens/";
$urltoimages = $BASEURL."/screens";
$maxsize = 1024 * 1024;

if (!mkglobal("id"))
	site_error_message("Foutmelding", "Geen torrent ID ontvangen.");

$id = 0 + $id;
if (!$id)
	site_error_message("Foutmelding", "Geen torrent ID ontvangen.");

$res = mysqli_query($con_link, "SELECT name FROM torrents WHERE id = $id")	or sqlerr();
$row = mysqli_fetch_array($res);
if (!$row)
	site_error_message("Foutmelding", "Geen torrent ontvangen.");

$torrent_name = $row['name'];

$mode = @$_GET['mode'];
if ($mode == "") { $mode = "form"; }

if ($mode == "upload")
	{
	$file = $_FILES['file']['name'];
  	// Als je een eigen extensie wilt toelaten, voeg deze hier toe, vergeet niet om OOK een hoofdletter extensie toe te voegen.
	$allowedfiles[] = "gif";
	$allowedfiles[] = "jpg";
	$allowedfiles[] = "jpeg";
	$allowedfiles[] = "png";
	$allowedfiles[] = "GIF";
	$allowedfiles[] = "JPG";
	$allowedfiles[] = "JPEG";
	$allowedfiles[] = "PNG";
	$res = mysqli_query($con_link, "SELECT name FROM torrents WHERE id = $id")	or sqlerr();
	$row = mysqli_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Geen torrent ontvangen.");
	
	$torrent_name = $row['name'];
	
	$i = strrpos($file, ".");
	$ext = strtolower(substr($file, $i));
	$file = strtolower($id . $ext);

	//   print $file; die;
	// print $file . $i . $ext . " - " . $tmp; die;

	if($_FILES['file']['size'] > $maxsize)
		site_error_message("Foutmelding", "Bestand is te groot. Verklein het bestand en probeer het opnieuw.");
	else
		{
		$path = "$serverpath/$file";
		foreach($allowedfiles as $allowedfile)
			{
			$tmp = strtolower($CURUSER['username'] . "." . $allowedfile);
		   	$tmppath = "$serverpath/$tmp";
			if (file_exists($tmppath) && $path !== $tmppath)
				unlink("$screens_dir/$tmp");
   			if (@$done <> "yes")
				{
				if (file_exists($path)) 
					unlink("$screens_dir/$file");
				}
			if (substr($file, -3) == $allowedfile)
				{
				$screen_file = $_FILES['file']['tmp_name'];
				$screen_file =  str_replace(" ","_",$screen_file);
				$path =  str_replace(" ","_",$path);
				
				move_uploaded_file($screen_file, "$path");
		      	$screen_send = $urltoimages . "/" . $file;
				$screen_send =  str_replace(" ","_",$screen_send);
		      	$screen_send = sqlesc($screen_send);
				$screen_by = $CURUSER['id'];
				mysqli_query($con_link, "UPDATE torrents SET screen = $screen_send, screen_by = $screen_by WHERE id=$id") or print("Database error");
				
				$done = "yes";
				header("Location: $BASEURL/details.php?id=$id");
				die;
				}
			}
			if (@$done <> "yes")
				site_error_message("Foutmelding", "<b>Error:</b> Jouw afbeelding is NIET geupload. De extensie is niet herkend. Probeer het opnieuw AUB.");
		}
	}

site_header("screen");
print("<table class=bottom width=80% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td align=center class=embedded><div align=center>");

tabel_top("screen plaatsen voor torrent " . $torrent_name);
print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td align=center class=embedded><div align=center><br>");

if ($mode == "form") {
print "<form method=post action=\"?mode=upload\" enctype=\"multipart/form-data\">";
print "<table class=bottom width=75% border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>";
if (get_screen($id)){
	print "<center><font color=blue>Huidige screen<br><br><img height=250 src=" . get_screen($id) . ">";
}else{
	print "<center>Geen gevonden";
}
	
print "<br><br><center>";
print "Alleen plaatjes met de extensie <b>JPG GIF PNG</b> worden geacepteerd, en de screen mag niet groter zijn dan 1 Mb";
print "<br>De bestandsnaam wordt gewijzigd op de server naar $id.jpg, $id.gif of $id.png";

print "</td></tr></table><br>";
print "<table width=80% border=1 cellspacing=0 cellpadding=8>";
print "<tr><td bgcolor=white class=rowhead>Bestand</td><td bgcolor=white align=center><input type=file name=file size=80></td></tr>";
print "<tr>";
print "<td bgcolor=white colspan=2 align=center>";
print "<table class=bottom border=0><tr><td class=embedded>";
print "</td><td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
print "<input type=hidden name=id value=" . $id . ">";
print "<input type=submit name=Submit value=\"Verzenden\" class=btn>";
print("</td></tr></table>");
print "</td></tr>";
print "</table></form><p>";
print("<br></td></tr></table><br>");
 }

print("</td></tr></table>");
site_footer();  
?>
