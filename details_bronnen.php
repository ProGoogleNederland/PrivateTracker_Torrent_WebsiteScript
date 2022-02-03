<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

$torrent_id = (int)@$_GET['torrent_id'];
if (!$torrent_id)
	new_error_message("Foutmelding", "Geen torrent gevonden.","white",3000);

$seeders_count = get_row_count("peers","WHERE seeder='yes' AND torrent=".$torrent_id);
$leechers_count = get_row_count("peers","WHERE seeder='no' AND torrent=".$torrent_id);

$res = mysqli_query($con_link, "SELECT torrents.cover_by, torrents.seeders, torrents.banned, torrents.leechers, torrents.info_hash, torrents.filename, LENGTH(torrents.nfo) AS nfosz, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(torrents.last_action) AS lastseed, torrents.numratings, torrents.name, IF(torrents.numratings < $minvotes, NULL, ROUND(torrents.ratingsum / torrents.numratings, 1)) AS rating, torrents.owner, torrents.save_as, torrents.descr, torrents.visible, torrents.size, torrents.added, torrents.views, torrents.hits, torrents.times_completed, torrents.id, torrents.type, torrents.numfiles, categories.name AS cat_name, users.username FROM torrents LEFT JOIN categories ON torrents.category = categories.id LEFT JOIN users ON torrents.owner = users.id WHERE torrents.id = $torrent_id") or sqlerr(__FILE__, __LINE__);
//$res = mysqli_query($con_link, "SELECT * FROM torrents WHERE id = $torrent_id") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);
if (!$row)
	new_error_message("Foutmelding", "Deze torrent niet gevonden.","white",3000);

site_header("Bronnen");
page_start();
tabel_top("Overzicht bronnen","center");
tabel_start(97);
print "<font size=2 color=white><a class=altlink_white href='details.php?id=".$torrent_id."'>Terug naar: ".htmlspecialchars($row['name'])."</a><br><br>";

$downloaders = array();
$seeders = array();
$subres = mysqli_query($con_link, "SELECT peer_id, seeder, finishedat, downloadoffset, uploadoffset, ip, port, uploaded, downloaded, to_go, UNIX_TIMESTAMP(started) AS st, connectable, agent, UNIX_TIMESTAMP(last_action) AS la, userid FROM peers WHERE torrent = $torrent_id") or sqlerr();
while ($subrow = mysqli_fetch_array($subres))
	{
	if ($subrow["seeder"] == "yes")
		$seeders[] = $subrow;
	else
		$downloaders[] = $subrow;
	}

function leech_sort($a,$b)
	{
	if ( isset( $_GET["usort"] ) ) return seed_sort($a,$b);				
	$x = $a["to_go"];
	$y = $b["to_go"];
	if ($x == $y)
		return 0;
	if ($x < $y)
		return -1;
	return 1;
	}
function seed_sort($a,$b)
	{
	$x = $a["uploaded"];
	$y = $b["uploaded"];
	if ($x == $y)
		return 0;
	if ($x < $y)
		return 1;
	return -1;
	}

usort($seeders, "seed_sort");
usort($downloaders, "leech_sort");

print "<div align=left>";
if ($seeders_count == 1)
	print "<font color=white size=2><b>" . $seeders_count . " Deler</b></font>\n";
else
	print "<font color=white size=2><b>" . $seeders_count . " Delers</b></font>\n";

print "<div align=center>";
print dltable("Deler", $seeders, $row);

print "<div align=left>";
if ($leechers_count == 1)
	print "<font color=white size=2><b>" . $leechers_count . " Ontvanger</b></font>\n";
else
	print "<font color=white size=2><b>" . $leechers_count . " Ontvangers</b></font>\n";

print "<div align=center>";

print dltable("Ontvangers", $downloaders, $row);

print "<br><font size=2 color=white><a class=altlink_white href='details.php?id=".$torrent_id."'>Terug naar: ".htmlspecialchars($row['name'])."</a><br><br>";
tabel_einde();
page_einde();
site_footer();

