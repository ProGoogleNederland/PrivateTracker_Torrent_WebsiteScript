<?php
  require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
  dbconn();
  loggedinorreturn();

  if ($_SERVER["REQUEST_METHOD"] != "POST")
    site_error_message("Foutmelding", "Geen informatie gevonden om te verwerken.");

  $n_pms = @$_POST["n_pms"];
  if ($n_pms)
  {  			                                                      //////  MM  ///
    if (get_user_class() < UC_ADMINISTRATOR)
	  site_error_message("Foutmelding", "Toegang geweigerd");

    $msg = trim($_POST["msg"]);
		if (!$msg)
	  	site_error_message("Foutmelding","Verkeerder informatie ontvangen");

    $sender_id = ($_POST['sender'] == 'system' ? 0 : $CURUSER['id']);

    $from_is = @$_POST['pmees'];

    $subject = @$_POST['subject'];

    $query = "INSERT INTO messages (sender, receiver, added, subject, msg, poster) ".
             "SELECT $sender_id, u.id, '" . get_date_time() . "', ".sqlesc($subject)."," . sqlesc($msg) .
             ", $sender_id " . $from_is;

    mysqli_query($con_link, $query) or sqlerr(__FILE__, __LINE__);
    $n = mysqli_affected_rows($con_link);

	///// Opslaan massa berichten, door Programmeur op 22 november 2006
	$bericht = sqlesc($msg);
	$datum_verzenden =sqlesc(get_date_time());
	$user_id_sender = $CURUSER['id'];
	mysqli_query($con_link, "INSERT INTO massa_berichten (sender, aantal, msg, added, user_id_sender) VALUES ($sender_id, $n_pms, $bericht, $datum_verzenden, $user_id_sender)") or sqlerr(__FILE__, __LINE__);
	///// Opslaan massa berichten, door Programmeur op 22 november 2006

    $comment = @$_POST['comment'];
    $snapshot = @$_POST['snap'];

    // add a custom text or stats snapshot to comments in profile
    if ($comment || $snapshot)
    {
	    $res = mysqli_query($con_link, "SELECT u.id, u.uploaded, u.downloaded, u.modcomment ".$from_is) or sqlerr(__FILE__, __LINE__);
	    if (mysqli_num_rows($res) > 0)
	    {
	      $l = 0;
	      while ($user = mysqli_fetch_array($res))
	      {
	        unset($new);
	        $old = $user['modcomment'];
	        if ($comment)
	          $new = $comment;
	        if ($snapshot)
	        {
	          $new .= ($new?"\n":"") .
	            "MMed, " . gmdate("Y-m-d") . ", " .
	            "UL: " . mksizegb($user['uploaded']) . ", " .
	            "DL: " . mksizegb($user['downloaded']) . ", " .
	            "r: " . ratios($user['uploaded'],$user['downloaded'], False) . " - " .
	            ($_POST['sender'] == "system"?"System":$CURUSER['username']);
	        }
	      	$new .= $old?("\n".$old):$old;
		      mysqli_query($con_link, "UPDATE users SET modcomment = " . sqlesc($new) . " WHERE id = " . $user['id'])
		        or sqlerr(__FILE__, __LINE__);
	  	    if (mysqli_affected_rows($con_link))
	    	    $l++;
	      }
	    }
    }
  }
  else
  {               																							//////  PM  ///
  	$receiver = @$_POST["receiver"];
	  $origmsg = @$_POST["origmsg"];
	  $save = @$_POST["save"];
 	  $returnto = @$_POST["returnto"];

	  if (!is_valid_id($receiver) || ($origmsg && !is_valid_id($origmsg)))
	  	site_error_message("Foutmelding","Invalid ID");

	  $msg = trim($_POST["msg"]);
	  $subject = trim(@$_POST["subject"]);
	  if (!$msg)
	    site_error_message("Foutmelding","Geen gegevens gevonden");

	  $location = ($save == 'yes') ? "both" : "in";

	  $res = mysqli_query($con_link, "SELECT acceptpms, notifs, UNIX_TIMESTAMP(last_access) as la FROM users WHERE id=$receiver") or sqlerr(__FILE__, __LINE__);
	  $user = mysqli_fetch_assoc($res);
	  if (!$user)
	    site_error_message("Foutmelding", "Geen gebruiker met id $receiver gevonden.");

	  //Make sure recipient wants this message
		if (get_user_class() < UC_ADMINISTRATOR)
		{
    	if ($user["acceptpms"] == "yes")
	    {
	      $res2 = mysqli_query($con_link, "SELECT * FROM blocks WHERE userid=$receiver AND blockid=" . $CURUSER["id"]) or sqlerr(__FILE__, __LINE__);
	      if (mysqli_num_rows($res2) == 1)
	        site_error_message("Geweigerd", "Deze gebruiker heeft u geblokkeerd voor alle berichten");
	    }
	    elseif ($user["acceptpms"] == "friends")
	    {
	      $res2 = mysqli_query($con_link, "SELECT * FROM friends WHERE userid=$receiver AND friendid=" . $CURUSER["id"]) or sqlerr(__FILE__, __LINE__);
	      if (mysqli_num_rows($res2) != 1)
	        site_error_message("Geweigerd", "De gebruiker accepteerd alleen berichten uit zijn vriendenlijst");
	    }
	    elseif ($user["acceptpms"] == "no")
	        site_error_message("Geweigerd", "Deze gebruiker heeft iedereen geblokkeerd voor berichten");
	  }

	  mysqli_query($con_link, "INSERT INTO messages (poster, sender, receiver, added, subject, msg, location) VALUES(" . $CURUSER["id"] . ", " .
	  $CURUSER["id"] . ", $receiver, '" . get_date_time() . "', " .
	  sqlesc($subject) . ", " .
	  sqlesc($msg) . ", " . sqlesc($location) . ")") or sqlerr(__FILE__, __LINE__);

	  if (strpos($user['notifs'], '[pm]') !== false)
	  {
	    if (gmtime() - $user["la"] >= 300)
	    {
	    $username = $CURUSER["username"];
$body = <<<EOD
U heeft een bericht ontvangen van $username!

U kunt via onderstaande link direct naar het bericht gaan, inloggen wel noodzakelijk.

$DEFAULTBASEURL/inbox.php

--
$SITE_NAME
EOD;
	    @mail($user["email"], "You have received a PM from " . $username . "!",
	    	$body, "From: $SITEEMAIL", "-f$SITEEMAIL");
	    }
	  }
	  $delete = @$_POST["delete"];

	  if ($origmsg)
	  {
      if ($delete == "yes")
      {
	      // Make sure receiver of $origmsg is current user
	      $res = mysqli_query($con_link, "SELECT * FROM messages WHERE id=$origmsg") or sqlerr(__FILE__, __LINE__);
	      if (mysqli_num_rows($res) == 1)
	      {
	        $arr = mysqli_fetch_assoc($res);
	        if ($arr["receiver"] != $CURUSER["id"])
	          site_error_message("w00t","This shouldn't happen.");
	        if ($arr["location"] == "in")
	        	mysqli_query($con_link, "DELETE FROM messages WHERE id=$origmsg AND location = 'in'") or sqlerr(__FILE__, __LINE__);
	        elseif ($arr["location"] == "both")
	        	mysqli_query($con_link, "UPDATE messages SET location = 'out' WHERE id=$origmsg AND location = 'both'") or sqlerr(__FILE__, __LINE__);
	      }
      }
   	  if (!$returnto)
   	  	$returnto = "$BASEURL/inbox.php";
	  }

    if ($returnto)
    {
      header("Location: $returnto");
      die;
    }
	}
	site_header();
	sitemsg("Gelukt", (($n_pms > 1) ? "$n berichten zijn " : "Bericht is").
	" verzonden." . ($l ? " $l profiel mod-comment" . (($l>1) ? "s zijn" : " is") . " gewijzigd" : ""));
	print "<br>";
	site_footer();
	exit;
?>