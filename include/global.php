<?php  
require_once("secrets.php");  
error_reporting(E_ALL);  
ini_set('display_errors', 1);  
define ('UC_USER', 0);  
define ('UC_POWER_USER', 1);  
define ('UC_VIP', 2);  
define ('UC_UPLOADER', 3);  
define ('UC_MODERATOR', 4);  
define ('UC_ADMINISTRATOR', 5);  
define ('UC_SYSOP', 6);  
define ('UC_OWNER', 7);  
define ('UC_GOD', 8);  
define ('UC_SCRIPTER', 255);  
  
function get_user_class_name($class)  
	{  
	switch ($class)  
		{  
		case UC_USER: return "User";  
		case UC_POWER_USER: return "Power user";  
		case UC_VIP: return "Super Power user";  
		case UC_UPLOADER: return "VIP";	  
		case UC_MODERATOR: return "Uploader";  
		case UC_ADMINISTRATOR: return "Moderator";  
		case UC_GOD: return "Oprichter";  
		case UC_SCRIPTER: return "Systeem";  
		}  
	return "";  
	}  
  
$smilies = array(  
  "..lol" => "_lol.gif",  
//  "..blow" => "__dude.gif",  
  "..kus" => "__kus.gif",  
//  "..psst" => "__psst.gif",  
  "..schiet" => "__schieten.gif",  
  "..foto" => "__foto.gif",  
  "..wow" => "__wow.gif",  
  "..denken" => "__denken.gif",  
  "..feest" => "__panda_feest.gif",  
  "..bal" => "panda_bal.gif",  
  "..kont" => "panda_kont.gif",  
  "..panda" => "panda_dans.gif",  
  ":-)" => "smile1.gif",  
  ":smile:" => "smile2.gif",  
  ":-D" => "grin.gif",  
  ":lol:" => "laugh.gif",  
  ":w00t:" => "w00t.gif",  
  ":-P" => "tongue.gif",  
  ";-)" => "wink.gif",  
  ":-|" => "noexpression.gif",  
  ":-/" => "confused.gif",  
  ":-(" => "sad.gif",  
  ":'-(" => "cry.gif",  
  ":weep:" => "weep.gif",  
  ":-O" => "ohmy.gif",  
  ":o)" => "clown.gif",  
  "8-)" => "cool1.gif",  
  "|-)" => "sleeping.gif",  
  ":innocent:" => "innocent.gif",  
  ":whistle:" => "whistle.gif",  
  ":unsure:" => "unsure.gif",  
  ":closedeyes:" => "closedeyes.gif",  
  ":cool:" => "cool2.gif",  
  ":fun:" => "fun.gif",  
  ":thumbsup:" => "thumbsup.gif",  
  ":thumbsdown:" => "thumbsdown.gif",  
  ":blush:" => "blush.gif",  
  ":unsure:" => "unsure.gif",  
  ":yes:" => "yes.gif",  
  ":no:" => "no.gif",  
  ":love:" => "love.gif",  
  ":?:" => "question.gif",  
  ":!:" => "excl.gif",  
  ":idea:" => "idea.gif",  
  ":arrow:" => "arrow.gif",  
  ":arrow2:" => "arrow2.gif",  
  ":hmm:" => "hmm.gif",  
  ":hmmm:" => "hmmm.gif",  
  ":huh:" => "huh.gif",  
  ":geek:" => "geek.gif",  
  ":look:" => "look.gif",  
  ":rolleyes:" => "rolleyes.gif",  
  ":kiss:" => "kiss.gif",  
  ":shifty:" => "shifty.gif",  
  ":blink:" => "blink.gif",  
  ":smartass:" => "smartass.gif",  
  ":sick:" => "sick.gif",  
  ":crazy:" => "crazy.gif",  
  ":wacko:" => "wacko.gif",  
  ":alien:" => "alien.gif",  
  ":wizard:" => "wizard.gif",  
  ":wave:" => "wave.gif",  
  ":wavecry:" => "wavecry.gif",  
  ":baby:" => "baby.gif",  
  ":angry:" => "angry.gif",  
  ":ras:" => "ras.gif",  
  ":sly:" => "sly.gif",  
  ":devil:" => "devil.gif",  
  ":evil:" => "evil.gif",  
  ":evilmad:" => "evilmad.gif",  
  ":sneaky:" => "sneaky.gif",  
  ":axe:" => "axe.gif",  
  ":slap:" => "slap.gif",  
  ":wall:" => "wall.gif",  
  ":rant:" => "rant.gif",  
  ":jump:" => "jump.gif",  
  ":yucky:" => "yucky.gif",  
  ":nugget:" => "nugget.gif",  
  ":smart:" => "smart.gif",  
  ":shutup:" => "shutup.gif",  
  ":shutup2:" => "shutup2.gif",  
  ":crockett:" => "crockett.gif",  
  ":zorro:" => "zorro.gif",  
  ":snap:" => "snap.gif",  
  ":beer:" => "beer.gif",  
  ":beer2:" => "beer2.gif",  
  ":drunk:" => "drunk.gif",  
  ":strongbench:" => "strongbench.gif",  
  ":weakbench:" => "weakbench.gif",  
  ":dumbells:" => "dumbells.gif",  
  ":music:" => "music.gif",  
  ":stupid:" => "stupid.gif",  
  ":dots:" => "dots.gif",  
  ":offtopic:" => "offtopic.gif",  
  ":spam:" => "spam.gif",  
  ":oops:" => "oops.gif",  
  ":lttd:" => "lttd.gif",  
  ":please:" => "please.gif",  
  ":sorry:" => "sorry.gif",  
  ":hi:" => "hi.gif",  
  ":yay:" => "yay.gif",  
  ":cake:" => "cake.gif",  
  ":hbd:" => "hbd.gif",  
  ":band:" => "band.gif",  
  ":punk:" => "punk.gif",  
	":rofl:" => "rofl.gif",  
  ":bounce:" => "bounce.gif",  
  ":mbounce:" => "mbounce.gif",  
  ":thankyou:" => "thankyou.gif",  
  ":gathering:" => "gathering.gif",  
  ":hang:" => "hang.gif",  
  ":chop:" => "chop.gif",  
  ":rip:" => "rip.gif",  
  ":whip:" => "whip.gif",  
  ":judge:" => "judge.gif",  
  ":chair:" => "chair.gif",  
  ":tease:" => "tease.gif",  
  ":box:" => "box.gif",  
  ":boxing:" => "boxing.gif",  
  ":guns:" => "guns.gif",  
  ":shoot:" => "shoot.gif",  
  ":shoot2:" => "shoot2.gif",  
  ":flowers:" => "flowers.gif",  
  ":wub:" => "wub.gif",  
  ":lovers:" => "lovers.gif",  
  ":kissing:" => "kissing.gif",  
  ":kissing2:" => "kissing2.gif",  
  ":console:" => "console.gif",  
  ":group:" => "group.gif",  
  ":hump:" => "hump.gif",  
  ":hooray:" => "hooray.gif",  
  ":happy2:" => "happy2.gif",  
  ":clap:" => "clap.gif",  
  ":clap2:" => "clap2.gif",  
	":weirdo:" => "weirdo.gif",  
  ":yawn:" => "yawn.gif",  
  ":bow:" => "bow.gif",  
	":dawgie:" => "dawgie.gif",  
	":cylon:" => "cylon.gif",  
  ":book:" => "book.gif",  
  ":fish:" => "fish.gif",  
  ":mama:" => "mama.gif",  
  ":pepsi:" => "pepsi.gif",  
  ":medieval:" => "medieval.gif",  
  ":rambo:" => "rambo.gif",  
  ":ninja:" => "ninja.gif",  
  ":hannibal:" => "hannibal.gif",  
  ":party:" => "party.gif",  
  ":snorkle:" => "snorkle.gif",  
  ":evo:" => "evo.gif",  
  ":king:" => "king.gif",  
  ":chef:" => "chef.gif",  
  ":mario:" => "mario.gif",  
  ":pope:" => "pope.gif",  
  ":fez:" => "fez.gif",  
  ":cap:" => "cap.gif",  
  ":cowboy:" => "cowboy.gif",  
  ":pirate:" => "pirate.gif",  
  ":pirate2:" => "pirate2.gif",  
  ":rock:" => "rock.gif",  
  ":cigar:" => "cigar.gif",  
  ":icecream:" => "icecream.gif",  
  ":oldtimer:" => "oldtimer.gif",  
	":trampoline:" => "trampoline.gif",  
	":banana:" => "bananadance.gif",  
  ":smurf:" => "smurf.gif",  
  ":yikes:" => "yikes.gif",  
  ":osama:" => "osama.gif",  
  ":saddam:" => "saddam.gif",  
  ":santa:" => "santa.gif",  
  ":indian:" => "indian.gif",  
  ":pimp:" => "pimp.gif",  
  ":nuke:" => "nuke.gif",  
  ":jacko:" => "jacko.gif",  
  ":ike:" => "ike.gif",  
  ":greedy:" => "greedy.gif",  
	":super:" => "super.gif",  
  ":wolverine:" => "wolverine.gif",  
  ":spidey:" => "spidey.gif",  
  ":spider:" => "spider.gif",  
  ":bandana:" => "bandana.gif",  
  ":construction:" => "construction.gif",  
  ":sheep:" => "sheep.gif",  
  ":police:" => "police.gif",  
	":detective:" => "detective.gif",  
  ":bike:" => "bike.gif",  
	":fishing:" => "fishing.gif",  
  ":clover:" => "clover.gif",  
  ":horse:" => "horse.gif",  
  ":shit:" => "shit.gif",  
  ":soldiers:" => "soldiers.gif",  
);  
  
