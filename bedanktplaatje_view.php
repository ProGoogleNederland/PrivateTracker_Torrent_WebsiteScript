<?
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();
if (get_user_class() < UC_ADMINISTRATOR)
site_error_message("Foutmelding", "Deze pagina is alleen voor de beheerder en hoger.");
site_header("Bedanktplaatjes overzicht");
$bedankt_dir = $BASEURL."/bedankjes";
$start = 0 + @$_GET['start'];
$totaal = get_row_count("users","WHERE bedanktplaat LIKE '" . $bedankt_dir . "%'");
$per_pagina = 50;
$paginas = floor($totaal / $per_pagina);
if ($paginas * $per_pagina < $totaal)
++$paginas;
$site_pager = "<font color=blue size=3>";
for ($i = 0; $i < $paginas; ++$i)
{
$begin = $i*$per_pagina;
if ($i > 0) $site_pager .= "&nbsp;-&nbsp;";
$pagina = $i + 1;
if ($start/$per_pagina == $i)
$site_pager .= "" . $pagina . "";
else
$site_pager .= "<a href=bedanktplaatje_view.php?start=" . $begin . "><font color=blue size=3><b>" . $pagina . "</b></font></a>";
}
$site_pager .= "</font>";
print $site_pager;
$fff = substr(@$avatar_url,0,20);
$userid = $CURUSER['id'];
$res = mysqli_query($con_link, "SELECT * FROM users WHERE bedanktplaat LIKE '" . @$bedankt_url . "%' ORDER BY username LIMIT $start,$per_pagina") or sqlerr(__FILE__, __LINE__);	
print("<table width=60% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
print("<br>");
tabel_top("Overzicht gebruikte bedanktplaatjes die geplaatst zijn op server");
print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td class=embedded><div align=center><br>");
print("<table class=outer border=1 cellspacing=0 cellpadding=5>");
print("<tr><td class=colheadsite>");
print("Gebruiker");
print("</td><td class=colheadsite>");
print("Bedanktplaatje");
print("</td>");
print("</tr>");
$color = "#CCCCCC";
while ($row = mysqli_fetch_assoc($res)) {
print("<tr><td bgcolor=white>");
print("<a href=userdetails.php?id=" . $row['id']. ">" . get_usernamesitesmal($row['id']) . "</a>");
print("</td><td bgcolor=white>");
if($row["bedanktplaat"]!=""){
	$img_bedanktplaat = $row["bedanktplaat"];
}else{
	$img_bedanktplaat = 'https://torrentmedia.org/pic/default_bedankje.gif';
}
print('<img width="50" src="'.$img_bedanktplaat.'">');
print("</td>");
print("</tr>");
}
print("</td></tr></table>");
print("<br></td></tr></table>");
print("</td></table><br>");
print $site_pager;
print "<br><br>";
site_footer();
?>