<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_OWNER)
	site_error_message("Foutmelding", "U ben niet bevoegd om deze pagina te bekijken.");

$user_id = (int)@$_GET['user_id'];

if (!$user_id)
	site_error_message("Foutmelding", "Geen gebruikers ID ontvangen.");

$action = (string)@$_GET['action'];
if ($action == "wijzig")
	{
	$ammount = (int)@$_GET['ammount'];
	
	if ($ammount < 1)
		site_error_message("Foutmelding", "Krediet is lager dan 1, kan niet verwerkt worden.");
	if ($ammount > 500)
		site_error_message("Foutmelding", "Krediet is hoger dan 500, kan niet verwerkt worden.");
	$sender = $CURUSER['id'];
	
	$message = "Hallo " . get_username($user_id) . ",\n\n";
	$message .= "Uw krediet is met ".$ammount." verhoogd door ".get_username($sender)." op ".convertdatum(get_date_time())."\n\n";
	$message .= "Tevens heeft u 200 BP ontvangen.\n\n";
	$message .= "Met vriendelijke groet,\n";
	$message .= $CURUSER['username'];

	site_send_message($user_id,$sender,$message,false);

	mysqli_query($con_link, "UPDATE users SET bonus_punten = bonus_punten + 200, credits = credits + $ammount WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);

	$krediet = $ammount;
	$pincode = sqlesc("Handmatig");
	$added = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO donations_users (user_id, krediet, added, pincode) VALUES ($user_id, $krediet, $added, $pincode)");

	header("Refresh: 0; url=userdetails.php?id=" . $user_id);
	}

if ($action == "wijzig_donatie")
	{
	$ammount = (int)@$_GET['ammount'];
	
	if ($ammount < 1)
		site_error_message("Foutmelding", "Krediet is lager dan 1, kan niet verwerkt worden.");
	if ($ammount > 500)
		site_error_message("Foutmelding", "Krediet is hoger dan 500, kan niet verwerkt worden.");
	$sender = $CURUSER['id'];


	$message = "Hallo " . get_username($user_id) . "\n\n";
	$message .= "Wij hebben uw donatie ontvangen en verwerkt.\n\n";
	if ($ammount == 1)
		$message .= "Uw krediet is met ".$ammount." punt verhoogd.\n\n";
	else
		$message .= "Uw krediet is met ".$ammount." punten verhoogd.\n\n";
	$message .= "Tevens heeft u 200 BP ontvangen.\n\n";
	$message .= "Harstikke bedankt hiervoor, alle donatie's zullen ten goede komen voor het in leven houden en verbeteren van ".$SITE_NAME.".\n\n";
	$message .= "Met vriendelijke groet,\n";
	$message .= $CURUSER['username'];

	site_send_message($user_id,$sender,$message,false);

	mysqli_query($con_link, "UPDATE users SET bonus_punten = bonus_punten + 200, credits = credits + $ammount WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);

	$krediet = $ammount;
	$pincode = sqlesc("Handmatig");
	$added = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO donations_users (user_id, krediet, added, pincode) VALUES ($user_id, $krediet, $added, $pincode)");

	header("Refresh: 0; url=userdetails.php?id=" . $user_id);
	}

if ($action == "bonus_punten")
	{
	$ammount = (int)@$_GET['ammount'];
	
	if ($ammount < 100)
		site_error_message("Foutmelding", "Minimaal 100 BP.");
	if ($ammount > 50000)
		site_error_message("Foutmelding", "Maximaaal 50000 BP");
	$sender = $CURUSER['id'];

	$message = "Hallo " . get_username($user_id) . "\n\n";
	$message .= "Uw BP totaal is met ".$ammount." BP verhoogd.\n\n";
	$message .= "Veel plezier ermee.\n\n";
	$message .= "Met vriendelijke groet,\n";
	$message .= $CURUSER['username'];

	site_send_message($user_id,$sender,$message,false);

	mysqli_query($con_link, "UPDATE users SET bonus_punten = bonus_punten + $ammount WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);

	header("Refresh: 0; url=userdetails.php?id=" . $user_id);
	}

site_header("Krediet");
page_start();
tabel_top("Krediet verhogen van " . get_username($user_id),"center");
tabel_start();

print "<table class=bottom><tr><td class=embedded>";
print "<form method=get action=''>";
print "<input type=hidden name=user_id value=" . $user_id . ">";
print "<input type=hidden name=action value=wijzig>";
print "<input maxlength=8 type=text size=8 style='font-weight: bold; font-size: 12pt' name=ammount value=''>";
print "</td><td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
print "<input type=submit style='font-weight: bold;height: 28px;width: 300px' value='Krediet verhoging toepassen, normaal' class=btn>";
print "</form>";
print "</td></tr></table>";

print "<hr>";

print "<table class=bottom><tr><td class=embedded>";
print "<form method=get action=''>";
print "<input type=hidden name=user_id value=" . $user_id . ">";
print "<input type=hidden name=action value=wijzig_donatie>";
print "<input maxlength=8 type=text size=8 style='font-weight: bold; font-size: 12pt' name=ammount value=''>";
print "</td><td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
print "<input type=submit style='font-weight: bold; height: 28px;width: 300px' value='Krediet verhoging toepassen als donatie' class=btn>";
print "</form>";
print "</td></tr></table>";

print "<hr>";

print "<table class=bottom><tr><td class=embedded>";
print "<form method=get action=''>";
print "<input type=hidden name=user_id value=" . $user_id . ">";
print "<input type=hidden name=action value=bonus_punten>";
print "<input maxlength=8 type=text size=8 style='font-weight: bold; font-size: 12pt' name=ammount value=''>";
print "</td><td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
print "<input type=submit style='font-weight: bold; height: 28px;width: 300px' value='Bonus punten aan gebruiker geven' class=btn>";
print "</form>";
print "</td></tr></table>";
print "</td></tr></table>";

tabel_einde();
site_footer();
?>
