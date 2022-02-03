<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

$torrent_id = (int)@$_GET['torrent_id'];

if (!$torrent_id)
	site_error_message("Foutmelding", "Geen torrent id ontvangen.");

$res = mysqli_query($con_link, "SELECT * FROM torrents WHERE id = ".$torrent_id) or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);
if (!$row)
	site_error_message("Foutmelding", "Geen torrent gevonden met dit id nummer.");

site_header("Bedankjes");
page_start();
tabel_top("Overzicht bedankjes","center");
tabel_start(70);
print "<font size=2 color=white><a class=altlink_white href='details.php?id=".$torrent_id."'>Terug naar: ".htmlspecialchars($row['name'])."</a><br><br>";

print "<table width=300 class=main border=1 cellspacing=0 cellpadding=5>\n";
print "<tr>\n";
print "<td widht=130 class=colheadsite>Gebruiker</td>\n";
print "<td widht=170 class=colheadsite>Datum</td>\n";
print "</tr>\n";

$def = mysqli_query($con_link, "SELECT user, torrent, added FROM thankyou WHERE torrent = $torrent_id ORDER BY added DESC") or sqlerr(__FILE__, __LINE__);
while ($defs = mysqli_fetch_assoc($def))
	{
	print "<tr>\n";
	print "<td><a class=altlink_blue href=userdetails.php?id=".$defs['user'].">".get_usernamesitesmal($defs['user'])."</a></td>\n";
	print "<td>".convertdatum($defs['added'])."</td>\n";
	print "</tr>\n";
	}

print "</table>";

print "<br><font size=2 color=white><a class=altlink_white href='details.php?id=".$torrent_id."'>Terug naar: ".htmlspecialchars($row['name'])."</a><br><br>";
tabel_einde();
page_einde();
site_footer();
?>