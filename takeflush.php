<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
function bark($msg) 
{
  site_header();
  stdmsg("Failed", $msg);
  site_footer();
  exit;
}

dbconn();
loggedinorreturn();

$id = 0 + @$_GET['id'];
if (!is_valid_id($id))
 bark("Invalid ID.");

if (get_user_class() >= UC_MODERATOR || $CURUSER['id'] == $id) 
{  
  $deadtime = deadtime(); 
  mysqli_query($con_link, "DELETE FROM peers WHERE last_action < FROM_UNIXTIME($deadtime) AND userid=" . $id);
  $effected = mysqli_affected_rows($con_link);

      
  site_error_message('Success', "$effected ghost torrent" . ($effected ? 's' : '') . 'where sucessfully cleaned.');
}
else
{ 
  bark("You can only clean your own ghost torrents");
}
?>