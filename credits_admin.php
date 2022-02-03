<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_SYSOP)
	site_error_message("Foutmelding", "U ben niet bevoegd om deze pagina te bekijken.");

$action = @$_GET['action'];
$user_id = @$_GET['user_id'];

$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);

if (!$row)
	site_error_message("Foutmelding", "Geen gebruiker gevonden met dit id.");

$until = $row['donor_until'];
$credits = $row['credits'];
$downloaded = $row['downloaded'];
$uploaded = $row['uploaded'];
$verschil = 12*1024*1024*1024;

if (($downloaded - $uploaded) >= $verschil)
	$grens = false;
else
	$grens = true;

function create_date_week($until)
	{
	$datum = get_date_time();
	if ($until == "0000-00-00 00:00:00")
		return date("Y-m-d H:i:s",mktime(0, 0, 0, date("m"), date("d")+7,  date("Y")));
	else
		if ($until > $datum)
			{
			$day = substr($until,8,2);
			$month = substr($until,5,2);
			$year = substr($until,0,4);
			return date("Y-m-d H:i:s",mktime(0, 0, 0, $month, $day+7,  $year));
			}
		else
			return date("Y-m-d H:i:s",mktime(0, 0, 0, date("m"), date("d")+7,  date("Y")));
	}

function create_date_month($until)
	{
	$datum = get_date_time();
	if ($until == "0000-00-00 00:00:00")
		return date("Y-m-d H:i:s",mktime(0, 0, 0, date("m")+1, date("d"),  date("Y")));
	else
		if ($until > $datum)
			{
			$day = substr($until,8,2);
			$month = substr($until,5,2);
			$year = substr($until,0,4);
			return date("Y-m-d H:i:s",mktime(0, 0, 0, $month+1, $day,  $year));
			}
		else
			return date("Y-m-d H:i:s",mktime(0, 0, 0, date("m")+1, date("d"),  date("Y")));
	}

