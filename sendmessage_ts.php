<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

$action = (string)@$_POST['action'];
$stuur_naar = 3;

if ($action == "save_new")
	{
	$user_to = 3;
	$user_from = $CURUSER['id'];
	$message = (string)@$_POST['message'];
	$message = sqlesc($message);
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, added, msg, poster) VALUES ($user_from, $user_to, NOW(), $message, 0)") or sqlerr(__FILE__, __LINE__);
	$returnto = "$BASEURL/donatie.php";
	header("Location: $returnto");
	}

$message = "Vul onderstaand formulier volledig in en u aanvraag wordt zo spoedig mogelijk beantwoord.\n";
$message .= "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
$message .= "Gewenste bedrag :\n";
$message .= "Account naam :\n";
$message .= "Bank naam :\n";
$message .= "Uw persoonlijk media verzoek :\n";
$message .= "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
$message .= "Eventuele opmerking hieronder graag:\n";

site_header("Bericht versturen");
page_start(98);
tabel_start();

print "<font color=white size=6><b>U ontvangt binnen 24 uur een betaal link in uw Postvak IN.<br>";
print "<font color=white size=2><b>Alleen vragen met betrekking over een donatie worden behandeld.<br><br>";
print "<font color=white size=2><b>Voor andere vragen kunt u terecht op de staf pagina.<br><br>";

print "<table width=1% border=1 cellspacing=0 cellpadding=5>";
print "<form name=hd_new method=post action=sendmessage_ts.php>";
print "<input type=hidden name=action value=save_new>";
print "<tr><td bgcolor=white><textarea name=message cols=125 rows=15>".htmlspecialchars($message)."</textarea></td></tr>";
print "<tr><td bgcolor=white align=center><input type=submit class=btn style='height: 32px; width: 400px;font-weight: bold;color:blue' value='Verstuur bericht aan  betaalafdeling'></td></tr>";
print "</table>";
print "</form>";

tabel_einde();
page_einde();
site_footer();
?>