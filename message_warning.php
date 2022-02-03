<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de moderator en hoger.");

$warnid = @$_GET["warnid"];
$warnid = 0 + $warnid;
$userid = @$_GET["userid"];
$userid = 0 + $userid;
$torrentid = @$_GET["torrentid"];
$torrentid = 0 + $torrentid;
$referer = @$_GET["referer"];
$ratio = @$_GET["ratio"];

if (!$warnid)
	site_error_message("Foutmelding", "Geen waarschuwings id gevonden.");
if (!$userid)
	site_error_message("Foutmelding", "Geen gebruikers id gevonden.");
if (!$torrentid)
	site_error_message("Foutmelding", "Geen torrent id gevonden.");

	$res = mysqli_query($con_link, "SELECT name FROM torrents WHERE id = $torrentid") or sqlerr();
	$row = mysqli_fetch_array($res);
	$tnaam = $row['name'];

	$sender = $CURUSER[id];

if ($warnid == 1)
	$message = "Hallo " . get_username($userid) . ",\n\n";
	$message .= "Uit ons waarschuwingssysteem is gebleken dat u torrent $tnaam niet meer aan het delen bent.\n";
	$message .= "U heeft torrent $tnaam ontvangen met een torrent ratio van $ratio en wij hanteren als regel een ratio van 1.\n";
	$message .= "Daar het geven van dit bericht alleen een verzoek is om weer te gaan delen, ontvangt u hier geen nog geen officiele waarschuwing voor (mits u deze al heeft ontvangen).\n";
	$message .= "Indien dit gedrag regelmatig bij u wordt geconstateerd zal u een officiele waarschuwing kunnen ontvangen en dat kan een uitsluiting tot gevolg hebben.\n";
	$message .= "Het is voor ons niet mogelijk om te kijken wat de exacte reden is waarom u niet meer aan het delen bent, maar wij gaan er vanuit dat u deze\n";
	$message .= "torrent weer gaat delen zodat ook de andere gebruikers deze kunnen ontvangen.\n";
	$message .= "Mocht u reeds aan het delen zijn dan kunt u dit bericht als niet verzonden beschouwen.\n\n";
	$message .= "Met vriendelijke groet,\n";
	$message .= get_username($sender);
	$message = sqlesc($message);

	$added = sqlesc(get_date_time());
	
	$def = mysqli_query($con_link, "SELECT * FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
	$defs = mysqli_fetch_array($def);
	$descr = "Bericht gehad voor Pakken en Wegwezen bij torrent ".$tnaam." door ".get_username($CURUSER['id']).".";
	$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\n" . $defs['modcomment']);
	mysqli_query($con_link, "UPDATE users SET modcomment = $modcomment WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
	
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES ($sender, $userid, $message, $added)") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "INSERT INTO warn_pm_torrent (sender, receiver, torrent, added) VALUES ($sender, $userid, $torrentid, $added)") or sqlerr(__FILE__, __LINE__);
	
if ($referer)
	header("Location: $referer");
else
	header("Location: $BASEURL/");

?>