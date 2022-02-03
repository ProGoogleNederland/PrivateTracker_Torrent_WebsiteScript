<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

$action = (string)@$_POST['action'];

if ($action == 'opslaan')
	{
	$comment_uploader = (string)@$_POST['comment_uploader'];
	if (!$comment_uploader)
		site_error_message("Foutmelding", "Geen commentaar ontvangen.");

	$torrent_id = (int)@$_POST['torrent_id'];
	if (!$torrent_id)
		site_error_message("Foutmelding", "Geen torrent_id ontvangen !!!.");

	$res = mysqli_query($con_link, "SELECT * FROM torrents WHERE id = $torrent_id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Geen torrent gevonden.");

	if ($row['owner'] != $CURUSER['id'])
		site_error_message("Foutmelding", "Dit is niet uw torrent.");

	$comment_uploader = trim($comment_uploader);

	$res2 = mysqli_query($con_link, "SELECT * FROM comments_uploader WHERE torrent = $torrent_id") or sqlerr(__FILE__, __LINE__);
	$row2 = mysqli_fetch_array($res2);
	if ($row2)
		{
		mysqli_query($con_link, "UPDATE comments_uploader set text=".sqlesc($comment_uploader).", editedby=".$CURUSER['id'].", editedat='". get_date_time()."' WHERE torrent=".$torrent_id) or sqlerr(__FILE__,__LINE__);
		header("Refresh: 0; url=details.php?id=$torrent_id");
		}
	else
		{
		mysqli_query($con_link, "INSERT INTO comments_uploader (user, torrent, added, text) VALUES (".$CURUSER["id"].",".$torrent_id.", '". get_date_time()."', ".sqlesc($comment_uploader).")") or sqlerr(__FILE__,__LINE__);
		header("Refresh: 0; url=details.php?id=$torrent_id");
		}
	}

$torrent_id = (int)@$_POST['torrent_id'];

if (!$torrent_id)
	site_error_message("Foutmelding", "Geen torrent_id ontvangen.");

$res = mysqli_query($con_link, "SELECT * FROM torrents WHERE id = $torrent_id") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);
if (!$row)
	site_error_message("Foutmelding", "Geen torrent gevonden.");

if ($row['owner'] != $CURUSER['id'])
	site_error_message("Foutmelding", "Dit is niet uw torrent.");

$res2 = mysqli_query($con_link, "SELECT * FROM comments_uploader WHERE torrent = $torrent_id") or sqlerr(__FILE__, __LINE__);
$row2 = mysqli_fetch_array($res2);
if ($row2)
	$comment_uploader = $row['text'];

site_header("Commentaar");
page_start(98);
tabel_top("Uploader commentaar bewerken","center");
tabel_start();

print "<font size=2 color=white><b>Torrent: " . htmlspecialchars($row['name']);

print "<table width=1% border=1 cellspacing=0 cellpadding=5>";
print "<form name=hd_new method=post action=''>";
print "<input type=hidden name=action value=opslaan>";
print "<input type=hidden name=torrent_id value=".$torrent_id.">";
print "<tr><td bgcolor=white><textarea name=comment_uploader cols=125 rows=15>".htmlspecialchars($row2['text'])."</textarea></td></tr>";
print "<tr><td bgcolor=white align=center><input type=submit class=btn style='height: 32px; width: 400px;font-weight: bold;color:blue' value='Opslaan'></td></tr>";
print "</table>";
print "</form>";

tabel_einde();
page_einde();
site_footer();
?>