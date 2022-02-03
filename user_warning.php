<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "U ben niet bevoegd om deze pagina te bekijken.");

$user_id = 0 + @$_GET['user_id'];

$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);
if (!$row)
	site_error_message("Foutmelding", "Geen gebruiker gevonden met dit id.");

if ($row['donor'] == "yes")
	site_error_message("Foutmelding", "Donateurs kunnen niet gewaarschuwd worden.");

if ($row['class'] >= UC_UPLOADER)
	site_error_message("Foutmelding", "Stafleden kunnen niet gewaarschuwd worden.");

$action = @$_GET['action'];

if ($action == "send")
	{
	//
	}

site_header("Waarschuwen");
page_start();
tabel_top("<a class=altlink_yellow href=userdetails.php?id=".$user_id.">" . get_usernamesite($user_id) . "</a> waarschuwen.","center");
tabel_start();

print "<table class=bottom width=40% border=0 cellspacing=0 cellpadding=10>";
print "<tr>";
print "<td class=colheadsite align=left>Lengte&nbsp;waarschuwing</td>";
print "<td class=colheadsite align=left>Reden&nbsp;waarschuwing</td>";
print "</tr>";

print "<tr>";
print "<td bgcolor=white align=left>";
print "<input type=radio name=lengte value=24>24 uur<hr>";
print "<input type=radio name=lengte value=48>48 uur<hr>";
print "<input type=radio name=lengte value=72>72 uur<hr>";
print "<input type=radio name=lengte value=144>144 uur<br>";
print "</td>";
print "<td bgcolor=white align=left>";
print "<input type=radio name=lengte value=24>24 uur<hr>";
print "<input type=radio name=lengte value=48>48 uur<hr>";
print "<input type=radio name=lengte value=72>72 uur<hr>";
print "<input type=radio name=lengte value=144>144 uur<br>";
print "</td>";
print "</tr>";

print "</table>";

tabel_einde();
page_einde();
site_footer();
?>
