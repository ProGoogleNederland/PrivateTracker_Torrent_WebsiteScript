<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
if (!mkglobal("id"))
	die();

$id = 0 + $id;
if (!$id)
	site_error_message("Foutmelding", "Ongeldig id ontvangen.");

dbconn();
loggedinorreturn();

$res = mysqli_query($con_link, "SELECT * FROM torrents WHERE id = $id");
$row = mysqli_fetch_array($res);
if (!$row)
	site_error_message("Foutmelding", "Ongeldig id ontvangen.");

site_header("Bewerk torrent");
page_start(98);
tabel_top("Bewerk torrent " . $row['name'],"center");
tabel_start();

if (!isset($CURUSER) || ($CURUSER["id"] != $row["owner"] && get_user_class() < UC_MODERATOR)) {
	print("<h1>U kunt deze torrent niet bewerken</h1>\n");
	print("<p>U bent niet de eigenaar van deze torrent, of u bent niet <a href=\"login.php?returnto=" . urlencode($_SERVER["REQUEST_URI"]) . "&amp;nowarn=1\">goed aangemeld</a> volgens de regels.</p>\n");
}
else {
	print("<form method=post action=takeedit.php enctype=multipart/form-data>\n");
	print("<input type=\"hidden\" name=\"id\" value=\"$id\">\n");
	if (isset($_GET["returnto"]))
	print("<input type=\"hidden\" name=\"returnto\" value=\"" . htmlspecialchars($_GET["returnto"]) . "\" />\n");
	print("<table border=\"1\" cellspacing=\"0\" cellpadding=\"10\">\n");
	tr("Torrent naam", "<input maxlength=\"55\" type=\"text\" name=\"name\" value=\"" . htmlspecialchars($row["name"]) . "\" size=\"82\" />", 1);
	tr("Youtube Video:", "<input maxlength=\"60\" type=\"text\" name=\"imdb\" value=\"" . htmlspecialchars($row["imdb"]) . "\" size=\"82\" />", 1);
		if ($CURUSER["id"] == 3 || $CURUSER["id"] == 5 || $CURUSER["id"] == 8) {
	tr("NFO bestand", "<input type=radio name=nfoaction value='keep' checked>Bewaar huidig bestand<br>".
	"<input type=radio name=nfoaction value='update'>Wijzigen naar:<br><input type=file name=nfo size=82>", 1);
		}
if ((strpos($row["ori_descr"], "<") === false) || (strpos($row["ori_descr"], "&lt;") !== false))
  $c = "";
else
  $c = " checked";
	tr("Omschrijving", "<textarea name=\"descr\" rows=\"20\" cols=\"150\">" . htmlspecialchars($row["ori_descr"]) . "</textarea><br>(HTML is niet toegestaan. <a href=tags.php target=_blank>Druk hier</a> voor informatie over beschikbare tags.)", 1);

	$s = "<select name=\"type\">\n";

	$cats = genrelist();
	foreach ($cats as $subrow) {
		$s .= "<option value=\"" . $subrow["id"] . "\"";
		if ($subrow["id"] == $row["category"])
			$s .= " selected=\"selected\"";
		$s .= ">" . htmlspecialchars($subrow["name"]) . "</option>\n";
	}

	$s .= "</select>\n";
	tr("Type", $s, 1);
	tr("Zichtbaar", "<input type=\"checkbox\" name=\"visible\"" . (($row["visible"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" /> Zichtbaar op de pagina's<br /><table border=0 cellspacing=0 cellpadding=0 width=420><tr><td bgcolor=white class=embedded><br><b>LET OP:</b> De torrent wordt automatisch zichtbaar waneer er een deler is, en wordt automatisch onzichtbaar (dood) als er een tijdje geen deler meer is. gebruik deze funktie om het proces handmatig te versnellen. Naar dode torrents kunnen altijd nog via zoeken gezocht worden.</td></tr></table>", 1);

	if ($CURUSER["id"] == 3 || $CURUSER["id"] == 5 || $CURUSER["id"] == 8) {
		tr("Verbannen", "<input type=\"checkbox\" name=\"banned\"" . (($row["banned"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" /> Banned", 1);
	} 
	print("<tr><td bgcolor=white colspan=\"2\" align=\"center\"><input type=\"submit\" value='Wijzigingen opslaan' style='height: 25px; width: 130px'> <input type=reset value='Herstel wijzigingen' style='height: 25px; width: 130px'></td></tr>\n");
	print("</table>\n");
	print("</form>\n");

if (get_user_class() >= UC_ADMINISTRATOR || ($CURUSER["id"] == $row["owner"]))
	{
	print("<p>\n");
	print("<form method=\"post\" action=\"delete.php\">\n");
	  print("<center><b>Verwijderen van de torrent.</b>");
	  print("<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\">\n");
	  print("<td bgcolor=white><input name=\"reasontype\" type=\"radio\" value=\"1\">&nbsp;Dood </td><td bgcolor=white> 0 delers, 0 ontvangers = 0 bronnen totaal</td></tr>\n");
	  print("<tr><td bgcolor=white><input name=\"reasontype\" type=\"radio\" value=\"2\">&nbsp;Dubbel</td><td bgcolor=white><input type=\"text\" size=\"40\" name=\"reason[]\"></td></tr>\n");
	  print("<tr><td bgcolor=white><input name=\"reasontype\" type=\"radio\" value=\"3\">&nbsp;Niet werkend</td><td bgcolor=white><input type=\"text\" size=\"40\" name=\"reason[]\"></td></tr>\n");
	  print("<tr><td bgcolor=white><input name=\"reasontype\" type=\"radio\" value=\"4\">&nbsp;Overtreding van de regels</td><td bgcolor=white><input type=\"text\" size=\"40\" name=\"reason[]\"> (verplicht)</td></tr>");
	  print("<tr><td bgcolor=white><input name=\"reasontype\" type=\"radio\" value=\"5\" checked>&nbsp;Anders:</td><td bgcolor=white><input type=\"text\" size=\"40\" name=\"reason[]\"> (verplicht)</td></tr>\n");
	print("<input type=\"hidden\" name=\"id\" value=\"$id\">\n");
	if (isset($_GET["returnto"]))
		print("<input type=\"hidden\" name=\"returnto\" value=\"" . htmlspecialchars($_GET["returnto"]) . "\" />\n");
	 print("<td bgcolor=white colspan=\"2\" align=\"center\"><input type=submit value='Verwijder torrent' style='height: 25px'></td></tr>\n");
  	print("</table>");
	print("</form>\n");
	print("</p>\n");
	}
}

tabel_einde();
page_einde();
site_footer();
?>