$privatesmilies = array(  
  ":)" => "smile1.gif",  
//  ";)" => "wink.gif",  
  ":wink:" => "wink.gif",  
  ":D" => "grin.gif",  
  ":P" => "tongue.gif",  
  ":(" => "sad.gif",  
  ":'(" => "cry.gif",  
  ":|" => "noexpression.gif",  
  // "8)" => "cool1.gif",   we don't want this as a smilie...  
  ":Boozer:" => "alcoholic.gif",  
  ":deadhorse:" => "deadhorse.gif",  
  ":spank:" => "spank.gif",  
  ":yoji:" => "yoji.gif",  
  ":locked:" => "locked.gif",  
  ":grrr:" => "angry.gif", 			// legacy  
  "O:-" => "innocent.gif",			// legacy  
  ":sleeping:" => "sleeping.gif",	// legacy  
  "-_-" => "unsure.gif",			// legacy  
  ":clown:" => "clown.gif",  
  ":mml:" => "mml.gif",  
  ":rtf:" => "rtf.gif",  
  ":morepics:" => "morepics.gif",  
  ":rb:" => "rb.gif",  
  ":rblocked:" => "rblocked.gif",  
  ":maxlocked:" => "maxlocked.gif",  
  ":hslocked:" => "hslocked.gif",  
);  
  
