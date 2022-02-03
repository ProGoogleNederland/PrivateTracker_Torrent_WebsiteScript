<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_UPLOADER)
	site_error_message("Foutmelding", "U heeft geen toegang tot deze pagina.");

$torrentid = @$_POST['id'];

if (!$torrentid)
	site_error_message("Foutmelding", "Gegevens ontbreken.");
$torrentid = 0 + $torrentid;

$res = mysqli_query($con_link, "SELECT * FROM torrents WHERE id=$torrentid") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);

if (!$torrentid)
	site_error_message("Foutmelding", "Torrent niet gevonden.");

global $cover_dir;
	
$cover = get_cover($torrentid);

$cover_del = sqlesc("");

mysqli_query($con_link, "UPDATE torrents SET cover = $cover_del WHERE id=$torrentid") or sqlerr(__FILE__, __LINE__);
	
	if ($cover)
		{
		$cover_bestand_len = strlen($cover);
		$urltoimages = $BASEURL."/covers";
		$tmp_len = strlen($urltoimages) + 1;
		$cover_len = $cover_bestand_len - $tmp_len;
		$cover_file = substr($cover,$tmp_len,$cover_len);
	    unlink("$cover_dir/$cover_file");
		}

header("Refresh: 0; url=details.php?id=$torrentid");

?>