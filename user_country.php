<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "U ben niet bevoegd om deze pagina te bekijken.");

$extra = "";
$user_id = 0 + $_GET['user_id'];

$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);

if (!$row)
	site_error_message("Foutmelding", "Geen gebruiker gevonden met dit id.");

$country = $row['country'];

$action = @$_GET['action'];

if ($action == "send")
	{
	$country = @$_GET['country'];

	if (!$country)
		site_error_message("Foutmelding", "Geen gegevens ontvangen om te gebruiken.");

	mysqli_query($con_link, "UPDATE users SET country = $country WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	header("Location: $BASEURL/userdetails.php?id=$user_id");
	}

site_header("Land");
page_start();
tabel_top("Land aanpassen voor <a class=altlink_yellow href=userdetails.php?id=".$user_id.">" . get_usernamesite($user_id) . "</a>","center");
tabel_start();
print "<table class=bottom width=40% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded>";

print "<form method=get action=''>";
print "<input type=hidden name=action value=send>";
print "<input type=hidden name=user_id value=" . $user_id . ">";
print "<tr>";
print "<td class=colheadsite>Kies een Land</td>";
print "</tr>";
print "<tr>";
print "<td bgcolor=white align=center>";

$countries = "<option value=0>---Niets geselecteerd ---</option>";
$res = mysqli_query($con_link, "SELECT id,name FROM countries ORDER BY name") or die;
while ($row = mysqli_fetch_array($res))
	$countries .= "<option value=$row[id]" . ($country == $row['id'] ? " selected" : "") . ">$row[name]</option>";
print "<br><select name=country>\n$countries\n</select>";

print "</td>";
print "</tr>";

print "<tr><td bgcolor=white align=center><input type=submit style='height: 24px;width: 150px' value='Gegevens opslaan'></td></tr>";
print "</form>";

print "<br></td></tr></table>";
tabel_einde();
page_einde();
site_footer();
?>
