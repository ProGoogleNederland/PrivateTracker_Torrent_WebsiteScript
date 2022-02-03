<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();
//agecheck();

?>
<script type="text/javascript">
checked=false;
function checkedAll (frm1) {
	var aa= document.getElementById('frm1');
	 if (checked == false)
          {
           checked = true
          }
        else
          {
          checked = false
          }
	for (var i =0; i < aa.elements.length; i++) 
	{
	 aa.elements[i].checked = checked;
	}
      }
</script>
<?

function get_row_counts($table, $suffix = "")
	{
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
	$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	
	if ($suffix)
		$suffix = " $suffix";
	($r = mysqli_query($con_link, "SELECT COUNT(*) FROM $table$suffix")) or die(mysqli_error());
	($a = mysqli_fetch_row($r)) or die(mysqli_error());
	return $a[0];
	}

$type = @$_GET['type'];
$user_id = $CURUSER['id'];
if ($type == 'save')		// Opslaan
{
				$message_id = @$_GET['id'];
				mysqli_query($con_link, "UPDATE messages SET location = 'save',  poster=".$user_id." WHERE id=" . $message_id) or die("arghh");

header("Refresh: 0; url=".$_SERVER["HTTP_REFERER"]."");
}
//Algemene instellingen voor inbox.php
			$postvakin = get_row_counts("messages", "WHERE receiver=" . $CURUSER["id"] . " AND location IN ('in', 'both')");
			$postvakinnew = get_row_counts("messages", "WHERE receiver=" . $CURUSER["id"] . " AND location IN ('in', 'both') AND unread = 'yes'");
			$postvakuit = get_row_counts("messages", "WHERE sender=" . $CURUSER["id"] . " AND location IN ('out','both')");
			$concepten = get_row_counts("messages", "WHERE poster=" . $CURUSER["id"] . " AND location IN ('save')");

			$leftmenu = "<form method=get action='inbox.php'>";
			$leftmenu .= "<input type=submit class=btn style='height: 24px;font-weight: bold;width: 100px;color:white;background: green;font-size:11px' value='Inbox ($postvakin - $postvakinnew)'>";
			$leftmenu .= "</form><br>";
			$leftmenu .= "<form method=get action=inbox.php>";
			$leftmenu .= "<input type=hidden name=outbox value=1>";
			$leftmenu .= "<input type=submit class=btn style='height: 24px;font-weight: bold;width: 100px;color:white;background: red;font-size:11px' value='Verzonden ($postvakuit)'>";
			$leftmenu .= "</form><br>";
			$leftmenu .= "<form method=get action='inbox.php'>";
			$leftmenu .= "<input type=hidden name=concepts value=1>";
			$leftmenu .= "<input type=submit class=btn style='height: 24px;font-weight: bold;width: 100px;color:white;background: blue;font-size:11px' value='Concepten ($concepten)'>";
			$leftmenu .= "</form><br>";
			$leftmenu .= "<form method=get action='inbox.php'>";
			$leftmenu .= "<input type=hidden name=send value=1>";
			$leftmenu .= "<input type=submit class=btn style='height: 24px;font-weight: bold;width: 100px;color:white;background: green;font-size:11px' value='Nieuw Bericht'>";
			$leftmenu .= "</form><br>";
				if (get_user_class() >= UC_ADMINISTRATOR)
					{
			$leftmenu .= "<form method=get action='inbox.php'>";
			$leftmenu .= "<input type=hidden name=staffmess value=1>";
			$leftmenu .= "<input type=submit class=btn style='height: 24px;font-weight: bold;width: 100px;color:white;background: green;font-size:11px' value='Staff Bericht'>";
			$leftmenu .= "</form><br>";
					}
			$leftmenu .= "<form method=get action='inbox.php'>";
			$leftmenu .= "<input type=hidden name=help value=1>";
			$leftmenu .= "<input type=submit class=btn style='height: 24px;font-weight: bold;width: 100px;color:blue;background:yellow;font-size:11px' value='Help'>";
			$leftmenu .= "</form><br>";
//Algemene instellingen voor inbox.php

