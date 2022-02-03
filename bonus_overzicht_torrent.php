<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

$torrent_id = (int)@$_GET['torrent_id'];
if (!$torrent_id)
	new_error_message("Foutmelding", "Geen torrent gevonden.","white",3000);

$res = mysqli_query($con_link, "SELECT * FROM torrents WHERE id = $torrent_id") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);
if (!$row)
	new_error_message("Foutmelding", "Deze torrent niet gevonden.","white",3000);
	
site_header("BP-Torrent");
print "<br>";
page_start(99);
tabel_top("BP overzicht torrent","center");
tabel_start();

print "<font size=2 color=white><a class=altlink_white href='details.php?id=".$torrent_id."'>Terug naar: ".htmlspecialchars($row['name'])."</a><br><br>";

print "<table width=500 class=main border=1 cellspacing=0 cellpadding=5>\n";
print "<tr>\n";
print "<td widht=250 class=colheadsite>Gebruiker</td>\n";
print "<td widht=100 class=colheadsite>Aantal</td>\n";
print "<td widht=150 class=colheadsite>Datum</td>\n";
print "</tr>\n";

$teller = 0;
$def = mysqli_query($con_link, "SELECT * FROM bonus_punten WHERE torrent_id = ".$torrent_id." ORDER BY added DESC") or sqlerr(__FILE__, __LINE__);
while ($defs = mysqli_fetch_assoc($def))
	{
	if (!$totaal_gegeven[$defs['sender_id']])
		{
		$def2 = mysqli_query($con_link, "SELECT * FROM bonus_punten WHERE torrent_id = ".$torrent_id." AND sender_id = ".$defs['sender_id']) or sqlerr(__FILE__, __LINE__);
		while ($defs2 = mysqli_fetch_assoc($def2))
			$totaal_gegeven[$defs['sender_id']] += $defs2['ammount'];

		$teller++;
		$RESULT[$teller] = array("ammount"=>$totaal_gegeven[$defs['sender_id']],"sender_id"=>$defs['sender_id'],"added"=>$defs['added']);
		}
	}

rsort ($RESULT);

$i = 0;
while ($i <= $teller -1)
	{
	$totaal_gebruiker = 0;
	$def3 = mysqli_query($con_link, "SELECT * FROM bonus_punten WHERE sender_id = ".$RESULT[$i]['sender_id']) or sqlerr(__FILE__, __LINE__);
	while ($defs3 = mysqli_fetch_assoc($def3))
		$totaal_gebruiker += $defs3['ammount'];

	print "<tr>\n";
	print "<td><a class=altlink_blue href=userdetails.php?id=".$RESULT[$i]['sender_id'].">".get_usernamesitesmal($RESULT[$i]['sender_id'])."</a> (".$totaal_gebruiker." totaal gegeven)</td>\n";
	print "<td align=right>".$RESULT[$i]['ammount']." BP</td>\n";
	print "<td align=right>".convertdatum($RESULT[$i]['added'])."</td>\n";
	print "</tr>\n";
	$i++;
	}
	
print "</table>";

print "<br><font size=2 color=white><a class=altlink_white href='details.php?id=".$torrent_id."'>Terug naar: ".htmlspecialchars($row['name'])."</a><br><br>";

tabel_einde();
page_einde();
site_footer(false);
?>