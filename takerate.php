<?php

require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);


dbconn();



function bark($msg) {
	genbark($msg, "Rating failed!");
}

if (!isset($CURUSER))
	bark("Must be logged in to vote");

if (!mkglobal("rating:id"))
	bark("missing form data");

$id = 0 + $id;
if (!$id)
	bark("invalid id");

$rating = 0 + $rating;
if ($rating <= 0 || $rating > 5)
	bark("invalid rating");

$res = mysqli_query($con_link, "SELECT owner FROM torrents WHERE id = $id");
$row = mysqli_fetch_array($res);
if (!$row)
	bark("no such torrent");

//if ($row["owner"] == $CURUSER["id"])
//	bark("You can't vote on your own torrents.");

$res = mysqli_query($con_link, "INSERT INTO ratings (torrent, user, rating, added) VALUES ($id, " . $CURUSER["id"] . ", $rating, NOW())");
if (!$res) {
	if (mysqli_errno() == 1062)
		bark("You have already rated this torrent.");
	else
		bark(mysqli_error());
}

mysqli_query($con_link, "UPDATE torrents SET numratings = numratings + 1, ratingsum = ratingsum + $rating WHERE id = $id");

header("Refresh: 0; url=details.php?id=$id&rated=1");



?>