//Help Functie
$help = @$_GET['help'];
if ($help)		// Nieuw Bericht
{	
	site_header("Berichten Hulp", false);
	page_start(90);;tabel_start();
	tabel_top('Berichten Help', 'center','90');

			print "<table class=main width=100% border=1 cellspacing=0 cellpadding=0><tr>";
			print "<td colspan=2><b><font size=3 color=white>&nbsp;&nbsp;Help voor berichten op $SITE_NAME.</font></b></td></tr><tr>";
			print "<td valign=top width=125 class=text bgcolor=#FFFFFF><b><div align=center>\n";
			print $leftmenu;
			print "</td>";

			print "<td valign=top class=text bgcolor=#FFFFFF>";

			print "<table align=center class=bottom width=99% border=0 cellspacing=0 cellpadding=5>";
			print "<tr><td class=embedded><div align=left>";

//Inbox Help
			print "<table class=main width=100% border=1 cellspacing=0 cellpadding=0><tr>";
			print "<td class=tabel_top><b><font size=2 color=white>&nbsp;&nbsp;Inbox</td></tr>";
			print "<tr><td class=text>";
			
			print "Hier staan al uw berichten die u heeft ontvangen op $SITE_NAME.";
			print "</br>Communicatie is van belang, lees eerst al uw berichten voor u verder kunt.";
			print "</br>Tip: Om een bericht te openen klikt u op de datum of de onderwerp van het bericht, u wordt dan naar de juiste bericht gestuurt.";
			
			print "</td</tr>";
			print "</table><br>";
//Inbox Help Einde
//Outbox Help
			print "<table class=main width=100% border=1 cellspacing=0 cellpadding=0><tr>";
			print "<td class=tabel_top><b><font size=2 color=white>&nbsp;&nbsp;Verzonden</td></tr>";
			print "<tr><td class=text>";
			
			print "Indien u voor de optie gekozen heeft om berichten te bewaren, dan vindt u hier al uw verzonden berichten op $SITE_NAME.";
			
			print "</td</tr>";
			print "</table><br>";
//Outbox Help Einde
//Concepten Help
			print "<table class=main width=100% border=1 cellspacing=0 cellpadding=0><tr>";
			print "<td class=tabel_top><b><font size=2 color=white>&nbsp;&nbsp;Concepten</td></tr>";
			print "<tr><td class=text>";
			
			print "Hier staan berichten die u heeft bewaard op $SITE_NAME.";
			
			print "</td</tr>";
			print "</table><br>";
//Concepten Help Einde
//Bericht Help
			print "<table class=main width=100% border=1 cellspacing=0 cellpadding=0><tr>";
			print "<td class=tabel_top><b><font size=2 color=white>&nbsp;&nbsp;Nieuwe Berichten</td></tr>";
			print "<tr><td class=text>";
			
			print "Hier kunt u berichten sturen naar andere leden op $SITE_NAME.";
			
			print "</td</tr>";
			print "</table><br>";
//Bericht Help Einde
//Staff Bericht Help
				if (get_user_class() >= UC_ADMINISTRATOR)
					{
			print "<table class=main width=100% border=1 cellspacing=0 cellpadding=0><tr>";
			print "<td class=tabel_top><b><font size=2 color=white>&nbsp;&nbsp;Staff Berichten</td></tr>";
			print "<tr><td class=text>";
			
			print "Hier kunt u groepsberichten sturen naar stafleden op $SITE_NAME.";
			
			print "</td</tr>";
			print "</table><br>";
					}
//Staff Bericht Help Einde

			print "</td></tr>";
			print "</table></td></tr>";
			print "</table>";


tabel_einde();
page_einde();
print "</table></table></tabel></tabel><br>";
print "</table></table></tabel></tabel>";

site_footer();
die;
		}

//Einde Help Functie
// Postvak-uit
$outbox = @$_GET['outbox'];
if ($outbox)
{	
	site_header("Verzonden Berichten", false);
	page_start(90);tabel_start();
	tabel_top('***	LET OP ***', 'center','90');

			print "<table class=messages width=100% border=0 cellspacing=0 cellpadding=0><tr>";
			print "<td colspan=2><div align=center><font size=3 >Communicatie is van belang, lees eerst al uw berichten voor u verder kunt.</font></br><font size=2 >Tip: Om een bericht te openen klikt u op de datum of de onderwerp van het bericht, u wordt dan naar de juiste bericht gestuurt.</br></font></td></tr>";
			print "<td valign=top width=125 class=text><b><div align=center>\n";
			print $leftmenu;
			print "</td>";
			print "<td width=95% valign=top class=text>";

$message_id = @$_GET['message_id'];
if ($message_id)		// Bericht
{
			$res = mysqli_query($con_link, "SELECT * FROM messages WHERE id=".$message_id) or die("barf!");

				while ($arr = mysqli_fetch_assoc($res))
				{
					if (is_valid_id($arr["sender"]))
				{
				$res2 = mysqli_query($con_link, "SELECT username FROM users WHERE id=" . $arr["sender"]) or sqlerr();
				$arr2 = mysqli_fetch_assoc($res2);
				$receiver = "<a class=altlink_blue href=userdetails.php?id=" . $arr["receiver"] . ">" . get_usernamesitesmal($arr["receiver"]) . "</a>";
				}
				$elapsed = get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]));
					if (!isset($CURUSER) || ($CURUSER["id"] != $arr["sender"])) {
				print "<h1 align=center>U heeft een ongeldig Message ID opgegeven.</h1>";
				print "<p align=center>Ga terug en probeer het nogmaals.</p>";
				tabel_einde();
				page_einde();
				print "</table></table></tabel></tabel>";

				site_footer();
				die;
					}
				print "<p><table class=main width=100% border=1 cellspacing=0 cellpadding=5>";
				print "<tr><td>";
				
				print "<table class=main width=100% cellspacing=0 cellpadding=5><tr>";
				print "<td width=1% class=inbox><div align=right><b>Datum:</td><td class=inbox>";
				print "".convertdatum($arr['added'])." ($elapsed geleden)";
				print "</td></tr>";
				print "<td class=inbox><div align=right><b>Ontvanger:</td><td class=inbox>".$receiver."</td></tr>";
				print "<td class=inbox><div align=right><b>Onderwerp:</td><td class=inbox>";
				print stripslashes(format_comment(@$arr["subject"]));
				print "</td></tr></table>";
				
				print "<tr><td bgcolor=white>";
				print(stripslashes(format_comment($arr["msg"])));
				print("</td></tr></table></p>\n<p>");

				print("<table class=bottom width=100% border=0><tr>\n");

				print "<td class=embedded width=10>";
				print "<table class=bottom width=100 border=0><tr><td class=embedded>";
				print "<td class=embedded>";
				print "</td>";

				print "</td><td class=embedded width=10><div align=left>";
				print "<form method=get action='deletemessage.php'>";
				print "<input type=hidden name=type value=out>";
				print "<input type=hidden name=id value=".$arr["id"].">";
				print "<input type=submit class=btn style='height: 24px;font-weight: bold;width: 100px;color:white;background: red;font-size:11px' value='Verwijderen'>";
				print "</form>";
				print "</td>";
				print "<td width=10 class=embedded></td>";
				print "<td width=10 class=embedded><form method=get action=''>";
				print "<input type=hidden name=type value=save>";
				print "<input type=hidden name=id value=".$arr["id"].">";
				print "<input type=submit class=btn style='height: 24px;font-weight: bold;width: 100px;color:blue;background: orange;font-size:11px' value='Opslaan'>";
				print "</form>";
				print "</td></tr></table>";
				print "</td>";

				print "</td>";
				print("</tr></table></tr></table>\n");
				print ("</p>");
}
tabel_einde();
page_einde();
print "</table></table></tabel></tabel><br>";
print "</table></table></tabel></tabel>";

