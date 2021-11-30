# TorrentMedia.org
**PHP7.3**
**Latest MySQL**
**Light weight**

**Dutch Private Torrent Tracker Website**
[DEMO](https://torrentmedia.org)

adjust as needed:
- include/bittorrent.php (links & sitename)
```
$announce_urls[] = "https://torrentmedia.org/announce.php";
$announce_site = "https://torrentmedia.org/announce.php";

if ($_SERVER["HTTP_HOST"] == "")
	$_SERVER["HTTP_HOST"] = $_SERVER["SERVER_NAME"];

$BASEURL = "https://" . $_SERVER["HTTP_HOST"];


$DEFAULTBASEURL = "https://torrentmedia.org";
$PEERLIMIT = 50000;
$SITEEMAIL = "no-reply@torrentmedia.org";
$TORRENTEMAIL = "no-reply@torrentmedia.org";
$EMAIL_NOREPLY = "no-reply@torrentmedia.org";
$RECOVEREMAIL = "no-reply@torrentmedia.org";
$SITE_NAME = "Torrent Media";
```

- include/bittorrent.php  (password reset or creation)
```
// To make a new hash go to http://www.sha1-online.com/ and create a secure key SHA1

$PASSWORD_HASH ="5600BA1C24CB49B5600BA1C24CB49B";
```

Make a database inport database in "mysql" folder
- include/secrets.php
database settings
```
$mysql_host = "localhost";  /////location of database, usually localhost 
$mysql_user = "progoogl_torrent";  ///username of database
$mysql_pass = "progoogl_torrent"; ////pass of database
$mysql_db = "progoogl_torrent"; ////name of database
```

Login System:
```
TorrentMedia
Qwerty@123
```

Adjust php.ini if needed

2021 Copyright and Credit 
[Pro Google Nederland](https://progoogle.nl)
