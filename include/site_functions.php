<?php
require_once("bittorrent.php");
require_once("secrets.php");
function verwijder_gebruiker($userid)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
		
	mysqli_query($con_link, "DELETE FROM addedrequests WHERE userid=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM blocks WHERE userid=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM blocks WHERE blockid=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM bookmarks WHERE userid=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM comments WHERE user=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM downloaded WHERE user=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM downtotals WHERE user=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM downup WHERE user=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM messages WHERE sender=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM messages WHERE receiver=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM news WHERE userid=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM peers WHERE userid=$userid") or sqlerr(__FILE__, __LINE__);
	//mysqli_query($con_link, "DELETE FROM pollanswers WHERE userid=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM posts WHERE userid=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM ratings WHERE user=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM readposts WHERE userid=$userid") or sqlerr(__FILE__, __LINE__);
      
	mysqli_query($con_link, "DELETE FROM requests WHERE userid=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM requests WHERE filledby=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM shouts WHERE user=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM thankyou WHERE user=$userid") or sqlerr(__FILE__, __LINE__);
	//mysqli_query($con_link, "DELETE FROM topics WHERE userid=$userid") or sqlerr(__FILE__, __LINE__);
	//mysqli_query($con_link, "DELETE FROM topics WHERE lastpost=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM user_ip WHERE userid=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM warn_pm_seeding WHERE sender=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM warn_pm_seeding WHERE receiver=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM warn_pm_torrent WHERE sender=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM warn_pm_torrent WHERE receiver=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM warn_pm_gb WHERE sender=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM warn_pm_gb WHERE receiver=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM warn_pm_gb_last WHERE sender=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM warn_pm_gb_last WHERE receiver=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM warnings WHERE userid=$userid") or sqlerr(__FILE__, __LINE__);
	//mysqli_query($con_link, "DELETE FROM helpdesk WHERE userid=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM donations_claim WHERE user_id=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM donations_claim_del WHERE user_id=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM donations_claim_msg WHERE user_id=$userid") or sqlerr(__FILE__, __LINE__);
//	mysqli_query($con_link, "DELETE FROM wk_poule WHERE user_id=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM users_comment WHERE user_id=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM users_comment WHERE done_by=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM verzoekjes WHERE added_by=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM verzoekjes WHERE edit_by=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM verzoekjes_stemmen WHERE user_id=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "DELETE FROM donations_email WHERE user_id=$userid") or sqlerr(__FILE__, __LINE__);

    mysqli_query($con_link, "DELETE FROM uploader_bonus WHERE user_id=$userid") or sqlerr(__FILE__, __LINE__);
    mysqli_query($con_link, "DELETE FROM bonus_punten WHERE sender_id=$userid") or sqlerr(__FILE__, __LINE__);
    mysqli_query($con_link, "DELETE FROM bonus_punten WHERE receiver_id=$userid") or sqlerr(__FILE__, __LINE__);
	
	mysqli_query($con_link, "DELETE FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
	}

function site_ip_check($site_userid)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$site_ip = getip();
	
	if($site_userid != 1){
	
		$res = mysqli_query($con_link, "SELECT id FROM user_ip WHERE userid=$site_userid AND ip='$site_ip'") or sqlerr(__FILE__, __LINE__);
		$row = mysqli_fetch_array($res);
		if (!$row)
			{
			$added = sqlesc(get_date_time());
			$site_ip = sqlesc($site_ip);
			mysqli_query($con_link, "INSERT INTO user_ip (userid, ip, added, last_seen) VALUES ($site_userid, $site_ip, $added, $added)");
			}
		else
			{
			$id = $row['id'];
			$added = sqlesc(get_date_time());
			mysqli_query($con_link, "UPDATE user_ip SET last_seen = now() WHERE id=$id");
			}
		}
	}

function proxy_ip_check($ip)
	{
	global $CURUSER;
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$ip = sqlesc($ip);	
	$user_id = $CURUSER['id'];
	
	$res = mysqli_query($con_link, "SELECT id FROM proxy_ip WHERE userid=$user_id AND ip=$ip");
	$row = mysqli_fetch_array($res);
	if (!$row)
		{
		$added = sqlesc(get_date_time());
		mysqli_query($con_link, "INSERT INTO proxy_ip (userid, ip, added) VALUES ($user_id, $ip, $added)");
		}
	}

function site_error_message2($heading, $text, $color="red")
	{
//	site_header();
	print "<table class=main border=0 width=60% cellpadding=0 cellspacing=0><tr><td class=embedded>";
//	tabel_top ($heading);
	print "<table width=100% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded align=center><br>";
	print "<center><font size=2 color=$color><b>" . $text . "</b></font></center><br>";
	print "</td></tr></table>";
	print "</td></tr></table><br>";
	tabel_einde();
	site_footer();
	die;
	}

function site_error_message($heading, $text, $color='red')
	{
	site_header();
	print "<table class=main border=0 width=60% cellpadding=0 cellspacing=0><tr><td class=embedded>";
	tabel_top ($heading);
	print "<table width=100% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded align=center><br>";
	print "<center><font size=2 color=$color><b>" . @$text . "</b></font></center><br>";
	print "</td></tr></table>";
	print "</td></tr></table><br>";
	tabel_einde();
	site_footer();
	die;
	}

function new_error_message($heading, $text, $color="red", $sluiten=0)
	{
	new_header();
	if ($sluiten > 0)
		print "<BODY onLoad=\"setTimeout(window.close, ".$sluiten.")\">";
		
	site_menu(false);
	print "<br>";
	print "<table class=main border=0 width=60% cellpadding=0 cellspacing=0><tr><td class=embedded>";
	tabel_top ($heading);
	print "<table width=100% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded align=center><br>";
	print "<center><font size=2 color=$color><b>" . $text . "</b></font></center><br>";
	print "</td></tr></table>";
	print "</td></tr></table><br>";
	new_footer(false);
	die;
	}

function sitemsg($heading, $text, $width=100, $center="center")
{
	print "<br><table class=main border=0 width=" . $width . "% cellpadding=0 cellspacing=0><tr><td class=embedded><div align=" . $center . ">";
	tabel_top ($heading, "center");
	print "<table width=100% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded align=center><br>";
	print "<center><font size=3 color=red><b>" . $text . "</b></font></center><br>";
	print "</td></tr></table>";
	print "</td></tr></table><br>";
}

// scheldwoord systeem
function scheld($tekst){
    $woorden = array(
	'tyfus',
	'kankerkop',
	'fuck', 
	'shit',
	'kutje',
	'kut',
	'kanker',
	'jood',
	'kankerlijer',
	'homo');

$aantal = count($woorden);
for ($var = 0; $var < $aantal; $var++ )
{
$tekst = @preg_replace($woorden[$var], 'Ongepast Woord', $tekst);
}

return $tekst;

    //return eregi_replace($scheldwoorden, '****', $p_sText);
}
// Scheldwoord eind

