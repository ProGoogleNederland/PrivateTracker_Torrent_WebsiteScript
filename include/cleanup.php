<?php
require_once("secrets.php");
function opschonen_database()
	{
	global $CURUSER;
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);

	$datum = get_date_time();
	$user_id = $CURUSER['id'];

	$tijd = time() - (30*60); // ieder half uur

	$res = mysqli_query($con_link, "SELECT * FROM opschonen WHERE tijd > $tijd ORDER by tijd DESC LIMIT 1");
	$row = mysqli_fetch_array($res);
	if (!$row)
		{
		$huidige_tijd = time();
		mysqli_query($con_link, "INSERT INTO opschonen (user_id, added, tijd) VALUES ($user_id, NOW(), $huidige_tijd)");
		opschonen_bronnen();
		}
	}

function opschonen_messages()
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$system_message = time() - 86400 * 10;
	$all_message = time() - 86400 * 21;
	mysqli_query($con_link, "DELETE FROM messages WHERE sender='0' AND added < FROM_UNIXTIME($system_message)");
	mysqli_query($con_link, "DELETE FROM messages WHERE added < FROM_UNIXTIME($all_message)");
	mysqli_query($con_link, "OPTIMIZE TABLE messages");
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////
function autosystempm()
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	
	$system_message = time() - 86400 * 7;// 7 dagen 
//	$all_message = time() - 86400 * 21;
	mysqli_query($con_link, "DELETE FROM messages WHERE sender='0' AND added < FROM_UNIXTIME($system_message)");
	mysqli_query($con_link, "DELETE FROM messages WHERE added < FROM_UNIXTIME($all_message)");
	mysqli_query($con_link, "OPTIMIZE TABLE messages");
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
function opschonen_torrents()
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	
	$tijd = time() - 2*60*60;
	$res = mysqli_query($con_link, "SELECT * FROM torrents WHERE added < FROM_UNIXTIME($tijd)");
	while ($row = mysqli_fetch_assoc($res))
		{
		$torrentid = $row['id'];
		$ontvangen = get_row_count("peers", "WHERE torrent=$torrentid AND seeder='no'");
		$verzenden = get_row_count("peers", "WHERE torrent=$torrentid AND seeder='yes'");
		$aanwezig = floor((gmtime() - sql_timestamp_to_unix_timestamp($row["added"])) / 3600);
		if ($verzenden == 0 && $ontvangen == 0)
			{
			$torrentid = $row['id'];
			$filename = $row['filename'];
			deletetorrent($torrentid,$filename);
			write_log("Torrent ($row[name]) is verwijderd door het systeem, omdat dit een dode torrent was.");
			}
		}
    foreach(explode(".","peers.files.comments.ratings.thankyou.downloaded.downup.warn_pm_torrent") as $x)
	mysqli_query($con_link, "OPTIMIZE TABLE files");
	mysqli_query($con_link, "OPTIMIZE TABLE comments");
	mysqli_query($con_link, "OPTIMIZE TABLE ratings");
	mysqli_query($con_link, "OPTIMIZE TABLE thankyou");
	mysqli_query($con_link, "OPTIMIZE TABLE downloaded");
	mysqli_query($con_link, "OPTIMIZE TABLE downup");
	mysqli_query($con_link, "OPTIMIZE TABLE bookmarks");
	mysqli_query($con_link, "OPTIMIZE TABLE torrents");
	}

function opschonen_dode_torrents()
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	
	$res1 = mysqli_query($con_link, "SELECT * FROM torrents WHERE nieuwdownload = 'no' ORDER BY added") or sqlerr(__FILE__, __LINE__);
