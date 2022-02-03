<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_MODERATOR)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de moderator en hoger.");

$user_id = (int)@$_GET['user_id'];

if (!$user_id)
	site_error_message("Foutmelding", "Geen user id ontvangen.");


site_header("Kliks");
page_start();
tabel_top("Overzicht kliks op de site voor alle Moderators. (Deze maand)","center");
tabel_start(70);

$s = "<table class=main width=300 border=1 cellspacing=0 cellpadding=\"5\">\n";
$s.= "<tr><td class=colheadsite width=100>Pagina</td><td class=colheadsite align=right width=100>Kliks</td></tr>\n";

$subres = mysqli_query($con_link, "SELECT * FROM hits WHERE user_id = ".$user_id." ORDER BY page");

while ($subrow = mysqli_fetch_array($subres))
	{
	$s .= "<tr><td bgcolor=white align=left>" . htmlspecialchars($subrow["page"]) . "</td>\n";
	$s .= "<td bgcolor=white align=right>" . $subrow["kliks"] . "</td></tr>\n";
	}
	
$s .= "</td></tr></table>";
print $s;

tabel_einde();
page_einde();
site_footer();
?>
