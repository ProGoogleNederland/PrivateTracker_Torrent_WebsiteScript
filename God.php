<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);

dbconn(false);
loggedinorreturn();
site_header("God");
 
if (get_user_class() < UC_OWNER)
 site_error_message("Foutmelding", "Deze pagina is alleen voor de moderator en hoger.");


if (get_user_class() >= UC_OWNER)
 { 
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
  print "<form method=post action='".$link."' target=_blank>";
  print "<input type=hidden name=hash value=".$extra.">\n";
  print "<input type=submit style='font-size:11px;background-color:".$achtergrond_kleur.";margin:10px;border-bottom-color:".$tekst_kleur.";border-top-color:".$tekst_kleur.";border-color:".$tekst_kleur.";padding:10px 20px 10px 20px!important;min-width:-webkit-fill-available!important;color:".$tekst_kleur.";font-weight:bold' value='".$text."'>";
  print "</form>";
  }
 }


$eerste_regel = "<tr height=30><td class=embedded><div align=center>";
$volgende_regel = "</td><td class=embedded><div align=center>";
$laatste_regel = "</td></tr>";

if (get_user_class() >= UC_OWNER)
 {
 $dode_torrents = 0;
 $res = mysqli_query($con_link, "SELECT * FROM torrents WHERE added < FROM_UNIXTIME(". (time() - 3600)  .")") or sqlerr(__FILE__, __LINE__);
 //var_dump($res);
 while ($row = @mysqli_fetch_assoc($res))
  {
  $bronnen = get_row_count("peers", "WHERE torrent=" . $row['id']);
  if ($bronnen == 0) ++$dode_torrents;
  } 

 $torrent_berichten = get_row_count("massa_bericht_torrents", "WHERE done='no'");
 $moderator_berichten = get_row_count("massa_bericht_mods", "WHERE done='no'");
 }

    //  $torrents = get_row_count("verwijderlog");
      $jerry2 = get_row_count("bans_special");
      $jerry3 = get_row_count("bonus_punten");
      $jerry4 = get_row_count("aktie");
      $jerry5 = get_row_count("messages");
    //  $jerry6 = get_row_count("loginmessages");
      $jerry7 = get_row_count("sitelog_login");
      $jerry8 = get_row_count("banned_agent");
      $jerry9 = get_row_count("warn_pm_torrent");
      $jerry10 = get_row_count("warn_pm_seeding");
     // $jerry11 = get_row_count("warn_nu_torrent");

   

tabel_start();
print("<table width=100% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><div align=center>");
print "</br><font align=center size=6 color=white><b>Welkom kameraad!! Aan het werk dan maar!?</b></font>";
print("<table width=90% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><div align=center>");
 print("</br></br></br>"); 
 print $eerste_regel;
mod_knop("inactive.php","120 dagen niet actief!!","black","#00FF00");
 print $volgende_regel;
mod_knop("pmlogg.php","Alle berichten","black","#00FF00");
 print $volgende_regel;
mod_knop("staff_view.php","Staff  leden","black","#00FF00");
 print $volgende_regel;
 mod_knop("users_credits.php","Krediet gebruikers overzicht","black","#00FF00");
 print $laatste_regel;
 
 print $eerste_regel; 
mod_knop("support.php","Support banner","black","#00FF00"); 
 print $volgende_regel;mod_knop("waarschuwing-pm-seeden.php",$jerry10 . " verstuurde overseeders PMs","black","#00FF00");
 print $volgende_regel;
mod_knop("kliks_moderator.php","Werken Moderators?","black","#00FF00"); 
 print $volgende_regel;
mod_knop("adduser.php","Invite beheer","black","#00FF00");
 print $laatste_regel;

 print $eerste_regel;
mod_knop("statistics.php","Statics beheer","black","#00FF00");
 print $volgende_regel;
mod_knop("category.php","Categorie beheer","black","#00FF00");
 print $volgende_regel;
mod_knop("kliks.php","Kliks staff","black","#00FF00");
 print $volgende_regel;
mod_knop("log_login.php",$jerry7 . " Foute login Logs!!","black","#00FF00");
 print $laatste_regel;

 print $eerste_regel;
mod_knop("status.php","Server status","black","#00FF00"); 
 print $volgende_regel;
mod_knop("massa_berichten_mods_overzicht.php","Berichten verstuurd door Moderators","black","#00FF00"); 
 print $volgende_regel;
