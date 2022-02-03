<?php
require_once("include/bittorrent.php");
dbconn();

if (!mkglobal("type"))
	die();

if ($type == "signup" && mkglobal("email")) {
	site_header("User signup");
        sitemsg("Registratie gelukt!",
	"Een bevestigings e-mail is verzonden naar het door u opgegeven adres  (" . htmlspecialchars($email) . "). U dient deze te lezen en te reageren om uw account te activeren. Als u dit niet doet, wordt het account automatisch verwijderd na een paar dagen.", 80);
	site_footer();
}
elseif ($type == "invite" && mkglobal("email"))
	{
	site_header("Gebruiker uitnodiging");
        sitemsg("Uitnodiging gelukt",
	"Een registratie bevestigings e-mail is verzonden naar het door u opgegeven adres  (" . htmlspecialchars($email) . "). Deze dient te worden gelezen en er moet op gereageerd worden om het account te activeren. Gebeurd dit niet dan wordt het account automatisch verwijderd na een paar dagen.", 80);
	site_footer();
	}
elseif ($type == "confirmed") {
	site_header("Reeds bevestigd");
	print("<h1>Reeds bevestigd</h1>\n");
	print("<p>Dit account is al bevestigd. U kunt verder gaan met door u <a href=\"login.php\">hier</a> aan te melden.</p>\n");
	site_footer();
}
elseif ($type == "confirm") {
	if (isset($CURUSER)) {
		site_header("Bevestigen van uw account is gelukt");
		print("<h1>Account is bevestigd</h1>\n");
		print("<p>Uw account is geactiveerd! u bent nu automatisch aangemeld. U kunt nu verder gaan naar de <a href=\"/\"><b>hoofdpagina</b></a> en uw account gaan gebruiken.</p>\n");
		print("<p>Voor dat u ".$SITE_NAME." gaat gebruiken dient u lees dan eerst de <a href=\"site_regels.php\"><b>REGELS</b></a>.</p>\n");
		site_footer();
	}
	else {
		site_header("Bevestigen van uw account is gelukt");
		print("<h1>Account is bevestigd<</h1>\n");
		print("<p>Uw account is geactiveerd! Alleen u bent niet automatisch aangemeld. Een reden zou kunnen zijn dat u de cookies heeft uitgeschakeld in uw internet browser. U dient cookies aan te zetten om uw account te gebuiken. Controleer dat alstublieft en ga naar <a href=\"login.php\">aanmelden</a> en probeer het opnieuw.</p>\n");
		site_footer();
	}
}
else
	die();



?>
