<?php
require_once("site_functions.php");
require_once("secrets.php");


$SITE_ONLINE = true;
$SITE_ONLINE_MSG = "Wij zijn bezig met een kortstondig onderhoud aan de server, duurt enkele minuten.";

$DONOR_ADMIN = 0;

//$ONDERHOUD = "Er wordt momenteel onderhoud gepleegd aan de server en de site, ons excuus voor eventueel ongemak.";

$krediet_groot = 4;
//error_reporting(0);
$donatie_klein = 1.5*1024*1024*1024;
$donatie_groot = 7.5*1024*1024*1024;
$donatie_maanden = 35*1024*1024*1024;
$ratio_klein = 3*1024*1024*1024;
$ratio_groot = 15*1024*1024*1024;

$max_torrent_size = 2000000;
$max_cover_size = 10*1024*1024;
$announce_interval = 2800;

$signup_timeout = 86400 * 14;
$minvotes = 1;
$max_dead_torrent_time = 24 * 3600;

$maxusers = 14000;
$invites = 15000;

// To make a new hash go to http://www.sha1-online.com/ and create a secure key SHA1

$PASSWORD_HASH ="bb43ef1b3ec5e2bfca21091b40fc987fc74ebc04";

$torrent_dir = "torrents";
$cover_dir = "covers";
$screens_dir = "screens";
$avatar_dir = "avatar";
$bedankt_dir = "bedanktjes";

$announce_urls = array();
$announce_urls[] = "https://torrentmedia.org/announce.php";
$announce_site = "https://torrentmedia.org/announce.php";

if ($_SERVER["HTTP_HOST"] == "")
	$_SERVER["HTTP_HOST"] = $_SERVER["SERVER_NAME"];

$BASEURL = "https://" . $_SERVER["HTTP_HOST"];


$DEFAULTBASEURL = "https://torrentmedia.org";
$PEERLIMIT = 50000;
$SITEEMAIL = "no-reply@torrentmedia.org";
$TORRENTEMAIL = "no-reply@torrentmedia.org";
$EMAIL_NOREPLY = "no-reply@torrentmedia.org";
$RECOVEREMAIL = "no-reply@torrentmedia.org";
$SITE_NAME = "Torrent Media";
$pic_base_url = "/pic/";


require_once("cleanup.php");


function local_user()
	{
	global $_SERVER;
	return $_SERVER["SERVER_ADDR"] == $_SERVER["REMOTE_ADDR"];
	}

function get_username($id)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$res = mysqli_query($con_link, "SELECT username FROM users WHERE id = $id");
	$row = mysqli_fetch_array($res);
	if ($row)
		return $row['username'];
	}

function get_email($id)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$res = mysqli_query($con_link,"SELECT email FROM users WHERE id = $id");
	$row = mysqli_fetch_array($res);
	if ($row)
		return $row['email'];
	}

function get_passkey($id)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$res = mysqli_query($con_link,"SELECT passkey FROM users WHERE id = $id");
	$row = mysqli_fetch_array($res);
	if ($row)
		return $row['passkey'];
	}

function get_usernamesite($id)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$res = mysqli_query($con_link," SELECT username, warned, donor, blocked FROM users WHERE id = $id")	or sqlerr();
	$row = mysqli_fetch_array($res);
	$usernamesite = $row['username'];
	if ($row['warned'] == "yes")
		$usernamesite .= "&nbsp;<img src=pic/warnedbig.gif border=0>";
	if ($row['blocked'] == "yes")
		$usernamesite .= "&nbsp;<img src=pic/blocked.gif border=0>";
	if ($row['donor'] == "yes")
		$usernamesite .= "&nbsp;<img border=0 width=22 height=22 src=pic/system/star.gif alt='Donateur' style='margin-left: 4pt'>";
	if ($row)
		return $usernamesite;
	}

function get_usernamesitesmal($id)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$res = mysqli_query($con_link,"SELECT username, warned, class, donor, blocked FROM users WHERE id = $id")	or sqlerr();
	$row = mysqli_fetch_array($res);
	$usernamesite = $row['username'];
	if ($row['warned'] == "yes")
		$usernamesite .= "<img src=pic/warned.gif border=0 style='margin-left: 2pt'>";
	if ($row['blocked'] == "yes")
		$usernamesite .= "&nbsp;<img width=13 height=13 src=pic/blocked.gif border=0>";
	if ($row['donor'] == "yes")
		$usernamesite .= "<img align=bottom border=0 width=14 height=14 src=pic/system/star.gif alt='Donateur' style='margin-left: 2pt'>";
	if ($row)
		return $usernamesite;
	}

function get_categorie($id)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$res = mysqli_query($con_link,"SELECT image FROM categories WHERE id = $id") or sqlerr();
	$row = mysqli_fetch_array($res);
	if (!$row['image']) 
		return "";
	else
		return $row['image'];
	}

function get_categorie_naam($id)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$res = mysqli_query($con_link,"SELECT name FROM categories WHERE id = $id") or sqlerr();
	$row = mysqli_fetch_array($res);
	if (!$row['name']) 
		return "";
	else
		return $row['name'];
	}

function noaccess($class, $page, $id, $naam) {
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	if(get_user_class() < $class){
		$date = sqlesc(get_date_time());
		$takereason="Illegale toegang op pagina $page";
		mysqli_query($con_link, "INSERT INTO reports (votedfor,naam,addedby,reason,added) VALUES ('$id','$naam','0','$takereason',$date)") or sqlerr();
		//mysqli_query("UPDATE users SET warned = 'yes', warneduntil = '0000-00-00 00:00:00' WHERE id=$CURUSER[id]") or sqlerr(__FILE__, __LINE__);
		header("Refresh: 0; url=index.php");
		die();
	}
}

function get_userratio($id)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$res = mysqli_query($con_link,"SELECT downloaded, uploaded FROM users WHERE id = $id");
	$row = mysqli_fetch_array($res);
	$ratiotmp =  number_format((($row["downloaded"] > 0) ? ($row["uploaded"] / $row["downloaded"]) : 0),2);
	if ($ratiotmp < 1)
		@$ratio .= "<font color=red>(" . $ratiotmp . ")</font>";
	else
		@$ratio .= "<font color=green>(" . $ratiotmp . ")</font>";
	if ($row)
		return $ratio;
	}

