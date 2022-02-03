<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);


dbconn();



function bark($msg) {
	genbark($msg, "Foutmelding!");
}

loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "Toegang geweigerd.");

$id = @$_GET["id"];
$id = 0 + $id;
if (!$id)
	bark("Fout ID nummer $id");

mysqli_query($con_link, "UPDATE users SET status='confirmed', editsecret='' WHERE id=$id AND status='pending'");

header("Refresh: 0; url=usersearch.php");



?>