<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_SYSOP)
	site_error_message("Foutmelding", "U ben niet bevoegd om deze pagina te bekijken.");

$extra = "";
$user_id = 0 + $_GET['user_id'];

$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);

if (!$row)
	site_error_message("Foutmelding", "Geen gebruiker gevonden met dit id.");

$uploaded = $row['uploaded'];
$downloaded = $row['downloaded'];

if (!$user_id)
	site_error_message("Foutmelding", "Geen gebruikers ID ontvangen.");

$action = @$_GET['action'];

if ($action == "send")
	{
	$addthis = @$_GET[addthis];
	$message = @$_GET[message];

	if (!$addthis && !$message)
		site_error_message("Foutmelding", "Geen gegevens ontvangen om te gebruiken.");
	
	if (!$addthis)
		site_error_message("Foutmelding", "Geen GB geselecteerd.");

	if (!$message)
		site_error_message("Foutmelding", "Geen bericht ontvangen.");

	$addthis = $addthis * 1024 *1024*1024;
	$add_msg = mksize($addthis);
	$message = str_replace("##GB##", $add_msg, $message);
	
	$modcomment = $row['modcomment'];

	$uploaded = $addthis;
	$modcomment = "Bonus gegeven van ".mksize($addthis)." op " . convertdatum(gmdate("Y-m-d H:i:s")) . " - door " . $CURUSER['username'] . " - oud = ".mksize($row['uploaded'])." en nieuw = ".mksize($row['uploaded'] + $addthis).".\n" . $modcomment;
	$modcomment = sqlesc($modcomment);
	$message = sqlesc($message);
	$sender = $CURUSER['id'];
	mysqli_query($con_link, "UPDATE users SET uploaded = uploaded + $addthis, modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, added, msg, poster) VALUES ($sender, $user_id, NOW(), $message, 0)") or sqlerr(__FILE__, __LINE__);
	header("Location: $BASEURL/userdetails.php?id=$user_id");
	}

$message = "Hallo " . get_username($user_id) . ",\n\n";
$message .= "U heeft een verhoging van u totaal verzonden ontvangen van ##GB##.\n\n";
$message .= "Hetgeen uw ratio zal verbeteren op ".$SITE_NAME.".\n\n";
$message .= "Met vriendelijke groet,\n\n";
$message .= $CURUSER['username'];

site_header("GB");
print "<table class=bottom width=60% border=0 cellspacing=0 cellpadding=0>";
print "<tr>";
print "<td align=center class=embedded><div align=center>";
tabel_top("Bonus voor <a class=altlink_yellow href=userdetails.php?id=".$user_id.">" . get_usernamesite($user_id) . "</a>","center");
print "<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=10 cellpadding=0>";
print "<tr>";
print "<td align=center class=embedded><div align=center>";

print "<table class=bottom width=90% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded>";

print "<form method=get action=''>";
print "<input type=hidden name=action value=send>";
print "<input type=hidden name=user_id value=" . $user_id . ">";
print "<tr>";
print "<td class=colheadsite></td>";
print "</tr>";
print "<tr>";
print "<td bgcolor=white align=center>";

print "<table class=bottom width=95% border=0 cellspacing=0 cellpadding=0><tr>";
print "<td align=center class=embedded><div align=center>1 Gb<br><input type=radio name=addthis value=1></td>";
print "<td align=center class=embedded><div align=center>2 Gb<br><input type=radio name=addthis value=2></td>";
print "<td align=center class=embedded><div align=center>3 Gb<br><input type=radio name=addthis value=3></td>";
print "<td align=center class=embedded><div align=center>4 Gb<br><input type=radio name=addthis value=4></td>";
print "<td align=center class=embedded><div align=center>5 Gb<br><input type=radio name=addthis value=5></td>";
print "<td align=center class=embedded><div align=center>10 Gb<br><input type=radio name=addthis value=10></td>";
print "<td align=center class=embedded><div align=center>15 Gb<br><input type=radio name=addthis value=15></td>";
print "<td align=center class=embedded><div align=center>20 Gb<br><input type=radio name=addthis value=20></td>";
print "<td align=center class=embedded><div align=center>25 Gb<br><input type=radio name=addthis value=25></td>";
print "</tr></table>";

print "</td>";
print "</tr>";
print "<tr><td bgcolor=white><textarea name=message cols=125 rows=15>".htmlspecialchars($message)."</textarea></td></tr>";

print "<tr><td bgcolor=white align=center><input type=submit style='height: 24px;width: 150px' value='Gegevens versturen'></td></tr>";
print "</form>";

print "<br></td></tr></table>";
print "<br></td></tr></table>";
print "</td></tr></table><br>";

site_footer();

function makesize($bytes)
	{
	return round( $bytes / 1073741824, 0);
	}
?>
