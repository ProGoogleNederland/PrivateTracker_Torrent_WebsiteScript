<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "U ben niet bevoegd om deze pagina te bekijken.");

$torrentid = @$_POST['torrentid'];
if (!$torrentid)
	site_error_message("Foutmelding", "Geen torrent ID ontvangen.");

$returnto = @$_POST['returnto'];

$action = @$_POST['action'];
if (!$action)
	site_error_message("Foutmelding", "Geen opdracht ontvangen.");

$sure = @$_POST['sure'];
if (!$sure)
	site_error_message("Foutmelding", "Geen bevestiging ontvangen.");

$res = mysqli_query($con_link, "SELECT * FROM torrents WHERE id=$torrentid") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);

if (!$row)
	site_error_message("Foutmelding", "Geen torrent gevonden.");

$message = "Hallo,\n\n";
$message .= "De torrent " . $row['name'] . " is verwijderd van ".$SITE_NAME.", omdat deze niet goed bleek te zijn.\n\n";
$message .= "Sorry dat dit is gebeurd, we hopen dat uw volgende download wel goed zal gaan.\n\n";
$message .= "Om uw ratio te compenseren is er " . mksize($row['size']) . " bij uw totale upload toegevoegd.\n\n";
$message .= "Met vriendelijk groet,\n\nonzesite";
$message = sqlesc($message);
$added = sqlesc(get_date_time());
$sender = 0;

if ($action == "verwijderen")
	{
	$def = mysqli_query($con_link, "SELECT * FROM downup WHERE torrent=$torrentid") or sqlerr(__FILE__, __LINE__);
	while ($defs = mysqli_fetch_assoc($def))
		{
		$userid = $defs['user'];

		$upthis = $row["size"];
		
		mysqli_query($con_link, "UPDATE users SET uploaded = uploaded + $upthis WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
		
		mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES ($sender, $userid, $message, $added)") or sqlerr(__FILE__, __LINE__);
			}
	}

	$filename = $row['filename'];
	deletetorrent($torrentid,$filename);

	write_log("Torrent $id ($row[name]) is verwijderd door $CURUSER[username], omdat deze niet goed was. Ratio correctie toegepast.");

if (!$returnto)
	header("Location: $BASEURL/details.php?id=$torrentid");
else
	header("Location: $returnto");

?>
