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

global $screen_dir;
	
$screen = get_screen($torrentid);

$screen_del = sqlesc("");

mysqli_query($con_link, "UPDATE torrents SET screen = $screen_del WHERE id=$torrentid") or sqlerr(__FILE__, __LINE__);
	
	if ($screen)
		{
		$screen_bestand_len = strlen($screen);
		$urltoimages = $BASEURL."/screens";
		$tmp_len = strlen($urltoimages) + 1;
		$screen_len = $screen_bestand_len - $tmp_len;
		$screen_file = substr($screen,$tmp_len,$screen_len);
	    unlink("screens/$screen_file");
		}

header("Refresh: 0; url=details.php?id=$torrentid");

?>