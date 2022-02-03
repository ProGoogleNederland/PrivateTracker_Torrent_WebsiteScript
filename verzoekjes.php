<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

function categorie_lijst($categorie_id = 0)
	{
	$categories = "<select name=categorie style='font-size: 13px; font-weight:bold; color: white; width: 250px'><option value=0>>>> maak uw keuze <<<</option>\n";
	$categorie = genrelist();
	foreach ($categorie as $row)
		{
		if ($categorie_id == $row['id'])
			$categories .= "<option value=\"" . $row["id"] . "\" selected=selected>" . htmlspecialchars($row["name"]) . "</option>\n";
		else
			$categories .= "<option value=\"" . $row["id"] . "\">" . htmlspecialchars($row["name"]) . "</option>\n";
		}
	$categories .= "</select>\n";
	return $categories;
	}

$action = (string)@$_POST['action'];
$start = (int)@$_GET['start'];

if ($action == "stemmen_verzoekje")
	{
	$verzoek_id = 0 + $_POST['verzoek_id'];

	if (!$verzoek_id)
		site_error_message("Foutmelding", "Verzoekje niet gevonden.");
	$res = mysqli_query($con_link, "SELECT * FROM verzoekjes WHERE id=$verzoek_id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Verzoekje niet gevonden.");

	$res = mysqli_query($con_link, "SELECT * FROM verzoekjes_stemmen WHERE verzoek_id=$verzoek_id AND user_id=$CURUSER[id]") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if ($row)
		site_error_message("Foutmelding", "U heeft al op dit verzoekje gestemd.");
	$added = sqlesc(get_date_time());
	//var_dump("INSERT INTO verzoekjes_stemmen (verzoek_id, user_id, added) VALUES ($verzoek_id, $CURUSER[id], $added)");
	mysqli_query($con_link, "INSERT INTO verzoekjes_stemmen (verzoek_id, user_id, added) VALUES ($verzoek_id, $CURUSER[id], $added)") or sqlerr(__FILE__, __LINE__);
	$extra_text = "Stem toegevoegd";
	}

if ($action == "verwijder_verzoekje")
	{
	$verzoek_id = 0 + $_POST['verzoek_id'];

	if (!$verzoek_id)
		site_error_message("Foutmelding", "Verzoekje niet gevonden.");
	$res = mysqli_query($con_link, "SELECT * FROM verzoekjes WHERE id=$verzoek_id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Verzoekje niet gevonden.");

	mysqli_query($con_link, "DELETE FROM verzoekjes WHERE id=$verzoek_id") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM verzoekjes_stemmen WHERE verzoek_id=$verzoek_id") or sqlerr(__FILE__, __LINE__);
	$extra_text = "Verzoekje verwijderd";
	}

if ($action == "nieuw_verzoekje_opslaan")
	{
	$omschrijving = @$_POST['omschrijving'];
	$categorie = 0 + $_POST['categorie'];

	if (@$aantal_verzoekjes >= 3)
		site_error_message("Foutmelding", "Drie verzoekjes is maximaal.");

	if (!$omschrijving)
		site_error_message("Foutmelding", "Geen omschrijving ontvangen om te verwerken.");
	if (strlen($omschrijving) < 5)
		site_error_message("Foutmelding", "De door u opgegeven omschrijving is te klein om te verwerken.");
	if (strlen($omschrijving) > 100)
		site_error_message("Foutmelding", "De door u opgegeven omschrijving is te groot om te verwerken.");
	if (!is_valid_id($categorie))
		site_error_message("Foutmelding", "Geen geldige groep ontvangen.");

	$omschrijving = sqlesc($omschrijving);
	$added_date = sqlesc(get_date_time());
	$added_by = $CURUSER['id'];

	mysqli_query($con_link, "INSERT INTO verzoekjes (omschrijving, categorie, added_date, added_by) VALUES ($omschrijving, $categorie, $added_date, $added_by)") or sqlerr(__FILE__, __LINE__);
	$extra_text = "Gegevens van nieuw verzoekje zijn opgeslagen";
	}