site_footer();
	die;
		}

				print("<table class=site width=100% border=0 cellspacing=0 cellpadding=5>\n");
				print "<tr><td class=embedded width=1%><form id=frm1 method=post action=/take-delmpx.php><input type=checkbox name=checkall onclick='checkedAll(frm1);'></td><td width=200 class=embedded>Ontvanger</td><td class=embedded>Onderwerp</td><td class=embedded>Datum en Tijd</td></tr>";
				{
				$res = mysqli_query($con_link, "SELECT * FROM messages WHERE sender=" . $CURUSER["id"] . " AND location IN ('out','both') ORDER BY added DESC") or die("barf!");
				if (mysqli_num_rows($res) == 0)
		    	print "<tr><td colspan=4 class=messages_bottom align=center><h1>U heeft geen verzonden berichten in uw Outbox!</h1></td></tr>";
					else
				$start = 1;
					while ($arr = mysqli_fetch_assoc($res))
					{
				$res2 = mysqli_query($con_link, "SELECT username FROM users WHERE id=" . $arr["sender"]) or sqlerr();
				$arr2 = mysqli_fetch_assoc($res2);
				$receiver = "<a class=altlink_blue href=userdetails.php?id=" . $arr["receiver"] . ">" . get_usernamesitesmal($arr["receiver"]) . "</a>";
				$elapsed = get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]));

				if ($start == 1) {
					$start = 2;}
				else $start = 1;
				if ($start == 2)
					$bgcolor = "bgcolor=white";
				else
					$bgcolor = "bgcolor=#CCCCCC";

				$s = "<td $bgcolor class=inbox onClick=\"location.href='/inbox.php?outbox=1&message_id=".$arr["id"]."'\">$receiver</td>";
				$s .= "<td $bgcolor class=inbox onClick=\"location.href='/inbox.php?outbox=1&message_id=".$arr["id"]."'\">".@$arr["subject"]."";
					if ($arr["unread"] == "yes")
				$s .= "&nbsp;<font color=red>(Ongelezen)</font>";
				$s .= "</td><td $bgcolor class=inbox onClick=\"location.href='/inbox.php?outbox=1&message_id=".$arr["id"]."'\">".convertdatum($arr['added'])." ($elapsed geleden)</td>";
				print "<tr><td $bgcolor class=inbox><input type=checkbox name=\"delmp[]\" value=\"" . $arr['id'] . "\">$s</td></tr>";
					}
				if (mysqli_num_rows($res) == 0)
				print "";
				else
				print "<tr><td bgcolor=white class=messages_bottom colspan=4><b>De geselecteerde berichten:&nbsp;<input type=submit value='Verwijderen!' /></form></b></td></tr>";

					}
				print("<table></tr></table></tr></table>\n");
				tabel_einde();
				page_einde();
				print "</table></table></tabel></tabel>";

				site_footer();
				die;
		}
		
