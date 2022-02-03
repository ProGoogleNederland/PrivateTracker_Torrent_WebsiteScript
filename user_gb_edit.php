<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_SYSOP)
	site_error_message("Foutmelding", "U ben niet bevoegd om deze pagina te bekijken.");

$extra = "";
$user_id = 0 + $_GET['user_id'];

$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
$row = mysqli_fetch_array($res);

if (!$row)
	site_error_message("Foutmelding", "Geen gebruiker gevonden met dit id.");

$uploaded = $row['uploaded'];
$downloaded = $row['downloaded'];

if (!$user_id)
	site_error_message("Foutmelding", "Geen gebruikers ID ontvangen.");

$action = @$_GET['action'];

if ($action == "updown")
	{
	$up_new = @$_GET[uploaded];
	$down_new = @$_GET[downloaded];
	$up_sure = @$_GET[up_sure];
	$down_sure = @$_GET[down_sure];

	if (!$up_new && !$down_new && !$up_sure && !$down_sure)
		site_error_message("Foutmelding", "Geen gegevens ontvangen om te gebruiken.");
	
	$modcomment = $row['modcomment'];
	if ($up_sure)
		{
		if ($up_new < 1)		
			site_error_message("Foutmelding", "Totaal verzonden mag niet lager of gelijk dan nul zijn.");

		$upthis = $up_new * 1024 *1024*1024;
		$uploaded = $upthis;
		$modcomment = "Totaal verzonden aangepast op " . convertdatum(gmdate("Y-m-d H:i:s")) . " - door " . $CURUSER['username'] . " - oud = ".mksize($row['uploaded'])." en nieuw = ".mksize($upthis).".\n" . $modcomment;
		mysqli_query($con_link, "UPDATE users SET uploaded = $upthis WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
		
		$extra = "<br><font size=3 color=yellow><b>Gegevens aangepast</b></font><br>";
		}

	if ($down_sure)
		{
		if ($down_new < 1)		
			site_error_message("Foutmelding", "Totaal ontvangen mag niet lager of gelijk dan nul zijn.");

		$upthis = $down_new * 1024 *1024*1024;
		$downloaded = $upthis;
		$modcomment = "Totaal ontvangen aangepast op " . convertdatum(gmdate("Y-m-d H:i:s")) . " - door " . $CURUSER['username'] . " - oud = ".mksize($row['downloaded'])." en nieuw = ".mksize($upthis).".\n" . $modcomment;
		mysqli_query($con_link, "UPDATE users SET downloaded = $upthis WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);

		$extra = "<br><font size=3 color=yellow><b>Gegevens aangepast</b></font><br>";
		}
	if ($extra)
		{
		$modcomment = sqlesc($modcomment);
		mysqli_query($con_link, "UPDATE users SET modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
		}
	}

site_header("GB");
print "<table class=bottom width=60% border=0 cellspacing=0 cellpadding=0>";
print "<tr>";
print "<td align=center class=embedded><div align=center>";
tabel_top("GigaByte gegevens aanpassen van <a class=altlink_yellow href=userdetails.php?id=".$user_id.">" . get_usernamesite($user_id) . "</a>","center");
print "<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=10 cellpadding=0>";
print "<tr>";
print "<td align=center class=embedded><div align=center>";
if ($extra)
	print $extra;

print "<table class=bottom width=60% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded>";

print "<form method=get action=''>";
print "<input type=hidden name=action value=updown>";
print "<input type=hidden name=user_id value=" . $user_id . ">";
print "<tr>";
print "<td class=colheadsite>Soort</td>";
print "<td class=colheadsite>Huidige&nbsp;waarde</td>";
print "<td class=colheadsite align=center>Nieuwe&nbsp;waarde&nbsp;in&nbsp;GB</td>";
print "<td class=colheadsite align=center>Bevestiging</td>";
print "</tr>";
print "<tr>";
print "<td bgcolor=white>Totaal verzonden:</td>";
print "<td bgcolor=white>".mksize($uploaded)."</td>";
print "<td bgcolor=white align=center><input maxlength=5 type=text size=5 name=uploaded value=".makesize($uploaded)."></td>";
print "<td bgcolor=white align=center><input type=checkbox name=up_sure></td>";
print "</tr>";
print "<tr>";
print "<td bgcolor=white>Totaal ontvangen:</td>";
print "<td bgcolor=white>".mksize($downloaded)."</td>";
print "<td bgcolor=white align=center><input maxlength=5 type=text size=5 name=downloaded value='".makesize($downloaded)."'></td>";
print "<td bgcolor=white align=center><input type=checkbox name=down_sure></td>";
print "</tr>";
print "<tr><td bgcolor=white colspan=4 align=center><input type=submit style='height: 24px;width: 150px' value='Gegevens aanpassen'></td></tr>";
print "</form>";

print "<br></td></tr></table>";
print "<br></td></tr></table>";
print "</td></tr></table><br>";

site_footer();

function makesize($bytes)
	{
	return round( $bytes / 1073741824, 0);
	}
?>
