<?php
ob_start("ob_gzhandler");
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

error_reporting(0);

if (!mkglobal("id"))
	site_error_message("Foutmelding", "Geen torrent gevonden.");

$id = (int)$id;

if (!isset($id) || !$id)
	site_error_message("Foutmelding", "Geen torrent gevonden.");

$bonus = (int)@$_GET['bonus'];

if ($bonus)
	{
	$bonus_tekst = "";
	if ($bonus > $CURUSER['bonus_punten'])
		site_error_message("Foutmelding", "U heeft niet genoeg bonuspunten voor deze optie.");
	
	if ($bonus != 10 && $bonus != 25 && $bonus != 50 && $bonus != 100)
		site_error_message("Foutmelding", "Ongeldige hoeveelheid BP ontvangen.");
		
	$totaal_gegeven = 0;
	$res_totaal = mysqli_query($con_link, "SELECT * FROM bonus_punten WHERE torrent_id=".$id." AND sender_id=".$CURUSER['id']) or sqlerr(__FILE__, __LINE__);
	while ($row_totaal = mysqli_fetch_assoc($res_totaal))
		{
		$totaal_gegeven += $row_totaal['ammount'];
		}
	if ($totaal_gegeven > 100)
		$bonus_tekst = "Foutmelding: U heeft al het maximale aantal BP aan deze torrent gegeven.";
	elseif ($totaal_gegeven + $bonus > 100)
		$bonus_tekst = "Foutmelding: Met het geven van ".$bonus." BP komt u boven het maximale van 100 BP per torrent.";
	else
		{
		$res_torrent = mysqli_query($con_link, "SELECT * FROM torrents WHERE id=$id") or sqlerr(__FILE__, __LINE__);
		$row_torrent = mysqli_fetch_array($res_torrent);
		if (!$row_torrent)
			site_error_message("Foutmelding", "Geen torrent gevonden om BP aan te geven.");

		if ($CURUSER['id'] == $row_torrent['owner'])
			site_error_message("Foutmelding", "U kunt geen punten aan uw eigen torrent geven.");
		$torrent_id = $row_torrent['id'];
		$receiver_id = $row_torrent['owner'];
		$sender_id = $CURUSER['id'];
		$ammount = $bonus;
	
		mysqli_query($con_link, "INSERT INTO bonus_punten (torrent_id, receiver_id, sender_id, ammount, added) VALUES ($torrent_id, $receiver_id, $sender_id, $ammount, NOW())") or sqlerr(__FILE__, __LINE__);
		mysqli_query($con_link, "UPDATE users SET bonus_punten=bonus_punten-".$ammount." WHERE id=".$sender_id) or sqlerr(__FILE__, __LINE__);
		mysqli_query($con_link, "UPDATE users SET bonus_punten=bonus_punten+".$ammount." WHERE id=".$receiver_id) or sqlerr(__FILE__, __LINE__);
		$CURUSER['bonus_punten'] = $CURUSER['bonus_punten'] - $ammount;
		$bonus_tekst = "U heeft ".$ammount." BP gegeven aan ".get_username($receiver_id)." voor deze torrent.";
		}	
	}
////////////////////////////////////////////////////////////////////////////////////////
if ($CURUSER["bedanktplaat"])
	      $bd = "[img=" . $CURUSER["bedanktplaat"] . "]";
            else
	      $bd = "[img=pic/default_bedankje.gif]";


            $text = $bd;
            mysqli_query($con_link, "INSERT INTO comments (user, torrent, added, text, ori_text) VALUES (" .
	      $sender_id . ",$torrent_id, '" . get_date_time() . "', " . sqlesc($text) .
	       "," . sqlesc($text) . ")");
            mysqli_query($con_link, "UPDATE torrents SET comments = comments + 1 WHERE id = $torrent_id");
			////////////////////////////////////////////////////////////////////////////////////////
$seeders_count = get_row_count("peers","WHERE seeder='yes' AND torrent=".$id);
$leechers_count = get_row_count("peers","WHERE seeder='no' AND torrent=".$id);

$res = mysqli_query($con_link, "SELECT torrents.screen_by, torrents.cover_by, torrents.seeders, torrents.banned, torrents.leechers, torrents.info_hash, torrents.filename, LENGTH(torrents.nfo) AS nfosz, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(torrents.last_action) AS lastseed, torrents.numratings, torrents.name, IF(torrents.numratings < $minvotes, NULL, ROUND(torrents.ratingsum / torrents.numratings, 1)) AS rating, torrents.owner, torrents.save_as, torrents.descr, torrents.imdb, torrents.visible, torrents.size, torrents.added, torrents.views, torrents.hits, torrents.times_completed, torrents.id, torrents.type, torrents.numfiles, categories.name AS cat_name, users.username FROM torrents LEFT JOIN categories ON torrents.category = categories.id LEFT JOIN users ON torrents.owner = users.id WHERE torrents.id = $id")
	or sqlerr();
$row = mysqli_fetch_array($res);

