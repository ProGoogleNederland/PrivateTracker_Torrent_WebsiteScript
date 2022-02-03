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

if ($action == "verstuur_bericht")
	{
	$verstuur_naar = (int)@$_POST['verstuur_naar'];
	$message = (string)@$_POST['message'];

	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=".$verstuur_naar) or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Ontbrekende gegevens om bericht te verzenden.");
		
	$user_from = $CURUSER['id'];
	$message = sqlesc($message);
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, added, msg, poster) VALUES ($user_from, $verstuur_naar, NOW(), $message, 0)") or sqlerr(__FILE__, __LINE__);
	$returnto = "$BASEURL/uploader_aanvraag_overzicht.php";
	header("Location: $returnto");
	}

if ($action == 'verwijder_aanvraag')
	{
	$id = (int)@$_POST['id'];
	if (!$id)
		site_error_message("Foutmelding", "Ontbrekende gegevens om verzoek te verwerken.");
	$verwerkt_reden = (string)@$_POST['verwerkt_reden'];
	if (!$verwerkt_reden)
		site_error_message("Foutmelding", "Geen geldige reden ontvangen.");
	
	$res = mysqli_query($con_link, "SELECT * FROM uploader_aanvraag WHERE id=".$id) or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Aanvraag niet gevonden.");
	
	mysqli_query($con_link, "UPDATE uploader_aanvraag SET verwerkt = 'ja', verwerkt_datum = ".sqlesc(get_date_time()).", verwerkt_door = ".$CURUSER['id'].", verwerkt_reden = ".sqlesc($verwerkt_reden)." WHERE id=".$id) or sqlerr(__FILE__, __LINE__);
	}
	
if ($action == 'stuur_bericht')
	{
	$id = (int)@$_POST['id'];
	
	$res = mysqli_query($con_link, "SELECT * FROM uploader_aanvraag WHERE id=".$id) or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Aanvraag niet gevonden.");
		
	$message = "U heeft een aanvraag gedaan om uploader te worden op ".$SITE_NAME.".\n";
	$message .= "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
	$message .= "Heeft u ervaring met uploaden: ".strtoupper($row['ervaring'])."\n";
	$message .= "U weet hoe u een torrent moet plaatsen: ".strtoupper($row['torrent_plaatsen'])."\n";
	$message .= "U weet dat DHT en Peer Exchange uit moet staan: ".strtoupper($row['dht'])."\n";
	$message .= "U weet dat uw computer 24 uur per dag aan moet staan: ".strtoupper($row['uur'])."\n";
	$message .= "Uw upload_snelheid in Kbytes per seconde: ".strtoupper($row['upload_snelheid'])."\n";
	$message .= "Plaatst u ook uploads op andere sites: ".strtoupper($row['uploader'])."\n";
	if ($row['uploader'] == 'ja')
		$message .= "U plaatst ook op de volgende sites: ".strtoupper($row['uploader_sites'])."\n";
	$message .= "Bent u op een andere site ook staflid: ".strtoupper($row['staflid'])."\n";
	if ($row['staflid'] == 'ja')
		$message .= "U bent staflid op de volgende sites: ".strtoupper($row['staflid_sites'])."\n";
	if ($row['aantal_uploads'] >= 5)
		$message .= "Hoeveel uploads denkt u per maand te plaatsen: MEER DAN 5\n";
	else
		$message .= "Hoeveel uploads denkt u per maand te plaatsen: ".strtoupper($row['aantal_uploads'])."\n";
	$message .= "Wat denkt u te gaan uploaden: ".strtoupper($row['upload_wat'])."\n";
	if ($row['opmerking'] == 'ja')
		$message .= "Opmerking: ".strtoupper($row['opmerking'])."\n";
	$message .= "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
	$message .= "Over deze aanvraag heb ik nog een vraag, namelijk:\n\n\n";
	$message .= "Met vriendelijke groet,\n";
	$message .= get_username($CURUSER['id']);

	site_header("Bericht versturen");
	page_start(98);
	tabel_top("Bericht sturen aan <font color=yellow>".get_username($row['user_id'])."</font>","center");
	tabel_start();
	
	print "<table width=1% border=1 cellspacing=0 cellpadding=5>";
	print "<form name=hd_new method=post action=''>";
	print "<input type=hidden name=action value=verstuur_bericht>";
	print "<input type=hidden name=verstuur_naar value='".$row['user_id']."'>";
	print "<tr><td bgcolor=white><textarea name=message cols=125 rows=20>".htmlspecialchars($message)."</textarea></td></tr>";
	print "<tr><td bgcolor=white align=center><input type=submit class=btn style='height: 32px; width: 400px;font-weight: bold;color:blue' value='Verstuur bericht aan ".get_username($row['user_id'])."'></td></tr>";
	print "</table>";
	print "</form>";
	
	tabel_einde();
	page_einde();
	site_footer();
	die;
	}

$totaal = get_row_count("uploader_aanvraag","WHERE verwerkt='nee'");
$verwerkt = get_row_count("uploader_aanvraag","WHERE verwerkt='ja'");

if ($totaal <= 0)
	site_error_message("Foutmelding", "Geen nieuwe aanvragen gevonden.<br><br><a class=altlink_white href=uploader_aanvraag_verwerkt.php>>>> Ga naar de verwerkte aanvragen. <<<</a>");

site_header("Uploader aanvragen");
page_start(98);
tabel_top($totaal . " Uploader aanvragen&nbsp;&nbsp;&nbsp;<a class=altlink_white href=uploader_aanvraag_verwerkt.php>>>> Ga naar de verwerkte aanvragen. <<<</a>","center");
tabel_start();
print "<hr style='height:6px;background:white'>";

$res = mysqli_query($con_link, "SELECT * FROM uploader_aanvraag WHERE verwerkt = 'nee' ORDER BY toegevoegd") or sqlerr(__FILE__, __LINE__);
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
	print "<td class=embedded width=99%><div align=left>";
	print "<form method=post action=''>";
	print "<input type=hidden name=action value='stuur_bericht'>";
	print "<input type=hidden name=id value='".$row['id']."'>";
	print "<input type=submit style='height:26px;width:200px;color:white;font-weight:bold;background:green' value='Stuur bericht aan gebruiker'>";
	print "</form>";
	print "</td>";

	print "<td class=embedded><div align=right>";
	print "<b>Reden:&nbsp;";
	print "</td>";

	print "<td class=embedded><div align=right>";
	print "<form method=post action=''>";
	print "<input type=hidden name=action value='verwijder_aanvraag'>";
	print "<input maxlength=255 type=text size=50 name=verwerkt_reden value=''>";
	print "</td>";

	print "<td class=embedded><div align=right>";
	print "&nbsp;&nbsp;";
	print "</td>";

	print "<td class=embedded><div align=right>";
	print "<input type=hidden name=id value='".$row['id']."'>";
	print "<input type=submit style='height:26px;width:200px;color:white;font-weight:bold;background:red' value='Verwerk deze aanvraag'>";
	print "</form>";
	print "</td>";
	print "</tr>";
	print "</table>";

	print "<hr style='height:6px;background:white'>";
	}

tabel_einde();
page_einde();
site_footer();
?>