function get_ratio($id)
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$res = mysqli_query($con_link,"SELECT downloaded, uploaded FROM users WHERE id = $id");
	$row = mysqli_fetch_array($res);
	$ratio =  number_format((($row["downloaded"] > 0) ? ($row["uploaded"] / $row["downloaded"]) : 0),2);
	if ($row)
		return $ratio;
	}

function validip($ip)
	{
	if (!empty($ip) && ip2long($ip)!=-1)
		{
		$reserved_ips = array
			(
			array('0.0.0.0','2.255.255.255'),
			array('10.0.0.0','10.255.255.255'),
			array('127.0.0.0','127.255.255.255'),
			array('169.254.0.0','169.254.255.255'),
			array('172.16.0.0','172.31.255.255'),
			array('192.0.2.0','192.0.2.255'),
			array('192.168.0.0','192.168.255.255'),
			array('255.255.255.0','255.255.255.255')
			);
		foreach ($reserved_ips as $r)
			{
				$min = ip2long($r[0]);
				$max = ip2long($r[1]);
				if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;
			}
			return true;
		}
		else return false;
	}

function getip()
	{
	global $_SERVER;

	if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
	else
		{
		$ip = $_SERVER['REMOTE_ADDR'];
		}
	return $ip;
	}

function dbconn($autoclean = false)
	{
    global $SITE_ONLINE, $SITE_ONLINE_MSG, $mysql_host, $mysql_user, $mysql_pass, $mysql_db, $_SERVER, $krediet_groot, $aktie_vandaag, $aktie_text;
	if (!$SITE_ONLINE)
		die($SITE_ONLINE_MSG);
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	if (!@mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db))
	    {
		switch (mysqli_errno($con_link))
			{
			case 1040:
			case 2002:
				if ($_SERVER['REQUEST_METHOD'] == "GET")
					die("<html><head><meta http-equiv=refresh content=\"10 $_SERVER[REQUEST_URI]\"></head><body><table border=0 width=100% height=100%><tr><td bgcolor=blue><h3 align=center><font color=white>De serverload is heel hoog op dit moment.<br><br>Pagina wordt automatisch herladen, even geduld alstublieft.</h3></td></tr></table></body></html>");
				else
					die("Te veel gebruikers. Gebruik vernieuwen om opnieuw te proberen");
				default:
					die("[" . mysqli_errno($con_link) . "] dbconn: mysqli_connect: " . mysqli_error());
			}
		}
	mysqli_select_db($con_link, $mysql_db) or die('dbconn: mysqli_select_db: ' + mysqli_error());
    userlogin();

	$aktie_datum = sqlesc(substr(get_date_time(),0,10));
	$res = mysqli_query($con_link, "SELECT * FROM aktie WHERE datum=$aktie_datum");
	$row = mysqli_fetch_array($res);
	
	if ($row)
		{
		$krediet_groot = round($row['krediet']);
		$aktie_vandaag = true;
		$aktie_text =  "<table class=bottom width=100% height=45 border=0 cellspacing=0 cellpadding=0><tr><td class=embedded'><div align=center>\n";
		$aktie_text .= "<font color=white><center><b>";
		$aktie_text .= $row['aktie'];
		$aktie_text .= "</td></tr></table><center>";
		}

// ----- Ensures htmlspecialchars() doesn't damage output if used twice
function safe($var)
{
    return htmlspecialchars(str_replace(array("&gt;", "&lt;", "&quot;", "&amp;"), array(">", "<", "\"", "&"), $var));
}


    if ($autoclean)
		opschonen_database();
		opschonen_donateurs(); 
		opschonen_waarschuwingen();
		opschonen_topgebruiker(); 
		opschonen_bronnen();
		}

function userlogin()
	{
    global $_SERVER, $SITE_ONLINE, $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
    unset($GLOBALS["CURUSER"]);
    $ip = getip();
	$nip = ip2long($ip);
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
    $res = mysqli_query($con_link, "SELECT * FROM bans WHERE $nip >= first AND $nip <= last");
//    $res = mysqli_query("SELECT * FROM bans WHERE $nip >= first AND $nip <= last") or sqlerr(__FILE__, __LINE__);
   // var_dump($res);
    if (mysqli_num_rows($res) > 0)
	    {
		header("Location: @$BASEURL/foutmelding/geen_toegang.php");
		die;
		}

    if (!$SITE_ONLINE || empty($_COOKIE["uid"]) || empty($_COOKIE["pass"]))
        return;
    $id = 0 + $_COOKIE["uid"];
    if (!$id || strlen($_COOKIE["pass"]) != 32)
        return;
    $res = mysqli_query($con_link, "SELECT * FROM users WHERE id = $id AND enabled='yes' AND status = 'confirmed'");// or die(mysqli_error());
    $row = mysqli_fetch_array($res);
    if (!$row)
        return;
    $sec = hash_pad($row["secret"]);
    if ($_COOKIE["pass"] !== $row["passhash"])
        return;
	//if ($row['class'] > 3) // Moderator en hoger geen ip-nummer zichtbaar
    // 	mysqli_query($con_link, "UPDATE users SET last_access='" . get_date_time() . "', ip='000.000.000.000' WHERE id=" . $row["id"]);// or die(mysqli_error());
	//else
	if($row['class'] > 3)
	mysqli_query($con_link, "UPDATE users SET kliks = kliks + 1, last_access='" . get_date_time() . "', ip='0.0.0.0' WHERE id=" . $row["id"]);
	if ($row['class'] < 2)
	mysqli_query($con_link, "UPDATE users SET kliks = kliks + 1, last_access='" . get_date_time() . "', ip='$ip' WHERE id=" . $row["id"]);// or die(mysqli_error());
    $row['ip'] = $ip;
	    if ($row['override_class'] < $row['class']) $row['class'] = $row['override_class']; // Override class and save in GLOBAL array below.
    $GLOBALS["CURUSER"] = $row;
	get_site_vars();
	
	/// IP logboek \\
	mysqli_query($con_link, "INSERT INTO ip_logboek (tekst2, tekst3, added, user) VALUES('".@$_SERVER['REMOTE_ADDR']."', '".@$_SERVER['HTTP_REFERER']."', NOW(), ".$row['id'].")") or sqlerr(__FILE__, __LINE__);
	/// IP logboek \\
	
	if (get_user_class() >= UC_MODERATOR)
		{
		$res_hits = mysqli_query($con_link, "SELECT * FROM hits WHERE user_id=".$row['id']." AND page=".sqlesc(str_replace("/","",$_SERVER['PHP_SELF'])));
		$row_hits = mysqli_fetch_array($res_hits);
		if ($row_hits)		
			mysqli_query($con_link, "UPDATE hits set kliks=kliks+1 WHERE id=".$row_hits['id']);
		else
			mysqli_query($con_link, "INSERT INTO hits (user_id, page, kliks) VALUES(".$row['id'].", ".sqlesc(str_replace("/","",$_SERVER['PHP_SELF'])).",1)");
		}
}