if ($row)
	{
	$totaal_ontvangen = get_row_count("downloaded","WHERE torrent = $id");
	mysqli_query($con_link, "UPDATE torrents SET times_completed = $totaal_ontvangen WHERE id = $id");
	}

$owned = $moderator = 0;
	if (get_user_class() >= UC_ADMINISTRATOR)
		$owned = $moderator = 1;
	elseif ($CURUSER["id"] == $row["owner"])
		$owned = 1;

if (!$row || ($row["banned"] == "yes" && !$moderator))
	site_error_message("Foutmelding", "Geen torrent met ID $id.");
else {
	if ($_GET["hit"]) {
		mysqli_query($con_link, "UPDATE torrents SET views = views + 1 WHERE id = $id");

	if ($_GET["tocomm"])
		header("Location: $BASEURL/details.php?id=$id&page=0#startcomments");
	elseif ($_GET["filelist"])
		header("Location: $BASEURL/details.php?id=$id&filelist=1#filelist");
	elseif ($_GET["toseeders"])
		header("Location: $BASEURL/details.php?id=$id&dllist=1#seeders");
	elseif ($_GET["todlers"])
		header("Location: $BASEURL/details.php?id=$id&dllist=1#leechers");
	else
		header("Location: $BASEURL/details.php?id=$id");
	
	exit();
	}

//	if (!isset($_GET["page"])) {
		site_header("Gegevens van torrent \"" . $row["name"] . "\"");

		print "<table class=bottom border=0 width=98% cellpadding=0 cellspacing=0><tr><td class=embedded><center>";

		if ($CURUSER["id"] == $row["owner"] || get_user_class() >= UC_ADMINISTRATOR)
			$owned = 1;
		else
			$owned = 0;

		$spacer = "&nbsp;&nbsp;";

		if ($bonus_tekst)
			print "<h2>".$bonus_tekst."</h2>\n";

		if ($_GET["uploaded"]) {
			print("<h2>Torrent ontvangen.</h2>\n");
			print("<p>U kunt nu starten met delen. <b>LET OP:</b> de torrent zal pas zichtbaar worden als u begint met delen.</p>\n");
		}
		elseif ($_GET["edited"]) {
			print("<h2>Bewerking van torrent is gelukt.</h2>\n");
			if (isset($_GET["returnto"]))
				print("<p><b>Ga terug naar <a href=\"" . htmlspecialchars($_GET["returnto"]) . "\">waar u vandaan kwam</a>.</b></p>\n");
		}
		elseif (isset($_GET["searched"])) {
			print("<h2>Uw zoekopdracht naar \"" . htmlspecialchars($_GET["searched"]) . "\" gaf dit reslutaat:</h2>\n");
		}
		elseif ($_GET["rated"])
			print("<h2>Waardering toegevoegd</h2>\n");

		tabel_top($row[name],"center");
		tabel_start(100);

		///// Gebruiker opties /////
		print "<table width=99% class=bottom cellspacing=0 cellpadding=0>";
		print "<tr><td class=embedded width=99%><div align=left>";

		$bedankt_user = get_row_count("thankyou","WHERE torrent = ".$id." AND user = ".$CURUSER['id']." ORDER BY added DESC");
		$bedankt = get_row_count("thankyou","WHERE torrent = ".$id);
		if ($CURUSER['id'] != $row['owner'])
			{
			if ($bedankt_user > 0)
				{
				print "<form method=post action=''>";
				print "<input type=submit style='height:25px;width:140px;background:blue;color:white;font-weight:bold' value='U heeft al bedankt'>";
				print "</form>";
				}
			else
				{
					print "<br><form method=post action=takebedankplaatje.php>";
					print "<input type=hidden name=id value=" . $row['id'] . ">";
					print "<input type=submit style='height:36px;width:200px;background:#E56717;color:black;font-weight:bold' value='Nu Bedanken'>";
					print "</form>";
				}
			}

		print "</td><td class=embedded><div align=right>";

		$s = "";
		$s .= "<table width=600 class=bottom border=0 cellpadding=0 cellspacing=0><tr><td class=embedded><b>";
		if (!isset($row["rating"])) {
			if ($minvotes > 1) {
				$s .= "<font color=white><b>Nog niet (heeft op zijn minst $minvotes stemmen nodig en er zijn ";
				if ($row["numratings"])
					$s .= "maar " . $row["numratings"];
				else
					$s .= "geen";
				$s .= ")";
			}
			else
				$s .= "<font color=white><b>&nbsp;Nog geen stemmen";
		}
		else
			{
			$s .= "<font color=white><b>(" . $row["rating"] . " van 5 met " . $row["numratings"] . " stem(men) totaal)";
			}
		$s .= "\n";
		$s .= "</td><td class=embedded>$spacer</td><td class=embedded valign=top>";
		if (!isset($CURUSER))
			$s .= "(<a href=\"login.php?returnto=" . urlencode($_SERVER["REQUEST_URI"]) . "&amp;nowarn=1\">Log in</a> om deze torrent te waarderen)";
		else {
			$ratings = array(
					5 => "Waanzinnig",
					4 => "Goed",
					3 => "Middelmatig",
					2 => "Slecht",
					1 => "Waardeloos",
			);
			if (!$owned || $moderator) {
				$xres = mysqli_query($con_link, "SELECT rating, added FROM ratings WHERE torrent = $id AND user = " . $CURUSER["id"]);
				$xrow = mysqli_fetch_array($xres);
				if ($xrow)
					$s .= "<font color=white><b>(U stemde op deze torrent met een \"" . $xrow["rating"] . " - " . $ratings[$xrow["rating"]] . "\")";
				else {
					$s .= "</td><td class=embedded><div align=right><form method=\"post\" action=\"takerate.php\"><input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
					$s .= "<select style='border-radius: 5px; margin: 5px; height: 2.2rem; padding: 3px; background-color: rgba(255,255,255,0.2); color: #fff;' name=\"rating\">\n";
					$s .= "<option value=\"0\"> (Maak uw keuze) </option>\n";
					foreach ($ratings as $k => $v) {
						$s .= "<option value=\"$k\">$k - $v</option>\n";
					}
					$s .= "</select>\n";
					$s .= "<input type=submit type=submit style='height:24px;width:100px;background:white;color:blue;font-weight:bold' value='Nu stemmen'>";
					$s .= "</form>\n";
				}
			}
		}
		$s .= "</td></tr></table>";
		print $s;

		print "</td></tr><tr><td class=embedded colspan=2><hr color=white size=1 align=center>";

		//// BP SYSTEEM ////
//		if (get_user_class() >= UC_GOD)
//			{
			
			$totaal_torrent = 0;
			$totaal_user = 0;
			$res_totaal = mysqli_query($con_link, "SELECT * FROM bonus_punten WHERE torrent_id=$id") or sqlerr(__FILE__, __LINE__);
			while ($row_totaal = mysqli_fetch_assoc($res_totaal))
				{
				$totaal_torrent += $row_totaal['ammount'];
				if ($row_totaal['sender_id'] == $CURUSER['id'])
					$totaal_user += $row_totaal['ammount'];
				}
	
			print "</td></tr><tr><td class=embedded colspan=2>";

			print "<table width=100% class=bottom bordercolor=red border=0 cellspacing=0 cellpadding=2>";
			print "<tr><td class=embedded>";
			print "<font color=white size=2><b>Totaal ".$totaal_torrent." BP gegeven op deze torrent";
			if ($totaal_user)
				print " waarvan ".$totaal_user." BP door u.";
			else
				print " waarvan nog niets door u.";
			if ($CURUSER['bonus_punten'] > 10 && $CURUSER[id] != $row['owner'])
				{
				if ($totaal_user <= 95)
					{
					print "</td><td class=embedded width=230 align=left valign=top>";
					print "<font color=white size=2><b>Door op de munten recht hier van te klikken kunt u BP punten geven aan de uploader van deze torrent.";			
					print "</td><td class=embedded width=220><div align=right>";
					if ($totaal_user + 10 <= 100)
						print "<a href=?id=$id&bonus=10><img border=0 height=50 width=50 alt='Zucht' src='pic/bp/bp_010.png'></a>\n";
					if ($totaal_user + 25 <= 100)
						print "<a href=?id=$id&bonus=25><img border=0 height=50 width=50 src='pic/bp/bp_025.png'></a>\n";
					if ($totaal_user + 50 <= 100)
						print "<a href=?id=$id&bonus=50><img border=0 height=50 width=50 src='pic/bp/bp_050.png'></a>\n";
					if ($totaal_user + 100 <= 100)
						print "<a href=?id=$id&bonus=100><img border=0 height=50 width=50 src='pic/bp/bp_100.png'></a>\n";
					}
				}
			else
				{
				if ($totaal_user < 95 && $CURUSER[id] != $row['owner'])
					{
					print "</td><td class=embedded width=400 align=left valign=top>";
					print "<form method=post action='bonus_informatie.php'>\n";
					print "<input type=submit style='height:32px;width:400px;color:white;background:red;font-weight:bold' value='U niet genoeg BP punten, nu gaan kopen.'>\n";
					print "</form>\n";
					}
				}
			print "</td></tr></table>";
//			}
		//// BP SYSTEEM ////

		print "</td></tr></table>";

		///// Gebruiker opties /////

		///// Nieuwe torrent informatie /////
	/*	print "<br>";
		print "<table width=99% class=bottom bordercolor=red border=1 cellspacing=0 cellpadding=2>";
		print "<tr><td class=colheadsite colspan=1 height=25><center><a class=altlink_white href=download.php?id=$id>" . htmlspecialchars($row["filename"]) . " (nu downloaden, klik hier)</a></center></td><tr><td>";

		print "<table width=99% class=bottom cellspacing=0 cellpadding=0>";
		print "<tr><td class=embedded><div align=center>";*/
		///// Nieuwe torrent informatie /////
		print "<br>";
		print "<table width=100% class=bottom bordercolor=red border=1 cellspacing=0 cellpadding=2>";
              $gebruikert = $CURUSER["id"];
              $res1 = mysqli_query($con_link, "SELECT * FROM comments WHERE user = $gebruikert and torrent = $id") or sqlerr(__FILE__, __LINE__);
              $row1 = mysqli_fetch_array($res1);
              if ($row1['text'] || $CURUSER['id'] == $row['owner'])
		print "<tr><td class=colheadsite colspan=1 background=pics/system/achtergrond.gif height=15><center><a class=altlink_white href=download.php?id=$id&uid=$gebruikert><img border=0 src=pic/download.gif></a></center></td><tr><td>";
              else
              print "<tr><td class=colheadsite colspan=1 height=15><center><font size=3><font color=red><b>Laat eerst een commentaartje achter, daarna kun je hier de torrent downloaden!!</b></font></center></td><tr><td>";
		print "<table width=99% class=bottom cellspacing=0 cellpadding=0>";
		print "<tr><td class=embedded><div align=center>";
///////////--------------------------------------------------------------------------------		

		///// Cover en schermafbeelding /////
		print "<table width=100% align=center class=bottom cellspacing=0 cellpadding=0>";
		print "<tr><td class=embedded><div align=left>";

		print "<font size=2 color=white><b>Cover<hr color=white size=1 width=380 align=left>";

		print "</td><td class=embedded><div align=center>&nbsp;";

		print "</td><td class=embedded><div align=right>";
		print "<font size=2 color=white><b>Scherm afbeelding<hr color=white size=1 width=380 align=right>";
		print "</td></tr><tr><td class=embedded>";

		print "<table width=300 class=bottom cellspacing=0 cellpadding=0>";
		print "<tr><td class=embedded><div align=left>";
//		$maten = getimagesize(get_cover($row['id']));

		if (get_cover($row['id']))
			print "<img width=380 src=" . get_cover($row['id']) . ">";
//			print "<img ".pic_resize($maten[0],$maten[1], 380)." src=" . get_cover($row['id']) . ">";
		else
			print "<br><font size=2 color=white><b>Geen cover aanwezig.<br><br>";
			
		if (get_user_class() >= UC_ADMINISTRATOR || $CURUSER['id'] == $row['owner'])
			{
			print "</tr><tr></td><td class=embedded><div align=left>";

			print "<table width=1% class=bottom cellspacing=0 cellpadding=0>";
			print "<tr></td><td colspan=3 class=embedded><div align=left>";

			if (get_cover($row['id']))
				print "<font color=white size=2><b>Cover&nbsp;geplaatst&nbsp;door:&nbsp;<a class=altlink_lblue href=userdetails.php?id=".$row['cover_by'].">" . get_username($row['cover_by']) . "</a>";
			else
				print "&nbsp;";

			print "</td></tr>";

			print "<tr><td height=30 class=embedded><div align=left>";
			print "<form method=post action=cover_upload.php>";
			print "<input type=hidden name=id value=" . $row['id'] . ">";
			print "<input type=submit style='height:25px;width:125px;background:green;color:white;font-weight:bold' value='Plaatsen cover'>";
			print "</form>";
			print "</td>";
			print "<td height=30 class=embedded>";
			print "&nbsp;&nbsp;&nbsp;";
			print "</td>";
			print "<td height=30 class=embedded><div align=left>";
			print "<form method=post action=cover_delete.php>";
			print "<input type=hidden name=id value=" . $row['id'] . ">";
			print "<input type=submit style='height:25px;width:125px;background:red;color:white;font-weight:bold' value='Verwijder cover'>";
			print "</form>";
			print "</td></tr>";

			print "<tr></td><td colspan=3 class=embedded><div align=center>";
			print "</td></tr>";
			print "</table>";
			}
			
		print "</td></tr></table>";
		
		print "</td><td class=embedded><div align=center>";

		print "</td><td class=embedded><div align=right>";

		print "<table width=300 class=bottom cellspacing=0 cellpadding=0>";
		print "<tr><td class=embedded><div align=right>";

		$maten_screen = getimagesize(get_screen($row['id']));

		if (get_screen($row['id']))
			print "<img ".pic_resize($maten_screen[0],$maten_screen[1], 380)." src=" . get_screen($row['id']) . ">";
		else
			print "<br><font size=2 color=white><b>Geen scherm afbeelding aanwezig.<br><br>";

		if (get_user_class() >= UC_ADMINISTRATOR || $CURUSER['id'] == $row['owner'])
			{
			print "</tr><tr></td><td class=embedded><div align=right>";

			print "<table width=1% class=bottom cellspacing=0 cellpadding=0>";
			print "<tr></td><td colspan=3 class=embedded><div align=right>";

			if (get_screen($row['id']))
				print "<font color=white size=2><b>Screen&nbsp;geplaatst&nbsp;door: <a class=altlink_lblue href=userdetails.php?id=".$row['screen_by'].">" . get_username($row['screen_by']) . "</a>";
			else
				print "&nbsp;";

			print "</td></tr>";

			print "<tr><td height=30 class=embedded><div align=right>";
			print "<form method=post action=screen_upload.php>";
			print "<input type=hidden name=id value=" . $row['id'] . ">";
			print "<input type=submit style='height:25px;width:125px;background:green;color:white;font-weight:bold' value='Plaatsen screen'>";
			print "</form>";
			print "</td>";
			print "<td height=30 class=embedded>";
			print "&nbsp;&nbsp;&nbsp;";
			print "</td>";
			print "<td height=30 class=embedded><div align=right>";
			print "<form method=post action=screen_delete.php>";
			print "<input type=hidden name=id value=" . $row['id'] . ">";
			print "<input type=submit style='height:25px;width:125px;background:red;color:white;font-weight:bold' value='Verwijder screen'>";
			print "</form>";
			print "</td></tr>";

			print "<tr></td><td colspan=3 class=embedded><div align=center>";
			print "</td></tr>";
			print "</table>";
			}
			
		print "</td></tr></table>";
		print "</td></tr></table>";
		///// Cover en schermafbeelding /////

		print "</td></tr><tr><td colspan=1 class=embedded>";
		print "<br>";
		
		///// Torrent informatie /////
		print "<table width=100% class=bottom cellspacing=0 cellpadding=0>";
		print "<tr><td class=colheadsite height=25 width=250><div align=center>";
		print "Torrent informatie";
		print "</td><td class=embedded height=25 width=1><div align=center>";
		print "&nbsp;";
		print "</td><td class=colheadsite height=25><div align=center>";
		print "Torrent omschrijving";
		print "</td></tr>";		

		print "<tr><td class=text123 height=25 width=280 valign=top align=left>";

		print "<table width=100% class=bottom cellspacing=0 cellpadding=5>";

		print "<tr><td class=colheadsite height=20 width=1%><div align=left>";
		print "Categorie";
		print "</td><td class=text123>";
		if (isset($row["cat_name"]))
			print $row["cat_name"];
		else
			print "(onbekend)";
		print "</td></tr>";

		print "<tr><td class=colheadsite height=20 width=1%><div align=left>";
		print "Geplaatst&nbsp;door";
		print "</td><td class=text123>";
		if (isset($row["username"]))
			print "<a class=altlink_blue href=userdetails.php?id=".$row['owner'] . ">" . htmlspecialchars($row["username"]) . "</a>";
		print "</td></tr>";

		print "<tr><td class=colheadsite height=20 width=1%><div align=left>";
		print "Geplaatst&nbsp;op";
		print "</td><td class=text123>";
		print str_replace(" ","&nbsp;",convertdatum($row["added"]));
		print "</td></tr>";

		print "<tr><td class=colheadsite height=20 width=1%><div align=left>";
		print "Geplaatst";
		print "</td><td class=text123>";
		$aanwezig = floor((gmtime() - sql_timestamp_to_unix_timestamp($row["added"])) / 3600);
		print $aanwezig . " uur geleden";
		print "</td></tr>";

		print "<tr><td class=colheadsite height=20 width=1%><div align=left>";
		print "Laatste&nbsp;activiteit";
		print "</td><td class=text123>";
		print mkprettytime($row["lastseed"]) . " geleden";
		print "</td></tr>";

		print "<tr><td class=colheadsite height=20 width=1%><div align=left>";
		print "Grootte";
		print "</td><td class=text123>";
		print mksize($row["size"]);
		print "</td></tr>";

		print "<tr><td class=colheadsite height=20 width=1%><div align=left>";
		print "Bestanden";
		print "</td><td class=text123>";
		if ($row["numfiles"] == 1)
			print $row["numfiles"] . " bestand <font size=1><a class=altlink_red href='details_bestanden.php?torrent_id=".$row['id']."'>(overzicht)</a>";
		else
			print $row["numfiles"] . " bestanden <font size=1><a class=altlink_red href='details_bestanden.php?torrent_id=".$row['id']."'>(overzicht)</a>";
		print "</td></tr>";

		$zichtbaar = get_row_count("peers","WHERE userid=$CURUSER[id] AND torrent=".$id);

		print "<tr><td class=colheadsite height=20 width=1%><div align=left>";
		print "Delers";
		print "</td><td class=text123>";
		if ($seeders_count == 1)
			print $seeders_count . " deler <font size=1><a class=altlink_red href='details_bronnen.php?torrent_id=".$row['id']."'>(overzicht)</a>";
		else
			print $seeders_count . " delers <font size=1><a class=altlink_red href='details_bronnen.php?torrent_id=".$row['id']."'>(overzicht)</a>";
		print "</td></tr>";

		print "<tr><td class=colheadsite height=20 width=1%><div align=left>";
		print "Ontvangers";
		print "</td><td class=text123>";
		if ($leechers_count == 1)
			print $leechers_count . " ontvanger <font size=1><a class=altlink_red href='details_bronnen.php?torrent_id=".$row['id']."'>(overzicht)</a>";
		else
			print $leechers_count . " ontvangers <font size=1><a class=altlink_red href='details_bronnen.php?torrent_id=".$row['id']."'>(overzicht)</a>";
		print "</td></tr>";

		print "<tr><td class=colheadsite height=20 width=1%><div align=left>";
		print "Bedankjes";
		print "</td><td class=text123>";
		if ($bedankt > 0)
			print $bedankt . " keer bedankt <font size=1><a class=altlink_red href='details_bedankjes.php?torrent_id=".$row['id']."'>(overzicht)</a>";
		else
			print "Nog geen bedankjes.";
		print "</td></tr>";

		print "<tr><td class=colheadsite height=20 width=1%><div align=left>";
		print "Kompleet";
		print "</td><td class=text123>";

		if ($row["times_completed"] > 0)
			print $totaal_ontvangen . " keer ontvangen. <font size=1><a class=altlink_red href='details_ontvangen.php?torrent_id=".$row['id']."'>(overzicht)</a>";
		else
			print "0 keer ontvangen.";
		print "</td></tr>";

		print "<tr><td class=colheadsite height=20 width=1%><div align=left>";
		print "BP&nbsp;overzicht";
		print "</td><td class=text123>";

		$bp_totaal = get_row_count("bonus_punten","WHERE torrent_id='".$id."'");

		if ($bp_totaal > 0)
			print $totaal_torrent . " BP - " . $bp_totaal . " keer <font size=1><a class=altlink_red href='bonus_overzicht_torrent.php?torrent_id=".$row['id']."'>(overzicht)</a>";
		else
			print "Nog geen BP gegeven.";
		print "</td></tr>";

		print "</table>";


		if (get_user_class() >= UC_ADMINISTRATOR || $CURUSER['id'] == $row['owner'])
			{
			print "<br><div align=right>";
			print "<table class=bottom cellspacing=0 cellpadding=0>";

			print "<tr><td height=30 class=embedded><div align=right>";
			print "<form method=post action=edit.php>";
			print "<input type=hidden name=id value=$id>";
			print "<input type=submit style='height:25px;width:225px;background:green;color:white;font-weight:bold' value='Bewerk deze torrent'>";
			print "</form>";

			print "<tr><td height=30 class=embedded><div align=right>";
			print "<form method=get action=massa_berichten_torrent.php>";
			print "<input type=hidden name=torrentid value=" . $id . ">";
			print "<input type=submit style='height:25px;width:225px;background:blue;color:white;font-weight:bold' value='Massa bericht versturen'>";
			print "</form>";

			if (get_user_class() >= UC_ADMINISTRATOR)
				{
				print "<tr><td height=30 class=embedded><div align=right>";
				print "<form method=post action=downloaded.php>";
				print "<input type=hidden name=id value=" . $row['id'] . ">";
				print "<input type=submit style='height:25px;width:225px;background:orange;color:white;font-weight:bold' value='Moderator download overzicht'>";
				print "</form>";
				}

			if (get_user_class() >= UC_ADMINISTRATOR)
				{
				print "<tr><td height=30 class=embedded><div align=right>";
				print "<table width=1% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>";
				print "<form method=post action=torrent_delete_correctie.php>";
				print "<input type=hidden name=torrentid value=$id>";
				print "<input type=hidden name=action value=verwijderen>";
				print "<input type=checkbox name=sure>";
				print "</td><td class=embedded>";
				print "<input type=submit style='height:25px;width:225px;background:red;color:white;font-weight:bold' value='Verwijderen met ratio correctie'>";
				print "</form>";
				print "</td></tr></table>";
				}

			print "</td></tr>";
			print "</table>";
			}

		print "</td><td class=embedded height=25 width=1><div align=left valign=top>";
		print "&nbsp;";
		print "</td><td  class=text456 valign=top><div align=center>";

		$omschrijving = stripslashes(format_comment($row["descr"],true));
		print $omschrijving;
		
		print "</br></br></br></br>";

		$imdb = stripslashes(format_comment($row["imdb"],true));
		print $imdb;
		
		print "</td></tr></table>";
		///// Torrent informatie /////


		///// Commentaat Uploader /////
		print "<br><center>\n";

		print "<table width=100% class=bottom cellspacing=0 cellpadding=0>";
		print "<tr><td class=colheadsite height=100><div align=center>";
		print " Commentaar gereserveerd voor uploader ".get_username($row['owner']).".";
		print "</td></tr><tr><td height=25><div align=center><br>";

		$res_cu = mysqli_query($con_link, "SELECT * FROM comments_uploader WHERE torrent = $id") or sqlerr(__FILE__, __LINE__);
		$row_cu = mysqli_fetch_array($res_cu);
		if ($row_cu)
			$comment_uploader = format_comment($row_cu['text']);
		else
			$comment_uploader = format_comment("Uploader heeft nog geen commentaar geplaatst.");

		$avatar = ($CURUSER["avatars"] == "yes" ? get_avatar($row['owner']) : "");
		if (!$avatar)
			$avatar = "pic/default_avatar.gif";
		$maten = getimagesize($avatar);

		print "<table class=bottom width=750 border=1 cellspacing=0 cellpadding=$padding>\n";
		print "<tr valign=top>\n";
		print "<td class=text123 align=center width=1% style='padding: 0px'><img ".pic_resize($maten[0],$maten[1], 100)." src=$avatar></td>\n";

		print "</td><td class=text123 class=text>";
		print $comment_uploader;
		print "</td></tr></table>";		

		if ($CURUSER['id'] == $row['owner'])
			{
			print "<br>";
			print "<form method=post action='comment_uploader.php'>\n";
			print "<input type=hidden name=torrent_id value=".$id." />\n";
			print "<input type=submit style='height:24px;width:240px;background:green;color:white;font-weight:bold' value='Uploader commentaar bewerken' />";
			print "</form>\n";
			}

		print "<br>";
		print "</td></tr></table>";		
		///// Commentaat Uploader /////
		
		$alle_comment = get_row_count("comments","WHERE torrent=".$id);

		print "<br>";
		print "<center><p><a name=\"startcomments\"></a></p>\n";
		print "<table width=100% class=bottom cellspacing=0 cellpadding=0>";
		print "<tr><td class=colheadsite height=25><div align=center>";
		print "Totaal ".$alle_comment." reacties, overzicht laatste 10 reacties (van nieuw naar oud)&nbsp;&nbsp;&nbsp;<a class=altlink_lblue href='details_comments.php?torrent_id=".$row['id']."'>(alle ".$alle_comment." reacties lezen, druk hier)</a>";
		print "</td></tr><tr><td height=25><div align=center>";

		$subres = mysqli_query($con_link, "SELECT comments.id, text, user, comments.added, editedby, editedat, avatar, warned, ".
                  "username, title, class, donor FROM comments LEFT JOIN users ON comments.user = users.id WHERE torrent = " .
                  "$id ORDER BY comments.id DESC LIMIT 10") or sqlerr(__FILE__, __LINE__);
		$allrows = array();
		while ($subrow = mysqli_fetch_array($subres))
			$allrows[] = $subrow;

		//////////////////////////////////////////////////////////////////////////////////
		$bedanktplaatje_user = get_row_count("comments","WHERE torrent = ".$id." AND user = ".$CURUSER['id']." ORDER BY added DESC");
		$bedanktplaatje = get_row_count("comments","WHERE torrent = ".$id);
		if ($CURUSER['id'] != $row['owner'])
			{
			if ($bedanktplaatje_user > 0)
				{
				print "<form method=post action=''>";
				print "<input type=submit style='height:36px;width:200px;background:#E56717;color:black;font-weight:bold' value='Bedankje is geplaatst'>";
				print "</form>";
				}
			else
				{
					print "<br><div align=center>";
			//		print "<form method=get action='comment.php'>\n";
			//		print "<input type=hidden name=action value=add />\n";
			//		print "<input type=hidden name=tid value=".$id." />\n";
			//		print "<input type=submit style='height:36px;width:200px;background:blue;color:white;font-weight:bold' value='Reageren' /></form>";
			//		print "</form>";
					print "<br><form method=post action=takebedankplaatje.php>";
					print "<input type=hidden name=id value=" . $row['id'] . ">";
					print "<input type=submit style='height:36px;width:200px;background:#E56717;color:black;font-weight:bold' value='Gebruik uw bedankje'>";
					print "</form>";
				}
			}
			
					$bedanktplaatje_user = get_row_count("comments","WHERE torrent = ".$id." AND user = ".$CURUSER['id']." ORDER BY added DESC");
		$bedanktplaatje = get_row_count("comments","WHERE torrent = ".$id);
	//	if ($CURUSER['id'] != $row['owner'])
	//		{
					print "<br><div align=center>";
					print "<form method=get action='comment.php'>\n";
					print "<input type=hidden name=action value=add />\n";
					print "<input type=hidden name=tid value=".$id." />\n";
					print "<input type=submit style='height:36px;width:200px;background:blue;color:white;font-weight:bold' value='Reageren' /></form>";

	//		}
			////////////////////////////////////////////////////////////////////////////////////////////////////

		commenttable($allrows);

		print "</td></tr></table>";		
		print "<br>";
		print "</td></tr></table>";
		print "<br>";
		print "</td></tr></table>";
		print "</td></tr></table>";
		///// Nieuwe torrent informatie /////

	print "</td></tr></table><br>";
	}

