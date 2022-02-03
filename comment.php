<?php

require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
if (!mkglobal("action"))
	die();

if (@$id)
 $id = 0 + $id;
//$action = @$_GET["action"];
//$action = @$_POST["action"];

dbconn(false);

loggedinorreturn();

if ($action == "add")
{
  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
    $torrentid = 0 + $_POST["tid"];
	  if (!is_valid_id($torrentid))
			site_error_message("Foutmelding", "Fout ID $torrentid.");

		$res = mysqli_query($con_link, "SELECT name FROM torrents WHERE id = $torrentid") or sqlerr(__FILE__,__LINE__);
		$arr = mysqli_fetch_array($res);
		if (!$arr)
		  site_error_message("Foutmelding", "Geen torrent met ID $torrentid.");

	  $text = trim($_POST["text"]);
	  if (!$text)
			site_error_message("Foutmelding", "Bericht mag niet leeg zijn!");

	  mysqli_query($con_link, "INSERT INTO comments (user, torrent, added, text, ori_text) VALUES (" .
	      $CURUSER["id"] . ",$torrentid, '" . get_date_time() . "', " . sqlesc($text) .
	       "," . sqlesc($text) . ")");

	  $newid = mysqli_insert_id($con_link);

	  mysqli_query($con_link, "UPDATE torrents SET comments = comments + 1 WHERE id = $torrentid");

	  header("Refresh: 0; url=details.php?id=$torrentid&viewcomm=$newid#comm$newid");

    
	  die;
	}

  $torrentid = 0 + $_GET["tid"];
  if (!is_valid_id($torrentid))
		site_error_message("Foutmelding", "Foutief ID $torrentid.");

	$res = mysqli_query($con_link, "SELECT name FROM torrents WHERE id = $torrentid") or sqlerr(__FILE__,__LINE__);
	$arr = mysqli_fetch_array($res);
	if (!$arr)
	  site_error_message("Foutmelding", "Geen torrent gevonden met ID $torrentid.");

	site_header("Commentaar toeoegen \"" . $arr["name"] . "\"");

	print("<h1>Commentaar toevoegen aan \"" . htmlspecialchars($arr["name"]) . "\"</h1>\n");
	print("<p><form name=new_comment method=\"post\" action=\"comment.php?action=add\">\n");
	print("<input type=\"hidden\" name=\"tid\" value=\"$torrentid\"/>\n");
	print("<textarea name=\"text\" rows=\"12\" cols=\"90\"></textarea></p>\n");
	print("<p><input type=\"submit\" class=btn value=\"Opslaan\" /></p></form>\n");
?>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript">
<!--
document.new_comment.text.focus();
//-->
</script>
<?php

	$res = mysqli_query($con_link, "SELECT comments.id, text, comments.added, username, users.id as user, users.avatar FROM comments LEFT JOIN users ON comments.user = users.id WHERE torrent = $torrentid ORDER BY comments.id DESC LIMIT 5");

	$allrows = array();
	while ($row = mysqli_fetch_array($res))
	  $allrows[] = $row;

	if (count($allrows)) {
	  print("<h2>Laatste commentaren, in omgekeerde volgorde</h2>\n");
	  commenttable($allrows);
	}

  print "<br>";
  site_footer();
  
	die;
}
elseif ($action == "edit")
{
  $commentid = 0 + $_GET["cid"];
  if (!is_valid_id($commentid))
		site_error_message("Foutmelding", "Foutief ID $commentid.");

  $res = mysqli_query($con_link, "SELECT c.*, t.name FROM comments AS c LEFT JOIN torrents AS t ON c.torrent = t.id WHERE c.id=$commentid") or sqlerr(__FILE__,__LINE__);
  $arr = mysqli_fetch_array($res);
  if (!$arr)
  	site_error_message("Foutmelding", "Foutief ID $commentid.");

	if ($arr["user"] != $CURUSER["id"] && get_user_class() < UC_MODERATOR)
		site_error_message("Foutmelding", "Toegang geweigerd.");

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
	  $text = @$_POST["text"];
    $returnto = @$_POST["returnto"];

	  if ($text == "")
	  	site_error_message("Foutmelding", "Bericht mag niet leeg zijn!");

	  $text = sqlesc($text);

	  $editedat = sqlesc(get_date_time());

	  mysqli_query($con_link, "UPDATE comments SET text=$text, editedat=$editedat, editedby=$CURUSER[id] WHERE id=$commentid") or sqlerr(__FILE__, __LINE__);

		if ($returnto)
	  	header("Location: $returnto");
		else
		  header("Location: $BASEURL/");      // change later ----------------------

  	
		die;
	}

 	site_header("Commentaar bewerken \"" . $arr["name"] . "\"");

	print("<h1>Bewerk het commentaar van \"" . htmlspecialchars($arr["name"]) . "\"</h1><p>\n");
	print("<form name=edit_comment method=\"post\" action=\"comment.php?action=edit&amp;cid=$commentid\">\n");
	print("<input type=\"hidden\" name=\"returnto\" value=\"" . $_SERVER["HTTP_REFERER"] . "\" />\n");
	print("<input type=\"hidden\" name=\"cid\" value=\"$commentid\" />\n");
	print("<textarea name=\"text\" rows=\"12\" cols=\"90\">" . stripslashes(htmlspecialchars($arr["text"])) . "</textarea></p>\n");
	print("<p><input type=\"submit\" class=btn value=\"Opslaan\" /></p></form>\n");