function dltable($name, $arr, $torrent)
	{
	global $CURUSER;
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	if (!count($arr))
		return @$s;
	$s = "<table width=100% class=main border=1 cellspacing=0 cellpadding=5>\n";
	$s .= "<tr><td class=colheadsite>Gebruiker</td>" .
          "<td class=colheadsite align=right>Gedeeld</td>".
          "<td class=colheadsite align=right>Snelheid</td>".
          "<td class=colheadsite align=right>Ontvangen</td>" .
          "<td class=colheadsite align=right>Snelheid</td>" .
          "<td class=colheadsite align=right>Ratio</td>" .
          "<td class=colheadsite align=right>Kompleet</td>" .
          "<td class=colheadsite align=left>Programma</td></tr>\n";
	$now = time();
	$moderator = (isset($CURUSER) && get_user_class() >= UC_ADMINISTRATOR);
	$mod = get_user_class() >= UC_MODERATOR;
	foreach ($arr as $e) {


	$userid = $e['userid'];
	$torrentid = $torrent['id'];
	$ressite =  mysqli_query($con_link, "SELECT * FROM downup WHERE user='" . $userid . "' AND torrent='" . $torrentid . "'") or sqlerr(__FILE__, __LINE__);
	$rowsite = mysqli_fetch_array($ressite);
    if ($rowsite["downloaded"] > 0)
    {
      	$ratiosite = number_format($rowsite["uploaded"] / $rowsite["downloaded"], 2);
      	$ratiosite = "<font color=" . get_ratio_color($ratiosite) . ">$ratiosite</font>";
		if ($rowsite["uploaded"] / $rowsite["downloaded"] > 20) $ratiosite = "<center><img border=0 src=pic/oneindig.gif></center>";
    }
    else
      if ($rowsite["uploaded"] > 0)
        $ratiorhc = "<center><img border=0 src=pic/oneindig.gif></center>";
      else
        $ratiosite = "---";

	if ($rowsite["downloaded"] == 0) $ratiosite = "<center><img border=0 src=pic/oneindig.gif></center>";

	if ($rowsite)
		$uploaded = str_replace(" ", "&nbsp;", mksize($rowsite["uploaded"]));
	else
		$uploaded = "onbekend";
	if ($rowsite)
		$downloaded = str_replace(" ", "&nbsp;", mksize($rowsite["downloaded"]));
	else
		$downloaded = "onbekend";

                // user/ip/port
                // check if anyone has this ip
                ($unr = mysqli_query($con_link, "SELECT username, warned, donor, privacy FROM users WHERE id=$e[userid] ORDER BY last_access DESC LIMIT 1")) or die;
                $una = mysqli_fetch_array($unr);
				if ($una["privacy"] == "strong") continue;
				$s .= "<tr>\n";
				if ($una["warned"] == "yes")
					$warned = " <img src=/pic/warned.gif border=0>";
				else
					$warned = "";
				if ($una["donor"] == "yes")
					$donor = " <img border=0 src=pic/system/star.gif>";
				else
					$donor = "";
                if ($una["username"]) {
				$ratiotmp = get_userratio($e['userid']);
//                  $s .= "<td bgcolor=white><b>$una[username]</b>&nbsp;$ratiotmp$donor$warned</td>\n";
                  $s .= "<td bgcolor=white><a class=altlink_blue href=userdetails.php?id=$e[userid]><b>$una[username]</b>&nbsp;$ratiotmp$donor$warned</a></td>\n";
				 } 
                else
                  $s .= "<td>" . ($mod ? $e["ip"] : preg_replace('/\.\d+$/', ".xxx", $e["ip"])) . "</td>\n";
		$secs = max(1, ($now - $e["st"]) - ($now - $e["la"]));
		$revived = @$e["revived"] == "yes";
		$s .= "<td bgcolor=white align=right>" . str_replace(" ","&nbsp;",$uploaded) . "</td>\n";
		$s .= "<td bgcolor=white align=right><nobr>" . str_replace(" ","&nbsp;",mksize(($e["uploaded"] - $e["uploadoffset"]) / $secs)) . "/s</nobr></td>\n";
		$s .= "<td bgcolor=white align=right>" . $downloaded . "</td>\n";
		if ($e["seeder"] == "no")
			$s .= "<td bgcolor=white align=right><nobr>" . mksize(($e["downloaded"] - $e["downloadoffset"]) / $secs) . "/s</nobr></td>\n";
		else
			$s .= "<td bgcolor=white align=right><nobr>" . mksize(($e["downloaded"] - $e["downloadoffset"]) / max(1, $e["finishedat"] - $e['st'])) .	"/s</nobr></td>\n";
		$s .= "<td bgcolor=white align=right>$ratiosite</td>\n";
		$s .= "<td bgcolor=white align=right>" . sprintf("%.2f%%", 100 * (1 - ($e["to_go"] / $torrent["size"]))) . "</td>\n";
		$s .= "<td bgcolor=white align=left>" . htmlspecialchars(getagent($e["agent"], $e["peer_id"])) . "</td>\n";
		$s .= "</tr>\n";
	}
	$s .= "</table>\n";
	return $s;
	}

function getagent($httpagent, $peer_id)
	{
	if (substr($peer_id,1,2) == "BC")
		return "BitComet" . " " . substr($peer_id,4,1) . "." . substr($peer_id,5,2);
	elseif (substr($peer_id,0,4) == "exbc")
		return "BitComet oude versie";
	else
		return ($httpagent != "" ? $httpagent : "---");
	}

?>