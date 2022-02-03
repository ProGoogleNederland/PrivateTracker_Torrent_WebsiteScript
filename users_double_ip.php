<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();

loggedinorreturn();

site_header();

if (get_user_class() < UC_SYSOP)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de moderator en hoger.");

$res = mysqli_query($con_link, "SELECT ip, username FROM users ORDER BY ip") or sqlerr(__FILE__, __LINE__);	

print("<table width=95% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
print("<br>");
tabel_top("Gebruikers met hetzelfde Ip-Nummer");
print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td class=embedded><div align=center><br>");
print("<table width=95% class=outer border=1 cellspacing=0 cellpadding=5>");
print("<tr><td class=colheadsite>");
print("Gebruiker");
print("</td><td class=colheadsite>");
print("IP-nummer");
print("</td><td class=colheadsite>");
print("Aangemeld");
print("</td><td class=colheadsite>");
print("Laatst&nbsp;gezien");
print("</td><td class=colheadsite>");
print("Ontvangen");
print("</td><td class=colheadsite>");
print("Verzonden");
print("</td><td class=colheadsite>");
print("Ratio");
print("</td><td class=colheadsite>");
print("Opties");
print("</td>");
print("</tr>");

$color = "#CCCCCC";

while ($row = mysqli_fetch_assoc($res)) {
	$ip = $row['ip'];

	if (@$oldip <> $ip) $teller = 0;

	if (@$oldip == $ip && $ip && $teller == 0)
		{
		if ($color == "#FFFFFF")
			$color = "#CCCCCC";
		else 
			$color = "#FFFFFF";
		$def = mysqli_query($con_link, "SELECT * FROM users WHERE ip='$ip'") or sqlerr(__FILE__, __LINE__);	
		while ($defs = mysqli_fetch_assoc($def))
			{
			$teller += 1;
			print("<tr><td bgcolor=$color>");
			if ($defs['enabled'] == "yes")
				print("<a href=userdetails.php?id=" . $defs['id']. ">" . get_usernamesitesmal($defs['id']) . "</a>");
			else
				print("<a href=userdetails.php?id=" . $defs['id']. "><font color=red><b>" . get_usernamesitesmal($defs['id']) . "</a></b></font>");
			print("</td><td bgcolor=$color>");
			$nip = ip2long($defs['ip']);
			$bans = get_row_count("bans", "WHERE first='$nip'");
			if ($bans > 0)
				print("<font color=red><b>" . $defs['ip'] . "</b></font>");
			else
				print($defs['ip']);
			print("</td><td bgcolor=$color>");
			print(convertdatum($defs['added']));
			print("</td><td bgcolor=$color>");
			print(convertdatum($defs['last_access']));
			print("</td><td bgcolor=$color>");
			print(mksize($defs['downloaded']));
			print("</td><td bgcolor=$color>");
			print(mksize($defs['uploaded']));
			print("</td><td bgcolor=$color>");
			print(get_userratio($defs['id']));
			print("</td><td bgcolor=$color>");
			$id = $defs['id'];
			print "<a href=\"#naar$id\"> </a>";
			print ("<form method=post action=users_double_ip_remove.php>\n");
			print ("<input type=hidden name='referer' value='users_double_ip.php#naar" . $id . "'>");
			print ("<input type=hidden name='id' value='$id'>");
			print("<input name=enabled value=1 type=checkbox>Uitschakelen<br>");
			print("<input name=ban value=1 type=checkbox>IP-Ban");
			print ("&nbsp;&nbsp;&nbsp;<input type=submit value='OK'>\n");
			print ("</form>\n");
			print("</td>");
			print("</tr>");
			}
			if ($teller > 0)
				{
			print("</td>");
			print("</tr>");
				}
			
			$chkip = $ip;
		}
	$oldip = $ip;
	
}
print("</td></tr></table>");

print("<br></td></tr></table>");
print("</td></table><br>");

site_footer();

?>