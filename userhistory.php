<?php
ob_start("ob_gzhandler");
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

$userid = @$_GET["id"];

if (!is_valid_id($userid)) site_error_message("Foutmelding", "Foutief ID");

if (get_user_class()< UC_POWER_USER || ($CURUSER["id"] != $userid && get_user_class() < UC_ADMINISTRATOR))
	site_error_message("Foutmelding", "Toegang geweigerd");

$page = @$_GET["page"];

$action = @$_GET["action"];

//-------- Global variables

$perpage = 50;

//-------- Action: View posts

if ($action == "viewposts")
{
	$select_is = "COUNT(DISTINCT p.id)";

	$from_is = "posts AS p JOIN topics as t ON p.topicid = t.id JOIN forums AS f ON t.forumid = f.id";

	$where_is = "p.userid = $userid AND f.minclassread <= " . $CURUSER['class'];

	$order_is = "p.id DESC";

	$query = "SELECT $select_is FROM $from_is WHERE $where_is";

	$res = mysqli_query($con_link, $query) or sqlerr(__FILE__, __LINE__);

	$arr = mysqli_fetch_row($res) or site_error_message("Foutmelding", "No posts found");

	$postcount = $arr[0];

	//------ Make page menu

	list($pagertop, $pagerbottom, $limit) = pager($perpage, $postcount, $_SERVER["PHP_SELF"] . "?action=viewposts&id=$userid&");

	//------ Get user data

	$res = mysqli_query($con_link, "SELECT username, donor, warned, enabled FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);

	if (mysqli_num_rows($res) == 1)
	{
  	$arr = mysqli_fetch_assoc($res);

	  $subject = "<a href=userdetails.php?id=$userid><b>$arr[username]</b></a>";
	}
	else
	    $subject = "unknown[$userid]";

	//------ Get posts

 	$from_is = "posts AS p JOIN topics as t ON p.topicid = t.id JOIN forums AS f ON t.forumid = f.id LEFT JOIN readposts as r ON p.topicid = r.topicid AND p.userid = r.userid";

	$select_is = "f.id AS f_id, f.name, t.id AS t_id, t.subject, t.lastpost, r.lastpostread, p.*";

	$query = "SELECT $select_is FROM $from_is WHERE $where_is ORDER BY $order_is $limit";

	$res = mysqli_query($con_link, $query) or sqlerr(__FILE__, __LINE__);

	if (mysqli_num_rows($res) == 0) site_error_message("Foutmelding", "Niets gevonden");

	site_header("Forum geschiedenis");

	print("<h1>Forum geschiedenis van $subject</h1>\n");

	if ($postcount > $perpage) echo $pagertop;

	//------ Print table

	begin_main_frame();

	begin_frame();

	while ($arr = mysqli_fetch_assoc($res))
	{
	    $postid = $arr["id"];

	    $posterid = $arr["userid"];

	    $topicid = $arr["t_id"];

	    $topicname = $arr["subject"];

	    $forumid = $arr["f_id"];

	    $forumname = $arr["name"];

	    $newposts = ($arr["lastpostread"] < $arr["lastpost"]) && $CURUSER["id"] == $userid;

	    $added = convertdatum($arr["added"]) . " (" . (get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]))) . " geleden)";

	    print("<p class=sub><table border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>
	    $added&nbsp;--&nbsp;<b>Forum:&nbsp;</b>
	    <a href=/forums.php?action=viewforum&forumid=$forumid>$forumname</a>
	    &nbsp;--&nbsp;<b>Topic:&nbsp;</b>
	    <a href=/forums.php?action=viewtopic&topicid=$topicid>$topicname</a>
      &nbsp;--&nbsp;<b>Post:&nbsp;</b>
      #<a href=/forums.php?action=viewtopic&topicid=$topicid&page=p$postid#$postid>$postid</a>" .
      ($newposts ? " &nbsp;<b>(<font color=red>NEW!</font>)</b>" : "") .
	    "</td></tr></table></p>\n");

	    begin_table(true);

	    $body = format_comment($arr["body"]);
		$body = stripslashes($body);
		
	    if (is_valid_id($arr['editedby']))
	    {
        	$subres = mysqli_query($con_link, "SELECT username FROM users WHERE id=$arr[editedby]");
	        if (mysqli_num_rows($subres) == 1)
	        {
	            $subrow = mysqli_fetch_assoc($subres);
	            $body .= "<p><font size=1 class=small>Last edited by <a href=userdetails.php?id=$arr[editedby]><b>$subrow[username]</b></a> at $arr[editedat] </font></p>\n";
	        }
	    }

	    print("<tr valign=top><td class=comment>$body</td></tr>\n");

	    end_table();
	}

	end_frame();

	end_main_frame();

	if ($postcount > $perpage) echo $pagerbottom;

	site_footer();

	die;
}

