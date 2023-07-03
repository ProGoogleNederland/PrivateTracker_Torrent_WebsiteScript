<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();

if (!$RECOVEREMAIL)
	$RECOVEREMAIL = $EMAIL_NOREPLY;

if (!$SITE_NAME)
	$SITE_NAME = $SITE_NAME;

//if (get_user_class() < UC_GOD)
//	site_error_message("Foutmelding", "Pagina is tijdelijk uitgeschakeld wordt aan gewerkt momenteel.");

if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
	$email = trim((string)@$_POST["email"]);
	//var_dump("SELECT * FROM users WHERE email=".sqlesc($email)." LIMIT 1");
	if (!$email)
		site_error_message("Foutmelding", "U dient een E-mailadres in te voeren");
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE email=".sqlesc($email)." LIMIT 1") or sqlerr(__FILE__, __LINE__);
	$arr = mysqli_fetch_assoc($res);
	if (!$arr)
		site_error_message("Foutmelding", "Het E-mailadres <b>".htmlspecialchars($email)."</b> is niet gevonden in de database.\n");	
	$sec = $PASSWORD_HASH;

	mysqli_query($con_link, "UPDATE users SET editsecret=" . sqlesc($sec) . " WHERE id=" . $arr["id"]) or sqlerr();

	if (!mysqli_affected_rows($con_link))
		site_error_message("Foutmelding", "Database fout. Neem contact op met een van uw administrators.");
	
	$hash = md5($sec . $email . $sec);

	$body = "Account herstel bericht van ".$SITE_NAME."\n\n";
	$body .= "Iemand, hopelijk u, heeft verzocht om het wachtwoord van een account te veranderen op ".$SITE_NAME.".\n\n";
	$body .= "Hiervoor is dit e-mailadres ($email) opgegeven, welke in onze database vermeld staat.\n\n";
	$body .= "Heeft u wel een account maar heeft u geen nieuw wachtwoord aangevraagd, negeer dit bericht dan.\n\n";
	$body .= "Als u dit niet heeft gedaan negeer dit bericht dan.\n\n";
	$body .= "Dit bericht niet beantwoorden alstublieft.\n\n";
	$body .= "Wilt u dit verzoek bevestigen, druk dan op de onderstaande snelkoppeling:\n";
	$body .= $DEFAULTBASEURL."/recover.php?id=".$arr["id"]."&secret=$hash\n\n";
	$body .= "Nadat u dit heeft gedaan, wordt wachtwoord hersteld en naar u terug gezonden.\n\n";
	$body .= "Met vriendelijk groet,\n";
	$body .= $SITE_NAME . "\n";

	@mail($arr["email"] , "$SITE_NAME wachtwoord wijzigings bevestiging", $body, "From: ".$SITE_NAME." <".$RECOVEREMAIL.">", "-f$RECOVEREMAIL")
		or site_error_message("Foutmelding", "Kan geen e-mail verzenden. Neem contact op met een van uw administrators.");
		
	site_error_message("Verzenden van de e-mail is gelukt", "Een bevestiging e-mail is verstuurd naar <br><br><font size=2><b>$email</b></font><br><br>Een paar minuten geduld voordat de e-mail bij u is aan is gekomen.");
	}
elseif(@$_GET)
	{
	$id = (int)@$_GET["id"];
	$md5 = (string)@$_GET["secret"];

	if (!$id){
	
		echo "Geen idee wat u probeerde, doe maar niet meer. Uw gegevens zijn gelogd.";
	return;}
	
	$res = mysqli_query($con_link, "SELECT username, email, passhash, editsecret FROM users WHERE id = $id");
	$arr = mysqli_fetch_array($res);
	echo $arr['email'];
	if (!$arr){
		site_error_message("Foutmelding", "Het E-mailadres <b>".htmlspecialchars($email)."</b> is niet gevonden in de database.\n");
	}
	
	
	$sec = $PASSWORD_HASH;
	$email = $arr["email"];

	
	if ($md5 != md5($sec . $email .  $sec)){
	
	echo"Geen idee wat u probeerde, doe maar niet meer. Uw gegevens zijn gelogd.";
	return;
	}

	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

	
	$newpassword = "";
	for ($i = 0; $i < 10; $i++)
		$newpassword .= $chars[mt_rand(0, strlen($chars) - 1)];

	$sec = $PASSWORD_HASH;
	$newpasshash = md5($sec . $newpassword . $sec);
	mysqli_query($con_link, "UPDATE users SET secret=" . sqlesc($sec) . ", editsecret='', passhash=" . sqlesc($newpasshash) . " WHERE id=$id AND editsecret=" . sqlesc($arr["editsecret"]));

	if (!mysqli_affected_rows($con_link))
		site_error_message("Foutmelding", "Niet mogelijk om de gebruikers gegevens te wijzigen.<br><br>Neem contact op met een van uw administrators.");

	$body = "Hallo ".htmlspecialchars($arr["username"]).".\n\n";
	$body .= "Zoals u ons verzocht hebben wij voor een nieuw wachtwoord voor u aangemaakt.\n\n";
	$body .= "De volgende gegevens zijn in onze database opgenomen.\n\n";
	$body .= "=================================================\n";
	$body .= "Inlognaam: " . $arr["username"] . "\n";
	$body .= "Wachtwoord: " . $newpassword . "\n";
	$body .= "=================================================\n";
	$body .= "U kunt zich aanmelden op ".$DEFAULTBASEURL."/login.php\n\n";
	$body .= "Met vriendelijk groet,\n";
	$body .= $SITE_NAME . "\n";

	@mail($arr["email"] , "$SITE_NAME account gegevens", $body, "From: ".$SITE_NAME." <".$RECOVEREMAIL.">", "-f$RECOVEREMAIL")
		or site_error_message("Foutmelding", "Kan geen e-mail verzenden. Neem contact op met een van uw administrators.");

	site_error_message("Gelukt", "De nieuwe gegevens zijn verstuurd naar <b>$email</b>.<br><br>Een paar minuten geduld voordat de e-mail bij u is aan is gekomen.");
	}
else
	{
print "<meta name=\"googlebot\" content=\"noindex, nofollow, disallow\">";
print "<meta name=\"robots\" content=\"noindex, nofollow, disallow\">";
	site_header("Account herstel");
	page_start(98);
	tabel_top("Gebruik onderstaand formulier om uw inlog gegevens te herstellen.","center");
	tabel_start();
	print "<br><br>";
	print "<form method=post action=recover.php>";
	print "<table border=1 cellspacing=0 cellpadding=10>";
	print "<tr><td class=rowhead>Geregistreerd E-mailadres</td>";
	print "<td><input type=text size=30 name=email></td></tr>";
	print "<tr><td colspan=2 align=center><input type=submit style='font-size:11px;height:28px;width:150px;color:white;font-weight:bold' value='Verzoek verzenden'></form></td></tr>";
	print "</table>";
	print "<br>";
	tabel_einde();
	page_einde();
	site_footer();
	}
?>
