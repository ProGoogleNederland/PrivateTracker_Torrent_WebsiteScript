<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(true);
loggedinorreturn();

if (get_user_class() < UC_OWNER)
   new_error_message("Foutmelding", "Toegang geweigerd.");

//config
$sitename = "SITE-NAAM"; // Sitename, format: site.com
$replyto = "nietbeantwoorden@SITE-NAAM"; // The Reply-to email.
$record_mail = true; // set this true or false . If you set this true every time whene you send a mail the time , userid , and the number of mail sent will be recorded
$days = 120; //number of days of inactivite
//end config

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

$action = @$_POST["action"];
$cday = 0 + $_POST["cday"];

if (!is_numeric($cday))
site_error_message("Error","Vieze rat !");

if (empty($_POST["userid"]) && (($action == "deluser") || ($action == "mail")))
site_error_message("Foutje","Seleteer een gebruiker!");

if ($action == "deluser" && (!empty($_POST["userid"])))
{
mysqli_query($con_link, "DELETE FROM users WHERE id IN (" . implode(", ", $_POST['userid']) . ") ");
site_error_message("Successfully","Je hebt met succes de geselecteerde accounts verwijderd! <a href=\"".$BASEURL."/inactive.php\">Ga terug</a>");
}

if ($action == "cday" && ($cday > $days))
$days = $cday;

if ($action == "disable" && (!empty($_POST["userid"])))
{
$res = mysqli_query($con_link, "SELECT id, modcomment FROM users WHERE id IN (" . implode(", ", $_POST['userid']) . ") ORDER BY id DESC ")or sqlerr(__FILE__, __LINE__);
while ($arr = mysqli_fetch_array($res))
{
$id = 0 + $arr["id"];
$cname = $CURUSER["username"];
$modcomment = $arr["modcomment"];
$modcomment = gmdate("Y-m-d") . " - Uitgeschakeld door: $cname.\n".$modcomment;

mysqli_query($con_link, "UPDATE users SET modcomment=".sqlesc($modcomment).", enabled='no' WHERE id=$id ") or sqlerr(__FILE__, __LINE__);
}
site_error_message("Succes","Je hebt succesvol de geseleteerde accounts uitgeschakeld! <a href=\"".$BASEURL."/inactive.php\">Ga terug</a>");
}

if ($action == "mail" && (!empty($_POST["userid"])))
{

$res = mysqli_query($con_link, "SELECT id, email , username, added, last_access FROM users WHERE id IN (" . implode(", ", $_POST['userid']) . ") ORDER BY last_access DESC ");
$count = mysqli_num_rows($res);
while ($arr = mysqli_fetch_array($res))
{
$id = $arr["id"];
$username = htmlspecialchars($arr["username"]);
$email = htmlspecialchars($arr["email"]);
$added = $arr["added"];
$last_access = $arr["last_access"];

$subject = "Uw account op $sitename !";
$message = "Hoi!
Tot grote betreuring hebben wij geconstateerd dat u al 3 weken niet meer online bent geweest. 
Op de site is inmiddels al weer heel wat veranderd. Wie weet staat uw favoriete film, album of game er inmiddels bij en dan mist u dat. Dat is toch zonde?
Daarom nodigen wij u graag uit om weer eens een kijkje te nemen op Speedje

Uw gebruikersnaam is: $username
Uw account is aangemaakt op: $added
De laatste keer dat u op $sitename was: $last_access

Kijk op: http://www.speedje.info/login.php
Bent u uw wachtwoord vergeten maak dan hier een nieuwe aan: http://www.speedje.info/recover.php

We hopen u snel weer te zien op $sitename!
Met vriendelijke groet,

De $sitename Staf
";
$headers = 'From: nietbeantwoorden@' . $sitename . "\r\n" .
'Reply-To:' . $replyto . "\r\n" .
'X-Mailer: PHP/' . phpversion();

$mail= @mail($email, $subject, $message, $headers);
}

if($record_mail){
$date = time();
$userid = 0 + $CURUSER["id"];
if ($count > 0 && $mail)
mysqli_query($con_link, "update avps set value_i='$date', value_u='$count', value_s='$userid' WHERE arg='inactivemail' ") or sqlerr(__FILE__, __LINE__);
}

if ($mail)
site_error_message("Success", "Bericht verzonden.");
else
site_error_message("Foutje", "Probeer opnieuw.");
}
}
site_header("Inactive gebruikers");

