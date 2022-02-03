<?php
require "include/bittorrent.php";
dbconn(true);
loggedinorreturn();

$site_pics_dir = "pic";
$serverpath = "pic/";
$urltoimages = __DIR__."/pic/support";
$maxsize = 2*1024*1024;

if (get_user_class() < UC_SYSOP)
	site_error_message("Foutmelding", "U heeft geen toegang tot deze pagina.");

$action = (string)@$_GET['action'];

if ($action == "upload_logo")
	{
	$file = $_FILES['file']['name'];

	$allowedfiles[] = "gif";
	$allowedfiles[] = "GIF";
	
	$i = strrpos($file, ".");
	$ext = strtolower(substr($file, $i));
	$file = strtolower("support" . $ext);

	if($_FILES['file']['size'] > $maxsize)
		site_error_message("Foutmelding", "<font color=red>Bestand wat u stuur is te groot.");
	else
		{
		$path = "$urltoimages/support.gif";
		foreach($allowedfiles as $allowedfile)
			{
			$tmp = "support." . $allowedfile;
		   	$tmppath = "$urltoimages/$tmp";
			if (file_exists($tmppath) && $path !== $tmppath)
				unlink("$urltoimages/$tmp");

				if (file_exists($path)) {
					unlink($path);
				}
			
			if (substr($file, -3) == $allowedfile)
				{
				move_uploaded_file($_FILES['file']['tmp_name'], "$path");
				$done = "yes";
				site_error_message("Melding", "<font color=red>Uploaden gelukt. (<a class=altlink_red href=support.php>Ga terug naar pagina</a>)");
				}
			}
			if ($done <> "yes")
				site_error_message("Foutmelding", "<font color=red>Uploaden mislukt, onbekende extensie ontvangen.");
		}
	}


site_header("Support");
page_start(80);
tabel_top("Support","center");
tabel_start();
print "<hr>";
print "<br><font size=4><b>Alleen .gif | maximaal 400px x 50px";
print "<hr>";
print "<img src=pic/support/support.gif>";
print "<form method=post action=\"?action=upload_logo\" enctype=\"multipart/form-data\">";
print "<table width=80% border=1 cellspacing=0 cellpadding=8>";
print "<tr><td bgcolor=white class=rowhead>Support 1</td><td bgcolor=white align=center><input type=file name=file size=80></td></tr>";
print "<tr>";
print "<td bgcolor=white colspan=2 align=center>";
print "<input type=submit name=Submit value=\"Verzenden\" class=btn>";
print "</td></tr>";
print "</table></form>";

tabel_einde();
page_einde();
site_footer();
?>