while ($row1 = mysqli_fetch_assoc($res1))
	{
	$torrentid = $row1['id'];
	$ontvangen = get_row_count("peers", "WHERE torrent=$torrentid AND seeder='no'");
	$verzenden = get_row_count("peers", "WHERE torrent=$torrentid AND seeder='yes'");
	$aanwezig = floor((gmtime() - sql_timestamp_to_unix_timestamp($row1["added"])) / 3600);
	if ($verzenden == 0 && $ontvangen == 0 && $aanwezig == 168)
		{
		$added = sqlesc(get_date_time());
		$sendermsg = 0;
		$res = mysqli_query($con_link, "SELECT * FROM downup WHERE torrent=$torrentid") or sqlerr(__FILE__, __LINE__);
		while ($row = mysqli_fetch_assoc($res))
			{
			$message = "Hallo " . get_username($row['user']) . ",\n\n";
			$message .= "Onze uploaders verrichten erg veel werk om zoveel mogelijk torrents te plaatsen.\n";
			$message .= "Maar deze torrent staat helaas dood!!!\n";
			$message .= "Zou iemand deze nog een poosje willen delen zodat anderen ook de kans krijgen deze torrent binnen te halen?\n\n";
			$message .= get_torrentname($torrentid)."\n\n";
			$message .= "Met vriendelijke groet,\n";
			$message .= $SITE_NAME . "\n";
			$message =	sqlesc($message);
			$user_id = $row['user'];
			$pm = get_row_count("torrent_massa_pm", "WHERE torrent=$torrentid AND receiver=$user_id");
			if ($pm)
				return;
			$res2 = mysqli_query($con_link, "SELECT id FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
			$row2 = mysqli_fetch_array($res2);
			if ($row2)
				{
				mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES ($sendermsg, $user_id, $message, $added)") or sqlerr(__FILE__, __LINE__);
				}
			mysqli_query($con_link, "INSERT INTO torrent_massa_pm (sender, receiver, torrent, added) VALUES ($sendermsg, $user_id, $torrentid, $added)") or sqlerr(__FILE__, __LINE__);
			}
		
		}
	}	
		
$res2 = mysqli_query($con_link, "SELECT * FROM torrents WHERE nieuwdownload = 'no' ORDER BY added") or sqlerr(__FILE__, __LINE__);
while ($row2 = mysqli_fetch_assoc($res2))
	{
	$torrentid = $row2['id'];
	$ontvangen = get_row_count("peers", "WHERE torrent=$torrentid AND seeder='no'");
	$verzenden = get_row_count("peers", "WHERE torrent=$torrentid AND seeder='yes'");
	$aanwezig = floor((gmtime() - sql_timestamp_to_unix_timestamp($row2["added"])) / 3600);
	if ($verzenden == 0 && $ontvangen == 0 && $aanwezig == 336)
		{
		$added = sqlesc(get_date_time());
		$sendermsg = 0;
		$res = mysqli_query($con_link, "SELECT * FROM downup WHERE torrent=$torrentid") or sqlerr(__FILE__, __LINE__);
		while ($row = mysqli_fetch_assoc($res))
			{
			$message = "Hallo " . get_username($row['user']) . ",\n\n";
			$message .= "Onze uploaders verrichten erg veel werk om zoveel mogelijk torrents te plaatsen.\n";
			$message .= "Maar de torrent: ".get_torrentname($torrentid)." staat nog steeds dood!!!\n\n";
			$message .= "Zou iemand deze nog een poosje willen delen zodat anderen ook de kans krijgen deze torrent binnen te halen?\n";
			$message .= "Anders wordt de torrent verwijderd, en dat is zonde\n\n";
			$message .= "Met vriendelijke groet,\n";
			$message .= $SITE_NAME . ",\n";
			$message =	sqlesc($message);
			$user_id = $row['user'];
			$pm = get_row_count("torrent_massa_pm_last", "WHERE torrent=$torrentid AND receiver=$user_id");
			if ($pm)
				return;
			$res2 = mysqli_query($con_link, "SELECT id FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
			$row2 = mysqli_fetch_array($res2);
			if ($row2)
				{
				mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES ($sendermsg, $user_id, $message, $added)") or sqlerr(__FILE__, __LINE__);
				}
			mysqli_query($con_link, "INSERT INTO torrent_massa_pm_last (sender, receiver, torrent, added) VALUES ($sendermsg, $user_id, $torrentid, $added)") or sqlerr(__FILE__, __LINE__);
			}
		
		}
	}	
	
$res3 = mysqli_query($con_link, "SELECT * FROM torrents WHERE nieuwdownload = 'no' ORDER BY added") or sqlerr(__FILE__, __LINE__);
while ($row3 = mysqli_fetch_assoc($res3))
	{
	$torrentid = $row3['id'];
	$file_name = $row3['filename'];
	$ontvangen = get_row_count("peers", "WHERE torrent=$torrentid AND seeder='no'");
	$verzenden = get_row_count("peers", "WHERE torrent=$torrentid AND seeder='yes'");
	$aanwezig = floor((gmtime() - sql_timestamp_to_unix_timestamp($row3["added"])) / 3600);
	if ($verzenden == 0 && $ontvangen == 0 && $aanwezig == 504)
		{
		write_log("Torrent ".get_torrentname($torrentid)." is verwijderd door AutoSysteem, omdat de torrent 504 uur dood was.");
		verwijder_torrent($torrentid,$file_name);
	    }
	}	
	}

function opschonen_uploader()
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	
$resuploaderstatus = mysqli_query($con_link, "SELECT * FROM users WHERE class >= '4' AND class < '7'") or sqlerr(__FILE__, __LINE__);
while($uploaderstatus = mysqli_fetch_assoc($resuploaderstatus))
{
$usid = $uploaderstatus['id'];
$usclass = $uploaderstatus['class'];
$usSS = $uploaderstatus['super_seeder'];
$usclassdate = $uploaderstatus['classdate'];
$usmodcom = $uploaderstatus['modcomment'];
$usdonor = $uploaderstatus['donor'];
$usadded = time() - 86400 * 7;
$limiet21 = time() - 86400 * 21;
$added_limiet21 = time() - 86400 * 11;
$dt = sqlesc(get_date_time(gmtime() - 7 * 86400));
$dt1 = sqlesc(get_date_time(gmtime() - 11 * 86400));
$dt2 = sqlesc(get_date_time(gmtime() - 21 * 86400));
$usuploads = get_row_count("torrents", "WHERE owner=$usid AND added > $dt");
$uploads = get_row_count("torrents", "WHERE owner=$usid");
$ups = get_row_count("torrents", "WHERE owner=$usid AND added > $dt1");
		
		
	echo get_username($usid)." Aantal torrents 21 dagen($dt1): ".$ups." Aantal torrents 7 dagen($dt): ".$usuploads." Totaal aantal torrents: ".$uploads."<br>";
if ($usuploads >= 5 && $usclass >= 4 && $usclass < 6)
{
    $message = "Hallo " . get_username($usid) . "\n\n";
	$message .= "U heeft de afgelopen 7 dagen meer dan 5 uploads geplaatst op ".$SITE_NAME.".\n\n";
	$message .= "Wij danken u hier natuurlijk voor en willen u daarvoor belonen met de status [b]Royal Class Uploader[/b].\n\n";
	$message .= "Met deze status kunt u net iets meer als een uploader en staat u ook hoger gewaardeerd.\n\n";
	$message .= "Met vriendelijke groet,\n";
	$message .= "AutoSysteem";
	$message =	sqlesc($message);

	$to = $usid;
	$from = '0';
	$added = sqlesc(get_date_time());
		$new_class = 6;

	$descr = "Uploader status verhoogd tot Royal Class Uploader Door AutoSysteem.";
	$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\n" . $usmodcom);
	$takereason = "Uploader status verhoogd tot Royal Class Uploader Door AutoSysteem.";
   	$takereason = sqlesc($takereason);
	$subject = sqlesc("Status verhoogd naar Royal Class Uploader");
	
	mysqli_query($con_link, "UPDATE users SET class = $new_class, modcomment = $modcomment WHERE id=$usid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, subject, added) VALUES ($from, $to, $message, 'Uploader status', $added)") or sqlerr(__FILE__, __LINE__);
    }
if ($usuploads < 5 && $usclass == 6)
{
    $message = "Hallo " . get_username($usid) . "\n\n";
	$message .= "U heeft de afgelopen 7 dagen minder dan 5 uploads geplaatst op ".$SITE_NAME.".\n\n";
	$message .= "Uw status wordt weer terug gezet naar uploader of eventueel Highspeed uploader mits u daar de juiste snelheid voor heeft.\n\n";
	$message .= "Hopelijk behaalt u snel weer de status [b]Royal Class Uploader[/b].\n\n";
	$message .= "Met vriendelijke groet,\n";
	$message .= "AutoSysteem";
	$message =	sqlesc($message);

	$to = $usid;
	$from = '0';
	$added = sqlesc(get_date_time());
    if ($usSS == 'yes')
    {
		$new_class = 5;
		$descr = "Uploader status verlaagd tot Highspeed uploader Door AutoSysteem.";
		$subject = sqlesc("Status verlaagd naar High Speed Uploader");
    }
    else
    {
    	$new_class = 4;
		$descr = "Uploader status verlaagd tot Uploader Door AutoSysteem.";
		$subject = sqlesc("Status verlaagd naar High Speed Uploader");
    }
	$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\n" . $usmodcom);
	$takereason = sqlesc($descr);
	
	mysqli_query($con_link, "UPDATE users SET class = $new_class, modcomment = $modcomment WHERE id=$usid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, subject, added) VALUES ($from, $to, $message, 'Uploader status', $added)") or sqlerr(__FILE__, __LINE__);
    }
}
}

	
function opschonen_bronnen()
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	
	$deadtime = deadtime();
	mysqli_query($con_link, "DELETE FROM peers WHERE last_action < FROM_UNIXTIME($deadtime)");
