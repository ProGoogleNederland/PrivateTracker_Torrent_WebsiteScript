<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if ($CURUSER['shoutblok'] == "yes")
	site_error_message("Foutmelding", "U bent geblokkeerd van de smsbox neem contact op met een beheerder om uw blokkade op te heffen.");

$action = @$_POST['action'];
$until = $CURUSER['donor_until'];

$downloaded = $CURUSER['downloaded'];
$uploaded = $CURUSER['uploaded'];
$verschil = 12*1024*1024*1024;

if (($downloaded - $uploaded) >= $verschil)
	$grens = false;
else
	$grens = true;

function maketable_downloaded($res)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	
	global $cats, $slechte_gevonden;
	if (!isset($cats))
		{
		$res2 = mysqli_query($con_link, "SELECT id, image, name FROM categories") or sqlerr(__FILE__, __LINE__);
		while ($arr = mysqli_fetch_assoc($res2))
			{
			$catimages[$arr["id"]] = $arr["image"];
			$catnames[$arr["id"]] = $arr["name"];
			}
		}
	$ret = "<table width=100% class=outer border=1 cellspacing=0 cellpadding=5>";
	$ret .=	"<tr><td class=colheadsite width=80>Soort</td><td class=colheadsite width=99%>Naam</td><td class=colheadsite align=center>Datum&nbsp;ontvangen</td><td class=colheadsite align=center>Grootte</td><td class=colheadsite align=center>Verzonden</td>";
	$ret .=	"<td class=colheadsite align=center>Ontvangen</td><td class=colheadsite align=center>Ratio&nbsp;torrent";
	$ret .= "</td><td class=colheadsite align=center>Corrigeer&nbsp;Torrent&nbsp;Ratio";
	$ret .= "</td></tr>";
	while ($arr = mysqli_fetch_assoc($res))
		{
		$del_old = get_row_count("torrents", "WHERE id=$arr[torrent]");
		if ($del_old == 0)
			{
			mysqli_query($con_link, "DELETE FROM downloaded WHERE torrent=$arr[torrent]") or sqlerr(__FILE__, __LINE__);
			}
		else
			{
			$restmp =  mysqli_query($con_link, "SELECT * FROM downup WHERE user='" . $arr['user'] . "' AND torrent=" . $arr['torrent'] . " AND uploaded < downloaded") or sqlerr(__FILE__, __LINE__);
			$rowtmp = mysqli_fetch_array($restmp);
			if ($rowtmp)
				{
				$slechte_gevonden = true;
				$res2 = mysqli_query($con_link, "SELECT name,size,category,added FROM torrents WHERE id=$arr[torrent]");
				$arr2 = mysqli_fetch_assoc($res2);
				$catimage = htmlspecialchars($catimages[$arr2["category"]]);
				$catname = str_replace(" ", "&nbsp;", htmlspecialchars($catnames[$arr2["category"]]));
				$size = str_replace(" ", "&nbsp;", mksize($arr2["size"]));
				$userid = $arr['user'];
				$torrentid = $arr['torrent'];
				$ressite =  mysqli_query($con_link, "SELECT * FROM downup WHERE user='" . $userid . "' AND torrent='" . $torrentid . "'") or sqlerr(__FILE__, __LINE__);
				$rowsite = mysqli_fetch_array($ressite);
				if ($rowsite["downloaded"] > 0)
					{
					$ratio = number_format($rowsite["uploaded"] / $rowsite["downloaded"], 2);
					$ratio = "<font color=" . get_ratio_color($ratio) . ">$ratio</font>";
					if ($rowsite["uploaded"] / $rowsite["downloaded"] > 20) $ratio = "<center><img border=0 src=pic/oneindig.gif></center>";
					}
				else
					{
					if ($rowsite["uploaded"] > 0)
						$ratio = "<center><img border=0 src=pic/oneindig.gif></center>";
					else
						$ratio = "---";
					}
				if ($rowsite)
					$uploaded = str_replace(" ", "&nbsp;", mksize($rowsite["uploaded"]));
				else
				$uploaded = "onbekend";
		
				if ($rowsite)
					$downloaded = str_replace(" ", "&nbsp;", mksize($rowsite["downloaded"]));
				else
					$downloaded = "onbekend";
		
				if ($rowsite)
					$added = str_replace(" ", "&nbsp;", convertdatum($rowsite['added'], "no"));	
			
				$ret .= "<tr><td bgcolor=white><font color=blue><b>$catname</b></font></td>";
				$ret .= "<td bgcolor=white><a href=details.php?id=$arr[torrent]&amp;hit=1><b>" . htmlspecialchars($arr2[name]);
				$ret .= "</b></a></td><td align=left bgcolor=white>$added</td><td align=right bgcolor=white>$size</td><td align=right bgcolor=white>$uploaded</td>";
				$ret .= "<td align=right bgcolor=white>$downloaded</td><td align=center bgcolor=white>$ratio";
				$ret .=  "</td><td bgcolor=white>";
				$ret .=  "<table class=bottom><tr><td class=embedded>";
				$ret .=  "<form method=post action=''>";
				$ret .=  "<input type=hidden name=action value=ratio_correctie>";
				$ret .=  "<input type=hidden name=torrentid value=".$torrentid.">";
				$ret .=  "<input type=hidden name=userid value=".$userid.">";
				$ret .=  "<input type=hidden name=returnto value=userdetails.php?id=".$userid.">";
				$ret .=  "<input type=submit style='height: 22px;width: 200px;background-color:red;color:white;font-weight:bold' value='Corrigeer Ratio - 1 krediet punt'>";
				$ret .=  "</form>";
				$ret .=  "</td></tr></table>";
				$ret .= "</td></tr>";
				}
			}
		}
	$ret .= "</table>";
	return $ret;
	}

