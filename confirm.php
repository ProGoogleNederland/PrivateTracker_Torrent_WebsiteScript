<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
$id = 0 + $_GET["id"];
$md5 = @$_GET["secret"];

if (!$id)
	httperr();

dbconn();

$res = mysqli_query($con_link, "SELECT passhash, editsecret, status FROM users WHERE id = $id");
$row = mysqli_fetch_array($res);

if (!$row)
	httperr();

if ($row["status"] != "pending") {
	header("Refresh: 0; url=../../ok.php?type=confirmed");
	exit();
}

$sec = $row["editsecret"];
if ($md5 != md5($sec))
	httperr();

mysqli_query($con_link, "UPDATE users SET status='confirmed', editsecret='' WHERE id=$id AND status='pending'");

if (!mysqli_affected_rows($con_link))
	httperr();

logincookie($id, $row["passhash"]);

header("Refresh: 0; url=../../ok.php?type=confirm");
?>