<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de moderators.");

$action = @$_POST['action'];

if ($action == "sendmessage")
	{
	if (get_user_class() < UC_ADMINISTRATOR)
		new_error_message("Foutmelding", "Alleen moderatoren kunnen deze versturen.");
	$message = @$_POST['message'];
	$added = sqlesc(get_date_time());
	$message =	sqlesc($message);
	$sendermsg = $CURUSER['id'];
	$send_count = 0;
	$res = mysqli_query($con_link, "SELECT * FROM mod_letters WHERE userid = ".$CURUSER['id']) or sqlerr(__FILE__, __LINE__);	
	while ($row = mysqli_fetch_assoc($res))
		{
		$letter = $row['letter'];
		$res2 = mysqli_query($con_link, "SELECT id FROM users WHERE username LIKE '".$letter."%'") or sqlerr(__FILE__, __LINE__);	
		while ($row2 = mysqli_fetch_assoc($res2))
			{
			$userid = $row2['id'];
			$send_count = $send_count + 1;
			mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES ($sendermsg, $userid, $message, $added)") or sqlerr(__FILE__, __LINE__);
			}
		}
	mysqli_query($con_link, "INSERT INTO massa_bericht_mods (sender, aantal, msg, added) VALUES ($sendermsg, $send_count, $message, $added)") or sqlerr(__FILE__, __LINE__);
	new_error_message("Mededeling", "Berichten zijn verzonden.");
	}

$res = mysqli_query($con_link, "SELECT * FROM mod_letters WHERE userid = " . $CURUSER['id']) or sqlerr(__FILE__, __LINE__);	
while ($row = mysqli_fetch_assoc($res))
	{
	@$letters .= "<td class=embedded><div align=center><font color=lightblue size=2><b>" . @$row['letter'] . "</font></div></td>";
	}

$sjabloon = "Hallo,\n\n\n\nMet vriendelijke groet,\n\n" . $CURUSER['username'];
site_header("Massa bericht");tabel_start();
print "<br>";
print "<table width=95% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>";
print "<br>";
tabel_top("Massa bericht aan uw letters als moderator.", "center");
print "<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=0>";
print "<tr>";
print "<td class=bottom align=center><center><br>";

print "<table width=90% class=bottom border=0 cellspacing=0 cellpadding=0><tr>";
print "<td class=embedded><div align=center><font color=lightblue size=2><b>";
print "Hier kunt u als moderator berichten versturen naar alle gebruikers die bij uw letter horen.";
print "<br>LET OP: Deze optie wijs gebruiken en niet voor onnodige zaken.";
print "<br>Hier onder staan de letters welke bij u horen.";
print "<br>";
print "<br>";
print "</font></div></td>";
print "</tr></table>";

print "<table width=70% class=bottom border=0 cellspacing=0 cellpadding=0><tr>".$letters."</tr></table>";
print "<br>";
print "<form name='save_new' method=post action='massa_berichten_mods.php'>";
print "<input type=hidden name=action value=sendmessage>";
print "<textarea name=message cols=125 rows=15>".htmlspecialchars($sjabloon)."</textarea>";
print "<br><br>";
print "<input type=submit class=btn style='height: 25px; width: 120px' value='Berichten versturen'>";
print "</form>";

print "<br></td></tr></table>";
print "</td></table><br>";
tabel_einde();
site_footer(false);
?>