<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_SYSOP)
	site_error_message("Foutmelding", "U heeft geen rechten voor deze pagina.");

function knop($aantal,$omschrijving,$knop)
	{
	print "<tr>\n";
	if (get_user_class() >= UC_SYSOP)
		{
		if ($aantal > 0)
			{
			print "<td width=170 height=30 bgcolor=white><div align=center><form method=post action=_opruimen.php>\n";			
			print "<input type=hidden name=action value=".$knop."><input type=submit style='height: 22px;width: 130px;color:red;font-weight:bold' value='NU VERWIJDEREN'></form>\n";
			}
		else
			print "<td width=160 height=30 bgcolor=white><div align=center></td>\n";			
		}
	print "<td bgcolor=white width=30 align=center>" . $aantal;
	print "</td><td bgcolor=white width=600>";
	print $omschrijving;
	print("</td></tr>\n");
	}
	
function optimzeknop($aantal,$omschrijving,$knop)
	{
	print "<tr>\n";
	if (get_user_class() >= UC_SYSOP)
		{
		if ($aantal > 0)
			{
			print "<td width=170 height=30 bgcolor=white><div align=center><form method=post action=_opruimen.php>\n";			
			print "<input type=hidden name=action value=".$knop."><input type=submit style='height: 22px;width: 130px;color:red;font-weight:bold' value='NU OPRUIMEN'></form>\n";
			}
		else
			print "<td width=160 height=30 bgcolor=white><div align=center></td>\n";			
		}
	print "<td bgcolor=white width=30 align=center>" . $aantal;
	print "</td><td bgcolor=white width=600>";
	print $omschrijving;
	print("</td></tr>\n");
	}

$maxclass = UC_POWER_USER;

$ip_logboek = time() - 86400 * 1;// site gegevens 
$inactive_no_downup = time() - 86400 * 21;
$signup_timeout = time() - 86400 * 3;
$inactive_user = time() - 86400 * 60;
$bad_ratio_days = time() - 86400 * 14;
$bad_ratio = 0.4;
$system_message = time() - 86400 * 10;
$all_message = time() - 86400 * 21;
$warnings = time() - 86400 * 14;
$waarschuwingen = time() - 86400 * 90; // Waarschuwingen in profiel...

$action = @$_POST['action'];

if ($action == "bad_ratio_days")
	{
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE downloaded>1024*1024*1024 AND enabled='yes' AND class <= $maxclass AND last_access < FROM_UNIXTIME($bad_ratio_days)") or sqlerr(__FILE__, __LINE__);
	while ($row = mysqli_fetch_assoc($res))
		{
		$ratio =  number_format((($row["downloaded"] > 0) ? ($row["uploaded"] / $row["downloaded"]) : 0),2);
		$donor = $row['donor'];
		if ($ratio < 0.4)
			{
			$id = $row['id'];
			verwijder_gebruiker($id);
			}
		}
	}

if ($action == "pending_users")
	{
	$res = mysqli_query($con_link, "SELECT id FROM users WHERE status = 'pending' AND added < FROM_UNIXTIME($signup_timeout) AND last_login < FROM_UNIXTIME($signup_timeout) AND last_access < FROM_UNIXTIME($signup_timeout)") or sqlerr(__FILE__, __LINE__);
	while ($arr = mysqli_fetch_assoc($res))
		{
		$id = $arr['id'];
		verwijder_gebruiker($id);
		}
	if ($arr)
		mysqli_query($con_link, "OPTIMIZE TABLE users") or sqlerr(__FILE__, __LINE__);
	}

if ($action == "warn_pm_seeding")
	{
	mysqli_query($con_link, "DELETE FROM warn_pm_seeding WHERE added < FROM_UNIXTIME($warnings)") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "OPTIMIZE TABLE warn_pm_seeding") or sqlerr(__FILE__, __LINE__);
	}

