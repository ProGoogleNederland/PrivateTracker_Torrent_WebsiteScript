<?php
ob_start("ob_gzhandler");
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

$shout = @$_POST["shout"];
$action = @$_POST['action'];
$delete = @$_GET['delete'];
$legen = @$_GET["legen"];
if ($CURUSER['shoutblok'] == "yes")
	site_error_message("Foutmelding", "U bent geblokkeerd van de shoutbox neem contact op met een beheerder om uw blokkade op te heffen.");

if ($legen == "ja")
	{
	if (get_user_class() >= UC_ADMINISTRATOR)
		{
		mysqli_query($con_link, "DELETE FROM shouts") or sqlerr(__FILE__, __LINE__);
		$action = "shout";
		$shout = "Shout geheel geleegd. Veel plezier verder op Torrent Media.";
		mysqli_query($con_link, "OPTIMIZE TABLE shouts");
		mysqli_query($con_link, "OPTIMIZE TABLE shouts_seen");
		}
	}

if ($delete == "delete")
	{
	if (get_user_class() >= UC_ADMINISTRATOR)
		{
		$id = @$_GET["id"];
		mysqli_query ($con_link, "DELETE FROM shouts WHERE id=$id") or sqlerr();
		mysqli_query($con_link, "OPTIMIZE TABLE shouts");
		mysqli_query($con_link, "OPTIMIZE TABLE shouts_seen");
		}
	}

if ($action == "shout")
	{
	$username = $CURUSER['username'];
	$shout = str_replace("/me", $username, $shout);
	$shout = sqlesc($shout);
	$id = $CURUSER["id"];	
	if (strlen($shout) > 2)
		{
		//$res = mysqli_query($con_link, "SELECT * FROM shouts WHERE text=$shout") or sqlerr(__FILE__, __LINE__);
		//$row = mysqli_fetch_array($res);
		//if (!$row)
			mysqli_query($con_link, "INSERT INTO shouts (user, text, added) VALUES (" . $CURUSER["id"] . ", $shout, NOW())");
		}

	$secs = 1*24*3600;
	$dt = sqlesc(get_date_time(gmtime() - $secs));
	mysqli_query($con_link, "DELETE FROM shouts WHERE added < $dt") or sqlerr(__FILE__, __LINE__);
	}

$user_seen = $CURUSER['id'];
$seen = sqlesc(get_date_time());

site_header("Shout");

$res = mysqli_query($con_link, "SELECT * FROM shouts_seen WHERE user=$user_seen") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);
if (!$row)
	mysqli_query($con_link, "INSERT INTO shouts_seen (user, seen) VALUES ($user_seen, $seen)") or sqlerr(__FILE__, __LINE__);
else
	mysqli_query($con_link, "UPDATE shouts_seen SET seen=$seen WHERE user=$user_seen") or sqlerr(__FILE__, __LINE__);

$verwijder = 180;
$deadtime = time() - $verwijder;
mysqli_query($con_link, "DELETE FROM shouts_seen WHERE seen < FROM_UNIXTIME($deadtime)");

function get_usernameshoutbox($id) {
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$res = mysqli_query($con_link, "SELECT username, warned, class, donor FROM users WHERE id = $id")	or sqlerr();
	$row = mysqli_fetch_array($res);
	
	$usernamesite = "";

	if ($row['class'] == 255)
		$usernamesite .= "<font color=#9c44a1>" . $row['username'] . "</font>";
	if ($row['class'] == 8)
		$usernamesite .= "<font color=green>" . $row['username'] . "</font>";
	if ($row['class'] == 7)
		$usernamesite .= "<font color=black>" . $row['username'] . "</font>";
	if ($row['class'] == 6)
		$usernamesite .= "<font color=green>" . $row['username'] . "</font>";
	if ($row['class'] == 5)
		$usernamesite .= "<font color=#FF0000>" . $row['username'] . "</font>";
	if ($row['class'] == 4)
		$usernamesite .= "<font color=#FF00FF>" . $row['username'] . "</font>";
	if ($row['class'] == 3)
		$usernamesite .= "<font color=#9A6258>" . $row['username'] . "</font>";
	if ($row['class'] == 2)
		$usernamesite .= "<font color=#FF6600>" . $row['username'] . "</font>";
	if ($row['class'] == 1)
		$usernamesite .= "<font color=#4F3157>" . $row['username'] . "</font>";
	if ($row['class'] == 0)
		$usernamesite .= $row['username'];

	if ($row['warned'] == "yes")
		$usernamesite .= "<img src=pic/warned.gif border=0 style='margin-left: 2pt'>";

	if ($row['donor'] == "yes")
		$usernamesite .= "<img border=0 width=15 height=15 src=pic/system/star.gif alt='Donateur' style='margin-left: 2pt'>";
	
	if ($row) return $usernamesite;
}
tabel_start();
print("<a name=shout></a>");
//print"<b><font size=3 color=blue>Mocht u een donatie aan ons willen doen ga dan naar <a href=donatie.php>deze pagina</a></font></center>";
//print("<br>");