print "</td></tr></table><br>";
site_footer();

function getagent($httpagent, $peer_id)
	{
	if (substr($peer_id,1,2) == "BC")
		return "BitComet" . " " . substr($peer_id,4,1) . "." . substr($peer_id,5,2);
	elseif (substr($peer_id,0,4) == "exbc")
		return "BitComet oude versie";
	else
		return ($httpagent != "" ? $httpagent : "---");
	}

function dltable($name, $arr, $torrent)
	{
	global $CURUSER,$leechers_count,$seeders_count;
	if ($name == "Deler(s)")
		$s = "<b>" . $seeders_count . " $name</b>\n";
	else
		$s = "<b>" . $leechers_count . " $name</b>\n";
	
	if (!count($arr))
		return $s;
	$s .= "\n";
	$s .= "<table width=100% class=main border=1 cellspacing=0 cellpadding=5>\n";
	$s .= "<tr><td class=colheadsite>Gebruiker</td>" .
          "<td class=colheadsite align=right>Gedeeld</td>".
          "<td class=colheadsite align=right>Snelheid</td>".
          "<td class=colheadsite align=right>Ontvangen</td>" .
          "<td class=colheadsite align=right>Snelheid</td>" .
          "<td class=colheadsite align=right>Ratio</td>" .
          "<td class=colheadsite align=right>Kompleet</td>" .
          "<td class=colheadsite align=left>Programma</td></tr>\n";
	$now = time();
	$moderator = (isset($CURUSER) && get_user_class() >= UC_ADMINISTRATOR);
	$mod = get_user_class() >= UC_MODERATOR;
	foreach ($arr as $e) {


	$userid = $e['userid'];
	$torrentid = $torrent['id'];
	$ressite =  mysqli_query($con_link, "SELECT * FROM downup WHERE user='" . $userid . "' AND torrent='" . $torrentid . "'") or sqlerr(__FILE__, __LINE__);
	$rowsite = mysqli_fetch_array($ressite);
    if ($rowsite["downloaded"] > 0)
    {
      	$ratiosite = number_format($rowsite["uploaded"] / $rowsite["downloaded"], 2);
      	$ratiosite = "<font color=" . get_ratio_color($ratiosite) . ">$ratiosite</font>";
		if ($rowsite["uploaded"] / $rowsite["downloaded"] > 20) $ratiosite = "<center><img border=0 src=pic/oneindig.gif></center>";
    }
    else
      if ($rowsite["uploaded"] > 0)
        $ratiorhc = "<center><img border=0 src=pic/oneindig.gif></center>";
      else
        $ratiosite = "---";

	if ($rowsite["downloaded"] == 0) $ratiosite = "<center><img border=0 src=pic/oneindig.gif></center>";

	if ($rowsite)
		$uploaded = str_replace(" ", "&nbsp;", mksize($rowsite["uploaded"]));
	else
		$uploaded = "onbekend";
	if ($rowsite)
		$downloaded = str_replace(" ", "&nbsp;", mksize($rowsite["downloaded"]));
	else
		$downloaded = "onbekend";

                // user/ip/port
                // check if anyone has this ip
                ($unr = mysqli_query($con_link, "SELECT username, warned, donor, privacy FROM users WHERE id=$e[userid] ORDER BY last_access DESC LIMIT 1")) or die;
                $una = mysqli_fetch_array($unr);
				if ($una["privacy"] == "strong") continue;
				$s .= "<tr>\n";
				if ($una["warned"] == "yes")
					$warned = " <img src=/pic/warned.gif border=0>";
				else
					$warned = "";
				if ($una["donor"] == "yes")
					$donor = " <img border=0 src=pic/star.gif>";
				else
					$donor = "";
                if ($una["username"]) {
				$ratiotmp = get_userratio($e[userid]);
                  $s .= "<td class=text123><a href=userdetails.php?id=$e[userid]><b>$una[username]</b>&nbsp;$ratiotmp$donor$warned</a></td>\n";
				 } 
                else
                  $s .= "<td>" . ($mod ? $e["ip"] : preg_replace('/\.\d+$/', ".xxx", $e["ip"])) . "</td>\n";
		$secs = max(1, ($now - $e["st"]) - ($now - $e["la"]));
		$revived = $e["revived"] == "yes";
		$s .= "<td class=text123 align=right>" . str_replace(" ","&nbsp;",$uploaded) . "</td>\n";
		$s .= "<td class=text123 align=right><nobr>" . str_replace(" ","&nbsp;",mksize(($e["uploaded"] - $e["uploadoffset"]) / $secs)) . "/s</nobr></td>\n";
		$s .= "<td class=text123 align=right>" . $downloaded . "</td>\n";
		if ($e["seeder"] == "no")
			$s .= "<td class=text123 align=right><nobr>" . mksize(($e["downloaded"] - $e["downloadoffset"]) / $secs) . "/s</nobr></td>\n";
		else
			$s .= "<td class=text123 align=right><nobr>" . mksize(($e["downloaded"] - $e["downloadoffset"]) / max(1, $e["finishedat"] - $e[st])) .	"/s</nobr></td>\n";
		$s .= "<td class=text123 align=right>$ratiosite</td>\n";
		$s .= "<td class=text123 align=right>" . sprintf("%.2f%%", 100 * (1 - ($e["to_go"] / $torrent["size"]))) . "</td>\n";
		$s .= "<td class=text123 align=left>" . htmlspecialchars(getagent($e["agent"], $e["peer_id"])) . "</td>\n";
		$s .= "</tr>\n";
	}
	$s .= "</table>\n";
	return $s;
	}
?>
