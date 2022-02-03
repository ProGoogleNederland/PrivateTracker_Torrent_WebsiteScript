<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

$font_color = "white";

$action = (string)@$_POST['action'];

if ($action == "verwijderen_totaal")
	{
	$id = (int)@$_POST['id'];
	$sure = (string)@$_POST['sure'];
	if (!$sure)
		site_error_message("Foutmelding", "Geen bevestiging ontvangen.");
	$res = mysqli_query($con_link, "SELECT * FROM massa_bericht_torrents WHERE id=$id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	
	$msg = sqlesc($row['msg']."%");
	if ($row)
		{
		mysqli_query($con_link, "DELETE FROM messages WHERE msg LIKE $msg") or sqlerr(__FILE__, __LINE__);
		mysqli_query($con_link, "DELETE FROM massa_bericht_torrents WHERE id LIKE $id") or sqlerr(__FILE__, __LINE__);
		}
	header("Refresh: 0; url=". $PHP_SELF);
	die;
	}
	
if ($action == "verwijderen")
	{
	$id = (int)@$_POST['id'];
	if ($id)
		{
		mysqli_query($con_link, "UPDATE massa_bericht_torrents set done='yes' WHERE id LIKE $id") or sqlerr(__FILE__, __LINE__);
		}
	header("Refresh: 0; url=". $PHP_SELF);
	die;
	}

if (get_user_class() < UC_SYSOP)
	site_error_message("Foutmelding", "U heeft geen toegang tot deze pagina.");

$aantal = get_row_count("massa_bericht_torrents", "WHERE done='no'");

if ($aantal < 1)
	site_error_message("Foutmelding", "Geen nieuwe torrent massa berichten gevonden.");

site_header("Massa berichten torrents");
page_start(98);
tabel_top("Overzicht massa berichten torrents - ".$aantal." stuk(s)","center");
tabel_start(98);

if ($action == "allemaal")
	$res = mysqli_query($con_link, "SELECT * FROM massa_bericht_torrents WHERE done='no' ORDER BY added DESC") or sqlerr(__FILE__, __LINE__);	
else
	$res = mysqli_query($con_link, "SELECT * FROM massa_bericht_torrents WHERE done='no' ORDER BY added DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);	
while ($row = mysqli_fetch_assoc($res))
	{
	print "<table width=100% class=bottom border=0 cellspacing=0 cellpadding=3>";
	print "<tr>";
	print "<td class=colheadsite>";
	print "<table width=100% class=bottom border=0 cellspacing=0 cellpadding=3>";
	print "<tr>";
	print "<td class=embedded><font color=$font_color><b>";
	print "Uit naam van: " . get_usernamesitesmal($row['sender']);
	print "</td>";
	print "<td class=embedded><font color=$font_color><b>";
	print "Verzonden op: " . str_replace(" ", "&nbsp;", convertdatum($row['added']));
	print "</td>";
	print "<td class=embedded><font color=$font_color><b>";
	if ($row['aantal'] == 1)
		print $row['aantal'] . " bericht verzonden.";
	else
		print $row['aantal'] . " berichten verzonden.";

	print "</td>";
	print "<td class=embedded><div align=right><font color=$font_color><b>";
	print "<form method=post action=''>";
	print "<input type=hidden name=action value='verwijderen'>";
	print "<input type=hidden name=id value=".$row['id'].">";
	print "<input type=submit style='height: 20px;width: 250px;background: yellow;color: red' value='Verwijder deze alszijnde gelezen'>";
	print "</form>";
	print "</td>";
	print "</tr>";

	print "<tr>";
	print "<td class=embedded><font color=$font_color><b>";
	print "Naam verzender: <a class=altlink_white href='userdetails.php?id=".$row['sender']."'>" . get_username($row['sender']) . "</a>";
	print "</td>";
	print "<td class=embedded><font color=$font_color><b>";
	$res2 = mysqli_query($con_link, "SELECT name FROM torrents WHERE id=$row[torrent_id]") or sqlerr(__FILE__, __LINE__);
	$row2 = mysqli_fetch_array($res2);
	if ($row2)
		print "<a class=altlink_white href='details.php?id=" . $row['torrent_id'] . "'>" . $row2['name'] . "</a>";
	print "</td>";
	print "<td class=embedded><font color=$font_color><b>";
	$msg = sqlesc($row['msg']."%");
	$aanwezig = get_row_count("messages","WHERE msg LIKE $msg");
	if ($aanwezig == 1)
		print "Nog " . $aanwezig . " bericht nog aanwezig.";
	else
		print "Nog " . $aanwezig . " berichten nog aanwezig.";
	print "</td>";
	print "<td class=embedded><div align=right>";

	print "<table width=1% class=bottom align=right border=0 cellspacing=0 cellpadding=0>";
	print "<tr>";
	print "<td class=embedded>";
	print "<form method=post action=''>";
	print "<input type=hidden name=action value='verwijderen_totaal'>";
	print "<input type=checkbox name=sure>";
	print "</td><td class=embedded>";
	print "<input type=hidden name=id value=".$row['id'].">";
	print "<input type=submit style='height: 20px;width: 250px;background: red;color: white' value='Verwijder alle nog aanwezige berichten'>";
	print "</form>";
	print "</td></tr></table>";

	print "</td>";
	print "</tr>";
	print "</td></tr>";
	print "</table>";
	print "<tr><td bgcolor=white>";
	print stripslashes(format_comment($row['msg']));
	print "</td></tr>";
	print "</table><br>";
	}

print "<form method=post action=''>";
print "<input type=hidden name=action value='allemaal'>";
print "<input type=submit style='height: 32px;width: 250px;background: white;color: red;font-weight: bold' value='Allemaal weergeven'>";
print "</form>";

tabel_einde();
page_einde();
site_footer();
?>