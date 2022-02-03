<?php
require_once("include/benc.php");
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
ini_set("upload_max_filesize",$max_torrent_size);

function bark($msg)
	{
	site_error_message("Foutmelding", "Uploaden mislukt. (".$msg.")");
	}

dbconn();
loggedinorreturn();

if (get_user_class() < UC_UPLOADER)
	site_error_message("Foutmelding", "U heeft hier geen rechten.");

foreach(explode(":","descr:imdb:type:name") as $v) {
	if (!isset($_POST[$v]))
		site_error_message("Foutmelding", "Gegevens ontbreken.");
		
}

if (!isset($_FILES["file"]))
	site_error_message("Foutmelding", "Gegevens ontbreken.");

$f = $_FILES["file"];
$fname = unesc($f["name"]);
if (empty($fname))
	site_error_message("Foutmelding", "Bestandsnaam is leeg.");

$descr = unesc($_POST["descr"]);
if (!$descr)
	site_error_message("Foutmelding", "Geen omschrijving ontvangen.");

$imdb = unesc($_POST["imdb"]);
if (!$imdb)
	site_error_message("Foutmelding", "Geen omschrijving ontvangen.");

$catid = (0 + $_POST["type"]);
if (!is_valid_id($catid))
	site_error_message("Foutmelding", "Geen groep ontvangen.");

if (!validfilename($fname))
	site_error_message("Foutmelding", "Ongeldige bestandsnaam.");
if (!preg_match('/^(.+)\.torrent$/si', $fname, $matches))
	site_error_message("Foutmelding", "Ongeldige bestandsnaam. Is geen torrent");
$shortfname = $torrent = $matches[1];
if (!empty($_POST["name"]))
	$torrent = unesc($_POST["name"]);

$tmpname = $f["tmp_name"];
if (!is_uploaded_file($tmpname))
	site_error_message("Foutmelding", "U deed iets niet goed.");
if (!filesize($tmpname))
	site_error_message("Foutmelding", "Leeg bestand ontvangen.");

$dict = bdec_file($tmpname, $max_torrent_size);
if (!isset($dict))
	site_error_message("Foutmelding", "Ongeldige bestandsnaam, dit is geen torrent.");

function dict_check($d, $s) {
	if ($d["type"] != "dictionary")
		bark("not a dictionary");
	$a = explode(":", $s);
	$dd = $d["value"];
	$ret = array();
	foreach ($a as $k) {
		unset($t);
		if (preg_match('/^(.*)\((.*)\)$/', $k, $m)) {
			$k = $m[1];
			$t = $m[2];
		}
		if (!isset($dd[$k]))
			bark("dictionary is missing key(s)");
		if (isset($t)) {
			if ($dd[$k]["type"] != $t)
				bark("invalid entry in dictionary");
			$ret[] = $dd[$k]["value"];
		}
		else
			$ret[] = $dd[$k];
	}
	return $ret;
}

function dict_get($d, $k, $t) {
	if ($d["type"] != "dictionary")
		bark("not a dictionary");
	$dd = $d["value"];
	if (!isset($dd[$k]))
		return;
	$v = $dd[$k];
	if ($v["type"] != $t)
		bark("invalid dictionary entry type");
	return $v["value"];
}

list($ann, $info) = dict_check($dict, "announce(string):info");
list($dname, $plen, $pieces) = dict_check($info, "name(string):piece length(integer):pieces(string)");

$announce_site = $announce_site . "?passkey=" . $CURUSER['passkey'];

if ($ann !== $announce_site)
	site_error_message("Foutmelding", "Ongeldige announce url ontvangen, moet zijn <b>" . $announce_site . "</b>.");

if (strlen($pieces) % 20 != 0)
	site_error_message("Foutmelding", "Aantal bestanden klopt niet.");

$filelist = array();
$totallen = dict_get($info, "length", "integer");
if (isset($totallen)) {
	$filelist[] = array($dname, $totallen);
	$type = "single";
}
else {
	$flist = dict_get($info, "files", "list");
	if (!isset($flist))
		site_error_message("Foutmelding", "Bestanden kloppen niet.");
	if (!count($flist))
		site_error_message("Foutmelding", "Geen bestanden ontvangen.");
	$totallen = 0;
	foreach ($flist as $fn) {
		list($ll, $ff) = dict_check($fn, "length(integer):path(list)");
		$totallen += $ll;
		$ffa = array();
		foreach ($ff as $ffe) {
			if ($ffe["type"] != "string")
				site_error_message("Foutmelding", "Bestandsnaam fout.");
			$ffa[] = $ffe["value"];
		}
		if (!count($ffa))
			site_error_message("Foutmelding", "Bestandsnaam fout.");
		$ffe = implode("/", $ffa);
		$filelist[] = array($ffe, $ll);
	}
	$type = "multi";
}

$infohash = pack("H*", sha1($info["string"]));


// Replace punctuation characters with spaces
$torrent = str_replace("_", " ", $torrent);
$bestand = $fname;

