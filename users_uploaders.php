<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de moderator en hoger.");

$res = mysqli_query($con_link, "SELECT * FROM users WHERE class>2 ORDER BY class DESC") or sqlerr(__FILE__, __LINE__);	

site_header();
page_start();
tabel_top("Staff overzicht", "center");
tabel_start();

print "<table class=outer border=1 cellspacing=0 cellpadding=5>";
print "<tr>";
print "<td class=colheadsite>Gebruiker</td>";
print "<td class=colheadsite>Functie</td>";
print "<td class=colheadsite>Laatst&nbsp;gezien</td>";
print "<td class=colheadsite>Uploads</td>";
print "<td class=colheadsite>Laatste&nbsp;upload</td>";
print "</tr>";

while ($row = mysqli_fetch_assoc($res))
	{
	print "<tr>";
	if ($row['class'] == 8 || $row['class'] == 6 || $row['class'] == 4)
		$color = "#CCCCCC";
	else
		$color = "#FFFFFF";
	$torrents = get_row_count("torrents", "WHERE owner=$row[id]");
	print "<td bgcolor=$color><a class=altlink href=userdetails.php?id=$row[id]>" .$row['username'] . "</a></td>";
	print "<td bgcolor=$color>" . get_user_class_name($row["class"]) . "</td>";
	print "<td bgcolor=$color>"  . get_elapsed_time(sql_timestamp_to_unix_timestamp($row["last_access"])) . " geleden</td>";
	print "<td align=center bgcolor=$color>" . $torrents . "</td>";
	if ($torrents > 0)
		{
		$res2 = mysqli_query($con_link, "SELECT * FROM torrents WHERE owner=$row[id] ORDER BY added DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);
		$row2 = mysqli_fetch_array($res2);
		print "<td bgcolor=$color>" . convertdatum($row2['added'], "No") . "</td>";
		}
	else
		print "<td bgcolor=$color> </td>";
	print "</tr>";
	}
	
print "</td></tr></table>";

tabel_einde();
page_einde();
site_footer();
?>