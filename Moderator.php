<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();
site_header("Moderators");

$eerste_regel = "<tr height=30><td class=embedded><div align=center>";
$volgende_regel = "</td><td class=embedded><div align=center>";
$laatste_regel = "</td></tr>";
	
if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de moderator en hoger.");

function mod_knop($link, $text, $achtergrond_kleur = "white", $tekst_kleur = "darkblue")
	{
	if ($link)
		{
		print "<form method=get action='".$link."'>";
		print "<input type=submit style='font-size:11px;background-color:".$achtergrond_kleur.";margin:10px;border-bottom-color:".$tekst_kleur.";border-top-color:".$tekst_kleur.";border-color:".$tekst_kleur.";padding:10px 20px 10px 20px!important;min-width:-webkit-fill-available!important;color:".$tekst_kleur.";font-weight:bold' value='".$text."' onmouseover=\"return overlib('<table width=100%><tr><td><font size=6>".$text."</td></tr></table>',  WIDTH, 150, DELAY, 200);\" onmouseout=\"return nd();\";>";
		print "</form>";
		}
	}
function mod_knop_post($link, $text, $extra, $achtergrond_kleur = "white", $tekst_kleur = "darkblue")
	{
	if ($link)
		{
		print "<form method=post action='".$link."'>";
		print "<input type=hidden name=hash value=".$extra.">\n";
		print "<input type=submit style='font-size:11px;background-color:".$achtergrond_kleur.";margin:10px;border-bottom-color:".$tekst_kleur.";border-top-color:".$tekst_kleur.";border-color:".$tekst_kleur.";padding:10px 20px 10px 20px!important;min-width:-webkit-fill-available!important;color:".$tekst_kleur.";font-weight:bold' value='".$text."'>";
		print "</form>";
		}
	}
	
tabel_start();

if (get_user_class() >= UC_ADMINISTRATOR)
	{	
	print $eerste_regel;
mod_knop("advanceddownloaded.php","Snelle Moderator","black","#00FF00");
	print $volgende_regel;
mod_knop("upload_aanvraag.php","Uploader aanvraag!!!","black","#00FF00");
	print $volgende_regel;
mod_knop("users_uploaders.php","Uploader Overzicht","black","#00FF00");
	print $volgende_regel;
mod_knop("users_unconfirmed.php","Leden aanvragen!!!","black","#00FF00");
	print $laatste_regel;
	
	print $eerste_regel;	
mod_knop("bad_users.php","Slechte Gebruikers","black","#00FF00");
	print $volgende_regel;
mod_knop("waarschuwing-pm-seeden.php","Gewaarschuwde Users","black","#00FF00");
	print $volgende_regel;
mod_knop("dht_controle.php","DHT Check","black","#00FF00");
	print $volgende_regel;
mod_knop("mod_users.php?","Waarschuwingssysteem","black","#00FF00");
	print $laatste_regel;
	
	print $eerste_regel;	
mod_knop("mod_users_wegwezen.php","Users met rode ratio","black","#00FF00");
	print $volgende_regel;
mod_knop("inactive.php","Inactive gebruikers","black","#00FF00");	
	print $volgende_regel;
mod_knop("massa_berichten_torrents_overzicht.php","Torrent aanvragen (Opnieuw delen)","black","#00FF00");
	print $volgende_regel;	
mod_knop("user_view_peers.php","Niet verbindbaar","black","#00FF00");
	print $laatste_regel;

	print $eerste_regel;	
mod_knop("torrents_50bp.php","50BP geven","black","#00FF00");
	print $volgende_regel;
mod_knop("users_disabled_shoutbox.php","Geweigerde shoutbox users","black","#00FF00");	
	print $volgende_regel;
mod_knop("avatar_view.php","Controleer avatars users","black","#00FF00");		
	print $volgende_regel;	
mod_knop("bedanktplaatje_view.php","Controleer dankje plaatjes","black","#00FF00");			
	print $laatste_regel;
	
	print $eerste_regel;
mod_knop("users_modview.php","Gebruikers per letter","black","#00FF00");
	print $volgende_regel;
mod_knop("massa_berichten_mods.php","Massa PM jouw letter(s)","black","#00FF00");
	print $volgende_regel;
	mod_knop("oude_covers_verwijderen.php","Wis oude covers","black","#00FF00");
	print $volgende_regel;
mod_knop("oude_screens_verwijderen.php","Wis oude screens","black","#00FF00");
	print $laatste_regel;
	
	print $eerste_regel;	
mod_knop("torrents_100bp.php","100BP geven","black","#00FF00");
	print $volgende_regel;
mod_knop("usersearch.php","Gebruikers zoeken","black","#00FF00");
	print $volgende_regel;
mod_knop("log_useremail.php","E-mail log","black","#00FF00");
	print $volgende_regel;
mod_knop("gb_verschil_users.php","GB Verschil users","black","#00FF00");
	print $laatste_regel;

	}

	tabel_einde();

