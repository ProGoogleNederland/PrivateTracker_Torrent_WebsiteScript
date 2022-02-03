<?php  
error_reporting(E_ALL);  
ini_set('display_errors', 1);  
require "include/bittorrent.php";  
require_once("include/secrets.php");  
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;  
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);  
dbconn(false);  
loggedinorreturn();  
?><style>td.colheadsite {    column-rule-width: unset;    column-width: 175px!important;}</style><?php  $ip = @$_GET["ip"];  
$addr = $ip;function maketable($res)  
	{  
	global $cats;  
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;  
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);  
	if (!isset($cats))  
	{  
		$res2 = mysqli_query($con_link, "SELECT id, image, name FROM categories") or sqlerr(__FILE__, __LINE__);  
		while ($arr = mysqli_fetch_assoc($res2))  
		{  
			$catimages[$arr["id"]] = $arr["image"];  
			$catnames[$arr["id"]] = $arr["name"];  
		}  
	}  
  $ret = "<table width=98% class=outer border=1 cellspacing=0 cellpadding=5>" .  
    "<tr><td class=colheadsite>Soort</td><td class=colheadsite>Naam</td><td class=colheadsite align=center>Grootte</td><td class=colheadsite align=center>Verzonden</td>" .  
    "<td class=colheadsite align=center>Ontvangen</td><td class=colheadsite align=center>Ratio&nbsp;torrent</td></tr>";  
  while ($arr = mysqli_fetch_assoc($res))  
  {  
  
	$del_old = get_row_count("torrents", "WHERE id=$arr[torrent]");  
	if ($del_old == 0) {  
		mysqli_query($con_link, "DELETE FROM downloaded WHERE torrent=$arr[torrent]") or sqlerr(__FILE__, __LINE__);  
		}  
	else {  
	$res2 = mysqli_query($con_link, "SELECT name=$name,size,category,added FROM torrents WHERE id=$arr[torrent]");  
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
      if ($rowsite["uploaded"] > 0)  
        $ratio = "<center><img border=0 src=pic/oneindig.gif></center>";  
      else  
        $ratio = "---";  
  
	if ($rowsite)  
		$uploaded = str_replace(" ", "&nbsp;", mksize($rowsite["uploaded"]));  
	else  
		$uploaded = "onbekend";  
	if ($rowsite)  
		$downloaded = str_replace(" ", "&nbsp;", mksize($rowsite["downloaded"]));  
	else  
		$downloaded = "onbekend";  
	  
    $ret .= "<tr><td bgcolor=white><font color=blue><b>$catname</b></font></td>" .  
		"<td bgcolor=white><a href=details.php?id=$arr[torrent]&amp;hit=1><b>" . htmlspecialchars($arr2[$name]) .  
		"</b></a></td><td align=center bgcolor=white>$size</td><td align=center bgcolor=white>$uploaded</td>" .  
		"<td align=center bgcolor=white>$downloaded</td><td align=center bgcolor=white>$ratio</td></tr>";  
  }  
	}  
  $ret .= "</table>";  
  return $ret;  
}  
  
