<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

	
site_header("Ddos_admin");
page_start(99);
tabel_top('"'.@$aantal.' Ddosaanvallen"');
tabel_start();	
//stderr("w00t", $text);
function puke($text = "w00t")
{
}


if (get_user_class() < UC_SYSOP)
puke();

?>
<p align="center size=4 color=white"><a href="turncate.php">Clear Database</a><br />
<em>Its HIGHLY recomended that you clear the database on a daily basis. </em></p>
<div align="center">
<table width="622" border="1">
<tr>
<td width="571"><div align="center" class="style1">Anti-DDoS Elite</div></td>
</tr>
</table>
<table width="622" border="1">
<tr>
<td width="571"><div align="center">IP Addres </div></td>
<td width="571"><div align="center">Number Times accessed </div></td>
</tr>
<?php
//include("include/connect.php");
$result = mysqli_query($con_link, "SELECT ips, COUNT(ips) AS NumOccurrences FROM ips GROUP BY ips HAVING ( COUNT(ips) > 1 ) order by NumOccurrences desc");
while($r=@mysqli_fetch_array($result))
{
$ips=$r["ips"];
$NumOccurrences=$r["NumOccurrences"];
echo "<tr><td>$ips</td><td>[$NumOccurrences]</td></tr>";
}
?>
</table>
</div>
<?
puke();
?>