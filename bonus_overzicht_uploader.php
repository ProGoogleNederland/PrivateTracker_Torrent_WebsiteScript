<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

$maand = (string)@$_GET['maand'];
$dag = (string)@$_GET['dag'];
	
site_header("BP uploader");
page_start(99);
tabel_top("BP overzicht uploader","center");
tabel_start();

$MAAND['1'] = array("nummer"=>"01","naam"=>"Januari","max"=>"31");
$jaar  = date("Y");
if(($jaar / 4) == round($jaar / 4))
	$MAAND['2'] = array("nummer"=>"02","naam"=>"Februari","max"=>"29");
else
	$MAAND['2'] = array("nummer"=>"02","naam"=>"Februari","max"=>"28");
$MAAND['3'] = array("nummer"=>"03","naam"=>"Maart","max"=>"31");
$MAAND['4'] = array("nummer"=>"04","naam"=>"April","max"=>"30");
$MAAND['5'] = array("nummer"=>"05","naam"=>"Mei","max"=>"31");
$MAAND['6'] = array("nummer"=>"06","naam"=>"Juni","max"=>"30");
$MAAND['7'] = array("nummer"=>"07","naam"=>"Juli","max"=>"31");
$MAAND['8'] = array("nummer"=>"08","naam"=>"Augustus","max"=>"31");
$MAAND['9'] = array("nummer"=>"09","naam"=>"September","max"=>"30");
$MAAND['10'] = array("nummer"=>"10","naam"=>"Oktober","max"=>"31");
$MAAND['11'] = array("nummer"=>"11","naam"=>"November","max"=>"30");
$MAAND['12'] = array("nummer"=>"12","naam"=>"December","max"=>"31");

if (!$maand)
	$maand  = date("m");
if (strlen($maand) < 2)
	$maand = "0" . $maand;

if (!$dag)
	$dag  = date("d");
if (strlen($dag) < 2)
	$dag = "0" . $dag;
	
print "<table width=200 class=outer border=1 cellspacing=0 cellpadding=5>\n";
print "<tr>\n";
$i = 1;
while ($i <= 12)
	{
	if (strlen($i) < 2)
		$zoek = "0" . $i;
	else
		$zoek = $i;
	$count_maand = get_row_count("bonus_punten","WHERE added LIKE '%-".$zoek."-%'");
	
	print "<td bgcolor=white align=center>\n";	
	if ($count_maand && $zoek == $maand)
		{
		if ($zoek == $maand)
			print "<a class=altlink_red href='?maand=".$i."'><font size=+1>" . $MAAND[$i]['naam'] . "</a>";
		else
			print "<a class=altlink_green href='?maand=".$i."'>" . $MAAND[$i]['naam'] . "</a>";
		}
	else
		print "<font color=gray>".$MAAND[$i]['naam'];
	print "</td>\n";
	$i++;
	}
print "</tr></table>\n";
print "<table width=200 class=outer border=1 cellspacing=0 cellpadding=5>\n";
print "<tr>\n";

$i = 1;
while ($i <= $MAAND[round($maand)]['max'])
	{
	$count_dag = get_row_count("bonus_punten","WHERE added LIKE '%-".$maand."-%' AND added LIKE '%-".$i." %'");
	
	print "<td bgcolor=white align=center>\n";	
	if ($count_dag > 0)
		{
		if ($i == $dag)
			print "<a class=altlink_red href='?maand=".$maand."&dag=".$i."'><font size=+1>" . $i . "</a>";
		else
			print "<a class=altlink_green href='?maand=".$maand."&dag=".$i."'>" . $i . "</a>";
		}
	else
		print "<font color=gray>".$i;
	print "</td>\n";
	$i++;
	}
print "</tr></table>\n";

$count_dag = get_row_count("bonus_punten","WHERE added LIKE '%-".$maand."-%' AND added LIKE '%-".$dag." %'");

if ($count_dag > 0)
	{
	$PRINT[@$tt] = "<br><table width=250 class=outer border=1 cellspacing=0 cellpadding=5>";
	$PRINT[@$tt] .= "<tr>";
	$PRINT[@$tt] .= "<td class=colheadsite align=center><font size=4><b>".convertdatum($jaar."-".$maand."-".$dag,"no")."</td>";
	$PRINT[@$tt] .= "</td></tr><tr><td bgcolor=white align=center>";
	
	$PRINT[@$tt] .= "<table width=240 class=outer border=1 cellspacing=0 cellpadding=5>";
	$PRINT[@$tt] .= "<tr>";
	$PRINT[@$tt] .= "<td class=colheadsite>Uploader</td>";
	$PRINT[@$tt] .= "<td class=colheadsite>Ontvangen BP</td>";
	$PRINT[@$tt] .= "</tr>";

	$res = mysqli_query($con_link, "SELECT * FROM users WHERE class >= 3 ORDER BY username") or sqlerr(__FILE__, __LINE__);
	while ($row = mysqli_fetch_assoc($res))
		{
		$totaal_ontvangen = 0;
		//var_dump("SELECT * FROM bonus_punten WHERE receiver_id=".$row['id'] ." AND  added LIKE '%-".$maand."-%' AND added LIKE '%-".$dag." %'");
		$res_totaal = mysqli_query($con_link, "SELECT * FROM bonus_punten WHERE receiver_id=".$row['id'] ." AND  added LIKE '%-".$maand."-%' AND added LIKE '%-".$dag." %'") or sqlerr(__FILE__, __LINE__);
		while ($row_totaal = mysqli_fetch_assoc($res_totaal))
			$totaal_ontvangen += $row_totaal['ammount'];
	
		if ($totaal_ontvangen > 0)
			{
			@$teller++;
			$TOP[@$teller] = array("totaal"=>$totaal_ontvangen,"receiver"=>$row['id']);
			}
		}
	
	rsort ($TOP);
	
	$i = 0;
	while ($i <= $teller - 1)
		{
		$PRINT[@$tt] .= "<tr>";
		$PRINT[@$tt] .= "<td align=left bgcolor=white>" . get_username($TOP[$i]['receiver']) . "</td>";
		$PRINT[@$tt] .= "<td bgcolor=white align=right>" . $TOP[$i]['totaal'] . "</td>";
		$PRINT[@$tt] .= "</td>";
		$PRINT[@$tt] .= "</tr>";
		$i++;
		}
	
	$PRINT[@$tt] .= "</table>";
	print $PRINT[@$tt];
	}
else
	print "<br><font size=4 color=white><b>Niets gevonden op ".convertdatum($jaar."-".$maand."-".$dag,"no")."<br><br>";	
print "</td></tr></table>";
tabel_einde();
page_einde();
site_footer();
?>