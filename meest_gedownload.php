<?php
ob_start("ob_gzhandler");
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();
//set_max_torrents($CURUSER['id']);

$cats = genrelist();

$fff = @$_GET['search'];
$searchstr = unesc($fff);
$cleansearchstr = searchfield($searchstr);
if (empty($cleansearchstr))
	unset($cleansearchstr);

$orderby = "ORDER BY torrents.times_completed DESC";

$addparam = "";
$wherea = array();
$wherecatina = array();

if (@$_GET["incldead"] == 1)
	{
	$addparam .= "incldead=1&amp;";
	if (!isset($CURUSER) || get_user_class() < UC_ADMINISTRATOR)
		$wherea[] = "banned != 'yes'";
	}
elseif (@$_GET["incldead"] == 2)
	{
	$addparam .= "incldead=2&amp;";
	$wherea[] = "visible = 'no'";
	}
else
	$wherea[] = "visible = 'yes'";

$category = @$_GET["cat"];

$all = @$_GET["all"];

if (!$all)
	if (!$_GET && $CURUSER["notifs"])
		{
		$all = True;
		foreach ($cats as $cat)
			{
			$all &= $cat['id'];
			if (strpos($CURUSER["notifs"], "[cat" . $cat['id'] . "]") !== False)
				{
				$wherecatina[] = $cat['id'];
				$addparam .= "c$cat[id]=1&amp;";
				}
			}
		}
	elseif ($category)
		{
		if (!is_valid_id($category))
			site_error_message("Foutmelding", "Foutieve groep ID.");
		$wherecatina[] = $category;
		$addparam .= "cat=$category&amp;";
		}
	else
		{
		$all = True;
		foreach ($cats as $cat)
			{
			$all &= @$_GET["c$cat[id]"];
			if (@$_GET["c$cat[id]"])
				{
				$wherecatina[] = $cat['id'];
				$addparam .= "c$cat[id]=1&amp;";
				}
			}
		}

if ($all)
	{
	$wherecatina = array();
	$addparam = "";
	}

if (count($wherecatina) > 1)
	$wherecatin = implode(",",$wherecatina);
elseif (count($wherecatina) == 1)
	$wherea[] = "category = $wherecatina[0]";

$wherebase = $wherea;

if (isset($cleansearchstr))
	{
	$wherea[] = "MATCH (search_text, ori_descr) AGAINST (" . sqlesc($searchstr) . ")";
	$addparam .= "search=" . urlencode($searchstr) . "&amp;";
	$orderby = "";
	}

$where = implode(" AND ", $wherea);
if (@$wherecatin)
	$where .= ($where ? " AND " : "") . "category IN(" . $wherecatin . ")";

if ($where != "")
	$where = "WHERE $where";

$res = mysqli_query($con_link, "SELECT COUNT(*) FROM torrents $where") or die(mysqli_error());
$row = mysqli_fetch_array($res);
$count = $row[0];

if (!$count && isset($cleansearchstr)) {
	$wherea = $wherebase;
	$orderby = "ORDER BY id times_completed";
	$searcha = explode(" ", $cleansearchstr);
	$sc = 0;
	foreach ($searcha as $searchss) {
		if (strlen($searchss) <= 1)
			continue;
		$sc++;
		if ($sc > 5)
			break;
		$ssa = array();
		foreach (array("search_text", "ori_descr") as $sss)
			$ssa[] = "$sss LIKE '%" . sqlwildcardesc($searchss) . "%'";
		$wherea[] = "(" . implode(" OR ", $ssa) . ")";
	}
	if ($sc) {
		$where = implode(" AND ", $wherea);
		if ($where != "")
			$where = "WHERE $where";
		$res = mysqli_query($con_link, "SELECT COUNT(*) FROM torrents $where");
		$row = mysqli_fetch_array($res);
		$count = $row[0];
	}
}

$torrents_per_pagina = 25;

if ($count)
	{
	list($pagertop, $pagerbottom, $limit) = pager($torrents_per_pagina, $count, "browse.php?" . $addparam);
	$query = "SELECT torrents.id, IF(torrents.numratings < $minvotes, NULL, ROUND(torrents.ratingsum / torrents.numratings, 1)) AS rating, torrents.category, torrents.leechers, torrents.seeders, torrents.name, torrents.times_completed, torrents.size, torrents.added, torrents.comments,torrents.numfiles,torrents.filename,torrents.owner,IF(torrents.nfo <> '', 1, 0) as nfoav," .
	"categories.name AS cat_name, categories.image AS cat_pic, users.username FROM torrents LEFT JOIN categories ON category = categories.id LEFT JOIN users ON torrents.owner = users.id $where $orderby $limit";
	$res = mysqli_query($con_link, $query) or die(mysqli_error());
	}
else
	unset($res);

site_header("Torrents");    
   
?>
<?php
page_start(100);tabel_start();
tabel_top ("Laatste 20 torrents");
//Start of Last X torrents with poster mod
$query="SELECT id, name, category, cover as poster FROM torrents WHERE visible='yes' and category NOT IN ('32','39','44','45') ORDER BY added DESC LIMIT 20";
$result=mysqli_query($con_link, $query);
$num = mysqli_num_rows($result); // count rows
?>

