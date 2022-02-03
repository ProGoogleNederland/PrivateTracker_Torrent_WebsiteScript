<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
$id = (int)@$_GET["id"];
if (!is_numeric($id) || $id < 1 || floor($id) != $id)
	die;

$type = @$_GET["type"];

dbconn(false);
loggedinorreturn();
if ($type == 'in')
  {
  	// make sure message is in CURUSER's Inbox
	  $res = mysqli_query($con_link, "SELECT receiver, location FROM messages WHERE id=" . sqlesc($id)) or die("barf");
	  $arr = mysqli_fetch_array($res) or die("Bad message ID");
	  if ($arr["receiver"] != $CURUSER["id"])
	    die("I wouldn't do that if i were you...");
    if ($arr["location"] == 'in')
	  	mysqli_query($con_link, "DELETE FROM messages WHERE id=" . sqlesc($id)) or die('delete failed (error code 1).. this should never happen, contact an admin.');
    else if ($arr["location"] == 'both')
			mysqli_query($con_link, "UPDATE messages SET location = 'out' WHERE id=" . sqlesc($id)) or die('delete failed (error code 2).. this should never happen, contact an admin.');
    else
    	die('The message is not in your Inbox.');
  }
	elseif ($type == 'out')
  {
   	// make sure message is in CURUSER's Sentbox
	  $res = mysqli_query($con_link, "SELECT sender, location FROM messages WHERE id=" . sqlesc($id)) or die("barf");
	  $arr = mysqli_fetch_array($res) or die("Bad message ID");
	  if ($arr["sender"] != $CURUSER["id"])
	    die("I wouldn't do that if i were you...");
    if ($arr["location"] == 'out')
	  	mysqli_query($con_link, "DELETE FROM messages WHERE id=" . sqlesc($id)) or die('delete failed (error code 3).. this should never happen, contact an admin.');
    else if ($arr["location"] == 'both')
			mysqli_query($con_link, "UPDATE messages SET location = 'in' WHERE id=" . sqlesc($id)) or die('delete failed (error code 4).. this should never happen, contact an admin.');
    else
    	die('The message is not in your Sentbox.');
  }
  else
  	die('Unknown PM type.');

//mysqli_query($con_link, "OPTIMIZE TABLE messages") or sqlerr(__FILE__, __LINE__);

header("Location: $BASEURL/inbox.php".($type == 'out'?"?out=1":""));
?>