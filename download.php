<?php
ob_start("ob_gzhandler");
require_once("include/bittorrent.php");
require_once("include/benc.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();

$id = @$_GET["id"];
$id = 0 + $id;
if (!isset($id) || !$id)
	die();

$res = mysqli_query($con_link, "SELECT filename FROM torrents WHERE id = $id");
$row = mysqli_fetch_array($res);

$fn = $torrent_dir . "/" . $row['filename'];

if (!$row || !is_file($fn) || !is_readable($fn))
	site_error_message("Foutmelding", "Het is niet mogelijk deze torrent te downloaden, omdat het torrent bestand beschadigd is.");

if ($CURUSER['blocked'] == "yes")
	site_error_message("Foutmelding", "Uw account is geblokkeerd, u kunt nu niets downloaden.");

//mysqli_query($con_link, "UPDATE torrents SET hits = hits + 1 WHERE id = $id");


//////////////////////////////////////////////////////////////
//header("Content-Type: application/x-bittorrent");
//readfile($fn);


if (strlen($CURUSER['passkey']) != 32) {
	$CURUSER['passkey'] = md5($CURUSER['username'].get_date_time().$CURUSER['passhash']);
	mysqli_query($con_link, "UPDATE users SET passkey='$CURUSER[passkey]' WHERE id=$CURUSER[id]");
	}

$dict = bdec_file($fn, (1024*1024));
$dict['value']['announce']['value'] = "$BASEURL/announce.php?passkey=$CURUSER[passkey]";
$dict['value']['announce']['string'] = strlen($dict['value']['announce']['value']).":".$dict['value']['announce']['value'];
$dict['value']['announce']['strlen'] = strlen($dict['value']['announce']['string']);

header("Content-Type: application/x-bittorrent");
if (str_replace("Gecko", "", $_SERVER['HTTP_USER_AGENT']) != $_SERVER['HTTP_USER_AGENT']) {
    header('Content-Disposition: attachment; filename="'.$row["filename"]. '.torrent');
} elseif (str_replace("Firefox", "", $_SERVER['HTTP_USER_AGENT']) != $_SERVER['HTTP_USER_AGENT']) {
    header('Content-Disposition: attachment; filename="'.$row["filename"]. '.torrent');
} elseif (str_replace("Opera", "", $_SERVER['HTTP_USER_AGENT']) != $_SERVER['HTTP_USER_AGENT']) {
    header('Content-Disposition: attachment; filename="'.$row["filename"]. '.torrent');
} elseif (str_replace("IE", "", $_SERVER['HTTP_USER_AGENT']) != $_SERVER['HTTP_USER_AGENT']) {
    header('Content-Disposition: attachment; filename=" . str_replace("+", "%20", rawurlencode(". $row["filename"] .".torrent"))');
} else {
    header('Content-Disposition: attachment; filename=" . str_replace("+", "%20", rawurlencode(". $row["filename"] .".torrent"))');
}
print(benc($dict));

////////////////////////////////////////////////////////////////
	?>