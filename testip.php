<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();
if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "Toegang geweigerd");

if ($_SERVER["REQUEST_METHOD"] == "POST")
	$ip = @$_POST["ip"];
else
	$ip = @$_GET["ip"];
if ($ip)
{
	$nip = ip2long($ip);
	if ($nip == -1)
	  site_error_message("Foutmelding", "Foutief IP.");
	$res = mysqli_query($con_link, "SELECT * FROM bans WHERE $nip >= first AND $nip <= last") or sqlerr(__FILE__, __LINE__);
	if (mysqli_num_rows($res) == 0)
		$verbannen = "Nee";
	else
	{
	  $banstable = "<table class=main border=0 cellspacing=0 cellpadding=5>\n" .
	    "<tr><td class=colhead>Eerste</td><td class=colhead>Laatste</td><td class=colhead>Opmerking</td></tr>\n";
	  while ($arr = mysqli_fetch_assoc($res))
	  {
	    $first = long2ip($arr["first"]);
	    $last = long2ip($arr["last"]);
	    $comment = htmlspecialchars($arr["comment"]);
	    $banstable .= "<tr><td>$first</td><td>$last</td><td>$comment</td></tr>\n";
	  }
	  $banstable .= "</table>\n";
		$verbannen = "Ja";
	}
}
site_header("Bans Zoeken");tabel_start();

if (@$verbannen == "Nee")
	sitemsg("Resultaat", "Het IP nummer <b>$ip</b> is niet verbannen.",70);
if (@$verbannen == "Ja")
	sitemsg("Resultaat", "<table class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded style='padding-right: 5px'><img src=pic/smilies/excl.gif></td><td class=embedded>Het IP nummer <b>$ip</b> is verbannen:</td></tr></table><p>$banstable</p>",70);

if (get_user_class() >= UC_SYSOP)
	{
	if (get_row_count("user_ip","WHERE ip='$ip'") == 0 || !$ip)
		sitemsg("Resultaat", "Geen gebruiker gevonden.",70);
	else
		{
		print("<table width=70% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
		tabel_top("Gevonden met ip-nummer $ip", "center");
		print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=0>");
		print("<tr>");
		print("<td class=embedded align=center><center><br>");
		$res = mysqli_query($con_link, "SELECT * FROM user_ip WHERE ip='$ip'") or sqlerr(__FILE__, __LINE__);
		while ($row = mysqli_fetch_assoc($res))
			{
			print "<a class=altlink_yellow href=userdetails.php?id=" . $row['userid'] . "><font size=3>" . get_username($row['userid']) . "</font></a>";
			print "<br>";
			}
		print("<br></td></tr></table>");
		print("</td></table><br>");
		}
	}

print("<table width=70% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
tabel_top("Test een IP nummer", "center");
print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td class=embedded align=center><center><br>");

?>
<form method=post action=testip.php>
<table width=70% border=1 cellspacing=0 cellpadding=5>
<tr><td class=rowhead bgcolor=white>IP nummer</td><td bgcolor=white><input type=text name=ip></td></tr>
<tr><td bgcolor=white colspan=2 align=center><input type=submit class=btn style='height: 25px; width: 120px' value=Test&nbsp;Ip-nummer></td></tr>
</form>
</table>
<br>
<?

print("</td></tr></table>");
print("<br></td></tr></table>");
print("</td></table><br>");

tabel_einde();
site_footer();
?>