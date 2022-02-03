<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

$action = (string)@$_POST['action'];

if ($CURUSER['class'] >= UC_MODERATOR)
	{
	if ($CURUSER['class'] >= UC_ADMINISTRATOR)
		site_error_message("Melding", "<a class=altlink_white href='uploader_aanvraag_overzicht.php'>Druk hier om naar de uploader aanvragen te gaan.</a>");
	else
		site_error_message("Foutmelding", "U bent al uploader of hoger.");
	}

if (controleer_tabel("uploader_aanvraag") == true)
	{
	$res_controle = mysqli_query($con_link, "SELECT * FROM uploader_aanvraag WHERE user_id=".$CURUSER['id']." AND verwerkt='nee'") or sqlerr(__FILE__, __LINE__);
	$row_controle = mysqli_fetch_array($res_controle);
	if ($row_controle)
		site_error_message("Foutmelding", "Er is nog een uploader aanvraag van u in behandeling.");
	}

if (controleer_tabel("uploader_aanvraag") == false)
	{
	$sql_string = "CREATE TABLE `uploader_aanvraag` (
	`id` int(10) unsigned NOT NULL auto_increment,
	`user_id` int(10) unsigned NOT NULL default '0',
	`toegevoegd` datetime NOT NULL default '0000-00-00 00:00:00',
	`ervaring` enum('ja','nee') NOT NULL default 'nee',
	`torrent_plaatsen` enum('ja','nee') NOT NULL default 'nee',
	`dht` enum('ja','nee') NOT NULL default 'nee',
	`uur` enum('ja','nee') NOT NULL default 'nee',
	`upload_snelheid` varchar(12) NOT NULL default '',
	`uploader` enum('ja','nee') NOT NULL default 'nee',
	`uploader_sites` varchar(255) NOT NULL default '',
	`staflid` enum('ja','nee') NOT NULL default 'nee',
	`staflid_sites` varchar(255) NOT NULL default '',
	`aantal_uploads` varchar(5) NOT NULL default '',
	`upload_wat` varchar(255) NOT NULL default '',
	`opmerking` varchar(255) NOT NULL default '',
	`verwerkt` enum('ja','nee') NOT NULL default 'nee',
	`verwerkt_datum` datetime NOT NULL default '0000-00-00 00:00:00',
	`verwerkt_door` int(10) unsigned NOT NULL default '0',
	`verwerkt_reden` varchar(255) NOT NULL default '',
	PRIMARY KEY  (`id`)
	) ENGINE=MyISAM;";
	$res_nieuw = mysqli_query($sql_string);
	////
	}

