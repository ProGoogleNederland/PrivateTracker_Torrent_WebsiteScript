<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

if (get_user_class() < UC_SYSOP)
	stderr("Fout", "Toegang Geweigerd.");

function get_row_counts($table, $suffix = "")
{
	if ($suffix)
		$suffix = " $suffix";
	($r = mysqli_query($con_link, "SELECT COUNT(*) FROM $table$suffix")) or die(mysqli_error());
	($a = mysqli_fetch_row($r)) or die(mysqli_error());
	return $a[0];
}

$id = 0 + @$_GET["id"];

if ($id == 1 && !$CURUSER['id'] == 1)
	site_error_message("Foutmelding", "ERROR, database table corrupt.");

$out = 0 + @$_GET['out'];

if ($out == 1 && !$CURUSER['id'] == 1)
	site_error_message("Foutmelding", "ERROR, database table corrupt.");

if ($out)		// Postvak-uit
{	
	site_header("Postvak-uit van " . get_username($out), false);
	print("<table class=bottom width=750 border=0 cellspacing=0 cellpadding=10><tr><td class=embedded>\n");
  	print("<h1 align=center>Postvak-uit van " . get_username($out) . "</h1>\n");
   	print("<div align=center>(<a href=inbox_spy.php?id=" . $out . ">Postvak-in</a>)</div>\n");
	$res = mysqli_query($con_link, "SELECT * FROM messages WHERE sender=" . $out . " AND location IN ('out','both') ORDER BY added DESC") or die("barf!");
	if (mysqli_num_rows($res) == 0)
    	sitemsg("Informatie","Uw postvak-uit is leeg!");
	else
		while ($arr = mysqli_fetch_assoc($res))
	  	{
			$res2 = mysqli_query($con_link, "SELECT username FROM users WHERE id=" . $arr["receiver"]) or sqlerr();
			$arr2 = mysqli_fetch_assoc($res2);
			$receiver = "<a href=userdetails.php?id=" . $arr["receiver"] . ">" . $arr2["username"] . "</a>";
			$elapsed = get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]));
			print("<p><table background=pics/system/tabel_achtergrond.gif width=100% border=1 cellspacing=0 cellpadding=10><tr><td class=text>\n");
			print("Aan <b>$receiver</b> op\n" . $arr["added"] . " ($elapsed geleden) \n");
			if (get_user_class() >= UC_MODERATOR && $arr["unread"] == "yes")
	    		print("<b>(<font color=red>Ongelezen!</font>)</b>");
				print("<p><table class=main width=100% border=1 cellspacing=0 cellpadding=10><tr><td bgcolor=white class=text>\n");
				print(stripslashes(format_comment($arr["msg"])));
				print("</td></tr></table></p>\n<p>");
				print("</tr></table></p>\n");
		}


if (get_user_class() >= UC_GOD)
	{
	print("<table class=bottom width=750 border=0 cellspacing=0 cellpadding=10><tr><td class=embedded>\n");
  	print("<h1 align=center>Postvak-uit van " . get_username($out) . "</h1>\n");
   	print("<div align=center>(<a href=inbox_spy.php?id=" . $out . ">Postvak-in</a>)</div>\n");
	$res = mysqli_query($con_link, "SELECT * FROM messages WHERE sender=" . $out . " ORDER BY added DESC") or die("barf!");
	if (mysqli_num_rows($res) == 0)
    	sitemsg("Informatie","Uw postvak-uit is leeg!");
	else
		while ($arr = mysqli_fetch_assoc($res))
	  	{
			$res2 = mysqli_query($con_link, "SELECT username FROM users WHERE id=" . $arr["receiver"]) or sqlerr();
			$arr2 = mysqli_fetch_assoc($res2);
			$receiver = "<a href=userdetails.php?id=" . $arr["receiver"] . ">" . $arr2["username"] . "</a>";
			$elapsed = get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]));
			print("<p><table background=pics/system/tabel_achtergrond.gif width=100% border=1 cellspacing=0 cellpadding=10><tr><td class=text>\n");
			print("Verzonden aan <b>$receiver</b> op\n" . $arr["added"] . " ($elapsed geleden) \n");
			if (get_user_class() >= UC_MODERATOR && $arr["unread"] == "yes")
	    		print("<b>(<font color=red>Ongelezen!</font>)</b>");
				print("<p><table class=main width=100% border=1 cellspacing=0 cellpadding=10><tr><td bgcolor=white class=text>\n");
				print(stripslashes(format_comment($arr["msg"])));
				print("</td></tr></table></p>\n<p>");
				print("</tr></table></p>\n");
		}
	}
		
}
else		// Postvak-in
{
	site_header("Postvak-in van " . get_username($id), false);
	print("<table class=bottom width=750 border=0 cellspacing=0 cellpadding=10><tr><td class=embedded>\n");
	print("<h1 align=center>Postvak-in van " . get_username($id) . "</h1>\n");
	print("<div align=center>(<a href=" . $_SERVER['PHP_SELF'] . "?out=" . $id . ">Postvak-uit</a>)</div>\n");
	$res = mysqli_query($con_link, "SELECT * FROM messages WHERE receiver=" . $id . " AND location IN ('in','both') ORDER BY added DESC") or die("barf!");
	if (mysqli_num_rows($res) == 0)
		sitemsg("Informatie","Uw postvak-in is leeg!");
	else
		while ($arr = mysqli_fetch_assoc($res))
		{
			if (is_valid_id($arr["sender"]))
			{
				$res2 = mysqli_query($con_link, "SELECT username FROM users WHERE id=" . $arr["sender"]) or sqlerr();
				$arr2 = mysqli_fetch_assoc($res2);
				$sender = "<a class=altlink_white href=userdetails.php?id=" . $arr["sender"] . ">" . ($arr2["username"]?$arr2["username"]:"[Deleted]") . "</a>";
			}
			else
				$sender = "onzesite";
				$elapsed = get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]));
				print("<p><table background=pics/system/tabel_achtergrond.gif width=100% border=1 cellspacing=0 cellpadding=10><tr><td class=text>\n");
				print("<font color=white>Van <b>$sender</b> op\n" . $arr["added"] . " ($elapsed geleden) \n");
				if ($arr["unread"] == "yes")
				{
					print("<b>(<font color=white>nieuw!</font>)</b>");
				}
				print("<p><table class=main width=100% border=1 cellspacing=0 cellpadding=10><tr><td bgcolor=white class=text>\n");
				print(stripslashes(format_comment($arr["msg"])));
				print("</td></tr></table></p>\n");
				print("</tr></table>\n");
		}
}
print("</td></tr></table>\n");
print("<p align=center><a href=users.php>Een gebruiker zoeken.</a></p>\n");
site_footer();
?>