// Set this to the line break character sequence of your system  
$linebreak = "\r\n";  
  
function get_row_count($table, $suffix = "")  
	{  
	if ($suffix)  
		$suffix = " $suffix";  
  global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;  
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);   
//var_dump("SELECT COUNT(*) FROM ".$table." ".$suffix);  
	($r = mysqli_query($con_link, "SELECT COUNT(*) FROM ".$table." ".$suffix)) or die(@mysqli_error());  
	($a = mysqli_fetch_row($r)) or die(mysqli_error());  
	return $a[0];  
	}  
  
function stdmsg($heading, $text)  
{  
  print("<table class=bottom width=750 border=0 cellpadding=0 cellspacing=0><tr><td class=embedded>\n");  
  if ($heading)  
    print("<h2>$heading</h2>\n");  
  print("<table width=100% border=1 cellspacing=0 cellpadding=10><tr><td bgcolor=white class=text>\n");  
  print("<font size=2 color=red><b>" . $text . "</b></td></tr></table></td></tr></table>\n");  
}  
  
function sqlerr($file = '', $line = '')  
	{  
	global $CURUSER;  
  global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;  
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);   
	print("<table border=0 bgcolor=blue align=left cellspacing=0 cellpadding=10 style='background: blue'>" .  
	"<tr><td class=embedded><font color=white><h1>SQL Error</h1>\n" .  
	"<b>" . mysqli_error($con_link) . ($file != '' && $line != '' ? "<p>in $file, line $line</p>" : "") . "</b></font></td></tr></table>");  
		  
	$bericht = "Er is een fout opgetreden:\n\n" . mysqli_error($con_link) . "\n\nBestand: $file\nRegel: $line";  
	if ($CURUSER)  
		$bericht .= "\n\nGebruiker-id = " . $CURUSER['id'] . " - Gebruikersnaam = " . $CURUSER['username'];  
	$email_aan = "info@torrentmedia.org";  
	$onderwerp = "SQL_ERROR";  
	$email_van = "no-replyo@torrentmedia.org";  
	$success = mail($email_aan , $onderwerp, $bericht, "From: ".@$SV['SITE_NAME']." <".$email_van.">", "-f$$email_van");  
	  
	die;  
	}  
  
  
function get_date_time($timestamp = 0)  
{  
  date_default_timezone_set('Europe/Amsterdam');  
  if ($timestamp)  
    return date("Y-m-d H:i:s", $timestamp);  
  else  
//    return gmdate("Y-m-d H:i:s");  
    return date("Y-m-d H:i:s");  
}  
  
function encodehtml($s, $linebreaks = true)  
{  
  $s = str_replace("<", "&lt;", str_replace("&", "&amp;", $s));  
  if ($linebreaks)  
    $s = nl2br($s);  
  return $s;  
}  
  
function get_dt_num()  
{  
  return gmdate("YmdHis");  
}  
  
function format_urls($s)  
{  
	return preg_replace(  
    	"/(\A|[^=\]'\"a-zA-Z0-9])((http|ftp|https|ftps|irc):\/\/[^()<>\s]+)/i",  
	    "\\1<a href=\"\\2\">\\2</a>", $s);  
}  
  
function _strlastpos ($haystack, $needle, $offset = 0)  
{  
	$addLen = strlen ($needle);  
	$endPos = $offset - $addLen;  
	while (true)  
	{  
		if (($newPos = strpos ($haystack, $needle, $endPos + $addLen)) === false) break;  
		$endPos = $newPos;  
	}  
	return ($endPos >= 0) ? $endPos : false;  
}  
  
