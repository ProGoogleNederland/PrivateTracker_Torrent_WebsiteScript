<?php
require_once"include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "U heeft geen rechten op deze pagina.");

$action = (string)@$_POST['action'];

if ($action == 'verwijder_aanvraag')
	{
	$id = (int)@$_POST['id'];
	if (!$id)
		site_error_message("Foutmelding", "Ontbrekende gegevens om verzoek te verwerken.");
	
	$res = mysqli_query($con_link, "SELECT * FROM uploader_aanvraag WHERE id=".$id) or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Aanvraag niet gevonden.");
	
	mysqli_query($con_link, "DELETE FROM uploader_aanvraag WHERE id=".$id) or sqlerr(__FILE__, __LINE__);
	}

$totaal = get_row_count("uploader_aanvraag","WHERE verwerkt='ja'");

if ($totaal <= 0)
	site_error_message("Foutmelding", "Geen verwerkte aanvragen gevonden.<br><br><a class=altlink_white href=uploader_aanvraag_overzicht.php>>>> Ga naar de onverwerkte aanvragen. <<<</a>".$verwerkt);

site_header("Uploader aanvragen");
page_start(98);
tabel_top($totaal . " Uploader aanvragen&nbsp;&nbsp;&nbsp;<a class=altlink_white href=uploader_aanvraag_overzicht.php>>>> Ga naar de onverwerkte aanvragen. <<<</a>","center");
tabel_start();
print "<hr style='height:6px;background:white'>";

