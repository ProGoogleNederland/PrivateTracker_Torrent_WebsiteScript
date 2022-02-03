<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_OWNER)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de systeembeheeders.");

$user_id = @$_GET['user_id'];
if (!$user_id)
	site_error_message("Foutmelding", "Geen gebruikers ID ontvangen.");

$action = @$_GET['action'];

if ($action == "wijzigen")
	{
	$datum = @$_GET["datum"];
	if (!$datum)
		site_error_message("Foutmelding", "Geen datum gevonden om te gebruiken.");
	else
		{
		$datum = sqlesc($datum);
		mysqli_query($con_link, "UPDATE users SET donor_until=$datum WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
		header("Refresh: 0; url=userdetails.php?id=".$user_id);
		}
	}

$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);

$until = $row['donor_until'];

site_header("Donatie gegevens");
page_start(50);
tabel_top("Donatie datum aanpassen van " . get_username($user_id),"center");
tabel_start();

print  "<form name=invoer method=get action=''>";
print  "<input type=hidden name='user_id' value='$user_id'>";
print  "<input type=hidden name='action' value='wijzigen'>";

print "<input type=text size=12 name=datum value=\"" . htmlspecialchars(substr($until,0,10)) . "\">";

?>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript">
<!--
document.invoer.datum.focus();
//-->
</script>
<?php

print "<input type=submit style='height: 24px;width: 150px' value='Verwerk gegevens'>";
print "</form>";
tabel_einde();
page_einde();
site_footer();
?>