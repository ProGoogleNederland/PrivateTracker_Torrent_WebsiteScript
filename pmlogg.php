<?php
ob_start("ob_gzhandler");
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);

loggedinorreturn();

if (get_user_class() < UC_OWNER)
site_error_message("FOUTJE", "HIER HOOR JIJ NIET THUIS!!!!!!");
$typ = @$HTTP_GET_VARS["typ"];

if ($typ == "edit") {

$id = 0 + @$_GET["id"];
$page = 0 + @$_GET["page"];
mysqli_query($con_link, "DELETE FROM messages WHERE id=" . sqlesc($id)) or die();




if (!is_numeric($id) || $id < 1 || floor($id) != $id)
die;

if (get_user_class() < UC_OWNER)
stderr("Error", "Permission denied.");

  $res = mysqli_query($con_link, "SELECT * FROM messages WHERE id=$id") or sqlerr(__FILE__,__LINE__);
  $arr = mysqli_fetch_array($res);
  if (!$arr)
  	stderr("Error", "Invalid ID.");

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
	  $text = @$_POST["text"];
    $returnto = @$_POST["returnto"];

	  if ($text == "")
	  	stderr("Error", "You can NOT leave a PM empty!");

	  $text = sqlesc($text);

	  mysqli_query($con_link, "UPDATE messages SET msg=$text WHERE id=$id") or sqlerr(__FILE__, __LINE__);

		if ($returnto)
	  	header("Location: $returnto");
		else
		  header("Location: $BASEURL/pmlogg.php");      // change later ----------------------
		die;
	}

 	site_header("Edit PM");

	print("<h1><font color=yellow>Edit PM</font></h1><p>\n");
	print("<form method=\"post\" action=\"pmlogg.php?typ=edit&amp;id=$id\">\n");
	print("<input type=\"hidden\" name=\"returnto\" value=pmlogg.php?page=$page>\n");
	print("<input type=\"hidden\" name=\"id\" value=\"$id\" />\n");
	print("<textarea name=\"text\" rows=\"10\" cols=\"60\">" . htmlspecialchars($arr["msg"]) . "</textarea></p>\n");
	print("<p><input type=\"submit\" class=btn value=\"Edit!\" /></p></form>\n");

site_footer();
die;
}

site_header("PMlog");

$res2 = mysqli_query($con_link, "SELECT COUNT(*) FROM messages");
        $row = mysqli_fetch_array($res2);
        $count = $row[0];
$perpage = 100;
    list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $_SERVER["PHP_SELF"] ."?" );


$res = mysqli_query($con_link, "SELECT * FROM messages ORDER BY id DESC $limit") or sqlerr(__FILE__, __LINE__);

tabel_start();
echo $pagertop;
  print("<center><table border=1 cellspacing=0 cellpadding=5>\n");
  print("<tr><td class=colhead align=left>Zender</td><td class=colhead align=left>Ontvanger</td><td class=colhead align=left>Bericht</td><td class=colhead align=center>Gelezen Ja/Nee</td><td class=colhead align=center>Bewerk</td><td class=colhead align=center>Verwijder</td></tr>\n");
  while ($arr = mysqli_fetch_assoc($res))
  {
    $page = 0 + @$_GET["page"];
    $res2 = mysqli_query($con_link, "SELECT username FROM users WHERE id=" . $arr["receiver"]) or sqlerr();
    $arr2 = mysqli_fetch_assoc($res2);
    $receiver = "<center><a href=userdetails.php?id=" . $arr["receiver"] . "><b>" . $arr2["username"] . "</b></a>";
    $res3 = mysqli_query($con_link, "SELECT username FROM users WHERE id=" . $arr["sender"]) or sqlerr();
    $arr3 = mysqli_fetch_assoc($res3);
    $delete = "<center><a href=https://torrentmedia.org/pmlogg.php?typ=tabort&page=$page&id=$arr[id]><img title=Delete border=0 src=pic/delete.gif width=16 height=16></a>";
    $edit = "<center><a href=https://torrentmedia.org/pmlogg.php?typ=edit&page=$page&id=$arr[id]><img title=Edit border=0 src=pic/edit.gif width=16 height=16></a>";
    $read = "<center><img title=Unread-" . $arr["unread"] . " border=0 src=pic/new.png width=24 height=24>";
    $sender = "<a href=userdetails.php?id=" . $arr["sender"] . "><b>" . $arr3["username"] . "</b></a>";
             if( $arr["sender"] == 0 )
             $sender = "<font color=red><b>System</b></font>";
    $msg = format_comment($arr["msg"]);
  print("<tr><td>$sender</td><td>$receiver</td><td align=left>$msg</td><td>$read</td><td>$edit</td><td>$delete</td></tr>\n");
  }
  print("</table>");
print($pagerbottom);


tabel_einde();
site_footer();
?>