?>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript">
<!--
document.edit_comment.text.focus();
//-->
</script>
<?php

	print "<br>";
	site_footer();
  
	die;
}
elseif ($action == "delete")
{
	if (get_user_class() < UC_MODERATOR)
		site_error_message("Foutmelding", "Toegang geweigerd.");

  $commentid = 0 + $_GET["cid"];

  if (!is_valid_id($commentid))
		site_error_message("Foutmelding", "Foutief ID $commentid.");

  $sure = @$_GET["sure"];

  if (!$sure)
  {
 		$referer = $_SERVER["HTTP_REFERER"];
		site_error_message("Delete comment", "You are about to delete a comment. Click\n" .
			"<a href=?action=delete&cid=$commentid&sure=1" .
			($referer ? "&returnto=" . urlencode($referer) : "") .
			">here</a> if you are sure.");
  }


	$res = mysqli_query($con_link, "SELECT torrent FROM comments WHERE id=$commentid")  or sqlerr(__FILE__,__LINE__);
	$arr = mysqli_fetch_array($res);
	if ($arr)
		$torrentid = $arr["torrent"];

	mysqli_query($con_link, "DELETE FROM comments WHERE id=$commentid") or sqlerr(__FILE__,__LINE__);
	if ($torrentid && mysqli_affected_rows($con_link) > 0)
		mysqli_query($con_link, "UPDATE torrents SET comments = comments - 1 WHERE id = $torrentid");

	$returnto = @$_GET["returnto"];

	if ($returnto)
	  header("Location: $returnto");
	else
	  header("Location: $BASEURL/");      // change later ----------------------

  
	die;
}
elseif ($action == "vieworiginal")
{
	if (get_user_class() < UC_MODERATOR)
		site_error_message("Foutmelding", "Toegang geweigerd.");

  $commentid = 0 + $_GET["cid"];

  if (!is_valid_id($commentid))
		site_error_message("Foutmelding", "Foutief ID $commentid.");

  $res = mysqli_query($con_link, "SELECT c.*, t.name FROM comments AS c JOIN torrents AS t ON c.torrent = t.id WHERE c.id=$commentid") or sqlerr(__FILE__,__LINE__);
  $arr = mysqli_fetch_array($res);
  if (!$arr)
  	site_error_message("Foutmelding", "Foutief ID $commentid.");

  site_header("Original comment");
  print("<h1>Original contents of comment #$commentid</h1><p>\n");
	print("<table width=500 border=1 cellspacing=0 cellpadding=5>");
  print("<tr><td class=comment>\n");
	echo htmlspecialchars($arr["ori_text"]);
  print("</td></tr></table>\n");

  $returnto = $_SERVER["HTTP_REFERER"];

//	$returnto = "details.php?id=$torrentid&amp;viewcomm=$commentid#$commentid";

	if ($returnto)
 		print("<p><font size=small>(<a href=$returnto>back</a>)</font></p>\n");

	print "<br>";
	site_footer();
  
	die;
}
else
	site_error_message("Foutmelding", "Onbekende aktie $action");

die;
?>