function format_quotes($s)  
{  
  while (@$old_s != $s)  
  {  
  	$old_s = $s;  
  
	  //find first occurrence of [/quote]  
	  $close = strpos($s, "[/quote]");  
	  if ($close === false)  
	  	return $s;  
  
	  //find last [quote] before first [/quote]  
	  //note that there is no check for correct syntax  
	  $open = _strlastpos(substr($s,0,$close), "[quote");  
	  if ($open === false)  
	    return $s;  
  
	  $quote = substr($s,$open,$close - $open + 8);  
  
	  //[quote]Text[/quote]  
	  $quote = preg_replace(  
	    "/\[quote\]\s*((\s|.)+?)\s*\[\/quote\]\s*/i",  
	    "<p class=sub><b>Citaat:</b></p><table class=main border=1 cellspacing=0 cellpadding=10><tr><td style='border: 1px black dotted'>\\1</td></tr></table><br>", $quote);  
  
	  //[quote=Author]Text[/quote]  
	  $quote = preg_replace(  
	    "/\[quote=(.+?)\]\s*((\s|.)+?)\s*\[\/quote\]\s*/i",  
	    "<p class=sub><b>\\1 wrote:</b></p><table class=main border=1 cellspacing=0 cellpadding=10><tr><td style='border: 1px black dotted'>\\2</td></tr></table><br>", $quote);  
  
	  $s = substr($s,0,$open) . $quote . substr($s,$close + 8);  
  }  
  
	return $s;  
}  
  
function format_tekst($text, $strip_html = true)  
	{  
	global $smilies, $privatesmilies, $CURUSER;  
	$s = $text;  
  
	$s = str_replace("  ", " &nbsp;", $s);  
  
	reset($smilies);  
	while (list($code, $url) = each($smilies))  
		{  
		if (substr($code,0,2) == "..")  
			$s = str_replace($code, "<img height=40 border=0 src=\"/pic/smilies/$url\" alt=\"" . htmlspecialchars($code) . "\">", $s);  
		elseif (substr($code,0,4) == "..ku")  
			$s = str_replace($code, "<img height=20 border=0 src=\"/pic/smilies/$url\" alt=\"" . htmlspecialchars($code) . "\">", $s);  
		else  
			$s = str_replace($code, "<img border=0 src=\"/pic/smilies/$url\" alt=\"" . htmlspecialchars($code) . "\">", $s);  
		}  
  
	reset($privatesmilies);  
	while (list($code, $url) = each($privatesmilies))  
		$s = str_replace($code, "<img border=0 src=\"/pic/smilies/$url\">", $s);  
  
	return $s;  
	}  
  
