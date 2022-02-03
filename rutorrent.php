<?php
require_once("include/bittorrent.php");

dbconn();

site_header("Rtorrent + RuTorrent 3.10");

print("<table class=bottom width=90% border=0 cellspacing=0 cellpadding=0><tr><td class=embedded-page>\n");
tabel_top("Rtorrent + RuTorrent 3.10 met Docker op Windows 10/11 - Hou je aan je ratio 1:1 anders verlies je de status.","center");
tabel_start();
?>

<b><div align=center>
<font color=white size=4><b>HowTo</b></br></br></font>
<div align=center>
<font color=lightblue>
<table align=center width=45% border=0 cellspacing=0 cellpadding=0><tr><td class=embedded-page>
Installeer de volgende 2 benodigdheden:</br>
<a href="https://desktop.docker.com/win/stable/amd64/Docker%20Desktop%20Installer.exe">DOCKER DESKTOP</a></br>
<a href="https://dotnet.microsoft.com/download/dotnet/thank-you/runtime-desktop-5.0.0-windows-x86-installer">.NET Desktop Runtime 5.0.0</a></br>
</br>
Open "CMD" als administrator</br>
</br>
Kopieër de regel hier onder op 1 lijn in "CMD" <b>g:/Dowloads/</b> vervang je voor jouw gewenste Windows locatie.</br>
docker run -d --name rutorrent --ulimit nproc=65535 --ulimit nofile=32000:40000 -p 6881:6881/udp -p 8000:8000 -p 8080:8080 -p 9000:9000</br>
-p 50000:50000 -v <b>g:/Downloads/</b>:/hdd -v /data:/data -v /hdd/:/hdd -v /passwd:/passwd crazymax/rtorrent-rutorrent:latest</br>
</br>
Open je browser en typ:</br>
localhost:8080</br>
</br>
Je kan nu Rutorrent 3.10 gebruiken.</br>
</br>
Docker zal bij het opstarten van je pc vertraagd opstarten en tijden gebruik van windows op de achtergrond draaien.</br>
</br>
Minimale vereisten:</br>
Windows 10/11
4 cores & 4GB geheugen</br>
</br>
Aangeraden specificaties:</br>
Windows 10/11
8 cores & 8GB geheugen</br>
LET OP! Dit moet je toewijzen aan Docker standaard gebruikt docker 1 core met 1.5GB geheugen + 512MB Swap geheugen.</br>
</br>
Mocht u eventueel twijfels of vragen hebben over, of u heeft een probleem  met een torrent, neem dan eerst contact op </br>
met iemand van ons <a class=altlink_yellow href="<? print $BASEURL ?>/staff.php">staf</a></br>
<a href="https://torrentmedia.org/login.php">U dient zich wel eerst aan te melden.</a></br>
</br>
</td></tr></table>

<?
tabel_einde();

print("</td></tr></table>\n");
site_footer(); ?>