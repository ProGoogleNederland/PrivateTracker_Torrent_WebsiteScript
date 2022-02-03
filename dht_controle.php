<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();

if (get_user_class() < UC_SYSOP)
	site_error_message("Foutmelding", "U heeft geen rechten op deze pagina.");

loggedinorreturn();
site_header("DHT");
page_start(98);
tabel_top("Overzicht torrents waar DHT aan staat","center");
tabel_start(70);
$count = 1;
print "<div align=left>";
$res = mysqli_query($con_link, "SELECT id, name, filename, owner FROM torrents ORDER BY id DESC LIMIT 1000") or sqlerr(__FILE__, __LINE__);
while ($row = mysqli_fetch_assoc($res))
	{

	$test = @file_get_contents("torrents/" . $row['filename']);
	$ann_1 = substr_count($test, "announce.php?passkey");
	$ann_2 = substr_count($test, ":announce-list");

	if (substr_count($test, "announce.php?passkey") > 1 && substr_count($test, ":announce-list") > 0)
//	if (!strstr($test, "privatei1"))
		{
		print "<font color=yellow size=2>".$count++." - <a class=altlink_white href=details.php?id=".$row['id'].">".$row['name']."</a> - Door:<a class=altlink_white href=userdetails.php?id=".$row['owner'].">".get_username($row['owner'])."</a>";
		print "<br>";
		}

	}

tabel_einde();
page_einde();
site_footer();
?>