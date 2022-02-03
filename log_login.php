<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

function puke($text)
	{
	new_error_message("Foutmelding", $text);
	}

if (get_user_class() < UC_SYSOP)
	puke("Alleen toegang voor administrator of hoger... Wegwezen dus...");

$legen = (string)@$_GET['legen'];

if (get_user_class() == UC_GOD)
	{
	if ($legen == 'legen')
		mysqli_query($con_link, "TRUNCATE TABLE sitelog_login") or sqlerr(__FILE__, __LINE__);
	}

$secs = 1 * 24 * 60 * 60;

site_header("Logboek aanmelden");
//site_menu(false);
print "<br>";

mysqli_query($con_link, "DELETE FROM sitelog_login WHERE " . gmtime() . " - UNIX_TIMESTAMP(added) > $secs") or sqlerr(__FILE__, __LINE__);

$res = mysqli_query($con_link, "SELECT added, txt FROM sitelog_login ORDER BY added DESC") or sqlerr(__FILE__, __LINE__);

if (mysqli_num_rows($res) == 0)
	print("<b><font color=white size=8>Logboek is leeg</b>\n");
else
	{
	print("<table class=bottom width=80% border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
	if (get_user_class() == UC_GOD)
		tabel_top("Foutieve aanmeldingen logboek <a class=altlink_white href='?legen=legen'>Legen</a>");
	else
		tabel_top("Foutieve aanmeldingen logboek");
	tabel_start();
	print("<table width=100% border=1 cellspacing=0 cellpadding=5>\n");
	print("<tr><td class=colheadsite align=left>Datum</td><td class=colheadsite align=left>Tijd</td><td class=colheadsite align=left>Gebeurtenis</td></tr>\n");
	while ($arr = mysqli_fetch_assoc($res))
		{
		$date = convertdatum($arr['added'],"no");
		$time = substr($arr['added'], strpos($arr['added'], " ") + 1);
		print("<tr><td bgcolor=white>$date</td><td bgcolor=white>$time</td><td align=left bgcolor=white>$arr[txt]</td></tr>\n");
		}
	print("</table>");
	tabel_einde();
	print("</td></tr></table><br>");
	
	}
page_einde();
new_footer(false);
?>