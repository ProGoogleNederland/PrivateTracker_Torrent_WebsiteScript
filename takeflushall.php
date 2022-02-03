<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() >= UC_OWNER)
{
$deadtime = deadtime();
mysqli_query($con_link, "DELETE FROM peers WHERE last_action < FROM_UNIXTIME($deadtime)");
$effected = @mysqli_affected_rows($con_link);

site_error_message('OK', "$effected ghost torrent" . ($effected ? 's' : '') . ' zijn succesvol verwijdert.');
}

?>
