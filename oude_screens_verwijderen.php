<?php
///////////////////////////////////////////////////////////////
///                                                         ///
///                     DLFSU.ORG                           ///
///                                                         ///
///////////////////////////////////////////////////////////////
/// Dlfsuinstelingen.php Deze mod is geen free ware         ///
/// Bij diefstal van deze mod zullen wij actie ondernemen.  ///
/// Made by underground van Dlfsu.org. 04-07-2009           ///
/// update date -- -- ---     Door:                         ///
/// Dlfsu.org more than torrents.                           ///
/// Scripters Mrspeedy and Underground.                     ///
///////////////////////////////////////////////////////////////
///                                                         ///
///                Dont remove !!!!!!                       ///
///                                                         ///
///////////////////////////////////////////////////////////////
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_OWNER)
	site_error_message("Foutmelding", "U heeft geen rechten op deze pagina.");

$allowedfiles[] = "gif";
$allowedfiles[] = "jpg";
$allowedfiles[] = "jpeg";
$allowedfiles[] = "png";
$allowedfiles[] = "GIF";
$allowedfiles[] = "JPG";
$allowedfiles[] = "JPEG";
$allowedfiles[] = "PNG";

site_header("Oude screens verwijderen");
page_start(99);
tabel_top("Oude screens verwijderen","center");
tabel_start();

$dir    = 'screens/';
$files = scandir($dir);
$totaal = 0;

foreach($files as $file)
	{
	$torrent_id = round(str_replace(strchr($file, "."),"", $file));
	if ($torrent_id > 0)
		{
		$res = mysqli_query($con_link, "SELECT * FROM torrents WHERE id=$torrent_id") or sqlerr(__FILE__, __LINE__);
		$row = mysqli_fetch_array($res);
	
		if (!$row)
			{
			$totaal++;
			foreach($allowedfiles as $allowedfile)
				unlink("$screens_dir/$torrent_id.".$allowedfile);
			}
		}
	}
	

print $totaal . " oude screens verwijderd.";

tabel_einde();
page_einde();
site_footer();
?>