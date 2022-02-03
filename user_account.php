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

if ($userid == 2564 || $userid == 1 || $userid == 2 || $userid == 3 || $userid == 6)
	site_error_message("Foutmelding", "Deze optie werkt niet op deze gebruiker.");

$returnto = @$_POST['returnto'];

$sure = @$_POST['sure'];
if (!$sure)
	site_error_message("Foutmelding", "Geen bevestiging ontvangen.");

$action = @$_POST['action'];
if (!$action)
	site_error_message("Foutmelding", "Geen opdracht ontvangen.");

$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);

if (!$row)
	site_error_message("Foutmelding", "Geen gebruiker gevonden.");

if ($action == "disable_account")
	{
	$modcomment = "Gebruikersaccount uitgeschakeld door " . get_username($CURUSER['id']) . " op " . convertdatum(get_date_time()) . ".\n\n";
	$modcomment .= $row['modcomment'];
	$modcomment = sqlesc($modcomment);
	
	mysqli_query($con_link, "UPDATE users SET modcomment=$modcomment, enabled='no' WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
	}

if ($action == "enable_account")
	{
	$modcomment = "Gebruikersaccount ingeschakeld door " . get_username($CURUSER['id']) . " op " . convertdatum(get_date_time()) . ".\n\n";
	$modcomment .= $row['modcomment'];
	$modcomment = sqlesc($modcomment);
	
	mysqli_query($con_link, "UPDATE users SET modcomment=$modcomment, enabled='yes' WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
	}

if ($action == "disable_warning")
	{
	if ($row['warned'] == "yes")
		{
		$modcomment = "Waarschuwing verwijderd door " . get_username($CURUSER['id']) . " op " . convertdatum(get_date_time()) . ".\n\n";
		$modcomment .= $row['modcomment'];
		$modcomment = sqlesc($modcomment);
		
		mysqli_query($con_link, "UPDATE users SET modcomment=$modcomment, warned='no' WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
		}
	}

if (!$returnto)
	header("Refresh: 0; url=index.php");
else
	header("Location: $returnto");

?>
