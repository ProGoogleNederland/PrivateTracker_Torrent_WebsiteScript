<?php

/*
if ( ! defined( 'IN_WINBITS' ) )
{
	print "<h1>Incorrect access</h1>You cannot access this file directly.";
	exit();
}
*/
include('include/bittorrent.php');
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();
site_header("Statistics Center");
if (get_user_class() < UC_OWNER)
	stderr("Error", "Access denied.");

$pic_base_url = "/pic/";

	//$base_url = $BASEURL."/admin/statistics.php"; // You should change this! Doh!!
	tabel_start();	
?>
		
		<h2>STATISTICS CENTRE</h2>
		
		<table id='torrenttable' border='1' width=80%>
		<tr><td><a href='../statistics.php?act=stats&amp;code=reg'>Registration Stats</a></td>
		<td><a href='../statistics.php?act=stats&amp;code=rate'>Rating Stats</a></td>
		<td><a href='../statistics.php?act=stats&amp;code=post'>Post Stats</a></td>
		</tr>
		
		<tr><td><a href='../statistics.php?act=stats&amp;code=msg'>Personal Message</a></td>
		<td><a href='../statistics.php?act=stats&amp;code=torr'>Torrents Stats</a></td>
		<td><a href='../statistics.php?act=stats&amp;code=bans'>Ban Stats</a></td>
		</tr>
		
		<tr><td><a href='../statistics.php?act=stats&amp;code=comm'>Comment Stats</a></td>
		<td><a href='../statistics.php?act=stats&amp;code=new'>News Stats</a></td>
		<td><a href='../statistics.php?act=stats&amp;code=rqst'>Request Stats</a></td>
		</tr>
		</table>
		<br />
		
