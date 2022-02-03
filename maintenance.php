<?php
require_once("include/bittorrent.php");
require_once("include/site_functions.php");

dbconn();
site_header("Snelle Nederlandse High Quality Downloads");
print "<meta name=\"googlebot\" content=\"nofollow\">";
print "<meta name=\"robots\" content=\"nofollow\">";
page_start();
tabel_start();
	print("</br></br></br><font size=6 color=white>Onderhoud bezig.. wij zijn snel weer terug</font></br></br></br>\n");
	

tabel_einde();
page_einde();
site_footer();
?>