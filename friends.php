<?php

require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

//$userid = @$_GET['id'];
$action = @$_GET['action'];

if (!@$userid)
	$userid = $CURUSER['id'];

if (!is_valid_id($userid))
	site_error_message("Foutmelding", "Foutief ID.");

if ($userid != $CURUSER["id"])
	site_error_message("Foutmelding", "Toegang geweigerd.");

$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
$user = mysqli_fetch_array($res) or site_error_message("Foutmelding", "Geen gebruiker met dit ID.");

// action: add -------------------------------------------------------------

if ($action == 'add')
{
	$targetid = @$_GET['targetid'];
	$type = @$_GET['type'];

  if (!is_valid_id($targetid))
		site_error_message("Foutmelding", "Foutief ID.");

  if ($type == 'friend')
  {
  	$table_is = $frag = 'friends';
    $field_is = 'friendid';
  }
	elseif ($type == 'block')
  {
		$table_is = $frag = 'blocks';
    $field_is = 'blockid';
  }
	else
		site_error_message("Foutmelding", "Onbekende ID");

  $r = mysqli_query($con_link, "SELECT id FROM $table_is WHERE userid=$userid AND $field_is=$targetid") or sqlerr(__FILE__, __LINE__);
  if (mysqli_num_rows($r) == 1)
		site_error_message("Foutmelding", "Gebruiker ID staat reeds in uw lijst.");

	mysqli_query($con_link, "INSERT INTO $table_is VALUES (0,$userid, $targetid)") or sqlerr(__FILE__, __LINE__);
  header("Location: $BASEURL/friends.php?id=$userid#$frag");
  die;
}

// action: delete ----------------------------------------------------------

if ($action == 'delete')
{
	$targetid = @$_GET['targetid'];
	$type = @$_GET['type'];

  if (!is_valid_id($targetid))
		site_error_message("Foutmelding", "Fout ID.");

  if ($type == 'friend')
  {
    mysqli_query($con_link, "DELETE FROM friends WHERE userid=$userid AND friendid=$targetid") or sqlerr(__FILE__, __LINE__);
    if (mysqli_affected_rows($con_link) == 0)
      site_error_message("Foutmelding", "Geen vrienden gevonden met dit ID");
    $frag = "friends";
  }
  elseif ($type == 'block')
  {
    mysqli_query($con_link, "DELETE FROM blocks WHERE userid=$userid AND blockid=$targetid") or sqlerr(__FILE__, __LINE__);
    if (mysqli_affected_rows($con_link) == 0)
      site_error_message("Foutmelding", "Geen blokering gevonden met dit ID");
    $frag = "blocks";
  }
  else
    site_error_message("Foutmelding", "Onbekende $type");

  header("Location: $BASEURL/friends.php?id=$userid#$frag");
  die;
}

// main body  -----------------------------------------------------------------

site_header("Personal lists for " . $user['username']);
tabel_start();
if ($user["donor"] == "yes") $donor = "<td class=embedded><img src=pic/starbig.gif alt='Donor' style='margin-left: 4pt'></td>";
if ($user["warned"] == "yes") $warned = "<td class=embedded><img src=pic/warnedbig.gif alt='Warned' style='margin-left: 4pt'></td>";