<table width="99%" align="center" class="bottom" border="0" cellspacing="5" cellpadding="0">
    <tr>
        <td class="embedded">
            <table width="100%" align="center" class="bottom" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="embedded">
                        <table background="/pic/statusbar/table_background.gif" border="0" cellpadding="5" width="100%">
                            <tr>
                                <td>
                                    <marquee scrollAmount="5" onmouseover="stop();"  onmouseout="start();" scrolldelay="0" direction="right">
                                        <?php
                                        $i = 40;
                                        while ($row = mysqli_fetch_assoc($result))
                                        {
                                            if($row['poster'] != ""){
                                                $id = $row['id'];
                                                $name = $row['name'];
                                                $poster = $row['poster'];
                                                $category = $row['category'];
                                                $name = str_replace('_', ' ' , $name);
                                                $name = str_replace('.', ' ' , $name);
                                                $name = substr($name, 0, 50);
                                                echo "<a href=\"$BASEURL/details.php?id=$id\" title=\"$name\"><img src=".$row["poster"]." width=\"117\" height=\"170\" title=\"$name\" border=\"0\"  padding-bottom=\"25px\" /></a>&nbsp;&nbsp;&nbsp;";
                                                $i++;
                                            }
                                        }
                                        //End of the mod
                                        ?>
                                    </marquee>
									</br>
									</br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table><?php tabel_einde(); ?><?php print "</br>"; ?><?php tabel_start(); ?>
<table background="pics/system/info_menu.gif" width="99%" border=0 cellpadding="5" cellspacing="0">
<tr>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=26>Film (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 26); ?>)</a></td>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=27>Series (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 27); ?>)</a></td>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=28>Kids  (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 28); ?>)</a></td>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=29>Apps (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 29); ?>)</a></td>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=30>Windows (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 30); ?>)</a></td>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=31>Ebooks (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 31); ?>)</a></td>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=32>XXX (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 32); ?>)</a></td>
</tr><tr>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=33>HD&nbsp;Films  (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 33); ?>)</a></td>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=34>HD&nbsp;Series (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 34); ?>)</a></td>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=35>HD&nbsp;Kids (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 35); ?>)</a></td>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=36>Games (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 36); ?>)</a></td>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=37>Mac (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 37); ?>)</a></td>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=38>Stripboeken (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 38); ?>)</a></td>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=39>HD XXX (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 39); ?>)</a></td>
</tr><tr>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=40>4K&nbsp;Films  (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 40); ?>)</a></td>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=41>4K&nbsp;Series (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 41); ?>)</a></td>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=46>4K&nbsp;Kids (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 46); ?>)</a></td>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=meest_gedownload.php?>Meest gedownload</a></td>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=43>Linux (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 43); ?>)</a></td>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=44>XXX boeken (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 44); ?>)</a></td>
<td height=20 width=110 class=embedded><div align=center><a class=altlink_white href=browse.php?cat=45>4K XXX (<?php echo $torrents = get_row_count("torrents", "WHERE category=" . 45); ?>)</a></td>
</tr><tr>


</td></tr>
</table><?php tabel_einde(); ?><?php print "</br>"; ?><?php tabel_start(); ?>
<table width="99%" border=0 cellpadding="5" cellspacing="0" class=bottom>
<tr>
<td bgcolor="#000000"><a class=altlink_black href=browse.php?all=1><b>Alles weergeven</b></a></td>
<td bgcolor="#000000" align="right">
<table class=main border=0 cellspacing=0 cellpadding=0><tr><td bgcolor="#000000" class=embedded>
<form method="get" action=browse.php>

<font color=blue><b>Zoek opdracht:</b></font>
<input type="text" name="search" size="40" value="<?php echo  htmlspecialchars($searchstr) ?>" />
in
<select name="cat">
<option value="0">(alle groepen)</option>
<?


$cats = genrelist();
$catdropdown = "";
foreach ($cats as $cat) {
    $catdropdown .= "<option value=\"" . $cat["id"] . "\"";
    if ($cat["id"] == @$_GET["cat"])
        $catdropdown .= " selected=\"selected\"";
    $catdropdown .= ">" . htmlspecialchars($cat["name"]) . "</option>\n";
}

$deadchkbox = "<input type=\"radio\" name=\"incldead\" value=\"1\"";
if ($_GET["incldead"])
    $deadchkbox .= " checked=\"checked\"";
$deadchkbox .= " /><font color=blue><b> inclusief dode torrents</b></font>\n";

?>
<?php echo  $catdropdown ?>
</select>
<?php echo  $deadchkbox ?>
<input type="submit" value="Zoeken" />
</form>
</td></tr></table>
</td>
</tr>
</table>
</form>


<?php
//print "<center><font color=red size=2><b>LET OP: Indien u na het ontvangen direct stopt en niet blijft delen tot 1 op 1, gaat u een waarschuwing krijgen.</font></center>";
//print "<center><font color=red size=2><b>Als u wilt dat de uploaders gemotiveerd blijven, plaats dan eens een commentaar bij de torrent. En druk eens op de bedank knop.</font></center>";

if (isset($cleansearchstr))
print("<h2>Zoekresultaten voor \"" . htmlspecialchars($searchstr) . "\"</h2>\n");
tabel_einde();print "</br>";
if ($count)
	{tabel_start();
	print($pagertop);tabel_einde();print "</br>";
	torrenttable($res);tabel_start();
	print($pagerbottom);tabel_einde();
	}
else
	{
	if (isset($cleansearchstr))
		{
		print("<h2>Niets gevonden!</h2>\n");
		print("<p>Probeer het opnieuw met andere zoekopdracht.</p>\n");
		}
	else
		{
		print("<h2>Geen torrents</h2>\n");
		print("<p>Er zijn geen torrents aanwezig hier. Sorry vriend :(</p><br>\n");
		}
	}

mysqli_query($con_link, "UPDATE users SET last_browse = NOW() where id=".$CURUSER['id']);
page_einde();
site_footer();
?>
