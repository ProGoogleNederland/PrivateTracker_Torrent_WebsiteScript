<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
function bark($msg) {
genbark($msg, "Bedankplaatje is op deze torrent mislukt.");
}
$id = @$_POST["id"];
if (!isset($CURUSER))
bark("U dient te zijn aangemeld om te kunnen bedanken voor deze torrent.");
if ($id == "")
bark("Gegevens ontbreken. $id");
$id = 0 + $id;
if (!$id)
bark("Ongeldig id");
$res = mysqli_query($con_link, "SELECT owner FROM torrents WHERE id = $id");
$row = mysqli_fetch_array($res);
if (!$row)
bark("Torrent niet gevonden");
if (@$row["user"] == $CURUSER["id"])
bark("U kunt niet bedanken voor uw eigen torrents.");
if ($CURUSER["bedanktplaat"])
$bd = "[img=" . $CURUSER["bedanktplaat"] . "]";
else
$bd = "[img=pic/default_bedankje.gif]";
$text = $bd;
$torrent_id = $id;
$sender_id = $CURUSER['id'];
$res = mysqli_query($con_link, "INSERT INTO comments (user, torrent, added, text, ori_text) VALUES (" .
	      $sender_id . ",$torrent_id, '" . get_date_time() . "', " . sqlesc($text) .
	       "," . sqlesc($text) . ")");
             mysqli_query($con_link, "UPDATE torrents SET comments = comments + 1 WHERE id = $torrent_id");
if (!$res) {
if (mysqli_errno($con_link) == 1062)
bark("U heeft al bedankt voor deze torrent.");
else
bark(mysqli_error($con_link));
}
header("Refresh: 0; url=details.php?id=$id");
?>