<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
$res = mysqli_query($con_link, "SELECT COUNT(*) FROM users");
$arr = mysqli_fetch_row($res);
if ($arr[0] >= $maxusers)
	{
	site_header();
	print "<table class=main border=0 width=777 cellpadding=0 cellspacing=0><tr><td class=embedded>";
	tabel_top ("Registratie gesloten","center");
	print "<table background=pic/site/table_background.gif width=100% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded align=center><br>";
	print "<center><font size=4 color=white><b>We hebben de limiet van " . number_format($invites) . " leden bereikt.</font><br><br><hr>";

	print "<center><font size=4 color=white><b>Registratie bij ".$SITE_NAME." nog wel mogelijk na een donatie.<br><br>";
	print "<form method=get action=registratie.php>";
	print "<input type=submit style='height: 36px;width: 320px' value='Druk hier om verder te gaan'>";
	print "</form>";
	print "<br><br>";

	print "</td></tr></table>";
	print "</td></tr></table><br>";
	site_footer();
	die;
	}
//	site_error_message("Registratie niet mogelijk", "We hebben de limiet van (" . number_format($invites) . ") bereikt. Inactieve registraties worden regelmatig verwijderd, probeer het op een ander tijdstip nogmaals...</a><br><br>");
print "<meta name=\"googlebot\" content=\"noindex, nofollow, disallow\">";
print "<meta name=\"robots\" content=\"noindex, nofollow, disallow\">";
site_header("Registratie");
tabel_start();
?>
<br><font size=6 color=white>Vanaf 23 juni 2021 beperkt open voor registratie</br> Sneller, betrouwbaarder en makkelijker kan het niet, u dient zich wel aan te melden.</font>
<p>
<b><font color=white>Belangrijk:</font></b> U dient cookies aan te zetten voor registreren en aanmelden<br>
<p>
<script type="text/javascript">
function myFunction(id) {
  var x = document.getElementById(id);
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>

<form method="post" action="takesignup.php">
<table border="1" cellspacing=0 cellpadding="10">
<tr><td align="right" class="heading">Gewenste gebruikersnaam:</td><td align=left><input type="text" maxlength="12" size="40" name="wantusername" /></td></tr>
<tr><td align="right" class="heading">Kies een wachtwoord:</td><td align=left><input type="password" maxlength="40" size="40" name="wantpassword" id="myInputps"/><span onclick="myFunction('myInputps')" style="cursor: pointer;margin-left: -35px;z-index: 2;position: relative">👁︁</span></td></tr>
<tr><td align="right" class="heading">Wachtwoord nogmaals:</td><td align=left><input type="password" maxlength="40" size="40" name="passagain" id="myInputpsag"/><span onclick="myFunction('myInputpsag')" style="cursor: pointer;margin-left: -35px;z-index: 2;position: relative">👁︁</span></td></tr>
<tr valign=top><td align="right" class="heading">E-mailadres:</td><td align=left><input type="text" size="40" name="email" />
<table width=250 border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><font class=small>
Wij moeten eerst uw account accepteren.</td></tr>
</font></td></tr></table>
</td></tr>
<tr><td align="right" class="heading"></td><td align=left><input type=checkbox name=rulesverify value=yes><font class=small> U heeft de regels van <?php print $SITE_NAME ?> gelezen.</font><br>
<input type=checkbox name=faqverify value=yes><font class=small> Ik ben niet werkzaam bij Justitie, Stichting Brein of een soortgelijke organisatie.</font><br>
<input type=checkbox name=ageverify value=yes><font class=small> Ik ben minimaal 13 of ouder.</font></td></tr>
<td colspan="2" align="center"><input type=submit value="Registreren! (1x drukken!)" style='height: 25px'></td></tr>
</table>
</form>
<?php
tabel_einde();
site_footer();
?>
