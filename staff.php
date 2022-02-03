<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

function stafleden($class, $tekst="", $minimaal=0)
	{
	global $CURUSER, $pic_base_url;
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	if (!$class) return;
	if ($CURUSER['class'] < $minimaal) return;
	
	$breedte = 5;
	
	$breedte_naam = 160;
	$breedte_online = 20;
	$breedte_pm = 30;
	$breedte_space = 30;
	
	$count = 0;
	print "<table class=bottom border=0 cellspacing=0 cellpadding=3>";
	print "<tr>";
	print "<td class=embedded colspan=16><font size=4 color=white><b><hr>" . $tekst . "<hr></td>";
	print "</tr>";
	
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE class = " . $class . " ORDER BY username") or sqlerr(__FILE__, __LINE__);
	while ($row = mysqli_fetch_assoc($res))
		{
		print "<td class=embedded width=".$breedte_naam.">";
		print "<a class=altlink_white href='userdetails.php?id=".$row['id']."'>" . get_usernamesitesmal($row['id']) . "</a>";
		print "</td>";
		
		print "<td class=embedded width=".$breedte_online.">";
		if ($row['last_access'] < (get_date_time(gmtime() - 180)))
			print "<img src=".$pic_base_url."button_offline.gif border=0>";		
		else
			print "<img src=".$pic_base_url."button_online.gif border=0>";		
		print "</td>";

		print "<td class=embedded width=".$breedte_pm.">";
		print "<a class=altlink_white href=sendmessage.php?receiver=".$row['id']."><img src=".$pic_base_url."button_pm.gif border=0></a>";		
		print "</td>";

		print "<td class=embedded width=".$breedte_space.">&nbsp;</td>";

		$count++;

		if ($count == 4)
			{
			$count = 0;
			print "</tr><tr></br></br></br></br>";
			}
		}
		
	if ($count <= 4)
		{
		$teller = 4;
		for ($i = $count; $i < $teller; ++$i)
			{
			print "<td class=embedded width=".$breedte_naam.">&nbsp;</td>";
			print "<td class=embedded width=".$breedte_online.">&nbsp;</td>";
			print "<td class=embedded width=".$breedte_pm.">&nbsp;</td>";
			print "<td class=embedded width=".$breedte_space.">&nbsp;</td>";
			}
		}
	print "</td></tr>";
	print "</table><br>";
	}

site_header("Stafleden");
page_start(99);
tabel_top("<font size=5>Overzicht stafleden van " . $SITE_NAME ."</font>","center");

	if (get_user_class() >= UC_UPLOADER)

	{
	print "<font size=3>Wie zijn er nog meer online? Klik <a class=altlink_red href=gebruikers_overzicht.php>hier</a> and find out!</font></br></br>";
	}
tabel_start();
////////////////////////////////////////////////////////////////////////////////////////////////

 
$tijd = date("G"); //bepaal de tijd in uren 
 
if($tijd < 6) 
    { 
        echo "<font color=white size=5>Goede nacht!"; 
    } 
elseif($tijd < 12) 
    { 
        echo "<font color=white size=5>Goedemorgen!"; 
    } 
elseif($tijd < 18)   
    { 
        echo "<font color=white size=5>Goedemiddag!"; 
    } 
else 
    { 
        echo "<font color=white size=5>Goede avond !";   
    } 
	
	

///////////////////////////////////////////////////////////////////////////////////////////////
$uc_owner = get_row_count("users", "WHERE class=" . UC_SCRIPTER);
$uc_sysop = get_row_count("users", "WHERE class=" . UC_ADMINISTRATOR);
$uc_administrator = get_row_count("users", "WHERE class=" . UC_MODERATOR);
$uc_uploader = get_row_count("users", "WHERE class=" . UC_UPLOADER);

if ($uc_owner == 1)
	stafleden(UC_SCRIPTER, $uc_owner." Oprichter online", UC_ADMINISTRATOR);
else
	stafleden(UC_SCRIPTER, $uc_owner." Oprichters online", UC_ADMINISTRATOR);

if ($uc_sysop == 1)
	stafleden(UC_ADMINISTRATOR, $uc_sysop." Moderator online", UC_USER);
else
	stafleden(UC_ADMINISTRATOR, $uc_sysop." Moderators online", UC_USER);

if ($uc_administrator == 1)
	stafleden(UC_MODERATOR, $uc_administrator." Uploader online", UC_USER);
else
	stafleden(UC_MODERATOR, $uc_administrator." Uploaders online", UC_USER);

if ($uc_uploader == 1)
	stafleden(UC_UPLOADER,"Een extra bedankje voor ".$uc_uploader." lid", UC_UPLOADER);
else
	stafleden(UC_UPLOADER,"Een extra bedankje voor ".$uc_uploader." leden", UC_UPLOADER);

$first = substr($CURUSER['username'],0,1);
$first = strtoupper($first);

$res = mysqli_query($con_link, "SELECT * FROM mod_letters WHERE letter='$first'") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);	


if ($first == $row['letter'])
	{
	$which_mod = "<hr width=960><font size=5 color=white><b>Uw Moderator is ".get_username($row['userid']).". Heeft een vraag? Klik dan<a class=altlink_red href=sendmessage.php?receiver=".$row['userid']."> hier</a>.";
	}

print $which_mod;

tabel_einde();
page_einde();
site_footer();
?>