function format_comment($text, $strip_html = true)  
{  
	global $smilies, $privatesmilies;  
  
	$s = $text;  
  
  // This fixes the extraneous ;) smilies problem. When there was an html escaped  
  // char before a closing bracket - like >), "), ... - this would be encoded  
  // to &xxx;), hence all the extra smilies. I created a new :wink: label, removed  
  // the ;) one, and replace all genuine ;) by :wink: before escaping the body.  
  // (What took us so long? :blush:)- wyz  
  
	$s = str_replace(";)", ":wink:", $s);  
  
	if ($strip_html)  
		$s = htmlspecialchars($s);  
  
	// [*]  
	$s = preg_replace("/\[\*\]/", "<li>", $s);  
  
	$s = preg_replace("/\javascript/", "niet_toegestane_tekst", $s);  
  
	// [b]Bold[/b]  
	$s = preg_replace("/\[b\]((\s|.)+?)\[\/b\]/", "<b>\\1</b>", $s);  
  
	// [center]center[/center]  
	$s = preg_replace("/\[center\]((\s|.)+?)\[\/center\]/", "<center>\\1</center>", $s);  
  
	// [center]center[/center]  
	$s = preg_replace("/\[li\]((\s|.)+?)\[\/li\]/", "<li>\\1", $s);  
  
	// [i]Italic[/i]  
	$s = preg_replace("/\[i\]((\s|.)+?)\[\/i\]/", "<i>\\1</i>", $s);  
  
	// [u]Underline[/u]  
	$s = preg_replace("/\[u\]((\s|.)+?)\[\/u\]/", "<u>\\1</u>", $s);  
  
	// [u]Underline[/u]  
	$s = preg_replace("/\[u\]((\s|.)+?)\[\/u\]/i", "<u>\\1</u>", $s);  
  
	// [img]https://www/image.gif[/img]  
	$s = preg_replace("/\[img\](https:\/\/[^\s'\"<>]+(\.(jpg|gif|png)))\[\/img\]/i", "<IMG border=\"0\" src=\"\\1\">", $s);  
	  
	// [img=https://www/image.gif]  
 //   $s = preg_replace("/\[img=([^\s'\"<>]+(\.(gif|jpg|png)))\]/i", "<IMG border=\"0\" src=\"https://torrentmedia.org/\\1\">", $s);  
  
	// Nieuw op advies  
//	$s = preg_replace("/\[img]=(http://[^\s'\"<>]+(.gif|.jpg|.png))+[/img]/i", "<img border=0 src="\1">", $s);  
//	$s = preg_replace("/\[img=(http://[^\s'\"<>]+(.gif|.jpg|.png))]", "<img border=0 src="\1">", $s);  
	  
	// [color=blue]Text[/color]  
	$s = preg_replace(  
		"/\[color=([a-zA-Z]+)\]((\s|.)+?)\[\/color\]/i",  
		"<font color=\\1>\\2</font>", $s);  
  
	// [color=#ffcc99]Text[/color]  
	$s = preg_replace(  
		"/\[color=(#[a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9])\]((\s|.)+?)\[\/color\]/i",  
		"<font color=\\1>\\2</font>", $s);  
  
	// [url=http://www.example.com]Text[/url]  
	$s = preg_replace(  
		"/\[url=([^()<>\s]+?)\]((\s|.)+?)\[\/url\]/i",  
		"<a href=\"\\1\">\\2</a>", $s);  
  
	// [url]http://www.example.com[/url]  
	$s = preg_replace(  
		"/\[url\]([^()<>\s]+?)\[\/url\]/i",  
		"<a href=\"\\1\">\\1</a>", $s);  
  
	// [size=4]Text[/size]  
	$s = preg_replace(  
		"/\[size=([1-7])\]((\s|.)+?)\[\/size\]/i",  
		"<font size=\\1>\\2</font>", $s);  
  
	// [font=Arial]Text[/font]  
	$s = preg_replace(  
		"/\[font=([a-zA-Z ,]+)\]((\s|.)+?)\[\/font\]/i",  
		"<font face=\"\\1\">\\2</font>", $s);  
    
    
  	  // [youtube=https://www.youtube.com/watch?v=_y9bj5jqV7I]  
    $s = preg_replace("/\\[youtube=[^\\s'\"<>]*youtube.com.*v=([^\\s'\"<>]+)\\]/ims",   
	"<iframe width=560 height=315 src=https://www.youtube.com/embed/\\1 title=YouTube video player frameborder=0 allowfullscreen></iframe>", $s);  
  
//  //[quote]Text[/quote]  
//  $s = preg_replace(  
//    "/\[quote\]\s*((\s|.)+?)\s*\[\/quote\]\s*/i",  
//    "<p class=sub><b>Quote:</b></p><table class=main border=1 cellspacing=0 cellpadding=10><tr><td style='border: 1px black dotted'>\\1</td></tr></table><br>", $s);  
  
//  //[quote=Author]Text[/quote]  
//  $s = preg_replace(  
//    "/\[quote=(.+?)\]\s*((\s|.)+?)\s*\[\/quote\]\s*/i",  
//    "<p class=sub><b>\\1 wrote:</b></p><table class=main border=1 cellspacing=0 cellpadding=10><tr><td style='border: 1px black dotted'>\\2</td></tr></table><br>", $s);  
  
	// Quotes  
	$s = format_quotes($s);  
  
	// URLs  
	$s = format_urls($s);  
//	$s = format_local_urls($s);  
  
	// Linebreaks  
	$s = nl2br($s);  
  
	// [pre]Preformatted[/pre]  
	$s = preg_replace("/\[pre\]((\s|.)+?)\[\/pre\]/i", "<tt><nobr>\\1</nobr></tt>", $s);  
  
	// [nfo]NFO-preformatted[/nfo]  
	$s = preg_replace("/\[nfo\]((\s|.)+?)\[\/nfo\]/i", "<tt><nobr><font face='MS Linedraw' size=2 style='font-size: 10pt; line-height: " .  
		"10pt'>\\1</font></nobr></tt>", $s);  
  
	// Maintain spacing  
	$s = str_replace("  ", " &nbsp;", $s);  
  
	reset($smilies);  
	while (list($code, $url) = @each($smilies))  
		$s = str_replace($code, "<img border=0 src=\"/pic/smilies/$url\" alt=\"" . htmlspecialchars($code) . "\">", $s);  
  
	reset($privatesmilies);  
	while (list($code, $url) = each($privatesmilies))  
		$s = str_replace($code, "<img border=0 src=\"/pic/smilies/$url\">", $s);  
  
	return $s;  
}  
  
function get_user_class()  
{  
  global $CURUSER;  
  return $CURUSER["class"];  
}  
  
function is_valid_user_class($class)  
{  
  return is_numeric($class) && floor($class) == $class && $class >= UC_USER && $class <= UC_GOD;  
}  
  
function is_valid_id($id)  
{  
  return is_numeric($id) && ($id > 0) && (floor($id) == $id);  
}  
  
  
// ----- Shortens newsgroup names (not finished - add your own):  
function clean_ng_name($string) {  
      $string = str_replace("alt.", "a.", $string);  
      $string = str_replace("binaries", "b", $string);  
      $string = str_replace("multimedia", "mm", $string);  
      $string = str_replace("erotica", "e", $string);  
      $string = str_replace("pictures", "p", $string);  
      $string = str_replace(".movies", ".m", $string);  
      $string = str_replace("comedy", "com", $string);  
      $string = str_replace(".mpeg", ".mpg", $string);  
      $string = str_replace(".video", ".vid", $string);  
      $string = str_replace(".sounds", ".ss", $string);  
      $string = str_replace("repost", "r", $string);  
      $string = str_replace(".games", ".g", $string);  
      $string = str_replace("image", "i", $string);  
      $string = str_replace(".warez", ".w", $string);  
      $string = str_replace(".highspeed", ".hs", $string);  
      $string = str_replace("dominion", "d", $string);  
      $string = str_replace("midnightmovies", "mnm", $string);  
      $string = str_replace("education", "edu", $string);  
      $string = str_replace("technical", "tech", $string);  
      $string = str_replace(".complete_cd", ".c_cd", $string);  
      $string = str_replace(".electronic", ".electro", $string);  
      $string = str_replace(".gothic-industrial", ".goth-ind", $string);  
      $string = str_replace(".documentaries", ".docus", $string);  
      $string = str_replace(".playstation2.", ".ps2.", $string);  
      $string = str_replace("it.binari.x.erotismo", "i.b.x.e", $string);  
      return $string;                            
}  
  
  
// ----- Remove references to cracks, keygens, plus other stuff in the name - add your own     
function clean_nzb_name($string) {  
      $string = str_ireplace("keygen", "Fix", $string);  
      $string = str_ireplace(".patch", ".Fix", $string);  
      $string = str_ireplace("regged", "Fixed", $string);  
      $string = str_ireplace("keymaker", "Fix", $string);  
      $string = str_ireplace("cracked", "Fixed", $string);  
      $string = str_ireplace("abwi0 ", "", $string);  
      $string = str_ireplace("#", "", $string);   
      return $string;  
}  
  
