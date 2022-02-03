<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_SYSOP)
	site_error_message("Foutmelding", "U heeft hier niet te zoeken, oprotten dus.");

$action = (string)@$_POST['action'];

if ($action == 'onderhoud_aan')
	{
	mysqli_query($con_link, "UPDATE site_vars SET var_data = 'ja' WHERE var_name = 'service'") or sqlerr(__FILE__, __LINE__);
	}

if ($action == 'onderhoud_uit')
	{
	mysqli_query($con_link, "UPDATE site_vars SET var_data = 'nee' WHERE var_name = 'service'") or sqlerr(__FILE__, __LINE__);
	}

if ($action == 'onderhoud_tekst')
	{
	$service_text = (string)@$_POST['service_text'];
	if (!$service_text)
		site_error_message("Foutmelding", "Niets ontvangen om te verwerken.");
	mysqli_query($con_link, "UPDATE site_vars SET var_data = '".$service_text."' WHERE var_name = 'service_text'") or sqlerr(__FILE__, __LINE__);
	}

get_site_vars();
site_header("Instellingen");
page_start(98);
tabel_top("Site instellingen","center");
tabel_start();

print "<table class=bottom border=0 width=100% cellpadding=5><tr><td class=colhead colspan=2>";

print "<div align=center>\n";

print "</td></tr><tr><td class=embedded bgcolor=white>&nbsp;&nbsp;";
print "<font size=2><b>Onderhoudsbericht op de hele site (SPATIE VOOR GEEN)</b></font><br>";
print "<form method=post action=''>";
print "<input type=hidden name=action value=onderhoud_tekst>";
print "<input maxlength=255 type=text size=200 name=service_text value=\"" . htmlspecialchars($SV['service_text']) . "\">";
print "<br>\n";
print "<input type=submit style='height:28px;width:200px;background:blue;color:white;font-weight:bold' value='Bericht online plaatsen'>";
print "</form>";
print "</td><td bgcolor=white class=embedded valign=bottom>&nbsp;&nbsp;";

if ($SV['service'] == 'ja')
	{
	print "<form method=post action=''>";
	print "<input type=hidden name=action value=onderhoud_uit>";
	print "<input type=submit style='height:28px;width:280px;background:red;color:white;font-weight:bold' value='Onderhoud uitzetten, staat momenteel aan.'>";
	print "</form>";
	}
else
	{
	print "<form method=post action=''>";
	print "<input type=hidden name=action value=onderhoud_aan>";
	print "<input type=submit style='height:28px;width:280px;background:green;color:white;font-weight:bold' value='Onderhoud aanzetten, staat momenteel uit.'>";
	print "</form>";
	}

	print "<br>";

tabel_einde();
page_einde();
site_footer();
?>