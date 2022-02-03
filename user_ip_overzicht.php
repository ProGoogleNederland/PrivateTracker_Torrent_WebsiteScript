<?php  
require_once("include/bittorrent.php");  
require_once("include/secrets.php");  
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;  
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);  
dbconn();  
loggedinorreturn();  
  
if (get_user_class() < UC_ADMINISTRATOR)  
	site_error_message("Foutmelding", "u heeft geen toegang tot deze pagina.");  
  
$ip = @$_GET['ip'];  
$id = @$_GET['id'];  

$return_id = 0 + @$_GET['return_id'];  
if ($return_id < 1)  
	$return_id = 0 + @$_POST['return_id'];  
  
$action = @$_POST['action'];  
  
if ($action == "verwijder")  
	{  
	$id_nr = 0 + @$_POST['id_nr'];  
	mysqli_query($con_link, "DELETE FROM user_ip WHERE id=$id_nr") or sqlerr(__FILE__, __LINE__);  
	if ($id)  
		{  
	  	header("Location: user_ip_overzicht.php?id=$id");  
		die;  
		}  
	if ($ip)  
		{  
	  	header("Location: user_ip_overzicht.php?ip=$ip&return_id=$return_id");  
		die;  
		}  
	die;  
	}  
  
if ($action == "verwijder_alle")  
	{  
	$id_nr = 0 + @$_POST['id_nr'];  
	mysqli_query($con_link, "DELETE FROM user_ip WHERE userid=$id_nr") or sqlerr(__FILE__, __LINE__);  
	if ($id)  
		{  
	  	header("Location: user_ip_overzicht.php?id=$id");  
		die;  
		}  
	if ($ip)  
		{  
	  	header("Location: user_ip_overzicht.php?ip=$ip&return_id=$return_id");  
		die;  
		}  
	die;  
	}  
	  
if ($action == "verwijder_alle_ip")  
	{  
	$id_nr = 0 + @$_POST['id_nr'];  
	mysqli_query($con_link, "DELETE FROM user_ip WHERE ip='$ip'") or sqlerr(__FILE__, __LINE__);  
	if ($id)  
		{  
	  	header("Location: user_ip_overzicht.php?id=$id");  
		die;  
		}  
	if ($ip)  
		{  
	  	header("Location: user_ip_overzicht.php?ip=$ip&return_id=$return_id");  
		die;  
		}  
	die;  
	}  
	  
if (@$_GET['id'])   
	{  
	$id = @$_GET['id'];  
		  
	site_header("IP overzicht");  
	page_start(98);  
	tabel_top("Overzicht van gebruikte ipnummers door " . get_username($id),"center");  
	tabel_start(98);  
	  
	print "<table width=98% class=outer border=1 cellspacing=0 cellpadding=5>";  
	print "<tr>";  
	print "<td class=colheadsite width=140>Ip</td>";  
	print "<td class=colheadsite width=400>Gberuikers</td>";  
	print "<td class=colheadsite width=140>Eerste&nbsp;keer&nbsp;gezien</td>";  
	print "<td class=colheadsite width=140>Laatste&nbsp;keer&nbsp;gezien</td>";  
	print "<td class=colheadsite width=100>Verwijderen</td>";  
	print "</tr>";  
  
	$res = mysqli_query($con_link, "SELECT * FROM user_ip WHERE userid=$id ORDER BY last_seen DESC") or sqlerr(__FILE__, __LINE__);	  
	while ($row = mysqli_fetch_assoc($res))  
		{  
		print "<tr><td bgcolor=white width=120>";  
		print "<b>" . $row['ip'];  
		print "</td><td bgcolor=white>";  
		$tmp_ip = sqlesc($row['ip']);  
		$namen = "";  
		$res2 = mysqli_query($con_link, "SELECT * FROM user_ip WHERE ip=$tmp_ip ORDER BY last_seen DESC") or sqlerr(__FILE__, __LINE__);	  
		while ($row2 = mysqli_fetch_assoc($res2))  
			{  
			if (!$namen)  
				$namen = "<a class=altlink_blue href='userdetails.php?id=".$row2['userid']."'>" . get_username($row2['userid']) . "</a>";  
			else  
				$namen .= "&nbsp;-&nbsp;<a class=altlink_blue href='userdetails.php?id=".$row2['userid']."'>" . get_username($row2['userid']) . "</a>";  
			}  
		print $namen;  
		print "</td><td bgcolor=white>";  
		print convertdatum($row['added']);  
		print "</td><td bgcolor=white>";  
		print convertdatum($row['last_seen']);  
		print "</td><td bgcolor=white>";  
		print "<form method=post action=''>";  
		print "<input type=hidden name=action value='verwijder'>";  
		print "<input type=hidden name=id value=".$id.">";  
		print "<input type=hidden name=id_nr value=".$row['id'].">";  
		print "<input type=submit style='height: 22px;width: 100px' value='Verwijderen'>";  
		print "</form>";  
		print "</td></tr>";  
		}	  
	print "</table>";  
	print "<br>";  
	print "<form method=post action=''>";  
	print "<input type=hidden name=action value='verwijder_alle'>";  
	print "<input type=hidden name=id_nr value=".$id.">";  
	print "<input type=submit style='height: 32px;width: 180px' value='Alle verwijderen'>";  
	print "</form>";  
  
	print "<br>";  
  
	print "<form method=get action='userdetails.php'>";  
	print "<input type=hidden name=id value=".$id.">";  
	print "<input type=submit style='height: 24px;width: 120px' value='Terug'>";  
	print "</form>";  
  
	tabel_einde();  
	page_einde();  
	site_footer();  
	die;  
	}  
  
