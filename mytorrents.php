<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

site_header($CURUSER["username"] . "'s torrents");

$where = "WHERE owner = " . $CURUSER["id"] . " AND banned != 'yes'";
$res = mysqli_query($con_link, "SELECT COUNT(*) FROM torrents $where");
$row = mysqli_fetch_array($res);
$count = $row[0];

if (!$count) {
?>
<h1>Geen torrents</h1>
<p>U heeft nog geen torrents geupload, dus er staat niets op deze pagina.</p>
<?php
}
else {
	list($pagertop, $pagerbottom, $limit) = pager(20, $count, "mytorrents.php?");

	$res = mysqli_query($con_link, "SELECT torrents.type, torrents.comments, torrents.leechers, torrents.seeders, IF(torrents.numratings < $minvotes, NULL, ROUND(torrents.ratingsum / torrents.numratings, 1)) AS rating, torrents.id, categories.name AS cat_name, categories.image AS cat_pic, torrents.name, save_as, numfiles, added, size, views, visible, hits, times_completed, category FROM torrents LEFT JOIN categories ON torrents.category = categories.id $where ORDER BY id DESC $limit");

	print($pagertop);

	torrenttable($res, "mytorrents");

	print($pagerbottom);
}

site_footer();
?>
