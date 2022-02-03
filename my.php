<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();
$res = mysqli_query($con_link, "SELECT COUNT(*) FROM messages WHERE receiver=" . $CURUSER["id"] . " AND location IN ('in', 'both')") or print(mysqli_error());
$arr = mysqli_fetch_row($res);
$messages = $arr[0];
$res = mysqli_query($con_link, "SELECT COUNT(*) FROM messages WHERE receiver=" . $CURUSER["id"] . " AND location IN ('in', 'both') AND unread='yes'") or print(mysqli_error());
$arr = mysqli_fetch_row($res);
$unread = $arr[0];
$res = mysqli_query($con_link, "SELECT COUNT(*) FROM messages WHERE sender=" . $CURUSER["id"] . " AND location IN ('out', 'both')") or print(mysqli_error());
$arr = mysqli_fetch_row($res);
$outmessages = $arr[0];


site_header($CURUSER["username"] . "'s prive pagina", false);
tabel_start();
if (@$_GET["edited"]) {
	print("<h1>Profiel aangepast.</h1>\n");
	if (@$_GET["mailsent"])
		print("<h2>Bevestiging e-mail is verstuurd.</h2>\n");
}
elseif (@$_GET["emailch"])
	print("<h1>E-mailadres is gewijzigd!</h1>\n");

print("<table class=bottom width=90% border=0 cellspacing=0 cellpadding=0><tr><td class=embedded-page>\n");
	tabel_top("Persoonlijke instellingen van: <a href=userdetails.php?id=" . $CURUSER['id'] . "><font color=yellow>" . $CURUSER['username'] . "</a>");
//	print("<br><table width=80% border=0 cellpadding=5><tr><td align=center class=text123033><font size=3 color=yellow><b>Persoonlijke instellingen van: <a href=userdetails.php?id=$CURUSER[id]><font color=yellow>$CURUSER[username]</a></td></tr></table>");

?>
<table class=bottom1 width=100% border="0" cellspacing="0" cellpadding="10" align="center">
<tr>
<td class=embedded align="center" width="33%"><center><br><form method=post action=friends.php><input type=submit style='height: 30px;width: 300px' value='Mijn vrienden'></form><br><br></td>
<td class=embedded align="center" width="33%"><center><br><form method=post action=mytorrents.php><input type=submit style='height: 30px;width: 300px' value='Mijn Torrents'></form><br><br></td>
<td class=embedded align="center" width="33%"><center><br><form method=post action=logout.php><input type=submit style='height: 30px;width: 300px' value='Afmelden'></form><br><br></td>
</tr>
<tr>
<td class=embedded colspan="3"><center>
<form method="post" action="takeprofedit.php">
<table class=bottom1 border="1" cellspacing=0 cellpadding="5" width="95%">
<?

$countries = "<option value=0>---Niets geselecteerd ---</option>\n";
$ct_r = mysqli_query($con_link, "SELECT id,name FROM countries ORDER BY name") or die;
while ($ct_a = mysqli_fetch_array($ct_r))
  $countries .= "<option value=$ct_a[id]" . ($CURUSER["country"] == $ct_a['id'] ? " selected" : "") . ">$ct_a[name]</option>\n";

function format_tz($a)
{
	$h = floor($a);
	$m = ($a - floor($a)) * 60;
	return ($a >= 0?"+":"-") . (strlen(abs($h)) > 1?"":"0") . abs($h) .
		":" . ($m==0?"00":$m);
}
///////////////////////////////////////////////////////////
//print "<tr><td class=text123 valign='top' align='left' border=0><font color=white size=2>XXX uitzetten:</td></td><td class=text123 valign='top' align=left><font color=white size=2><input type=radio name=xxx" . ($CURUSER["xxx"] == "yes" ? " checked" : "") . " value=yes>ja<input type=radio name=xxx" .  ($CURUSER["xxx"] == "no" ? " checked" : "") . " value=no>Nee</font></td></tr>";
//print "<tr><td class='heading' valign='top' align='right'>Kindvriendelijke modus</td>";
//print "<td class=heading valign='top' align=left><input type=radio name=XXX" . ($CURUSER["XXX"] == "yes" ? " checked" : "") . " value=yes>uit
//<input type=radio name=XXX" .  ($CURUSER["XXX"] == "no" ? " checked" : "") . " value=no>aan";
//////////////////////////////////////////////////////////
tr("Accepteer berichten van",
"<input type=radio name=acceptpms" . ($CURUSER["acceptpms"] == "yes" ? " checked" : "") . " value=yes>Iedereen (behalve de door u geblokkeerde)
<input type=radio name=acceptpms" .  ($CURUSER["acceptpms"] == "friends" ? " checked" : "") . " value=friends>Alleen uw vrienden
<input type=radio name=acceptpms" .  ($CURUSER["acceptpms"] == "no" ? " checked" : "") . " value=no>Alleen leden van de staff"
,1);

tr("Beantwoorde berichten verwijderen", "<input type=checkbox name=deletepms" . ($CURUSER["deletepms"] == "yes" ? " checked" : "") . "> (Aanvinken voor verwijderen)",1);

tr("Bewaar verzonden berichten", "<input type=checkbox name=savepms" . ($CURUSER["savepms"] == "yes" ? " checked" : "") . "> (Aanvinken voor bewaren)",1);