function maketable_seeding($res)  
{  
	global $cats;  
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;  
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);  
	if (!isset($cats))  
	{  
		$res2 = mysqli_query($con_link, "SELECT id,image,name FROM categories") or sqlerr(__FILE__, __LINE__);  
		while ($arr = mysqli_fetch_assoc($res2))  
		{  
			$catimages[$arr["id"]] = $arr["image"];  
			$catnames[$arr["id"]] = $arr["name"];  
		}  
	}  
	if (get_user_class() >= UC_MODERATOR)  
		{  
		$ret = "<table width=98% class=outer border=1 cellspacing=0 cellpadding=5>" .  
		"<tr><td class=colheadsite>Soort</td><td class=colheadsite>Naam</td><td class=colheadsite align=center>Grootte</td><td class=colheadsite align=center>Verzonden</td>" .  
		"<td class=colheadsite align=center>Ontvangen</td><td class=colheadsite align=center>Ratio&nbsp;torrent</td><td class=colheadsite align=center>Stuur&nbsp;overseed&nbsp;bericht</td></tr>";  
		}  
	else  
		{  
		$ret = "<table width=98% class=outer border=1 cellspacing=0 cellpadding=5>" .  
		"<tr><td class=colheadsite>Soort</td><td class=colheadsite>Naam</td><td class=colheadsite align=center>Grootte</td><td class=colheadsite align=center>Verzonden</td>" .  
		"<td class=colheadsite align=center>Ontvangen</td><td class=colheadsite align=center>Ratio&nbsp;torrent</td></tr>";  
		}  
  while ($arr = mysqli_fetch_assoc($res))  
  {  
  
	$del_old = get_row_count("torrents", "WHERE id=$arr[torrent]");  
	if ($del_old == 0) {  
		mysqli_query($con_link, "DELETE FROM downloaded WHERE torrent=$arr[torrent]") or sqlerr(__FILE__, __LINE__);  
		}  
	else {  
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
      	$ratio_send = number_format($rowsite["uploaded"] / $rowsite["downloaded"], 2);  
      	$ratio = "<font color=" . get_ratio_color($ratio) . ">$ratio</font>";  
		if ($rowsite["uploaded"] / $rowsite["downloaded"] > 20) $ratio = "<center><img border=0 src=pic/oneindig.gif></center>";  
    }  
    else  
      if ($rowsite["uploaded"] > 0)  
        $ratio = "<center><img border=0 src=pic/oneindig.gif></center>";  
      else  
        $ratio = "---";  
  
	if ($rowsite)  
		$uploaded = str_replace(" ", "&nbsp;", mksize($rowsite["uploaded"]));  
	else  
		$uploaded = "onbekend";  
	if ($rowsite)  
		$downloaded = str_replace(" ", "&nbsp;", mksize($rowsite["downloaded"]));  
	else  
		$downloaded = "onbekend";  
  
	$sender = "";  
	$message = "&nbsp;";  
	if (get_row_count("warn_pm_seeding", "WHERE receiver=$userid AND torrent=$torrentid") > 0)   
		{  
		$def =  mysqli_query($con_link, "SELECT sender FROM warn_pm_seeding WHERE receiver=$userid AND torrent=$torrentid") or sqlerr(__FILE__, __LINE__);  
		while ($defs = mysqli_fetch_assoc($def))  
			{  
			$sender .= get_username($defs['sender']) . ", ";  
			}  
		}  
		if ($rowsite["uploaded"] > 0)  
			{  
			if (@$ratio_send > 1.5)  
				{  
				if ($sender)  
					$message =  $sender . "<a class=altlink href=message_seeding.php?userid=" . $userid . "&amp;warnid=1&amp;torrentid=$torrentid&amp;ratio=$ratio_send&amp;referer=userdetails.php?id=$userid>nogmaals</a>";  
				else  
					$message = "<a class=altlink href=message_seeding.php?userid=" . $userid . "&amp;warnid=1&amp;torrentid=$torrentid&amp;ratio=$ratio_send&amp;referer=userdetails.php?id=$userid>stuur pm</a>";  
				}  
			}  
		  
	if (get_user_class() >= UC_MODERATOR)  
		{  
	    $ret .= "<tr><td bgcolor=white><font color=blue><b>$catname</b></font></td>" .  
		"<td bgcolor=white><a href=details.php?id=$arr[torrent]&amp;hit=1><b>" . htmlspecialchars(@$arr2['name']) .  
		"</b></a></td><td align=center bgcolor=white>$size</td><td align=center bgcolor=white>$uploaded</td>" .  
		"<td align=center bgcolor=white>$downloaded</td><td align=center bgcolor=white>$ratio</td><td align=center bgcolor=white>$message</td></tr>";  
		}  
	else  
		{  
	    $ret .= "<tr><td bgcolor=white><font color=blue><b>$catname</b></font></td>" .  
		"<td bgcolor=white><a href=details.php?id=$arr[torrent]&amp;hit=1><b>" . htmlspecialchars(@$arr2['name']) .  
		"</b></a></td><td align=center bgcolor=white>$size</td><td align=center bgcolor=white>$uploaded</td>" .  
		"<td align=center bgcolor=white>$downloaded</td><td align=center bgcolor=white>$ratio</td></tr>";  
		}  
  }  
	}  
  $ret .= "</table>";  
  return $ret;  
}  
  
function maketable_downloaded($res)  
{  
	global $cats, $id;  
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;  
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);  
	if (!isset($cats))  
	{  
		$res2 = mysqli_query($con_link, "SELECT id, image, name FROM categories") or sqlerr(__FILE__, __LINE__);  
		while ($arr = mysqli_fetch_assoc($res2))  
		{  
			$catimages[$arr["id"]] = $arr["image"];  
			$catnames[$arr["id"]] = $arr["name"];  
		}  
	}  
  
	if (get_user_class() >= UC_SYSOP)  
		{  
		@$ret .=  "<div align=right><form method=post action=user_downup_gb_all.php>";  
		$ret .=  "<input type=hidden name=action value=correctie>";  
		$ret .=  "<input type=hidden name=userid value=".$id.">";  
		$ret .=  "<input type=hidden name=returnto value=userdetails.php?id=".$id.">";  
		$ret .=  "<input type=submit style='height:26px;width:200px;color:white;font-weight:bold;background:red' value='Alle torrents aanpassen'>";  
		$ret .=  "</form><br><div align=center>";  
		}  
  
  	@$ret .= "<table width=100% class=outer border=1 cellspacing=0 cellpadding=5>" .  
    	"<tr><td class=colheadsite>Soort</td>		<td class=colheadsite>Naam</td>		<td class=colheadsite>Datum</td>		<td class=colheadsite>Grootte</td>		<td class=colheadsite>Verzonden</td>" .  
    	"<td class=colheadsite>Ontvangen</td>		<td class=colheadsite>Ratio torrent";  
	if (get_user_class() >= UC_OWNER)  
		{  
		$ret .= "</td><td class=colheadsite align=center>Correctie";  
		}  
	$ret .= "</td></tr>";  
  while ($arr = mysqli_fetch_assoc($res))  
  {  
  
	$del_old = get_row_count("torrents", "WHERE id=$arr[torrent]");  
	if ($del_old == 0) {  
		mysqli_query($con_link, "DELETE FROM downloaded WHERE torrent=$arr[torrent]") or sqlerr(__FILE__, __LINE__);  
		}  
	else {  
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
      if ($rowsite["uploaded"] > 0)  
        $ratio = "<center><img border=0 src=pic/oneindig.gif></center>";  
      else  
        $ratio = "---";  
  
	if ($rowsite)  
		$uploaded = str_replace(" ", "&nbsp;", mksize($rowsite["uploaded"]));  
	else  
		$uploaded = "onbekend";  
  
	if ($rowsite)  
		$downloaded = str_replace(" ", "&nbsp;", mksize($rowsite["downloaded"]));  
	else  
		$downloaded = "onbekend";  
	if ($rowsite)  
		$added = convertdatum($arr['added'], "no");	  
	  
    $ret .= "<tr><td bgcolor=white><font color=blue><b>$catname</b></font></td>" .  
		"<td bgcolor=white><a href=details.php?id=$arr[torrent]&amp;hit=1><b>" . htmlspecialchars($arr2['name']) .  
		"</b></a></td><td align=left bgcolor=white>$added</td><td align=left bgcolor=white>$size</td><td align=left bgcolor=white>$uploaded</td>" .  
		"<td align=left bgcolor=white>$downloaded</td><td align=left bgcolor=white>$ratio";  
	if (get_user_class() >= UC_ADMINISTRATOR)  
		{  
		$ret .=  "</td><td bgcolor=white align=center>";  
		$ret .=  "<table class=bottom><tr><td class=embedded>";  
		$ret .=  "<form method=post action=user_downup_gb.php>";  
		$ret .=  "<input type=hidden name=action value=correctie>";  
		$ret .=  "<input type=hidden name=torrentid value=".$torrentid.">";  
		$ret .=  "<input type=hidden name=userid value=".$userid.">";  
		$ret .=  "<input type=hidden name=returnto value=userdetails.php?id=".$userid.">";  
		$ret .=  "<input type=submit style='height:20px;width:80px;color:white;font-weight:bold;background:blue' value='Aanpassen'>";  
		$ret .=  "</form>";  
		$ret .=  "</td></tr></table>";  
		}	  
	$ret .= "</td></tr>";  
  }  
	}  
  $ret .= "</table>";  
  return $ret;  
}  
  
