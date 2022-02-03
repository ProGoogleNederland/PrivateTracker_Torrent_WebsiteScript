<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
function bark($msg) {
	genbark($msg, "Update failed!");
}

dbconn();
loggedinorreturn();

//if (!mkglobal("email:chpassword:passagain"))
//	site_error_message("Foutmelding","Niet alle gegevens ontvangen");

// $set = array();

$updateset = array();
//$changedemail = 0;

if (@$chpassword != "") {
	if (strlen($chpassword) > 40)
		bark("Sorry, password is too long (max is 40 chars)");
	if ($chpassword != $passagain)
		bark("The passwords didn't match. Try again.");

	$sec = mksecret();

  $passhash = md5($sec . $chpassword . $sec);

	$updateset[] = "secret = " . sqlesc($sec);
	$updateset[] = "passhash = " . sqlesc($passhash);
	logincookie($CURUSER["id"], $passhash);
}
/*
if ($email != $CURUSER["email"]) {
	if (!validemail($email))
		bark("That doesn't look like a valid email address.");
  $r = mysqli_query($con_link, "SELECT id FROM users WHERE email=" . sqlesc($email)) or sqlerr();
	if (mysqli_num_rows($r) > 0)
		bark("The e-mail address $email is already in use.");
	$changedemail = 1;
}
*/
$acceptpms = @$_POST["acceptpms"];
$deletepms = (@$_POST["deletepms"] != "" ? "yes" : "no");
$savepms = (@$_POST["savepms"] != "" ? "yes" : "no");
//$pmnotif = @$_POST["pmnotif"];
$emailnotif = @$_POST["emailnotif"];
//$notifs = ($pmnotif == 'yes' ? "[pm]" : "");
@$notifs .= ($emailnotif == 'yes' ? "[email]" : "");
$r = mysqli_query($con_link, "SELECT id FROM categories") or sqlerr();
$rows = mysqli_num_rows($r);
for ($i = 0; $i < $rows; ++$i)
{
	$a = mysqli_fetch_assoc($r);
	if (@$_POST["cat$a[id]"] == 'yes')
	  $notifs .= "[cat$a[id]]";
}
//$avatar = htmlspecialchars($_POST["avatar"]);
$avatars = (@$_POST["avatars"] != "" ? "yes" : "no");
// $ircnick = @$_POST["ircnick"];
// $ircpass = @$_POST["ircpass"];
$info = @$_POST["info"];
$country = @$_POST["country"];
//$timezone = 0 + $_POST["timezone"];
$dst = (@$_POST["dst"] != "" ? "yes" : "no");
/////////////////////////////////////////////////////////////////////////
$XXX = @$_POST["XXX"];


$updateset[] = "XXX = '$XXX'";
/////////////////////////////////////////////////////////////////////////
/*
if ($privacy != "normal" && $privacy != "low" && $privacy != "strong")
	bark("whoops");

$updateset[] = "privacy = '$privacy'";
*/

if (is_valid_id($country))
  $updateset[] = "country = $country";

//$updateset[] = "timezone = $timezone";
//$updateset[] = "dst = '$dst'";
$updateset[] = "info = " . sqlesc($info);
$updateset[] = "acceptpms = " . sqlesc($acceptpms);
$updateset[] = "deletepms = '$deletepms'";
$updateset[] = "savepms = '$savepms'";
$updateset[] = "notifs = '$notifs'";
$updateset[] = "avatar = " . sqlesc(@$avatar);
$updateset[] = "avatars = '$avatars'";
if (@$_POST['resetpasskey'])
	{
	if (@$_POST['resetpasskey'])
		{
		$user_id = $CURUSER['id'];
		$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
		$row = mysqli_fetch_array($res);
		if ($row)
			{
			$passkey = md5($row['username'].get_date_time().$row['passhash']);
			mysqli_query($con_link, "UPDATE users SET passkey='$passkey' WHERE id=$row[id]");
			}
		}
	}

$urladd = "";

/*
if ($changedemail)
	{
	$sec = mksecret();
	$hash = md5($sec);
//	$hash = md5($sec . $email . $sec);
	$obemail = urlencode($email);
	$updateset[] = "editsecret = " . sqlesc($sec);
	$thishost = $_SERVER["HTTP_HOST"];
	$thisdomain = preg_replace('/^www\./is', "", $thishost);
	$body = <<<EOD
U heeft verzocht dat in uw gebruikersprofiel {$CURUSER["username"]}
op $SITE_NAME moet worden gewijzigd met dit e-mailadres ($email) als uw contactadres.

Als u deze aanvraag niet heeft gedaan dan kunt u dit bericht negeren. De aanvraag
is gedaan van af de computer met het ip-nummer {$_SERVER["REMOTE_ADDR"]}.
Gaarne op dit bericht niet antwoorden of reageren.

Om de verandering plaats te laten vinden druk dan op de onderstaande link:

$DEFAULTBASEURL/confirmemail.php?id={$CURUSER["id"]}&md5=$hash&email=$obemail

Uw e-mailadres zal dan daarna in uw profiel worden weergegeven.

Met vriendelijk groet,

TorrentMedia.org

EOD;

	mail($email, "$SITE_NAME profiel wijziging", $body, "From: $from", "-f$SITEEMAIL");

	$urladd .= "&mailsent=1";
}
*/


$emailnotif = @$_POST["emailnotif"];

$notifs .= ($emailnotif == 'yes' ? "[email]" : "");
$r = mysqli_query($con_link, "SELECT id FROM categories") or sqlerr();
$rows = mysqli_num_rows($r);
for ($i = 0; $i < $rows; ++$i)
{
	$a = mysqli_fetch_assoc($r);
	if (@$_POST["cat$a[id]"] == 'yes')
	  $notifs .= "[cat$a[id]]";
}$action1 = (string)@$_POST['action1'];if ($action1 == 'skype_name')	{	$skype_name = (string)@$_POST['skype_name'];	if (!$skype_name)	site_error_message("Foutmelding", "Niets ontvangen om te verwerken.");	mysqli_query($con_link, "UPDATE users SET skype_name = '". $skype_name ."' WHERE id =  '". $CURUSER["id"] ."'") or sqlerr(__FILE__, __LINE__);	}	
$updateset[] = 'notifs_donor = "'.$notifs.'"';
//var_dump("UPDATE users SET " . implode(",", $updateset) . " WHERE id = " . $CURUSER["id"]);
mysqli_query($con_link, "UPDATE users SET " . implode(",", $updateset) . " WHERE id = " . $CURUSER["id"]) or sqlerr(__FILE__,__LINE__);

header("Location: $DEFAULTBASEURL/my.php?edited=1" . $urladd);

?>