//// PASSKEY 
tr("Reset passkey","<input type=checkbox name=resetpasskey value=1 /> LET OP: Al uw upload moeten opnieuw geplaatst worden.</td>", 1);
//// PASSKEY 

print "<td class=embedded><div align=center>";
$r = mysqli_query($con_link, "SELECT id,name FROM categories ORDER BY name") or sqlerr();
if (mysqli_num_rows($r) > 0)
{
	@$categories .= "<table class=bottom width=90% align=center border=0><tr>\n";
	$i = 0;
	while ($a = mysqli_fetch_assoc($r))
	{
	  $categories .=  ($i && $i % 2 == 0) ? "" : "";
	  $categories .= "<td class=bottomcat style='padding-right: 5px'><div><input name=cat$a[id] type=\"checkbox\" " . (strpos($CURUSER['notifs'], "[cat$a[id]]") !== false ? " checked" : "") . " value='yes'>&nbsp;" . htmlspecialchars($a["name"]) . "</div></td>\n";
	  
	  ++$i;
	}
	$categories .= "</table>\n";
	
}
tr("Emails ontvangen?","<input type=checkbox name=emailnotif" . (strpos($CURUSER['notifs_donor'], "[email]") !== false ? " checked" : "") . " value=yes> Mail mij de nieuwe uploads waar ik interesse in heb.\n</td>",1);
tr("Kies uw interesses </br><i>(zichtbaar in uw torrent overzicht)</i>",$categories,1);
tr("Nationaliteit", "<select name=country>\n$countries\n</select>",1);

tr("<font style=\"line-height:36px;\" >Skype naam</font>", "<form method=post action=''><input type=hidden name=action1 value=skype_name><input maxlength=40 type=text size=60 name=skype_name value=\"" . htmlspecialchars($CURUSER['skype_name']) . "\">",1);
$action1 = (string)@$_POST['action1'];
if ($action1 == 'skype_name')
	{
	$skype_name = (string)@$_POST['skype_name'];
	if (!$skype_name)
	site_error_message("Foutmelding", "Niets ontvangen om te verwerken.");
	mysqli_query($con_link, "UPDATE users SET skype_name = '". $skype_name ."' WHERE id =  '". $CURUSER["id"] ."'") or sqlerr(__FILE__, __LINE__);
	}
	


/*
tr("Avatar URL", "<input name=avatar size=73 value=\"" . htmlspecialchars($CURUSER["avatar"]) .
  "\"><br>\nBreedte mag niet meer zijn dan 150 pixels (indien nodig wordt deze veranderd)</p><a href=avatar_upload.php>Avatar plaatsen op de $SITE_NAME server.</a>\n",1);
*/
tr("Avatar plaatje", "Avatar plaatsen? <a class=altlink_red href=avatar_upload.php>Klik hier</a>.\n",1);
tr("Bedankt plaatje", "Bedankje plaatsen? <a class=altlink_red href=bedankt_upload.php>Klik hier</a>.\n",1);
tr("Avatars zichtbaar", "<input type=checkbox name=avatars" . ($CURUSER["avatars"] == "yes" ? " checked" : "") . "> (ivm trage internetsnelheid deze optie beter uit)",1);
tr("Gebruikersnaam", "Voor wijzigen uw gebruikersnaam moet u contact opnemen met een administrator.");
tr("E-Mail", "Voor wijzigen uw e-mailadres moet u contact opnemen met een administrator.");

function priv($name, $descr) {
	global $CURUSER;
	if ($CURUSER["privacy"] == $name)
		return "<input type=\"radio\" name=\"privacy\" value=\"$name\" checked=\"checked\" /> $descr";
	return "<input type=\"radio\" name=\"privacy\" value=\"$name\" /> $descr";
}


?>
<tr><td class=text123 colspan="2" align="center"><input type="submit" value="Wijzigingen opslaan" style='height: 30px'> <input type="reset" value="Wijzigingen ongedaan maken" style='height: 30px'></td></tr>
</table><br>
</form>
<?
$ww_form = "<form method=post action=password.php>";
$ww_form .= "<input type=submit style='height: 30px;width: 300px' value='Druk hier om uw wachtwoord te wijzigen'>";
$ww_form .= "</form>";
print $ww_form;
print "<br>";
?>


</td>
</tr>
</table>
</td>
</tr>
</table>
<?php
//if ($messages){
//  print("<p>U heeft $messages bericht" . ($messages != 1 ? "en" : "") . " ($unread nieuw) in uw <a href=inbox.php><b>postvak-in</b></a>,<br>\n");
//	if ($outmessages)
//		print("en $outmessages bericht" . ($outmessages != 1 ? "en" : "") . " in uw <a href=inbox.php?out=1><b>postvak-uit</b></a>.\n</p>");
//	else
//		print("en uw <a href=inbox.php?out=1>postvak-uit</a> is leeg.</p>");
//}
//else
//{
//  print("<p>uw <a href=inbox.php>postvak-in</a> is leeg, <br>\n");
//	if ($outmessages)
//		print("en u heeft $outmessages bericht" . ($outmessages != 1 ? "en" : "") . " in uw <a href=inbox.php?out=1><b>postvak-uit</b></a>.\n</p>");
//	else
//		print("en ook uw <a href=inbox.php?out=1>postvak-uit</a>.</p>");
//}

//print("<p><a href=users.php><b>Zoek een gebruiker</b></a></p>");
tabel_einde();
site_footer();


?>