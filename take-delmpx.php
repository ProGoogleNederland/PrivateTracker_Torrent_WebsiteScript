<?php
require_once('include/bittorrent.php');
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if(isset($_POST["delmp"])) {
mysqli_query($con_link, "DELETE FROM messages WHERE id IN (" . implode(", ", $_POST['delmp']) . ")");
//$res=mysqli_query($do);
}
header("Refresh: 0; url=/inbox.php");
?>