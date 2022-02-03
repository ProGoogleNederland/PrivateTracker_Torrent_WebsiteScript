<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	new_error_message("Foutmelding", "Deze pagina is alleen voor de administrator en hoger.");

$action = @$_GET['action'];

$gb = @$_GET['gb'];

if (!$gb) $gb = 15;

$verschil = $gb*1024*1024*1024;
$limiet = 15*1024*1024*1024;
$woot = 20*1024*1024*1024;

if ($action == "verwijderen")
	{
	$user_id = @$_GET['user_id'];
	verwijder_gebruiker($user_id);
	}

if ($action == "send_warning")
	{
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE downloaded > uploaded + $limiet AND enabled='yes' ORDER BY last_access") or sqlerr(__FILE__, __LINE__);	
	while ($row = mysqli_fetch_assoc($res))
		{
		$user_id = $row['id'];
		$count_bad = get_row_count("warn_pm_gb", "WHERE receiver=$user_id");
		if (!$count_bad)
			{
			$ontvanger = $row['username'];
			$downloaded = mksize($row['downloaded']);
			$uploaded = mksize($row['uploaded']);
			$verschil2 = mksize($row['downloaded'] - $row['uploaded']);
			$message = "Hallo " . $ontvanger . ",\n\n";
			$message .= "Na controle is gebleken dat u meer ontvangt als dat u verzend naar andere gebruikers.\n\n";
			$message .= "U heeft " . $downloaded . " ontvangen.\n";
			$message .= "U heeft " . $uploaded . " verzonden.\n";
			$message .= "Met een negatief verschil van " . $verschil2 . ".\n\n";
			$message .= "Bij een verschil van 20 Gb of meer wordt u van de site verwijderd.\n\n";
			$message .= "Bij deze krijgt u van " . $SITE_NAME . " nog de kans om te blijven om daar wat aan te doen.\n\n";
			$message .= "U zou ook een donatie kunnen doen van 5 euro en vragen naar een RATIO CORRECTIE van 15 Gb.\n\n";
			$message .= "Met vriendelijke groeten,\n\n" . $CURUSER['username'];

			$modcomment = convertdatum(get_date_time()) . " - bericht gehad van ".get_username($CURUSER['id'])." voor GB verschil van " . $verschil2 . " (Verzonden: ".$uploaded." en ontvangen: ".$downloaded.")\n";
			$modcomment .= $row['modcomment'];
			$modcomment = sqlesc($modcomment);

			mysqli_query($con_link, "UPDATE users SET modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);

			$sender = $CURUSER['id'];
			$added = sqlesc(get_date_time());
			$message = sqlesc($message);
			mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES ($sender, $user_id, $message, $added)") or sqlerr(__FILE__, __LINE__);
			mysqli_query($con_link, "INSERT INTO warn_pm_gb (sender, receiver, added) VALUES ($sender, $user_id, $added)") or sqlerr(__FILE__, __LINE__);
			}
		}
	}


if ($action == "send_last_warning")
	{
	if (get_user_class() < UC_SYSOP)
		new_error_message("Foutmelding", "U heeft geen toegang tot deze pagina.");
	
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE downloaded > uploaded + $woot AND enabled='yes' ORDER BY last_access") or sqlerr(__FILE__, __LINE__);	
	while ($row = mysqli_fetch_assoc($res))
		{
		$user_id = $row['id'];
		$count_bad = get_row_count("warn_pm_gb_last", "WHERE receiver=$user_id");
		if (!$count_bad)
			{
			$ontvanger = $row['username'];
			$downloaded = mksize($row['downloaded']);
			$uploaded = mksize($row['uploaded']);
			$verschil2 = mksize($row['downloaded'] - $row['uploaded']);
			$message = "Hallo " . $ontvanger . ",\n\n";
			$message .= "Na controle is gebleken dat u meer ontvangt als dat u verzend naar andere gebruikers.\n\n";
			$message .= "U heeft " . $downloaded . " ontvangen.\n";
			$message .= "U heeft " . $uploaded . "  verzonden.\n";
			$message .= "Met een negatief verschil van ".$verschil2.".\n\n";
			$message .= "Bij een verschil van 20 Gb of meer wordt u van de site verwijderd.\n\n";
			$message .= "Bij deze krijgt u van " . $SITE_NAME . " nog 1 kans om te blijven en dat is heel\n";
			$message .= "snel 1 of liever 2 donaties te doen van 5 euro en vragen naar een RATIO CORRECTIE van 15 Gb.\n\n";
			$message .= "Indien u binnen 24 uur na het lezen van dit bericht geen actie heeft ondernomen wordt u verwijderd van de site.\n\n";
			$message .= "Met vriendelijke groeten,\n\n" . $CURUSER['username'];

			$modcomment = convertdatum(get_date_time()) . " - laatste bericht gehad van ".get_username($CURUSER['id'])." voor GB verschil van " . $verschil2 . " (Verzonden: ".$uploaded." en ontvangen: ".$downloaded.")\n";
			$modcomment .= $row['modcomment'];
			$modcomment = sqlesc($modcomment);

			mysqli_query($con_link, "UPDATE users SET  modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);

			$sender = $CURUSER['id'];
			$added = sqlesc(get_date_time());
			$message = sqlesc($message);
			mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES ($sender, $user_id, $message, $added)") or sqlerr(__FILE__, __LINE__);
			mysqli_query($con_link, "INSERT INTO warn_pm_gb_last (sender, receiver, added) VALUES ($sender, $user_id, $added)") or sqlerr(__FILE__, __LINE__);
			}
		}
	}

site_header("GB verschillen");tabel_start();
//site_menu(false);
print "<br>";

if (get_user_class() >= UC_ADMINISTRATOR)
	{
	print "<form method=get action=modview_bad_gb.php>";
	print "<input type=hidden name=action value=send_warning>";
	print "<input type=hidden name=gb value=".$gb.">";
	print "<input type=submit style='height: 32px;width: 300px;background-color:red;color:white;font-weight:bold' value='Waarschuwingen sturen'>";
	print "</form>";
	}	

if (get_user_class() >= UC_SYSOP)
	{
	print "<br>";
	print "<form method=get action=modview_bad_gb.php>";
	print "<input type=hidden name=action value=send_last_warning>";
	print "<input type=hidden name=gb value=".$gb.">";
	print "<input type=submit style='height: 32px;width: 300px;background-color:red;color:white;font-weight:bold' value='Laatste waarschuwingen sturen'>";
	print "</form>";
	}	

//////////////////////
$res = mysqli_query($con_link, "SELECT * FROM users WHERE downloaded > uploaded + $verschil AND enabled='yes' ORDER BY last_access") or sqlerr(__FILE__, __LINE__);	
$aantal = mysqli_num_rows($res);

print("<table width=98% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
print("<br>");
tabel_top("$aantal gebruikers met $gb Gb verschil");
print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print"<td class=embedded align=center><center>";
if (@$extra_text)
	print $extra_text;
print "<br>";
print "<font size=3><a class=altlink_yellow href=modview_bad_gb.php?gb=5>5 Gb</a></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
print "<font size=3><a class=altlink_yellow href=modview_bad_gb.php?gb=10>10 Gb</a></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
print "<font size=3><a class=altlink_yellow href=modview_bad_gb.php?gb=15>15 Gb</a></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
print "<font size=3><a class=altlink_yellow href=modview_bad_gb.php?gb=20>20 Gb</a></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
print "<br>";
print "<br>";
print("<table width=98% class=outer border=1 cellspacing=0 cellpadding=5>");
print("<tr><td class=colheadsite>");
print("Gebruiker");
print("</td><td class=colheadsite>");
print("Ontvangen");
print("</td><td class=colheadsite>");
print("Verzonden");
print("</td><td class=colheadsite>");
print("Verschil");
print("</td><td align=center class=colheadsite>");
print("Ratio");
print("</td><td class=colheadsite>");
print("Aangemeld");
print("</td><td class=colheadsite>");
print("Laatst gezien");
print("</td><td class=colheadsite>");
print("Bericht");
print("</td>");
print "</td><td class=colheadsite align=center>";
print "Laatste kans";
if (get_user_class() >= UC_SYSOP)
	{
	print "</td><td class=colheadsite align=center>";
	print "Verwijderen";
	}
print "</td>";
print("</td><td class=colheadsite>");
print("Krediet");
print("</td>");
print("</td><td class=colheadsite>");
print("Claim");
print("</td>");
print("</tr>");
while ($row = mysqli_fetch_assoc($res)) {
	$user_id = $row['id'];
	$count = get_row_count("warn_pm_gb", "WHERE receiver=$user_id");
	$countwoot = get_row_count("warn_pm_gb_last", "WHERE receiver=$user_id");

	if (($row['downloaded']-$row['uploaded']) > $limiet)
		{
		if (($row['downloaded']-$row['uploaded']) > $woot)
			{
			if ($countwoot == 0)
				$teveel = "#FF0000";
			else
				$teveel = "#FFFFFF";
			}
		else
			{
			if ($count == 0)
				$teveel = "#FF9900";
			else
				$teveel = "#FFFFFF";
			}
		}
	else
		$teveel = '';
	$userid = $row['id'];
	print("<tr>");
	if ($teveel)
		print "<td bgcolor=$teveel>";
	else
		print "<td bgcolor=white>";
	print("<a class=altlink_blue href=userdetails.php?id=$row[id]>" .get_usernamesitesmal($row[id]) . "</a>");
	print("</td>");
	if ($teveel)
		print "<td align=right bgcolor=$teveel>";
	else
		print "<td align=right bgcolor=white>";
	print(mksize($row['downloaded']));
	print("</td>");
	if ($teveel)
		print "<td align=right bgcolor=$teveel>";
	else
		print "<td align=right bgcolor=white>";
	print(mksize($row['uploaded']));
	print("</td>");
	if ($teveel)
		print "<td align=right bgcolor=$teveel>";
	else
		print "<td align=right bgcolor=white>";
	print(mksize($row['downloaded']-$row['uploaded']));
	print("</td>");
	if ($teveel)
		print "<td align=center bgcolor=$teveel>";
	else
		print "<td align=center bgcolor=white>";
	print(get_userratio($row[id]));
	print("</td>");
	if ($teveel)
		print "<td bgcolor=$teveel>";
	else
		print "<td bgcolor=white>";
	print(convertdatum($row['added'], "no"));
	print("</td>");
	if ($teveel)
		print "<td bgcolor=$teveel>";
	else
		print "<td bgcolor=white>";
	print(convertdatum($row['last_access'], "no"));
	print("</td>");

	if ($teveel)
		print "<td bgcolor=$teveel>";
	else
		print "<td bgcolor=white>";
	$res2 = mysqli_query($con_link, "SELECT * FROM warn_pm_gb WHERE receiver=$user_id") or sqlerr(__FILE__, __LINE__);
	while ($row2 = mysqli_fetch_assoc($res2))
		{
		$ttl = floor((gmtime() - sql_timestamp_to_unix_timestamp($row2["added"])) / 3600);
		print $ttl . " uur - " . get_username($row2['sender']) . "<br>";
		}


	print "</td>";
			
	$ttl_vw = 0;
	if ($teveel)
		print "<td bgcolor=$teveel>";
	else
		print "<td bgcolor=white>";
		$user_id = $row['id'];
		$res3 = mysqli_query($con_link, "SELECT * FROM warn_pm_gb_last WHERE receiver=$user_id") or sqlerr(__FILE__, __LINE__);
		while ($row3 = mysqli_fetch_assoc($res3))
			{
			$ttl = floor((gmtime() - sql_timestamp_to_unix_timestamp($row3["added"])) / 3600);
			print $ttl . " uur - " . get_username($row3['sender']) . "<br>";
			$ttl_vw = $ttl;
			}

		if ($ttl_vw > 23 && ($row['downloaded']-$row['uploaded']) > $woot)
			$verwijderen = true;
		else
			$verwijderen = false;

	if (get_user_class() >= UC_SYSOP)
		{
		print "</td>";
		if ($teveel)
			print "<td bgcolor=$teveel align=center>";
		else
			print "<td bgcolor=white align=center>";
		if ($verwijderen)
			print "<a class=altlink_red href=?action=verwijderen&amp;user_id=".$row['id']."&amp;gb=".$gb.">Verwijderen</a>";
		}

	print "</td>";
	if ($teveel)
		print "<td bgcolor=$teveel>";
	else
		print "<td bgcolor=white>";
	print($row['credits']);
	print("</td>");

	print "</td>";
	if ($teveel)
		print "<td bgcolor=$teveel>";
	else
		print "<td bgcolor=white>";
	$res7 = mysqli_query($con_link, "SELECT * FROM donations_claim WHERE user_id=$user_id AND verwerkt='no' AND code = '-'") or sqlerr(__FILE__, __LINE__);
	$row7 = mysqli_fetch_array($res7);
	if ($row7)
		print "bank";

	$res8 = mysqli_query($con_link, "SELECT * FROM donations_claim WHERE user_id=$user_id AND verwerkt='no' AND rekening = '-'") or sqlerr(__FILE__, __LINE__);
	$row8 = mysqli_fetch_array($res7);
	if ($row8)
		print "telefoon";

	print("</td>");
	
	print("</tr>");
	}
print("</td></tr></table>");

print("<br></td></tr></table>");
print("</td></table><br>");
tabel_einde();
site_footer(false);
?>