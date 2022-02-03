<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_OWNER)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de moderator en hoger.");

site_header("Kliks");
page_start();
tabel_top("Overzicht kliks op de site voor alle Moderators. (Deze maand)","center");
tabel_start(70);

$s = "<table class=main width=300 border=1 cellspacing=0 cellpadding=\"5\">\n";
$s.= "<tr><td class=colheadsite width=100>Gebruikersnaam</td><td class=colheadsite align=left width=100>Class</td><td class=colheadsite align=right width=100>Kliks</td></tr>\n";

$subres = mysqli_query($con_link, "SELECT * FROM users WHERE class >= 4 ORDER BY class, kliks DESC");

while ($subrow = mysqli_fetch_array($subres))
	{
	$s .= "<tr><td bgcolor=white align=left><a class=altlink_blue href='userdetails.php?id=".$subrow["id"]."'>" . get_username($subrow["id"]) . "</td><td bgcolor=white align=left>" . get_user_class_name($subrow["class"]) . "</td><td bgcolor=white align=right>" . $subrow["kliks"] . "</td></tr>\n";
	}
	
$s .= "</td></tr></table>";
print $s;

tabel_einde();
page_einde();
site_footer();
?>
