<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

// The following line may need to be changed to UC_MODERATOR if you don't have Forum Moderators
if ($CURUSER['class'] < UC_MODERATOR) die(); // No acces to below this rank
if ($CURUSER['override_class'] != 255) die(); // No access to an overridden user class either - just in case

if (@$_GET['action'] == 'editclass') //Process the querystring - No security checks are done as a temporary class higher
{                                   //than the actual class mean absoluetly nothing.
    $newclass = 0+@$_GET['class'];
    $returnto = @$_GET['returnto'];

    mysqli_query($con_link, "UPDATE users SET override_class = ".sqlesc($newclass)." WHERE id = ".$CURUSER['id']); // Set temporary class

    header ("Location: ".$BASEURL."/".htmlspecialchars($returnto));
    die();
}

// HTML Code to allow changes to current class
site_header("LOWER CLASS VIEW VOOR " . $CURUSER["username"]);
?>
<br>
<font size=4><b>Hiermee kunt u rechtstreeks via de site uw rang tijdelijk verlagen<br />( u blijft zichtbaar onder uw eigen rang maar met de opties en mogelijkheden die bij de lagere rang horen )</b></font>
<br><br />
<form method=get action='setclass.php'>
    <input type=hidden name='action' value='editclass'>
    <input type=hidden name='returnto' value="userdetails.php?id=<?php print($CURUSER['id']);?>">
    <table width=150 border=2 cellspacing=5 cellpadding=5>
        <tr><td>Rang</td><td align=left><select name=class>
        <?php  $maxclass = get_user_class() - 1;
          for ($i = 0; $i <= $maxclass; ++$i)
            if (trim(get_user_class_name($i)) != "") print("<option value=$i" .  ">" . get_user_class_name($i) . "\n");
        ?>
        </select></td></tr>
        </td></tr>
        <tr><td colspan=3 align=center><input type=submit class=btn value='Okay'></td></tr>
    </table>
</form>
<br>
<font size=4><b>Door weer bovenaan ( naast afmelden ) op uw lagere rang te klikken wordt uw rang automatisch weer terug gezet</b></font>
<?php

?>
