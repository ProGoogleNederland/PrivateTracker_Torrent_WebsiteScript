<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

$serverpath = "bedankjes/";
$urltoimages = $BASEURL."/bedankjes";
$maxsize = 400 * 1024;

site_header("Bedankjes uploaden");
print("<table class=bottom width=80% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td align=center class=embedded><div align=center>");

tabel_top("Bedankjes zenden naar " . $SITE_NAME);
print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td align=center class=embedded><div align=center><br>");

$mode = @$_GET['mode'];
if ($mode == "") { $mode = "form"; }

$avatar_sure = @$_POST['avatar_sure'];

if ($mode == "form") {
print "<form method=post action=\"?mode=upload\" enctype=\"multipart/form-data\">";
print "<table class=bottom width=75% border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>";
print "<p>Een bedanktje versturen naar $SITE_NAME is heel eenvoudig.</p>";
print "Denk na voordat je een bedankje kiest. De plaatjes mogen niet breder zijn als 150 pixels en maximaal 400 KB groot. (Browsers zullen de plaatjes toch automatisch aanpassen tot de correcte grootte: kleine plaatjes zien er dan niet uit en grote plaatjes kosten meer bandbreedte en processor-verbruik).</p>";
print "Gebruik geen bedankjes die andere mensen kunnen kwetsen zoals plaatjes die met religie te maken hebben. Ook plaatjes met porno zijn niet toegestaan. Als je twijfelt of een plaatje kan, schrijf dan een bericht aan een Moderator of hoger.</p>";
print "Het bestand dat je verzend zal gewijzigd worden in " . strtolower($CURUSER['username']) . ".gif , " . strtolower($CURUSER['username']) . ".jpg of " . strtolower($CURUSER['username']) . ".png</p>";
print "Tevens is maximaal 1 avatar per gebruiker toegestaan.</p>";
print "<p><b>ALLEEN GIF, JPG en PNG zijn toegestaan om te verzenden en maximale bestandsgrootte is 400 KB.</b>";
if (get_bedanktjes($CURUSER['id']))
	print "</td><td align=center class=embedded><center><font color=orange>Huidige bedankje<br><br><img height=150 src=" . get_bedanktjes($CURUSER['id']) . ">";
print "</td></tr></table><br>";
print "<table width=80% border=1 cellspacing=0 cellpadding=8>";
print "<tr><td bgcolor=white class=rowhead>Bestand</td><td bgcolor=white align=center><input type=file name=file size=80></td></tr>";
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
		$path = $serverpath."/".$file;
		foreach($allowedfiles as $allowedfile)
			{
			$tmp = strtolower($CURUSER['username'] . "." . $allowedfile);
		   	$tmppath = $serverpath."/".$tmp;
			if (file_exists($tmppath) && $path !== $tmppath)
				@unlink($bedankt_dir."/".$tmp);
   			if (@$done <> "yes")
				{
				if (file_exists($path)) 
					@unlink($bedankt_dir."/".$file);
				}
			if (substr($file, -3) == $allowedfile)
				{
				move_uploaded_file($_FILES['file']['tmp_name'], $path);
					if ($avatar_sure)
						{
						$userid = $CURUSER['id'];
				      	$avatar_send = sqlesc($urltoimages . "/" . $file);
						mysqli_query($con_link, "UPDATE users SET bedanktplaat = $avatar_send WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
						}
				$done = "yes";
				print "<p><font color=orange size=3>Verzenden is gelukt. Je kunt de image doorlinken via onderstaande URL.</font></p>";
				print "<input type=text name=tmp value='".$urltoimages."/".$file."' size=60>";
				print "<p><A href='".$urltoimages."/".$file."' target='_blank'><strong>".$urltoimages."/".$file."</strong></a></p>";
				print "<p><img src='".$urltoimages."/".$file."' border='0'><br><br>";            
				if ($avatar_sure)
					print "<p><a href=userdetails.php?id=" . $userid . ">Klik hier</a> om naar uw gebruikers gegevens pagina te gaan.<br><br>";            
				}
			}
			if (@$done <> "yes")
				print "<font size=2 color=yellow><p><b>Error:</b> Jouw afbeelding is NIET geupload. De extensie is niet herkend. Probeer het opnieuw AUB.<br><br>";
		}
	}
print("</td></tr></table>");
site_footer();  
?>