if ($action == 'verstuur_aanvraag')
	{
	$ervaring = (string)@$_POST['ervaring'];
	if (!$ervaring)	$error = true;
	$dht = (string)@$_POST['dht'];
	if (!$dht) $error = true;
	$torrent_plaatsen = (string)@$_POST['torrent_plaatsen'];
	if (!$torrent_plaatsen) $error = true;
	$uur = (string)@$_POST['uur'];
	if (!$uur) $error = true;
	$upload_snelheid = (string)@$_POST['upload_snelheid'];
	$upload_snelheid = round($upload_snelheid);
	if ($upload_snelheid <= 0) $error = true;
	$uploader = (string)@$_POST['uploader'];
	if (!$uploader) $error = true;
	$uploader_sites = (string)@$_POST['uploader_sites'];
	if ($uploader == 'ja' && !$uploader_sites) $error = true;
	$staflid = (string)@$_POST['staflid'];
	if (!$staflid) $error = true;
	$staflid_sites = (string)@$_POST['staflid_sites'];
	if ($staflid == 'ja' && !$staflid_sites) $error = true;
	$aantal_uploads = (string)@$_POST['aantal_uploads'];
	if (!$aantal_uploads) $error = true;
	$upload_wat = (string)@$_POST['upload_wat'];
	if (!$upload_wat) $error = true;
	$opmerking = (string)@$_POST['opmerking'];
	
	if (!$error)
		{
		$res_controle = mysqli_query($con_link, "SELECT * FROM uploader_aanvraag WHERE user_id=".$CURUSER['id']." AND verwerkt='nee'") or sqlerr(__FILE__, __LINE__);
		$row_controle = mysqli_fetch_array($res_controle);
		if ($row_controle)
			site_error_message("Foutmelding", "Uw eerdere uploader aanvraag is nog in behandeling.");

		$sql_string = "INSERT INTO uploader_aanvraag SET ";
		$sql_string .= "user_id=" . $CURUSER['id'] . ", ";
		$sql_string .= "toegevoegd=" . sqlesc(get_date_time()) . ", ";
		$sql_string .= "ervaring=" . sqlesc($ervaring) . ", ";
		$sql_string .= "dht=" . sqlesc($dht) . ", ";
		$sql_string .= "torrent_plaatsen=" . sqlesc($torrent_plaatsen) . ", ";
		$sql_string .= "uur=" . sqlesc($uur) . ", ";
		$sql_string .= "upload_snelheid=" . sqlesc($upload_snelheid) . ", ";
		$sql_string .= "uploader=" . sqlesc($uploader) . ", ";
		$sql_string .= "uploader_sites=" . sqlesc($uploader_sites) . ", ";
		$sql_string .= "staflid=" . sqlesc($staflid) . ", ";
		$sql_string .= "staflid_sites=" . sqlesc($staflid_sites) . ", ";
		$sql_string .= "aantal_uploads=" . sqlesc($aantal_uploads) . ", ";
		$sql_string .= "upload_wat=" . sqlesc($upload_wat) . ", ";
		$sql_string .= "opmerking=" . sqlesc($opmerking) . "";
		
		$res_toevoegen = mysqli_query($con_link, $sql_string) or sqlerr(__FILE__, __LINE__);
	
		if ($res_toevoegen)
			{
			site_error_message("Melding", "Bedankt voor uw aanvraag, deze zal zo spoedig mogelijk verwerkt worden.");
			}
		}
	}

site_header("Uploader aanvraag");
page_start(98);
tabel_top("Uploader aanvraag formulier","center");
tabel_start();

if (@$error)
	print "<font size=2 color=white><b>De velden met de gele achtergrondkleur zijn niet of niet goed ingevuld.<br>";

print "<table class=bottom width=950 border=0 cellspacing=0 cellpadding=10><tr><td class=embedded>";

print "<form method=post action=''>";
print "<input type=hidden name=action value='verstuur_aanvraag'>";
	print "<tr><td bgcolor=white>";
print "<b>Heeft&nbsp;u&nbsp;ervaring&nbsp;met&nbsp;uploaden:</td>";
if (@$error && !$ervaring)
	print "<td align=left bgcolor=#FFFFCC>";
else
	print "<td align=left bgcolor=#FFFFFF>";
print "<table class=bottom border=0 cellspacing=0 cellpadding=10><tr>";
if (@$ervaring == 'ja')
	print "<td class=embedded><input name=ervaring type=radio value='ja' checked></td><td class=embeddedsite><div valign=middle><b><font color=green>Ja</td>";
else
	print "<td class=embedded><input name=ervaring type=radio value='ja'></td><td class=embeddedsite><div valign=middle><b><font color=green>Ja</td>";
print "<td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
if (@$ervaring == 'nee')
	print "<td class=embedded><input name=ervaring type=radio checked value='nee'></td><td class=embeddedsite><div valign=middle><b><font color=red>Nee</td>";
else
	print "<td class=embedded><input name=ervaring type=radio value='nee'></td><td class=embeddedsite><div valign=middle><b><font color=red>Nee</td>";
print "</td></tr></table>";
print "</td></tr>";

print "<tr><td bgcolor=white><b>U&nbsp;weet&nbsp;hoe&nbsp;u&nbsp;een&nbsp;torrent&nbsp;moet&nbsp;plaatsen:</td>";
if (@$error && !$torrent_plaatsen)
	print "<td align=left bgcolor=#FFFFCC>";