$id = @$_GET["id"];  
$id = 0 + $id;  
	  
if (!is_valid_id($id))  
  @site_error_message("Foutmelding, fout ID-nummer $id.");  
  
$r = @mysqli_query($con_link, "SELECT * FROM users WHERE id=$id AND id!= 0") or sqlerr();  
$user = mysqli_fetch_array($r) or @site_error_message("", "Er is geen gebruiker met dit ID.", 'red');  
  
if ($user["status"] == "pending")  
	@site_error_message("Foutmelding", "Deze gebruiker heeft nog niet op de bevestiging e-mail gereageerd.");  
  
	$r = mysqli_query($con_link, "SELECT id, added, name, seeders, leechers, category FROM torrents WHERE owner=$id ORDER BY added DESC") or sqlerr();  
if (mysqli_num_rows($r) > 0)  
	{  
	$torrents = "<table width=98% class=outer border=1 cellspacing=0 cellpadding=5>" .  
	"<tr><td class=colheadsite >Soort</td>	<td class=colheadsite>Naam</td>	<td class=colheadsite>Geplaats op</td>	<td class=colheadsite>Delers</td>	<td class=colheadsite>Ontvangers</td>	</tr>";  
	while ($a = mysqli_fetch_assoc($r))  
  		{  
		$seeders_count = get_row_count("peers","WHERE seeder='yes' AND torrent=".$a['id']);  
		$leechers_count = get_row_count("peers","WHERE seeder='no' AND torrent=".$a['id']);  
		$r2 = mysqli_query($con_link, "SELECT name, image FROM categories WHERE id=$a[category]") or sqlerr(__FILE__, __LINE__);  
		$a2 = mysqli_fetch_assoc($r2);  
		$cat = "$a2[name]";  
		$torrents .= "<tr><td bgcolor=white><font color=blue><b>$cat</b></font></td><td bgcolor=white><a href=details.php?id=" . $a["id"] . "&hit=1><b>" . htmlspecialchars($a["name"]) . "</b></a></td>" .  
		"<td align=left bgcolor=white>" . convertdatum($a['added']) . "</td><td align=right bgcolor=white>$seeders_count</td><td align=right bgcolor=white>$leechers_count</td></tr>";  
		}  
	$torrents .= "</table>";  
	}  
  
  
// To count number of NZB's uploaded:  
// Uncomment the next line and ending "}" if you use the anonymous uploader mod  
//if ($user["advertisename"] == "yes" || $user["id"] == $CURUSER["id"] || get_user_class() >= UC_MODERATOR) {  
    $resnzb = mysqli_query($con_link, "SELECT COUNT(owner) AS num_nzbs FROM nzbs WHERE owner = $id");  
    $numnzb = @mysqli_data_seek($resnzb, 0);  
//}  
  
if ($user["ip"] && (get_user_class() >= UC_MODERATOR || $user["id"] == $CURUSER["id"]))  
{  
  $ip = $user["ip"];  
  $dom = @gethostbyaddr($user["ip"]);  
  if ($dom == $user["ip"] || @gethostbyname($dom) != $user["ip"])  
    $addr = $ip;  
  else  
  {  
    $dom = strtoupper($dom);  
    $domparts = explode(".", $dom);  
    $domain = $domparts[count($domparts) - 2];  
    if ($domain == "COM" || $domain == "CO" || $domain == "NET" || $domain == "NE" || $domain == "ORG" || $domain == "OR" )  
      $l = 2;  
    else  
      $l = 1;  
    $addr = "$ip ($dom)";  
  }  
}  
if ($user['added'] == "0000-00-00 00:00:00")  
  $joindate = 'Onbekend';  
else  
  $joindate = convertdatum($user['added'], "no") . " (" . get_elapsed_time(sql_timestamp_to_unix_timestamp($user["added"])) . " geleden)";  
  
$gezien = $user["last_access"];  
$lastseen = convertdatum($user["last_access"]);  
  
if ($gezien == "0000-00-00 00:00:00")  
  $lastseen = "nooit";  
