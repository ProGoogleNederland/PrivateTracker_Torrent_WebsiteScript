<?php
require_once("include/bittorrent.php");
dbconn(false);
loggedinorreturn();

$controle = (string)@$_POST['controle'];
if (!$controle == "controle")
	site_error_message("Foutmelding", "U bent op onregelmatige manier op deze pagina gekomen.");

if (get_user_class() < UC_UPLOADER)
	site_error_message("Foutmelding", "U kunt geen torrents naar ons verzenden, u heeft daar de rechten niet voor.");

$announce_site = $announce_site . "?passkey=" . $CURUSER['passkey'];

site_header("Upload");
page_start(98);
tabel_top("Uploaden van een torrent","center");
tabel_start();

print "<font color=white size=4><b>In onderstaande vak staat uw persoonlijke announce URL van ".$SITE_NAME."</b></font><br>";
print "<form>";
print "<input type=text name=url style='height:24px;font-size:14px;background:white;color:blue;font-weight:bold' size=100 value='".$announce_site."'>";
print "</form><br>";

print "<div align=center>";
print "<form enctype='multipart/form-data' action='takeupload.php' method=post>";
print "<input type=hidden name=MAX_FILE_SIZE value='".$max_torrent_size."'>";

print "<table width=80% background='pics/system/tabel_achtergrond.gif' border=1 cellspacing=0 cellpadding=5>";

print "<tr><td class=colheadsite>Torrent gegevens</td></tr>";
print "<tr><td>";
print "&nbsp;&nbsp;<font size=2 color=white><b>Bestandsnaam:<br>";
print "<input type=file name=file size=82>";
print "</td></tr>";
print "<tr><td>";
print "&nbsp;&nbsp;<font size=2 color=white><b>Naam van de torrent op de site:<br>";
print "<input maxlength=55 type=text name=name size=82>";
print "<br><font size=2 color=white><b>(Maximale lengte torrent naam is 55 lettertekens.)";
print "</td></tr>";
print "<tr><td>";
print "&nbsp;&nbsp;<font size=2 color=white><b>Omschrijving van de torrent:<br>";
print "<textarea name=descr rows=18 cols=150></textarea>";
print "<br><font size=2 color=white>(HTML is niet toegestaan. <a href=tags.php target=_blank>Druk hier</a> voor informatie over beschikbare tags.)";
print "</td></tr>";
print "<tr><td>";
print "&nbsp;&nbsp;<font size=2 color=white><b>Youtube Video [youtube=https://youtube.com/watch?v=Wqr7Nh12D]:<br>";
print "<input maxlength=60 type=text name=imdb value=\"&nbsp;&nbsp;\" size=82>";
print "</td></tr>";
$s = "<select name=\"type\">\n<option value=\"0\">&nbsp;&nbsp;(Kies een categorie)&nbsp;&nbsp;</option>\n";
$cats = genrelist();
foreach ($cats as $row)
	$s .= "<option value=\"" . $row["id"] . "\">" . htmlspecialchars($row["name"]) . "</option>\n";
$s .= "</select>\n";

print "<tr><td>";
print "&nbsp;&nbsp;<font size=2 color=white><b>Kies een categorie:<br>";
print $s;
print "</td></tr>";
print "<tr><td class=embedded><div align=center><br>";

print "<input type=submit style='height:30px;width:300;color:white;background:orange;font-weight:bold' value='Verstuur gegevens van de nieuwe torrent'>";
print "</table></form>";
print "<br>";
tabel_einde();
page_einde();
site_footer();
?>