if ($action == "plaats_verzoekje_opslaan")
	{
	$verzoek_id = 0 + $_POST['verzoek_id'];
	$torrent_id = 0 + $_POST['torrent_id'];

	if (!$verzoek_id)
		site_error_message("Foutmelding", "Verzoekje niet gevonden.");
	$res = mysqli_query($con_link, "SELECT * FROM verzoekjes WHERE id=$verzoek_id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Verzoekje niet gevonden.");

	if (!$torrent_id)
		site_error_message("Foutmelding", "Torrent niet gevonden.");
	$res2 = mysqli_query($con_link, "SELECT * FROM torrents WHERE id=$torrent_id") or sqlerr(__FILE__, __LINE__);
	$row2 = mysqli_fetch_array($res2);
	if (!$row2)
		site_error_message("Foutmelding", "Torrent niet gevonden.");

	$res3 = mysqli_query($con_link, "SELECT * FROM verzoekjes_stemmen WHERE verzoek_id=$verzoek_id") or sqlerr(__FILE__, __LINE__);
	while ($row3 = mysqli_fetch_assoc($res3))
		{
		$bericht = "Hallo ".get_username($row3['user_id'])." ,\n\n";
		$bericht .= "U had uw stem uitgebracht voor een verzoekje met de omschrijving:\n\n";
		$bericht .= "[size=2][color=blue][b]".htmlspecialchars($row['omschrijving'])."[/b][/color][/size]\n\n";
		$bericht .= "Er is een torrent geplaatst die voldoet aan deze omschrijving:\n\n";
		$bericht .= "[url=https://torrentmedia.org/details.php?id=".$torrent_id."][size=2][color=blue][b]".htmlspecialchars($row2['name'])."[/b][/color][/size][/url]\n\n";
		$bericht .= "[url=https://torrentmedia.org/details.php?id=".$torrent_id."][size=2][color=blue][b]Druk hier om naar de torrent te gaan.[/b][/color][/size][/url]\n\n";
		$bericht .= "Met vriendelijke groet,\n\n" . $SITE_NAME;
		$bericht = sqlesc($bericht);
		$ontvanger = $row3['user_id'];
		$afzender = 0;
		$added = sqlesc(get_date_time());
		mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES ($afzender, $ontvanger, $bericht, $added)") or sqlerr(__FILE__, __LINE__);
		mysqli_query($con_link, "DELETE FROM verzoekjes WHERE id=$verzoek_id") or sqlerr(__FILE__, __LINE__);
		mysqli_query($con_link, "DELETE FROM verzoekjes_stemmen WHERE verzoek_id=$verzoek_id") or sqlerr(__FILE__, __LINE__);
		}
	$extra_text = "Verzoekje verwerkt en berichten zijn verzonden.";
	}

if ($action == "bewerk_verzoekje_opslaan")
	{
	$omschrijving = @$_POST['omschrijving'];
	$categorie = 0 + $_POST['categorie'];
	$verzoek_id = 0 + $_POST['verzoek_id'];

	if (!$verzoek_id)
		site_error_message("Foutmelding", "Verzoekje niet gevonden.");
	$res = mysqli_query($con_link, "SELECT * FROM verzoekjes WHERE id=$verzoek_id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Verzoekje niet gevonden.");

	if (!$omschrijving)
		site_error_message("Foutmelding", "Geen omschrijving ontvangen om te verwerken.");
	if (strlen($omschrijving) < 5)
		site_error_message("Foutmelding", "De door u opgegeven omschrijving is te klein om te verwerken.");
	if (strlen($omschrijving) > 100)
		site_error_message("Foutmelding", "De door u opgegeven omschrijving is te groot om te verwerken.");
	if (!is_valid_id($categorie))
		site_error_message("Foutmelding", "Geen geldige groep ontvangen.");

	$omschrijving = sqlesc($omschrijving);
	$edit_date = sqlesc(get_date_time());
	$edit_by = $CURUSER['id'];

	mysqli_query($con_link, "UPDATE verzoekjes SET omschrijving=$omschrijving, categorie=$categorie, edit_date=$edit_date, edit_by=$edit_by WHERE id=$verzoek_id") or sqlerr(__FILE__, __LINE__);
	$extra_text = "Wijzigingen opgeslagen";
	}

$aantal_verzoekjes = get_row_count("verzoekjes","WHERE added_by=$CURUSER[id]");