// ----- For nzb and imdb stuff - 24hr cleanup:
function tfhrclean() {
    $tfhrclean_interval = 86400;
    
    $now = time();

    global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$res = mysqli_query($con_link,"SELECT value_u FROM avps WHERE arg = 'lasttfhrclean'");
    $row = mysqli_fetch_array($res);
    if (!$row) {
        mysqli_query($con_link, "INSERT INTO avps (arg, value_u) VALUES ('lasttfhrclean',$now)");
        return;
    }
    $ts = $row[0];
    if ($ts + $tfhrclean_interval > $now)
        return;
    mysqli_query($con_link, "UPDATE avps SET value_u=$now WHERE arg='lasttfhrclean' AND value_u = $ts");
    if (!mysqli_affected_rows($con_link))
        return;

    dotfhrclean();
}

// ----- Shows age in days in x.x format from a given timestamp (eg 5.0 days old)
function show_age($timestamp) {
    $day = 60*60*24;
    $time_now = gmtime();
    $diff = $time_now - $timestamp;
    $age = $diff/$day;
    $age = sprintf("%.1f", $age);
    return $age;
}

function unesc($x) {
    if (get_magic_quotes_gpc())
        return stripslashes($x);
    return $x;
}

function strip_magic_quotes($arr){
	foreach ($arr as $k => $v){
		if (is_array($v)){ 
			$arr[$k] = strip_magic_quotes($v); 
		}else{ 
			$arr[$k] = stripslashes($v); 
		}
	}
	return $arr;
}

if (get_magic_quotes_gpc()){
	if (!empty($_GET)){ 
		$_GET    = strip_magic_quotes($_GET);    
	}
	if (!empty($_POST)){ 
		$_POST   = strip_magic_quotes($_POST);   
	}
	if (!empty($_COOKIE)){ 
		$_COOKIE = strip_magic_quotes($_COOKIE); 
	}
}

function mksize($bytes)
{
	if ($bytes < 1000 * 1024)
		return number_format($bytes / 1024, 2) . " kB";
	elseif ($bytes < 1000 * 1048576)
		return number_format($bytes / 1048576, 2) . " MB";
	elseif ($bytes < 1000 * 1073741824)
		return number_format($bytes / 1073741824, 2) . " GB";
	else
		return number_format($bytes / 1099511627776, 2) . " TB";
}

function mksizekb($bytes)
{
  return number_format($bytes / 1024) . " KB";
}

function mksizemb($bytes)
{
  return number_format($bytes / 1048576,2) . " MB";
}

function mksizegb($bytes)
{
  return number_format($bytes / 1073741824,2) . " GB";
}

function deadtime() {
    global $announce_interval;
    return time() - floor($announce_interval * 1.3);
}

function mkprettytime($s) {
    if ($s < 0)
        $s = 0;
    $t = array();
    foreach (array("60:sec","60:min","24:uur","0:dag") as $x) {
        $y = explode(":", $x);
        if ($y[0] > 1) {
            $v = $s % $y[0];
            $s = floor($s / $y[0]);
        }
        else
            $v = $s;
        $t[$y[1]] = $v;
    }

    if ($t["day"])
        return $t["day"] . "d " . sprintf("%02d:%02d:%02d", $t["hour"], $t["min"], $t["sec"]);
    if ($t["hour"])
        return sprintf("%d:%02d:%02d", $t["hour"], $t["min"], $t["sec"]);
//    if ($t["min"])
        return sprintf("%d:%02d", $t["min"], $t["sec"]);
//    return $t["sec"] . " secs";
}

function mkglobal($vars) {
    if (!is_array($vars))
        $vars = explode(":", $vars);
    foreach ($vars as $v) {
        if (isset($_GET[$v]))
            $GLOBALS[$v] = unesc($_GET[$v]);
        elseif (isset($_POST[$v]))
            $GLOBALS[$v] = unesc($_POST[$v]);
        else
            return 0;
    }
    return 1;
}

function tr($x,$y,$noesc=0) {
    if ($noesc)
        $a = $y;
    else {
        $a = htmlspecialchars($y);
        $a = str_replace("\n", "<br />\n", $a);
    }
    print("<tr><td bgcolor=#FFFFFF class=\"heading\" valign=\"top\" align=\"right\">$x</td><td bgcolor=#FFFFFF valign=\"top\" align=left>$a</td></tr>\n");
}

function validfilename($name) {
    return preg_match('/^[^\0-\x1f:\\\\\/?*\xff#<>|]+$/si', $name);
}

function validemail($email) {
    return preg_match('/^[\w.-]+@([\w.-]+\.)+[a-z]{2,6}$/is', $email);
}

function sqlesc($x) {
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
    return "'".mysqli_real_escape_string($con_link, $x)."'";
}

function delete_start_end($x) {
	$x_len = strlen($x);
	$x = substr($x,1,$x_len - 2);
    return $x;
}

function sqlwildcardesc($x) {
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
    return str_replace(array("%","_"), array("\%","\_"), mysqli_real_escape_string($con_link, $x));
}

