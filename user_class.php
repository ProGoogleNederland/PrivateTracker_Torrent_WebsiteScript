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
$user_id = (int)@$_GET['user_id'];

$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);

if (!$row)
	site_error_message("Foutmelding", "Geen gebruiker gevonden met dit id.");

if ($row['class'] >= $CURUSER['class'])
	site_error_message("Foutmelding", "U ben niet bevoegd om deze te wijzigen.");

$class = $row['class'];

$action = @$_GET['action'];

if ($action == "send")
	{
	$class_new = @$_GET['class_new'];

	if ($class_new < 0)
		site_error_message("Foutmelding", "Geen gegevens ontvangen om te gebruiken.");

	if ($class_new >= $CURUSER['class'])
		site_error_message("Foutmelding", "Deze optie is niet mogelijk.");

	$class_old = $row['class'];
	
	if ($class_old == $class_new)
		site_error_message("Foutmelding", "Deze gebruiker heeft al deze class.");

	$modcomment = $row['modcomment'];

	if ($class_new > $class_old)
		{
		$modcomment = "Op " . convertdatum(gmdate("Y-m-d H:i:s")) . " - Status verhoogd tot " . get_user_class_name($class_new) . " door ".$CURUSER['username'].".\n". $modcomment;
		$msg = sqlesc("Uw status is verhoogd naar '" . get_user_class_name($class_new) . "' door ".$CURUSER['username'].".");
		$message = sqlesc("De status van " . htmlspecialchars(get_username($user_id)) . " is verhoogd naar '" . get_user_class_name($class_new) . "' door ".$CURUSER['username'].".");
		}
	else
		{
		$modcomment = "Op " . convertdatum(gmdate("Y-m-d H:i:s")) . " - Status verlaagd tot " . get_user_class_name($class_new) . " door ".$CURUSER['username'].".\n". $modcomment;
		$msg = sqlesc("Uw status is verlaagd naar '" . get_user_class_name($class_new) . "' door ".$CURUSER['username'].".");
		$message = sqlesc("De status van " . htmlspecialchars(get_username($user_id)) . " is verlaagd naar '" . get_user_class_name($class_new) . "' door ".$CURUSER['username'].".");
		}

	$added = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES(0, $user_id, $msg, $added)") or sqlerr(__FILE__, __LINE__);

	$modcomment = sqlesc($modcomment);

	mysqli_query($con_link, "UPDATE users SET class = $class_new, modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);

	$res7 = mysqli_query($con_link, "SELECT * FROM users WHERE class >= 6 AND class != 7 AND class != 8") or sqlerr(__FILE__, __LINE__);
	while ($row7 = mysqli_fetch_assoc($res7))
		{
		site_send_message($row7['id'],0,$message);
		}


	header("Location: $BASEURL/userdetails.php?id=$user_id");
	}

site_header("Status");
page_start();
tabel_top("Status aanpassen voor <a class=altlink_yellow href=userdetails.php?id=".$user_id.">" . get_usernamesite($user_id) . "</a>","center");
tabel_start();
print "<table class=bottom width=40% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded>";

print "<form method=get action=''>";
print "<input type=hidden name=action value=send>";
print "<input type=hidden name=user_id value=" . $user_id . ">";
print "<tr>";
print "<td class=colheadsite>Kies de gewenste status</td>";
print "</tr>";
print "<tr>";
print "<td bgcolor=white align=center>";

$classes = "";

$maxclass = get_user_class() - 1;

for ($i = 0; $i <= $maxclass; ++$i)
	$classes .= "<option value=$i" . ($row["class"] == $i ? " selected" : "") . ">".@$prefix. get_user_class_name($i);
$classes .= "</select></td></tr>";

print "<br><select name=class_new>\n$classes\n</select>";

print "</td>";
print "</tr>";

print "<tr><td bgcolor=white align=center><input type=submit style='height: 24px;width: 150px' value='Gegevens opslaan'></td></tr>";
print "</form>";

print "<br></td></tr></table>";
tabel_einde();
page_einde();
site_footer();
?>