else  
{  
  $lastseen .= " (" . get_elapsed_time(sql_timestamp_to_unix_timestamp($gezien)) . " geleden)";  
}  
  $res = mysqli_query($con_link, "SELECT COUNT(*) FROM comments WHERE user=" . $user['id']) or sqlerr();  
  $arr3 = mysqli_fetch_row($res);  
  $torrentcomments = $arr3[0];  
  //$res = mysqli_query($con_link, "SELECT COUNT(*) FROM nzbcomments WHERE user=" . $user["id"]) or sqlerr();  
  //$arr3 = mysqli_fetch_row($res);  
  //$nzbcomments = $arr3[0];  
  $res = mysqli_query($con_link, "SELECT COUNT(*) FROM posts WHERE userid=" . $user['id']) or sqlerr();  
  $arr3 = mysqli_fetch_row($res);  
  $forumposts = $arr3[0];  
  
if ($user["donor"] == "yes") $donor = "<img width=22 height=22 src=pic/system/star.gif alt='Donor' style='margin-top: 0pt'>";  
if ($user["warned"] == "yes") $warned = "<td class=embedded><img src=pic/warnedbig.gif alt='Warned' style='margin-left: 4pt'></td>";  
  
$res = mysqli_query($con_link, "SELECT userid AS user,torrent,uploaded,downloaded FROM peers WHERE userid=$id AND seeder='no'");  
if (mysqli_num_rows($res) > 0)  
  $leeching = maketable($res);  
$res = mysqli_query($con_link, "SELECT userid AS user,torrent,uploaded,downloaded FROM peers WHERE userid=$id AND seeder='yes'");  
if (mysqli_num_rows($res) > 0)  
  $seeding = maketable_seeding($res);  
$res = mysqli_query($con_link, "SELECT torrent, user, added, uploaded, downloaded FROM downloaded WHERE user=$id ORDER BY added DESC");  
if (mysqli_num_rows($res) > 0)  
  $downloaded = maketable_downloaded($res);  
///////////////////////////////////////////////////////////////////////////  
$user_id = $user["id"];  
///////////////////////////////////////////////////////////////////////////  
site_header("gegevens van " . $user["username"]);  
$enabled = $user["enabled"] == 'yes';  
  
/// Nieuwe look  
if ($CURUSER["id"] != $user["id"])  
	if (get_user_class() >= UC_MODERATOR)  
  		$showpmbutton = 1;  
	elseif ($user["acceptpms"] == "yes")  
		{  
		$r = mysqli_query($con_link, "SELECT id FROM blocks WHERE userid=$user[id] AND blockid=$CURUSER[id]") or sqlerr(__FILE__,__LINE__);  
		$showpmbutton = (mysqli_num_rows($r) == 1 ? 0 : 1);  
		}  
	elseif ($user["acceptpms"] == "friends")  
		{  
		$r = mysqli_query($con_link, "SELECT id FROM friends WHERE userid=$user[id] AND friendid=$CURUSER[id]") or sqlerr(__FILE__,__LINE__);  
		$showpmbutton = (mysqli_num_rows($r) == 1 ? 1 : 0);  
		}  
  
if ($user['donor'] == "yes") $donortext = "&nbsp;&nbsp;<font color=white><b>" . $donor . " Donateur tot " . convertdatum($user['donor_until'], "no") . "</b></font>";  
  
if ($user['blocked'] == "yes")  
	{  
	$block_text = "<font color=red size=4><b>";  
	$block_text .= "ACCOUNT IS GEBLOKKEERD OP " . convertdatum($user['blocked_date']) . "<br>";  
	$block_text .= "DOOR " . get_username($user['blocked_by']) . "<br>";  
	$block_text .= "REDEN: " . htmlspecialchars($user['blocked_reason']) . "<br>";  
	print $block_text;  
	}  
  
if (!$enabled)  
	print("<p><font size=5 color=red><b>Dit account is uitgeschakeld.</b></font></p>");  
if (@$warned)  
	{  
	if ($user['warnedby'] > 0)  
		print("<p><font size=5 color=red><b>" . $user['username'] . " is gewaarschuwd door " . get_username($user['warnedby']) . ".</b></font></p>");  
	else  
		print("<p><font size=5 color=red><b>" . $user['username'] . " is gewaarschuwd door het systeem.</b></font></p>");  
	}  
if ($CURUSER["id"] <> $user["id"])  
	{  
	$r = mysqli_query($con_link, "SELECT id FROM friends WHERE userid=$CURUSER[id] AND friendid=$id") or sqlerr(__FILE__, __LINE__);  
	$friend = mysqli_num_rows($r);  
	$r = mysqli_query($con_link, "SELECT id FROM blocks WHERE userid=$CURUSER[id] AND blockid=$id") or sqlerr(__FILE__, __LINE__);  
	$block = mysqli_num_rows($r);  
  
	print "<table class=bottom width=50% border=0><tr>";  
	if ($friend)  
		{  
			print "<td class=embedded><div align=center>";  
			print "<form method=get action=friends.php>";  
			print "<input type=hidden name=action value=delete>";  
			print "<input type=hidden name=sure value=1>";  
			print "<input type=hidden name=type value=friend>";  
			print "<input type=hidden name=targetid value=" . $user['id'] . ">";  
			print "<input type=submit style='height: 30px;width: 200px' value='Verwijderen van vrienden'>";  
			print "</form></td>";  
		}  
	elseif($block)  
		{  
			print "<td class=embedded><div align=center>";			  
			print "<form method=get action=friends.php>";  
			print "<input type=hidden name=action value=delete>";  
			print "<input type=hidden name=type value=block>";  
			print "<input type=hidden name=sure value=1>";  
			print "<input type=hidden name=targetid value=" . $user['id'] . ">";  
			print "<input type=submit style='height: 30px;width: 200px' value='Blokkering opheffen'>";  
			print "</form></td>";  
		}  
	else  
		{  
		print "<td class=embedded><div align=center>";  
		print "<form method=get action=friends.php>";  
		print "<input type=hidden name=action value=add>";  
		print "<input type=hidden name=type value=friend>";  
		print "<input type=hidden name=targetid value=" . $user['id'] . ">";  
		print "<input type=submit style='height: 30px;width: 200px' value='Toevoegen aan vrienden'>";  
		print "</form></td>";  
		print "<td class=embedded><div align=center>";			  
		print "<form method=get action=friends.php>";  
		print "<input type=hidden name=action value=add>";  
		print "<input type=hidden name=type value=block>";  
		print "<input type=hidden name=targetid value=" . $user['id'] . ">";  
		print "<input type=submit style='height: 30px;width: 200px' value='Blokkeren'>";  
		print "</form></td>";  
		}  
	print "</tr></table>";  
	}  
