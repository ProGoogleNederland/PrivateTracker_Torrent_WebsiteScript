<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	new_error_message("Foutmelding", "U heeft geen rechten om deze pagina te bekijken.");
		
$res = mysqli_query($con_link, "SELECT * FROM users WHERE blocked='yes' ORDER BY blocked_date DESC") or sqlerr(__FILE__, __LINE__);

site_header("Accounts");
//site_menu(false);
print "<br>";
page_start(98);
tabel_start();
tabel_top("Gebruikers waarvan account is uitgeschakeld", "center");
print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded><br>");
print("<table align=center class=sitetable border=1 cellspacing=0 cellpadding=5>");

print "<tr>";
print "<td class=colheadsite width=100>Door</td>";
print "<td class=colheadsite width=500>Mod commentaar</td>";
print "<td class=colheadsite width=100>Datum</td>";
print "<td class=colheadsite width=100>Gebruiker</td>";
print "</tr>";

while ($row = mysqli_fetch_assoc($res))
	{
	print "<tr>";
	print "<td bgcolor=white><a class=altlink_blue href=userdetails.php?id=" . $row['blocked_by'] . ">" . get_usernamesitesmal($row['blocked_by']) . "</a></td>";
	print "<td bgcolor=white width=400>".htmlspecialchars($row['blocked_reason'])."</td>";
	print "<td bgcolor=white>".convertdatum($row['blocked_date'])."</td>";
	$ip = sqlesc(long2ip(@$arr['first']));
	$count = get_row_count("users","WHERE ip=$ip");

	print "<td bgcolor=white>";
	print "<a class=altlink_blue href=userdetails.php?id=" . $row['id'] . ">" . get_usernamesitesmal($row['id']) . " " . get_ratio($row['id']) . "</a>";
	print "</td>";
	print "</tr>";
	$temp = long2ip(@$arr['first']);
	}

tabel_einde();
page_einde();
site_footer(false);
?>