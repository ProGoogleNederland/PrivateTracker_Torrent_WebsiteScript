<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();

loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de administrator en hoger.");

site_header("Niet verbindbaar");

$res = mysqli_query($con_link, "SELECT * FROM peers WHERE connectable='no'") or sqlerr(__FILE__, __LINE__);	
//$row = mysqli_fetch_array($res);

$aantal = mysqli_num_rows($res);

$totaal = number_format(get_row_count("peers", ""));
tabel_start();
print("<table width=95% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
print("<br>");
tabel_top("$aantal niet verbindbaar van de $totaal bronnen");
print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td class=embedded align=center><center><br>");
print("<table width=95% class=outer border=1 cellspacing=0 cellpadding=5>");
print("<tr>");
print "<td class=colheadsite>Gebruiker</td>";
print "<td class=colheadsite>Bronnen</td>";
print "<td class=colheadsite>Ontvangen</td>";
print "<td class=colheadsite>Verzonden</td>";
print "<td class=colheadsite>Laatste contact</td>";
print "<td class=colheadsite>Torrent</td>";

print("</tr>");

while ($row = mysqli_fetch_assoc($res)) {

	print("<tr><td bgcolor=white>");
	print("<a href=userdetails.php?id=$row[userid]>" .get_usernamesitesmal($row[userid]) . "</a>");
	print("</td><td bgcolor=white>");
	
	$bronnen = number_format(get_row_count("peers", "WHERE userid=$row[userid] AND seeder='no'"));
	$delen = number_format(get_row_count("peers", "WHERE userid=$row[userid] AND seeder='yes'"));
	if ($bronnen > 0)
		print("<center>$bronnen&nbsp;-&nbsp;$delen</center>");
	else		
		print("<center><font color=red>$bronnen&nbsp;-&nbsp;$delen</font></center>");
	print("</td><td bgcolor=white>");
	print(mksize($row['downloaded']));
	print("</td><td bgcolor=white>");
	print(mksize($row['uploaded']));
	print("</td><td bgcolor=white>");
	print(convertdatum($row['last_action'])) . " (" . get_elapsed_time(sql_timestamp_to_unix_timestamp($row["last_action"])) . " geleden)";
	print("</td><td bgcolor=white>");
	$modcommnent = $row['modcomment'];
	print($row['torrent']);
	print("</td>");
	print("</tr>");
}
print("</td></tr></table>");

print("<br></td></tr></table>");
print("</td></table><br>");
tabel_einde();
site_footer();

?>