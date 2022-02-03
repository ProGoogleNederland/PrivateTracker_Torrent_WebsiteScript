<?php

require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();

function bark($msg) {
	genbark($msg, "Bedanken op deze torrent mislukt.");
}

$id = @$_POST["id"];

if (!isset($CURUSER))
	bark("U dient te zijn aangemeld om te kunnen bedanken voor deze torrent.");

if ($id == "")
	bark("Gegevens ontbreken. $id");

$id = 0 + $id;
if (!$id)
	bark("Ongeldig id");

//$rating = 0 + $rating;
//if ($rating <= 0 || $rating > 5)
//	bark("invalid rating");

$res = mysqli_query($con_link, "SELECT owner FROM torrents WHERE id = $id");
$row = mysqli_fetch_array($res);
if (!$row)
	bark("Torrent niet gevonden");

if (@$row["user"] == $CURUSER["id"])
	bark("U kunt niet bedanken voor uw eigen torrents.");

$res = mysqli_query($con_link, "INSERT INTO thankyou (torrent, user, added) VALUES ($id, " . $CURUSER["id"] . ", NOW())");
if (!$res) {
	if (mysqli_errno($con_link) == 1062)
		bark("U heeft al bedankt voor deze torrent.");
	else
		bark(mysqli_error($con_link));
}

header("Refresh: 0; url=details.php?id=$id");
?>
