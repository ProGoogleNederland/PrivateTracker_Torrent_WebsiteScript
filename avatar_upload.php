<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

$serverpath = "avatar/";
$urltoimages = $BASEURL."/avatar";
$maxsize = 400 * 1024;

print "<style>input[type=\"text\" i], select, .inputk, .embedded td input {border-radius: 5px;font-family: \"Trebuchet MS\", Helvetica, sans-serif;height: auto;padding: 3px;background-color: rgba(255,255,255,0.2);color: #fff;padding: 10px 30px 10px 30px!important;}</style>";

site_header("Avatar");
print("<table class=bottom width=80% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td align=center class=embedded><div align=center>");
tabel_start();
tabel_top("Avatar uploaden naar " . $SITE_NAME);
print("<table width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td align=center class=embedded><div align=center><br>");

$mode = @$_GET['mode'];
if ($mode == "") { $mode = "form"; }

$avatar_sure = @$_POST['avatar_sure'];

if ($mode == "form") {
print "<form method=post action=\"?mode=upload\" enctype=\"multipart/form-data\">";
print "<table class=bottom width=75% border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>";
print "<font size=4>Een avatar uploaden naar $SITE_NAME. ";
print "Gebruik geen avatars die bij andere mensen kwetsend kunnen overkomen. Plaatjes met XXX zijn niet toegestaan. Als je twijfelt </br>of een plaatje gepast is, schrijf dan een bericht aan een van de mensen uit het Staff</p>";
print "Het bestand dat je verzend zal gewijzigd worden in " . strtolower($CURUSER['username']) . ".gif, " . strtolower($CURUSER['username']) . ".jpg of " . strtolower($CURUSER['username']) . ".png</p>";
print "</br><b>ALLEEN GIF, JPG en PNG kun je uploaden met max 150px breedt/hoog en niet groter als 400 KB.</b></br></br></font>";
if (get_avatar($CURUSER['id']))
	print "</br></br></td><td align=center class=embedded><center><font size=4>Huidige avatar</br></br></font><img height=150 src=" . get_avatar($CURUSER['id']) . "></br></br>";
print "</td></tr></table><br>";
print "<table width=80% border=1 cellspacing=0 cellpadding=8>";
print "<tr><td bgcolor=white align=center><input type=file name=file size=150></td></tr>";
print "<tr>";
print "<td bgcolor=white colspan=2 align=center>";
print "<table class=bottom border=0><tr><td class=embedded>";
print "Wilt u de avatar direct in uw profiel plaatsen?";
print "</td><td class=embedded>";
print "<input type=checkbox name=avatar_sure>";
print "</td><td class=embedded>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
print "<input type=submit name=Submit value=\"Verzenden\" class=btn>";
print("</td></tr></table>");
print "</td></tr>";
print "</table></form><p>";
//print "<table class=bottom width=75% border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>";
//print "<b>Disclaimer:</b> Upload geen verboden, copyrighted of tegen alle regels en algemene normen en waarden indruisende afbeeldingen. Geuploaden afbeeldingen worden beschouwd als \"publiek bezit\"; Upload dus geen afbeeldingen waarvan je niet wilt dat iemand anders er toegang tot heeft. Verder wordt HotLinking binnenkort actief zodat je deze locatie niet kunt gebruiken op andere sites. Deze service is puur bedoelt om je avatar hier te hosten voor deze site, om zo bandbreedte te besparen en de snelheid te bevorderen op de site in zijn algemeen.</font>";
//print "</td></tr></table>";

print("<br></td></tr></table><br>");
tabel_einde();

//  echo "<form enctype='multipart/form-data' method='post' action='?mode=upload'>\n";
//  echo "<input type='file' name='file'>\n";
//  echo "<input type='submit' name='Submit' value='Upload'>\n";
 }

if ($mode == "upload")
	{
	$file = $_FILES['file']['name'];
  	// Als je een eigen extensie wilt toelaten, voeg deze hier toe, vergeet niet om OOK een hoofdletter extensie toe te voegen.
	$allowedfiles[] = "gif";
	$allowedfiles[] = "jpg";
	$allowedfiles[] = "jpeg";
	$allowedfiles[] = "png";
	$allowedfiles[] = "GIF";
	$allowedfiles[] = "JPG";
	$allowedfiles[] = "JPEG";
	$allowedfiles[] = "PNG";
	
	$i = strrpos($file, ".");
	$ext = strtolower(substr($file, $i));
	$file = strtolower($CURUSER['username'] . $ext);

	//   print $file; die;
	// print $file . $i . $ext . " - " . $tmp; die;

	if($_FILES['file']['size'] > $maxsize)
		print "Bestand is te groot. Verklein het bestand en probeer het opnieuw.";
	else
		{
		$path = "$serverpath/$file";
		foreach($allowedfiles as $allowedfile)
			{
			$tmp = strtolower($CURUSER['username'] . "." . $allowedfile);
		   	$tmppath = "$serverpath/$tmp";
			if (file_exists($tmppath) && $path !== $tmppath)
				unlink("$avatar_dir/$tmp");
   			if (@$done <> "yes")
				{
				if (file_exists($path)) 
					unlink("$avatar_dir/$file");
				}
			if (substr($file, -3) == $allowedfile)
				{
				move_uploaded_file($_FILES['file']['tmp_name'], "$path");
					if ($avatar_sure)
						{
						$userid = $CURUSER['id'];
				      	$avatar_send = sqlesc($urltoimages . "/" . $file);
						mysqli_query($con_link, "UPDATE users SET avatar = $avatar_send WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
						}
				$done = "yes";
				tabel_start();
				print "<p><font color=blue size=3>Verzenden is gelukt. Je kunt de image doorlinken via onderstaande URL.</font></p>";
				print "<input type=text name=tmp value='$urltoimages/$file' size=60>";
				print "<p><A href='$urltoimages/$file' target='_blank'><strong>$urltoimages/$file</strong></a></p>";
				print "<p><img src='$urltoimages/$file' border='0'><br><br>";            
				if ($avatar_sure)
					print "<p><a href=userdetails.php?id=" . $userid . ">Klik hier</a> om naar uw gebruikers gegevens pagina te gaan.<br><br>";            
				tabel_einde(); 
				}
			}
			if ($done <> "yes")
				print "<font size=2 color=yellow><p><b>Error:</b> Jouw afbeelding is NIET geupload. De extensie is niet herkend. Probeer het opnieuw AUB.<br><br>";
		}
	}
print("</td></tr></table>");
tabel_einde();
site_footer();  
?>
