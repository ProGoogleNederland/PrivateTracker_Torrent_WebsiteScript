<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
	$receiver = (int)@$_GET["receiver"];
	if (!is_valid_id($receiver))
	  die;

	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$receiver") or die(mysqli_error());
	$user = mysqli_fetch_assoc($res);
	if (!$user)
	  die("Geen gebruiker gevonden met dit ID.");

	$ontvanger = $user['username'];
	$downloaded = mksize($user['downloaded']);
	$uploaded = mksize($user['uploaded']);
	$verschil = mksize($user['downloaded'] - $user['uploaded']);
	$ratio =  number_format((($user["downloaded"] > 0) ? ($user["uploaded"] / $user["downloaded"]) : 0),2);
	$tijd = get_tijdverschil(sql_timestamp_to_unix_timestamp($user["added"]),sql_timestamp_to_unix_timestamp($user["last_access"]));
	}

$default =  @$_POST['default'];
$default =  @$_GET['default'];

$uploader = (string)@$_GET["uploader"];
if ($uploader == "aanvraag")
	{
	$body = "UPLOADER AANVRAAG\n\n";
	$body .= "Vul onderstaand formulier volledig in:\n";
	$body .= "==-==-==-==-==-==-==-==-==-==-==-==-==\n";
	$body .= "1- Heeft u kennis van DHT en PeerExchange?:\n";
	$body .= "2- Heeft u ervaring met uploaden?:\n";
	$body .= "3- Wat is uw upload snelheid?:\n";
	$body .= "4- Hoe regelmatig denkt u iets te uploaden?:\n";
	$body .= "5- Wat denkt u te gaan uploaden?:\n";
	$body .= "Eventuele opmerkingen:\n\n";
	$body .= "==-==-==-==-==-==-==-==-==-==-==-==-==\n";
	$body .= "Alleen versturen indien u uploader wilt worden,\nen vragen 1 en 2 met Ja heeft beantwoord.\n";
	}

if ($default)
	{
	$body=$default;
	}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
	if (get_user_class() < UC_ADMINISTRATOR)
		site_error_message("Foutmelding", "Toegang geweigerd");

	$n_pms = @$_POST['n_pms'];
	$pmees = @$_POST['pmees'];
	$auto = @$_POST['auto'];
	
	if ($auto)
		$body=$mm_template[$auto][1];

	site_header("Bericht verzenden", false);
		