if ($action == "nieuw_verzoekje")
	{
	if ($aantal_verzoekjes >= 3)
		site_error_message("Foutmelding", "Drie verzoekjes is maximaal.");

	site_header("Verzoekjes");
	page_start(98);
	tabel_top("Nieuw verzoekje plaatsen","center");
	tabel_start();

	if ($aantal_verzoekjes == 0)
		print "<font color=white size=4><b>Dit is uw eerste verzoekje die hier geregisteerd wordt.<br><br>";
	if ($aantal_verzoekjes == 1)
		print "<font color=white size=4>Dit is uw tweede verzoekje die hier geregisteerd zal worden.<br><br>";
	if ($aantal_verzoekjes == 2)
		print "<font color=white size=4>Dit is uw derde en laatste verzoekje die hier geregisteerd kan worden.<br><br>";

	print "<font color=white size=4>==========<br>";
	print "<font color=white size=4>Alle verzoekjes worden na 4 weken automatisch verwijderd uit dit systeem.<br>";
	print "<hr>";
	print "<form method=post action=''>";
	print "<input type=hidden name=action value=nieuw_verzoekje_opslaan>";
	print "<table class=bottom><tr><td class=embedded>";
	print "</td></tr><tr><td class=embedded><div align=center>";
	print "<font color=white size=2><b>Geef korte maar duidelijke omschrijving op:</b></font>";
	print "</td></tr><tr><td class=embedded>";
	print "<input maxlength=100 type=text size=125 name=omschrijving value=''>";
	print "</td></tr>";
	print "<tr><td class=embedded><div align=center>";
	print "<font color=white size=2><b><br>Kies een categorie:</b></font>";
	print "</td></tr>";
	print "<tr><td class=embedded><div align=center>";
	print categorie_lijst();
	print "</td></tr>";
	print "<tr><td class=embedded><div align=center><br><br>";
	print "<input type=submit style='height: 28px;width: 200px' value='Verstuur verzoekje'>";
	print "</form>";
	print "</td></tr></table>";
	print "<hr>";
	
	tabel_einde();
	page_einde();	
	site_footer();
	die;
	}

if ($action == "plaats_verzoekje")
	{
	$verzoek_id = 0 + $_POST['verzoek_id'];

	if (!$verzoek_id)
		site_error_message("Foutmelding", "Verzoekje niet gevonden.");
	$res = mysqli_query($con_link, "SELECT * FROM verzoekjes WHERE id=$verzoek_id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Verzoekje niet gevonden.");

	if (get_user_class() < UC_UPLOADER)
		site_error_message("Foutmelding", "U heeft geen rechten tot deze pagina.");

	site_header("Verzoekjes");
	page_start(98);
	tabel_top("Verwerk verzoekje","center");
	tabel_start();
	
	print "<font color=white size=2><b>Alleen de laatste 50 torrents worden hier weergegeven, aangezien het verwerken van een verzoekje tijdig dient te gebeuren.<br>";
	print "<font color=white size=4><b>Selecteer de gewenste torrent en druk op 'Gegevens opsturen'.<br><br>";
	print "<font color=white size=4><b>Omschrijving: ".htmlspecialchars($row['omschrijving'])."<br><br>";
	
	print "<form method=post action=''>";
	print "<input type=hidden name=action value=plaats_verzoekje_opslaan>";
	print "<input type=hidden name=verzoek_id value='".$verzoek_id."'>";
	print "<input type=submit style='height: 28px;width: 200px' value='Gegevens versturen'><br><br>";
	print "<table align=center class=bottom border=1 width=100% cellspacing=0 cellpadding=5>";
	print "<tr>";
	print "<td class=colheadsite>Groep</td>";
	print "<td class=colheadsite width=99%>Torrent</td>";
	print "<td class=colheadsite>Door</td>";
	print "<td class=colheadsite>Datum</td>";
	print "<td class=colheadsite>##</td>";
	print "</tr>";

	$res = mysqli_query($con_link, "SELECT * FROM torrents ORDER BY added DESC LIMIT 50") or sqlerr(__FILE__, __LINE__);
    while ($row = mysqli_fetch_array($res))
		{
		print "<tr>";
		print "<td bgcolor=white><font color=blue><b>".str_replace(" ","&nbsp;", get_categorie_naam($row['category']))."</td>";
		print "<td bgcolor=white><font color=blue><b>".str_replace(" ","&nbsp;", htmlspecialchars($row['name']))."</td>";
		print "<td bgcolor=white><font color=blue><b>".str_replace(" ","&nbsp;", get_username($row['owner']))."</td>";
		print "<td bgcolor=white><font color=blue><b>".str_replace(" ","&nbsp;", convertdatum($row['added']))."</td>";
		print "<td bgcolor=white><input type=radio name=torrent_id value=\"" . $row["id"] . "\"></td>";
		print "</tr>";
		}
	print "</form>";

	print "</table>";

	tabel_einde();
	page_einde();	
	site_footer();
	die;
	}

