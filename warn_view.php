<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de administrator en hoger.");

site_header("Overzicht");

$id = @$_GET["id"];

if (!$id) {
	Print "<br>";
	Print "<font size=4 color=red>Geen gebruikers id ontvangen</font>";
	Print "<br>";
	Print "<br>";
	die;
}

$id = 0 + $id;
$res = mysqli_query($con_link, "SELECT * FROM users WHERE warnedby=$id") or sqlerr(__FILE__, __LINE__);	


print("<table width=90% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
tabel_top("Gewaarschuwde gebruikers door " . get_username($id));
print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td class=embedded align=center><center><br>");

print("<table class=outer border=1 cellspacing=0 cellpadding=5>");
print("<tr>");
print("<td class=colheadsite>Gebruiker</td>");
print("<td class=colheadsite>Functie</td>");
print("<td class=colheadsite>Laatst&nbsp;gezien</td>");
print("<td class=colheadsite>Comment</td>");
print("<td class=colheadsite>Verzonden</td>");
print("<td class=colheadsite>Ontvangen</td>");
print("<td class=colheadsite>Mod comment</td>");
print("</tr>");

while ($row = mysqli_fetch_assoc($res)) {
	print("<td bgcolor=white><a href=userdetails.php?id=$row[id]>" . get_usernamesitesmal($row[id]) . " " . get_userratio($row[id]) . "</a></td>");
	print("<td bgcolor=white>" . get_user_class_name($row["class"]) . "</td>");
	print("<td bgcolor=white>"  . get_elapsed_time(sql_timestamp_to_unix_timestamp($row["last_access"])) . " geleden</td>");
	if (get_row_count("comments", "WHERE user=$row[id]") > 0)
		print("<td align=center bgcolor=white><a href=userhistory.php?action=viewcomments&id=$row[id]>" . get_row_count("comments", "WHERE user=$row[id]") . "</a></td>");
	else
		print("<td align=center bgcolor=white>0</td>");
	print("<td align=center bgcolor=white>" . mksize($row[uploaded]) . "</td>");
	print("<td align=center bgcolor=white>" . mksize($row[downloaded]) . "</td>");
	$modcommnent = $row['modcomment'];
	print("<td width=250 bgcolor=white>" . substr($modcommnent,0,115) . "....." . "</td>");
	print("</tr>");
}

print("</td></tr></table>");
print("<br></td></tr></table>");
print("</td></table><br>");
site_footer();
?>