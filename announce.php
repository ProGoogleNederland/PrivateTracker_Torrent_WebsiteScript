<?php
ob_start("ob_gzhandler");
require_once("include/bittorrent.php");
require_once("include/benc.php");
require_once("include/secrets.php");


if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}


global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);

$agent = $_SERVER["HTTP_USER_AGENT"];
block_browser();

function dbconn_announce($autoclean = false)
{
    global $SITE_ONLINE, $SITE_ONLINE_MSG, $mysql_host, $mysql_user, $mysql_pass, $mysql_db, $_SERVER, $krediet_groot, $aktie_vandaag, $aktie_text;
    $con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
    if (!$SITE_ONLINE)
        err("Server is tijdelijk offline");
    if (!@mysqli_connect($mysql_host, $mysql_user, $mysql_pass)) {
        switch (mysqli_errno($con_link)) {
            case 1040:
            case 2002:
                if ($_SERVER['REQUEST_METHOD'] == "GET")
                    err("Tijdelijk contact verlies met server");
                else
                    err("Tijdelijk contact verlies met server");
            default:
                err("Tijdelijk contact verlies met server");
        }
    }
    mysqli_select_db($con_link, $mysql_db) or die('dbconn: mysql_select_db: ' + mysqli_error($con_link));
    userlogin();
}

function err($msg)
{
    benc_resp(array("failure reason" => array("type" => "string", "value" => $msg)));
    exit();
}

function benc_resp($d)
{
    benc_resp_raw(benc(array("type" => "dictionary", "value" => $d)));
}

function benc_resp_raw($x)
{
    header("Content-Type: text/plain");
    header("Pragma: no-cache");
    print($x);
}

foreach (array("passkey", "info_hash", "peer_id", "ip", "event") as $x)
    if (isset($_GET["$x"])) {
        $GLOBALS[$x] = $_GET[$x];
    }

foreach (array("port", "downloaded", "uploaded", "left") as $x) {
    $GLOBALS[$x] = 0 + $_GET[$x];
}
if (strpos($passkey, "?")) {
    $tmp = substr($passkey, strpos($passkey, "?"));
    $passkey = substr($passkey, 0, strpos($passkey, "?"));
    $tmpname = substr($tmp, 1, strpos($tmp, "=") - 1);
    $tmpvalue = substr($tmp, strpos($tmp, "=") + 1);
    $GLOBALS[$tmpname] = $tmpvalue;
}

foreach (array("passkey", "info_hash", "peer_id", "port", "downloaded", "uploaded", "left") as $x)
    if (!isset($x))
        err("Ontbrekende gegevens: $x");

foreach (array("info_hash", "peer_id") as $x) {
    if (strlen($GLOBALS[$x]) != 20) {
        err("Foute $x (" . strlen($GLOBALS[$x]) . " - " . rawurlencode($GLOBALS[$x]) . ")");
    }

    if (strlen($passkey) != 32) {
        err("Verkeerde passkey. Download de torrent opnieuw aub.");
    }
}

$rsize = 50;
foreach (array("num want", "numwant", "num_want") as $k) {
    if (isset($_GET[$k])) {
        $rsize = 0 + $_GET[$k];
        break;
    }
}


//if ("text/html, */*" == $_SERVER["HTTP_ACCEPT"] || "Close" == $_SERVER["HTTP_CONNECTION"] && "gzip, deflate" != $_SERVER["HTTP_ACCEPT_ENCODING"])
//	{
//	$u = mysql_fetch_assoc(mysql_query("SELECT id, username FROM users WHERE id=".$userid));
//	$dt = sqlesc(get_date_time());
//
//	$msg = sqlesc("You have been logged for trying to cheat!");
//	mysql_query("INSERT INTO messages (sender, receiver, added, msg, poster) VALUES(0, 1, $dt, $msg, 0)");
//	mysql_query("INSERT INTO messages (sender, receiver, added, msg, poster) VALUES(0, $userid, $dt, $msg, 0)") or sqlerr(__FILE__, __LINE__);

//	write_log("User ".$userid." (".$u["username"].") was logged for trying to cheat.");
//	benc_resp_raw("You have been logged for trying to cheat");

//	$ip = getip();
//	$subject = sqlesc("Fake upload - $ip");
//	$body = sqlesc("User ".$userid." (".$u["username"].") has been detected trying to cheat using a fake maker.\n\n His IP address is $ip.");
//	auto_post( $subject , $body );
//	}

if (!$port || $port > 0xffff) {
    err("Verkeerde poort");
}
if (!isset($event))
    $event = "";

$seeder = ($left == 0) ? "yes" : "no";

dbconn_announce(false);

$valid = @mysqli_fetch_row(@mysqli_query($con_link, "SELECT COUNT(*) FROM users WHERE passkey=" . sqlesc($passkey)));
if ($valid[0] != 1) err("Foute passkey! Download de .torrent opnieuw van de site");