if ($action == "warn_pm_torrent")
	{
	mysqli_query($con_link, "DELETE FROM warn_pm_torrent WHERE added < FROM_UNIXTIME($warnings)") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "OPTIMIZE TABLE warn_pm_torrent") or sqlerr(__FILE__, __LINE__);
	}

if ($action == "waarschuwingen")
	{
	mysqli_query($con_link, "DELETE FROM warnings WHERE date < FROM_UNIXTIME($waarschuwingen)") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "OPTIMIZE TABLE warnings") or sqlerr(__FILE__, __LINE__);
	}
	
if ($action == "warn_pm_gb")
	{
	mysqli_query($con_link, "DELETE FROM warn_pm_gb WHERE added < FROM_UNIXTIME($warnings)") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "OPTIMIZE TABLE warn_pm_gb") or sqlerr(__FILE__, __LINE__);
	}

if ($action == "warn_pm_gb_last")
	{
	mysqli_query($con_link, "DELETE FROM warn_pm_gb_last WHERE added < FROM_UNIXTIME($warnings)") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "OPTIMIZE TABLE warn_pm_gb_last") or sqlerr(__FILE__, __LINE__);
	}

if ($action == "system_message")
	{
	mysqli_query($con_link, "DELETE FROM messages WHERE sender='0' AND added < FROM_UNIXTIME($system_message)") or sqlerr(__FILE__, __LINE__);
	}

if ($action == "inactive_user")
	{
	$res = mysqli_query($con_link, "SELECT id FROM users WHERE status='confirmed' AND class <= $maxclass AND last_access < FROM_UNIXTIME($inactive_user) AND last_access != '0000-00-00 00:00:00'") or sqlerr(__FILE__, __LINE__);
	while ($arr = mysqli_fetch_assoc($res))
		{
		$id = $arr['id'];
		verwijder_gebruiker($id);
		}
	}

if ($action == "inactive_no_downup")
	{
	$res = mysqli_query($con_link, "SELECT id FROM users WHERE downloaded=0 AND uploaded=0 AND last_access < FROM_UNIXTIME($inactive_no_downup) AND last_access") or sqlerr(__FILE__, __LINE__);
	while ($arr = mysqli_fetch_assoc($res))
		{
		$id = $arr['id'];
//		site_error_message("Gelukt", "Verwijderen gelukt als ik deze blokkade regel weg haal.");
		verwijder_gebruiker($id);
		}
	}

if ($action == "all_message")
	{
	mysqli_query($con_link, "DELETE FROM messages WHERE added < FROM_UNIXTIME($all_message)") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "OPTIMIZE TABLE messages") or sqlerr(__FILE__, __LINE__);
	}


if ($action == "user_ip")
	{
	mysqli_query($con_link, "DELETE FROM user_ip") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "OPTIMIZE TABLE user_ip") or sqlerr(__FILE__, __LINE__);
	}
////////////////////////////site gegevens///////////////////////////////////////////////////////////////////////////	
if ($action == "ip_logboek")                                                                                      //    
	{                                                                                                             //		
	mysqli_query($con_link, "DELETE FROM ip_logboek WHERE added < FROM_UNIXTIME($ip_logboek)") or sqlerr(__FILE__, __LINE__); //
	mysqli_query($con_link, "OPTIMIZE TABLE ip_logboek") or sqlerr(__FILE__, __LINE__);                                       //
	}	                                                                                                          //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

