<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_UPLOADER)
	site_error_message("Foutmelding", "U ben niet bevoegd om deze pagina te bekijken.");

$aantal = get_row_count("torrents","WHERE owner = " . $CURUSER['id'] . "");

if ($aantal == 0)
	site_error_message("Foutmelding", "U heeft geen torrent geplaatst op ".$SITE_NAME." die nog aktief is.");

site_header("Torrents");
page_start(99);
if ($aantal == 1)
	tabel_top("U heeft 1 torrent geplaatst op ".$SITE_NAME." die nog aktief is.","center");
else
	tabel_top("U heeft ".$aantal." torrent geplaatst op ".$SITE_NAME." die nog aktief zijn.","center");

tabel_start();

print "<table width=100% class=main border=1 cellspacing=0 cellpadding=5>" ;
print "<tr>" ;
print "<td class=colheadsite width=80 align=left>Torrent</td>";
print "<td class=colheadsite width=80 align=left>Delers</td>";
print "<td class=colheadsite width=80 align=left>Ontvangers</td>";
print "<td class=colheadsite width=80 align=left>Informatie</td>";
print "</tr>" ;


$res = mysqli_query($con_link, "SELECT * FROM torrents WHERE owner = " . $CURUSER['id'] . " ORDER BY added DESC") or sqlerr(__FILE__, __LINE__);
while ($row = mysqli_fetch_assoc($res))
	{
	$ontvangers = get_row_count("peers", "WHERE torrent = " . $row['id']);
	$delers = get_row_count("peers", "WHERE seeder='yes' AND torrent = " . $row['id']);
	$zelf = get_row_count("peers", "WHERE seeder='yes' AND torrent = " . $row['id'] . " AND userid = " . $CURUSER['id']);
	$ontvangen = get_row_count("downloaded", "WHERE torrent = " . $row['id']);
	
	print "<tr>";
	print "<td bgcolor=white align=left><a class=altlink_blue href='details.php?id=".$row['id']."'>".htmlspecialchars($row['name'])."</a></td>";
	print "<td bgcolor=white align=left>".$delers."</td>";
	print "<td bgcolor=white align=left>".$ontvangers."</td>";
	if ($ontvangen >= 5)
		{
		if ($zelf == 1 && $delers >= 5)
			print "<td bgcolor=white align=left width=1%><font color=red><b>Stop&nbsp;deze&nbsp;maar&nbsp;met&nbsp;delen.</td>";
		else
			print "<td bgcolor=white align=left width=1%>&nbsp;</td>";
		}
	else
		print "<td bgcolor=white align=left width=1%>&nbsp;</td>";
	print "</td></tr>";
	}
print "</table>";
tabel_einde();
page_einde();
site_footer();
?>