$def = mysqli_query($con_link, "SELECT id FROM users WHERE passkey=" . sqlesc($passkey));
$defs = mysqli_fetch_assoc($def);
if ($defs) {
    $userid = $defs['id'];
}

//$res = mysqli_query("SELECT id, banned, seeders + leechers AS numpeers, UNIX_TIMESTAMP(added) AS ts FROM torrents WHERE " . hash_where("info_hash", $info_hash));
$res = mysqli_query($con_link, "SELECT id, banned, UNIX_TIMESTAMP(added) AS ts FROM torrents WHERE " . hash_where("info_hash", $info_hash));
$torrent = mysqli_fetch_assoc($res);
if (!$torrent)
    err("Deze torrent bestaat niet op deze tracker. ");
$torrentid = $torrent["id"];

$fields = "seeder, peer_id, ip, port, uploaded, downloaded, userid";

//$numpeers = $torrent["numpeers"];
//$limit = "";
//if ($numpeers > $rsize)
$limit = "ORDER BY RAND() LIMIT 50";

$res = mysqli_query($con_link, "SELECT $fields FROM peers WHERE torrent = $torrentid AND connectable = 'yes' $limit");
$resp = "d" . benc_str("interval") . "i" . $announce_interval . "e" . benc_str("peers") . "l";
unset($self);
while ($row = mysqli_fetch_assoc($res)) {
    $row["peer_id"] = hash_pad($row["peer_id"]);
    if ($row["peer_id"] === $peer_id) {
        $userid = $row["userid"];
        $self = $row;
        continue;
    }

    $resp .= "d" .
        benc_str("ip") . benc_str($row["ip"]) .
        benc_str("peer id") . benc_str($row["peer_id"]) .
        benc_str("port") . "i" . $row["port"] . "e" .
        "e";
}

$resp .= "ee";
$selfwhere = "torrent = $torrentid AND " . hash_where("peer_id", $peer_id);

if (!isset($self)) {
    $res = mysqli_query($con_link, "SELECT $fields FROM peers WHERE $selfwhere");
    $row = mysqli_fetch_assoc($res);
    if ($row) {
        $userid = $row["userid"];
        $self = $row;
    }
}

//// Up/down stats ////////////////////////////////////////////////////////////
function verbindbaar()
{
    $sockres = @fsockopen($ip, $port, $errno, $errstr, 5);
    if (!$sockres) {
        @fclose($sockres);
        return "Nee";
    } else {
        @fclose($sockres);
        return "";
    }
}

if (!isset($self)) {
    if (!verbindbaar()) {
        $connectable = "no";
        err("U bent niet verbindbaar..1..");
    }

    $valid = @mysqli_fetch_row(@mysqli_query($con_link, "SELECT COUNT(*) FROM peers WHERE torrent=$torrentid AND passkey=" . sqlesc($passkey)));

    $rz = mysqli_query($con_link, "SELECT maxtorrents, id, uploaded, downloaded, class FROM users WHERE passkey=" . sqlesc($passkey) . " AND enabled = 'yes' ORDER BY last_access DESC LIMIT 1") or err("Tracker error 2");
    if (mysqli_num_rows($rz) == 0)
        err("Onbekende passkey. Download de torrent opnieuw aub.");

    $az = mysqli_fetch_assoc($rz);
    $userid = $az["id"];

    if (!verbindbaar()) {
        $connectable = "no";
        err("U bent niet verbindbaar..2..");
    }

    $allowedtorrents = $az["maxtorrents"];
    $res = mysqli_query($con_link, "SELECT COUNT(*) FROM peers WHERE userid=$userid") or err("Maximale torrents bereikt.");
    $row = mysqli_fetch_row($res);
    $activetorrents = $row[0];
    if ($activetorrents >= $allowedtorrents)
        err("Sorry, $allowedtorrents is maximaal voor u.");
} else {
    $upthis = max(0, $uploaded - $self["uploaded"]);
    $downthis = max(0, $downloaded - $self["downloaded"]);

    if ($upthis > 0 || $downthis > 0) {
        $ressite = mysqli_query($con_link, "SELECT * FROM downup WHERE user=$userid AND torrent=$torrentid") or err("DownUpStats Error");
        $rowsite = mysqli_num_rows($ressite);
        if ($rowsite==0){
            mysqli_query($con_link, "INSERT INTO downup (torrent, user, added, uploaded, downloaded) VALUES ($torrentid, $userid, NOW(), $upthis, $downthis)");
		}
        else{
            mysqli_query($con_link, "UPDATE downup SET uploaded = uploaded + $upthis, downloaded = downloaded + $downthis, lastseen = NOW() WHERE user=$userid AND torrent=$torrentid") or err("Tracker foutmelding 4");
			mysqli_query($con_link, "UPDATE users SET uploaded = uploaded + $upthis, downloaded = downloaded + $downthis WHERE id=$userid") or err("Tracker foutmelding 3");

	
		}
//		if (get_super_seeder($userid) == "no")
//			{
//			$verschil = 1024*1024*1024;
//			if ($upthis > $verschil)
//				{
//				$verzendtekst = "<a href=userdetails.php?id=".$userid.">" . get_username($userid) . "</a> heeft " . mksize($upthis) . " verzonden voor torrent <a href=details.php?id=".$torrentid.">".get_torrentname($torrentid)."</a>, terwijl max is " . mksize($verschil) . " - <a href=sendmessage.php?receiver=".$userid."&auto=9>PM</a>";
//				write_log_cheat($verzendtekst);
//				}
//			}

      
    }
}

