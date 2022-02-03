<?php
ob_start("ob_gzhandler");
require "include/bittorrent.php";

dbconn();

site_header("PreUpload");

if (get_user_class() < UC_UPLOADER)
	{
	sitemsg("Sorry...", "U kunt geen torrents naar ons verzenden, u heeft daar de rechten niet voor.  (Vraag <a href=\"upload_aanvraag.php?\">hier</a> uploader rechten aan)");
	site_footer();
	exit;
	}

print("<table class=bottom width=90% border=0 cellspacing=0 cellpadding=0><tr><td class=embedded-page>\n");
tabel_top("UPLOAD REGELS - Hou je aan deze regels anders verlies je de upload status!","center");
tabel_start();

print "<form method=post action='upload.php'>\n";
print "<input type=hidden name=controle value=onzesite>\n";
print "<center><input type=submit value='Ik ga akkoord met de onder staande regels' style='font-weight:bold;color:white;background:orange;height:32px;width:300px'></center></form>\n";
print "<hr>";

print "<form method=post action='bonus_punten.php'>\n";
print "<center><input type=submit value='Uw BP punten inwisselen voor donateurschap' style='font-weight:bold;color:white;background:green;height:32px;width:300px'></center>\n";
print "</form>";
print "<hr>";

print "<form method=post action='upload_controle.php'>\n";
print "<center><input type=submit value='Controleer uw uploads' style='font-weight:bold;color:red;background:white;height:32px;width:300px'></center>\n";
print "</form>";
print "<hr>";

?>

<b><div align=center>
<font color=white size=4><b>Dit zijn de belangrijkste regels</b></br></br></font>
<div align=center>
<font color=lightblue>
<table align=center width=45% border=0 cellspacing=0 cellpadding=0><tr><td class=embedded-page>
Bij films zijn nl ondertitels verplicht, met uitzondering van XXX. Indien u een iets plaatst zonder nl ondertilels toch even </br>duidelijk in de omschrijving van de torrent vermelden dat er geen ondertitels bij zitten. Tevens kunnen er uitzonderingen </br>gemaakt worden voor documentaires, specials en dergelijke.
</br></br>U dient een duidelijke omschrijving aan de torrent te geven.
</br></br>U dient minimaal te blijven seeden tot dat 4 gebruikers hem binnen hebben en deze aan het delen (seeden) zijn, in geval </br>van vele ontvangers (leechers) dient u te blijven delen to ongeveer 30 procent van de gebruikers hem binnen geeft. </br>U dient de torrent dusdanig te delen totdat er genoeg delers bij zijn om het over te nemen.
</br></br>indien de kwaliteit niet 100% is, graag dan niet plaatsen.
</br></br>Plaats de torrent in de juiste categorie.
</br></br>Laat de gebruikers zien dat u een uploader met kwaliteit bent, dit kan al door een nette torrent / upload te verzorgen, </br>maak de torrent van een nette kwaliteit de gebruiker zal dit zeker waarderen.
</br></br>Alle torrents dienen te voorzien zijn van een duidelijke en alles omschrijvende NFO text, de NFO word verwerkt in de </br>torrent, hierdoor kan men de informatie later nog eens teruglezen. </br>Wat met name bij Games/Software van belang is.
</br></br>Mocht u eventueel twijfels of vragen hebben over, of u heeft een probleem  met een torrent, neem dan eerst contact op </br>met iemand van ons <a class=altlink_yellow href="<? print $BASEURL ?>/staff.php">staf</a></br></br>
</td></tr></table>
<?


tabel_einde();

print("</td></tr></table>\n");
site_footer(); ?>