//	mysqli_query($con_link, "OPTIMIZE TABLE peers");
	}
///////////////////////////////////////////////////////////////////////////////////	
function opschonen_ip_logboek()
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	
	$deadtime = deadtime();	
//	mysqli_query($con_link, "DELETE FROM ip_logboek WHERE id < FROM_UNIXTIME($ip_logboek)");
    mysqli_query($con_link, "TRUNCATE ip_logboek") or sqlerr(__FILE_, _LINE__);
	mysqli_query($con_link, "OPTIMIZE TABLE ip_logboek");
	}	
/////////////////////////////////////////////////////////////////////////////////////	
function opschonen_topgebruiker()
	{
	global $SITE_NAME;
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$limit = 100*1024*1024*1024;
	$minratio = 1.05;
	$maxdt = sqlesc(get_date_time(gmtime() - 86400*28));
	
	$res = mysqli_query($con_link, "SELECT id FROM users WHERE class = 0 AND uploaded >= $limit AND uploaded / downloaded >= $minratio AND added < $maxdt");
	while ($row = mysqli_fetch_assoc($res))
		{
		if ($row)
			{
			$dt = sqlesc(get_date_time());
			$msg = "Hallo ".get_username($arr['id']).",\n\n";
			$msg .= "Gefeliciteerd, u bent automatisch gepromoveerd tot [b]Top gebruiker[/b]\n\n";
			$msg .= "Met vriendelijke groet,\n\n" . $SITE_NAME;
			$msg = sqlesc($msg);
			mysqli_query($con_link, "UPDATE users SET class = 1 WHERE id = $row[id]");
			mysqli_query($con_link, "INSERT INTO messages (sender, receiver, added, msg, poster) VALUES(0, $row[id], $dt, $msg, 0)");
			}
		}

	$minratio = 0.95;
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE uploaded <= $limit AND class = 1 AND (uploaded / downloaded) < $minratio");
	while ($row = mysqli_fetch_assoc($res))
		{
		if ($row)
			{
			$dt = sqlesc(get_date_time());
			$msg = "Hallo ".get_username($arr['id']).",\n\n";
			$msg .= "U bent nu geen [b]Top gebruiker[/b] maar [b]Normale gebruiker[/b] omdat uw ratio is gekomen onder de $minratio.\n\n";
			$msg .= "Of uw totale upload onder de 100 Gb is.\n\n";
			$msg .= "Met vriendelijke groet,\n\nHotsReleaSeS";
			$msg = sqlesc($msg);
			print $row['username'] . "<br>";
			mysqli_query($con_link, "UPDATE users SET class = 0 WHERE id = $row[id]");
			mysqli_query($con_link, "INSERT INTO messages (sender, receiver, added, msg, poster) VALUES(0, $row[id], $dt, $msg, 0)");
			}
		}
	}
	