function urlparse($m) {
    $t = $m[0];
    if (preg_match(',^\w+://,', $t))
        return "<a href=\"$t\">$t</a>";
    return "<a href=\"http://$t\">$t</a>";
}

function parsedescr($d, $html) {
    if (!$html)
    {
      $d = htmlspecialchars($d);
      $d = str_replace("\n", "\n<br>", $d);
    }
    return $d;
}

function genbark($x,$y) {
    site_header($y);
	print("<br><table width=50% border=0><tr><td align=center bgcolor=red><font size=3 color=yellow><b>" . htmlspecialchars($y) . "</td></tr></table>");
	print("<table width=50% border=0 cellspacing=0 cellpadding=0>");
	print("<tr>");
	print("<td align=center><br>");
    print("<font size=2>" . htmlspecialchars($x) . "</font>");
	print("<br><br></td></tr></table><br>");
    site_footer();
    exit();
}

function mksecret($len = 20) {
    $ret = "";
    for ($i = 0; $i < $len; $i++)
        $ret .= chr(mt_rand(0, 255));
    return $ret;
}

function httperr($code = 404) {
    header("HTTP/1.0 404 Not found");
    print("<h1>Niet gevonden</h1>\n");
    print("<p>Sorry :(</p>\n");
    exit();
}

function gmtime()
{
    return strtotime(get_date_time());
}

function logincookie($id, $passhash, $updatedb = 1, $expires = 0x7fffffff)
{
	setcookie("uid", $id, $expires, "/");
	setcookie("pass", $passhash, $expires, "/");
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
  if ($updatedb)
  	mysqli_query($con_link, "UPDATE users SET last_login = NOW() WHERE id = $id");
}


function logoutcookie()
	{
	setcookie("uid", "", 0x7fffffff, "/");
	setcookie("pass", "", 0x7fffffff, "/");
	}

function loggedinorreturn()
	{
    global $CURUSER;
    if (!$CURUSER)
		{
        header("Location: $BASEURL/login.php?returnto=" . urlencode($_SERVER["REQUEST_URI"]));
        exit();
    	}
	site_ip_check($CURUSER['id']);	// Nieuw om alle ip-nummers van alle gebruikers op te slaan
	}

function barken($msg)
	{ /// Tijdelijk hier geplaatst
	site_header();
	sitemsg("Verwijderen mislukt!", $msg);
	site_footer();
	exit;
	}

function deletetorrent($id,$filename) {
    global $row;
    global $CURUSER;
	if ($CURUSER["id"] != $row["owner"] && get_user_class() < UC_MODERATOR)
		barken("U bent niet de eigenaar ban deze torrent, hoe kan dat nou?\n");
    global $torrent_dir;
    global $cover_dir;
	$cover = get_cover($id);
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	mysqli_query($con_link, "DELETE FROM torrents WHERE id = $id");
//	mysqli_query("OPTIMIZE TABLE torrents") or sqlerr(__FILE__, __LINE__);
    foreach(explode(".","peers.files.comments.comments_uploader.ratings.thankyou.downloaded.downup.warn_pm_torrent") as $x)
        mysqli_query($con_link, "DELETE FROM $x WHERE torrent = $id");
    unlink("$torrent_dir/$filename");
    mysqli_query($con_link, "DELETE FROM bookmarks WHERE torrentid = $id");
    mysqli_query($con_link, "DELETE FROM uploader_bonus WHERE torrent_id = $id");
    mysqli_query($con_link, "DELETE FROM bonus_punten WHERE torrent_id = $id");
    mysqli_query($con_link, "DELETE FROM massa_bericht_torrents WHERE torrent_id = $id");
	if ($cover)
		{
		$len = strlen("ttps://torrentmedia.org//");
		$new_path = substr($cover, $len, strlen($cover)-$len); 
	    unlink("$new_path");
		}
}

// ----- Delete NZB
function deletenzb($id) {
    global $SITENZBDIR;
    global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
    $nzbfile = @mysqli_query($con_link, "SELECT filename FROM nzbs WHERE id = $id");
    $nzbfilename = @mysqli_result($nzbfile, 0);
    if (! $nzbfilename) {
        write_log("NZB $id could not be deleted!");
        @mysqli_query($con_link, "DELETE FROM nzbs WHERE id = $id");
        foreach(explode(".","nzbpiecelist.nzbcomments") as $x)
            @mysqli_query($con_link, "DELETE FROM $x WHERE nzb = $id");
    } else {
        @mysqli_query($con_link, "DELETE FROM nzbs WHERE id = $id");
        foreach(explode(".","nzbpiecelist.nzbcomments") as $x)
            @mysqli_query($con_link, "DELETE FROM $x WHERE nzb = $id");
        $nzbfilename = str_replace(" ", "_", $nzbfilename);
        @unlink($SITENZBDIR."/".$nzbfilename);
        @unlink($SITENZBDIR."/".$nzbfilename.".zip");
    }
} 


