<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "U ben niet bevoegd om deze pagina te bekijken.");

$userid = @$_POST['userid'];
if (!$userid)
	site_error_message("Foutmelding", "Geen gebruikers ID ontvangen.");

$torrentid = @$_POST['torrentid'];
if (!$torrentid)
	site_error_message("Foutmelding", "Geen torrent ID ontvangen.");

$action = @$_POST['action'];
if (!$action)
	site_error_message("Foutmelding", "Geen opdracht ontvangen.");

$returnto = @$_POST['returnto'];

$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);

if (!$row)
	site_error_message("Foutmelding", "Geen gebruiker gevonden.");

$def = mysqli_query($con_link, "SELECT * FROM downup WHERE user=$userid AND torrent=$torrentid") or sqlerr(__FILE__, __LINE__);
$defs = mysqli_fetch_array($def);

$erbij = rand(1000,1100);

$ontvangen = $defs['downloaded'];

$upthis = $ontvangen / 1000 * $erbij;

mysqli_query($con_link, "UPDATE downup SET uploaded = $upthis WHERE user=$userid AND torrent=$torrentid") or err("Tracker foutmelding 4");

if (!$returnto)
	header("Location: $BASEURL/userdetails.php?id=$userid");
else
	header("Location: $returnto");

?>
