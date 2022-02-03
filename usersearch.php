<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
// 0 - No debug; 1 - Show and run SQL query; 2 - Show SQL query only
$DEBUG_MODE = 0;

dbconn();
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	new_error_message("Foutmelding", "Toegang geweigerd.");

site_header("Administratief gebruikers zoeken");
tabel_start();
print("<table width=98% class=bottom border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><center>");
tabel_top("Administratief gebruikers zoeken");
print("<table width=100% border=0 cellspacing=0 cellpadding=0>");
print("<tr>");
print("<td class=embedded align=center><center><br>");

$massa = @$_GET["massa"];

if ($massa == "massa") print "<h1>Alle berichten zijn verzonden...</h1>";

if (@$_GET['h'])
{
	echo "<table class=bottom width=90% border=0 align=center><tr><td class=embedded><div align=left><font size=3><center></br>
	Niet ingevulde velden worden genegeerd. Jokers * en ? mogen gebruikt worden in Naam, E-mailadres and Commentaar, evenals meerdere waardes</br
	gescheiden door spatie's (v.b. 'wyz Max*' In naam zal 2 gebruikers weergeven. 'wyz' en alle andere namen die beginnen met 'Max'. </br>	Net zoals '~' gebruikt kan worden voor het uitsluiten waarde, v.b. '~alfiest' bij commentaar , Alle gebruikers die niet de text 'alfiest' hebben staan bij commentaar </br>
	zullen worden uitgesloten in de zoek actie).</br></br>
    De ratio velden accepteren 'Inf' en '---' naast de gebruikelijke numerieke waardes.</br>
	Het subnet masker mag worden ingegeven als decimalen(ip nr vorm) of CIDR notitie (v.b. 255.255.255.0 is hetzelfde als /24).</br>
    De waardes geüpload en gedownload moeten in Gb's worden ingevoerd.</br></br>
	Bij zoek optie's met meerdere text velden zal de tweede worden genegeerd</br>
	tenzij deze relevant is voor de gekozen zoek optie. </br></br>
	'Alleen actief ' Geeft alleen gebruikers weer die aan het up en/of downloaden zijn,</br>
	'Inactief IP nr' voor de gene van wie het IP nr word weergegeven in uitgeschakelde accounts.</br>
	De 'p' kolommen in de resultaten geven gedeeltelijke statisieken weer, dat zijn, de aktieve torrents.</br>
	De geschiedenis kolom geeft het aantal torrent commentaren weer, net als een link naar de geschiedenis pagina.</br></br>
	</center></div></td></tr></table></br></br>";
}
else
{
	echo "<p align=center>(<a href='".$_SERVER["PHP_SELF"]."?h=1'> Handleiding </a>)";
	echo "&nbsp;-&nbsp;(<a href='".$_SERVER["PHP_SELF"]."'> Herstel </a>)</p>\n";
}

$highlight = " bgcolor=#BBAF9B";

@$body = <<<EOD
U heeft een account aangevraagd op $SITE_NAME en u heeft daarvoor
het volgende E-mailadres gebruikt: ({@$email}) 

Als u dit niet heeft gedaan kunt u deze e-mail als niet verzonden beschouwen.
De persoon die uw emailadres heeft gebruikt had het IP adres {$_SERVER["REMOTE_ADDR"]}.

Beantwoordt deze email AUB niet.

Om uw inschrijving te bevestigen, moet u de volgende link volgen:

$DEFAULTBASEURL/confirm.php?id=$id&secret={@$psecret}

Als u dit gedaan heeft, is uw account gebruiksklaar, als u dit niet doet
wordt uw account binnen enkele dagen verwijderd. We moedigen u ook aan om de
REGELS en FAQ te lezen voordat u gebruikt maakt van uw account op $SITE_NAME

EOD;


?>

