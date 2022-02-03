<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

$torrent_id = (int)@$_GET['torrent_id'];
if (!$torrent_id)
	new_error_message("Foutmelding", "Geen torrent gevonden.","white",3000);

$res = mysqli_query($con_link, "SELECT * FROM torrents WHERE id = $torrent_id") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);
if (!$row)
	new_error_message("Foutmelding", "Deze torrent niet gevonden.","white",3000);

site_header("Reacties");
page_start();
tabel_top("Overzicht reactie's","center");
tabel_start(70);
print "<font size=2 color=white><a class=altlink_white href='details.php?id=".$torrent_id."'>Terug naar: ".htmlspecialchars($row['name'])."</a><br><br>";

///// Commentaat Uploader /////
print "<br><center>\n";

print "<table width=100% class=bottom cellspacing=0 cellpadding=0>";
print "<tr><td class=colheadsite height=25 width=250><div align=center>";
print "Commentaar gereserveerd voor uploader ".get_username($row['owner']).".";
print "</td></tr><tr><td height=25 width=250><div align=center><br>";

$res_cu = mysqli_query($con_link, "SELECT * FROM comments_uploader WHERE torrent = $torrent_id") or sqlerr(__FILE__, __LINE__);
$row_cu = mysqli_fetch_array($res_cu);
if ($row_cu)
	$comment_uploader = format_comment($row_cu['text']);
else
	$comment_uploader = format_comment("Uploader heeft nog geen commentaar geplaatst.");

$avatar = ($CURUSER["avatars"] == "yes" ? get_avatar($row['owner']) : "");
if (!$avatar)
	$avatar = "/pic/default_avatar.gif";
$maten = getimagesize($avatar);

print "<table class=bottom width=750 border=1 cellspacing=0 cellpadding=$padding>\n";
print "<tr valign=top>\n";
print "<td bgcolor=white align=center width=1% style='padding: 0px'><img ".pic_resize($maten[0],$maten[1], 100)." src=$avatar></td>\n";

print "</td><td bgcolor=white class=text>";
print $comment_uploader;
print "</td></tr></table>";		

print "<br>";
print "</td></tr></table>";		
///// Commentaat Uploader /////


$subres = mysqli_query($con_link, "SELECT comments.id, text, user, comments.added, editedby, editedat, avatar, warned, ".
		  "username, title, class, donor FROM comments LEFT JOIN users ON comments.user = users.id WHERE torrent = " .
		  "$torrent_id ORDER BY comments.id DESC") or sqlerr(__FILE__, __LINE__);

$allrows = array();
while ($subrow = mysqli_fetch_array($subres))
	$allrows[] = $subrow;

commenttable($allrows);

print "<center><br><font size=2 color=white><a class=altlink_white href='details.php?id=".$torrent_id."'>Terug naar: ".htmlspecialchars($row['name'])."</a><br><br>";
tabel_einde();
page_einde();
site_footer();
?>