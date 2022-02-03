<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

$action = (string)@$_POST['action'];

if ($action == 'bp_kopen')
	{
	$aantal = (int)@$_POST['aantal'];
	if ($CURUSER['credits'] < 4 && $aantal == 500)
		site_error_message("Foutmelding", "U heeft niet genoeg krediet voor deze optie.");
	if ($CURUSER['credits'] < 1  && $aantal == 100)
		site_error_message("Foutmelding", "U heeft niet genoeg krediet voor deze optie.");
	if ($aantal == 100 && $CURUSER['credits'] >= 1)
		{
		mysqli_query($con_link, "UPDATE users set bonus_punten = bonus_punten + 100, credits = credits - 1 WHERE id='".$CURUSER['id']."'") or sqlerr(__FILE__, __LINE__);
		$CURUSER['bonus_punten'] = $CURUSER['bonus_punten'] + 100;
		$CURUSER['credits'] = $CURUSER['credits'] - 1;
		$extra_tekst = "<font size=4 color=white><b>Gefeliciteerd u heeft nu 100 BP gekocht voor 1 kredietpunt.</b></font>";

		$descr = "100 BP gekocht voor 1 kredietpunt.";
		$descr = sqlesc($descr);
		$added = sqlesc(get_date_time());
		$user_id = $CURUSER['id'];
		mysqli_query($con_link, "INSERT INTO users_credits (user_id, descr, added) VALUES ($user_id, $descr, $added)") or sqlerr(__FILE__, __LINE__);
		}
	if ($aantal == 500 && $CURUSER['credits'] >= 4)
		{
		mysqli_query($con_link, "UPDATE users set bonus_punten = bonus_punten + 500, credits = credits - 4 WHERE id='".$CURUSER['id']."'") or sqlerr(__FILE__, __LINE__);
		$CURUSER['bonus_punten'] = $CURUSER['bonus_punten'] + 500;
		$CURUSER['credits'] = $CURUSER['credits'] - 4;
		$extra_tekst = "<font size=4 color=white><b>Gefeliciteerd u heeft nu 500 BP gekocht voor 4 kredietpunten.</b></font>";

		$descr = "500 BP gekocht voor 4 kredietpunten.";
		$descr = sqlesc($descr);
		$added = sqlesc(get_date_time());
		$user_id = $CURUSER['id'];
		mysqli_query($con_link, "INSERT INTO users_credits (user_id, descr, added) VALUES ($user_id, $descr, $added)") or sqlerr(__FILE__, __LINE__);
		}
	}

site_header("Bonus punten");
page_start(98);
tabel_top("BP (Bonus Punten) uitleg","center");
tabel_start();

if ($extra_tekst)
	print "<center>".$extra_tekst."</center>";

print "<table class=bottom width=70% border=0 cellspacing=0 cellpadding=5><tr><td class=embedded>\n";

print "<center><font color=white size=4><b>Koop hier uw BP (Bonus Punten).</b></font></center>\n";
print "<br><hr><font color=white size=2><b>\n";

print "BP (Bonus Punten) zijn punten die u een uploader kunt geven als blijk van waardering voor het plaatsen van een torrent.<br><br>\n";
print "BP zijn er in vier valuta, namelijk 10, 25, 50 en 100.<br><br>\n";

print "<img height=75 width=75 src='pic/bp/bp_010.png'>";
print "<img height=75 width=75 src='pic/bp/bp_025.png'>";
print "<img height=75 width=75 src='pic/bp/bp_050.png'>";
print "<img height=75 width=75 src='pic/bp/bp_100.png'>";
print "<br><br>\n";
print "U kunt maximaal 100 BP per torrent geven aan een uploader.<br><br>\n";
print "Voor 1 kredietpunt ontvangt u 100 BP en voor 4 kredietpunten ontvangt u 500 BP.<br><br>\n";
print "U heeft nu ".$CURUSER['bonus_punten']." BP en u heeft nu ".$CURUSER['credits']." kredietpunten.\n";
print "<br><br>\n";
print "<font size=4 color=yellow>LET OP: U kunt geen BP inwisselen voor kredietpunten.</font>";
print "<div align=center>";

if ($CURUSER['credits'] > 0)
	{
	print "<hr>\n";
	print "<br>\n";
	print "<table class=bottom width=70% border=0 cellspacing=0 cellpadding=5><tr><td class=embedded>\n";
	print "<form method=post action=''>\n";
	print "<input type=hidden name=action value=bp_kopen>\n";
	print "<input type=hidden name=aantal value=100>\n";
	print "<input type=submit style='height:32px;width:250px;color:white;background:red;font-weight:bold' value='Nu 100 BP kopen voor 1 kredietpunt'>\n";
	print "</form>\n";
	if ($CURUSER['credits'] >= 4)
		{
		print "</td><td class=embedded>\n";
		print "<form method=post action=''>\n";
		print "<input type=hidden name=action value=bp_kopen>\n";
		print "<input type=hidden name=aantal value=500>\n";
		print "<input type=submit style='height:32px;width:250px;color:white;background:red;font-weight:bold' value='Nu 500 BP kopen voor 4 kredietpunten'>\n";
		print "</form>\n";
		}
	else
		{
		print "</td><td class=embedded>&nbsp;\n";
		}
	print "</td></tr></table>\n";
	}
else
	{
	print "<hr>\n";
	print "<br>\n";
	print "<form method=post action='donatie.php'>\n";
	print "<input type=submit style='height:32px;width:250px;color:white;background:red;font-weight:bold' value='Nu krediet gaan kopen'>\n";
	print "</form>\n";
	}
print "</td></tr></table>\n";
tabel_einde();
page_einde();
site_footer();
?>