if ($ip)  
	{  
	$ip = sqlesc($ip);  
	site_header("IP overzicht");  
	page_start(98);  
	tabel_top("Overzicht gebruikers welke ip-nummer " . $ip . " gebruikt hebben.","center");  
	tabel_start(98);  
	  
	print "<table width=98% class=outer border=1 cellspacing=0 cellpadding=5>";  
	print "<tr>";  
	print "<td class=colheadsite width=140>Gebruiker</td>";  
	print "<td class=colheadsite width=180>Eerste&nbsp;keer&nbsp;gezien</td>";  
	print "<td class=colheadsite width=180>Laatste&nbsp;keer&nbsp;gezien</td>";  
	print "<td class=colheadsite width=100>Verwijderen</td>";  
	print "</tr>";  
  
	$res = mysqli_query($con_link, "SELECT * FROM user_ip WHERE ip=$ip ORDER BY last_seen DESC") or sqlerr(__FILE__, __LINE__);	  
	while ($row = mysqli_fetch_assoc($res))  
		{  
		print "<tr><td bgcolor=white width=120>";  
		print "<a class=altlink_blue href='userdetails.php?id=".$row['userid']."'>" . get_username($row['userid']) . "</a>";  
		print "</td><td bgcolor=white>";  
		print convertdatum($row['added']);  
		print "</td><td bgcolor=white>";  
		print convertdatum($row['last_seen']);  
		print "</td><td bgcolor=white>";  
		print "<form method=post action=''>";  
		print "<input type=hidden name=action value='verwijder'>";  
		print "<input type=hidden name=id_nr value=".$row['id'].">";  
		print "<input type=hidden name=ip value=".$ip.">";  
		print "<input type=hidden name=return_id value=".$return_id.">";  
		print "<input type=submit style='height: 22px;width: 100px' value='Verwijderen'>";  
		print "</form>";  
		print "</td></tr>";  
		}	  
	print "</table>";  
	print "<br>";  
	print "<form method=post action=''>";  
	print "<input type=hidden name=action value='verwijder_alle_ip'>";  
	print "<input type=hidden name=ip value=".$ip.">";  
	print "<input type=hidden name=return_id value=".$return_id.">";  
	print "<input type=submit style='height: 32px;width: 180px' value='Alle verwijderen'>";  
	print "</form>";  
  
	print "<br>";  
  
	print "<form method=get action='userdetails.php'>";  
	print "<input type=hidden name=id value=".$return_id.">";  
	print "<input type=submit style='height: 24px;width: 120px' value='Terug'>";  
	print "</form>";  
	tabel_einde();  
	page_einde();  
	site_footer();  
	die;  
	}  
	  
site_error_message("Foutmelding", "Geen gegevens ontvangen.");  
?>