<?
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

function puke($text = "Oops er ging iets niet helemaal goed")
	{
  	site_error_message("Foutmelding", $text);
	}

if (get_user_class() < UC_MODERATOR)
	puke("U heeft hier niets te zoeken");

$action = $_POST["action"];

if ($action == "confirmuser")
	{
	$userid = 0 + $_POST["userid"];
	$returnto = $_POST["returnto"];
	
	mysqli_query($con_link, "UPDATE users SET status='confirmed' WHERE id=" . $userid) or sqlerr(__FILE__, __LINE__);
	
	if (!$returnto)
		$returnto = 'index.php';
	
	header("Location: $BASEURL/$returnto");
	die;
	}
	
if ($action == "edituser")
	{
	$userid = 0 + @$_POST["userid"];
	$warned = @$_POST["warned"];
	$warnlength = 0 + $_POST["warnlength"];
	$warnreason = @$_POST["warnreason"];
	$warnpm = @$_POST["warnpm"];
	$donor = @$_POST["donor"];
   //var_dump("SELECT * FROM users WHERE id='$userid'");
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id='".$userid."'") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);

  	if ($row['donor'] == 'yes' && $warnlength > 0)
		site_error_message("Foutmelding", "Donateurs kunnen niet gewaarschuwd worden.");
  
 	if ($warnreason == 0)
		{
		$warnreason = "Hallo " . get_username($userid) . ",\n\n";
		$warnreason .= "U heeft een waarschuwing gehad voor 'Pakken en wegwezen' (Hit & Run).\n";
		$warnreason .= "Hetgeen inhoud dat u een torrent heeft gedownload en niet de moeite heeft genomen om te blijven delen voor andere gebruikers.\n";
		$warnreason .= "Bij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\n";
		$warnreason .= "Tevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\n";
		$warnreason .= "Met vriendelijke groet,\n";
		$warnreason .= "Staff van $SITE_NAME\n";
		$warnmod = "Pakken en wegwezen.";
		}
	if ($warnreason == 1)
		{
		$warnreason = "Hallo " . get_username($userid) . ",\n\n";
		$warnreason .= "U heeft een waarschuwing gehad voor 'Lage Ratio' (Hit & Run).\n";
		$warnreason .= "Hetgeen inhoud dat u een meer Gb ontvangt als wenst te delen aan andere gebruikers.\n";
		$warnreason .= "Ratio is de deling van hetgeen u heeft verzonden door hetgeen u heeft ontvangen.\n";
		$warnreason .= "U kunt dit verbeteren doormiddel van te blijven delen (seeden) na het downloaden totdat uw ratio weer goed is.\n";
		$warnreason .= "Een lage ratio betekend ook dat u minder torrents tergelijkertijd mag gebruiken.\n";
		$warnreason .= "Bij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\n";
		$warnreason .= "Tevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\n";
		$warnreason .= "Met vriendelijke groet,\n";
		$warnreason .= "Staff van $SITE_NAME\n";
		$warnmod = "Lage ratio.";
		}
	if ($warnreason == 2)
		{
		$warnreason = "Hallo " . get_username($userid) . ",\n\n";
		$warnreason .= "U heeft een waarschuwing gehad voor 'Overseeden'.\n";
		$warnreason .= "Hetgeen betekend dat u blijt delen (seeden) op een of meerdere torrents waardoor u het voor de gebruikers met.\n";
		$warnreason .= "een slechte ratio moeilijk of onmogelijk wordt hun ratio te verbeteren.\n";
		$warnreason .= "Bij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\n";
		$warnreason .= "Tevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\n";
		$warnreason .= "Met vriendelijke groet,\n";
		$warnreason .= "Staff van $SITE_NAME\n";
		$warnmod = "Overseeden.";
		}
	if ($warnreason == 3)
		{
		$warnreason = "Hallo " . get_username($userid) . ",\n\n";
		$warnreason .= "U heeft een waarschuwing gehad voor 'Gb verschil'.\n";
		$warnreason .= "Hetgeen betekend dat u meer wenst te ontvangen als te delen aan andere gebruikers.\n";
		$warnreason .= "Dit staat los van het door u opgebouwde ratio.\n";
		$warnreason .= "Ratio is de deling van hetgeen u heeft verzonden door hetgeen u heeft ontvangen.\n";
		$warnreason .= "Bij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\n";
		$warnreason .= "Tevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\n";
		$warnreason .= "Met vriendelijke groet,\n";
		$warnreason .= "Staff van $SITE_NAME\n";
		$warnmod = "Gb verschil.";
		}
	if ($warnreason == 4)
		{
		$warnreason = "Hallo " . get_username($userid) . ",\n\n";
		$warnreason .= "U heeft een waarschuwing gehad voor 'Gedrag'.\n";
		$warnreason .= "Deze algemene waarschuwing is voor taal gebruik tegen staff leden en of andere gebruikers in torrentcommentaar, forum, pm berichten of de chat.\n";
		$warnreason .= "Bij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\n";
		$warnreason .= "Tevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\n";
		$warnreason .= "Met vriendelijke groet,\n";
		$warnreason .= "Staff van $SITE_NAME\n";
		$warnmod = "Gedrag.";
		}

	$modcomment = $_POST["modcomment"];
	$nzbunrestr = $_POST["nzbunrestr"];
	
	// NZB Unrestricted access:  
if (get_user_class() >= UC_ADMINISTRATOR)
{  
    if ($nzbunrestr != $curnzbunrestr)
    {
        if ($nzbunrestr == 'yes')
        {
            $modcomment = gmdate("Y-m-d") . " - Unrestricted NZB Access manually granted by " . $CURUSER['username'] . ".\n" . $modcomment;
        }
        else
        {
            $modcomment = gmdate("Y-m-d") . " - Unrestricted NZB Access manually revoked by " . $CURUSER['username'] . ".\n" . $modcomment;
        }
    }
}

	if (!is_valid_id($userid))
    	site_error_message("Foutmelding", "Foutief gebruiker ID.");

	$res = mysqli_query($con_link, "SELECT warned, username, class, uploaded, downloaded, nzbunrestr FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
	$arr = mysqli_fetch_assoc($res) or puke();
	//var_dump($arr);
	$curclass = $arr["class"];
	$curwarned = $arr["warned"];
	$curnzbunrestr = $arr["nzbunrestr"];
	$uploaded = $arr["uploaded"];
	$downloaded = $arr["downloaded"];

	if ($curclass >= get_user_class())
		puke();

	if ($warned && $curwarned != $warned)
		{
		$updateset[] = "warned = " . sqlesc($warned);
		$updateset[] = "warneduntil = '0000-00-00 00:00:00'";
		if ($warned == 'no')
			{
			$modcomment = convertdatum(gmdate("Y-m-d H:i:s")) . " - Waarschuwing verwijderd door " . $CURUSER['username'] . ".\nMomentopname: Ontvangen: " . mksize($downloaded) . " - Verzonden: " . mksize($uploaded) . " - Ratio: "  . get_ratio($userid) . "\n\n". $modcomment;
			$msg = sqlesc("Uw waarschuwing is verwijderd door " . $CURUSER['username'] . ".");
			$logmsg = "De waarschuwing van <a href=userdetails.php?id=" . $userid . ">" . get_username($userid) . "</a> is verwijderd door <a href=userdetails.php?id=" . $CURUSER['id'] . ">" . $CURUSER['username'] . "</a>.";
			}
		$added = sqlesc(get_date_time());
		mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES (0, $userid, $msg, $added)") or sqlerr(__FILE__, __LINE__);
		$updateset[] = "warnedby = 0";
		write_log_warning($logmsg);
		}
	elseif ($warnlength)
		{
		$warneduntil = get_date_time(time() + $warnlength * 3600);
		$dur = $warnlength . " uur";
		$modcomment = convertdatum(date("Y-m-d H:i:s")) . " - Gewaarschuwd voor $dur door " . $CURUSER['username'] .  ".\nReden waarschuwing: $warnmod $warnpm \nMomentopname: Ontvangen: " . mksize($downloaded) . " - Verzonden: " . mksize($uploaded) . " - Ratio: "  . get_ratio($userid) . "\n\n" . $modcomment;
		$logmsg = "<a href=userdetails.php?id=" . $userid . ">" . get_username($userid) . "</a> is gewaarschuwd door <a href=userdetails.php?id=" . $CURUSER['id'] . ">" . $CURUSER['username'] . "</a> voor " . $warnmod;
		$msg = sqlesc("$warnreason $warnpm");
		$updateset[] = "warneduntil = '$warneduntil'";
		$updateset[] = "warnedby = " . $CURUSER['id'];
		write_log_warning($logmsg);
		$added = sqlesc(get_date_time());
		$senderid = $CURUSER['id'];
		mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES ($senderid, $userid, $msg, $added)") or sqlerr(__FILE__, __LINE__);
		$updateset[] = "warned = 'yes'";
		}

	$updateset[] = "donor = " . sqlesc($donor);

	$updateset[] = "modcomment = " . sqlesc($modcomment);
	/*
	if (get_user_class() >= UC_ADMINISTRATOR) {
      $updateset[] = "nzbunrestr = " . sqlesc($nzbunrestr);
  	}
*/
	$uploaded = sqlesc($uploaded);
	$downloaded = sqlesc($downloaded);
	$dur = sqlesc($dur);
	$warnmod = sqlesc($warnmod);

	mysqli_query($con_link, "INSERT INTO warnings (userid, warned_by, warned_for, warned_time, date, uploaded, downloaded) VALUES ($userid, $senderid, $warnmod, $dur, NOW(), $uploaded, $downloaded)");

	mysqli_query($con_link, "UPDATE users SET  " . implode(", ", $updateset) . " WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
	$returnto = $_POST["returnto"];
	
	header("Location: $BASEURL/$returnto");
	die;
	}
puke();
?>