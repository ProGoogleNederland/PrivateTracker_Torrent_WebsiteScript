 <?php
require_once "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();
function puke($text = "w00t")
{
//stderr("w00t", $text);
}
if (get_user_class() < UC_SYSOP)
puke();

$sql = mysqli_query($con_link, 'TRUNCATE TABLE `antiddos`');
$sql = mysqli_query($con_link, 'TRUNCATE TABLE `ip_logboek`');
echo "Anti ddos en iplogboek is leeggemaakt! Druk de terug knop links bovenin jouw browser :) ";

puke();
?>