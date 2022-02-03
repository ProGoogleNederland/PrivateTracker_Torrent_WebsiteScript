<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();
  /////////////////////////////////////////////////////////////////////////////////////////////

$hour = number_format(date('H'));
$hour2 = number_format(date('H'));
if ($hour < 18 && $hour2 > 4)
site_error_message("Foutmelding","<font color=white>De<font color=red> donatie<font color=white> pagina is momenteel uit... <br><br><font color=gold>sorry.</br>");


  /////////////////////////////////////////////////////////////////////////////////////////////


site_header("Doneren");
//print "<font size=3 color=red><b>Lees de pagina eerst.</b></font><br>";
tabel_top("Doneren","center");
tabel_start();
print("<table class=bottom width=90% border=0 cellspacing=0 cellpadding=0><tr><td class=embedded-page>\n");
print "<div align=left>";
print "<br><br><br><hr><a name='wat' id='wat'></a>";

print "<font color=yellow size=3><b>";
print "Als u doneerd krijgt u ook wat terug:<br>";
print "</b></font><font color=lightblue>";
if ($CURUSER['donor_until'] != "0000-00-00 00:00:00")
	{
	print "<li>10 punten voor iedere donatie van &euro; 5.00.";
	print "<li>150 punten voor iedere donatie van &euro; 25.00.";
	print "<li>400 punten voor iedere donatie van &euro; 50.00.";
	}
else
	{
	print "<li>10 punten voor iedere donatie van &euro; 5.00.";
	print "<li>100 punten voor iedere donatie van &euro; 25.00.";
	print "<li>300 punten voor iedere donatie van &euro; 50.00.";
	}
print "</font><br><br><br><hr><a name='credits' id='credits'></a>";
print "<font color=yellow size=3><b>";
print "Wat is mijn 'krediet' en wat kan ik daar mee:<br><br>";
print "</b></font><font color=lightblue>";
print "Krediet, dat zijn tegoeden welke u op " . $SITE_NAME . " kunt inwisselen voor het volgende:<br>";
print "<li>1 punt geeft recht op donateurschap voor de periode van 1 week.";
print "<li>4 punten geeft recht op donateurschap voor de periode van 1 maand. (inclusief een extra uitnodiging)";
print "<li>1 punt geeft recht op een ratio correctie van 3 Gigabyte.";
print "<li>4 punten geeft recht op een ratio correctie van 15 Gigabyte.";
print "<li>1 punt geeft recht op 1 extra uitnodiging.";
print "<li>1 punt geeft recht op 1 torrent correctie.";
//print "<li>U kunt deze 'punten' ook aan andere gebruikers geven.";
print "</font><br><br><br><hr><a name='donor' id='donor'></a>";

print "<font color=yellow size=3><b>";
print "Wilt u vaste 'Donateur' worden:<br>";
print "</b></font><font color=lightblue>";
print "<li>U krijgt dan de status 'Belangrijke gebruiker'. (in oplopende volgorde: Normale gebruiker, Top gebruiker, Belangrijke gebruiker, Uploader, enz enz)";
print "<li>Achter uw naam krijgt u dan een sterretje om het donateurschap duidelijk aan te geven.";
print "<li>Uw maximaal aantal torrents wordt dan vijf stuks.";
print "<li>Verhoging van uw totaal verzonden hetgeen uw ratio zal verbeteren. (".mksize($donatie_klein)." voor 1 punt en ".mksize($donatie_groot)." voor 4 punten)";
print "<li>Een eventuele ontvangen waarschuwing zal verwijderd worden.";
print "<li>De kans dat u een waarschuwing krijgt als donateur is heel klein, of u moet zich vreselijk misdragen op ".$SITE_NAME.".";
print "</font><br><br><br><hr><a name='ratio' id='ratio'></a>";

print "<font color=yellow size=3><b>";
print "Wat is een 'Ratio correctie':<br>";
print "</b></font><font color=lightblue>";
print "<li>U krijgt dan een verhoging van uw totaal verzonden hetgeen uw ratio zal verbeteren.";
print "<br><br>";
print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bijvoorbeeld:<p>";
$gb_ontvangen = 20*1024*1024*1024;
$gb_verzonden = 10*1024*1024*1024;
print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;U heeft ".mksize($gb_ontvangen)." ontvangen en ".mksize($gb_verzonden)." verzonden, dit betekend dat u dan een ratio heeft van ".number_format(($gb_verzonden / $gb_ontvangen), 1).".<p>";
print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;U kiest voor een 'Ratio correctie' van ".mksize($ratio_groot)." dan heeft u daarna het volgende.<p>";
print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;U heeft dan na de 'Ratio correctie' ".mksize($gb_ontvangen)." ontvangen en ".mksize($gb_verzonden + $ratio_groot)." verzonden, dit betekend dat u dan een ratio heeft van ".number_format((($gb_verzonden + $ratio_groot) / $gb_ontvangen), 2).".<p>";
print "</font><br><hr><a name='waarvoor' id='waarvoor'></a>";

print "<font color=yellow size=3><b>";
print "Wat wordt er met de donties gedaan:<br>";
print "</b></font><font color=lightblue>";
print "<li>De serverkosten en de domeinregistratie van ".$SITE_NAME." worden er van betaald.";
//print "<li>De serverkosten en de domeinregistratie van Forum worden er van betaald.";
print "<li>Gedeelte van de internetprovider kosten van de systeembeheerder.";
print "<br><br><br><hr></br>";
print "<center><font size=5>Doneren is niet verplicht maar altijd welkom</font>";
print "</font></center></br><hr></br>";
print "<a class=altlink_doneren href=https://torrentmedia.org/sendmessage_ts.php?receiver=5><center><font size=3>Klik hier om een betaal link aan te vragen</font></center></a>";
print "</br>";
print "<hr>";
print("</td></tr></table>\n");
tabel_einde();
page_einde();
site_footer();
?>
