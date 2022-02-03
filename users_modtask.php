<?php
require_once("include/bittorrent.php");
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "Deze pagina is alleen voor Moderator en hoger.");

if(isset($_POST['action']))
	$action = @$_POST['action'];
else
	$action = @$_GET['action'];

if ($action == "del_peers")
	{
	$user_id = 0 + $_POST['user_id'];
	mysqli_query($con_link, "DELETE FROM peers WHERE userid=$user_id") or sqlerr(__FILE__, __LINE__);
	$extra_text = "Bronnen verwijderd.";
	$action = "view";
	}

if ($action == "invite_list")
	{
	if (get_user_class() < UC_SYSOP)
		site_error_message("Foutmelding", "Deze optie is alleen voor de beheerders en hoger.");
	$user_id = 0 + $_POST['user_id'];
	mysqli_query($con_link, "UPDATE users SET invited_by=0 WHERE invited_by=$user_id") or sqlerr(__FILE__, __LINE__);
	$extra_text = "Uitnodigingen lijst geleegd.";
	$action = "view";
	}

if ($action == "invites_null")
	{
	if (get_user_class() < UC_SYSOP)
		site_error_message("Foutmelding", "Deze optie is alleen voor de beheerders en hoger.");
	$user_id = 0 + $_POST['user_id'];
	mysqli_query($con_link, "UPDATE users SET invites = 0 WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	$extra_text = "Uitnodigingen verwijderd.";
	$action = "view";
	}

if ($action == "super_seeder")
	{
	$user_id = 0 + $_POST['user_id'];
	$waarde = @$_POST['waarde'];
	if ($waarde == "yes")
		$msg = "Hallo " . get_username($user_id) . ",\n\nU heeft met onmiddelijke ingang de status 'Super Deler' gekregen.\n\nDaar er is geconstateerd dat u met een hogere uploadsnelheid heeft dan 1 mbit.\n\nDit geeft geen extra voordelen, behalve dat u niet meer geregistreerd wordt voor vals spel.\n\nMet vriendelijke groeten,\n\n" . $CURUSER['username'];
	else
		$msg = "Hallo " . get_username($user_id) . ",\n\nDe status 'Super Deler' is u ontnomen.\n\n" . $CURUSER['username'];

	$waarde = sqlesc($waarde);
	mysqli_query($con_link, "UPDATE users SET super_seeder = $waarde WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);

	$message =	sqlesc($msg);
	$added = sqlesc(get_date_time());
	$sender = $CURUSER['id'];
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES ($sender, $user_id, $message, $added)") or sqlerr(__FILE__, __LINE__);

	$action = "view";
	}
	
if ($action == "shoutblok")
	{
	$user_id = 0 + $_POST['user_id'];
	$waarde = @$_POST['waarde'];
	if ($waarde == "yes")
		$msg = "Hallo " . get_username($user_id) . ",\n\nU ben vanaf heden geblokkeerd om in de shoutbox te komen.\n\nEn de mogelijkheid is u ontnomen om een bericht te plaatsen in de smsbalk\n\nMocht u hier bezwaar tegen willen nemen kunt u contact opnemen met beheerder.\n\nMet vriendelijke groeten,\n\n" . @$CURUSER['sitename'];
	else
		$msg = "Hallo " . get_username($user_id) . ",\n\nU bent vanaf heden weer toegestaan op de shoutbox en u kunt weer berichten plaatsen in de smsbalk.\n\n" . $CURUSER['username'];

	$waarde = sqlesc($waarde);
	mysqli_query($con_link, "UPDATE users SET shoutblok = $waarde WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);

	$message =	sqlesc($msg);
	$added = sqlesc(get_date_time());
	$sender = $CURUSER['id'];
	mysqli_query($con_link, "INSERT INTO messages (sender, receiver, msg, added) VALUES ($sender, $user_id, $message, $added)") or sqlerr(__FILE__, __LINE__);

	$action = "view";
	}
if ($action == "reset_passkey")
	{
	$user_id = 0 + $_POST['user_id'];
//	mysqli_query($con_link, "UPDATE users SET passkey = 'leeg' WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);
	if ($row)
		{
		$passkey = md5($row['username'].get_date_time().$row['passhash']);
		mysqli_query($con_link, "UPDATE users SET passkey='$passkey' WHERE id=$row[id]");
		$extra_text = "Reset passkey gelukt.";
		}
	else
		$extra_text = "Reset passkey NIET gelukt.";

	$action = "view";
	}
	
if ($action == "view")
	{
	if(isset($_POST['user_id']))
		$user_id = 0 + $_POST['user_id'];
	else
		$user_id = 0 + $_GET['user_id'];

	$res = mysqli_query($con_link, "SELECT * FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	$row = mysqli_fetch_array($res);

	site_header("Moderator");
	page_start(98);
	tabel_top("Moderator opties voor gebruiker ".get_username($user_id),"center");
	tabel_start();

	if (@$extra_text)
		print "<center><font size=3 color=yellow><b>" . $extra_text . "</b></font></center><br>";

	if (get_user_class() >= UC_OWNER)
		{
		print "<table width=85% class=sitetable border=1 cellspacing=0 cellpadding=2>";
		print "<tr><td width=250 align=right><form method=get action=user_credits.php>";
		print "<input type=hidden name=user_id value=" . $user_id . ">";
		print "<input type=submit style='height: 22px;width: 200px' value='Krediet toevoegen'></form>";
		print "</td><td>Krediet geven aan <font color=blue><b>".get_username($user_id)."</b></font>.</td></tr>";

		print "<tr><td width=250 align=right><form method=get action=user_donate_date.php>";
		print "<input type=hidden name=user_id value=" . $user_id . ">";
		print "<input type=submit style='height: 22px;width: 200px' value='Gebruiker donatiedatum'></form>";
		print "</td><td>Gebruiker <font color=blue><b>".get_username($user_id)."</b></font> donatie datum aanpassen.</td></tr>";
		

		print "</table>";

		print "<table width=85% class=sitetable border=1 cellspacing=0 cellpadding=2>";
		
		print "<tr><td width=250 align=right><form method=get action=credits_admin.php>";
		print "<input type=hidden name=user_id value=" . $user_id . ">";
		print "<input type=submit style='height: 22px;width: 200px' value='Krediet gebruiken'></form>";
		print "</td><td>Krediet gebruiken voor <font color=blue><b>".get_username($user_id)."</b></font>.</td></tr>";

		print "<tr><td width=250 align=right><form method=get action=inbox_spy.php>";
		print "<input type=hidden name=id value=" . $user_id . ">";
		print "<input type=submit style='height: 22px;width: 200px' value='Postvak-IN'></form>";
		print "</td><td>Postvak in van <font color=blue><b>".get_username($user_id)."</b></font> bekijken.</td></tr>";

		print "<tr><td width=250 align=right><form method=get action=inbox_spy.php>";
		print "<input type=hidden name=out value=" . $user_id . ">";
		print "<input type=submit style='height: 22px;width: 200px' value='Postvak-UIT'></form>";
		print "</td><td>Postvak uit van <font color=blue><b>".get_username($user_id)."</b></font> bekijken.</td></tr>";

		print "<tr><td width=250 align=right><form method=get action=user_gb_edit.php>";
		print "<input type=hidden name=user_id value=" . $user_id . ">";
		print "<input type=submit style='height: 22px;width: 200px' value='GB totalen aanpassen'></form>";
		print "</td><td>Totaal verzonden en totaal ontvangen van <font color=blue><b>".get_username($user_id)."</b></font> aanpassen.</td></tr>";

		print "<tr><td width=250 align=right><form method=get action=user_gb_bonus.php>";
		print "<input type=hidden name=user_id value=" . $user_id . ">";
		print "<input type=submit style='height: 22px;width: 200px' value='Bonus in Gb'></form>";
		print "</td><td><font color=blue><b>".get_username($user_id)."</b></font> een bonus geven in GigaBytes.</td></tr>";

		print "<tr><td width=250 align=right><form method=post action=user_delete.php>";
		print "<input type=hidden name=userid value=" . $user_id . ">";
		print "<input type=hidden name=action value=verwijderen>";
		print "<input type=checkbox name=sure>";
		print "<input type=submit style='height: 22px;width: 200px' value='Account verwijderen ipban'></form>";
		print "</td><td>Gebruiker <font color=blue><b>".get_username($user_id)."</b></font> definitief verwijderen met een ip-ban.</td></tr>";
		
		print "<tr><td width=250 align=right><form method=post action=user_delete_noban.php>";
		print "<input type=hidden name=userid value=" . $user_id . ">";
		print "<input type=hidden name=action value=verwijderen>";
		print "<input type=checkbox name=sure>";
		print "<input type=submit style='height: 22px;width: 200px' value='Account verwijderen'></form>";
		print "</td><td>Gebruiker <font color=blue><b>".get_username($user_id)."</b></font> definitief verwijderen zonder ip-ban.</td></tr>";		

		
		
////////////////////////////////////////////////
		if (get_shout_blok($user_id) == "yes")
			{
			print "<tr><td width=250 align=right><form method=post action=users_modtask.php>";
			print "<input type=hidden name=action value=shoutblok>";
			print "<input type=hidden name=waarde value=no>";
			print "<input type=hidden name=user_id value=" . $user_id . ">";
			print "<input type=submit style='height: 22px;width: 200px' value='Blokkade uitzetten'></form>";
			print "</td><td><font color=black>Shoutbox en smsbalk blokkade voor <font color=red><b>".get_username($user_id)."</b></font><font color=white> uit zetten.</td></tr>";
			}
		else
			{
			print "<tr><td width=250 align=right><form method=post action=users_modtask.php>";
			print "<input type=hidden name=action value=shoutblok>";
			print "<input type=hidden name=waarde value=yes>";
			print "<input type=hidden name=user_id value=" . $user_id . ">";
			print "<input type=submit style='height: 22px;width: 200px' value='Blokkade aanzetten'></form>";
			print "</td><td><font color=black>Shoutbox en smsbalk blokkade voor <font color=red><b>".get_username($user_id)."</b></font><font color=white> aan zetten.</td></tr>";
			
			print "</table>";
			}
///////////////////////////////////////////////////			

		print "<table width=85% class=sitetable border=1 cellspacing=0 cellpadding=2>";
		print "<tr><td width=250 align=right><form method=post action=user_name.php>";
		print "<input type=hidden name=userid value=" . $user_id . ">";
		print "<input type=submit style='height: 22px;width: 200px' value='Gebruikersnaam wijzigen'></form>";
		print "</td><td>Gebruikersnaam van <font color=blue><b>".get_username($user_id)."</b></font> wijzigen, mits deze nog niet wordt gebruikt.</td></tr>";

		print "<tr><td width=250 align=right><form method=post action=password_sysop.php>";
		print "<input type=hidden name=user_id value=" . $user_id . ">";
		print "<input type=submit style='height: 22px;width: 200px' value='Wachtwoord wijzigen'></form>";
		print "</td><td>Wachtwoord van <font color=blue><b>".get_username($user_id)."</b></font> wijzigen.</td></tr>";

		print "<tr><td width=250 align=right><form method=post action=user_account.php>";
		print "<input type=hidden name=userid value=" . $user_id . ">";
		print "<input type=hidden name='returnto' value='userdetails.php?id=" . $user_id . "'>";
		print "<input type=hidden name=action value=disable_warning>";
		print "<input type=checkbox name=sure>";
		print "<input type=submit style='height: 22px;width: 200px' value='Waarschuwing verwijderen'></form>";
		print "</td><td>Waarschuwing van <font color=blue><b>".get_username($user_id)."</b></font> verwijderen.</td></tr>";

		print "<tr><td width=250 align=right><form method=post action=user_ban.php>";
		print "<input type=hidden name=userid value=" . $user_id . ">";
		print "<input type=hidden name=action value=disable_ban>";
		print "<input type=checkbox name=sure>";
		print "<input type=submit style='height: 22px;width: 200px' value='IP-BAN'></form>";
		print "</td><td>Gebruikers account van <font color=blue><b>".get_username($user_id)."</b></font> uitschakelen met een ip-ban.</td></tr>";

		print "<tr><td width=250 align=right><form method=post action=user_account.php>";
		print "<input type=hidden name=userid value=" . $user_id . ">";
		print "<input type=hidden name='returnto' value='userdetails.php?id=" . $user_id . "'>";
		print "<input type=hidden name=action value=enable_account>";
		print "<input type=checkbox name=sure>";
		print "<input type=submit style='height: 22px;width: 200px' value='Account AAN'></form>";
		print "</td><td>Gebruikers account van <font color=blue><b>".get_username($user_id)."</b></font> inschakelen.</td></tr>";

		print "<tr><td width=250 align=right><form method=post action=user_account.php>";
		print "<input type=hidden name=userid value=" . $user_id . ">";
		print "<input type=hidden name='returnto' value='userdetails.php?id=" . $user_id . "'>";
		print "<input type=hidden name=action value=disable_account>";
		print "<input type=checkbox name=sure>";
		print "<input type=submit style='height: 22px;width: 200px' value='Account UIT'></form>";
		print "</td><td>Gebruikers account van <font color=blue><b>".get_username($user_id)."</b></font> uitschakelen.</td></tr>";

		print "<tr><td width=250 align=right><form method=get action=blokkeer_account.php>";
		print "<input type=hidden name=user_id value=" . $user_id . ">";
		print "<input type=submit style='height: 22px;width: 200px' value='Gebruikers account blokkeren'></form>";
		print "</td><td>Gebruikers account blokkeren, deze kan dan geen nieuwe torrents meer downloaden.</td></tr>";

		print "<tr><td width=250 align=right><form method=post action=user_email.php>";
		print "<input type=hidden name=userid value=" . $user_id . ">";
		print "<input type=submit style='height: 22px;width: 200px' value='E-mail wijzigen'></form>";
		print "</td><td>E-mailadres van <font color=blue><b>".get_username($user_id)."</b></font> wijzigen, mits deze nog niet wordt gebruikt.</td></tr>";
		
		print "<tr><td width=250 align=right><form method=post action=users_modtask.php>";
		print "<input type=hidden name=action value=reset_passkey>";
		print "<input type=hidden name=user_id value=" . $user_id . ">";
		print "<input type=submit style='height: 22px;width: 200px' value='Reset passkey'></form>";
		print "</td><td>Passkey resetten van <font color=blue><b>".get_username($user_id)."</b></font>. (huidige = ".$row['passkey'].")</td></tr>";

		print "</table>";
		}

	if (get_user_class() >= UC_ADMINISTRATOR)
		{
		print "<table width=85% class=sitetable border=1 cellspacing=0 cellpadding=2>";
		print "</td><td>Moderators</td></tr>";
		print "<tr><td width=250 align=right><form method=get action=extra_maxtorrents.php>";
		print "<input type=hidden name=user_id value=" . $user_id . ">";
		print "<input type=submit style='height: 22px;width: 200px' value='Extra maxtorrents'></form>";
		print "</td><td>Extra maxtorrents geven voor <font color=red><b>".get_username($user_id)."</b></font>.</td></tr>";
		
		print "<tr><td width=250 align=right><form method=post action=user_plaatjes.php>";
        print "<input type=hidden name=user_id value=" . $user_id . ">";
        print "<input class=btn_donatie_blauw type=submit style='height: 22px;width: 200px' value='Bedanktplaatjes wijzigen'></form>";
        print "</td><td><b><font color=blue>Bedanktplaatje van <font color=blue><b><b><a class=altlink_red href=userdetails.php?id=".$user_id.">" . get_usernamesite($user_id) . "</a></font> aanpassen.</td></tr>";
		
		print "<tr><td width=250 align=right><form method=get action=user_class.php>";
		print "<input type=hidden name=user_id value=" . $user_id . ">";
		print "<input type=submit style='height: 22px;width: 200px' value='Gebruiker status'></form>";
		print "</td><td>Gebruiker status van <font color=blue><b>".get_username($user_id)."</b></font> wijzigen.</td></tr>";	
			

		print "<tr><td width=250 align=right><form method=post action=users_modtask.php>";
		print "<input type=hidden name=action value=del_peers>";
		print "<input type=hidden name=user_id value=" . $user_id . ">";
		print "<input type=submit style='height: 22px;width: 200px' value='Bronnen verwijderen'></form>";
		print "</td><td>Alle bronnen van <font color=blue><b>".get_username($user_id)."</b></font> verwijderen.</td></tr>";

		print "<tr><td width=250 align=right><form method=get action=user_country.php>";
		print "<input type=hidden name=user_id value=" . $user_id . ">";
		print "<input type=submit style='height: 22px;width: 200px' value='Land wijzigen'></form>";
		print "</td><td>Land wijzigen van <font color=blue><b>".get_username($user_id)."</b></font>.</td></tr>";

		print "<tr><td width=250 align=right><form method=post action=user_avatar.php>";
		print "<input type=hidden name=user_id value=" . $user_id . ">";
		print "<input type=submit style='height: 22px;width: 200px' value='Avatar wijzigen'></form>";
		print "</td><td>Avatar van <font color=blue><b>".get_username($user_id)."</b></font> aanpassen.</td></tr>";

		print "</table>";
		}
	tabel_einde();
	page_einde();
	site_footer();
	die;
	}
?>