//Concepten
$concepts = @$_GET['concepts'];
if ($concepts)		// Concepten
{	
	site_header("Opgeslagen Berichten", false);
	page_start(90);tabel_start();
	tabel_top('***	LET OP ***', 'center','90');

			print "<table class=messages width=100% border=0 cellspacing=0 cellpadding=0><tr>";
			print "<td colspan=2><div align=center><font size=3 >Communicatie is van belang, lees eerst al uw berichten voor u verder kunt.</font></br><font size=2 >Tip: Om een bericht te openen klikt u op de datum of de onderwerp van het bericht, u wordt dan naar de juiste bericht gestuurt.</br></font></td></tr>";
			print "<td valign=top width=125 class=text><b><div align=center>\n";
			print $leftmenu;
			print "</td>";
			print "<td width=99% valign=top class=text>";

$message_id = @$_GET['message_id'];
if ($message_id)		// Bericht
{
			$res = mysqli_query($con_link, "SELECT * FROM messages WHERE id=".$message_id) or die("barf!");

				while ($arr = mysqli_fetch_assoc($res))
				{
					if (is_valid_id($arr["sender"]))
				{
				$res2 = mysqli_query($con_link, "SELECT username FROM users WHERE id=" . $arr["sender"]) or sqlerr();
				$arr2 = mysqli_fetch_assoc($res2);
				$receiver = "<a class=altlink_blue href=userdetails.php?id=" . $arr["sender"] . ">" . get_usernamesitesmal($arr["receiver"]) . "</a>";
				}
				$elapsed = get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]));
					if (!isset($CURUSER) || ($CURUSER["id"] != $arr["poster"])) {
				print "<h1 align=center>U heeft een ongeldig Message ID opgegeven.</h1>";
				print "<p align=center>Ga terug en probeer het nogmaals.</p>";
				tabel_einde();
				page_einde();
				print "</table></table></tabel></tabel>";

				//site_footer();
			//	die;
					}
				print "<p><table class=main width=100% border=1 cellspacing=0 cellpadding=5>";
				print "<tr><td>";
				
				print "<table class=main width=100% cellspacing=0 cellpadding=5><tr>";
				print "<td width=1% class=inbox><div align=right><b>Datum:</td><td class=inbox>";
				print "".convertdatum($arr['added'])." ($elapsed geleden)";
				print "</td></tr>";
				print "<td class=inbox><div align=right><b>Ontvanger:</td><td class=inbox>".$receiver."</td></tr>";
				print "<td class=inbox><div align=right><b>Onderwerp:</td><td class=inbox>";
				print stripslashes(format_comment(@$arr["subject"]));
				print "</td></tr></table>";
				
				print "<tr><td bgcolor=white>";
				print(stripslashes(format_comment($arr["msg"])));
				print("</td></tr></table></p>\n<p>");

				print("<table class=bottom width=100% border=0><tr>\n");

				print "<td class=embedded width=10>";
				print "<table class=bottom width=100 border=0><tr><td class=embedded>";
				print "<td class=embedded>";
				print "</td>";
				print "</td><td class=embedded width=10><div align=left>";
				print "<form method=get action='deletemessage.php'>";
				print "<input type=hidden name=type value=concepts>";
				print "<input type=hidden name=id value=".$arr["id"].">";
				print "<input type=submit class=btn style='height: 24px;font-weight: bold;width: 100px;color:white;background: red;font-size:11px' value='Verwijderen'>";
				print "</form>";
				print "</td></tr></table>";
				print "</td>";
				print("</tr></table></tr></table>\n");
				print ("</p>");
}
tabel_einde();
page_einde();
print "</table></table></tabel></tabel>";
print "</table></table></tabel></tabel><br>";

site_footer();
	die;
		}

				print("<table class=site width=100% border=0 cellspacing=0 cellpadding=5>\n");
				print "<tr><td class=embedded width=1%><form id=frm1 method=post action=/take-delmpx.php><input type=checkbox name=checkall onclick='checkedAll(frm1);'></td><td width=200 class=embedded>Ontvanger</td><td class=embedded>Onderwerp</td><td class=embedded>Datum en Tijd</td></tr>";
				{
				$res = mysqli_query($con_link, "SELECT * FROM messages WHERE poster=" . $CURUSER["id"] . " AND location IN ('save') ORDER BY added DESC") or die("barf!");
				if (mysqli_num_rows($res) == 0)
		    	print "<tr><td colspan=4 class=messages_bottom align=center><h1>U heeft geen opgeslagen berichten in uw map Concepten!</h1></td></tr>";
				else
				$start = 1;
					while ($arr = mysqli_fetch_assoc($res))
				{
				$res2 = mysqli_query($con_link, "SELECT username FROM users WHERE id=" . $arr["receiver"]) or sqlerr();
				$arr2 = mysqli_fetch_assoc($res2);
				if ($arr["receiver"] == $CURUSER["id"])
				$receiver = "<b>Aan Mij Verstuurt</b></a>";
				else
				$receiver = "<a class=altlink_blue href=userdetails.php?id=" . $arr["receiver"] . ">" . get_usernamesitesmal($arr["receiver"]) . "</a>";
				$elapsed = get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]));

				if ($start == 1) {
					$start = 2;}
				else $start = 1;
				if ($start == 2)
					$bgcolor = "bgcolor=white";
				else
					$bgcolor = "bgcolor=#CCCCCC";
				$s = "<td $bgcolor class=inbox onClick=\"location.href='/inbox.php?concepts=1&message_id=".$arr["id"]."'\">$receiver</td>";
				$s .= "<td $bgcolor class=inbox onClick=\"location.href='/inbox.php?concepts=1&message_id=".$arr["id"]."'\">".@$arr["subject"]."";
				$s .= "</td><td $bgcolor class=inbox onClick=\"location.href='/inbox.php?concepts=1&message_id=".$arr["id"]."'\">".convertdatum($arr['added'])." ($elapsed geleden)</td>";
				print "<tr><td $bgcolor class=inbox><input type=checkbox name=\"delmp[]\" value=\"" . $arr['id'] . "\">$s</td></tr>";
					}
				if (mysqli_num_rows($res) == 0)
				print "";
				else
				print "<tr><td bgcolor=white class=messages_bottom colspan=4><b>De geselecteerde berichten:&nbsp;<input type=submit value='Verwijderen!' /></form></b></td></tr>";

					}
				print("<table></tr></table></tr></table>\n");
				tabel_einde();
				page_einde();
				print "</table></table></tabel></tabel>";

				site_footer();
				die;
					}

