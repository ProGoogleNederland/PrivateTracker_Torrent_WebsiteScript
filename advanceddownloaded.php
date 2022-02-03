<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();
if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "Deze optie is alleen voor de Moderators en hoger.");

site_header();

function bark($msg) {
	genbark($msg, "Foutmelding!");
}

$letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

for ($i = 0; $i < strlen($letters); ++$i){
	$letter = substr($letters,$i,1);
	@$mod_letter .= "<font size=3><a class=altlink_lblue href='downloaded.php?id=".@$id."&letter=".$letter."'>" . $letter . "</a> ";
}

$page = @$_GET['page'];
$perpage = 20;

$res = mysqli_query($con_link, "SELECT COUNT(id) FROM torrents") or sqlerr();
$arr2 = mysqli_fetch_row($res);
$pages = floor($arr2[0] / $perpage);
if ($pages * $perpage < $arr2[0])
  ++$pages;

if ($page < 1)
  $page = 1;
else
  if ($page > $pages)
    $page = $pages;

for ($i = 1; $i <= $pages; ++$i)
  if ($i == $page)
    @$pagemenu .= "<b>$i</b>\n";
  else
    @$pagemenu .= "<a href=?page=$i><b>$i</b></a>\n";

if ($page == 1)
  @$browsemenu .= "<b>&lt;&lt; Vorige</b>";
else
  @$browsemenu .= "<a href=?page=" . ($page - 1) . "><b>&lt;&lt; Vorige</b></a>";

$browsemenu .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

if ($page == $pages)
  $browsemenu .= "<b>Volgende &gt;&gt;</b>";
else
  $browsemenu .= "<a href=?page=" . ($page + 1) . "><b>Volgende &gt;&gt;</b></a>";

print("<p>$browsemenu<br>$page</p>");

$offset = ($page * $perpage) - $perpage;
	
