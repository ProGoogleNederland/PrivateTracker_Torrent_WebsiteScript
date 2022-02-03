<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_OWNER)
	site_error_message("Foutmelding", "U ben niet bevoegd om deze pagina te bekijken.");

$userid = @$_POST['userid'];
if (!$userid)
	site_error_message("Foutmelding", "Geen gebruikers ID ontvangen.");

$sure = @$_POST['sure'];
if (!$sure)
	site_error_message("Foutmelding", "Geen bevestiging ontvangen.");

if ($userid == 2564 || $userid == 1 || $userid == 2 || $userid == 3 || $userid == 6)
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

$bancomment = "Gebruiker " . get_username($userid) . " is verbannen wegens grove overtreding van de regels.";
$bancomment = sqlesc($bancomment);
$added = sqlesc(get_date_time());


if ($action == "disable_ban")
	{
	$modcomment = "Gebruikersaccount uitgeschakeld door " . get_username($CURUSER['id']) . " op " . convertdatum(get_date_time()) . " inclusief een ip-ban.\n\n";
	$modcomment .= $row['modcomment'];
	$modcomment = sqlesc($modcomment);
	$passkey = sqlesc("12345678901234567890123456789012");
	
	mysqli_query($con_link, "UPDATE users SET passkey=$passkey, modcomment=$modcomment, enabled='no' WHERE id=$userid") or sqlerr(__FILE__, __LINE__);

	mysqli_query($con_link, "INSERT INTO bans (added, addedby, first, last, comment) VALUES($added, $CURUSER[id], $first, $last, $bancomment)") or sqlerr(__FILE__, __LINE__);

	}

header("Refresh: 0; url=userdetails.php?id=$userid");

?>