/// Client ban code
/*
$uagent = $_SERVER['HTTP_USER_AGENT'];
$bua = mysqli_query("SELECT agent FROM banned_agent") or err('Foutmelding Agents');
while ($nea = mysqli_fetch_array($bua))
	{
	$n = $nea['agent'];
	$nr = preg_replace("/\//", "\/", $n);
	$neadle = "/\b$nr\b/i";
	if (preg_match($neadle, $uagent))
		{
		err("Client software verbannen.");
		}
	}
*/
/// Client ban code

function portblacklisted($port)
{
    if ($port >= 411 && $port <= 413) return true; // direct connect
    if ($port >= 6881 && $port <= 6889) return true; // bittorrent
    if ($port == 1214) return true; // kazaa
    if ($port >= 6346 && $port <= 6347) return true; // gnutella
    if ($port == 4662) return true; // emule
    if ($port == 6699) return true; // winmx
    return false;
}

$updateset = array();

if ($event == "stopped") {
    if (isset($self)) {
        mysqli_query($con_link, "DELETE FROM peers WHERE $selfwhere");
        if (mysqli_affected_rows($con_link)) {
            if ($self["seeder"] == "yes")
                $updateset[] = "seeders = seeders - 1";
            else
                $updateset[] = "leechers = leechers - 1";
        }
    }
} else {
    if ($event == "completed") {
        $ratiocompleted = floor($uploaded / $downloaded * 1000) / 1000;
        $updateset[] = "times_completed = times_completed + 1";
        mysqli_query($con_link, "INSERT INTO downloaded (torrent, user, added, uploaded, downloaded) VALUES ($torrentid, $userid, NOW(), $uploaded, $downloaded)");
    }
    if (isset($self)) {
        if (!verbindbaar()) {
            $connectable = "no";
            err("U bent niet verbindbaar..3..");
        }

        mysqli_query($con_link, "UPDATE peers SET uploaded = $uploaded, downloaded = $downloaded, to_go = $left, last_action = NOW(), seeder = '$seeder'"
            . ($seeder == "yes" && $self["seeder"] != $seeder ? ", finishedat = " . time() : "") . " WHERE $selfwhere");
        if (mysqli_affected_rows($con_link) && $self["seeder"] != $seeder) {
            if ($seeder == "yes") {
                $updateset[] = "seeders = seeders + 1";
                $updateset[] = "leechers = leechers - 1";
            } else {
                $updateset[] = "seeders = seeders - 1";
                $updateset[] = "leechers = leechers + 1";
            }
        }
    } else {
        if (portblacklisted($port))
            err("Poort $port is geblokkeerd op Torrentmedia.org.");
        else {
            if (!verbindbaar()) {
                $connectable = "no";
            } else {
                $connectable = "yes";
            }
        }

        $ret = mysqli_query($con_link, "INSERT INTO peers (connectable, torrent, peer_id, ip, port, uploaded, downloaded, to_go, started, last_action, seeder, userid, agent, uploadoffset, downloadoffset, passkey) VALUES ('$connectable', $torrentid, " . sqlesc($peer_id) . ", " . sqlesc($ip) . ", $port, $uploaded, $downloaded, $left, NOW(), NOW(), '$seeder', $userid, " . sqlesc($agent) . ", $uploaded, $downloaded, " . sqlesc($passkey) . ")");

        if ($ret) {
            if ($seeder == "yes")
                $updateset[] = "seeders = seeders + 1";
            else
                $updateset[] = "leechers = leechers + 1";
        }
    }
}

if ($seeder == "yes") {
    if ($torrent["banned"] != "yes")
        $updateset[] = "visible = 'yes'";
    $updateset[] = "last_action = NOW()";
}

if (count($updateset))
    mysqli_query($con_link, "UPDATE torrents SET " . join(",", $updateset) . " WHERE id = $torrentid");

if (!verbindbaar()) {
    err("U bent niet verbindbaar..3..");
} else
    benc_resp_raw($resp);

?>