function create_date_week($until)
	{
	$datum = get_date_time();
	if ($until == "0000-00-00 00:00:00")
		return date("Y-m-d H:i:s",mktime(0, 0, 0, date("m"), date("d")+7,  date("Y")));
	else
		if ($until > $datum)
			{
			$day = substr($until,8,2);
			$month = substr($until,5,2);
			$year = substr($until,0,4);
			return date("Y-m-d H:i:s",mktime(0, 0, 0, $month, $day+7,  $year));
			}
		else
			return date("Y-m-d H:i:s",mktime(0, 0, 0, date("m"), date("d")+7,  date("Y")));
	}

function create_date_month($until)
	{
	$datum = get_date_time();
	if ($until == "0000-00-00 00:00:00")
		return date("Y-m-d H:i:s",mktime(0, 0, 0, date("m")+1, date("d"),  date("Y")));
	else
		if ($until > $datum)
			{
			$day = substr($until,8,2);
			$month = substr($until,5,2);
			$year = substr($until,0,4);
			return date("Y-m-d H:i:s",mktime(0, 0, 0, $month+1, $day,  $year));
			}
		else
			return date("Y-m-d H:i:s",mktime(0, 0, 0, date("m")+1, date("d"),  date("Y")));
	}

if ($action == "ratio_correctie")
	{
	if ($CURUSER['credits'] < 1)
		site_error_message("Foutmelding", "U heeft geen saldo meer, dus bewerking kan niet verwerkt worden.");

	$userid = (int)$CURUSER['id'];	
	if (!$userid)
		site_error_message("Foutmelding", "Ontbrekende gegevens...");

	$torrentid = (int)@$_POST['torrentid'];
	if (!$torrentid)
		site_error_message("Foutmelding", "Ontbrekende gegevens...");

	$def = mysqli_query($con_link, "SELECT * FROM downup WHERE user=$userid AND torrent=$torrentid") or sqlerr(__FILE__, __LINE__);
	$defs = mysqli_fetch_array($def);
	
	$erbij = rand(1000,1100);
	
	$ontvangen = $defs['downloaded'];
	
	$upthis = round($ontvangen / 1000 * $erbij);

	if ($defs["downloaded"] > 0)
		{
		$ratio_oud = number_format($defs["uploaded"] / $defs["downloaded"], 2);
		$ratio_nieuw = number_format($upthis / $defs["downloaded"], 2);
		}
	else
		{
		$ratio = "---";
		}

	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);

	$rest = mysqli_query($con_link, "SELECT * FROM torrents WHERE id=$torrentid") or sqlerr(__FILE__, __LINE__);
	$rowt = mysqli_fetch_array($rest);

	$descr = "Torrent ratio correctie voor torrent ".htmlspecialchars($rowt['name'])." voor 1 punt. - Ratio was ".$ratio_oud." en is nu ".$ratio_nieuw.".";
	$descr = sqlesc($descr);
	$added = sqlesc(get_date_time());
	$user_id = $CURUSER['id'];
	$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\n" . $row['modcomment']);

	mysqli_query($con_link, "UPDATE downup SET uploaded = $upthis WHERE user=$userid AND torrent=$torrentid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "UPDATE users SET credits = credits - 1, modcomment = $modcomment WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "INSERT INTO users_credits (user_id, descr, added) VALUES ($user_id, $descr, $added)") or sqlerr(__FILE__, __LINE__);

	$CURUSER['credits'] -= 1;
	}
	
