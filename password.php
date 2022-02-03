<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (!$CURUSER)
	site_error_message("Foutmelding", "U ben niet bevoegd om deze pagina te bekijken.");

$userid = $CURUSER['id'];

$action = @$_POST['action'];
if ($action == "update")
	{
	$ww_old = @$_POST['ww_old'];
	$ww_new = @$_POST['ww_new'];
	$ww_repeat = @$_POST['ww_repeat'];
	
	if (!$ww_old)
		site_error_message("Foutmelding", "Geen oud wachtwoord ontvangen.");
	if (!$ww_new)
		site_error_message("Foutmelding", "Geen nieuw wachtwoord ontvangen.");
	if (!$ww_repeat)
		site_error_message("Foutmelding", "Geen herhaling van uw nieuwe wachtwoord ontvangen.");
	if ($ww_new <> $ww_repeat)
		site_error_message("Foutmelding", "Nieuwe wachtwoorden komen niet overeen.");

	$res = mysqli_query($con_link, "SELECT id, passhash, secret, enabled FROM users WHERE id = " . $CURUSER['id']) or sqlerr(__FILE__,__LINE__);
	$row = mysqli_fetch_array($res);
	
	if ($row["passhash"] != md5($row["secret"] . $ww_old . $row["secret"]))
		site_error_message("Foutmelding", "Dit komt niet overeen met uw oude wachtwoord.");
	
	$sec = "5600BA1C24CB49B5D243F168D18AFCDBDB57B937";
	$passhash = md5($sec . $ww_new . $sec);
	logincookie($CURUSER["id"], $passhash);
	$secret = sqlesc($sec);
	$passhash = sqlesc($passhash);
	mysqli_query($con_link, "UPDATE users SET secret = $secret, passhash = $passhash WHERE id = " . $CURUSER['id']) or sqlerr(__FILE__,__LINE__);

	header("Location: $DEFAULTBASEURL/my.php?id=" . $CURUSER['id']);
	die;
	}

site_header("Wachtwoord");
print("<table class=bottom width=60% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td align=center class=embedded><div align=center>");
tabel_top("Wachtwoord wijzigen van " . get_username($userid));
print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=10 cellpadding=0>");
print("<tr>");
print("<td align=center class=embedded><div align=center>");
print "<table class=bottom width=60% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded>";

print "<form name='password' method=post action='password.php'>";
print "<input type=hidden name=action value=update>";
print "<tr><td bgcolor=white class=rowhead>Oude&nbsp;wachtwoord:</td><td bgcolor=white align=left>";
print "<input maxlength=40 type=password size=40 name=ww_old value=''></td></tr>";

print "<tr><td bgcolor=white class=rowhead>Nieuwe&nbsp;wachtwoord:</td><td bgcolor=white align=left>";
print "<input maxlength=40 type=password size=40 name=ww_new value=''></td></tr>";

print "<tr><td bgcolor=white class=rowhead>Herhaal&nbsp;wachtwoord:</td><td bgcolor=white align=left>";
print "<input maxlength=40 type=password size=40 name=ww_repeat value=''></td></tr>";

print "<input type=hidden name=userid value=" . $userid . ">";
print "<tr><td bgcolor=white colspan=2 align=center><input type=submit value=Wijzigen class=btn></td></tr>";
print "</form>";
?>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript">
<!--
document.password.ww_old.focus();
//-->
</script>
<?
print("<br></td></tr></table>");
print("<br></td></tr></table>");
print("</td></tr></table><br>");

site_footer();
?>
