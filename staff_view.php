<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de moderator en hoger.");

mysqli_query($con_link, "UPDATE users SET warneduntil = '0000-00-00 00:00:00', warnedby = 0 WHERE warned = 'no' AND warneduntil < FROM_UNIXTIME(".time().") AND warneduntil != '0000-00-00 00:00:00' ORDER By warneduntil DESC") or sqlerr(__FILE__, __LINE__);

site_header("Staff overzicht");

$res = mysqli_query($con_link, "SELECT * FROM users WHERE class > 3 ORDER BY class DESC") or sqlerr(__FILE__, __LINE__);	

tabel_start();
tabel_top("Staff overzicht");


print "<table width=100% border=0 cellspacing=0 cellpadding=0>";
print "<tr>";
print "<td class=embedded align=center><center><br>";
print "<br><font size=4 color=white><b>Totaal ".get_row_count("users", "WHERE warned='yes'")." gewaarschuwde gebruikers.<br><br>";
print "<table class=outer border=1 cellspacing=0 cellpadding=5>";
print "<tr>";
print "<td class=colheadsite>Gebruiker</td>";
print "<td class=colheadsite>Functie</td>";
print "<td class=colheadsite>Laatst&nbsp;gezien</td>";
print "<td class=colheadsite>Comment</td>";
print "<td class=colheadsite>Uploads</td>";
print "<td class=colheadsite>Waarschuwing</td>";
print "<td class=colheadsite>Kliks</td>";
print "</tr>";

while ($row = mysqli_fetch_assoc($res))
	{
	print("<tr>");
	if ($row['class'] == 8 || $row['class'] == 6 || $row['class'] == 4)
		$achtergrond = "#FFFFFF";
	else
		$achtergrond = "#EEEEEE";
	print "<td bgcolor=".$achtergrond."><a class=altlink_red href=userdetails.php?id=$row[id]>" .$row['username'] . "</a></td>";
	print "<td bgcolor=".$achtergrond.">" . get_user_class_name($row["class"]) . "</td>";
	print "<td bgcolor=".$achtergrond.">"  . get_elapsed_time(sql_timestamp_to_unix_timestamp($row["last_access"])) . " geleden</td>";
	print "<td align=center bgcolor=".$achtergrond."><a class=altlink_red href=userhistory.php?action=viewcomments&id=$row[id]>" . get_row_count("comments", "WHERE user=$row[id]") . "</a></td>";
	print "<td align=center bgcolor=".$achtergrond.">" . get_row_count("torrents", "WHERE owner=$row[id]") . "</td>";
	if (get_row_count("users", "WHERE warnedby=$row[id]") > 0)
		print "<td align=center bgcolor=".$achtergrond."><a class=altlink_red href=warn_view.php?id=$row[id]>" . get_row_count("users", "WHERE warnedby=$row[id]") . "</a></td>";
	else
		print "<td align=center bgcolor=".$achtergrond.">0</td>";
	print "<td bgcolor=".$achtergrond." align=center><a class=altlink_blue href='kliks_overzicht.php?user_id=".$row['id']."'>" . $row["kliks"] . "</a></td>";
	print "</tr>";
	}
tabel_einde();
page_einde();
site_footer();
?>