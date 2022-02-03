<?php if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];?>
<?php



$proxy_headers = array(
    'HTTP_VIA',
    'HTTP_X_FORWARDED',
    'HTTP_FORWARDED',
    'HTTP_CLIENT_IP',
    'HTTP_FORWARDED_FOR_IP',
    'VIA',
    'X_FORWARDED_FOR',
    'FORWARDED_FOR',
    'X_FORWARDED',
    'FORWARDED',
    'CLIENT_IP',
    'FORWARDED_FOR_IP',
    'HTTP_PROXY_CONNECTION'
);
foreach($proxy_headers as $x){
    if (isset($_SERVER[$x])) { 
        die("Zet uw vpn uit!");
         
 }
}

$key = 'J1qB44KfbxVkeJJKzznCgq20NxUsQepf';
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_CLIENT_IP'];
        $strictness = 1;
        $result = json_decode(file_get_contents(sprintf('https://ipqualityscore.com/api/json/ip/%s/%s?strictness=%s',
        $key, $ip, $strictness)), true);
        if($result !== null){

            if(isset($result['active_vpn']) && $result['active_vpn'] == true){
        die("Zet uw vpn uit!");

              
            }
        }


require_once("include/secrets.php");
require_once("include/bittorrent.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
dbconn();
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
$res = mysqli_query($con_link, "SELECT COUNT(*) FROM users");
$arr = mysqli_fetch_row($res);

if ($arr[0] >= $maxusers)
        site_error_message("Foutmelding", "Sorry, leden aantal bereikt. Probeer het later nog eens.");

if (!mkglobal("wantusername:wantpassword:passagain:email"))
        die();

function bark($msg) {
        bark("Registreren mislukt", $msg);

}

function validusername($username)
{
        if ($username == "")
          return false;

        // The following characters are allowed in user names
        $allowedchars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@-_.";

        for ($i = 0; $i < strlen($username); ++$i)
          if (strpos($allowedchars, $username[$i]) === false)
            return false;

        return true;
}

function isportopen($port)
{
        global $HTTP_SERVER_VARS;
        
        $sd = @fsockopen($HTTP_SERVER_VARS["REMOTE_ADDR"], $port, $errno, $errstr, 1);
        if ($sd)
        {
                fclose($sd);
                return true;
        }
        else
                return false;
}


if (empty($wantusername) || empty($wantpassword) || empty($email))
        bark("Geen velden leeg laten.");

if (strlen($wantusername) > 12)
        bark("Sorry, gebruikersnaam is te lang maximaal 12 letters/cijfers.");

if (@$wantpassword != $passagain)
        bark("De wachtwoorden komen niet overeen, probeer het nogmaals.");

if (strlen($wantpassword) < 6)
        bark("Sorry, wachtwoord is te kort minimaal 6 letters/cijfers en maximaal 40.");

if (strlen($wantpassword) > 40)
        bark("Sorry, wachtwoord is te lang, maximaal 40 letters/cijfers en minimaal 6.");

if ($wantpassword == $wantusername)
        bark("Sorry, wachtwoord mag niet hetzelfde zijn als uw gebruikersnaam.");

if (!validemail($email))
        bark("Dat lijkt niet op een goed E-mailadres.");

if (!validusername($wantusername))
        bark("Fout in gebruikersnaam.");
//---------------------------------------------------------------
//f (scheld($wantusername))
//bark("Fout deze naam is niet toegestaan als gebruikersnaam.");
//---------------------------------------------------------------   

// make sure user agrees to everything...
if (@$_POST["rulesverify"] != "yes" || @$_POST["faqverify"] != "yes" || @$_POST["ageverify"] != "yes")
      site_error_message("Registreren mislukt", "Sorry, u bent niet geschikt om hier lid te worden.");


// check if email addy is already in use
$a = (@mysqli_fetch_row(@mysqli_query($con_link, "select count(*) from users where email='$email'"))) or die(mysqli_error());
if ($a[0] != 0)
  bark("Het door u ingevoerde E-mailadres $email is al eens gebruikt hier.");

/*
// do simple proxy check
if (isproxy())
        bark("You appear to be connecting through a proxy server. Your organization or ISP may use a transparent caching HTTP proxy. Please try and access the site on <a href=http://torrentbits.org:81/signup.php>port 81</a> (this should bypass the proxy server). <p><b>Note:</b> if you run an Internet-accessible web server on the local machine you need to shut it down until the sign-up is complete.");
*/

$verification = "automatisch";



$secret = $PASSWORD_HASH;
$wantpasshash = md5($secret . $wantpassword . $secret);
$editsecret = $PASSWORD_HASH;

$ret = mysqli_query($con_link, "INSERT INTO users (username, passhash, secret, editsecret, email, status, added) VALUES (" .
                implode(",", array_map("sqlesc", array($wantusername, $wantpasshash, $secret, $editsecret, $email, 'pending'))) .
                ",'" . get_date_time() . "')");

if (!$ret) {
        if (mysqli_errno($con_link) == 1062)
                bark("Gebruikersnaam bestaat al!");
        bark("borked");
}

$id = mysqli_insert_id($con_link);

write_log("User account $id ($wantusername) was created");

$psecret = md5($editsecret);

$body = <<<EOD
U heeft een account aangevraagd op $SITE_NAME en u heeft daarvoor
het volgende E-mailadres gebruikt: ($email) 

Als u dit niet heeft gedaan kunt u deze e-mail als niet verzonden beschouwen.
De persoon die uw emailadres heeft gebruikt had het IP adres {$_SERVER["REMOTE_ADDR"]}.

Beantwoordt deze email AUB niet.

Om uw inschrijving te bevestigen, moet u de volgende link volgen:

$DEFAULTBASEURL/confirm.php?id=$id&secret=$psecret

Als u dit gedaan heeft, is uw account gebruiksklaar, als u dit niet doet
wordt uw account binnen enkele dagen verwijderd. We moedigen u ook aan om de
REGELS te lezen voordat u gebruikt maakt van uw account op $SITE_NAME

EOD;

$sitebody = <<<EOD
Nieuwe registratie :
Gebruiker    : $wantusername
E-mailadres : $email
Ip-nummer    : {$_SERVER["REMOTE_ADDR"]}
EOD;
@mail($email, "$SITE_NAME gebruiker registratie", $body, "Van: $EMAIL_SITE", "-f$EMAIL_SITE");
$added = sqlesc(get_date_time());
$welcome = sqlesc ("Welkom op  $SITE_NAME, We zijn blij dat je je bij ons hebt aangemeld
De site voor:
High quality Nederlands downloads.
Net als bij vele collega-sites ben je verplicht om 1 op 1 te delen.
Op $SITE_NAME is het ook verplicht om verbindbaar te zijn en DHT uit te zetten.
Als je een van beide niet bent kun je niet down/uploaden van de tracker.
U zult dit dan eerst in orde moeten maken om volledig gebruik te kunnen maken van de site.
Mocht je vragen hebben schroom dan niet om je moderator hiermee te belasten.
Daar zijn ze tenslotte voor.
Rest ons nog u veel plezier te wensen van en bij $SITE_NAME
Staff $SITE_NAME.");

mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES(0, $id, $welcome, $added)") or sqlerr(__FILE__, __LINE__);

if (@$verification == 'automatisch'){
        site_header();
       // stdmsg("Einde Registratie!", "Klik <a href=\"$DEFAULTBASEURL/confirm.php?id=$id&secret=$psecret\">hier</a> om de registratie te voltooien, bedankt!",false);
        stdmsg("Registratie gelukt!", "Binnen 24 uur bekijken wij uw aanvraag, indien vantoepassing keuren wij deze goed of af. Bedankt!",false);
  site_footer();
        exit;
}else{

$subject = 'gebruiker registratie';
$headers = 'From: no-reply@torrentmedia.org' . "\r\n" .
    'Reply-To: info@torrentmedia.org' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($email, $subject, $body, $headers);

//mail($email, "$SITE_NAME gebruiker registratie", $body, "Van: $EMAIL_SITE", "-f$EMAIL_SITE");
//sent_mail($email,$SITENAME,$SITEEMAIL,"$SITENAME user registration confirmation",$body,"signup",false);
header("Refresh: 0; url=ok.php?type=signup&email=" . urlencode($email));
}
?>
