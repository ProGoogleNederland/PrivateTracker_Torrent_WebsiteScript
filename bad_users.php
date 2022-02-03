<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_SYSOP)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de beheerders.");

site_header("Slechte gebruikers");

$days = 10;
$dt = sqlesc(get_date_time(gmtime() - ($days * 86400)));
$def = mysqli_query($con_link, "SELECT * FROM users WHERE downloaded>1024*1024*1024 AND enabled='yes' AND last_access < $dt AND last_access > 0") or sqlerr(__FILE__, __LINE__);	

print("<table width=95% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
print("<br>");
tabel_top("Slechte gebruikers en $days dagen niet online geweest");
print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td class=embedded><div align=center><br>");
print("<table width=90% class=outer border=1 cellspacing=0 cellpadding=5>");
print("<tr><td class=colheadsite>");
print("Gebruiker");
print("</td><td class=colheadsite>");
print("Ontvangen");
print("</td><td class=colheadsite>");
print("Verzonden");
print("</td><td class=colheadsite>");
print("Laatst gezien");
print("</td><td class=colheadsite>");
print("Laatst gezien");
	if (get_user_class() >= UC_GOD)
		{
		print("</td><td align=right class=colheadsite>");
		print("Verwijderen gebruiker");
		}
print("</td>");
print("</tr>");

while ($defs = mysqli_fetch_assoc($def))
	{
	$ratio = get_ratio($defs[id]);
	if ($ratio < 0.7)
		{
		print("<tr><td bgcolor=white>");
		print("<a href=userdetails.php?id=$defs[id]>" .get_usernamesitesmal($defs[id]) . "&nbsp;" . get_userratio($defs[id]) . "</a>");
		print("</td><td bgcolor=white align=right>");
		print(mksize($defs['downloaded']));
		print("</td><td bgcolor=white align=right>");
		print(mksize($defs['uploaded']));
		print("</td><td bgcolor=white>");
		print convertdatum($defs['last_access']);
		print("</td><td bgcolor=white>");
		print get_elapsed_time(sql_timestamp_to_unix_timestamp($defs["last_access"])) . " geleden";
		if (get_user_class() >= UC_GOD)
			{
			print("</td><td align=right bgcolor=white>");
			print "<form method=post action=user_delete.php>\n";
			print "<input type=hidden name=userid value=" . $defs['id'] . ">";
			print "<input type=hidden name=returnto value=bad_users.php>";
			print "<input type=hidden name=sure value=1>";
			print "<input type=hidden name=action value=verwijderen>";
			print "<input type=submit style='height: 22px;width: 110px;background: red;color: yellow' value='Verwijder gebruiker'>";
			print "</form>";
			}
		print("</td>");
		print("</tr>");
		}
	}
print("</td></tr></table>");
print("<br></td></tr></table>");
print("</td></table><br>");

site_footer();

?>