function pager($rpp, $count, $href, $opts = array()) {
    $pages = ceil($count / $rpp);

    if (!@$opts["lastpagedefault"])
        $pagedefault = 0;
    else {
        $pagedefault = floor(($count - 1) / $rpp);
        if ($pagedefault < 0)
            $pagedefault = 0;
    }

    if (isset($_GET["page"])) {
        $page = 0 + $_GET["page"];
        if ($page < 0)
            $page = $pagedefault;
    }
    else
        $page = $pagedefault;

    $pager = "";

    $mp = $pages - 1;
    $as = "<b><font color=white>&lt;&lt;&nbsp;Vorige</b>";
    if ($page >= 1) {
        $pager .= "<a href=\"{$href}page=" . ($page - 1) . "\"><font color=white>";
        $pager .= $as;
        $pager .= "</a>";
    }
    else
        $pager .= $as;
    $pager .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $as = "<b><font color=white>Volgende&nbsp;&gt;&gt;</b>";
    if ($page < $mp && $mp >= 0) {
        $pager .= "<a href=\"{$href}page=" . ($page + 1) . "\"><font color=white>";
        $pager .= $as;
        $pager .= "</a>";
    }
    else
        $pager .= $as;

    if ($count) {
        $pagerarr = array();
        $dotted = 0;
        $dotspace = 3;
        $dotend = $pages - $dotspace;
        $curdotend = $page - $dotspace;
        $curdotstart = $page + $dotspace;
        for ($i = 0; $i < $pages; $i++) {
            if (($i >= $dotspace && $i <= $curdotend) || ($i >= $curdotstart && $i < $dotend)) {
                if (!$dotted)
                    $pagerarr[] = "...";
                $dotted = 1;
                continue;
            }
            $dotted = 0;
            $start = $i * $rpp + 1;
            $end = $start + $rpp - 1;
            if ($end > $count)
                $end = $count;
            $text = "$start&nbsp;-&nbsp;$end";
            if ($i != $page)
                $pagerarr[] = "<a href=\"{$href}page=$i\"><b><font color=white>$text</b></a>";
            else
                $pagerarr[] = "<b><font color=white>$text</b>";
        }
        $pagerstr = join(" | ", $pagerarr);
        $pagertop = "<p align=\"center\">$pager<br />$pagerstr</p>\n";
        $pagerbottom = "<p align=\"center\">$pagerstr<br />$pager</p>\n";
    }
    else {
        $pagertop = "<p align=\"center\">$pager</p>\n";
        $pagerbottom = $pagertop;
    }

    $start = $page * $rpp;

    return array($pagertop, $pagerbottom, "LIMIT $start,$rpp");
}

function downloaderdata($res) {
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
    $rows = array();
    $ids = array();
    $peerdata = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
        $id = $row["id"];
        $ids[] = $id;
        $peerdata[$id] = array(downloaders => 0, seeders => 0, comments => 0);
    }

    if (count($ids)) {
        $allids = implode(",", $ids);
        $res = mysqli_query($con_link, "SELECT COUNT(*) AS c, torrent, seeder FROM peers WHERE torrent IN ($allids) GROUP BY torrent, seeder");
        while ($row = mysqli_fetch_assoc($res)) {
            if ($row["seeder"] == "yes")
                $key = "seeders";
            else
                $key = "downloaders";
            $peerdata[$row["torrent"]][$key] = $row["c"];
        }
        $res = mysqli_query($con_link, "SELECT COUNT(*) AS c, torrent FROM comments WHERE torrent IN ($allids) GROUP BY torrent");
        while ($row = mysqli_fetch_assoc($res)) {
            $peerdata[$row["torrent"]]["comments"] = $row["c"];
        }
    }

    return array($rows, $peerdata);
}

function commenttable($rows) {

  global $CURUSER, $_SERVER, $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
//   begin_main_frame();

    print("<table class=bottom width=750 border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>\n");

    $count = 0;
    foreach ($rows as $row)
    {
	
	   print "<br>";
	print "<table align=center class=site border=0 width=100% cellpadding=0 cellspacing=0>";
	print "<tr><td class=embedded>";
	print "<table width=100% class=bottom cellspacing=0 cellpadding=0><tr>";
	print "<td class=nav_site><font size=2>&nbsp;&nbsp;";
	
      print("<font color=lightblue>Door ");
//      print("<p class=sub>#" . $row["id"] . " door ");
        if (isset($row["username"]))
		{
			$title = @$row["title"];
			if ($title == "")
				$title = get_user_class_name(@$row["class"]);
			else
				$title = htmlspecialchars($title);
            print("<a name=comm". $row["id"] .
             " href=userdetails.php?id=" . $row["user"] . "><b><font color=lightblue>" .
             htmlspecialchars(@$row["username"]) . "</b></a>" . (@$row["donor"] == "yes" ? "<img src=pic/star.gif alt='Donor'>" : "") . (@$row["warned"] == "yes" ? "<img src=".
        "/pic/warned.gif alt=\"Warned\">" : "") . " ($title)\n");
		}
        else
            print("<a name=\"comm" . $row["id"] . "\"><i>(orphaned)</i></a>\n");
        print(" op " . convertdatum($row["added"]) . " " . (get_user_class() >= UC_MODERATOR || $CURUSER["id"] == $row["user"] ? "&nbsp;&nbsp;&nbsp;&nbsp;[<a href=comment.php?action=edit&amp;cid=$row[id]><font color=lightblue>Bewerken</a>]" : "") . "\n");

		if (get_user_class() >= UC_ADMINISTRATOR) 
        	print ("[<a href=deletecomment.php?id=$row[id]><font color=lightblue>Verwijder</a>]");


	print "</td>";
	print "</td></tr></table>";
	print "</td></tr></table>";

//	avatar_controle($row['user']);

      $avatar = ($CURUSER["avatars"] == "yes" ? htmlspecialchars($row["avatar"]) : "");
      if (!$avatar)
        $avatar = "pic/default_avatar.gif";
		
		$maten = getimagesize($avatar);

//		if (get_cover($row['id']))
//			print "<img ".pic_resize($maten[0],$maten[1], 300)." src=" . get_cover($row['id']) . ">";
		
    	print("<table class=bottom width=99% border= cellspacing=0 cellpadding=".@$padding.">\n");
        print("<tr valign=top>\n");
        print("<td bgcolor=white align=center width=1% style='padding: 0px'><img  ".pic_resize($maten[0],$maten[1], 100)."  src=$avatar></td>\n");

	$body = format_comment($row["text"]);
    $body = stripslashes($body);

      if (is_valid_id(@$row['editedby']))
      {
        $res2 = mysqli_query($con_link, "SELECT username FROM users WHERE id=$row[editedby]");
        if (mysqli_num_rows($res2) == 1)
        {
          $arr2 = mysqli_fetch_assoc($res2);
		  $bewerkt = convertdatum($row[editedat]);
          $body .= "<p><font color=brown size=1 class=small>Laatst bewerkt door <a href=userdetails.php?id=$row[editedby]><b><font color=brown>$arr2[username]</b></a> op $bewerkt</font></p>\n";
        }
      }

        print("<td bgcolor=white class=text>" . $body . "</td>\n");
        print("</tr>\n");
      end_table();
    }
    end_frame();
	print "<br>";
  end_main_frame();
}