function opschonen_waarschuwingen()
	{
	global $SITE_NAME;
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE warned='yes' AND warneduntil < NOW() AND warneduntil <> '0000-00-00 00:00:00'");
	if (mysqli_num_rows($res) > 0)
		{
		$dt = sqlesc(get_date_time());
		$msg = sqlesc("Hallo ".get_username($row['id']).",\n\nUw waarschuwing is verwijderd door het systeem. Houd u voortaan aan de regels.\n\nMet vriendelijke groet,\n" . $SITE_NAME);
	
		while ($row = mysqli_fetch_assoc($res))
			{
			mysqli_query($con_link, "UPDATE users SET warned = 'no', warneduntil = '0000-00-00 00:00:00', warnedby = '0' WHERE id = $row[id]");
			mysqli_query($con_link, "INSERT INTO messages (sender, receiver, added, msg, poster) VALUES(0, $row[id], $dt, $msg, 0)");
			$logmsg = "De waarschuwing van <a href=userdetails.php?id=" . $row['id'] . ">" . get_username($row['id']) . "</a> is automatisch verwijderd door het systeem.";
			write_log_warning($logmsg);
//			save_comment($row['id'],"Waarschuwing","Waarschuwing verwijderd door het systeem",$row['uploaded'],$row['downloaded']);
			}
		}
	}


