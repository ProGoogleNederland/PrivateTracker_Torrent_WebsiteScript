<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
if (!mkglobal("username:password"))
	die();
dbconn();

function bark($text = "Gebruikersnaam of wachtwoord fout")
{
	$ip = getip();
	$gebruikersnaam = @$_POST['username'];
	$wachtwoord = @$_POST['password'];
	$log_msg = "Have a member login with username ".  @$_POST['username'] . ' and IP '.$_SERVER['REMOTE_ADDR'];
	write_log_login($log_msg);
	site_error_message("Aanmelden mislukt!", $text);

//	write_log_login("Aanmelden mislukt! with Gebruikersnaam". $gebruikersnaam. 'and IP'.$_SERVER['REMOTE_ADDR']);
}

$res = mysqli_query($con_link, "SELECT id, passhash, secret, enabled FROM users WHERE username = " . sqlesc($username) . " AND status = 'confirmed'");
$row = mysqli_fetch_array($res);
$sec = $PASSWORD_HASH;
if (!$row)
	//var_dump("Aanmelden mislukt! with Gebruikersnaam".  @$_POST['username'] . 'and IP'.$_SERVER['REMOTE_ADDR']);
	bark();

if ($row["passhash"] != md5($sec. $password . $sec))
	
	bark();

if ($row["enabled"] == "no")
	bark("Deze registratie is Geblokkeerd.");

logincookie($row["id"], $row["passhash"]);

if (!empty($_POST["returnto"]))
	header("Location: $BASEURL$_POST[returnto]");
else
	header("Location: $BASEURL/index.php");
?>