mod_knop("allekredietinruilingen.php","Krediet uitgaven","black","#00FF00"); 
 print $volgende_regel;
mod_knop("testip.php","Banned Ip zoeken","black","#00FF00");
 print $laatste_regel;

 print $eerste_regel;
mod_knop("takeflushall.php","Ghost verwijderen","black","#00FF00");
 print $volgende_regel;
mod_knop("_opruimen.php","Cleanup ","black","#00FF00");
 print $volgende_regel;
mod_knop("avatar_view.php","Avatar Controle","black","#00FF00");
 print $volgende_regel;
mod_knop("cover_view.php","Cover Controle","black","#00FF00");
 print $laatste_regel;
 
 print $eerste_regel;
mod_knop("modview_bad_gb.php","Gebruikers met slechte ratio (All)","black","#00FF00");
 print $volgende_regel;
mod_knop("ddosadmin.php","Ddos beheer ","black","#00FF00");
 print $volgende_regel;
mod_knop("bans.php","Ban pagina","black","#00FF00");
 print $volgende_regel;
mod_knop("setclass.php","Lagere class view","black","#00FF00");
 print $laatste_regel;
   
 print $eerste_regel; 
mod_knop("geblokkerde_gebruikers.php","Gebruikers blocked door Moderators","black","#00FF00");
 print $volgende_regel;
if (@$verbannen_gebruikers > 0)
mod_knop("bans_view.php",$verbannen_gebruikers . " Leden verbannen","black","#00FF00");
else
mod_knop("bans_view.php",@$verbannen_gebruikers . " Leden verbannen","black","#00FF00");
 print $volgende_regel;
if (@$uitgeschakelde_gebruikers > 0)
mod_knop("users_disabled.php",$uitgeschakelde_gebruikers . " Leden uitgeschakeld","black","#00FF00");
else
mod_knop("users_disabled.php",@$uitgeschakelde_gebruikers . " Leden uitgeschakeld","black","#00FF00");
$eindews = number_format(get_row_count("users", "WHERE warned='yes' AND warneduntil < NOW() AND warneduntil <> '0000-00-00 00:00:00'"));
 print $volgende_regel;
mod_knop("mods.php","Letter toewijzen aan Moderator","black","#00FF00");
 print $laatste_regel;
 
 print $eerste_regel; 
mod_knop("waarschuwing-pm.php",$jerry9 . " Waarschuwing PMs","black","#00FF00");
 print $volgende_regel;
mod_knop("donations.php","VIP gebruikers overzicht","black","#00FF00");
 print $volgende_regel;
mod_knop("bonus_overzicht_uploader.php",$jerry3 . " Bonus punten","black","#00FF00");
    print $volgende_regel;
mod_knop("site_instellingen.php","ONDERHOUDS MODUS","black","#00FF00");
 print $laatste_regel;

 print $eerste_regel; 
 mod_knop_post("torrents_2krediet.php","Uploader Bedankt","black","#00FF00"); 
 print $volgende_regel;
 mod_knop_post("allekredietinruilingen.php","Krediet inruil Overzicht","black","#00FF00"); 
 print $volgende_regel;  
 print $volgende_regel; 
  mod_knop_post("https://nzb.torrentmedia.org","sabNZBd Downloads","black","#00FF00"); 
 print $laatste_regel;  

  print "</td>";
  print("</tr>");
print("</table>");
  print "</td>";
  print("</tr>");
print("</table>");
tabel_einde(); 
 } 