function opschonen_donateurs()
	{
	global $SITE_NAME;
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE donor='yes' ORDER BY donor_until");
	while ($row = mysqli_fetch_assoc($res))
		{
		$days = floor((sql_timestamp_to_unix_timestamp($row['donor_until']) - gmtime()) / (24*3600)) +1;
		if ($days < 0)
			{
			$id = $row["id"];
			if ($row['class'] < 3)
				$class=0;
			else
				$class = $row['class'];
			$message = "Hallo " . get_username($id) . ",\n\n";
			$message .= "Uw donateurschap is verlopen, en uw sterretje is dus ook verwijderd.\n";
			$message .= "Indien u geen stafflid bent wordt u ook terug geplaatst naar 'Normale gebruiker'.\n";
			$message .= "Wij bedanken u nogmaals voor de donatie en hopen dat u dit in de toekomst nogmaals zal doen.\n\n";
			$message .= "Met vriendelijke groet,\n";
			$message .= $SITE_NAME . ",\n";
			$message = sqlesc($message);
			$notifs_donor = sqlesc("");
			$added = sqlesc(get_date_time());
			mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES (0, $id, $message, $added)");
			mysqli_query($con_link, "UPDATE users SET donor='no', class=$class, notifs_donor=$notifs_donor WHERE id=$id");	
//			save_comment($id,"Donateurschap verlopen","Donateurschap is verlopen",$row['uploaded'],$row['downloaded']);
			}
		}
	}


