<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

site_header("Kliks");
page_start();
tabel_top("Overzicht kliks, top 50, alle gebruikers.","center");
tabel_start(70);

$s = "<table class=main border=\"1\" cellspacing=0 cellpadding=\"5\">\n";
$s.= "<tr><td class=colheadsite>Gebruikersnaam</td><td class=colheadsite align=right>Kliks</td></tr>\n";

$subres = mysqli_query($con_link, "SELECT * FROM users ORDER BY kliks DESC LIMIT 50");

while ($subrow = mysqli_fetch_array($subres))
	{
	$s .= "<tr><td bgcolor=white align=left><a class=altlink_blue href='userdetails.php?id=".$subrow["id"]."'>" . get_username($subrow["id"]) . "</td><td bgcolor=white align=right>" . $subrow["kliks"] . "</td></tr>\n";
	}
	
$s .= "</td></tr></table>";
print $s;

tabel_einde();
page_einde();
site_footer();
?>
