<?php
ob_start("ob_gzhandler");
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de admins.");

site_header("Krediet overzicht");

$aantal = get_row_count("users", "WHERE credits > 0");

page_start();	
tabel_top("Donateurs - $aantal stuks</center></font>");
tabel_start();

print "<table class=outer border=1 cellspacing=0 cellpadding=5>" ;
print "<tr>" ;
print "<td class=colheadsite>Gebruiker</td>";
print "<td class=colheadsite>Verzonden</td>";
print "<td class=colheadsite>Ontvangen</td>";
print "<td class=colheadsite>Verschil</td>";
print "<td class=colheadsite>Krediet gebruiken</td>";
	if (get_user_class() >= UC_SYSOP)
	{
	print "<td class=colheadsite>Gebruiken</td>";
	}
print "</tr>" ;

$res = mysqli_query($con_link, "SELECT * FROM users WHERE credits > 0 ORDER BY (uploaded - downloaded) DESC") or sqlerr();
while ($row = mysqli_fetch_assoc($res))
	{
	print "<tr>";
	print "<td bgcolor=white><a class=altlink_blue href=userdetails.php?id=" . $row['id'] . ">" . get_usernamesitesmal($row['id']) . "</a></td>";
	print "<td bgcolor=white align=right>" . mksize($row['uploaded']) . "</td>";
	print "<td bgcolor=white align=right>" . mksize($row['downloaded']) . "</td>";
	$verschil = $row['uploaded'] - $row['downloaded'];
	$color = "#FF0000";
	if ($verschil < -1*1024*1024*1024) $color = "#FF0000";
	if ($verschil < -2*1024*1024*1024) $color = "#EE0000";
	if ($verschil < -4*1024*1024*1024) $color = "#DD0000";
	if ($verschil < -6*1024*1024*1024) $color = "#CC0000";
	if ($verschil < -7*1024*1024*1024) $color = "#BB0000";
	if ($verschil < -10*1024*1024*1024) $color = "#AA0000";
	if ($verschil < -15*1024*1024*1024) $color = "#990000";
	if ($verschil < -20*1024*1024*1024) $color = "#880000";
	if ($verschil > 0) $color = "green";
	print "<td bgcolor=white align=right><font color=$color>" . mksizegb($verschil) . "</td>";
	print "<td bgcolor=white align=right>" . $row['credits'] . "</td>";
	if (get_user_class() >= UC_SYSOP)
		{
		print "<td width=130 bgcolor=white align=right>";
		print "<a class=altlink_blue href=credits_admin.php?user_id=".$row['id'].">Krediet&nbsp;gebruiken</a>";
		print "</td>";
		}
	print "</tr>";
	}

print("</td></tr></table>");
tabel_einde();
page_einde();
site_footer();
?>