function set_max_torrents($userid)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$userid = 0 + $userid;
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);

	if ($row["uploaded"] > 0 || $row["downloaded"] > 0 )
		{
		if ($row["downloaded"] > 1024 )
			{
			$ratio = floor(($row["uploaded"] / $row["downloaded"]) * 100) / 100;
			$maxtorrents = 2;
			if ($ratio > 0.60) $maxtorrents = 3;
			if ($ratio > 1) $maxtorrents = 4;
			if ($ratio > 2) $maxtorrents = 5;
			if ($row['class'] > 1) $maxtorrents = 5;
			if ($row['class'] > 2) $maxtorrents = 10;
				
			$userid = $row['id'];
			mysqli_query($con_link, "UPDATE users SET maxtorrents = maxtorrents_extra + $maxtorrents WHERE id=$userid");
			}
		}
	}

function site_header($title = "", $msgalert = true)
	{
	global $DEFAULTBASEURL, $CURUSER, $_SERVER, $PHP_SELF, $SITE_ONLINE, $SITE_NAME, $krediet_groot, $aktie_vandaag, $aktie_text;
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);

	if (!$SITE_ONLINE)
		die("De pagina's zijn geloten wegens een storing... Even geduld a.u.b. Ons excuus... Nee dit komt niet door Brein... LOL<br>");
	
	if ($title == "")
		$title = $SITE_NAME;
	else
		$title = $SITE_NAME . " : " . htmlspecialchars($title);

	if ($msgalert && $CURUSER)
		{
//		$res = mysqli_query($con_link, "SELECT COUNT(*) FROM messages WHERE receiver=" . $CURUSER["id"] . " && unread='yes'") or die("OopppsY!");
	    $res = mysqli_query($con_link, "SELECT COUNT(*) FROM messages WHERE receiver=" . $CURUSER["id"] . " AND location IN ('in', 'both') AND unread='yes'") or print(mysqli_error());
		$arr = mysqli_fetch_row($res);
		$unread = $arr[0];
		}

	if (get_user_class() <= UC_UPLOADER)
		{
		if (@$unread)
			header("Location: $DEFAULTBASEURL/inbox.php");
		}	
	
	print "<html><head><title>$title</title>\n";
	print "<link rel=stylesheet href='default.css' type='text/css'>";
	if($_SERVER['SCRIPT_NAME'] != "/upload.php" || get_user_class() < UC_UPLOADER){
	}
	
	print "</head><body>";
	
	menu_top();
	
	$w = "width=100%";
	$fn = substr($PHP_SELF, strrpos($PHP_SELF, "/") + 1);
	
	print "<table width=100% style='background: transparent' border=0 cellspacing=0 cellpadding=0>";
	print "<tr><td align=center class=embedded><center>";

	if ($CURUSER)
		if ($aktie_vandaag)
			print $aktie_text;

	if (@$unread)
		site_mail(@$unread);

	print "<br><center>";
		
	if ($CURUSER['donor'] == "no")
	{	$controle = controleer_bedankjes(); 		if ($controle)			melding_bedankjes($controle);		}
	}