$dt = sqlesc(get_date_time(gmtime() - ($days * 86400)));
$res= mysqli_query($con_link, "SELECT id,username,class,email,uploaded,downloaded,last_access,ip,added FROM users WHERE last_access<$dt AND status='confirmed' AND enabled='yes' ORDER BY last_access DESC ") or sqlerr(__FILE__, __LINE__);
$count = mysqli_num_rows($res);
if ($count > 0){
?>
<script type="text/javascript" LANGUAGE="JavaScript">

<!-- Begin
var checkflag = "false";
function check(field) {
if (checkflag == "false") {
for (i = 0; i < field.length; i++) {
field[i].checked = true;}
checkflag = "true";
return "Deselecteer allemaal"; }
else {
for (i = 0; i < field.length; i++) {
field[i].checked = false; }
checkflag = "false";
return "Selecteer allemaal"; }
}
// End -->
</script>
<?
print("<form action=\"inactive.php\" method=\"post\">");
print("<table class=main border=1 cellspacing=0 cellpadding=5><tr>\n");
print("<td class=colhead>Aantal dagen</td><td class=colhead><input type=\"text\" name=\"cday\" size=\"10\" value=\"".($cday > $days ? $cday : $days)."\" maxlength=\"3\" /></td>");
print("<td class=\"colhead\"><input type=\"submit\" value=\"Verander\" /><input type=\"hidden\" name='action' value=\"cday\" />");
print("</td></tr></table></form><br/>");


print("<h2><font color=orange>".$count." accounts die langer dan ".$days." dagen niet online zijn geweest.</font></h2>");
print("<form action=\"inactive.php\" method=\"post\">");
print("<table class=main border=1 cellspacing=0 cellpadding=5><tr>\n");
print("<td class=colhead>Gebruikersnaam</td>");
print("<td class=colhead>Class</td>");
print("<td class=colhead>IP</td>");
print("<td class=colhead>Ratio</td>");
print("<td class=colhead>Aanmelddatum</td>");
print("<td class=colhead>Laatst gezien</td>");
print("<td class=colhead align=\"center\">x</td>");

while ($arr = mysqli_fetch_assoc($res)) {
$ratio = ($arr["downloaded"] > 0 ? number_format($arr["uploaded"] / $arr["downloaded"], 3) : ($arr["uploaded"] > 0 ? "Inf." : "---"));
$downloaded = mksize($arr["downloaded"]);
$uploaded = mksize($arr["uploaded"]);
$last_seen = (($arr["last_access"] == "0000-00-00 00:00:00") ? "never" : "".get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["last_access"]))."&nbsp;geleden" );
$class=get_user_class_name($arr["class"]);
$joindate = substr($arr['added'], 0, strpos($arr['added'], " "));
print("<tr>");
print("<td><a href=\"userdetails.php?id=".$arr["id"]."\">".htmlspecialchars($arr["username"])."</a></td>");
print("<td>".$class."</td>");
print("<td>".($arr["ip"] == "" ? "---" : $arr["ip"] )."</td>");
print("<td>".$ratio."<br/><font class=\"small\"> D: ".$downloaded." U: ".$uploaded."</font></td>");
print("<td>".$joindate."</td>");
print("<td>".$last_seen."</td>");
print("<td align=\"center\" bgcolor=\"#FF0000\"><input type=\"checkbox\" name=\"userid[]\" value=\"".$arr["id"]."\" /></td>");
print("</tr>");
}
print("<tr><td colspan=\"7\" class=\"colhead\" align=\"center\">
<select name=\"action\">
<option value=\"mail\">Stuur een email</option>
<option value=\"deluser\" ".($CURUSER["class"] < UC_OWNER ? "disabled" : "" ).">Verwijder gebruikers</option>
<option value=\"disable\">Accounts uitschakelen</option>
</select>&nbsp;&nbsp;<input type=\"submit\" name=\"submit\" value=\"Bevestig\"/>&nbsp;&nbsp;<input type=\"button\" value=\"Check all\" onClick=\"this.value=check(form)\" /></td></tr>");

if($record_mail){
$ress = mysqli_query($con_link, "SELECT avps.value_s AS userid, avps.value_i AS last_mail, avps.value_u AS mails, users.username FROM avps LEFT JOIN users ON avps.value_s=users.id WHERE avps.arg='inactivemail' LIMIT 1");
$date = mysqli_fetch_assoc($ress);
if ($date["last_mail"] > 0 )
print("<tr><td colspan=\"7\" class=\"colhead\" align=\"center\" style=\"color:red;\">Laatste email verzonden door <a href=\"userdetails.php?id=".$date["userid"]."\">".$date["username"]."</a> op <b>".gmdate("d M Y",$date["last_mail"])."</b> en is <b>".$date["mails"]."</b> mail".($date["mails"] > 1 ? "s" : "")." verstuurd!</td></tr>");
}

print("</table></form>");
}else{
print("<h2>Er zijn geen accounts van langer dan ".$days." dagen inactief.</h2>");
}
site_footer();
?>