if ($action == "get_donatie_groot")
	{
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$CURUSER[id]") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if ($row['credits'] < 4)
		site_error_message("Foutmelding", "U heeft geen saldo meer, dus bewerking kan niet verwerkt worden.");
	
	$descr = "Maand donateurschap tot ".convertdatum(create_date_month($until),"Nee")." voor 4 punten en een verhoging van  ".mksize($donatie_groot)." - Totaal verzonden: voor = ".mksize($CURUSER['uploaded'])." en na ".mksize($CURUSER['uploaded'] + $donatie_groot).".";
	$descr = sqlesc($descr);
	$until = create_date_month($until);
	$until_save = sqlesc($until);
	$added = sqlesc(get_date_time());
	$user_id = $CURUSER['id'];
	$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\n" . $row['modcomment']);

	if ($row['class'] < 3)
		mysqli_query($con_link, "UPDATE users SET class=2, maxtorrents=5 WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);

	if ($row['warned'] == "yes")
		{
		mysqli_query($con_link, "UPDATE users SET warned='no' WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
		$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\nWaarschuwing verwijderd in verband met donatie.\n" . $row['modcomment']);
		}

	$blocked_reason = sqlesc("");
	$blocked_added = sqlesc("0000-00-00 00:00:00");

	mysqli_query($con_link, "UPDATE users SET blocked = 'no', blocked_by = 0, blocked_date = $blocked_added, blocked_reason = $blocked_reason, uploaded = uploaded + $donatie_groot, credits = credits - 4, donor='yes', donor_until=$until_save, modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
//	mysqli_query($con_link, "UPDATE users SET invites = invites + 1, uploaded = uploaded + $donatie_groot, credits = credits - 4, donor='yes', donor_until=$until_save, modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "INSERT INTO users_credits (user_id, descr, added) VALUES ($user_id, $descr, $added)") or sqlerr(__FILE__, __LINE__);

	$CURUSER['credits'] -= 4;
	$CURUSER['donor_until'] = $until;
	$CURUSER['uploaded'] += $donatie_groot;
	$CURUSER['donor'] = 'yes';
	}

if ($action == "get_upload_big")
	{
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$CURUSER[id]") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if ($row['credits'] < 4)
		site_error_message("Foutmelding", "U heeft geen saldo meer, dus bewerking kan niet verwerkt worden.");
	
	$descr = "RATIO CORRECTIE van ".mksize($ratio_groot)." voor 4 punten - Totaal verzonden: voor = ".mksize($CURUSER['uploaded'])." en na ".mksize($CURUSER['uploaded'] + $ratio_groot).".";
	$descr = sqlesc($descr);
	$added = sqlesc(get_date_time());
	$user_id = $CURUSER['id'];
	$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\n" . $row['modcomment']);

	if ($row['warned'] == "yes")
		{
		mysqli_query($con_link, "UPDATE users SET warned='no' WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
		$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\nWaarschuwing verwijderd in verband met donatie.\n" . $row['modcomment']);
		}

	mysqli_query($con_link, "UPDATE users SET uploaded = uploaded + $ratio_groot, credits = credits - 4, modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "INSERT INTO users_credits (user_id, descr, added) VALUES ($user_id, $descr, $added)") or sqlerr(__FILE__, __LINE__);

	$CURUSER['credits'] -= 4;
	$CURUSER['uploaded'] += $ratio_groot;
	}
	
if ($action == "get_extra_slot")
	{
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$CURUSER[id]") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if ($row['credits'] < 2)
		site_error_message("Foutmelding", "U heeft geen saldo meer, dus bewerking kan niet verwerkt worden.");
	
	$descr = "Extra torrent slot voor 2 punten";
	$descr = sqlesc($descr);
	$until = create_date_week($until);
	$until_save = sqlesc($until);
	$added = sqlesc(get_date_time());
	$user_id = $CURUSER['id'];

	$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\n" . $row['modcomment']);

	mysqli_query($con_link, "UPDATE users SET maxtorrents = maxtorrents + 1, credits = credits - 2, modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "INSERT INTO users_credits (user_id, descr, added) VALUES ($user_id, $descr, $added)") or sqlerr(__FILE__, __LINE__);

	$CURUSER['credits'] -= 2;
	}

if ($action == "get_donatie_klein")
	{
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$CURUSER[id]") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if ($row['credits'] < 1)
		site_error_message("Foutmelding", "U heeft geen saldo meer, dus bewerking kan niet verwerkt worden.");
	
	$descr = "Week donateurschap tot ".convertdatum(create_date_week($until),"Nee")." voor 1 punt en een verhoging van  ".mksize($donatie_klein)." - Totaal verzonden: voor = ".mksize($CURUSER['uploaded'])." en na ".mksize($CURUSER['uploaded'] + $donatie_klein).".";
	$descr = sqlesc($descr);
	$until = create_date_week($until);
	$until_save = sqlesc($until);
	$added = sqlesc(get_date_time());
	$user_id = $CURUSER['id'];

	if ($row['class'] < 3)
		mysqli_query($con_link, "UPDATE users SET class=2, maxtorrents=5 WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);

	$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\n" . $row['modcomment']);

	$blocked_reason = sqlesc("");
	$blocked_added = sqlesc("0000-00-00 00:00:00");

	mysqli_query($con_link, "UPDATE users SET blocked = 'no', blocked_by = 0, blocked_date = $blocked_added, blocked_reason = $blocked_reason, uploaded = uploaded + $donatie_klein, credits = credits - 1, donor='yes', donor_until=$until_save, modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "INSERT INTO users_credits (user_id, descr, added) VALUES ($user_id, $descr, $added)") or sqlerr(__FILE__, __LINE__);

	$CURUSER['credits'] -= 1;
	$CURUSER['donor_until'] = $until;
	$CURUSER['uploaded'] += $donatie_klein;
	$CURUSER['donor'] = 'yes';
	}

if ($action == "get_upload_smal")
	{
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$CURUSER[id]") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if ($row['credits'] < 1)
		site_error_message("Foutmelding", "U heeft geen saldo meer, dus bewerking kan niet verwerkt worden.");
	
	$descr = "RATIO CORRECTIE van ".mksize($ratio_klein)." voor 1 punt - Totaal verzonden: voor = ".mksize($CURUSER['uploaded'])." en na ".mksize($CURUSER['uploaded'] + $ratio_klein).".";
	$descr = sqlesc($descr);
	$added = sqlesc(get_date_time());
	$user_id = $CURUSER['id'];

	$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\n" . $row['modcomment']);

	mysqli_query($con_link, "UPDATE users SET uploaded = uploaded + $ratio_klein, credits = credits - 1, modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "INSERT INTO users_credits (user_id, descr, added) VALUES ($user_id, $descr, $added)") or sqlerr(__FILE__, __LINE__);

	$CURUSER['credits'] -= 1;
	$CURUSER['uploaded'] += $ratio_klein;
	
}

if ($action == "krediet_weg")
   {
   $ammount = (int)@$_POST['ammount'];
   //$user_id = (int)@$_POST['user_id'];
   $user_name = @$_POST['user_id'];
   $res_user_by_name = mysqli_query($con_link, "SELECT * FROM users WHERE username='$user_name'") or sqlerr(__FILE__, __LINE__);
   $result_value = mysqli_fetch_object($res_user_by_name);
   //var_dump($result_value->id);
   $user_id = (int)@$result_value->id;

if ($CURUSER['credits'] < 1)
      site_error_message("Foutmelding", "U heeft geen saldo meer, dus bewerking kan niet verwerkt worden.");
 
    
if (!$user_id)
   site_error_message("Foutmelding", "Geen Gebruikersnaam ontvangen.");

   if ($ammount < 1)
      site_error_message("Foutmelding", "Krediet is lager dan 1, kan niet verwerkt worden.");
   if ($ammount > 500)
      site_error_message("Foutmelding", "Krediet is hoger dan 500, kan niet verwerkt worden.");
   $sender = $CURUSER['id'];
   
   $message = "Hallo " . get_username($user_id) . ",\n\n";
   $message .= "Uw krediet is met ".$ammount." verhoogd door ".get_username($sender)." op ".convertdatum(get_date_time())."\n\n";
   $message .= "Je hebt ".$ammount." erbij gekregen van ".get_username($sender)." omdat die je graag een kredietpuntje wil geven.\n\n";
   $message .= "U kunt uw krediet gebruiken door op de link [url=".$BASEURL."/credits.php][size=2][color=blue][b]Krediet[/b][/color][/size][/url] te drukken.\n\n";
   $message .= "Met vriendelijke groet,\n";
   $message .= $CURUSER['username'];

   site_send_message($user_id,$sender,$message,false);

if ($ammount == 1)
    $descr = "$ammount krediet weg gegeven aan " . get_username($user_id) . ".";
else
    $descr = "$ammount krediet weg gegeven aan " . get_username($user_id) . ".";
   
   
   $descr = sqlesc($descr);
   $added = sqlesc(get_date_time());
   $modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\n" . @$row['modcomment']);
  
mysqli_query($con_link, "UPDATE users SET credits = credits + $ammount WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
mysqli_query($con_link, "UPDATE users SET credits = credits - $ammount WHERE id=$sender") or sqlerr(__FILE__, __LINE__);
mysqli_query($con_link, "INSERT INTO users_credits (user_id, descr, added) VALUES ($sender, $descr, $added)") or sqlerr(__FILE__, __LINE__);
   }

if ($action == "loterij")
	{
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$CURUSER[id]") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if ($row['credits'] < 1)
		site_error_message("Foutmelding", "U heeft geen saldo meer, dus bewerking kan niet verwerkt worden.");
	
      $descr = "Lot gekocht via krediet punten";
	$descr = sqlesc($descr);
	$added = sqlesc(get_date_time());
	$user_id = $CURUSER['id'];

	$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\n" . $row['modcomment']);
      $lot = rand(123,789);
      $lot = sqlesc($lot);
      mysqli_query($con_link, "INSERT INTO loterij (user_id, lot, added) VALUES ($user_id, $lot, NOW())") or sqlerr(__FILE__, __LINE__);
      mysqli_query($con_link, "UPDATE users SET credits = credits - 1, modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
      mysqli_query($con_link, "INSERT INTO users_credits (user_id, descr, added) VALUES ($user_id, $descr, $added)") or sqlerr(__FILE__, __LINE__);
      $CURUSER['credits'] -= 1;
      $message = "Hallo " . get_username($user_id) . ",\n\n";
	$message .=	"Bedankt voor het kopen van een ". $SITE_NAME . " Loterij lot.\n\n";
	$message .=	"Uw lotnummer is $lot.\n\n";
	$message .=	"U kunt deze nu ook terug vinden op uw eigen pagina, door op uw gebruikersnaam te klikken.\n\n";
	$message .=	"De trekking is te zien op [url=/trekking_loterij.php][size=2][color=blue][b]Loterij[/b][/color][/size][/url] \n\n";
	$message .=	"Met vriendelijke groet,\n\n";
	$message .=	$SITE_NAME . "\n\n";
      $message =	sqlesc($message);
	$added = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES (0, $user_id, $message, $added)") or sqlerr(__FILE__, __LINE__);
			
       }

if ($action == "nltorwarning")
	{
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$CURUSER[id]") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if ($row['credits'] < 4)
		site_error_message("Foutmelding", "U heeft geen saldo meer, dus bewerking kan niet verwerkt worden.");
	
	$descr = "Waarschuwing verwijderd door krediet punten";
	$descr = sqlesc($descr);
	$added = sqlesc(get_date_time());
	$user_id = $CURUSER['id'];

	$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\n" . $row['modcomment']);

	mysqli_query($con_link, "UPDATE users SET hitruns = 0, credits = credits - 4, modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "INSERT INTO users_credits (user_id, descr, added) VALUES ($user_id, $descr, $added)") or sqlerr(__FILE__, __LINE__);

	$CURUSER['credits'] -= 4;
	
}

$credits = $CURUSER['credits'];

site_header("Krediet");
page_start(99);

if ($CURUSER['credits'] > 0)
	{
	$res = mysqli_query($con_link, "SELECT * FROM downloaded WHERE user=".$CURUSER['id']." ORDER BY added DESC") or sqlerr(__FILE__, __LINE__);
	if (mysqli_num_rows($res) > 0)
		{
		$downloaded = maketable_downloaded($res);
		if ($slechte_gevonden)
			{
			tabel_top("Slecht gedeelde torrents","center");
			tabel_start();
			print "<font color=white><b>Indien u een torrent heeft ontvangen maar u kunt deze door omstandigheden niet delen, dan kunt u per torrent deze ratio aanpassen.<br>De ratio wordt dan voor die torrent tussen de 1 en de 1,1<br>Door op de knop achter de onderstaande torrent te klikken, dit kost u 1 krediet punt per correctie.<br>LET OP: Uw totaal verzonden wordt hierdoor niet verhoogd.<br><br>";
			print $downloaded;
			print "<br>";
			tabel_einde();
			print "<br>";
			}
		}
	}

if ($credits == 1)
	tabel_top("Uw saldo is $credits punt","center");
else
	tabel_top("Uw saldo is $credits punten","center");
tabel_start();

if ($CURUSER['donor'] == 'yes')
	print "<font size=2 color=lightblue><b>U bent nog donateur tot en met " . convertdatum($CURUSER['donor_until'],"Nee") . "</b></font><br>";

print "<font size=2 color=lightblue><b>U heeft totaal verzonden " . mksize($CURUSER['uploaded']) . " en totaal " . mksize($CURUSER['downloaded']) . " ontvangen</b></font><br>";
$ratio = $CURUSER['uploaded'] - $CURUSER['downloaded'];
if ($ratio <= 0)
	$ratio_color = "color=red";
else
	$ratio_color = "color=yellow";
$verschil = $CURUSER['uploaded'] - $CURUSER['downloaded'];
if ($verschil <= 0)
	$verschil_color = "color=red";
else
	$verschil_color = "color=yellow";

print "<font size=2 color=lightblue><b>Uw ratio is <font size=2 $ratio_color>$ratio</font> en uw verschil is <font size=2 $verschil_color>".mksize($verschil)."</font>.</b></font><br>";
print "<hr>";
if ($credits < 1)
	print "<font color=lightblue size=3><b>U heeft geen krediet punten meer.<br><br>";
print "<font color=lightblue size=3><a class=altlink_yellow href='donatie.php'>Druk hier om nieuwe krediet punten te verkrijgen door te doneren.</a>";
print "<hr>";	
if ($credits > 0)
	{
	print "<table width=90% border=0 class=bottom><tr><td class=embedded>";
	print "<font color=yellow size=2><b>RATIO CORRECTIE van ".mksize($ratio_klein)."</b></font><font color=white size=2><br>";
	print "U heeft nu " . mksize($CURUSER['uploaded']) . " totaal verzonden en dat wordt dan " . mksize($CURUSER['uploaded'] + $ratio_klein) . "<br>";
	if ($CURUSER['downloaded'] > 0)
		{
		$ratio = number_format((($CURUSER["downloaded"] > 0) ? ($CURUSER["uploaded"] / $CURUSER["downloaded"]) : 0),2);
		$ratio_new = number_format((($CURUSER["downloaded"] > 0) ? (($CURUSER["uploaded"] + $ratio_klein) / $CURUSER["downloaded"]) : 0),2);
		print "Uw ratio is nu " . $ratio . " en die wordt dan " . $ratio_new . "<br>";
		}
	print "</td><td class=embedded><div align=right>";
	print "<form method=post action=>";
	print "<input type=hidden name=action value=get_upload_smal>";
	print "<input type=submit style='height: 32px;width: 400px;background:yellow;color:blue;font-weight:bold' value='Verhoog mijn totaal verzonden met ".mksize($ratio_klein)." voor 1 punt'></form>";
	print "</tr></td><tr><td colspan=2 class=embedded>";
	print "<hr>";
	print "</td></tr></table>";
	
	if ($credits >= 1){
		print "<table width=90% border=0 class=bottom><tr><td class=embedded>";
		print "<font color=yellow size=2><b>Ratio correctie voor torrents. Als er geen torrents staan dan hebben alle torrents een ratio van meer dan 1.</b></font><font color=white size=2><br>";
	
			tabel_start();
			print (@$downloaded2);
			tabel_einde();
			print "<br>";
		
		print "</tr></td><tr><td colspan=2 class=embedded>";
		print "<hr>";
		print "</td></tr></table>";
	}
	
	if ($grens)
		{
		print "<table width=90% border=0 class=bottom><tr><td class=embedded>";
		print "<font color=yellow size=2><b>Donateurschap voor 1 week tot  van ".convertdatum(create_date_week($until),"Nee")."</b></font><font color=white size=2><br>";
//		print "U ontvangt 1 uitnodiging, om een vriend of kennis uit te nodigen voor ".$SITE_NAME."<br>";
		print "U krijgt een verhoging van uw totaal verzonden van ".mksize($donatie_klein)."<br>";
		print "U heeft nu " . mksize($CURUSER['uploaded']) . " totaal verzonden en dat wordt dan " . mksize($CURUSER['uploaded'] + $donatie_klein) . "<br>";
		if ($CURUSER['downloaded'] > 0)
			{
			$ratio = number_format((($CURUSER["downloaded"] > 0) ? ($CURUSER["uploaded"] / $CURUSER["downloaded"]) : 0),2);
			$ratio_new = number_format((($CURUSER["downloaded"] > 0) ? (($CURUSER["uploaded"] + $donatie_klein) / $CURUSER["downloaded"]) : 0),2);
			print "Uw ratio is nu " . $ratio . " en die wordt dan " . $ratio_new . "<br>";
			}
		print "</td><td class=embedded><div align=right>";
		print "<form method=post action=>";
		print "<input type=hidden name=action value=get_donatie_klein>";
		print "<input type=submit style='height: 32px;width: 400px;background:yellow;color:blue;font-weight:bold' value='Donateurschap tot ".convertdatum(create_date_week($CURUSER['donor_until']),"Nee")." voor 1 punt'></form>";
		print "</tr></td><tr><td colspan=2 class=embedded>";
		print "<hr>";
		print "</td></tr></table>";
		}

	if ($credits >= 4)
		{
		print "<table width=90% border=0 class=bottom><tr><td class=embedded>";
		print "<font color=yellow size=2><b>RATIO CORRECTIE van ".mksize($ratio_groot)."</b></font><font color=white size=2><br>";
		print "U heeft nu " . mksize($CURUSER['uploaded']) . " totaal verzonden en dat wordt dan " . mksize($CURUSER['uploaded'] + $ratio_groot) . "<br>";
		if ($CURUSER['downloaded'] > 0)
			{
			$ratio = number_format((($CURUSER["downloaded"] > 0) ? ($CURUSER["uploaded"] / $CURUSER["downloaded"]) : 0),2);
			$ratio_new = number_format((($CURUSER["downloaded"] > 0) ? (($CURUSER["uploaded"] + $ratio_groot) / $CURUSER["downloaded"]) : 0),2);
			print "Uw ratio is nu " . $ratio . " en die wordt dan " . $ratio_new . "<br>";
			}
		print "</td><td class=embedded><div align=right>";
		print "<form method=post action=>";
		print "<input type=hidden name=action value=get_upload_big>";
		print "<input type=submit style='height: 32px;width: 400px;background:yellow;color:blue;font-weight:bold' value='Verhoog mijn totaal verzonden met ".mksize($ratio_groot)." voor 4 punten'></form>";
		print "</tr></td><tr><td colspan=2 class=embedded>";
		print "<hr>";
		print "</td></tr></table>";
		
		if ($grens)
			{
			print "<table width=90% border=0 class=bottom><tr><td class=embedded>";
			print "<font color=yellow size=2><b>Donateurschap voor 1 maand tot  van ".convertdatum(create_date_month($until),"Nee")."</b></font><font color=white size=2><br>";
//			print "U ontvangt 1 uitnodiging, om een vriend of kennis uit te nodigen voor ".$SITE_NAME."<br>";
			print "U krijgt een verhoging van uw totaal verzonden van ".mksize($donatie_groot)."<br>";
			print "U heeft nu " . mksize($CURUSER['uploaded']) . " totaal verzonden en dat wordt dan " . mksize($CURUSER['uploaded'] + $donatie_groot) . "<br>";
			if ($CURUSER['downloaded'] > 0)
				{
				$ratio = number_format((($CURUSER["downloaded"] > 0) ? ($CURUSER["uploaded"] / $CURUSER["downloaded"]) : 0),2);
				$ratio_new = number_format((($CURUSER["downloaded"] > 0) ? (($CURUSER["uploaded"] + $donatie_groot) / $CURUSER["downloaded"]) : 0),2);
				print "Uw ratio is nu " . $ratio . " en die wordt dan " . $ratio_new . "<br>";
				}
			print "</td><td class=embedded><div align=right>";
			print "<form method=post action=>";
			print "<input type=hidden name=action value=get_donatie_groot>";
			print "<input type=submit style='height:32px;width:400px;background:yellow;color:blue;font-weight:bold' value='Donateurschap tot ".convertdatum(create_date_month($until),"Nee")." voor 4 punten'></form>";
			print "</tr></td><tr><td colspan=2 class=embedded>";
			print "<hr>";
			print "</td></tr></table>";
			}
		
		}	
      

     print "<table width=90% border=0 class=bottom><tr><td class=embedded>";
	print "<font color=white size=2>";
	print "<font color=yellow size=2>Uw kunt een extra torrent slot voor 2 punten aanschaffen. </br>Gebruik hem wijs!</font><font color=white size=2><br>";
	print "</td><td class=embedded><div align=right>";
	print "<form method=post action=>";
	print "<input type=hidden name=action value=get_extra_slot>";
	print "<input type=submit style='height: 32px;width: 400px;background:yellow;color:blue;font-weight:bold' value='Voor 2 punten 1 extra slot kopen'></form>";
	print "</tr></td><tr><td colspan=2 class=embedded>";
	print "<hr>";
	print "</td></tr></table>";



	print "<table width=90% border=0 class=bottom><tr><td class=embedded>";
	print "<font color=white size=2>";
	print "<font color=yellow size=2><b>BP (Bonus Punten) kopen</b></font><font color=white size=2><br>";
	print "</td><td class=embedded><div align=right>";
	print "<form method=post action='bonus_informatie.php'>";
	print "<input type=submit style='height: 32px;width: 400px;background:yellow;color:blue;font-weight:bold' value='BP (Bonus Punten) kopen'></form>";
	print "</tr></td><tr><td colspan=2 class=embedded>";
	print "<hr>";

	print "</td></tr></table>";
	
	

        print "<table width=90% border=0 class=bottom><tr><td class=embedded>";
        print "<font color=white size=2>";  
        print "<form method=post action=''>";
	print "<input type=hidden name=action value=krediet_weg>";
	print "<font color=yellow size=2><b>Krediet punten <input maxlength=3 type=text size=5  name=ammount value=''>";
	print "</td><td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	print "<font color=yellow size=2><b>gebruikersnaam <input maxlength=50 type=text size=50 name=user_id value=''></br>";
	print "</td><td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	print "";  
        print "<font color=white size=2><br>";   
        print "</td><td class=embedded><div align=right>";   
        print "<input type=submit style='height: 32px;width: 400px;background:yellow;color:blue;font-weight:bold' value='Geef punt(en) weg aan een ander'></form>";
        print "</tr></td><tr><td colspan=2 class=embedded>";
        print "";
    
        print "</td></tr></table>";
	}

        print "</br><hr></br></br>";	
$res = mysqli_query($con_link, "SELECT * FROM users_credits WHERE user_id=$CURUSER[id] ORDER BY added DESC") or sqlerr(__FILE__, __LINE__);
if (mysqli_num_rows($res) > 0)
	{
	print "<font size=4 color=lightblue><b>Overzicht gebruikte punten.<br>\n";
	print "<table width=95% border=1 cellspacing=0 cellpadding=5>\n";
	print "<tr><td class=colheadsite align=left>Datum</td><td class=colheadsite align=left>Tijd</td><td class=colheadsite align=left>Gebeurtenis</td></tr>\n";
	while ($arr = mysqli_fetch_assoc($res))
		{
		$date = convertdatum($arr['added'],"no");
		$time = substr($arr['added'], strpos($arr['added'], " ") + 1);
		print "<tr><td bgcolor=white class=td_site>$date</td><td bgcolor=white class=td_site>$time</td><td bgcolor=white align=left class=td_site>$arr[descr]</td></tr>\n";
		}
	print "</table>";
	}

tabel_einde();
page_einde();
site_footer();
?>