<form method=get action=<?php echo $_SERVER["PHP_SELF"]?>>
<table border="1" cellspacing="0" cellpadding="5">
<tr>

  <td bgcolor=white valign="middle" class=rowhead>Naam:</td>
  <td bgcolor=white<?php echo @$_GET['n']?$highlight:""?>><input name="n" type="text" value="<?php echo @$_GET['n']?>" size=35></td>

  <td bgcolor=white valign="middle" class=rowhead>Deelverhouding:</td>
  <td bgcolor=white<?php echo @$_GET['r']?$highlight:""?>><select name="rt">
    <?
	$options = array("gelijk aan","meer dan","minder dan","tussen");
	for ($i = 0; $i < count($options); $i++){
	    echo "<option value=$i ".(($_GET['rt']=="$i")?"selected":"").">".$options[$i]."</option>\n";
	}
	?>
    </select>
    <input name="r" type="text" value="<?php echo @$_GET['r']?>" size="5" maxlength="4">
    <input name="r2" type="text" value="<?php echo @$_GET['r2']?>" size="5" maxlength="4"></td>

  <td bgcolor=white valign="middle" class=rowhead>Gebruiker status:</td>
  <td bgcolor=white<?php echo @$_GET['st']?$highlight:""?>><select name="st">
    <?
	$options = array("(alle)","geregistreerd","ongeregistreerd");
	for ($i = 0; $i < count($options); $i++){
	    echo "<option value=$i ".((@$_GET['st']=="$i")?"selected":"").">".$options[$i]."</option>\n";
	}
    ?>
    </select></td></tr>
<tr><td bgcolor=white valign="middle" class=rowhead>E-mailadres:</td>
  <td bgcolor=white<?php echo @$_GET['em']?$highlight:""?>><input name="em" type="text" value="<?php echo @$_GET['em']?>" size="35"></td>
  <td bgcolor=white valign="middle" class=rowhead>IP:</td>
  <td bgcolor=white<?php echo @$_GET['ip']?$highlight:""?>><input name="ip" type="text" value="<?php echo @$_GET['ip']?>" maxlength="17"></td>

  <td bgcolor=white valign="middle" class=rowhead> </td>
  <td bgcolor=white> </td></tr>
<tr>
  <td bgcolor=white valign="middle" class=rowhead>Commentaar:</td>
  <td bgcolor=white<?php echo @$_GET['co']?$highlight:""?>><input name="co" type="text" value="<?php echo @$_GET['co']?>" size="35"></td>
  <td bgcolor=white valign="middle" class=rowhead>Mask:</td>
  <td bgcolor=white<?php echo @$_GET['ma']?$highlight:""?>><input name="ma" type="text" value="<?php echo @$_GET['ma']?>" maxlength="17"></td>
  <td bgcolor=white valign="middle" class=rowhead>Class:</td>
  <td bgcolor=white<?php echo (@$_GET['c'] && @$_GET['c'] != 1)?$highlight:""?>><select name="c"><option value='1'>(alle)</option>
  <?
  $class = @$_GET['c'];
  if (!is_valid_id($class))
  	$class = '';
  for ($i = 2;;++$i) {
		if ($c = get_user_class_name($i-2))
       	 print("<option value=" . $i . ($class && $class == $i? " selected" : "") . ">$c</option>\n");
	  else
	   	break;
	}
	?>
    </select></td></tr>
<tr>

    <td bgcolor=white valign="middle" class=rowhead>Aangemeld:</td>

  <td bgcolor=white<?php echo @$_GET['d']?$highlight:""?>><select name="dt">
    <?
	$options = array("op","voor","na","tussen");
	for ($i = 0; $i < count($options); $i++){
	  echo "<option value=$i ".(($_GET['dt']=="$i")?"selected":"").">".$options[$i]."</option>\n";
	}
    ?>
    </select>

    <input name="d" type="text" value="<?php echo @$_GET['d']?>" size="12" maxlength="10">

    <input name="d2" type="text" value="<?php echo @$_GET['d2']?>" size="12" maxlength="10"></td>


  <td bgcolor=white valign="middle" class=rowhead>Geüpload:</td>

  <td bgcolor=white<?php echo @$_GET['ul']?$highlight:""?>><select name="ult" id="ult">
    <?
    $options = array("gelijk aan","meer dan","minder dan","tussen");
    for ($i = 0; $i < count($options); $i++){
  	  echo "<option value=$i ".(($_GET['ult']=="$i")?"selected":"").">".$options[$i]."</option>\n";
    }
    ?>
    </select>

    <input name="ul" type="text" id="ul" size="8" maxlength="7" value="<?php echo @$_GET['ul']?>">

    <input name="ul2" type="text" id="ul2" size="8" maxlength="7" value="<?php echo @$_GET['ul2']?>"></td>
  <td bgcolor=white valign="middle" class="rowhead">Gedoneerd:</td>

  <td bgcolor=white<?php echo @$_GET['do']?$highlight:""?>><select name="do">
    <?
    $options = array("(alle)","Ja","Nee");
	for ($i = 0; $i < count($options); $i++){
	  echo "<option value=$i ".(($_GET['do']=="$i")?"selected":"").">".$options[$i]."</option>\n";
    }
    ?>
	</select></td></tr>