if ($action == "bewerk_verzoekje")
	{
	$verzoek_id = 0 + $_POST['verzoek_id'];

	if (!$verzoek_id)
		site_error_message("Foutmelding", "Verzoekje niet gevonden.");
	$res = mysqli_query($con_link, "SELECT * FROM verzoekjes WHERE id=$verzoek_id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Verzoekje niet gevonden.");

	site_header("Verzoekjes");
	page_start(98);
	tabel_top("Bewerk verzoekje","center");
	tabel_start();

	print "<form method=post action=''>";
	print "<input type=hidden name=action value=bewerk_verzoekje_opslaan>";
	print "<input type=hidden name=verzoek_id value='".$verzoek_id."'>";
	print "<table class=bottom><tr><td class=embedded>";
	print "</td></tr><tr><td class=embedded><div align=center>";
	print "<font color=white size=2><b>Geef korte maar duidelijke omschrijving op:</b></font>";
	print "</td></tr><tr><td class=embedded>";
	print "<input maxlength=100 type=text size=125 name=omschrijving value='".htmlspecialchars($row['omschrijving'])."'>";
	print "</td></tr>";
	print "<tr><td class=embedded><div align=center>";
	print "<font color=white size=2><b><br>Kies een categorie:</b></font>";
	print "</td></tr>";
	print "<tr><td class=embedded><div align=center>";
	print categorie_lijst($row['categorie']);
	print "</td></tr>";
	print "<tr><td class=embedded><div align=center><br><br>";
	print "<input type=submit style='height: 28px;width: 200px' value='Wijzigingen opslaan'>";
	print "</form>";
	print "</td></tr></table>";
	
	tabel_einde();
	page_einde();	
	site_footer();
	die;
	}

if ($action == "zoeken")
	{
	$cat = htmlspecialchars((int)@$_POST['cat']);
	if ($cat)
		{
		$zoek_querie = "WHERE categorie=$cat";
		}
	$zoeken = htmlspecialchars((string)@$_POST['zoekstr']);
	if ($zoeken)
		{
		if ($zoek_querie)
			$zoek_querie .= " AND omschrijving LIKE '%$zoeken%'";
		else
			$zoek_querie = " WHERE omschrijving LIKE '%$zoeken%'";
		}
	}

$totaal = get_row_count("verzoekjes",@$zoek_querie);
$per_pagina = 75;
$paginas = floor($totaal / $per_pagina);
if ($paginas * $per_pagina < $totaal)
  ++$paginas;

$site_pager = "<font color=white size=3>";
for ($i = 0; $i < $paginas; ++$i)
	{
	$begin = $i*$per_pagina;
	if ($i > 0) $site_pager .= "&nbsp;-&nbsp;";
	$pagina = $i + 1;
	if ($start/$per_pagina == $i)
		$site_pager .= "" . $pagina . "";
	else
		$site_pager .= "<a href=verzoekjes.php?start=" . $begin . "$sort_link><font color=white size=3><b>" . $pagina . "</b></font></a>";
	}
$site_pager .= "</font><br><br>";

site_header("Verzoekjes");
page_start(98);
tabel_top("Verzoekjes gesorteerd van nieuw naar oud","center");
tabel_start();

print "<form method=post action=''>";
print "<input type=hidden name=action value=zoeken>";
$s = "<select name=cat><option value=0>(alle categories)</option>\n";
$cats = genrelist();
foreach ($cats as $row)
	$s .= "<option value=\"" . $row["id"] . "\">" . htmlspecialchars($row["name"]) . "</option>\n";
$s .= "</select>\n";
print $s;
print "<input maxlength=20 type=text size=40 name=zoekstr value=''>";
print "<input type=submit value=Zoeken>";
print "</form>";

print "<br><br>";
print $site_pager;
if (@$extra_text)
	print "<font size=4 color=white>".$extra_text."</font><br><br>";