$dht_test = file_get_contents($tmpname);

//////////// Controle dubbele announce ////////////
if (substr_count($dht_test, "announce.php?passkey") > 1 && substr_count($dht_test, ":announce-list") > 0)
	{
	if (function_exists(site_error_message))
		site_error_message("Foutmelding", "Torrent kan niet geplaatst worden, aangezien er meerdere announce URL's in staan.<br><br>Maak de torrent opnieuw, of neem contact op met een Administrator.");
	elseif (function_exists(site_error_message))
		site_error_message("Foutmelding", "Torrent kan niet geplaatst worden, aangezien er meerdere announce URL's in staan.<br><br>Maak de torrent opnieuw, of neem contact op met een Administrator.");
	else
		die("Torrent kan niet geplaatst worden, aangezien er meerdere announce URL's in staan.<br><br>Maak de torrent opnieuw, of neem contact op met een Administrator.");
	}
//////////// Controle dubbele announce ////////////

if (!strstr($dht_test, "privatei1"))
	{
	if (function_exists(site_error_message))
		site_error_message("Foutmelding", "Torrent kan niet geplaatst worden, aangezien DHT nog aan staat.<br><br>Maak de torrent opnieuw.");
	elseif (function_exists(site_error_message))
		site_error_message("Foutmelding", "Torrent kan niet geplaatst worden, aangezien DHT nog aan staat.<br><br>Maak de torrent opnieuw.");
	else
		die("Torrent kan niet geplaatst worden, aangezien DHT nog aan staat.<br><br>Maak de torrent opnieuw.");
	}

$testname = sqlesc($fname);
$res7 = mysqli_query($con_link, "SELECT * FROM torrents WHERE filename=$testname") or sqlerr(__FILE__, __LINE__);
$row7 = mysqli_fetch_array($res7);
if ($row7)
	site_error_message("Foutmelding", "Torrent met deze bestandsnaam wordt reeds gebruikt.");

$ret = mysqli_query($con_link, "INSERT INTO torrents (search_text, filename, owner, visible, info_hash, name, size, numfiles, type, imdb, descr, ori_descr, category, save_as, added, last_action) VALUES (" .
		implode(",", array_map("sqlesc", array(searchfield("$shortfname $dname $torrent"), $fname, $CURUSER["id"], "no", $infohash, $torrent, $totallen, count($filelist), $type, $imdb, $descr, $descr, 0 + $_POST["type"], $dname))) .
		", '" . get_date_time() . "', '" . get_date_time() . "')");
if (!$ret) {
	if (mysqli_errno($con_link) == 1062)
		site_error_message("Foutmelding", "Torrent is al geplaatst.");
	bark("mysql puked: ".mysqli_error());
}
$id = mysqli_insert_id($con_link);

@mysqli_query($con_link, "DELETE FROM files WHERE torrent = $id");
foreach ($filelist as $file) {
	@mysqli_query($con_link, "INSERT INTO files (torrent, filename, size) VALUES ($id, ".sqlesc($file[0]).",".$file[1].")");
}

move_uploaded_file($tmpname, "$torrent_dir/$bestand");

write_log("Torrent $id ($torrent) is geplaatst door " . $CURUSER["username"]);

$res = mysqli_query($con_link, "SELECT name FROM categories WHERE id=$catid") or sqlerr();
$arr = mysqli_fetch_assoc($res);
$cat = $arr["name"];
$res4 = mysqli_query($con_link, "SELECT email FROM users WHERE enabled='yes' AND donor='yes' AND notifs_donor LIKE '%[cat$catid]%' AND notifs_donor LIKE '%[email]%'") or sqlerr();
$uploader = $CURUSER['username'];
$size = mksize($totallen);
$description = (strip_tags($descr));
$imdb = (strip_tags($imdb));

$body = <<<EOD
Er is een nieuwe torrent geplaatst op TorrentMedia.org

Naam: $torrent
Grootte: $size
Groep: $cat
Geplaatst door: $uploader

Omschrijving
-------------------------------------------------------------------------------
$description
-------------------------------------------------------------------------------

U kunt de onderstaande link gebruiken om de torrent te downloaden.
(u dient wel aangemeld te zijn op de site natuurlijk).

$DEFAULTBASEURL/details.php?id=$id&hit=1

--
$SITE_NAME
EOD;

while ($row = mysqli_fetch_assoc($res4))
	{
		$send_to = $row['email'];
		$from_name = "TorrentMedia.org";
		$from_email = "info@torrentmedia.org";
		$from = "$from_name <$from_email>";
//		mail($send_to, "Nieuwe torrent $torrent", $body, "From: $from");
		mail($send_to , "$torrent", $body, "From: ".$SITE_NAME." nieuwe torrent<".$TORRENTEMAIL.">", "-f$TORRENTEMAIL");
	}

header("Location: $BASEURL/details.php?id=$id&uploaded=1");
?>