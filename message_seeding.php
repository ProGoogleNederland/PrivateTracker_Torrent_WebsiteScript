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
$userid = 0 + $_GET["userid"];
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
	$sendermsg = 0;

if ($warnid == 1)
	{
	$message = "Hallo " . get_username($userid) . ",\n\n";
	$message .=	"Bij deze vraag ik u om te stoppen met delen/seeden op torrent $tnaam,\n";
	$message .=	"om andere gebruikers ook een kans te geven op deze torrent een goede ratio te kunnen halen.\n\n";
	$message .=	"Gezien u nu op deze torrent en ratio van $ratio heeft.\n\n";
	$message .=	"Met vriendelijke groet,\nonzesite";
	$message =	sqlesc($message);
	}

	$added = sqlesc(get_date_time());

	$def = mysqli_query($con_link, "SELECT * FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
	$defs = mysqli_fetch_array($def);
	if ($defs)
		{
		$descr = convertdatum(get_date_time()) . " - Bericht gehad voor Overseeden bij torrent ".$tnaam." door ".get_username($CURUSER['id']).".";
		$modcomment = sqlesc($descr . "\n" . $defs['modcomment']);

		mysqli_query($con_link, "UPDATE users SET modcomment = $modcomment WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
	
		mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES ($sendermsg, $userid, $message, $added)") or sqlerr(__FILE__, __LINE__);
		mysqli_query($con_link, "INSERT INTO warn_pm_seeding (sender, receiver, torrent, added) VALUES ($sender, $userid, $torrentid, $added)") or sqlerr(__FILE__, __LINE__);
		}
	
if ($referer)
	header("Location: $referer");
else
	header("Location: $BASEURL/");

?>