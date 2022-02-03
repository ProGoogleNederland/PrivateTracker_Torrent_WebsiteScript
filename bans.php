<?php
/////////////////////////////////////////////////////////////////////
////                                                             ////
////   DIT PHP BESTAND NIET BEWERKEN, AANPASSEN OF VERWIJDEREN   ////
////                                                             ////
////                                                             ////
/////////////////////////////////////////////////////////////////////
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de administrator en hoger.");


$extra_ban[1] = "62.58.44.90";
$extra_ban[2] = "82.175.90.187";
$extra_ban[3] = "80.57.182.88";
$extra_ban[4] = "82.175.90.186";
$extra_ban[5] = "84.80.216.148";
$extra_ban[6] = "86.88.34.38";

$paginas = 6;
for ($i = 1; $i <= $paginas; ++$i)
	{
	$res = mysqli_query($con_link, "SELECT * FROM bans WHERE first=".ip2long($extra_ban[$i])." AND  first=".ip2long($extra_ban[$i])) or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if (!$row)
		{
		$first = ip2long($extra_ban[$i]);
		$last = ip2long($extra_ban[$i]);
		$comment = sqlesc("Systeem ip uitsluiting, niet verwijderbaar.");
		$added = sqlesc(get_date_time());
		mysqli_query($con_link, "INSERT INTO bans (added, addedby, first, last, comment) VALUES($added, 0, $first, $last, $comment)") or sqlerr(__FILE__, __LINE__);
		}
	}

@$start = 0 + $_GET['start'];

$remove = @$_GET['remove'];
if (is_valid_id($remove))
	{
	mysqli_query($con_link, "DELETE FROM bans WHERE id=$remove") or sqlerr();
	write_log("Ban $remove is verwijderd door $CURUSER[id] ($CURUSER[username])");
	}

if ($_SERVER["REQUEST_METHOD"] == "POST" && get_user_class() >= UC_ADMINISTRATOR)
	{
	$first = trim($_POST["first"]);
	$last = trim($_POST["last"]);
	$comment = trim($_POST["comment"]);
	if (!$first || !$comment)
		site_error_message("Foutmelding", "Formulier gegevens ontbreken.");
	$last = $first;
	$first = ip2long($first);
	$last = ip2long($last);
	if ($first == -1 || $last == -1)
		site_error_message("Foutmelding", "Verkeerd IP nummer.");
	$comment = sqlesc($comment);
	$added = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO bans (added, addedby, first, last, comment) VALUES($added, $CURUSER[id], $first, $last, $comment)") or sqlerr(__FILE__, __LINE__);
	header("Refresh: 0; url=bans.php");
	die;
	}
$totaal = get_row_count("bans","");
$per_pagina = 100;
$paginas = floor($totaal / $per_pagina);
if ($paginas * $per_pagina < $totaal)
	++$paginas;

	$site_pager = "<font color=blue size=3>";
	for ($i = 0; $i < $paginas; ++$i)
		{
		$begin = $i*$per_pagina;
		if ($i > 0) $site_pager .= "&nbsp;-&nbsp;";
		$pagina = $i + 1;
		if ($start/$per_pagina == $i)
			$site_pager .= "" . $pagina . "";
		else
			$site_pager .= "<a href=bans.php?start=" . $begin . "><font color=blue size=3><b>" . $pagina . "</b></font></a>";
		}
		$site_pager .= "</font>";
		
$res = mysqli_query($con_link, "SELECT * FROM bans ORDER BY added DESC LIMIT $start,$per_pagina") or sqlerr(__FILE__, __LINE__);
$aantal = get_row_count("bans", "");

if (@function_exists('site_header'))
	site_header("Uitsluitingen");
elseif (@function_exists('thc_header'))
	thc_header("Uitsluitingen");
elseif (@function_exists('new_header'))
	new_header("Uitsluitingen");
else
	die("Kan pagina niet starten, functie ontbreekt op de site");

