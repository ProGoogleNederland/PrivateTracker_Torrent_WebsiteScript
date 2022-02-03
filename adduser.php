<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

//site_error_message("Foutmelding", "Deze optie is uitgeschakeld, gebruik uw uitnodigingen hiervoor.");


if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "Toegang geweigerd.");
	
if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
	if ($_POST["username"] == "" || $_POST["password"] == "" || $_POST["email"] == "")
		site_error_message("Foutmelding", "Formulier gegevens ontbreken.");
	if ($_POST["password"] != @$_POST["password2"])
		site_error_message("Foutmelding", "Fout wachtwoord.");
	$username = sqlesc($_POST["username"]);

	$email = sqlesc($_POST["email"]);


	$password = @$_POST["password"];
	$secret = mksecret();
	$passhash = sqlesc(md5($secret . $password . $secret));
	$secret = sqlesc($secret);
	
	
	
	mysqli_query($con_link, "INSERT INTO users (added, last_access, secret, username, passhash, status, email) VALUES(NOW(), NOW(), $secret, $username, $passhash, 'confirmed', $email)") or sqlerr(__FILE__, __LINE__);
	$user_id = mysqli_insert_id($con_link);
	header("Location: $BASEURL/userdetails.php?id=$user_id");
	die;
	}
site_header("Gebruiker toevoegen");tabel_start();
print("<table width=40% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
tabel_top("Gebruiker toevoegen");
print("<table width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td class=embedded align=center><center><br>");

?>

<form method=post action=adduser.php>
<table border=1 cellspacing=0 cellpadding=5>
<tr><td bgcolor=white class=rowhead>Gebruikersnaam</td><td bgcolor=white><input type=text name=username maxlength="12" size=40></td></tr>
<tr><td bgcolor=white class=rowhead>Wachtwoord</td><td bgcolor=white><input type=password name=password maxlength="40" size=40></td></tr>
<tr><td bgcolor=white class=rowhead>Nogmaals wachtwoord</td><td bgcolor=white><input type=password maxlength="40" name=password2 size=40></td></tr>
<tr><td bgcolor=white class=rowhead>E-mailadres</td><td bgcolor=white><input type=text name=email size=40></td></tr>
<tr><td bgcolor=white colspan=2 align=right><input type=submit value="Gegevens opslaan" style='height: 30px;width: 150px' class=btn></td></tr>
</table>
</form>
<br>
<?
print("</td></tr></table>");
print("<br></td></tr></table>");
tabel_einde();

site_footer();
?>