// ----- Comment display on the NZB's
function nzbcommenttable($rows, $owner)
{
	global $CURUSER;
	begin_main_frame();
	begin_frame();
	$count = 0;
	foreach ($rows as $row)
	{
		print("<p class=sub>#" . $row["id"] . " by ");
		
        if (isset($row["username"]))
		{
        	/*  UNCOMMENT FOR ANONYMOUS UPLOADER MOD
            if ($row['user'] == $owner & get_user_class() < UC_MODERATOR & $row['advertisename'] == "no")
            {
                print("<a name=comm". $row["id"]><b>Uploader</b></a>\n");
            }
            else
            { */	
                $title = $row["title"];
    			if ($title == "")
    				$title = get_user_class_name($row["class"]);
    			else
    				$title = safe($title);
                print("<a name=comm". $row["id"] .
                    " href=userdetails.php?id=" . $row["user"] . "><b>" .
                    safe($row["username"]) . "</b></a>" . ($row["donor"] == "yes" ? "<img src=pic/star.gif alt='Donor'>" : "") . ($row["warned"] == "yes" ? "<img src=".
        			"pic/warned.gif alt=\"Warned\">" : "") . " ($title)\n");
        /*  }   */  // UNCOMMENT FOR ANONYMOUS UPLOADER MOD
		}
		else
   	        print("<a name=\"comm" . $row["id"] . "\"><i>(orphaned)</i></a>\n");

		print(" at " . $row["added"] . " GMT" .
			($row["user"] == $CURUSER["id"] || get_user_class() >= UC_MODERATOR ? "- [<a href=nzbcomment.php?action=edit&amp;cid=$row[id]>Edit</a>]" : "") .
			(get_user_class() >= UC_MODERATOR ? "- [<a href=nzbcomment.php?action=delete&amp;cid=$row[id]>Delete</a>]" : "") .
			($row["editedby"] && get_user_class() >= UC_MODERATOR ? "- [<a href=nzbcomment.php?action=vieworiginal&amp;cid=$row[id]>View original</a>]" : "") . "</p>\n");
			
		$avatar = ($CURUSER["avatars"] == "yes" ? safe($row["avatar"]) : "");
		if (!$avatar)
			$avatar = "pic/default_avatar.gif";
		/*  UNCOMMENT FOR ANONYMOUS UPLOADER MOD
		if ($row['user'] == $owner & get_user_class() < UC_MODERATOR & $row['advertisename'] == "no")
            $avatar = "pic/default_avatar.gif";
        */  // UNCOMMENT FOR ANONYMOUS UPLOADER MOD
			
		$text = format_comment($row["text"]);
		
        if ($row["editedby"])
            $text .= "<p><font size=1 class=small>Last edited by <a href=userdetails.php?id=$row[editedby]><b>$row[username]</b></a> at $row[editedat] GMT</font></p>\n";
        /* USE ABOVE ^^^ OR BELOW vvv DEPENDING ON WHETHER YOU HAVE THE ANONYMOUS UPLOADER MOD */
        /* // --- Anonymous uploader - comment out if not using anonymous mod
        if ($row['user'] == $owner & get_user_class() < UC_MODERATOR & $row['advertisename'] == "no") {
            $editname = "<b>uploader</b>";
        } elseif ($row['editedby'] == $row['user']) {
            $editname = "<a href=\"userdetails.php?id=".$row['editedby']."\"><b>".$row['username']."</b></a>";
        } else {
            $editname = "<a href=\"userdetails.php?id=".$row['editedby']."\" class=\"altlink\"><b>Staff</b></a>";
        } 
        
        if ($row["editedby"])
            $text .= "<p><font size=1 class=small>Last edited by $editname at $row[editedat] GMT</font></p>\n";*/
    	   
		begin_table(true);
		print("<tr valign=top>\n");
		print("<td align=center width=150 style='padding: 0px'><img width=150 src=$avatar></td>\n");
		print("<td class=text>$text</td>\n");
		print("</tr>\n");
        end_table();
    }
	end_frame();
	end_main_frame();
}


function searchfield($s) {
    return preg_replace(array('/[^a-z0-9]/si', '/^\s*/s', '/\s*$/s', '/\s+/s'), array(" ", "", "", " "), $s);
}

function genrelist() {
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
    $ret = array();
    $res = mysqli_query($con_link, "SELECT id, name, volgorde FROM categories ORDER BY volgorde");
    while ($row = mysqli_fetch_array($res))
        $ret[] = $row;
    return $ret;
}

function convertdatum($datum,$tijd="") {
	if (substr($datum,5,1) == "0")
		$month = substr($datum,6,1);
	else
		$month = substr($datum,5,2);
	if (substr($datum,8,1) == "0")
		$day = substr($datum,9,1);
	else
		$day = substr($datum,8,2);
	$year = substr($datum,0,4);
	if (!$tijd == "no")
		$time = "  om " . substr($datum,11,8);
	else
		$time = "";
	if ($month == "1") return $day . " januari " . $year . $time;
	if ($month == "2") return $day . " februari " . $year . $time;
	if ($month == "3") return $day . " maart " . $year . $time;
	if ($month == "4") return $day . " april " . $year . $time;
	if ($month == "5") return $day . " mei " . $year . $time;
	if ($month == "6") return $day . " juni " . $year . $time;
	if ($month == "7") return $day . " juli " . $year . $time;
	if ($month == "8") return $day . " augustus " . $year . $time;
	if ($month == "9") return $day . " september " . $year . $time;
	if ($month == "10") return $day . " oktober " . $year . $time;
	if ($month == "11") return $day . " november " . $year . $time;
	if ($month == "12") return $day . " december " . $year . $time;
}
function alleentijd($datum) {
	$time = substr($datum,11,8);
	return $time;
}

// ----- NZB genre list
function nzbgenrelist() {
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
    $ret = array();
    $res = mysqli_query($con_link, "SELECT id, name FROM nzbcategories ORDER BY name");
    while ($row = mysqli_fetch_array($res))
        $ret[] = $row;
    return $ret;
}