//-------- Action: View comments

if ($action == "viewcomments")
{
	$select_is = "COUNT(*)";

	// LEFT due to orphan comments
	$from_is = "comments AS c LEFT JOIN torrents as t
	            ON c.torrent = t.id";

	$where_is = "c.user = $userid";
	$order_is = "c.id DESC";

	$query = "SELECT $select_is FROM $from_is WHERE $where_is ORDER BY $order_is";

	$res = mysqli_query($con_link, $query) or sqlerr(__FILE__, __LINE__);

	$arr = mysqli_fetch_row($res) or site_error_message("Foutmelding", "No comments found");

	$commentcount = $arr[0];

	//------ Make page menu

	list($pagertop, $pagerbottom, $limit) = pager($perpage, $commentcount, $_SERVER["PHP_SELF"] . "?action=viewcomments&id=$userid&");

	//------ Get user data

	$res = mysqli_query($con_link, "SELECT username, donor, warned, enabled FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);

	if (mysqli_num_rows($res) == 1)
	{
		$arr = mysqli_fetch_assoc($res);

	  $subject = "<a href=userdetails.php?id=$userid><b>$arr[username]</b></a>";
	}
	else
	  $subject = "unknown[$userid]";

	//------ Get comments

	$select_is = "t.name, c.torrent AS t_id, c.id, c.added, c.text";

	$query = "SELECT $select_is FROM $from_is WHERE $where_is ORDER BY $order_is $limit";

	$res = mysqli_query($con_link, $query) or sqlerr(__FILE__, __LINE__);

	if (mysqli_num_rows($res) == 0) site_error_message("Foutmelding", "Niets gevonden");

	site_header("Commentaar geschiedenis");

	print("<h1>Commentaar geschiedenis voor $subject</h1>\n");

	if ($commentcount > $perpage) echo $pagertop;

	//------ Print table

	begin_main_frame();

	begin_frame();

	while ($arr = mysqli_fetch_assoc($res))
	{

		$commentid = $arr["id"];

	  $torrent = $arr["name"];

    // make sure the line doesn't wrap
	  if (strlen($torrent) > 55) $torrent = substr($torrent,0,52) . "...";

	  $torrentid = $arr["t_id"];

	  //find the page; this code should probably be in details.php instead

	  $subres = mysqli_query($con_link, "SELECT COUNT(*) FROM comments WHERE torrent = $torrentid AND id < $commentid")
	  	or sqlerr(__FILE__, __LINE__);
	  $subrow = mysqli_fetch_row($subres);
    $count = $subrow[0];
    $comm_page = floor($count/20);
    $page_url = $comm_page?"&page=$comm_page":"";

	  $added = convertdatum($arr["added"]);
		$body = format_comment($arr["text"]);
	  print("<p class=sub><table border=0 cellspacing=0 cellpadding=0><tr><td class=embedded style=\"text-align: center;\">Op $added is de reactie <b>#<a href=/details.php?id=$torrentid&tocomm=1$page_url>$commentid</a></b> bij ".	  ($torrent?("<b><a href=/details.php?id=$torrentid&tocomm=1>$torrent</a></b>"):" [Deleted] ")."<p></br></p><tr valign=top padding=20px style=\"background-color:rgba(0,0,0,0.3)\"><td class=comment>$body</td></tr>
	 
	  </td></tr></table></p>\n");

	}

	end_frame();

	end_main_frame();

	if ($commentcount > $perpage) echo $pagerbottom;

	site_footer();

	die;
}


//-------- Action: View NZB comments

if ($action == "viewnzbcomments")
{
	$select_is = "COUNT(*)";
	// LEFT due to orphan comments
	$from_is = "nzbcomments AS c LEFT JOIN nzbs as n
	            ON c.nzb = n.id";
	$where_is = "c.user = $userid";
	$order_is = "c.id DESC";
	$query = "SELECT $select_is FROM $from_is WHERE $where_is ORDER BY $order_is";
	$res = mysqli_query($con_link, $query) or sqlerr(__FILE__, __LINE__);
	$arr = mysqli_fetch_row($res) or stderr("Error", "No comments found");
	$commentcount = $arr[0];

	//------ Make page menu
	list($pagertop, $pagerbottom, $limit) = pager($perpage, $commentcount, $_SERVER["PHP_SELF"] . "?action=viewnzbcomments&id=$userid&");

	//------ Get user data
	$res = mysqli_query($con_link, "SELECT username, donor, warned, enabled FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);

	if (mysqli_num_rows($res) == 1)
	{
		$arr = mysqli_fetch_assoc($res);
        $subject = "<a href=\"userdetails.php?id=$userid\"><b>$arr[username]</b></a>" . get_user_icons($arr, true);
	}
	else
        $subject = "unknown[$userid]";

	//------ Get comments
	$select_is = "n.name, c.nzb AS n_id, c.id, c.added, c.text";
	$query = "SELECT $select_is FROM $from_is WHERE $where_is ORDER BY $order_is $limit";
	$res = mysqli_query($con_link, $query) or sqlerr(__FILE__, __LINE__);
	if (mysqli_num_rows($res) == 0) stderr("Error", "No comments found");
	
	stdhead("NZB Comments history");
	print("<h1>NZB Comments history for $subject</h1>\n");
	if ($commentcount > $perpage) echo $pagertop;

	//------ Print table
	begin_main_frame();
	begin_frame();

	while ($arr = mysqli_fetch_assoc($res))
	{
        $commentid = $arr["id"];
        $nzb = $arr["name"];
        $nzbid = $arr["n_id"];
        $subres = mysqli_query($con_link, "SELECT COUNT(*) FROM nzbcomments WHERE nzb = $nzbid AND id < $commentid")
        or sqlerr(__FILE__, __LINE__);
        $subrow = mysqli_fetch_row($subres);
        $count = $subrow[0];
        $comm_page = floor($count/20);
        $page_url = $comm_page?"&page=$comm_page":"";
        $added = $arr["added"] . " GMT (" . (get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]))) . " ago)";
        begin_table(true);
        print("<tr><td class=\"row2\">".
            "$added<br /><b>NZB:&nbsp;</b>".
            ($nzb?("<a href=\"/nzbdetails.php?id=$nzbid&tocomm=1\">$nzb</a>"):" [Deleted] ").
            "&nbsp;&nbsp;&nbsp;&nbsp;<b>Comment:&nbsp;</b>#<a href=\"/nzbdetails.php?id=$nzbid&tocomm=1$page_url\">$commentid</a></td></tr>\n");
        $body = format_comment($arr["text"]);
        print("<tr valign=\"top\"><td class=\"row1\">$body</td></tr>\n");
        end_table();
        print("<br />");
	}
	end_frame();
	end_main_frame();
	if ($commentcount > $perpage) echo $pagerbottom;
	stdfoot();
	die;
}

//-------- Handle unknown action

if ($action != "")
	site_error_message("Geschiedenis foutmelding", "Onbekende aktie.");

//-------- Any other case

site_error_message("Geschiedenis foutmelding", "Geen of foutieve invoer gevonden.");

?>