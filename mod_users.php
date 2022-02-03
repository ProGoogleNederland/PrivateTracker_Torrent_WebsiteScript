<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

//site_error_message("Foutmelding", "Pagina staat uit");

if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "U heeft geen rechten om deze pagina te bekijken.");

$action = (string) @$_POST['action'];
if ($action == "waarschuwen")
	{
	$pm_messages = @$_POST['messages'];
	$sure = @$_POST['sure'];

	if ($sure != "yes")
		new_error_message("Foutmelding", "Geen bevestiging ontvangen voor versturen waarschuwingen.");

	if ($pm_messages)
		{
		$res = mysqli_query($con_link, "SELECT * FROM users WHERE id IN (" . implode(", ", array_map("sqlesc",$pm_messages)) . ")") or sqlerr(__FILE__, __LINE__);
		while ($row = mysqli_fetch_assoc($res))
			{
			$bericht = "Hallo " . get_username($row['id']) . ",\n\n";
			$bericht .= "Uw ratio van ".get_ratio($row['id'])." is lager dan toegestaan op ".$SITE_NAME.".\n\n";
			$warnings = get_row_count("warnings", "WHERE userid=$row[id]") + 1;
			$bericht .= "Dit is nu uw ".$warnings."e officiële waarschuwing, en bij teveel waarschuwingen zou u van ".$SITE_NAME." verwijderd kunnen worden.\n\n";
			if ($warnings == 1)
				{
				$warnlength = 48;		
				}
			if ($warnings == 2)
				{
				$warnlength = 96;		
				}
			if ($warnings == 3)
				{
				$warnlength = 168;		
				}
			if ($warnings > 3)
				{
				$warnlength = 336;		
				}

			$bericht .= "Wij vragen u bij deze dringend maar vriendelijk hier wat aan te gaan doen, door langer te blijven delen op de torrents die u download.\n\n";
			$bericht .= "U kunt natuurlijk ook een [url=https://torrentmedia.org/donatie.php][size=2][color=blue][b]donatie[/b][/color][/size][/url] doen en dan uw krediet gebruiken voor een Ratio Correctie van 15 Gb.\n\n";
			$bericht .= "Met vriendelijke groet,\n" . get_username($CURUSER['id']);

			$warneduntil = get_date_time(time() + $warnlength * 3600);
			$modcomment = convertdatum(date("Y-m-d H:i:s")) . " - Gewaarschuwd voor ".$warnlength." uur door " . $CURUSER['username'] .  ".\nReden waarschuwing: Lage Ratio\nMomentopname: Ontvangen: " . mksize($row["downloaded"]) . " - Verzonden: " . mksize($row["uploaded"]) . " - Ratio: "  . get_ratio($row["id"]) . "\n\n" . $row['modcomment'];
			$logmsg = "<a href=userdetails.php?id=" . $row['id'] . ">" . get_username($row['id']) . "</a> is gewaarschuwd door <a href=userdetails.php?id=" . $CURUSER['id'] . ">" . $CURUSER['username'] . "</a> voor Lage ratio.";
			write_log_warning($logmsg);

			$bericht = sqlesc("$bericht");
			$added = sqlesc(get_date_time());

			$receiverid = $row['id'];
			$senderid = $CURUSER['id'];
			mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES ($senderid, $receiverid, $bericht, $added)") or sqlerr(__FILE__, __LINE__);

			$updateset[] = "modcomment = " . sqlesc($modcomment);
			$updateset[] = "warned = 'yes'";
			$updateset[] = "warneduntil = '$warneduntil'";
			$updateset[] = "warnedby = " . $CURUSER['id'];

			mysqli_query($con_link, "UPDATE users SET  " . implode(", ", $updateset) . " WHERE id=$receiverid") or sqlerr(__FILE__, __LINE__);
			mysqli_query($con_link, "INSERT INTO warnings (userid, warned_by, warned_for, warned_time, date, uploaded, downloaded) VALUES ($receiverid, $senderid, 'Lage ratio.', $warnlength, NOW(), $row[uploaded], $row[downloaded])") or sqlerr(__FILE__, __LINE__);
			}
		}
	else
		new_error_message("Foutmelding", "Geen selectie ontvangen om te verwerken.");
	}


$letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$download_limiet = 5*1024*1024*1024;
$ratio_limiet = 90/100;
$added_limiet = time() - 86400 * 10;

for ($i = 0; $i < strlen($letters); ++$i)
	{
	$letter = substr($letters,$i,1);
	if (get_user_class() == UC_MODERATOR)
		{
		$res2 = mysqli_query($con_link, "SELECT * FROM mod_letters WHERE letter LIKE '%$letter%' AND userid=$CURUSER[id]") or sqlerr(__FILE__, __LINE__);
		$row2 = mysqli_fetch_array($res2);
		if ($row2)
			$mod_letter .= "<font size=3><a class=altlink_lblue href='mod_users.php?letter=".$letter."'>" . $letter . "</a> ";
		}
	else
		{
		@$mod_letter .= "<font size=3><a class=altlink_lblue href='mod_users.php?letter=".$letter."'>" . $letter . "</a> ";
		}
	}

if (!$mod_letter)
	new_error_message("Foutmelding", "U heeft geen letters als Moderator dus u heeft op deze pagina geen rechten.");

