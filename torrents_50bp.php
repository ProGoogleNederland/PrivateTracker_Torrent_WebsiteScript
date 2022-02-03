<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "U heeft geen rechten op deze pagina.");

$action = (string)@$_POST['action'];

$ammount = 50;

if ($action == "bp_geven")
	{
	$res = mysqli_query($con_link, "SELECT * FROM torrents ORDER BY id") or sqlerr(__FILE__, __LINE__);
	while ($row = mysqli_fetch_assoc($res))
		{
		$totaal = get_row_count("bonus_punten","WHERE torrent_id=".$row['id']." AND sender_id=".$CURUSER['id']);
		if ($totaal <= 0)
			{
			mysqli_query($con_link, "INSERT INTO bonus_punten (torrent_id, receiver_id, sender_id, ammount, added) VALUES (".$row['id'].", ".$row['owner'].", ".$CURUSER['id'].", ".$ammount.", NOW())") or sqlerr(__FILE__, __LINE__);
			mysqli_query($con_link, "UPDATE users SET bonus_punten=bonus_punten+".$ammount." WHERE id=".$row['owner']) or sqlerr(__FILE__, __LINE__);
			}
		}
	}

site_header("BP");
page_start(98);
tabel_top("Torrents waar u nog geen BP aan gegeven heeft","center");
tabel_start(70);

print "<form method=post action=''>";
print "<input type=hidden name=action value=bp_geven>";
print "<input type=submit style='height: 28px;width: 200px' value='Al deze torrents ".$ammount." BP geven'>";
print "</form><br>";

print "<div align=left>";
$res = mysqli_query($con_link, "SELECT * FROM torrents ORDER BY id") or sqlerr(__FILE__, __LINE__);
while ($row = mysqli_fetch_assoc($res))
	{
	$totaal = get_row_count("bonus_punten","WHERE torrent_id=".$row['id']." AND sender_id=".$CURUSER['id']);
	if ($totaal <= 0)
		print "<font color=white>" . $row['name'] . "<br>";
	}

tabel_einde();
page_einde();
site_footer();
?>