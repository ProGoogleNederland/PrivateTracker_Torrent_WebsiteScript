<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

if (get_user_class() < UC_MODERATOR)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de moderators en hoger.");

$action = $_GET['action'];
$stuur_naar = 0 + $_GET['stuur_naar'];
$msg_id = 0 + $_GET['msg_id'];

if ($action == "save_new")
	{
	$user_to = 0 + $_GET['user_to'];
	$user_from = 0 + $_GET['user_from'];
	$message = $_GET['message'];
	$message = sqlesc($message);
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, added, msg, poster) VALUES ($user_from, $user_to, NOW(), $message, 0)") or sqlerr(__FILE__, __LINE__);
	$returnto = "$BASEURL/deletemessage.php?id=".$msg_id."&type=in";
	header("Location: $returnto");
	}

$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$stuur_naar") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);
if (!$row)
	site_error_message("Foutmelding", "Gebruiker niet gevonden.");

$res2 = mysqli_query($con_link, "SELECT * FROM messages WHERE id=$msg_id") or sqlerr(__FILE__, __LINE__);
$row2 = mysqli_fetch_array($res2);
if (!$row2)
	site_error_message("Foutmelding", "Bericht niet gevonden.");


$message = "Het orginele bericht bericht was verzonden aan ".get_username($CURUSER['id'])." op ".convertdatum($row2['added'])."\n\nInhoud bericht:\n--------------------------------------------------\n" . $row2['msg'];

site_header("Helpdesk");
page_start(98);
tabel_top("Bericht doorsturen","center");
tabel_start();
print "<font color=lightblue size=2><b>Bericht van <font color=yellow>".get_username($row2['sender'])."</font> doorsturen aan <font color=yellow>".get_username($row['id'])."</font>.</font>";
print "<br>";

print "<table width=70% border=1 cellspacing=0 cellpadding=5>";
print "<form name=hd_new method=get action=sendmessage_fw.php>";
print "<input type=hidden name=action value=save_new>";
print  "<input type=hidden name=msg_id value=".$msg_id.">";
print  "<input type=hidden name=user_to value=".$row['id'].">";
print  "<input type=hidden name=user_from value=".$row2['sender'].">";
print "<tr><td bgcolor=white><textarea name=message cols=125 rows=15>".htmlspecialchars($message)."</textarea></td></tr>";
print "<tr><td bgcolor=white align=center><input type=submit class=btn style='height: 25px; width: 120px' value='Versturen'></td></tr>";
print "</table>";
print "</form>";

?>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript">
<!--
document.hd_new.message.focus();
//-->
</script>
<?
tabel_einde();
page_einde();
site_footer();
?>