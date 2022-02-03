<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_OWNER)
	site_error_message("Foutmelding", "U ben niet bevoegd om deze pagina te bekijken.");

$user_id = 0 + @$_GET['user_id'];

if (!$user_id)
	site_error_message("Foutmelding", "Geen user_id ontvangen.");

$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$user_id") or sqlerr();
$row = mysqli_fetch_array($res);
if (!$row)
	site_error_message("Foutmelding", "Geen gebruiker gevonden.");

$action = @$_GET['action'];

if ($action == "blokkeren_opheffen")
	{
	$blocked_reason = sqlesc("");
	$added = sqlesc("0000-00-00 00:00:00");

	mysqli_query($con_link, "UPDATE users SET blocked = 'no', blocked_by = 0, blocked_date = $added, blocked_reason = $blocked_reason WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	
	header("Refresh: 0; url=userdetails.php?id=" . $user_id);
	die;
	}

if ($action == "blokkeren")
	{
	if ($row['class'] > 2)
		site_error_message("Foutmelding", "Deze optie is niet mogelijk voor uploaders of hoger.");
	if ($row['donor'] == "yes") 
		site_error_message("Foutmelding", "Deze gebruiker is donateur, account kan niet geblokkeerd worden.");
	$blocked_reason = (string) $_GET['blocked_reason'];
	if (!$blocked_reason)
		site_error_message("Foutmelding", "Geen reden ontvangen om te verwerken.");
	if (strlen($blocked_reason) < 15)
		site_error_message("Foutmelding", "De door u opgegeven reden is te klein om te verwerken.");
	if (strlen($blocked_reason) > 100)
		site_error_message("Foutmelding", "De door u opgegeven reden is te groot om te verwerken.");

	$blocked_reason = sqlesc($blocked_reason);
	$added = sqlesc(get_date_time());

	mysqli_query($con_link, "UPDATE users SET blocked = 'yes', blocked_by = $CURUSER[id], blocked_date = $added, blocked_reason = $blocked_reason WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	header("Refresh: 0; url=userdetails.php?id=" . $user_id);
	die;
	}

if ($row['class'] > 2)
	site_error_message("Foutmelding", "Deze optie is niet mogelijk voor uploaders of hoger.");

site_header("Blokkeren");
page_start(98);
tabel_top("Account van " . get_username($user_id) . " blokkeren.","center");
tabel_start();
if ($row['blocked'] == "yes")
	{
	print "<form method=get action=''>";
	print "<input type=hidden name=user_id value=" . $user_id . ">";
	print "<input type=hidden name=action value=blokkeren_opheffen>";
	print "<input type=submit style='height: 32px;width: 300px' value='Blokkering opheffen' class=btn>";
	print "</form>";
	}
else
	{
	if ($row['donor'] == "yes") 
		site_error_message("Foutmelding", "Deze gebruiker is donateur, account kan niet geblokkeerd worden.");
	print "<table class=bottom><tr><td class=embedded>";
	print "<form method=get action=''>";
	print "<input type=hidden name=user_id value=" . $user_id . ">";
	print "</td></tr>";
	print "<font color=white size=2><b>Geef korte maar duidelijke reden op:</b></font>";
	print "<tr><td class=embedded>";
	print "<input type=hidden name=action value=blokkeren>";
	print "<input maxlength=100 type=text size=125 name=blocked_reason value=''>";
	print "</td></tr>";
	print "<tr><td class=embedded><div align=center><br>";
	print "<input type=submit style='height: 32px;width: 300px' value='Account blokkeren' class=btn>";
	print "</form>";
	print "</td></tr></table>";
	print "<br><hr>";
	
	print "<font color=white size=2><b>";
	print "Als het account van een gebruiker geblokkeerd is dan kan deze geen nieuwe torrents meer downloaden van de site.<br>";
	print "Tevens ziet de gebruiker tijdens de blokkade een ververlend scherm in zijn beeld, hierin staat het volgende:";
	print "<li>De naam van diegene die hem geblokkeerd heeft.";
	print "<li>De datum dat hij geblokeerd is.";
	print "<li>De reden van de blokkade hierboven aangegeven.";
	print "<li>Duidelijke verwijzing om een bericht te sturen aan diegene die hem geblokkeerd heeft.";
	print "</b></font>";
	}
tabel_einde();
page_einde();
site_footer();
?>