site_header();
print "<br>";
print("<table width=99% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
tabel_top("Opruim pagina","center");
print "<table align=center class=site border=0 width=100% cellpadding=0 cellspacing=0>";
print "<tr><td class=embedded>";
print "</td></tr></table>";
print "<table background=pic/site/table_background.gif width=100% border=0 cellspacing=0 cellpadding=0>";
print "<tr>";
print "<td class=embedded><div align=center><br>";
print "<table class=outer border=1 cellspacing=0 cellpadding=5>";

$aantal = get_row_count("users", "WHERE downloaded=0 AND uploaded=0 AND last_access < FROM_UNIXTIME($inactive_no_downup) AND last_access");
knop($aantal, "Gebruikers verwijderen die 21 dagen lid zijn en nog niets hebben 'Ontvangen' en niets hebben 'Verzonden'.","inactive_no_downup");

$aantal = get_row_count("users", "WHERE status = 'pending' AND added < FROM_UNIXTIME($signup_timeout) AND last_login < FROM_UNIXTIME($signup_timeout) AND last_access < FROM_UNIXTIME($signup_timeout)");
knop($aantal, "Gebruikers die al 3 dagen wel geregistreerd zijn maar niet de e-mail hebben bevestigd.","pending_users");

$aantal = get_row_count("users", "WHERE status='confirmed' AND class <= $maxclass AND last_access < FROM_UNIXTIME($inactive_user) AND last_access != '0000-00-00 00:00:00'");
knop($aantal, "Inactieve gebruikers welke 60 dagen niets op de site zijn geweest.","inactive_user");

$aantal = 0;
$res = mysqli_query($con_link, "SELECT * FROM users WHERE downloaded>1024*1024*1024 AND enabled='yes' AND class <= $maxclass AND last_access < FROM_UNIXTIME($bad_ratio_days)") or sqlerr(__FILE__, __LINE__);
while ($row = mysqli_fetch_assoc($res))
	{
	$ratio =  number_format((($row["downloaded"] > 0) ? ($row["uploaded"] / $row["downloaded"]) : 0),2);
	if ($ratio < 0.4) 
		{
		$aantal = $aantal + 1;
		}
	}
knop($aantal, "Gebruikers met een ratio lager dan 0.4 welke 14 dagen niet op de site zijn geweest.","bad_ratio_days");

$aantal = get_row_count("messages", "WHERE sender='0' AND added < FROM_UNIXTIME($system_message)");
knop($aantal, "Systeem berichten die ouder zijn dan 10 dagen.","system_message");

$aantal = get_row_count("messages", "WHERE added < FROM_UNIXTIME($all_message)");
knop($aantal, "Alle berichten die ouder zijn dan 21 dagen.","all_message");

$aantal = get_row_count("warn_pm_gb", "WHERE added < FROM_UNIXTIME($warnings)");
knop($aantal, "Waarschuwingen voor 15 Gb en hoger ouder dan 14 dagen.","warn_pm_gb");

$aantal = get_row_count("warn_pm_gb_last", "WHERE added < FROM_UNIXTIME($warnings)");
knop($aantal, "Waarschuwingen voor 20 Gb en hoger ouder dan 14 dagen.","warn_pm_gb_last");

$aantal = get_row_count("warn_pm_seeding", "WHERE added < FROM_UNIXTIME($warnings)");
knop($aantal, "Waarschuwingen voor overseeden ouder dan 14 dagen.","warn_pm_seeding");

$aantal = get_row_count("warn_pm_torrent", "WHERE added < FROM_UNIXTIME($warnings)");
knop($aantal, "Waarschuwingen voor pakken en wegwezen ouder dan 14 dagen.","warn_pm_torrent");

$aantal = get_row_count("warnings", "WHERE date < FROM_UNIXTIME($waarschuwingen)");
knop($aantal, "Waarschuwingen uit profiel gebruiker ouder dan 90 dagen.","waarschuwingen");

//////////////////////////////////site gegevens///////////////////////////////////////////////////////
$aantal = get_row_count("ip_logboek", "WHERE added < FROM_UNIXTIME($ip_logboek)");                     //
knop($aantal, "Legen uit view_ip ouder dan 1 dag(en).","ip_logboek");                                       //
//////////////////////////////////////////////////////////////////////////////////////////////////////
//$aantal = get_row_count("user_ip", "");
//knop($aantal, "Gebruikte ip-nummers.","user_ip");

print("</td></tr></table>");
print("<br></td></tr></table>");
print("</td></table><br>");
new_footer(false);

?>