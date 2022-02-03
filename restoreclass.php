<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

mysqli_query($con_link, "UPDATE users SET override_class = 255 WHERE id = ".$CURUSER['id']);

header("Location: $BASEURL/index.php");
die();
?>
