<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_SYSOP)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de beheerders.");

$id = @$_POST["id"];
$ban = @$_POST["ban"];
$enabled = @$_POST["enabled"];
$delete = @$_POST["delete"];
$referer = @$_POST["referer"];

$id = 0 + $id;
if (!$id)
	site_error_message("Foutmelding","Geen gebruikers id ontvangen");

if (!$enabled && !$ban && !$delete)
	site_error_message("Foutmelding","Geen opties ontvangen");

$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$id") or sqlerr();
$row = mysqli_fetch_array($res);

if (!$row) die;

if ($enabled);
	mysqli_query($con_link, "UPDATE users SET enabled = 'no' WHERE id=$id") or sqlerr(__FILE__, __LINE__);

if ($ban)
	{
	$gebruiker = $row['username'];
	$first = trim($row['ip']);
	$last = trim($row['ip']);
	$first = ip2long($first);
	$last = ip2long($last);
	if ($first == -1 || $last == -1)
		site_error_message("Foutmelding", "Verkeerd IP nummer.");
	$comment = sqlesc("$gebruiker is verbannen wegens nieuw account op hetzelfde IP met slechte ratio.");
	$added = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO bans (added, addedby, first, last, comment) VALUES($added, $CURUSER[id], $first, $last, $comment)") or sqlerr(__FILE__, __LINE__);
	}

if ($referer)
	header("Refresh: 0; url=$referer");
else
	header("Location: $BASEURL/");

?>