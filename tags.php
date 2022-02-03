<?php
require "include/bittorrent.php";
dbconn();

function insert_tag($name, $description, $syntax, $example, $remarks)
{
	$result = format_comment($example);
//	print("<p class=sub><b>$name</b></p>\n");
	print "<table align=center class=site border=0 width=90% cellpadding=0 cellspacing=0>";
	print "<tr><td class=embedded>";
	print "<table width=100% class=bottom cellspacing=0 cellpadding=0><tr>";
	print "<td class=nav_site><font size=3>&nbsp;&nbsp;$name</td>";
	print "</td></tr></table>";
	print "</td></tr></table>";

	print("<table class=main width=90% border=1 cellspacing=0 cellpadding=5>\n");
	print("<tr valign=top><td bgcolor=white width=25%>Beschrijving:</td><td bgcolor=white>$description\n");
	print("<tr valign=top><td bgcolor=white>Invoer:</td><td bgcolor=white><tt>$syntax</tt>\n");
	print("<tr valign=top><td bgcolor=white>Voorbeeld:</td><td bgcolor=white><tt>$example</tt>\n");
	print("<tr valign=top><td bgcolor=white>Resultaat:</td><td bgcolor=white>$result\n");
	if ($remarks != "")
		print("<tr><td bgcolor=white>Opmerking:</td><td bgcolor=white>$remarks\n");
	print("</table><br>\n");
}

site_header("Tags");

print("<table width=95% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
tabel_top("Tags");
print("<table background=pics/system/tabel_achtergrond.gif width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td class=embedded align=center><center><br>");

$test = @$_POST["test"];

	print "<table align=center class=bottom border=0 width=70% cellpadding=0 cellspacing=0>";
	print "<tr><td class=embedded><center>";
	print "<font size=3 color=yellow><b>In de forums kunt u een aantal <i>BB tags</i> gebruiken in uw berichten.";
	print "</td></tr></table>";

?>
<table width=70% class=bottom><tr><td class=embedded align=center><center>
<form method=post action=?>
<textarea name=test cols=120 rows=4><? print($test ? htmlspecialchars($test) : "")?></textarea><br>
<input type=submit value="Test deze invoer!" style='height: 25px; margin-left: 5px'>
</form>
</td></tr></table><br>
<?

if ($test != "")
  print("<p><hr>" . format_comment($test) . "<hr></p>\n");

insert_tag(
	"Youtube",
	"Plaats youtube trailers in comments",
	"[youtube=<i>https://www.youtube.com/watch?v=_y9bj5jqV7I</i>]",
	"[youtube=https://www.youtube.com/watch?v=_y9bj5jqV7I]",
	""
);

insert_tag(
	"Vet",
	"Maak een vet gedrukte tekst.",
	"[b]<i>Tekst</i>[/b]",
	"[b]Deze tekst is vet gedrukt.[/b]",
	""
);

insert_tag(
	"Schuin",
	"Maak een schuin gedrukte tekst.",
	"[i]<i>Tekst</i>[/i]",
	"[i]Deze tekst is schuin gedrukt.[/i]",
	""
);

insert_tag(
	"Onderstreept",
	"Maak een onderstreepte tekst.",
	"[u]<i>Tekst</i>[/u]",
	"[u]Deze tekst is onderstreept.[/u]",
	""
);

insert_tag(
	"Kleur",
	"Maak een gekleurde tekst.",
	"[color=<i>Color</i>]<i>Tekst</i>[/color]",
	"[color=blue]Deze tekst is blauw.[/color]",
	"De ondersteunde kleuren verschilt per internetprogramma. Als u de basis kleuren (red, green, blue, yellow, pink enz) gebruikt lukt het zeker."
);

insert_tag(
	"Grootte",
	"Maak een grote tekst.",
	"[size=<i>n</i>]<i>tekst</i>[/size]",
	"[size=4]Deze tekst is 4 groot.[/size]",
	"<i>n</i> moet een getal zijn tussen de 1 en 7. De standaardwaarde is 2."
);

insert_tag(
	"Lettertype",
	"Maak een tekst met een ander lettertype.",
	"[font=<i>Font</i>]<i>Tekst</i>[/font]",
	"[font=Impact]Hallo wereld![/font]",
	""
);

insert_tag(
	"Snelkoppeling (1)",
	"Voeg een snelkoppeling in uw tekst.",
	"[url]<i>URL</i>[/url]",
	"[url]".$BASEURL."/[/url]",
	"De ingevoerde snelkoppeling is dan ook zichtbaar."
);

insert_tag(
	"Snelkoppeling (2)",
	"Voeg een snelkoppeling in uw tekst.",
	"[url=<i>URL</i>]<i>Snelkoppeling tekst</i>[/url]",
	"[url=".$BASEURL."/]onzesite[/url]",
	"Doe dit alleen indien u in plaats van de snelkoppeling een tekst wilt weergeven."
);

insert_tag(
	"Plaatje",
	"Voeg een plaatje in uw tekst.",
	"[img]<i>URL/abcdef.png</i>[/img]",
	"[img]https://i.imgur.com/D8tgOmo.png[/img]",
	"De URL moet eindigen op <b>.gif</b>, <b>.jpg</b> of <b>.png</b>."
);

insert_tag(
	"Citaat (1)",
	"Voeg een citaat in uw tekst.",
	"[quote]<i>Te citeren tekst</i>[/quote]",
	"[quote]Wie niet waagt wie niet wint.[/quote]",
	""
);

insert_tag(
	"Citaat (2)",
	"Voeg een citaat in uw tekst.",
	"[quote=<i>Schrijver</i>]<i>Te citeren tekst</i>[/quote]",
	"[quote=John Doe]Wie niet waagt wie niet wint.[/quote]",
	""
);

insert_tag(
	"Hoofdstukken",
	"Maak een tekst met hoofdstukken en/of onderdelen.",
	"[*]<i>Tekst</i>",
	"[*] Dit is hoofdstuk 1\n[*] Dit is hoofdstuk 2",
	""
);

print("</td></tr></table>");
print("<br></td></tr></table>");
print("</td></table><br>");


//end_frame();
//print("<br>");
//end_main_frame();
site_footer();
?>