else
	print "<td align=left bgcolor=#FFFFFF>";
print "<table class=bottom border=0 cellspacing=0 cellpadding=10><tr>";
if (@$torrent_plaatsen == 'ja')
	print "<td class=embedded><input name=torrent_plaatsen type=radio value='ja' checked></td><td class=embeddedsite><div valign=middle><b><font color=green>Ja</td>";
else
	print "<td class=embedded><input name=torrent_plaatsen type=radio value='ja'></td><td class=embeddedsite><div valign=middle><b><font color=green>Ja</td>";
print "<td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
if (@$torrent_plaatsen == 'nee')
	print "<td class=embedded><input name=torrent_plaatsen type=radio value='nee' checked></td><td class=embeddedsite><div valign=middle><b><font color=red>Nee</td>";
else
	print "<td class=embedded><input name=torrent_plaatsen type=radio value='nee'></td><td class=embeddedsite><div valign=middle><b><font color=red>Nee</td>";
print "</td></tr></table>";
print "</td></tr>";

print "<tr><td bgcolor=white><b>U&nbsp;weet&nbsp;dat&nbsp;DHT&nbsp;en&nbsp;Peer&nbsp;Exchange&nbsp;uit&nbsp;moet&nbsp;staan:</td>";
if (@$error && !$dht)
	print "<td align=left bgcolor=#FFFFCC>";
else
	print "<td align=left bgcolor=#FFFFFF>";
print "<table class=bottom border=0 cellspacing=0 cellpadding=10><tr>";
if (@$dht == 'ja')
	print "<td class=embedded><input name=dht type=radio value='ja' checked></td><td class=embeddedsite><div valign=middle><b><font color=green>Ja</td>";
else
	print "<td class=embedded><input name=dht type=radio value='ja'></td><td class=embeddedsite><div valign=middle><b><font color=green>Ja</td>";
print "<td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
if (@$dht == 'nee')
	print "<td class=embedded><input name=dht type=radio value='nee' checked></td><td class=embeddedsite><div valign=middle><b><font color=red>Nee</td>";
else
	print "<td class=embedded><input name=dht type=radio value='nee'></td><td class=embeddedsite><div valign=middle><b><font color=red>Nee</td>";
print "</td></tr></table>";
print "</td></tr>";

print "<tr><td bgcolor=white><b>U&nbsp;weet&nbsp;dat&nbsp;uw&nbsp;computer&nbsp;24&nbsp;uur&nbsp;per&nbsp;dag&nbsp;aan&nbsp;moet&nbsp;staan:</td>";
if (@$error && !$uur)
	print "<td align=left bgcolor=#FFFFCC>";
else
	print "<td align=left bgcolor=#FFFFFF>";
print "<table class=bottom border=0 cellspacing=0 cellpadding=10><tr>";
if (@$uur == 'ja')
	print "<td class=embedded><input name=uur type=radio value='ja' checked></td><td class=embeddedsite><div valign=middle><b><font color=green>Ja</td>";
else
	print "<td class=embedded><input name=uur type=radio value='ja'></td><td class=embeddedsite><div valign=middle><b><font color=green>Ja</td>";
print "<td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
if (@$uur == 'nee')
	print "<td class=embedded><input name=uur type=radio value='nee' checked></td><td class=embeddedsite><div valign=middle><b><font color=red>Nee</td>";
else
	print "<td class=embedded><input name=uur type=radio value='nee'></td><td class=embeddedsite><div valign=middle><b><font color=red>Nee</td>";
print "</td></tr></table>";
print "</td></tr>";

print "<tr><td bgcolor=white><b>Uw&nbsp;upload_snelheid&nbsp;in&nbsp;Kbytes&nbsp;per&nbsp;seconde:</td>";
if (@$error && !$upload_snelheid)
	print "<td align=left bgcolor=#FFFFCC>";
else
	print "<td align=left bgcolor=#FFFFFF>";
