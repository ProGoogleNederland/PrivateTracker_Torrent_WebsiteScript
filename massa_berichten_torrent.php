<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_UPLOADER)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de uploaders en hoger.");

$torrentid = 0 + $_GET['torrentid'];

if (!$torrentid)
	site_error_message("Foutmelding", "Geen torrent ID ontvangen.");

$res = mysqli_query($con_link, "SELECT * FROM torrents WHERE id=$torrentid") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);
if (!$row)
	site_error_message("Foutmelding", "Geen torrent gevonden met dit ID.");

$action = @$_GET['action'];

if ($action == "sendmessage")
	{
	if (get_user_class() < UC_UPLOADER)
		site_error_message("Foutmelding", "Alleen uploaders of hoger kunnen deze versturen.");
	$message = @$_GET['message'];
	if (!$message)
		site_error_message("Foutmelding", "Geen bericht ontvangen.");
	$added = sqlesc(get_date_time());
	$message =	sqlesc($message);
	$sendermsg = $CURUSER['id'];
	$send_count = 0;
	$res = mysqli_query($con_link, "SELECT * FROM downup WHERE torrent=$torrentid") or sqlerr(__FILE__, __LINE__);
	while ($row = mysqli_fetch_assoc($res))

		{
		$user_id = $row['user'];
		$res2 = mysqli_query($con_link, "SELECT id FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
		$row2 = mysqli_fetch_array($res2);
		if ($row2)
			{
			$send_count = $send_count + 1;
			mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES ($sendermsg, $user_id, $message, $added)") or sqlerr(__FILE__, __LINE__);
			}
		}
		$send_to =	sqlesc($send_to);
		mysqli_query($con_link, "INSERT INTO massa_bericht_torrents (sender, aantal, msg, added, torrent_id) VALUES ($sendermsg, $send_count, $message, $added, $torrentid)") or sqlerr(__FILE__, __LINE__);
		site_error_message("Mededeling", "Berichten zijn verzonden.");
	}

$sjabloon = "Hallo,\n\n\n\nMet vriendelijke groet,\n\n" . $CURUSER['username'] . "\n\nDit bericht wordt aan iedereen verzonden die de torrent '".$row['name']."'\naan het ontvangen is of ontvangen heeft.";
site_header("Massa bericht");
print "<table width=95% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>";
print "<br>";
tabel_top("Massa bericht aan iedereen die met een torrent bezig is.", "center");
print "<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=0>";
print "<tr>";
print "<td class=bottom align=center><center><br>";

$res7 = mysqli_query($con_link, "SELECT * FROM massa_bericht_torrents WHERE torrent_id=$torrentid") or sqlerr(__FILE__, __LINE__);
$row7 = mysqli_fetch_array($res7);
	{
	if ($row7)
		{
		print "<table width=90% class=bottom border=0 cellspacing=0 cellpadding=0><tr>";
		print "<td class=colheadsite height=20>";
		print "&nbsp;&nbsp;Massa bericht verzonden door ".get_username($row7['sender'])." op ".convertdatum($row7['added'])." aan ".$row7['aantal']." gebruikers.";
		print "</td></tr>";
		print "<tr><td bgcolor=white>";
		print format_comment($row7['msg']);
		print "</font></div></td>";
		print "</tr></table><br><br>";
		}
	}

print "<table width=90% class=bottom border=0 cellspacing=0 cellpadding=0><tr>";
print "<td class=embedded><div align=center><font color=lightblue size=2><b>";
print "<font size=4 color=white>".$row['name']."</font><br>";
print "Hier kunt u als <font color=white>uploader of hoger</font> een bericht versturen naar alle gebruikers die met dezelfde torrent bezig zijn.";
print "<br>LET OP: Deze optie wijs gebruiken en niet voor onnodige zaken.";
$totaal = get_row_count("downup","WHERE torrent=$torrentid");
print "<br><br>Dit bericht wordt dus naar ".$totaal." gebruikers verstuurd:";
print "<li>Iedereen die deze torrent momenteel aan het ontvangen zijn.";
print "<li>Iedereen die deze torrent aan de torrent compleet ontvangen hebben.";
print "<li>Iedereen die deze torrent aan het delen is, dus ook de uploader.";
print "<li>Iedereen die deze torrent ooit met deze torrent is begonnen.";
print "<br><br><font color=white>NIET voor vragen om bedankjes en NIET voor pakken en wegwezen (misbruik wordt bestraft).";
print "</font></div></td>";
print "</tr></table>";

print "<br>";
print "<form name='save_new' method=get action='massa_berichten_torrent.php'>";
print "<input type=hidden name=action value=sendmessage>";
print "<input type=hidden name=torrentid value=$torrentid>";
print "<textarea name=message cols=125 rows=15>".htmlspecialchars($sjabloon)."</textarea>";
print "<br><br>";
print "<input type=submit class=btn style='height: 25px; width: 120px' value='Berichten versturen'>";
print "</form>";

print "<br></td></tr></table>";
print "</td></table><br>";

site_footer();

?>