print "<br>";  
print("<table align=center class=bottom border=0 width=95% cellspacing=0 cellpadding=0><tr><td class=embedded><div align=center>");  
  
if (get_user_class() >= UC_OWNER)  
	{  
	$user_ip = sqlesc($user['ip']);  
	$ip_nummers = get_row_count("user_ip", "WHERE userid=$user[id]");  
	$ip_users = get_row_count("user_ip", "WHERE ip=$user_ip");  
	}  
  
$nip = $user['ip'];  
$nip = ip2long($nip);  
  
$tekst = "Gebruikersgegevens van " . get_username($user['id']) . " <font size=2>[ " . get_user_class_name($user['class']) . " ] " . @$donortext;  
  
tabel_top($tekst);  
tabel_start();  
print("<table width=100% border=0 cellspacing=0 cellpadding=0>");  
print("<tr>");  
print("<td class=embedded align=center><center><br>");  
if ($user["avatar"])  
	$avatar = "<img width=150 src=\"" . $user["avatar"] . "\">";  
else  
	$avatar = "<img height=80 width=80 src=pic/default_avatar.gif>";  
///////////////////////////////////////////////////////////////////////  
if ($user["bedanktplaat"])  
	$bd = "<img width=120 src=\"" . $user["bedanktplaat"] . "\">";  
else  
	$bd = "<img width=120 src=pic/default_bedankje.gif>";  
////////////////////////////////////////////////////////////////////////  
print("<table width=98% class=bottom cellspacing=0 cellpadding=5>");  
print ("<tr>");  
//print ("<td class=embedded align=center width=80 style='padding: 0px'>$avatar</td><td class=embedded>&nbsp;&nbsp;</td><td class=embedded align=top>");  
print ("<td class=embedded align=center width=80 style='padding: 0px'>$avatar<br>$bd</td><td class=embedded>&nbsp;&nbsp;</td><td class=embedded align=top>");  
print "<div align=right>";  
if (get_user_class() >= UC_MODERATOR)  
	{  
	print "<table width=1% class=bottom cellspacing=0 cellpadding=5><tr>";  
	if (get_user_class() >= UC_ADMINISTRATOR)  
		{  
		print "<td class=embedded width=200><div align=right>";  
		if (@$ip_nummers > 1)  
			{  
			print "<font color=white><b><a class=altlink_lblue href='user_ip_overzicht.php?id=".$user['id']."'>Gebruiker&nbsp;is&nbsp;aangemeld&nbsp;geweest&nbsp;op&nbsp;" . $ip_nummers . "&nbsp;verschillende&nbsp;ipnummers.</a>";  
			print "<br>";  
			if ($ip_users > 1)  
				print "<font color=white><b><a class=altlink_lblue href='user_ip_overzicht.php?ip=".$user['ip']."&return_id=".$user['id']."'>Er&nbsp;zijn&nbsp;" . $ip_users . "&nbsp;gebruikers&nbsp;die&nbsp;dit&nbsp;ip-nummer&nbsp;gebruiken.</a>";  
			else  
				print "<font color=white><b><a class=altlink_lblue href='user_ip_overzicht.php?ip=".$user['ip']."&return_id=".$user['id']."'>Er&nbsp;is&nbsp;" . $ip_users . "&nbsp;gebruiker&nbsp;die&nbsp;dit&nbsp;ip-nummer&nbsp;gebruikt.</a>";  
			}  
		else  
			{  
			print "<font color=white><b><a class=altlink_lblue href='user_ip_overzicht.php?id=".$user['id']."'>Gebruiker&nbsp;is&nbsp;aangemeld&nbsp;geweest&nbsp;op&nbsp;" . @$ip_nummers . "&nbsp;ipnummer.</a>";  
			print "<br>";  
			if (@$ip_users > 1)  
				print "<font color=white><b><a class=altlink_lblue href='user_ip_overzicht.php?ip=".$user['ip']."&return_id=".$user['id']."'>Er&nbsp;zijn&nbsp;" . @$ip_users . "&nbsp;gebruikers&nbsp;die&nbsp;dit&nbsp;ip-nummer&nbsp;gebruiken.</a>";  
			else  
				print "<font color=white><b><a class=altlink_lblue href='user_ip_overzicht.php?ip=".$user['ip']."&return_id=".$user['id']."'>Er&nbsp;is&nbsp;" . @$ip_users . "&nbsp;gebruiker&nbsp;die&nbsp;dit&nbsp;ip-nummer&nbsp;gebruikt.</a>";  
			}  
		print "</td>";  
		}  
	if (get_user_class() >= UC_ADMINISTRATOR){  
	print "<td class=embedded><div align=right>";  
	print "<form method=get action=users_modtask.php>";  
	print "<input type=hidden name=action value=view>";  
	print "<input type=hidden name=user_id value=" . $user['id'] . ">";  
	print "<input type=submit style='height: 26px;width: 200px' value='Moderator opties voor deze gebruiker'>";  
	print "</form>";  
	print "</td></tr></table><br>";  
	}else{  
		  
	}  
	}  