// ----- To add nzb retention and set the WHERE clause so that only nzbs within the retention are pulled
function nzbretention() {
    global $CURUSER, $SITENZBRETENTION;
    
    $maxret = $SITENZBRETENTION;
    if ($CURUSER['nzbretention'] != 0) {
        if ($CURUSER['nzbretention'] < $maxret)
              $retent = $CURUSER['nzbretention'];
        else
              $retent = $maxret;
        if ($retent >= $SITENZBRETENTION)
              return false;
        //take retention time away from time now
        $retent = $retent*24*60*60;
        $timenow = time();
        $retent = $timenow-$retent;
        return $retent;
    } else {
        return false;
    }
}


function linkcolor($num) {
    if (!$num)
        return "red";
//    if ($num == 1)
//        return "yellow";
    return "green";
}

function ratingpic($num) {
    global $pic_base_url;
    $r = round($num * 2) / 2;
    if ($r < 1 || $r > 5)
        return;
    return "<img src=\"$pic_base_url/rating/$r.gif\" border=\"0\" alt=\"Waardering: $num / 5\" />";
}

function waarderings_balk($num)
	{
	$waarde = round($num * 20);
	$rest = round(100 - $waarde);
	$wd  = "<table class=bottom height=2 border=0 width=150><tr><td class=embedded width=$waarde% bgcolor=yellow></td><td class=embedded width=$rest% bgcolor=red></td></tr></table>";
	return $wd;
	}

function getthanks($id) {
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$ressite = mysqli_query($con_link, "SELECT  torrent FROM thankyou WHERE torrent = $id")
	or sqlerr();

	$countty = 0;

	while ($rowsite = mysqli_fetch_assoc($ressite)) {
		$countty += 1;
	}
	
	return $countty;
}

function hash_pad($hash) {
    return str_pad($hash, 20);
}

function hash_where($name, $hash) {
    $shhash = preg_replace('/ *$/s', "", $hash);
    return "($name = " . sqlesc($hash) . " OR $name = " . sqlesc($shhash) . ")";
}

