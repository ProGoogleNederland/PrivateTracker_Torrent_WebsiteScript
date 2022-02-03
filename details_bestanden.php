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

site_header("Bestanden");
page_start();
tabel_top("Overzicht bestanden","center");
tabel_start(70);
print "<font size=2 color=white><a class=altlink_white href='details.php?id=".$torrent_id."'>Terug naar: ".htmlspecialchars($row['name'])."</a><br><br>";
$subres = mysqli_query($con_link, "SELECT * FROM files WHERE torrent = ".$torrent_id." ORDER BY id");
$s = "<table class=main border=\"1\" cellspacing=0 cellpadding=\"5\">\n";
$s.= "<tr><td class=colheadsite>Bestandsnaam</td><td class=colheadsite align=right>Grootte</td></tr>\n";

while ($subrow = mysqli_fetch_array($subres))
	{
	$s .= "<tr><td bgcolor=white>" . $subrow["filename"] . "</td><td bgcolor=white align=right>" . str_replace(" ","&nbsp;",mksize($subrow["size"])) . "</td></tr>\n";
	}
	
$s .= "<tr><td bgcolor=white align=right><b>Totaal</td><td bgcolor=white align=right>" . str_replace(" ","&nbsp;",mksize($row["size"])) . "</td></tr>\n";
$s .= "</td></tr></table>";
print $s;

print "<br><font size=2 color=white><a class=altlink_white href='details.php?id=".$torrent_id."'>Terug naar: ".htmlspecialchars($row['name'])."</a><br><br>";
tabel_einde();
page_einde();
site_footer();
?>
