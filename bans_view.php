<?php
ob_start("ob_gzhandler");
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

if (get_user_class() < UC_OWNER)
	new_error_message("Foutmelding", "U heeft geen rechten om deze pagina te bekijken.");

$del = mysqli_query($con_link, "SELECT * FROM bans ORDER BY first DESC") or sqlerr(__FILE__, __LINE__);
while ($dels = mysqli_fetch_assoc($del))
	{
	if (@$temp == long2ip($dels['first']))
		{
		mysqli_query($con_link, "DELETE FROM bans WHERE id=$tempid") or sqlerr(__FILE__, __LINE__);
		}
	$temp = long2ip($dels['first']);
	$tempid = $dels['id'];
	}

		
$res = mysqli_query($con_link, "SELECT * FROM bans ORDER BY added DESC") or sqlerr(__FILE__, __LINE__);

site_header("Ip-bans");
//site_menu(false);
print "<br>";
page_start(99);tabel_start();
tabel_top("Gebruikers nog aanwezig met IP-Ban", "center");
print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded><br>");
print("<table align=center class=sitetable border=1 width=99% cellspacing=0 cellpadding=5>");

print "<tr>";
print "<td class=colheadsite>Ip-nummer</td>";
print "<td class=colheadsite>Commentaar</td>";
print "<td class=colheadsite>Datum</td>";
print "<td class=colheadsite>Door</td>";
print "<td class=colheadsite>Data</td>";
print "<td class=colheadsite>Gebruiker</td>";
print "</tr>";

while ($arr = mysqli_fetch_assoc($res))
	{
	$ip = sqlesc(long2ip($arr['first']));
	$count = get_row_count("users","WHERE ip=$ip");
	if ($count > 0)
	{

	print "<tr>";
	if ($temp == long2ip($arr['first']))
		print "<td bgcolor=red>".long2ip($arr['first'])."---".$tempid."</td>";
	else
		print "<td bgcolor=white>".long2ip($arr['first'])."<br>".long2ip($arr['last'])."</td>";
	print "<td bgcolor=white>".$arr['comment']."</td>";
	print "<td bgcolor=white>".convertdatum($arr[added], "no")."</td>";
	print "<td bgcolor=white>".get_username($arr['addedby'])."</td>";
	$ip = sqlesc(long2ip($arr['first']));
	$count = get_row_count("users","WHERE ip=$ip");
	if ($count > 0)
		{
			$def = mysqli_query($con_link, "SELECT * FROM users WHERE ip=$ip") or sqlerr(__FILE__, __LINE__);
			$defs2 = mysqli_fetch_array($def);
			print "<td bgcolor=white> Ontvangen: ".mksize($defs2['downloaded'])."<br>Verzonden: ".mksize($defs2['uploaded'])."</td>";
			$def = mysqli_query($con_link, "SELECT * FROM users WHERE ip=$ip") or sqlerr(__FILE__, __LINE__);
			print "<td bgcolor=white>";
			while ($defs = mysqli_fetch_assoc($def))
				{
				print "<a class=altlink href=userdetails.php?id=" . $defs['id'] . ">" . get_usernamesitesmal($defs['id']) . " " . get_ratio($defs['id']) . "</a> - " . $defs['credits'];
				print "<form method=post action=user_delete_noban.php>\n";
				print "<input type=hidden name=userid value=" . $defs['id'] . ">";
				print "<input type=hidden name=action value=verwijderen>";
				print "<input type=submit style='height: 22px;width: 150px;color:red;font-weight:bold' value='VERWIJDER GEBRUIKER'>";
				print "</form>";
				}
			print "</td>";
		}
	else
		print "<td bgcolor=white> </td>";
	print "</tr>";
	$temp = long2ip($arr['first']);
	}
	}

tabel_einde();
page_einde();
site_footer(false);
?>