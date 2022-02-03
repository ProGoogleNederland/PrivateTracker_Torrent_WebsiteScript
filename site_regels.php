<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

$action = (string)@$_POST['action'];

if ($action == "verwijder_onderwerp_nu")
	{
	$id = (int)@$_POST['id'];

	$res = mysqli_query($con_link, "SELECT * FROM regels WHERE id=" . $id) or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Betreffende regel niet gevonden in de database.");
		
	mysqli_query($con_link, "DELETE FROM regels WHERE id=" . $id) or sqlerr(__FILE__, __LINE__);

	$res = mysqli_query($con_link, "SELECT * FROM regels ORDER BY volgorde") or sqlerr(__FILE__, __LINE__);
	while ($row = mysqli_fetch_assoc($res))
		{
		$volgorde_nieuw++;
		$regel_id = $row['id'];
		mysqli_query($con_link, "UPDATE regels SET volgorde = ".$volgorde_nieuw." WHERE id=$regel_id") or sqlerr(__FILE__, __LINE__);
		}
	}

if ($action == "verwijder_onderwerp")
	{
	$id = (int)@$_POST['id'];

	$res = mysqli_query($con_link, "SELECT * FROM regels WHERE id=" . $id) or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Betreffende regel niet gevonden in de database.");
		
	site_header("Regels");
	page_start(98);

	tabel_top("Bevestigen verwijderen","center");
	tabel_start();
	print "<font size=4 color=white>U staat op het punt <font size=4 color=yellow>" . htmlspecialchars($row['onderwerp']) . "<font size=4 color=white> te verwijderen, weet u dit zeker?";
	print "<br><br>";

	print "<table class=bottom width=1% border=0 cellspacing=0 cellpadding=5>";
	print "<tr><td class=embedded>";

	print "<form method=post action=''>";
	print "<input type=hidden name=action value=verwijder_onderwerp_nu>";
	print "<input type=hidden name=id value=".$row['id'].">";
	print "<input type=submit style='height:25px;width:100px;background:red;color:white;font-weight:bold' value='JA'>";
	print "</form>";

	print "</td><td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	print "</td><td class=embedded>";

	print "<form method=post action=''>";
	print "<input type=hidden name=action value=''>";
	print "<input type=submit style='height:25px;width:100px;background:green;color:white;font-weight:bold' value='NEE'>";
	print "</form>";
	
	print "</td></tr></table>";
	tabel_einde();
	page_einde();
	site_footer();
	die;	
	}

if ($action == "naar_boven")
	{
	$id = (int)@$_POST['id'];

	$res = mysqli_query($con_link, "SELECT * FROM regels WHERE id=" . $id) or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Betreffende regel niet gevonden in de database.");
	
	if ($row['volgorde'] == 1)
		site_error_message("Foutmelding", "Deze staat al bovenaan.");
	
	$volgorde_a = $row['volgorde'];
	$volgorde_b = $row['volgorde'] - 1;

	$res2 = mysqli_query($con_link, "SELECT * FROM regels WHERE volgorde=" . $volgorde_b) or sqlerr(__FILE__, __LINE__);
	$row2 = mysqli_fetch_array($res2);
	if (!$row2)
		site_error_message("Foutmelding", "Er gebeurde iets wat de maker van de site niet verwachte.");
	
	mysqli_query($con_link, "UPDATE regels SET volgorde = ".$volgorde_a." WHERE id=". $row2['id']) or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "UPDATE regels SET volgorde = ".$volgorde_b." WHERE id=". $row['id']) or sqlerr(__FILE__, __LINE__);
	}

if ($action == "naar_beneden")
	{
	$id = (int)@$_POST['id'];

	$res = mysqli_query($con_link, "SELECT * FROM regels WHERE id=" . $id) or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Betreffende regel niet gevonden in de database.");
	
	if ($row['volgorde'] == get_row_count("regels",""))
		site_error_message("Foutmelding", "Deze staat al onderaan.");
	
	$volgorde_a = $row['volgorde'];
	$volgorde_b = $row['volgorde'] + 1;

	$res2 = mysqli_query($con_link, "SELECT * FROM regels WHERE volgorde=" . $volgorde_b) or sqlerr(__FILE__, __LINE__);
	$row2 = mysqli_fetch_array($res2);
	if (!$row2)
		site_error_message("Foutmelding", "Er gebeurde iets wat de maker van de site niet verwachte.");
	
	mysqli_query($con_link, "UPDATE regels SET volgorde = ".$volgorde_a." WHERE id=". $row2['id']) or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "UPDATE regels SET volgorde = ".$volgorde_b." WHERE id=". $row['id']) or sqlerr(__FILE__, __LINE__);
	}
	