@$start = 0 + @$_GET['start'];
$letter = "" . @$_GET['letter'];

if (strlen($letter) <= 0)
	{
	$res3 = mysqli_query($con_link, "SELECT * FROM mod_letters WHERE userid=$CURUSER[id]") or sqlerr(__FILE__, __LINE__);
	$row3 = mysqli_fetch_array($res3);
	if ($row3)
		$letter = $row3['letter'];
	if (get_user_class() > UC_MODERATOR)
		$letter = "A";
	}

if (get_user_class() == UC_MODERATOR)
	{
	$res4 = mysqli_query($con_link, "SELECT * FROM mod_letters WHERE letter LIKE '%$letter%' AND userid=$CURUSER[id]") or sqlerr(__FILE__, __LINE__);
	$row4 = mysqli_fetch_array($res4);
	if (!$row4)
		new_error_message("Foutmelding", "Deze letter is niet voor u.");
	}
	
$sorteren = @$_GET['sorteren'];
if (!$sorteren || $sorteren == "ratio")
	{
	$sorteren_sql = "(uploaded / downloaded)";
	$sorteren_tekst = "ratio";
	}
if ($sorteren == "gezien")
	{
	$sorteren_sql = "last_access";
	$sorteren_tekst = "laatst gezien";
	}

$sorted = "<a class=altlink_lblue href=mod_users.php?letter=".$letter."&amp;sorteren=ratio><font size=3><b>Ratio</b></font></a>";
$sorted .= "<font color=#66FFFF> - </font><a class=altlink_lblue href=mod_users.php?letter=".$letter."&amp;sorteren=gezien><font size=3><b>Laatst gezien</b></font></a>";
	
$my_querie = "WHERE username LIKE '".$letter."%' AND downloaded > $download_limiet AND (uploaded / downloaded) < $ratio_limiet AND added < FROM_UNIXTIME($added_limiet) AND class < 2 AND warned != 'yes' AND blocked != 'yes'";
$totaal = get_row_count("users",$my_querie);
$allemaal = get_row_count("users","WHERE username LIKE '".$letter."%'");

new_header("Moderator");
site_menu(false);
print "<br>";
page_start();
tabel_start();
print "<center><font size=3 color=#66FFFF>Gesorteerd op : " . $sorted . "<hr></center>";
print "<center>" . $mod_letter . "<hr></center>";
tabel_einde();
print "<br>";
tabel_top($totaal . " van de ".$allemaal." gebruikers beginnend met: " . $letter . " gesorteerd op " . $sorteren_tekst, "center");
tabel_start();

$res = mysqli_query($con_link, "SELECT * FROM users ".$my_querie." ORDER BY $sorteren_sql") or sqlerr(__FILE__, __LINE__);

print "<table align=center class=sitetable border=1 cellspacing=0 cellpadding=5>";
print "<tr>";
print "<td class=colheadsite width=100>Gebruiker</td>";
print "<td class=colheadsite width=100>Aanmelddatum</td>";
print "<td class=colheadsite width=100>Laatst gezien</td>";
print "<td class=colheadsite width=100 align=center>Ontvangen</td>";
print "<td class=colheadsite width=100 align=center>Verzonden</td>";
print "<td class=colheadsite width=100 align=center>Ratio</td>";
print "<td class=colheadsite width=100 align=center>Waarschuwingen</td>";
print "<td class=colheadsite width=100 align=center>##</td>";
print "</tr>";

print "<form method=post action=''>";
print "<input type=hidden name=action value=waarschuwen>";

while ($row = mysqli_fetch_assoc($res))
	{
	print "<tr>";
	print "<td bgcolor=white><a class=altlink_blue href='userdetails.php?id=".$row['id']."' target=_blank>".get_usernamesitesmal($row['id'])."</a></td>";
	print "<td bgcolor=white>".convertdatum($row['added'], "No")."</td>";
	print "<td bgcolor=white>".get_elapsed_time(sql_timestamp_to_unix_timestamp($row['last_access']))." geleden</td>";
	print "<td bgcolor=white align=right>".mksize($row['downloaded'])."</td>";
	print "<td bgcolor=white align=right>".mksize($row['uploaded'])."</td>";
	print "<td bgcolor=white align=center>".get_userratio($row['id'])."</td>";
	$waarschuwingen = get_row_count("warnings","WHERE userid=$row[id] ORDER by date");
	print "<td bgcolor=white align=center>".$waarschuwingen."</td>";
	print "<td bgcolor=white align=center><INPUT type=\"checkbox\" name=\"messages[]\" value=\"" . $row['id'] . "\"></td>";
	print "</tr>";
	}

print "</td></tr></table><br>";
print "<table align=center class=bottom border=0 cellspacing=0 cellpadding=5>";
print "<tr>";
print "<td class=embedded>";
print "<input type=checkbox name=sure value=yes>";
print "</td>";
print "<td class=embedded><font color=yellow size=2><b>Selecteer dit vak ter bevestiging voor versturen waarschuwingen.";
print "</td></tr></table>";
print "<input type=submit style='height: 32px;width: 400px' value='Nu geselecteerde gebruikers waarschuwen'>";
print "</form>";
tabel_einde();
page_einde();
new_footer(false);
?>