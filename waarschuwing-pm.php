<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();
if (get_user_class() < UC_GOD)
site_error_message("Foutmelding", "Deze pagina is alleen voor de moderator en hoger.");
site_header("Verstuurde waarschuwingen");tabel_start();
$res2 = mysqli_query($con_link, "SELECT COUNT(*) FROM warn_pm_torrent");
$row = mysqli_fetch_array($res2);
$count = $row[0];
$perpage = 100;
list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $_SERVER["PHP_SELF"] ."?" );
echo $pagertop;
$res =  mysqli_query($con_link, "SELECT * FROM warn_pm_torrent ORDER BY added DESC $limit") or sqlerr(__FILE__, __LINE__);
$aantal = get_row_count("warn_pm_torrent","");
print("<table width=95% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
print("<br>");
tabel_top("Waarschuwingen verstuurt","center");
print("<table width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td class=embedded align=center><center><br>");
print @$site_pager;
print "<br>";
print("<table width=95% class=outer border=1 cellspacing=0 cellpadding=5>");
print("<tr>");
print "<td class=colheadsite>Gebruiker</td>";
print "<td class=colheadsite>Torrent</td>";
print "<td class=colheadsite>verstuurt</td>";
print "<td class=colheadsite>door wie</td>";
while ($row = mysqli_fetch_assoc($res)) {
$userid = $row['receiver'];
$res3 =  mysqli_query($con_link, "SELECT * FROM users WHERE id='" . $userid . "'") or sqlerr(__FILE__, __LINE__);
$row3 = mysqli_fetch_array($res3);
print("<tr><td bgcolor=blue>");
print "<a href=userdetails.php?id=" .$row[receiver]. ">" . htmlspecialchars($row3[username] . "");
$torrentid = $row['torrent'];
$res2 =  mysqli_query($con_link, "SELECT * FROM torrents WHERE id='" . $torrentid . "'") or sqlerr(__FILE__, __LINE__);
$row2 = mysqli_fetch_array($res2);
print("</td><td bgcolor=blue>");
print "<a href=details.php?id=" .$row[torrent]. ">" . htmlspecialchars($row2[name] . "");
print("</td><td bgcolor=blue>");
print("" . $row['added'] . "");
print("</td><td bgcolor=blue>");
$userid2 = $row['sender'];
$res4 =  mysqli_query($con_link, "SELECT * FROM users WHERE id='" . $userid2 . "'") or sqlerr(__FILE__, __LINE__);
$row4 = mysqli_fetch_array($res4);
print "<a href=userdetails.php?id=" .$row[receiver]. ">" . htmlspecialchars($row4[username] . "");
print("</td>");
print("</tr>");
}
print("</td></tr></table>");
print($pagerbottom);
print("<br></td></tr></table>");
print("</td></table><br>");tabel_einde();
site_footer();
?>
