<?php
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
if ("text/html, */*" == $_SERVER["HTTP_ACCEPT"] || "Close" == $_SERVER["HTTP_CONNECTION"] && "gzip, deflate" != $_SERVER["HTTP_ACCEPT_ENCODING"])
	{
	$u = mysqli_fetch_assoc(mysqli_query($con_link, "SELECT id, username FROM users WHERE id=".$userid));
	$dt = sqlesc(get_date_time());

	$msg = sqlesc("You have been logged for trying to cheat!");
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, added, msg, poster) VALUES(0, 1, $dt, $msg, 0)");
//	mysql_query("INSERT INTO messages (sender, receiver, added, msg, poster) VALUES(0, $userid, $dt, $msg, 0)") or sqlerr(__FILE__, __LINE__);

//	write_log("User ".$userid." (".$u["username"].") was logged for trying to cheat.");
//	benc_resp_raw("You have been logged for trying to cheat");

//	$ip = getip();
//	$subject = sqlesc("Fake upload - $ip");
//	$body = sqlesc("User ".$userid." (".$u["username"].") has been detected trying to cheat using a fake maker.\n\n His IP address is $ip.");
//	auto_post( $subject , $body );
	}

?>