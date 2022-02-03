<?php
require_once "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
global $HTTP_SERVER_VARS;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();
 
 //if (@$HTTP_SERVER_VARS["REQUEST_METHOD"] != "POST")
 //  stdmsg("Error", "Metodo");

   

@noaccess(UC_SYSOP,MASSPM,$CURUSER['id'],$CURUSER['username']);

$sender_id = (@$_POST['sender'] == 'system' ? 0 : $CURUSER['id']);
$dt = sqlesc(get_date_time());
$msg = @$_POST['msg'];
//var_dump($msg);
if (!$msg)
stdmsg("Error","Je moet een bericht invullen!");

$updateset = @$_POST['clases'];
$subject = @$_POST['subject'];

$query = @mysqli_query($con_link, "SELECT id FROM users WHERE class IN (".implode(",", $updateset).")");
while($dat = @mysqli_fetch_assoc($query))
{
mysqli_query($con_link, "INSERT INTO messages (sender, receiver, added, subject, msg) VALUES ($sender_id, $dat[id], '" . get_date_time() . "',  " . sqlesc($msg) .", " . sqlesc($msg) .")") or sqlerr(__FILE__,__LINE__);
}

//header("Refresh: 0; url=staffmess.php");
header("Refresh: 0; url=inbox.php?staffmess");


?>