if ($action == "save_nieuw_onderwerp")
	{
	$onderwerp = (string)@$_POST['onderwerp'];
	$inhoud = (string)@$_POST['inhoud'];
	$min_class = (int)@$_POST['min_class'];

	if (!$onderwerp)	
		site_error_message("Foutmelding", "Ontbrekende gegevens, geen onderwerp ontvangen.");
	if (!$inhoud)	
		site_error_message("Foutmelding", "Ontbrekende gegevens, geen inhoud ontvangen.");
	
	$res = mysqli_query($con_link, "SELECT * FROM regels ORDER BY volgorde") or sqlerr(__FILE__, __LINE__);
	while ($row = mysqli_fetch_assoc($res))
		{
		$volgorde_nieuw++;
		$regel_id = $row['id'];
		mysqli_query($con_link, "UPDATE regels SET volgorde = ".$volgorde_nieuw." WHERE id=$regel_id") or sqlerr(__FILE__, __LINE__);
		}

	$volgorde = get_row_count("regels","") + 1;

	$onderwerp = sqlesc($onderwerp);
	$inhoud = sqlesc($inhoud);
	$edit_by = $CURUSER['id'];
	$edit_date = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO regels (volgorde, onderwerp, inhoud, min_class, edit_by, edit_date) VALUES ($volgorde, $onderwerp, $inhoud, $min_class, $edit_by, $edit_date)") or sqlerr(__FILE__, __LINE__);
	}
	
if ($action == "save_edit_onderwerp")
	{
	$id = (int)@$_POST['id'];
	$onderwerp = (string)@$_POST['onderwerp'];
	$inhoud = (string)@$_POST['inhoud'];
	$min_class = (int)@$_POST['min_class'];

	if (!$id)	
		site_error_message("Foutmelding", "Ontbrekende gegevens, geen id ontvangen.");
	if (!$onderwerp)	
		site_error_message("Foutmelding", "Ontbrekende gegevens, geen onderwerp ontvangen.");
	if (!$inhoud)	
		site_error_message("Foutmelding", "Ontbrekende gegevens, geen inhoud ontvangen.");
	
	$res = mysqli_query($con_link, "SELECT * FROM regels WHERE id=" . $id) or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Betreffende regel niet gevonden in de database.");
	
	$volgorde = get_row_count("regels","") + 1;

	$onderwerp = sqlesc($onderwerp);
	$inhoud = sqlesc($inhoud);
	$edit_by = $CURUSER['id'];
	$edit_date = sqlesc(get_date_time());
	mysqli_query($con_link, "UPDATE regels SET onderwerp = ".$onderwerp.", inhoud = ".$inhoud.", min_class = ".$min_class.", edit_by = ".$edit_by.", edit_date = ".$edit_date." WHERE id=". $id) or sqlerr(__FILE__, __LINE__);
	}
	
if ($action == "nieuw_onderwerp")
	{
	site_header("Regels");
	page_start(98);
	tabel_top("Nieuw onderwerp","center");
	tabel_start();

	print "<table class=bottom width=1% border=0 cellspacing=0 cellpadding=5>";
	print "<tr><td class=embedded>";
	print "<div align=left>";

	print "<form method=post action=''>";
	print "<input type=hidden name=action value=save_nieuw_onderwerp>";
	print "&nbsp;<font size=2 color=white>Onderwerp<br><input maxlength=100 type=text size=80 name=onderwerp value=\"" . htmlspecialchars($onderwerp) . "\"><br><br>";
	print "&nbsp;<font size=2 color=white>Inhoud<br><textarea name=inhoud cols=125 rows=15>".htmlspecialchars($inhoud)."</textarea><br><br>";

	print "&nbsp;<font size=2 color=white>Zichtbaar voor keuze en hoger<br><select name=min_class><option value=0>(zichtbaar voor iedereen)</option><br>";
	for ($i = 0 ; ; ++$i)
		{
		if ($c = get_user_class_name($i))
			print "<option value=" . $i . ">Alleen zichtbaar voor $c en hoger</option>\n";
		else
			break;
		}
	print "</select>";

	print "<hr>";
	print "<div align=right>";

	print "<input type=submit style='height:25px;width:225px;background:orange;color:white;font-weight:bold' value='Gegevens opslaan'>";
	print "</form>";
	
	print "</td></tr>";
	print "</table>";
	tabel_einde();
	page_einde();
	site_footer();
	die;
	}

