<?php

require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
if (!mkglobal("id"))
	site_error_message("Verwijderen mislukt!", "Gegevens ontbreken");

$id = 0 + $id;
if (!$id)
	die();

dbconn();
loggedinorreturn();

$res = mysqli_query($con_link, "SELECT filename,name,owner,seeders FROM torrents WHERE id = $id");
$row = mysqli_fetch_array($res);
if (!$row)
	die();

if ($CURUSER["id"] != $row["owner"] && get_user_class() < UC_MODERATOR)
	site_error_message("Verwijderen mislukt!", "U bent niet de eigenaar ban deze torrent, hoe kan dat nou.");

$rt = 0 + $_POST["reasontype"];

if (!is_int($rt) || $rt < 1 || $rt > 5)
	site_error_message("Verwijderen mislukt!", "Ongeldige reden: $rt.");

$r = @$_POST["r"];
$reason = @$_POST["reason"];

if ($rt == 1)
	$reasonstr = "Dood: geen delers/ontvangers meer";
elseif ($rt == 2)
	$reasonstr = "Dubbel" . ($reason[0] ? (": " . trim($reason[0])) : "!");
elseif ($rt == 3)
	$reasonstr = "Niet werkende uitgave" . ($reason[1] ? (": " . trim($reason[1])) : "!");
elseif ($rt == 4)
{
	if (!$reason[2])
	site_error_message("Verwijderen mislukt!", "Omschrijf de regel die is overtreden.");
  $reasonstr = "Overtreding van de regels: " . trim($reason[2]);
}
else
{
	if (!$reason[3])
	site_error_message("Verwijderen mislukt!", "Geef een reden waarom deze torrent verwijderd dient te worden.");
  $reasonstr = trim($reason[3]);
}

$filename = $row['filename'];

deletetorrent($id,$filename);

write_log("Torrent $id ($row[name]) is verwijderd door $CURUSER[username] ($reasonstr)\n");

site_header("Torrent verwijderd!");

if (isset($_POST["returnto"]))
	$ret = "<a href=\"" . htmlspecialchars($_POST["returnto"]) . "\">Terug</a>";
else
	$ret = "<a href=\"./\">Terug naar hoofdmenu</a>";

?>
<h2>Torrent verwijderd!</h2>
<p><?php echo  $ret ?></p>
<?

site_footer();


?>