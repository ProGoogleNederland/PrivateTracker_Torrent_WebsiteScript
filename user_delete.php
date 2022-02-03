<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_SYSOP)
	site_error_message("Foutmelding", "U ben niet bevoegd om deze pagina te bekijken.");

$userid = @$_POST['userid'];
if (!$userid)
	site_error_message("Foutmelding", "Geen gebruikers ID ontvangen.");

$returnto = @$_POST['returnto'];

$sure = @$_POST['sure'];
if (!$sure)
	site_error_message("Foutmelding", "Geen bevestiging ontvangen.");

if ($userid == 1 || $userid == 2 || $userid == 3)
	site_error_message("Foutmelding", "Deze gebruiker kan niet verwijderd worden.");

$action = @$_POST['action'];
if (!$action)
	site_error_message("Foutmelding", "Geen opdracht ontvangen.");

$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);

if (!$row)
	site_error_message("Foutmelding", "Geen gebruiker gevonden.");

$first = trim($row['ip']);
$last = trim($row['ip']);
$first = ip2long($first);
$last = ip2long($last);
if ($first == -1 || $last == -1)
	site_error_message("Foutmelding", "Verkeerd IP nummer.");

$bancomment = "Gebruiker " . get_username($userid) . " is verbannen en verwijderd van de site.";
$bancomment = sqlesc($bancomment);
$added = sqlesc(get_date_time());

if ($action == "verwijderen")
	{
	mysqli_query($con_link, "INSERT INTO bans (added, addedby, first, last, comment) VALUES($added, $CURUSER[id], $first, $last, $bancomment)") or sqlerr(__FILE__, __LINE__);
	verwijder_gebruiker($userid);
	}

if (!$returnto)
	header("Location: $BASEURL/userdetails.php?id=$userid");
else
	header("Location: $returnto");

?>