$torrent_ratio = 2.5;
$torrent_size = 1*1024*1024*1024;

$action = @$_POST['action'];

if ($action == "warn")
	{
	$warn = @$_POST['warn'];
	foreach ($warn as $id)
		{
		$res = mysqli_query($con_link, "SELECT * FROM downup WHERE id=$id") or sqlerr(__FILE__, __LINE__);
		$row = mysqli_fetch_array($res);

		$ratio = number_format($row['uploaded']/$row['downloaded'],2);

		$res2 = mysqli_query($con_link, "SELECT name FROM torrents WHERE id = $row[torrent]") or sqlerr();
		$row2 = mysqli_fetch_array($res2);
		$tnaam = $row2['name'];

		$warnings = get_row_count("warn_pm_seeding","WHERE receiver=$row[user]") + 1;

		if ($warnings == 1)
			$straf = 5*1024*1024*1024;
		if ($warnings == 2)
			$straf = 10*1024*1024*1024;
		if ($warnings == 3)
			$straf = 20*1024*1024*1024;
		if ($warnings == 4)
			$straf = 40*1024*1024*1024;

		$message = "Hallo " . get_username($row['user']) . ",\n\n";
		$message .=	"Bij deze vraag ik u om te stoppen met delen/seeden op torrent $tnaam,\n";
		$message .=	"om andere gebruikers ook een kans te geven op deze torrent een goede ratio te kunnen halen.\n\n";
		$message .=	"Gezien u nu op deze torrent en ratio van $ratio heeft.\n\n";
		if ($warnings > 1)
			$message .=	"En dit is nu waarschuwing nummer $warnings voor u voor 'OverSeeden'.\n\n";
		$message .=	"Uw totaal verzonden wordt verlaagd met ".mksize($straf)." .\n\n";
		$message .=	"U heeft ook een officiele waarschuwing gekregen voor 24 uur.\n\n";
		$message .=	"Met vriendelijke groet,\nonzesite";
		$message =	sqlesc($message);

		$added = sqlesc(get_date_time());
		mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES (0, $row[user], $message, $added)") or sqlerr(__FILE__, __LINE__);
		mysqli_query($con_link, "INSERT INTO warn_pm_seeding (sender, receiver, torrent, added) VALUES (0, $row[user], $row[torrent], $added)") or sqlerr(__FILE__, __LINE__);
		
		$res3 = mysqli_query($con_link, "SELECT * FROM users WHERE id=$row[user]") or sqlerr(__FILE__, __LINE__);
		$row3 = mysqli_fetch_array($res3);

		$boete = $row3['uploaded'] - $straf;
		if ($boete < 0)
			$boete = 0;
		
		$modcomment = $row3['modcomment'];		
		$warneduntil = get_date_time(time() + 24 * 3600);
		$modcomment = convertdatum(date("Y-m-d H:i:s")) . " - Gewaarschuwd voor 24 uur door het systeem.\nReden waarschuwing: OverSeeden.\n\n" . $modcomment;
		$modcomment = sqlesc($modcomment);
		
		$logmsg = "<a href=userdetails.php?id=" . $row3['id'] . ">" . get_username($row3['id']) . "</a> is gewaarschuwd door het systeem voor OVERSEEDEN";
		write_log_warning($logmsg);

		mysqli_query($con_link, "UPDATE users SET modcomment=$modcomment, uploaded=$boete, warneduntil = '$warneduntil', warnedby = 0, warned = 'yes' WHERE id=$row[user]") or sqlerr(__FILE__, __LINE__);
		}	
	}


