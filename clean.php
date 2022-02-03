<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
if (get_user_class() < UC_SYSOP)
dbconn();
$res = mysqli_query($con_link, "SELECT id,torrent FROM peers") or sqlerr();
$n = 0;
while ($arr =  mysqli_fetch_assoc($res))
{
  $res2 = mysqli_query($con_link, "SELECT id FROM torrents WHERE id=" . $arr["torrent"]) or sqlerr();
  if (mysqli_num_rows($res2) == 0)
    ++$n;
}
print "" . $n . " torrents zijn er verwijderd (zonder seeds)! Druk de terug knop links bovenin jouw browser :) ";

?>