print("<table width=80% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
tabel_top("Persoonlijke lijsten voor ".$user['username']."</h1>".@$donor.@$warned.@$country);
print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td class=embedded align=center><center><br>");

print("<table class=bottom width=95% border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><div align=center>");

print("<h2><a name=\"friends\"><font color=yellow size=3>Vriendenlijst</font></a></h2>");

print("<table width=100% class=bottom border=0 cellspacing=0 cellpadding=5><tr><td class=embedded><div align=center>");

$i = 0;

$res = mysqli_query($con_link, "SELECT f.friendid as id, u.username AS name, u.class, u.avatar, u.title, u.donor, u.warned, u.last_access, u.skype_name FROM friends AS f LEFT JOIN users as u ON f.friendid = u.id WHERE userid=$userid ORDER BY name") or sqlerr(__FILE__, __LINE__);
if(mysqli_num_rows($res) == 0)
	$friends = "<font size=2 color=white>Uw vriendenlijst is leeg.</font>";
else
	while ($friend = mysqli_fetch_array($res))
	{
    $title = $friend["title"];
		if (!$title)
	    $title = get_user_class_name($friend["class"]);
    $body1 = "<a href=userdetails.php?id=" . $friend['id'] . "><b>" . $friend['name'] . "</b></a>";
    $body1 .= ($friend["donor"] == "yes" ? "<img src=/pic/star.gif alt='Donor'>" : "");
    $body1 .= ($friend["warned"] == "yes" ? "<a href=site_regels.php#warning class=altlink><img src=/pic/warned.gif alt=\"Warned\" border=0></a>" : "");
    $body1 .= " ($title)";
    $body1 .= "<br><br>laatst gezien op " . $friend['last_access'] . "<br>(" . get_elapsed_time(sql_timestamp_to_unix_timestamp($friend['last_access'])) . " geleden)";
		$body2 = "<br><a href=friends.php?id=$userid&action=delete&type=friend&targetid=" . $friend['id'] . "><img src=/pic/button_del.gif></img></a>";
		$body2 .= "<br><br><a href=sendmessage.php?receiver=" . $friend['id'] . "><img src=/pic/button_pm.gif></img></a>";
		$body2 .= ($friend['last_access'] < (get_date_time(gmtime() - 180)) ? "<br><br><img src=".$pic_base_url."button_offline.gif border=0>" : "<br><br><img src=".$pic_base_url."button_online.gif border=0>");
		
		$body2 .= ($friend['skype_name'] == null ? "<br><br>" : "<br><br><a href=skype:". $friend['skype_name'] . "?chat><img src=/pic/button_chat.gif></img></a>");

		
    $avatar = ($CURUSER["avatars"] == "yes" ? htmlspecialchars($friend["avatar"]) : "");
		if (!$avatar)
			$avatar = "/pic/default_avatar.gif";
    if ($i % 2 == 0)
    	print("<table width=100% class=bottom style='padding: 0px'><tr><td class=bottom style='padding: 5px' width=50% align=center>");
    else
    	print("<td class=bottom style='padding: 20px' width=100% align=center>");
    print("<table class=main width=100% height=75px>");
    print("<tr valign=top><td width=75 align=center style='padding: 0px'>" .
			($avatar ? "<div style='width:150px;height:150px;overflow: hidden'><img width=150px src=\"$avatar\"></div>" : ""). "</td><td>\n");
    print("<table class=main width=100% height=100%>");
    print("<tr><td bgcolor=white class=embedded style='padding: 5px' width=80%>$body1</td>\n");
	print("<td bgcolor=white class=embedded style='padding: 5px' width=20%>$body2</td></tr>\n");
	
    print("</table>");
		print("</td></tr>");
		print("</td></tr></table>\n");
    if ($i % 2 == 1)
			print("</td></tr></table>\n");
		else
			print("</td>\n");
		$i++;
	}
if ($i % 2 == 1)
	print("<td class=bottom width=50%>&nbsp;</td></tr></table>\n");
print(@$friends);
print("</td></tr></table>\n");

$res = mysqli_query($con_link, "SELECT b.blockid as id, u.username AS name, u.donor, u.warned, u.last_access FROM blocks AS b LEFT JOIN users as u ON b.blockid = u.id WHERE userid=$userid ORDER BY name") or sqlerr(__FILE__, __LINE__);
if(mysqli_num_rows($res) == 0)
	$blocks = "<font size=2 color=white>Uw negeerlijst is leeg.</font>";
else
	while ($block = mysqli_fetch_array($res))
	{
    $blocks .= (isset($blocks) ? ", " : "") . "<a href=userdetails.php?id=" . $block['id'] . "><b>" . $block['name'] . "</b></a>";
		$blocks .= " - [<font class=small><a href=friends.php?id=$userid&action=delete&type=block&targetid=" . $block['id'] . ">verwijder</a></font>]";
	}
print("<br><br>");
print("<table class=bottom width=100% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded><div align=center>");
print("<h2><a name=\"blocks\"><font color=yellow size=3>Lijst van genegeerde gebruikers</font></a></h2>");
print("<tr><td class=embedded><div align=center>");
print("$blocks\n");
print("</td></tr></table>\n");
print("</td></tr></table>\n");
//print("<p><a href=users.php><b>Zoek een gebruiker</b></a></p>");

print("<br></td></tr></table>");
print("</td></table><br>");
tabel_einde();
site_footer();
?>