$resultaat = mysqli_query($con_link, "SELECT id FROM torrents WHERE freedlfsu ='no' ORDER BY id desc LIMIT $offset,$perpage");
while ($arr=@mysqli_fetch_array($resultaat)){
$idt = 0 + $arr['id'];
$id = 0 + $arr['id'];
$torrent = $arr['id'];
$letter = @$_GET['letter'];
$aantal = get_row_count("downloaded", "WHERE username LIKE '".$letter."%' AND torrent=$idt");
$res2 = mysqli_query($con_link, "SELECT id, name FROM torrents WHERE id = $idt AND freedlfsu ='no'") or sqlerr(__FILE__, __LINE__);
$row2 = mysqli_fetch_array($res2);
$tnaam = $row2['name'];
$torrentid = $row2['id'];

	$res = mysqli_query($con_link, "SELECT * FROM downloaded WHERE username LIKE '".$letter."%' AND torrent=$id ORDER BY added DESC") or sqlerr(__FILE__, __LINE__);
	
print("<table width=95% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
print("<br>");
tabel_top("Download gegevens van ". $tnaam);
print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td class=embedded align=center><div align=center><br>");

print("<table class=outer border=1 cellspacing=0 cellpadding=5>");
if (get_user_class() >= UC_MODERATOR) {
print("<center><font color=red size=3><b>LET OP: Na 2200 uur hoeft er niet gecheckt te worden tot 9 uur smorgens omdat wij ervanuit gaan dat er users zijn die hun pc NIET aan hebben snachts.</b></center></font><br>");
print("<center><font color=white size=3>LET OP: U kunt nu de gebruiker een bericht sturen door op de knop <b>'stuur pm'</b> te drukken een verzoek tot het gaan delen, dit bericht komt uit jou naam. Indien deze gebruiker reeds gewaarschuwd is dan staat er de naam van diegene die dat heeft gedaan, met de knop erachter <b>nogmaals'</b> om de betreffende gebruiker nogmaals een bericht te sturen uit jou naam. Alleen gebruikers die niet aan het delen zijn en onder de torrentratio 1 zitten kunnen een bericht worden gezonden.</font></center><br>");
print("<center><b><font color=white size=2>Tevens kunt u nu een bericht sturen naar een gebruiker voor het stoppen met seeden op deze torrent.</font></b></center><br>");
}
print("<tr>");
print("<td class=colheadsite>");
print "<b>Gedownload door</font>";
print "</td>";
print("<td class=colheadsite>");
print "<b>Ratio</font>";
print "</td>";
print("<td class=colheadsite>");
print "<b>Datum en tijd</font>";
print "</td>";
print("<td class=colheadsite>");
print "<b>Ratio torrent</font>";
print "</td>";
print("<td class=colheadsite>");
print "<b>Ontvangen</font>";
print "</td>";
print("<td class=colheadsite>");
print "<b>Verzonden</font>";
print "</td>";
print("<td class=colheadsite>");
print "<b>Delen</font>";
print "</td>";
if (get_user_class() >= UC_MODERATOR) {
print("<td class=colheadsite>");
print "<b>Hit en run";
print "</td>";
print("<td class=colheadsite>");
print "<b>Overseeden";
print "</td>";
}
if (get_user_class() >= UC_OWNER)
	{
	print("<td align=center class=colheadsite>");
	print "<b>Correctie";
	print "</td>";
	}

print "</tr>";
		
	
	while ($row = mysqli_fetch_assoc($res)) {


	$userid = $row['user'];
	$torrentid = $idt;
	$ressite =  mysqli_query($con_link, "SELECT * FROM downup WHERE user='" . $userid . "' AND torrent='" . $torrentid . "'") or sqlerr(__FILE__, __LINE__);
	$rowsite = mysqli_fetch_array($ressite);
    if ($rowsite["downloaded"] > 0)
    {
      	$ratio = number_format($rowsite["uploaded"] / $rowsite["downloaded"], 2);
      	$ratiosite = number_format($rowsite["uploaded"] / $rowsite["downloaded"], 2);
      	$ratiosite = "<font color=" . get_ratio_color($ratiosite) . ">$ratiosite</font>";
		if ($rowsite["uploaded"] / $rowsite["downloaded"] > 20) $ratiosite = "<center><img border=0 src=pic/oneindig.gif></center>";
    }
    else
      if ($rowsite["uploaded"] > 0)
        $ratiorhc = "<center><img border=0 src=pic/oneindig.gif></center>";
      else
        $ratiosite = "---";

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
print("<td bgcolor=black>");
print "<a href=userdetails.php?id=" . $row["user"] . "><b>" . get_usernamesitesmal($row['user']) . "</b></a>";
print "</td>";
print("<td bgcolor=black align=center>");
$ratiouser = get_userratio($row['user']);
	print $ratiouser;
print "</td>";
print("<td bgcolor=black>");
print convertdatum($row['added']);
print "</td>";
print "<td bgcolor=black align=center>";
print $ratiosite;
print "</td>";
print "<td bgcolor=black align=right>";
print $downloaded;
print "</td>";
print "<td bgcolor=black align=right>";
print $uploaded;
print "</td>";
print "<td bgcolor=black align=center>";

$delen = number_format(get_row_count("peers", "WHERE userid=$row[user] AND torrent=$torrentid AND seeder='yes'"));
if ($delen > 0)
	print "<font color=green>JA</font>";
else
	print "<font color=red>NEE</font>";
print "</td>";
if (get_user_class() >= UC_MODERATOR)
	{
	$sender="";
	if (get_row_count("warn_pm_torrent", "WHERE receiver=$row[user] AND torrent=$torrentid") > 0) 
		{
		$def =  mysqli_query($con_link, "SELECT sender, added FROM warn_pm_torrent WHERE receiver=$row[user] AND torrent=$torrentid") or sqlerr(__FILE__, __LINE__);
		while ($defs = mysqli_fetch_assoc($def))
			{
			if ($defs['sender'] == 0)
				$sender .= "<b><font color=red>Het systeem op " . convertdatum($defs['added'], "Nee") . "</font></b><br>";
			else
				$sender .= "<b><font color=red>" . get_username($defs['sender']) . " op " . convertdatum($defs['added'], "Nee") . "</font></b><br>";
			}
		}
		if ($delen < 1)
			{
			if ($ratio < 1)
				{
				print "<td bgcolor=black align=center>";
				if ($sender)
					print $sender . "<a class=altlink href=message_warning.php?userid=" . $row['user'] . "&amp;warnid=1&amp;torrentid=$torrentid&amp;ratio=$ratio&amp;referer=advanceddownloaded.php?id=$torrentid&pagina=$page>nogmaals</a>";
				else
					print "<a class=altlink href=message_warning.php?userid=" . $row['user'] . "&amp;warnid=1&amp;torrentid=$torrentid&amp;ratio=$ratio&amp;referer=advanceddownloaded.php?id=$torrentid&pagina=$page>stuur&nbsp;pm</a>";
				print "</td>";
				}
			else 
				print "<td bgcolor=black align=center> </td>";
			}
		else 
			print "<td bgcolor=black align=center> </td>";
	}
	
if (get_user_class() >= UC_MODERATOR)
	{
		$sender="";
	if (get_row_count("warn_pm_seeding", "WHERE receiver=$row[user] AND torrent=$torrentid") > 0) 
		{
		$def =  mysqli_query($con_link, "SELECT sender, added FROM warn_pm_seeding WHERE receiver=$row[user] AND torrent=$torrentid") or sqlerr(__FILE__, __LINE__);
		while ($defs = mysqli_fetch_assoc($def))
			{
			if ($defs['sender'] == 0)
				$sender .= "<b><font color=red>Het systeem op " . convertdatum($defs['added'], "Nee") . "</font></b><br>";
			else
				$sender .= "<b><font color=red>" . get_username($defs['sender']) . " op " . convertdatum($defs['added'], "Nee") . "</font></b><br>";
			}
		}
		if ($delen > 0)
			{
			if ($ratio > 1.5)
				{
				print "<td bgcolor=black align=center>";
				if ($sender)
					print $sender . "<a class=altlink href=message_seeding.php?userid=" . $row['user'] . "&amp;warnid=1&amp;torrentid=$torrentid&amp;ratio=$ratio&amp;referer=advanceddownloaded.php?id=$torrentid&pagina=$page>nogmaals</a>";
				else
					print "<a class=altlink href=message_seeding.php?userid=" . $row['user'] . "&amp;warnid=1&amp;torrentid=$torrentid&amp;ratio=$ratio&amp;referer=advanceddownloaded.php?id=$torrentid&pagina=$page>stuur pm</a>";
				print "</td>";
				}
			else 
				print "<td bgcolor=black align=center> </td>";
			}
		else 
			print "<td bgcolor=black align=center> </td>";
	}
if (get_user_class() >= UC_OWNER)
	{
	print("<td bgcolor=black>");
	print "<table class=bottom><tr><td class=embedded>";
	print "<form method=post action=user_downup_gb.php>";
	print "<input type=hidden name=action value=correctie>";
	print "<input type=hidden name=torrentid value=".$torrentid.">";
	print "<input type=hidden name=userid value=".$row['user'].">";
	print "<input type=hidden name=returnto value=downloaded.php?id=".$torrentid.">";
	print "<input type=submit style='height: 20px;width: 60px' value='Pas aan'>";
	print "</form>";
	print "</td></tr></table>";
	print "</td>";
	}	
	
print("</tr>");
}

print("</td></tr></table>");
print("<br></td></tr></table>");
print("</td></table><br>");
}
print("<p>$browsemenu<br>$page</p>");
site_footer();

?>