function site_footer()
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	
	mysqli_close($con_link);
	print("</td></tr></table>\n");
	print("<table class=footer  align=center width=100% border=0 cellspacing=10 cellpadding=10><tr valign=top>\n");
	print("<table align=center width=70% border=0 cellspacing=10 cellpadding=10>\n");	
	print("<tr class=footer align=center width=75%>\n");
	print("<td align=left width=50% border=0 cellspacing=10 cellpadding=10>\n");
    print("<font size=4 color=white><a style='color:#ff0033!important; font-size:18px;'><br>Stem op ons</a></font><br><br>\n");
	print("<a href=https://seedhost.eu><img src=pic/support/support.gif></a><br><br><br><br><br><br></td>\n");
	print("<td align=left width=50% border=0 cellspacing=10 cellpadding=10>\n");
    print("<font size=4 color=white><a style='color:#ff0033!important; font-size:18px;'>Disclaimer</a><br><p>Geen van de bestanden hier getoond zijn te vinden op deze server. De links zijn gepost door de gebruikers van deze site.</br> De administrator van deze site kan niet verantwoordelijk worden gehouden voor wat zijn gebruikers posten, of enige andere acties van zijn gebruikers.</br> Je mag deze site niet gebruiken om enig materiaal te downloaden/verspreiden als je daartoe niet de legale rechten hebt.</br> Het is je eigen verantwoordelijkheid om je aan de regels te houden. </br></br></br></br></p></font>\n");	
	print("	</td></tr>\n");	  
	print("</table>\n");	
	print("</tr></table>\n");
	print("</body></html>\n");
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function menu_top()
	{
	global $SITE_NAME, $CURUSER, $ONDERHOUD, $SV;
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
        if ($CURUSER)
                {
                $credits = $CURUSER['credits'];
$bonus = $CURUSER['bonus_punten'];

				                $maxtorrents = $CURUSER['maxtorrents'];
                $peers = get_row_count("peers", "WHERE userid=$CURUSER[id]");
                $seeding = get_row_count("peers", "WHERE userid=$CURUSER[id] AND seeder='yes'");
                $leeching = $peers - $seeding;
                $uped = mksize($CURUSER['uploaded']);
                $downed = mksize($CURUSER['downloaded']);
                $verschil = mksizegb($CURUSER['uploaded'] - $CURUSER['downloaded']);
                $donor = $CURUSER['donor'];
                $warned = $CURUSER['warned'];
                $ratio = number_format((($CURUSER["downloaded"] > 0) ? ($CURUSER["uploaded"] / $CURUSER["downloaded"]) : 0),2);

                $verb = mysqli_query($con_link, "SELECT * FROM peers WHERE userid=" . $CURUSER["id"] . "") or print(mysqli_error());
                $varb = @mysqli_fetch_array($verb);
                $verbindbaar = $varb['connectable'];
                $res5 = mysqli_query($con_link, "SELECT maxtorrents FROM users WHERE id=" . sqlesc($CURUSER["id"]) . " LIMIT 1") or print(mysqli_error());
                $arr = mysqli_fetch_assoc($res5);
                $max = "$arr[maxtorrents]";
                $res3 = mysqli_query($con_link, "SELECT connectable FROM peers WHERE userid=" . sqlesc($CURUSER["id"]) . " LIMIT 1") or print(mysqli_error());
                if($row = mysqli_fetch_row($res3)){
                $connect = $row[0];
                if($connect == "yes"){
                $connectable = "<b><font color=limegreen><a title='Connectable = Yes'>Ja</a></font></b>";
                }else{
                $connectable = "<b><font color=red><a title='Connectable = No'>Nee</a></font></b>";
                }
                }else{
                $connectable = "<b><font color=red><a title='Unknow'>Onbekend</a></font></b>";
                }
                /// lords port  checker
                $res = mysqli_query($con_link, "SELECT port FROM peers WHERE userid=" . sqlesc($CURUSER["id"]) . " LIMIT 1") or print(mysqli_error());
                if (mysqli_num_rows($res) == 1)
                {
                $arr = mysqli_fetch_assoc($res);
                $port = "$arr[port]";

                if($connect == "no"){
                $port ="<b><font color=#CC9900>$port</font>";
                }else{
                $port = "<font color=#CC9900></font> $arr[port]";
                }
                }else{
                $port = "<b>Wacht</b>";
                }


                $res1 = mysqli_query($con_link, "SELECT COUNT(*) FROM messages WHERE receiver=" . $CURUSER["id"] . " AND location IN ('in', 'both')") or print(mysqli_error());
                $arr1 = mysqli_fetch_row($res1);
                $messages = $arr1[0];
                $res1 = mysqli_query($con_link, "SELECT COUNT(*) FROM messages WHERE receiver=" . $CURUSER["id"] . " AND location IN ('in', 'both') AND unread='yes'") or print(mysqli_error());
                $arr1 = mysqli_fetch_row($res1);
                $unread = $arr1[0];
                $res1 = mysqli_query($con_link, "SELECT COUNT(*) FROM messages WHERE sender=" . $CURUSER["id"] . " AND location IN ('out', 'both')") or print(mysqli_error());
                $arr1 = mysqli_fetch_row($res1);
                $outmessages = $arr1[0];
                $res1 = mysqli_query($con_link, "SELECT COUNT(*) FROM messages WHERE receiver=" . $CURUSER["id"] . " && unread='yes'") or die("OopppsY!");
                $arr1 = mysqli_fetch_row($res1);
                $unread = $arr1[0];
                if ($unread)
                        $unreadtext = "&nbsp;nieuw";
                else
                        $unreadtext = "";
                }

         print "<table align=top width=100% border=0 cellspacing=0 cellpadding=0>";
    
		
		if ($CURUSER)
                {
                print "<table align=center width=80% border=0 cellspacing=3 cellpadding=4 class=site_info>";
                print "<tr><td width=17% class=site_info>";
                if ($CURUSER['donor'] == 'yes')
                print "<a class=altlink_red href=userdetails.php?id=$CURUSER[id]>$CURUSER[username]</a><img height=14 width=14 src=pic/system/star.gif border=0 style='margin-left: 2pt'>";
                else
                print "<a class=altlink_black href=userdetails.php?id=$CURUSER[id]>$CURUSER[username]</a>";
				print ", <a class=altlink_white href=logout.php>Afmelden</a>";
				print "</td><td width=17% class=site_info>";
				print "<a class=altlink_white href='friends.php'>Vrienden</a>";
				print "</td><td  width=30% class=site_info2>";

			
          		if (get_user_class() <= UC_UPLOADER)
  			    print "<input type=submit style='width:-webkit-fill-available!important;display: inline-block;max-width: 40%!important;' value='TORRENT PROGRAMMA' onclick=window.open('https://torrentmedia.org/rutorrent.php?','_blank') 						class=btn></form>";
          
				print "</td><td  width=35% class=site_info>";
          		print "<p style='font-size: 3rem!important;font-weight:600;position: absolute;color:#fff!important;'> " . $SITE_NAME . " </p>";        
       			print "</td></tr>";
				
				
print "<tr><td class=site_info>";
				print "<b><font color=black>GB verschil:</b> ";
				if ($verschil > 0)
                print "<font color=#b0fd59>+ $verschil</font>";
                else
                print "<font color=#ff0000>- $verschil</font>";
        print "</td><td class=site_info>";
	            print "<a class=altlink_white href=inbox.php>Postvak IN:</a> $messages - $unread $unreadtext";
        print "</td></tr>";

print "<tr><td class=site_info>";
				print "<b><font color=black>Ratio:</b> ";
				if ($ratio >= 1.0)
                print "<font color=#b0fd59>$ratio</font>";
				else
				print "<font color=red>$ratio</font>";
		print "</td><td class=site_info>";
				print "<a class=altlink_white href=inbox.php?out=1>Postvak UIT:</a> $outmessages";
        print "</td></tr>";
				
print "<tr><td class=site_info>";
				print "<b><font color=black>Upload:</b> $uped";
		print "</td><td class=site_info>";
				print "<b><font color=black> Krediet:</b> ";
				if ($credits < 1)
                print "geen <a class=altlink_black href=donatie.php>(kopen)</a>";
                else
                print "$credits <a class=altlink_#500000 href=credits.php>(gebruik)</a>";
		print "</td></tr>";

print "<tr><td class=site_info>";
				print "<b><font color=black>Download:</b> $downed";
		print "</td><td class=site_info>";
				print "<b><font color=black>Bonus: </b>";
				if ($bonus < 1)
                print "geen BP <a class=altlink_white href=credits.php>(kopen)</a>";
				else
                print "$bonus BP";
        print "</td></tr>";
				
print "<tr><td class=site_info>";
		        print "<b><font color=black>Seeding: $seeding <img border=0 src=/pic/pic_upload.png></b>";
        print "</td><td class=site_info>";        
				print "<b><font color=black>Max Torrents: $maxtorrents</b>";
		print "</td></tr>";

print "</tr><td class=site_info>";
				print "<b><font color=black>Leeching: $leeching <img border=0 src=/pic/pic_downl.png></b>";			
		print "</td><td class=site_info>";
				print "<b><font color=black>Poort:</b> $port";
        print "</td></tr>";
        print "<tr><td class=embedded>";

        $added = get_date_time();
        print "</td></tr>";
		 }
        print "</table>";
		
		site_menu();
		
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//====SMS BALK
	
    print "<table border=0 width=100% cellpadding=0 cellspacing=8><tr><td align=center class=embedded><table width=100% class=bottom1 cellspacing=0 cellpadding=8><tr>";
	if ($CURUSER["id"] == 3 || $CURUSER["id"] == 5 || $CURUSER["id"] == 8) 
	print "<td width=120>&nbsp;<a href=\"site_promo.php\"><b><font color=gold>PROMO</b></a>&nbsp;</td></font>";
	print "<td align=center><center><marquee scrollamount=6 scrolldelay=50 truespeed><div style=\"font-size: 18px; color: #fff\">".$SV['promo_text']."</div></marquee></center></td><td width=120>&nbsp;</td></tr></table>";
	print "</table></br>";

	//====EIND SMS BALK	
	/////////////////////////////////////tijdzone met dagen begin//////////////////////////////////////////////////



print("<table width=20% align=center class=bottom1 border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>");
// dag van de week array
$Dag = array ("<font color=gold size=5>Vandaag is het Zondag", "<font color=gold size=5>Vandaag is het Maandag", "<font color=gold size=5>Vandaag is het Dinsdag", "<font color=gold size=5>Vandaag is het Woensdag", "<font color=gold size=5>Vandaag is het Donderdag", "<font color=gold size=5>Vandaag is het Vrijdag", "<font color=gold size=5>Vandaag is het Zaterdag");
 
// maand array
$Maand = array("Niet", "Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December");
 
 
  $w = date("w");
  $j = date("j");
  $n = date("n");
  $Y = date("Y");
 
echo $Dag[$w] . ", " . $j . " " . $Maand[$n] . " " . $Y . "&nbsp;";  //datum laten zien

print "<br>";

/////////////////////////////////////////tijdzone met dagen eind//////////////////////////////////////////////////
			if ($CURUSER['override_class'] != 255 && $CURUSER) 
	{
		print("<p><table width=115% border=0 cellspacing=0 cellpadding=10 bgcolor=800008 align=center><tr><td style='padding: 10px; background: #235dcb'>\n");
		print("<b><a href=".@$BASEURL."/restoreclass.php><font color=F5DEB3;>U bent online onder een lagere rang. Klik hier om te herstellen.</font></a></b>");
		print("</table></p>\n");
	}
        print "</td></tr></table>";	
		
	if ($CURUSER)
		{
		if ($SV['service'] == 'ja')
			balk($SV['service_text']);

		if ($ONDERHOUD)
			balk($ONDERHOUD);
		if ($donor == 'no' && $ratio > 0.1 && $ratio < 0.6)
			balk_error(">>> UW RATIO IS LAGER DAN IS TOEGESTAAN, DOE HIER SNEL IETS AAN !!! <<<");
		if ($donor == 'no' && $warned == 'yes')
			balk_error(">>> U BENT GEWAARSCHUWD VOOR HET NIET HOUDEN AAN DE ".$SITE_NAME." REGELS !!! <<<");
		if ($CURUSER['blocked'] == "yes")
			{
			$block_text = "<font color=white size=4><b>";
			$block_text .= "UW ACCOUNT IS GEBLOKKEERD OP " . convertdatum($CURUSER['blocked_date']) . "<br>";
			$block_text .= "DOOR <a class=altlink_white href=sendmessage.php?receiver=".$CURUSER['blocked_by'].">" . get_username($CURUSER['blocked_by']) . "</a><br>";
			$block_text .= "REDEN:" . htmlspecialchars($CURUSER['blocked_reason']) . "<br>";
			$block_text .= "U KUNT GEEN NIEUWE TORRENTS MEER DOWNLOADEN<br>";
			$block_text .= "<a class=altlink_white href=sendmessage.php?receiver=".$CURUSER['blocked_by'].">DRUK HIER OM " . get_username($CURUSER['blocked_by']) . " EEN BERICHT TE STUREN</a>";
			print "<table align=center class=main border=0 width=100% cellpadding=0 cellspacing=0>";
			print "<tr><td align=center class=embedded>";
			print "<table width=100% class=bottom1 cellspacing=0 cellpadding=10><tr>";
			print "<td align=center bgcolor=red><center>$block_text</center></td>";
			print "</td></tr></table>";
			print "</td></tr></table>";
			}
		}
	}