tabel_start();
tabel_top("Over seeders","center");
print "<table class=sitetable width=100% border=1 cellspacing=0 cellpadding=5>";
print "<tr>";
print "<td class=colheadsite>Torrent</td>";
print "<td class=colheadsite>Grootte</td>";
print "<td class=colheadsite>up</td>";
print "<td class=colheadsite>down</td>";
print "<td class=colheadsite>Gebruiker</td>";
print "<td class=colheadsite>##</td>";
print "<td class=colheadsite>Verzonden</td>";
print "<td class=colheadsite>Ontvangen</td>";
print "<td class=colheadsite>T&nbsp;ratio</td>";
print "<td class=colheadsite>Gewaarschuwd&nbsp;door</td>";
print "<td class=colheadsite>##</td>";
print "</tr>";
print "<form method=post action=over_seeder.php>";
print "<input type=hidden name=action value=warn>";

$res = mysqli_query($con_link, "SELECT userid, torrent FROM peers WHERE seeder='yes' ORDER BY torrent") or sqlerr(__FILE__, __LINE__);
while ($row = mysqli_fetch_array($res))
	{
	$res2 = mysqli_query($con_link, "SELECT id, name, size FROM torrents WHERE id=$row[torrent]") or sqlerr(__FILE__, __LINE__);
	$row2 = mysqli_fetch_array($res2);
	$res3 = mysqli_query($con_link, "SELECT id, downloaded, uploaded FROM downup WHERE torrent=$row[torrent] AND user=$row[userid]") or sqlerr(__FILE__, __LINE__);
	$row3 = mysqli_fetch_array($res3);
	$res4 = mysqli_query($con_link, "SELECT id, class FROM users WHERE id=$row[userid]") or sqlerr(__FILE__, __LINE__);
	$row4 = mysqli_fetch_array($res4);

	$alle = get_row_count("peers","WHERE torrent=$row[torrent]");
	$delers = get_row_count("peers","WHERE torrent=$row[torrent] AND seeder='yes'");
	$ontvangers = $alle - $delers;

	$warnings = get_row_count("warn_pm_seeding","WHERE receiver=$row[userid]");

	if ($row3['uploaded'] > ($row3['downloaded'] * $torrent_ratio) && $row2['size'] > $torrent_size && $row3['downloaded'] > $torrent_size)
		{
		if ($row4['class'] < 3 && $delers > 3 && $old != $row3['id'])
			{
			print "<tr>";
			print "<td><a class=altlink href=details.php?id=".$row2['id'].">".$row2['name']."</a></td>";
			print "<td>".mksize($row2['size'])."</td>";
			print "<td>".$delers."</td>";
			print "<td>".$ontvangers."</td>";
			print "<td><a class=altlink href=userdetails.php?id=".$row['userid'].">".get_usernamesitesmal($row['userid'])."</a></td>";
			print "<td>".$warnings."</td>";
			print "<td>".mksize($row3['uploaded'])."</td>";
			print "<td>".mksize($row3['downloaded'])."</td>";
			print "<td>".number_format($row3['uploaded']/$row3['downloaded'],2)."</td>";
			$sender = "";
			$res5 =  mysqli_query($con_link, "SELECT sender, added FROM warn_pm_seeding WHERE torrent=$row[torrent] AND receiver=$row[userid]") or sqlerr(__FILE__, __LINE__);
			while ($row5 = mysqli_fetch_assoc($res5))
				{
				$sender .= "<b><font color=red>" . "Door het systeem op " . convertdatum($row5['added'], "Nee") . "</font></b><br>";
				}
			if ($sender)
				print "<td align=center>" . $sender . "</td>";
			else
				print "<td align=center>&nbsp;</td>";
			if ($sender)
				print "<td align=center><input name=warn[] type=checkbox value=".$row3['id']."></td>";
			else
				print "<td align=center><input name=warn[] type=checkbox value=".$row3['id']." checked></td>";
			print "</tr>";
			$old = $row3['id'];
			}
		}
	}
print "</table>";
print "<div align=right><input type=submit class=btn style=' height: 24px; width: 300px' value='Stuur waarschuwingen naar geselecteerde'>";
print "</form>";
tabel_einde();
site_footer();
?>