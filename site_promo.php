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

if ($action == 'promo_tekst')
	{
	$promo_text = (string)@$_POST['promo_text'];
	if (!$promo_text)
		site_error_message("Foutmelding", "Niets ontvangen om te verwerken.");
	mysqli_query($con_link, "UPDATE site_vars SET var_data = '".$promo_text."' WHERE var_name = 'promo_text'") or sqlerr(__FILE__, __LINE__);
	}

get_site_vars();
site_header("Promo");
page_start(98);
tabel_top("Promo instellingen","center");
tabel_start();

print "<table class=bottom border=0 width=100% cellpadding=5><tr><td class=colhead colspan=2>";

print "<div align=center>\n";

print "</td></tr><tr><td class=embedded bgcolor=white>&nbsp;&nbsp;";
print "<font size=2><b>Bericht op de hele site </b></font><br>";
print "<form method=post action=''>";
print "<input type=hidden name=action value=promo_tekst>";
print "<input maxlength=255 type=text size=200 name=promo_text value=\"" . htmlspecialchars($SV['promo_text']) . "\">";
print "<br>\n";
print "<input type=submit style='height:28px;width:200px;background:blue;color:white;font-weight:bold' value='Bericht online plaatsen'>";
print "</form>";
print "</td><td bgcolor=white class=embedded valign=bottom>&nbsp;&nbsp;";

	print "<br>";

tabel_einde();
page_einde();
site_footer();
?>