print("<table align=left width=100% border=1 cellspacing=0 cellpadding=5>");  
print ("<tr>");  
print ("<td class=colheadsite align=left>Aanmelddatum</td>");  
print ("<td class=colheadsite align=left>Laatst gezien</td>");  
print ("<td align=left class=colheadsite>Ontvangen</td>");  
print ("<td align=left class=colheadsite>Verzonden</td>");  
print ("<td align=left class=colheadsite>Ratio</td>");  
print  "<td align=left class=colheadsite>Krediet</td>";  
print  "<td align=left class=colheadsite>BP</td>";  
print("</tr>");  
print ("<tr>");  
//print ("<td bgcolor=white>$joindate</td>");  
print ("<td bgcolor=white align=left>Gaat je niks aan</td>");  
//print ("<td bgcolor=white>$lastseen</td>");  
print ("<td bgcolor=white align=left>Ben er nu toch lol</td>");  
print ("<td bgcolor=white align=left>" . mksize($user["downloaded"]) . "</td>");  
print ("<td bgcolor=white align=left>" . mksize($user["uploaded"]) . "</td>");  
print ("<td bgcolor=white align=left>" . get_userratio($user["id"]) . "</td>");  
print "<td bgcolor=white align=left>" . $user["credits"] . "</td>";  
print "<td bgcolor=white align=left>" . $user["bonus_punten"] . "</td>";  
print("</tr>");  
print("</table><br>");  
if (get_user_class() >= UC_ADMINISTRATOR)  
	{  
	print("<table align=left width=100% border=1 cellspacing=0 cellpadding=5>");  
	print ("<tr>");  
    print ("<td class=colheadsite align=left>Ip adres</td>");	  
	print ("<td class=colheadsite align=left>E-mail</td>");			print ("<td class=colheadsite align=left>Skype</td>");  
	print ("<td class=colheadsite align=left>Flush Ghost</td>");  
	print ("<td class=colheadsite align=left>Reacties</td>");  
	print ("<td class=colheadsite align=left>Max Torrents</td>");  
	print "<td class=colheadsite align=left>Kliks</td>";  
	print("</tr>");  
	print ("<tr>");  
	  
if (get_user_class() >= UC_OWNER)  
		{  
		print ("<td bgcolor=white align=left>".$user['ip']."</td>");  
		}  
	else  
		{  
	if ($user['class'] < 4)  
		print ("<td bgcolor=white align=left>$addr</td>");  
	else  
		print ("<td bgcolor=white align=left>Onbekend</td>");  
		}		  
		print ("<td bgcolor=white align=left><a href=mailto:$user[email]>$user[email]</a></td>");	  
			$skype= ($user['skype_name'] == null ? "<br><br>" : "<a href=skype:". $user['skype_name'] . "?chat><img src=/pic/button_chat.gif></img></a>");  
		print ("<td bgcolor=white align=left>" . $skype . "</td>");  
  
		print ("<td bgcolor=white align=left><a href=takeflush.php?id=$user[id]>Verwijder Ghost Torrent</a></td>");  
  
if ($torrentcomments)  
		print ("<td bgcolor=white align=left><a href=userhistory.php?action=viewcomments&id=$id>$torrentcomments</a></td>");  
	else  
		print ("<td bgcolor=white align=left>$torrentcomments</td>");  
	print ("<td bgcolor=white align=left>" . $user['maxtorrents'] . "</td>");  
	print "<td bgcolor=white align=left>" . $user['kliks'] . "</td>";  
  
	print("</tr>");  
	print("</table><br>");  
  
	print("</tr>");  
	print("</table><br>");  
	}  
  
if (@$showpmbutton)  
	print("<center><form method=get action=sendmessage.php><input type=hidden name=receiver value=" .  
		$user["id"] . "><input type=submit value=\"Bericht sturen\" style='height: 25px; width: 110px'></form></center>");  
  
print("</td></tr></table><br>");  
  
print("</td></tr></table><br>");  
  
$donaties = get_row_count("donations_users", "WHERE user_id=$user[id]");  
  
if (get_user_class() >= UC_OWNER)  
	{if (get_user_class() >= UC_OWNER)	{	$ip = $user['ip'];	$def = mysqli_query($con_link, "SELECT id, username FROM users WHERE ip='$ip' AND ip!='000.000.000.000'") or sqlerr(__FILE__, __LINE__);		while ($defs = mysqli_fetch_assoc($def))		{		if ($user['username'] <> $defs['username'])			@$dubbelip .= ", <a class=altlink_white href=userdetails.php?id=" . $defs['id'] . ">" . $defs['username'] . "</a>";		}		if (@$dubbelip) print ("<center></br></br></br><font size=5 color=white><b>Hetzelfde IP-nummer gevonden bij " . $dubbelip) . "</b></font></center><br>";	}	  
	if ($donaties > 0)  
		{  
		tabel_top("Donatie overzicht gebruiker - $donaties keer.","center");  
		print "<table width=100% border=0 cellspacing=0 cellpadding=0>\n";  
		print "<tr>\n";  
		print "<td class=embedded align=center><center><br>\n";  
	  
		print "<table class=outer border=1 cellspacing=0 cellpadding=5>\n";  
		print "<tr>\n";  
		print "<td class=colheadsite width=120>\n";  
		print "<b>Datum\n";  
		print "</td>\n";  
		print "<td class=colheadsite width=120 align=center>\n";  
		print "<b>Krediet punten\n";  
		print "</td>\n";  
		print "<td class=colheadsite width=120 align=center>\n";  
		print "<b>Pincode\n";  
		print "</td>\n";  
		print "</tr>\n";  
	  
		$res = mysqli_query($con_link, "SELECT * FROM donations_users WHERE user_id=$user[id] ORDER by added") or sqlerr(__FILE__, __LINE__);  
		while ($row = mysqli_fetch_assoc($res))  
			{  
			print "<tr>\n";  
			print "<td bgcolor=white>";  
			print convertdatum($row['added']);  
			print "</td>";  
			print "<td bgcolor=white align=center>";  
			print $row['krediet'];  
			print "</td>";  
			print "<td bgcolor=white align=center>";  
			print $row['pincode'];  
			print "</td>";  
			print "</tr>\n";  
			}  
		print "</table><br>\n";  
		  
		print "</td></tr></table><br>\n";  
		}  
	}  
  