print "<table class=bottom border=0 cellspacing=0 cellpadding=10><tr>";
print "<td class=embedded><b><input maxlength=12 type=text size=10 name=upload_snelheid value=\"" . htmlspecialchars(@$upload_snelheid) . "\">&nbsp;&nbsp;Kbytes&nbsp;per&nbsp;seconde</td>";
print "<td class=embedded>&nbsp;&nbsp;</td>";
print "<td class=embedded>(Test uw snelheid bij <a class=altlink_red href=\"http://www.speedtest.nl/TestSuite/TestController.asp?TestTypeID=,3,\" target=\"_blank\">SpeedTest</a> zet wel uw up en downloads uit.)</td>";
print "</td></tr></table>";
print "</td></tr>";

print "<tr><td bgcolor=white><b>Plaatst&nbsp;u&nbsp;ook&nbsp;uploads&nbsp;op&nbsp;andere&nbsp;sites:</td>";
if ((@$error && !$uploader) || (@$error && !$uploader_sites))
	{
	if (($error && $uploader == 'ja') || !$uploader)
		print "<td align=left bgcolor=#FFFFCC>";
	else
		print "<td align=left bgcolor=#FFFFFF>";
	}
else
	print "<td align=left bgcolor=#FFFFFF>";
print "<table class=bottom border=0 cellspacing=0 cellpadding=10><tr>";
if (@$uploader == 'ja')
	print "<td class=embedded><input name=uploader type=radio value='ja' checked></td><td class=embeddedsite><div valign=middle><b><font color=green>Ja</td>";
else
	print "<td class=embedded><input name=uploader type=radio value='ja'></td><td class=embeddedsite><div valign=middle><b><font color=green>Ja</td>";
print "<td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
if (@$uploader == 'nee')
	print "<td class=embedded><input name=uploader type=radio value='nee' checked></td><td class=embeddedsite><div valign=middle><b><font color=red>Nee</td>";
else
	print "<td class=embedded><input name=uploader type=radio value='nee'></td><td class=embeddedsite><div valign=middle><b><font color=red>Nee</td>";
print "<td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
if (@$uploader == 'nee')
	print "<td class=embedded><b>Welke:&nbsp;<input maxlength=255 type=text size=50 name=uploader_sites value='Geen'></td>";
else
	print "<td class=embedded><b>Welke:&nbsp;<input maxlength=255 type=text size=50 name=uploader_sites value=\"" . htmlspecialchars(@$uploader_sites) . "\"></td>";
print "</td></tr></table>";
print "</td></tr>";

print "<tr><td bgcolor=white><b>Bent&nbsp;u&nbsp;op&nbsp;een&nbsp;andere&nbsp;site&nbsp;ook&nbsp;staflid:</td>";
if ((@$error && !$staflid) || (@$error && !$staflid_sites))
	{
	if (($error && $staflid == 'ja') || !$staflid)
		print "<td align=left bgcolor=#FFFFCC>";
	else
		print "<td align=left bgcolor=#FFFFFF>";
	}
else
	print "<td align=left bgcolor=#FFFFFF>";
print "<table class=bottom border=0 cellspacing=0 cellpadding=10><tr>";
if (@$staflid == 'ja')
	print "<td class=embedded><input name=staflid type=radio value='ja' checked></td><td class=embeddedsite><div valign=middle><b><font color=green>Ja</td>";
else
	print "<td class=embedded><input name=staflid type=radio value='ja'></td><td class=embeddedsite><div valign=middle><b><font color=green>Ja</td>";
print "<td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
if (@$staflid == 'nee')
	print "<td class=embedded><input name=staflid type=radio value='nee' checked></td><td class=embeddedsite><div valign=middle><b><font color=red>Nee</td>";
else
	print "<td class=embedded><input name=staflid type=radio value='nee'></td><td class=embeddedsite><div valign=middle><b><font color=red>Nee</td>";
print "<td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
if (@$staflid == 'nee')
	print "<td class=embedded><b>Welke:&nbsp;<input maxlength=255 type=text size=50 name=staflid_sites value='Geen'></td>";
