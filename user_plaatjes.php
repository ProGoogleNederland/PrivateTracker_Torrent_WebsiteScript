<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();
if (get_user_class() < UC_MODERATOR)
site_error_message("Foutmelding", "U ben niet bevoegd om deze pagina te bekijken.");
$user_id = @$_POST['user_id'];
if (!$user_id)
site_error_message("Foutmelding", "Geen gebruikers ID ontvangen.");
$mode = @$_GET['mode'];
if ($mode == "") $mode = "form";
if ($mode == "form")
{
$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);
if (!$row)
site_error_message("Foutmelding", "Geen gebruiker gevonden met dit id.");
$avatar = $row['bedanktplaat'];
site_header("Bedanktplaatje wijzigen");
page_start();
tabel_top("Bedanktplaatje wijzigen van " . get_username($user_id),"center");
tabel_start();
print "<table class=bottom width=60% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded>";
print "<form method=post action=?mode=wijzig>";
print "<tr><td bgcolor=white class=rowhead>Bedanktplaatje:</td><td bgcolor=white align=left>";
print "<input maxlength=50 type=text size=120 name=avatar value=\"" . htmlspecialchars($avatar) . "\"></td></tr>";
print "<input type=hidden name=user_id value=" . $user_id . ">";
print "<tr><td bgcolor=white colspan=2 align=center><input type=submit value=Wijzigen class=btn></td></tr>";
print "</form>";
print("<br></td></tr></table>");
tabel_einde();
page_einde();
site_footer();
die;
}
if ($mode == "wijzig")
{
$avatar = @$_POST['avatar'];
$user_id = 0 + $_POST['user_id'];
if (!$avatar)
site_error_message("Foutmelding", "Geen gegevens ontvangen.");
if (!$user_id)
site_error_message("Foutmelding", "Geen gebruikers id ontvangen.");
$avatar = sqlesc($avatar);
mysqli_query($con_link, "UPDATE users SET bedanktplaat=$avatar WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
site_error_message("bedanktplaatje", "<font color=white>bedanktplaatje van <a href=userdetails.php?id=" . $user_id . ">" . get_username($user_id) . "</a> is gewijzigd.");
}
?>