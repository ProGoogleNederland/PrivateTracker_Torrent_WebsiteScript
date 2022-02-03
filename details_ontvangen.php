<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

$torrent_id = (int)@$_GET['torrent_id'];
if (!$torrent_id)
	new_error_message("Foutmelding", "Geen torrent gevonden.","white",3000);

$res = mysqli_query($con_link, "SELECT * FROM torrents WHERE id = $torrent_id") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);
if (!$row)
	new_error_message("Foutmelding", "Deze torrent niet gevonden.","white",3000);

$torrent_name = $row['name'];

site_header("Bedankjes");
page_start();
tabel_top("Overzicht bedankjes","center");
tabel_start(70);
print "<font size=2 color=white><a class=altlink_white href='details.php?id=".$torrent_id."'>Terug naar: ".htmlspecialchars($row['name'])."</a><br><br>";

print "<table class=outer border=1 cellspacing=0 cellpadding=5>";
print "<tr>";
print "<td class=colheadsite>";
print "<b>Gedownload door</font>";
print "</td>";
print "<td class=colheadsite>";
print "<b>Ratio</font>";
print "</td>";
print "<td class=colheadsite>";
print "<b>Datum en tijd</font>";
print "</td>";
print "<td class=colheadsite>";
print "<b>Ratio torrent</font>";
print "</td>";
print "<td class=colheadsite>";
print "<b>Ontvangen</font>";
print "</td>";
print "<td class=colheadsite>";
print "<b>Verzonden</font>";
print "</td>";
print "<td class=colheadsite>";
print "<b>Delen</font>";
print "</td>";
print "</tr>";
	
$res = mysqli_query($con_link, "SELECT * FROM downloaded WHERE torrent=$torrent_id ORDER BY added DESC") or sqlerr();
while ($row = mysqli_fetch_assoc($res))
	{

	$userid = $row['user'];
	$ressite =  mysqli_query($con_link, "SELECT * FROM downup WHERE user='" . $userid . "' AND torrent='" . $torrent_id . "'") or sqlerr(__FILE__, __LINE__);
	$rowsite = mysqli_fetch_array($ressite);
	if ($rowsite["downloaded"] > 0)
		{
		$ratio = number_format($rowsite["uploaded"] / $rowsite["downloaded"], 2);
		$ratiosite = number_format($rowsite["uploaded"] / $rowsite["downloaded"], 2);
		$ratiosite = "<font color=" . get_ratio_color($ratiosite) . ">$ratiosite</font>";
		if ($rowsite["uploaded"] / $rowsite["downloaded"] > 20) $ratiosite = "<center><img border=0 src=pic/oneindig.gif></center>";
		}
	else
		{
	  if ($rowsite["uploaded"] > 0)
		$ratiorhc = "<center><img border=0 src=pic/oneindig.gif></center>";
	  else
		$ratiosite = "---";
		}

	if ($rowsite["downloaded"] == 0) $ratiosite = "<center><img border=0 src=pic/oneindig.gif></center>";
	
	if ($rowsite)
		$uploaded = str_replace(" ", "&nbsp;", mksize($rowsite["uploaded"]));
	else
		$uploaded = "onbekend";
	if ($rowsite)
		$downloaded = str_replace(" ", "&nbsp;", mksize($rowsite["downloaded"]));
	else
		$downloaded = "onbekend";
	
	print("<tr>");
	print("<td bgcolor=white>");
	print "<a class=altlink_blue href=userdetails.php?id=" . $row["user"] . "><b>" . get_usernamesitesmal($row['user']) . "</b></a>";
	print "</td>";
	print("<td bgcolor=white align=center>");
	$ratiouser = get_userratio($row['user']);
	print $ratiouser;
	print "</td>";
	print("<td bgcolor=white>");
	print convertdatum($row['added']);
	print "</td>";
	print "<td bgcolor=white align=center>";
	print $ratiosite;
	print "</td>";
	print "<td bgcolor=white align=right>";
	print $downloaded;
	print "</td>";
	print "<td bgcolor=white align=right>";
	print $uploaded;
	print "</td>";
	print "<td bgcolor=white align=center>";

	$delen = number_format(get_row_count("peers", "WHERE userid=$row[user] AND torrent=$torrent_id AND seeder='yes'"));
	if ($delen > 0)
		print "<font color=green>JA</font>";
	else
		print "<font color=red>NEE</font>";
	print "</td>";
		
	print("</tr>");
	}

print "</td></tr></table>";

print "</table>";

print "<center><br><font size=2 color=white><a class=altlink_white href='details.php?id=".$torrent_id."'>Terug naar: ".htmlspecialchars($torrent_name)."</a><br><br>";
tabel_einde();
page_einde();
site_footer();
?>