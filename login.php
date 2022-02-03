<?php
require_once("include/bittorrent.php");
dbconn();

site_header("Snelle Nederlandse High Quality Downloads ");
print "<meta name=\"googlebot\" content=\"nofollow\">";
print "<meta name=\"robots\" content=\"nofollow\">";
page_start();
tabel_start();

unset($returnto);
if (!empty(@$_GET["returnto"])) {
	$returnto = @$_GET["returnto"];
	if (!@$_GET["nowarn"]) {
		print("<br></br><font size=6 color=white>Overzichtelijk met een moderne look (PHP7.3) met een ideale gebruikers ervaring.</br> Sneller, betrouwbaarder en makkelijker kan het niet!</br></br></font>\n");
	}
}

?>
<script type="text/javascript">
function myFunction() {
  var x = document.getElementById("myInputps");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function getIPFromAmazon() {
  fetch("https://checkip.amazonaws.com/").then(res => res.text()).then(data => console.log(data))
}
</script>

<form method="post" action="takelogin.php">
<br>
<font size=2 color=white>Belangrijk: U dient cookies aan te zetten voor aanmelden</font>
<table border="0" cellpadding=5>
<tr><td  class=rowhead>Gebruikersnaam:</td><td  align=left><input type="text" size=40 name="username" /></td></tr>
<tr><td  class=rowhead>Wachtwoord:</td><td  align=left><input type="password" size=40 name="password" id="myInputps"/><span onclick="myFunction()" style="cursor: pointer;margin-left: -35px;">👁︁</span></td></tr>
<tr><td  colspan="2" align="center"><input type="submit" value="Aanmelden" class=btn></td></tr>
</table>
<?php

if (isset($returnto))
	print("<input type=\"hidden\" name=\"returnto\" value=\"" . htmlspecialchars($returnto) . "\" />\n");

?>
</form>
<br>
<font size=4 color=white>Registreren? <a class=altlink_red href="signup.php">Druk hier!</a></br></br></br><font size=4 color=white>Uw wachtwoord kwijt? <a class=altlink_red href=recover.php>Druk dan hier!</a>
</br></br>
<a href="https://torrentmedia.org/rutorrent.php?">HowTo: Rtorrent + RuTorrent 3.10 met Docker op Windows 10/11</a></br>
</br><?

tabel_einde();
page_einde();
site_footer();
?>
