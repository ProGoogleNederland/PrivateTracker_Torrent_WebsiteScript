<?php
include('include/bittorrent.php');
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();
if (get_user_class() < UC_SYSOP)
	stderr("Fout", "Toegang Geweigerd.");

site_header("Categorieën");tabel_start();
print("</br>");
print("<table width=100% border=1 cellspacing=0 cellpadding=2><tr><td align=center>\n");

///////////////////// D E L E T E C A T E G O R Y \\\\\\\\\\\\\\\\\\\\\\\\\\\\

$sure = @$_GET['sure'];
if($sure == "yes") {
	$delid = (int)@$_GET['delid'];
	$query = "DELETE FROM categories WHERE id=" .sqlesc($delid) . " LIMIT 1";
	$sql = mysqli_query($con_link, $query);
	echo("Categorie is succesvol verwijderd! [ <a href='category.php'>Terug</a> ]");
	tabel_einde();
	site_footer();
	die();
}
$delid = (int)@$_GET['delid'];
$name = htmlspecialchars(@$_GET['cat']);
if($delid > 0) {
	echo("Weet je het zeker dat je deze categorie wilt verwijderen? ($name) ( <strong><a href='". $_SERVER['SCRIPT_NAME'] . "?delid=$delid&cat=$name&sure=yes'>Ja</a></strong> / <strong><a href='". $_SERVER['SCRIPT_NAME'] . "'>Nee</a></strong> )");
	tabel_einde();
	site_footer();
	die();

}

///////////////////// E D I T A C A T E G O R Y \\\\\\\\\\\\\\\\\\\\\\\\\\\\
$edited = @$_GET['edited'];
if($edited == 1) {
	$id = (int)@$_GET['id'];
	$cat_name = sqlesc(@$_GET['name']);
	$cat_img = sqlesc(@$_GET['img']);
	$query = "UPDATE categories SET name = ".sqlesc($cat_name).", image = ".sqlesc($cat_img).", WHERE id=".sqlesc($id);
	 mysqli_query($con_link, $query);
		echo("<table class=main cellspacing=0 cellpadding=5 width=100%>");
		echo("<tr><td><div align='center'>Goed gedaan! Jou categorie is <strong>succesvol!</strong> veranderd [ <a href='category.php'>Terug</a> ]</div></tr>");
		echo("</table>");
		tabel_einde();
		site_footer();
		die();
}

$editid = (int)@$_GET['editid'];
$name = htmlspecialchars(@$_GET['name']);
$img = htmlspecialchars(@$_GET['img']);
if($editid > 0) {
echo("<form name='form1' method='get' action='" . $_SERVER['SCRIPT_NAME'] . "'>");
echo("<table class=main cellspacing=0 cellpadding=5 width=100%>");
echo("<div align='center'><input type='hidden' name='edited' value='1'>Categorie <strong>\"$name\"</strong> aan het veranderen</div>");
echo("<br>");
echo("<input type='hidden' name='id' value='$editid'<table class=main cellspacing=0 cellpadding=5 width=100%>");
echo("<tr><td>Categorie Naam: </td><td align='left'><input type='text' id='specialboxn' size=50 name='cat_name' value='$name'></td></tr>");
echo("<tr><td>Categorie Plaatje Naam: </td><td align='left'><input type='text' id='specialboxn' size=50 name='cat_img' value='$img'> Niet het pad invullen. Vul alleen bestand naam in.</td></tr>");
echo("</select><input type='Submit' class='btn' value='Categorie Opslaan'></td></tr>");
echo("</table></form>");
tabel_einde();
site_footer();
die();
}

///////////////////// A D D A N E W C A T E G O R Y \\\\\\\\\\\\\\\\\\\\\\\\\\\\
$add = @$_GET['add'];
if($add == 'true') {
	$cat_name = htmlspecialchars($_GET['cat_name']);
	$cat_img = htmlspecialchars($_GET['cat_img']);
	if (!$cat_name OR !$cat_img) {
		stdmsg('Fout','Geen velden leeg laten!');
		tabel_einde();
		site_footer();
		die;
	}
	$query = "INSERT INTO categories SET name = ".sqlesc($cat_name).", image = ".sqlesc($cat_img)."";
	$sql = mysqli_query($con_link, $query) or sqlerr(__FILE__, __LINE__);
	if($sql) {
		$success = TRUE;
	} else {
		$success = FALSE;
	}
}
print("<strong>Nieuwe categorie toevoegen!</strong>");
print("<br />");
print("<br />");
echo("<form name='form1' method='get' action='" . $_SERVER['SCRIPT_NAME'] . "'>");
echo("<table class=main cellspacing=0 cellpadding=5 width=100%>");
echo("<tr><td>Categorie Naam: </td><td align='left'><input type='text' id='specialboxn' size=50 name='cat_name'></td></tr>");
echo("<tr><td>Categorie plaatjes naam: </td><td align='left'><input type='text' id='specialboxn' size=50 name='cat_img'><input type='hidden' name='add' value='true'> Niet het pad invullen. Vul alleen bestand naam in.</td></tr>");
?>
        </select>
		<input type='Submit' class='btn' value='Categorie toevoegen'>
    </td>
  </tr>
<?php
echo("</table>");
if(@$success == TRUE) {
print("<strong>Succes!</strong>");
}
echo("<br>");
echo("</form>");

///////////////////// E X I S T I N G C A T E G O R I E S \\\\\\\\\\\\\\\\\\\\\\\\\\\\

print("<strong>Bestaande categorien:</strong>");
print("<br />");
print("<br />");
echo("<table class=main cellspacing=0 cellpadding=5 width=100%>");
echo("<tr><td class=colhead align=center>ID</td><td class=colhead>Naam</td><td class=colhead align=center>Mimimum Lees Permissie</td><td class=colhead align=center>Plaatje</td><td class=colhead align=center>Zoek</td><td class=colhead align=center>Verander</td><td align=center class=colhead>Verwijder</td></tr>");
$query = "SELECT * FROM categories WHERE 1=1";
$sql = mysqli_query($con_link, $query);
while ($row = mysqli_fetch_array($sql)) {
	$id = htmlspecialchars($row['id']);
	$name = htmlspecialchars($row['name']);
	$img = htmlspecialchars($row['image']);
	echo("<tr><td align=center><strong>$id</strong></td><td><strong>$name</strong></td><td align=center>" . get_user_class_name(@$row["minclassread"]) . "</td><td align=center><img src='".@$rootpath.$pic_base_url."$img' border='0' /></td><td><div align='center'><a href='".$BASEURL."/browse.php?cat=$id'><img src='".@$rootpath.$pic_base_url."viewnfo.gif' border='0' class=special /></a></div></td> <td><a href='category.php?editid=$id&name=$name&img=$img'><div align='center'><img src='".@$rootpath.$pic_base_url."edit.gif' border='0' class=special /></a></div></td> 
	<td><div align='center'><a href='category.php?delid=$id&cat=$name'><img src='".@$rootpath.$pic_base_url."delete.gif' border='0' class=special align='center' /></a></div></td></tr>");
}
tabel_einde();
tabel_einde();
site_footer();
?>