$warnings = get_row_count("warnings", "WHERE userid=$user[id]");  
  
if (get_user_class() >= UC_ADMINISTRATOR)  
	{  
	if ($warnings > 0)  
		{  
		tabel_top("Waarschuwingen overzicht gebruiker - $warnings","center");  
		print "<table width=100% border=0 cellspacing=0 cellpadding=0>\n";  
		print "<tr>\n";  
		print "<td class=embedded align=center><center><br>\n";  
	  
		print "<table class=outer width=98% border=1 cellspacing=0 cellpadding=5>\n";  
		print "<tr>\n";  
		print "<td class=colheadsite>\n";  
		print "<b>Datum\n";  
		print "</td>\n";  
		print "<td class=colheadsite>\n";  
		print "<b>Reden\n";  
		print "</td>\n";  
		print "<td class=colheadsite>\n";  
		print "<b>Lengte\n";  
		print "</td>\n";  
		print "<td class=colheadsite>\n";  
		print "<b>Ontvangen\n";  
		print "</td>\n";  
		print "<td class=colheadsite>\n";  
		print "<b>Verzonden\n";  
		print "</td>\n";  
		print "<td class=colheadsite>\n";  
		print "<b>Door\n";  
		print "</td>\n";  
		print "</tr>\n";  
	  
		$res = mysqli_query($con_link, "SELECT * FROM warnings WHERE userid=$user[id] ORDER by date") or sqlerr(__FILE__, __LINE__);  
		while ($row = mysqli_fetch_assoc($res))  
			{  
			print "<tr>\n";  
			print "<td bgcolor=white>";  
			print convertdatum($row['date']);  
			print "</td>";  
			print "<td bgcolor=white>";  
			print $row['warned_for'];  
			print "</td>";  
			print "<td bgcolor=white>";  
			print $row['warned_time'];  
			print "</td>";  
			print "<td bgcolor=white>";  
			print mksize($row['downloaded']);  
			print "</td>";  
			print "<td bgcolor=white>";  
			print mksize($row['uploaded']);  
			print "</td>";  
			print "<td bgcolor=white>";  
			print get_username($row['warned_by']);  
			print "</td>";  
	  
			print "</tr>\n";  
			}  
		print "</table><br>\n";  
		  
		print "</td></tr></table><br>\n";  
		}  
	}  
  
/// Nieuwe look einde  
  
?>  
<table width=100% border=1 cellspacing=0 cellpadding=5>  
<?php  
if ($user["downloaded"] > 0)  
{  
  $sr = $user["uploaded"] / $user["downloaded"];  
  if ($sr >= 4)  
    $s = "w00t";  
  else if ($sr >= 2)  
    $s = "grin";  
  else if ($sr >= 1)  
    $s = "smile1";  
  else if ($sr >= 0.5)  
    $s = "noexpression";  
  else if ($sr >= 0.25)  
    $s = "sad";  
  else  
    $s = "cry";  
  $sr = "<table border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><font color=" . get_ratio_color($sr) . ">" . number_format($sr, 2) . "</font></td><td class=embedded>&nbsp;&nbsp;<img src=/pic/smilies/$s.gif></td></tr></table>";  
}  
  
	if (get_user_class() >= UC_OWNER || $CURUSER['id'] == $user['id'])  
	{  
		  
	$loten = get_row_count("loterij","WHERE user_id=$user[id]");   
	if ($loten > 0)  
		{  
		if ($loten == 1)  
			tabel_top($loten. " onzesite Loterij lot.");  
		else  
			tabel_top($loten. " onzesite Loterij loten.");  
			  
		print "<table width=100% border=0 cellspacing=0 cellpadding=0>";  
		print "<tr><td class=embedded align=center><center>";  
		print "<br><table width=50% class=outer border=1 cellspacing=0 cellpadding=5>";  
		  
		if (get_user_class() >= UC_OWNER)  
			{  
			print "<form method=post action=take_extra_loterij_lot.php>";  
			print "<input type=hidden name=id value=".$row['id'].">";  
			print "<input type=hidden name=user_id value=".$user_id.">";  
			print "<input type=hidden name=action value='verwerk'>";  
			print "<input type=submit class=btn style='height: 22px; width: 150px' value='Extra loterij lot geven'>";  
			print "</form>";  
			}  
		  
		print "<tr>";  
		print "<td class=colheadsite width=150>Lot&nbsp;nummer</td>";  
		print "<td class=colheadsite>Datum&nbsp;aangemaakt</td>";  
		print "</tr>";  
		$def = mysqli_query($con_link, "SELECT * FROM loterij WHERE user_id=$user[id]") or sqlerr(__FILE__, __LINE__);	  
		while ($defs = mysqli_fetch_assoc($def))  
			{  
			print "<tr>";  
			print "<td width=150>".htmlspecialchars($defs['lot'])."</td>";  
			print "<td>".convertdatum($defs['added'])."</td>";  
			print "</tr>";  
			}  
		print "</table><br>";  
		print "</td></tr></table><br>";  
		}  
  
	if (get_user_class() >= UC_OWNER)  
		{  
		$res = mysqli_query($con_link, "SELECT * FROM users_credits WHERE user_id=$user_id ORDER BY added DESC") or sqlerr(__FILE__, __LINE__);  
		if (mysqli_num_rows($res) > 0)  
			{  
			tabel_top("Overzicht gebruikte krediet punten","center");  
			tabel_start();  
			print "<table width=95% border=1 cellspacing=0 cellpadding=5>\n";  
			print "<tr><td class=colheadsite align=left>Datum</td><td class=colheadsite align=left>Tijd</td><td class=colheadsite align=left>Gebeurtenis</td></tr>\n";  
			while ($arr = mysqli_fetch_assoc($res))  
				{  
				$date = convertdatum($arr['added'],"no");  
				$time = substr($arr['added'], strpos($arr['added'], " ") + 1);  
				print "<tr><td bgcolor=white class=td_site>$date</td><td bgcolor=white class=td_site>$time</td><td bgcolor=white align=left class=td_site>$arr[descr]</td></tr>\n";  
				}  
			print "</table>";  
			tabel_einde();  
			print "<br>";  
			}  
		}  
	}  
	  