// ----- To stop IMDb, etc giving filenames bad characters  
function cleannzbfilename($name) {  
    return str_replace(array(":", "'", "\"", "&", "#"), array("", "", "", "", ""), $name);  
}  
  
  
// ----- Function to get a user's nzb-related permissions:  
function getNzbPermissions($forwhat) {  
  
    //------------------------------------------------------------------------  
    //-- REMEMBER THAT THIS MUST BE CHANGED IF THE USER CLASSES ARE ALTERED!!-  
    //------------------------------------------------------------------------  
      
    global $CURUSER;  
  
    /* set permissions here. maxdlpday is an integer, will go against   
    nzbstodaydl - the rest are intended as booleans  
    zip     = Can download zipped NZB's  
    nzb     = Can download uncompressed NZB's  
    part    = Can download partial NZB's  
    maxdlpday = Max NZB's a user can download (per day)  
    ulnzb   = Can upload NZB's  
    ulzip   = Can upload zipped NZB's  
    nfo     = Can view the NZB's NFO  
    nzbmsg  = Message displayed if user can't download zipped NZB's and/or NZB's  
    nfomsg  = Message displayed if user can't view NZB's NFO   
    partmsg = Message displayed if user can't download partial NZB's  
    maxmsg  = Message displayed if user has reached their download limit   
      
    All are examples below, customise this for your classes, whether you have download disabled, etc. Add in extra arrays of values if you want, just make sure to set the conditions below in the correct order. */  
      
    $permissions = array(  
        // array 0 - Leech/Peasant Class or warned user  
        array(  
            "zip" => 0,  
            "nzb" => 0,  
            "part" => 0,  
            "maxdlpday" => 0,  
            "ulnzb" => 0,  
            "ulzip" => 0,  
            "nfo" => 0,  
            "nzbmsg" => "",  
            "nfomsg" => "",  
            "partmsg" => "",  
            "maxmsg" => 0  
        ),  
        // array 1 - User  
        array(        
            "zip" => 1,  
            "nzb" => 0,  
            "part" => 0,  
            "maxdlpday" => 15,  
            "ulnzb" => 1,  
            "ulzip" => 0,  
            "nfo" => 0,  
            "nzbmsg" => "",  
            "nfomsg" => "",  
            "partmsg" => "",  
            "maxmsg" => ""		     
        ),  
        // array 2 - Power User  
        array(        
            "zip" => 1,  
            "nzb" => 1,  
            "part" => 0,  
            "maxdlpday" => 30,  
            "ulnzb" => 1,  
            "ulzip" => 1,  
            "nfo" => 1,  
            "nzbmsg" => 0,  
            "nfomsg" => 0,  
            "partmsg" => "",  
            "maxmsg" => ""		     
        ),  
        // array 3 - VIP and upwards  
        array(        
            "zip" => 1,  
            "nzb" => 1,  
            "part" => 1,  
            "maxdlpday" => 100,  
            "ulnzb" => 1,  
            "ulzip" => 1,  
            "nfo" => 1,  
            "nzbmsg" => 0,  
            "nfomsg" => 0,  
            "partmsg" => 0,  
            "maxmsg" => ""		     
        ),  
        // array 4 - NZB Unrestricted  
        array(        
            "zip" => 1,  
            "nzb" => 1,  
            "part" => 1,  
            "maxdlpday" => 100,  
            "ulnzb" => 1,  
            "ulzip" => 1,  
            "nfo" => 1,  
            "nzbmsg" => 0,  
            "nfomsg" => 0,  
            "partmsg" => 0,  
            "maxmsg" => ""		     
        ),  
        // array 5 - Download Disabled  
        array(        
            "zip" => 0,  
            "nzb" => 0,  
            "part" => 0,  
            "maxdlpday" => 0,  
            "ulnzb" => 0,  
            "ulzip" => 0,  
            "nfo" => 1,  
            "nzbmsg" => "",  
            "nfomsg" => 0,  
            "partmsg" => "",  
            "maxmsg" => 0		     
        )  
    );  
      
    // Set which array the user will be accessing for permission  
    // *needs to be in qualification order!*  
    // All conditions must be joined by elseif's  
    // Download disabled peeps:  
    //if ($CURUSER["downloadpos"] == "no")  
    //    $arr = 5;  
    // Now the unrestricted users:  
    // elseif ($CURUSER["nzbunrestr"] == "yes")  
    if ($CURUSER["nzbunrestr"] == "yes")  
        $arr = 4;  
    // Now users with a class of VIP or above:  
    elseif ($CURUSER["class"] >= UC_VIP)  
        $arr = 3;  
    // Now the lower classes:  
    elseif ($CURUSER["class"] == UC_POWERUSER)  
        $arr = 2;  
    elseif ($CURUSER["class"] == UC_USER)  
        $arr = 1;  
    //elseif ($CURUSER["class"] == UC_LEECH)  
    //    $arr = 0;  
    // Just to be on safe side...:  
    //else  
    //    $arr = 1;  
          
    // Reet, let's access what they can do:  
    $answer = $permissions[$arr][$forwhat];  
      
    return $answer;  
}  
  
  //-------- Begins a main frame  
  
  function begin_main_frame()  
  {  
    print("<table class=main width=750 border=0 cellspacing=0 cellpadding=0>" .  
      "<tr><td class=embedded>\n");  
  }  
  
  //-------- Ends a main frame  
  
  function end_main_frame()  
  {  
    print("</td></tr></table>\n");  
  }  
  
  function begin_frame($caption = "", $center = false, $padding = 10)  
  {  
    if ($caption)  
      print("<h2>$caption</h2>\n");  
  
    print("<table width=100% border=1 cellspacing=0 cellpadding=$padding><tr><td  align=center>\n");  
  
  }  
  
  function begin_frame_site($caption = "", $center = false, $padding = 10)  
  {  
    if ($caption)  
      print("<h2>$caption</h2>\n");  
  
    print("<table width=100% border=1 cellspacing=0 cellpadding=$padding><tr><td align=center>\n");  
  
  }  
  
  function attach_frame($padding = 10)  
  {  
    print("</td></tr><tr><td style='border-top: 0px'>\n");  
  }  
  
  function end_frame()  
  {  
    print("</td></tr></table>\n");  
  }  
  
  function begin_table($fullwidth = false, $padding = 5)  
  {  
    if ($fullwidth)  
      $width = " width=100%";  
    print("<table class=main$width border=1 cellspacing=0 cellpadding=$padding>\n");  
  }  
  
  function begin_table_site($fullwidth = false, $padding = 5)  
  {  
    if ($fullwidth)  
      $width = " width=100%";  
    print("<table class=main$width border=1 cellspacing=0 cellpadding=$padding>\n");  
  }  
  
  function end_table()  
  {  
    print("</td></tr></table>\n");  
  }  
  
  //-------- Inserts a smilies frame  
  //         (move to globals)  
  
  function insert_smilies_frame()  
  {  
    global $smilies, $BASEURL;  
  
    begin_frame("Gezichtjes", true);  
  
    begin_table(false, 5);  
  
    print("<tr><td class=colhead>Intypen...</td><td class=colhead>Om te maken ...</td></tr>\n");  
  
    while (list($code, $url) = each($smilies))  
      print("<tr><td>$code</td><td><img src=$BASEURL/pic/smilies/$url></td>\n");  
  
    end_table();  
  
    end_frame();  
  }  
  
  