$res = mysqli_query($con_link, "SELECT * FROM uploader_aanvraag WHERE verwerkt = 'ja' ORDER BY toegevoegd") or sqlerr(__FILE__, __LINE__);
while ($row = mysqli_fetch_assoc($res))
	{
	$res_user = mysqli_query($con_link, "SELECT * FROM users WHERE id = " . $row['user_id']) or sqlerr(__FILE__, __LINE__);
	$row_user = mysqli_fetch_array($res_user);

	print "<font size=2 color=white><b>Aanvraag door:&nbsp;&nbsp;&nbsp;<a class=altlink_white href=userdetails.php?id=".$row['user_id']."><font size=4>" . get_usernamesite($row['user_id']) . "</a><font size=2 color=white><b>&nbsp;&nbsp;&nbsp;op&nbsp;".convertdatum($row['toegevoegd']);

	print "<table align=center width=100% border=1 cellspacing=0 cellpadding=5>";
	print "<tr>";
	print "<td class=colheadsite align=center width=20%>Upload&nbsp;ervaring</td>";
	print "<td class=colheadsite align=center width=20%>Torrent&nbsp;plaatsen&nbsp;ervaring</td>";
	print "<td class=colheadsite align=center width=20%>Kennis&nbsp;van&nbsp;DHT&nbsp;en&nbsp;PeerExchange</td>";
	print "<td class=colheadsite align=center width=20%>Computer&nbsp;24&nbsp;uur</td>";
	print "<td class=colheadsite align=center width=20%>Upload&nbsp;snelheid</td>";
	print "<td class=colheadsite align=center width=20%>Aantal&nbsp;uploads</td>";
	print "</tr>";
	print "<tr>";
	if ($row['ervaring'] == 'ja')
		print "<td bgcolor=#00FF00 align=center width=20%><b><font color=black>Ja</td>";
	else
		print "<td bgcolor=#FF0000 align=center width=20%><b><font color=white>Nee</td>";

	if ($row['torrent_plaatsen'] == 'ja')
		print "<td bgcolor=#00FF00 align=center width=20%><b><font color=black>Ja</td>";
	else
		print "<td bgcolor=#FF0000 align=center width=20%><b><font color=white>Nee</td>";

	if ($row['dht'] == 'ja')
		print "<td bgcolor=#00FF00 align=center width=20%><b><font color=black>Ja</td>";
	else
		print "<td bgcolor=#FF0000 align=center width=20%><b><font color=white>Nee</td>";

	if ($row['uur'] == 'ja')
		print "<td bgcolor=#00FF00 align=center width=20%><b><font color=black>Ja</td>";
	else
		print "<td bgcolor=#FF0000 align=center width=20%><b><font color=white>Nee</td>";
	
	if ($row['upload_snelheid'] >= 100)
		print "<td bgcolor=#00FF00 align=center width=20%><b><font color=black>".$row['upload_snelheid']."</td>";
	else
		print "<td bgcolor=#FF0000 align=center width=20%><b><font color=white>".$row['upload_snelheid']."</td>";

	if ($row['aantal_uploads'] >= 3)
		{
		if ($row['aantal_uploads'] >= 5)
			print "<td bgcolor=#00FF00 align=center width=20%><b><font color=black>Meer</td>";
		else
			print "<td bgcolor=#00FF00 align=center width=20%><b><font color=black>".$row['aantal_uploads']."</td>";
		}
	else
		print "<td bgcolor=#FF0000 align=center width=20%><b><font color=white>".$row['aantal_uploads']."</td>";

	print "</tr>";
	print "</table><p>";

	print "<table align=center width=100% border=1 cellspacing=0 cellpadding=5>";
	print "<tr>";
	print "<td class=colheadsite align=center width=25%>Uploader&nbsp;andere&nbsp;site(s)</td>";
	print "<td class=colheadsite align=center width=25%>Uploader&nbsp;bij</td>";
	print "<td class=colheadsite align=center width=25%>Staflid&nbsp;andere&nbsp;site(s)</td>";
	print "<td class=colheadsite align=center width=25%>Staflid&nbsp;bij</td>";
	print "</tr>";
	print "<tr>";
	if ($row['uploader'] == 'nee')
		print "<td bgcolor=#FFFFFF align=center width=25%><b><font color=black>Nee</td>";
	else
		print "<td bgcolor=#FFFFFF align=center width=25%><b><font color=black>Ja</td>";

	if ($row['uploader'] == 'nee')
		print "<td bgcolor=#FFFFFF align=center width=25%><b><font color=black>Geen</td>";
	else
		print "<td bgcolor=#FFFFFF align=center width=25%><b><font color=black>".$row['uploader_sites']."</td>";

	if ($row['staflid'] == 'nee')
		print "<td bgcolor=#FFFFFF align=center width=25%><b><font color=black>Nee</td>";
	else
		print "<td bgcolor=#FFFFFF align=center width=25%><b><font color=black>Ja</td>";

	if ($row['staflid'] == 'nee')
		print "<td bgcolor=#FFFFFF align=center width=25%><b><font color=black>Geen</td>";
	else
		print "<td bgcolor=#FFFFFF align=center width=25%><b><font color=black>".$row['staflid_sites']."</td>";

	print "</tr>";
	print "</table><p>";

	print "<table align=center width=100% border=1 cellspacing=0 cellpadding=5>";
	print "<tr>";
	print "<td class=colheadsite align=left>Gaat&nbsp;uploaden</td>";
	print "<td class=colheadsite align=left>Opmerking</td>";
	print "</tr>";
	print "<tr>";
	print "<td bgcolor=#FFFFFF align=left width=50%><b><font color=black>".$row['upload_wat']."</td>";
	print "<td bgcolor=#FFFFFF align=left width=50%><b><font color=black>".$row['opmerking']."</td>";
	print "</tr>";
	print "</table>";

	print "<p>";
	print "<table class=bottom align=center width=100% border=0 cellspacing=0 cellpadding=5>";
	print "<tr>";
	print "<td class=embedded><div align=left>";
	print "<font color=white size=2><b>";
	print "Verwerkt door: " . get_username($row['verwerkt_door']) . " op " . convertdatum($row['verwerkt_datum']) . "<br>";
	print "Verwerkt reden: " . htmlspecialchars($row['verwerkt_reden']);
	print "</td>";
	print "<td class=embedded><div align=right>";

	if ($CURUSER['class'] >= UC_SYSOP)
		{
		print "<form method=post action=''>";
		print "<input type=hidden name=action value='verwijder_aanvraag'>";
		print "<input type=hidden name=id value='".$row['id']."'>";
		print "<input type=submit style='height:26px;width:200px;color:white;font-weight:bold;background:red' value='Verwijder deze aanvraag'>";
		print "</form>";
		}
	else
		print "&nbsp;";
	print "</td>";
	print "</tr>";
	print "</table>";

	print "<hr style='height:6px;background:white'>";
	}

tabel_einde();
page_einde();
site_footer();
?>