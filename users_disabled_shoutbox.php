<?php
ob_start("ob_gzhandler");
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	new_error_message("Foutmelding", "U heeft geen rechten om deze pagina te bekijken.");
		
$res = mysqli_query($con_link, "SELECT * FROM users WHERE shoutbox='no'") or sqlerr(__FILE__, __LINE__);

site_header("Accounts");
print "<br>";
page_start(98);
tabel_top("Gebruikers waarvan shoutbox van uit is uitgeschakeld", "center");
print("<table background=pic/site/table_background.gif width=100% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded><br>");
print("<table align=center class=sitetable border=1 width=98% cellspacing=0 cellpadding=5>");

print "<tr>";
print "<td class=colheadsite>Ip-nummer</td>";
print "<td class=colheadsite>Mod commentaar</td>";
print "<td class=colheadsite>Datum</td>";
print "<td class=colheadsite>Data</td>";
print "<td class=colheadsite width=180>Gebruiker</td>";
print "</tr>";

while ($row = @mysqli_fetch_assoc(@$res))
	{
	print "<tr>";
	print "<td bgcolor=white>".$row['ip']."</td>";
	print "<td bgcolor=white width=400><textarea name=plans cols=100 rows=6>".$row['modcomment']."</textarea></td>";
	print "<td bgcolor=white>".convertdatum($row['added'], "no")."</td>";
	$ip = sqlesc(long2ip(@$arr['first']));
	$count = get_row_count("users","WHERE ip=$ip");

	if (($row['uploaded']-$row['downloaded']) > 0)
		$kleur = "<font color=green>";
	else
		$kleur = "<font color=red>";
	print "<td bgcolor=white align=center> Ontvangen: <b>".mksize($row['downloaded'])."</b><br><br>Verzonden: <b>".mksize($row['uploaded'])."<br><br></b>Verschil: <b>".$kleur.mksizegb($row['uploaded']-$row['downloaded'])."</b></td>";
	print "<td bgcolor=white align=center>";
	print "<a class=altlink_red href=userdetails.php?id=" . $row['id'] . ">" . get_usernamesitesmal($row['id']) . " " . get_ratio($row['id']) . "</a><br>";
	print "<font color=blue size=2><b>" . get_user_class_name($row['class']) . "</b></font><br>";
	print "<font color=blue size=2><b>Krediet: " . $row['credits'] . "</b></font><br>";
	print "</td>";
	print "</tr>";
	$temp = long2ip(@$arr['first']);
	}

tabel_einde();
page_einde();
site_footer();
?>