function balk($msg)
	{
	print "<table align=center border=0 width=100% cellpadding=0 cellspacing=0>";
	print "<tr><td align=center class=embedded>";
	print "<table width=100% class=bottom1 cellspacing=0 cellpadding=0><tr>";
	print "<td align=center bgcolor=red class=nav_site><font color=white><center>$msg</center></td>";
	print "</td></tr></table>";
	print "</td></tr></table>";
	}

function site_mail($unread)
	{
	global $DEFAULTBASEURL;
	print "<table align=center border=1 width=60% cellpadding=0 cellspacing=0>";
	print "<tr><td align=center class=embedded>";
	print "<table width=100% class=bottom1 cellspacing=0 cellpadding=0><tr>";
	if ($unread > 1)
		print "<td width=100 class=nav_site><center><a class=altlink_white href=$DEFAULTBASEURL/inbox.php><img border=0 height=25 width=36 src='/pic/mail.gif'></a></center></td><td align=center class=nav_site><font size=2><center><a class=altlink_white href=$DEFAULTBASEURL/inbox.php><font color=white>U heeft $unread nieuwe berichten. (klik hier om uw berichten te bekijken)</font></a></center></td><td width=100 class=nav_site><center><a class=altlink_white href=$DEFAULTBASEURL/inbox.php><img border=0 height=25 width=36 src='/pic/mail.gif'></a></center></td>";
	else
		print "<td width=100 class=nav_site><center><a class=altlink_white href=$DEFAULTBASEURL/inbox.php><img border=0 height=25 width=36 src='/pic/mail.gif'></a></center></td><td align=center class=nav_site><font size=2><center><a class=altlink_white href=$DEFAULTBASEURL/inbox.php><font color=white>U heeft $unread nieuw bericht. (klik hier om uw bericht te bekijken)</font></a></center></td><td width=100 class=nav_site><center><a class=altlink_white href=$DEFAULTBASEURL/inbox.php><img border=0 height=25 width=36 src='/pic/mail.gif'></a></center></td>";
	print "</td></tr></table>";
	print "</td></tr></table></p>";
	}

function balk_error($msg)
	{
	print "<table align=center class=site_bar_red border=0 width=100% cellpadding=0 cellspacing=0>";
	print "<tr><td align=center class=embedded>";
	print "<table width=100% class=bottom1 cellspacing=0 cellpadding=10><tr>";
	print "<td align=center class=nav_site><font color=red><center>$msg</center></td>";
	print "</td></tr></table>";
	print "</td></tr></table>";
	}

function tabel_top($msg, $align="",$width=100)
	{
	print "<table align=center class=site border=0 cellpadding=0 cellspacing=0>";
	print "<tr><td class=embedded>";
	print "<table width=100% class=bottom1 cellspacing=0 cellpadding=0><tr>";
	if ($align == "")
		print "<td class=nav_site><font size=3 color=white>&nbsp;&nbsp;$msg</td>";
	else
		print "<td class=nav_site ><font size=3 color=white><div align=" . $align . ">&nbsp;&nbsp;$msg&nbsp;&nbsp;</td>";
	print "</td></tr></table>";
	print "</td></tr></table>";
	}

function page_start($width=100)
	{
	print "<table width=$width% border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>\n";
	}

function page_einde()
	{
	print "</td></tr></table><br>\n";
	}

function tabel_start($width=98, $cellpadding=0,$table_width=90,$paddingmain=10)
	{
	print("<table align=center width=".$table_width."% border=0 cellspacing=0 ,$paddingmain><tr><td style=background-color:rgba(0,0,0,0.4)!important;border-radius:15px;padding:2rem;><br>");
	print("<table align=center border=0 width=$width% cellspacing=0 cellpadding=$cellpadding><tr><td><div align=center>");
	}

function tabel_einde()
	{
	print "</td></tr></table><br>";
	print "</td></tr></table>";
	}