if ($action == "get_donatie_groot")
	{
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if ($row['credits'] < 4)
		site_error_message("Foutmelding", "Er is geen saldo meer, dus bewerking kan niet verwerkt worden.");
	
	$descr = "Maand donateurschap tot ".convertdatum(create_date_month($until),"Nee")." voor 4 punten en een verhoging van  ".mksize($donatie_groot)." - Totaal verzonden: voor = ".mksize($row['uploaded'])." en na ".mksize($row['uploaded'] + $donatie_groot).".";
	$descr = sqlesc($descr);
	$until = create_date_month($until);
	$until_save = sqlesc($until);
	$added = sqlesc(get_date_time());

	$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\n" . $row['modcomment']);

	$msg = "Hallo ".get_username($user_id).",\n\n";
	$msg .= "Het systeem heeft 4 punten gebruikt voor het volgende:\n\n";
	$msg .= $descr . "\n\n";
	$msg .= "Met vriendelijke groet,\n\n" . $SITE_NAME;
	$msg = sqlesc($msg);
	$dt = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, added, msg, poster) VALUES(0, $user_id, $dt, $msg, 0)");

	if ($row['warned'] == "yes")
		{
		mysqli_query($con_link, "UPDATE users SET warned='no' WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
		$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\nWaarschuwing verwijderd in verband met donatie.\n" . $row['modcomment']);
		}

	if ($row['class'] < 3)
		mysqli_query($con_link, "UPDATE users SET class=2 WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);

	mysqli_query($con_link, "UPDATE users SET invites = invites + 1, uploaded = uploaded + $donatie_groot, credits = credits - 4, donor='yes', donor_until=$until_save, modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "INSERT INTO users_credits (user_id, descr, added) VALUES ($user_id, $descr, $added)") or sqlerr(__FILE__, __LINE__);
	header("Refresh: 0; url=credits_admin.php?user_id=$user_id");
	}

if ($action == "get_upload_big")
	{
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if ($row['credits'] < 4)
		site_error_message("Foutmelding", "Er is geen saldo meer, dus bewerking kan niet verwerkt worden.");
	
	$descr = "RATIO CORRECTIE van ".mksize($ratio_groot)." voor 4 punten - Totaal verzonden: voor = ".mksize($row['uploaded'])." en na ".mksize($row['uploaded'] + $ratio_groot).".";
	$descr = sqlesc($descr);
	$added = sqlesc(get_date_time());

	$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\n" . $row['modcomment']);

	$msg = "Hallo ".get_username($user_id).",\n\n";
	$msg .= "Het systeem heeft 4 punten gebruikt voor het volgende:\n\n";
	$msg .= $descr . "\n\n";
	$msg .= "Met vriendelijke groet,\n\n" . $SITE_NAME;
	$msg = sqlesc($msg);
	$dt = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, added, msg, poster) VALUES(0, $user_id, $dt, $msg, 0)");

	if ($row['warned'] == "yes")
		{
		mysqli_query($con_link, "UPDATE users SET warned='no' WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
		$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\nWaarschuwing verwijderd in verband met donatie.\n" . $row['modcomment']);
		}

	mysqli_query($con_link, "UPDATE users SET uploaded = uploaded + $ratio_groot, credits = credits - 4, modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "INSERT INTO users_credits (user_id, descr, added) VALUES ($user_id, $descr, $added)") or sqlerr(__FILE__, __LINE__);
	header("Refresh: 0; url=credits_admin.php?user_id=$user_id");
	}

if ($action == "get_extra_invite")
	{
	site_error_message("Foutmelding", "Optie uitgeschakeld.");
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if ($row['credits'] < 1)
		site_error_message("Foutmelding", "Er is geen saldo meer, dus bewerking kan niet verwerkt worden.");
	
	$descr = "Een extra uitnodiging ontvangen voor 1 punt";
	$descr = sqlesc($descr);
	$until = create_date_week($until);
	$until_save = sqlesc($until);
	$added = sqlesc(get_date_time());

	$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\n" . $row['modcomment']);

	$msg = "Hallo ".get_username($user_id).",\n\n";
	$msg .= "Het systeem heeft 1 punt gebruikt voor het volgende:\n\n";
	$msg .= $descr . "\n\n";
	$msg .= "Met vriendelijke groet,\n\n" . $SITE_NAME;
	$msg = sqlesc($msg);
	$dt = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, added, msg, poster) VALUES(0, $user_id, $dt, $msg, 0)");

	mysqli_query($con_link, "UPDATE users SET invites = invites + 1, credits = credits - 1, modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "INSERT INTO users_credits (user_id, descr, added) VALUES ($user_id, $descr, $added)") or sqlerr(__FILE__, __LINE__);
	header("Refresh: 0; url=credits_admin.php?user_id=$user_id");
	}

if ($action == "get_donatie_klein")
	{
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if ($row['credits'] < 1)
		site_error_message("Foutmelding", "Er is geen saldo meer, dus bewerking kan niet verwerkt worden.");
	
	$descr = "Week donateurschap tot ".convertdatum(create_date_week($until),"Nee")." en een verhoging van  ".mksize($donatie_klein)." - Totaal verzonden: voor = ".mksize($row['uploaded'])." en na ".mksize($row['uploaded'] + $donatie_klein).".";
	$descr = sqlesc($descr);
	$until = create_date_week($until);
	$until_save = sqlesc($until);
	$added = sqlesc(get_date_time());

	$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\n" . $row['modcomment']);

	$msg = "Hallo ".get_username($user_id).",\n\n";
	$msg .= "Het systeem heeft 1 punt gebruikt voor het volgende:\n\n";
	$msg .= $descr . "\n\n";
	$msg .= "Met vriendelijke groet,\n\n" . $SITE_NAME;
	$msg = sqlesc($msg);
	$dt = sqlesc(get_date_time());

	if ($row['class'] < 3)
		mysqli_query($con_link, "UPDATE users SET class=2 WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);

	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, added, msg, poster) VALUES(0, $user_id, $dt, $msg, 0)");

	mysqli_query($con_link, "UPDATE users SET uploaded = uploaded + $donatie_klein, credits = credits - 1, donor='yes', donor_until=$until_save, modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "INSERT INTO users_credits (user_id, descr, added) VALUES ($user_id, $descr, $added)") or sqlerr(__FILE__, __LINE__);
	header("Refresh: 0; url=credits_admin.php?user_id=$user_id");
	}

if ($action == "get_upload_smal")
	{
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if ($row['credits'] < 1)
		site_error_message("Foutmelding", "U heeft geen saldo meer, dus bewerking kan niet verwerkt worden.");
	
	$descr = "RATIO CORRECTIE van ".mksize($ratio_klein)." - Totaal verzonden: voor = ".mksize($row['uploaded'])." en na ".mksize($row['uploaded'] + $ratio_klein).".";
	$descr = sqlesc($descr);
	$added = sqlesc(get_date_time());

	$msg = "Hallo ".get_username($user_id).",\n\n";
	$msg .= "Het systeem heeft 1 punt gebruikt voor het volgende:\n\n";
	$msg .= $descr . "\n\n";
	$msg .= "Met vriendelijke groet,\n\n" . $SITE_NAME;
	$msg = sqlesc($msg);
	$dt = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, added, msg, poster) VALUES(0, $user_id, $dt, $msg, 0)");

	mysqli_query($con_link, "UPDATE users SET uploaded = uploaded + $ratio_klein, credits = credits - 1 WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "INSERT INTO users_credits (user_id, descr, added) VALUES ($user_id, $descr, $added)") or sqlerr(__FILE__, __LINE__);
	header("Refresh: 0; url=credits_admin.php?user_id=$user_id");
	}

site_header("Krediet");
page_start(90);

if ($credits == 1)
	tabel_top("Saldo van ".get_usernamesite($user_id)." is $credits punt","center");
else
	tabel_top("Saldo van ".get_usernamesite($user_id)." is $credits punten","center");
tabel_start();

print "<font size=4 color=yellow>Verzonden : " . mksize($uploaded) . " - " . "Ontvangen : " . mksize($downloaded) . "</font>";

if ($credits < 1)
	print "<font color=lightblue size=3><b>U heeft geen krediet punten meer.<br><br>";
if ($credits > 0)
	{
	print "<form method=get action=>";
	print "<input type=hidden name=action value=get_upload_smal>";
	print "<input type=hidden name=user_id value=".$user_id.">";
	print "<input type=submit style='height: 32px;width: 400px' value='Verhoog totaal verzonden met ".mksize($ratio_klein)." voor 1 punt'></form>";
	print "<br>";

	if ($grens)
		{
		print "<form method=get action=>";
		print "<input type=hidden name=action value=get_donatie_klein>";
		print "<input type=hidden name=user_id value=".$user_id.">";
		print "<input type=submit style='height: 32px;width: 400px' value='Donateurschap tot ".convertdatum(create_date_week($row['donor_until']),"Nee")." voor 1 punt'></form>";
		print "<br>";
		}

	if ($credits >= 4)
		{
		print "<form method=get action=>";
		print "<input type=hidden name=action value=get_upload_big>";
		print "<input type=hidden name=user_id value=".$user_id.">";
		print "<input type=submit style='height: 32px;width: 400px' value='Verhoog totaal verzonden met ".mksize($ratio_groot)." voor 4 punten'></form>";
		print "<br>";
		
		if ($grens)
			{
			print "<form method=get action=>";
			print "<input type=hidden name=action value=get_donatie_groot>";
			print "<input type=hidden name=user_id value=".$user_id.">";
			print "<input type=submit style='height: 32px;width: 400px' value='Donateurschap tot ".convertdatum(create_date_month($until),"Nee")." voor 4 punten'></form>";
			print "<br>";
			}
		}	

	/*
	print "<form method=get action=>";
	print "<input type=hidden name=action value=get_extra_invite>";
	print "<input type=hidden name=user_id value=".$user_id.">";
	print "<input type=submit style='height: 32px;width: 400px' value='Extra uitnodiging voor 1 punt'></form>";
	print "<br>";
	*/
	}
	
	$res = mysqli_query($con_link, "SELECT * FROM users_credits WHERE user_id=$user_id ORDER BY added DESC") or sqlerr(__FILE__, __LINE__);
	if (mysqli_num_rows($res) > 0)
		{
		print "<font size=4 color=lightblue><b>Overzicht gebruikte punten.<br>\n";
		print "<table width=95% border=1 cellspacing=0 cellpadding=5>\n";
		print "<tr><td class=colheadsite align=left>Datum</td><td class=colheadsite align=left>Tijd</td><td class=colheadsite align=left>Gebeurtenis</td></tr>\n";
		while ($arr = mysqli_fetch_assoc($res))
			{
			$date = convertdatum($arr['added'],"no");
			$time = substr($arr['added'], strpos($arr['added'], " ") + 1);
			print "<tr><td bgcolor=white class=td_site>$date</td><td bgcolor=white class=td_site>$time</td><td bgcolor=white align=left class=td_site>$arr[descr]</td></tr>\n";
			}
		print "</table>";
		}
		
tabel_einde();
page_einde();
site_footer();
?>
