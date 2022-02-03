<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_GOD)
	site_error_message("Foutmelding", "U heeft geen rechten op deze pagina.");

$allowedfiles[] = "gif";
$allowedfiles[] = "jpg";
$allowedfiles[] = "jpeg";
$allowedfiles[] = "png";
$allowedfiles[] = "GIF";
$allowedfiles[] = "JPG";
$allowedfiles[] = "JPEG";
$allowedfiles[] = "PNG";

site_header("Oude covers verwijderen");
page_start(99);
tabel_top("Oude coverss verwijderen","center");
tabel_start();

$dir    = 'covers/';
$files = scandir($dir);
$totaal = 0;

foreach($files as $file)
	{
	$torrent_id = round(str_replace(strchr($file, "."),"", $file));
	if ($torrent_id > 0)
		{
		$res = mysqli_query($con_link, "SELECT * FROM torrents WHERE id=$torrent_id") or sqlerr(__FILE__, __LINE__);
		$row = mysqli_fetch_array($res);
		//var_dump($row);
		if (!$row)
			{
			$totaal++;
			foreach($allowedfiles as $allowedfile)
				@unlink($cover_dir."/".$torrent_id.$allowedfile);
			}
		}
	}

print $totaal . " oude covers verwijderd.";
tabel_einde();
page_einde();
site_footer();
?>