$send = @$_GET['send'];
if ($send)		// Nieuw Bericht
{	
	$replyto = @$_GET["replyto"];
	if ($replyto && !is_valid_id($replyto))
		die;
	site_header("Nieuw Bericht", false);
	page_start(90);tabel_start();
	tabel_top('***	LET OP ***', 'center','90');

			print "<table class=messages width=100% border=0 cellspacing=0 cellpadding=0><tr>";
			print "<td colspan=2><div align=center><font size=3 >Communicatie is van belang, lees eerst al uw berichten voor u verder kunt.</font></br><font size=2 >Tip: Om een bericht te openen klikt u op de datum of de onderwerp van het bericht, u wordt dan naar de juiste bericht gestuurt.</br></font></td></tr>";
			print "<td valign=top width=125 class=text><b><div align=center>\n";
			print $leftmenu;
			print "</td>";

			print "<td valign=top class=text>";
			$receiver = @$_GET["receiver"];
			$subject = @$_GET["subject"];

			

			if ($replyto)
				{
				$res = mysqli_query($con_link, "SELECT * FROM messages WHERE id=$replyto") or sqlerr(__FILE__, __LINE__);
				$msga = mysqli_fetch_assoc($res);
				if ($msga["receiver"] != $CURUSER["id"])
					die;
				$res = mysqli_query($con_link, "SELECT username FROM users WHERE id=" . $msga["sender"]) or sqlerr(__FILE__, __LINE__);
				$usra = mysqli_fetch_assoc($res);
				$body .= "\n\n\n[quote][b]Van $usra[username] op ".convertdatum($msga['added'])."[/b]\n\n".htmlspecialchars($msga['msg'])."[/quote]\n";
				}

			print "<table align=center class=messages width=90% border=0 cellspacing=0 cellpadding=5>";
			print "<tr><td class=embedded>";
			if (@$_GET["returnto"] || $_SERVER["HTTP_REFERER"])
				{
				if (@$_GET["returnto"])
					print "<input type=hidden name=returnto value=".$_GET["returnto"].">";
				else
					print "<input type=hidden name=returnto value=".$_SERVER["HTTP_REFERER"].">";
				} 
			print "<table class=bottom>";
			print "<form method=get action=inbox.php>";
			print "<tr><td class=embedded><div align=right><b>Ontvanger:&nbsp;</b></td>";
			print "<td class=embedded><select name=receiver>";
			print "<option value=0>-- Selecteer Gebruiker --</option>";
			$def = mysqli_query($con_link, "SELECT * FROM users ORDER by username") or die("barf!");
			while ($defs = mysqli_fetch_assoc($def))
				{
				print "<option value=$defs[id]" . ($receiver == $defs['id'] ? " selected" : "") . ">" . $defs['username'] . "</option>";
				
				}
			print "</select>";
			print "&nbsp;<input type=submit style='height: 20px;width: 110px' value='Dit word het!'></td>";
			if (get_user_class() >= UC_OWNER)
			print "<tr><td class=embedded>";
            print "<input type=hidden name=send value=1>";


			print "</td></tr></form>";
			
		
			print "<form method=post action=takemessage.php>";
			print "<input type=hidden name=returnto value=inbox.php>";
			print "<input type=hidden name=outbox value=1>";
			print "<tr><td class=embedded><div align=right><b>Onderwerp:&nbsp;</b></td>";
			print "<td class=embedded>";
			if ($receiver == 0)
			print "<p align=left>&nbsp;Selecteer eerst een gebruiker.</p></td></tr>";
			else{
			if ($replyto){
			$subject = "".htmlspecialchars($msga['subject'])."";
					print "<input type=text maxlength=80 size=110 name=subject value='RE: $subject'>";
					} else {
					print "<input type=text maxlength=80 size=110 name=subject value=$subject><font size=1>&nbsp;(Verplicht veld)</font>";
					}
			}
			print "</td></tr></table><hr>";
			@$body = htmlspecialchars($body);
			if ($replyto)
			print "<b>Bericht: <font size=1>HTML is niet toegestaan. <a href=tags.php target=_blank>Druk hier</a> voor informatie over beschikbare tags.).</B><br>";
			else
			print "<b>Bericht: <font size=1>HTML is niet toegestaan. <a href=tags.php target=_blank>Druk hier</a> voor informatie over beschikbare tags.</B>&nbsp;(Verplicht veld)<br>";
			if ($receiver == 0){
					if (get_user_class() >= UC_OWNER)
			print "<font size=2></td></tr>";
			else
			print "<p align=center><b>U dient eerst een gebruiker te selecteren voor u een bericht kunt verzenden.</b></p></td></tr>";
			} else
			print "<center><textarea name=msg cols=130 rows=30>".htmlspecialchars($body)."</textarea></td></tr>";
			print "<tr>";

			print "<td class=embedded align=center><center><br>";
			print "<table class=bottom><tr>";
			if ($replyto)
			{
			print "<td class=embedded align=center><center>";
			print "<table class=bottom><tr>";
			print "<td class=embedded>";

			if ($CURUSER['deletepms'] == "yes")
			print "<input type=checkbox name='delete' value='yes' checked></td>";
				else
			print "<input type=checkbox name='delete' value='yes' ></td>";
		
			print "<td class=embedded>Bericht&nbsp;verwijderen&nbsp;waarop&nbsp;ik&nbsp;reageer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			print "</tr></table>";
			print "</td>";
			print "<input type=hidden name=origmsg value=".$replyto."></td>";
			}
			print "<td class=embedded>";
			if ($CURUSER['savepms'] == "no")
				print "<input type=checkbox name='save' value='yes'></td>";
			else
				print "<input type=checkbox name='save' value='yes' checked></td>";

			print "<td class=embedded>Bericht&nbsp;bewaren&nbsp;in&nbsp;Verzonden-Map&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			print "<td class=embedded colspan=2 align=center>";
	
			print "<center><input style='height: 30px;width: 120px' type=submit value='Bericht versturen'></td>";
			print "<input type=hidden name=receiver value=".$receiver.">";
			print "</form>";
			print "</tr>";
			print "</table></td></tr>";
			print "</table>";

				tabel_einde();
				page_einde();
				print "</table></table></tabel></tabel>";

				site_footer();
			die;
}
$staffmess = @$_GET['staffmess'];
if ($staffmess)		// staff-mess
{	
	$replyto = @$_GET["replyto"];
	if ($replyto && !is_valid_id($replyto))
		die;
	site_header("Nieuw Staff Bericht aan gebruikers", false);
	page_start(90);tabel_start();
	Tabel_top('Nieuw Staff Bericht maken en verzenden', 'center','90');

			print "<table class=messages width=100% border=0 cellspacing=0 cellpadding=0><tr>";
			print "<td colspan=2><b><font size=3 color=black></font></b></td></tr><tr>";
			print "<td valign=top width=125 class=text><b><div align=center>\n";
			print $leftmenu;
			print "</td>";

			print "<td width=90% valign=top class=text>";

						if (get_user_class() < UC_ADMINISTRATOR)
							{
							site_error_message1("Foutmelding", "U heeft geen rechten op deze pagina.");
							} else {

				print "<form id=frm1 method=post action=takestaffmess.php>";

				if (@$_GET["returnto"] || @$_SERVER["HTTP_REFERER"])
				{
				print "<input type=hidden name=returnto value=".@$_GET["returnto"]." ? ".@$_GET["returnto"]." : ".$_SERVER["HTTP_REFERER"].">";
				}
				print "<table align=center width=100% class=messages cellspacing=0 cellpadding=5><tr><td class=text><div align=center>";
				print "<table class=messages border=0 cellpadding=0 cellspacing=0><tr>";

				print "<td rowspan=2 class=embedded><b>Verstuur naar:</br></br></b></td>";
						if (get_user_class() >= UC_ADMINISTRATOR)
							{
				print "<td class=embedded border=0 width=40><input type=checkbox name=clases[] value=0></td><td class=embedded border=0>&nbsp;" . get_user_class_name(0) . "</td>";
				print "<td class=embedded border=0 width=40><input type=checkbox name=clases[] value=1></td><td class=embedded border=0>&nbsp;" . get_user_class_name(1) . "</td>";
				print "<td class=embedded border=0 width=40><input type=checkbox name=clases[] value=2></td><td class=embedded border=0>&nbsp;" . get_user_class_name(2) . "</td>";
				print "<td class=embedded border=0 width=40><input type=checkbox name=clases[] value=3></td><td class=embedded border=0>&nbsp;" . get_user_class_name(3) . "</td>";
				print "<td class=embedded border=0 width=40><input type=checkbox name=clases[] value=4></td><td class=embedded border=0>&nbsp;" . get_user_class_name(4) . "</td>";		   
						   }
						if (get_user_class() >= UC_OWNER)
							{
				
				print "</tr><tr>";
				print "<td class=embedded border=0 width=40><input type=checkbox name=clases[] value=5></td><td class=embedded border=0>&nbsp;" . get_user_class_name(5) . "</td>";				
				print "<td class=embedded border=0 width=40><input type=checkbox name=clases[] value=255 checked></td><td class=embedded border=0>&nbsp;" . get_user_class_name(255) . "</td>";				
				print "<td class=embedded border=0 width=40><input type=checkbox name=checkall onclick='checkedAll(frm1)'></td><td class=embedded border=0>&nbsp;Alle users</td>";
                            }
				print "</td></tr></table></td></tr>";

				print "<tr><td class=embedded><center><b>Onderwerp:</b>&nbsp;&nbsp;<input type=text name=subject size=110><hr></td></tr>";
				print "<tr><td class=embedded><center><b>Bericht:</b>(HTML is niet toegestaan. <a href=tags.php target=_blank>Druk hier</a> voor informatie over beschikbare tags.)<br /><center><textarea name=msg cols=130 rows=30>".@$body."</textarea></center></td></tr>";

				print "<tr><td class=embedded colspan=2><div align=center><b>Versturen als:&nbsp;&nbsp;</b>".$CURUSER['username']."<input name=sender type=radio value=self>&nbsp;Systeem<input name=sender type=radio value=system></div></td></tr>";
				print "<tr><td class=embedded colspan=2><div align=center><input type=submit value='Verstuur!' class=btn></td></tr>";
				
				print "</table><input type=hidden name=receiver value=".@$receiver."></form>";
				print "</div></td></tr></table>";

			print "</td></tr>";
							}
}
//staff-mess
else		// Postvak-in
{
		$res1 = mysqli_query($con_link, "SELECT COUNT(*) FROM messages WHERE receiver=" . $CURUSER["id"] . " && unread='yes'") or die("OopppsY!");
		$arr1 = mysqli_fetch_row($res1);
		$unread1 = $arr1[0];
		if ($unread1 > 0)
		$unreadhead = "(".$unread1.")";
	site_header("Postvak-in ".@$unreadhead, false);
	page_start(90);tabel_start();
	tabel_top('***	LET OP ***', 'center','90');

			print "<table class=messages width=100% border=0 cellspacing=0 cellpadding=0><tr>";
			print "<td colspan=2><div align=center><font size=3 >Communicatie is van belang, lees eerst al uw berichten voor u verder kunt.</font></br><font size=2 >Tip: Om een bericht te openen klikt u op de datum of de onderwerp van het bericht, u wordt dan naar de juiste bericht gestuurt.</br></font></td></tr>";
			print "<td valign=top width=125 class=text><b><div align=center>\n";
			print $leftmenu;
			print "</td>";
			print "<td width=99% valign=top class=text>";

$message_id = @$_GET['message_id'];
if ($message_id)		// Bericht
{
			$res = mysqli_query($con_link, "SELECT * FROM messages WHERE id=".$message_id) or die("barf!");

				while ($arr = mysqli_fetch_assoc($res))
				{
					if (is_valid_id($arr["sender"]))
				{
				$res2 = mysqli_query($con_link, "SELECT username FROM users WHERE id=" . $arr["sender"]) or sqlerr();
				$arr2 = mysqli_fetch_assoc($res2);
				if ($arr["unread"] == "yes")
				$sender = "<a class=altlink_red href=userdetails.php?id=" . $arr["sender"] . ">" . get_usernamesitesmal($arr["sender"]) . "</a>";
				else
				$sender = "<a class=altlink_blue href=userdetails.php?id=" . $arr["sender"] . ">" . get_usernamesitesmal($arr["sender"]) . "</a>";
				}
				else
				$sender = $SITE_NAME;
				$elapsed = get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]));
					if (!isset($CURUSER) || ($CURUSER["id"] != $arr["receiver"])) {
				print "<h1 align=center>U heeft een ongeldig Message ID opgegeven.</h1>";
				print "<p align=center>Ga terug en probeer het nogmaals.</p>";
				tabel_einde();
				page_einde();
				print "</table></table></tabel></tabel>";

				site_footer();
				die;
					}
				if ($arr["unread"] == "yes")
				mysqli_query($con_link, "UPDATE messages SET unread='no' WHERE id=" . $message_id) or die("arghh");
				print "<p><table class=main width=100% border=1 cellspacing=0 cellpadding=5>";
				if ($arr['sender'] == 0)
				$bgcolormsg='white';
				else
				$bgcolormsg='white';
				print "<tr><td bgcolor=$bgcolormsg>";
				
				print "<table bgcolor=$bgcolormsg class=main width=100% cellspacing=0 cellpadding=5><tr>";
				print "<td bgcolor=$bgcolormsg width=1% class=inbox><div align=right><b>Datum:</td><td bgcolor=$bgcolormsg class=inbox>";
				print "".convertdatum($arr['added'])." ($elapsed geleden)";
				print "</td></tr>";
				print "<td bgcolor=$bgcolormsg class=inbox><div align=right><b>Afzender:</td><td bgcolor=$bgcolormsg class=inbox>".$sender."</td></tr>";
				print "<td bgcolor=$bgcolormsg class=inbox><div align=right><b>Onderwerp:</td><td bgcolor=$bgcolormsg class=inbox>";
				print stripslashes(format_comment(@$arr["subject"]));
				print "</td></tr></table>";
				
				print "<tr><td bgcolor=$bgcolormsg>";
				print(stripslashes(format_comment($arr["msg"])));
				print("</td></tr></table></p>\n<p>");

				print("<table class=bottom width=100% border=0><tr>\n");

				if ($arr['sender'] != 0)
					{
					print "<td class=embedded>";
					print "<table class=bottom border=0><tr><td class=embedded><div align=center>";

					print "<form method=get action='inbox.php'>";
					print "<input type=hidden name=send value=1>";
					print "<input type=hidden name=receiver value=".$arr["sender"].">";
					print "<input type=hidden name=replyto value=".$arr["id"].">";
//					print "<input type=hidden name=replyto value=".$arr["id"].">";
	
					print "<input type=submit class=btn style='height: 24px;font-weight: bold;width: 100px;color:white;background: green;font-size:11px' value='Beantwoorden'>";
					print "</form></td>";
					}
				else
					{
					print "<td class=embedded width=10>";
					print "<table class=bottom width=100 border=0><tr><td class=embedded>";
					print "<td class=embedded>";
					print "&nbsp;";
					print "</td>";
					}
				print "</td><td class=embedded width=10></td><td class=embedded width=10><div align=left>";
				print "<form method=get action='deletemessage.php'>";
				print "<input type=hidden name=type value=in>";
				print "<input type=hidden name=id value=".$arr["id"].">";
				print "<input type=submit class=btn style='height: 24px;font-weight: bold;width: 100px;color:white;background: red;font-size:11px' value='Verwijderen'>";
				print "</form>";
				print "</td>";
				print "</td>";
				print "<td class=embedded width=10> </td>";

				print "<td class=embedded><form method=get action=''>";
				print "<input type=hidden name=type value=save>";
				print "<input type=hidden name=id value=".$arr["id"].">";
				print "<input type=submit class=btn style='height: 24px;font-weight: bold;width: 100px;color:blue;background: orange;font-size:11px' value='Opslaan'>";
				print "</form>";
				print "</td></tr></table>";
				print "</td>";

				if (get_user_class() >= UC_OWNER)
					{
					print "<td class=embedded><table class=bottom width=100% border=0><tr><td class=embedded><div align=right>\n";
					print "<form method=get action=sendmessage_fw.php>";
					print "<input type=hidden name=msg_id value=".$arr["id"].">";
					print "<select name='stuur_naar'><option value=0>--- stafleden ---</option>";
					$def = mysqli_query($con_link, "SELECT * FROM users WHERE class > 3 AND class != 7 ORDER BY class DESC") or die("barf!");
					while ($defs = mysqli_fetch_assoc($def))
						{
						print "<option value=" . $defs['id'] . ">" . $defs['username'] . " - " . get_user_class_name($defs['class']) . "</option>";
						}
					print "</select>";
					print "<input type=submit style='height: 24px;font-weight: bold;width: 100px;color:white;background: blue;font-size:11px' value='Doorsturen'>";
					print "</form>";
					print "</td></tr></table></td>";
					}

				print("</tr></table></tr></table>\n");
				print ("</p>");
}
tabel_einde();
page_einde();
print "</table></table></tabel></tabel><br>";
print "</table></table></tabel></tabel>";

