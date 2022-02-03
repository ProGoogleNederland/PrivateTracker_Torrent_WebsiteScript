<?php
// Email script en database gemaakt door Rockstar/ Logitech (c) 2009
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn();
loggedinorreturn();
@noaccess(UC_ADMINISTRATOR,MASSPM,$CURUSER['id'],$CURUSER['username']);
site_header("Forever Newsletter");

if($_SERVER['REQUEST_METHOD'] == "POST"){
//$query = @mysqli_query($con_link, "SELECT username,email FROM `users` ORDER BY `username` ASC") or die(mysqli_error());
$query = @mysqli_query($con_link, "SELECT email FROM `email` ORDER BY `id` DESC") or die(mysqli_error($con_link));
while($mailqu = mysqli_fetch_assoc($query)){
$header = "From: Powertor <webmaster@the-place.info>\r\n";
$header .= "Reply-To: webmaster@the-place.info\r\n";
$header .= "MIME-Version: 1.0\r\n"; 
$header .= "Content-Type: text/html; charset=iso-8859-1\r\n"; 


$header .= "Content-Type: text/html; charset=UTF-8\n";
$header .= "Content-Transfer-Encoding: 8bit\n\n";
$message = "<html><body>Beste,<BR><BR>".$_POST['bericht']."<BR><BR />Met vriendelijke groet,<BR />Staff Powertor<BR /><a href='http://www.the-place.info'>http://www.the-place.info</a></body></html>";

mail("".$mailqu['email']."", "".$_POST['titel']."", $message, $header);

//echo'<table border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>Verzonden naar: '.$mailqu['email'].'</td></tr></table>';
 }
} else {
?>

<form method="POST">
  <table border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2"><strong>Torrent Media Nieuwsbrief</strong></td>
    </tr>
    <tr>
      <td width="80"><strong>Titel: </strong></td>
      <td><input name="titel" type="text" size="75" /></td>
    </tr>
    <tr>
      <td><strong>**********************************</strong></td>
      <td>Beste Leden,<BR />
        <BR />
        <textarea name="bericht" cols="75" rows="10" id="bericht"></textarea>
        <BR />
        Met vriendelijke groet,<BR />
        - TEAM -<BR />
        <a href="https://torrentmedia.org">TorrentMedia</a></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="right"><input type="submit" value="Verzend" />
        <input type="reset" value="Reset" /></td>
    </tr>
  </table>
</form>
<? } site_footer(); ?>