<tr>

<td bgcolor=white valign="middle" class=rowhead>Laatst gezien:</td>

  <td bgcolor=white <?php echo @$_GET['ls']?$highlight:""?>><select name="lst">
  <?
  $options = array("op","voor","na","tussen");
  for ($i = 0; $i < count($options); $i++){
    echo "<option value=$i ".(($_GET['lst']=="$i")?"selected":"").">".$options[$i]."</option>\n";
  }
  ?>
  </select>

  <input name="ls" type="text" value="<?php echo @$_GET['ls']?>" size="12" maxlength="10">

  <input name="ls2" type="text" value="<?php echo @$_GET['ls2']?>" size="12" maxlength="10"></td>
	  <td bgcolor=white valign="middle" class=rowhead>Gedownload:</td>

  <td bgcolor=white<?php echo @$_GET['dl']?$highlight:""?>><select name="dlt" id="dlt">
  <?
	$options = array("gelijk aan","meer dan","minder dan","tussen");
	for ($i = 0; $i < count($options); $i++){
	  echo "<option value=$i ".(($_GET['dlt']=="$i")?"selected":"").">".$options[$i]."</option>\n";
	}
	?>
    </select>

    <input name="dl" type="text" id="dl" size="8" maxlength="7" value="<?php echo @$_GET['dl']?>">

    <input name="dl2" type="text" id="dl2" size="8" maxlength="7" value="<?php echo @$_GET['dl2']?>"></td>

	<td bgcolor=white valign="middle" class=rowhead>Gewaarschuwd:</td>

	<td bgcolor=white<?php echo @$_GET['w']?$highlight:""?>><select name="w">
  <?
  $options = array("(alle)","Ja","Nee");
	for ($i = 0; $i < count($options); $i++){
		echo "<option value=$i ".(($_GET['w']=="$i")?"selected":"").">".$options[$i]."</option>\n";
  }
  ?>
	</select></td></tr>

<tr><td bgcolor=white class="rowhead"></td><td bgcolor=white></td>
  <td bgcolor=white valign="middle" class=rowhead>Alleen Actief:</td>
	<td bgcolor=white<?php echo @$_GET['ac']?$highlight:""?>><input name="ac" type="checkbox" value="1" <?php echo (@$_GET['ac'])?"checked":"" ?>></td>
  <td bgcolor=white valign="middle" class=rowhead>Uitgeschakeld IP nr: </td>
  <td bgcolor=white<?php echo @$_GET['dip']?$highlight:""?>><input name="dip" type="checkbox" value="1" <?php echo (@$_GET['dip'])?"checked":"" ?>></td>
  </tr>
<tr><td bgcolor=white colspan="6" align=center><input name="submit" type=submit value="Zoeken" style="height:25px" class=btn></td></tr>
</table>
<br><br>
</form>

<?

// Validates date in the form [yy]yy-mm-dd;
// Returns date if valid, 0 otherwise.
function mkdate($date){
  if (strpos($date,'-'))
  	$a = explode('-', $date);
  elseif (strpos($date,'/'))
  	$a = explode('/', $date);
  else
  	return 0;
  for ($i=0;$i<3;$i++)
  	if (!is_numeric($a[$i]))
    	return 0;
    if (checkdate($a[1], $a[2], $a[0]))
    	return  date ("Y-m-d", mktime (0,0,0,$a[1],$a[2],$a[0]));
    else
			return 0;
}

// ratio as a string
function ratios($up,$down, $color = True)
{
	if ($down > 0)
	{
		$r = number_format($up / $down, 2);
    if ($color)
			$r = "<font color=".get_ratio_color($r).">$r</font>";
	}
	else
		if ($up > 0)
	  	$r = "Inf.";
	  else
	  	$r = "---";
	return $r;
}

// checks for the usual wildcards *, ? plus mySQL ones
function haswildcard($text){
	if (strpos($text,'*') === False && strpos($text,'?') === False
			&& strpos($text,'%') === False && strpos($text,'_') === False)
  	return False;
  else
  	return True;
}

///////////////////////////////////////////////////////////////////////////////