$res = @mysqli_query($con_link, "SELECT * FROM verzoekjes $zoek_querie ORDER BY added_date DESC LIMIT $start,$per_pagina") or sqlerr(__FILE__, __LINE__);
print "<table align=center class=bottom border=1 width=100% cellspacing=0 cellpadding=5>";
print "<tr>";

if ($totaal <= 0)
	print "Geen gevonden";
else
	{
	print "<td class=colheadsite width=100>Groep</td>";
	print "<td class=colheadsite width=99%>Omschrijving</td>";
	print "<td class=colheadsite width=100>Door</td>";
	print "<td class=colheadsite width=120>Datum</td>";
	print "<td class=colheadsite width=10>##</td>";
	print "<td class=colheadsite width=10>Stemmen</td>";
	print "<td class=colheadsite width=10>Bewerken</td>";
	print "<td class=colheadsite width=10>Verwijderen</td>";
	if (get_user_class() >= UC_UPLOADER)
		print "<td class=colheadsite width=10>Geplaatst</td>";
	print "</tr>";
	
	while ($row = mysqli_fetch_assoc($res))
		{
		print "<tr>";
		print "<td bgcolor=white>".str_replace(" ","&nbsp;", get_categorie_naam($row['categorie']))."</td>";
		print "<td bgcolor=white width=400>".htmlspecialchars($row['omschrijving'])."</td>";
		print "<td bgcolor=white>".str_replace(" ","&nbsp;", get_username($row['added_by']))."</td>";
		print "<td bgcolor=white>".str_replace(" ","&nbsp;", convertdatum($row['added_date']))."</td>";
		print "<td bgcolor=white align=center><font size=2 color=blue><b>".get_row_count("verzoekjes_stemmen","WHERE verzoek_id=$row[id]")."</td>";
		print "<td bgcolor=white>";
	
		$res2 = mysqli_query($con_link, "SELECT * FROM verzoekjes_stemmen WHERE verzoek_id=$row[id] AND user_id=$CURUSER[id]") or sqlerr(__FILE__, __LINE__);
		$row2 = mysqli_fetch_array($res2);
		if (!$row2 && $CURUSER['id'] != $row['added_by'])
			{
			print "<form method=post action=''>";
			print "<input type=hidden name=action value=stemmen_verzoekje>";
			print "<input type=hidden name=verzoek_id value='".$row['id']."'>";
			print "<input type=submit value='Stemmen'>";
			print "</form>";
			}
		else
			print "<center><font color=blue><b>---</b></font></center>";
		print "</td>";
		print "<td bgcolor=white>";
		if ($CURUSER['id'] == $row['added_by'] || get_user_class() >= UC_ADMINISTRATOR)
			{
			print "<form method=post action=''>";
			print "<input type=hidden name=action value=bewerk_verzoekje>";
			print "<input type=hidden name=verzoek_id value='".$row['id']."'>";
			print "<input type=submit value='Bewerken'>";
			print "</form>";
			}
		else
			print "<center><font color=blue><b>---</b></font></center>";
		print "</td>";
		print "<td bgcolor=white>";
		if ($CURUSER['id'] == $row['added_by'] || get_user_class() >= UC_ADMINISTRATOR)
			{
			print "<form method=post action=''>";
			print "<input type=hidden name=action value=verwijder_verzoekje>";
			print "<input type=hidden name=verzoek_id value='".$row['id']."'>";
			print "<input type=submit value='Verwijderen'>";
			print "</form>";
			}
		else
			print "<center><font color=blue><b>---</b></font></center>";
		print "</td>";
		if (get_user_class() >= UC_UPLOADER)
			{
			print "<td bgcolor=white>";
			print "<form method=post action=''>";
			print "<input type=hidden name=action value=plaats_verzoekje>";
			print "<input type=hidden name=verzoek_id value='".$row['id']."'>";
			print "<input type=submit value='Geplaatst'>";
			print "</form>";
			print "</td>";
			}
	
		print "</tr>";
		$temp = @long2ip($arr['first']);
		}
	print "</table>";
	}

if ($aantal_verzoekjes <= 2)
	{
	print "<br>";
	print "<form method=post action=''>";
	print "<input type=hidden name=action value=nieuw_verzoekje>";
	print "<input type=submit style='height: 28px;width: 200px' value='Nieuw verzoekje plaatsen'>";
	print "</form>";
	}
tabel_einde();
page_einde();	
site_footer();
?>