site_footer();
	die;
		}

	print "<META HTTP-EQUIV=REFRESH CONTENT='45; URL=inbox.php'>";
				print("<table class=site width=100% border=0 cellspacing=0 cellpadding=5>\n");
				
				print "<tr><td class=embedded width=1%><form id=frm1 method=post action=/take-delmpx.php><input type=checkbox name=checkall onclick='checkedAll(frm1);'>";

				print "</td><td width=200 class=embedded>Afzender</td><td class=embedded>Onderwerp</td><td class=embedded>Datum en Tijd</td></tr>";
				{
	$res = mysqli_query($con_link, "SELECT * FROM messages WHERE receiver=" . $CURUSER["id"] . " AND location IN ('in','both') ORDER BY added DESC") or die("barf!");
	if (mysqli_num_rows($res) == 0)
    	print "<tr><td colspan=4 class=messages_bottom align=center><h1>U heeft geen ontvangen berichten in uw Inbox!</h1></td></tr>";
	else
		$start = 1;
		while ($arr = mysqli_fetch_assoc($res))
		{
			if (is_valid_id($arr["sender"]))
			{
				$res2 = mysqli_query($con_link, "SELECT username FROM users WHERE id=" . $arr["sender"]) or sqlerr();
				$arr2 = mysqli_fetch_assoc($res2);
			if ($arr["unread"] == "yes")
				$sender = "<a class=altlink_red href=userdetails.php?id=" . $arr["sender"] . ">" . get_usernamesitesmal($arr["sender"]) . "</a>";
				else
				$sender = "<a class=altlink_blue href=userdetails.php?id=" . $arr["sender"] . ">" . get_usernamesitesmal($arr["sender"]) . "</a>";
			}
			else
				$sender = $SITE_NAME;
			$elapsed = get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]));

			if ($start == 1) {
				$start = 2;}
			else $start = 1;
			if ($start == 2)
				$bgcolor = "bgcolor=#2050bf";
			else
				$bgcolor = "bgcolor=#2050bf";
			if ($arr["unread"] == "yes"){
				$s = "<td $bgcolor class=inbox onClick=\"location.href='/inbox.php?message_id=".$arr["id"]."'\"><font color=red><b>$sender</b></font></td>";
				$s .= "<td $bgcolor class=inbox onClick=\"location.href='/inbox.php?message_id=".$arr["id"]."'\"><font color=red><b>".@$arr["subject"]."</b></font></td>";
				$s .= "<td $bgcolor class=inbox onClick=\"location.href='/inbox.php?message_id=".$arr["id"]."'\"><font color=red><b>".convertdatum($arr['added'])." ($elapsed geleden)</b></font></td>";
			} else {
				$s = "<td $bgcolor class=inbox onClick=\"location.href='/inbox.php?message_id=".$arr["id"]."'\">$sender</td>";
				$s .= "<td $bgcolor class=inbox onClick=\"location.href='/inbox.php?message_id=".$arr["id"]."'\">".@$arr["subject"]."</td>";
				$s .= "<td $bgcolor class=inbox onClick=\"location.href='/inbox.php?message_id=".$arr["id"]."'\">".convertdatum($arr['added'])." ($elapsed geleden)</td>";}
				
				    echo("<tr><td $bgcolor class=inbox>");
					if ($arr["unread"] == "no")
					echo("<input type=checkbox name=delmp[] value=" . $arr['id'] . ">");
					echo("</TD>\n");
				print "$s</td></tr>";
			}
				if (mysqli_num_rows($res) == 0)
				print "";
				else
				print "<tr><td class=messages_bottom colspan=4 border=0><b>De geselecteerde berichten:&nbsp;<input type=submit value='Verwijderen!' /></form></b></td></tr>";

			}
				print "<tr><td class=messages_bottom colspan=4 border=0><b>Let Op!!! De Inbox ververst elke minuut!</b></td></tr>";
				print("<table></tr></table></tr></table>\n");
			}

				print("<table></tr></table></tr></table>\n");
				print ("</p>");
				tabel_einde();
				page_einde();
				print "</table></table></tabel></tabel>";

				site_footer();
?>