if (count(@$_GET) > 0 && !@$_GET['h'])
{
	// name
  $names = explode(' ',trim(@$_GET['n']));
  if ($names[0] !== "")
  {
		foreach($names as $name)
		{
	  	if (substr($name,0,1) == '~')
	  	{
      	if ($name == '~') continue;
   	    $names_exc[] = substr($name,1);
      }
	    else
	    	$names_inc[] = $name;
	  }

    if (is_array($names_inc))
    {
	  	$where_is .= isset($where_is)?" AND (":"(";
	    foreach($names_inc as $name)
	    {
      	if (!haswildcard($name))
	        $name_is .= (isset($name_is)?" OR ":"")."u.username = ".sqlesc($name);
	      else
	      {
	        $name = str_replace(array('?','*'), array('_','%'), $name);
	        $name_is .= (isset($name_is)?" OR ":"")."u.username LIKE ".sqlesc($name);
	      }
	    }
      $where_is .= $name_is.")";
      unset($name_is);
	  }

    if (is_array($names_exc))
    {
	  	$where_is .= isset($where_is)?" AND NOT (":" NOT (";
	    foreach($names_exc as $name)
	    {
	    	if (!haswildcard($name))
	      	$name_is .= (isset($name_is)?" OR ":"")."u.username = ".sqlesc($name);
	      else
	      {
	      	$name = str_replace(array('?','*'), array('_','%'), $name);
	        $name_is .= (isset($name_is)?" OR ":"")."u.username LIKE ".sqlesc($name);
	      }
	    }
      $where_is .= $name_is.")";
	  }
	  $q .= ($q ? "&amp;" : "") . "n=".urlencode(trim($_GET['n']));
  }

  // email
  $emaila = explode(' ', trim($_GET['em']));
  if ($emaila[0] !== "")
  {
  	$where_is .= isset($where_is)?" AND (":"(";
    foreach($emaila as $email)
    {
	  	if (strpos($email,'*') === False && strpos($email,'?') === False
	    		&& strpos($email,'%') === False)
	    {
      	if (validemail($email) !== 1)
      	{
	        sitemsg("Error", "Bad email.");
	        new_footer(false);
	      	die();
	      }
	      $email_is .= (isset($email_is)?" OR ":"")."u.email =".sqlesc($email);
      }
      else
      {
	    	$sql_email = str_replace(array('?','*'), array('_','%'), $email);
	      $email_is .= (isset($email_is)?" OR ":"")."u.email LIKE ".sqlesc($sql_email);
	    }
    }
		$where_is .= $email_is.")";
    $q .= ($q ? "&amp;" : "") . "em=".urlencode(trim($_GET['em']));
  }

  //class
  // NB: the c parameter is passed as two units above the real one
  $class = @$_GET['c'] - 2;
	if (is_valid_id($class + 1))
	{
  	$where_is .= (isset($where_is)?" AND ":"")."u.class=$class";
    $q .= ($q ? "&amp;" : "") . "c=".($class+2);
  }

  // IP
  $ip = trim($_GET['ip']);
  if ($ip)
  {
  	$regex = "/^(((1?\d{1,2})|(2[0-4]\d)|(25[0-5]))(\.\b|$)){4}$/";
    if (!preg_match($regex, $ip))
    {
    	sitemsg("Error", "Bad IP.");
    	new_footer(false);
    	die();
    }

    $mask = trim($_GET['ma']);
    if ($mask == "" || $mask == "255.255.255.255")
    	$where_is .= (isset($where_is)?" AND ":"")."u.ip = '$ip'";
    else
    {
    	if (substr($mask,0,1) == "/")
    	{
      	$n = substr($mask, 1, strlen($mask) - 1);
        if (!is_numeric($n) or $n < 0 or $n > 32)
        {
        	sitemsg("Error", "Bad subnet mask.");
        	new_footer(false);
          die();
        }
        else
	      	$mask = long2ip(pow(2,32) - pow(2,32-$n));
      }
      elseif (!preg_match($regex, $mask))
      {
				sitemsg("Error", "Bad subnet mask.");
				new_footer(false);
	      die();
      }
      $where_is .= (isset($where_is)?" AND ":"")."INET_ATON(u.ip) & INET_ATON('$mask') = INET_ATON('$ip') & INET_ATON('$mask')";
      $q .= ($q ? "&amp;" : "") . "ma=$mask";
    }
    $q .= ($q ? "&amp;" : "") . "ip=$ip";
  }

  // ratio
  $ratio = trim($_GET['r']);
  if ($ratio)
  {
  	if ($ratio == '---')
  	{
    	$ratio2 = "";
      $where_is .= isset($where_is)?" AND ":"";
      $where_is .= " u.uploaded = 0 and u.downloaded = 0";
    }
    elseif (strtolower(substr($ratio,0,3)) == 'inf')
    {
    	$ratio2 = "";
      $where_is .= isset($where_is)?" AND ":"";
      $where_is .= " u.uploaded > 0 and u.downloaded = 0";
    }
    else
    {
    	if (!is_numeric($ratio) || $ratio < 0)
    	{
      	sitemsg("Error", "Bad ratio.");
      	new_footer(false);
        die();
      }
      $where_is .= isset($where_is)?" AND ":"";
      $where_is .= " (u.uploaded/u.downloaded)";
      $ratiotype = @$_GET['rt'];
      $q .= ($q ? "&amp;" : "") . "rt=$ratiotype";
      if ($ratiotype == "3")
      {
      	$ratio2 = trim($_GET['r2']);
        if(!$ratio2)
        {
        	sitemsg("Error", "Two ratios needed for this type of search.");
        	new_footer(false);
          die();
        }
        if (!is_numeric($ratio2) or $ratio2 < $ratio)
        {
        	sitemsg("Error", "Bad second ratio.");
        	new_footer(false);
        	die();
        }
        $where_is .= " BETWEEN $ratio and $ratio2";
        $q .= ($q ? "&amp;" : "") . "r2=$ratio2";
      }
      elseif ($ratiotype == "2")
      	$where_is .= " < $ratio";
      elseif ($ratiotype == "1")
      	$where_is .= " > $ratio";
      else
      	$where_is .= " BETWEEN ($ratio - 0.004) and ($ratio + 0.004)";
    }
    $q .= ($q ? "&amp;" : "") . "r=$ratio";
  }

  // comment
  $comments = explode(' ',trim($_GET['co']));
  if ($comments[0] !== "")
  {
		foreach($comments as $comment)
		{
	    if (substr($comment,0,1) == '~')
	    {
      	if ($comment == '~') continue;
   	    $comments_exc[] = substr($comment,1);
      }
      else
	    	$comments_inc[] = $comment;
	  }

    if (is_array($comments_inc))
    {
	  	$where_is .= isset($where_is)?" AND (":"(";
	    foreach($comments_inc as $comment)
	    {
	    	if (!haswildcard($comment))
		    	$comment_is .= (isset($comment_is)?" OR ":"")."u.modcomment LIKE ".sqlesc("%".$comment."%");
        else
        {
	      	$comment = str_replace(array('?','*'), array('_','%'), $comment);
	        $comment_is .= (isset($comment_is)?" OR ":"")."u.modcomment LIKE ".sqlesc($comment);
        }
      }
      $where_is .= $comment_is.")";
      unset($comment_is);
    }

    if (is_array($comments_exc))
    {
	  	$where_is .= isset($where_is)?" AND NOT (":" NOT (";
	    foreach($comments_exc as $comment)
	    {
	    	if (!haswildcard($comment))
		    	$comment_is .= (isset($comment_is)?" OR ":"")."u.modcomment LIKE ".sqlesc("%".$comment."%");
        else
        {
	      	$comment = str_replace(array('?','*'), array('_','%'), $comment);
	        $comment_is .= (isset($comment_is)?" OR ":"")."u.modcomment LIKE ".sqlesc($comment);
	      }
      }
      $where_is .= $comment_is.")";
	  }
    $q .= ($q ? "&amp;" : "") . "co=".urlencode(trim($_GET['co']));
  }

  $unit = 1073741824;		// 1GB

  // uploaded
  $ul = trim($_GET['ul']);
  if ($ul)
  {
  	if (!is_numeric($ul) || $ul < 0)
  	{
    	sitemsg("Error", "Bad uploaded amount.");
    	new_footer(false);
      die();
    }
    $where_is .= isset($where_is)?" AND ":"";
    $where_is .= " u.uploaded ";
    $ultype = @$_GET['ult'];
    $q .= ($q ? "&amp;" : "") . "ult=$ultype";
    if ($ultype == "3")
    {
	    $ul2 = trim($_GET['ul2']);
    	if(!$ul2)
    	{
      	sitemsg("Error", "Two uploaded amounts needed for this type of search.");
      	new_footer(false);
        die();
      }
      if (!is_numeric($ul2) or $ul2 < $ul)
      {
      	sitemsg("Error", "Bad second uploaded amount.");
      	new_footer(false);
        die();
      }
      $where_is .= " BETWEEN ".$ul*$unit." and ".$ul2*$unit;
      $q .= ($q ? "&amp;" : "") . "ul2=$ul2";
    }
    elseif ($ultype == "2")
    	$where_is .= " < ".$ul*$unit;
    elseif ($ultype == "1")
    	$where_is .= " >". $ul*$unit;
    else
    	$where_is .= " BETWEEN ".($ul - 0.004)*$unit." and ".($ul + 0.004)*$unit;
    $q .= ($q ? "&amp;" : "") . "ul=$ul";
  }

  // downloaded
  $dl = trim($_GET['dl']);
  if ($dl)
  {
  	if (!is_numeric($dl) || $dl < 0)
  	{
    	sitemsg("Error", "Bad downloaded amount.");
    	new_footer(false);
      die();
    }
    $where_is .= isset($where_is)?" AND ":"";
    $where_is .= " u.downloaded ";
    $dltype = @$_GET['dlt'];
    $q .= ($q ? "&amp;" : "") . "dlt=$dltype";
    if ($dltype == "3")
    {
    	$dl2 = trim($_GET['dl2']);
      if(!$dl2)
      {
      	sitemsg("Error", "Two downloaded amounts needed for this type of search.");
      	new_footer(false);
        die();
      }
      if (!is_numeric($dl2) or $dl2 < $dl)
      {
      	sitemsg("Error", "Bad second downloaded amount.");
      	new_footer(false);
        die();
      }
      $where_is .= " BETWEEN ".$dl*$unit." and ".$dl2*$unit;
      $q .= ($q ? "&amp;" : "") . "dl2=$dl2";
    }
    elseif ($dltype == "2")
    	$where_is .= " < ".$dl*$unit;
    elseif ($dltype == "1")
     	$where_is .= " > ".$dl*$unit;
    else
     	$where_is .= " BETWEEN ".($dl - 0.004)*$unit." and ".($dl + 0.004)*$unit;
    $q .= ($q ? "&amp;" : "") . "dl=$dl";
  }

  // date joined
  $date = trim($_GET['d']);
  if ($date)
  {
  	if (!$date = mkdate($date))
  	{
    	sitemsg("Error", "Invalid date.");
    	new_footer(false);
      die();
    }
    $q .= ($q ? "&amp;" : "") . "d=$date";
    $datetype = @$_GET['dt'];
		$q .= ($q ? "&amp;" : "") . "dt=$datetype";
    if ($datetype == "0")
    // For mySQL 4.1.1 or above use instead
    // $where_is .= (isset($where_is)?" AND ":"")."DATE(added) = DATE('$date')";
    $where_is .= (isset($where_is)?" AND ":"").
    		"(UNIX_TIMESTAMP(added) - UNIX_TIMESTAMP('$date')) BETWEEN 0 and 86400";
    else
    {
      $where_is .= (isset($where_is)?" AND ":"")."u.added ";
      if ($datetype == "3")
      {
        $date2 = mkdate(trim($_GET['d2']));
        if ($date2)
        {
          if (!$date = mkdate($date))
          {
            sitemsg("Error", "Invalid date.");
            new_footer(false);
            die();
          }
          $q .= ($q ? "&amp;" : "") . "d2=$date2";
          $where_is .= " BETWEEN '$date' and '$date2'";
        }
        else
        {
          sitemsg("Error", "Two dates needed for this type of search.");
          new_footer(false);
          die();
        }
      }
      elseif ($datetype == "1")
        $where_is .= "< '$date'";
      elseif ($datetype == "2")
        $where_is .= "> '$date'";
    }
  }

	// date last seen
  $last = trim($_GET['ls']);
  if ($last)
  {
  	if (!$last = mkdate($last))
  	{
    	sitemsg("Error", "Invalid date.");
    	new_footer(false);
      die();
    }
    $q .= ($q ? "&amp;" : "") . "ls=$last";
    $lasttype = @$_GET['lst'];
    $q .= ($q ? "&amp;" : "") . "lst=$lasttype";
    if ($lasttype == "0")
    // For mySQL 4.1.1 or above use instead
    // $where_is .= (isset($where_is)?" AND ":"")."DATE(added) = DATE('$date')";
    	$where_is .= (isset($where_is)?" AND ":"").
      		"(UNIX_TIMESTAMP(last_access) - UNIX_TIMESTAMP('$last')) BETWEEN 0 and 86400";
    else
    {
    	$where_is .= (isset($where_is)?" AND ":"")."u.last_access ";
      if ($lasttype == "3")
      {
      	$last2 = mkdate(trim($_GET['ls2']));
        if ($last2)
        {
        	$where_is .= " BETWEEN '$last' and '$last2'";
	        $q .= ($q ? "&amp;" : "") . "ls2=$last2";
        }
        else
        {
        	sitemsg("Error", "The second date is not valid.");
        	new_footer(false);
        	die();
        }
      }
      elseif ($lasttype == "1")
    		$where_is .= "< '$last'";
      elseif ($lasttype == "2")
      	$where_is .= "> '$last'";
    }
  }

  // status
  $status = @$_GET['st'];
  if ($status)
  {
  	$where_is .= ((isset($where_is))?" AND ":"");
    if ($status == "1")
    	$where_is .= "u.status = 'confirmed'";
    else
    	$where_is .= "u.status = 'pending'";
    $q .= ($q ? "&amp;" : "") . "st=$status";
  }

  // account status
  $accountstatus = @$_GET['as'];
  if ($accountstatus)
  {
  	$where_is .= (isset($where_is))?" AND ":"";
    if ($accountstatus == "1")
    	$where_is .= " u.enabled = 'yes'";
    else
    	$where_is .= " u.enabled = 'no'";
    $q .= ($q ? "&amp;" : "") . "as=$accountstatus";
  }

  //donor
	$donor = @$_GET['do'];
  if ($donor)
  {
		$where_is .= (isset($where_is))?" AND ":"";
    if ($donor == 1)
    	$where_is .= " u.donor = 'yes'";
    else
    	$where_is .= " u.donor = 'no'";
    $q .= ($q ? "&amp;" : "") . "do=$donor";
  }

  //warned
	$warned = @$_GET['w'];
  if ($warned)
  {
		$where_is .= (isset($where_is))?" AND ":"";
    if ($warned == 1)
    	$where_is .= " u.warned = 'yes'";
    else
    	$where_is .= " u.warned = 'no'";
    $q .= ($q ? "&amp;" : "") . "w=$warned";
  }

  // disabled IP
  $disabled = @$_GET['dip'];
  if ($disabled)
  {
  	$distinct = "DISTINCT ";
    $join_is .= " LEFT JOIN users AS u2 ON u.ip = u2.ip";
		$where_is .= ((isset($where_is))?" AND ":"")."u2.enabled = 'no'";
    $q .= ($q ? "&amp;" : "") . "dip=$disabled";
  }

  // active
  $active = @$_GET['ac'];
  if ($active == "1")
  {
  	$distinct = "DISTINCT ";
    $join_is .= " LEFT JOIN peers AS p ON u.id = p.userid";
    $q .= ($q ? "&amp;" : "") . "ac=$active";
  }


  $from_is = "users AS u".@$join_is;
  $distinct = isset($distinct)?$distinct:"";

  $queryc = "SELECT COUNT(".$distinct."u.id) FROM ".$from_is.
  		((@$where_is == "")?"":" WHERE ".@$where_is);

  $querypm = "FROM ".$from_is.((@$where_is == "")?" ":" WHERE". @$where_is);

  $select_is = "u.id, u.username, u.email, u.status, u.added, u.last_access, u.ip,
  	u.class, u.uploaded, u.downloaded, u.donor, u.modcomment, u.enabled, u.warned";

  $query = "SELECT ".$distinct." ".$select_is." ".$querypm;

//    <temporary>    /////////////////////////////////////////////////////
  if ($DEBUG_MODE > 0)
  {
  	sitemsg("Count Query",$queryc);
    echo "<BR><BR>";
    sitemsg("Search Query",$query);
    echo "<BR><BR>";
    sitemsg("URL ",$q);
    if ($DEBUG_MODE == 2)
    	die();
    echo "<BR><BR>";
  }
//    </temporary>   /////////////////////////////////////////////////////

  $res = mysqli_query($con_link, $queryc) or sqlerr();
  $arr = mysqli_fetch_row($res);
  $count = $arr[0];

  $q = isset($q)?($q."&amp;"):"";

  $perpage = 250;

  list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $_SERVER["PHP_SELF"]."?".$q);

  $query .= $limit;

  $res = mysqli_query($con_link, $query) or sqlerr();

  if (mysqli_num_rows($res) == 0)
  	sitemsg("Sorry","Geen gebruiker gevonden.");
  else
  {
  	if ($count > $perpage)
  		echo $pagertop;
    echo "<table border=1 cellspacing=0 cellpadding=5>\n";
    echo "<tr><td class=colheadsite align=left>Naam</td>
    		<td class=colheadsite align=left>Ratio</td>
        <td class=colheadsite>Up</td>
        <td class=colheadsite>Down</td>
        <td class=colheadsite align=left>Ip-nummer</td>
        <td class=colheadsite align=left>E-mailadres</td>".
        "<td class=colheadsite align=left>Aangemeld:</td>".
        "<td class=colheadsite align=left>Laatst gezien:</td>".
        "<td class=colheadsite align=left>Status</td>".
        "</tr>";
    while ($user = mysqli_fetch_array($res))
    {
    	if ($user['added'] == '0000-00-00 00:00:00')
      	$user['added'] = '---';
      if ($user['last_access'] == '0000-00-00 00:00:00')
      	$user['last_access'] = '---';

		if ($user['ip'] && get_user_class() > UC_MODERATOR)
			{
			$nip = ip2long($user['ip']);
			$auxres = mysqli_query($con_link, "SELECT COUNT(*) FROM bans WHERE $nip >= first AND $nip <= last") or sqlerr(__FILE__, __LINE__);
			$array = mysqli_fetch_row($auxres);
			if ($array[0] == 0)
				$ipstr = $user['ip'];
			else
				$ipstr = "<a href='/testip.php?ip=".$user['ip']."'><font color='#FF0000'><b>".$user['ip']."</b></font></a>";
			}
		else
			$ipstr = "Onbekend";

      $auxres = mysqli_query($con_link, "SELECT SUM(uploaded) AS pul, SUM(downloaded) AS pdl FROM peers WHERE userid = ".$user['id']) or sqlerr(__FILE__, __LINE__);
      $array = mysqli_fetch_array($auxres);

      $pul = $array['pul'];
      $pdl = $array['pdl'];
      if ($pdl > 0)
      	$partial = ratios($pul,$pdl)." (".mksizemb($pul)."/".mksizemb($pdl).")";
      else
      	if ($pul > 0)
      		$partial = "Inf. ".mksizemb($pul)."/".mksizemb($pdl).")";
      	else
      		$partial = "---";


	if ($user['status'] == "pending") 
		if (get_user_class() > UC_MODERATOR)
			$status = "<a href='takeconfirm.php?id=" . $user['id'] . "'>Open</a>";
		else
			$status = "Open";
	else
		$status = "Aktief";

    	echo "<tr><td bgcolor=white><b><a class=altlink_blue href='userdetails.php?id=" . $user['id'] . "'>" .
      		$user['username']."</a></b>" .
      		($user["donor"] == "yes" ? "<img src=pic/star.gif alt=\"Donor\">" : "") .
					($user["warned"] == "yes" ? "<img src=\"/pic/warned.gif\" alt=\"Warned\">" : "") . "</td>
          <td bgcolor=white>" . ratios($user['uploaded'], $user['downloaded']) . "</td>
          <td bgcolor=white><div align=right>" . mksize($user['uploaded']) . "</div></td>
          <td bgcolor=white><div align=right>" . mksize($user['downloaded']) . "</div></td>
          <td bgcolor=white>" . $ipstr . "</td><td bgcolor=white><a class=altlink_blue href=mailto:" . $user['email'] . ">" . $user['email'] . "</a></td>
          <td bgcolor=white><div align=center>" . convertdatum($user['added'], "no") . "</div></td>
          <td bgcolor=white><div align=center>" . convertdatum($user['last_access'], "no") . "</div></td>
          <td bgcolor=white><div align=center>" . $status . "</div></td>".
          "</tr>\n";
    }
    echo "</table>";
    if ($count > $perpage)
    	echo "$pagerbottom";

if (get_user_class() >= UC_ADMINISTRATOR)
{

?>
<hr><br>
     <form method=post action=/sendmessage.php>
      <table class=bottom border="0" cellpadding="5" cellspacing="0">
        <tr>
          <td class=embedded>
            <div align="center">
              <input name="pmees" type="hidden" value="<?echo $querypm?>" size=10>
              <input name="PM" type="submit" style='height: 36px;width: 400px;color:darkblue;font-weight:bold' value="Massaal bericht sturen aan alle weergegeven gebruikers" class=btn>
              <input name="n_pms" type="hidden" value="<?echo $count?>" size=10>
            </div></td>
        </tr>
      </table>
    </form>
<?

}
  }
}

print(@$pagemenu.'<br>'.@$browsemenu);

print("</td></tr></table>");
print("<br></td></tr></table>");tabel_einde();
site_footer();
die;

?>