<?		
	tabel_einde();
	print "</br></br></br>";
	//--------------------------------------------------------------------
	tabel_start();	
	function start_form($hiddens="", $name='theAdminForm', $js="") {
		global $base_url;
	
		$form = "<form action='{$base_url}' method='post' name='$name' $js>
				 ";
		
		if (is_array($hiddens))
		{
			foreach ($hiddens as $k => $v) {
				$form .= "\n<input type='hidden' name='{$v[0]}' value='{$v[1]}'>";
			}
		}
		
		return $form;
		
	}
	
	//-----------------------------------------
	
	function form_dropdown($name, $list=array(), $default_val="", $js="", $css="") {
	
		if ($js != "")
		{
			$js = ' '.$js.' ';
		}
		
		if ($css != "")
		{
			$css = ' class="'.$css.'" ';
		}
	
		$html = "<select name='$name'".$js." $css class='dropdown'>\n";
		
		foreach ($list as $k => $v)
		{
		
			$selected = "";
			
			if ( ($default_val != "") and ($v[0] == $default_val) )
			{
				$selected = ' selected';
			}
			
			$html .= "<option value='".$v[0]."'".$selected.">".$v[1]."</option>\n";
		}
		
		$html .= "</select>\n\n";
		
		return $html;
	
	
	}
	
	//-----------------------------------------
	
	function end_form($text = "", $js = "", $extra = "")
	{
		// If we have text, we print another row of TD elements with a submit button
		
		$html    = "";
		$colspan = "";
		$td_colspan = 0;
		
		if ($text != "")
		{
			if ($td_colspan > 0)
			{
				$colspan = " colspan='".$td_colspan."' ";
			}
			
			$html .= "<tr><td align='center' class='form'".$colspan."><input type='submit' value='$text'".$js." id='button' accesskey='s'>{$extra}</td></tr>\n";
		}
		
		$html .= "</form>";
		
		return $html;
		
	}
	
	
	$month_names = array();


		
		//-----------------------------------------
		//Don't ask!!
		//-----------------------------------------
		
		$tmp_in = array_merge( $_GET, $_POST );
		
		foreach ( $tmp_in as $k => $v )
		{
			unset($$k);
		}
		//print_r($tmp_in);
		//-----------------------------------------
		
		$month_names = array( 1 => 'January', 'February', 'March'     , 'April'  , 'May'     , 'June',
										 'July'   , 'August'  , 'September' , 'October', 'November', 'December');

		if(isset($tmp_in['code']) && $tmp_in['code'] != "") {
		switch($tmp_in['code'])
		{
			case 'show_reg':
				result_screen('reg');
				break;
				
			case 'show_rate':
				result_screen('rate');
				break;
					
			case 'rate':
				main_screen('rate');
				break;
			
			//-----------------------------------------
			
			case 'show_post':
				result_screen('post');
				break;
					
			case 'post':
				main_screen('post');
				break;
			
			//-----------------------------------------
			
			case 'show_msg':
				result_screen('msg');
				break;
					
			case 'msg':
				main_screen('msg');
				break;
				
				//-----------------------------------------
			
			case 'show_torr':
				result_screen('torr');
				break;
					
			case 'torr':
				main_screen('torr');
				break;
			
			//-----------------------------------------
						
			case 'show_bans':
				result_screen('bans');
				break;
					
			case 'bans':
				main_screen('bans');
				break;
			
			//-----------------------------------------
						
			case 'show_comm':
				result_screen('comm');
				break;
					
			case 'comm':
				main_screen('comm');
				break;
			
			//-----------------------------------------
						
			case 'show_new':
				result_screen('new');
				break;
					
			case 'new':
				main_screen('new');
				break;
			
			//-----------------------------------------
						
			case 'show_poll':
				result_screen('poll');
				break;
					
			case 'poll':
				main_screen('poll');
				break;
			
			//-----------------------------------------
						
			case 'show_rqst':
				result_screen('rqst');
				break;
					
			case 'rqst':
				main_screen('rqst');
				break;
			
			//-----------------------------------------
			
			default:
				main_screen('reg');
				break;
		}
	}	
	

	
	//-----------------------------------------
	//| Results screen
	//-----------------------------------------
	function result_screen($mode='reg')
	{
		global $month_names;
		global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
		$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
		$page_title = "<h2>Statistic Center Results</h2>";
		
		$page_detail = "&nbsp;";
		
		//-----------------------------------------
		
		if ( ! checkdate($_POST['to_month']   ,$_POST['to_day']   ,$_POST['to_year']) )
		{
			die("The 'Date To:' time is incorrect, please check the input and try again");
		}
		
		if ( ! checkdate($_POST['from_month'] ,$_POST['from_day'] ,$_POST['from_year']) )
		{
			die("The 'Date From:' time is incorrect, please check the input and try again");
		}
		
		//-----------------------------------------
		
		$to_time   = mktime(12 ,0 ,0 ,$_POST['to_month']   ,$_POST['to_day']   ,$_POST['to_year']  );
		$from_time = mktime(12 ,0 ,0 ,$_POST['from_month'] ,$_POST['from_day'] ,$_POST['from_year']);
		//$sql_date_to = date("Y-m-d",$to_time);
		//$sql_date_from = date("Y-m-d",$from_time);
		
		$human_to_date   = getdate($to_time);
		$human_from_date = getdate($from_time);
		
		//-----------------------------------------
		
		if ($mode == 'reg')
		{
			$table     = 'Registration Statistics';
			
			$sql_table = 'users';
			$sql_field = 'added';
			
			$page_detail = "Showing the number of users registered. (Note: All times based on GMT)";
		}
		else if ($mode == 'rate')
		{
			$table     = 'Rating Statistics';
			
			$sql_table = 'ratings';
			$sql_field = 'added';
			
			$page_detail = "Showing the number of ratings. (Note: All times based on GMT)";
		}
		else if ($mode == 'post')
		{
			$table     = 'Post Statistics';
			
			$sql_table = 'posts';
			$sql_field = 'added';
			
			$page_detail = "Showing the number of posts. (Note: All times based on GMT)";
		}
		else if ($mode == 'msg')
		{
			$table     = 'PM Sent Statistics';
			
			$sql_table = 'messages';
			$sql_field = 'added';
			
			$page_detail = "Showing the number of sent messages. (Note: All times based on GMT)";
		}
		else if ($mode == 'torr')
		{
			$table     = 'Torrent Statistics';
			
			$sql_table = 'torrents';
			$sql_field = 'added';
			
			$page_detail = "Showing the number of Torrents. (Note: All times based on GMT)";
		}
		else if ($mode == 'bans')
		{
			$table     = 'Ban Statistics';
			
			$sql_table = 'bans';
			$sql_field = 'added';
			
			$page_detail = "Showing the number of Bans. (Note: All times based on GMT)";
		}
		else if ($mode == 'comm')
		{
			$table     = 'Comment Statistics';
			
			$sql_table = 'comments';
			$sql_field = 'added';
			
			$page_detail = "Showing the number of torrent Comments. (Note: All times based on GMT)";
		}
		else if ($mode == 'new')
		{
			$table     = 'News Statistics';
			
			$sql_table = 'news';
			$sql_field = 'added';
			
			$page_detail = "Showing the number of News Items added. (Note: All times based on GMT)";
		}
		else if ($mode == 'poll')
		{
			$table     = 'Poll Statistics';
			
			$sql_table = 'polls';
			$sql_field = 'added';
			
			$page_detail = "Showing the number of Polls added. (Note: All times based on GMT)";
		}
		else if ($mode == 'rqst')
		{
			$table     = 'Request Statistics';
			
			$sql_table = 'requests';
			$sql_field = 'added';
			
			$page_detail = "Showing the number of Requests made. (Note: All times based on GMT)";
		}
		
	  	switch ($_POST['timescale'])
	  	{
	  		case 'daily':
	  			$sql_date = "%w %U %m %Y";
		  		$php_date = "F jS - Y";
		  		//$sql_scale = "DAY";
		  		break;
		  		
		  	case 'monthly':
		  		$sql_date = "%m %Y";
		  	    $php_date = "F Y";
		  	    //$sql_scale = "MONTH";
		  	    break;
		  	    
		  	default:
		  		// weekly
		  		$sql_date = "%U %Y";
		  		$php_date = " [F Y]";
		  		//$sql_scale = "WEEK";
		  		break;
		}
		
		$sortby = isset($_POST['sortby']) ? mysqli_real_escape_string($con_link, $_POST['sortby']) : "";
		//$sortby = sqlesc($sortby);
		$sqlq = "SELECT UNIX_TIMESTAMP(MAX({$sql_field})) as result_maxdate,
				 COUNT(*) as result_count,
				 DATE_FORMAT({$sql_field},'{$sql_date}') AS result_time
				 FROM {$sql_table}
				 WHERE UNIX_TIMESTAMP({$sql_field}) > '{$from_time}'
				 AND UNIX_TIMESTAMP({$sql_field}) < '{$to_time}'
				 GROUP BY result_time
				 ORDER BY {$sql_field} {$sortby}";
		
		$res = @mysqli_query($con_link, $sqlq);
	/*	$res = @sql_query( "SELECT UNIX_TIMESTAMP(MAX(added)) as result_maxdate,
							COUNT(*) as result_count,
							".$sql_scale."(".$sql_field.") AS result_time
							FROM ".$sql_table."
							WHERE added > '".$sql_date_from."'
							AND added < '".$sql_date_to."'
							GROUP BY result_time
							ORDER BY ".$sql_field); */
		
		
		$running_total = 0;
		$max_result    = 0;
		
		$results       = array();
		//-----------------------------------------
		// Naaaaaaaaaaaaaaaaah!! STILL!
		//$td_header = array();
		//$td_header[] = array( "Date"    , "20%" );
		//$td_header[] = array( "Result"  , "70%" );
		//$td_header[] = array( "Count"   , "10%" );
		
		//-----------------------------------------
		
		$html = $page_title."<br /><table id=torrenttable border=1 width=100%><tr><td colspan=3>".ucfirst($_POST['timescale']) ." ".$table
			." ({$human_from_date['mday']} {$month_names[$human_from_date['mon']]} {$human_from_date['year']} to"
										    ." {$human_to_date['mday']} {$month_names[$human_to_date['mon']]} {$human_to_date['year']})<br />{$page_detail}</td></tr>\n";
		
		if ( mysqli_num_rows($res) )
		{
		
			while ($row = mysqli_fetch_array($res) )
			{
			
				if ( $row['result_count'] >  $max_result )
				{
					$max_result = $row['result_count'];
				}
				
				$running_total += $row['result_count'];
			
				$results[] = array(
									 'result_maxdate'  => $row['result_maxdate'],
									 'result_count'    => $row['result_count'],
									 'result_time'     => $row['result_time'],
								  );
								  
			}
			
			foreach( $results as $pOOp => $data )
			{
			
    			$img_width = intval( ($data['result_count'] / $max_result) * 100 - 20);
    			
    			if ($img_width < 1)
    			{
    				$img_width = 1;
    			}
    			
    			$img_width .= '%';
    			
    			if ($_POST['timescale'] == 'weekly')
    			{
    				$date = "Week #".strftime("%W", $data['result_maxdate'])."<br />" . date( $php_date, $data['result_maxdate'] );
    			}
    			else
    			{
    				$date = date( $php_date, $data['result_maxdate'] );
    			}
    			
    			$html .= "<tr><td width=25%>" .$date . "</td><td width=70%><img src='/pic/bar_end.gif' border='0' height='10' align='middle' alt=''><img src='/pic/bar.gif' border='0' width='$img_width' height='10' align='middle' alt=''><img src='/pic/bar_end.gif' border='0' height='10' align='middle' alt=''></td><td align=right width=5%>".
												  		  $data['result_count']."</td></tr>\n";
			}
			
			$html .= '<tr><td colspan=3>&nbsp;'. "<div align='right'><b>Total </b>".
													 "<b>".$running_total."</b></div></td></tr>\n";
		
		}
		else
		{
			$html .= "<tr><td>No results found</td></tr>\n" ;
		}
		
		
		
		print $html."</table>\n<br />";
		
	}
	print "</br></br></br>";
	//-----------------------------------------
	//| Date selection screen
	//-----------------------------------------
	function main_screen($mode='reg')
	{
		global $month_names;
		
		$page_title = "";
		
		$page_detail = "";
		
		if ($mode == 'reg')
		{
			$form_code = 'show_reg';
			
			$table     = '<h2>Registration Statistics</h2>';
		}
		else if ($mode == 'rate')
		{
			$form_code = 'show_rate';
			
			$table     = '<h2>Rating Statistics</h2>';
		}
		else if ($mode == 'post')
		{
			$form_code = 'show_post';
			
			$table     = '<h2>Post Statistics</h2>';
		}
		else if ($mode == 'msg')
		{
			$form_code = 'show_msg';
			
			$table     = '<h2>PM Statistics</h2>';
		}
		else if ($mode == 'torr')
		{
			$form_code = 'show_torr';
			
			$table     = '<h2>Torrent Statistics</h2>';
		}
		else if ($mode == 'bans')
		{
			$form_code = 'show_bans';
			
			$table     = '<h2>Ban Statistics</h2>';
		}
		else if ($mode == 'comm')
		{
			$form_code = 'show_comm';
			
			$table     = '<h2>Comment Statistics</h2>';
		}
		else if ($mode == 'new')
		{
			$form_code = 'show_new';
			
			$table     = '<h2>News Statistics</h2>';
		}
		else if ($mode == 'poll')
		{
			$form_code = 'show_poll';
			
			$table     = '<h2>Polls Statistics</h2>';
		}
		else if ($mode == 'rqst')
		{
			$form_code = 'show_rqst';
			
			$table     = '<h2>Request Statistics</h2>';
		}
		
		
		$old_date = getdate(time() - (3600 * 24 * 90));
		$new_date = getdate(time() + (3600 * 24));
		
		
		//-----------------------------------------
		
		$html =  "<table id=torrenttable border=1 width=80%><tr><td>$table</td></tr>";
		$html .=  "<tr><td>$page_title<br />$page_detail</td></tr>";
		$html .= start_form( array( 1 => array( 'code'  , $form_code  ),
												  2 => array( 'act'   , 'stats'     ),
									     )      );
		
		//-----------------------------------------
		// Naaaaaaaaaaaah!!
		//$td_header = array();
		//$td_header[] = array( "&nbsp;"  , "40%" );
		//$td_header[] = array( "&nbsp;"  , "60%" );
		
		//-----------------------------------------
		

									     
		$html .= "<tr><td><br /><b>Van </b>" .form_dropdown( "from_month" , make_month(), $old_date['mon']  ).'&nbsp;&nbsp;'.
				form_dropdown( "from_day"   , make_day()  , $old_date['mday'] ).'&nbsp;&nbsp;'.
												  form_dropdown( "from_year"  , make_year() , $old_date['year'] )
												  ."<br /></td></tr>";
									     
		$html .= "<tr><td><br /><b>Tot </b>" .form_dropdown( "to_month" , make_month(), $new_date['mon']  ).'&nbsp;&nbsp;'.
												  form_dropdown( "to_day"   , make_day()  , $new_date['mday'] ).'&nbsp;&nbsp;'.form_dropdown( "to_year"  , make_year() , $new_date['year'] ) ."<br /></td></tr>";
		
		if ($mode != 'views')
		{
			$html .= "<tr><td><br /><b>Zichtbaar per </b>" .form_dropdown( "timescale" , array( 0 => array( 'daily', 'Dag'), 1 => array( 'weekly', 'Week' ), 2 => array( 'monthly', 'Maand' ) ) ) ."<br /></td></tr>";
		}
						     
		$html .= "<tr><td><br /><b>Resultaat Sorteren op  </b>" .form_dropdown( "sortby" , array( 0 => array( 'asc', 'Oude datum eerst'), 1 => array( 'desc', 'Recente datum eerst' ) ), 'desc' ) ."<br /></td></tr>";
									     									     
		$html .= end_form("Show")."</table>";
										 
		
		
		print $html;
		
		
	}
	//-----------------------------------------
	
	function make_year()
	{
		$time_now = getdate();
		
		$return = array();
		
		$start_year = 2002;
		
		$latest_year = intval($time_now['year']);
		
		if ($latest_year == $start_year)
		{
			$start_year -= 1;
		}
		
		for ( $y = $start_year; $y <= $latest_year; $y++ )
		{
			$return[] = array( $y, $y);
		}
		
		return $return;
	}
	
	//-----------------------------------------
	
	function make_month()
	{
		global $month_names;
		reset($month_names);
		$return = array();
		
		for ( $m = 1 ; $m <= 12; $m++ )
		{
			$return[] = array( $m, $month_names[$m] );
		}
		
		return $return;
	}
	
	//-----------------------------------------
	
	function make_day()
	{
		$return = array();
		
		for ( $d = 1 ; $d <= 31; $d++ )
		{
			$return[] = array( $d, $d );
		}
		
		return $return;
	}
	
tabel_einde();		
site_footer();
?>