if (@$torrents)  
	{  
	tabel_top("U heeft ".@$aantal." torrent geplaatst op ".@$SITE_NAME."","center");  
	tabel_start();  
	print ($torrents);  
	tabel_einde();  
	print "<br>";  
	}  
	  
if (@$seeding)  
	{  
	tabel_top("Nu aan het delen");  
	tabel_start();  
	print ($seeding);  
	tabel_einde();  
	print "<br>";  
	}  
	  
if (@$leeching)  
	{  
	tabel_top("Nu aan het ontvangen");  
	tabel_start();  
	print ($leeching);  
	tabel_einde();  
	print "<br>";  
	}  
if (@$downloaded)  
	{  
	tabel_top("Ontvangen torrents");  
	tabel_start();  
	print ($downloaded);  
	tabel_einde();  
	print "<br>";  
	}  
  
if (get_user_class() >= UC_ADMINISTRATOR && $user["class"] < get_user_class())  
	{  
	tabel_top("Gebruikers gegevens aanpassen (alleen voor moderator en hoger)");  
	tabel_start();  
	print("<form method=post action=modtask.php>");  
	print("<input type=hidden name='action' value='edituser'>");  
	print("<input type=hidden name='userid' value='$id'>");  
	print("<input type=hidden name='returnto' value='userdetails.php?id=$id'>");  
	print("<table width=100% class=outer border=1 cellspacing=0 cellpadding=5>");  
  
  
 if ($CURUSER["class"] >= UC_ADMINISTRATOR){  
        print("");  
}     
	// we do not want mods to be able to change user classes or amount donated...  
	print("<input type=hidden name=donor value=$user[donor]>");  
  
	$modcomment = htmlspecialchars($user["modcomment"]);  
	$modcomment = stripslashes($modcomment);  
  
	$d = str_replace("\n&cedil;", "\n<br>", $modcomment);  
  
	print("<tr><td bgcolor=white colspan=4 align=center><font size=2><b>Moderator commentaar:<br><textarea cols=180 rows=20 name=modcomment>$modcomment</textarea></td></tr>");  
	$warned = $user["warned"] == "yes";  
	print ("<tr><td bgcolor=white class=rowhead>Gewaarschuwd</td>");  
	if ($warned)  
		print ("<td bgcolor=white align=left><input name=warned value='yes' type=radio" . ($warned ? " checked" : "") . ">Ja <input name=warned value='no' type=radio" . (!$warned ? " checked" : "") . ">Nee</td>");  
	else  
		print ("<td bgcolor=white align=left><b>Niet&nbsp;gewaarschuwd</b></td>");  
	if ($warned)  
		{  
		$warneduntil = $user['warneduntil'];  
		if ($warneduntil == '0000-00-00 00:00:00')  
			print("<td bgcolor=white align=center>(arbitrary duration)</td></tr>");  
		else  
			{  
			print("<td bgcolor=white align=center>Gewaarschuwd tot " . convertdatum($warneduntil));  
			//	    print(" (" . mkprettytime(strtotime($warneduntil) - time()) . " te gaan)</td></tr>");  
			}  
		}  
	else  
		{  
		print("<td bgcolor=white>Waarschuw voor <select name=warnlength>");  
		print("<option value=0>------</option>");  
		print("<option value=48>2 dagen (eerste waarschuwing)</option>");  
		print("<option value=96>4 dagen (tweede waarschuwing)</option>");  
		print("<option value=336>2 weken (derde waarschuwing)</option>");  
//		print("<option value=672>4 weken (hopeloze gebruikers)</option>");  
//		print("<option value=1680>10 weken (alleen uitzonderlijke gebruikers)</option>");  
		print("</select></td>");  
		print("<td bgcolor=white>Waarschuwen voor <select name=warnreason>");  
		print("<option value=1>Ratio te laag</option>");  
		print("<option value=0>Pakken en wegwezen</option>");  
		print("<option value=2>Overseeden</option>");  
		print("<option value=3>Gb verschil</option>");  
		print("<option value=4>Gedrag</option>");  
		print("</select></td></tr>");  
		}  
	print("</td></tr>");  
	print("<tr><td bgcolor=white colspan=4 align=center><input type=submit class=btn value='Pas Aan'></td></tr>");  
	print("</table>");  
	print("</form>");  
	tabel_einde();  
	print "<br>";  
	}  
  
print("</td></tr></table>");  
print("<br>");  
print "</td></tr></table><br>";  
tabel_einde();  
site_footer();  
?>