function mod_knop1($link, $text, $achtergrond_kleur = "#235dcb", $tekst_kleur = "white")
	{
	if ($link)
		{
		print "<form method=get action='".$link."'>";
		print "<input type=submit style='font-size:14px;background-color:".$achtergrond_kleur.";color:".$tekst_kleur.";font-weight:bold' value='".$text."'>";
		print "</form>";
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
function site_menu($normaal=true)
	{
	global $CURUSER;
	print "<table align=center class=bottom1 border=0 width=100% cellpadding=0 cellspacing=0>";
	print "<tr><td class=embedded>";
	print "<table width=100% class=bottom1 cellspacing=0 cellpadding=10><tr>";

	if (!$CURUSER)
		{ 
	print "";
//		print "<td class=nav_site><div align=right><a class=nav_site href=login.php>Inloggen</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
//		print "<td class=nav_site><div align=left><a class=nav_site href=/signup.php>Registeren</a></td>";
//		print "<td class=nav_site><a class=nav_site href=/information.php>Informatie</a></td>";
		}
	else
		{
		if ($normaal)
			$link_class = "altlink_white";
		else
			$link_class = "altlink_white";
		print "<td class=nav_site>".mod_knop1("browse.php","Torrents","rgba(0,0,0,0.5)")."</td>";
		print "<td class=nav_site>".mod_knop1("shoutbox.php","Shout","rgba(0,0,0,0.5)")."</td>";
		if (get_user_class() >= UC_UPLOADER)
		print "<td class=nav_site>".mod_knop1("upload_info.php","Upload","rgba(0,0,0,0.5)")."</td>";
        else
		print "<td class=nav_site>".mod_knop1("upload_aanvraag.php","Upload aanvraag","rgba(0,0,0,0.5)")."</td>";
		print "<td class=nav_site>".mod_knop1("my.php","Profiel","rgba(0,0,0,0.5)")."</td>";
		print "<td class=nav_site>".mod_knop1("verzoekjes.php","Verzoekjes","rgba(0,0,0,0.5)")."</td>";		
		print "<td class=nav_site>".mod_knop1("credits.php","Krediet","rgba(0,0,0,0.5)")."</td>";
		print "<td class=nav_site>".mod_knop1("donatie.php","Doneren","rgba(0,0,0,0.5)")."</td>";	
		print "<td class=nav_site>".mod_knop1("site_regels.php","Regels","rgba(0,0,0,0.5)")."</td>";	
		print "<td class=nav_site>".mod_knop1("staff.php","Staf","rgba(0,0,0,0.5)")."</td>";

		if (get_user_class() >= UC_ADMINISTRATOR)
			{
		print "<td class=nav_site>".mod_knop1("Moderator.php","Mod","rgba(0,0,0,0.5)")."</td>";
			
		if (get_user_class() >= UC_OWNER)
			{				
		print "<td class=nav_site>".mod_knop1("God.php","God","rgba(0,0,0,0.5)")."</td>";	
//if (get_user_class() <= UC_OWNER)
//			{
//		print "<td class=nav_site><a class=$link_class href=http://hotsspots.com/forum/><font color=red>HotsSpots</font></a></td>";
//		}
//		print "<td class=nav_site><a class=$link_class href=/shoutbox.php>Shout</a></td>";
			

		
//		if (get_user_class() >= UC_OWNER || $CURUSER['donor'] == "yes")
//			print "<td class=nav_site><a class=$link_class href=/donateur.php><font color=red>Donateurs</font></td>";
//		print "<td class=nav_site><a class=$link_class href=/verwacht.php>Verwacht</a></td>";
//		if (get_user_class() >= UC_POWER_USER)
//			print "<td class=nav_site><a class=$link_class href=/bookmarks.php>Favorieten</a></td>";
//		if (get_user_class() >= UC_UPLOADER)
		//	print "<td class=nav_site><a class=$link_class href=/upload_info.php>Upload</a></td>";//////////////////////////////////////////////
	//	else 
	//		print "<td class=nav_site><a class=$link_class href=/uploader_aanvraag.php>Uploader&nbsp;aanvraag</a></td>";
	//	if (get_user_class() >= UC_UPLOADER)
	//		print "<td class=nav_site><a class=$link_class href=/uploadnzb.php>Upload NZB'S</a></td>";

	//	print "<td class=nav_site><a class=$link_class href=/my.php>Profiel</a></td>";
	//	print "<td class=nav_site><a class=$link_class href=/forums.php>Forum</a></td>";
	//	print "<td class=nav_site><a class=$link_class href=/partner.php><font color=red>Partners</font></a></td>";
	//	if (get_user_class() >= UC_OWNER)
	//		{
	//		$aantal_claims = get_row_count("donations_claim","WHERE verwerkt='no' AND code != '-'");
	//		$aantal_donaties = get_row_count("donations","WHERE date=".sqlesc(date("Y-m-d")));
	//		$aantal_betaald = get_row_count("donations_registratie","WHERE date=".sqlesc(date("Y-m-d")));
	//		print "<td class=nav_site><a class=$link_class href='donatie_admin.php'>".$aantal_donaties." (".$aantal_claims.") - ".$aantal_betaald."</a></td>";
	//		}
	//	else
	//		print "<td class=nav_site><a class=altlink_lblue href='credits.php'>Krediet</a></td>";
	//	print "<td class=nav_site><a class=$link_class href='donatie.php'>Doneren</a></td>";
	//	print "<td class=nav_site><a class=$link_class href=/information.php><font color=red>Info</font></a></td>";
//		print "<td class=nav_site><a class=$link_class href=/helpdesk_info.php>Helpdesk</a></td>";
//		print "<td class=nav_site><a class=$link_class href=/helpdesk/admin/admin_main.php>Helpdesk</a></td>";		
	//	print "<td class=nav_site><a class=$link_class href=/staff.php>Staf</a></td>";
//		if (get_user_class() >= UC_MODERATOR)
//			{
//			print "<td class=nav_site><a class=$link_class href=moderator_links.php><font color=red>MOD</font></a></td>";
//			print "<td class=nav_site><a class=$link_class href=god_links.php><font color=gold>GOD</font></a></td>";			
//			}
//	if (get_user_class() >= UC_ADMINISTRATOR)
//		{
//		$registered = number_format(get_row_count("users", "WHERE status='confirmed'"));
//		print "<td class=nav_site><a class=altlink_red href=informatie_ucgod.php>".$registered."</a></td>";
		}
		}
		}
	print "</td></tr></table>";


//////////////////////////////////////////////  aktieknoppen tekst begin///////////////////////

	if (@$SV['omschrijving'] == 'ja')
		{
			print"<form method=get action=aktie_donatie.php>";
			print"<table background=/pic/site/table_top.gif border=0 width=100% cellpadding=0 cellspacing=8><tr><td align=center class=embedded><table width=100% class=bottom cellspacing=0 cellpadding=8><tr><td align=center class=top_site>
			<b><font size=3 color=white></font></b></td> 
			</td></tr></table></td></tr></table></form>";
		}
			
//if (get_row_count("aktie_donatie","") > 0)
//	{
//	$res = mysqli_query($con_link, "SELECT * FROM aktie_donatie") or sqlerr(__FILE__, __LINE__);
//	while ($row = mysqli_fetch_assoc($res))
//		{
//		print "<table class=bottom width=100% height=45 border=0 cellspacing=0 cellpadding=0><tr><td class=nav_site onMouseOver=javascript:this.style.background='#868484'; onMouseOut=this.style.background=''; onClick=location.href='/donatie.php'><div align=center><font size=5>\n";
//		print "<a class=altlink_blue href='/donatie.php'><font color=red><center><b>";
   /*     ?><font size=5><center><b><?*/
//                print "".htmlspecialchars($row['omschrijving'])."";
	/*	?></center><?  */
//		print "</td></tr></table><center>";
//	    }
//    }

		$actiemoderator = $CURUSER['actiemoderator'];
		if ($actiemoderator == "yes")
		{
			print "<table  align=center border=0 width=100% cellpadding=0 cellspacing=0><tr><td align=center class=embedded><table width=100% class=bottom cellspacing=0 cellpadding=10><tr><td align=center class=nav_site><font color=red><center><font size=4 color=red><center><marquee width=100% behavior=alternate scrollamount=3> *** Uploaders Gezocht meld je aan via Uploader aanvraag of bij een stafflid *** </marquee></center></td></tr></table></td></tr></table>";
			print("</td></tr></table></td></tr></table>");
		}

	$actieuploader = $CURUSER['actieuploader'];
	if ($actieuploader == "yes")
	{
	print "<table  align=center border=0 width=100% cellpadding=0 cellspacing=0><tr><td align=center class=embedded><table width=100% class=bottom cellspacing=0 cellpadding=10><tr><td align=center class=nav_site><font color=red><center><font size=4 color=red><center><marquee width=100% behavior=alternate scrollamount=3></marquee></center></td></tr></table></td></tr></table>";
	print("</td></tr></table></td></tr></table>");
	}

	$actieadmin = $CURUSER['actieadmin'];
	if ($actieadmin == "yes")
	{
	print "<table  align=center border=0 width=100% cellpadding=0 cellspacing=0><tr><td align=center class=embedded><table width=100% class=bottom cellspacing=0 cellpadding=10><tr><td align=center class=nav_site><font color=#FFFF00><center><font size=4 color=red><center><marquee width=100% behavior=alternate scrollamount=3> *** Moderators Gezocht meld je aan bij <a href=https://www.topspinner.org/sendmessage.php?receiver=3>TorrentMedia</a><----</marquee></center></td></tr></table></td></tr></table>";
	print("</td></tr></table></td></tr></table>");
	}

	$actie2009 = @$CURUSER['actie2010'];
	if (@$actie2007 == "yes")
	{
	print("<table  width=100% border=0 cellspacing=0 cellpadding=0>
	<table class=bottom1 width=100% height=30 border=0 cellspacing=0 cellpadding=0><tr>
	<td class=embedded ><div align=center class=top_style>");
	print("<b><font size=4 color=white><center>ACTIE! NIEUW JAAR, NIEUWE KANSEN! DAAROM GEEN 8 GB VOOR 8 euro. MAAR 20 GB VOOR 8 euro plus 4 krediet punten!</center></td>");
	print("</td></tr></table></td></tr></table>");
	}

	$actieserver = $CURUSER['actieserver'];
	if ($actieserver == "yes")
	{
	print("<table  width=100% border=0 cellspacing=0 cellpadding=0>
	<table class=bottom1 width=100% height=30 border=0 cellspacing=0 cellpadding=0><tr>
	<td class=embedded ><div align=center class=top_style>");
	print("<b><font size=4 color=white><center>Er wordt momenteel aan de site gewerkt. Sorry voor het ongemak.</center></td>");
	print("</td></tr></table></td></tr></table>");
	}

	$actiest = @$CURUSER['actiest'];
	if ($actiest == "yes")
	{
	print("<table  width=100% border=0 cellspacing=0 cellpadding=0>
	<table class=bottom1 width=100% height=30 border=0 cellspacing=0 cellpadding=0><tr>
	<td class=embedded ><div align=center class=top_style>");
	print("<b><font size=5 color=white><center>Wie plaatst de 400ste torrent en verdient 25 kredietpunten!!</center></td>");
	print("</td></tr></table></td></tr></table>");
	}
	
	$waarschuwing = $CURUSER['waarschuwing'];
	if ($waarschuwing == "yes")
	{
	print("<table  width=100% border=0 cellspacing=0 cellpadding=0>
	<table class=bottom1 width=100% height=30 border=0 cellspacing=0 cellpadding=0><tr>
	<td class=embedded ><div align=center class=top_style>");
	print("<b><font size=5 color=C711585><center>Wij gaan op waarschuwing controleren vandaag.</center></td>");
	print("</td></tr></table></td></tr></table>");
	}

	$ratio = $CURUSER['ratio'];
	if ($ratio == "yes")
	{
	print("<table  width=100% border=0 cellspacing=0 cellpadding=0>
	<table class=bottom1 width=100% height=30 border=0 cellspacing=0 cellpadding=0><tr>
	<td class=embedded ><div align=center class=top_style>");
	print("<b><font size=4 color=lime><center>Er zullen  nagenoeg geen warnings meer gegeven worden aan Hit en Runners maar zij worden direct beloond met een blokkade. Laat het niet zover komen.
	</center></td>");
	print("</td></tr></table></td></tr></table>");
	}

	$doneer1 = $CURUSER['doneer1'];
	if ($doneer1 == "yes")
	{
print("<table  width=100% border=0 cellspacing=0 cellpadding=0>
<table class=bottom1 width=100% height=30 border=0 cellspacing=0 cellpadding=0><tr>
<td class=embedded ><div align=center class=top_style>");
print("<b><a href=$BASEURL/donatie.php?action=telefoon><font size=4 color=white><center>Doneer nu 2,50 en krijg 5 krediet punten dat is goed voor een ratio correctie van 18gb!</center></td>");
print("</td></tr></table></td></tr></table>");
}

$doneer2 = $CURUSER['doneer2'];
if ($doneer2 == "yes")
{
print("<table  width=100% border=0 cellspacing=0 cellpadding=0>
<table class=bottom1 width=100% height=30 border=0 cellspacing=0 cellpadding=0><tr>
<td class=embedded ><div align=center class=top_style>");
print("<b><a href=$BASEURL/donatie.php?action=telefoon1><font size=4 color=white><center>Doneer nu 5 euro en krijg 12 krediet punten dat is goed voor een ratio correctie van 45gb!</center></td>");
print("</td></tr></table></td></tr></table>");
}

$doneer3 = $CURUSER['doneer3'];
if ($doneer3 == "yes")
{
print("<table  width=100% border=0 cellspacing=0 cellpadding=0>
<table class=bottom1 width=100% height=30 border=0 cellspacing=0 cellpadding=0><tr>
<td class=embedded ><div align=center class=top_style>");
print("<b><a href=$BASEURL/donatie.php?action=telefoon2><font size=4 color=white><center>Doneer nu 7,50 en krijg 16 krediet punten dat is goed voor een ratio correctie van 60gb!</center></td>");
print("</td></tr></table></td></tr></table>");
}

$actieinfo = $CURUSER['actieinfo'];
if ($actieinfo == "yes")
{
$registered = number_format(get_row_count("users", "WHERE status='confirmed'"));
$unverified = number_format(get_row_count("users", "WHERE status='pending'"));
$torrents = number_format(get_row_count("torrents"));

$peers = get_row_count("peers", "");
$seeders = get_row_count("peers", "WHERE seeder='yes'");
$leechers = $peers - $seeders;

if ($leechers == 0)
        $ratio = 0;
else
        $ratio = round($seeders / $leechers * 100);

$peers = number_format($peers);
$seeders = number_format($seeders);
$leechers = number_format($leechers);
print("<table  width=100% border=0 cellspacing=0 cellpadding=0>
<table class=bottom1 width=100% height=30 border=0 cellspacing=0 cellpadding=0><tr>
<td class=embedded ><div align=center class=top_style>");
print("<b><font size=3 color=orange><center>Geregistreerde gebruikers&nbsp;:&nbsp;&nbsp;" . $registered . "&nbsp;&nbsp;&nbsp;&nbsp;<font color=mediumvioletred>Torrents&nbsp;:&nbsp;&nbsp;" . $torrents . "&nbsp;&nbsp;&nbsp;&nbsp;<font color=mediumvioletred>Bronnen&nbsp;:&nbsp;&nbsp;" . $peers . "&nbsp;&nbsp;&nbsp;&nbsp;<font color=mediumvioletred>Delers&nbsp;:&nbsp;&nbsp;" . $seeders . "&nbsp;&nbsp;&nbsp;&nbsp;<font color=mediumvioletred>Ontvangers&nbsp;:&nbsp;&nbsp;" . $leechers . "&nbsp;&nbsp;&nbsp;&nbsp;<font color=mediumvioletred>Deel/ontvangverhouding (%)&nbsp;:&nbsp;&nbsp;" . $ratio . "%</center></td>");
print("</td></tr></table></td></tr></table>");
}
print "</td></tr></table>";
}

	 ////////////////////////////////////////// aktieknoppen einde //////////////////////
function get_tijdverschil($van,$tot)
{
  $mins = floor(($tot - $van) / 60);
  $hours = floor($mins / 60);
  $mins -= $hours * 60;
  $days = floor($hours / 24);
  $hours -= $days * 24;
  $weeks = floor($days / 7);
  $days -= $weeks * 7;
  $t = "";
  if ($weeks > 0)
  	if ($weeks > 1) return "$weeks weken"; 
	else return "$weeks week";
  if ($days > 0)
  	if ($days > 1) return "$days dagen"; 
	else return "$days dag";
  if ($hours > 0)
  	if ($hours > 1) return "$hours uur"; 
	else return "$hours uur";
  if ($mins > 0)
  	if ($mins > 1) return "$mins minuten"; 
	else return "$mins minuut";
  return "minder dan 1 minuut";
}

function site_send_message($receiver, $sender, $message , $tijd=true)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	
	$added = sqlesc(get_date_time());
	if ($tijd)
		$message .= " op " . convertdatum(get_date_time());
	$message = sqlesc($message);
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES ($sender, $receiver, $message, $added)") or sqlerr(__FILE__, __LINE__);
	}

function site_send_message_spy($spy, $receiver, $sender, $message , $tijd=true)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$added = sqlesc(get_date_time());
	if ($tijd)
		$message = "KOPIE - KOPIE - KOPIE - KOPIE - KOPIE - KOPIE - KOPIE - KOPIE - KOPIE - KOPIE - KOPIE \n\n Origineel bericht verzonden van ".get_username($sender)." aan ".get_username($receiver)." op " . convertdatum(get_date_time()) ."\n---------- ---------- ---------- ---------- ---------- ---------- ---------- \n\n".$message;
	$message = sqlesc($message);
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES ($sender, $spy, $message, $added)") or sqlerr(__FILE__, __LINE__);
	}

function get_cover($id)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	
	$id = 0 + $id;
	$res = mysqli_query($con_link, "SELECT cover FROM torrents WHERE id = '$id'");
	$row = mysqli_fetch_array($res);
	if ($row)
		return $row['cover'];
	}

function get_avatar($id)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$id = 0 + $id;
	$res = mysqli_query($con_link, "SELECT avatar FROM users WHERE id = '$id'");
	$row = mysqli_fetch_array($res);
	if ($row)
		return $row['avatar'];
	}
	
function get_bedanktjes($id)
	{
    global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$id = 0 + $id;
	$res = mysqli_query($con_link, "SELECT bedanktplaat FROM users WHERE id = '$id'");
	$row = mysqli_fetch_array($res);
	if ($row)
		return $row['bedanktplaat'];
	}	

function get_screen($id)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	
	$id = 0 + $id;
	$res = mysqli_query($con_link, "SELECT screen FROM torrents WHERE id = '$id'");
	$row = mysqli_fetch_array($res);
	if ($row)
		return $row['screen'];
	}

function get_torrentname($id) {
	$id = 0 + $id;
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$res = mysqli_query($con_link, "SELECT name FROM torrents WHERE id = '$id'");
	$row = mysqli_fetch_array($res);
	
	if ($row) return $row['name'];
}

function get_super_seeder($id) {
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$id = 0 + $id;
	$res = mysqli_query($con_link, "SELECT super_seeder FROM users WHERE id = '$id'");
	$row = mysqli_fetch_array($res);
	if ($row) return $row['super_seeder'];
}

function get_shout_blok($id) {
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$id = 0 + $id;
	$res = mysqli_query($con_link, "SELECT shoutblok FROM users WHERE id = '$id'");
	$row = mysqli_fetch_array($res);
	if ($row) return $row['shoutblok'];
}
function donatie_balk()
	{
	$added = get_date_time();
	if (substr($added,5,2) == "01" || substr($added,5,2) == "03" || substr($added,5,2) == "05" || substr($added,5,2) == "07" || substr($added,5,2) == "08" || substr($added,5,2) == "10" ||substr($added,5,2) == "12")
		$total = 31*24*60;
	if (substr($added,5,2) == "02")
		$total = 28*24*60;
	if (substr($added,5,2) == "04" || substr($added,5,2) == "06" || substr($added,5,2) == "09" || substr($added,5,2) == "11")
		$total = 30*24*60;
	$maximaal = 18; // ongeveer +2%
	$breedte = 400; // breedte balk
	$current = ((substr($added,8,2)*24*60) + (substr($added,11,2) * 60)) +  substr($added,14,2);
	$percentage = $current / $total * $maximaal;

	$wel = $percentage / 100 * $breedte;
	$niet = (100 - $percentage) / 100 * $breedte;
	$msg = "Percentage dekking serverkosten deze maand ".number_format($percentage,1)."% door uw donaties.";
	$msg .= "<table align=center class=site border=0 width=$breedte cellpadding=0 cellspacing=0><tr>";
	$msg .= "<td height=5 width=$wel class=embedded bgcolor=green><font size=1>&nbsp;</td>";
	$msg .= "<td height=5 width=$niet class=embedded bgcolor=red><font size=1>&nbsp;</td>";
	$msg .= "</tr></table>";
	$ts = "<table align=center class=site border=0 width=100% cellpadding=0 cellspacing=0>";
	$ts .= "<tr><td class=embedded>";
	$ts .= "<td class=nav_site><div align=center>$msg</td>";
	$ts .= "</td></tr></table>";
	return $ts;
	}

function avatar_controle($user_id)
	{
	global $DEFAULTBASEURL;
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$res = mysqli_query($con_link, "SELECT avatar FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if ($row)
		{
		$avatar = strtolower($row['avatar']);
		$avatar = str_replace($DEFAULTBASEURL . "/","",$avatar);
		if (!file_exists($avatar))
			{
			$avatar_del = sqlesc("");
			mysqli_query($con_link, "UPDATE users SET avatar = $avatar_del WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
			}
		}
	}

function get_sjabloon($id, $receiver)
	{
	global $CURUSER;
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$res = mysqli_query($con_link, "SELECT * FROM berichten_sjabloon WHERE id='$id'") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	$def = mysqli_query($con_link, "SELECT * FROM users WHERE id='$receiver'") or sqlerr(__FILE__, __LINE__);
	$defs = mysqli_fetch_array($def);
	$sjabloon_msg = htmlspecialchars($row['sjabloon_msg']);
	print $sjabloon_msg;
	$sjabloon_msg = str_replace("##naam##", get_username($receiver), $sjabloon_msg);
	$sjabloon_msg = str_replace("##verzonden##", mksize($defs['uploaded']), $sjabloon_msg);
	$sjabloon_msg = str_replace("##ontvangen##", mksize($defs['downloaded']), $sjabloon_msg);
	$sjabloon_msg = str_replace("##mijnnaam##", get_username($CURUSER[id]), $sjabloon_msg);
	$sjabloon_msg = str_replace("##ip##", $defs['ip'], $sjabloon_msg);
	$sjabloon_msg = str_replace("##email##", $defs['email'], $sjabloon_msg);
	return $sjabloon_msg;
	}

function convert_sjabloon($sjabloon_msg, $receiver)
	{
	global $CURUSER;
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$def = mysqli_query($con_link, "SELECT * FROM users WHERE id='$receiver'") or sqlerr(__FILE__, __LINE__);
	$defs = mysqli_fetch_array($def);
	$sjabloon_msg = str_replace("##naam##", get_username($receiver), $sjabloon_msg);
	$sjabloon_msg = str_replace("##verzonden##", mksize($defs['uploaded']), $sjabloon_msg);
	$sjabloon_msg = str_replace("##ontvangen##", mksize($defs['downloaded']), $sjabloon_msg);
	$sjabloon_msg = str_replace("##verschil##", mksize($defs['uploaded'] - $defs['downloaded']), $sjabloon_msg);
	$sjabloon_msg = str_replace("##ratio##", number_format($defs['uploaded'] / $defs['downloaded'],2), $sjabloon_msg);
	$sjabloon_msg = str_replace("##mijnnaam##", get_username($CURUSER[id]), $sjabloon_msg);
	$sjabloon_msg = str_replace("##ip##", $defs['ip'], $sjabloon_msg);
	$sjabloon_msg = str_replace("##email##", $defs['email'], $sjabloon_msg);
	return $sjabloon_msg;
	}

function save_comment($user_id, $kind="Onbekend", $comment, $uploaded=0, $downloaded=0, $done_by=0)
	{
	global $CURUSER;
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$comment = sqlesc($comment);
	$kind = sqlesc($kind);
	$added = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO users_comment (user_id, kind, added, comment, uploaded, downloaded, done_by) VALUES($user_id, $kind, $added, $comment, $uploaded, $downloaded, $done_by)") or sqlerr(__FILE__, __LINE__);
	}

function new_header($title = "", $msgalert = true)
	{
	global $CURUSER, $_SERVER, $PHP_SELF, $SITE_ONLINE, $SITE_NAME;

	if (!$SITE_ONLINE)
		die("De pagina's zijn geloten wegens een storing... Even geduld a.u.b. Ons excuus... Nee dit komt niet door Brein... LOL<br>");
	
	if ($title == "")
		$title = "$SITE_NAME";
	else
		$title = "$SITE_NAME : " . htmlspecialchars($title);
	
	print "<html><head><title>$title</title>\n";
	print "<link rel=stylesheet href='default.css' type='text/css'>";
	print "</head><body>";
	print "<table  width=100% border=0 cellspacing=0 cellpadding=0>";
	print "<tr><td align=center class=embedded><center>";
	}

function new_footer($enter=true)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	
	mysqli_close($con_link);
	if ($enter)
		print "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
	print("</td></tr></table>\n");
	print("</body></html>\n");
	}

function reg_error_message($heading, $text, $color="red")
	{
	new_header();
	print "<br><br><br><br><br>";
	print "<table class=main border=0 width=60% cellpadding=0 cellspacing=0><tr><td class=embedded>";
	tabel_top ($heading);
	print "<table width=100% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded align=center><br>";
	print "<center><font size=2 color=$color><b>" . $text . "</b></font></center><br>";
	print "</td></tr></table>";
	print "</td></tr></table><br>";
	tabel_einde();
	site_footer();
	die;
	}

function controleer_bedankjes()
	{
	global $CURUSER;
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$user_id = $CURUSER['id'];
	
	$res = mysqli_query($con_link, "SELECT * FROM peers WHERE userid=$user_id");
	while ($row = mysqli_fetch_assoc($res))
		{
		$res2 = mysqli_query($con_link, "SELECT * FROM torrents WHERE id=$row[torrent]");
		$row2 = mysqli_fetch_array($res2);
		if ($row2)
			{
			if ($user_id != $row2['owner'])
				{
				$res3 = mysqli_query($con_link, "SELECT * FROM comments WHERE user=$user_id AND torrent=$row[torrent]");
				$row3 = mysqli_fetch_array($res3);
				if ($row3)
					$commentaar = true;
				else
					$commentaar = false;
					
				$res4 = mysqli_query($con_link, "SELECT * FROM thankyou WHERE user=$user_id AND torrent=$row[torrent]");
				$row4 = mysqli_fetch_array($res4);
				if ($row4)
					$bedankt = true;
				else
					$bedankt = false;
			
				if (!$bedankt && !$commentaar)
					{
					$bericht .= "<font color=white><b>U download torrent <a class=altlink_red href='details.php?id=".$row2['id']."'>" . $row2['name'] . "</a> maar heeft geen commentaar geplaatst en niet bedankt.</font><br>";
					}
				}
			}
		}
		if (@$bericht)
			return $bericht;
	}

function melding_bedankjes($bericht)
	{
	print "<table class=main width=98% border=1 cellspacing=0 cellpadding=10><tr><td align=center bgcolor=red>";
	print $bericht;
	print "</td></tr></table><br>";
	}

function get_site_vars()
	{
	global $SV;
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$res = mysqli_query($con_link, "SELECT * FROM site_vars") or sqlerr(__FILE__, __LINE__);
	while ($row = mysqli_fetch_assoc($res))
		{
		$var_name = $row['var_name'];
		$var_data = $row['var_data'];
		
		$SV[$var_name] = $var_data;
		}
	}
function pic_resize($width, $height, $target) 
	{
	if ($width > $height) 
		{
		$percentage = ($target / $width);
		} 
	else 
		{
		$percentage = ($target / $height);
		}
	$width = round($width * $percentage);
	$height = round($height * $percentage);
	return "width=\"$width\" height=\"$height\"";
	}
	
function de_pagina()
	{
	return $_SERVER['PHP_SELF'];
	}
?>
