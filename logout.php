<?php
require_once("include/bittorrent.php");
dbconn();

logoutcookie();

//header("Refresh: 0; url=./");
header("Location: $BASEURL/");
?>
