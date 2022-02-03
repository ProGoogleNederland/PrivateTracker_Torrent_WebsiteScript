<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_OWNER)
	site_error_message("Foutmelding", "U ben niet bevoegd om deze pagina te bekijken.");

$extra = "";
$userid = (int)@$_POST['userid'];

$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);

if (!$row)
	site_error_message("Foutmelding", "Geen gebruiker gevonden met dit id.");

if ($row['class'] >= $CURUSER['class'])
	site_error_message("Foutmelding", "U ben niet bevoegd om deze te wijzigen.");

$mode = @$_GET['mode'];
if ($mode == "") $mode = "form";

if ($mode == "form")
	{
	$username = get_username($userid);
	site_header("Gebruikersnaam");
	print("<table class=bottom width=60% border=0 cellspacing=0 cellpadding=0>");
	print("<tr>");
	print("<td align=center class=embedded><div align=center>");
	tabel_top("Gebruikersnaam wijzigen van " . get_username($userid));
	print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=10 cellpadding=0>");
	print("<tr>");
	print("<td align=center class=embedded><div align=center>");
	print "<table class=bottom width=60% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded>";

	print "<form method=post action=?mode=wijzig>";
	print "<tr><td bgcolor=white class=rowhead>Gebruikersnaam:</td><td bgcolor=white align=left><input maxlength=12 type=text size=40 name=username value=\"" . htmlspecialchars($username) . "\"></td></tr>";
	print "<input type=hidden name=userid value=" . $userid . ">";
	print "<tr><td bgcolor=white colspan=2 align=center><input type=submit value=Wijzigen class=btn></td></tr>";
	print "</form>";
	
	print("<br></td></tr></table>");
	print("<br></td></tr></table>");
	print("</td></tr></table><br>");
	
	site_footer();
	die;
	}

if ($mode == "wijzig")
	{
	$username = @$_POST['username'];
	
	if (!$username)
		site_error_message("Foutmelding", "Geen gegevens ontvangen.");

	if (strlen($username) > 12)
		site_error_message("Foutmelding", "Uw gebruikersnaam mag maximaal 12 letters en/of cijfers groot zijn.");
	
	$res = mysqli_query($con_link, "SELECT id, username FROM users WHERE username = '$username'")	or sqlerr();
	$row = mysqli_fetch_array($res);
	if ($row)
		site_error_message("Foutmelding", "Deze gebruikersnaam wordt al gebruikt, kies een andere.");

	$message = "Gebruikersnaam " . get_username($userid) . " gewijzigd in " . $username . " door " . get_username($CURUSER['id']);
	$username = sqlesc($username);
	mysqli_query($con_link, "UPDATE users SET username=$username WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
	write_log_username($message);
//	site_send_message(1,0,$message);
//	site_send_message(3,0,$message);
	site_error_message("Gebruikersnaam", "Gebruikersnaam is gewijzigd.");

	}
?>