if (get_user_class() >= UC_ADMINISTRATOR)
	{
	print "<table width=50% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>";
	tabel_top("Uitsluiting toevoegen");
	print "<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=0>";
	print "<tr>";
	print "<td class=embedded align=center><center><br>";

	print "<table width=90% border=1 cellspacing=0 cellpadding=5>\n";
	print "<form method=post action=bans.php>\n";
	print "<tr><td bgcolor=white>IP-nummer</td><td bgcolor=white><input type=text name=first size=60></td>\n";
	print "<tr><td bgcolor=white>Commentaar</td><td bgcolor=white><input type=text name=comment size=60 value='Gebruiker xxx is verbannen omdat:'></td>\n";
	print "<tr><td colspan=2 align=right bgcolor=white><input type=submit value='Gegevens opslaan' style='height: 30px;width: 150px' class=btn></td></tr>\n";
	print "</form>\n</table>\n";
	print "<br>";

	print "</td></tr></table>";
	print "<br></td></tr></table>";
	}

print "<table class=bottom align=center width=98% border=0><tr><td class=embedded><center><font size=3 color=red><b>$aantal IP-Nummer uitsluitingen tot aan vandaag.</td></tr></table><br>";

print $site_pager;
print "<br>";
print "<br>";

if (mysqli_num_rows($res) == 0)
	print("<p align=center><b>Niets gevonden.</b></p>\n");
else
	{
	print "<table align=center border=1 width=98% cellspacing=0 cellpadding=8>\n";
	print "<tr><td bgcolor=black><font color=white><b>Toegevoegd&nbsp;op</td><td bgcolor=black align=left><font color=white><b>IP-nummer</td><td bgcolor=black align=left><font color=white><b>Door</td><td bgcolor=black align=left><font color=white><b>Commentaar</td><td bgcolor=black><font color=white><b>Verwijderen</td></tr>\n";

	while ($arr = mysqli_fetch_assoc($res))
		{
		$r2 = mysqli_query($con_link, "SELECT username FROM users WHERE id=$arr[addedby]") or sqlerr();
		$a2 = mysqli_fetch_assoc($r2);
		$arr["first"] = long2ip($arr["first"]);
		$arr["last"] = long2ip($arr["last"]);
		print "<tr>\n";
		print "<td bgcolor=white><font color=black>" . convertdatum($arr['added'], "no") . "</td>\n";
		print "<td align=left bgcolor=white><font color=black>$arr[first]</td>\n";
		if ($arr['addedby'] == 0)
			print "<td align=left bgcolor=white><b><font color=black>Systeem</td>\n";
		else
			print "<td align=left bgcolor=white><a href=userdetails.php?id=$arr[addedby]><font color=black>".get_username($arr['addedby'])."</a></td>\n";
		print "<td align=left width=99% bgcolor=white><font color=black>$arr[comment]</td>\n";
		if ($arr['addedby'] == 0)
			{
			if ($CURUSER['id'] == 1)
				print "<td bgcolor=white><a class=altlink_red href=bans.php?remove=$arr[id]>Verwijder&nbsp;LET&nbsp;OP&nbsp;IS&nbsp;SYSTEEMBAN</a></td>\n";
			else
				print "<td bgcolor=white> </td>\n";
			}
		else
			print "<td bgcolor=white><a class=altlink_red href=bans.php?remove=$arr[id]>Verwijder</a></td>\n";
		print "</tr>\n";
		}
	print("</table>\n");
	}

print("<br>");
print $site_pager;
print "<br>";
print "<br>";
if (@function_exists('site_footer'))
	site_footer();
elseif (@function_exists('thc_footer'))
	thc_footer();
elseif (function_exists('new_footer'))
	new_footer();
/////////////////////////////////////////////////////////////////////
////                                                             ////
////   DIT PHP BESTAND NIET BEWERKEN, AANPASSEN OF VERWIJDEREN   ////
////                                                             ////
////                                                             ////
/////////////////////////////////////////////////////////////////////
?>