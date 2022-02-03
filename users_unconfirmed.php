<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();


if(isset($_POST['accept'])){
	$accept = $_POST['userid'];
    $result = mysqli_query($con_link, "UPDATE users SET status='confirmed', editsecret='' WHERE id=$accept AND status='pending'");
};  
	
if(isset($_POST['delete'])){
	$accept2 = $_POST['userid'];
	$result2 = mysqli_query($con_link, "SELECT * FROM users WHERE id=".$accept2) or sqlerr(__FILE__, __LINE__);
};  


if (get_user_class() < UC_OWNER)
	site_error_message("Fout", "Toegang geweigerd.");

$res = mysqli_query($con_link, "SELECT * FROM users WHERE status='pending'") or sqlerr(__FILE__, __LINE__);

site_header("Accounts onbevestigd");
tabel_start();
tabel_top("Gebruikers die nog niet bevestigd zijn", "center");
print("<table width=100% border=0 cellspacing=0 cellpadding=10><tr><td class=embedded><br>");
print("<table align=center class=sitetable border=1 width=98% cellspacing=0 cellpadding=5>");

print "<tr>";
print "<td class=colheadsite>Datum</td>";

print "<td class=colheadsite>Gebruiker</td>";
print "</tr>";

$editsecret = $PASSWORD_HASH;
$psecret = md5($editsecret);

while ($row = mysqli_fetch_assoc($res))
	{ 
	
	print "<tr>";
	print "<td bgcolor=darkblue>".convertdatum($row['added'], "no")."</td>";
	$ip = sqlesc(long2ip(@$arr['first']));
	$count = get_row_count("users","WHERE ip=$ip");
	print "<td bgcolor=darkblue align=center>";
	print "<a class=altlink_red href=userdetails.php?id=" . $row['id'] . ">" . get_usernamesitesmal($row['id']) . " " . get_ratio($row['id']) . "</a><br>";
	print "<font color=blue size=2><b>" . get_user_class_name($row['class']) . "</b></font><br>";
	print "<font color=blue size=2><b>Krediet: " . $row['credits'] . "</b></font><br>";
	print "<br><form method='post' action=''>";
	print "<input type=hidden name='userid' value=" . $row['id'] . ">";
	print "<input type=hidden name=returnto value='users_unconfirmed.php'>";
    print "<input type='submit' name='accept' onclick='myfunc()' style='height: 22px;width: 150px;color:red;font-weight:bold' value='ACCEPTEER'>";
	print "</form>";
	print "<br><form method='post' action='user_delete_noban.php'>";
	print "<input type=hidden name='userid' value=" . $row['id'] . ">";
	print "<input type=hidden name=action value=verwijderen>"; 
	print "<input type=hidden name=returnto value='users_unconfirmed.php'>";
	print "<input type='submit' name='delete' onclick='myfunc()' style='height: 22px;width: 150px;color:red;font-weight:bold' value='VERWIJDER'>";
    print "</form>";
	print "</td>";
	print "</tr>";
	$temp = long2ip(@$arr['first']);
	};

tabel_einde();
page_einde();
site_footer();
?>