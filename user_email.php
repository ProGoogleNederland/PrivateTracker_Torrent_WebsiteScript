<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
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
	$email = get_email($userid);

	site_header("E-mailadres");
	print("<table class=bottom width=60% border=0 cellspacing=0 cellpadding=0>");
	print("<tr>");
	print("<td align=center class=embedded><div align=center>");
	tabel_top("E-mailadres wijzigen van " . get_username($userid));
	print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=10 cellpadding=0>");
	print("<tr>");
	print("<td align=center class=embedded><div align=center>");
	print "<table class=bottom width=60% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded>";

	print "<form method=post action=?mode=wijzig>";
	print "<tr><td bgcolor=white class=rowhead>E-mailadres:</td><td bgcolor=white align=left>";
	print "<input maxlength=50 type=text size=40 name=useremail value=\"" . htmlspecialchars($email) . "\"></td></tr>";


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
	$useremail = @$_POST['useremail'];
	$userid = @$_POST['userid'];
	
	if (!$useremail)
		site_error_message("Foutmelding", "Geen gegevens ontvangen.");

	if (!$userid)
		site_error_message("Foutmelding", "Geen gebruikers id ontvangen.");

	if (strlen($useremail) > 50)
		site_error_message("Foutmelding", "Het e-mailadres mag maximaal 50 letters groot zijn.");

	if (!validemail($useremail))
		site_error_message("Foutmelding", "Geen goed e-mailadres ontvangen.");

	
	$res = mysqli_query($con_link, "SELECT id, email FROM users WHERE email = '$useremail'")	or sqlerr();
	$row = mysqli_fetch_array($res);
	if ($row)
		site_error_message("Foutmelding", "Het e-mailadres wordt al gebruikt, kies een andere.");

	$message = "Van " . get_username($userid) . " het e-mailadres gewijzigd in " . $useremail . " door " . get_username($CURUSER['id']);
	$useremail = sqlesc($useremail);
	mysqli_query($con_link, "UPDATE users SET email=$useremail WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
	write_log_useremail($message);
	site_error_message("E-mailadres", "E-mailadres van <a href=userdetails.php?id=" . $userid . ">" . get_username($userid) . "</a> is gewijzigd.");

	}
?>
