![alt text](https://github.com/[username]/[reponame]/blob/[branch]/demo1.jpg?raw=true)

![alt text](https://github.com/[username]/[reponame]/blob/[branch]/demo2.jpg?raw=true)

![alt text](https://github.com/[username]/[reponame]/blob/[branch]/demo3.jpg?raw=true)

```
=============================================
=== DUTCH PRIVATE TORRENT TRACKER WEBSITE ===
===   CLEAN AND COLORFULL MODERN DESIGN   ===
=============================================
==========  :: FAST & STABLE ::  ============
==========  ::    PHP7.3+    ::  ============
==========  ::  LATEST MySQL ::  ============
=============================================


=============================================
==========  ::  HOW TO SETUP  :: ============
=============================================
```

1. EDIT; include/bittorrent.php (links & sitename)

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

2. EDIT; include/bittorrent.php  (password reset or creation)
   
```
// To make a new hash go to http://www.sha1-online.com/ and create a secure key SHA1

$PASSWORD_HASH ="5600BA1C24CB49B5600BA1C24CB49B";
```

3. IMPORT DATABASE; (in "mysql" folder)

```
database.sql
```

4. EDIT; include/secrets.php (database settings)

```
$mysql_host = "localhost";  /////location of database, usually localhost 
$mysql_user = "progoogl_torrent";  ///username of database
$mysql_pass = "progoogl_torrent"; ////pass of database
$mysql_db = "progoogl_torrent"; ////name of database
```

5. LOGIN; (admin account in front-end)

```
TorrentMedia
Qwerty@123
```

6. OPPOSITIONAL; Adjust php.ini if needed

```
============================================
=====  ::      2023 Copyright     ::  ======
=====  ::  Pro Google Nederland   ::  ======
============================================
=========  ::   Credits for   :: ===========
=========  :: Robin Offenberg :: ===========
============================================
```