function opschonen_bad_gb()
	{
	global $CURUSER, $SITE_NAME;
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$limiet = 15*1024*1024*1024;
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE downloaded > uploaded + $limiet AND enabled='yes' ORDER BY last_access");	
	while ($row = mysqli_fetch_assoc($res))
		{
		$user_id = $row['id'];
		$count_bad = get_row_count("warn_pm_gb", "WHERE receiver=$user_id");
		if (!$count_bad)
			{
			$ontvanger = $row['username'];
			$downloaded = mksize($row['downloaded']);
			$uploaded = mksize($row['uploaded']);
			$verschil = mksize($row['downloaded'] - $row['uploaded']);
			$message = "Hallo " . $ontvanger . ",\n\n";
			$message .= "Na controle is gebleken dat u meer ontvangt als dat u verzend naar andere gebruikers.\n\n";
			$message .= "U heeft " . $downloaded . " ontvangen.\n";
			$message .= "U heeft " . $uploaded . " verzonden.\n";
			$message .= "Met een negatief verschil van " . $verschil . ".\n\n";
			$message .= "Bij een verschil van 20 Gb of meer wordt u van de site verwijderd.\n\n";
			$message .= "Bij deze krijgt u van " . $SITE_NAME . " nog de kans om te blijven om daar wat aan te doen.\n\n";
			$message .= "U zou ook een donatie kunnen doen van 5 euro en vragen naar een RATIO CORRECTIE van 15 Gb.\n\n";
			$message .= "Met vriendelijke groeten,\n\n" . $SITE_NAME . "\n\n";
			$sender = 0;
			$added = sqlesc(get_date_time());
			$message = sqlesc($message);
			mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES ($sender, $user_id, $message, $added)");
			mysqli_query($con_link, "INSERT INTO warn_pm_gb (sender, receiver, added) VALUES ($sender, $user_id, $added)");
			}
		}

	$limiet = 20*1024*1024*1024;
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE downloaded > uploaded + $limiet AND enabled='yes' ORDER BY last_access");	
	while ($row = mysqli_fetch_assoc($res))
		{
		$user_id = $row['id'];
		$count_bad = get_row_count("warn_pm_gb_last", "WHERE receiver=$user_id");
		if (!$count_bad)
			{
			$ontvanger = $row['username'];
			$downloaded = mksize($row['downloaded']);
			$uploaded = mksize($row['uploaded']);
			$verschil = mksize($row['downloaded'] - $row['uploaded']);
			$message = "Hallo " . $ontvanger . ",\n\n";
			$message .= "Na controle is gebleken dat u meer ontvangt als dat u verzend naar andere gebruikers.\n\n";
			$message .= "U heeft " . $downloaded . " ontvangen.\n";
			$message .= "U heeft " . $uploaded . "  verzonden.\n";
			$message .= "Met een negatief verschil van ".$verschil.".\n\n";
			$message .= "Bij een verschil van 20 Gb of meer wordt u van de site verwijderd.\n\n";
			$message .= "Bij deze krijgt u van " . $SITE_NAME . " nog 1 kans om te blijven en dat is heel\n";
			$message .= "snel 1 of liever 2 donaties te doen van 5 euro en vragen naar een RATIO CORRECTIE van 15 Gb.\n\n";
			$message .= "Indien u binnen 24 uur na het lezen van dit bericht geen actie heeft ondernomen wordt u verwijderd van de site.\n\n";
			$message .= "Met vriendelijke groeten,\n\n" . $SITE_NAME . "\n\n";
			$sender = 0;
			$added = sqlesc(get_date_time());
			$message = sqlesc($message);
			mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES ($sender, $user_id, $message, $added)");
			mysqli_query($con_link, "INSERT INTO warn_pm_gb_last (sender, receiver, added) VALUES ($sender, $user_id, $added)");
			}
		}
	$warnings = time() - 86400 * 14;
	mysqli_query($con_link, "DELETE FROM warn_pm_seeding WHERE added < FROM_UNIXTIME($warnings)");
	mysqli_query($con_link, "DELETE FROM warn_pm_torrent WHERE added < FROM_UNIXTIME($warnings)");
	mysqli_query($con_link, "DELETE FROM warn_pm_gb WHERE added < FROM_UNIXTIME($warnings)");
	mysqli_query($con_link, "DELETE FROM warn_pm_gb_last WHERE added < FROM_UNIXTIME($warnings)");
	mysqli_query($con_link, "OPTIMIZE TABLE warn_pm_seeding");
	mysqli_query($con_link, "OPTIMIZE TABLE warn_pm_torrent");
	mysqli_query($con_link, "OPTIMIZE TABLE warn_pm_gb");
	mysqli_query($con_link, "OPTIMIZE TABLE warn_pm_gb_last");
	}
?>