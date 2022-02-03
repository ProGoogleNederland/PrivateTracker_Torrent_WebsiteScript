<?
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysqli_host, $mysqli_user, $mysqli_pass, $mysqli_db;
$con_link = mysqlii_connect($mysqli_host, $mysqli_user, $mysqli_pass, $mysqli_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_OWNER)
	new_error_message("Foutmelding", "U heeft geen rechten tot deze pagina.");

$action = $_POST['action'];

if ($action == "verwijderen")
	{
	$aktie_id = 0 + $_POST['aktie_id'];

	if (!$aktie_id)
		new_error_message("Foutmelding", "Geen id ontvangen.");

	$res = mysqli_query($con_link, "SELECT * FROM aktie WHERE id=$aktie_id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);

	if (!$row)
		new_error_message("Foutmelding", "Geen data gevonden om te verwijderen.");

	mysqli_query("DELETE FROM aktie WHERE id=$aktie_id") or sqlerr(__FILE__, __LINE__);
	$action = "";
	}
	
if ($action == "voorbeeld")
	{
	$aktie_id = 0 + $_POST['aktie_id'];

	if (!$aktie_id)
		new_error_message("Foutmelding", "Geen id ontvangen.");

	$res = mysqli_query($con_link, "SELECT * FROM aktie WHERE id=$aktie_id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);

	if (!$row)
		new_error_message("Foutmelding", "Geen gegevens gevonden om te bewerken.");

	$aktie_test =  "<table class=bottom width=100% height=45 border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><div align=center>\n";
	$aktie_test .= "<table class=bottom width=99% height=35 cellspacing=0 cellpadding=0><tr><td>\n";
	$aktie_test .= "<font color=blue><center><b>";
	$aktie_test .= $row['aktie'];
	$aktie_test .= "</b></center></td></tr></table>";
	$aktie_test .= "</td></tr></table><center>";
	}
	
if ($action == "bewerken_opslaan")
	{
	$aktie_id = $_POST['aktie_id'];
	$datum = $_POST['datum'];
	$aktie = $_POST['aktie'];
	$krediet = $_POST['krediet'];
	
	if (strlen($datum) != 10)
		new_error_message("Foutmelding", "Ongeldige datum ontvangen, lengte niet goed.");
	if (substr($datum,4,1) != "-")
		new_error_message("Foutmelding", "Ongeldige datum ontvangen, streepje ontbreekt.");
	if (substr($datum,7,1) != "-")
		new_error_message("Foutmelding", "Ongeldige datum ontvangen, streepje ontbreekt.");
	if (substr($datum,0,4) < "2006")
		new_error_message("Foutmelding", "Ongeldige datum ontvangen, is datum in verleden.");
	if (substr($datum,5,2) < "1" || substr($datum,5,2) > "12")
		new_error_message("Foutmelding", "Ongeldige datum ontvangen, maand aanduiding ongeldig.");
	if (substr($datum,8,2) < "1" || substr($datum,8,2) > "31")
		new_error_message("Foutmelding", "Ongeldige datum ontvangen, dag aanduiding ongeldig.");

	if ($krediet < "4" || $krediet > "24")
		new_error_message("Foutmelding", "Ongeldige krediet aantal ontvangen.");

	if (!$aktie_id)
		new_error_message("Foutmelding", "Geen id ontvangen.");
	if (!$datum)
		new_error_message("Foutmelding", "Geen datum ontvangen.");
	if (!$aktie)
		new_error_message("Foutmelding", "Geen omschrijving ontvangen.");
	if (!$krediet)
		new_error_message("Foutmelding", "Geen krediet ontvangen.");
	
	$datum = sqlesc($datum);
	$krediet = sqlesc($krediet);
	$aktie = sqlesc($aktie);

	mysqli_query($con_link, "UPDATE aktie SET datum = $datum, krediet = $krediet, aktie = $aktie WHERE id=$aktie_id") or sqlerr(__FILE__, __LINE__);

	$action = "";
	}

if ($action == "nieuw_opslaan")
	{
	$datum = $_POST['datum'];
	$aktie = $_POST['aktie'];
	$krediet = $_POST['krediet'];
	
	if (strlen($datum) != 10)
		new_error_message("Foutmelding", "Ongeldige datum ontvangen, lengte niet goed.");
	if (substr($datum,4,1) != "-")
		new_error_message("Foutmelding", "Ongeldige datum ontvangen, streepje ontbreekt.");
	if (substr($datum,7,1) != "-")
		new_error_message("Foutmelding", "Ongeldige datum ontvangen, streepje ontbreekt.");
	if (substr($datum,0,4) < "2006")
		new_error_message("Foutmelding", "Ongeldige datum ontvangen, is datum in verleden.");
	if (substr($datum,5,2) < "1" || substr($datum,5,2) > "12")
		new_error_message("Foutmelding", "Ongeldige datum ontvangen, maand aanduiding ongeldig.");
	if (substr($datum,8,2) < "1" || substr($datum,8,2) > "31")
		new_error_message("Foutmelding", "Ongeldige datum ontvangen, dag aanduiding ongeldig.");

	if ($krediet < "4" || $krediet > "24")
		new_error_message("Foutmelding", "Ongeldige krediet aantal ontvangen.");

	if (!$datum)
		new_error_message("Foutmelding", "Geen datum ontvangen.");
	if (!$aktie)
		new_error_message("Foutmelding", "Geen omschrijving ontvangen.");
	if (!$krediet)
		new_error_message("Foutmelding", "Geen krediet ontvangen.");
	
	$datum = sqlesc($datum);
	$krediet = sqlesc($krediet);
	$aktie = sqlesc($aktie);
	$added = sqlesc(get_date_time());
	$added_by = $CURUSER['id'];

	mysqli_query($con_link, "INSERT INTO aktie (datum, krediet, aktie, added, added_by) VALUES($datum, $krediet, $aktie, $added, $added_by)") or sqlerr(__FILE__, __LINE__);

	$action = "";
	}

if ($action == "bewerken")
	{
	$aktie_id = 0 + $_POST['aktie_id'];
	if (!$aktie_id)
		new_error_message("Foutmelding", "Geen id ontvangen.");

	$res = mysqli_query($con_link, "SELECT * FROM aktie WHERE id=$aktie_id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);

	if (!$row)
		new_error_message("Foutmelding", "Geen gegevens gevonden om te bewerken.");
	
	site_header("Aktie");
	//site_menu(false);
	print "<br>";
	page_start(98);
	tabel_top("Aktie bewerken","center");
	tabel_start();
	print "<table width=80% class=bottom>\n";
	print "<form method=post action=''>\n";
	print "<input type=hidden name=action value=bewerken_opslaan>\n";
	print "<input type=hidden name=aktie_id value='".$row['id']."'>\n";

	print "<tr><td class=embedded>\n";
	print "&nbsp;&nbsp;<b>" . "<font color=white>Datum:\n";
	print "</td></tr>\n";
	print "<tr><td class=embedded>\n";
	print "<input maxlength=10 type=text size=15 name=datum value='".htmlspecialchars($row['datum'])."'>&nbsp;&nbsp;<b><font color=white>(Gewenst formaat: 2006-12-31)<br><br>\n";
	print "</td></tr>";

	print "<tr><td class=embedded>\n";
	print "&nbsp;&nbsp;<b>" . "<font color=white>Omschrijving:\n";
	print "</td></tr>\n";
	print "<tr><td class=embedded>\n";
	print "<input maxlength=255 type=text size=150 name=aktie value='".htmlspecialchars($row['aktie'])."'><br><br>\n";
	print "</td></tr>\n";

	print "<tr><td class=embedded>\n";
	print "&nbsp;&nbsp;<b>" . "<font color=white>Krediet:\n";
	print "</td></tr>\n";
	print "<tr><td class=embedded>\n";
	print "<input maxlength=10 type=text size=15 name=krediet value='".htmlspecialchars($row['krediet'])."'>&nbsp;&nbsp;<b><font color=white>(Minimaal 5 en maximaal 12)<br><br>\n";
	print "</td></tr>";

	print "<tr><td class=embedded><hr><div align=center>\n";
	print "<input type=submit style='height: 28px;width: 180px' value='Gegevens opslaan'>\n";
	print "</form>\n";
	print "</td></tr>\n";
	print "</table>\n";
	tabel_einde();
	page_einde();	
	new_footer(false);
	die;
	}

if ($action == "nieuw")
	{
	site_header("Aktie");
//	site_menu(false);
	print "<br>";
	page_start(98);
	tabel_top("Aktie","center");
	tabel_start();
	print "<table width=80% class=bottom>\n";
	print "<form method=post action=''>\n";
	print "<input type=hidden name=action value=nieuw_opslaan>\n";

	print "<tr><td class=embedded>\n";
	print "&nbsp;&nbsp;<b>" . "<font color=white>Datum:\n";
	print "</td></tr>\n";
	print "<tr><td class=embedded>\n";
	print "<input maxlength=10 type=text size=15 name=datum value='0000-00-00'>&nbsp;&nbsp;<b><font color=white>(Gewenst formaat: 2006-12-31)<br><br>\n";
	print "</td></tr>";

	print "<tr><td class=embedded>\n";
	print "&nbsp;&nbsp;<b>" . "<font color=white>Omschrijving:\n";
	print "</td></tr>\n";
	print "<tr><td class=embedded>\n";
	print "<input maxlength=255 type=text size=150 name=aktie value=''><br><br>\n";
	print "</td></tr>\n";

	print "<tr><td class=embedded>\n";
	print "&nbsp;&nbsp;<b>" . "<font color=white>Krediet:\n";
	print "</td></tr>\n";
	print "<tr><td class=embedded>\n";
	print "<input maxlength=10 type=text size=15 name=krediet value='6'>&nbsp;&nbsp;<b><font color=white>(Minimaal 5 en maximaal 12)<br><br>\n";
	print "</td></tr>";

	print "<tr><td class=embedded><hr><div align=center>\n";
	print "<input type=submit style='height: 28px;width: 180px' value='Gegevens opslaan'>\n";
	print "</form>\n";
	print "</td></tr>\n";
	print "</table>\n";
	tabel_einde();
	page_einde();	
	new_footer(false);
	die;
	}

site_header("Aktie");
//site_menu(false);
print "<br>";
page_start(99);
tabel_top("Aktie","center");
tabel_start();

if (get_row_count("aktie","") > 0)
	{
	print "<table width=100% class=main border=1 cellspacing=0 cellpadding=5>" ;
	print "<tr>" ;
	print "<td class=colheadsite width=80 align=center>Aktie datum</td>";
	print "<td class=colheadsite width=1% align=center>Krediet</td>";
	print "<td class=colheadsite width=700>Omschrijving</td>";
//	print "<td class=colheadsite width=80>Door</td>";
//	print "<td class=colheadsite width=100>Datum aangemaakt</td>";
	print "<td class=colheadsite width=1% align=center>Bewerken</td>";
	print "<td class=colheadsite width=1% align=center>Verwijderen</td>";
	print "<td class=colheadsite width=1% align=center>Voorbeeld</td>";
	print "</tr>" ;

	$res = mysqli_query($con_link, "SELECT * FROM aktie") or sqlerr(__FILE__, __LINE__);
	while ($row = mysqli_fetch_assoc($res))
		{
		print "<tr>";
		print "<td bgcolor=white align=center><font size=2><b>".htmlspecialchars($row['datum'])."</td>";
		print "<td bgcolor=white align=center>".htmlspecialchars($row['krediet'])."</td>";
		print "<td bgcolor=white>".htmlspecialchars($row['aktie'])."</td>";
//		print "<td bgcolor=white>".get_username($row['added_by'])."</td>";
//		print "<td bgcolor=white>".convertdatum($row['added'])."</td>";

		print "<td bgcolor=white>";
		print "<form method=post action=''>";
		print "<input type=hidden name=action value=bewerken>";
		print "<input type=hidden name=aktie_id value=".$row['id'].">";
		print "<input type=submit style='height: 22px' value='Bewerk'>";
		print "</form>";
		print "</td>";

		print "<td bgcolor=white>";
		print "<form method=post action=''>";
		print "<input type=hidden name=action value=verwijderen>";
		print "<input type=hidden name=aktie_id value=".$row['id'].">";
		print "<input type=submit style='height: 22px' value='Verwijder'>";
		print "</form>";
		print "</td>";

		print "<td bgcolor=white>";
		print "<form method=post action=''>";
		print "<input type=hidden name=action value=voorbeeld>";
		print "<input type=hidden name=aktie_id value=".$row['id'].">";
		print "<input type=submit style='height: 22px' value='Voorbeeld'>";
		print "</form>";
		print "</td>";

		print "</tr>";
		}
	print "</table>";
	}

print "<br><hr>";
print "<form method=post action=''>";
print "<input type=hidden name=action value=nieuw>";
print "<input type=submit style='height: 28px;width: 180px' value='Nieuwe aktie aanmaken'>";
print "</form>";

tabel_einde();
page_einde();	

if ($aktie_test)
	{
	print "<hr>";
	print $aktie_test;
	print "<hr>";
	}

new_footer(false);
?>
