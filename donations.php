<?php
ob_start("ob_gzhandler");
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_OWNER)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de beheerders.");

site_header("Donaties");


$action = @$_GET["action"];

if ($action == 'remove_all')
	{
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE donor='yes' ORDER BY donor_until") or sqlerr();
	while ($row = mysqli_fetch_assoc($res))
		{
		$days = floor((sql_timestamp_to_unix_timestamp($row['donor_until']) - gmtime()) / (24*3600)) +1;
		if ($days < 0)
			{
			$id = $row["id"];
			if ($row['class'] < 3)
				$class=0;
			else
				$class = $row['class'];
			$message = "Hallo " . get_username($id) . ",\n\n";
			$message .= "Uw donateurschap is verlopen, en uw sterretje is dus ook verwijderd.\n";
			$message .= "Indien u geen stafflid bent wordt u ook terug geplaatst naar 'Normale gebruiker'.\n";
			$message .= "Wij bedanken u nogmaals voor de donatie en hopen dat u dit in de toekomst nogmaals zal doen.\n\n";
			$message .= "Met vriendelijke groet,\n";
			$message .= $SITE_NAME . ",\n";
			$message = sqlesc($message);
			$notifs_donor = sqlesc("");
			$added = sqlesc(get_date_time());
			mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES (0, $id, $message, $added)") or sqlerr(__FILE__, __LINE__);
			mysqli_query($con_link, "UPDATE users SET donor='no', class=$class, notifs_donor=$notifs_donor WHERE id=$id") or sqlerr(__FILE__, __LINE__);	
			}
		}
	}


if ($action == 'remove')
	{
	$id = @$_GET["id"];
	$res = mysqli_query($con_link, "SELECT class FROM users WHERE id=$id") or sqlerr();
	$row = mysqli_fetch_array($res);
	if ($row['class'] < 3)
		$class=0;
	else
		$class = $row['class'];
	$message = "Hallo " . get_username($id) . ",\n\n";
	$message .= "Uw donateurschap is verlopen, en uw sterretje is dus ook verwijderd.\n";
	$message .= "Indien u geen stafflid bent wordt u ook terug geplaatst naar 'Normale gebruiker'.\n";
	$message .= "Wij bedanken u nogmaals voor de donatie en hopen dat u dit in de toekomst nogmaals zal doen.\n\n";
	$message .= "Met vriendelijke groet,\n";
	$message .= $SITE_NAME . ",\n";
	$message = sqlesc($message);
	$notifs_donor = sqlesc("");
	$added = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES (0, $id, $message, $added)") or sqlerr(__FILE__, __LINE__);
	mysqli_query($con_link, "UPDATE users SET donor='no', class=$class, notifs_donor=$notifs_donor WHERE id=$id") or sqlerr(__FILE__, __LINE__);	
	}

$aantal = get_row_count("users", "WHERE class='3'");
	
print("<table width=99% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
tabel_top("Er zijn totaal $aantal VIP leden");
tabel_start();



if (get_user_class() >= UC_GOD)
	{
	print ("<a class=altlink_lblue href=donations.php?action=remove_all><font size=3>Alle verwijderen</font></a><br><br>");
	}


print "<table width=50% class=outer border=1 cellspacing=0 cellpadding=7>" ;
print "<tr>" ;
print "<td class=colheadsite><b>VIP</td>";
print "<td class=colheadsite><b>Gedoneerd tot</td>";
print "<td class=colheadsite><b>Aantal&nbsp;dagen</td>";
if (get_user_class() >= UC_GOD)
	print "<td class=colheadsite><b>Verwijderen</td>";
print "</tr>" ;
$res = mysqli_query($con_link, "SELECT * FROM users WHERE class='3' ORDER BY donor_until") or sqlerr();
while ($row = mysqli_fetch_assoc($res)) {
print("<tr><td bgcolor=white>");
print "<b><a href=userdetails.php?id=" . $row['id'] . ">" . get_usernamesitesmal($row['id']) . "</a>";
print("</td><td bgcolor=white align=right>");
print convertdatum($row['donor_until'], "no");
	print("</td><td bgcolor=white align=center>");

	$days = floor((sql_timestamp_to_unix_timestamp($row['donor_until']) - gmtime()) / (24*3600)) +1;

	if ($days >= 0)
		print ($days . " dagen");
	else
		print ("<b><font color=red>" . $days . " dagen</font>");
	print("</td>");
if (get_user_class() >= UC_GOD)
	{
	print("<td align=center bgcolor=white>");	
	if ($days >= 0)
		print ("");
	else
		{
		print ("<b><a href=donations.php?action=remove&amp;id=$row[id]>Verwijderen</a>");
		}
	print("</td>");	
	}
print("</tr>");

}
print("</td></tr></table>\n");



tabel_einde();
page_einde();
site_footer();
?>