print("<table class=bottom width=90% border=0 cellspacing=0 cellpadding=0><tr><td class=embedded-page>\n");
	tabel_top ("Massaal bericht aan $n_pms gebruikers","center");
	print "<form method=post action=takemessage.php>";
	if ($_SERVER["HTTP_REFERER"])
		{
		print "<input type=hidden name=returnto value='usersearch.php?massa=massa'>";
		}
	print "<table border=1 cellspacing=0 cellpadding=5>";
	?>
	
	<tr><td colspan="2"><div align="center">
	<textarea name=msg cols=150 rows=20><?php echo htmlspecialchars($body)?></textarea>
	</div></td></tr>
  <tr><td><div align="center"><b>Van:&nbsp;&nbsp;</b>
	<?php echo $CURUSER['username']?>
	<input name="sender" type="radio" value="self" checked>
	&nbsp; <? print $SITE_NAME; ?>
	<input name="sender" type="radio" value="system">
	</div></td></tr>
	<tr><td colspan="2" align=center><input type=submit value="Verzenden" class=btn>
	</td></tr></table>
	<input type=hidden name=pmees value="<?php echo $pmees?>">
	<input type=hidden name=n_pms value=<?php echo $n_pms?>>
	</form><br><br>
	</td></tr></table>
  <?
} else
	{	// Normaal bericht
	$receiver = @$_GET["receiver"];
	if (!is_valid_id($receiver))
		die;

	$replyto = @$_GET["replyto"];
	if ($replyto && !is_valid_id($replyto))
		die;

	$auto = @$_GET["auto"];
	$std = @$_GET["std"];
	$warning = @$_GET["warning"];

	if (($auto || $std ) && get_user_class() < UC_MODERATOR)
		die("Toegang geweigerd.");

	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$receiver") or sqlerr(__FILE__, __LINE__);
	$user = mysqli_fetch_assoc($res);
	if (!$user)
		die("Geen gebruiker gevonden met dit ID.");

	if ($auto)
		$body = $pm_std_reply[$auto];
	if ($std)
		$body = $pm_template[$std][1];
	if ($warning)
		$body = $pm_std_warning[$warning];


	if ($replyto)
		{
		$res = mysqli_query($con_link, "SELECT * FROM messages WHERE id=$replyto") or sqlerr(__FILE__, __LINE__);
		$msga = mysqli_fetch_assoc($res);
		if ($msga["receiver"] != $CURUSER["id"])
			die;
		$res = mysqli_query($con_link, "SELECT username FROM users WHERE id=" . $msga["sender"]) or sqlerr(__FILE__, __LINE__);
		$usra = mysqli_fetch_assoc($res);
		$body .= "\n\n\n-------- $usra[username] schreef: --------\n".htmlspecialchars($msga['msg'])."\n";
		}
	site_header("Bericht versturen", false);
	print "<table class=bottom width=800 border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>";
	print "<div align=center>";
	$aan_gebruiker = "Bericht aan <a href=userdetails.php?id=" . $receiver . "><font color=#FFFF99>" . get_usernamesite($user['id']) . "</a>";
	tabel_top($aan_gebruiker,"center");
	tabel_start();

	if (!$replyto)
		{
		if (get_user_class() >= UC_MODERATOR)
			{
			print "<form method=get action=sendmessage.php>";
			if (@$_GET["returnto"] || $_SERVER["HTTP_REFERER"])
				{
				if (@$_GET["returnto"])
					print "<input type=hidden name=returnto value=".@$_GET["returnto"].">";
				else
					print "<input type=hidden name=returnto value=".$_SERVER["HTTP_REFERER"].">";
				} 
			print "<input type=hidden name=receiver value=".$receiver.">";
			while ($defs = @mysqli_fetch_assoc(@$def))
				{
				print "<option value=" . $defs['id'] . ">" . $defs['sjabloon'] . "</option>";
				}
			print "</form><hr>";
			}
		}

	print "<form method=post action=takemessage.php>";
	if (@$_GET["returnto"] || $_SERVER["HTTP_REFERER"])
		{
		if (@$_GET["returnto"])
			print "<input type=hidden name=returnto value=".@$_GET["returnto"].">";
		else
			print "<input type=hidden name=returnto value=".$_SERVER["HTTP_REFERER"].">";
		} 
	$body = htmlspecialchars(@$body);
	print "<table align=center class=bottom width=15% border=0 cellspacing=0 cellpadding=5>";
	if ($default)
		{
		if ($replyto)
			print "<tr><td class=embedded colspan=2>";
		else
			print "<tr><td class=embedded>";
		print "<center><textarea name=msg cols=130 rows=20>".htmlspecialchars($default)."</textarea></td></tr>";
		print "";
		print "";
		}
	else
		{
		if ($replyto)
			print "<tr><td class=embedded colspan=2>";
		else
			print "<tr><td class=embedded>";
		print "<center><textarea name=msg cols=130 rows=20>".htmlspecialchars($body)."</textarea></td></tr>";
		print "<tr>";
		print "";
		}

	if ($replyto)
		{
		print "<td class=embedded align=center><center><br>";
		print "<table class=bottom><tr>";
		print "<td class=embedded>";

		if ($CURUSER['deletepms'])
			print "<input type=checkbox name='delete' value='yes' checked></td>";
		else
			print "<input type=checkbox name='delete' value='yes' ></td>";
		
		print "<td class=embedded><font color=white>Het&nbsp;bericht&nbsp;waarop&nbsp;u&nbsp;antwoord&nbsp;verwijderen</td>";
		print "</tr></table>";
		print "</td>";
		print "<input type=hidden name=origmsg value=".$replyto."></td>";
		}
	
	print "<td class=embedded align=center><center><br>";
	print "<table class=bottom><tr>";
	print "<td class=embedded>";
	if ($CURUSER['savepms'])
		print "<input type=checkbox name='save' value='yes'></td>";
	else
		print "<input type=checkbox name='save' value='yes' checked></td>";

	print "<td class=embedded><font color=white>Bewaar&nbsp;dit&nbsp;bericht&nbsp;in&nbsp;uw&nbsp;postvak-uit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
	if ($replyto)
		print "<td class=embedded align=center>";
	else
		print "<td class=embedded colspan=2 align=center>";

	print "<center><input style='height: 30px;width: 120px' type=submit value='Bericht versturen'></td>";
	print "</tr>";
	print "</table></td></tr>";
	print "</table>";
	print "<input type=hidden name=receiver value=".$receiver.">";
	print "</form>";
	tabel_einde();
	print "</td>";
	print "</tr></table>";
}
print "<br>";
site_footer();
?>