function sql_timestamp_to_unix_timestamp($s)  
{  
  return mktime(substr($s, 11, 2), substr($s, 14, 2), substr($s, 17, 2), substr($s, 5, 2), substr($s, 8, 2), substr($s, 0, 4));  
}  
  
  function get_ratio_color($ratio)  
  {  
    if ($ratio < 0.1) return "#ff0000";  
    if ($ratio < 0.2) return "#ee0000";  
    if ($ratio < 0.3) return "#dd0000";  
    if ($ratio < 0.4) return "#cc0000";  
    if ($ratio < 0.5) return "#bb0000";  
    if ($ratio < 0.6) return "#aa0000";  
    if ($ratio < 0.7) return "#990000";  
    if ($ratio < 0.8) return "#880000";  
    if ($ratio < 0.9) return "#770000";  
    if ($ratio < 1) return "#660000";  
    return "green";  
  }  
  
  function get_slr_color($ratio)  
  {  
    if ($ratio < 0.025) return "#ff0000";  
    if ($ratio < 0.05) return "#ee0000";  
    if ($ratio < 0.075) return "#dd0000";  
    if ($ratio < 0.1) return "#cc0000";  
    if ($ratio < 0.125) return "#bb0000";  
    if ($ratio < 0.15) return "#aa0000";  
    if ($ratio < 0.175) return "#990000";  
    if ($ratio < 0.2) return "#880000";  
    if ($ratio < 0.225) return "#770000";  
    if ($ratio < 0.25) return "#660000";  
    if ($ratio < 0.275) return "#550000";  
    if ($ratio < 0.3) return "#440000";  
    if ($ratio < 0.325) return "#330000";  
    if ($ratio < 0.35) return "#220000";  
    if ($ratio < 0.375) return "#110000";  
    return "#FFFFFF";  
  }  
  
