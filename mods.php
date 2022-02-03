<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_SYSOP)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de beheerders en hoger.");

$action = @$_POST["action"];

$letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

function get_mod($id) {
	$id = sqlesc($id);
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
	$res = mysqli_query($con_link, "SELECT userid FROM mod_letters WHERE letter = $id");
	$row = mysqli_fetch_array($res);
	if ($row) return $row['userid'];
}

if ($action == "opslaan")
	{
	for ($i = 0; $i < strlen($letters); ++$i)
		{
		$letter = substr($letters,$i,1);
		$userid = 0 + $_POST[$letter];
		$letter = sqlesc($letter);
		mysqli_query($con_link, "UPDATE mod_letters SET letter = $letter, userid = $userid, added = NOW() WHERE letter = $letter") or sqlerr(__FILE__, __LINE__);
		}
	}

site_header("Gebruikers per letter");

tabel_start();
print("<table width=50% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
print("<br>");
tabel_top("Moderators");
print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print"<td class=embedded align=center><center>";
print "<br>";
print("<table width=20% class=outer border=1 cellspacing=0 cellpadding=5>");
print("<tr>");
print("<td align=center class=colheadsite>Moderator</td>");
print("<td align=center class=colheadsite>Letters</td>");
print("<td align=center class=colheadsite>Totaal</td>");
print("</tr>");
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE class >= 4 ORDER BY username") or sqlerr(__FILE__, __LINE__);	
	while ($row = mysqli_fetch_assoc($res))
		{
		$let = "&nbsp&nbsp;";
		$aantal = 0;
		$userid = $row['id'];
		$res2 = mysqli_query($con_link, "SELECT * FROM mod_letters WHERE userid = $userid") or sqlerr(__FILE__, __LINE__);	
		while ($row2 = mysqli_fetch_assoc($res2))
			{			
			$let .= "<b>" . $row2['letter'] . "</b>&nbsp&nbsp;";
			$aantal = $aantal + get_row_count("users", "WHERE username LIKE '" . $row2['letter'] . "%'");
			}
		
		print "<tr>";
		print "<td bgcolor=white>" . $row['username'] . "</td>";
		print "<td bgcolor=white align=center>$let</td>";
		print "<td bgcolor=white align=right>$aantal</td>";
		print "</tr>";
		}
print("</table>");
print("<br></td></tr></table>");
print("</td></table><br>");

print("<table width=50% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
print("<br>");
tabel_top("Gebruikers per letter");
print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print"<td class=embedded align=center><center>";
print "<br>";
print("<table width=20% class=outer border=1 cellspacing=0 cellpadding=5>");
print("<tr>");
print("<td align=center class=colheadsite>Letters</td>");
print("<td align=center class=colheadsite>Aantal</td>");
print("<td align=center class=colheadsite>Moderator</td>");

print("</tr>");

print("<form method=post action=mods.php>");
print("<input type=hidden name='action' value='opslaan'>");

for ($i = 0; $i < strlen($letters); ++$i)
	{
	$userid = $row['id'];
	print("<tr>");
	print "<td align=center bgcolor=white>" . substr($letters,$i,1) . "</td>";

	$test = get_row_count("users", "WHERE username LIKE '" . substr($letters,$i,1) . "%'");

	print "<td align=center bgcolor=white>" . $test . "</td>";

    print("<td><select name=" . substr($letters,$i,1) . ">");
    print("<option value=0>--- Selecteer een moderator ---</option>");

	$vinden = get_mod(substr($letters,$i,1));

	$res = mysqli_query($con_link, "SELECT * FROM users WHERE class >= 4 ORDER BY username") or sqlerr(__FILE__, __LINE__);	
	while ($row = mysqli_fetch_assoc($res))
	{
	if ($row['id'] == $vinden)
	    print("<option value=" . $row['id'] . " selected=\"selected\">" . $row['username'] . "</option>");
	else
	    print("<option value=" . $row['id'] . ">" . $row['username'] . "</option>");
	}

    print("</select></td>");

	print("</tr>");
	}

	
print("</td></tr></table>");

print "</td></tr><tr><td class=embedded><div align=center><br>";
print ("<input type=submit class=btn style='height: 30px; width: 200px' value='Gegevens opslaan'>");
print("</form><br>");

print("<br></td></tr></table>");
print("</td></table><br>");

tabel_einde();
site_footer();



?>