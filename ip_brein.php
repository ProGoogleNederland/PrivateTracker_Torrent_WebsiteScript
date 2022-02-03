<?php
require "include/bittorrent.php";
require_once("include/secrets.php");
global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
$con_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
dbconn(false);
loggedinorreturn();

if (get_user_class() < UC_ADMINISTRATOR)
	site_error_message("Foutmelding", "Deze pagina is alleen voor de administrator en hoger.");


	$first = trim("87.249.97.112");
	$last = trim("87.249.97.127");
	$comment = "Stichting Brein - NOOIT verwijderen.";
	$first = ip2long($first);
	$last = ip2long($last);
	if ($first == -1 || $last == -1)
		site_error_message("Foutmelding", "Verkeerd IP nummer.");
	$comment = sqlesc($comment);
	$added = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO bans (added, addedby, first, last, comment) VALUES($added, $CURUSER[id], $first, $last, $comment)") or sqlerr(__FILE__, __LINE__);

	$first = trim("61.35.135.0");
	$last = trim("61.35.135.63");
	$comment = "Stichting Brein - NOOIT verwijderen.";
	$first = ip2long($first);
	$last = ip2long($last);
	if ($first == -1 || $last == -1)
		site_error_message("Foutmelding", "Verkeerd IP nummer.");
	$comment = sqlesc($comment);
	$added = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO bans (added, addedby, first, last, comment) VALUES($added, $CURUSER[id], $first, $last, $comment)") or sqlerr(__FILE__, __LINE__);

	$first = trim("62.58.162.224");
	$last = trim("62.58.162.239");
	$comment = "Stichting Brein - NOOIT verwijderen.";
	$first = ip2long($first);
	$last = ip2long($last);
	if ($first == -1 || $last == -1)
		site_error_message("Foutmelding", "Verkeerd IP nummer.");
	$comment = sqlesc($comment);
	$added = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO bans (added, addedby, first, last, comment) VALUES($added, $CURUSER[id], $first, $last, $comment)") or sqlerr(__FILE__, __LINE__);

	$first = trim("62.58.173.64");
	$last = trim("62.58.173.87");
	$comment = "Stichting Brein - NOOIT verwijderen.";
	$first = ip2long($first);
	$last = ip2long($last);
	if ($first == -1 || $last == -1)
		site_error_message("Foutmelding", "Verkeerd IP nummer.");
	$comment = sqlesc($comment);
	$added = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO bans (added, addedby, first, last, comment) VALUES($added, $CURUSER[id], $first, $last, $comment)") or sqlerr(__FILE__, __LINE__);

	$first = trim("211.119.63.192");
	$last = trim("211.119.63.255");
	$comment = "Stichting Brein - NOOIT verwijderen.";
	$first = ip2long($first);
	$last = ip2long($last);
	if ($first == -1 || $last == -1)
		site_error_message("Foutmelding", "Verkeerd IP nummer.");
	$comment = sqlesc($comment);
	$added = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO bans (added, addedby, first, last, comment) VALUES($added, $CURUSER[id], $first, $last, $comment)") or sqlerr(__FILE__, __LINE__);

	$first = trim("211.168.129.64");
	$last = trim("211.168.129.79");
	$comment = "Stichting Brein - NOOIT verwijderen.";
	$first = ip2long($first);
	$last = ip2long($last);
	if ($first == -1 || $last == -1)
		site_error_message("Foutmelding", "Verkeerd IP nummer.");
	$comment = sqlesc($comment);
	$added = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO bans (added, addedby, first, last, comment) VALUES($added, $CURUSER[id], $first, $last, $comment)") or sqlerr(__FILE__, __LINE__);


	$first = trim("80.127.175.48");
	$last = trim("80.127.175.63");
	$comment = "Stichting Brein - NOOIT verwijderen.";
	$first = ip2long($first);
	$last = ip2long($last);
	if ($first == -1 || $last == -1)
		site_error_message("Foutmelding", "Verkeerd IP nummer.");
	$comment = sqlesc($comment);
	$added = sqlesc(get_date_time());
	mysqli_query($con_link, "INSERT INTO bans (added, addedby, first, last, comment) VALUES($added, $CURUSER[id], $first, $last, $comment)") or sqlerr(__FILE__, __LINE__);

?>