if ($action == "edit_onderwerp")
	{
	$id = (int)@$_POST['id'];

	if (!$id)	
		site_error_message("Foutmelding", "Ontbrekende gegevens, geen id ontvangen.");

	$res = mysqli_query($con_link, "SELECT * FROM regels WHERE id=$id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Ontbrekende gegevens, geen id gevonden in de database.");
	
	site_header("Regels");
	page_start(98);
	tabel_top("Bewerk onderwerp","center");
	tabel_start();

	print "<table class=bottom width=1% border=0 cellspacing=0 cellpadding=5>";
	print "<tr><td class=embedded>";
	print "<div align=left>";

	print "<form method=post action=''>";
	print "<input type=hidden name=action value=save_edit_onderwerp>";
	print "<input type=hidden name=id value=".$id.">";
	print "&nbsp;<font size=2 color=white>Onderwerp<br><input maxlength=100 type=text size=80 name=onderwerp value=\"" . htmlspecialchars($row['onderwerp']) . "\"><br><br>";
	print "&nbsp;<font size=2 color=white>Inhoud<br><textarea name=inhoud cols=125 rows=15>".htmlspecialchars($row['inhoud'])."</textarea><br><br>";

	print "&nbsp;<font size=2 color=white>Zichtbaar voor keuze en hoger<br><select name=min_class><option value=0>(zichtbaar voor iedereen)</option><br>";
	for ($i = 0 ; ; ++$i)
		{
		if ($c = get_user_class_name($i))
			if ($row['min_class'] == $i)
				print "<option selected=selected value=" . $i . ">Alleen zichtbaar voor $c en hoger</option>\n";
			else
				print "<option value=" . $i . ">Alleen zichtbaar voor $c en hoger</option>\n";
		else
			break;
		}
	print "</select>";

	print "<hr>";
	print "<div align=right>";

	print "<input type=submit style='height:25px;width:225px;background:orange;color:white;font-weight:bold' value='Gegevens opslaan'>";
	print "</form>";
	
	print "</td></tr>";
	print "</table>";
	tabel_einde();
	page_einde();
	site_footer();
	die;
	}

site_header("Regels");
page_start(99);

$res = mysqli_query($con_link, "SELECT * FROM regels ORDER BY volgorde") or sqlerr(__FILE__, __LINE__);
while ($row = mysqli_fetch_assoc($res))
	{
	if ($row['min_class'] == 0)
		$zichtbaar = " - Zichtbaar voor iedereen";
	else
		$zichtbaar = " - Alleen zichtbaar voor " . get_user_class_name($row['min_class']) . " en hoger.";

	if ($CURUSER['class'] == 0)
			$zichtbaar = "";

	if ($CURUSER['class'] >= $row['min_class'])
		{
		tabel_top(htmlspecialchars($row['onderwerp']) . $zichtbaar,"");
		tabel_start();
		print "<div align=left><font color=white>";
		print "<font color=white>" . format_comment($row['inhoud']);	
		if (get_user_class() >= UC_SYSOP)
			{
			print "<hr><div align=right>";
	
			print "<table class=bottom width=1% border=0 cellspacing=0 cellpadding=5>";
			print "<tr>";
			print "<td class=embedded>";
			$tekst = str_replace(" ","&nbsp;","Laatst bewerkt door ".get_username($row['edit_by'])." op ".convertdatum($row['edit_date']).".");
			print "<font color=white size=1>". $tekst;
			print "<td class=embedded>&nbsp;&nbsp;</td>";
	
			if ($row['volgorde'] != 1)
				{
				print "<td class=embedded>";
				print "<form method=post action=''>";
				print "<input type=hidden name=action value=naar_boven>";
				print "<input type=hidden name=id value=".$row['id'].">";
				print "<input type=submit style='height:25px;width:100px;background:green;color:white;font-weight:bold' value='Naar boven'>";
				print "</form>";
				print "</td>";
				print "<td class=embedded>&nbsp;&nbsp;</td>";
				}
			
			if ($row['volgorde'] != get_row_count("regels",""))
				{
				print "<td class=embedded>";
				print "<form method=post action=''>";
				print "<input type=hidden name=action value=naar_beneden>";
				print "<input type=hidden name=id value=".$row['id'].">";
				print "<input type=submit style='height:25px;width:100px;background:green;color:white;font-weight:bold' value='Naar beneden'>";
				print "</form>";
				print "</td>";
				print "<td class=embedded>&nbsp;&nbsp;</td>";
				}
	
			print "<td class=embedded>";
			print "<form method=post action=''>";
			print "<input type=hidden name=action value=edit_onderwerp>";
			print "<input type=hidden name=id value=".$row['id'].">";
			print "<input type=submit style='height:25px;width:100px;background:orange;color:white;font-weight:bold' value='Bewerken'>";
			print "</form>";
			print "<td class=embedded>&nbsp;&nbsp;</td>";
			print "</td><td class=embedded>";
			print "<form method=post action=''>";
			print "<input type=hidden name=action value=verwijder_onderwerp>";
			print "<input type=hidden name=id value=".$row['id'].">";
			print "<input type=submit style='height:25px;width:100px;background:red;color:white;font-weight:bold' value='Verwijderen'>";
			print "</form>";
			print "</td></tr></table>";
			}	
		tabel_einde();
		print "<br>";
		}
	}

if (get_user_class() >= UC_SYSOP)
	{
	print "<div align=center>";
	print "<form method=post action=''>";
	print "<input type=hidden name=action value=nieuw_onderwerp>";
	print "<input type=submit style='height:25px;width:225px;background:orange;color:white;font-weight:bold' value='Nieuw onderwerp maken'>";
	print "</form>";
	}

page_einde();
site_footer();
?>