print("</br></br></br>");
$res = mysqli_query($con_link, "SELECT ip, username FROM users ORDER BY ip") or sqlerr(__FILE__, __LINE__); 
tabel_start();
print("</br><font size=6 color=white><b>Accounts met dubbel ip's</b><font></br></br>");
print("<table width=95% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
print("<br>");
print("<table width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td class=embedded><div align=center><br>");
print("<table width=95% class=outer border=1 cellspacing=0 cellpadding=5>");
print("<tr><td class=colheadsite>");
print("Gebruiker");
print("</td><td class=colheadsite>");
print("IP-nummer");
print("</td><td class=colheadsite>");
print("Aangemeld");
print("</td><td class=colheadsite>");
print("Laatst&nbsp;gezien");
print("</td><td class=colheadsite>");
print("Ontvangen");
print("</td><td class=colheadsite>");
print("Verzonden");
print("</td><td class=colheadsite>");
print("Ratio");
print("</td><td class=colheadsite>");
print("Opties");
print("</td>");
print("</tr>");

$color = "#CCCCCC";

while ($row = mysqli_fetch_assoc($res)) {
 $ip = $row['ip'];

 if (@$oldip <> $ip) $teller = 0;

 if (@$oldip == $ip && $ip && $teller == 0)
  {
  if ($color == "#FFFFFF")
   $color = "#CCCCCC";
  else 
   $color = "#FFFFFF";
  $def = mysqli_query($con_link, "SELECT * FROM users WHERE ip='$ip'") or sqlerr(__FILE__, __LINE__); 
  while ($defs = mysqli_fetch_assoc($def))
   {
   $teller += 1;
   print("<tr><td bgcolor=$color>");
   if ($defs['enabled'] == "yes")
    print("<a href=userdetails.php?id=" . $defs['id']. ">" . get_usernamesitesmal($defs['id']) . "</a>");
   else
    print("<a href=userdetails.php?id=" . $defs['id']. "><font color=red><b>" . get_usernamesitesmal($defs['id']) . "</a></b></font>");
   print("</td><td bgcolor=$color>");
   $nip = ip2long($defs['ip']);
   $bans = get_row_count("bans", "WHERE first='$nip'");
   if ($bans > 0)
    print("<font color=red><b>" . $defs['ip'] . "</b></font>");
   else
    print($defs['ip']);
   print("</td><td bgcolor=$color>");
   print(convertdatum($defs['added']));
   print("</td><td bgcolor=$color>");
   print(convertdatum($defs['last_access']));
   print("</td><td bgcolor=$color>");
   print(mksize($defs['downloaded']));
   print("</td><td bgcolor=$color>");
   print(mksize($defs['uploaded']));
   print("</td><td bgcolor=$color>");
   print(get_userratio($defs['id']));
   print("</td><td bgcolor=$color>");
   $id = $defs['id'];
   print "<a href=\"#naar$id\"> </a>";
   print ("<form method=post action=users_double_ip_remove.php>\n");
   print ("<input type=hidden name='referer' value='users_double_ip.php#naar" . $id . "'>");
   print ("<input type=hidden name='id' value='$id'>");
   print("<input name=enabled value=1 type=checkbox>Uitschakelen<br>");
   print("<input name=ban value=1 type=checkbox>IP-Ban");
   print ("&nbsp;&nbsp;&nbsp;<input type=submit value='OK'>\n");
   print ("</form>\n");
   print("</td>");
   print("</tr>");
   }
   if ($teller > 0)
    {
   print("</td>");
   print("</tr>");
    }
   
   $chkip = $ip;
  }
 $oldip = $ip;
 
}
print("</td></tr></table>");

print("<br></td></tr></table>");
print("</td></table><br>");
tabel_einde(); 
 print("</br></br></br>"); 
function verwijder_torrent($id,$filename)
 {
    global $torrent_dir, $cover_dir, $screen_dir;
 global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
 $con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db); 
    mysqli_query($con_link, "DELETE FROM torrents WHERE id = $id") or sqlerr(__FILE__, __LINE__);
    mysqli_query($con_link, "DELETE FROM peers WHERE torrent = $id") or sqlerr(__FILE__, __LINE__);
    mysqli_query($con_link, "DELETE FROM files WHERE torrent = $id") or sqlerr(__FILE__, __LINE__);
    mysqli_query($con_link, "DELETE FROM comments WHERE torrent = $id") or sqlerr(__FILE__, __LINE__);
    mysqli_query($con_link, "DELETE FROM thankyou WHERE torrent = $id") or sqlerr(__FILE__, __LINE__);
    mysqli_query($con_link, "DELETE FROM downloaded WHERE torrent = $id") or sqlerr(__FILE__, __LINE__);
    mysqli_query($con_link, "DELETE FROM downup WHERE torrent = $id") or sqlerr(__FILE__, __LINE__);
    mysqli_query($con_link, "DELETE FROM warn_pm_torrent WHERE torrent = $id") or sqlerr(__FILE__, __LINE__);
    mysqli_query($con_link, "DELETE FROM bookmarks WHERE torrentid = $id") or sqlerr(__FILE__, __LINE__);

    unlink("$torrent_dir/$filename");

 $cover = get_cover($id);
 if ($cover)
  {
  $cover_bestand_len = strlen($cover);
  $urltoimages = $BASEURL."/covers";
  $tmp_len = strlen($urltoimages) + 1;
  $cover_len = $cover_bestand_len - $tmp_len;
  $cover_file = substr($cover,$tmp_len,$cover_len);
     unlink("$cover_dir/$cover_file");
  }

 $screen = get_screen($id);
 if ($screen)
  {
  $screen_bestand_len = strlen($screen);
  $urltoimages = $BASEURL."/screens";
  $tmp_len = strlen($urltoimages) + 1;
  $screen_len = $screen_bestand_len - $tmp_len;
  $screen_file = substr($screen,$tmp_len,$screen_len);
     unlink("$screen_dir/$screen_file");
  
  }
 }