function torrenttable($res, $variant = "index")
	{
	global $pic_base_url, $CURUSER, $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);

    while ($row = mysqli_fetch_assoc($res))
		{
		$id = $row["id"];
		$zichtbaar = get_row_count("peers","WHERE userid=$CURUSER[id] AND torrent=".$id);

			tabel_start();
		print "<table width=100% border=0 cellspacing=0 cellpadding=0>\n";


		print "<td width=100>\n";
		if (isset($row["cat_name"]))
			{
			print("<span\">");
			if (isset($row["cat_name"]) && $row["cat_name"] != "")
			print("<img  class=image123 height=100 width=90 border=0 src=\"" . get_cover($row['id']) .  "\" alt=\"" . $row["id"] . "\" /><img  class=large height=540 width=360 border=0 src=\"" . get_cover($row['id']) .  "\" alt=\"" . $row["cat_name"] . "\" />");
			else
				print($row["cat_name"]);
			print("</span>");
			}
		print("</td>");


	
		$userid = $CURUSER['id'];
		$def = mysqli_query($con_link, "SELECT last_browse FROM users WHERE id = $userid");
		$defs = mysqli_fetch_array($def);
		$last_browse = $defs['last_browse'];
		
		$dispname = htmlspecialchars($row["name"]);

		print("<td class=embedded colspan=1 width=18% align=center><b><a class=altlink_white href=\"details.php?");
		if ($variant == "mytorrents")
			print("returnto=" . urlencode($_SERVER["REQUEST_URI"]) . "&amp;");
			print("id=$id");
		if ($variant == "index")
			print("&amp;hit=1");
		print("\">$dispname</b></a></td>\n");
		
		$seeders_count = get_row_count("peers","WHERE seeder='yes' AND torrent=".$row['id']);
		$leechers_count = get_row_count("peers","WHERE seeder='no' AND torrent=".$row['id']);

		if ($seeders_count > 0)
			{
			if ($leechers_count)
				$ratio = $seeders_count / $leechers_count; else $ratio = 1;
			if ($zichtbaar > 0 || get_user_class() >= UC_MODERATOR || $CURUSER['id'] == $row['owner'])
				$delers = "<b><a class=altlink_white href='details_bronnen.php?torrent_id=".$row['id']."'>" . number_format($seeders_count) . "</a></b>\n";
//				$delers = "<b><a class=altlink_white href='details_bronnen.php?torrent_id=".$row['id']."'><font color=" .	get_slr_color($ratio) . ">" . number_format($seeders_count) . "</font></a></b>\n";
			else		
				$delers = "<b><font color=white>" . number_format($seeders_count) . "</font></b>\n";
//				$delers = "<b><font color=" .	get_slr_color($ratio) . ">" . number_format($seeders_count) . "</font></b>\n";
			}
		else
			$delers = "0\n";

		if ($leechers_count > 0)
			{
			if ($zichtbaar > 0 || get_user_class() >= UC_MODERATOR || $CURUSER['id'] == $row['owner'])
				$ontvangers = "<b><a class=altlink_white href='details_bronnen.php?torrent_id=".$row['id']."'>" . number_format($leechers_count) . "</b></a>\n";
			else
				$ontvangers = "<b>" . number_format($leechers_count) . "</b>\n";
			}
		else
			$ontvangers = ("0\n");
	
		if ($row["seeders"] == "1") 
			{
			if ($zichtbaar > 0 || get_user_class() >= UC_MODERATOR || $CURUSER['id'] == $row['owner'])
				$dtekst = "<a class=altlink_white href='details_bronnen.php?torrent_id=".$row['id']."'>deler</a>";
			else
				$dtekst = "deler";
			}
		else
			{
			if ($zichtbaar > 0 || get_user_class() >= UC_MODERATOR || $CURUSER['id'] == $row['owner'])
				$dtekst = "<a class=altlink_white href='details_bronnen.php?torrent_id=".$row['id']."'>delers</a>";
			else
				$dtekst = "delers";
			}

		if ($row["leechers"] == "1") 
			{
			if ($zichtbaar > 0 || get_user_class() >= UC_MODERATOR || $CURUSER['id'] == $row['owner'])
				$otekst = "<a class=altlink_white href='details_bronnen.php?torrent_id=".$row['id']."'>ontvanger</a>";
			else
				$otekst = "ontvanger";
			}
		else
			{
			if ($zichtbaar > 0 || get_user_class() >= UC_MODERATOR || $CURUSER['id'] == $row['owner'])
				$otekst = "<a class=altlink_white href='details_bronnen.php?torrent_id=".$row['id']."'>ontvangers</a>";
			else
				$otekst = "ontvangers";
			}
	
		print "<td class=embedded  colspan=1 width=18% align=center><font color=white>$delers $dtekst en $ontvangers $otekst</td>\n";
		if ($row["numfiles"] == "1")
			print("<td class=embedded colspan=1 width=18% align=center><a class=altlink_white href='details_bestanden.php?torrent_id=".$id."'>" . mksize($row["size"]) ." in " . $row["numfiles"] . " bestand</a></td>");
		else
			print("<td class=embedded colspan=1 width=18% align=center><a class=altlink_white href='details_bestanden.php?torrent_id=".$id."'>" . mksize($row["size"]) ." in " . $row["numfiles"] . " bestanden</a></td>");
	
		$totaal_torrent = 0;
		$res_totaal = mysqli_query($con_link, "SELECT * FROM bonus_punten WHERE torrent_id=".$row['id']) or sqlerr(__FILE__, __LINE__);
		while ($row_totaal = mysqli_fetch_assoc($res_totaal))
			$totaal_torrent += $row_totaal['ammount'];

		if ($totaal_torrent)
			$muntjes = "<img border=0 height=12 width=12 src='pic/bp/bp_010.png'>";
		if ($totaal_torrent > 1000)
			$muntjes .= "<img border=0 height=12 width=12 src='pic/bp/bp_010.png'>";
		if ($totaal_torrent > 2000)
			$muntjes .= "<img border=0 height=12 width=12 src='pic/bp/bp_010.png'>";
		if ($totaal_torrent > 3000)
			$muntjes .= "<img border=0 height=12 width=12 src='pic/bp/bp_010.png'>";
		if ($totaal_torrent > 4000)
			$muntjes .= "<img border=0 height=12 width=12 src='pic/bp/bp_010.png'>";

		if ($totaal_torrent)
			print "<td class=embedded colspan=1 width=18% align=center><font color=white><b><a class=altlink_white href='bonus_overzicht_torrent.php?torrent_id=".$row['id']."'>".$totaal_torrent." BP ".$muntjes."</a></td>";
		else
			print "<td class=embedded colspan=1 width=18% align=center><font color=white><b>0 BP</td>";

		if (@$row["owner"] > 0)
			print"<td class=embedded colspan=1 width=18% align=center><font color=white>Geplaatst door: " . (isset($row["username"]) ? ("<a class=altlink_white href=userdetails.php?id=" . $row["owner"] . "><b>" . htmlspecialchars($row["username"]) . "</b></a>") : "<b><font color=white>ANONIEM</i>") . "</b></td>";
		else
			print("<td class=embedded colspan=1 width=18% align=center><font color=white>Geplaatst door: (onbekend)</td>");
		
		print "</tr>\n";
		
		print "<tr>\n";
	
		print "<td class=embedded align=center><font color=white>" . number_format($row["times_completed"]) . " keer gedownload</td>\n";


		$ttl = floor((gmtime() - sql_timestamp_to_unix_timestamp($row["added"])) / 3600);
		print "<td class=embedded align=center><font color=white>Torrent is <b>$ttl</b> uur aanwezig</td>\n";
		
		if (!$row["comments"])
			print "<td class=embedded align=center><font color=white>Nog geen opmerkingen</td>\n";
		else
			if ($row["comments"] == 1)
				print "<td class=embedded align=center><font color=white>" . $row["comments"] . " opmerking</td>\n";
			else
				print "<td class=embedded align=center><font color=white>" . $row["comments"] . " opmerkingen</td>\n";
		print "<td class=embedded align=center><font color=white>" . convertdatum($row["added"]) . "</td>";
		$thanks = getthanks($row['id']);
		if ($thanks == 0)
			print "<td class=embedded align=center><font color=white>Nog niet bedankt</td>\n";
		else
			print "<td class=embedded align=center><font color=white>$thanks keer bedankt</td>\n";
		print "</tr>\n";

		print "<tr>";

		if (@$row["username"] == $CURUSER["username"])
			print "<td width=18% class=embedded><center><a title=\"$dispname nu bewerken\" href=\"edit.php?returnto=" . urlencode($_SERVER["REQUEST_URI"]) . "&amp;id=" . $row["id"] . "\"><img border=0 height=12 width=12 src=/pic/site/hammer.gif></a></center></td\n>";
		else
		if ($row['added'] >= $last_browse)
			$new_msg = "<font color=yellow><b>NIEUW</b></font>";

		else
			print("<td width=18% class=embedded></td>");
	
		print "<td width=18% class=embedded>".@$new_msg."</td>\n";

		print "<td width=18% class=embedded align=right>".@$extra_msg."</td>\n";
		
print("</table>");
			//tabel_einde();

		$seeders_count = get_row_count("peers","WHERE seeder='yes' AND torrent=".$row['id']);
		if ($seeders_count > 3)
			{
			print "<td width=99%><img border=0 src='pic/woot.gif'></td>\n";
			}
		
		print "</tr>\n";
		print "</table></td></tr></table></br>\n";
		}
	}
function block_browser()
{
    $agent = $_SERVER["HTTP_USER_AGENT"];
    if (preg_match("/^Mozilla/", $agent) || preg_match("/^Opera/", $agent) || preg_match("/^Links/", $agent) || preg_match("/^Lynx/", $agent)) {
        err("Browser access blocked!");
    }
    // check headers
    if (function_exists('getallheaders')) { //getallheaders() is only supported when PHP is installed as an Apache module
        $headers = getallheaders();
        //else
        //	$headers = emu_getallheaders();

        if ($_SERVER["HTTPS"] != "on") {
            if (isset($headers["Cookie"]) || isset($headers["Accept-Language"]) || isset($headers["Accept-Charset"])) {
                err("Anti-Cheater: You cannot use this agent");
            }
        }
    }
}
require "global.php";
?>
