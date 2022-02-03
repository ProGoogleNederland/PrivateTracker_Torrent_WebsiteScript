<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
if (get_user_class() < UC_ADMINISTRATOR) die;
$id = 0 + $_GET["id"];
if (!$id) die;
@mysqli_query($con_link, "DELETE FROM comments WHERE id=$id") or sqlerr(__FILE__, __LINE__);

$referer = $_SERVER["HTTP_REFERER"];

if ($referer)
	header("Location: $referer");
else
	header("Location: $BASEURL/");


?>