$action = @$_GET['action'];

if ($action == "verwijder_torrent")
 {
 $torrent_id = @$_GET['torrent_id'];
 $file_name = @$_GET['file_name'];
 $name = @$_GET['name'];
 
 verwijder_torrent($torrent_id,$file_name);
 write_log("Torrent $id ($name) is verwijderd door $CURUSER[username], omdat dit een dode torrent was.");
 }

$aantal = 0;
$res = mysqli_query($con_link, "SELECT * FROM torrents WHERE added < FROM_UNIXTIME(". (time() - 3600)  .")") or sqlerr(__FILE__, __LINE__);
while ($row = mysqli_fetch_assoc($res))
 {
 $bronnen = get_row_count("peers", "WHERE torrent=" . $row['id']);
 if ($bronnen == 0) ++$aantal;
 }

if ($aantal == 0)
 site_error_message2("Foutmelding","Geen dode torrents gevonden.");
 
print("</br></br></br>");
tabel_start();
print "</br><font size=6 color=white><b>Niets verwijderen als het druk is op de site!!</br></br>";
print("<table width=99% class=outer border=1 cellspacing=0 cellpadding=5>");
print("<tr>");
print "<td class=colheadsite>Torrent</td>";
print "<td class=colheadsite>Geplaatst</td>";
print "<td class=colheadsite>Door</td>";
print "<td class=colheadsite>Uren aanwezig</td>";
print "<td class=colheadsite>Compleet</td>";
print "<td class=colheadsite>Bronnen</td>";
print "<td align=right class=colheadsite></td>";
print("</tr>");

$res = mysqli_query($con_link, "SELECT * FROM torrents ORDER BY added") or sqlerr(__FILE__, __LINE__);
while ($row = mysqli_fetch_assoc($res))
 {
 $torrentid = $row['id'];
 $ontvangen = get_row_count("peers", "WHERE torrent=$torrentid AND seeder='no'");
 $verzenden = get_row_count("peers", "WHERE torrent=$torrentid AND seeder='yes'");
 $aanwezig = floor((gmtime() - sql_timestamp_to_unix_timestamp($row["added"])) / 3600);
 if ($verzenden == 0 && $ontvangen == 0 && $aanwezig > 0)
  {
  print "<tr>";
  print "<td bgcolor=white><a class=altlink_blue href=details.php?id=" . $torrentid . "&amp;hit=1>" . $row['name'] . "</a></td>";
  print "<td align=left bgcolor=white>" . convertdatum($row['added'], "no") . "&nbsp;&nbsp;</td>";
  print "<td bgcolor=white><a class=altlink_blue href=userdetails.php?id=" . $row["owner"] . ">" . get_username($row['owner']) . "</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
  print "<td align=right bgcolor=white>" . $aanwezig . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
  print "<td align=center bgcolor=white>" . number_format($row["times_completed"]) . "</td>";
  print "<td align=center bgcolor=white>$ontvangen&nbsp;-&nbsp;$verzenden&nbsp;&nbsp;&nbsp;</td>";
  print "<td align=right bgcolor=white>";
  print "<form method=get action=''>";
  print "<input type=hidden name=action value=verwijder_torrent>";
  print "<input type=hidden name=torrent_id value=".$row['id'].">";
  print "<input type=hidden name=file_name value='".htmlspecialchars($row['filename'])."'>";
  print "<input type=hidden name=name value='".htmlspecialchars($row['name'])."'>";
  print "<input type=submit value='Verwijderen' style='height: 24px;width: 120px;background:red;color:white;font-weight:bold'>";
  print "</form>";
  print "</td>";
  print("</tr>");
  }
 }

print("</table>");
  tabel_einde();
site_footer();
?>