else
	print "<td class=embedded><b>Welke:&nbsp;<input maxlength=255 type=text size=50 name=staflid_sites value=\"" . htmlspecialchars(@$staflid_sites) . "\"></td>";
print "</td></tr></table>";
print "</td></tr>";

print "<tr><td bgcolor=white><b>Hoeveel&nbsp;uploads&nbsp;denkt&nbsp;u&nbsp;per&nbsp;maand&nbsp;te&nbsp;plaatsen:</td>";
if (@$error && !$aantal_uploads)
	print "<td align=left bgcolor=#FFFFCC>";
else
	print "<td align=left bgcolor=#FFFFFF>";
print "<table class=bottom border=0 cellspacing=0 cellpadding=10><tr>";
//if ($aantal_uploads == '1')
//	print "<td class=embedded><input name=aantal_uploads type=radio value='1' checked></td><td class=embeddedsite><div valign=middle><b><font color=blue>1</td>";
//else
//	print "<td class=embedded><input name=aantal_uploads type=radio value='1'></td><td class=embeddedsite><div valign=middle><b><font color=blue>1</td>";
//print "<td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
if (@$aantal_uploads == '2')
	print "<td class=embedded><input name=aantal_uploads type=radio value='2' checked></td><td class=embeddedsite><div valign=middle><b><font color=blue>2</td>";
else
	print "<td class=embedded><input name=aantal_uploads type=radio value='2'></td><td class=embeddedsite><div valign=middle><b><font color=blue>2</td>";
print "<td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
if (@$aantal_uploads == '3')
	print "<td class=embedded><input name=aantal_uploads type=radio value='3' checked></td><td class=embeddedsite><div valign=middle><b><font color=blue>3</td>";
else
	print "<td class=embedded><input name=aantal_uploads type=radio value='3'></td><td class=embeddedsite><div valign=middle><b><font color=blue>3</td>";
print "<td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
if (@$aantal_uploads == '4')
	print "<td class=embedded><input name=aantal_uploads type=radio value='4' checked></td><td class=embeddedsite><div valign=middle><b><font color=blue>4</td>";
else
	print "<td class=embedded><input name=aantal_uploads type=radio value='4'></td><td class=embeddedsite><div valign=middle><b><font color=blue>4</td>";
print "<td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
if (@$aantal_uploads == '5')
	print "<td class=embedded><input name=aantal_uploads type=radio value='5' checked></td><td class=embeddedsite><div valign=middle><b><font color=blue>meer</td>";
else
	print "<td class=embedded><input name=aantal_uploads type=radio value='5'></td><td class=embeddedsite><div valign=middle><b><font color=blue>meer</td>";
print "</td></tr></table>";
print "</td></tr>";

print "<tr><td bgcolor=white><b>Wat&nbsp;denkt&nbsp;u&nbsp;te&nbsp;gaan&nbsp;uploaden:</td>";
if (@$error && !$upload_wat)
	print "<td align=left bgcolor=#FFFFCC>";
else
	print "<td align=left bgcolor=#FFFFFF>";
print "<input maxlength=255 type=text size=100 name=upload_wat value=\"" . htmlspecialchars(@$upload_wat) . "\"></td></tr>";

print "<tr><td bgcolor=white><b>Opmerking:</td><td bgcolor=white align=left><input maxlength=255 type=text size=100 name=opmerking value=\"" . htmlspecialchars(@$opmerking) . "\"></td></tr>";

print "<tr><td bgcolor=white colspan=2 align=center><input type=submit style='height:26px;width:200px;color:white;font-weight:bold;background:blue' value='Verstuur uploader aanvraag'></td></tr>";
print "</form>";

print "<br></td></tr></table>";

tabel_einde();
page_einde();
site_footer();

function controleer_tabel($table = "")
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	
	if (!$table)
		return false;
	$res = mysqli_query($con_link, "SHOW TABLE STATUS LIKE '".$table."'") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_assoc($res);
	if ($row)
		{
		mysqli_free_result($res);
		return true;
		}
	else
		{
		mysqli_free_result($res);
		return false;
		}
	}
?>