print("<table align=center width=95% class=main border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
tabel_top("Shout&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class=altlink_yellow href=shoutbox.php>Druk hier om de Shout te verversen.</a>");

print("<table align=center width=100% border=0 cellspacing=0 cellpadding=10>");
print("<tr>");
print("<td align=center class=embedded><br><center>");

$shoutbox_extra_datum = sqlesc(substr(get_date_time(),0,10));

$res_se = mysqli_query($con_link, "SELECT * FROM shoutbox_extra WHERE datum=$shoutbox_extra_datum");

$row_se = @mysqli_fetch_array($res_se);

if ($row_se)
	{
	print $row_se['shoutbox_extra'];
	print "<br>";
	}
else
	{
	print "<font size=4 color=white><b>Geen verzoekjes hier plaatsen, Dank!</b></font><br>";
	}

print "<br><form name=invoer method=post action=shoutbox.php>";
print "<input type=hidden name='action' value='shout'>\n";
print "<input maxlength=400 type=text size=120 name=shout>&nbsp;&nbsp;";
print "<input type=submit class=btn value=Toevoegen>";
print "</form>";
print "<br>";
?>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript">
<!--
document.invoer.shout.focus();
//-->
</script>
<?php

$res = mysqli_query($con_link, "SELECT * FROM shouts ORDER BY added DESC LIMIT 100") or sqlerr();

print("<table align=center width=95% class=bottom border=0 cellspacing=0 cellpadding=1><tr><td align=center>");
print("<table width=100% class=bottom border=0 cellspacing=0 cellpadding=3>");
print("<tr><td class=embeddedsite width=85%>");
print("<font color=yellow><b>&nbsp;Berichten</b></font>");
print("<font color=yellow><b>&nbsp;</b></font>");
print("</td><td class=embeddedsite width=80>");
print("<center><font color=yellow><b>&nbsp;</b></font></center>");
if (get_user_class() >= UC_ADMINISTRATOR) {
	print("</td><td class=embeddedsite width=10>");
	print("<center><font color=yellow><b>&nbsp;</b></font></center>");
	}
print("</td></tr>");
//var_dump($res);
$start = 1;
while ($row = mysqli_fetch_assoc($res)) {
//	var_dump($row);
if ($start == 1) {
	$start = 2;
}
else $start = 1;
if ($start == 1)
	print("<tr><td class=embeddedsite bgcolor=#000000>");
else
	print("<tr><td class=embeddedsite bgcolor=#000000>");
$tekst = stripslashes($row['text']); 
$tekst = htmlspecialchars($tekst);
$tekst = scheld($tekst);
 
 
//$datum = $row['added'];
@$datum = substr($datum,11,8);
$datum = str_replace(" ","&nbsp;",$datum);
//print $datum ."&nbsp;". format_comment($tekst, true);
print $row["text"];



if ($start == 1)
	print("</td><td align=center class=embeddedsite bgcolor=#000000>\n");
else
	print("</td><td align=center class=embeddedsite bgcolor=#000000>\n");

print "<a href=userdetails.php?id=" . $row["user"] . ">" . (get_usernameshoutbox($row['user'])) . "</a>";
print "<br>" . $datum;

if (get_user_class() >= UC_ADMINISTRATOR) {
	if ($start == 1)
		print("</td><td class=embeddedsite bgcolor=#000000>\n");
	else
		print("</td><td class=embeddedsite bgcolor=#000000>\n");
	print "<a href=shoutbox.php?delete=delete&amp;id=" . $row['id'] . " style=color:red;>DEL</a>\n";
	}
}

print("</td></tr></table>\n");

print("</td></tr></table><br>");
if (get_user_class() >= UC_ADMINISTRATOR)
	print "<a class=altlink_yellow href=shoutbox.php?legen=ja>Leeg de gehele Shout.</font></a><br>";

print("</td>");
print("</tr>");
print("</table>");
print("</td></table><br>");
tabel_einde();
site_footer();
?>