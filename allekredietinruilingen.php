<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_OWNER)
 site_error_message("Foutmelding", "Deze pagina is alleen voor de moderator en hoger.");

$until = $CURUSER['donor_until'];

$downloaded = $CURUSER['downloaded'];
$uploaded = $CURUSER['uploaded'];
$verschil = 12*1024*1024*1024;

if (($downloaded - $uploaded) >= $verschil)
	$grens = false;
else
	$grens = true;
/*
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
*/
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

site_header("Kredietpunten overzicht");
tabel_start();
	$res = mysqli_query($con_link, "SELECT * FROM users_credits ORDER BY added DESC") or sqlerr(__FILE__, __LINE__);
	if (mysqli_num_rows($res) > 0) 
		{
		print "<font size=4 color=lightblue><b>Overzicht gebruikte punten.<br>\n";
		print "<table width=95% border=1 cellspacing=0 cellpadding=5>\n";
		print "<tr><td class=colheadsite align=left>Datum</td><td class=colheadsite align=left>Door</td><td class=colheadsite align=left>Tijd</td><td class=colheadsite align=left>Gebeurtenis</td></tr>\n";
		while ($arr = mysqli_fetch_assoc($res))
			{
			$door = $arr['user_id'];
			$date = convertdatum($arr['added'],"no");
			$time = substr($arr['added'], strpos($arr['added'], " ") + 1);
			print "<tr><td bgcolor=white class=td_site>$date</td><td bgcolor=white class=td_site><a class=altlink_blue href=userdetails.php?id=$door>" .get_usernamesitesmal($door) . "" . get_userratio($door) . "</a></td><td bgcolor=white class=td_site>$time</td><td bgcolor=white align=left class=td_site>$arr[descr]</td></tr>\n";
			}
		print "</table>";
		}
		
tabel_einde();
site_footer();
?>
