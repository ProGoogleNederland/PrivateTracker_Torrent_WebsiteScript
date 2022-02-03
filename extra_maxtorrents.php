<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_OWNER)
	site_error_message("Foutmelding", "U ben niet bevoegd om deze pagina te bekijken.");

$user_id = (int)@$_GET['user_id'];

if (!$user_id)
	site_error_message("Foutmelding", "Geen gebruikers ID ontvangen.");

$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);

$action = (string)@$_GET['action'];

if ($action == "wijzig")
	{
	$ammount = (int)@$_GET['ammount'];
	
	if ($ammount < 0)
		site_error_message("Foutmelding", "Extra maxtorrents is lager dan 0, kan niet verwerkt worden.");
	if ($ammount > 999)
		site_error_message("Foutmelding", "Extra maxtorrents is hoger dan 999, kan niet verwerkt worden.");
	$sender = $CURUSER['id'];
	
	$message = "Hallo " . get_username($user_id) . ",\n\n";
	if ($ammount == 0)
		$message .= "Uw heeft geen extra maxtorrents meer per ".convertdatum(get_date_time())."\n\n";
	else
		$message .= "Uw maxtorrents is met ".$ammount." extra verhoogd door ".get_username($sender)." op ".convertdatum(get_date_time())."\n\n";
	$message .= "Met vriendelijke groet,\n";
	$message .= $CURUSER['username'];

	site_send_message($user_id,$sender,$message,false);

	mysqli_query($con_link, "UPDATE users SET maxtorrents_extra = $ammount WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);

	set_max_torrents($user_id);
	
	header("Refresh: 0; url=userdetails.php?id=" . $user_id);
	}

site_header("Maxtorrents");
page_start();
tabel_top("Maxtorrents verhogen van " . get_username($user_id),"center");
tabel_start();

print "<table class=bottom><tr><td class=embedded>";
print "<form method=get action=''>";
print "<input type=hidden name=user_id value=" . $user_id . ">";
print "<input type=hidden name=action value=wijzig>";
print "<input maxlength=2 type=text size=2 style='font-weight: bold; font-size: 12pt' name=ammount value='".$row['maxtorrents_extra']."'>";
print "</td><td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
print "<input type=submit style='font-weight: bold;height: 28px;width: 300px' value='Extra maxtorrents geven' class=btn>";
print "</form>";
print "</td></tr></table>";
print "<br></td></tr></table>";

tabel_einde();
site_footer();
?>
