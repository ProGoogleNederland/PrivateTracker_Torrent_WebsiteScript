<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_UPLOADER)
	site_error_message("Foutmelding", "U heeft geen toegang tot deze pagina.");

$action = (string)@$_POST['action'];
$until = $CURUSER['donor_until'];

//mysqli_query($con_link, "UPDATE users SET bonus_punten = bonus_punten + 20000 WHERE id=1") or sqlerr(__FILE__, __LINE__);
//die;

if ($action == "bp_verkopen")
	{
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$CURUSER[id]") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if ($row['bonus_punten'] < 10000)
		site_error_message("Foutmelding", "U heeft geen saldo meer, dus bewerking kan niet verwerkt worden.");
	
	$descr = "Week donateurschap tot ".convertdatum(create_date_week($until),"Nee")." voor 10.000 BP.";
	$descr = sqlesc($descr);
	$until = create_date_week($until);
	$until_save = sqlesc($until);
	$added = sqlesc(get_date_time());
	$user_id = $CURUSER['id'];

	$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\n" . $row['modcomment']);

	mysqli_query($con_link, "UPDATE users SET bonus_punten = bonus_punten - 10000, donor='yes', donor_until=$until_save, modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
//	mysqli_query($con_link, "INSERT INTO users_bonus_punten (user_id, descr, added) VALUES ($user_id, $descr, $added)") or sqlerr(__FILE__, __LINE__);

	$CURUSER['bonus_punten'] -= 10000;
	$CURUSER['donor_until'] = $until;
	$CURUSER['donor'] = 'yes';
	}

$bonus_punten = $CURUSER['bonus_punten'];

site_header("Krediet");
page_start(99);

if ($bonus_punten == 1)
	tabel_top("Uw saldo is $bonus_punten punt","center");
else
	tabel_top("Uw saldo is $bonus_punten punten","center");

tabel_start();

if ($CURUSER['donor'] == 'yes')
	print "<font size=2 color=white><b>U bent nog donateur tot en met " . convertdatum($CURUSER['donor_until'],"Nee") . "</b></font><br><hr>";

if ($bonus_punten < 10000)
	print "<br><font size=2 color=white><b>U heeft nu ".$bonus_punten." BP en u heeft minimaal 10.000 BP nodig om ze in te kunnen wisselen.<br><br>";
else
	{
	print "<br>";
	if ($CURUSER['donor'] == 'yes')
		print "<font size=2 color=white><b>Op deze pagina kunt u als uploader bij ons uw verdiende BP omzetten met 1 week donateurschap verlengen.<br>";
	else
		print "<font size=2 color=white><b>Op deze pagina kunt u als uploader bij ons uw verdiende BP omzetten naar 1 week donateurschap.<br>";
	print "<br>";
	print "<font size=2 color=white><b>Uw donateuschap loopt dan tot ".convertdatum(create_date_week($CURUSER['donor_until']),"Nee").".<br>";
	print "<br>";
	print "<hr><br>";
	print "<table width=90% border=0 class=bottom><tr><td class=embedded><div align=center>";
	print "<form method=post action=>";
	print "<input type=hidden name=action value=bp_verkopen>";
	print "<input type=submit style='height: 32px;width: 400px;background:yellow;color:blue;font-weight:bold' value='Donateurschap tot ".convertdatum(create_date_week($CURUSER['donor_until']),"Nee")." voor 10.000 BP'></form>";
	print "</tr></td><tr><td colspan=2 class=embedded>";
	print "</td></tr></table>";
	print "<br>";
	}
print "</td></tr></table>";

tabel_einde();
page_einde();
site_footer();

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
?>