function write_log($text)  
{  
  $text = sqlesc($text);  
  $added = sqlesc(get_date_time());  
  global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;  
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	  
mysqli_query($con_link, "INSERT INTO sitelog (added, txt) VALUES($added, $text)") or sqlerr(__FILE__, __LINE__);  
}  
  
function write_ip_log($tekst1, $tekst2, $tekst3)  
{  
	global $CURUSER;  
	  
  $tekst1 = sqlesc($tekst1);  
  $tekst2 = sqlesc($tekst2);  
  $tekst3 = sqlesc($tekst3);  
   $userid = sqlesc($CURUSER['id']);  
  $added = sqlesc(get_date_time());  
  global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;  
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	  
mysqli_query($con_link, "INSERT INTO ip_logboek (tekst1, tekst2, tekst3, added, user) VALUES($tekst1, $tekst2, $tekst3, $added, $userid)") or sqlerr(__FILE__, __LINE__);  
}  
  
function write_log_admin($text)  
{  
  $text = sqlesc($text);  
  $added = sqlesc(get_date_time());  
  global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;  
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	  
mysqli_query($con_link, "INSERT INTO sitelogadmin (added, txt) VALUES($added, $text)") or sqlerr(__FILE__, __LINE__);  
}  
  
function write_log_cheat($text)  
{  
  $text = sqlesc($text);  
  $added = sqlesc(get_date_time());  
  global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;  
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	  
mysqli_query($con_link, "INSERT INTO sitelogcheat (added, txt) VALUES($added, $text)") or sqlerr(__FILE__, __LINE__);  
}  
  
function write_log_login($text)  
{  
  $text = sqlesc($text);  
  $added = sqlesc(get_date_time());  
  global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;  
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	  
mysqli_query($con_link, "INSERT INTO sitelog_login (added, txt) VALUES($added, $text)") or sqlerr(__FILE__, __LINE__);  
}  
  
function write_log_warning($text)  
{  
  $text = sqlesc($text);  
  $added = sqlesc(get_date_time());  
  global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;  
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	  
mysqli_query($con_link, "INSERT INTO sitelogwarning (added, txt) VALUES($added, $text)") or sqlerr(__FILE__, __LINE__);  
}  
  
function write_log_username($text)  
{  
  $text = sqlesc($text);  
  $added = sqlesc(get_date_time());  
  global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;  
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	  
mysqli_query($con_link, "INSERT INTO sitelogusername (added, txt) VALUES($added, $text)") or sqlerr(__FILE__, __LINE__);  
}  
  
function write_log_useremail($text)  
{  
  $text = sqlesc($text);  
  $added = sqlesc(get_date_time());  
  global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;  
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	  
mysqli_query($con_link, "INSERT INTO siteloguseremail (added, txt) VALUES($added, $text)") or sqlerr(__FILE__, __LINE__);  
}  
  
function write_log_autoban($text)  
{  
  $text = sqlesc($text);  
  $added = sqlesc(get_date_time());  
  global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;  
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);	  
mysqli_query($con_link, "INSERT INTO sitelogautoban (added, txt) VALUES($added, $text)") or sqlerr(__FILE__, __LINE__);  
}  
  
function get_elapsed_time($ts)  
{  
  $mins = floor((gmtime() - $ts) / 60);  
  $hours = floor($mins / 60);  
  $mins -= $hours * 60;  
  $days = floor($hours / 24);  
  $hours -= $days * 24;  
  $weeks = floor($days / 7);  
  $days -= $weeks * 7;  
  $t = "";  
  if ($weeks > 0)  
  	if ($weeks > 1) return "$weeks weken";   
	else return "$weeks week";  
  if ($days > 0)  
  	if ($days > 1) return "$days dagen";   
	else return "$days dag";  
  if ($hours > 0)  
  	if ($hours > 1) return "$hours uur";   
	else return "$hours uur";  
  if ($mins > 0)  
  	if ($mins > 1) return "$mins minuten";   
	else return "$mins minuut";  
  return "minder dan 1 minuut";  
}  
  
function get_togotime($ts)  
	{  
	$mins = floor(($ts- gmtime()) / 60);  
	$hours = floor($mins / 60);  
	$mins -= $hours * 60;  
	$days = floor($hours / 24);  
	$hours -= $days * 24;  
	$weeks = floor($days / 7);  
	$days -= $weeks * 7;  
	$t = "";  
	if ($weeks > 0)  
		if ($weeks > 1)  
			{  
			if ($days > 1)  
				return "$weeks weken en $days dagen";  
			else  
				return "$weeks weken en $days dag";  
			}  
		else  
			{  
			if ($days > 1)  
				return "$weeks week en $days dagen";  
			else  
				return "$weeks week en $days dag";  
			}  
	if ($days > 0)  
		if ($days > 1) return "$days dagen en $hours uur";   
		else return "$days dag en $hours uur";  
	if ($hours > 0)  
		if ($hours > 1) return "$hours uur en $mins minuten";   
		else return "$hours uur en $mins minuten";  
	if ($mins > 0)  
		if ($mins > 1) return "$mins minuten";   
		else return "$mins minuut";  
	return "minder dan 1 minuut";  
	}  
	  
  
?>