-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Gegenereerd op: 03 jul 2023 om 03:53
-- Serverversie: 10.3.36-MariaDB-cll-lve
-- PHP-versie: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `progoogl_torrent`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `aa_results`
--

CREATE TABLE `aa_results` (
  `id` int(10) UNSIGNED NOT NULL,
  `site` varchar(40) NOT NULL DEFAULT '',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `username` varchar(40) NOT NULL DEFAULT '',
  `email` varchar(80) NOT NULL DEFAULT '',
  `class` varchar(40) NOT NULL DEFAULT '',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_access` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `uploaded` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `downloaded` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `addedrequests`
--

CREATE TABLE `addedrequests` (
  `id` int(10) UNSIGNED NOT NULL,
  `requestid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `aktie`
--

CREATE TABLE `aktie` (
  `id` int(10) UNSIGNED NOT NULL,
  `datum` varchar(10) NOT NULL DEFAULT '',
  `krediet` char(2) NOT NULL DEFAULT '',
  `aktie` varchar(255) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `added_by` int(10) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `aktie_donatie`
--

CREATE TABLE `aktie_donatie` (
  `id` int(8) NOT NULL,
  `aktie_a` int(2) NOT NULL DEFAULT 0,
  `aktie_b` int(2) NOT NULL DEFAULT 0,
  `aktie_c` int(2) NOT NULL DEFAULT 0,
  `aktie_d` int(2) NOT NULL DEFAULT 0,
  `omschrijving` varchar(255) NOT NULL DEFAULT '',
  `added` int(11) NOT NULL DEFAULT 0,
  `added_by` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `antidos_logs`
--

CREATE TABLE `antidos_logs` (
  `ip` varchar(15) NOT NULL,
  `first` int(11) NOT NULL,
  `last` int(11) NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=MEMORY DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `auto_warning`
--

CREATE TABLE `auto_warning` (
  `userid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `gb_last` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gb_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `gb_up` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `gb_down` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `pakken_last` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pakken_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `pakken_up` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `pakken_down` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `avps`
--

CREATE TABLE `avps` (
  `arg` varchar(20) NOT NULL DEFAULT '',
  `value_s` text NOT NULL,
  `value_i` int(11) NOT NULL DEFAULT 0,
  `value_u` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `banned_agent`
--

CREATE TABLE `banned_agent` (
  `id` int(3) NOT NULL,
  `agent` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bans`
--

CREATE TABLE `bans` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `addedby` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `comment` varchar(255) NOT NULL DEFAULT '',
  `first` bigint(11) DEFAULT NULL,
  `last` bigint(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `bans`
--

INSERT INTO `bans` (`id`, `added`, `addedby`, `comment`, `first`, `last`) VALUES
(1, '2008-01-01 12:50:09', 0, 'Systeem ip uitsluiting, niet verwijderbaar.', 1043999834, 1043999834),
(2, '2008-01-01 12:50:09', 0, 'Systeem ip uitsluiting, niet verwijderbaar.', 1387223739, 1387223739),
(3, '2008-01-01 12:50:09', 0, 'Systeem ip uitsluiting, niet verwijderbaar.', 1345959512, 1345959512),
(4, '2008-01-01 12:50:09', 0, 'Systeem ip uitsluiting, niet verwijderbaar.', 1387223738, 1387223738),
(5, '2008-01-01 12:50:09', 0, 'Systeem ip uitsluiting, niet verwijderbaar.', 1414584468, 1414584468),
(6, '2008-01-01 21:36:12', 0, 'Systeem ip uitsluiting, niet verwijderbaar.', 1448616486, 1448616486),
(7, '2021-05-08 15:15:40', 3, 'Gebruiker xxx is verbannen omdat:hacker', 1435834558, 1435834558),
(8, '2021-05-08 15:34:14', 3, 'Gebruiker xxx is verbannen omdat:', 1309946032, 1309946032),
(12, '2021-07-03 03:00:00', 8, 'Stichting Brein - NOOIT verwijderen.', 1475961200, 1475961215),
(13, '2021-07-03 03:00:00', 8, 'Stichting Brein - NOOIT verwijderen.', 1025738496, 1025738559),
(14, '2021-07-03 03:00:00', 8, 'Stichting Brein - NOOIT verwijderen.', 1044030176, 1044030191),
(15, '2021-07-03 03:00:00', 8, 'Stichting Brein - NOOIT verwijderen.', 1044032832, 1044032855),
(16, '2021-07-03 03:00:00', 8, 'Stichting Brein - NOOIT verwijderen.', 3547807680, 3547807743),
(17, '2021-07-03 03:00:00', 8, 'Stichting Brein - NOOIT verwijderen.', 3551035712, 3551035727),
(18, '2021-07-03 03:00:00', 8, 'Stichting Brein - NOOIT verwijderen.', 1350545200, 1350545215),
(23, '2021-11-14 23:40:15', 3, 'Gebruiker Mr Media is verbannen en verwijderd van de site.', 0, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bans_special`
--

CREATE TABLE `bans_special` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `addedby` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `comment` varchar(255) NOT NULL DEFAULT '',
  `first` int(11) DEFAULT NULL,
  `last` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `berichten`
--

CREATE TABLE `berichten` (
  `id` int(10) UNSIGNED NOT NULL,
  `box_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `reply` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sender` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `receiver` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `subject_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `msg` text DEFAULT NULL,
  `read_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `berichten_box`
--

CREATE TABLE `berichten_box` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `box` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `berichten_sjabloon`
--

CREATE TABLE `berichten_sjabloon` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sjabloon` varchar(40) NOT NULL DEFAULT '',
  `sjabloon_msg` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `berichten_subject`
--

CREATE TABLE `berichten_subject` (
  `id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `subject` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `blocks`
--

CREATE TABLE `blocks` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `blockid` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bonus_punten`
--

CREATE TABLE `bonus_punten` (
  `id` int(10) UNSIGNED NOT NULL,
  `torrent_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sender_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `receiver_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ammount` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `bonus_punten`
--

INSERT INTO `bonus_punten` (`id`, `torrent_id`, `sender_id`, `receiver_id`, `added`, `ammount`) VALUES
(1, 2, 3, 3, '2021-04-21 16:10:54', 25),
(412, 44, 3, 3, '2021-07-14 11:13:04', 100),
(413, 45, 3, 3, '2021-07-14 11:13:04', 100),
(414, 46, 3, 3, '2021-07-14 11:13:04', 100),
(415, 47, 3, 3, '2021-07-14 11:13:04', 100),
(416, 48, 3, 3, '2021-07-14 11:13:04', 100),
(417, 49, 3, 3, '2021-07-14 11:13:04', 100),
(418, 50, 3, 3, '2021-07-14 11:13:04', 100),
(419, 52, 3, 3, '2021-07-14 11:13:04', 100),
(420, 53, 3, 3, '2021-07-14 11:13:04', 100),
(421, 54, 3, 3, '2021-07-14 11:13:04', 100),
(422, 55, 3, 3, '2021-07-14 11:13:04', 100),
(441, 76, 3, 3, '2021-07-14 11:13:04', 100),
(442, 78, 3, 3, '2021-07-14 11:13:04', 100),
(443, 80, 3, 3, '2021-07-14 11:13:04', 100),
(444, 81, 3, 3, '2021-07-14 11:13:04', 100),
(445, 83, 3, 3, '2021-07-14 11:13:04', 100),
(446, 84, 3, 3, '2021-07-14 11:13:04', 100),
(447, 85, 3, 3, '2021-07-14 11:13:04', 100),
(448, 86, 3, 3, '2021-07-14 11:13:04', 100),
(449, 87, 3, 3, '2021-07-14 11:13:04', 100),
(450, 88, 3, 3, '2021-07-14 11:13:04', 100),
(451, 89, 3, 3, '2021-07-14 11:13:04', 100),
(452, 90, 3, 3, '2021-07-14 11:13:04', 100),
(453, 91, 3, 3, '2021-07-14 11:13:04', 100),
(521, 184, 3, 3, '2021-07-14 11:13:04', 100);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `torrentid` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `volgorde` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `volgorde`) VALUES
(31, 'Ebooks', 'star.gif', 0),
(30, 'Windows', 'star.gif', 0),
(29, 'Apps', 'star.gif', 0),
(28, 'Kids', 'star.gif', 0),
(27, 'Series', 'star.gif', 0),
(26, 'Films', 'star.gif', 0),
(32, 'XXX', 'star.gif', 0),
(33, 'HD Films', 'star.gif', 0),
(34, 'HD Series', 'star.gif', 0),
(35, 'HD Kids', 'star.gif', 0),
(36, 'Games', 'star.gif', 0),
(37, 'Mac', 'star.gif', 0),
(38, 'Stripboeken', 'star.gif', 0),
(39, 'HD XXX', 'star.gif', 0),
(40, '4K Films', 'star.gif', 0),
(41, '4K Series', 'star.gif', 0),
(43, 'Linux', 'star.gif', 0),
(44, 'XXX Boeken', 'star.gif', 0),
(45, '4K XXX', 'star.gif', 0),
(46, 'Series Kids', 'star.gif', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `clients`
--

CREATE TABLE `clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client` varchar(32) NOT NULL DEFAULT '',
  `agentString` varchar(64) NOT NULL DEFAULT '',
  `freq` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `torrent` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` text NOT NULL,
  `ori_text` text NOT NULL,
  `editedby` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `editedat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `comments_uploader`
--

CREATE TABLE `comments_uploader` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `torrent` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` text NOT NULL,
  `editedby` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `editedat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `completed`
--

CREATE TABLE `completed` (
  `user` varchar(32) NOT NULL DEFAULT '',
  `torrent` int(11) NOT NULL DEFAULT 0,
  `added` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `counter_casino`
--

CREATE TABLE `counter_casino` (
  `id` int(10) UNSIGNED NOT NULL,
  `datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(10) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `flagpic` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `countries`
--

INSERT INTO `countries` (`id`, `name`, `flagpic`) VALUES
(1, 'Sweden', 'sweden.gif'),
(2, 'United States of America', 'usa.gif'),
(3, 'Russia', 'russia.gif'),
(4, 'Finland', 'finland.gif'),
(5, 'Canada', 'canada.gif'),
(6, 'France', 'france.gif'),
(7, 'Germany', 'germany.gif'),
(8, 'China', 'china.gif'),
(9, 'Italy', 'italy.gif'),
(10, 'Denmark', 'denmark.gif'),
(11, 'Norway', 'norway.gif'),
(12, 'United Kingdom', 'uk.gif'),
(13, 'Ireland', 'ireland.gif'),
(14, 'Poland', 'poland.gif'),
(15, 'Netherlands', 'netherlands.gif'),
(16, 'Belgium', 'belgium.gif'),
(17, 'Japan', 'japan.gif'),
(18, 'Brazil', 'brazil.gif'),
(19, 'Argentina', 'argentina.gif'),
(20, 'Australia', 'australia.gif'),
(21, 'New Zealand', 'newzealand.gif'),
(23, 'Spain', 'spain.gif'),
(24, 'Portugal', 'portugal.gif'),
(25, 'Mexico', 'mexico.gif'),
(26, 'Singapore', 'singapore.gif'),
(70, 'India', 'india.gif'),
(65, 'Albania', 'albania.gif'),
(29, 'South Africa', 'southafrica.gif'),
(30, 'South Korea', 'southkorea.gif'),
(31, 'Jamaica', 'jamaica.gif'),
(32, 'Luxembourg', 'luxembourg.gif'),
(33, 'Hong Kong', 'hongkong.gif'),
(34, 'Belize', 'belize.gif'),
(35, 'Algeria', 'algeria.gif'),
(36, 'Angola', 'angola.gif'),
(37, 'Austria', 'austria.gif'),
(38, 'Yugoslavia', 'yugoslavia.gif'),
(39, 'Western Samoa', 'westernsamoa.gif'),
(40, 'Malaysia', 'malaysia.gif'),
(41, 'Dominican Republic', 'dominicanrep.gif'),
(42, 'Greece', 'greece.gif'),
(43, 'Guatemala', 'guatemala.gif'),
(44, 'Israel', 'israel.gif'),
(45, 'Pakistan', 'pakistan.gif'),
(46, 'Czech Republic', 'czechrep.gif'),
(47, 'Serbia', 'serbia.gif'),
(48, 'Seychelles', 'seychelles.gif'),
(49, 'Taiwan', 'taiwan.gif'),
(50, 'Puerto Rico', 'puertorico.gif'),
(51, 'Chile', 'chile.gif'),
(52, 'Cuba', 'cuba.gif'),
(53, 'Congo', 'congo.gif'),
(54, 'Afghanistan', 'afghanistan.gif'),
(55, 'Turkey', 'turkey.gif'),
(56, 'Uzbekistan', 'uzbekistan.gif'),
(57, 'Switzerland', 'switzerland.gif'),
(58, 'Kiribati', 'kiribati.gif'),
(59, 'Philippines', 'philippines.gif'),
(60, 'Burkina Faso', 'burkinafaso.gif'),
(61, 'Nigeria', 'nigeria.gif'),
(62, 'Iceland', 'iceland.gif'),
(63, 'Nauru', 'nauru.gif'),
(64, 'Slovenia', 'slovenia.gif'),
(66, 'Turkmenistan', 'turkmenistan.gif'),
(67, 'Bosnia Herzegovina', 'bosniaherzegovina.gif'),
(68, 'Andorra', 'andorra.gif'),
(69, 'Lithuania', 'lithuania.gif'),
(71, 'Netherlands Antilles', 'nethantilles.gif'),
(72, 'Ukraine', 'ukraine.gif'),
(73, 'Venezuela', 'venezuela.gif'),
(74, 'Hungary', 'hungary.gif'),
(75, 'Romania', 'romania.gif'),
(76, 'Vanuatu', 'vanuatu.gif'),
(77, 'Vietnam', 'vietnam.gif'),
(78, 'Trinidad & Tobago', 'trinidadandtobago.gif'),
(79, 'Honduras', 'honduras.gif'),
(80, 'Kyrgyzstan', 'kyrgyzstan.gif'),
(81, 'Ecuador', 'ecuador.gif'),
(82, 'Bahamas', 'bahamas.gif'),
(83, 'Peru', 'peru.gif'),
(84, 'Cambodia', 'cambodia.gif'),
(85, 'Barbados', 'barbados.gif'),
(86, 'Bangladesh', 'bangladesh.gif'),
(87, 'Laos', 'laos.gif'),
(88, 'Uruguay', 'uruguay.gif'),
(89, 'Antigua Barbuda', 'antiguabarbuda.gif'),
(90, 'Paraguay', 'paraguay.gif'),
(93, 'Thailand', 'thailand.gif'),
(92, 'Union of Soviet Socialist Republics', 'ussr.gif'),
(94, 'Senegal', 'senegal.gif'),
(95, 'Togo', 'togo.gif'),
(96, 'North Korea', 'northkorea.gif'),
(97, 'Croatia', 'croatia.gif'),
(98, 'Estonia', 'estonia.gif'),
(99, 'Colombia', 'colombia.gif'),
(100, 'Lebanon', 'lebanon.gif'),
(101, 'Latvia', 'latvia.gif'),
(102, 'Costa Rica', 'costarica.gif'),
(103, 'Egypt', 'egypt.gif'),
(104, 'Bulgaria', 'bulgaria.gif'),
(105, 'Isla de Muerte', 'jollyroger.gif');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `credits`
--

CREATE TABLE `credits` (
  `id` int(10) UNSIGNED NOT NULL,
  `torrent_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sender_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `receiver_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ammount` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `credits`
--

INSERT INTO `credits` (`id`, `torrent_id`, `sender_id`, `receiver_id`, `added`, `ammount`) VALUES
(1, 37, 3, 11, '2021-07-14 16:41:59', 2),
(2, 38, 3, 11, '2021-07-14 16:41:59', 2),
(3, 44, 3, 3, '2021-07-14 16:41:59', 2),
(4, 45, 3, 3, '2021-07-14 16:41:59', 2),
(5, 46, 3, 3, '2021-07-14 16:41:59', 2),
(6, 47, 3, 3, '2021-07-14 16:41:59', 2),
(7, 48, 3, 3, '2021-07-14 16:41:59', 2),
(8, 49, 3, 3, '2021-07-14 16:41:59', 2),
(9, 50, 3, 3, '2021-07-14 16:41:59', 2),
(10, 52, 3, 3, '2021-07-14 16:41:59', 2),
(11, 53, 3, 3, '2021-07-14 16:41:59', 2),
(12, 54, 3, 3, '2021-07-14 16:41:59', 2),
(13, 55, 3, 3, '2021-07-14 16:41:59', 2),
(14, 56, 3, 11, '2021-07-14 16:41:59', 2),
(15, 57, 3, 11, '2021-07-14 16:41:59', 2),
(16, 58, 3, 11, '2021-07-14 16:41:59', 2),
(17, 59, 3, 11, '2021-07-14 16:41:59', 2),
(18, 60, 3, 11, '2021-07-14 16:41:59', 2),
(19, 62, 3, 11, '2021-07-14 16:41:59', 2),
(20, 63, 3, 11, '2021-07-14 16:41:59', 2),
(21, 64, 3, 11, '2021-07-14 16:41:59', 2),
(22, 65, 3, 11, '2021-07-14 16:41:59', 2),
(23, 66, 3, 11, '2021-07-14 16:41:59', 2),
(24, 67, 3, 11, '2021-07-14 16:41:59', 2),
(25, 68, 3, 11, '2021-07-14 16:41:59', 2),
(26, 69, 3, 11, '2021-07-14 16:41:59', 2),
(27, 70, 3, 11, '2021-07-14 16:41:59', 2),
(28, 71, 3, 11, '2021-07-14 16:41:59', 2),
(29, 72, 3, 11, '2021-07-14 16:41:59', 2),
(30, 73, 3, 11, '2021-07-14 16:41:59', 2),
(31, 75, 3, 11, '2021-07-14 16:41:59', 2),
(32, 76, 3, 3, '2021-07-14 16:41:59', 2),
(33, 78, 3, 3, '2021-07-14 16:41:59', 2),
(34, 80, 3, 3, '2021-07-14 16:41:59', 2),
(35, 81, 3, 3, '2021-07-14 16:41:59', 2),
(36, 83, 3, 3, '2021-07-14 16:41:59', 2),
(37, 84, 3, 3, '2021-07-14 16:41:59', 2),
(38, 85, 3, 3, '2021-07-14 16:41:59', 2),
(39, 86, 3, 3, '2021-07-14 16:41:59', 2),
(40, 87, 3, 3, '2021-07-14 16:41:59', 2),
(41, 88, 3, 3, '2021-07-14 16:41:59', 2),
(42, 89, 3, 3, '2021-07-14 16:41:59', 2),
(43, 90, 3, 3, '2021-07-14 16:41:59', 2),
(44, 91, 3, 3, '2021-07-14 16:41:59', 2),
(45, 92, 3, 11, '2021-07-14 16:41:59', 2),
(46, 93, 3, 11, '2021-07-14 16:41:59', 2),
(47, 94, 3, 11, '2021-07-14 16:41:59', 2),
(48, 95, 3, 11, '2021-07-14 16:41:59', 2),
(49, 96, 3, 11, '2021-07-14 16:41:59', 2),
(50, 97, 3, 11, '2021-07-14 16:41:59', 2),
(51, 98, 3, 11, '2021-07-14 16:41:59', 2),
(52, 99, 3, 11, '2021-07-14 16:41:59', 2),
(53, 100, 3, 11, '2021-07-14 16:41:59', 2),
(54, 101, 3, 11, '2021-07-14 16:41:59', 2),
(55, 102, 3, 11, '2021-07-14 16:41:59', 2),
(56, 104, 3, 11, '2021-07-14 16:41:59', 2),
(57, 105, 3, 11, '2021-07-14 16:41:59', 2),
(58, 106, 3, 11, '2021-07-14 16:41:59', 2),
(59, 107, 3, 11, '2021-07-14 16:41:59', 2),
(60, 108, 3, 11, '2021-07-14 16:41:59', 2),
(61, 109, 3, 11, '2021-07-14 16:41:59', 2),
(62, 110, 3, 11, '2021-07-14 16:41:59', 2),
(63, 112, 3, 11, '2021-07-14 16:41:59', 2),
(64, 113, 3, 11, '2021-07-14 16:41:59', 2),
(65, 114, 3, 11, '2021-07-14 16:41:59', 2),
(66, 115, 3, 11, '2021-07-14 16:41:59', 2),
(67, 116, 3, 11, '2021-07-14 16:41:59', 2),
(68, 117, 3, 11, '2021-07-14 16:41:59', 2),
(69, 118, 3, 11, '2021-07-14 16:41:59', 2),
(70, 119, 3, 11, '2021-07-14 16:41:59', 2),
(71, 120, 3, 11, '2021-07-14 16:41:59', 2),
(72, 122, 3, 11, '2021-07-14 16:41:59', 2),
(73, 123, 3, 11, '2021-07-14 16:41:59', 2),
(74, 126, 3, 11, '2021-07-14 16:41:59', 2),
(75, 127, 3, 11, '2021-07-14 16:41:59', 2),
(76, 128, 3, 11, '2021-07-14 16:41:59', 2),
(77, 130, 3, 11, '2021-07-14 16:41:59', 2),
(78, 131, 3, 11, '2021-07-14 16:41:59', 2),
(79, 133, 3, 11, '2021-07-14 16:41:59', 2),
(80, 134, 3, 11, '2021-07-14 16:41:59', 2),
(81, 135, 3, 11, '2021-07-14 16:41:59', 2),
(82, 136, 3, 11, '2021-07-14 16:41:59', 2),
(83, 137, 3, 11, '2021-07-14 16:41:59', 2),
(84, 138, 3, 11, '2021-07-14 16:41:59', 2),
(85, 140, 3, 11, '2021-07-14 16:41:59', 2),
(86, 141, 3, 11, '2021-07-14 16:41:59', 2),
(87, 142, 3, 11, '2021-07-14 16:41:59', 2),
(88, 143, 3, 11, '2021-07-14 16:41:59', 2),
(89, 146, 3, 11, '2021-07-14 16:41:59', 2),
(90, 149, 3, 11, '2021-07-14 16:41:59', 2),
(91, 150, 3, 11, '2021-07-14 16:41:59', 2),
(92, 152, 3, 11, '2021-07-14 16:41:59', 2),
(93, 153, 3, 11, '2021-07-14 16:41:59', 2),
(94, 154, 3, 11, '2021-07-14 16:41:59', 2),
(95, 155, 3, 11, '2021-07-14 16:41:59', 2),
(96, 156, 3, 11, '2021-07-14 16:41:59', 2),
(97, 157, 3, 11, '2021-07-14 16:41:59', 2),
(98, 159, 3, 11, '2021-07-14 16:41:59', 2),
(99, 160, 3, 11, '2021-07-14 16:41:59', 2),
(100, 161, 3, 11, '2021-07-14 16:41:59', 2),
(101, 162, 3, 11, '2021-07-14 16:41:59', 2),
(102, 163, 3, 11, '2021-07-14 16:41:59', 2),
(103, 168, 3, 11, '2021-07-14 16:41:59', 2),
(104, 171, 3, 11, '2021-07-14 16:41:59', 2),
(105, 173, 3, 11, '2021-07-14 16:41:59', 2),
(106, 175, 3, 11, '2021-07-14 16:41:59', 2),
(107, 178, 3, 11, '2021-07-14 16:41:59', 2),
(108, 179, 3, 11, '2021-07-14 16:41:59', 2),
(109, 180, 3, 11, '2021-07-14 16:41:59', 2),
(110, 182, 3, 11, '2021-07-14 16:41:59', 2),
(111, 183, 3, 11, '2021-07-14 16:41:59', 2),
(112, 184, 3, 3, '2021-07-14 16:41:59', 2),
(113, 185, 3, 11, '2021-07-14 16:41:59', 2),
(114, 186, 3, 11, '2021-07-14 16:41:59', 2),
(115, 187, 3, 11, '2021-07-14 16:41:59', 2),
(116, 188, 3, 11, '2021-07-14 16:41:59', 2),
(117, 189, 3, 11, '2021-07-14 16:41:59', 2),
(118, 190, 3, 11, '2021-07-14 16:41:59', 2),
(119, 191, 3, 11, '2021-07-14 16:41:59', 2),
(120, 192, 3, 11, '2021-07-14 16:41:59', 2),
(121, 193, 3, 11, '2021-07-14 16:41:59', 2),
(122, 194, 3, 11, '2021-07-14 16:41:59', 2),
(123, 206, 8, 8, '2021-07-20 21:56:59', 2),
(124, 213, 3, 11, '2021-07-21 19:04:31', 2),
(125, 214, 3, 11, '2021-07-21 19:04:31', 2),
(126, 215, 3, 11, '2021-07-21 19:04:31', 2),
(127, 216, 3, 11, '2021-07-21 19:04:31', 2),
(128, 217, 3, 11, '2021-07-21 19:04:31', 2),
(129, 218, 3, 11, '2021-07-21 19:04:31', 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `def_messages`
--

CREATE TABLE `def_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `comment` varchar(40) NOT NULL DEFAULT '',
  `message` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dlfsuinstelingen`
--

CREATE TABLE `dlfsuinstelingen` (
  `id` int(8) NOT NULL,
  `userip` int(2) NOT NULL DEFAULT 0,
  `loginsite` int(2) NOT NULL DEFAULT 0,
  `sitelog` int(2) NOT NULL DEFAULT 0,
  `searchcloud` int(2) NOT NULL DEFAULT 0,
  `reports` int(2) NOT NULL DEFAULT 0,
  `readposts` int(2) NOT NULL DEFAULT 0,
  `opschonen` int(2) NOT NULL DEFAULT 0,
  `berichttorrents` int(2) NOT NULL DEFAULT 0,
  `massaberichtmods` int(2) NOT NULL DEFAULT 0,
  `massaberichten` int(2) NOT NULL DEFAULT 0,
  `hits` int(2) NOT NULL DEFAULT 0,
  `helpdesk` int(2) NOT NULL DEFAULT 0,
  `bookmarks` int(2) NOT NULL DEFAULT 0,
  `donationsusers` int(2) NOT NULL DEFAULT 0,
  `shouts` int(2) NOT NULL DEFAULT 0,
  `verzoekjes` int(2) NOT NULL DEFAULT 0,
  `verzoekjesstemmen` int(2) NOT NULL DEFAULT 0,
  `warnings` int(2) NOT NULL DEFAULT 0,
  `warnnutorrent` int(2) NOT NULL DEFAULT 0,
  `warnpmgblast` int(2) NOT NULL DEFAULT 0,
  `warnpmseeding` int(2) NOT NULL DEFAULT 0,
  `warnpmtorrent` int(2) NOT NULL DEFAULT 0,
  `added` int(11) NOT NULL DEFAULT 0,
  `added_by` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `dlfsuinstelingen`
--

INSERT INTO `dlfsuinstelingen` (`id`, `userip`, `loginsite`, `sitelog`, `searchcloud`, `reports`, `readposts`, `opschonen`, `berichttorrents`, `massaberichtmods`, `massaberichten`, `hits`, `helpdesk`, `bookmarks`, `donationsusers`, `shouts`, `verzoekjes`, `verzoekjesstemmen`, `warnings`, `warnnutorrent`, `warnpmgblast`, `warnpmseeding`, `warnpmtorrent`, `added`, `added_by`) VALUES
(72, 31, 2, 2, 10, 10, 31, 10, 15, 10, 10, 31, 10, 10, 31, 0, 31, 31, 62, 31, 31, 31, 31, 2009, '6928');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donatieoverzicht`
--

CREATE TABLE `donatieoverzicht` (
  `id` int(10) NOT NULL,
  `userid` int(11) NOT NULL DEFAULT 0,
  `hoeveelheid` varchar(25) NOT NULL DEFAULT '',
  `methode` varchar(25) NOT NULL DEFAULT '',
  `datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donatie_ideal`
--

CREATE TABLE `donatie_ideal` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `nummer` varchar(10) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `verwerkt` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donatie_ideal_claim_msg`
--

CREATE TABLE `donatie_ideal_claim_msg` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `nummer` varchar(10) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `verwerkt` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donatie_ideal_del`
--

CREATE TABLE `donatie_ideal_del` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `nummer` varchar(10) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `verwerkt` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donatie_sms`
--

CREATE TABLE `donatie_sms` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `code` varchar(10) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `verwerkt` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donatie_sms_claim_msg`
--

CREATE TABLE `donatie_sms_claim_msg` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `code` varchar(10) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `verwerkt` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donatie_sms_del`
--

CREATE TABLE `donatie_sms_del` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `code` varchar(10) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `verwerkt` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donatie_telefoon`
--

CREATE TABLE `donatie_telefoon` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `code` varchar(10) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `verwerkt` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donatie_telefoon_claim_msg`
--

CREATE TABLE `donatie_telefoon_claim_msg` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `code` varchar(10) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `verwerkt` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donatie_telefoon_del`
--

CREATE TABLE `donatie_telefoon_del` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `code` varchar(10) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `verwerkt` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donatie_users`
--

CREATE TABLE `donatie_users` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `krediet` int(10) NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `code` varchar(12) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donations`
--

CREATE TABLE `donations` (
  `id` int(8) NOT NULL,
  `done` enum('yes','no') NOT NULL DEFAULT 'no',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `productid` int(8) NOT NULL DEFAULT 0,
  `accountname` varchar(50) NOT NULL DEFAULT '',
  `time` time NOT NULL DEFAULT '00:00:00',
  `phonenumber` varchar(12) NOT NULL DEFAULT '',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `pincode` varchar(15) NOT NULL DEFAULT '',
  `paytype` varchar(25) NOT NULL DEFAULT '',
  `currency` varchar(7) NOT NULL DEFAULT '',
  `revenue` varchar(25) NOT NULL DEFAULT '',
  `email` varchar(40) NOT NULL DEFAULT '',
  `ci` varchar(25) NOT NULL DEFAULT '',
  `validationcode` varchar(25) NOT NULL DEFAULT '',
  `ip_sender` varchar(20) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donations_claim`
--

CREATE TABLE `donations_claim` (
  `id` int(11) NOT NULL,
  `verwerkt` enum('yes','no') NOT NULL DEFAULT 'no',
  `user_id` int(11) NOT NULL DEFAULT 0,
  `naam` varchar(255) NOT NULL DEFAULT '',
  `rekening` varchar(50) NOT NULL DEFAULT '',
  `code` varchar(25) NOT NULL DEFAULT '',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donations_claim_del`
--

CREATE TABLE `donations_claim_del` (
  `id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `naam` varchar(40) NOT NULL DEFAULT '',
  `rekening` varchar(20) NOT NULL DEFAULT '',
  `code` varchar(10) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `kind` varchar(20) NOT NULL DEFAULT '',
  `verwerkt` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donations_claim_msg`
--

CREATE TABLE `donations_claim_msg` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `naam` varchar(40) NOT NULL DEFAULT '',
  `rekening` varchar(20) NOT NULL DEFAULT '',
  `code` varchar(10) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `kind` varchar(20) NOT NULL DEFAULT '',
  `verwerkt` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donations_email`
--

CREATE TABLE `donations_email` (
  `user_id` int(11) NOT NULL DEFAULT 0,
  `added` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donations_lotery`
--

CREATE TABLE `donations_lotery` (
  `id` int(10) UNSIGNED NOT NULL,
  `productid` varchar(80) NOT NULL DEFAULT '',
  `accountname` varchar(80) NOT NULL DEFAULT '',
  `time` varchar(80) NOT NULL DEFAULT '',
  `date` varchar(80) NOT NULL DEFAULT '',
  `ip` varchar(80) NOT NULL DEFAULT '',
  `pincode` varchar(80) NOT NULL DEFAULT '',
  `paytype` varchar(80) NOT NULL DEFAULT '',
  `currency` varchar(80) NOT NULL DEFAULT '',
  `revenue` varchar(80) NOT NULL DEFAULT '',
  `email` varchar(80) NOT NULL DEFAULT '',
  `validationcode` varchar(80) NOT NULL DEFAULT '',
  `phonenumber` varchar(80) NOT NULL DEFAULT '',
  `ci` varchar(80) NOT NULL DEFAULT '',
  `done` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donations_message`
--

CREATE TABLE `donations_message` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tijd` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donations_registratie`
--

CREATE TABLE `donations_registratie` (
  `id` int(8) NOT NULL,
  `done` enum('yes','no') NOT NULL DEFAULT 'no',
  `date` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `donations_users`
--

CREATE TABLE `donations_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `krediet` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pincode` varchar(80) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `donations_users`
--

INSERT INTO `donations_users` (`id`, `user_id`, `krediet`, `added`, `pincode`) VALUES
(1, 8, 48, '2021-06-17 23:34:33', 'Handmatig'),
(2, 8, 48, '2021-06-18 10:57:41', 'Handmatig'),
(3, 8, 48, '2021-06-18 10:57:52', 'Handmatig'),
(4, 8, 48, '2021-06-18 10:58:17', 'Handmatig'),
(5, 8, 48, '2021-06-18 10:58:27', 'Handmatig'),
(6, 10, 48, '2021-06-18 13:15:11', 'Handmatig'),
(7, 11, 48, '2021-06-18 23:53:37', 'Handmatig'),
(8, 8, 500, '2021-06-20 01:19:25', 'Handmatig'),
(9, 8, 500, '2021-06-20 18:06:29', 'Handmatig'),
(10, 11, 500, '2021-06-20 20:32:39', 'Handmatig'),
(11, 13, 500, '2021-06-24 14:59:23', 'Handmatig'),
(12, 13, 500, '2021-06-24 14:59:26', 'Handmatig'),
(13, 13, 500, '2021-06-24 14:59:28', 'Handmatig'),
(14, 13, 500, '2021-06-24 14:59:31', 'Handmatig'),
(15, 13, 500, '2021-06-24 14:59:33', 'Handmatig'),
(16, 13, 500, '2021-06-24 14:59:35', 'Handmatig'),
(17, 14, 500, '2021-06-24 22:22:08', 'Handmatig'),
(18, 14, 500, '2021-06-24 22:22:17', 'Handmatig'),
(19, 11, 500, '2021-06-24 23:30:02', 'Handmatig'),
(20, 11, 500, '2021-06-24 23:30:04', 'Handmatig'),
(21, 11, 500, '2021-06-24 23:30:07', 'Handmatig'),
(22, 11, 500, '2021-06-24 23:30:09', 'Handmatig'),
(23, 11, 500, '2021-06-24 23:30:11', 'Handmatig'),
(24, 11, 500, '2021-06-24 23:30:13', 'Handmatig'),
(25, 11, 500, '2021-06-24 23:30:16', 'Handmatig'),
(26, 11, 500, '2021-06-24 23:30:19', 'Handmatig'),
(27, 11, 500, '2021-06-24 23:30:22', 'Handmatig'),
(28, 11, 500, '2021-06-24 23:30:26', 'Handmatig'),
(29, 11, 500, '2021-06-24 23:30:28', 'Handmatig'),
(30, 11, 500, '2021-06-24 23:30:31', 'Handmatig'),
(31, 11, 500, '2021-06-24 23:30:34', 'Handmatig'),
(32, 11, 500, '2021-06-24 23:30:36', 'Handmatig'),
(33, 11, 500, '2021-06-24 23:30:38', 'Handmatig'),
(34, 11, 500, '2021-06-24 23:30:41', 'Handmatig'),
(35, 11, 500, '2021-07-05 13:01:55', 'Handmatig'),
(36, 8, 500, '2021-09-22 22:43:51', 'Handmatig'),
(37, 8, 500, '2021-09-30 16:55:14', 'Handmatig'),
(38, 8, 500, '2021-09-30 16:55:25', 'Handmatig'),
(39, 8, 500, '2021-09-30 16:55:32', 'Handmatig'),
(40, 5, 500, '2021-10-03 16:49:42', 'Handmatig'),
(41, 3, 100, '2021-11-14 23:39:17', 'Handmatig'),
(42, 3, 500, '2021-11-14 23:44:31', 'Handmatig'),
(43, 3, 500, '2021-11-14 23:44:38', 'Handmatig');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `doss_logboek`
--

CREATE TABLE `doss_logboek` (
  `ipnummer` char(255) NOT NULL,
  `serverload` int(2) NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `downloaded`
--

CREATE TABLE `downloaded` (
  `id` int(11) NOT NULL,
  `torrent` int(9) NOT NULL DEFAULT 0,
  `downloaded` bigint(25) NOT NULL DEFAULT 0,
  `uploaded` bigint(25) NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user` int(11) NOT NULL DEFAULT 0,
  `username` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `downtotals`
--

CREATE TABLE `downtotals` (
  `id` int(10) UNSIGNED NOT NULL,
  `torrent` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `uploaded` bigint(20) NOT NULL DEFAULT 0,
  `downloaded` bigint(20) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `downup`
--

CREATE TABLE `downup` (
  `id` int(9) NOT NULL,
  `torrent` int(11) NOT NULL DEFAULT 0,
  `user` int(11) NOT NULL DEFAULT 0,
  `uploaded` bigint(20) NOT NULL DEFAULT 0,
  `downloaded` bigint(20) NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastseen` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `username` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dox`
--

CREATE TABLE `dox` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` datetime DEFAULT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `filename` varchar(255) NOT NULL DEFAULT '',
  `size` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `uppedby` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `url` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `faq`
--

CREATE TABLE `faq` (
  `id` int(10) UNSIGNED NOT NULL,
  `volgorde` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `onderwerp` varchar(100) NOT NULL DEFAULT '',
  `inhoud` text DEFAULT NULL,
  `min_class` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `edit_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `edit_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `faq`
--

INSERT INTO `faq` (`id`, `volgorde`, `onderwerp`, `inhoud`, `min_class`, `edit_by`, `edit_date`) VALUES
(10, 1, 'FAQ', '[center][img]http://img143.imageshack.us/img143/8582/lijnfc5.gif[/img]\r\n\r\n[size=6][color=white]Welkom op Hots ReleaseS[/color][/size]\r\n\r\n[img]http://img143.imageshack.us/img143/8582/lijnfc5.gif[/img]\r\n[size=4][color=white]\r\nOns doel is om Gebruikers in de gelegenheid te stellen op een prettige manier hun bestanden met anderen te kunnen delen.\r\nIs dit ook iets voor u en hebt u de beschikking en/of de toegang tot leuke, bijzondere, allernieuwste of op andere manier interessante uitgaves van films, muziek, spellen, programma\'s enzovoort, twijfel dan niet maar meld u aan als Uploader op onze site.\r\n\r\nDit is een Prive-Site, u moet u dus eerst registeren voordat u volledige toegang krijgt.\r\nWij raden u aan eerst onze FAQ, onze Regels en ons Forum goed door te lezen voordat u begint op Hots ReleaseS.\r\n\r\nEr gelden slechts een paar Regels,\r\nmaar ze zijn er niet voor niets\r\nen wij hanteren ze ook consequent![/size]\r\n\r\n\r\n\r\n\r\n[size=6] >>>   Hot\'s FAQ   <<< [/size]\r\n\r\n\r\n[img]http://img143.imageshack.us/img143/8582/lijnfc5.gif[/img]\r\n\r\n[size=5]Algemene Info[/size]\r\n\r\n[img]http://img143.imageshack.us/img143/8582/lijnfc5.gif[/img]\r\n\r\n\r\n[size=4]Wat is een Torrent eigenlijk? Hoe krijg ik de bestanden?[/size][/color]\r\n\r\n[size=4][color=black]Kijk eens op  [url=http://www.btfaq.com/\"]Brian\'s BitTorrent FAQ and Guide[/url]  (deze site is in het Engels).\r\n[/color][/size]\r\n[color=white][size=4]Waar gaan mijn Donaties naartoe?[/size][/color]\r\n\r\n[color=black][size=4]Hots ReleaseS gebruikt de Donaties om de kosten van de site te betalen. Denk hierbij aan serverkosten, onderhoud, domeinregistratie, enz.\r\nHots ReleaseS is niet gemaakt om winsten te boeken. Breken er gouden tijden aan dan steunen wij:\r\n\r\n[img]http://img489.imageshack.us/img489/3039/zinloosgeweldfl1.jpg[/img]\r\n\r\n[url=http://www.zinloosgeweld.nl/]Geweld is te vaak zinloos, doe er wat aan! Landelijke Stichting Tegen Zinloos Geweld[/url]\r\n[/size][/color]\r\n[color=white][size=4]Waar kan ik een kopie vinden van de source code?[/size][/color]\r\n[color=black][size=4]Hiervoor verwijzen wij u naar TOF (Tracker Oprichtersforum). Wij geven op Hot\'s geen ondersteuning voor deze code, ook daarvoor kunt u op TOF terecht!\r\n[/size][/color]\r\n\r\n\r\n[img]http://img143.imageshack.us/img143/8582/lijnfc5.gif[/img]\r\n\r\n[size=5][color=white]Gebruikers Info[/color][/size][size=4]\r\n\r\n[img]http://img143.imageshack.us/img143/8582/lijnfc5.gif[/img]\r\n\r\n[color=white]\r\nIk heb een Account aangemaakt maar kreeg geen Bevestigingsmail!\r\n[/color][/size]\r\n[size=4][color=black]\r\nAls u een niet bestaand of onjuist Email-adres hebt opgegeven krijgt u geen Bevestiging en kunt u dus ook niet op onze Site. Registreer daarom alleen met een correct e-mailadres. Het kan zijn dat de mail is beland in uw Junk-mail, dus daar moet u even checken.\r\n- Opmerking:\r\nAls u de eerste keer g??n Bevestigingsmail hebt gekregen en het lukt ook een tweede keer niet, dan kunt u beter een ander e-mail adres proberen.\r\n[/color][/size][size=4][color=white]\r\nIk ben mijn Gebruikersnaam of Wachtwoord kwijt! Kunnen jullie het mij toezenden?\r\n[/color][/size][size=4][color=black]\r\nU kunt [url=http://www.hotsreleases.com/recover.php]deze link[/url] gebruiken, waarna u uw registratiegegevens via e-mail toegestuurd krijgt.\r\n[/color][/size][size=4][color=white]\r\nKunnen jullie mijn Gebruikersnaam veranderen?\r\n[/color][/size][size=4][color=black]\r\nDat kan, benader daarvoor een van onze Admin.\r\n[/color][/size][size=4][color=white]\r\nKunnen jullie mijn (bevestigd) Account verwijderen?\r\n[/color][/size][size=4][color=black]\r\nAls u een gegronde reden daarvoor heeft kan dat, benader daarvoor de Beheerder.\r\n[/color][/size][size=4][color=white]\r\nWat is MIJN Ratio?\r\n[/color][/size][size=4][color=black]\r\nHet is belangrijk om onderscheid te maken tussen uw Totale Ratio en de Individuele Ratio van iedere Torrent. \r\nDe Totale Ratio gaat over de totale upload en download van uw Account sinds u een Gebruiker bent van de Site. Deze vindt u in de linker bovenhoek van [url=http://www.hotsreleases.com/]het hoofmenu[/url] \r\nDe Individuele Ratio gaat over de waarden van iedere Torrent op zich. Dit Ratio is van belang voor de controle van Hit & Run op onze site. U vindt dit Ratio als u klikt op uw naam bovenaan in de linker bovenhoek van het hoofdmenu. U komt dan op de pagina met uw gebruikersgegevens waar getoond wordt welke Torrents u ontvangt of heeft ontvangen.\r\nIn de laatste kolom van de tabel staat het Ratio per Torrent vermeld.\r\n\r\nHet kan zijn dat je een symbool ziet ipv een getal. Dat symbool is de aanduiding voor Oneindig(Infinity) en dit betekend dat u 0 bytes hebt gedownload maar wel al iets geupload (ul/dl wordt oneindig). U leest het symbool als \'niet-beschikbaar\' en u ziet het dus alleen bij 0 bytes download/w?l upload (ul/dl = 0/0 wat onbepaald is).\r\n[/color][/size][size=4][color=white]\r\nIs mijn IP-adres zichtbaar op de site?\r\n[/color][/size][size=4][color=black]\r\nAlleen daartoe bevoegde staf kan dit zien. Andere gebruikers niet.\r\n[/color][/size][size=4][color=white]\r\nHelp! Ik kan niet inloggen!?\r\n[/color][/size][size=4][color=black]\r\nDit probleem komt soms voor met MicroSoft Internet Explorer. Sluit alle Internet Explorer vensters\r\nen open Extra - Internet Opties in het controlepaneel. Klik op \"verwijder Cookies\". U zou nu moeten kunnen inloggen. Een andere mogelijkheid is om een andere browser te gebruiken.\r\n[/color][/size][size=4][color=white]\r\nMijn IP adres is dynamisch. Moet ik ingelogd blijven?\r\n[/color][/size][size=4][color=black]\r\nDat hoeft niet. Alles wat u doet is ervoor zorgen dat u ingelogd bent met uw actuele\r\nIP wanneer u een Torrent-sessie start. Daarna, zelfs als uw IP veranderd tijdens die sessie, blijft het seeden of leechen doorgaan en de Statistieken zullen updaten zonder probleem.\r\n[/color][/size][size=4][color=white]\r\nWaarom ben ik niet verbindaar? (En waarom zou ik dat moeten betreuren?)\r\n[/color][/size][size=4][color=black]\r\nDe tracker heeft bepaald dat u firewalled of NATed bent en zodoende geen inkomende verbindingen kunt aannemen.\r\nDit betekend dat andere peers in de zwerm onmogelijk met u kunnen verbinden, alleen u met hen. Nog slechter,\r\nals twee peers beiden in deze situatie zijn zullen ze in geen geval verbinding kunnen maken met elkaar. Dit heeft duidelijk een nadelig\r\neffect op de globale snelheid.\r\nDe manier om dit probleem op te lossen is het openzetten van de poorten die gebruikt worden voor de binnenkomende verbindingen. U geeft hetzelfde bereik als in uw client door uw firewall en/of de instelling van uw NAT server een basisvorm van NAT te laten gebruiken voor dat gebied ipv NAPT (De feitelijke afstelling heeft een groot verschil tussen de verschillende routermodelen.\r\nRaadpleeg dus uw router documentatie. U kunt ook veel (engelstalige) informatie vinden over dit onderwerp op PortForward.com\r\n[/color][/size][size=4][color=white]\r\nWat zijn de verschillende gebruikersranks? En hoe werkt promovatie?\r\n[/color][/size][size=4][color=black]\r\n[b]Misbruiker[/b]\r\n-> Dit wordt u vanzelf als u ratio niet minimaal 1:1 bedraagd. Dit gebeurd automatisch door het systeem.\r\n\r\n[b]Gebruiker[/b]\r\n-> Dit is de standaard-rank voor nieuwe leden.\r\n\r\n[b]Top Gebruiker[/b]\r\n-> U bent minstens 1 week lid, heeft een Upload van minstens 25 GB en een ratio van meer als 1.05. Deze promotie gebeurd automatisch door het systeem en wordt teniet gedaan als uw ratio onder 0.975 daalt.\r\n\r\n[b]Donateur[/b]\r\n-> Dit wordt u door te doneren op onze site. Klik op Doneren voor meer informatie hierover.\r\n\r\n[b]Speciale Gebruiker[/b]\r\n-> Wordt toegekend door de Beheerder aan gebruikers waarvan hij/zij vindt dat ze een speciale bijdrage aan de site leveren/geleverd hebben. Zij die vragen worden bij voorbaat genegeerd.\r\n\r\n[b]Uploader[/b]\r\n-> Wordt toegekend door Administrators aan geschikte kandidaten die de Uploaderaanvraag verstuurd hebben. Bij interesse verzoeken wij eerst de voorwaarden door te nemen.\r\n\r\n[b]Moderator[/b]\r\n-> Wordt toegekend door de Beheerder. Heeft u interesse dan adviseren wij voor een beschrijving van deze rank de Regels door te nemen. Denkt u hieraan te kunnen voldoen neem dan contact op met de Beheerder\r\n\r\n[b]Administrator[/b]\r\n-> Wordt toegekend door de Beheerder. Vragen hiernaar heeft geen zin!\r\n\r\n[b]Beheerder[/b]\r\n-> Verantwoordelijk voor het reilen en zeilen op Hot\'s ReleaseS. \r\n[/color][/size][size=4][color=white]\r\nWaarom kan mijn vriend geen lid worden?\r\n[/color][/size][size=4][color=black]\r\nEr is een limiet van 15.000 leden. Wanneer dat aantal is bereikt stoppen we met het accepteren van nieuwe leden. Inactieve Accounts van meer dan 21 dagen worden automatisch verwijderd, blijf dus proberen.\r\nWij werken niet met reservering of een wachtlijst systeem, dus vraag daar ook niet om.\r\n[/color][/size][size=4][color=white]\r\nHoe kan ik een Avatar aan mijn Profiel toevoegen?\r\n[/color][/size][size=4][color=black]\r\nTen eerste, zoek een afbeelding die u leuk vind, en die binnen onze regels valt. \r\nDan gaat u naar [url=http://www.hotsreleases.com/my.php]uw Profiel[/url]. U kunt uw afbeelding uppen op onze server door te klikken op \"Avatar plaatsen op de Hots ReleaseS server\". Hoe dit in zijn werk gaat wijst zich vanzelf.\r\n[/color][/size]\r\n\r\n\r\n[img]http://img143.imageshack.us/img143/8582/lijnfc5.gif[/img]\r\n\r\n[size=5][color=white]Statistieken[/color][/size]\r\n\r\n[img]http://img143.imageshack.us/img143/8582/lijnfc5.gif[/img]\r\n\r\n[size=4][color=white]\r\nMeest voorkomende redenen waarom stats niet updaten zijn:\r\n[/color][/size][size=4][color=black]\r\nDe gebruiker speelt vals. Dit leidt onherroepelijk tot een [b]Ban[/b]\r\nDe server is overbelast en reageert niet. Probeer gewoon uw sessie open te houden totdat de server weer reageert (Het extra belasten van de server met herhaalde handmatige updates is niet aan te bevelen.)\r\nU gebruikt een slechte of Beta cli?nt. Als u een experimentele of CVS versie gebruikt doet u dat op eigen risico.\r\n[/color][/size][size=4][color=white]\r\nDe juiste manier\r\n[/color][/size][size=4][color=black]\r\nWanneer een Torrent die u momenteel leeched/seed niet in uw Profiel staat, wacht dan even totdat de Tracker de tijd heeft gehad de gegevens te updaten.\r\nZorg ervoor dat u uw cli?nt op de juiste wijze afsluit, zodat de Tracker de volgende melding ontvangt; \"event=completed\".\r\nAls de Tracker down is, stop dan vooral niet met seeden. Wanneer de Tracker weer online komt voordat u uw cli?nt sluit, moeten de stats weer correct ge-update worden.\r\n[/color][/size][size=4][color=white]\r\nMag ik elke BitTorrent cli?nt gebruiken?\r\n[/color][/size][size=4][color=black]\r\nJa. Wij accepteren in principe alle cli?nts. Klopt een Torrent niet dan wordt hij automatisch door ons systeem geweigerd. Bemerken wij dat een cli?nt niet funktioneerd met onze tracker dan behouden we ons het recht voor deze zonder pardon te bannen.\r\n[/color][/size][size=4][color=white]\r\nWaarom is een Torrent die ik aan het leechen/seeden ben een paar keer in mijn profiel te zien?\r\n[/color][/size][size=4][color=black]\r\nWanneer om welke reden dan ook (bijv. pc crash, of hangende cli?nt) uw cli?nt niet goed is afgesloten en u start hem opnieuw op, zal deze een nieuwe peer-id hebben, zodat het voor de Tracker op een nieuwe Torrent lijkt. De oude zal nooit meer de melding ontvangen \"event=completed\" of \"event=stopped\" en zal in de lijst blijven staan tot er een Tracker timeout komt. Gewoon negeren, uiteindelijk gaat het vanzelf weer weg.\r\n[/color][/size][size=4][color=white]\r\nIk ben klaar of stopte een Torrent. Waarom is deze toch nog te zien in mijn profiel?\r\n[/color][/size][size=4][color=black]\r\nSommige cli?nts, rapporteren niet correct aan de Tracker bij het stoppen van een Torrent.\r\nIn dat geval zal de Tracker blijven wachten op een bericht - en dus de Torrent in de lijst zetten als seeden of leechen - totdat er een timeout plaats vindt. Gewoon negeren, ook dit gaat vanzelf weer weg.\r\n[/color][/size][size=4][color=white]\r\nWaarom zie ik af en toe Torrents die ik niet leech in mijn profiel!?\r\n[/color][/size][size=4][color=black]\r\nWanneer een Torrent voor het eerst start,  gebruikt de Tracker het IP-adres om de gebruiker te identificeren en zal de Torrent geassocie?rd worden met de gebruiker die als laatste toegang had tot de site vanaf dat IP-adres. Als u uw IP-adres deelt (u zit achter NAT/ICS, of gebruikt een proxy), en sommige van die personen met wie u deelt zijn ook lid, dan kunt u af en toe hun Torrents in uw profiel vermeld zien. (Als zij een Torrent sessie van dat IP-adres starten en u was de laatste persoon die de site bezocht zal de Torrent geassocieerd worden met u). Kanttekening hierbij is dat wanneer Torrents in uw profiel vermeld worden, deze ook uw stats zullen verhogen.\r\nOm er zeker van te zijn dat uw Torrents te zien zijn in uw profiel, kunt u het beste de site bezoeken net voordat u een nieuwe sessie start.\r\n[/color][/size][size=4][color=white]\r\nMeerdere IPs (Kan ik inloggen vanaf verschillende computers?)\r\n[/color][/size][size=4][color=black]\r\nJa, de Tracker is in staat om sessies van verschillende IPs van dezelfde gebruiker te volgen. Een Torrent is geassocieerd met de gebruiker wanneer die start, en alleen op dat moment is het IP-adres relevant. Dus als u wilt seeden/leechen van computer A en computer B met dezelfde account kunt u van computer A toegang op de site hebben, start de Torrent daar, en daarna herhaalt u beide stappen vanaf computer B (dit is niet beperkt tot twee computers of tot een enkele Torrent, dit is alleen een simpel voorbeeld). U moet niet terug inloggen wanneer u de Torrent afsluit.\r\n[/color][/size][size=4][color=white]\r\nHoe past NAT/ICS in dit plaatje?\r\n[/color][/size][size=4][color=black]\r\nDit is een speciaal geval waarin alle computers in een LAN naar de buitenwereld gekend zijn als hebbende hetzelfde IP. We moeten onderscheid maken tussen twee gevallen:\r\n\r\n[b]1.[/b] U bent de enige Hots ReleaseS gebruiker in de LAN\r\n\r\nU moet hetzelfde Hots ReleaseS account gebruiken op alle computers.\r\nMerk op dat in het ICS geval u het best de BT client via de ICS gateway laat werken. BT Clients werkend op de andere PC\'s zullen onverbindbaar zijn (ze zullen zo vermeld worden, zoals elders uitgelegd in de FAQ) totdat u\r\ngeschikte services specifieerd in uw ICS configuratie (een goede uitleg hoe dit te doen voor Windows XP kunt u [url=http://www.microsoft.com/downloads/details.aspx?FamilyID=1dcff3ce-f50f-4a34-ae67-cac31ccd7bc9&amp;displaylang=en]hier[/url] vinden.\r\nIn het NAT geval zult u de verschillende bereiken van uw cli?nt moeten configureren op elke computer afzonderlijk en dan de juiste NAT regels toepassen in de router. (De details varieren hiervoor van router tot router en hiervoor kunt u het best de routerdocumentatie en/of support forum raadplegen.)\r\n\r\n[b]2.[/b] Er zijn meerdere Hots ReleaseS gebruikers in de LAN\r\n\r\nTot op heden is er nog geen work-around om dit altijd goed te laten werken met Hots ReleaseS.\r\nElke torrent zal geassocieerd worden met de gebruiker in de LAN die het laatst op de tracker is geweest voordat de torrent werd opgestart.\r\nTenzij de gebruikers iets overeenkomen kan het gebeuren dat stats gemixt worden.\r\n(Gebruiker A opent de site, download een .torrent file, maar start de torrent niet direkt.\r\nOndertussen, opent gebruiker B de site. Gebruiker A start dan pas de torrent. De torrent zal bijgeteld\r\nworden bij gebruiker B zijn stats, en niet bij gebruiker A.)\r\n\r\n\r\nHet is uw LAN, de verantwoordelijk ligt bij u. Vraag ons niet om andere gebruikers met hetzelfde IP te weren/bannen, want we doen dat niet. (Waarom zouden we [b]hem/haar[/b] bannen ipv [b]u[/b]?)\r\nVoor de geintresseerden onder u (De ontleding van een torrent sessie...) \r\nEnige a class=altlink href=\"anatomy.php\" info over de Anatomy of a torrent session\r\n[/color][/size]\r\n\r\n\r\n[img]http://img143.imageshack.us/img143/8582/lijnfc5.gif[/img]\r\n\r\n[size=5][color=white]Uploaden[/color][/size]\r\n\r\n[img]http://img143.imageshack.us/img143/8582/lijnfc5.gif[/img]\r\n\r\n[size=4][color=white]\r\nWaarom kan ik geen Torrents uploaden?\r\n[/color][/size]\r\n[size=4][color=black]\r\nAlleen [b]Uploaders[/b] hebben de mogelijkheid om Torrents te uploaden.\r\n[/color][/size]\r\n[size=4][color=white]\r\nHoe kan ik Uploader worden?\r\n[/color][/size]\r\n[size=4][color=black]\r\nKlik in de Menubalk op \"Uploader aanvraag\" en vul het daarop volgende vragenlijstje in. Klik daarna op \"verstuur uploader aanvraag\" en u krijgt vanzelf bericht van onze Staf.\r\n[/color][/size]\r\n[size=4][color=white]\r\nAan welke criteria moet ik voldoen om Uploader te kunnen worden?\r\n[/color][/size]\r\n[size=4][color=black]\r\nZie hiervoor onze voorwaarden onder Uploader worden.\r\n[/color][/size]\r\n[size=4][color=white]\r\nKan ik jullie Torrents uploaden naar andere Trackers?\r\n[/color][/size]\r\n[size=4][color=black]\r\nNee. Wij zijn een gesloten gemeenschap met een gelimiteerd aantal leden. Alleen geregistreerde gebruikers mogen de tracker gebruiken. Onze torrents posten op andere trackers is zinloos, omdat de meeste mensen die dat willen downloaden geen verbinding zullen kunnen maken met ons. Dit kan veel frustratie en slechte wil tot gevolg hebben tov ons hier op Hots ReleaseS, en dat tolereren we niet.\r\nKlachten van andere site admins over onze torrents die daar gepost worden zullen resulteren in uitsluiting van de verantwoordelijke gebruiker(s).\r\nOpmerking: de bestanden die u download via ons zijn van u en u kunt er dus mee doen wat u wilt. U kunt er altijd een andere torrent-file van maken, verwijzend naar een andere tracker, en het dan uploaden op een site van uw keuze.\r\n[/size][/color]\r\n\r\n\r\n[img]http://img143.imageshack.us/img143/8582/lijnfc5.gif[/img]\r\n\r\n[size=5][color=white]Downloaden[/color][/size]\r\n\r\n[img]http://img143.imageshack.us/img143/8582/lijnfc5.gif[/img]\r\n\r\n[size=4][color=white]\r\nHoe moet ik de files die ik gedownload heb gebruiken?\r\n[/color][/size]\r\n[size=4][color=black]\r\nLees de Handleiding Bestandformaten\r\n[/color][/size]\r\n[size=4][color=white]\r\nIk heb een film gedownload, maar weet niet wat CAM/TS/TC/SCR betekend.\r\n[/color][/size]\r\n[size=4][color=black]\r\nLees de Handleiding Extensies\r\n[/size][/color]\r\n[size=4][color=white]\r\nWaarom verdween plotseling een actieve Torrent?\r\n[/color][/size]\r\n[size=3][color=black]\r\nEr kunnen hiervoor drie redenen zijn:\r\n[b]1. [/b] De Torrent was niet in overeenstemming met onze Regels en daarom door een Staf-lid verwijderd.\r\n[b]2. [/b] De Staf heeft de Torrent verwijderd vanwege een verkeerde of niet werkende release. Deze wordt dan vervangen door een goede versie of u heeft ratio-correctie ontvangen.\r\n[b]3. [/b] Torrents worden automatisch verwijderd na 28 dagen.\r\n[/color][/size]\r\n[size=4][color=white]\r\nHoe herstart ik een (afgebroken) download of reseed ik iets?\r\n[/color][/size]\r\n[size=4][color=black]\r\nOpen de .Torrent file. Wanneer uw cli?nt naar een locatie vraagt, kies dan de locatie van\r\nde reeds gedownloade/aanwezige bestanden en de Torrent zal automatisch herstarten/reseeden.\r\n[/color][/size]\r\n[size=4][color=white]\r\nWaarom blijft mijn download op 99% staan?\r\n[/color][/size]\r\n[size=4][color=black]\r\nHoe meer delen u hebt, hoe moeilijker het word om peers te vinden die de delen hebben die u mist.\r\nDaarom is de download soms erg traag of staat zelfs stil ook al moet u nog maar een paar procent hebben.\r\nWees gewoon geduldig, en vroeg of laat zullen de resterende delen vanzelf binnenkomen.\r\n[/color][/size]\r\n[size=4][color=white]\r\nWat betekend de \"a piece has failed an hash check\" mededeling?\r\n[/color][/size]\r\n[size=4][color=black]\r\nBitTorrent cli?nts controleren de data die zij ontvangen op hun integriteit. Wanneer een deel deze controle niet doorstaat dan zal dat automatisch opnieuw gedownload worden. Hash fouten komen vaker voor, over deze fouten hoef u zich geen zorgen te maken.\r\n\r\nSommige cli?nts hebben een (uitgebreide) functie, die een naam heeft die ongeveer overeen komt met \'kick/ban cli?nts die u slechte data zenden\'. Wanneer u dit aanzet, zal een andere cli?nt die constant als peer slechte data aanlevert die niet door de hash-controle heenkomen in de toekomst worden genegeerd.\r\n[/color][/size]\r\n[size=4][color=white]\r\nEen Torrent is eigenlijk 100MB groot. Hoe komt het dat ik 120MB heb gedownload?\r\n[/color][/size]\r\n[size=4][color=black]\r\nLees de voorgaande sectie. Als u cli?nt foute/slechte data ontvangt zal die opnieuw gedownload worden, daarom\r\nzal de totale download groter zijn dan de Torrent grootte. Zorg er voor dat de \"kick/ban\" optie is aangezet\r\nom de extra download zoveel mogelijk te beperken.\r\n[/color][/size]\r\n[size=4][color=white]\r\nWaarom krijg ik de melding \"Not authorized (xx h) - READ THE FAQ!\" fout?\r\n[/color][/size]\r\n[size=4][color=black]\r\nVanaf het moment dat een [b]nieuwe[/b] Torrent is geupload naar de Tracker, is er een bepaalde periode waarbij nieuwe gebruikers en/of gebruikers met een slechte ratio een wachttijd hebben.\r\nDeze wachttijd heeft alleen maar effect op gebruikers met een lage ratio en gebruikers met een lage upload hoeveelheid.\r\n\r\nRatio onder 0.50 en/of upload onder 5.0GB -> vertraging 48u\r\n \r\nRatio onder 0.65 en/of upload onder 6.5GB -> vertraging 24u\r\n\r\nRatio onder 0.80 en/of upload onder 8.0GB -> vertraging 12u \r\n \r\nRatio onder 0.95 en/of upload onder 9.5GB -> vertraging 06u\r\n\r\n[b]En/of[/b] betekend een van de twee of beide. De vertraging zal de [b]grootste[/b] zijn van degene waaraan u [b]tenminste[/b] voldoet aan 1 voorwaarde.\r\nDit is ook van toepassing op nieuwe gebruikers dus een nieuwe account openen heeft geen zin. Merk ook op dat dit werkt op tracker niveau, u zal dus de .torrent file zelf ten allen tijden kunnen downloaden.\r\n[!--The delay applies only to leeching, not to seeding. If you got the files from any other source and\r\nwish to seed them you may do so at any time irrespectively of your ratio or total uploaded.\r\nN.B. Due to some users exploiting the \'no-delay-for-seeders\' policy we had to change it. The delay\r\nnow applies to both seeding and leeching. So if you are subject to a delay and get the files from\r\nsome other source you will not be able to seed them until the delay has elapsed.--]\r\n[/color][/size]\r\n[size=4][color=white]\r\nWaarom krijg ik \"rejected by tracker - Port xxxx is blacklisted\" fout?\r\n[/color][/size]\r\n[size=4][color=black]\r\nJe client rapporteert de tracker dat het de standaard bittorrent poort (6881-6889) gebruikt of een andere p2p poort voor de inkomende connecties.\r\n\r\nHots ReleaseS laat clients niet toe om van deze poorten gebruik te maken.\r\nDe eenvoudige reden is dat sommige ISP\'s deze poorten dichtknijpen.\r\n\r\nDe bijgevoegde lijst der geblokkeerde poorten is niet gelimiteerd en kan dus bij noodzaak uitgebreid worden:\r\n\r\nDirect Connect              411 - 413   \r\nKazaa/KazaaLite/KLR     1214\r\neDonkey                       4662\r\nGnutella                        6346 - 6347\r\nBitTorrent                     6881 - 6889\r\n \r\nAls je onze tracker wil gebruiken moet je dus je client configureren dat hij een poort(gebied) gebruikt dat niet in deze lijst staat (gebied tussen 49152 en 65535 heeft de voorkeur,\r\ncf. [url=http://www.iana.org/assignments/port-numbers]IANA[/url]. Merk op dat sommige, zoals Azureus 2.0.7.0 of hoger, een (1) enkele poort gebruiken voor al zijn torrents, terwijl de meeste andere een (1) poort per open torrent gebruiken.\r\nDit moet je in oogschouw nemen als je een gebied kiest (meestal minder dan 10 poorten groot. Je haalt geen voordeel door een groot gebied te kiezen, en dit kan eventueel wel een veiligheidsrisico inhouden).  \r\n\r\nDeze poorten worden gebruikt als verbinding tussen de peers , en niet van client naar tracker.\r\nDaarom zal deze wijziging geen invloed hebben op de bereikbaarheid van andere trackers(in feite zal\r\nhet zelfs de snelheid [b]verhogen[/b] van torrents van elke tracker, niet alleen onze). Je client zal ook nog steeds verbinding kunnen maken met peers die de standaardpoorten gebruiken.\r\nAls je client deze wijziging niet toelaat zul je een client moeten zoeken die dat wel doet.\r\n\r\nGelieve ons of in het forum niet te vragen welke poort te gebruiken. Hoe groter de diversiteit in gebruikte poorten des te moeilijker\r\nwordt het voor de ISPs om ons te snappen en zodus ook die poorten dicht te knijpen.\r\nAls we gewoon zelf een gebied definieren zullen de ISP\'s dat gebied snel dichtknijpen.\r\n\r\nAls je gebruik maakt van een router en/of firewall mag je niet vergeten de gekozen poorten hierin te openen\r\nof te forwarden (router). Zie de [b]\"Maak jezelf verbindbaar?\"[/b] sectie en aanwezige links voor meer informatie hieromtrend.\r\n[/color][/size]\r\n[size=4][color=white]\r\nWat is \"IOError - [Errno13] Permission denied\" fout?\r\n[/color][/size]\r\n[size=4][color=black]\r\nAls u alleen het probleem wil oplossen dan moet u uw PC rebooten.\r\nAnders moet u verder lezen.\r\n\r\nIOError betekend Input-Output Error, en het is een bestandssysteem fout, niet een tracker error.\r\nHet ontstaat als je client het torrent bestand niet of niet helemaal kan openen. De meest bekende reden is dat de client twee keer aanwezig is in taakbeheer.\r\nDe laastste keer dat de client was afgesloten, was deze niet volledig correct afgesloten, en is op de achtergrond verder gaan draaien.\r\nDoordat de andere client nog draait, is het bestand nog in gebruik door de eerste client.\r\n\r\nEen wat ongewonere reden kan een corrupte FAT partitie zijn. Een crash kan resulteren in corruptie van het gedeeltelijk gedownloade bestand, en daar komt de error vandaan. Scandisk draaien zou het moeten oplossen.\r\n(Let op: Dit gebeurt alleen als je Windows 9x hebt draaien - welke alleen support heeft voor FAT - of NT/2000/XP met FAT geformatteerde HD\'s. NTFS is meer robuust en zou dit probleem niet mogen hebben.)\r\n[/color][/size]\r\n[size=4][color=white]\r\nWat is \"TTL\" in de browse pagina?\r\n[/color][/size]\r\n[size=4][color=black]\r\nDe torrent\'s Time To Live, in uren. Dit betekend dat de torrent verwijderd zal worden van de tracker als deze tijd verstreken is (ja, ook als ie nog aktief is).\r\nMerk op dat dit de maximum waarde is, de torrent kan altijd verwijderd worden als ie niet meer aktief is.\r\n[/color][/size]\r\n[size=4][color=white]\r\nHoe kan ik mijn downloadsnelheid verbeteren?\r\n[/color][/size]\r\n[size=4][color=black]\r\nDe download snelheid is meestal afhankelijk van de seeder-to-leecher ratio (SLR). Trage download snelheden zijn meestal een probleem bij nieuwe en populaire torrents waardat de SLR laag is.\r\n\r\n(Kanttekening: Herinner je er zelf aan dat je trage downloadsnelheden niet leuk vond.\r\n[b]Seed[/b] zodat andere gebruikers deze pijn niet moeten ondergaan.)\r\n\r\nEr zijn een paar zaken die jezelf kan doen om een betere snelheid te bekomen:\r\n\r\n[b]Spring niet onmiddelijk op nieuwe torrents[/b]\r\n\r\nIn het bijzonder niet doen als je een langzame verbinding hebt. De beste snelheden worden gehaald als de TTL van een torrent in de helft is, dus wanneer de SLR het hoogst zal zijn. (Het nadeel is dat je niet meer zoveel kan seeden. Het is aan jou om de voor en nadelen tegen elkaar af te wegen.)\r\n\r\n[b]Maak jezelf verbindbaar[/b] \r\n\r\nZie de [b]\"Waarom ben ik vermeld als niet verbindbaar?\"[/b] sectie.\r\n\r\n\r\n[b]Limiteer je upload snelheid[/b]\r\n\r\nDe uploadsnelheid heeft op 2 manieren effekt op de download snelheid:\r\n\r\nBittorrent peers hebben de neiging om te uploaden aan diegene die ook naar hun upload. Dit betekend dat als A en B dezelfde torrent aan het downloaden zijn en A stuurt data naar B op hoge snelheid, B dit zo snel mogelijk probeert terug te doen. Dus door een hoge uploadsnelheid krijg je ook een hoge download snelheid.\r\nVanwege de manier waarop TCP werkt, wanneer A iets download van B moet A aan B blijven vertellen dat het data ontvangt dat wordt verzonden naar A. (Deze worden ook wel acknowledgements - ACKs - genoemd, een soort van \"ik heb het!\" berichtjes). Als A dit niet doet, dan zal B stoppen met verzenden en wachten.\r\nAls A aan het uploaden is met de maximale snelheid, dan kan er geen bandbreedte meer over zijn voor de ACKs en worden ze vertraagd. Dus door een te hoge upload wordt de download ook vertraagd.\r\n\r\nHet volledige effect is een combinatie van de twee. De upload moet zo hoog mogelijk gehouden worden, en je moet er tevens voor zorg te dragen dat de ACKs erdoor kunnen zonder vertraging. [b]Een goede vuistregel is om je upload op 80% van de theoretische uploadsnelheid te houden[/b]. Je moet een beetje uitproberen wat het beste werkt voor jou. (Onthoud dat je upload hoog instellen, goed is voor je totale ratio.)\r\n\r\nAls je meer dan een(1) client tegelijkertijd draait, dan moet je er rekening mee houden dat de upload verdeeld wordt over die clienten. Sommige clienten (b.v. Azureus) limiteren de globale upload snelheid, andere (b.v. Shad0w\'s) doen dit per torrent. Ken je client. Hetzelfde geldt als je je verbinding ook voor andere dingen gebruikt (b.v. surfen of ftp), denk altijd aan je totale upload snelheid.\r\n\r\n\r\n[b]Limiteer het aantal simultane verbindingen[/b]\r\n\r\nSommige OS (zoals Windows 9x) kunnen niet goed overweg met een groot aantal verbindingen, en kunnen zelfs crashen erdoor.\r\nOok sommige thuis routers (vooral wanneer NAT en/of firewall met packet inspecties wordt gebruikt) hebben de neiging om langzamer te worden of vast te lopen met teveel verbindingen.\r\nEr is geen goede waarde voor te geven, je kunt 60 of 100 proberen en experimenteren met de waardes. Let op dat deze nummers optellen, als je twee clienten hebt draaien, dan is dat dus twee keer zoveel connecties.\r\n\r\n[b]Limiteer het aantal simultane uploads[/b]\r\n\r\nIs dit niet hetzelfde als hierboven? Nee. De connectie limiet is het aantal peers waarmee je client tegelijkertijd kan communiceerd en/of van download.\r\nDe uploads limiet is het aantal peers waarmee je client daadwerkelijk mee communiceerd. Het ideale nummer is veelal lager dan het aantal connecties, en is afhankelijk van je (fysieke) internet verbinding.\r\n\r\n[b]Geef het een beetje tijd[/b]\r\n\r\nZoals al eerder uitgelegd verkiezen peers andere peers van wie ze data ontvangen. Wanneer je net begint met downloaden,\r\nheb je de andere peers niks te bieden, en zullen ze je negeren. Dit maakt het begin langzaam, zeker als er geen of weinig seeds zijn.\r\nDe snelheden zullen toenemen als je eenmaal wat stukjes aan te bieden hebt.\r\n\r\n[b]Waarom is het surfen zo traag gedurende het leechen?[/b]\r\n\r\nJe download snelheid is nooit oneindig. Als je een peer in een snelle torrent bent kan het dus zijn dat je tegen je downloadlimiet zit, waardoor je surfen de bandbreedte niet krijgt die het nodig heeft. Als je geen gebruik maakt van de nieuwste Azureus client (2.2.0.0) om de downloadsnelheid te limiteren zul je dus een andere oplossing moeten zoeken, zoals [url=http://www.netlimiter.com/]NetLimiter[/url].\r\nHet surfen werd gebruikt als voorbeeld, maar dit is ook van toepassing op gaming, IMing, enz...\r\n[/color][/size]\r\n[size=4][color=white]\r\nMijn ISP gebruikt een transparent proxy. Wat moet ik doen?\r\n[/color][/size]\r\n[size=4][color=black]\r\n[b]Dit is een grote complexe materie. Het is niet mogelijke om alle variaties te vernoemen.[/b]\r\n\r\nKort antwoord: verander naar een ISP dat geen proxies gebruikt. Als je dat niet kan of wil moet je verder lezen.\r\n\r\n[b]Wat is een proxy?[/b]\r\n\r\nIs in feite een tussenpersoon. Wanneer je een site browsed via een proxy zullen je aanvragen verstuurd worden naar die proxy\r\nwaarop deze die doorstuurd naar de site ipv je direkt te verbinden met die site. Er bestaan verschillende classificaties\r\n(deze terminologie is verre van standaard):\r\n\r\nTransparent\r\nEen transparente proxy heeft geen configuratie van de client. Hij stuurt alle poort 80 verkeer direkt naar de proxy. (Soms gebruikt als synoniem voor non-anonymous.)\r\n \r\nExpliciet/Vrijwillig\r\nClient moet zijn browser configureren om hem te kunnen gebruiken.\r\n \r\nAnoniem\r\nDe proxy verzend geen client identificatie naar de server. (HTTP_X_FORWARDED_FOR header wordt niet verzonden; de server ziet je IP niet.)\r\n \r\nSterk Anoniem\r\nDe proxy stuurt geen client identificatie en geen proxy indentificatie naar de server. (HTTP_X_FORWARDED_FOR, HTTP_VIA en HTTP_PROXY_CONNECTION headers worden niet verzonden; de server ziet jouw IP niet, en weet niet eens dat je een proxy gebruikt.)\r\n \r\nPublic (Zichzelf verklarend)\r\n\r\nEen transparent proxy kan anoniem of niet zijn, met een aantal graden van anonimiteit.\r\n\r\n[b]Hoe kan ik te weten komen of ik achter een (transparent/anonieme) proxy zit?[/b]\r\n\r\nProbeer [url=http://proxyjudge.org]ProxyJudge[/url]. Het geeft de HTTP headers die de server (waarop het loopt) ontvangt van jou. De relevante zijn HTTP_CLIENT_IP, HTTP_X_FORWARDED_FOR en REMOTE_ADDR.\r\n\r\n[b]Waarom sta ik vermeld als niet verbindbaar alhoewel ik niet NAT/Firewalled ben?[/b]\r\n\r\nDe tracker is redelijk goed in het vinden van jou echt IP, maar heeft hiervoor de proxy nodig om de HTTP header\r\nHTTP_X_FORWARDED_FOR te verzenden. Als jou ISP proxy dit niet doet dan zal de tracker het proxy IP interpreteren als zijnde het Client IP adres. Dit wil dus zeggen dat als je inlogt de tracker probeert te verbinden met jou client om te zien of je\r\nNAT/firewalled bent hij in feite zal proberen te verbinden met de proxy op de poort die je in je client geconfigureerd hebt voor inkomende connecties.\r\nNatuurlijk zal de proxy niet luisteren op deze poort, de verbinding zal misgaan en de tracker zal denken dat je NAT/firewalled bent.\r\n\r\n[b]Kan ik mijn ISP proxy bypassen?[/b]\r\n\r\nAls je ISP alleen HTTP verkeer via poort 80 toelaat of de gewone proxy poorten blokkeert dan zul je iets moeten gebruiken\r\nzoals [url=http://www.socks.permeo.com]socks[/url] en dit ligt buiten het bereik van deze FAQ.\r\nDe site laat ook connecties toe op poort 81 naast de gewone 80, en dit kan al genoeg zijn om sommige proxies te misleid. Dus het eerste dat je probeert is een verbinding proberen te maken met Hots ReleaseS.org. Merk wel op dat als dit werkt je bt client nog altijd gebruik maakt van poort 80 totdat je de announce url in de .torrent file aanpast.\r\nAnders mag je het volgende proberen:\r\nKies een publieke [b]niet-anonieme[/b] proxy dat [b]geen[/b] gebruik maakt van poort 80 (e.g. van [url=http://tools.rosinstrument.com/proxy/]deze[/url], [url=http://www.proxy4free.com/index.html]deze[/url] of         [url=http://www.samair.ru/proxy/]deze[/url] lijst).\r\nConfigureer je computer om die proxy te gebruiken. In Windows XP, doe [b]Start[/b], [b]Control Panel[/b], [b]Internet Options[/b], [b]Connections[/b], [b]LAN Settings[/b], [b]Use a Proxy server[/b], [b]Advanced[/b] en type het IP en poortnummer van je gekozen proxy. Of in Internet Explorer [b]Tools[/b], [b]Internet Options[/b], ...\r\n(Facultatief) Bezoek [url=http://proxyjudge.org/]ProxyJudge[/url]. Als je een HTTP_X_FORWARDED_FOR tegenkomt in de lijst gevolgd door je IP dan zal alles moeten werken, anders moet je een andere proxy kiezen en opnieuw proberen.\r\nBezoek Hots ReleaseS. Hopelijk zal de tracker nu je echt IP adres nemen (controleer je profiel om zeker te zijn).\r\nMerk op dat al je browsen nu via deze publieke proxy gaat ,welke meestal trager zijn.\r\nCommunicaties tussen de peers gebruiken poort 80 niet dus zal de snelheid niet aangetast worden, en in ieder geval beter dan wanneer je \"niet verbindbaar\" was.\r\n\r\n[b]Hoe kan ik mijn bittorrent client een proxy laten gebruiken?[/b]\r\n\r\nConfigureer Windows XP zoals hierboven beschreven. Als je een proxy insteld voor Internet Explorer stel je in feite een proxy in voor\r\nalle HTTP verkeer (bedank Microsoft en hun \"IE als deel van het OS politiek\" ). Aan de andere kant als je een andere\r\nbrowser (Opera/Mozilla/Firefox) gebruikt en een proxy insteld zal dit allen voor deze browser zijn. We weten niet van\r\neen BT client die toelaat om expliciet een proxy te specificeren.\r\n\r\n[b]Waarom kan ik me niet registreren achter een proxy?[/b]\r\n\r\nHet is onze politiek om geen nieuwe accounts toe te laten die geopend zijn achter een proxy.\r\n\r\n[b]Is dit van toepassing op andere torrent sites?[/b]\r\n\r\nDeze sectie werd geschreven voor Hots ReleaseS, een gesloten, poort 80-81 tracker. Andere trackers kunnen open of gesloten zijn, en luisteren misschien op b.v. poorten 6868 of 6969. Het bovenstaande is dus [b]niet[/b] noodzakelijk van toepassing op andere trackers.\r\n[/color][/size]\r\n[size=4][color=white]\r\nWaarom kan ik geen verbinding maken? Blokkeert de site mij?\r\n[/color][/size]\r\n[size=4][color=black]\r\nDeze verbindingsfout kan vele redenen hebben:\r\n\r\n[b]Misschien is mijn adres geblacklisted?[/b]\r\n\r\nDe site blokkeert adressen die voorkomen in de lijst van de (voormalige) [url=http://methlabs.org/]PeerGuardian[/url]\r\ndatabank, alsook deze van banned gebruikers. Dit werkt op Apache/PHP niveau, het is maar een script dat\r\n[b]aanmeldingen[/b] blokkeert van die adressen. Het stopt er u niet van om de site te bezoeken. Het zou zelfs mogelijk moeten zijn om de server te pingen/routetracen als u geblacklist bent. Als dit niet mogelijk is dan ligt het probleem ergens anders.\r\nAls uw adres inderdaad geblockt staat in de PG databank contacteer ons daar dan niet over, het ligt niet in onze lijn\r\nom hierover uitzonderingen te maken. In plaats daarvan kunt u best uw IP laten deblokkeren door de databank admins.\r\n\r\n[b]Uw ISP blokkeert het adres van de site[/b]\r\n\r\n(Eerst en vooral, is het onwaarschijnlijk dat uw ISP dit doet. Meestal ligt dit aan DNS name resolution en/of netwerk problemen.)\r\nHieraan kunnen wij niets doen.\r\nU zou uw ISP kunnen contacteren (of een nieuwe zoeken). Merk op dat u de site nog altijd kan bezoeken via een proxy, volg de instructies in het relevante FAQ onderdeel. In dit geval heeft het geen belang ofdat de proxy anoniem of niet is, of naar welke poort ie luisterd.\r\nMerk op dat u altijd als \"niet verbindbare\" client in de lijst zult staan omdat de tracker niet kan nagaan ofdat u in staat bent om inkomende verbindingen toe te staan.\r\n\r\n[b]Alternatieve poort (81)[/b]\r\n\r\nSommige van onze torrents gebruiken andere poorten dan de normale HTTP poort 80. Dit kan problemen geven bij sommige gebruikers, b.v. bij degene die achter een firewall of proxy zitten.\r\nDit kan je het best oplossen door de .torrent file zelf aan te passen met een torrent editor, b.v.\r\n[url=http://sourceforge.net/projects/burst/]MakeTorrent[/url],\r\nen de announce url  is http://www.HotsReleaseS.org/announce.php\r\nDe .torrent aanpassen met Notepad raden we af. Het kan er uit zien als een tekstbestand, maar het is in feite\r\neen bencoded bestand. Als je om een reden toch een plain text editor moet gebruiken, verander dan de announce url in\r\nhttp://www.HotsReleaseS/announce.php, en niet in http://www.HotsReleaseS (Als je eraan denkt om het nummer voor de announce url te veranderen, dan weet je teveel om dit te moeten lezen.)\r\n[/color][/size]\r\n[size=4][color=white]\r\nWat moet ik doen als ik hier geen antwoorden vind voor mijn probleem?\r\n[/color][/size]\r\n[size=4][color=black]\r\nVraag het dan eerst in de Forums. Je zal dit een vriendelijke en behulpzame\r\nplaats vinden, als je met het volgende rekening houdt:\r\n\r\nJe probleem mag niet in de FAQ staan. Het heeft geen nut een bericht te plaatsen als je toch terug naar hier gestuurd wordt.\r\nVoordat je post lees de sticky topics (die staan vanboven). Meestal kan je hier nieuwe informatie vinden die nog niet in de FAQ staan.\r\nHelp ons u te helpen. Zeg niet gewoon \"het werkt niet!\". Geef ons alle nuttige details zodat we geen tijd verliezen\r\nmet ze u te vragen. Welke client gebruik je? Welk OS? Wat is je netwerk setup? Welke is het volledige fout bericht\r\ndat je krijgt? Welke zijn de torrents waar je problemen mee hebt? Des te meer u ons vertelt des te makkelijker het is\r\nvoor ons, en des te waarschijnlijker dat u een antwoord krijgt.\r\nEn onnodig te vertellen: wees vriendelijk. Hulp eisen zal niet werken, er om vragen zal dat meestal wel doen.\r\n[/color][/size]\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nNog in bewerking :wink:\r\n[/center]', 0, 2, '2008-02-01 18:09:30');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `files`
--

CREATE TABLE `files` (
  `id` int(10) UNSIGNED NOT NULL,
  `torrent` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `filename` varchar(255) NOT NULL DEFAULT '',
  `size` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `forums`
--

CREATE TABLE `forums` (
  `sort` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL DEFAULT '',
  `description` varchar(200) DEFAULT NULL,
  `minclassread` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `minclasswrite` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `postcount` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `topiccount` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `minclasscreate` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `forums`
--

INSERT INTO `forums` (`sort`, `id`, `name`, `description`, `minclassread`, `minclasswrite`, `postcount`, `topiccount`, `minclasscreate`) VALUES
(4, 3, 'VERWACHT', 'Verwachte ReleaseS op de site', 0, 3, 0, 0, 3),
(5, 4, 'Welkom Nieuwe Gebruikers !', 'Belangrijke Info voor Nieuwe Gebruikers', 0, 0, 0, 0, 4),
(6, 5, 'Gebruikers Info', 'Over wat verder belangrijk is om te weten', 0, 0, 0, 0, 4),
(1, 17, 'Staf', 'Algemene Mededelingen Gehele Staf', 4, 4, 0, 0, 4),
(8, 7, 'Cafe', 'Voor de nodige ontspanning', 0, 0, 0, 0, 4),
(7, 8, 'Offline, Wie en Wanneer', 'Vermeld hier als je Offline gaat/moet', 0, 0, 0, 0, 0),
(7, 9, 'Problemen ?', 'Lees eerst Regels, FAQ en Forum voor je vragen stelt', 0, 0, 0, 0, 0),
(9, 10, 'HANDLEIDINGEN', 'Over Verbindbaar zijn, Cli?nten enzovoorts', 0, 0, 0, 2, 4),
(11, 11, 'TIPS PC', 'Weetjes en Handigheidjes voor je PC', 0, 0, 0, 0, 0),
(10, 12, 'Freeware', 'Leuke gratis Proggies', 0, 0, 0, 0, 0),
(0, 13, 'Code', 'Spreekt voor zich', 7, 7, 0, 0, 7),
(2, 14, 'Moderators', 'Info', 4, 4, 0, 0, 4),
(3, 15, 'Administrators', 'Info', 5, 5, 0, 0, 5),
(2, 16, 'Uploaders', 'Info', 3, 3, 0, 0, 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `friends`
--

CREATE TABLE `friends` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `friendid` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `friends`
--

INSERT INTO `friends` (`id`, `userid`, `friendid`) VALUES
(1, 24, 25),
(2, 25, 24),
(3, 330, 1),
(4, 4, 337),
(5, 1440, 241),
(6, 2380, 24),
(8, 2380, 25),
(9, 209, 2),
(10, 2270, 2),
(11, 2231, 2),
(12, 2231, 2678),
(14, 7, 8),
(16, 8, 3),
(18, 10, 8),
(21, 11, 3),
(22, 11, 8),
(25, 300, 8);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `giro`
--

CREATE TABLE `giro` (
  `id` int(8) NOT NULL,
  `added` int(11) NOT NULL DEFAULT 0,
  `locatie` varchar(12) NOT NULL DEFAULT '',
  `verwerkt` enum('Ja','Nee') NOT NULL DEFAULT 'Nee',
  `tegenrekening` varchar(15) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `helpdesk`
--

CREATE TABLE `helpdesk` (
  `id` int(10) UNSIGNED NOT NULL,
  `closed` enum('yes','no') NOT NULL DEFAULT 'no',
  `message` varchar(255) NOT NULL DEFAULT '',
  `ticket` int(15) NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `read_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `userid` int(11) NOT NULL DEFAULT 0,
  `edit_by` int(11) NOT NULL DEFAULT 0,
  `edit_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_attachments`
--

CREATE TABLE `hesk_attachments` (
  `att_id` mediumint(8) UNSIGNED NOT NULL,
  `ticket_id` varchar(13) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `saved_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `real_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `size` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `type` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `hesk_attachments`
--

INSERT INTO `hesk_attachments` (`att_id`, `ticket_id`, `saved_name`, `real_name`, `size`, `type`) VALUES
(1, 'RYY-8N6-7XA6', 'RYY-8N6-7XA6_d833e3816b8ff46ffe0cabc05523fb39.png', 'afbeelding_2021-05-02_142952.png', 569408, '1');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_banned_emails`
--

CREATE TABLE `hesk_banned_emails` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `banned_by` smallint(5) UNSIGNED NOT NULL,
  `dt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_banned_ips`
--

CREATE TABLE `hesk_banned_ips` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `ip_from` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `ip_to` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `ip_display` varchar(100) NOT NULL,
  `banned_by` smallint(5) UNSIGNED NOT NULL,
  `dt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_categories`
--

CREATE TABLE `hesk_categories` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cat_order` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `autoassign` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `type` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `priority` enum('0','1','2','3') COLLATE utf8_unicode_ci NOT NULL DEFAULT '3'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `hesk_categories`
--

INSERT INTO `hesk_categories` (`id`, `name`, `cat_order`, `autoassign`, `type`, `priority`) VALUES
(1, 'General', 10, '1', '0', '3');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_custom_fields`
--

CREATE TABLE `hesk_custom_fields` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `use` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `place` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text',
  `req` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `category` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `order` smallint(5) UNSIGNED NOT NULL DEFAULT 10
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `hesk_custom_fields`
--

INSERT INTO `hesk_custom_fields` (`id`, `use`, `place`, `type`, `req`, `category`, `name`, `value`, `order`) VALUES
(1, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(2, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(3, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(4, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(5, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(6, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(7, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(8, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(9, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(10, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(11, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(12, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(13, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(14, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(15, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(16, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(17, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(18, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(19, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(20, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(21, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(22, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(23, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(24, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(25, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(26, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(27, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(28, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(29, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(30, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(31, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(32, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(33, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(34, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(35, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(36, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(37, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(38, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(39, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(40, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(41, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(42, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(43, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(44, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(45, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(46, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(47, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(48, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(49, '0', '0', 'text', '0', NULL, '', NULL, 1000),
(50, '0', '0', 'text', '0', NULL, '', NULL, 1000);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_custom_statuses`
--

CREATE TABLE `hesk_custom_statuses` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `can_customers_change` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `order` smallint(5) UNSIGNED NOT NULL DEFAULT 10
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_kb_articles`
--

CREATE TABLE `hesk_kb_articles` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `catid` smallint(5) UNSIGNED NOT NULL,
  `dt` timestamp NOT NULL DEFAULT current_timestamp(),
  `author` smallint(5) UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `keywords` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `rating` float NOT NULL DEFAULT 0,
  `votes` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `views` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `type` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `html` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sticky` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `art_order` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `history` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `attachments` mediumtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_kb_attachments`
--

CREATE TABLE `hesk_kb_attachments` (
  `att_id` mediumint(8) UNSIGNED NOT NULL,
  `saved_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `real_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `size` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_kb_categories`
--

CREATE TABLE `hesk_kb_categories` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent` smallint(5) UNSIGNED NOT NULL,
  `articles` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `articles_private` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `articles_draft` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `cat_order` smallint(5) UNSIGNED NOT NULL,
  `type` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `hesk_kb_categories`
--

INSERT INTO `hesk_kb_categories` (`id`, `name`, `parent`, `articles`, `articles_private`, `articles_draft`, `cat_order`, `type`) VALUES
(1, 'Knowledgebase', 0, 0, 0, 0, 10, '0');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_logins`
--

CREATE TABLE `hesk_logins` (
  `ip` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `number` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `last_attempt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_log_overdue`
--

CREATE TABLE `hesk_log_overdue` (
  `id` int(10) UNSIGNED NOT NULL,
  `dt` timestamp NOT NULL DEFAULT current_timestamp(),
  `ticket` mediumint(8) UNSIGNED NOT NULL,
  `category` smallint(5) UNSIGNED NOT NULL,
  `priority` enum('0','1','2','3') COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `owner` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `due_date` timestamp NOT NULL DEFAULT '1999-12-31 23:00:00',
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_mail`
--

CREATE TABLE `hesk_mail` (
  `id` int(10) UNSIGNED NOT NULL,
  `from` smallint(5) UNSIGNED NOT NULL,
  `to` smallint(5) UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `dt` timestamp NOT NULL DEFAULT current_timestamp(),
  `read` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `deletedby` smallint(5) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `hesk_mail`
--

INSERT INTO `hesk_mail` (`id`, `from`, `to`, `subject`, `message`, `dt`, `read`, `deletedby`) VALUES
(1, 9999, 1, 'HESK quick start guide', '</p><div style=\"text-align:justify; padding-left: 10px; padding-right: 10px;\">\r\n\r\n<p>&nbsp;<br /><b>Welcome to HESK! You\'ll find it is a great tool for improving your customer support.</b></p>\r\n\r\n<p><b>Here is a short guide to get you started.</b><br />&nbsp;</p>\r\n\r\n<hr />\r\nSTEP #1: set up your profile\r\n<hr />\r\n<ol>\r\n<li>go to <a href=\"profile.php\">Profile</a>,</li>\r\n<li>set your name and email address.</li>\r\n</ol>\r\n\r\n&nbsp;\r\n\r\n<hr />\r\nSTEP #2: configure HESK\r\n<hr />\r\n<ol>\r\n<li>go to <a href=\"admin_settings_general.php\">Settings</a>,</li>\r\n<li>for a quick start, just modify these on the \"General\" tab:<br /><br />\r\nWebsite title<br />\r\nWebsite URL<br />\r\nWebmaster email<br />&nbsp;\r\n</li>\r\n<li>you can come back to the settings page later and explore all the options. To view details about a setting, click the [?]</li>\r\n</ol>\r\n\r\n&nbsp;\r\n\r\n<hr />\r\nSTEP #3: add ticket categories\r\n<hr />\r\n<p>Go to <a href=\"manage_categories.php\">Categories</a> to add ticket categories.</p>\r\n<p>You cannot delete the default category, but you can rename it.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<hr />\r\nSTEP #4: add staff accounts\r\n<hr />\r\n<p>Go to <a href=\"manage_users.php\">Team</a> to create new staff accounts.</p>\r\n<p>You can use two user types in HESK:</p>\r\n<ul>\r\n<li><b>Administrators</b>, who have full access to all HESK features</li>\r\n<li><b>Staff</b>, who have access to limited privileges and categories</li>\r\n</ul>\r\n\r\n&nbsp;\r\n\r\n<hr />\r\nSTEP #5: useful tools\r\n<hr />\r\n<p>You can do a lot on the <a href=\"banned_emails.php\">Tools</a> page, for example:</p>\r\n<ul>\r\n<li>create custom ticket statuses,</li>\r\n<li>add custom input fields to the \"Submit a ticket\" form,</li>\r\n<li>modify email templates,</li>\r\n<li>and more.</li>\r\n</ul>\r\n\r\n&nbsp;\r\n\r\n<hr />\r\nSTEP #6: create a knowledgebase\r\n<hr />\r\n<p>A clear and comprehensive knowledgebase can drastically reduce the number of support tickets you receive, thereby saving you significant time and effort in the long run.</p>\r\n<p>Go to <a href=\"manage_knowledgebase.php\">Knowledgebase</a> to create categories and write articles for your knowledgebase.</p>\r\n\r\n&nbsp;\r\n\r\n<hr />\r\nSTEP #7: don\'t repeat yourself\r\n<hr />\r\n<p>Sometimes several support tickets are addressing the same issues - allowing you to use pre-written (&quot;canned&quot;) responses.</p>\r\n<p>To compose canned responses go to <a href=\"manage_canned.php\">Canned</a> page.</p>\r\n\r\n&nbsp;\r\n\r\n<hr />\r\nSTEP #8: secure your help desk\r\n<hr />\r\n<p>Make sure your help desk is as secure as possible by going through <a href=\"https://www.hesk.com/knowledgebase/?article=82\">HESK security check list</a></p>\r\n\r\n&nbsp;\r\n\r\n<hr />\r\nSTEP #9: stay updated\r\n<hr />\r\n<p>HESK regularly receives improvements and bug fixes; make sure you know about them!</p>\r\n<ul>\r\n<li>for fast notifications, <a href=\"https://twitter.com/HESKdotCOM\">follow us on <b>Twitter</b></a></li>\r\n<li>for email notifications, subscribe to our low-volume zero-spam <a href=\"https://www.hesk.com/newsletter.php\">newsletter</a></li>\r\n</ul>\r\n\r\n&nbsp;\r\n\r\n<hr />\r\nSTEP #10: look professional\r\n<hr />\r\n<p>To look more professional and not advertise the tools you use, <a href=\"https://www.hesk.com/buy.php\">remove &quot;Powered by&quot; links</a> from your help desk.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Again, welcome to HESK and enjoy using it!</p>\r\n\r\n<p>Klemen<br />\r\n<a href=\"https://www.hesk.com\">https://www.hesk.com</a></p>\r\n\r\n</div><p>', '2021-05-02 11:21:02', '1', 9999);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_notes`
--

CREATE TABLE `hesk_notes` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `ticket` mediumint(8) UNSIGNED NOT NULL,
  `who` smallint(5) UNSIGNED NOT NULL,
  `dt` timestamp NOT NULL DEFAULT current_timestamp(),
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `attachments` mediumtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `hesk_notes`
--

INSERT INTO `hesk_notes` (`id`, `ticket`, `who`, `dt`, `message`, `attachments`) VALUES
(1, 1, 1, '2021-05-02 12:30:03', 'lol', '1#afbeelding_2021-05-02_142952.png,');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_online`
--

CREATE TABLE `hesk_online` (
  `user_id` smallint(5) UNSIGNED NOT NULL,
  `dt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tmp` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_pipe_loops`
--

CREATE TABLE `hesk_pipe_loops` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hits` smallint(1) UNSIGNED NOT NULL DEFAULT 0,
  `message_hash` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `dt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_replies`
--

CREATE TABLE `hesk_replies` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `replyto` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `message_html` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `dt` timestamp NOT NULL DEFAULT current_timestamp(),
  `attachments` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `staffid` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `rating` enum('1','5') COLLATE utf8_unicode_ci DEFAULT NULL,
  `read` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `hesk_replies`
--

INSERT INTO `hesk_replies` (`id`, `replyto`, `name`, `message`, `message_html`, `dt`, `attachments`, `staffid`, `rating`, `read`) VALUES
(1, 1, 'Mr.First', 'welke test lol', 'welke test lol', '2021-05-02 12:29:26', '', 1, NULL, '0');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_reply_drafts`
--

CREATE TABLE `hesk_reply_drafts` (
  `owner` smallint(5) UNSIGNED NOT NULL,
  `ticket` mediumint(8) UNSIGNED NOT NULL,
  `message` mediumtext CHARACTER SET utf8 NOT NULL,
  `message_html` mediumtext CHARACTER SET utf8 DEFAULT NULL,
  `dt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_reset_password`
--

CREATE TABLE `hesk_reset_password` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `user` smallint(5) UNSIGNED NOT NULL,
  `hash` char(40) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `dt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_service_messages`
--

CREATE TABLE `hesk_service_messages` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `dt` timestamp NOT NULL DEFAULT current_timestamp(),
  `author` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `style` enum('0','1','2','3','4') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `type` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `order` smallint(5) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_std_replies`
--

CREATE TABLE `hesk_std_replies` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `message_html` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `reply_order` smallint(5) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_tickets`
--

CREATE TABLE `hesk_tickets` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `trackid` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(1000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `category` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `priority` enum('0','1','2','3') COLLATE utf8_unicode_ci NOT NULL DEFAULT '3',
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `message_html` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `dt` timestamp NOT NULL DEFAULT '1999-12-31 23:00:00',
  `lastchange` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `firstreply` timestamp NULL DEFAULT NULL,
  `closedat` timestamp NULL DEFAULT NULL,
  `articles` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `language` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `openedby` mediumint(8) DEFAULT 0,
  `firstreplyby` smallint(5) UNSIGNED DEFAULT NULL,
  `closedby` mediumint(8) DEFAULT NULL,
  `replies` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `staffreplies` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `owner` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `assignedby` mediumint(8) DEFAULT NULL,
  `time_worked` time NOT NULL DEFAULT '00:00:00',
  `lastreplier` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `replierid` smallint(5) UNSIGNED DEFAULT NULL,
  `archive` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `locked` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `attachments` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `merged` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `history` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom1` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom2` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom3` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom4` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom5` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom6` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom7` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom8` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom9` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom10` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom11` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom12` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom13` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom14` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom15` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom16` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom17` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom18` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom19` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom20` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom21` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom22` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom23` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom24` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom25` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom26` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom27` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom28` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom29` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom30` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom31` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom32` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom33` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom34` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom35` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom36` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom37` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom38` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom39` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom40` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom41` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom42` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom43` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom44` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom45` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom46` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom47` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom48` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom49` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom50` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  `overdue_email_sent` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `hesk_tickets`
--

INSERT INTO `hesk_tickets` (`id`, `trackid`, `name`, `email`, `category`, `priority`, `subject`, `message`, `message_html`, `dt`, `lastchange`, `firstreply`, `closedat`, `articles`, `ip`, `language`, `status`, `openedby`, `firstreplyby`, `closedby`, `replies`, `staffreplies`, `owner`, `assignedby`, `time_worked`, `lastreplier`, `replierid`, `archive`, `locked`, `attachments`, `merged`, `history`, `custom1`, `custom2`, `custom3`, `custom4`, `custom5`, `custom6`, `custom7`, `custom8`, `custom9`, `custom10`, `custom11`, `custom12`, `custom13`, `custom14`, `custom15`, `custom16`, `custom17`, `custom18`, `custom19`, `custom20`, `custom21`, `custom22`, `custom23`, `custom24`, `custom25`, `custom26`, `custom27`, `custom28`, `custom29`, `custom30`, `custom31`, `custom32`, `custom33`, `custom34`, `custom35`, `custom36`, `custom37`, `custom38`, `custom39`, `custom40`, `custom41`, `custom42`, `custom43`, `custom44`, `custom45`, `custom46`, `custom47`, `custom48`, `custom49`, `custom50`, `due_date`, `overdue_email_sent`) VALUES
(1, 'RYY-8N6-7XA6', 'zomaar', 'nep@mail.org', 1, '1', 'test2 lol', 'dit is een test', 'dit is een test', '2021-05-02 12:27:06', '2021-05-14 10:26:45', '2021-05-02 12:29:26', NULL, NULL, '86.84.198.16', NULL, 2, 1, 1, NULL, 1, 1, 1, 1, '00:02:19', '1', 1, '0', '0', '', '', '<li class=\"smaller\">2021-05-02 12:27:06 | ticket created by Mr.First (Mr.First)</li><li class=\"smaller\">2021-05-02 12:27:06 | assigned to Mr.First (Mr.First) by Mr.First (Mr.First)</li><li class=\"smaller\">2021-05-14 10:26:45 | priority changed to High by Mr.First (Mr.First)</li>', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_ticket_templates`
--

CREATE TABLE `hesk_ticket_templates` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `message_html` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `tpl_order` smallint(5) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hesk_users`
--

CREATE TABLE `hesk_users` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `user` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pass` char(40) COLLATE utf8_unicode_ci NOT NULL,
  `isadmin` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `signature` varchar(1000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `language` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `categories` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `afterreply` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `autostart` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `autoreload` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `notify_customer_new` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `notify_customer_reply` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `show_suggested` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `notify_new_unassigned` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `notify_new_my` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `notify_reply_unassigned` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `notify_reply_my` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `notify_assigned` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `notify_pm` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `notify_note` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `notify_overdue_unassigned` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `notify_overdue_my` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `default_list` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `autoassign` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `heskprivileges` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ratingneg` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `ratingpos` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `rating` float NOT NULL DEFAULT 0,
  `replies` mediumint(8) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `hesk_users`
--

INSERT INTO `hesk_users` (`id`, `user`, `pass`, `isadmin`, `name`, `email`, `signature`, `language`, `categories`, `afterreply`, `autostart`, `autoreload`, `notify_customer_new`, `notify_customer_reply`, `show_suggested`, `notify_new_unassigned`, `notify_new_my`, `notify_reply_unassigned`, `notify_reply_my`, `notify_assigned`, `notify_pm`, `notify_note`, `notify_overdue_unassigned`, `notify_overdue_my`, `default_list`, `autoassign`, `heskprivileges`, `ratingneg`, `ratingpos`, `rating`, `replies`) VALUES
(1, 'Mr.First', '1a050e7ac610492ba8dea26aac6c1ec8930657f8', '1', 'Mr.First', 'barendhk@gmail.com', '', NULL, '', '0', '1', 0, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '', '1', '', 0, 0, 0, 1),
(2, 'vendetta', '1a050e7ac610492ba8dea26aac6c1ec8930657f8', '1', 'vendetta', 'nep@mail.org', '', NULL, '', '1', '1', 0, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '', '1', '', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hits`
--

CREATE TABLE `hits` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `page` varchar(40) NOT NULL DEFAULT '',
  `kliks` int(10) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `hits`
--

INSERT INTO `hits` (`id`, `user_id`, `page`, `kliks`) VALUES
(1, 1, 'index.php', 17),
(2, 1, 'moderator_links.php', 11),
(3, 1, 'browse.php', 17),
(4, 1, 'staff.php', 16),
(5, 1, 'medewerkers.php', 1),
(6, 1, 'shoutbox.php', 9),
(7, 1, 'donateur.php', 5),
(8, 1, 'information.php', 6),
(9, 1, 'links.php', 7),
(10, 1, 'site_regels.php', 6),
(11, 1, 'staff_view.php', 1),
(12, 1, 'inbox_spy.php', 1),
(13, 1, 'massa_berichten_torrents_overzicht.php', 1),
(14, 1, 'forums.php', 5),
(15, 1, 'site_faq.php', 1),
(16, 1, 'bookmarks.php', 5),
(17, 1, 'upload_info.php', 1),
(18, 1, 'my.php', 1),
(19, 1, 'spam.php', 1),
(20, 1, 'staffmess.php', 2),
(21, 1, 'takestaffmess.php', 1),
(22, 1, 'inbox.php', 2),
(23, 1, 'deletemessage.php', 1),
(24, 1, 'forum_admin.php', 7),
(25, 1, 'credits.php', 7),
(26, 1, 'userdetails.php', 4),
(27, 1, 'helpdesk_info.php', 2),
(28, 1, 'uploader_aanvraag_overzicht.php', 1),
(29, 1, 'donatie_admin.php', 1),
(30, 1, 'recover.php', 4),
(31, 1, 'partner.php', 6),
(32, 1, 'addpartner.php', 3),
(33, 1, 'informatie_moderator.php', 1),
(34, 1, 'mods.php', 9),
(35, 1, 'bonus_informatie.php', 6),
(36, 1, 'pics_site.php', 1),
(37, 1, 'category.php', 2),
(38, 1, 'nzbbrowse.php', 1),
(39, 1, 'donatie.php', 1),
(40, 1, 'news.php', 1),
(41, 3, 'userdetails.php', 474),
(42, 3, 'staff.php', 280),
(43, 3, 'moderator_links.php', 347),
(44, 3, 'shoutbox.php', 197),
(45, 3, 'browse.php', 802),
(46, 3, 'index.php', 1534),
(47, 3, 'informatie_ucgod.php', 6),
(48, 3, 'site_instellingen.php', 44),
(49, 3, 'credits.php', 136),
(50, 3, 'donatie.php', 100),
(51, 3, 'upload_info.php', 174),
(52, 3, 'upload.php', 86),
(53, 3, 'my.php', 325),
(54, 3, 'takeprofedit.php', 64),
(55, 3, 'nzbbrowse.php', 41),
(56, 3, 'shoutbox_extra.php', 37),
(57, 3, 'donateur.php', 29),
(58, 3, 'bookmarks.php', 30),
(59, 3, 'uploadnzb.php', 19),
(60, 3, 'inbox.php', 847),
(61, 3, 'log_login.php', 29),
(62, 3, 'kliks_moderator.php', 11),
(63, 3, 'staff_view.php', 16),
(64, 3, 'users_new_view.php', 3),
(65, 3, 'users_modview.php', 66),
(66, 3, 'users.php', 37),
(67, 3, 'users_modtask.php', 105),
(68, 3, 'logout.php', 58),
(69, 3, 'inbox_spy.php', 13),
(70, 3, 'user_account.php', 6),
(71, 3, 'takelogin.php', 18),
(72, 3, 'opruim_pagina.php', 246),
(73, 3, '_opruimen.php', 193),
(74, 3, 'spam.php', 11),
(75, 3, 'take-delmp.php', 3),
(76, 3, 'systeembeheer.php', 25),
(77, 3, 'friends.php', 105),
(78, 3, 'partner.php', 129),
(79, 3, 'addpartner.php', 40),
(80, 3, 'sendmessage.php', 31),
(81, 3, 'takemessage.php', 8),
(82, 3, 'deletemessage.php', 58),
(83, 3, 'mod_users.php', 12),
(84, 3, 'forums.php', 36),
(85, 3, 'avatar_upload.php', 29),
(86, 3, 'bedanktplaatje_view.php', 29),
(87, 3, 'bedankt_upload.php', 19),
(88, 4, 'index.php', 99),
(89, 4, 'userdetails.php', 5),
(90, 3, 'takeflush.php', 5),
(91, 3, 'takeupload.php', 83),
(92, 3, 'details.php', 617),
(93, 3, 'cover_upload.php', 90),
(94, 3, 'download.php', 10),
(95, 3, 'torrent_delete_correctie.php', 37),
(96, 3, 'details_bronnen.php', 21),
(97, 3, 'takebedankplaatje.php', 12),
(98, 3, 'deletecomment.php', 9),
(99, 4, 'upload_info.php', 6),
(100, 4, 'upload.php', 4),
(101, 4, 'my.php', 9),
(102, 4, 'takeprofedit.php', 3),
(103, 3, 'smsbalk.php', 5),
(104, 3, 'credits_berichten.php', 3),
(105, 3, 'smsadmin.php', 108),
(106, 3, 'god_links.php', 512),
(107, 3, 'pics_site.php', 66),
(108, 3, 'users_credits.php', 49),
(109, 3, 'uc_god_only.php', 13),
(110, 3, 'check_site.php', 19),
(111, 3, 'agent_ban.php', 6),
(112, 3, 'bans_special.php', 6),
(113, 3, 'users_double_ip.php', 3),
(114, 3, 'bans_view.php', 21),
(115, 3, 'aktie.php', 37),
(116, 3, 'bonus_overzicht_uploader.php', 19),
(117, 3, 'oude_covers_verwijderen.php', 9),
(118, 3, 'users_disabled.php', 6),
(119, 3, 'category.php', 12),
(120, 3, 'testip.php', 32),
(121, 3, 'clients_check.php', 7),
(122, 3, 'donatie_admin.php', 8),
(123, 3, 'emailoverzicht.php', 3),
(124, 3, 'emaildatabase.php', 2),
(125, 3, 'massuseremail.php', 1),
(126, 3, 'upload-bonus.php', 12),
(127, 3, 'take-upload-bonus.php', 4),
(128, 3, 'users_disabled_shoutbox.php', 9),
(129, 3, 'aktie_donatie.php', 6),
(130, 3, 'waarschuwing-pm.php', 7),
(131, 3, 'pmlogg.php', 1017),
(132, 3, 'waarschuwing-pm-seeden.php', 9),
(133, 3, 'donations.php', 48),
(134, 3, 'inviteadd.php', 3),
(135, 3, 'information.php', 19),
(136, 3, 'site_regels.php', 32),
(137, 3, 'uploader_aanvraag.php', 2),
(138, 3, 'uploader_aanvraag_overzicht.php', 6),
(139, 3, 'uploader_aanvraag_verwerkt.php', 5),
(140, 3, 'upload_utorrent_help.php', 1),
(141, 3, 'cover_delete.php', 7),
(142, 4, 'inbox.php', 168),
(143, 4, 'god_links.php', 20),
(144, 4, 'godverwijder.php', 1),
(145, 4, 'systeembeheer.php', 1),
(146, 4, 'donations.php', 1),
(147, 4, 'avatar_upload.php', 3),
(148, 3, 'god.php', 906),
(149, 3, 'delwaarschuwing.php', 1),
(150, 3, 'helpdesk_info.php', 10),
(151, 3, 'take-acties-test.php', 250),
(152, 3, 'comment.php', 29),
(153, 3, 'adduser.php', 17),
(154, 3, 'restoreclass.php', 37),
(155, 3, 'setclass.php', 86),
(156, 3, 'stip.php', 9),
(157, 3, 'recover.php', 6),
(158, 3, 'recepten.php', 1),
(159, 3, 'schuimpjes.php', 1),
(160, 3, 'raadsels.php', 10),
(161, 3, 'geluksrad.php', 548),
(162, 3, 'cryingmodpagina.php', 298),
(163, 3, 'find_baduser.php', 1),
(164, 3, 'log_useremail.php', 8),
(165, 3, 'torrents_bp.php', 7),
(166, 3, 'docleanup.php', 13),
(167, 3, 'ddosadmin.php', 45),
(168, 3, 'log_ddos.php', 12),
(169, 3, 'log_account.php', 10),
(170, 7, 'index.php', 172),
(171, 7, 'god_links.php', 8),
(172, 7, 'cryingmodpagina.php', 1),
(173, 7, 'ddosadmin.php', 1),
(174, 7, 'log_ddos.php', 2),
(175, 7, 'browse.php', 223),
(176, 7, 'verzoekjes.php', 6),
(177, 7, 'forums.php', 3),
(178, 7, 'credits.php', 9),
(179, 7, 'donatie.php', 11),
(180, 7, 'stip.php', 1),
(181, 3, 'log_controle.php', 4),
(182, 3, 'torrents_100bp.php', 14),
(183, 3, 'allekredietinruilingen.php', 18),
(184, 3, 'inactive.php', 15),
(185, 3, 'user_view_peers.php', 6),
(186, 3, 'krediettoevoeging.php', 16),
(187, 4, 'god.php', 4),
(188, 4, 'take-acties-test.php', 1),
(189, 3, 'smsadmin uitgebreid.php', 3),
(190, 3, 'mysql_stats.php', 10),
(191, 3, 'invite_page.php', 4),
(192, 3, 'kliks.php', 7),
(193, 3, 'kliks_overzicht.php', 4),
(194, 3, 'geblokkerde_gebruikers.php', 13),
(195, 3, 'usersearch.php', 21),
(196, 3, 'upload_controle.php', 13),
(197, 3, 'users_unconfirmed.php', 194),
(198, 3, 'takenzb.php', 6),
(199, 3, '24.php', 10),
(200, 3, 'stats.php', 2),
(201, 3, 'kleurtjes.php', 5),
(202, 3, 'advanceddownloaded.php', 37),
(203, 3, 'log_username.php', 5),
(204, 3, 'avatar_view.php', 41),
(205, 3, 'bans.php', 33),
(206, 3, 'cleanupinstelingen.php', 9),
(207, 3, 'smsad(met).php', 9),
(208, 3, 'roddelbar.php', 3),
(209, 3, 'signature.php', 1),
(210, 3, 'snatches.php', 1),
(211, 3, 'style.php', 1),
(212, 3, 'site_acties.php', 150),
(213, 3, 'sysoplog.php', 21),
(214, 4, 'site_acties.php', 6),
(215, 3, 'X.php', 14),
(216, 3, 'donateur_torrent_email.php', 5),
(217, 3, 'medewerkers.php', 1),
(218, 3, 'game_alcohol.php', 1),
(219, 3, 'game_button.php', 2),
(220, 3, 'game_code.php', 3),
(221, 3, 'game_honderd.php', 1),
(222, 3, 'game_dammen.php', 2),
(223, 3, 'cleanupinstellingen.php', 21),
(224, 3, 'arcade.php', 5),
(225, 3, 'modpagina.php', 317),
(226, 3, 'topten.php', 5),
(227, 3, 'informatie_leden.php', 5),
(228, 3, 'informatie_stats.php', 2),
(229, 3, 'informatie_delers.php', 1),
(230, 3, 'site_faq.php', 7),
(231, 3, 'links.php', 6),
(232, 3, 'verzoekjes.php', 111),
(233, 3, 'bonus_punten.php', 24),
(234, 3, 'informatie_torrents.php', 1),
(235, 3, 'informatie_moderator.php', 1),
(236, 3, 'helpdesk.php', 11),
(237, 3, 'importpg.php', 1),
(238, 3, 'game_memory.php', 1),
(239, 3, 'mobiel.php', 2),
(240, 3, 'godverwijder.php', 4),
(241, 3, 'ubinstall.php', 1),
(242, 3, 'users crying.php', 3),
(243, 4, 'browse.php', 22),
(244, 4, 'details.php', 9),
(245, 4, 'edit.php', 1),
(246, 4, 'takeedit.php', 1),
(247, 3, 'nzbdetails.php', 8),
(248, 3, 'nzbdownload.php2alan-walker.nzb.nzb', 1),
(249, 3, 'partnzbdload.php', 1),
(250, 4, 'nzbbrowse.php', 6),
(251, 4, 'nzbdetails.php', 4),
(252, 4, 'nzbdownload.php2alan-walker.nzb.nzb', 1),
(253, 4, 'nzbdownload.php1tha-playah.nzb.nzb', 1),
(254, 4, 'takeupload.php', 2),
(255, 4, 'download.php', 2),
(256, 3, 'password.php', 26),
(257, 3, 'takeflushall.php', 5),
(258, 3, 'log_admin.php', 2),
(259, 3, 'mod_users_wegwezen.php', 17),
(260, 3, 'users_uploaders.php', 4),
(261, 3, 'mods.php', 12),
(262, 3, 'users_betaald.php', 2),
(263, 3, 'donatie_overzicht.php', 1),
(264, 3, 'donatie_overzicht_reg.php', 1),
(265, 3, 'donatie_user_overzicht.php', 1),
(266, 3, 'log_warning.php', 2),
(267, 3, 'staffmess.php', 5),
(268, 3, '1waardering.php', 52),
(269, 3, 'FTP_mappen.php', 207),
(270, 3, 'site_bezoek.php', 227),
(271, 3, 'check_passkey.php', 2),
(272, 3, 'user_class.php', 18),
(273, 7, 'staff.php', 7),
(274, 7, 'userdetails.php', 24),
(275, 7, 'information.php', 4),
(276, 7, 'moderator_links.php', 4),
(277, 7, 'users_new_view.php', 1),
(278, 7, 'details_bronnen.php', 3),
(279, 7, 'inbox.php', 85),
(280, 7, 'login.php', 5),
(281, 7, 'takelogin.php', 3),
(282, 4, 'informatie_ucgod.php', 1),
(283, 4, 'moderator_links.php', 5),
(284, 4, 'login.php', 5),
(285, 7, '1waardering.php', 1),
(286, 7, 'modpagina.php', 3),
(287, 7, 'setclass.php', 3),
(288, 7, 'site_bezoek.php', 2),
(289, 4, 'takelogin.php', 2),
(290, 4, 'bezoekers.php', 8),
(291, 7, 'shoutbox.php', 8),
(292, 3, 'bezoekers.php', 71),
(293, 3, 'statistics.php', 73),
(294, 3, 'venster_bronnen.php', 1),
(295, 3, 'Xdet.php', 1),
(296, 3, 'XpmX.php', 3),
(297, 3, 'takestaffmess.php', 45),
(298, 3, 'filenotfound.php', 909),
(299, 3, 'videos.php', 37),
(300, 4, 'filenotfound.php', 102),
(301, 4, 'shoutbox.php', 2),
(302, 4, 'partner.php', 5),
(303, 7, 'filenotfound.php', 22),
(304, 7, 'deletemessage.php', 3),
(305, 3, 'verwacht.php', 22),
(306, 7, 'sysoplog.php', 1),
(307, 7, 'dead_torrents.php', 1),
(308, 3, 'user_helpdesk.php', 1),
(309, 3, 'extra_maxtorrents.php', 12),
(310, 3, 'pmspion.php', 4),
(311, 4, 'videos.php', 1),
(312, 4, 'addpartner.php', 2),
(313, 3, 'AntiDoS.php', 8),
(314, 7, 'details.php', 66),
(315, 7, 'takebedankplaatje.php', 4),
(316, 7, 'download.php', 5),
(317, 7, 'deletecomment.php', 7),
(318, 7, 'edit.php', 1),
(319, 7, 'takeedit.php', 1),
(320, 3, 'takerate.php', 7),
(321, 3, 'details_ontvangen.php', 1),
(322, 3, 'massa_berichten_torrents_overzicht.php', 5),
(323, 3, 'massa_berichten_mods.php', 13),
(324, 3, 'massa_berichten_mods_overzicht.php', 23),
(325, 3, 'massa_berichten_overzicht.php', 1),
(326, 3, 'view_ip.php', 700),
(327, 4, 'view_ip.php', 9),
(328, 7, 'view_ip.php', 2),
(329, 7, 'logout.php', 3),
(330, 7, 'usersearch.php', 7),
(331, 7, 'user_downup_gb.php', 2),
(332, 3, 'password_sysop.php', 9),
(333, 3, 'user_ip_overzicht.php', 5),
(334, 3, 'mijn_profiel.php', 1),
(335, 3, 'status.php', 16),
(336, 3, 'dead_torrents.php', 32),
(337, 4, 'details_bronnen.php', 1),
(338, 4, 'site_instellingen.php', 3),
(339, 3, 'take-delmpx.php', 7),
(340, 3, 'user_downup_gb_all.php', 2),
(341, 3, 'poll.php', 51),
(342, 4, 'bans.php', 1),
(343, 4, 'opruim_pagina.php', 6),
(344, 3, 'oude_screens_verwijderen.php', 4),
(345, 4, 'credits.php', 1),
(346, 3, 'zoek_woorden.php', 1),
(347, 3, 'test.php', 100),
(348, 4, 'verwacht.php', 2),
(349, 3, 'forum_admin.php', 1),
(350, 3, 'login.php', 73),
(351, 4, 'smsbalk.php', 1),
(352, 4, 'FTP_mappen.php', 5),
(353, 7, 'adduser.php', 3),
(354, 7, 'upload_info.php', 11),
(355, 7, 'upload.php', 8),
(356, 7, 'God.php', 19),
(357, 7, 'smsad(met).php', 15),
(358, 7, 'my.php', 6),
(359, 7, 'Moderator.php', 6),
(360, 7, 'takeprofedit.php', 1),
(361, 7, 'uploader_aanvraag.php', 1),
(362, 7, 'users.php', 6),
(363, 7, 'users_modtask.php', 7),
(364, 7, 'user_delete_noban.php', 3),
(365, 7, 'user_account.php', 1),
(366, 7, 'user_helpdesk.php', 1),
(367, 7, 'user_name.php', 2),
(368, 7, 'user_email.php', 2),
(369, 7, 'password_sysop.php', 2),
(370, 7, 'takeflush.php', 2),
(371, 7, 'comment.php', 2),
(372, 7, 'bans_view.php', 1),
(373, 7, 'pmlogg.php', 1),
(374, 7, 'users_uploaders.php', 4),
(375, 7, 'uploader_aanvraag_overzicht.php', 3),
(376, 7, 'uploader_aanvraag_verwerkt.php', 1),
(377, 7, 'docleanup.php', 2),
(378, 7, 'user_class.php', 4),
(379, 8, 'index.php', 432),
(380, 8, 'God.php', 511),
(381, 8, 'Moderator.php', 211),
(382, 8, 'log_useremail.php', 3),
(383, 8, 'users_modview.php', 45),
(384, 8, 'browse.php', 1130),
(385, 8, 'upload_info.php', 319),
(386, 8, 'upload.php', 213),
(387, 7, 'X.php', 1),
(388, 8, 'inbox.php', 756),
(389, 8, 'sendmessage_fw.php', 8),
(390, 8, 'upload_controle.php', 65),
(391, 8, 'shoutbox.php', 59),
(392, 8, 'userdetails.php', 455),
(393, 7, 'takeupload.php', 1),
(394, 8, 'takeupload.php', 223),
(395, 8, 'inactive.php', 7),
(396, 8, 'bad_users.php', 2),
(397, 8, 'advanceddownloaded.php', 11),
(398, 8, 'details.php', 1419),
(399, 8, 'cover_upload.php', 295),
(400, 7, 'torrent_delete_correctie.php', 2),
(401, 8, 'edit.php', 166),
(402, 8, 'takeedit.php', 123),
(403, 8, 'download.php', 129),
(404, 8, 'delete.php', 28),
(405, 8, 'details_bronnen.php', 210),
(406, 8, 'torrent_delete_correctie.php', 46),
(407, 8, 'details_bestanden.php', 17),
(408, 8, 'users.php', 11),
(409, 8, 'spinner.php', 3),
(410, 8, 'mod_users_wegwezen.php', 3),
(411, 8, 'credits.php', 137),
(412, 8, 'massa_berichten_torrents_overzicht.php', 2),
(413, 8, 'allekredietinruilingen.php', 9),
(414, 8, 'extra_maxtorrents.php', 24),
(415, 8, 'user_ip_overzicht.php', 23),
(416, 8, 'krediettoevoeging.php', 39),
(417, 7, 'bonus_punten.php', 2),
(418, 7, 'user_credits.php', 1),
(419, 8, 'user_credits.php', 132),
(420, 8, 'user_gb_edit.php', 46),
(421, 8, 'donatie.php', 26),
(422, 7, 'donateur.php', 1),
(423, 7, 'upload-bonus.php', 1),
(424, 7, 'krediettoevoeging.php', 9),
(425, 7, 'allekredietinruilingen.php', 1),
(426, 7, 'massa_berichten_torrents_overzicht.php', 1),
(427, 7, 'status.php', 1),
(428, 8, 'status.php', 10),
(429, 7, 'aktie.php', 1),
(430, 8, 'systeembeheer.php', 1),
(431, 7, 'mod_users_wegwezen.php', 1),
(432, 8, 'torrents_50bp.php', 78),
(433, 7, 'category.php', 39),
(434, 8, 'bonus_overzicht_torrent.php', 3),
(435, 8, 'category.php', 36),
(436, 8, 'screen_upload.php', 15),
(437, 8, 'staff_view.php', 21),
(438, 8, 'aktie.php', 2),
(439, 8, 'usersearch.php', 4),
(440, 8, 'modview_bad_gb.php', 4),
(441, 8, 'torrents_25bp.php', 4),
(442, 8, 'ddosadmin.php', 3),
(443, 8, 'bans.php', 12),
(444, 8, 'bonus_informatie.php', 42),
(445, 8, 'cover_delete.php', 14),
(446, 8, 'my.php', 162),
(447, 7, 'upload_controle.php', 1),
(448, 7, 'mytorrents.php', 1),
(449, 7, 'friends.php', 4),
(450, 7, 'site_regels.php', 22),
(451, 7, 'cleanupinstellingen.php', 1),
(452, 7, 'avatar_view.php', 1),
(453, 7, 'cover_view.php', 1),
(454, 7, 'takeflushall.php', 1),
(455, 7, '_opruimen.php', 1),
(456, 8, 'friends.php', 189),
(457, 8, 'credits_berichten.php', 2),
(458, 8, 'password.php', 25),
(459, 8, 'site_regels.php', 25),
(460, 7, 'bonus_informatie.php', 1),
(461, 7, 'advanceddownloaded.php', 1),
(462, 3, 'Moderator.php', 194),
(463, 3, 'modview_bad_gb.php', 8),
(464, 3, 'cover_view.php', 18),
(465, 3, 'alle_info.php', 9),
(466, 3, 'turncate.php', 5),
(467, 3, 'clean.php', 3),
(468, 8, 'kliks_overzicht.php', 4),
(469, 8, 'massa_berichten_mods_overzicht.php', 2),
(470, 8, 'verzoekjes.php', 23),
(471, 8, 'bans_view.php', 19),
(472, 8, 'alle_info.php', 62),
(473, 8, 'kliks.php', 10),
(474, 8, 'users_modtask.php', 178),
(475, 8, 'user_delete_noban.php', 80),
(476, 3, 'user_credits.php', 12),
(477, 3, 'sendmessage_ts.php', 5),
(478, 8, 'sendmessage_ts.php', 3),
(479, 8, 'takeprofedit.php', 24),
(480, 8, 'user_avatar.php', 5),
(481, 8, 'avatar_upload.php', 6),
(482, 8, 'takemessage.php', 15),
(483, 8, 'upload_aanvraag.php', 14),
(484, 8, 'users_unconfirmed.php', 133),
(485, 8, 'invite_page.php', 7),
(486, 8, 'invite_add.php', 1),
(487, 8, 'logout.php', 132),
(488, 8, 'dht_controle.php', 12),
(489, 8, 'staff.php', 156),
(490, 8, 'sendmessage.php', 7),
(491, 8, 'user_donate_date.php', 28),
(492, 8, 'credits_admin.php', 7),
(493, 8, 'user_view_peers.php', 3),
(494, 8, 'smsadmin.php', 8),
(495, 8, 'avatar_view.php', 19),
(496, 8, 'mysql_stats.php', 6),
(497, 8, '_opruimen.php', 32),
(498, 3, 'creditssss.php', 1),
(499, 3, 'credits_ratio.php', 2),
(500, 3, 'credits_admin.php', 11),
(501, 8, 'adduser.php', 18),
(502, 8, 'user_plaatjes.php', 2),
(503, 8, 'user_gb_bonus.php', 8),
(504, 8, 'modtask.php', 18),
(505, 8, 'user_country.php', 1),
(506, 8, 'takeflushall.php', 4),
(507, 8, 'take-delmpx.php', 37),
(508, 8, 'deletemessage.php', 47),
(509, 8, 'setclass.php', 59),
(510, 8, 'user_class.php', 59),
(511, 8, 'inbox_spy.php', 1),
(512, 8, 'user_name.php', 5),
(513, 8, 'user_account.php', 6),
(514, 10, 'index.php', 4),
(515, 10, 'upload_info.php', 11),
(516, 10, 'upload.php', 6),
(517, 10, 'browse.php', 13),
(518, 10, 'inbox.php', 26),
(519, 10, 'credits.php', 2),
(520, 10, 'userdetails.php', 4),
(521, 10, 'Moderator.php', 3),
(522, 10, 'my.php', 3),
(523, 10, 'friends.php', 5),
(524, 10, 'logout.php', 2),
(525, 8, 'upload-bonus.php', 32),
(526, 8, 'users_uploaders.php', 5),
(527, 10, 'God.php', 5),
(528, 10, 'alle_info.php', 1),
(529, 10, 'users_unconfirmed.php', 1),
(530, 10, 'staff.php', 2),
(531, 10, 'pmlogg.php', 1),
(532, 10, 'kliks.php', 1),
(533, 10, 'kliks_overzicht.php', 1),
(534, 10, 'staff_view.php', 1),
(535, 10, 'shoutbox.php', 3),
(536, 10, 'takeupload.php', 7),
(537, 10, 'details.php', 16),
(538, 10, 'cover_upload.php', 4),
(539, 3, 'modtask.php', 12),
(540, 3, 'modtaskthc.php', 1),
(541, 10, 'torrent_delete_correctie.php', 2),
(542, 10, 'take-delmpx.php', 1),
(543, 10, 'deletemessage.php', 10),
(544, 11, 'index.php', 311),
(545, 11, 'upload_info.php', 302),
(546, 11, 'shoutbox.php', 34),
(547, 11, 'browse.php', 867),
(548, 11, 'verzoekjes.php', 26),
(549, 11, 'Moderator.php', 139),
(550, 11, 'upload.php', 220),
(551, 11, 'logout.php', 67),
(552, 8, 'mods.php', 20),
(553, 8, 'statistics.php', 6),
(554, 8, 'take-upload-bonus.php', 16),
(555, 3, 'user_gb_bonus.php', 5),
(556, 3, 'user_gb_edit.php', 7),
(557, 3, 'bonus_informatie.php', 2),
(558, 3, 'status_site.php', 1),
(559, 8, 'pics_site.php', 4),
(560, 8, 'users_credits.php', 10),
(561, 11, 'takeupload.php', 226),
(562, 11, 'details.php', 905),
(563, 11, 'cover_upload.php', 300),
(564, 8, 'comment.php', 6),
(565, 8, 'takerate.php', 2),
(566, 11, 'userdetails.php', 148),
(567, 11, 'users_modtask.php', 59),
(568, 11, 'extra_maxtorrents.php', 6),
(569, 11, 'user_class.php', 16),
(570, 8, 'takebedankplaatje.php', 5),
(571, 8, 'deletecomment.php', 5),
(572, 3, 'edit.php', 65),
(573, 11, 'inbox.php', 176),
(574, 11, 'deletemessage.php', 31),
(575, 3, 'takeedit.php', 62),
(576, 11, 'edit.php', 78),
(577, 11, 'takeedit.php', 67),
(578, 11, 'staff.php', 42),
(579, 11, 'torrent_delete_correctie.php', 30),
(580, 11, 'site_regels.php', 19),
(581, 11, 'take-delmpx.php', 8),
(582, 3, 'screen_upload.php', 66),
(583, 11, 'upload_controle.php', 58),
(584, 3, 'mytorrents.php', 8),
(585, 11, 'details_bronnen.php', 13),
(586, 11, 'cover_delete.php', 15),
(587, 11, 'friends.php', 11),
(588, 11, 'my.php', 105),
(589, 11, 'mytorrents.php', 1),
(590, 3, 'donateur_takeprofedit.php', 2),
(591, 3, 'invite.php', 1),
(592, 3, 'trekking_loterij.php', 1),
(593, 3, 'details_bestanden.php', 3),
(594, 3, 'screen_delete.php', 1),
(595, 11, 'screen_upload.php', 32),
(596, 3, 'users_double_ip_remove.php', 2),
(597, 11, 'delete.php', 5),
(598, 11, 'takeprofedit.php', 30),
(599, 11, 'users_unconfirmed.php', 44),
(600, 3, 'browse2.php', 1),
(601, 3, 'meest_gedownload.php', 24),
(602, 3, 'modview_overseeden.php', 1),
(603, 3, 'warn_view.php', 2),
(604, 3, 'warning_remove.php', 1),
(605, 3, 'over_seeder.php', 2),
(606, 3, 'tags.php', 11),
(607, 3, 'upload_aanvraag.php', 5),
(608, 3, 'add_ip.php', 1),
(609, 3, 'add_ipnumber.php', 1),
(610, 3, 'addendum.php', 1),
(611, 3, 'aktie_bericht.php', 1),
(612, 3, 'anatomy.php', 1),
(613, 3, 'berichten.php', 1),
(614, 3, 'def_messages.php', 1),
(615, 3, 'delete_torrent.php', 1),
(616, 3, 'solliciteren.php', 1),
(617, 3, 'uploader_request.php', 1),
(618, 3, 'smilies.php', 1),
(619, 3, 'log_autoban.php', 1),
(620, 3, 'log_cheat.php', 1),
(621, 8, 'tags.php', 5),
(622, 8, 'mod_users.php', 1),
(623, 8, 'bedanktplaatje_view.php', 5),
(624, 8, 'waarschuwing-pm-seeden.php', 1),
(625, 3, 'reclame.php', 34),
(626, 8, 'takelogin.php', 71),
(627, 8, 'ftp_spy.php', 1),
(628, 8, 'uploader_aanvraag_overzicht.php', 10),
(629, 13, 'index.php', 1),
(630, 13, 'staff.php', 1),
(631, 13, 'my.php', 1),
(632, 13, 'browse.php', 1),
(633, 13, 'logout.php', 1),
(634, 8, 'bonus_punten.php', 5),
(635, 11, 'upload_aanvraag.php', 14),
(636, 11, 'uploader_aanvraag_overzicht.php', 16),
(637, 8, 'screen_delete.php', 2),
(638, 3, 'dht_controle.php', 4),
(639, 11, 'takemessage.php', 6),
(640, 11, 'torrents_50bp.php', 10),
(641, 11, 'credits.php', 28),
(642, 11, 'donatie.php', 14),
(643, 11, 'bonus_punten.php', 3),
(644, 8, 'kliks_moderator.php', 1),
(645, 8, 'site_instellingen.php', 2),
(646, 8, 'bonus_overzicht_uploader.php', 21),
(647, 8, 'user_email.php', 2),
(648, 8, 'restoreclass.php', 4),
(649, 11, 'smsadmin.php', 5),
(650, 11, 'user_view_peers.php', 6),
(651, 11, 'download.php', 38),
(652, 11, 'screen_delete.php', 1),
(653, 11, 'advanceddownloaded.php', 5),
(654, 3, 'gb_verschil_users.php', 7),
(655, 3, 'torrents_50bp.php', 4),
(656, 3, 'user_donate_date.php', 3),
(657, 3, 'user_delete.php', 7),
(658, 3, 'user_name.php', 4),
(659, 3, 'user_country.php', 1),
(660, 3, 'user_avatar.php', 1),
(661, 3, 'ftp_spy.php', 2),
(662, 15, 'login.php', 2),
(663, 15, 'my.php', 1),
(664, 15, 'upload_info.php', 1),
(665, 3, '7index.php', 1),
(666, 11, 'bad_users.php', 5),
(667, 11, 'usersearch.php', 10),
(668, 3, '7Moderator.php', 3),
(669, 3, '7God.php', 1),
(670, 3, '7users_modview.php', 2),
(671, 8, 'over_seeder.php', 1),
(672, 8, 'donations.php', 2),
(673, 8, 'users_disabled_shoutbox.php', 7),
(674, 3, 'user_warning.php', 2),
(675, 8, 'torrents_100bp.php', 11),
(676, 8, 'meest_gedownload.php', 23),
(677, 11, 'God.php', 177),
(678, 11, 'mods.php', 10),
(679, 3, 'gebruikers_online.php', 1),
(680, 11, 'users_modview.php', 238),
(681, 3, 'gebruikers_overzicht.php', 108),
(682, 3, 'user_email.php', 10),
(683, 11, 'credits_admin.php', 4),
(684, 3, 'site_promo.php', 38),
(685, 3, 'bad_users.php', 9),
(686, 11, 'users_uploaders.php', 1),
(687, 11, 'mod_users.php', 1),
(688, 11, 'dht_controle.php', 1),
(689, 11, 'waarschuwing-pm-seeden.php', 4),
(690, 11, 'user_credits.php', 6),
(691, 11, 'user_gb_edit.php', 4),
(692, 11, 'user_gb_bonus.php', 1),
(693, 11, 'user_delete.php', 1),
(694, 11, 'user_country.php', 5),
(695, 11, 'user_ip_overzicht.php', 9),
(696, 11, 'password_sysop.php', 1),
(697, 11, 'user_avatar.php', 2),
(698, 11, 'user_plaatjes.php', 1),
(699, 11, 'bonus_overzicht_uploader.php', 7),
(700, 11, 'torrents_100bp.php', 20),
(701, 8, 'gebruikers_overzicht.php', 25),
(702, 8, 'site_promo.php', 14),
(703, 8, 'takestaffmess.php', 47),
(704, 11, 'sendmessage.php', 3),
(705, 11, 'inbox_spy.php', 1),
(706, 11, 'staff_view.php', 1),
(707, 11, 'setclass.php', 19),
(708, 11, 'restoreclass.php', 3),
(709, 11, 'donations.php', 1),
(710, 8, 'confirm.php', 4),
(711, 18, 'index.php', 3),
(712, 18, 'inbox.php', 17),
(713, 18, 'browse.php', 4),
(714, 18, 'shoutbox.php', 2),
(715, 18, 'upload_info.php', 2),
(716, 18, 'my.php', 2),
(717, 18, 'verzoekjes.php', 2),
(718, 18, 'credits.php', 2),
(719, 18, 'donatie.php', 2),
(720, 18, 'site_regels.php', 3),
(721, 18, 'staff.php', 3),
(722, 18, 'userdetails.php', 4),
(723, 18, 'friends.php', 1),
(724, 18, 'take-delmpx.php', 1),
(725, 18, 'deletemessage.php', 2),
(726, 18, 'logout.php', 2),
(727, 18, 'Moderator.php', 17),
(728, 18, 'gb_verschil_users.php', 1),
(729, 18, 'modview_bad_gb.php', 1),
(730, 18, 'log_useremail.php', 1),
(731, 18, 'torrents_100bp.php', 3),
(732, 18, 'torrents_50bp.php', 1),
(733, 18, 'oude_covers_verwijderen.php', 1),
(734, 18, 'bedanktplaatje_view.php', 1),
(735, 18, 'user_view_peers.php', 1),
(736, 18, 'massa_berichten_torrents_overzicht.php', 1),
(737, 18, 'inactive.php', 1),
(738, 18, 'mod_users_wegwezen.php', 1),
(739, 18, 'mod_users.php', 1),
(740, 18, 'dht_controle.php', 1),
(741, 18, 'waarschuwing-pm-seeden.php', 1),
(742, 18, 'bad_users.php', 1),
(743, 18, 'users_unconfirmed.php', 1),
(744, 18, 'users_uploaders.php', 1),
(745, 18, 'upload_aanvraag.php', 1),
(746, 18, 'advanceddownloaded.php', 1),
(747, 18, 'users_modtask.php', 1),
(748, 18, 'extra_maxtorrents.php', 1),
(749, 18, 'user_plaatjes.php', 1),
(750, 18, 'user_class.php', 1),
(751, 18, 'user_country.php', 1),
(752, 18, 'user_avatar.php', 1),
(753, 11, 'bans_view.php', 8),
(754, 11, 'users_disabled.php', 6),
(755, 11, '_opruimen.php', 18),
(756, 11, 'kliks.php', 5),
(757, 11, 'reclame.php', 1),
(758, 18, 'takemessage.php', 1),
(759, 8, 'user_ban.php', 7),
(760, 11, 'user_delete_noban.php', 23),
(761, 8, 'testip.php', 8),
(762, 11, 'geblokkerde_gebruikers.php', 9),
(763, 11, 'user_account.php', 9),
(764, 11, 'bans.php', 3),
(765, 11, 'testip.php', 12),
(766, 11, 'cover_view.php', 2),
(767, 11, 'massa_berichten_mods_overzicht.php', 1),
(768, 11, 'ddosadmin.php', 2),
(769, 11, 'sendmessage_ts.php', 2),
(770, 11, 'user_name.php', 1),
(771, 8, 'login.php', 109),
(772, 8, 'geblokkerde_gebruikers.php', 15),
(773, 8, 'users_disabled.php', 3),
(774, 8, 'blokkeer_account.php', 8),
(775, 11, 'modtask.php', 1),
(776, 11, 'uploader_aanvraag_verwerkt.php', 7),
(777, 11, 'blokkeer_account.php', 8),
(778, 8, 'log_login.php', 21),
(779, 8, '16index.php', 2),
(780, 8, '16God.php', 1),
(781, 11, 'gebruikers_overzicht.php', 12),
(782, 8, '16credits.php', 1),
(783, 8, 'ip_brein.php', 1),
(784, 11, 'massa_berichten_torrents_overzicht.php', 4),
(785, 11, 'meest_gedownload.php', 2),
(786, 11, 'status.php', 3),
(787, 11, 'statistics.php', 12),
(788, 11, 'over_seeder.php', 2),
(789, 11, 'takeconfirm.php', 1),
(790, 11, 'inactive.php', 10),
(791, 11, 'site_instellingen.php', 2),
(792, 3, 'user_delete_noban.php', 109),
(793, 8, 'bedankt_upload.php', 6),
(794, 8, 'cover_view.php', 23),
(795, 11, 'log_login.php', 11),
(796, 11, 'category.php', 2),
(797, 11, 'turncate.php', 1),
(798, 11, 'kliks_moderator.php', 1),
(799, 11, 'users_credits.php', 2),
(800, 11, 'modview_bad_gb.php', 1),
(801, 11, 'allekredietinruilingen.php', 2),
(802, 8, 'gb_verschil_users.php', 1),
(803, 3, 'comment_uploader.php', 1),
(804, 8, 'userhistory.php', 1),
(805, 8, 'torrents_2krediet.php', 12),
(806, 11, 'torrents_2krediet.php', 3),
(807, 3, 'torrents_2krediet.php', 32),
(808, 11, 'takeflushall.php', 6),
(809, 11, 'takeflush.php', 4),
(810, 11, 'details_bestanden.php', 2),
(811, 11, 'takethankyou.php', 2),
(812, 11, 'comment.php', 10),
(813, 8, 'downloaded.php', 2),
(814, 8, 'massa_berichten_torrent.php', 3),
(815, 11, 'takebedankplaatje.php', 3),
(816, 11, 'deletecomment.php', 2),
(817, 11, 'details_comments.php', 2),
(818, 3, 'takethankyou.php', 5),
(819, 81, 'index.php', 1),
(820, 81, 'inbox.php', 2),
(821, 81, 'Moderator.php', 2),
(822, 81, 'browse.php', 6),
(823, 81, 'details.php', 6),
(824, 81, 'downloaded.php', 1),
(825, 81, 'my.php', 2),
(826, 81, 'upload_info.php', 2),
(827, 81, 'upload.php', 1),
(828, 81, 'shoutbox.php', 2),
(829, 81, 'userdetails.php', 2),
(830, 81, 'donatie.php', 2),
(831, 81, 'site_regels.php', 2),
(832, 81, 'dht_controle.php', 1),
(833, 81, 'credits.php', 1),
(834, 81, 'bonus_punten.php', 1),
(835, 81, 'comment.php', 2),
(836, 81, 'staff.php', 1),
(837, 3, 'downloaded.php', 1),
(838, 11, 'downloaded.php', 2),
(839, 11, 'user_downup_gb.php', 1),
(840, 8, 'signup.php', 3),
(841, 8, 'takesignup.php', 2),
(842, 8, 'ok.php', 8),
(843, 101, 'index.php', 1),
(844, 101, 'logout.php', 1),
(845, 105, 'browse.php', 10),
(846, 105, 'inbox.php', 8),
(847, 105, 'take-delmpx.php', 2),
(848, 105, 'deletemessage.php', 2),
(849, 105, 'upload_info.php', 1),
(850, 105, 'upload.php', 1),
(851, 105, 'takeupload.php', 1),
(852, 105, 'details.php', 16),
(853, 105, 'details_bronnen.php', 4),
(854, 105, 'torrent_delete_correctie.php', 1),
(855, 105, 'index.php', 1),
(856, 105, 'details_bestanden.php', 1),
(857, 105, 'takebedankplaatje.php', 1),
(858, 105, 'download.php', 1),
(859, 8, 'reclame.php', 265),
(860, 3, 'support.php', 4),
(861, 8, 'massa_berichten_mods.php', 8),
(862, 8, 'support.php', 1),
(863, 3, 'confirm.php', 2),
(864, 5, 'index.php', 102),
(865, 5, 'userdetails.php', 85),
(866, 5, 'inbox.php', 7),
(867, 5, 'God.php', 32),
(868, 5, 'Moderator.php', 66),
(869, 5, 'adduser.php', 1),
(870, 5, 'users_unconfirmed.php', 137),
(871, 5, 'browse.php', 84),
(872, 5, 'upload_info.php', 8),
(873, 5, 'upload.php', 7),
(874, 5, 'logout.php', 20),
(875, 5, 'staff_view.php', 5),
(876, 5, 'users_modtask.php', 27),
(877, 5, 'user_class.php', 6),
(878, 5, 'staff.php', 51),
(879, 5, 'sendmessage.php', 2),
(880, 5, 'bonus_overzicht_uploader.php', 2),
(881, 5, 'torrents_100bp.php', 2),
(882, 5, 'kliks.php', 1),
(883, 5, 'confirm.php', 1),
(884, 5, 'ok.php', 1),
(885, 5, 'login.php', 8),
(886, 5, 'takelogin.php', 64),
(887, 5, 'gebruikers_overzicht.php', 38),
(888, 5, 'user_ip_overzicht.php', 81),
(889, 5, 'user_delete_noban.php', 57),
(890, 5, 'bans_view.php', 15),
(891, 5, 'details.php', 70),
(892, 5, 'edit.php', 12),
(893, 5, 'takeedit.php', 9),
(894, 5, 'user_credits.php', 9),
(895, 5, 'setclass.php', 6),
(896, 5, 'restoreclass.php', 1),
(897, 5, 'comment.php', 2),
(898, 5, 'download.php', 1),
(899, 5, 'user_gb_edit.php', 3),
(900, 5, 'log_login.php', 3),
(901, 5, 'credits.php', 2),
(902, 5, 'donatie.php', 2),
(903, 5, 'sendmessage_ts.php', 1),
(904, 5, 'details_bronnen.php', 9),
(905, 5, 'donations.php', 1),
(906, 5, 'kliks_moderator.php', 1),
(907, 5, 'userhistory.php', 83),
(908, 5, 'user_downup_gb.php', 5),
(909, 5, 'shoutbox.php', 5),
(910, 5, 'meest_gedownload.php', 4),
(911, 5, 'deletemessage.php', 1),
(912, 5, 'verzoekjes.php', 3),
(913, 5, '_opruimen.php', 3),
(914, 5, 'site_regels.php', 3),
(915, 5, 'delete.php', 3),
(916, 5, 'takeupload.php', 8),
(917, 5, 'cover_upload.php', 2),
(918, 5, 'details_bestanden.php', 1),
(919, 5, 'torrent_delete_correctie.php', 1),
(920, 5, 'category.php', 186),
(921, 5, 'site_promo.php', 1),
(922, 5, 'users_credits.php', 1),
(923, 5, 'password_sysop.php', 1),
(924, 5, 'my.php', 1),
(925, 5, 'password.php', 4),
(926, 3, 'delete.php', 1),
(927, 8, 'takeflush.php', 1),
(928, 3, 'rutorrent.php', 11),
(929, 190, 'index.php', 3),
(930, 190, 'inbox.php', 2),
(931, 190, 'browse.php', 1),
(932, 190, 'upload_info.php', 1),
(933, 190, 'upload.php', 1),
(934, 190, 'logout.php', 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `infolog`
--

CREATE TABLE `infolog` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `message` text DEFAULT NULL,
  `text` varchar(10) NOT NULL,
  `added_by` int(10) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ip`
--

CREATE TABLE `ip` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `ip` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ip_logboek`
--

CREATE TABLE `ip_logboek` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` datetime DEFAULT NULL,
  `tekst2` char(50) NOT NULL,
  `tekst3` varchar(255) NOT NULL,
  `user` int(10) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `ip_logboek`
--

INSERT INTO `ip_logboek` (`id`, `added`, `tekst2`, `tekst3`, `user`) VALUES
(1, '2021-11-17 04:32:22', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(2, '2021-11-17 04:32:32', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(3, '2021-11-17 04:33:06', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(4, '2021-11-17 04:33:06', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(5, '2021-11-17 04:33:06', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(6, '2021-11-17 04:33:07', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(7, '2021-11-17 04:33:07', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(8, '2021-11-17 04:33:07', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(9, '2021-11-17 04:33:07', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(10, '2021-11-17 04:33:07', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(11, '2021-11-17 04:33:07', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(12, '2021-11-17 04:33:07', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(13, '2021-11-17 04:33:07', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(14, '2021-11-17 04:33:08', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(15, '2021-11-17 04:33:08', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(16, '2021-11-17 04:33:08', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(17, '2021-11-17 04:33:08', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(18, '2021-11-17 04:33:08', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(19, '2021-11-17 04:33:08', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(20, '2021-11-17 04:33:09', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(21, '2021-11-17 04:33:09', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(22, '2021-11-17 04:33:09', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(23, '2021-11-17 04:33:10', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(24, '2021-11-17 04:33:10', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(25, '2021-11-17 04:33:10', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(26, '2021-11-17 04:33:10', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(27, '2021-11-17 04:33:10', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(28, '2021-11-17 04:33:11', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(29, '2021-11-17 04:33:11', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(30, '2021-11-17 04:33:11', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(31, '2021-11-17 04:33:11', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(32, '2021-11-17 04:33:11', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(33, '2021-11-17 04:33:11', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(34, '2021-11-17 04:33:11', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(35, '2021-11-17 04:33:11', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(36, '2021-11-17 04:33:12', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(37, '2021-11-17 04:33:12', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(38, '2021-11-17 04:33:12', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(39, '2021-11-17 04:33:12', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(40, '2021-11-17 04:33:12', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(41, '2021-11-17 04:33:12', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(42, '2021-11-17 04:33:12', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(43, '2021-11-17 04:33:18', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(44, '2021-11-17 04:33:18', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(45, '2021-11-17 04:33:18', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(46, '2021-11-17 04:33:18', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(47, '2021-11-17 04:33:18', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(48, '2021-11-17 04:33:18', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(49, '2021-11-17 04:33:18', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(50, '2021-11-17 04:33:18', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(51, '2021-11-17 04:33:18', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(52, '2021-11-17 04:33:18', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(53, '2021-11-17 04:33:19', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(54, '2021-11-17 04:33:19', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(55, '2021-11-17 04:33:19', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(56, '2021-11-17 04:33:19', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(57, '2021-11-17 04:33:19', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(58, '2021-11-17 04:33:19', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(59, '2021-11-17 04:33:19', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(60, '2021-11-17 04:33:19', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(61, '2021-11-17 04:33:19', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(62, '2021-11-17 04:33:20', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(63, '2021-11-17 04:35:29', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(64, '2021-11-17 04:35:30', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(65, '2021-11-17 04:35:30', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(66, '2021-11-17 04:35:30', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(67, '2021-11-17 04:35:30', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(68, '2021-11-17 04:35:30', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(69, '2021-11-17 04:35:30', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(70, '2021-11-17 04:35:30', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(71, '2021-11-17 04:35:30', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(72, '2021-11-17 04:35:30', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(73, '2021-11-17 04:35:31', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(74, '2021-11-17 04:35:31', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(75, '2021-11-17 04:35:31', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(76, '2021-11-17 04:35:31', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(77, '2021-11-17 04:35:31', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(78, '2021-11-17 04:35:31', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(79, '2021-11-17 04:35:31', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(80, '2021-11-17 04:35:31', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(81, '2021-11-17 04:35:31', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(82, '2021-11-17 04:35:32', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(83, '2021-11-17 04:36:02', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(84, '2021-11-17 04:36:02', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(85, '2021-11-17 04:36:02', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(86, '2021-11-17 04:36:02', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(87, '2021-11-17 04:36:02', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(88, '2021-11-17 04:36:02', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(89, '2021-11-17 04:36:03', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(90, '2021-11-17 04:36:03', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(91, '2021-11-17 04:36:03', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(92, '2021-11-17 04:36:03', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(93, '2021-11-17 04:36:03', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(94, '2021-11-17 04:36:03', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(95, '2021-11-17 04:36:03', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(96, '2021-11-17 04:36:03', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(97, '2021-11-17 04:36:03', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(98, '2021-11-17 04:36:04', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(99, '2021-11-17 04:36:04', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(100, '2021-11-17 04:36:04', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(101, '2021-11-17 04:36:04', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(102, '2021-11-17 04:36:04', '84.106.3.83', 'https://torrentmedia.org/God?', 3),
(103, '2021-11-17 04:45:19', '84.106.3.83', '', 3),
(104, '2021-11-17 04:45:20', '84.106.3.83', '', 3),
(105, '2021-11-17 04:45:20', '84.106.3.83', '', 3),
(106, '2021-11-17 04:45:20', '84.106.3.83', '', 3),
(107, '2021-11-17 04:45:20', '84.106.3.83', '', 3),
(108, '2021-11-17 04:45:20', '84.106.3.83', '', 3),
(109, '2021-11-17 04:45:20', '84.106.3.83', '', 3),
(110, '2021-11-17 04:45:20', '84.106.3.83', '', 3),
(111, '2021-11-17 04:45:20', '84.106.3.83', '', 3),
(112, '2021-11-17 04:45:20', '84.106.3.83', '', 3),
(113, '2021-11-17 04:45:21', '84.106.3.83', '', 3),
(114, '2021-11-17 04:45:21', '84.106.3.83', '', 3),
(115, '2021-11-17 04:45:21', '84.106.3.83', '', 3),
(116, '2021-11-17 04:45:21', '84.106.3.83', '', 3),
(117, '2021-11-17 04:45:21', '84.106.3.83', '', 3),
(118, '2021-11-17 04:45:21', '84.106.3.83', '', 3),
(119, '2021-11-17 04:45:21', '84.106.3.83', '', 3),
(120, '2021-11-17 04:45:21', '84.106.3.83', '', 3),
(121, '2021-11-17 04:45:21', '84.106.3.83', '', 3),
(122, '2021-11-17 04:45:22', '84.106.3.83', '', 3),
(123, '2021-11-17 04:45:23', '84.106.3.83', '', 3),
(124, '2021-11-17 04:45:23', '84.106.3.83', '', 3),
(125, '2021-11-17 04:45:23', '84.106.3.83', '', 3),
(126, '2021-11-17 04:45:23', '84.106.3.83', '', 3),
(127, '2021-11-17 04:45:23', '84.106.3.83', '', 3),
(128, '2021-11-17 04:45:23', '84.106.3.83', '', 3),
(129, '2021-11-17 04:45:23', '84.106.3.83', '', 3),
(130, '2021-11-17 04:45:23', '84.106.3.83', '', 3),
(131, '2021-11-17 04:45:24', '84.106.3.83', '', 3),
(132, '2021-11-17 04:45:24', '84.106.3.83', '', 3),
(133, '2021-11-17 04:45:24', '84.106.3.83', '', 3),
(134, '2021-11-17 04:45:24', '84.106.3.83', '', 3),
(135, '2021-11-17 04:45:24', '84.106.3.83', '', 3),
(136, '2021-11-17 04:45:24', '84.106.3.83', '', 3),
(137, '2021-11-17 04:45:24', '84.106.3.83', '', 3),
(138, '2021-11-17 04:45:24', '84.106.3.83', '', 3),
(139, '2021-11-17 04:45:25', '84.106.3.83', '', 3),
(140, '2021-11-17 04:45:25', '84.106.3.83', '', 3),
(141, '2021-11-17 04:45:25', '84.106.3.83', '', 3),
(142, '2021-11-17 04:45:25', '84.106.3.83', '', 3),
(143, '2021-11-17 04:45:30', '84.106.3.83', '', 3),
(144, '2021-11-17 04:45:31', '84.106.3.83', '', 3),
(145, '2021-11-17 04:45:31', '84.106.3.83', '', 3),
(146, '2021-11-17 04:45:31', '84.106.3.83', '', 3),
(147, '2021-11-17 04:45:31', '84.106.3.83', '', 3),
(148, '2021-11-17 04:45:31', '84.106.3.83', '', 3),
(149, '2021-11-17 04:45:31', '84.106.3.83', '', 3),
(150, '2021-11-17 04:45:31', '84.106.3.83', '', 3),
(151, '2021-11-17 04:45:32', '84.106.3.83', '', 3),
(152, '2021-11-17 04:45:32', '84.106.3.83', '', 3),
(153, '2021-11-17 04:45:32', '84.106.3.83', '', 3),
(154, '2021-11-17 04:45:32', '84.106.3.83', '', 3),
(155, '2021-11-17 04:45:32', '84.106.3.83', '', 3),
(156, '2021-11-17 04:45:32', '84.106.3.83', '', 3),
(157, '2021-11-17 04:45:32', '84.106.3.83', '', 3),
(158, '2021-11-17 04:45:32', '84.106.3.83', '', 3),
(159, '2021-11-17 04:45:32', '84.106.3.83', '', 3),
(160, '2021-11-17 04:45:33', '84.106.3.83', '', 3),
(161, '2021-11-17 04:45:33', '84.106.3.83', '', 3),
(162, '2021-11-17 04:45:33', '84.106.3.83', '', 3),
(163, '2021-11-17 04:47:01', '84.106.3.83', 'https://torrentmedia.org/login.php?returnto=%2F', 3),
(164, '2021-11-17 04:47:04', '84.106.3.83', 'https://torrentmedia.org/', 3),
(165, '2021-11-17 04:47:06', '84.106.3.83', 'https://torrentmedia.org/inbox.php', 3),
(166, '2021-11-17 04:47:10', '84.106.3.83', 'https://torrentmedia.org/inbox.php?message_id=654', 3),
(167, '2021-11-17 04:47:10', '84.106.3.83', 'https://torrentmedia.org/inbox.php?message_id=654', 3),
(168, '2021-11-17 04:47:15', '84.106.3.83', 'https://torrentmedia.org/inbox.php', 3),
(169, '2021-11-17 04:47:17', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(170, '2021-11-17 04:47:17', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(171, '2021-11-17 04:47:17', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(172, '2021-11-17 04:47:17', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(173, '2021-11-17 04:47:17', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(174, '2021-11-17 04:47:18', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(175, '2021-11-17 04:47:18', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(176, '2021-11-17 04:47:18', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(177, '2021-11-17 04:47:18', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(178, '2021-11-17 04:47:18', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(179, '2021-11-17 04:47:18', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(180, '2021-11-17 04:47:18', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(181, '2021-11-17 04:47:18', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(182, '2021-11-17 04:47:19', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(183, '2021-11-17 04:47:19', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(184, '2021-11-17 04:47:19', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(185, '2021-11-17 04:47:19', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(186, '2021-11-17 04:47:19', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(187, '2021-11-17 04:47:19', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(188, '2021-11-17 04:47:19', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(189, '2021-11-17 04:47:20', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(190, '2021-11-17 04:47:20', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(191, '2021-11-17 04:47:21', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(192, '2021-11-17 04:47:21', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(193, '2021-11-17 04:47:21', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(194, '2021-11-17 04:47:21', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(195, '2021-11-17 04:47:21', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(196, '2021-11-17 04:47:21', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(197, '2021-11-17 04:47:21', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(198, '2021-11-17 04:47:21', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(199, '2021-11-17 04:47:21', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(200, '2021-11-17 04:47:21', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(201, '2021-11-17 04:47:22', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(202, '2021-11-17 04:47:22', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(203, '2021-11-17 04:47:22', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(204, '2021-11-17 04:47:22', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(205, '2021-11-17 04:47:22', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(206, '2021-11-17 04:47:22', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(207, '2021-11-17 04:47:22', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(208, '2021-11-17 04:47:22', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(209, '2021-11-17 04:47:27', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(210, '2021-11-17 04:47:28', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(211, '2021-11-17 04:47:28', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(212, '2021-11-17 04:47:28', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(213, '2021-11-17 04:47:28', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(214, '2021-11-17 04:47:28', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(215, '2021-11-17 04:47:28', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(216, '2021-11-17 04:47:28', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(217, '2021-11-17 04:47:28', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(218, '2021-11-17 04:47:28', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(219, '2021-11-17 04:47:29', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(220, '2021-11-17 04:47:29', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(221, '2021-11-17 04:47:29', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(222, '2021-11-17 04:47:29', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(223, '2021-11-17 04:47:29', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(224, '2021-11-17 04:47:29', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(225, '2021-11-17 04:47:29', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(226, '2021-11-17 04:47:29', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(227, '2021-11-17 04:47:29', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(228, '2021-11-17 04:47:29', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(229, '2021-11-17 04:47:38', '84.106.3.83', '', 3),
(230, '2021-11-17 04:47:38', '84.106.3.83', '', 3),
(231, '2021-11-17 04:47:38', '84.106.3.83', '', 3),
(232, '2021-11-17 04:47:38', '84.106.3.83', '', 3),
(233, '2021-11-17 04:47:38', '84.106.3.83', '', 3),
(234, '2021-11-17 04:47:38', '84.106.3.83', '', 3),
(235, '2021-11-17 04:47:38', '84.106.3.83', '', 3),
(236, '2021-11-17 04:47:38', '84.106.3.83', '', 3),
(237, '2021-11-17 04:47:38', '84.106.3.83', '', 3),
(238, '2021-11-17 04:47:39', '84.106.3.83', '', 3),
(239, '2021-11-17 04:47:39', '84.106.3.83', '', 3),
(240, '2021-11-17 04:47:39', '84.106.3.83', '', 3),
(241, '2021-11-17 04:47:39', '84.106.3.83', '', 3),
(242, '2021-11-17 04:47:39', '84.106.3.83', '', 3),
(243, '2021-11-17 04:47:39', '84.106.3.83', '', 3),
(244, '2021-11-17 04:47:39', '84.106.3.83', '', 3),
(245, '2021-11-17 04:47:39', '84.106.3.83', '', 3),
(246, '2021-11-17 04:47:39', '84.106.3.83', '', 3),
(247, '2021-11-17 04:47:39', '84.106.3.83', '', 3),
(248, '2021-11-17 04:47:40', '84.106.3.83', '', 3),
(249, '2021-11-17 04:47:41', '84.106.3.83', '', 3),
(250, '2021-11-17 04:47:41', '84.106.3.83', '', 3),
(251, '2021-11-17 04:47:41', '84.106.3.83', '', 3),
(252, '2021-11-17 04:47:41', '84.106.3.83', '', 3),
(253, '2021-11-17 04:47:41', '84.106.3.83', '', 3),
(254, '2021-11-17 04:47:41', '84.106.3.83', '', 3),
(255, '2021-11-17 04:47:41', '84.106.3.83', '', 3),
(256, '2021-11-17 04:47:41', '84.106.3.83', '', 3),
(257, '2021-11-17 04:47:41', '84.106.3.83', '', 3),
(258, '2021-11-17 04:47:42', '84.106.3.83', '', 3),
(259, '2021-11-17 04:47:42', '84.106.3.83', '', 3),
(260, '2021-11-17 04:47:42', '84.106.3.83', '', 3),
(261, '2021-11-17 04:47:42', '84.106.3.83', '', 3),
(262, '2021-11-17 04:47:42', '84.106.3.83', '', 3),
(263, '2021-11-17 04:47:42', '84.106.3.83', '', 3),
(264, '2021-11-17 04:47:42', '84.106.3.83', '', 3),
(265, '2021-11-17 04:47:42', '84.106.3.83', '', 3),
(266, '2021-11-17 04:47:42', '84.106.3.83', '', 3),
(267, '2021-11-17 04:47:42', '84.106.3.83', '', 3),
(268, '2021-11-17 04:47:43', '84.106.3.83', '', 3),
(269, '2021-11-17 04:47:48', '84.106.3.83', '', 3),
(270, '2021-11-17 04:47:48', '84.106.3.83', '', 3),
(271, '2021-11-17 04:47:48', '84.106.3.83', '', 3),
(272, '2021-11-17 04:47:48', '84.106.3.83', '', 3),
(273, '2021-11-17 04:47:48', '84.106.3.83', '', 3),
(274, '2021-11-17 04:47:48', '84.106.3.83', '', 3),
(275, '2021-11-17 04:47:48', '84.106.3.83', '', 3),
(276, '2021-11-17 04:47:48', '84.106.3.83', '', 3),
(277, '2021-11-17 04:47:49', '84.106.3.83', '', 3),
(278, '2021-11-17 04:47:49', '84.106.3.83', '', 3),
(279, '2021-11-17 04:47:49', '84.106.3.83', '', 3),
(280, '2021-11-17 04:47:49', '84.106.3.83', '', 3),
(281, '2021-11-17 04:47:49', '84.106.3.83', '', 3),
(282, '2021-11-17 04:47:49', '84.106.3.83', '', 3),
(283, '2021-11-17 04:47:49', '84.106.3.83', '', 3),
(284, '2021-11-17 04:47:49', '84.106.3.83', '', 3),
(285, '2021-11-17 04:47:49', '84.106.3.83', '', 3),
(286, '2021-11-17 04:47:49', '84.106.3.83', '', 3),
(287, '2021-11-17 04:47:50', '84.106.3.83', '', 3),
(288, '2021-11-17 04:47:50', '84.106.3.83', '', 3),
(289, '2021-11-17 04:47:50', '84.106.3.83', '', 3),
(290, '2021-11-17 04:47:50', '84.106.3.83', '', 3),
(291, '2021-11-17 04:47:50', '84.106.3.83', '', 3),
(292, '2021-11-17 04:47:50', '84.106.3.83', '', 3),
(293, '2021-11-17 04:47:50', '84.106.3.83', '', 3),
(294, '2021-11-17 04:47:50', '84.106.3.83', '', 3),
(295, '2021-11-17 04:47:50', '84.106.3.83', '', 3),
(296, '2021-11-17 04:47:52', '84.106.3.83', '', 3),
(297, '2021-11-17 04:47:52', '84.106.3.83', '', 3),
(298, '2021-11-17 04:47:52', '84.106.3.83', '', 3),
(299, '2021-11-17 04:47:52', '84.106.3.83', '', 3),
(300, '2021-11-17 04:47:52', '84.106.3.83', '', 3),
(301, '2021-11-17 04:47:52', '84.106.3.83', '', 3),
(302, '2021-11-17 04:47:52', '84.106.3.83', '', 3),
(303, '2021-11-17 04:47:52', '84.106.3.83', '', 3),
(304, '2021-11-17 04:47:52', '84.106.3.83', '', 3),
(305, '2021-11-17 04:47:52', '84.106.3.83', '', 3),
(306, '2021-11-17 04:47:53', '84.106.3.83', '', 3),
(307, '2021-11-17 04:47:53', '84.106.3.83', '', 3),
(308, '2021-11-17 04:47:53', '84.106.3.83', '', 3),
(309, '2021-11-17 04:47:53', '84.106.3.83', '', 3),
(310, '2021-11-17 04:47:53', '84.106.3.83', '', 3),
(311, '2021-11-17 04:47:53', '84.106.3.83', '', 3),
(312, '2021-11-17 04:47:53', '84.106.3.83', '', 3),
(313, '2021-11-17 04:47:53', '84.106.3.83', '', 3),
(314, '2021-11-17 04:47:53', '84.106.3.83', '', 3),
(315, '2021-11-17 04:47:54', '84.106.3.83', '', 3),
(316, '2021-11-17 04:47:59', '84.106.3.83', '', 3),
(317, '2021-11-17 04:47:59', '84.106.3.83', '', 3),
(318, '2021-11-17 04:47:59', '84.106.3.83', '', 3),
(319, '2021-11-17 04:47:59', '84.106.3.83', '', 3),
(320, '2021-11-17 04:47:59', '84.106.3.83', '', 3),
(321, '2021-11-17 04:47:59', '84.106.3.83', '', 3),
(322, '2021-11-17 04:48:00', '84.106.3.83', '', 3),
(323, '2021-11-17 04:48:00', '84.106.3.83', '', 3),
(324, '2021-11-17 04:48:00', '84.106.3.83', '', 3),
(325, '2021-11-17 04:48:00', '84.106.3.83', '', 3),
(326, '2021-11-17 04:48:00', '84.106.3.83', '', 3),
(327, '2021-11-17 04:48:00', '84.106.3.83', '', 3),
(328, '2021-11-17 04:48:00', '84.106.3.83', '', 3),
(329, '2021-11-17 04:48:00', '84.106.3.83', '', 3),
(330, '2021-11-17 04:48:00', '84.106.3.83', '', 3),
(331, '2021-11-17 04:48:00', '84.106.3.83', '', 3),
(332, '2021-11-17 04:48:01', '84.106.3.83', '', 3),
(333, '2021-11-17 04:48:01', '84.106.3.83', '', 3),
(334, '2021-11-17 04:48:01', '84.106.3.83', '', 3),
(335, '2021-11-17 04:48:01', '84.106.3.83', '', 3),
(336, '2021-11-17 04:48:01', '84.106.3.83', '', 3),
(337, '2021-11-17 04:48:01', '84.106.3.83', '', 3),
(338, '2021-11-17 04:48:02', '84.106.3.83', '', 3),
(339, '2021-11-17 04:48:02', '84.106.3.83', '', 3),
(340, '2021-11-17 04:48:02', '84.106.3.83', '', 3),
(341, '2021-11-17 04:48:03', '84.106.3.83', '', 3),
(342, '2021-11-17 04:48:03', '84.106.3.83', '', 3),
(343, '2021-11-17 04:48:03', '84.106.3.83', '', 3),
(344, '2021-11-17 04:48:03', '84.106.3.83', '', 3),
(345, '2021-11-17 04:48:03', '84.106.3.83', '', 3),
(346, '2021-11-17 04:48:03', '84.106.3.83', '', 3),
(347, '2021-11-17 04:48:03', '84.106.3.83', '', 3),
(348, '2021-11-17 04:48:03', '84.106.3.83', '', 3),
(349, '2021-11-17 04:48:03', '84.106.3.83', '', 3),
(350, '2021-11-17 04:48:03', '84.106.3.83', '', 3),
(351, '2021-11-17 04:48:04', '84.106.3.83', '', 3),
(352, '2021-11-17 04:48:04', '84.106.3.83', '', 3),
(353, '2021-11-17 04:48:04', '84.106.3.83', '', 3),
(354, '2021-11-17 04:48:04', '84.106.3.83', '', 3),
(355, '2021-11-17 04:48:04', '84.106.3.83', '', 3),
(356, '2021-11-17 04:48:04', '84.106.3.83', '', 3),
(357, '2021-11-17 04:48:04', '84.106.3.83', '', 3),
(358, '2021-11-17 04:48:09', '84.106.3.83', '', 3),
(359, '2021-11-17 04:48:09', '84.106.3.83', '', 3),
(360, '2021-11-17 04:48:10', '84.106.3.83', '', 3),
(361, '2021-11-17 04:48:10', '84.106.3.83', '', 3),
(362, '2021-11-17 04:48:10', '84.106.3.83', '', 3),
(363, '2021-11-17 04:48:10', '84.106.3.83', '', 3),
(364, '2021-11-17 04:48:10', '84.106.3.83', '', 3),
(365, '2021-11-17 04:48:10', '84.106.3.83', '', 3),
(366, '2021-11-17 04:48:10', '84.106.3.83', '', 3),
(367, '2021-11-17 04:48:10', '84.106.3.83', '', 3),
(368, '2021-11-17 04:48:10', '84.106.3.83', '', 3),
(369, '2021-11-17 04:48:10', '84.106.3.83', '', 3),
(370, '2021-11-17 04:48:11', '84.106.3.83', '', 3),
(371, '2021-11-17 04:48:11', '84.106.3.83', '', 3),
(372, '2021-11-17 04:48:11', '84.106.3.83', '', 3),
(373, '2021-11-17 04:48:11', '84.106.3.83', '', 3),
(374, '2021-11-17 04:48:11', '84.106.3.83', '', 3),
(375, '2021-11-17 04:48:11', '84.106.3.83', '', 3),
(376, '2021-11-17 04:48:11', '84.106.3.83', '', 3),
(377, '2021-11-17 04:48:11', '84.106.3.83', '', 3),
(378, '2021-11-17 04:48:42', '84.106.3.83', '', 3),
(379, '2021-11-17 04:48:42', '84.106.3.83', '', 3),
(380, '2021-11-17 04:48:42', '84.106.3.83', '', 3),
(381, '2021-11-17 04:48:42', '84.106.3.83', '', 3),
(382, '2021-11-17 04:48:42', '84.106.3.83', '', 3),
(383, '2021-11-17 04:48:42', '84.106.3.83', '', 3),
(384, '2021-11-17 04:48:42', '84.106.3.83', '', 3),
(385, '2021-11-17 04:48:42', '84.106.3.83', '', 3),
(386, '2021-11-17 04:48:42', '84.106.3.83', '', 3),
(387, '2021-11-17 04:48:43', '84.106.3.83', '', 3),
(388, '2021-11-17 04:48:43', '84.106.3.83', '', 3),
(389, '2021-11-17 04:48:43', '84.106.3.83', '', 3),
(390, '2021-11-17 04:48:43', '84.106.3.83', '', 3),
(391, '2021-11-17 04:48:43', '84.106.3.83', '', 3),
(392, '2021-11-17 04:48:43', '84.106.3.83', '', 3),
(393, '2021-11-17 04:48:43', '84.106.3.83', '', 3),
(394, '2021-11-17 04:48:43', '84.106.3.83', '', 3),
(395, '2021-11-17 04:48:43', '84.106.3.83', '', 3),
(396, '2021-11-17 04:48:43', '84.106.3.83', '', 3),
(397, '2021-11-17 04:48:44', '84.106.3.83', '', 3),
(398, '2021-11-17 04:49:44', '84.106.3.83', '', 3),
(399, '2021-11-17 04:49:44', '84.106.3.83', '', 3),
(400, '2021-11-17 04:49:44', '84.106.3.83', '', 3),
(401, '2021-11-17 04:49:44', '84.106.3.83', '', 3),
(402, '2021-11-17 04:49:44', '84.106.3.83', '', 3),
(403, '2021-11-17 04:49:44', '84.106.3.83', '', 3),
(404, '2021-11-17 04:49:44', '84.106.3.83', '', 3),
(405, '2021-11-17 04:49:45', '84.106.3.83', '', 3),
(406, '2021-11-17 04:49:45', '84.106.3.83', '', 3),
(407, '2021-11-17 04:49:45', '84.106.3.83', '', 3),
(408, '2021-11-17 04:49:45', '84.106.3.83', '', 3),
(409, '2021-11-17 04:49:45', '84.106.3.83', '', 3),
(410, '2021-11-17 04:49:45', '84.106.3.83', '', 3),
(411, '2021-11-17 04:49:45', '84.106.3.83', '', 3),
(412, '2021-11-17 04:49:45', '84.106.3.83', '', 3),
(413, '2021-11-17 04:49:45', '84.106.3.83', '', 3),
(414, '2021-11-17 04:49:45', '84.106.3.83', '', 3),
(415, '2021-11-17 04:49:46', '84.106.3.83', '', 3),
(416, '2021-11-17 04:49:46', '84.106.3.83', '', 3),
(417, '2021-11-17 04:49:46', '84.106.3.83', '', 3),
(418, '2021-11-17 04:51:51', '84.106.3.83', '', 3),
(419, '2021-11-17 04:57:09', '84.106.3.83', '', 3),
(420, '2021-11-17 05:01:33', '84.106.3.83', '', 3),
(421, '2021-11-17 05:03:06', '84.106.3.83', '', 3),
(422, '2021-11-17 05:05:03', '84.106.3.83', '', 3),
(423, '2021-11-17 05:05:36', '84.106.3.83', '', 3),
(424, '2021-11-17 05:07:17', '84.106.3.83', '', 3),
(425, '2021-11-17 05:09:29', '84.106.3.83', '', 3),
(426, '2021-11-17 05:09:31', '84.106.3.83', 'https://torrentmedia.org/pmlogg.php', 3),
(427, '2021-11-17 05:09:34', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(428, '2021-11-17 05:09:37', '84.106.3.83', 'https://torrentmedia.org/setclass.php?', 3),
(429, '2021-11-17 05:09:37', '84.106.3.83', 'https://torrentmedia.org/setclass.php?', 3),
(430, '2021-11-17 05:09:40', '84.106.3.83', 'https://torrentmedia.org/userdetails.php?id=3', 3),
(431, '2021-11-17 05:09:40', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(432, '2021-11-17 05:09:40', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(433, '2021-11-17 05:09:40', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(434, '2021-11-17 05:11:38', '84.106.3.83', 'https://torrentmedia.org/userdetails.php?id=3', 3),
(435, '2021-11-17 05:11:38', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(436, '2021-11-17 05:11:38', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(437, '2021-11-17 05:11:38', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(438, '2021-11-17 05:11:40', '84.106.3.83', 'https://torrentmedia.org/userdetails.php?id=3', 3),
(439, '2021-11-17 05:11:40', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(440, '2021-11-17 05:11:40', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(441, '2021-11-17 05:11:40', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(442, '2021-11-17 05:11:41', '84.106.3.83', 'https://torrentmedia.org/userdetails.php?id=3', 3),
(443, '2021-11-17 05:11:41', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(444, '2021-11-17 05:11:41', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(445, '2021-11-17 05:11:41', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(446, '2021-11-17 05:12:44', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(447, '2021-11-17 05:12:45', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(448, '2021-11-17 05:12:55', '84.106.3.83', 'https://torrentmedia.org/index.php', 3),
(449, '2021-11-17 05:13:05', '84.106.3.83', '', 3),
(450, '2021-11-17 05:13:31', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php', 3),
(451, '2021-11-17 05:13:35', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(452, '2021-11-17 05:13:37', '84.106.3.83', 'https://torrentmedia.org/setclass.php?', 3),
(453, '2021-11-17 05:13:37', '84.106.3.83', 'https://torrentmedia.org/setclass.php?', 3),
(454, '2021-11-17 05:13:43', '84.106.3.83', 'https://torrentmedia.org/userdetails.php?id=3', 3),
(455, '2021-11-17 05:13:43', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(456, '2021-11-17 05:13:43', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(457, '2021-11-17 05:13:43', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(458, '2021-11-17 05:14:15', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(459, '2021-11-17 05:14:15', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/my.php?', 3),
(460, '2021-11-17 05:14:15', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/my.php?', 3),
(461, '2021-11-17 05:14:15', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/my.php?', 3),
(462, '2021-11-17 05:14:18', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/my.php?', 3),
(463, '2021-11-17 05:14:18', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/upload_aanvraag.php?', 3),
(464, '2021-11-17 05:14:18', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/upload_aanvraag.php?', 3),
(465, '2021-11-17 05:14:18', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/upload_aanvraag.php?', 3),
(466, '2021-11-17 05:14:19', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/upload_aanvraag.php?', 3),
(467, '2021-11-17 05:14:20', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/shoutbox.php?', 3),
(468, '2021-11-17 05:14:20', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/shoutbox.php?', 3),
(469, '2021-11-17 05:14:20', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/shoutbox.php?', 3),
(470, '2021-11-17 05:14:28', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/shoutbox.php?', 3),
(471, '2021-11-17 05:14:28', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/browse.php?', 3),
(472, '2021-11-17 05:14:28', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/browse.php?', 3),
(473, '2021-11-17 05:14:28', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/browse.php?', 3),
(474, '2021-11-17 05:14:40', '84.106.3.83', '', 3),
(475, '2021-11-17 05:14:44', '84.106.3.83', 'https://torrentmedia.org//browse.php?', 3),
(476, '2021-11-17 05:14:44', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(477, '2021-11-17 05:14:44', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(478, '2021-11-17 05:14:44', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php/', 3),
(479, '2021-11-17 05:14:51', '84.106.3.83', '', 3),
(480, '2021-11-17 05:15:04', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php?/', 3),
(481, '2021-11-17 05:15:04', '84.106.3.83', 'https://torrentmedia.org/rutorrent.php?/', 3),
(482, '2021-11-17 06:08:33', '84.106.3.83', 'https://torrentmedia.org/login.php?returnto=%2F', 3),
(483, '2021-11-17 06:10:55', '84.106.3.83', 'https://server1843.seedhost.eu/', 3),
(484, '2021-11-17 06:10:58', '84.106.3.83', 'https://torrentmedia.org/', 3),
(485, '2021-11-17 06:13:03', '84.106.3.83', 'https://torrentmedia.org/login.php?returnto=%2F', 3),
(486, '2021-11-17 06:13:04', '84.106.3.83', 'https://torrentmedia.org/', 3),
(487, '2021-11-17 06:13:17', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(488, '2021-11-17 06:13:19', '84.106.3.83', 'https://torrentmedia.org/Moderator.php?', 3),
(489, '2021-11-17 06:13:23', '84.106.3.83', 'https://torrentmedia.org/users_unconfirmed.php?', 3),
(490, '2021-11-17 06:13:27', '84.106.3.83', 'https://torrentmedia.org/staff.php?', 3),
(491, '2021-11-17 06:13:51', '84.106.3.83', 'https://torrentmedia.org/gebruikers_overzicht.php', 3),
(492, '2021-11-17 06:14:00', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(493, '2021-11-17 06:15:07', '84.106.3.83', 'https://torrentmedia.org/mods.php?', 3),
(494, '2021-11-17 06:15:42', '84.106.3.83', 'https://torrentmedia.org/mods.php', 3),
(495, '2021-11-17 06:27:25', '84.106.3.83', 'https://torrentmedia.org/browse.php?', 3),
(496, '2021-11-17 09:49:04', '82.72.28.152', '', 302),
(497, '2021-11-17 09:49:10', '82.72.28.152', 'http://torrentmedia.org/login.php?returnto=%2F', 302),
(498, '2021-11-17 14:20:25', '84.106.3.83', 'https://server1843.seedhost.eu/', 3),
(499, '2021-11-17 14:20:31', '84.106.3.83', 'https://torrentmedia.org/', 3),
(500, '2021-11-17 14:20:32', '84.106.3.83', 'https://torrentmedia.org/site_regels.php?', 3),
(501, '2021-11-17 14:20:38', '84.106.3.83', 'https://torrentmedia.org/staff.php?', 3),
(502, '2021-11-17 14:21:15', '84.106.3.83', 'https://torrentmedia.org/userdetails.php?id=190', 3),
(503, '2021-11-17 14:21:41', '84.106.3.83', 'https://torrentmedia.org/user_ip_overzicht.php?id=190', 3),
(504, '2021-11-17 14:21:41', '84.106.3.83', 'https://torrentmedia.org/user_ip_overzicht.php?id=190', 3),
(505, '2021-11-17 14:21:48', '84.106.3.83', 'https://torrentmedia.org/user_ip_overzicht.php?id=190', 3),
(506, '2021-11-17 14:21:57', '84.106.3.83', 'https://torrentmedia.org/upload_info.php?', 3),
(507, '2021-11-17 14:22:15', '84.106.3.83', 'https://torrentmedia.org/staff.php?', 3),
(508, '2021-11-17 22:52:58', '84.106.3.83', '', 3),
(509, '2021-11-17 22:53:02', '84.106.3.83', 'https://torrentmedia.org/', 3),
(510, '2021-11-17 22:53:06', '84.106.3.83', 'https://torrentmedia.org/staff.php?', 3),
(511, '2021-11-17 22:53:25', '84.106.3.83', 'https://torrentmedia.org/userdetails.php?id=190', 3),
(512, '2021-11-17 22:53:29', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(513, '2021-11-17 22:53:33', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(514, '2021-11-17 22:53:34', '84.106.3.83', 'https://torrentmedia.org/Moderator.php?', 3),
(515, '2021-11-17 22:53:38', '84.106.3.83', 'https://torrentmedia.org/users_unconfirmed.php?', 3),
(516, '2021-11-17 22:53:38', '84.106.3.83', 'https://torrentmedia.org/users_unconfirmed.php?', 3),
(517, '2021-11-17 22:53:51', '84.106.3.83', 'https://torrentmedia.org/users_unconfirmed.php', 3),
(518, '2021-11-17 23:47:55', '163.158.56.71', '', 300),
(519, '2021-11-19 00:06:40', '163.158.56.71', '', 300),
(520, '2021-11-19 20:39:08', '84.193.87.230', 'https://torrentmedia.org/login.php?returnto=%2F', 190),
(521, '2021-11-19 20:39:16', '84.193.87.230', 'https://torrentmedia.org/', 190),
(522, '2021-11-19 20:39:24', '84.193.87.230', 'https://torrentmedia.org/inbox.php', 190),
(523, '2021-11-19 20:39:40', '84.193.87.230', 'https://torrentmedia.org/inbox.php?message_id=652', 190),
(524, '2021-11-19 20:40:00', '84.193.87.230', 'https://torrentmedia.org/browse.php?', 190),
(525, '2021-11-19 20:40:04', '84.193.87.230', 'https://torrentmedia.org/upload_info.php?', 190),
(526, '2021-11-19 20:40:12', '84.193.87.230', 'https://torrentmedia.org/upload.php', 190),
(527, '2021-11-20 00:10:43', '163.158.56.71', '', 300),
(528, '2021-11-20 00:14:08', '163.158.56.71', '', 300),
(529, '2021-11-20 00:14:11', '163.158.56.71', '', 300),
(530, '2021-11-20 00:14:16', '163.158.56.71', 'https://torrentmedia.org/', 300),
(531, '2021-11-20 00:14:21', '163.158.56.71', 'https://torrentmedia.org/browse.php?', 300),
(532, '2021-11-20 00:14:28', '163.158.56.71', 'https://torrentmedia.org/shoutbox.php?', 300),
(533, '2021-11-20 00:14:39', '163.158.56.71', 'https://torrentmedia.org/userdetails.php?id=3', 300),
(534, '2021-11-20 00:14:45', '163.158.56.71', 'https://torrentmedia.org/staff.php?', 300),
(535, '2021-11-20 23:58:30', '163.158.56.71', '', 300),
(536, '2021-11-21 01:52:28', '84.106.3.83', 'https://torrentmedia.org/login.php?returnto=%2F', 3),
(537, '2021-11-21 01:52:32', '84.106.3.83', 'https://torrentmedia.org/', 3),
(538, '2021-11-21 01:52:33', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(539, '2021-11-21 01:52:34', '84.106.3.83', 'https://torrentmedia.org/Moderator.php?', 3),
(540, '2021-11-21 01:52:49', '84.106.3.83', 'https://torrentmedia.org/users_unconfirmed.php?', 3),
(541, '2021-11-21 01:52:50', '84.106.3.83', 'https://torrentmedia.org/users_unconfirmed.php?', 3),
(542, '2021-11-21 01:52:51', '84.106.3.83', 'https://torrentmedia.org/users_unconfirmed.php?', 3),
(543, '2021-11-21 01:52:54', '84.106.3.83', 'https://torrentmedia.org/users_unconfirmed.php', 3),
(544, '2021-11-21 01:52:57', '84.106.3.83', 'https://torrentmedia.org/staff.php?', 3),
(545, '2021-11-22 00:03:15', '163.158.56.71', '', 300),
(546, '2021-11-23 00:35:18', '163.158.56.71', '', 300),
(547, '2021-11-23 10:39:02', '195.78.54.239', 'https://torrentmedia.org/login.php?returnto=%2F', 305),
(548, '2021-11-23 10:39:02', '195.78.54.239', 'https://torrentmedia.org/login.php?returnto=%2F', 305),
(549, '2021-11-23 10:39:11', '195.78.54.239', 'https://torrentmedia.org/inbox.php', 305),
(550, '2021-11-23 10:39:11', '195.78.54.239', 'https://torrentmedia.org/inbox.php', 305),
(551, '2021-11-23 10:39:18', '195.78.54.239', 'https://torrentmedia.org/inbox.php', 305),
(552, '2021-11-23 10:39:23', '195.78.54.239', 'https://torrentmedia.org/inbox.php?', 305),
(553, '2021-11-23 10:39:23', '195.78.54.239', 'https://torrentmedia.org/inbox.php?', 305),
(554, '2021-11-23 10:39:32', '195.78.54.239', 'https://torrentmedia.org/inbox.php', 305),
(555, '2021-11-23 10:39:34', '195.78.54.239', 'https://torrentmedia.org/inbox.php?', 305),
(556, '2021-11-23 10:39:35', '195.78.54.239', 'https://torrentmedia.org/take-delmpx.php', 305),
(557, '2021-11-23 10:39:40', '195.78.54.239', 'https://torrentmedia.org/inbox.php', 305),
(558, '2021-11-23 10:39:46', '195.78.54.239', 'https://torrentmedia.org/inbox.php?', 305),
(559, '2021-11-23 10:40:02', '195.78.54.239', 'https://torrentmedia.org/inbox.php?', 305),
(560, '2021-11-23 10:40:03', '195.78.54.239', 'https://torrentmedia.org/inbox.php?', 305),
(561, '2021-11-23 10:40:03', '195.78.54.239', 'https://torrentmedia.org/inbox.php?', 305),
(562, '2021-11-23 10:40:05', '195.78.54.239', 'https://torrentmedia.org/inbox.php', 305),
(563, '2021-11-23 10:40:05', '195.78.54.239', 'https://torrentmedia.org/take-delmpx.php', 305),
(564, '2021-11-23 10:40:09', '195.78.54.239', 'https://torrentmedia.org/inbox.php', 305),
(565, '2021-11-23 10:40:24', '195.78.54.239', 'https://torrentmedia.org/inbox.php?message_id=646', 305),
(566, '2021-11-23 10:40:34', '195.78.54.239', 'https://torrentmedia.org/browse.php?', 305),
(567, '2021-11-23 10:40:36', '195.78.54.239', 'https://torrentmedia.org/browse.php?', 305),
(568, '2021-11-23 10:40:38', '195.78.54.239', 'https://torrentmedia.org/browse.php?', 305),
(569, '2021-11-23 10:40:41', '195.78.54.239', 'https://torrentmedia.org/browse.php?all=1', 305),
(570, '2021-11-23 10:40:48', '195.78.54.239', 'https://torrentmedia.org/inbox.php', 305),
(571, '2021-11-23 10:40:49', '195.78.54.239', 'https://torrentmedia.org/shoutbox.php?', 305),
(572, '2021-11-23 10:40:53', '195.78.54.239', 'https://torrentmedia.org/credits.php?', 305),
(573, '2021-11-23 10:40:59', '195.78.54.239', 'https://torrentmedia.org/donatie.php', 305),
(574, '2021-11-23 10:41:02', '195.78.54.239', 'https://torrentmedia.org/browse.php?', 305),
(575, '2021-11-24 00:02:20', '163.158.56.71', '', 300),
(576, '2021-11-24 23:08:48', '163.158.56.71', '', 300),
(577, '2021-11-25 23:05:27', '163.158.56.71', '', 300),
(578, '2021-11-25 23:08:43', '163.158.56.71', '', 300),
(579, '2021-11-25 23:08:47', '163.158.56.71', 'https://torrentmedia.org/', 300),
(580, '2021-11-25 23:08:53', '163.158.56.71', 'https://torrentmedia.org/browse.php?', 300),
(581, '2021-11-26 19:19:40', '84.193.87.230', '', 190),
(582, '2021-11-26 19:19:44', '84.193.87.230', '', 190),
(583, '2021-11-26 19:19:50', '84.193.87.230', 'https://torrentmedia.org/', 190),
(584, '2021-11-27 00:01:51', '163.158.56.71', '', 300),
(585, '2021-11-27 21:10:08', '84.106.3.83', 'https://torrentmedia.org/login.php?returnto=%2F', 3),
(586, '2021-11-27 21:10:14', '84.106.3.83', 'https://torrentmedia.org/', 3),
(587, '2021-11-27 21:10:15', '84.106.3.83', 'https://torrentmedia.org/Moderator.php?', 3),
(588, '2021-11-27 21:10:25', '84.106.3.83', 'https://torrentmedia.org/users_unconfirmed.php?', 3),
(589, '2021-11-27 21:10:32', '84.106.3.83', 'https://torrentmedia.org/staff.php?', 3),
(590, '2021-11-27 21:10:33', '84.106.3.83', 'https://torrentmedia.org/staff.php?', 3),
(591, '2021-11-27 21:10:35', '84.106.3.83', 'https://torrentmedia.org/Moderator.php?', 3),
(592, '2021-11-27 21:10:40', '84.106.3.83', 'https://torrentmedia.org/staff.php?', 3),
(593, '2021-11-27 21:10:51', '84.106.3.83', 'https://torrentmedia.org/gebruikers_overzicht.php', 3),
(594, '2021-11-27 21:11:08', '84.106.3.83', 'https://torrentmedia.org/userdetails.php?id=302', 3),
(595, '2021-11-27 21:11:27', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(596, '2021-11-27 21:11:42', '84.106.3.83', 'https://torrentmedia.org/God.php?', 3),
(597, '2021-11-27 21:12:44', '84.106.3.83', 'https://torrentmedia.org/log_login.php?', 3),
(598, '2021-11-27 23:05:30', '163.158.56.71', '', 300),
(599, '2021-11-28 00:47:32', '51.195.107.236', 'https://server1843.seedhost.eu/', 3),
(600, '2021-11-30 18:52:16', '127.0.0.1', '', 3),
(601, '2021-11-30 18:52:34', '127.0.0.1', 'http://cmlrfdtuhre53hsywxhjzwbfo4ve4nepdhy2tmhgpxibtvqz5usnpkyd.onion/', 3),
(602, '2021-11-30 18:52:53', '127.0.0.1', 'http://cmlrfdtuhre53hsywxhjzwbfo4ve4nepdhy2tmhgpxibtvqz5usnpkyd.onion/userdetails.php?id=3', 3),
(603, '2021-11-30 18:53:01', '127.0.0.1', 'http://cmlrfdtuhre53hsywxhjzwbfo4ve4nepdhy2tmhgpxibtvqz5usnpkyd.onion/my.php?', 3),
(604, '2021-11-30 18:54:44', '127.0.0.1', 'http://cmlrfdtuhre53hsywxhjzwbfo4ve4nepdhy2tmhgpxibtvqz5usnpkyd.onion/password.php', 3),
(605, '2021-11-30 18:54:45', '127.0.0.1', 'http://cmlrfdtuhre53hsywxhjzwbfo4ve4nepdhy2tmhgpxibtvqz5usnpkyd.onion/password.php', 3),
(606, '2023-07-03 03:33:25', '83.83.102.213', 'https://torrent.media.progoogle.nl/login.php?returnto=%2F', 3),
(607, '2023-07-03 03:36:18', '83.83.102.213', 'https://torrent.media.progoogle.nl/', 3),
(608, '2023-07-03 03:36:42', '83.83.102.213', 'https://torrent.media.progoogle.nl/God.php?', 3),
(609, '2023-07-03 03:37:20', '83.83.102.213', 'https://torrent.media.progoogle.nl/Moderator.php?', 3),
(610, '2023-07-03 03:37:26', '83.83.102.213', 'https://torrent.media.progoogle.nl/my.php?', 3),
(611, '2023-07-03 03:38:14', '83.83.102.213', 'https://torrent.media.progoogle.nl/password.php', 3),
(612, '2023-07-03 03:49:35', '83.83.102.213', 'https://torrent.media.progoogle.nl/password.php', 3),
(613, '2023-07-03 03:50:17', '83.83.102.213', 'https://torrent.media.progoogle.nl/password.php', 3),
(614, '2023-07-03 03:50:50', '83.83.102.213', 'https://torrent.media.progoogle.nl/password.php', 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `kijkwijzer`
--

CREATE TABLE `kijkwijzer` (
  `id` int(10) UNSIGNED NOT NULL,
  `omschrijving` varchar(30) NOT NULL DEFAULT '',
  `plaatje` varchar(255) NOT NULL DEFAULT '',
  `volgorde` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `link_forum`
--

CREATE TABLE `link_forum` (
  `id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime DEFAULT NULL,
  `info` varchar(120) NOT NULL DEFAULT '',
  `link` varchar(120) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `loginmessages`
--

CREATE TABLE `loginmessages` (
  `id` int(10) UNSIGNED NOT NULL,
  `sender` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `receiver` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime DEFAULT NULL,
  `msg` text DEFAULT NULL,
  `status` enum('donatie','singup','spam','hacken','schelden','no','hit') NOT NULL DEFAULT 'no',
  `ip` text DEFAULT NULL,
  `text2` text NOT NULL,
  `geholpen` enum('yes','no') NOT NULL DEFAULT 'no',
  `datum2` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `loterij`
--

CREATE TABLE `loterij` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `lot` varchar(20) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `massa_berichten`
--

CREATE TABLE `massa_berichten` (
  `id` int(10) UNSIGNED NOT NULL,
  `sender` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `aantal` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime DEFAULT NULL,
  `msg` text DEFAULT NULL,
  `done` enum('yes','no') NOT NULL DEFAULT 'no',
  `user_id_sender` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `massa_bericht_mods`
--

CREATE TABLE `massa_bericht_mods` (
  `id` int(10) UNSIGNED NOT NULL,
  `sender` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `aantal` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime DEFAULT NULL,
  `msg` text DEFAULT NULL,
  `done` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `massa_bericht_mods`
--

INSERT INTO `massa_bericht_mods` (`id`, `sender`, `aantal`, `added`, `msg`, `done`) VALUES
(2, 3, 1, '2021-07-01 15:25:51', 'Hallo,\r\n\r\n\r\n\r\nMet vriendelijke groet,\r\n\r\nTorrentMedia', 'yes'),
(5, 8, 6, '2021-09-23 01:16:59', 'Hallo,\r\n\r\nTorrentMedia is een Verzoekjes pagina Als u een leuke film heeft gezien en wilt u hem nog een zien meld het ons dan \r\ndat geld natuurlijk ook voor een serie of Kinderfilm Zelfde geld voor alle software\'s\r\nNieuwe films worden geupload daar hoeft u niet naar om te kijken \r\n\r\nMet vriendelijke groet,\r\n\r\nMr Media', 'yes');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `massa_bericht_torrents`
--

CREATE TABLE `massa_bericht_torrents` (
  `id` int(10) UNSIGNED NOT NULL,
  `sender` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `aantal` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime DEFAULT NULL,
  `msg` text DEFAULT NULL,
  `send_to` text DEFAULT NULL,
  `done` enum('yes','no') NOT NULL DEFAULT 'no',
  `torrent_id` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `sender` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `receiver` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `msg` text DEFAULT NULL,
  `unread` enum('yes','no') NOT NULL DEFAULT 'yes',
  `poster` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `location` enum('in','out','both') NOT NULL DEFAULT 'in'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `messages`
--

INSERT INTO `messages` (`id`, `sender`, `receiver`, `added`, `subject`, `msg`, `unread`, `poster`, `location`) VALUES
(656, 0, 308, '2021-11-18 02:54:08', NULL, 'Welkom op  Torrent Media, We zijn blij dat je je bij ons hebt aangemeld\r\nDe site voor:\r\nHigh quality Nederlands downloads.\r\nNet als bij vele collega-sites ben je verplicht om 1 op 1 te delen.\r\nOp Torrent Media is het ook verplicht om verbindbaar te zijn en DHT uit te zetten.\r\nAls je een van beide niet bent kun je niet down/uploaden van de tracker.\r\nU zult dit dan eerst in orde moeten maken om volledig gebruik te kunnen maken van de site.\r\nMocht je vragen hebben schroom dan niet om je moderator hiermee te belasten.\r\nDaar zijn ze tenslotte voor.\r\nRest ons nog u veel plezier te wensen van en bij Torrent Media\r\nStaff Torrent Media.', 'yes', 0, 'in'),
(651, 0, 306, '2021-11-15 19:34:08', NULL, 'Welkom op  Torrent Media, We zijn blij dat je je bij ons hebt aangemeld\r\nDe site voor:\r\nHigh quality Nederlands downloads.\r\nNet als bij vele collega-sites ben je verplicht om 1 op 1 te delen.\r\nOp Torrent Media is het ook verplicht om verbindbaar te zijn en DHT uit te zetten.\r\nAls je een van beide niet bent kun je niet down/uploaden van de tracker.\r\nU zult dit dan eerst in orde moeten maken om volledig gebruik te kunnen maken van de site.\r\nMocht je vragen hebben schroom dan niet om je moderator hiermee te belasten.\r\nDaar zijn ze tenslotte voor.\r\nRest ons nog u veel plezier te wensen van en bij Torrent Media\r\nStaff Torrent Media.', 'yes', 0, 'in'),
(652, 0, 190, '2021-11-17 02:20:15', NULL, 'Uw status is verhoogd naar \'Uploader\' door TorrentMedia.', 'no', 0, 'in'),
(645, 0, 304, '2021-11-14 15:18:51', NULL, 'Welkom op  Torrent Media, We zijn blij dat je je bij ons hebt aangemeld\r\nDe site voor:\r\nHigh quality Nederlands downloads.\r\nNet als bij vele collega-sites ben je verplicht om 1 op 1 te delen.\r\nOp Torrent Media is het ook verplicht om verbindbaar te zijn en DHT uit te zetten.\r\nAls je een van beide niet bent kun je niet down/uploaden van de tracker.\r\nU zult dit dan eerst in orde moeten maken om volledig gebruik te kunnen maken van de site.\r\nMocht je vragen hebben schroom dan niet om je moderator hiermee te belasten.\r\nDaar zijn ze tenslotte voor.\r\nRest ons nog u veel plezier te wensen van en bij Torrent Media\r\nStaff Torrent Media.', 'yes', 0, 'in'),
(646, 0, 305, '2021-11-14 20:40:22', NULL, 'Welkom op  Torrent Media, We zijn blij dat je je bij ons hebt aangemeld\r\nDe site voor:\r\nHigh quality Nederlands downloads.\r\nNet als bij vele collega-sites ben je verplicht om 1 op 1 te delen.\r\nOp Torrent Media is het ook verplicht om verbindbaar te zijn en DHT uit te zetten.\r\nAls je een van beide niet bent kun je niet down/uploaden van de tracker.\r\nU zult dit dan eerst in orde moeten maken om volledig gebruik te kunnen maken van de site.\r\nMocht je vragen hebben schroom dan niet om je moderator hiermee te belasten.\r\nDaar zijn ze tenslotte voor.\r\nRest ons nog u veel plezier te wensen van en bij Torrent Media\r\nStaff Torrent Media.', 'no', 0, 'in'),
(639, 0, 298, '2021-11-13 10:35:52', NULL, 'Welkom op  Torrent Media, We zijn blij dat je je bij ons hebt aangemeld\r\nDe site voor:\r\nHigh quality Nederlands downloads.\r\nNet als bij vele collega-sites ben je verplicht om 1 op 1 te delen.\r\nOp Torrent Media is het ook verplicht om verbindbaar te zijn en DHT uit te zetten.\r\nAls je een van beide niet bent kun je niet down/uploaden van de tracker.\r\nU zult dit dan eerst in orde moeten maken om volledig gebruik te kunnen maken van de site.\r\nMocht je vragen hebben schroom dan niet om je moderator hiermee te belasten.\r\nDaar zijn ze tenslotte voor.\r\nRest ons nog u veel plezier te wensen van en bij Torrent Media\r\nStaff Torrent Media.', 'yes', 0, 'in'),
(640, 0, 299, '2021-11-13 13:38:34', NULL, 'Welkom op  Torrent Media, We zijn blij dat je je bij ons hebt aangemeld\r\nDe site voor:\r\nHigh quality Nederlands downloads.\r\nNet als bij vele collega-sites ben je verplicht om 1 op 1 te delen.\r\nOp Torrent Media is het ook verplicht om verbindbaar te zijn en DHT uit te zetten.\r\nAls je een van beide niet bent kun je niet down/uploaden van de tracker.\r\nU zult dit dan eerst in orde moeten maken om volledig gebruik te kunnen maken van de site.\r\nMocht je vragen hebben schroom dan niet om je moderator hiermee te belasten.\r\nDaar zijn ze tenslotte voor.\r\nRest ons nog u veel plezier te wensen van en bij Torrent Media\r\nStaff Torrent Media.', 'yes', 0, 'in'),
(644, 0, 303, '2021-11-14 01:54:22', NULL, 'Welkom op  Torrent Media, We zijn blij dat je je bij ons hebt aangemeld\r\nDe site voor:\r\nHigh quality Nederlands downloads.\r\nNet als bij vele collega-sites ben je verplicht om 1 op 1 te delen.\r\nOp Torrent Media is het ook verplicht om verbindbaar te zijn en DHT uit te zetten.\r\nAls je een van beide niet bent kun je niet down/uploaden van de tracker.\r\nU zult dit dan eerst in orde moeten maken om volledig gebruik te kunnen maken van de site.\r\nMocht je vragen hebben schroom dan niet om je moderator hiermee te belasten.\r\nDaar zijn ze tenslotte voor.\r\nRest ons nog u veel plezier te wensen van en bij Torrent Media\r\nStaff Torrent Media.', 'yes', 0, 'in'),
(642, 0, 301, '2021-11-13 17:54:50', NULL, 'Welkom op  Torrent Media, We zijn blij dat je je bij ons hebt aangemeld\r\nDe site voor:\r\nHigh quality Nederlands downloads.\r\nNet als bij vele collega-sites ben je verplicht om 1 op 1 te delen.\r\nOp Torrent Media is het ook verplicht om verbindbaar te zijn en DHT uit te zetten.\r\nAls je een van beide niet bent kun je niet down/uploaden van de tracker.\r\nU zult dit dan eerst in orde moeten maken om volledig gebruik te kunnen maken van de site.\r\nMocht je vragen hebben schroom dan niet om je moderator hiermee te belasten.\r\nDaar zijn ze tenslotte voor.\r\nRest ons nog u veel plezier te wensen van en bij Torrent Media\r\nStaff Torrent Media.', 'yes', 0, 'in'),
(643, 0, 302, '2021-11-13 20:55:58', NULL, 'Welkom op  Torrent Media, We zijn blij dat je je bij ons hebt aangemeld\r\nDe site voor:\r\nHigh quality Nederlands downloads.\r\nNet als bij vele collega-sites ben je verplicht om 1 op 1 te delen.\r\nOp Torrent Media is het ook verplicht om verbindbaar te zijn en DHT uit te zetten.\r\nAls je een van beide niet bent kun je niet down/uploaden van de tracker.\r\nU zult dit dan eerst in orde moeten maken om volledig gebruik te kunnen maken van de site.\r\nMocht je vragen hebben schroom dan niet om je moderator hiermee te belasten.\r\nDaar zijn ze tenslotte voor.\r\nRest ons nog u veel plezier te wensen van en bij Torrent Media\r\nStaff Torrent Media.', 'no', 0, 'in');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `messages_sjabloon`
--

CREATE TABLE `messages_sjabloon` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL DEFAULT 0,
  `sjabloon` varchar(35) NOT NULL DEFAULT '',
  `sjabloon_msg` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `moderators`
--

CREATE TABLE `moderators` (
  `id` int(11) NOT NULL,
  `letter` varchar(10) NOT NULL DEFAULT '',
  `userid` int(5) DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `mod_letters`
--

CREATE TABLE `mod_letters` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `letter` text NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `mod_letters`
--

INSERT INTO `mod_letters` (`id`, `userid`, `letter`, `added`) VALUES
(1, 3, 'A', '2021-11-17 06:15:07'),
(2, 3, 'B', '2021-11-17 06:15:07'),
(3, 3, 'C', '2021-11-17 06:15:07'),
(4, 3, 'D', '2021-11-17 06:15:07'),
(5, 3, 'E', '2021-11-17 06:15:07'),
(6, 3, 'F', '2021-11-17 06:15:07'),
(7, 3, 'G', '2021-11-17 06:15:07'),
(8, 3, 'H', '2021-11-17 06:15:07'),
(9, 3, 'I', '2021-11-17 06:15:07'),
(10, 3, 'J', '2021-11-17 06:15:07'),
(11, 3, 'K', '2021-11-17 06:15:07'),
(12, 3, 'L', '2021-11-17 06:15:07'),
(13, 3, 'M', '2021-11-17 06:15:07'),
(14, 3, 'N', '2021-11-17 06:15:07'),
(15, 3, 'O', '2021-11-17 06:15:07'),
(16, 3, 'P', '2021-11-17 06:15:07'),
(17, 3, 'Q', '2021-11-17 06:15:07'),
(18, 3, 'R', '2021-11-17 06:15:07'),
(19, 3, 'S', '2021-11-17 06:15:07'),
(20, 3, 'T', '2021-11-17 06:15:07'),
(21, 3, 'U', '2021-11-17 06:15:07'),
(22, 3, 'V', '2021-11-17 06:15:07'),
(23, 3, 'W', '2021-11-17 06:15:07'),
(24, 3, 'X', '2021-11-17 06:15:07'),
(25, 3, 'Y', '2021-11-17 06:15:07'),
(26, 3, 'Z', '2021-11-17 06:15:07'),
(27, 3, '0', '2021-11-17 06:15:07'),
(28, 3, '1', '2021-11-17 06:15:07'),
(29, 3, '2', '2021-11-17 06:15:07'),
(30, 3, '3', '2021-11-17 06:15:07'),
(31, 3, '4', '2021-11-17 06:15:07'),
(32, 3, '5', '2021-11-17 06:15:07'),
(33, 3, '6', '2021-11-17 06:15:07'),
(34, 3, '7', '2021-11-17 06:15:07'),
(35, 3, '8', '2021-11-17 06:15:07'),
(36, 3, '9', '2021-11-17 06:15:07');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `mychat_c_ban_users`
--

CREATE TABLE `mychat_c_ban_users` (
  `username` varchar(30) NOT NULL DEFAULT '',
  `latin1` tinyint(1) NOT NULL DEFAULT 0,
  `ip` varchar(16) NOT NULL DEFAULT '',
  `rooms` varchar(100) NOT NULL DEFAULT '',
  `ban_until` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `mychat_c_messages`
--

CREATE TABLE `mychat_c_messages` (
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `room` varchar(30) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `latin1` tinyint(1) NOT NULL DEFAULT 0,
  `m_time` int(11) NOT NULL DEFAULT 0,
  `address` varchar(30) NOT NULL DEFAULT '',
  `message` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `mychat_c_users`
--

CREATE TABLE `mychat_c_users` (
  `room` varchar(30) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `latin1` tinyint(1) NOT NULL DEFAULT 0,
  `u_time` int(11) NOT NULL DEFAULT 0,
  `status` char(1) NOT NULL DEFAULT '',
  `ip` varchar(16) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `news`
--

CREATE TABLE `news` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `body` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `news_staff`
--

CREATE TABLE `news_staff` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `body` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `nzbcategories`
--

CREATE TABLE `nzbcategories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `nzbcategories`
--

INSERT INTO `nzbcategories` (`id`, `name`, `image`) VALUES
(3, 'Anime', 'sml_anime.gif'),
(6, 'Appz/PC 0 Day', 'sml_apps0day.gif'),
(9, 'Appz/Misc', 'sml_appsmisc.gif'),
(12, 'Appz/PC ISO', 'sml_appspciso.gif'),
(15, 'eBooks', 'sml_ebook.gif'),
(18, 'Educational', 'sml_educat.gif'),
(21, 'Games/GBA', 'sml_gamesgba.gif'),
(24, 'Games/Other', 'sml_gamesother.gif'),
(27, 'Games/PC', 'sml_gamespc.gif'),
(30, 'Games/PS2', 'sml_gamesps2.gif'),
(33, 'Games/PSP', 'sml_gamespsp.gif'),
(36, 'Games/Retro', 'sml_gamesretro.gif'),
(39, 'Games/XBOX', 'sml_gamesxbox.gif'),
(42, 'Kidz', 'sml_kids.gif'),
(45, 'Movies/DVDR', 'sml_moviedvd.gif'),
(48, 'Movies/Other', 'sml_movieother.gif'),
(51, 'Movies/XviD', 'sml_moviexvid.gif'),
(54, 'Music/mp3', 'sml_musicmp3.gif'),
(57, 'Music/Other', 'sml_musicother.gif'),
(60, 'Music/Video', 'sml_musicvid.gif'),
(63, 'Other/Misc', 'sml_misc.gif'),
(66, 'Pars/etc', 'sml_parsetc.gif'),
(69, 'TV/DVDR', 'sml_tvdvdr.gif'),
(72, 'TV/Other', 'sml_tvother.gif'),
(75, 'TV/XviD', 'sml_tvxvid.gif'),
(78, 'XXX/DVD', 'sml_xxxdvd.gif'),
(81, 'XXX/Other', 'sml_xxxother.gif'),
(84, 'XXX/XviD', 'sml_xxxxvid.gif');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `nzbcomments`
--

CREATE TABLE `nzbcomments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `nzb` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` text NOT NULL,
  `ori_text` text NOT NULL,
  `editedby` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `editedat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `nzbdlstats`
--

CREATE TABLE `nzbdlstats` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `number` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `nzbpiecelist`
--

CREATE TABLE `nzbpiecelist` (
  `id` int(10) UNSIGNED NOT NULL,
  `nzb` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `nzb_piece` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `filepiece` text NOT NULL,
  `piece_poster` text NOT NULL,
  `piece_date` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `piece_subject` text NOT NULL,
  `piece_groups` text NOT NULL,
  `piece_size` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `piece_segments` bigint(20) NOT NULL DEFAULT 0,
  `piece_subjseg` bigint(20) NOT NULL DEFAULT 0,
  `piece_par` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `nzbpiecelist`
--

INSERT INTO `nzbpiecelist` (`id`, `nzb`, `nzb_piece`, `filepiece`, `piece_poster`, `piece_date`, `piece_subject`, `piece_groups`, `piece_size`, `piece_segments`, `piece_subjseg`, `piece_par`) VALUES
(1, 1, 0, '<file poster=\"Cat &lt;eager-poster@computer&gt;\" date=\"1619180284\" subject=\"[20/33] - &quot;17-tha_playah-keep_them_titties_jumping-.mp3&quot; yEnc  12989471 (1/19)\">\r\n<groups>\r\n<group>alt.binaries.misc</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"739707\" number=\"8\">MsGsXzQwSsYiHaFcHyTuAnJq-1619180284007@nyuu</segment>\r\n<segment bytes=\"739413\" number=\"1\">XzMuUkRaHpDrCpXlKpEwYuTp-1619180281404@nyuu</segment>\r\n<segment bytes=\"739466\" number=\"3\">OoGeXiMoFgNhSvEySnKfMaUb-1619180282341@nyuu</segment>\r\n<segment bytes=\"739778\" number=\"5\">XiOdZrNfRyKqXkPeGoArTgVg-1619180282911@nyuu</segment>\r\n<segment bytes=\"739870\" number=\"16\">PwYgXoQpOqSfSnYwZhQpKaQi-1619180286669@nyuu</segment>\r\n<segment bytes=\"739548\" number=\"14\">PvHyFmFnCfDmKaIcKqBgLxKw-1619180286335@nyuu</segment>\r\n<segment bytes=\"739515\" number=\"18\">JtPiViXtUpAoSsQhXxNiMlXm-1619180287386@nyuu</segment>\r\n<segment bytes=\"739470\" number=\"2\">YdEbCmKaHwBcYuSgHdHeClAy-1619180281454@nyuu</segment>\r\n<segment bytes=\"739680\" number=\"4\">ZiFvMjKsTiGjEjMvVeNsAgZy-1619180282877@nyuu</segment>\r\n<segment bytes=\"739585\" number=\"9\">TsNkUgAgYyLmDzBoIzVpFtGk-1619180284623@nyuu</segment>\r\n<segment bytes=\"739493\" number=\"7\">BaBcQsToSqFkQiFmSvOtHiUx-1619180283934@nyuu</segment>\r\n<segment bytes=\"739638\" number=\"15\">GoXrWtTfGwAeNbZnXiZtAkIg-1619180286459@nyuu</segment>\r\n<segment bytes=\"90655\" number=\"19\">WfTyIfOmNmZiAaOfEaOeGiJh-1619180287850@nyuu</segment>\r\n<segment bytes=\"739642\" number=\"17\">VtMeBuDpMtAwDvMcToXkHpKl-1619180287147@nyuu</segment>\r\n<segment bytes=\"739342\" number=\"6\">VeOnGtIcSxWeSkErAiInIgIc-1619180283829@nyuu</segment>\r\n<segment bytes=\"739506\" number=\"13\">XhKwJyEdJtViVnHrWaQfXqOq-1619180285884@nyuu</segment>\r\n<segment bytes=\"739661\" number=\"11\">BrXcYnGeCpHfFpBaNiEcOvVt-1619180285272@nyuu</segment>\r\n<segment bytes=\"739388\" number=\"12\">WuZrZeGcEaTpGdFlIwDhSqRd-1619180285279@nyuu</segment>\r\n<segment bytes=\"739519\" number=\"10\">OcJoEyJtRrQfWcQgVyAxWiUv-1619180285202@nyuu</segment>\r\n</segments>\r\n', 'Cat <eager-poster@computer>', 1619180284, '[20/33] - \"17-tha_playah-keep_them_titties_jumping-.mp3\" yEnc  12989471 (1/19)', 'a:1:{i:0;s:17:\"alt.binaries.misc\";}', 13402876, 19, 19, '1'),
(2, 1, 1, '<file poster=\"Cat &lt;eager-poster@computer&gt;\" date=\"1619180303\" subject=\"[23/33] - &quot;20-tha_playah-who_ya_rocking_with-.mp3&quot; yEnc  12339533 (1/18)\">\r\n<groups>\r\n<group>alt.binaries.misc</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"739435\" number=\"1\">CfEiFoOdXbAoMhAoDwZyIvIo-1619180301506@nyuu</segment>\r\n<segment bytes=\"739890\" number=\"16\">PqPuZrSbHtHvTcPtEsEsHcMu-1619180306097@nyuu</segment>\r\n<segment bytes=\"159611\" number=\"18\">YtLnIjGrXbXuIzJaOlEzGsVk-1619180306744@nyuu</segment>\r\n<segment bytes=\"739540\" number=\"11\">FxKeQhMpIsHzTpGfGvOhMoZj-1619180304585@nyuu</segment>\r\n<segment bytes=\"739421\" number=\"4\">KfZzRzAvJhAxStVpHaPvYuPo-1619180302433@nyuu</segment>\r\n<segment bytes=\"739800\" number=\"5\">EmShOiVkItOiLzRvRpPtCwUc-1619180303109@nyuu</segment>\r\n<segment bytes=\"739528\" number=\"6\">MoXpRhHtMyZmHcZxEjZqVvEf-1619180303205@nyuu</segment>\r\n<segment bytes=\"739256\" number=\"7\">JgXeOdVqUoXeQbZuZkLmNnPo-1619180303383@nyuu</segment>\r\n<segment bytes=\"739443\" number=\"10\">ZoNgZtZeSzJjVjJsFtKaXkYa-1619180304333@nyuu</segment>\r\n<segment bytes=\"739584\" number=\"2\">UzMyLbPyKeIrKwZdGtUvQwOb-1619180301847@nyuu</segment>\r\n<segment bytes=\"739564\" number=\"12\">EnEuDhThLtWqVqXnGmMmZkBi-1619180304986@nyuu</segment>\r\n<segment bytes=\"739393\" number=\"13\">WzHzXuXbDzEeWnEcLiErFxXz-1619180305283@nyuu</segment>\r\n<segment bytes=\"739615\" number=\"8\">ExKiZsAtUvWnImZiKrWfDvVg-1619180303511@nyuu</segment>\r\n<segment bytes=\"739549\" number=\"14\">LbItRkUyAaYmQuVrLpGkCjIz-1619180305291@nyuu</segment>\r\n<segment bytes=\"739616\" number=\"3\">SkNiSeDnMiToZnOgGtRpZrBo-1619180302403@nyuu</segment>\r\n<segment bytes=\"739317\" number=\"9\">RsGxAiSqVnKjSiDgSqPoYtNl-1619180303853@nyuu</segment>\r\n<segment bytes=\"739712\" number=\"15\">FoAwZeGiLdDwVwXiDkUwBdRa-1619180306069@nyuu</segment>\r\n<segment bytes=\"739709\" number=\"17\">EwXwNsZaYeNlJaNhNbLqKhRe-1619180306111@nyuu</segment>\r\n</segments>\r\n', 'Cat <eager-poster@computer>', 1619180303, '[23/33] - \"20-tha_playah-who_ya_rocking_with-.mp3\" yEnc  12339533 (1/18)', 'a:1:{i:0;s:17:\"alt.binaries.misc\";}', 12731983, 18, 18, '1'),
(3, 2, 0, '<file poster=\"Jos &lt;j.curiuos@hotmail.com&gt;\" date=\"1607873511\" subject=\"Alan Walker - File 4 of 4 - Alan Walker ft. Tomine Harket &amp; Aura - Darkside.mp3 (1/24)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"504839\" number=\"1\">XnsAC92A8326C1D9jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504722\" number=\"2\">XnsAC92A832C461jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504709\" number=\"3\">XnsAC92A833327F0jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504723\" number=\"4\">XnsAC92A8339DA2Ajcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504723\" number=\"5\">XnsAC92A833F9C99jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504723\" number=\"6\">XnsAC92A83466661jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504717\" number=\"7\">XnsAC92A834C8A0Cjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504717\" number=\"8\">XnsAC92A8352B2EEjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504717\" number=\"9\">XnsAC92A83586C35jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504722\" number=\"11\">XnsAC92A83659F8jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504709\" number=\"12\">XnsAC92A836C2965jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504774\" number=\"13\">XnsAC92A83728F86jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504774\" number=\"14\">XnsAC92A8378CA85jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504723\" number=\"15\">XnsAC92A837EEBC2jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504723\" number=\"10\">XnsAC92A835FF71Ejcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504709\" number=\"16\">XnsAC92A8385B408jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504709\" number=\"17\">XnsAC92A838CC1E5jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504723\" number=\"18\">XnsAC92A83925FFEjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504709\" number=\"19\">XnsAC92A83989DE7jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504774\" number=\"20\">XnsAC92A839FF277jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504774\" number=\"21\">XnsAC92A83A53557jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504723\" number=\"22\">XnsAC92A83ABD549jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504723\" number=\"23\">XnsAC92A83B2279Ejcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"368584\" number=\"24\">XnsAC92A83B84EEjcuriuoshotmailcom@194.109.6.163</segment>\r\n</segments>\r\n', 'Jos <j.curiuos@hotmail.com>', 1607873511, 'Alan Walker - File 4 of 4 - Alan Walker ft. Tomine Harket & Aura - Darkside.mp3 (1/24)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 11977443, 24, 24, '1'),
(4, 2, 1, '<file poster=\"Jos &lt;j.curiuos@hotmail.com&gt;\" date=\"1607873483\" subject=\"Alan Walker - File 2 of 4 - Alan Walker - Faded.mp3 (1/24)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"504640\" number=\"1\">XnsAC92A81E35853jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504603\" number=\"2\">XnsAC92A81E9EF24jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504693\" number=\"3\">XnsAC92A81EFDAjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504603\" number=\"4\">XnsAC92A81F68172jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504689\" number=\"5\">XnsAC92A81FCBF16jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504603\" number=\"6\">XnsAC92A82039434jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504694\" number=\"7\">XnsAC92A8209C0Bjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504737\" number=\"8\">XnsAC92A8210FB9Djcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504603\" number=\"9\">XnsAC92A821638BAjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504746\" number=\"10\">XnsAC92A821C6111jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504695\" number=\"11\">XnsAC92A82221175jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504695\" number=\"12\">XnsAC92A8228ACF0jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504680\" number=\"13\">XnsAC92A822EE4Fjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504695\" number=\"14\">XnsAC92A82359682jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504746\" number=\"15\">XnsAC92A823B362Bjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504746\" number=\"16\">XnsAC92A824174B4jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504695\" number=\"18\">XnsAC92A824EABA0jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504695\" number=\"17\">XnsAC92A824719F5jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504689\" number=\"19\">XnsAC92A825493D4jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504695\" number=\"20\">XnsAC92A825A7222jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504695\" number=\"21\">XnsAC92A8261D27Bjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504737\" number=\"22\">XnsAC92A8267F7E0jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504737\" number=\"23\">XnsAC92A826EBAEBjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"323085\" number=\"24\">XnsAC92A82747F8Fjcuriuoshotmailcom@194.109.6.163</segment>\r\n</segments>\r\n', 'Jos <j.curiuos@hotmail.com>', 1607873483, 'Alan Walker - File 2 of 4 - Alan Walker - Faded.mp3 (1/24)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 11930896, 24, 24, '1'),
(5, 2, 2, '<file poster=\"Jos &lt;j.curiuos@hotmail.com&gt;\" date=\"1607873477\" subject=\"Alan Walker - File 1 of 4 - aaron neville - Tell It Like It Is.mp3 (1/11)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"504670\" number=\"1\">XnsAC92A819AE5CAjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504618\" number=\"2\">XnsAC92A81A03ECAjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504618\" number=\"3\">XnsAC92A81A6D45Ejcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504752\" number=\"4\">XnsAC92A81B2E48Bjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504618\" number=\"5\">XnsAC92A81B8B961jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504696\" number=\"6\">XnsAC92A81BFBE21jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504618\" number=\"7\">XnsAC92A81C5D0CCjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504618\" number=\"8\">XnsAC92A81CCB110jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504618\" number=\"9\">XnsAC92A81D2EEA1jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504618\" number=\"10\">XnsAC92A81D83369jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"356260\" number=\"11\">XnsAC92A81DEF326jcuriuoshotmailcom@194.109.6.163</segment>\r\n</segments>\r\n', 'Jos <j.curiuos@hotmail.com>', 1607873477, 'Alan Walker - File 1 of 4 - aaron neville - Tell It Like It Is.mp3 (1/11)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 5402704, 11, 11, '1'),
(6, 2, 3, '<file poster=\"Cat &lt;eager-poster@computer&gt;\" date=\"1616109223\" subject=\"[23/60] - &quot;19-alan_walker_and_salem_ilese_-_fake_a_smile-zzzz.mp3&quot; yEnc  6771327 (1/10)\">\r\n<groups>\r\n<group>alt.binaries.ftn</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"739755\" number=\"3\">MhArSpSfPvQiGpNrUpMcVaCx-1616109222326@nyuu</segment>\r\n<segment bytes=\"739545\" number=\"7\">QhKuKbGgRpSePoFkJwFjCiAp-1616109223212@nyuu</segment>\r\n<segment bytes=\"739676\" number=\"2\">GhQwHsDtKaWwZtXcRiFuEuOl-1616109222287@nyuu</segment>\r\n<segment bytes=\"739449\" number=\"1\">KsPfNcQyTuRgHvJlDeUbUnTk-1616109222227@nyuu</segment>\r\n<segment bytes=\"330742\" number=\"10\">DuYvHnSpAuDvAdYgNvVjZoWq-1616109223728@nyuu</segment>\r\n<segment bytes=\"739571\" number=\"9\">HfWaDbEkLfGlWkBzFlTlFdMy-1616109223628@nyuu</segment>\r\n<segment bytes=\"739668\" number=\"6\">HuXzQmBhTiIyPjSjFbSqNlUy-1616109223057@nyuu</segment>\r\n<segment bytes=\"739748\" number=\"5\">QvGuOsPsLgBlOfAyJbXyUaYg-1616109223015@nyuu</segment>\r\n<segment bytes=\"739710\" number=\"4\">HlTkBnSjIfQiEeJtGsDqBgJb-1616109222784@nyuu</segment>\r\n<segment bytes=\"739545\" number=\"8\">NePqNiRkExSgJkAdQuTvSvMf-1616109223389@nyuu</segment>\r\n</segments>\r\n', 'Cat <eager-poster@computer>', 1616109223, '[23/60] - \"19-alan_walker_and_salem_ilese_-_fake_a_smile-zzzz.mp3\" yEnc  6771327 (1/10)', 'a:1:{i:0;s:16:\"alt.binaries.ftn\";}', 6987409, 10, 10, '1'),
(7, 2, 4, '<file poster=\"Jos &lt;j.curiuos@hotmail.com&gt;\" date=\"1607873496\" subject=\"Alan Walker - File 3 of 4 - Alan Walker &amp; Sophia Somajo - Diamond heart.mp3 (1/27)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"504766\" number=\"1\">XnsAC92A82796339jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504719\" number=\"2\">XnsAC92A827F9A60jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504761\" number=\"3\">XnsAC92A82866739jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504761\" number=\"4\">XnsAC92A828CA8D6jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504719\" number=\"5\">XnsAC92A8293AC26jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504719\" number=\"6\">XnsAC92A8299EA74jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504719\" number=\"7\">XnsAC92A829FE290jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504769\" number=\"8\">XnsAC92A82A6907jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504719\" number=\"9\">XnsAC92A82AC463Fjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504761\" number=\"10\">XnsAC92A82B3FD72jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504705\" number=\"11\">XnsAC92A82B9D1CBjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504770\" number=\"12\">XnsAC92A82C0BB4Ejcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504770\" number=\"13\">XnsAC92A82C6E819jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504718\" number=\"14\">XnsAC92A82CDDBCjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504719\" number=\"15\">XnsAC92A82D66804jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504761\" number=\"16\">XnsAC92A82DDCB27jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504713\" number=\"18\">XnsAC92A82E9CF0Bjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504719\" number=\"17\">XnsAC92A82E3C6C6jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504705\" number=\"19\">XnsAC92A82F03C15jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504713\" number=\"20\">XnsAC92A82F64FC2jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504705\" number=\"21\">XnsAC92A82FCCEE6jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504719\" number=\"22\">XnsAC92A8302FC02jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504719\" number=\"23\">XnsAC92A83083C52jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504770\" number=\"24\">XnsAC92A830F1EB2jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504705\" number=\"25\">XnsAC92A8315D20Fjcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"504705\" number=\"26\">XnsAC92A831BA8F4jcuriuoshotmailcom@194.109.6.163</segment>\r\n<segment bytes=\"333124\" number=\"27\">XnsAC92A83227C85jcuriuoshotmailcom@194.109.6.163</segment>\r\n</segments>\r\n', 'Jos <j.curiuos@hotmail.com>', 1607873496, 'Alan Walker - File 3 of 4 - Alan Walker & Sophia Somajo - Diamond heart.mp3 (1/27)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 13456153, 27, 27, '1'),
(8, 2, 5, '<file poster=\"Cat &lt;eager-poster@computer&gt;\" date=\"1616482704\" subject=\"[05/26] - &quot;01-alan_walker_-_lily_ft_k-391_and_emelie_hollow_(orz3u_bootleg)-zzzz.mp3&quot; yEnc  7670326 (1/11)\">\r\n<groups>\r\n<group>alt.binaries.misc</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"739571\" number=\"3\">JwBkUnQcYoWhPvBrNvGwNrYe-1616482703632@nyuu</segment>\r\n<segment bytes=\"739450\" number=\"10\">AkUlXqWeZfQdUvAcCqYmVaQp-1616482705204@nyuu</segment>\r\n<segment bytes=\"739906\" number=\"2\">VrXaVkPePnIzAeAqJlMbKtFt-1616482703454@nyuu</segment>\r\n<segment bytes=\"739441\" number=\"4\">WrGiOcPsAhEaLzJmIvIaZoQe-1616482703717@nyuu</segment>\r\n<segment bytes=\"739648\" number=\"6\">XwXwAjOeJzCoXgKcBwZwRtVz-1616482703819@nyuu</segment>\r\n<segment bytes=\"739508\" number=\"8\">OkCeSwNoMlVxTtBwOjXfWgJw-1616482704431@nyuu</segment>\r\n<segment bytes=\"739506\" number=\"7\">OrViGdDwLmVpZqDzQbWzZgTt-1616482703887@nyuu</segment>\r\n<segment bytes=\"739132\" number=\"1\">XpBpGeHfFdYsRbSvVtIeDpMz-1616482702767@nyuu</segment>\r\n<segment bytes=\"739474\" number=\"9\">XsTeBmIfBqWnVoCtInWwYuHp-1616482705134@nyuu</segment>\r\n<segment bytes=\"518523\" number=\"11\">NqRtBeYzSxYkKuTcWpVxQaTb-1616482705748@nyuu</segment>\r\n<segment bytes=\"739424\" number=\"5\">EiMxKsTiHkTpYzGgElMfXzXf-1616482703801@nyuu</segment>\r\n</segments>\r\n', 'Cat <eager-poster@computer>', 1616482704, '[05/26] - \"01-alan_walker_-_lily_ft_k-391_and_emelie_hollow_(orz3u_bootleg)-zzzz.mp3\" yEnc  7670326 (1/11)', 'a:1:{i:0;s:17:\"alt.binaries.misc\";}', 7913583, 11, 11, '1'),
(9, 2, 6, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590898\" subject=\"House Party with Alan Walker (2020) - [00/21] - &quot;House Party with Alan Walker (2020).nzb&quot; yEnc (1/1)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"73219\" number=\"1\">Part1of1.0C753AA1AF6A436BA0FCEE03A0FCDF61@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590898, 'House Party with Alan Walker (2020) - [00/21] - \"House Party with Alan Walker (2020).nzb\" yEnc (1/1)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 73219, 1, 1, '1'),
(10, 2, 7, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590893\" subject=\"House Party with Alan Walker (2020) - [18/21] - &quot;House Party with Alan Walker (2020).vol03+04.PAR2&quot; yEnc (1/5)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398588\" number=\"1\">Part1of5.B13546FE36244845AC394E5E0F5A6A8B@1617535221.local</segment>\r\n<segment bytes=\"398563\" number=\"2\">Part2of5.511EDF458A25452289ECA89FBFF6F488@1617535221.local</segment>\r\n<segment bytes=\"398364\" number=\"3\">Part3of5.7390CC493EBC4401B339E86F3ECD9B6D@1617535221.local</segment>\r\n<segment bytes=\"398730\" number=\"4\">Part4of5.9E55FE2D2B9040BE8C4502445C00D3F1@1617535221.local</segment>\r\n<segment bytes=\"43844\" number=\"5\">Part5of5.10928949F91E453C83051DDF7A41C6F4@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590893, 'House Party with Alan Walker (2020) - [18/21] - \"House Party with Alan Walker (2020).vol03+04.PAR2\" yEnc (1/5)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 1638089, 5, 5, '0'),
(11, 2, 8, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590837\" subject=\"House Party with Alan Walker (2020) - [05/21] - &quot;House Party with Alan Walker (2020).part03.rar&quot; yEnc (1/41)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398297\" number=\"1\">Part1of41.570E775CDDF84A6E8348CA7C9F7CE08E@1617535221.local</segment>\r\n<segment bytes=\"398412\" number=\"2\">Part2of41.D3320A893C9348DF8AF20A609CAF2E27@1617535221.local</segment>\r\n<segment bytes=\"398377\" number=\"3\">Part3of41.8BF2E23F647F4779B2C14A6749ED9FDA@1617535221.local</segment>\r\n<segment bytes=\"398320\" number=\"4\">Part4of41.050E42524DFF4B678F560E18715C5D1A@1617535221.local</segment>\r\n<segment bytes=\"398467\" number=\"5\">Part5of41.D42E87C180474F3AB1FFDCAC639AC889@1617535221.local</segment>\r\n<segment bytes=\"398256\" number=\"6\">Part6of41.17FDCEBFA4624541AB11C871179B74D6@1617535221.local</segment>\r\n<segment bytes=\"398386\" number=\"7\">Part7of41.62A77FC56B8A4219A8FB08CDD6C93E8F@1617535221.local</segment>\r\n<segment bytes=\"398542\" number=\"8\">Part8of41.4E871FD638E54F56867642D08EE3BECC@1617535221.local</segment>\r\n<segment bytes=\"398458\" number=\"9\">Part9of41.AC35FAF1EDF74443A93A43F05F7D4150@1617535221.local</segment>\r\n<segment bytes=\"398557\" number=\"10\">Part10of41.811D10B0503640E4A3A14BB884BCE0E3@1617535221.local</segment>\r\n<segment bytes=\"398422\" number=\"11\">Part11of41.C9304715EFDF45E68E5B8672829FAA25@1617535221.local</segment>\r\n<segment bytes=\"398352\" number=\"12\">Part12of41.D1E5569FA1C94C81BB98F99BABF68AD6@1617535221.local</segment>\r\n<segment bytes=\"398382\" number=\"13\">Part13of41.97390D1988F747869DC0C5A7DA29C9F9@1617535221.local</segment>\r\n<segment bytes=\"398383\" number=\"14\">Part14of41.4EB1FEF59A1E49FA8E8CEC20AB6E239A@1617535221.local</segment>\r\n<segment bytes=\"398365\" number=\"15\">Part15of41.2CEFEA42C1664D6E8226650773A45278@1617535221.local</segment>\r\n<segment bytes=\"398261\" number=\"16\">Part16of41.7E4AEE2E418342A19897528521A2BAA4@1617535221.local</segment>\r\n<segment bytes=\"398445\" number=\"17\">Part17of41.896D2D83D9C84476BF7B031ECB6E2F2A@1617535221.local</segment>\r\n<segment bytes=\"398370\" number=\"18\">Part18of41.502540B8AF76462388CFC43E413E9920@1617535221.local</segment>\r\n<segment bytes=\"398321\" number=\"19\">Part19of41.5AFB126992084B09A8F3BF316800E4C9@1617535221.local</segment>\r\n<segment bytes=\"398409\" number=\"20\">Part20of41.C8E83C0575D04738A7969EEDAF377FDF@1617535221.local</segment>\r\n<segment bytes=\"398399\" number=\"21\">Part21of41.3AA25D0513654DBAA77ED58117651EE7@1617535221.local</segment>\r\n<segment bytes=\"398325\" number=\"22\">Part22of41.6A9513EBA75E48E9A98BF1C3435A94B7@1617535221.local</segment>\r\n<segment bytes=\"398217\" number=\"23\">Part23of41.6F622DD3B05C4C009F64CF21060E2028@1617535221.local</segment>\r\n<segment bytes=\"398591\" number=\"24\">Part24of41.149C061105C74CA99107876912A3E256@1617535221.local</segment>\r\n<segment bytes=\"398380\" number=\"25\">Part25of41.54DE937D6D98458E884CC1C317E76660@1617535221.local</segment>\r\n<segment bytes=\"398510\" number=\"26\">Part26of41.C7EAFB2BCA304FB3A6B969DE521C5581@1617535221.local</segment>\r\n<segment bytes=\"398439\" number=\"27\">Part27of41.4C8B705D99394BF080A368C82131602C@1617535221.local</segment>\r\n<segment bytes=\"398395\" number=\"28\">Part28of41.DC2166B18E254AA487CBFECD8D2EE99A@1617535221.local</segment>\r\n<segment bytes=\"398442\" number=\"29\">Part29of41.313021864A82481A8BB3FA3DB534F9EE@1617535221.local</segment>\r\n<segment bytes=\"398422\" number=\"30\">Part30of41.939C6794C0BC480DBB558CCEB50E555B@1617535221.local</segment>\r\n<segment bytes=\"398535\" number=\"31\">Part31of41.3F8B1415D119457287CA22DE94FF3530@1617535221.local</segment>\r\n<segment bytes=\"398270\" number=\"32\">Part32of41.954BE7F8CD4C4C118D2CA6F3BACCA3CB@1617535221.local</segment>\r\n<segment bytes=\"398431\" number=\"33\">Part33of41.F89C00B4139D41FD92663745D47B8E9E@1617535221.local</segment>\r\n<segment bytes=\"398464\" number=\"34\">Part34of41.EFB0DC79E0BF4894A753EAD96658384C@1617535221.local</segment>\r\n<segment bytes=\"398378\" number=\"35\">Part35of41.29441C13BCE9481784564A910F2E677D@1617535221.local</segment>\r\n<segment bytes=\"398339\" number=\"36\">Part36of41.EE079DDB10C34D0F8E09D10CB203740A@1617535221.local</segment>\r\n<segment bytes=\"398328\" number=\"37\">Part37of41.894AF9F33184428394C59D9374D43ABC@1617535221.local</segment>\r\n<segment bytes=\"398374\" number=\"38\">Part38of41.4852FE0513614CE888416878C3549D19@1617535221.local</segment>\r\n<segment bytes=\"398418\" number=\"39\">Part39of41.D92ABB3891724023AF0EC23F2AC6A561@1617535221.local</segment>\r\n<segment bytes=\"398262\" number=\"40\">Part40of41.4CD56C8A568B45219730A87284CA31D6@1617535221.local</segment>\r\n<segment bytes=\"382504\" number=\"41\">Part41of41.F70615187E25492DA2BA8E06C1BC17CC@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590837, 'House Party with Alan Walker (2020) - [05/21] - \"House Party with Alan Walker (2020).part03.rar\" yEnc (1/41)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 16318205, 41, 41, '1'),
(12, 2, 9, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590875\" subject=\"House Party with Alan Walker (2020) - [13/21] - &quot;House Party with Alan Walker (2020).part11.rar&quot; yEnc (1/41)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398283\" number=\"1\">Part1of41.22FE3C20B96647CAA7AEEA85A0FBF31B@1617535221.local</segment>\r\n<segment bytes=\"398408\" number=\"2\">Part2of41.3551749C8770433B94DA3701B475F4C4@1617535221.local</segment>\r\n<segment bytes=\"398484\" number=\"3\">Part3of41.C13B3C69884B49CBACED4091E81CC90E@1617535221.local</segment>\r\n<segment bytes=\"398528\" number=\"4\">Part4of41.94540118CF0246BFACF3F3AE1DE0EBEA@1617535221.local</segment>\r\n<segment bytes=\"398381\" number=\"5\">Part5of41.917C4E9D6AA44E0E923E0EE4E44C6A00@1617535221.local</segment>\r\n<segment bytes=\"398404\" number=\"6\">Part6of41.60776D1587A248DDB491C4B5AC0FE302@1617535221.local</segment>\r\n<segment bytes=\"398492\" number=\"7\">Part7of41.F51D8D46CFE54B08A35AD909D6D0866F@1617535221.local</segment>\r\n<segment bytes=\"398219\" number=\"8\">Part8of41.CF19533D766548329BAB5F3E8321E8A1@1617535221.local</segment>\r\n<segment bytes=\"398529\" number=\"9\">Part9of41.284F4F52939448D2873C3F9045B96C88@1617535221.local</segment>\r\n<segment bytes=\"398494\" number=\"10\">Part10of41.58A0CFD75B974508B9A18BAD83E1DF3A@1617535221.local</segment>\r\n<segment bytes=\"398534\" number=\"11\">Part11of41.B25791E5240942F6BF7ABDB7528AAB56@1617535221.local</segment>\r\n<segment bytes=\"398620\" number=\"12\">Part12of41.AA9E3EB25B0E4527A3B34DB7C91CC701@1617535221.local</segment>\r\n<segment bytes=\"398443\" number=\"13\">Part13of41.5585460A655948F2930174F3CFDDC522@1617535221.local</segment>\r\n<segment bytes=\"398498\" number=\"16\">Part16of41.136259FC219D4556A3600BFAAB185E79@1617535221.local</segment>\r\n<segment bytes=\"398448\" number=\"19\">Part19of41.586460E0AE6E41CFA2A2489A49A136E7@1617535221.local</segment>\r\n<segment bytes=\"398577\" number=\"14\">Part14of41.7CD047C7BE994AAEA6EE386C2CCB38BF@1617535221.local</segment>\r\n<segment bytes=\"398422\" number=\"15\">Part15of41.455D39EF89714D02B6A882E245763F96@1617535221.local</segment>\r\n<segment bytes=\"398584\" number=\"18\">Part18of41.D1DB26FC09BC40DF94D18F937895D2CF@1617535221.local</segment>\r\n<segment bytes=\"398485\" number=\"17\">Part17of41.8C8FA6EE2526454E94C9147BAA0E2720@1617535221.local</segment>\r\n<segment bytes=\"398495\" number=\"23\">Part23of41.EC3D65A04BA44324ACA8580D6352F4E6@1617535221.local</segment>\r\n<segment bytes=\"398616\" number=\"20\">Part20of41.3F6808A87EC5449E8838FAF0ED7029F9@1617535221.local</segment>\r\n<segment bytes=\"398570\" number=\"22\">Part22of41.5E88431D8782404AAAE1EFF9285B55EE@1617535221.local</segment>\r\n<segment bytes=\"398557\" number=\"21\">Part21of41.D61CD57AA0E449E093240CC2433BE39C@1617535221.local</segment>\r\n<segment bytes=\"398643\" number=\"24\">Part24of41.E09E22254A104A55B0AF6133D9F984CA@1617535221.local</segment>\r\n<segment bytes=\"398315\" number=\"25\">Part25of41.99A72D118E2040ADAF21E5720F08D1CC@1617535221.local</segment>\r\n<segment bytes=\"398640\" number=\"26\">Part26of41.A12DDFB5F8B84605A985005E53D71BA4@1617535221.local</segment>\r\n<segment bytes=\"398601\" number=\"27\">Part27of41.5B75BC8CF35C4670913ED768873ED2E8@1617535221.local</segment>\r\n<segment bytes=\"398702\" number=\"28\">Part28of41.BBF0283C89C947F0A35170117B31FB76@1617535221.local</segment>\r\n<segment bytes=\"398668\" number=\"29\">Part29of41.343712EA4E414B47AAADF3EE333D5652@1617535221.local</segment>\r\n<segment bytes=\"398415\" number=\"30\">Part30of41.643BFC88E3864655ABEBEFBE93F10C2E@1617535221.local</segment>\r\n<segment bytes=\"398364\" number=\"31\">Part31of41.41FA2243DBC749C883877C181BA05A90@1617535221.local</segment>\r\n<segment bytes=\"398637\" number=\"34\">Part34of41.19F248A743E34EEB98B96F8A876230C4@1617535221.local</segment>\r\n<segment bytes=\"398625\" number=\"33\">Part33of41.E0A499BC59C0488A9F695FCEC3AAFF67@1617535221.local</segment>\r\n<segment bytes=\"398525\" number=\"32\">Part32of41.D13F8F08EEE4484D87D500A4CE530E3B@1617535221.local</segment>\r\n<segment bytes=\"398771\" number=\"35\">Part35of41.7EFFAE2205EA41818EC8F4EDC5721C67@1617535221.local</segment>\r\n<segment bytes=\"398563\" number=\"36\">Part36of41.3CE2066027B24EF590552D8DF7C563F4@1617535221.local</segment>\r\n<segment bytes=\"398647\" number=\"37\">Part37of41.83CAD8D1E5964DBDAB7FE92F8D0DB706@1617535221.local</segment>\r\n<segment bytes=\"398630\" number=\"39\">Part39of41.291BF3DFF50F496CBBE8368084A05B4B@1617535221.local</segment>\r\n<segment bytes=\"398509\" number=\"38\">Part38of41.07FE5B86D24D4304BF7935D395FC8DB6@1617535221.local</segment>\r\n<segment bytes=\"398514\" number=\"40\">Part40of41.ADB847ECC34F40BF8599FA2867B12D01@1617535221.local</segment>\r\n<segment bytes=\"382722\" number=\"41\">Part41of41.E01DCDA76DCF4EA09FF5AE68CF1F2305@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590875, 'House Party with Alan Walker (2020) - [13/21] - \"House Party with Alan Walker (2020).part11.rar\" yEnc (1/41)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 16323562, 41, 41, '1'),
(13, 2, 10, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590893\" subject=\"House Party with Alan Walker (2020) - [17/21] - &quot;House Party with Alan Walker (2020).vol01+02.PAR2&quot; yEnc (1/3)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398527\" number=\"1\">Part1of3.8038BE0F4D61402485E7BC56C7F554C5@1617535221.local</segment>\r\n<segment bytes=\"398500\" number=\"2\">Part2of3.EA2C7BCFCADF4D1DA8AF10F22C6C8E19@1617535221.local</segment>\r\n<segment bytes=\"29495\" number=\"3\">Part3of3.31B9D18A6970460B8A78069321D21F97@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590893, 'House Party with Alan Walker (2020) - [17/21] - \"House Party with Alan Walker (2020).vol01+02.PAR2\" yEnc (1/3)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 826522, 3, 3, '0'),
(14, 2, 11, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590837\" subject=\"House Party with Alan Walker (2020) - [06/21] - &quot;House Party with Alan Walker (2020).part04.rar&quot; yEnc (1/41)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398441\" number=\"1\">Part1of41.BAC6AB23654B4C65940990097BD12588@1617535221.local</segment>\r\n<segment bytes=\"398491\" number=\"2\">Part2of41.61CDF85241034EA9B5CAC996904AF635@1617535221.local</segment>\r\n<segment bytes=\"398576\" number=\"3\">Part3of41.094788BA4C6246C49EB0D8069D4A023E@1617535221.local</segment>\r\n<segment bytes=\"398358\" number=\"4\">Part4of41.FD976E1C7A2F4E8B997DF93930381A18@1617535221.local</segment>\r\n<segment bytes=\"398421\" number=\"5\">Part5of41.B9F5A22655DB4804AA4E9FA9125A244A@1617535221.local</segment>\r\n<segment bytes=\"398275\" number=\"6\">Part6of41.FDF0D1D720CC4C429B1C62902BE48900@1617535221.local</segment>\r\n<segment bytes=\"398321\" number=\"7\">Part7of41.CFC4452DEAA94B829269BCB29B6DA7EA@1617535221.local</segment>\r\n<segment bytes=\"398437\" number=\"8\">Part8of41.D481B89DF6A6450CB1A2C907925ECD8F@1617535221.local</segment>\r\n<segment bytes=\"398496\" number=\"9\">Part9of41.E2B85941CC3540558010ADECA778BFC4@1617535221.local</segment>\r\n<segment bytes=\"398619\" number=\"10\">Part10of41.DAD21AFBB047402A9B06A9F3541ACCE8@1617535221.local</segment>\r\n<segment bytes=\"398569\" number=\"11\">Part11of41.D09C665619DA45EE8CDD5F4E45B2E1F1@1617535221.local</segment>\r\n<segment bytes=\"398505\" number=\"12\">Part12of41.52D8F8C8ED9A48118645E87C2895E1D7@1617535221.local</segment>\r\n<segment bytes=\"398362\" number=\"13\">Part13of41.D8ADDFDA9D7C4751B39BD70F5182FE07@1617535221.local</segment>\r\n<segment bytes=\"398640\" number=\"14\">Part14of41.8D38DADD6C8248E6859D4DE70A3E47E8@1617535221.local</segment>\r\n<segment bytes=\"398492\" number=\"15\">Part15of41.44219D164F864DB793EC54D43756C34B@1617535221.local</segment>\r\n<segment bytes=\"398476\" number=\"16\">Part16of41.E5BB64DDBDC3442096D2EC42BB0B9ACF@1617535221.local</segment>\r\n<segment bytes=\"398456\" number=\"17\">Part17of41.6ABE8DE4E2204B0290E709503121CE17@1617535221.local</segment>\r\n<segment bytes=\"398478\" number=\"18\">Part18of41.DEB7D9FE1E24474784024CF45DCD72E8@1617535221.local</segment>\r\n<segment bytes=\"398586\" number=\"19\">Part19of41.89FD55826C704287893A12887ACEEA51@1617535221.local</segment>\r\n<segment bytes=\"398413\" number=\"20\">Part20of41.71EBFCBAAD404EC1B06B90F3D30A14FE@1617535221.local</segment>\r\n<segment bytes=\"398392\" number=\"21\">Part21of41.4BB97380CA064F92A068A3BAEEF1C79C@1617535221.local</segment>\r\n<segment bytes=\"398441\" number=\"22\">Part22of41.47ABF1138BF242B3BA00320C8EA5174F@1617535221.local</segment>\r\n<segment bytes=\"398405\" number=\"23\">Part23of41.F4C10372DA594A318FFFFA28AE9367FC@1617535221.local</segment>\r\n<segment bytes=\"398457\" number=\"24\">Part24of41.46CA7F6356F74E0CB8F0AC4F7A6CAB78@1617535221.local</segment>\r\n<segment bytes=\"398656\" number=\"25\">Part25of41.66A779BFD9DF406D818E481755EE8159@1617535221.local</segment>\r\n<segment bytes=\"398380\" number=\"26\">Part26of41.EAB92FCA6A9D4C37A3B075FC28C13F06@1617535221.local</segment>\r\n<segment bytes=\"398577\" number=\"27\">Part27of41.D2B9ED7E76C64E9EA284AEE9BD5EA357@1617535221.local</segment>\r\n<segment bytes=\"398423\" number=\"28\">Part28of41.8B3EA09AF40F46ECAEFF85B0E472B5E8@1617535221.local</segment>\r\n<segment bytes=\"398533\" number=\"29\">Part29of41.317D8B39A6AE4FA6BED5AB9AFFA516C4@1617535221.local</segment>\r\n<segment bytes=\"398356\" number=\"30\">Part30of41.7C7F15020A864C4F88BD4F15C948AFED@1617535221.local</segment>\r\n<segment bytes=\"398458\" number=\"31\">Part31of41.058174EC224D422C84849C20693FE498@1617535221.local</segment>\r\n<segment bytes=\"398794\" number=\"32\">Part32of41.1D959F84D5534D829F0904ACC3C90117@1617535221.local</segment>\r\n<segment bytes=\"398443\" number=\"33\">Part33of41.EA2D3A40721345D7B30A44C7D01C1CAD@1617535221.local</segment>\r\n<segment bytes=\"398372\" number=\"34\">Part34of41.0C1F542A6EB84799B62FE62321CFCBCE@1617535221.local</segment>\r\n<segment bytes=\"398552\" number=\"35\">Part35of41.57C3F224BECB406EB5A7E79471E94676@1617535221.local</segment>\r\n<segment bytes=\"398505\" number=\"36\">Part36of41.5AAA3F4802554278A355088745D11CC9@1617535221.local</segment>\r\n<segment bytes=\"398423\" number=\"37\">Part37of41.AFD46D420E3A4235BDA9A1E251FEDA80@1617535221.local</segment>\r\n<segment bytes=\"398517\" number=\"38\">Part38of41.AE13C48024AC4BCC99B0A4F580C2AA24@1617535221.local</segment>\r\n<segment bytes=\"398513\" number=\"39\">Part39of41.2CF3743D941846FAA421AED084994DD5@1617535221.local</segment>\r\n<segment bytes=\"398456\" number=\"40\">Part40of41.21F9BD727D0A4785A598040E62ED606E@1617535221.local</segment>\r\n<segment bytes=\"382336\" number=\"41\">Part41of41.6A3A9EE32A2E4A27951DE0AA60F8EBB4@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590837, 'House Party with Alan Walker (2020) - [06/21] - \"House Party with Alan Walker (2020).part04.rar\" yEnc (1/41)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 16321401, 41, 41, '1'),
(15, 2, 12, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590874\" subject=\"House Party with Alan Walker (2020) - [12/21] - &quot;House Party with Alan Walker (2020).part10.rar&quot; yEnc (1/41)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398436\" number=\"1\">Part1of41.B937428F32A24076B2573339C83AF98C@1617535221.local</segment>\r\n<segment bytes=\"398436\" number=\"2\">Part2of41.C38A3189E99E4288BEC79A0B27503C41@1617535221.local</segment>\r\n<segment bytes=\"398697\" number=\"3\">Part3of41.76AE939A9CDF408DB1F7F258559F5EB4@1617535221.local</segment>\r\n<segment bytes=\"398262\" number=\"4\">Part4of41.7C272CC9717D44C08E528944425BA6C1@1617535221.local</segment>\r\n<segment bytes=\"398365\" number=\"5\">Part5of41.DEAC5D66823F4E7F9D47AC25887FE101@1617535221.local</segment>\r\n<segment bytes=\"398458\" number=\"6\">Part6of41.DD6330FDFEA04C4F9BA69735261F164C@1617535221.local</segment>\r\n<segment bytes=\"398452\" number=\"7\">Part7of41.BC0AED794D214FE1A28C4F38BD5CA01E@1617535221.local</segment>\r\n<segment bytes=\"398402\" number=\"8\">Part8of41.029B3ACBD3AE49A59657DD29F1B67DD1@1617535221.local</segment>\r\n<segment bytes=\"398621\" number=\"9\">Part9of41.05B8A06E059B42B780F0482402471748@1617535221.local</segment>\r\n<segment bytes=\"398626\" number=\"10\">Part10of41.E3E27D6D353D4854BF7D498D1E67EF71@1617535221.local</segment>\r\n<segment bytes=\"398518\" number=\"11\">Part11of41.4297C57FD5634D648358D4A7C948A7D8@1617535221.local</segment>\r\n<segment bytes=\"398672\" number=\"12\">Part12of41.55F9D867EACB48B3B8073DEBEE635D8C@1617535221.local</segment>\r\n<segment bytes=\"398722\" number=\"13\">Part13of41.998ACEDF0BDD4CEF93F9146FEAB54B5B@1617535221.local</segment>\r\n<segment bytes=\"398687\" number=\"14\">Part14of41.F81D3583375C4957AD6C3008CA0EDC32@1617535221.local</segment>\r\n<segment bytes=\"398462\" number=\"15\">Part15of41.44D2CC7B683841A9AA5938F171285271@1617535221.local</segment>\r\n<segment bytes=\"398420\" number=\"16\">Part16of41.06AD6BA8FCBC4405BCD81138BC62089C@1617535221.local</segment>\r\n<segment bytes=\"398434\" number=\"19\">Part19of41.FD32D4C00E1143DAAA77E72EFBB0180E@1617535221.local</segment>\r\n<segment bytes=\"398587\" number=\"20\">Part20of41.A4AD4BC0032A46B284C230C2107FF81A@1617535221.local</segment>\r\n<segment bytes=\"398600\" number=\"17\">Part17of41.FE59CBEB3DAA4538AA3A7B49835F44BA@1617535221.local</segment>\r\n<segment bytes=\"398534\" number=\"18\">Part18of41.0D9E6A594E294E849C0E5BC14425261C@1617535221.local</segment>\r\n<segment bytes=\"398577\" number=\"21\">Part21of41.51748B91912145ACB9F7F0599834F390@1617535221.local</segment>\r\n<segment bytes=\"398613\" number=\"22\">Part22of41.A123850D4C2A4CFEB9BF2F125D0159FA@1617535221.local</segment>\r\n<segment bytes=\"398632\" number=\"23\">Part23of41.1DDA4A54DDF04DE2BF4094C943D1680B@1617535221.local</segment>\r\n<segment bytes=\"398719\" number=\"24\">Part24of41.7AAEC7C48CEE42CDABADB09B4D639F5B@1617535221.local</segment>\r\n<segment bytes=\"398578\" number=\"25\">Part25of41.550E938BCD68434489FBDCBDEAC7837D@1617535221.local</segment>\r\n<segment bytes=\"398344\" number=\"26\">Part26of41.8A4D7230BE50478E9F7869427A47FAA9@1617535221.local</segment>\r\n<segment bytes=\"398632\" number=\"27\">Part27of41.CB25AB9F734E43F4A7B81390B2F7CBE0@1617535221.local</segment>\r\n<segment bytes=\"398434\" number=\"28\">Part28of41.80AA12BD432143FC884810556993C909@1617535221.local</segment>\r\n<segment bytes=\"398540\" number=\"29\">Part29of41.BE5D985E34604BAEA33BE9C21E98C92C@1617535221.local</segment>\r\n<segment bytes=\"398728\" number=\"30\">Part30of41.2E3F2F5A73BC485FB8BDC5A96A22FADE@1617535221.local</segment>\r\n<segment bytes=\"398479\" number=\"31\">Part31of41.B53548B0141B4E1FA9500FC96AF007B6@1617535221.local</segment>\r\n<segment bytes=\"398668\" number=\"33\">Part33of41.4FE4C02EDC9C47AD8899B52AD2314E25@1617535221.local</segment>\r\n<segment bytes=\"398482\" number=\"32\">Part32of41.6EAF90ECE4BD4F298BBEB06EFDB93B8C@1617535221.local</segment>\r\n<segment bytes=\"398486\" number=\"34\">Part34of41.05B06B49B6E24481A41029A96B3F633E@1617535221.local</segment>\r\n<segment bytes=\"398416\" number=\"35\">Part35of41.903840E0ADBC475DA9A8D34076849A56@1617535221.local</segment>\r\n<segment bytes=\"398446\" number=\"36\">Part36of41.92BE8DE10626423BA44B14824577A2F3@1617535221.local</segment>\r\n<segment bytes=\"398740\" number=\"37\">Part37of41.B1E3F8ADE7404662BFC0F6C07BA7C01C@1617535221.local</segment>\r\n<segment bytes=\"398639\" number=\"39\">Part39of41.E7500924B12B493E9330E4BBE35F1D20@1617535221.local</segment>\r\n<segment bytes=\"398508\" number=\"38\">Part38of41.091925D6C275465D89E54DC34FBCA622@1617535221.local</segment>\r\n<segment bytes=\"398465\" number=\"40\">Part40of41.2553C9CA028946E0ADBEC648755459F7@1617535221.local</segment>\r\n<segment bytes=\"382772\" number=\"41\">Part41of41.7DDFE94D177B4646950C2F1A19C418D1@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590874, 'House Party with Alan Walker (2020) - [12/21] - \"House Party with Alan Walker (2020).part10.rar\" yEnc (1/41)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 16324289, 41, 41, '1'),
(16, 2, 13, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590893\" subject=\"House Party with Alan Walker (2020) - [15/21] - &quot;House Party with Alan Walker (2020).part13.rar&quot; yEnc (1/16)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398543\" number=\"1\">Part1of16.3BD58829586C4686A6BA90EBFA406A79@1617535221.local</segment>\r\n<segment bytes=\"398488\" number=\"2\">Part2of16.79BA744DD15B4CB89B2805C7851DE453@1617535221.local</segment>\r\n<segment bytes=\"398481\" number=\"3\">Part3of16.1537E56EC6894705B94BD9C6EA43C9CB@1617535221.local</segment>\r\n<segment bytes=\"398489\" number=\"4\">Part4of16.F8EA24245607437BB7BED9AEEC1C3F90@1617535221.local</segment>\r\n<segment bytes=\"398700\" number=\"7\">Part7of16.E2930A5DD17F47DF8861EFFE49791A5C@1617535221.local</segment>\r\n<segment bytes=\"398451\" number=\"5\">Part5of16.D7C89B8CEAB54666B3F37A175AD0203C@1617535221.local</segment>\r\n<segment bytes=\"398644\" number=\"6\">Part6of16.115C8B6F558B467AA501B43C96D98870@1617535221.local</segment>\r\n<segment bytes=\"398590\" number=\"9\">Part9of16.493EC61D91AE4CBF8FACED4D40E0844C@1617535221.local</segment>\r\n<segment bytes=\"398494\" number=\"10\">Part10of16.31440AFED8D543009775B1DBB380E715@1617535221.local</segment>\r\n<segment bytes=\"398525\" number=\"11\">Part11of16.96DE18338E584625AB3C67B0638E83E1@1617535221.local</segment>\r\n<segment bytes=\"398605\" number=\"14\">Part14of16.665B32972C2C4D00A6B2B04358985A70@1617535221.local</segment>\r\n<segment bytes=\"398688\" number=\"8\">Part8of16.550FC129C3AA406EAE24A032ECCF2BB8@1617535221.local</segment>\r\n<segment bytes=\"398452\" number=\"12\">Part12of16.6A3F9145387E4E8386BB7095E335D382@1617535221.local</segment>\r\n<segment bytes=\"398718\" number=\"13\">Part13of16.51F642276795434E9F4B4AF61608F592@1617535221.local</segment>\r\n<segment bytes=\"398473\" number=\"15\">Part15of16.79907C10286541FD946865DF050CA5B2@1617535221.local</segment>\r\n<segment bytes=\"217498\" number=\"16\">Part16of16.2D1A16653A4C469D9EBC8048970A5B14@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590893, 'House Party with Alan Walker (2020) - [15/21] - \"House Party with Alan Walker (2020).part13.rar\" yEnc (1/16)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 6195839, 16, 16, '1'),
(17, 2, 14, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590894\" subject=\"House Party with Alan Walker (2020) - [19/21] - &quot;House Party with Alan Walker (2020).vol07+08.PAR2&quot; yEnc (1/9)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398778\" number=\"1\">Part1of9.5E0EE06E04C24A0D9E3A5C8CBB7AB650@1617535221.local</segment>\r\n<segment bytes=\"398733\" number=\"2\">Part2of9.70E0EF7FB3B44D6891DA2DA3CDBBF04B@1617535221.local</segment>\r\n<segment bytes=\"398595\" number=\"3\">Part3of9.E7BBC6D1C6EC4BD4B219D63C6E1A3786@1617535221.local</segment>\r\n<segment bytes=\"398566\" number=\"5\">Part5of9.447BE9BE5CC94375A00F225692FC450B@1617535221.local</segment>\r\n<segment bytes=\"398554\" number=\"4\">Part4of9.26FF1B09884D4CAB96EB6926FA52623E@1617535221.local</segment>\r\n<segment bytes=\"398612\" number=\"6\">Part6of9.DD43F85960274EEE90629EBDBD43FC27@1617535221.local</segment>\r\n<segment bytes=\"398690\" number=\"7\">Part7of9.B76655216812488A94B64EBECA90EF7B@1617535221.local</segment>\r\n<segment bytes=\"398561\" number=\"8\">Part8of9.607B2B1D41D749829B493CBE0C63068A@1617535221.local</segment>\r\n<segment bytes=\"58251\" number=\"9\">Part9of9.0A08C6FC3F764F7E94CD61FFB72A29DD@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590894, 'House Party with Alan Walker (2020) - [19/21] - \"House Party with Alan Walker (2020).vol07+08.PAR2\" yEnc (1/9)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 3247340, 9, 9, '0');
INSERT INTO `nzbpiecelist` (`id`, `nzb`, `nzb_piece`, `filepiece`, `piece_poster`, `piece_date`, `piece_subject`, `piece_groups`, `piece_size`, `piece_segments`, `piece_subjseg`, `piece_par`) VALUES
(18, 2, 15, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590856\" subject=\"House Party with Alan Walker (2020) - [07/21] - &quot;House Party with Alan Walker (2020).part05.rar&quot; yEnc (1/41)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398558\" number=\"1\">Part1of41.80A32308AD094F6492F5D8FC57C6AB99@1617535221.local</segment>\r\n<segment bytes=\"398479\" number=\"2\">Part2of41.44113DFE05C047C68CB38C2479EFC178@1617535221.local</segment>\r\n<segment bytes=\"398448\" number=\"3\">Part3of41.408733B276D044C5AC5FF2DCBA4D2E64@1617535221.local</segment>\r\n<segment bytes=\"398318\" number=\"4\">Part4of41.A16BA3376D3842B4820295F5C63984FA@1617535221.local</segment>\r\n<segment bytes=\"398558\" number=\"5\">Part5of41.E7D9B5193B7B47BE801DA66240A358AE@1617535221.local</segment>\r\n<segment bytes=\"398301\" number=\"6\">Part6of41.685268E52AE2432DB268323568D0BB5F@1617535221.local</segment>\r\n<segment bytes=\"398334\" number=\"7\">Part7of41.9CDD711ABDD8452EBE6BB55937D1245B@1617535221.local</segment>\r\n<segment bytes=\"398503\" number=\"8\">Part8of41.1C5DE3E626D34486879B1E06E16390A2@1617535221.local</segment>\r\n<segment bytes=\"398398\" number=\"9\">Part9of41.0DC1E1096F354F01B63FB414BFA5E918@1617535221.local</segment>\r\n<segment bytes=\"398501\" number=\"10\">Part10of41.64FC56B6DB664F298CBF0B064E11B1D4@1617535221.local</segment>\r\n<segment bytes=\"398525\" number=\"11\">Part11of41.E3611CB1DA8C4325ADCC6C027EB25EC0@1617535221.local</segment>\r\n<segment bytes=\"398455\" number=\"12\">Part12of41.96690CD60B9341278360F716E79EA1A9@1617535221.local</segment>\r\n<segment bytes=\"398290\" number=\"13\">Part13of41.B2BB105574BF43B885EF9FA9FB7B1010@1617535221.local</segment>\r\n<segment bytes=\"398532\" number=\"14\">Part14of41.43874946DAB442E58D9DA65B1BFD6601@1617535221.local</segment>\r\n<segment bytes=\"398448\" number=\"15\">Part15of41.BF7BB52C7CCE44C0BB54328F1E6556F7@1617535221.local</segment>\r\n<segment bytes=\"398282\" number=\"16\">Part16of41.0006174CC75B47E1820B7D0C11E9404D@1617535221.local</segment>\r\n<segment bytes=\"398475\" number=\"17\">Part17of41.A23A646E71674FB993CEEF271DFC9117@1617535221.local</segment>\r\n<segment bytes=\"398482\" number=\"18\">Part18of41.81E54F0663964A129DBAFBA01E49E12E@1617535221.local</segment>\r\n<segment bytes=\"398328\" number=\"19\">Part19of41.C51325813EC54DD4BD3D8E66FCF64BC7@1617535221.local</segment>\r\n<segment bytes=\"398470\" number=\"20\">Part20of41.B8CBFE3767574EB6B087F2A94EA781C5@1617535221.local</segment>\r\n<segment bytes=\"398348\" number=\"21\">Part21of41.3F7495051DE34479B2FDE7DDE5E35CDF@1617535221.local</segment>\r\n<segment bytes=\"398301\" number=\"22\">Part22of41.A4DBBAD14C6341EF9238E2721F436CE5@1617535221.local</segment>\r\n<segment bytes=\"398441\" number=\"23\">Part23of41.9CF30EC1BC10481CA761E624B410C8BD@1617535221.local</segment>\r\n<segment bytes=\"398438\" number=\"24\">Part24of41.CCF65B5D5BF243F2B765F50A483DFC29@1617535221.local</segment>\r\n<segment bytes=\"398309\" number=\"25\">Part25of41.E6ABF886C8B34158B229FAA95B55261A@1617535221.local</segment>\r\n<segment bytes=\"398467\" number=\"26\">Part26of41.449B0BC255284EF1B9580CCC087F028F@1617535221.local</segment>\r\n<segment bytes=\"398384\" number=\"27\">Part27of41.C954F7074B564068B39ACDDDF977B52C@1617535221.local</segment>\r\n<segment bytes=\"398554\" number=\"28\">Part28of41.622CB633B91A4E228C4219BACEF2AF59@1617535221.local</segment>\r\n<segment bytes=\"398462\" number=\"29\">Part29of41.3D445AF2E9CA47A0B81D8D3E891DB771@1617535221.local</segment>\r\n<segment bytes=\"398486\" number=\"30\">Part30of41.8028F998485740CC9A9C3E99EB728B5C@1617535221.local</segment>\r\n<segment bytes=\"398413\" number=\"31\">Part31of41.21A85E39D4B243E684F06AB855A7299A@1617535221.local</segment>\r\n<segment bytes=\"398341\" number=\"32\">Part32of41.0E7A2DC74EE54D76B5E703DC9EED7426@1617535221.local</segment>\r\n<segment bytes=\"398479\" number=\"33\">Part33of41.26C0351C662F447C9EF5FA86DEE33AA6@1617535221.local</segment>\r\n<segment bytes=\"398406\" number=\"34\">Part34of41.B16ACFA9F219436BBEF3A06813ED437B@1617535221.local</segment>\r\n<segment bytes=\"398594\" number=\"35\">Part35of41.56C42675A503498EAFF8D39FBE707855@1617535221.local</segment>\r\n<segment bytes=\"398351\" number=\"36\">Part36of41.C743199C96AA4323B0B54310FA455D22@1617535221.local</segment>\r\n<segment bytes=\"398459\" number=\"37\">Part37of41.ABD98F0EDDA34BADA2DA9872CAC6569E@1617535221.local</segment>\r\n<segment bytes=\"398464\" number=\"38\">Part38of41.5BEF0FE75DB140FD935329F912715912@1617535221.local</segment>\r\n<segment bytes=\"398402\" number=\"39\">Part39of41.A2E177D8935F4AE382030903D43D331F@1617535221.local</segment>\r\n<segment bytes=\"398557\" number=\"40\">Part40of41.72AF05FE48D8484896E3D4DB60794FC1@1617535221.local</segment>\r\n<segment bytes=\"382523\" number=\"41\">Part41of41.B3D022C225034A4EA813866373E9345B@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590856, 'House Party with Alan Walker (2020) - [07/21] - \"House Party with Alan Walker (2020).part05.rar\" yEnc (1/41)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 16319864, 41, 41, '1'),
(19, 2, 16, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590856\" subject=\"House Party with Alan Walker (2020) - [08/21] - &quot;House Party with Alan Walker (2020).part06.rar&quot; yEnc (1/41)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398368\" number=\"1\">Part1of41.352A053EAE914C8083CA21C2A9223DBD@1617535221.local</segment>\r\n<segment bytes=\"398572\" number=\"2\">Part2of41.17CD4ABFBC0A49718D97893C2466F975@1617535221.local</segment>\r\n<segment bytes=\"398393\" number=\"3\">Part3of41.9AF5E991D85C4AE68F73258697610F3B@1617535221.local</segment>\r\n<segment bytes=\"398245\" number=\"4\">Part4of41.89EE40DA15D64E2E818F6C2EC60DA86A@1617535221.local</segment>\r\n<segment bytes=\"398408\" number=\"5\">Part5of41.6D60693E02B741A68AE21A4F128DE458@1617535221.local</segment>\r\n<segment bytes=\"398313\" number=\"6\">Part6of41.3C6159BF0B244495ADFA9ACDC55CE7D6@1617535221.local</segment>\r\n<segment bytes=\"398387\" number=\"7\">Part7of41.0A26AF4513B94809BB6890F432C35DC1@1617535221.local</segment>\r\n<segment bytes=\"398340\" number=\"8\">Part8of41.75B43B3B106A409B924940204C908E0B@1617535221.local</segment>\r\n<segment bytes=\"398539\" number=\"9\">Part9of41.EB17AACBC161486DA272B5C02D893058@1617535221.local</segment>\r\n<segment bytes=\"398323\" number=\"10\">Part10of41.A6B5C8942C7B4BA9A9806E297490F8F3@1617535221.local</segment>\r\n<segment bytes=\"398356\" number=\"11\">Part11of41.EB728DF2385247C487FBB43E7F18B4E8@1617535221.local</segment>\r\n<segment bytes=\"398440\" number=\"12\">Part12of41.E8A3B74876A74B45A0780CA217FF8124@1617535221.local</segment>\r\n<segment bytes=\"398452\" number=\"13\">Part13of41.C0C6F757F19F413D929482D7A82A6EF8@1617535221.local</segment>\r\n<segment bytes=\"398524\" number=\"14\">Part14of41.653DC910370844448EDC13C7B9B7E9F3@1617535221.local</segment>\r\n<segment bytes=\"398509\" number=\"15\">Part15of41.80C9B3C492294EEBAE15A8C758A60F83@1617535221.local</segment>\r\n<segment bytes=\"398273\" number=\"16\">Part16of41.78555495B81B48BFA8AD58256F36F400@1617535221.local</segment>\r\n<segment bytes=\"398550\" number=\"17\">Part17of41.0F7C28949FEF46799A5F0F994318CD68@1617535221.local</segment>\r\n<segment bytes=\"398394\" number=\"18\">Part18of41.FD5037267E404D1A9BE24E29B2E13B0A@1617535221.local</segment>\r\n<segment bytes=\"398436\" number=\"19\">Part19of41.D3F0C8705905449B9918C7AD5818DBC7@1617535221.local</segment>\r\n<segment bytes=\"398395\" number=\"20\">Part20of41.22F5FFD97B5D4357B05CC90C310238D2@1617535221.local</segment>\r\n<segment bytes=\"398436\" number=\"21\">Part21of41.EB621E1E15DD47718C11F5FB4AB97936@1617535221.local</segment>\r\n<segment bytes=\"398439\" number=\"22\">Part22of41.C30EA5706F294BE8BFF7247A54587C1C@1617535221.local</segment>\r\n<segment bytes=\"398557\" number=\"23\">Part23of41.45F81554CF414C07B73AA2DB867408E0@1617535221.local</segment>\r\n<segment bytes=\"398299\" number=\"24\">Part24of41.8103C0D03A79432CB7D7B527596CD009@1617535221.local</segment>\r\n<segment bytes=\"398477\" number=\"25\">Part25of41.091639B6F02740A0BF791DADF548780A@1617535221.local</segment>\r\n<segment bytes=\"398566\" number=\"26\">Part26of41.80928A2F4D034454952DF7D8D6B2CB7B@1617535221.local</segment>\r\n<segment bytes=\"398299\" number=\"27\">Part27of41.18AB5CE0B8E74C238DD2063AFE72C15E@1617535221.local</segment>\r\n<segment bytes=\"398326\" number=\"28\">Part28of41.21688C8E816E4648ADBF895D05374882@1617535221.local</segment>\r\n<segment bytes=\"398380\" number=\"29\">Part29of41.19344906015E4A4FBA444D6F77CC0DDC@1617535221.local</segment>\r\n<segment bytes=\"398500\" number=\"30\">Part30of41.8F8FC4BE096646BC9F1BA7C744DCACC8@1617535221.local</segment>\r\n<segment bytes=\"398421\" number=\"31\">Part31of41.6479D30B0DC5418297DFCAE7D7B3D4D3@1617535221.local</segment>\r\n<segment bytes=\"398476\" number=\"32\">Part32of41.06C8BCD407AF4BCCA8BAB237832E3385@1617535221.local</segment>\r\n<segment bytes=\"398461\" number=\"33\">Part33of41.2D2C2931CF1643C4AB5F00F6F8BABEF7@1617535221.local</segment>\r\n<segment bytes=\"398396\" number=\"34\">Part34of41.F13CAF88B2ED4CE6BC8A6DCF3BC4A828@1617535221.local</segment>\r\n<segment bytes=\"398466\" number=\"35\">Part35of41.0944352E98AB431BBD7573173DF032E9@1617535221.local</segment>\r\n<segment bytes=\"398310\" number=\"36\">Part36of41.66706220C9EB470BAD0ED741DBAD1535@1617535221.local</segment>\r\n<segment bytes=\"398407\" number=\"37\">Part37of41.72DC531725334D8096AE70BE1E455009@1617535221.local</segment>\r\n<segment bytes=\"398467\" number=\"38\">Part38of41.2E10464FA62345948CFB37D3046AF82E@1617535221.local</segment>\r\n<segment bytes=\"398410\" number=\"39\">Part39of41.6A44131A52E2428B88ADF5BD47C5FFCC@1617535221.local</segment>\r\n<segment bytes=\"398254\" number=\"40\">Part40of41.7C09322E3D4C40CB8B124F9DAFA3A0BC@1617535221.local</segment>\r\n<segment bytes=\"382539\" number=\"41\">Part41of41.800AC7082AA640308ED7F79E105568AC@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590856, 'House Party with Alan Walker (2020) - [08/21] - \"House Party with Alan Walker (2020).part06.rar\" yEnc (1/41)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 16319103, 41, 41, '1'),
(20, 2, 17, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590837\" subject=\"House Party with Alan Walker (2020) - [01/21] - &quot;House Party with Alan Walker (2020).nfo&quot; yEnc (1/1)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"2186\" number=\"1\">Part1of1.06344C21A6434EB4975A0F9C052CF007@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590837, 'House Party with Alan Walker (2020) - [01/21] - \"House Party with Alan Walker (2020).nfo\" yEnc (1/1)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 2186, 1, 1, '1'),
(21, 2, 18, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590874\" subject=\"House Party with Alan Walker (2020) - [11/21] - &quot;House Party with Alan Walker (2020).part09.rar&quot; yEnc (1/41)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398430\" number=\"1\">Part1of41.BA9CD87BE6DE4B97B914F80B935EFAAD@1617535221.local</segment>\r\n<segment bytes=\"398360\" number=\"2\">Part2of41.ADE5C7E9436E4C74AC39B01E14394278@1617535221.local</segment>\r\n<segment bytes=\"398380\" number=\"3\">Part3of41.A7F5350FDE4D4B50B8EB1AEF58A861CA@1617535221.local</segment>\r\n<segment bytes=\"398426\" number=\"4\">Part4of41.DA4BB1D44A8F4785935E388C3093B01E@1617535221.local</segment>\r\n<segment bytes=\"398347\" number=\"5\">Part5of41.9E2FD2C19624474CACA828E8E64A5C81@1617535221.local</segment>\r\n<segment bytes=\"398429\" number=\"6\">Part6of41.9BDE84DFCCF040688A06B63D2D7A7F14@1617535221.local</segment>\r\n<segment bytes=\"398640\" number=\"7\">Part7of41.95DAC37D5F9E4858AD648AF6400DAB1E@1617535221.local</segment>\r\n<segment bytes=\"398462\" number=\"8\">Part8of41.4780282DE02F4A2C8FD025F3CCC24D09@1617535221.local</segment>\r\n<segment bytes=\"398253\" number=\"9\">Part9of41.8870E5950E6647E9A35675729DD17AF5@1617535221.local</segment>\r\n<segment bytes=\"398514\" number=\"10\">Part10of41.BD9625D319F24F4DAF5552E1CEC0E09B@1617535221.local</segment>\r\n<segment bytes=\"398485\" number=\"11\">Part11of41.0C619D385D6140938D55CFF0F7A8EEC0@1617535221.local</segment>\r\n<segment bytes=\"398335\" number=\"12\">Part12of41.C931CB61651B4F6C9BE8A72686EACBBD@1617535221.local</segment>\r\n<segment bytes=\"398487\" number=\"15\">Part15of41.8DA0D5D12455484DB3D5A4CFA9CDC590@1617535221.local</segment>\r\n<segment bytes=\"398516\" number=\"16\">Part16of41.E5F8C093ED204832A5425E0716BEB77C@1617535221.local</segment>\r\n<segment bytes=\"398750\" number=\"17\">Part17of41.CCD4E541174249098B5F9C9B5EB12D32@1617535221.local</segment>\r\n<segment bytes=\"398817\" number=\"13\">Part13of41.E531D5B12F5244FE88FE057759965C9E@1617535221.local</segment>\r\n<segment bytes=\"398371\" number=\"14\">Part14of41.D3646DAF10FE421FAC9B890B9DD29718@1617535221.local</segment>\r\n<segment bytes=\"398508\" number=\"18\">Part18of41.CDF54C54AA39432AB2C72A829361BDCA@1617535221.local</segment>\r\n<segment bytes=\"398487\" number=\"21\">Part21of41.16EB4987CCDC47ADBC89A8CC8E25BE39@1617535221.local</segment>\r\n<segment bytes=\"398594\" number=\"19\">Part19of41.C1FB1CB2BA3B4151AFF42C4D55369CF2@1617535221.local</segment>\r\n<segment bytes=\"398453\" number=\"20\">Part20of41.BB7088CE134F4BFFA8431DD8A5AA778D@1617535221.local</segment>\r\n<segment bytes=\"398505\" number=\"22\">Part22of41.AE7BBEADF3D2470B9ED233EBC1C944B3@1617535221.local</segment>\r\n<segment bytes=\"398584\" number=\"24\">Part24of41.08FAF23C449645F280E407EEADD8FE29@1617535221.local</segment>\r\n<segment bytes=\"398383\" number=\"23\">Part23of41.DEE4EE527C7C4C13A3D388D9190B6633@1617535221.local</segment>\r\n<segment bytes=\"398519\" number=\"25\">Part25of41.D1E9989F10654B28B5FD74ADBDABF234@1617535221.local</segment>\r\n<segment bytes=\"398565\" number=\"26\">Part26of41.5508A3C21A2C412AAB0AC19555820419@1617535221.local</segment>\r\n<segment bytes=\"398593\" number=\"27\">Part27of41.A56DDDFD61184B0091E5977EBF615556@1617535221.local</segment>\r\n<segment bytes=\"398648\" number=\"28\">Part28of41.6C2BCC0DC1294A8D870650D1F731E997@1617535221.local</segment>\r\n<segment bytes=\"398677\" number=\"29\">Part29of41.C73190A1DE6E4D9791CC6ABA52D39366@1617535221.local</segment>\r\n<segment bytes=\"398593\" number=\"30\">Part30of41.C6E854005B914955A7F6F00AE14F248B@1617535221.local</segment>\r\n<segment bytes=\"398455\" number=\"31\">Part31of41.15736F631D674E9B909E7FBD9D491BB6@1617535221.local</segment>\r\n<segment bytes=\"398553\" number=\"32\">Part32of41.40E3A82FF2F34FD3B684BF27C713DF16@1617535221.local</segment>\r\n<segment bytes=\"398466\" number=\"33\">Part33of41.5C7AA673DC6F40EE849743A36D5B4CA3@1617535221.local</segment>\r\n<segment bytes=\"398546\" number=\"34\">Part34of41.7789BFD40A364FF6965B3265893590EE@1617535221.local</segment>\r\n<segment bytes=\"398430\" number=\"35\">Part35of41.A3669F392F1B4D9CBDE2A3A56B0F0124@1617535221.local</segment>\r\n<segment bytes=\"398565\" number=\"36\">Part36of41.BB358BC220234A518771EDB2FA83BDC7@1617535221.local</segment>\r\n<segment bytes=\"398543\" number=\"37\">Part37of41.C29D13EB4F98477B8168AEFB6DC1B3F5@1617535221.local</segment>\r\n<segment bytes=\"398678\" number=\"38\">Part38of41.97B229354B7449FDBE340C432240B084@1617535221.local</segment>\r\n<segment bytes=\"398701\" number=\"40\">Part40of41.3DE1C1F81221479B96F4764CB02E0B42@1617535221.local</segment>\r\n<segment bytes=\"398562\" number=\"39\">Part39of41.59781D1BF2C44975958C1CCFEB8E7844@1617535221.local</segment>\r\n<segment bytes=\"382683\" number=\"41\">Part41of41.8CD2FE793B5B47148F606BBD0E5F97B8@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590874, 'House Party with Alan Walker (2020) - [11/21] - \"House Party with Alan Walker (2020).part09.rar\" yEnc (1/41)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 16323293, 41, 41, '1'),
(22, 2, 19, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590837\" subject=\"House Party with Alan Walker (2020) - [02/21] - &quot;House Party with Alan Walker (2020).par2&quot; yEnc (1/1)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"15023\" number=\"1\">Part1of1.4CD89A82EBCD4C049A45F475D1D75A3A@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590837, 'House Party with Alan Walker (2020) - [02/21] - \"House Party with Alan Walker (2020).par2\" yEnc (1/1)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 15023, 1, 1, '0'),
(23, 2, 20, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590837\" subject=\"House Party with Alan Walker (2020) - [03/21] - &quot;House Party with Alan Walker (2020).part01.rar&quot; yEnc (1/41)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398542\" number=\"1\">Part1of41.3754070424034A8C9A925153120B43E3@1617535221.local</segment>\r\n<segment bytes=\"398570\" number=\"2\">Part2of41.8C1D2F0FA52647BEAA444736F8B8AE79@1617535221.local</segment>\r\n<segment bytes=\"398574\" number=\"3\">Part3of41.8D7E7880E6944A56AADDF83E173A83BA@1617535221.local</segment>\r\n<segment bytes=\"398522\" number=\"4\">Part4of41.6D517E8702F5469786DB0B6E7AFD7E4E@1617535221.local</segment>\r\n<segment bytes=\"398453\" number=\"5\">Part5of41.65E2429973074C55A8B43FC591ECA97A@1617535221.local</segment>\r\n<segment bytes=\"398423\" number=\"6\">Part6of41.D41E7891E5FC4C35A786C376A7362498@1617535221.local</segment>\r\n<segment bytes=\"398483\" number=\"7\">Part7of41.360B3B463870426AAD409FCF7B0669B1@1617535221.local</segment>\r\n<segment bytes=\"398367\" number=\"8\">Part8of41.2C2B8A83F7474EBDB3D93035110D9328@1617535221.local</segment>\r\n<segment bytes=\"398518\" number=\"9\">Part9of41.1CA60B1FA46F4C73A9B1EF038B16B585@1617535221.local</segment>\r\n<segment bytes=\"398698\" number=\"10\">Part10of41.8CA81BBE97DA427FB93452FF1AB20C2C@1617535221.local</segment>\r\n<segment bytes=\"398485\" number=\"11\">Part11of41.35F3B9BA4EC64EAD98535468592AC935@1617535221.local</segment>\r\n<segment bytes=\"398459\" number=\"12\">Part12of41.F9125FE31326431CAEE7FFED5B8976EA@1617535221.local</segment>\r\n<segment bytes=\"398417\" number=\"13\">Part13of41.814F4F90C22E47F7BE2CD57F4E1BD802@1617535221.local</segment>\r\n<segment bytes=\"398392\" number=\"14\">Part14of41.DEC22E654B7446C285F60169D911A385@1617535221.local</segment>\r\n<segment bytes=\"398527\" number=\"15\">Part15of41.1369B2E67A694161A97003D9E3ABC93B@1617535221.local</segment>\r\n<segment bytes=\"398291\" number=\"16\">Part16of41.2C0B2BE024714B6398B7EA7AD12906F5@1617535221.local</segment>\r\n<segment bytes=\"398453\" number=\"17\">Part17of41.DE92C646F18F48F3B41B35D504C46D64@1617535221.local</segment>\r\n<segment bytes=\"398425\" number=\"18\">Part18of41.650CD78775D841A4BE2B8CA2ED5F2161@1617535221.local</segment>\r\n<segment bytes=\"398357\" number=\"19\">Part19of41.5304E801B0964B63B3B55C71BAB2157D@1617535221.local</segment>\r\n<segment bytes=\"398509\" number=\"20\">Part20of41.1AAFB635EBDB4BC9962D415BBAF2A881@1617535221.local</segment>\r\n<segment bytes=\"398535\" number=\"21\">Part21of41.07EB0C375CF04C08B1535806DF4179ED@1617535221.local</segment>\r\n<segment bytes=\"398569\" number=\"22\">Part22of41.15B4156FC63042EBB58F8A62F82382F9@1617535221.local</segment>\r\n<segment bytes=\"398507\" number=\"23\">Part23of41.BDFD11BC130D4F1F8A263FBC7ECF6E73@1617535221.local</segment>\r\n<segment bytes=\"398465\" number=\"24\">Part24of41.0755328027A649C78CAB9A307B1D119B@1617535221.local</segment>\r\n<segment bytes=\"398530\" number=\"25\">Part25of41.5080D6E0FF0D497A8324D4F1B5EBE838@1617535221.local</segment>\r\n<segment bytes=\"398472\" number=\"26\">Part26of41.9AC0F423CAD64ABF823019323BD3F912@1617535221.local</segment>\r\n<segment bytes=\"398674\" number=\"27\">Part27of41.4F33C6185EC040C490BB3113E1703F54@1617535221.local</segment>\r\n<segment bytes=\"398356\" number=\"28\">Part28of41.572015504A1B48859F3ED413B07CC8D7@1617535221.local</segment>\r\n<segment bytes=\"398613\" number=\"29\">Part29of41.89E3DB9F364D46A1825F435A80734ECB@1617535221.local</segment>\r\n<segment bytes=\"398430\" number=\"30\">Part30of41.8E710D1432D34D5B9CFB97611E706E53@1617535221.local</segment>\r\n<segment bytes=\"398303\" number=\"31\">Part31of41.3D847FFD3FDD46FDB394A378412DA8E9@1617535221.local</segment>\r\n<segment bytes=\"398547\" number=\"32\">Part32of41.83EA4954A6FA4A54985ACE28CC98F7B6@1617535221.local</segment>\r\n<segment bytes=\"398393\" number=\"33\">Part33of41.B3BFDC5B98FC4274902D5C1714880384@1617535221.local</segment>\r\n<segment bytes=\"398391\" number=\"34\">Part34of41.C4EF7A57DE4844C2B4EAC547298B2360@1617535221.local</segment>\r\n<segment bytes=\"398418\" number=\"35\">Part35of41.3F788ECCBE274BA186603A96834A2FA6@1617535221.local</segment>\r\n<segment bytes=\"398438\" number=\"36\">Part36of41.43259052FF464B0591CEC31BC86266E6@1617535221.local</segment>\r\n<segment bytes=\"398439\" number=\"37\">Part37of41.7BAD31229C24424CB19772274B6D42C5@1617535221.local</segment>\r\n<segment bytes=\"398566\" number=\"38\">Part38of41.95CED91352AA41B5B22B0CF371D10BE8@1617535221.local</segment>\r\n<segment bytes=\"398583\" number=\"39\">Part39of41.4E147EC6E97A44EDB40E5CAE1960DEC3@1617535221.local</segment>\r\n<segment bytes=\"398331\" number=\"40\">Part40of41.302B7B378B5F4BB0A64CE66C7A6C82B9@1617535221.local</segment>\r\n<segment bytes=\"382454\" number=\"41\">Part41of41.555B0C42CA924A309199BD122E4A1CAF@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590837, 'House Party with Alan Walker (2020) - [03/21] - \"House Party with Alan Walker (2020).part01.rar\" yEnc (1/41)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 16321479, 41, 41, '1'),
(24, 2, 21, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590875\" subject=\"House Party with Alan Walker (2020) - [14/21] - &quot;House Party with Alan Walker (2020).part12.rar&quot; yEnc (1/41)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398498\" number=\"1\">Part1of41.4D5FAFE6B4554B16B35792627B184845@1617535221.local</segment>\r\n<segment bytes=\"398479\" number=\"2\">Part2of41.0440610057E241738E66CCF60F7D57F4@1617535221.local</segment>\r\n<segment bytes=\"398374\" number=\"3\">Part3of41.B0EA2E51A7514F969DFC37C797F754D4@1617535221.local</segment>\r\n<segment bytes=\"398547\" number=\"4\">Part4of41.C109238F7E3A4F44BE985E0637865EC7@1617535221.local</segment>\r\n<segment bytes=\"398581\" number=\"5\">Part5of41.7E7CEB80FCD140A9B66A838FB3A9CF05@1617535221.local</segment>\r\n<segment bytes=\"398269\" number=\"6\">Part6of41.2886DE16DED74AA191384378375FC16D@1617535221.local</segment>\r\n<segment bytes=\"398391\" number=\"7\">Part7of41.EE34D30EF38F4C1AACBE7313ADE4B4FD@1617535221.local</segment>\r\n<segment bytes=\"398357\" number=\"8\">Part8of41.38FB9DAFAF164559AFF3486B86A48EC5@1617535221.local</segment>\r\n<segment bytes=\"398459\" number=\"9\">Part9of41.7126430AB68B45D2823E711A08999F0A@1617535221.local</segment>\r\n<segment bytes=\"398456\" number=\"10\">Part10of41.88487CF63822418FBB6603BAFFD57296@1617535221.local</segment>\r\n<segment bytes=\"398643\" number=\"11\">Part11of41.DFDCCBA3B60B4C6F903503D31B358CCA@1617535221.local</segment>\r\n<segment bytes=\"398620\" number=\"12\">Part12of41.58BC2D510D204B6684F43956214D2908@1617535221.local</segment>\r\n<segment bytes=\"398585\" number=\"13\">Part13of41.E0ED96C7AF0A47C58958EAF4E006A00B@1617535221.local</segment>\r\n<segment bytes=\"398558\" number=\"14\">Part14of41.0ECC10ABEBB14E618D8D1699BCEC9D06@1617535221.local</segment>\r\n<segment bytes=\"398612\" number=\"15\">Part15of41.BCE18F259661473081381D91178AC5E9@1617535221.local</segment>\r\n<segment bytes=\"398480\" number=\"16\">Part16of41.7E2CF4D6E12546498381DA9673F1909F@1617535221.local</segment>\r\n<segment bytes=\"398449\" number=\"17\">Part17of41.E1E53A9DC2A0457FB0477C228FF7B875@1617535221.local</segment>\r\n<segment bytes=\"398586\" number=\"18\">Part18of41.D2B7B4D7A03E49EAB6AE882964488ABC@1617535221.local</segment>\r\n<segment bytes=\"398415\" number=\"21\">Part21of41.646D3DE6BD104D1694C2E5B064DEE432@1617535221.local</segment>\r\n<segment bytes=\"398452\" number=\"19\">Part19of41.9256CCC994B34FA0A63D86C982F8BB26@1617535221.local</segment>\r\n<segment bytes=\"398504\" number=\"20\">Part20of41.DE3096E0589F4E9EBB3DB858A78C2F0E@1617535221.local</segment>\r\n<segment bytes=\"398526\" number=\"24\">Part24of41.54A97D5FB91A4C269DB9AD13E371CEA1@1617535221.local</segment>\r\n<segment bytes=\"398561\" number=\"22\">Part22of41.8866400BEDAF4E9EAFC736941FAB20A3@1617535221.local</segment>\r\n<segment bytes=\"398573\" number=\"26\">Part26of41.20160CB04EB1427E9BBA1BCE71DCDCC1@1617535221.local</segment>\r\n<segment bytes=\"398475\" number=\"23\">Part23of41.7E1CC21552F247A8B57E1798F54AF52E@1617535221.local</segment>\r\n<segment bytes=\"398458\" number=\"25\">Part25of41.504B5BE99D0F49258312DD12BFC85177@1617535221.local</segment>\r\n<segment bytes=\"398524\" number=\"28\">Part28of41.EA433E6A8F2F4871BBCC48A703F8C692@1617535221.local</segment>\r\n<segment bytes=\"398629\" number=\"27\">Part27of41.5B5ECC747AE7428CB1673ED5E92532C7@1617535221.local</segment>\r\n<segment bytes=\"398310\" number=\"29\">Part29of41.4B8789DB3F45489D99EBD3352341FE24@1617535221.local</segment>\r\n<segment bytes=\"398499\" number=\"30\">Part30of41.E7A849D52C1B4349B2B70B45F6307D92@1617535221.local</segment>\r\n<segment bytes=\"398751\" number=\"31\">Part31of41.5CF982A8F440450CA3ABF6E2BE717B87@1617535221.local</segment>\r\n<segment bytes=\"398335\" number=\"32\">Part32of41.43A1052DEC9045A18BA1DB063991A6BB@1617535221.local</segment>\r\n<segment bytes=\"398685\" number=\"37\">Part37of41.A789B10424F84449AFB367E3C23F1F9C@1617535221.local</segment>\r\n<segment bytes=\"398471\" number=\"33\">Part33of41.2F176596DF33466AB8F6A1B07AE5F174@1617535221.local</segment>\r\n<segment bytes=\"398767\" number=\"34\">Part34of41.298B7A506DC34A6D91518DFC248522CD@1617535221.local</segment>\r\n<segment bytes=\"398439\" number=\"35\">Part35of41.D810F7CE195B44E19DC96C2217D039D2@1617535221.local</segment>\r\n<segment bytes=\"398548\" number=\"36\">Part36of41.71C0839224CD43978DF9E0562DA97800@1617535221.local</segment>\r\n<segment bytes=\"398777\" number=\"38\">Part38of41.47458ED7159C440F9C17D35B133785D4@1617535221.local</segment>\r\n<segment bytes=\"398523\" number=\"39\">Part39of41.56609925E5F547BFB109582FD3CEA4FB@1617535221.local</segment>\r\n<segment bytes=\"398628\" number=\"40\">Part40of41.98C6373BDC0F47E0A7D8505122B9993D@1617535221.local</segment>\r\n<segment bytes=\"382825\" number=\"41\">Part41of41.5C03A3CFE4EC4ECC81FB9940A85FD0FF@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590875, 'House Party with Alan Walker (2020) - [14/21] - \"House Party with Alan Walker (2020).part12.rar\" yEnc (1/41)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 16323619, 41, 41, '1'),
(25, 2, 22, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590856\" subject=\"House Party with Alan Walker (2020) - [09/21] - &quot;House Party with Alan Walker (2020).part07.rar&quot; yEnc (1/41)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398277\" number=\"1\">Part1of41.68683F9738B3452CB5749E832D431A5A@1617535221.local</segment>\r\n<segment bytes=\"398551\" number=\"2\">Part2of41.8EEB9AF69F7E43A896ECFCACFE3A5D72@1617535221.local</segment>\r\n<segment bytes=\"398443\" number=\"3\">Part3of41.0DCE8938ACD6457B8EB79ADADBE1C576@1617535221.local</segment>\r\n<segment bytes=\"398454\" number=\"4\">Part4of41.7DD36731488A4668BD60908C2C96764C@1617535221.local</segment>\r\n<segment bytes=\"398514\" number=\"5\">Part5of41.31F51839FD634AC8A6E4F4BA2CD0901C@1617535221.local</segment>\r\n<segment bytes=\"398370\" number=\"6\">Part6of41.E3A905FC4E21407BABC920B77E96DFD8@1617535221.local</segment>\r\n<segment bytes=\"398505\" number=\"7\">Part7of41.5DC77086B41F49E6B01D837B8C870C63@1617535221.local</segment>\r\n<segment bytes=\"398329\" number=\"8\">Part8of41.E17394D99114419E8B1A75D238FBE571@1617535221.local</segment>\r\n<segment bytes=\"398425\" number=\"9\">Part9of41.BDE17B143FA34C9E9BB54F7D7D4D4CEF@1617535221.local</segment>\r\n<segment bytes=\"398312\" number=\"10\">Part10of41.C30FA995D7604BB09D3148A88D724A24@1617535221.local</segment>\r\n<segment bytes=\"398456\" number=\"11\">Part11of41.0CC71E83D0D046AC86CD0EA70896A78B@1617535221.local</segment>\r\n<segment bytes=\"398661\" number=\"12\">Part12of41.E20FEDF56D5146979A73C75CFBD3C4DC@1617535221.local</segment>\r\n<segment bytes=\"398385\" number=\"13\">Part13of41.5772641AF3C14E4697271B05FC996A86@1617535221.local</segment>\r\n<segment bytes=\"398682\" number=\"14\">Part14of41.FAFE0B83B1DF454F94695E09C38469DA@1617535221.local</segment>\r\n<segment bytes=\"398446\" number=\"15\">Part15of41.4126108FF00E45678BEC1B9F935B9F72@1617535221.local</segment>\r\n<segment bytes=\"398503\" number=\"16\">Part16of41.90BA4E9CFA694651B7E3ECE907134223@1617535221.local</segment>\r\n<segment bytes=\"398514\" number=\"17\">Part17of41.7A0B15B1B1C6461EB7727F03A1898C81@1617535221.local</segment>\r\n<segment bytes=\"398522\" number=\"18\">Part18of41.787BD43AD9204CAEA5D2EA938A14911C@1617535221.local</segment>\r\n<segment bytes=\"398432\" number=\"19\">Part19of41.AEDA084F69AA4B8D8B1FFAF2FDD56BD2@1617535221.local</segment>\r\n<segment bytes=\"398304\" number=\"20\">Part20of41.E5216CF4CF8645079C6309E00B95174F@1617535221.local</segment>\r\n<segment bytes=\"398370\" number=\"21\">Part21of41.F1F1254B9C39423A990D2C90422A4B11@1617535221.local</segment>\r\n<segment bytes=\"398461\" number=\"22\">Part22of41.5191DA4BFF6B464BBFEB1CB8D0F4BE65@1617535221.local</segment>\r\n<segment bytes=\"398341\" number=\"23\">Part23of41.24A663C5901644D2B570610E30A10ECC@1617535221.local</segment>\r\n<segment bytes=\"398374\" number=\"24\">Part24of41.DB649774D0DF4629B39968091F4ADEF3@1617535221.local</segment>\r\n<segment bytes=\"398612\" number=\"25\">Part25of41.134076619DBF4374B6A3208349E51362@1617535221.local</segment>\r\n<segment bytes=\"398457\" number=\"26\">Part26of41.223BA6D543E142EEAC3E1602633033DA@1617535221.local</segment>\r\n<segment bytes=\"398437\" number=\"27\">Part27of41.99A6496A3D6240F282219636A9C4A0AC@1617535221.local</segment>\r\n<segment bytes=\"398323\" number=\"28\">Part28of41.A4279B746DE5466793AB84007165776D@1617535221.local</segment>\r\n<segment bytes=\"398443\" number=\"29\">Part29of41.7600D7EB105649BAACD26FEA04515E82@1617535221.local</segment>\r\n<segment bytes=\"398494\" number=\"30\">Part30of41.22EB8057145E46229ABF711A78A56132@1617535221.local</segment>\r\n<segment bytes=\"398431\" number=\"31\">Part31of41.E2BA2A5823F34811A1E1A869DD2E840C@1617535221.local</segment>\r\n<segment bytes=\"398506\" number=\"32\">Part32of41.611D2FD0912D4DFB914EDF2E25F59E0B@1617535221.local</segment>\r\n<segment bytes=\"398285\" number=\"33\">Part33of41.C8128CF4A7244C489BC2868F7CC4205C@1617535221.local</segment>\r\n<segment bytes=\"398593\" number=\"34\">Part34of41.C7863BC8F4794816B8DB697B74E4C276@1617535221.local</segment>\r\n<segment bytes=\"398376\" number=\"35\">Part35of41.DDF6E2B2B99D4B1095AC80B05293FA09@1617535221.local</segment>\r\n<segment bytes=\"398459\" number=\"36\">Part36of41.69998BE9EEAF45EE90EB91D82EEE3A2B@1617535221.local</segment>\r\n<segment bytes=\"398427\" number=\"37\">Part37of41.5A5EA294AD5748178E94D5FF6CD62D69@1617535221.local</segment>\r\n<segment bytes=\"398540\" number=\"38\">Part38of41.2BA1B3EAA07D442A9837FE492A786551@1617535221.local</segment>\r\n<segment bytes=\"398510\" number=\"39\">Part39of41.E46489F29F824464989A6A35C239126D@1617535221.local</segment>\r\n<segment bytes=\"398537\" number=\"40\">Part40of41.E4B1052B46B0469CBEAF1950ED6FB2A5@1617535221.local</segment>\r\n<segment bytes=\"382578\" number=\"41\">Part41of41.BA702F3533A3462FB73AE4A692DAFD99@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590856, 'House Party with Alan Walker (2020) - [09/21] - \"House Party with Alan Walker (2020).part07.rar\" yEnc (1/41)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 16320639, 41, 41, '1'),
(26, 2, 23, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590837\" subject=\"House Party with Alan Walker (2020) - [04/21] - &quot;House Party with Alan Walker (2020).part02.rar&quot; yEnc (1/41)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398356\" number=\"1\">Part1of41.452455C3D8AD460BBCCB54E639958C99@1617535221.local</segment>\r\n<segment bytes=\"398483\" number=\"2\">Part2of41.8B9D5B0BF60D47E3A82CBD4F3D9BBED4@1617535221.local</segment>\r\n<segment bytes=\"398385\" number=\"3\">Part3of41.461F79C63C874FFFA7A602CA53C6DC65@1617535221.local</segment>\r\n<segment bytes=\"398357\" number=\"4\">Part4of41.CA06E088136D4FD982A717D816A980AD@1617535221.local</segment>\r\n<segment bytes=\"398364\" number=\"5\">Part5of41.D32A18E62B80421AAE61E6F6B3ABC82E@1617535221.local</segment>\r\n<segment bytes=\"398496\" number=\"6\">Part6of41.E5BF509E41F741A79C42C1C3005C982A@1617535221.local</segment>\r\n<segment bytes=\"398224\" number=\"7\">Part7of41.62F2356E400C4AE88BF5F5AFC17DB0B4@1617535221.local</segment>\r\n<segment bytes=\"398415\" number=\"8\">Part8of41.A4465D349C3646839F17694B4BE8E289@1617535221.local</segment>\r\n<segment bytes=\"398369\" number=\"9\">Part9of41.50CDFEB2D426444CA3148578AF2527A3@1617535221.local</segment>\r\n<segment bytes=\"398390\" number=\"10\">Part10of41.3DBABB72C2D2421392AAB7DDAD522230@1617535221.local</segment>\r\n<segment bytes=\"398413\" number=\"11\">Part11of41.F27F7D3D0EF34FC89932DE81DE6E87C4@1617535221.local</segment>\r\n<segment bytes=\"398432\" number=\"12\">Part12of41.E5432F2DE07B401A998BA958F5FBB21C@1617535221.local</segment>\r\n<segment bytes=\"398360\" number=\"13\">Part13of41.4BED8CEC30B74101819BBF85525E7B34@1617535221.local</segment>\r\n<segment bytes=\"398534\" number=\"14\">Part14of41.DE17BEA1E00D4334AA775BA6F4E04B82@1617535221.local</segment>\r\n<segment bytes=\"398375\" number=\"15\">Part15of41.33625DDD5EC845B7BA54AE276EBB5911@1617535221.local</segment>\r\n<segment bytes=\"398338\" number=\"16\">Part16of41.281798A47819410DBF8D4420AD503DE9@1617535221.local</segment>\r\n<segment bytes=\"398364\" number=\"17\">Part17of41.B14EDB01801A4472925CE11A540E36DF@1617535221.local</segment>\r\n<segment bytes=\"398648\" number=\"18\">Part18of41.54FE6EFBAA964D73A7FD129764487073@1617535221.local</segment>\r\n<segment bytes=\"398521\" number=\"19\">Part19of41.D1BD287CE7E04E57906C5E7724335757@1617535221.local</segment>\r\n<segment bytes=\"398466\" number=\"20\">Part20of41.32866C79D8DD448896706CCAEE0B5537@1617535221.local</segment>\r\n<segment bytes=\"398433\" number=\"21\">Part21of41.254F4A6B1D644905B2FFD9B11DEB2902@1617535221.local</segment>\r\n<segment bytes=\"398430\" number=\"22\">Part22of41.D7E456D8E57A425CA36DE4FD1376F73B@1617535221.local</segment>\r\n<segment bytes=\"398406\" number=\"23\">Part23of41.233DF8DBB66D4CCFAFCA5400D38C3EA8@1617535221.local</segment>\r\n<segment bytes=\"398611\" number=\"24\">Part24of41.70707E90917540B38509AEAA088ABEBF@1617535221.local</segment>\r\n<segment bytes=\"398570\" number=\"25\">Part25of41.EB566A3A4C1C44998552764FC6025557@1617535221.local</segment>\r\n<segment bytes=\"398430\" number=\"26\">Part26of41.AFA509C3BAF942C0AE1083ABF5B8B405@1617535221.local</segment>\r\n<segment bytes=\"398399\" number=\"27\">Part27of41.DEE17299A8C041D09B2917EB30776C41@1617535221.local</segment>\r\n<segment bytes=\"398487\" number=\"28\">Part28of41.30CEC7F46576443588560CD411826092@1617535221.local</segment>\r\n<segment bytes=\"398392\" number=\"29\">Part29of41.71D13DA314234F938A70BE77D2BB16D8@1617535221.local</segment>\r\n<segment bytes=\"398382\" number=\"30\">Part30of41.C73BA83A644F4B158DFB4757727D14F0@1617535221.local</segment>\r\n<segment bytes=\"398370\" number=\"31\">Part31of41.658E62EFA9BE4DE08288C5163746E392@1617535221.local</segment>\r\n<segment bytes=\"398485\" number=\"32\">Part32of41.972801DDCF794E5A98E1DCCFA11BFB13@1617535221.local</segment>\r\n<segment bytes=\"398334\" number=\"33\">Part33of41.B379EB0A245F4A4195A5AFF96F5BCB96@1617535221.local</segment>\r\n<segment bytes=\"398360\" number=\"34\">Part34of41.C7BD1F77AED34A3E8BA547F6FC1E964A@1617535221.local</segment>\r\n<segment bytes=\"398527\" number=\"35\">Part35of41.6C6AED2B68CD4368B52C7CA089F94107@1617535221.local</segment>\r\n<segment bytes=\"398456\" number=\"36\">Part36of41.9FC0E64AF08C44688F198F3FB7E72093@1617535221.local</segment>\r\n<segment bytes=\"398373\" number=\"37\">Part37of41.39A404FD626E43289CEF15E155D578EA@1617535221.local</segment>\r\n<segment bytes=\"398525\" number=\"38\">Part38of41.F04C0653AF70406CBE4FC3E278CDB04C@1617535221.local</segment>\r\n<segment bytes=\"398428\" number=\"39\">Part39of41.51ABBB6FA92149A987DF870CA587E714@1617535221.local</segment>\r\n<segment bytes=\"398391\" number=\"40\">Part40of41.01624FB121EA4E4FA7BB02E2BD3CAE77@1617535221.local</segment>\r\n<segment bytes=\"382519\" number=\"41\">Part41of41.183670885692449E9F89AB4A7E0EAFFA@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590837, 'House Party with Alan Walker (2020) - [04/21] - \"House Party with Alan Walker (2020).part02.rar\" yEnc (1/41)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 16319598, 41, 41, '1'),
(27, 2, 24, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590893\" subject=\"House Party with Alan Walker (2020) - [16/21] - &quot;House Party with Alan Walker (2020).vol00+01.PAR2&quot; yEnc (1/2)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398749\" number=\"1\">Part1of2.4D33B16C02D345E89B22AB1AF5A4F116@1617535221.local</segment>\r\n<segment bytes=\"15385\" number=\"2\">Part2of2.0538983451C346CDB94A72A9F094DD85@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590893, 'House Party with Alan Walker (2020) - [16/21] - \"House Party with Alan Walker (2020).vol00+01.PAR2\" yEnc (1/2)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 414134, 2, 2, '0'),
(28, 2, 25, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590856\" subject=\"House Party with Alan Walker (2020) - [10/21] - &quot;House Party with Alan Walker (2020).part08.rar&quot; yEnc (1/41)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398391\" number=\"1\">Part1of41.B4AF4AFD80A64A2E82775FBF6F27FDCA@1617535221.local</segment>\r\n<segment bytes=\"398532\" number=\"2\">Part2of41.29CAD9258EE842F8940E7403B7D16BBB@1617535221.local</segment>\r\n<segment bytes=\"398283\" number=\"3\">Part3of41.4364C34732174813A3AE20118F426604@1617535221.local</segment>\r\n<segment bytes=\"398308\" number=\"4\">Part4of41.E8703A25DE13475BBAB5FB9FAD7D00D4@1617535221.local</segment>\r\n<segment bytes=\"398401\" number=\"5\">Part5of41.B28841C6841743DB95DE946751DF00F0@1617535221.local</segment>\r\n<segment bytes=\"398310\" number=\"6\">Part6of41.2A36BA4AA0094446856A39C6EEA2C0D2@1617535221.local</segment>\r\n<segment bytes=\"398292\" number=\"7\">Part7of41.7F22FA02351449EAB0C0BD21D7D436BD@1617535221.local</segment>\r\n<segment bytes=\"398316\" number=\"8\">Part8of41.F9984A8D7D1B4D20B1D82F3DC103D8B0@1617535221.local</segment>\r\n<segment bytes=\"398624\" number=\"9\">Part9of41.F7A66D9B525549999BB3780681E506AC@1617535221.local</segment>\r\n<segment bytes=\"398448\" number=\"10\">Part10of41.A80BAFD4BC444D63ABC74C665E6270F5@1617535221.local</segment>\r\n<segment bytes=\"398515\" number=\"11\">Part11of41.1473D93F625740B993E031235DCC6216@1617535221.local</segment>\r\n<segment bytes=\"398603\" number=\"12\">Part12of41.AAAE183589F64C79AEAC1448859E5667@1617535221.local</segment>\r\n<segment bytes=\"398448\" number=\"13\">Part13of41.55CE432F667E492B837C0304AEA38A77@1617535221.local</segment>\r\n<segment bytes=\"398438\" number=\"14\">Part14of41.B4A54C743B034223BD82F9E5E7EB4225@1617535221.local</segment>\r\n<segment bytes=\"398508\" number=\"15\">Part15of41.0CC681A1F4A04F89BF447E91D2BF4F31@1617535221.local</segment>\r\n<segment bytes=\"398356\" number=\"16\">Part16of41.DA2B8FE5F7CB48E18EC292C4C8C09819@1617535221.local</segment>\r\n<segment bytes=\"398388\" number=\"17\">Part17of41.81628FD3159646D3A765FAC2DE275430@1617535221.local</segment>\r\n<segment bytes=\"398448\" number=\"18\">Part18of41.632A391E823842A78328207A1FF0C0A8@1617535221.local</segment>\r\n<segment bytes=\"398475\" number=\"19\">Part19of41.7FF46A1167E8443B88381FB2622C2D3E@1617535221.local</segment>\r\n<segment bytes=\"398482\" number=\"20\">Part20of41.B0E4778E959047E79550374E700876D3@1617535221.local</segment>\r\n<segment bytes=\"398433\" number=\"21\">Part21of41.5409C6B58C20408DBC431420F8D71617@1617535221.local</segment>\r\n<segment bytes=\"398475\" number=\"22\">Part22of41.60DC33A1B0FB4CFBA0E6E7F20E2D4FDD@1617535221.local</segment>\r\n<segment bytes=\"398367\" number=\"23\">Part23of41.9C89E6E8E65F41EAAFFD0636265E41DC@1617535221.local</segment>\r\n<segment bytes=\"398498\" number=\"24\">Part24of41.A14288EFCE37463590C8A3B10F66872A@1617535221.local</segment>\r\n<segment bytes=\"398330\" number=\"25\">Part25of41.EBBD6B3F00464672BF0A050544D64D72@1617535221.local</segment>\r\n<segment bytes=\"398502\" number=\"26\">Part26of41.9E2445022B8B462398D1BB4C30F7BDCD@1617535221.local</segment>\r\n<segment bytes=\"398442\" number=\"27\">Part27of41.8EF9A006D7FF422D8636857F68E431D0@1617535221.local</segment>\r\n<segment bytes=\"398509\" number=\"28\">Part28of41.C79E067B15A84527BBB0DA783E2301E8@1617535221.local</segment>\r\n<segment bytes=\"398684\" number=\"29\">Part29of41.43CC7200EDE243FEA57B31DF999FEBE0@1617535221.local</segment>\r\n<segment bytes=\"398443\" number=\"30\">Part30of41.58833B3D55FD4749BBD9B9CDC60D3B99@1617535221.local</segment>\r\n<segment bytes=\"398477\" number=\"31\">Part31of41.41CBEEA92C5E448998D08F8DCAE5A06D@1617535221.local</segment>\r\n<segment bytes=\"398538\" number=\"32\">Part32of41.2968D6EAD79B4834BABD6F15BBF2D940@1617535221.local</segment>\r\n<segment bytes=\"398302\" number=\"33\">Part33of41.20FC783CA3F840538871748A13692ED8@1617535221.local</segment>\r\n<segment bytes=\"398397\" number=\"34\">Part34of41.9A80FE3D91C14115AFD376FFF5DADF0D@1617535221.local</segment>\r\n<segment bytes=\"398526\" number=\"35\">Part35of41.892B85359FF64A0BA0EE388BF8EFC6FD@1617535221.local</segment>\r\n<segment bytes=\"398477\" number=\"36\">Part36of41.BC78DDAD1D5041A78981D1346E85A230@1617535221.local</segment>\r\n<segment bytes=\"398244\" number=\"37\">Part37of41.E225D65D25D045299AD1156FB08F6D77@1617535221.local</segment>\r\n<segment bytes=\"398429\" number=\"38\">Part38of41.C812A9E2801E4CAF8AF84FA3B06380FC@1617535221.local</segment>\r\n<segment bytes=\"398486\" number=\"39\">Part39of41.6772CDC5BA75406390EA345E2B44FF62@1617535221.local</segment>\r\n<segment bytes=\"398296\" number=\"40\">Part40of41.6D530DA5F39B455FA4295E56C6BD6FDE@1617535221.local</segment>\r\n<segment bytes=\"382534\" number=\"41\">Part41of41.45A05D7E9CD7431FB9296E98212BE7CC@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590856, 'House Party with Alan Walker (2020) - [10/21] - \"House Party with Alan Walker (2020).part08.rar\" yEnc (1/41)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 16319955, 41, 41, '1'),
(29, 2, 26, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590894\" subject=\"House Party with Alan Walker (2020) - [20/21] - &quot;House Party with Alan Walker (2020).vol15+12.PAR2&quot; yEnc (1/13)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398781\" number=\"1\">Part1of13.EE85D884D2BE4E859BE25F1950B558FE@1617535221.local</segment>\r\n<segment bytes=\"398605\" number=\"2\">Part2of13.F0630A4F723840A18EBB0576C7AD3C97@1617535221.local</segment>\r\n<segment bytes=\"398691\" number=\"6\">Part6of13.A092B6CD288E4AA3840F0BE135148E98@1617535221.local</segment>\r\n<segment bytes=\"398496\" number=\"3\">Part3of13.1E656A84547E4E4F871E2916F769F635@1617535221.local</segment>\r\n<segment bytes=\"398752\" number=\"7\">Part7of13.938D810299E54BEEB1E1EAB9BB5B2F34@1617535221.local</segment>\r\n<segment bytes=\"398602\" number=\"4\">Part4of13.5821AFE4673845EFB50CC2CDE5A9984B@1617535221.local</segment>\r\n<segment bytes=\"398579\" number=\"5\">Part5of13.029ED728EB824DA6B9BB8CB219020721@1617535221.local</segment>\r\n<segment bytes=\"398595\" number=\"8\">Part8of13.7982786E5FD8463FA636BF8028B1B0B4@1617535221.local</segment>\r\n<segment bytes=\"398613\" number=\"9\">Part9of13.D5D946E588194F0EA1B2EF379DC11B47@1617535221.local</segment>\r\n<segment bytes=\"398647\" number=\"10\">Part10of13.3A3CDCF8D69744DD998E3FD5647CA7FE@1617535221.local</segment>\r\n<segment bytes=\"398710\" number=\"11\">Part11of13.64FF577F554B4E90BDD5566C18D05AB4@1617535221.local</segment>\r\n<segment bytes=\"398683\" number=\"12\">Part12of13.AC96C6F477F745CD96AE11C18C6B8D8E@1617535221.local</segment>\r\n<segment bytes=\"58646\" number=\"13\">Part13of13.F8954BF8C0D5404E87F10888892544C7@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590894, 'House Party with Alan Walker (2020) - [20/21] - \"House Party with Alan Walker (2020).vol15+12.PAR2\" yEnc (1/13)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 4842400, 13, 13, '0'),
(30, 2, 27, '<file poster=\"Michel2020@navaroo.com (Michel2002)\" date=\"1617590896\" subject=\"House Party with Alan Walker (2020) - [21/21] - &quot;House Party with Alan Walker (2020).vol27+23.PAR2&quot; yEnc (1/24)\">\r\n<groups>\r\n<group>alt.binaries.mp3</group>\r\n</groups>\r\n<segments>\r\n<segment bytes=\"398588\" number=\"1\">Part1of24.AB7D6DD518604809A9DAE5EB775BC3C5@1617535221.local</segment>\r\n<segment bytes=\"398699\" number=\"3\">Part3of24.ABA836A8728141BE8E6C63E4560D492B@1617535221.local</segment>\r\n<segment bytes=\"398646\" number=\"4\">Part4of24.3D155F0FCD6F4A01B472A97E04096D4D@1617535221.local</segment>\r\n<segment bytes=\"398494\" number=\"2\">Part2of24.65EBA7AA732946DBA4157264BA96F872@1617535221.local</segment>\r\n<segment bytes=\"398567\" number=\"5\">Part5of24.4831DD0CC5294BC5A58A962F0C878673@1617535221.local</segment>\r\n<segment bytes=\"398661\" number=\"6\">Part6of24.3873B479ED2541CC8D5ED455F10BE452@1617535221.local</segment>\r\n<segment bytes=\"398628\" number=\"7\">Part7of24.8D2C9E5B7DB94C1699245E740FE496A0@1617535221.local</segment>\r\n<segment bytes=\"398590\" number=\"12\">Part12of24.843ED47A56CC4F27BB448AC6B5464ADA@1617535221.local</segment>\r\n<segment bytes=\"398526\" number=\"8\">Part8of24.A81B297CBBE443B5B58007C83DF46F8E@1617535221.local</segment>\r\n<segment bytes=\"398646\" number=\"9\">Part9of24.6A79F2F748DD4EC5A9E37AC8AA5F978E@1617535221.local</segment>\r\n<segment bytes=\"398472\" number=\"10\">Part10of24.0961EFA2DBF34DF78BF176346283080C@1617535221.local</segment>\r\n<segment bytes=\"398578\" number=\"11\">Part11of24.91809B5C07DA4B81B20D40BE0BF2FC88@1617535221.local</segment>\r\n<segment bytes=\"398748\" number=\"14\">Part14of24.5B31BE55BEAD486C80D2F727ED3EAD3C@1617535221.local</segment>\r\n<segment bytes=\"398562\" number=\"13\">Part13of24.D53F38F6567A444090239275EBC79C7E@1617535221.local</segment>\r\n<segment bytes=\"398760\" number=\"18\">Part18of24.4573641A68994D84996323453F480DAB@1617535221.local</segment>\r\n<segment bytes=\"398537\" number=\"15\">Part15of24.C823AB00C6ED403C9D52AB86C1450119@1617535221.local</segment>\r\n<segment bytes=\"398671\" number=\"16\">Part16of24.9E897810678549D998FAFFB4B2915F26@1617535221.local</segment>\r\n<segment bytes=\"398594\" number=\"17\">Part17of24.8F21B970337549E9854E2B38F7676597@1617535221.local</segment>\r\n<segment bytes=\"398832\" number=\"22\">Part22of24.E56D95920ABA4B98A23B1BDBC7500F4A@1617535221.local</segment>\r\n<segment bytes=\"73446\" number=\"24\">Part24of24.08DAFBBD5ECF4ED681A0C7CDF380B4A5@1617535221.local</segment>\r\n<segment bytes=\"398459\" number=\"19\">Part19of24.07FC5929F4BB4C6581336EC3341AF16E@1617535221.local</segment>\r\n<segment bytes=\"398405\" number=\"20\">Part20of24.4B4BDC0A3CA84384AFF00A45BEACF947@1617535221.local</segment>\r\n<segment bytes=\"398447\" number=\"21\">Part21of24.05ED8447CD7A45F4982A6D2EF52F4239@1617535221.local</segment>\r\n<segment bytes=\"398571\" number=\"23\">Part23of24.6E7F2E214E3D40DA86FAA9257A24B665@1617535221.local</segment>\r\n</segments>\r\n', 'Michel2020@navaroo.com (Michel2002)', 1617590896, 'House Party with Alan Walker (2020) - [21/21] - \"House Party with Alan Walker (2020).vol27+23.PAR2\" yEnc (1/24)', 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', 9241127, 24, 24, '0');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `nzbs`
--

CREATE TABLE `nzbs` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `filename` varchar(255) NOT NULL DEFAULT '',
  `search_text` text NOT NULL,
  `descr` text NOT NULL,
  `ori_descr` text NOT NULL,
  `category` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `size` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `numfiles` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `comments` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `views` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `owner` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `nfo` text NOT NULL,
  `poster` text NOT NULL,
  `postdate` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `groups` text NOT NULL,
  `nzbvernum` char(3) NOT NULL DEFAULT '',
  `pars` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `partotsize` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `autoimdb` enum('no','yes') NOT NULL DEFAULT 'no',
  `url` varchar(100) NOT NULL DEFAULT '',
  `imdbrating` char(4) NOT NULL DEFAULT '',
  `genre` varchar(20) NOT NULL DEFAULT '',
  `addtext` varchar(25) NOT NULL DEFAULT '',
  `format` enum('na','ntsc','pal') NOT NULL DEFAULT 'na'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `nzbs`
--

INSERT INTO `nzbs` (`id`, `name`, `filename`, `search_text`, `descr`, `ori_descr`, `category`, `size`, `added`, `numfiles`, `comments`, `views`, `hits`, `owner`, `nfo`, `poster`, `postdate`, `groups`, `nzbvernum`, `pars`, `partotsize`, `autoimdb`, `url`, `imdbrating`, `genre`, `addtext`, `format`) VALUES
(1, 'tha-playah.nzb', '1-tha-playah.nzb-MyMintSite.com-4971.nzb', 'tha playah tha playah nzb 20 33 17 tha playah keep them titties jumping mp3 yEnc 12989471 1 19', 'muziek', 'muziek', 57, 26134859, '2021-04-27 17:22:39', 2, 0, 2, 1, 3, '', 'Cat <eager-poster@computer>', 1619180284, 'a:1:{i:0;s:17:\"alt.binaries.misc\";}', '1.0', 0, 0, 'no', '', '', '', '', 'na'),
(2, 'alan-walker.nzb', '2-alan-walker.nzb-MyMintSite.com-4616.nzb', 'alan walker alan walker nzb Alan Walker File 4 of 4 Alan Walker ft Tomine Harket Aura Darkside mp3 1 24', 'muziek', 'muziek', 54, 280019074, '2021-04-27 17:35:54', 28, 0, 2, 2, 3, '', 'Jos <j.curiuos@hotmail.com>', 1607873511, 'a:1:{i:0;s:16:\"alt.binaries.mp3\";}', '1.0', 7, 20224635, 'no', '', '', '', '', 'na');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `opschonen`
--

CREATE TABLE `opschonen` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tijd` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `opschonen`
--

INSERT INTO `opschonen` (`id`, `user_id`, `added`, `tijd`) VALUES
(1, 1, '2009-05-23 16:32:18', 1243089138),
(2, 3, '2021-04-18 10:43:31', 1618735411),
(3, 3, '2021-04-18 11:29:28', 1618738168),
(4, 3, '2021-04-18 13:36:29', 1618745789),
(5, 3, '2021-04-18 14:19:43', 1618748383),
(6, 3, '2021-04-18 15:10:14', 1618751414),
(7, 3, '2021-04-18 15:44:55', 1618753495),
(8, 3, '2021-04-18 16:26:19', 1618755979),
(9, 3, '2021-04-18 17:40:58', 1618760458),
(10, 3, '2021-04-19 15:25:32', 1618838732),
(11, 3, '2021-04-19 15:56:55', 1618840615),
(12, 3, '2021-04-19 17:05:54', 1618844754),
(13, 4, '2021-04-19 17:52:34', 1618847554),
(14, 3, '2021-04-19 18:45:04', 1618850704),
(15, 3, '2021-04-20 15:11:08', 1618924268),
(16, 3, '2021-04-20 16:46:20', 1618929980),
(17, 3, '2021-04-20 18:02:06', 1618934526),
(18, 3, '2021-04-20 18:34:26', 1618936466),
(19, 3, '2021-04-20 19:06:06', 1618938366),
(20, 3, '2021-04-20 19:51:45', 1618941105),
(21, 3, '2021-04-20 20:22:05', 1618942925),
(22, 3, '2021-04-21 13:26:04', 1619004364),
(23, 3, '2021-04-21 14:11:09', 1619007069),
(24, 3, '2021-04-21 14:49:15', 1619009355),
(25, 3, '2021-04-21 15:19:45', 1619011185),
(26, 7, '2021-04-21 18:38:56', 1619023136),
(27, 3, '2021-04-21 19:12:38', 1619025158),
(28, 3, '2021-04-21 19:43:15', 1619026995),
(29, 3, '2021-04-21 20:34:34', 1619030074),
(30, 3, '2021-04-21 21:11:32', 1619032292),
(31, 3, '2021-04-21 21:42:00', 1619034120),
(32, 3, '2021-04-22 13:20:16', 1619090416),
(33, 3, '2021-04-22 15:23:07', 1619097787),
(34, 3, '2021-04-22 16:23:45', 1619101425),
(35, 3, '2021-04-22 18:38:50', 1619109530),
(36, 3, '2021-04-22 20:19:29', 1619115569),
(37, 3, '2021-04-23 13:34:59', 1619177699),
(38, 3, '2021-04-23 14:57:55', 1619182675),
(39, 3, '2021-04-24 09:26:55', 1619249215),
(40, 3, '2021-04-24 11:05:45', 1619255145),
(41, 3, '2021-04-24 13:26:58', 1619263618),
(42, 3, '2021-04-24 14:14:25', 1619266465),
(43, 3, '2021-04-24 16:11:30', 1619273490),
(44, 3, '2021-04-24 19:09:23', 1619284163),
(45, 3, '2021-04-26 09:04:54', 1619420694),
(46, 3, '2021-04-26 11:42:50', 1619430170),
(47, 3, '2021-04-26 12:17:03', 1619432223),
(48, 3, '2021-04-26 12:47:08', 1619434028),
(49, 3, '2021-04-26 13:27:27', 1619436447),
(50, 3, '2021-04-26 15:47:54', 1619444874),
(51, 3, '2021-04-27 19:30:00', 1619544600),
(52, 3, '2021-04-28 13:21:12', 1619608872),
(53, 3, '2021-04-28 14:44:23', 1619613863),
(54, 3, '2021-04-28 18:33:24', 1619627604),
(55, 3, '2021-04-28 19:40:10', 1619631610),
(56, 3, '2021-04-28 20:29:32', 1619634572),
(57, 3, '2021-04-29 13:24:56', 1619695496),
(58, 3, '2021-04-29 14:42:31', 1619700151),
(59, 3, '2021-04-29 15:52:41', 1619704361),
(60, 3, '2021-04-29 17:45:56', 1619711156),
(61, 3, '2021-04-29 18:31:16', 1619713876),
(62, 3, '2021-04-29 19:11:11', 1619716271),
(63, 3, '2021-04-29 19:42:16', 1619718136),
(64, 3, '2021-04-30 12:56:33', 1619780193),
(65, 3, '2021-04-30 15:31:36', 1619789496),
(66, 3, '2021-04-30 16:29:13', 1619792953),
(67, 3, '2021-04-30 17:27:29', 1619796449),
(68, 3, '2021-04-30 18:03:08', 1619798588),
(69, 3, '2021-04-30 18:54:32', 1619801672),
(70, 3, '2021-04-30 19:45:29', 1619804729),
(71, 3, '2021-05-01 07:59:24', 1619848764),
(72, 3, '2021-05-01 08:51:34', 1619851894),
(73, 3, '2021-05-01 09:57:12', 1619855832),
(74, 3, '2021-05-01 13:28:59', 1619868539),
(75, 4, '2021-05-01 15:33:24', 1619876004),
(76, 3, '2021-05-01 16:03:41', 1619877821),
(77, 3, '2021-05-01 16:41:52', 1619880112),
(78, 3, '2021-05-01 17:23:40', 1619882620),
(79, 3, '2021-05-01 18:57:13', 1619888233),
(80, 3, '2021-05-02 17:53:40', 1619970820),
(81, 4, '2021-05-02 18:31:00', 1619973060),
(82, 3, '2021-05-02 20:06:29', 1619978789),
(83, 7, '2021-05-02 20:56:09', 1619981769),
(84, 3, '2021-05-03 14:40:08', 1620045608),
(85, 3, '2021-05-03 16:42:14', 1620052934),
(86, 3, '2021-05-03 17:23:13', 1620055393),
(87, 3, '2021-05-03 19:33:45', 1620063225),
(88, 3, '2021-05-03 20:04:14', 1620065054),
(89, 7, '2021-05-04 00:34:13', 1620081253),
(90, 3, '2021-05-04 14:43:14', 1620132194),
(91, 3, '2021-05-04 17:37:27', 1620142647),
(92, 3, '2021-05-04 19:58:16', 1620151096),
(93, 3, '2021-05-05 13:24:12', 1620213852),
(94, 3, '2021-05-05 17:20:25', 1620228025),
(95, 4, '2021-05-05 18:56:02', 1620233762),
(96, 3, '2021-05-06 15:35:52', 1620308152),
(97, 3, '2021-05-06 16:18:54', 1620310734),
(98, 3, '2021-05-06 17:55:11', 1620316511),
(99, 4, '2021-05-06 18:29:35', 1620318575),
(100, 3, '2021-05-06 19:02:22', 1620320542),
(101, 3, '2021-05-06 19:45:00', 1620323100),
(102, 3, '2021-05-06 20:25:32', 1620325532),
(103, 7, '2021-05-07 07:03:58', 1620363838),
(104, 7, '2021-05-07 10:03:14', 1620374594),
(105, 3, '2021-05-07 12:42:32', 1620384152),
(106, 3, '2021-05-07 13:26:13', 1620386773),
(107, 3, '2021-05-07 14:28:47', 1620390527),
(108, 3, '2021-05-07 15:06:29', 1620392789),
(109, 3, '2021-05-07 15:38:34', 1620394714),
(110, 3, '2021-05-07 16:59:02', 1620399542),
(111, 3, '2021-05-07 17:44:25', 1620402265),
(112, 3, '2021-05-07 18:49:56', 1620406196),
(113, 3, '2021-05-07 19:19:59', 1620407999),
(114, 3, '2021-05-07 20:18:30', 1620411510),
(115, 3, '2021-05-07 20:55:39', 1620413739),
(116, 3, '2021-05-07 22:24:39', 1620419079),
(117, 3, '2021-05-08 08:10:39', 1620454239),
(118, 3, '2021-05-08 08:57:27', 1620457047),
(119, 3, '2021-05-08 10:11:39', 1620461499),
(120, 3, '2021-05-08 10:49:12', 1620463752),
(121, 3, '2021-05-08 11:28:27', 1620466107),
(122, 3, '2021-05-08 11:59:26', 1620467966),
(123, 3, '2021-05-08 12:38:45', 1620470325),
(124, 3, '2021-05-08 13:10:04', 1620472204),
(125, 3, '2021-05-08 15:08:41', 1620479321),
(126, 3, '2021-05-08 15:44:39', 1620481479),
(127, 3, '2021-05-08 16:17:19', 1620483439),
(128, 3, '2021-05-08 17:29:31', 1620487771),
(129, 3, '2021-05-08 19:06:39', 1620493599),
(130, 3, '2021-05-08 19:42:07', 1620495727),
(131, 3, '2021-05-08 20:14:38', 1620497678),
(132, 3, '2021-05-09 08:45:20', 1620542720),
(133, 3, '2021-05-09 09:16:14', 1620544574),
(134, 3, '2021-05-09 10:22:02', 1620548522),
(135, 3, '2021-05-09 10:53:29', 1620550409),
(136, 3, '2021-05-09 11:25:58', 1620552358),
(137, 3, '2021-05-09 11:59:52', 1620554392),
(138, 3, '2021-05-09 16:01:37', 1620568897),
(139, 3, '2021-05-09 16:54:51', 1620572091),
(140, 3, '2021-05-09 19:14:33', 1620580473),
(141, 4, '2021-05-10 12:57:33', 1620644253),
(142, 3, '2021-05-10 15:15:47', 1620652547),
(143, 3, '2021-05-10 15:58:19', 1620655099),
(144, 3, '2021-05-10 17:00:12', 1620658812),
(145, 3, '2021-05-10 17:37:45', 1620661065),
(146, 3, '2021-05-10 18:23:06', 1620663786),
(147, 3, '2021-05-10 19:14:50', 1620666890),
(148, 3, '2021-05-10 20:29:07', 1620671347),
(149, 3, '2021-05-10 21:16:46', 1620674206),
(150, 3, '2021-05-10 21:47:01', 1620676021),
(151, 3, '2021-05-11 14:36:03', 1620736563),
(152, 3, '2021-05-11 15:06:06', 1620738366),
(153, 3, '2021-05-11 15:56:24', 1620741384),
(154, 3, '2021-05-11 17:19:36', 1620746376),
(155, 3, '2021-05-11 18:02:26', 1620748946),
(156, 3, '2021-05-11 18:51:41', 1620751901),
(157, 3, '2021-05-11 19:52:57', 1620755577),
(158, 3, '2021-05-11 20:23:09', 1620757389),
(159, 3, '2021-05-11 21:09:08', 1620760148),
(160, 3, '2021-05-12 16:31:53', 1620829913),
(161, 3, '2021-05-12 19:49:56', 1620841796),
(162, 3, '2021-05-12 21:33:05', 1620847985),
(163, 3, '2021-05-12 22:20:29', 1620850829),
(164, 3, '2021-05-13 09:24:27', 1620890667),
(165, 3, '2021-05-13 12:57:09', 1620903429),
(166, 3, '2021-05-13 13:48:09', 1620906489),
(167, 3, '2021-05-13 14:42:23', 1620909743),
(168, 3, '2021-05-13 15:38:58', 1620913138),
(169, 3, '2021-05-13 16:23:08', 1620915788),
(170, 3, '2021-05-13 17:41:14', 1620920474),
(171, 3, '2021-05-13 18:31:49', 1620923509),
(172, 3, '2021-05-13 20:00:16', 1620928816),
(173, 4, '2021-05-13 20:40:07', 1620931207),
(174, 3, '2021-05-13 21:18:02', 1620933482),
(175, 3, '2021-05-14 09:32:11', 1620977531),
(176, 3, '2021-05-14 10:19:54', 1620980394),
(177, 3, '2021-05-14 10:54:35', 1620982475),
(178, 3, '2021-05-14 11:41:57', 1620985317),
(179, 3, '2021-05-14 12:12:00', 1620987120),
(180, 8, '2021-06-16 22:49:40', 1623883780),
(181, 3, '2021-06-20 00:04:19', 1624147459),
(182, 8, '2021-06-20 01:02:52', 1624150972),
(183, 8, '2021-06-20 01:33:46', 1624152826),
(184, 3, '2021-06-20 10:45:37', 1624185937),
(185, 3, '2021-06-20 11:24:35', 1624188275),
(186, 3, '2021-06-20 11:55:56', 1624190156),
(187, 3, '2021-06-22 02:03:08', 1624327388),
(188, 3, '2021-06-22 15:21:13', 1624375273),
(189, 3, '2021-06-24 03:07:46', 1624504066),
(190, 8, '2021-06-24 10:38:16', 1624531096),
(191, 3, '2021-06-24 11:12:01', 1624533121),
(192, 3, '2021-06-24 22:28:32', 1624573712),
(193, 3, '2021-06-25 23:39:00', 1624664340),
(194, 3, '2021-06-26 01:08:11', 1624669691),
(195, 8, '2021-06-30 14:38:21', 1625063901),
(196, 3, '2021-07-01 13:27:06', 1625146026),
(197, 18, '2021-07-01 19:10:47', 1625166647),
(198, 11, '2021-07-04 02:50:43', 1625359843),
(199, 11, '2021-07-04 10:20:26', 1625386826),
(200, 11, '2021-07-04 12:01:11', 1625392871),
(201, 3, '2021-07-04 18:58:08', 1625417888),
(202, 11, '2021-07-04 20:09:37', 1625422177),
(203, 11, '2021-07-04 22:36:44', 1625431004),
(204, 11, '2021-07-05 11:46:54', 1625478414),
(205, 8, '2021-07-05 12:19:32', 1625480372),
(206, 8, '2021-07-06 01:48:50', 1625528930),
(207, 11, '2021-07-07 23:19:14', 1625692754),
(208, 3, '2021-07-21 15:29:06', 1626874146),
(209, 3, '2021-07-21 18:23:20', 1626884600),
(210, 3, '2021-07-21 20:49:48', 1626893388),
(211, 8, '2021-07-30 00:47:03', 1627598823),
(212, 8, '2021-07-30 01:21:52', 1627600912),
(213, 8, '2021-07-30 03:06:05', 1627607165),
(214, 8, '2021-07-30 12:40:45', 1627641645),
(215, 8, '2021-07-30 13:12:14', 1627643534),
(216, 8, '2021-07-30 13:44:05', 1627645445),
(217, 3, '2021-07-31 00:44:38', 1627685078),
(218, 3, '2021-09-01 12:38:52', 1630492732),
(219, 3, '2021-09-06 03:28:37', 1630891717),
(220, 3, '2021-09-22 17:06:37', 1632344797),
(221, 8, '2021-09-22 18:59:03', 1632351543),
(222, 8, '2021-09-22 19:42:29', 1632354149),
(223, 3, '2021-11-14 23:34:27', 1636929267),
(224, 3, '2021-11-17 04:26:35', 1637119595);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `opschonen_bad_gb`
--

CREATE TABLE `opschonen_bad_gb` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tijd` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `opschonen_donations`
--

CREATE TABLE `opschonen_donations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tijd` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `opschonen_messages`
--

CREATE TABLE `opschonen_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tijd` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `opschonen_torrents`
--

CREATE TABLE `opschonen_torrents` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tijd` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `partner`
--

CREATE TABLE `partner` (
  `id` int(10) UNSIGNED NOT NULL,
  `titel` varchar(255) COLLATE latin1_german1_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE latin1_german1_ci DEFAULT NULL,
  `link` varchar(255) COLLATE latin1_german1_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Gegevens worden geëxporteerd voor tabel `partner`
--

INSERT INTO `partner` (`id`, `titel`, `banner`, `link`) VALUES
(30, 'first-release', 'https://first-release.org/pics_site/site_logo_bl.gif', 'http://first-release.org'),
(29, 'Taranis', 'https://taranis.me/banner/oie_ygM2aCCy6pOn.jpg', 'http://taranis.me');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `peers`
--

CREATE TABLE `peers` (
  `id` int(10) UNSIGNED NOT NULL,
  `torrent` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `peer_id` varchar(20) NOT NULL DEFAULT '',
  `ip` varchar(64) NOT NULL DEFAULT '',
  `port` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `uploaded` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `downloaded` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `to_go` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `seeder` enum('yes','no') NOT NULL DEFAULT 'no',
  `started` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_action` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `connectable` enum('yes','no') NOT NULL DEFAULT 'yes',
  `userid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `agent` varchar(60) NOT NULL DEFAULT '',
  `finishedat` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `downloadoffset` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `uploadoffset` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `passkey` varchar(32) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `peer_id`
--

CREATE TABLE `peer_id` (
  `id` int(10) UNSIGNED NOT NULL,
  `peer_id` varchar(32) NOT NULL DEFAULT '',
  `client` varchar(32) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `poll`
--

CREATE TABLE `poll` (
  `id` int(11) NOT NULL,
  `vraag` varchar(100) NOT NULL DEFAULT '',
  `antwoorden` text NOT NULL,
  `stemmen` text NOT NULL,
  `ip` text NOT NULL,
  `datum` int(20) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `poll`
--

INSERT INTO `poll` (`id`, `vraag`, `antwoorden`, `stemmen`, `ip`, `datum`) VALUES
(1, 'Wat vind je van deze website powertor?', 'Super,Geweldig,Gaaf,Gaat,Minder', '1,0,0,0,0', ' 31.161.200.144', 1143552256);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `pollanswers`
--

CREATE TABLE `pollanswers` (
  `id` int(10) UNSIGNED NOT NULL,
  `pollid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `selection` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `polls`
--

CREATE TABLE `polls` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `question` varchar(255) NOT NULL DEFAULT '',
  `option0` varchar(40) NOT NULL DEFAULT '',
  `option1` varchar(40) NOT NULL DEFAULT '',
  `option2` varchar(40) NOT NULL DEFAULT '',
  `option3` varchar(40) NOT NULL DEFAULT '',
  `option4` varchar(40) NOT NULL DEFAULT '',
  `option5` varchar(40) NOT NULL DEFAULT '',
  `option6` varchar(40) NOT NULL DEFAULT '',
  `option7` varchar(40) NOT NULL DEFAULT '',
  `option8` varchar(40) NOT NULL DEFAULT '',
  `option9` varchar(40) NOT NULL DEFAULT '',
  `option10` varchar(40) NOT NULL DEFAULT '',
  `option11` varchar(40) NOT NULL DEFAULT '',
  `option12` varchar(40) NOT NULL DEFAULT '',
  `option13` varchar(40) NOT NULL DEFAULT '',
  `option14` varchar(40) NOT NULL DEFAULT '',
  `option15` varchar(40) NOT NULL DEFAULT '',
  `option16` varchar(40) NOT NULL DEFAULT '',
  `option17` varchar(40) NOT NULL DEFAULT '',
  `option18` varchar(40) NOT NULL DEFAULT '',
  `option19` varchar(40) NOT NULL DEFAULT '',
  `sort` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `topicid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime DEFAULT NULL,
  `body` text DEFAULT NULL,
  `editedby` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `editedat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `proxy_ip`
--

CREATE TABLE `proxy_ip` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `ip` varchar(15) DEFAULT '000.000.000.000',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rating`
--

CREATE TABLE `rating` (
  `id` int(10) UNSIGNED NOT NULL,
  `aantal` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `cijfer` int(15) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ratings`
--

CREATE TABLE `ratings` (
  `torrent` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `rating` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `ratings`
--

INSERT INTO `ratings` (`torrent`, `user`, `rating`, `added`) VALUES
(6, 3, 5, '2021-05-06 16:15:52'),
(2, 3, 4, '2021-05-06 16:18:45');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `readposts`
--

CREATE TABLE `readposts` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `topicid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `lastpostread` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `readposts`
--

INSERT INTO `readposts` (`id`, `userid`, `topicid`, `lastpostread`) VALUES
(1, 3, 1, 1),
(2, 3, 2, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `regels`
--

CREATE TABLE `regels` (
  `id` int(10) UNSIGNED NOT NULL,
  `volgorde` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `onderwerp` varchar(100) NOT NULL DEFAULT '',
  `inhoud` text DEFAULT NULL,
  `min_class` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `edit_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `edit_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `regels`
--

INSERT INTO `regels` (`id`, `volgorde`, `onderwerp`, `inhoud`, `min_class`, `edit_by`, `edit_date`) VALUES
(1, 1, 'Regels', '[size=5][color=white]Algemene Regels[/color][/size]\r\n\r\n* Respecteer de wensen van onze Staff-leden! Het niet opvolgen ervan \r\n   betekent een Waarschuwing of in ernstige gevallen een IP-ban.\r\n* Indien u een torrent, die u bij ons download, op een andere tracker plaatst, \r\n   bedank dan onze uploader op die tracker in de torrentinfo.\r\n* Slecht gedrag in Forum, Helpdesk of elders op Torrent Media zal leiden tot een waarschuwing \r\n   en zonodig IP-Ban op Torrent Media.\r\n* Behandel iedereen met respect of u ontvangt een waarschuwing van 1 van onze Stafleden.\r\n* Torrent Media behoudt zich ten alle tijden het recht voor wijzigingen aan te kunnen brengen \r\n   ten behoeve van een correcte werking van het door ons gebruikte systeem.\r\n\r\n\r\n\r\n\r\n[size=5][color=white]Download Regels[/color][/size]\r\n\r\n* Het downloaden van een torrent is volledig voor eigen verantwoording.\r\n* Na het ontvangen dient u een torrent te delen tot een torrentratio van minimaal  1.00 en minimaal 3 andere overblijvende seeders.\r\n* Te lage ratios kunnen zware gevolgen hebben, zoals uitsluiting (IP-Ban) in extreme gevallen.\r\n* Het delen van een torrent met een torrentratio boven de 1.50 is alleen toegestaan als u de laatste seeder bent.\r\n* Een bedankje en leuk commentaar voor onze Uploaders wordt zeer gewaardeerd. \r\n   Tenslotte steken zij er een hoop tijd en energie in om voor ? leuke uploads te plaatsen.\r\n* Het is nergens voor nodig om negatieve opmerkingen te plaatsen bij het commentaar van een torrent, \r\n   dit kan op een nette manier via PM! Ditzelfde geldt voor Shoutbox en Forum.\r\n\r\n\r\n\r\n\r\n[size=5][color=white]Avatar regels[/color][/size]\r\n\r\n* Denk na voordat u een avatar kiest. De afbeelding mag niet breder zijn dan 150 pixels en maximaal 150 KB groot. \r\n   (Browsers zullen de afbeelding toch automatisch aanpassen tot de correcte grootte: \r\n   kleine afbeeldingen zien er dan niet uit en grote kosten meer bandbreedte en processorverbruik.\r\n* De toegestane extensies zijn .gif .jpg en .png.\r\n* Gebruik geen avatars die andere mensen kunnen kwetsen zoals afbeeldingen die met religie te maken hebben. \r\n   Ook afbeeldingen met grove porno zijn niet toegestaan. Onze Admins en Mods hebben \r\n   een bescheiden mening wat toelaatbaar is. Bij twijfel PM uw Mod!\r\n* Avatar plaatsen op onze server: Druk [url=http://topspinner.org/avatar_upload.php]hier[/url]\r\n\r\n\r\n\r\n\r\n[size=5][color=white]Verschillende Ranks op Torrent Media - Hoe worden deze bepaald en waarom.[/color][/size]\r\n\r\n[b]Misbruiker[/b]\r\nDit wordt u vanzelf als u ratio niet minimaal 1:1 bedraagd. Dit gebeurd automatisch door het systeem.\r\n\r\n[b]Normale Gebruiker[/b]\r\nDit is de standaard-rank voor nieuwe leden.\r\n\r\n[b]Top Gebruiker[/b]\r\nU bent minstens 1 week lid, heeft een Upload van minstens 25 GB en een ratio van meer als 1.05. Deze promotie gebeurd automatisch door het systeem en wordt teniet gedaan als uw ratio onder 0.975 daalt.\r\n\r\n[b]Donateur[/b]\r\nDit wordt u door te doneren op onze site. Klik op [url=https://torrentmedia.org/donatie.php]Doneren[/url] voor meer informatie hierover.\r\n\r\n[b]Belangrijke Gebruiker[/b]\r\nWordt toegekend door een Beheerder aan gebruikers waarvan hij/zij vindt dat ze een speciale bijdrage aan de site leveren/geleverd hebben. Zij die vragen worden bij voorbaat genegeerd.\r\n\r\n[b]Uploader[/b]\r\nWordt toegekend door Administrators aan geschikte kandidaten die de [url=https://torrentmedia.org/upload_aanvraag.php]Uploader aanvraag[/url] verstuurd hebben. Bij interesse verzoeken wij eerst de voorwaarden zoals hieronder vermeld in deze Regels door te nemen.\r\n\r\n[b]Moderator[/b]\r\nDagelijkse aanwezigheid op de site is gewenst! Lukt dat niet dan stelt u uw Admin daarvan op de hoogte.\r\nWordt toegekend door een Beheerder. Heeft u interesse dan adviseren wij voor een beschrijving van deze rank de onderstaande Moderator Regels door te nemen. Denkt u hieraan te kunnen voldoen neem dan contact op met een Beheerder.\r\n\r\n\r\n\r\n\r\n[size=5][color=white]Upload Richtlijnen[/color][/size]\r\n\r\nDit zijn de belangrijkste regels\r\nBij films zijn nl ondertitels verplicht, met uitzondering van XXX. Indien u een iets plaatst zonder nl ondertilels toch even duidelijk in de omschrijving van de torrent vermelden dat er geen ondertitels bij zitten.\r\nTevens kunnen er uitzonderingen gemaakt worden voor documentaires, specials en dergelijke.\r\nU dient een duidelijke omschrijving aan de torrent te geven.\r\nU dient minimaal te blijven seeden tot dat 4 gebruikers hem binnen hebben en deze aan het delen (seeden) zijn, in geval van vele ontvangers (leechers) dient u te blijven delen to ongeveer 30 procent van de gebruikers hem binnen geeft. U dient de torrent dusdanig te delen totdat er genoeg delers bij zijn om het over te nemen.\r\nindien de kwaliteit niet 100% is dan niet plaatsen.\r\nPlaats de torrent in de juiste categorie.\r\nLaat de gebruikers zien dat u een uploader met kwaliteit bent, dit kan al door een nette torrent / upload te verzorgen, maak de torrent van een nette kwaliteit de gebruiker zal dit zeker waarderen.\r\nAlle torrents dienen te voorzien zijn van een duidelijke en alles omschrijvende NFO text, de NFO word verwerkt in de torrent, hierdoor kan men de informatie later nog eens teruglezen ( wat met name bij spellen van belang is ).\r\nMocht u eventueel twijfels of vragen hebben over, of u heeft een probleem met een torrent, neem dan eerst contact op met iemand van ons  [url=https://torrentmedia.org/staff.php?]Staff[/url]\r\n\r\n\r\n\r\n[size=5][color=white]Uploader Opties - Wat kunt u zelf doen om uw Torrents in leven te houden?[/color][/size]\r\n\r\n* Check regelmatig op bijzonderheden op de site als u iets geplaatst heeft. \r\n   Situaties kunnen veranderen en het is zowel voor uzelf als voor ons en de Gebruikers minder als u dan niet op de hoogte bent.\r\n* Controleer de door u geplaatste Torrents regelmatig op Hit & Run.\r\n* Staat een van uw Torrents dood, stuur dan een Massa bericht aan iedereen die er mee bezig was met verzoek weer te gaan seeden.\r\n* Zijn er problemen met een gebruiker, ga daar dan niet zelf mee in discussie maar geef het door aan uw Moderator.\r\n\r\n\r\n\r\n\r\n[size=5][color=white]Moderator regels - Gebruik u eigen overtuiging[/color][/size]\r\n\r\n* Wees niet bang om NEE te zeggen.\r\n* Kraak nooit leden van de staff af, stuur hen een bericht.\r\n* Wees tolerant! Geef leden een kans om zich te verbeteren.\r\n* Gedraag u volwassen. Leden kunnen fouten maken, corrigeer ze op een nette manier daarop.\r\n* Probeer [b]niet relevante berichten en/of onderwerpen[/b] te veranderen zodat men er goed over verder kan praten.\r\n* Werk [b]ALTIJD[/b] Gebruikers gegevens bij bij een wijziging.\r\n\r\n\r\n\r\n\r\n[size=5][color=white]Moderator opties - Wat kan ik doen als moderator[/color][/size]\r\n\r\n* U kunt berichten in het forum aanpassen en/of verplaatsen.\r\n* U kunt torrent-info aanpassen\r\n* U kunt commentaren van leden bewerken\r\n* U kunt u opgeven om actief betrokken te zijn bij opleiding/begeleiding van Uploaders\r\n* U kunt alle info zien van leden.\r\n* U kunt de inloggegevens van leden herstellen.\r\n* U kunt leden seedverzoek of overseedbericht sturen en/of waarschuwen.\r\n* U kunt massa Pm\'s op torrents en op letters van leden versturen.\r\n* U kunt de passkey van de gebruiker resetten.\r\n* U kunt de Helpdesk-instelling voor leden aanpassen.\r\n* U kunt torrents verwijderen en aanpassen\r\n* U kunt avatars en vlaggen van leden wijzigen.\r\n* U kunt commentaar toevoegen bij leden. (andere Moderators en hoger kunnen dit lezen).\r\n* U staat op de Stafpagina.\r\n\r\n\r\n', 0, 8, '2021-07-01 21:59:56');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `registratie`
--

CREATE TABLE `registratie` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip` int(11) DEFAULT NULL,
  `teller` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `addedby` int(11) NOT NULL DEFAULT 0,
  `votedfor` int(11) NOT NULL DEFAULT 0,
  `reason` varchar(255) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `naam` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `report_user`
--

CREATE TABLE `report_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` datetime DEFAULT NULL,
  `sender` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `receiver` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `done` enum('yes','no') NOT NULL DEFAULT 'no',
  `done_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `done_date` datetime DEFAULT NULL,
  `message` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `requests`
--

CREATE TABLE `requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `request` varchar(225) DEFAULT NULL,
  `descr` text NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `cat` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `filledby` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `filledurl` varchar(70) DEFAULT NULL,
  `filled` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `shoutboxaktie`
--

CREATE TABLE `shoutboxaktie` (
  `id` int(8) NOT NULL,
  `datum` date NOT NULL DEFAULT '0000-00-00',
  `krediet` int(2) NOT NULL DEFAULT 0,
  `aktie` varchar(255) NOT NULL DEFAULT '',
  `added` int(11) NOT NULL DEFAULT 0,
  `added_by` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `shoutbox_extra`
--

CREATE TABLE `shoutbox_extra` (
  `id` int(10) UNSIGNED NOT NULL,
  `datum` varchar(10) NOT NULL DEFAULT '',
  `shoutbox_extra` text NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `added_by` int(10) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `shouts`
--

CREATE TABLE `shouts` (
  `id` smallint(6) NOT NULL,
  `user` varchar(25) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `shouts`
--

INSERT INTO `shouts` (`id`, `user`, `added`, `text`) VALUES
(45, '3', '2021-11-17 01:24:02', 'ja mail info@torrentmedia.org');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `shouts_mod`
--

CREATE TABLE `shouts_mod` (
  `id` smallint(6) NOT NULL,
  `user` varchar(25) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `shouts_mod`
--

INSERT INTO `shouts_mod` (`id`, `user`, `added`, `text`) VALUES
(1, '1', '2009-05-22 18:47:42', 'test');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `shouts_seen`
--

CREATE TABLE `shouts_seen` (
  `user` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `seen` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `shouts_seen`
--

INSERT INTO `shouts_seen` (`user`, `seen`) VALUES
(305, '2021-11-23 10:40:41');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sitelog`
--

CREATE TABLE `sitelog` (
  `id` int(10) NOT NULL,
  `added` datetime DEFAULT '0000-00-00 00:00:00',
  `txt` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `sitelog`
--

INSERT INTO `sitelog` (`id`, `added`, `txt`) VALUES
(10, '2021-05-06 15:54:56', 'Torrent  (davina) is verwijderd door MrFirst, omdat deze niet goed was. Ratio correctie toegepast.'),
(8, '2021-05-06 15:22:45', 'Torrent 5 (davina) is geplaatst door MrFirst'),
(9, '2021-05-06 15:49:38', 'Torrent 5 (davina) is bewerkt door testaccount'),
(7, '2021-05-03 19:50:12', 'Verwachte torrent (\'test\') is toegevoegd door MrFirst'),
(11, '2021-05-06 15:57:27', 'Torrent 6 (davina) is geplaatst door MrFirst'),
(12, '2021-05-06 19:20:07', 'Verwachte torrent (test) is verwijderd door MrFirst'),
(13, '2021-05-07 20:26:19', 'Torrent  (davina) is verwijderd door MrFirst, omdat dit een dode torrent was.'),
(14, '2021-05-07 20:26:21', 'Torrent  (The best of Cock Robin-Ripped by ZakspeeeD for Edonkey-) is verwijderd door MrFirst, omdat dit een dode torrent was.'),
(15, '2021-05-07 20:26:26', 'Torrent  (The best of Cock Robin-Ripped by ZakspeeeD for Edonkey-) is verwijderd door MrFirst, omdat dit een dode torrent was.'),
(16, '2021-06-16 23:02:36', 'Torrent 7 (boss level) is geplaatst door moderator'),
(17, '2021-06-16 23:04:32', 'Torrent 8 (Dutch (2021) 1080p WEB-DL DD5.1 H264) is geplaatst door moderator'),
(18, '2021-06-16 23:04:42', 'Torrent  (The Playah) is verwijderd door testaccount, omdat deze niet goed was. Ratio correctie toegepast.'),
(19, '2021-06-16 23:12:06', 'Torrent 9 (Judas and the Black Messiah (2021) 1080p BluRay DTS x26) is geplaatst door moderator'),
(20, '2021-06-16 23:16:02', 'Torrent 9 (Judas and the Black Messiah (2021) 1080p BluRay DTS x26) is bewerkt door moderator'),
(21, '2021-06-16 23:20:18', 'Torrent 9 (Judas and the Black Messiah (2021) 1080p BluRay DTS x26) is bewerkt door moderator'),
(22, '2021-06-16 23:22:26', 'Torrent 9 (Judas and the Black Messiah (2021) 1080p BluRay DTS x26) is verwijderd door moderator (nl subs)\n'),
(23, '2021-06-16 23:23:06', 'Torrent 10 (Judas and the Black Messiah (2021) 1080p BluRay DTS x26) is geplaatst door moderator'),
(24, '2021-06-16 23:25:10', 'Torrent  (Judas and the Black Messiah (2021) 1080p BluRay DTS x26) is verwijderd door moderator, omdat deze niet goed was. Ratio correctie toegepast.'),
(25, '2021-06-16 23:28:35', 'Torrent  (Alan Walker) is verwijderd door testaccount, omdat deze niet goed was. Ratio correctie toegepast.'),
(26, '2021-06-16 23:28:35', 'Torrent 11 (The.Godfather.Trilogy.[ I. II. III ].1080p.BluRay.x264.) is geplaatst door moderator'),
(27, '2021-06-16 23:29:53', 'Torrent 11 (The.Godfather.Trilogy.[ I. II. III ].1080p.BluRay.x264.) is bewerkt door moderator'),
(28, '2021-06-16 23:33:01', 'Torrent  (The.Godfather.Trilogy.[ I. II. III ].1080p.BluRay.x264.) is verwijderd door moderator, omdat deze niet goed was. Ratio correctie toegepast.'),
(29, '2021-06-16 23:36:22', 'Torrent 12 (The.Godfather.Trilogy.[ I. II. III ].1080p.BluRay.x264) is geplaatst door moderator'),
(30, '2021-06-16 23:41:48', 'Torrent 13 (Gladiator (2000) Extended 1080p HEVC x265 (Retail NL Su) is geplaatst door moderator'),
(31, '2021-06-17 00:45:22', 'Torrent 14 (Judas.and.the.Black.Messiah.2021.1080p.BluRay.DTS.x264-) is geplaatst door moderator'),
(32, '2021-06-17 00:53:48', 'Torrent 14 (Judas.and.the.Black.Messiah.2021.1080p.BluRay.DTS.x264-) is bewerkt door moderator'),
(33, '2021-06-17 00:57:34', 'Torrent 14 (Judas.and.the.Black.Messiah.2021.1080p.BluRay.DTS.x264-) is bewerkt door moderator'),
(34, '2021-06-17 01:10:42', 'Torrent 15 (Godzilla.vs.Kong.2021.2160p.HMAX.WEB-DL.DDP5.1.Atmos.HD) is geplaatst door moderator'),
(35, '2021-06-17 01:13:36', 'Torrent  (Gladiator (2000) Extended 1080p HEVC x265 (Retail NL Su) is verwijderd door moderator, omdat deze niet goed was. Ratio correctie toegepast.'),
(36, '2021-06-17 01:14:21', 'Torrent 16 (Gladiator (2000) Extended 1080p HEVC x265 (Retail NL Su) is geplaatst door moderator'),
(37, '2021-06-17 01:17:43', 'Torrent  (The.Godfather.Trilogy.[ I. II. III ].1080p.BluRay.x264) is verwijderd door moderator, omdat deze niet goed was. Ratio correctie toegepast.'),
(38, '2021-06-17 01:18:05', 'Torrent 17 (The.Godfather.Trilogy.[ I. II. III ].1080p.BluRay.x264.) is geplaatst door moderator'),
(39, '2021-06-17 01:19:05', 'Torrent  (Dutch (2021) 1080p WEB-DL DD5.1 H264) is verwijderd door moderator, omdat deze niet goed was. Ratio correctie toegepast.'),
(40, '2021-06-17 01:19:47', 'Torrent 18 (Dutch (2021) 1080p WEB-DL DD5.1 H264) is geplaatst door moderator'),
(41, '2021-06-17 01:20:22', 'Torrent  (boss level) is verwijderd door moderator, omdat deze niet goed was. Ratio correctie toegepast.'),
(42, '2021-06-17 01:21:01', 'Torrent 19 (Boss.Level.2020.1080p.BluRay.x264-GELMIBSON.mkv) is geplaatst door moderator'),
(43, '2021-06-17 01:25:38', 'Torrent 19 (Boss Level 2020) is bewerkt door moderator'),
(44, '2021-06-17 01:26:16', 'Torrent 18 (Dutch (2021) ) is bewerkt door moderator'),
(45, '2021-06-17 01:26:36', 'Torrent 17 (The.Godfather.Trilogy.[ I. II. III ]) is bewerkt door moderator'),
(46, '2021-06-17 01:26:58', 'Torrent 16 (Gladiator (2000) NL SUBS) is bewerkt door moderator'),
(47, '2021-06-17 01:27:07', 'Torrent 16 (Gladiator (2000) NL SUBS) is bewerkt door moderator'),
(48, '2021-06-17 01:28:20', 'Torrent 14 (Judas and the Black Messiah 2021) is bewerkt door moderator'),
(49, '2021-06-17 01:31:24', 'Torrent 20 (The Conjuring the Devil Made Me Do It 2021) is geplaatst door moderator'),
(50, '2021-06-17 08:45:15', 'Torrent 21 (Van God Los Seizoen 1 en 2) is geplaatst door moderator'),
(51, '2021-06-17 08:53:42', 'Torrent 22 (Pearl Harbor 1080P) is geplaatst door moderator'),
(52, '2021-06-17 08:59:50', 'Torrent 23 (Harry Potter 8 Film Collection NL Gesproken en Engels) is geplaatst door moderator'),
(53, '2021-06-17 09:16:53', 'Torrent 24 (The Lord of the Rings Collection - 3 films -X265) is geplaatst door moderator'),
(54, '2021-06-17 09:18:36', 'Torrent 24 (The Lord of the Rings Trilogy NL Subs) is bewerkt door moderator'),
(55, '2021-06-17 09:22:34', 'Torrent 25 (The Hobbit Trilogy ) is geplaatst door moderator'),
(56, '2021-06-17 09:28:33', 'Torrent 26 (WinRAR v6 0 1 Final  NL + EN   Unattended  by Vinny27) is geplaatst door moderator'),
(57, '2021-06-17 09:31:54', 'Torrent 27 (Betternet Premium VPN 4.4.2) is geplaatst door moderator'),
(58, '2021-06-17 09:37:02', 'Torrent 28 (Terminator ALL MOVIES ) is geplaatst door moderator'),
(59, '2021-06-17 10:15:17', 'Torrent 29 (Take Back (2021) 1080p WEB-DL DD5.1 NLSub) is geplaatst door moderator'),
(60, '2021-06-17 11:48:20', 'Torrent 29 (Take Back (2021) 1080p WEB-DL DD5.1 NLSub) is bewerkt door moderator'),
(61, '2021-06-17 22:15:00', 'Torrent 29 (Take Back (2021) 1080p WEB-DL DD5.1 NLSub) is bewerkt door TM Admin'),
(62, '2021-06-17 22:51:30', 'Torrent 30 (Baantjer Seizoen 1 t/m 11 Plus De Film) is geplaatst door TM Admin'),
(63, '2021-06-17 23:06:03', 'Torrent 31 (100 Jaar Disney NL GESPROKEN) is geplaatst door TM Admin'),
(64, '2021-06-17 23:10:30', 'Torrent 32 (Dragonball z) is geplaatst door TM Admin'),
(65, '2021-06-18 00:10:18', 'Torrent 33 (Dexter Seizoen 1 t/m 8 Geen NL subs) is geplaatst door TM Admin'),
(66, '2021-06-18 00:14:47', 'Torrent 33 (Dexter Seizoen 1 t/m 8 Geen NL subs) is bewerkt door TM Admin'),
(67, '2021-06-18 00:18:17', 'Torrent 33 (Dexter Seizoen 1 t/m 8 Geen NL subs) is bewerkt door TM Admin'),
(68, '2021-06-18 00:19:20', 'Torrent 33 (Dexter Seizoen 1 t/m 8 Geen NL subs) is bewerkt door TM Admin'),
(69, '2021-06-18 00:22:31', 'Torrent 33 (Dexter Seizoen 1 t/m 8 Geen NL subs) is bewerkt door TM Admin'),
(70, '2021-06-18 00:55:40', 'Torrent 33 (Dexter Seizoen 1 t/m 8 Geen NL subs) is bewerkt door TM Admin'),
(71, '2021-06-18 01:01:26', 'Torrent 33 (Dexter Seizoen 1 t/m 8 Geen NL subs) is bewerkt door TM Admin'),
(72, '2021-06-18 01:04:03', 'Torrent  (Dexter Seizoen 1 t/m 8 Geen NL subs) is verwijderd door TM Admin, omdat deze niet goed was. Ratio correctie toegepast.'),
(73, '2021-06-18 01:04:20', 'Torrent 34 (Dexter Seizoen 1 t/m 8) is geplaatst door TM Admin'),
(74, '2021-06-18 12:57:43', 'Torrent 34 (Dexter Seizoen 1 t/m 8) is bewerkt door TM Admin'),
(75, '2021-06-18 13:02:01', 'Torrent 34 (Dexter Seizoen 1 t/m 8) is bewerkt door TM Admin'),
(76, '2021-06-18 13:04:16', 'Torrent 34 (Dexter Seizoen 1 t/m 8) is bewerkt door TM Admin'),
(77, '2021-06-18 18:27:42', 'Torrent  (Dexter Seizoen 1 t/m 8) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(78, '2021-06-18 18:32:05', 'Torrent  (Dragonball z) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(79, '2021-06-18 18:32:28', 'Torrent  (100 Jaar Disney NL GESPROKEN) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(80, '2021-06-18 18:34:28', 'Torrent  (Baantjer Seizoen 1 t/m 11 Plus De Film) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(81, '2021-06-18 18:34:42', 'Torrent  (Take Back (2021) 1080p WEB-DL DD5.1 NLSub) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(82, '2021-06-18 18:35:00', 'Torrent  (Terminator ALL MOVIES ) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(83, '2021-06-18 18:35:17', 'Torrent  (Betternet Premium VPN 4.4.2) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(84, '2021-06-18 18:35:28', 'Torrent  (WinRAR v6 0 1 Final  NL + EN   Unattended  by Vinny27) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(85, '2021-06-18 18:35:37', 'Torrent  (The Hobbit Trilogy ) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(86, '2021-06-18 18:35:46', 'Torrent  (The Lord of the Rings Trilogy NL Subs) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(87, '2021-06-18 18:35:54', 'Torrent  (Harry Potter 8 Film Collection NL Gesproken en Engels) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(88, '2021-06-18 18:36:01', 'Torrent  (Pearl Harbor 1080P) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(89, '2021-06-18 18:36:09', 'Torrent  (Van God Los Seizoen 1 en 2) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(90, '2021-06-18 18:36:21', 'Torrent  (Judas and the Black Messiah 2021) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(91, '2021-06-18 18:36:31', 'Torrent  (Godzilla.vs.Kong.2021.2160p.HMAX.WEB-DL.DDP5.1.Atmos.HD) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(92, '2021-06-18 18:36:40', 'Torrent  (Gladiator (2000) NL SUBS) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(93, '2021-06-18 18:36:49', 'Torrent  (The.Godfather.Trilogy.[ I. II. III ]) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(94, '2021-06-18 18:36:57', 'Torrent  (Dutch (2021) ) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(95, '2021-06-18 18:37:06', 'Torrent  (Boss Level 2020) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(96, '2021-06-18 18:37:15', 'Torrent  (The Conjuring the Devil Made Me Do It 2021) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(97, '2021-06-18 23:04:57', 'Torrent 35 (Baantjer Seizoen 1 t/m 11 Plus De Film) is geplaatst door Speedy-M'),
(98, '2021-06-18 23:13:27', 'Torrent 36 (Walt Disney 100 jaar Mappen Vol Films NL GESPROKEN) is geplaatst door Speedy-M'),
(99, '2021-06-18 23:24:27', 'Torrent  (Walt Disney 100 jaar Mappen Vol Films NL GESPROKEN) is verwijderd door Speedy-M, omdat deze niet goed was. Ratio correctie toegepast.'),
(100, '2021-06-18 23:24:35', 'Torrent  (Baantjer Seizoen 1 t/m 11 Plus De Film) is verwijderd door Speedy-M, omdat deze niet goed was. Ratio correctie toegepast.'),
(101, '2021-06-20 01:13:17', 'Torrent 37 (Kluun - Help ik heb mijn vrouw zwanger gemaakt) is geplaatst door Speedy'),
(102, '2021-06-20 16:58:33', 'Torrent 38 (Spetters NL gesproken) is geplaatst door Speedy'),
(103, '2021-06-20 20:14:14', 'Torrent 38 (Spetters NL gesproken) is bewerkt door TorrentMedia'),
(104, '2021-06-20 20:14:45', 'Torrent 38 (Spetters NL gesproken) is bewerkt door TorrentMedia'),
(105, '2021-06-20 20:21:47', 'Torrent 39 (Birds Of Prey NL SUBS) is geplaatst door Speedy'),
(106, '2021-06-20 20:26:31', 'Torrent 39 (Birds Of Prey NL SUBS) is bewerkt door Speedy'),
(107, '2021-06-20 20:26:54', 'Torrent 39 (Birds Of Prey NL SUBS) is bewerkt door Speedy'),
(108, '2021-06-20 20:35:27', 'Torrent 39 (Birds Of Prey NL SUBS) is bewerkt door TM Admin'),
(109, '2021-06-20 20:36:03', 'Torrent 39 (Birds Of Prey NL SUBS) is bewerkt door TM Admin'),
(110, '2021-06-20 21:12:51', 'Torrent 39 (Birds Of Prey NL SUBS) is bewerkt door TM Admin'),
(111, '2021-06-20 21:15:09', 'Torrent 39 (Birds Of Prey NL SUBS) is bewerkt door Speedy'),
(112, '2021-06-20 21:16:13', 'Torrent 39 (Birds Of Prey NL SUBS) is bewerkt door Speedy'),
(113, '2021-06-20 21:16:50', 'Torrent 39 (Birds Of Prey NL SUBS) is bewerkt door Speedy'),
(114, '2021-06-20 21:17:08', 'Torrent 39 (Birds Of Prey NL SUBS) is bewerkt door Speedy'),
(115, '2021-06-20 21:17:57', 'Torrent  (Birds Of Prey NL SUBS) is verwijderd door Speedy, omdat deze niet goed was. Ratio correctie toegepast.'),
(116, '2021-06-20 21:24:16', 'Torrent 37 (Kluun - Help ik heb mijn vrouw zwanger gemaakt) is bewerkt door TorrentMedia'),
(117, '2021-06-20 21:29:33', 'Torrent 37 (Kluun - Help ik heb mijn vrouw zwanger gemaakt) is bewerkt door TorrentMedia'),
(118, '2021-06-20 21:53:23', 'Torrent 40 (CCleaner Pro Toolbox v1 0 - Download altijd de laatste ) is geplaatst door TorrentMedia'),
(119, '2021-06-21 06:57:44', 'Torrent 41 (Birds Of Prey NL SUBS) is geplaatst door Speedy'),
(120, '2021-06-21 07:01:59', 'Torrent  (Birds Of Prey NL SUBS) is verwijderd door Speedy, omdat deze niet goed was. Ratio correctie toegepast.'),
(121, '2021-06-21 07:04:57', 'Torrent 42 (Birds Of Prey NL SUBS) is geplaatst door Speedy'),
(122, '2021-06-21 07:07:46', 'Torrent  (Birds Of Prey NL SUBS) is verwijderd door Speedy, omdat deze niet goed was. Ratio correctie toegepast.'),
(123, '2021-06-21 07:10:05', 'Torrent 43 (Birds Of Prey NL SUBS) is geplaatst door Speedy'),
(124, '2021-06-21 07:16:02', 'Torrent 43 (Birds Of Prey NL SUBS) is bewerkt door Speedy'),
(125, '2021-06-21 07:19:07', 'Torrent 43 (Birds Of Prey NL SUBS) is bewerkt door Speedy'),
(126, '2021-06-21 07:19:38', 'Torrent 43 (Birds Of Prey NL SUBS) is bewerkt door Speedy'),
(127, '2021-06-21 12:50:39', 'Torrent 44 (Gemiste uitzendingen downloader) is geplaatst door TorrentMedia'),
(128, '2021-06-21 15:42:38', 'Torrent 45 (Nederlandse Tijdschriften 18-06-2021) is geplaatst door TorrentMedia'),
(129, '2021-06-21 17:27:18', 'Torrent 46 (Plants vs Zombies GOTY) is geplaatst door TorrentMedia'),
(130, '2021-06-21 17:28:54', 'Torrent 46 (Plants vs Zombies GOTY) is bewerkt door TorrentMedia'),
(131, '2021-06-21 17:44:04', 'Torrent 47 (Android Apps Pack Daily 11-05-2021 Paid) is geplaatst door TorrentMedia'),
(132, '2021-06-21 17:50:55', 'Torrent 48 (Rayman Legends  | PC) is geplaatst door TorrentMedia'),
(133, '2021-06-21 17:51:58', 'Torrent 46 (Plants vs Zombies GOTY | PC) is bewerkt door TorrentMedia'),
(134, '2021-06-21 17:58:01', 'Torrent 49 (World of Goo | PC) is geplaatst door TorrentMedia'),
(135, '2021-06-21 18:03:01', 'Torrent 50 (Paw Patrol on a roll | PC) is geplaatst door TorrentMedia'),
(136, '2021-06-21 18:23:28', 'Torrent 51 (Windows Laptop naar ChromeOS met Playstore) is geplaatst door TorrentMedia'),
(137, '2021-06-21 18:25:52', 'Torrent 51 (Windows Laptop naar ChromeOS met Playstore) is bewerkt door TorrentMedia'),
(138, '2021-06-21 18:31:11', 'Torrent 52 (Windows Laptop naar ChromeOS met Playstore 2021) is geplaatst door TorrentMedia'),
(139, '2021-06-21 18:32:01', 'Torrent  (Windows Laptop naar ChromeOS met Playstore) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(140, '2021-06-21 20:17:45', 'Torrent 53 (Striplv Kink Shaved Pussies Vol 1 - May 2021-TX) is geplaatst door TorrentMedia'),
(141, '2021-06-21 20:19:26', 'Torrent 54 (Nylons World Photo - Volume 56 2021-TX) is geplaatst door TorrentMedia'),
(142, '2021-06-21 20:21:41', 'Torrent 55 (SuicideGirls com  Pictures From 29/05/2021 TX) is geplaatst door TorrentMedia'),
(143, '2021-06-21 21:41:52', 'Torrent 56 (Adobe Pack 2018/2019) is geplaatst door Speedy'),
(144, '2021-06-21 21:54:52', 'Torrent 57 (AutoCAD | Mac 2019) is geplaatst door Speedy'),
(145, '2021-06-21 21:58:40', 'Torrent 58 (Final Cut Pro 10.4.5 Mac) is geplaatst door Speedy'),
(146, '2021-06-21 22:02:45', 'Torrent 59 (SketchUp Pro 2018 v18.0.16976 Mac) is geplaatst door Speedy'),
(147, '2021-06-21 22:08:32', 'Torrent 60 (VMware Fusion Professional v11.5.5.MAC Incl Keygen) is geplaatst door Speedy'),
(148, '2021-06-21 22:13:06', 'Torrent 61 (office Mac 2020 ) is geplaatst door Speedy'),
(149, '2021-06-21 22:19:24', 'Torrent 62 (Any Video Converter Professional Windows) is geplaatst door Speedy'),
(150, '2021-06-21 22:51:19', 'Torrent 63 (AutoCAD | ARCHITECTURE  2022  Windows) is geplaatst door Speedy'),
(151, '2021-06-21 22:54:20', 'Torrent 64 (AutoCAD | ELECTRICAL 2022 Windows  ) is geplaatst door Speedy'),
(152, '2021-06-21 22:58:53', 'Torrent 65 (AutoCAD | LT 2022 Windows  ) is geplaatst door Speedy'),
(153, '2021-06-21 23:01:34', 'Torrent 66 (AutoCAD | MAP 3D 2022 Windows) is geplaatst door Speedy'),
(154, '2021-06-21 23:04:18', 'Torrent 67 (AutoCAD | MECHANICAL 2022 Windows) is geplaatst door Speedy'),
(155, '2021-06-21 23:07:15', 'Torrent 68 (AutoCAD | MEP 2022 Windows  ) is geplaatst door Speedy'),
(156, '2021-06-21 23:10:19', 'Torrent 69 (AutoCAD | PLANT3D 2022 Windows   ) is geplaatst door Speedy'),
(157, '2021-06-21 23:12:46', 'Torrent 70 (AutoCAD | RASTER DESIGN 2022 Windows  ) is geplaatst door Speedy'),
(158, '2021-06-21 23:15:04', 'Torrent 71 (AutoCAD | V 2022 Windows ) is geplaatst door Speedy'),
(159, '2021-06-21 23:19:31', 'Torrent 72 (DVDFab 12.0.2.8 Windows) is geplaatst door Speedy'),
(160, '2021-06-21 23:23:15', 'Torrent 73 (IObit Driver Booster Pro Windows) is geplaatst door Speedy'),
(161, '2021-06-21 23:27:14', 'Torrent 74 (KLS.Backup 2019 Professional.v10.0.3.3.x64) is geplaatst door Speedy'),
(162, '2021-06-21 23:29:20', 'Torrent 74 (KLS.Backup 2019 Professional.v10.0.3.3.x64) is bewerkt door Speedy'),
(163, '2021-06-21 23:32:22', 'Torrent 74 (KLS.Backup 2019 Professional.v10.0.3.3.x64) is bewerkt door Speedy'),
(164, '2021-06-21 23:33:41', 'Torrent 74 (KLS.Backup 2019 Professional.v10.0.3.3.x64) is bewerkt door Speedy'),
(165, '2021-06-21 23:36:53', 'Torrent 74 (KLS.Backup 2019 Professional.v10.0.3.3.x64) is bewerkt door Speedy'),
(166, '2021-06-21 23:38:24', 'Torrent 74 (KLS.Backup 2019 Professional.v10.0.3.3.x64) is bewerkt door Speedy'),
(167, '2021-06-21 23:41:56', 'Torrent 75 (Malwarebytes PREMIUM Windows) is geplaatst door Speedy'),
(168, '2021-06-21 23:42:46', 'Torrent 74 (KLS.Backup 2019 Professional.v10.0.3.3.x64) is bewerkt door Speedy'),
(169, '2021-06-22 01:42:22', 'Torrent 60 (VMware Fusion Professional v11.5.5.MAC Incl Keygen) is bewerkt door TorrentMedia'),
(170, '2021-06-22 05:19:00', 'Torrent 55 (SuicideGirls com  Pictures From 29/05/2021 TX) is bewerkt door TorrentMedia'),
(171, '2021-06-22 05:20:03', 'Torrent 54 (Nylons World Photo - Volume 56 2021-TX) is bewerkt door TorrentMedia'),
(172, '2021-06-22 05:20:31', 'Torrent 53 (Striplv Kink Shaved Pussies Vol 1 - May 2021-TX) is bewerkt door TorrentMedia'),
(173, '2021-06-22 05:24:35', 'Torrent 52 (Windows Laptop naar ChromeOS met Playstore 2021) is bewerkt door TorrentMedia'),
(174, '2021-06-22 05:24:49', 'Torrent 50 (Paw Patrol on a roll | PC) is bewerkt door TorrentMedia'),
(175, '2021-06-22 05:25:11', 'Torrent 49 (World of Goo | PC) is bewerkt door TorrentMedia'),
(176, '2021-06-22 05:25:26', 'Torrent 48 (Rayman Legends  | PC) is bewerkt door TorrentMedia'),
(177, '2021-06-22 05:25:44', 'Torrent 47 (Android Apps Pack Daily 11-05-2021 Paid) is bewerkt door TorrentMedia'),
(178, '2021-06-22 05:28:17', 'Torrent 46 (Plants vs Zombies GOTY | PC) is bewerkt door TorrentMedia'),
(179, '2021-06-22 05:28:28', 'Torrent 46 (Plants vs Zombies GOTY | PC) is bewerkt door TorrentMedia'),
(180, '2021-06-22 05:28:50', 'Torrent 45 (Nederlandse Tijdschriften 18-06-2021) is bewerkt door TorrentMedia'),
(181, '2021-06-22 05:29:17', 'Torrent 44 (Gemiste uitzendingen downloader) is bewerkt door TorrentMedia'),
(182, '2021-06-22 05:29:39', 'Torrent 40 (CCleaner Pro Toolbox v1 0 - Download altijd de laatste ) is bewerkt door TorrentMedia'),
(183, '2021-06-22 05:30:26', 'Torrent 74 (KLS.Backup 2019 Professional.v10.0.3.3.x64) is bewerkt door TorrentMedia'),
(184, '2021-06-22 05:31:18', 'Torrent 74 (KLS.Backup 2019 Professional.v10.0.3.3.x64) is bewerkt door TorrentMedia'),
(185, '2021-06-22 05:33:02', 'Torrent  (KLS.Backup 2019 Professional.v10.0.3.3.x64) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(186, '2021-06-22 05:34:51', 'Torrent 76 (KLS Backup 2019 Professional v10.0.3.3 x64) is geplaatst door TorrentMedia'),
(187, '2021-06-22 05:36:29', 'Torrent  (office Mac 2020 ) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(188, '2021-06-22 05:38:00', 'Torrent 77 (Microsoft Office 2020 | Mac) is geplaatst door TorrentMedia'),
(189, '2021-06-22 05:43:37', 'Torrent 77 (Microsoft Office 2020 | Mac) is bewerkt door TorrentMedia'),
(190, '2021-06-22 05:43:52', 'Torrent 77 (Microsoft Office 2020 | Mac) is bewerkt door TorrentMedia'),
(191, '2021-06-22 05:44:38', 'Torrent  (Microsoft Office 2020 | Mac) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(192, '2021-06-22 05:45:23', 'Torrent 78 (Microsoft Office 2020 | Mac) is geplaatst door TorrentMedia'),
(193, '2021-06-22 05:57:39', 'Torrent 79 (Microsoft Office 2019 365 AiO nl-NL v16 0 13901 2040 ) is geplaatst door TorrentMedia'),
(194, '2021-06-22 06:03:59', 'Torrent 79 (Microsoft Office 2019 365 AiO nl-NL v16 0 13901 2040 ) is bewerkt door TorrentMedia'),
(195, '2021-06-22 06:05:37', 'Torrent  (Microsoft Office 2019 365 AiO nl-NL v16 0 13901 2040 ) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(196, '2021-06-22 06:06:13', 'Torrent 80 (Microsoft Office 2019 365 AiO nl-NL v16 0 13901 2040 ) is geplaatst door TorrentMedia'),
(197, '2021-06-22 06:11:32', 'Torrent 81 (Microsoft Windows 10 (21H1) 32 en 64bit \"GiGA AiO\" NL) is geplaatst door TorrentMedia'),
(198, '2021-06-22 06:16:06', 'Torrent 82 (Microsoft Windows 11 (DEV) GiGA AiO ENGLISH-US) is geplaatst door TorrentMedia'),
(199, '2021-06-22 06:33:59', 'Torrent 83 (Virtueel OSX in WIndows) is geplaatst door TorrentMedia'),
(200, '2021-06-22 06:39:06', 'Torrent 84 (Photoshop ACTIONS & PRESETS) is geplaatst door TorrentMedia'),
(201, '2021-06-22 06:50:17', 'Torrent 85 (Pliek Windows XP 3 06) is geplaatst door TorrentMedia'),
(202, '2021-06-22 06:54:00', 'Torrent 86 (Rollback Rx Pro 11.3 + RebootRestore Rx Pro 11.3  Multi) is geplaatst door TorrentMedia'),
(203, '2021-06-22 06:59:58', 'Torrent 87 (Total Commander 10.00 FINAL x32 x64) is geplaatst door TorrentMedia'),
(204, '2021-06-22 07:03:01', 'Torrent 88 (VMware Workstation Pro 12.1.1 Build 3770994) is geplaatst door TorrentMedia'),
(205, '2021-06-22 07:05:46', 'Torrent 89 (WinRAR 6.02 FINAL NEDERLANDS x32/x64) is geplaatst door TorrentMedia'),
(206, '2021-06-22 07:09:17', 'Torrent 90 (PHOTOSHOP CC X64 MULTI x64) is geplaatst door TorrentMedia'),
(207, '2021-06-22 07:14:20', 'Torrent 91 (18+ Stripboeken) is geplaatst door TorrentMedia'),
(208, '2021-06-22 10:25:16', 'Torrent 92 (Please Dont 2 1080p XXX) is geplaatst door Speedy'),
(209, '2021-06-22 10:26:30', 'Torrent 92 (Please Don\'t 2 1080p XXX) is bewerkt door Speedy'),
(210, '2021-06-22 10:27:06', 'Torrent 92 (Please Don\'t 2 1080p XXX) is bewerkt door Speedy'),
(211, '2021-06-22 10:30:33', 'Torrent 93 (Grannys Little Secret Service 1080p) is geplaatst door Speedy'),
(212, '2021-06-22 10:33:39', 'Torrent 94 (Girlcum Cecelia Taylor 1080p XXX) is geplaatst door Speedy'),
(213, '2021-06-22 10:36:49', 'Torrent 95 (Fresh Shaven Pussy Dolls 1080P) is geplaatst door Speedy'),
(214, '2021-06-22 10:40:52', 'Torrent 96 (Please Fuck My Wife  1080P) is geplaatst door Speedy'),
(215, '2021-06-22 10:44:46', 'Torrent 97 (BOX Teens Take It Big 1080P XXX) is geplaatst door Speedy'),
(216, '2021-06-22 10:48:08', 'Torrent 98 (Evil MILFs 3 Slutty Stepmoms 720P XXX) is geplaatst door Speedy'),
(217, '2021-06-22 10:55:01', 'Torrent 99 (X-Art Alecia Fox And Alexis Crystal Threesome 480P) is geplaatst door Speedy'),
(218, '2021-06-22 10:59:56', 'Torrent 100 (Nikki Hill Hot Czech Blonde And Sex For Breakfast 480P) is geplaatst door Speedy'),
(219, '2021-06-22 12:47:26', 'Torrent 101 (Aladdin (2019) 1080p NL gesproken) is geplaatst door Speedy'),
(220, '2021-06-22 12:52:19', 'Torrent 102 (Bedknobs and Broomsticks  Heksen Bezemstelen NL SUB) is geplaatst door Speedy'),
(221, '2021-06-22 13:35:26', 'Torrent 103 (How to Train your Dragon 3) is geplaatst door Speedy'),
(222, '2021-06-22 13:36:15', 'Torrent 103 (How to Train your Dragon 3) is bewerkt door Speedy'),
(223, '2021-06-22 13:47:56', 'Torrent 104 (Luca (2021) 1080p ENG+NL  (Retail NL Subs)) is geplaatst door Speedy'),
(224, '2021-06-22 13:54:46', 'Torrent 105 (SamSam 2020 1080P) is geplaatst door Speedy'),
(225, '2021-06-22 15:21:15', 'Torrent 106 (Scoob (2020) 1080P Dutch & Dutch NL Sub) is geplaatst door Speedy'),
(226, '2021-06-22 16:02:02', 'Torrent 107 (Disney NL Collectie Deel 1) is geplaatst door Speedy'),
(227, '2021-06-22 16:36:55', 'Torrent 108 (Disney NL Collectie Deel 2) is geplaatst door Speedy'),
(228, '2021-06-22 17:08:23', 'Torrent 109 (Disney NL Collectie Deel 3) is geplaatst door Speedy'),
(229, '2021-06-22 17:14:36', 'Torrent 110 (Disney NL Collectie Deel 4) is geplaatst door Speedy'),
(230, '2021-06-22 17:24:41', 'Torrent 111 (Comics pack 2021 NL) is geplaatst door TorrentMedia'),
(231, '2021-06-22 22:35:08', 'Torrent 103 (How to Train your Dragon 3) is verwijderd door Speedy (Dood: geen delers/ontvangers meer)\n'),
(232, '2021-06-22 22:42:03', 'Torrent 112 (How Train The Dragon 3 Delen) is geplaatst door Speedy'),
(233, '2021-06-22 23:09:13', 'Torrent 113 (Pokemon 4 Delen 1080P) is geplaatst door Speedy'),
(234, '2021-06-22 23:10:31', 'Torrent 113 (Pokemon 4 Delen 1080P NL GESPROKEN) is bewerkt door Speedy'),
(235, '2021-06-22 23:15:48', 'Torrent 114 (The Croods A New Age 2020 1080P NL GESPROKEN) is geplaatst door Speedy'),
(236, '2021-06-22 23:19:55', 'Torrent 115 (Tom and Jerry 2021 1080p NL SUB) is geplaatst door Speedy'),
(237, '2021-06-22 23:27:25', 'Torrent 116 (Two by Two Overboard 2021 1080P NL GESPROKEN) is geplaatst door Speedy'),
(238, '2021-06-22 23:31:53', 'Torrent 117 (Yakari  A Spectacular Journey 2021) is geplaatst door Speedy'),
(239, '2021-06-22 23:33:22', 'Torrent 117 (Yakari  A Spectacular Journey 2021 NL GESPROKEN) is bewerkt door Speedy'),
(240, '2021-06-22 23:34:47', 'Torrent 105 (SamSam 2020 1080P ENG GESPROKEN) is bewerkt door Speedy'),
(241, '2021-06-22 23:38:40', 'Torrent 118 (100% Wolf (2021) 1080p) is geplaatst door Speedy'),
(242, '2021-06-22 23:38:54', 'Torrent 118 (100% Wolf (2021) 1080p) is bewerkt door Speedy'),
(243, '2021-06-22 23:39:50', 'Torrent 118 (100% Wolf (2021) 1080p NL GESPROKEN) is bewerkt door Speedy'),
(244, '2021-06-22 23:44:54', 'Torrent 119 (Rango NL GESPROKEN Kids) is geplaatst door Speedy'),
(245, '2021-06-23 00:04:12', 'Torrent  (Comics pack 2021 NL) is verwijderd door TM Admin, omdat deze niet goed was. Ratio correctie toegepast.'),
(246, '2021-06-23 00:30:50', 'Torrent 120 (Avatar Serie ) is geplaatst door Speedy'),
(247, '2021-06-23 00:32:21', 'Torrent 120 (Avatar Serie NL GESPROKEN) is bewerkt door Speedy'),
(248, '2021-06-23 00:33:17', 'Torrent 120 (Avatar Serie NL GESPROKEN) is bewerkt door Speedy'),
(249, '2021-06-23 00:37:31', 'Torrent 121 (Baantjer Seizoen 1 t/m 11 Plus De Film) is geplaatst door Speedy'),
(250, '2021-06-23 00:39:59', 'Torrent 121 (Baantjer Seizoen 1 t/m 11 Plus De Film) is bewerkt door Speedy'),
(251, '2021-06-23 00:59:53', 'Torrent 122 (Dexter Seizoen 1 t/m 8 Geen NL SUBS) is geplaatst door Speedy'),
(252, '2021-06-23 01:02:25', 'Torrent 123 (Mocro Maffia Seizoen 1 2 3 Top Serie 1080P) is geplaatst door Speedy'),
(253, '2021-06-23 01:09:28', 'Torrent 124 (Loki 1080P NL Subs) is geplaatst door Speedy'),
(254, '2021-06-23 01:11:00', 'Torrent 124 (Loki Marvel Serie 1080P NL Subs) is bewerkt door Speedy'),
(255, '2021-06-23 01:13:06', 'Torrent 125 (The Falcon and the Winter Soldier) is geplaatst door Speedy'),
(256, '2021-06-23 05:26:55', 'Torrent 124 (Loki Marvel Serie 1080P NL Subs) is bewerkt door Speedy'),
(257, '2021-06-23 05:30:53', 'Torrent 124 (Loki Marvel Serie 1080P NL Subs) is bewerkt door Speedy'),
(258, '2021-06-23 05:34:14', 'Torrent 124 (Loki Marvel Serie 1080P NL Subs) is bewerkt door Speedy'),
(259, '2021-06-23 05:58:39', 'Torrent 126 (Dragonball z Serie + Movies ENG SUB) is geplaatst door Speedy'),
(260, '2021-06-23 06:00:48', 'Torrent 126 (Dragonball z Serie + Movies ) is bewerkt door Speedy'),
(261, '2021-06-23 06:01:24', 'Torrent 126 (Dragonball z Serie + Movies ) is bewerkt door Speedy'),
(262, '2021-06-23 06:05:07', 'Torrent 126 (Dragonball z Serie + Movies ) is bewerkt door Speedy'),
(263, '2021-06-23 06:06:17', 'Torrent 127 (Van God Los Seizoen 1 en 2) is geplaatst door Speedy'),
(264, '2021-06-23 06:08:28', 'Torrent 124 (Loki Marvel Serie 1080P NL Subs) is bewerkt door Speedy'),
(265, '2021-06-23 06:09:02', 'Torrent  (Loki Marvel Serie 1080P NL Subs) is verwijderd door Speedy, omdat deze niet goed was. Ratio correctie toegepast.'),
(266, '2021-06-23 06:09:37', 'Torrent 128 (Loki 1080P NL Subs) is geplaatst door Speedy'),
(267, '2021-06-23 06:10:40', 'Torrent 128 (Loki 1080P NL Subs   2 AFLEVERINGEN) is bewerkt door Speedy'),
(268, '2021-06-23 06:11:54', 'Torrent  (The Falcon and the Winter Soldier) is verwijderd door Speedy, omdat deze niet goed was. Ratio correctie toegepast.'),
(269, '2021-06-23 06:13:56', 'Torrent 129 (The Falcon and the Winter Soldier 1080p NL SUB) is geplaatst door Speedy'),
(270, '2021-06-23 06:14:45', 'Torrent  (The Falcon and the Winter Soldier 1080p NL SUB) is verwijderd door Speedy, omdat deze niet goed was. Ratio correctie toegepast.'),
(271, '2021-06-23 06:17:23', 'Torrent 130 (The Falcon and the Winter Soldier 1080p NL SUB) is geplaatst door Speedy'),
(272, '2021-06-23 06:19:25', 'Torrent  (Baantjer Seizoen 1 t/m 11 Plus De Film) is verwijderd door Speedy, omdat deze niet goed was. Ratio correctie toegepast.'),
(273, '2021-06-23 06:22:26', 'Torrent 131 (The Act Mini Serie Eng SUB) is geplaatst door Speedy'),
(274, '2021-06-23 06:37:46', 'Torrent 132 (Marvel Film Collectie 25 Delig NL SUB) is geplaatst door Speedy'),
(275, '2021-06-23 06:45:42', 'Torrent 132 (Marvel Film Collectie 25 Delig NL SUB) is bewerkt door Speedy'),
(276, '2021-06-23 06:47:45', 'Torrent  (Marvel Film Collectie 25 Delig NL SUB) is verwijderd door Speedy, omdat deze niet goed was. Ratio correctie toegepast.'),
(277, '2021-06-23 07:04:58', 'Torrent 133 (Marvel Film Collectie 25 Delig NL SUB) is geplaatst door Speedy'),
(278, '2021-06-23 10:25:00', 'Torrent 134 (The Lord of the Rings Collection  3 films NL SUBS ) is geplaatst door Speedy'),
(279, '2021-06-23 13:13:16', 'Torrent 135 (A Perfect Enemy (2021) 1080p) is geplaatst door Speedy'),
(280, '2021-06-23 13:14:54', 'Torrent 135 (A Perfect Enemy (2021) 1080p) is bewerkt door Speedy'),
(281, '2021-06-23 13:17:23', 'Torrent 136 (All My Life (2020) 1080p) is geplaatst door Speedy'),
(282, '2021-06-23 13:20:41', 'Torrent 137 (Becky (2020) 1080p BluRay NL SUB) is geplaatst door Speedy'),
(283, '2021-06-23 13:25:42', 'Torrent 138 (Birds of Prey (2020) 2160p NL SUB) is geplaatst door Speedy'),
(284, '2021-06-23 13:28:44', 'Torrent 139 (Braveheart (1995) 1080P NL SUB) is geplaatst door Speedy'),
(285, '2021-06-23 13:30:43', 'Torrent  (Braveheart (1995) 1080P NL SUB) is verwijderd door Speedy, omdat deze niet goed was. Ratio correctie toegepast.'),
(286, '2021-06-23 13:34:18', 'Torrent 140 (Braveheart (1995) 1080P NL SUB) is geplaatst door Speedy'),
(287, '2021-06-23 13:37:43', 'Torrent 138 (Birds of Prey (2020) 2160p NL SUB) is bewerkt door Speedy'),
(288, '2021-06-23 13:42:17', 'Torrent 141 (Childs Play Complete 7 Film Chucky Collection) is geplaatst door Speedy'),
(289, '2021-06-23 13:55:21', 'Torrent 142 (Harry Potter 8 Film Collection NL Gesproken en Engels) is geplaatst door Speedy'),
(290, '2021-06-23 14:17:30', 'Torrent 143 (Loki 1080P NL Subs S01 AFLEVERING 03) is geplaatst door Speedy'),
(291, '2021-06-24 01:33:03', 'Torrent 144 (Boss Level 2020 1080p 5.1 NL Sub) is geplaatst door TorrentMedia'),
(292, '2021-06-24 01:34:27', 'Torrent 144 (Boss Level 2020 1080p 5.1 NL Sub) is bewerkt door TorrentMedia'),
(293, '2021-06-24 01:43:11', 'Torrent 144 (Boss Level 2020 1080p 5.1 NL Sub) is bewerkt door TorrentMedia'),
(294, '2021-06-24 06:52:45', 'Torrent 145 (https://torrentmedia.org/announce.php?passkey=06d662d18) is geplaatst door Speedy'),
(295, '2021-06-24 06:53:29', 'Torrent 145 (Baantjer Seizoen 1 t/m 11 Plus De Film) is bewerkt door Speedy'),
(296, '2021-06-24 06:54:53', 'Torrent 145 (Baantjer Seizoen 1 t/m 11 Plus De Film) is bewerkt door Speedy'),
(297, '2021-06-24 06:55:09', 'Torrent  (Baantjer Seizoen 1 t/m 11 Plus De Film) is verwijderd door Speedy, omdat deze niet goed was. Ratio correctie toegepast.'),
(298, '2021-06-24 07:17:53', 'Torrent 146 (Baantjer Seizoen 1 t/m 11 Plus De Film) is geplaatst door Speedy'),
(299, '2021-06-24 07:23:11', 'Torrent 147 (Alfred Jodocus Kwak 52 Afleveringen) is geplaatst door Speedy'),
(300, '2021-06-24 07:27:05', 'Torrent 147 (Alfred Jodocus Kwak 52 Afleveringen) is bewerkt door Speedy'),
(301, '2021-06-24 07:28:06', 'Torrent 147 (Alfred Jodocus Kwak 52 Afleveringen) is bewerkt door Speedy'),
(302, '2021-06-24 07:28:46', 'Torrent  (Alfred Jodocus Kwak 52 Afleveringen) is verwijderd door Speedy, omdat deze niet goed was. Ratio correctie toegepast.'),
(303, '2021-06-24 07:29:19', 'Torrent 148 (Alfred Jodocus Kwak 52 Afleveringen) is geplaatst door Speedy'),
(304, '2021-06-24 07:29:30', 'Torrent  (Alfred Jodocus Kwak 52 Afleveringen) is verwijderd door Speedy, omdat deze niet goed was. Ratio correctie toegepast.'),
(305, '2021-06-24 07:33:24', 'Torrent 149 (Alfred Jodocus Kwak 52 Afleveringen ) is geplaatst door Speedy'),
(306, '2021-06-24 07:34:19', 'Torrent 149 (Alfred Jodocus Kwak 52 Afleveringen ) is bewerkt door Speedy'),
(307, '2021-06-24 08:54:41', 'Torrent 150 (The Hobbit The Motion Picture Trilogy EXTENDED 1080p) is geplaatst door Speedy'),
(308, '2021-06-24 09:00:19', 'Torrent 151 (A Joy To Bang Ass Teen Mouth 2021) is geplaatst door Speedy'),
(309, '2021-06-24 09:03:55', 'Torrent  (Birds Of Prey NL SUBS) is verwijderd door TM Admin, omdat deze niet goed was. Ratio correctie toegepast.'),
(310, '2021-06-24 09:11:21', 'Torrent 152 ( Pirates Of The Carribeans ALLE 5 DELEN  NL SUB) is geplaatst door Speedy'),
(311, '2021-06-24 09:19:39', 'Torrent 153 (Halloween Complete Collection 1080p ENG SUB) is geplaatst door Speedy'),
(312, '2021-06-24 09:26:47', 'Torrent 154 (John Wick Chapter 1  2  3  Trilogy 2014-2019 Eng SUB) is geplaatst door Speedy'),
(313, '2021-06-24 09:31:44', 'Torrent 155 (The Final Destination Collection 1080P NL SUB) is geplaatst door Speedy'),
(314, '2021-06-24 09:37:41', 'Torrent 156 (Saw The Complete Collection 2004-2010 1080p BluRay) is geplaatst door Speedy'),
(315, '2021-06-24 09:57:19', 'Torrent 157 (Willys Wonderland (2021) 1080p BluRay NL SUB) is geplaatst door Speedy'),
(316, '2021-06-24 10:13:41', 'Torrent 158 (Blue Iris 5 3 7 10) is geplaatst door Speedy'),
(317, '2021-06-24 10:16:12', 'Torrent 158 (Blue Iris 5 3 7 10) is bewerkt door Speedy'),
(318, '2021-06-24 10:43:45', 'Torrent 157 (Willys Wonderland (2021) 1080p BluRay NL SUB) is bewerkt door TM Admin'),
(319, '2021-06-24 11:20:17', 'Torrent 159 (Highlander Complete Collection 1986-2007 ENG SUB) is geplaatst door Speedy'),
(320, '2021-06-24 11:25:47', 'Torrent 160 (Avatar 2009 1080P NL SUB) is geplaatst door Speedy'),
(321, '2021-06-24 11:33:16', 'Torrent 161 (Battle Royale 1 + 2 NL SUB) is geplaatst door Speedy'),
(322, '2021-06-24 11:34:21', 'Torrent 161 (Battle Royale 1 + 2 NL SUB) is bewerkt door Speedy'),
(323, '2021-06-24 12:00:25', 'Torrent 162 (Bekende Stripboeken Hele Lijst Vol) is geplaatst door Speedy'),
(324, '2021-06-24 14:48:53', 'User account 12 (Hallo123) was created'),
(325, '2021-06-24 14:53:27', 'User account 13 (Ajax) was created'),
(326, '2021-06-24 19:54:31', 'Torrent 163 (Perfecte afdrukken maken NL-Talig VIDEOCURSUS) is geplaatst door Speedy'),
(327, '2021-06-24 20:07:10', 'Torrent 164 (Endangered Species 2021 1080P NL SUB) is geplaatst door Speedy'),
(328, '2021-06-24 20:10:43', 'Torrent 165 (Black Easter 2021 1080p NL SUB) is geplaatst door Speedy'),
(329, '2021-06-24 20:22:22', 'Torrent 166 (American Traitor The Trial of Axis Sally 2021 NL SUB) is geplaatst door Speedy'),
(330, '2021-06-24 20:26:42', 'Torrent 166 (American Traitor The Trial of Axis Sally 2021 NL SUB) is bewerkt door Speedy'),
(331, '2021-06-24 20:27:32', 'Torrent 166 (American Traitor The Trial of Axis Sally 2021 NL SUB) is verwijderd door Speedy (nl subs)\n'),
(332, '2021-06-24 20:28:51', 'Torrent 167 (American Traitor The Trial of Axis Sally 2021 NL SUB 10) is geplaatst door Speedy'),
(333, '2021-06-24 20:39:37', 'Torrent 168 (Marvel Spiderman 7 Delen Met NL SUB) is geplaatst door Speedy'),
(334, '2021-06-24 20:44:18', 'Torrent 169 (Dutch (2021) 1080p) is geplaatst door Speedy'),
(335, '2021-06-24 20:45:10', 'Torrent 169 (Dutch (2021) 1080p) is bewerkt door Speedy'),
(336, '2021-06-24 20:45:43', 'Torrent  (Dutch (2021) 1080p) is verwijderd door Speedy, omdat deze niet goed was. Ratio correctie toegepast.'),
(337, '2021-06-24 20:53:34', 'Torrent 170 (Rambo Film Collectie 5 Delen ENG SUB) is geplaatst door Speedy'),
(338, '2021-06-24 20:54:23', 'Torrent 170 (Rambo Film Collectie 5 Delen ENG SUB) is bewerkt door Speedy'),
(339, '2021-06-24 20:55:53', 'Torrent 170 (Rambo Film Collectie 5 Delen ENG SUB) is verwijderd door Speedy (Niet werkende uitgave: dood)\n'),
(340, '2021-06-24 20:58:06', 'Torrent 171 (Rambo Film Collectie 5 Delen ENG SUB  ) is geplaatst door Speedy'),
(341, '2021-06-24 21:07:56', 'Torrent 167 (American Traitor The Trial of Axis Sally 2021 NL SUB 10) is bewerkt door TM Admin'),
(342, '2021-06-24 22:00:32', 'Torrent 172 (Seductive Campus Coeds 2160p) is geplaatst door Speedy'),
(343, '2021-06-24 22:03:32', 'Torrent 172 (Seductive Campus Coeds 2160p) is bewerkt door Speedy'),
(344, '2021-06-24 22:04:14', 'Torrent  (Seductive Campus Coeds 2160p) is verwijderd door Speedy, omdat deze niet goed was. Ratio correctie toegepast.'),
(345, '2021-06-24 22:07:39', 'Torrent 173 (Seductive Campus Coeds 2160p) is geplaatst door Speedy'),
(346, '2021-06-24 22:17:02', 'User account 14 (Melvin.Adm) was created'),
(347, '2021-06-24 22:19:30', 'Torrent 40 (CCleaner Pro Toolbox v1 0 - Download altijd de laatste ) is bewerkt door Speedy'),
(348, '2021-06-24 22:54:47', 'Torrent 40 (CCleaner Pro Toolbox v1 0 - Download altijd de laatste ) is bewerkt door TorrentMedia'),
(349, '2021-06-24 22:57:02', 'Torrent 40 (CCleaner Pro Toolbox v1 0 - Download altijd de laatste ) is bewerkt door TM Admin'),
(350, '2021-06-24 22:58:02', 'Torrent 40 (CCleaner Pro Toolbox v1 0 - Download altijd de laatste ) is bewerkt door TM Admin'),
(351, '2021-06-24 22:58:46', 'Torrent  (CCleaner Pro Toolbox v1 0 - Download altijd de laatste ) is verwijderd door TM Admin, omdat deze niet goed was. Ratio correctie toegepast.'),
(352, '2021-06-24 23:01:43', 'Torrent 174 (CC Cleaner Pro Download Altijd Laatste Versie ) is geplaatst door Speedy'),
(353, '2021-06-24 23:15:20', 'Torrent 175 (Django.Unchained 1080p 5.1 NL Sub) is geplaatst door Speedy'),
(354, '2021-06-24 23:16:41', 'Torrent 175 (Django Unchained 1080p 5.1 NL Sub) is bewerkt door Speedy'),
(355, '2021-06-25 08:18:29', 'Torrent 176 (My Horny Japanese Grandma 1080p) is geplaatst door TM Admin'),
(356, '2021-06-25 08:20:19', 'Torrent 176 (My Horny Japanese Grandma 1080p) is bewerkt door TM Admin'),
(357, '2021-06-25 08:21:40', 'Torrent  (My Horny Japanese Grandma 1080p) is verwijderd door TM Admin, omdat deze niet goed was. Ratio correctie toegepast.'),
(358, '2021-06-25 08:23:33', 'Torrent 177 (My Horny Japanese Grandma 1080p) is geplaatst door Speedy'),
(359, '2021-06-25 08:25:07', 'Torrent 177 (My Horny Japanese Grandma 1080p) is bewerkt door Speedy'),
(360, '2021-06-25 08:25:43', 'Torrent  (My Horny Japanese Grandma 1080p) is verwijderd door Speedy, omdat deze niet goed was. Ratio correctie toegepast.'),
(361, '2021-06-25 08:28:03', 'Torrent 178 (My Horny Japanese Grandma 1080p) is geplaatst door Speedy'),
(362, '2021-06-25 08:36:07', 'Torrent 179 ( Fifty Shades 3 Delig  1080p 7.1 NL SUB) is geplaatst door Speedy'),
(363, '2021-06-25 08:59:12', 'Torrent 167 (American Traitor The Trial of Axis Sally 2021 NL SUB ) is bewerkt door Speedy'),
(364, '2021-06-25 09:15:17', 'Torrent 180 (Fast And The Furious Alle 8 Delen 1080p NL SUB) is geplaatst door Speedy'),
(365, '2021-06-30 14:54:19', 'Torrent 181 (A Quiet Place Part II 1080P NL SUB) is geplaatst door Speedy'),
(366, '2021-06-30 19:29:32', 'Torrent 181 (A Quiet Place Part II 1080P NL SUB) is bewerkt door Speedy'),
(367, '2021-06-30 19:31:29', 'Torrent  (A Quiet Place Part II 1080P NL SUB) is verwijderd door Speedy, omdat deze niet goed was. Ratio correctie toegepast.'),
(368, '2021-06-30 19:31:48', 'Torrent 182 (A Quiet Place Part II 1080P NL SUB  ) is geplaatst door Speedy'),
(369, '2021-06-30 19:42:16', 'Torrent 183 (Terminator ALLE 6 DELEN  1080P NL SUB) is geplaatst door Speedy'),
(370, '2021-07-01 00:17:35', 'Torrent 174 (CC Cleaner Pro Download Altijd Laatste Versie ) is bewerkt door TorrentMedia'),
(371, '2021-07-01 00:22:25', 'Torrent  (CC Cleaner Pro Download Altijd Laatste Versie ) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(372, '2021-07-01 00:24:27', 'Torrent 184 (  CC Cleaner Pro Download Altijd Laatste Versie	) is geplaatst door TorrentMedia'),
(373, '2021-07-01 15:55:33', 'User account 17 (bachlan) was created'),
(374, '2021-07-01 16:15:32', 'Torrent 185 (EMBATTLED (2021) 4k NL SUB) is geplaatst door Speedy'),
(375, '2021-07-01 17:11:59', 'Torrent 186 (Spirit Untamed the Movie 2021 1080p NL SUB) is geplaatst door Speedy'),
(376, '2021-07-01 21:00:47', 'User account 18 (speedy123) was created'),
(377, '2021-07-01 21:27:29', 'User account 19 (speedy123) was created'),
(378, '2021-07-01 21:33:03', 'Torrent 187 (Peter Rabbit 2 2021 1080p) is geplaatst door Speedy'),
(379, '2021-07-01 21:37:42', 'Torrent 188 (Run With The Hunted 2019 1080p NL SUB) is geplaatst door Speedy'),
(380, '2021-07-01 21:41:17', 'Torrent 188 (Run With The Hunted 2019 1080p NL SUB) is bewerkt door Speedy'),
(381, '2021-07-01 22:20:12', 'Torrent 189 (sir alex ferguson never give in 2021 1080p NL SUB) is geplaatst door Speedy'),
(382, '2021-07-01 22:23:17', 'Torrent 189 (Sir Alex Ferguson Never Give In 2021 1080p NL SUB) is bewerkt door Speedy'),
(383, '2021-07-01 23:57:31', 'Torrent 190 (World Sex Tour 1-29) is geplaatst door Speedy'),
(384, '2021-07-02 03:30:05', 'Torrent 47 (Android Apps Pack Daily 11-05-2021 Paid) is bewerkt door Speedy'),
(385, '2021-07-02 08:28:04', 'Ban 11 is verwijderd door 8 (TM Admin)'),
(386, '2021-07-02 08:28:07', 'Ban 10 is verwijderd door 8 (TM Admin)'),
(387, '2021-07-02 08:49:15', 'User account 20 (speedy123) was created'),
(388, '2021-07-02 10:40:19', 'Torrent 184 (  CC Cleaner Pro Download Altijd Laatste Versie	) is bewerkt door Mr Torrent'),
(389, '2021-07-02 11:28:58', 'User account 21 (bachlan) was created'),
(390, '2021-07-02 13:03:27', 'User account 22 (bachlan) was created'),
(391, '2021-07-02 15:03:04', 'Torrent 186 (Spirit Untamed the Movie 2021 1080p NL SUB) is bewerkt door Mr Torrent'),
(392, '2021-07-02 20:05:07', 'Torrent 189 (Sir Alex Ferguson Never Give In 2021 1080p NL SUB) is bewerkt door Mr Torrent'),
(393, '2021-07-03 08:47:57', 'Torrent 190 (World Sex Tour 1-29) is bewerkt door Mr Torrent'),
(394, '2021-07-03 08:56:46', 'Torrent 66 (AutoCAD | MAP 3D 2022 Windows) is bewerkt door Mr Torrent'),
(395, '2021-07-03 22:25:15', 'Torrent 189 (Sir Alex Ferguson Never Give In 2021 1080p NL SUB) is bewerkt door Mr Torrent'),
(396, '2021-07-04 00:36:40', 'Torrent  (Endangered Species 2021 1080P NL SUB) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(397, '2021-07-04 00:37:15', 'Torrent  (Black Easter 2021 1080p NL SUB) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(398, '2021-07-04 00:37:56', 'Torrent  (Blue Iris 5 3 7 10) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(399, '2021-07-04 00:38:32', 'Torrent  (American Traitor The Trial of Axis Sally 2021 NL SUB ) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(400, '2021-07-04 00:39:38', 'Torrent  (A Joy To Bang Ass Teen Mouth 2021) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(401, '2021-07-04 00:41:51', 'Torrent  (Microsoft Windows 11 (DEV) GiGA AiO ENGLISH-US) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(402, '2021-07-04 01:06:46', 'User account 23 (JHXaGIbUBTy) was created'),
(403, '2021-07-04 14:53:28', 'Torrent 191 (It Deel 1 En 2 1080P NL SUBS) is geplaatst door Mr Torrent'),
(404, '2021-07-04 16:10:04', 'User account 24 (UuLYqAHCZPEh) was created'),
(405, '2021-07-04 17:51:39', 'Torrent  (Boss Level 2020 1080p 5.1 NL Sub) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(406, '2021-07-04 23:02:48', 'User account 25 (upiKsXmEFD) was created'),
(407, '2021-07-04 23:17:53', 'User account 26 (lryHBJFRA) was created'),
(408, '2021-07-05 01:06:44', 'Torrent 191 (It Deel 1 En 2 1080P NL SUBS) is bewerkt door Mr Torrent'),
(409, '2021-07-05 01:16:17', 'User account 27 (tnZdEyCB) was created'),
(410, '2021-07-05 02:10:48', 'User account 28 (UAuLlbivB) was created'),
(411, '2021-07-05 09:32:05', 'User account 29 (YKebTnUEx) was created'),
(412, '2021-07-05 13:05:22', 'Torrent 192 (The Nest 2021 1080p NL SUBS) is geplaatst door Mr Torrent'),
(413, '2021-07-05 13:10:27', 'Torrent 193 (Zootopia NL GESPROKEN) is geplaatst door Mr Torrent'),
(414, '2021-07-05 18:08:27', 'User account 30 (ePIqEytNTXls) was created'),
(415, '2021-07-05 20:46:24', 'User account 31 (KsmFPZbMQd) was created'),
(416, '2021-07-06 06:15:54', 'User account 32 (lFaNiAhM) was created'),
(417, '2021-07-06 18:01:16', 'User account 33 (KlHqaTVe) was created'),
(418, '2021-07-06 20:27:09', 'User account 34 (TZmqFOMHX) was created'),
(419, '2021-07-06 23:30:22', 'User account 35 (LXVeMDqT) was created'),
(420, '2021-07-07 02:47:39', 'User account 36 (mTJFBRhqC) was created'),
(421, '2021-07-07 06:38:32', 'User account 37 (HyoemNVrGW) was created'),
(422, '2021-07-07 15:59:09', 'User account 38 (ZYXcFWzA) was created'),
(423, '2021-07-07 17:14:24', 'User account 39 (nfszqJEjTeZP) was created'),
(424, '2021-07-07 20:06:43', 'User account 40 (krbHcKWZvq) was created'),
(425, '2021-07-07 20:15:17', 'User account 41 (NqcCJvZIwGL) was created'),
(426, '2021-07-07 23:09:06', 'User account 42 (EhpPnkwAIxDT) was created'),
(427, '2021-07-08 00:53:39', 'User account 43 (qVHBEDWp) was created'),
(428, '2021-07-08 07:17:11', 'User account 44 (RyrMownPesY) was created'),
(429, '2021-07-08 12:27:14', 'User account 45 (rAlcoPVX) was created'),
(430, '2021-07-08 13:01:04', 'User account 46 (JoqDLHQlNpBO) was created'),
(431, '2021-07-08 15:09:58', 'User account 47 (VlFDbZxtJg) was created'),
(432, '2021-07-08 16:30:54', 'User account 48 (iEKVFqceZRt) was created'),
(433, '2021-07-08 21:11:14', 'User account 49 (zokYdqnKZmGh) was created'),
(434, '2021-07-08 21:18:08', 'User account 50 (oSUxeQRwcmbJ) was created'),
(435, '2021-07-08 23:53:04', 'User account 51 (ECqXybkrAG) was created'),
(436, '2021-07-09 00:39:44', 'User account 52 (lZyvgVuMTO) was created'),
(437, '2021-07-09 00:40:12', 'User account 53 (SdPFtyMQpwn) was created'),
(438, '2021-07-09 01:15:47', 'User account 54 (lHGFMSgXLvs) was created'),
(439, '2021-07-09 07:57:09', 'User account 55 (HiklWqoyEL) was created'),
(440, '2021-07-09 10:22:18', 'User account 56 (iGCTfKJeYgc) was created'),
(441, '2021-07-09 19:33:36', 'User account 57 (hTMJrYPekC) was created'),
(442, '2021-07-09 22:13:49', 'User account 58 (jLnWxKGw) was created'),
(443, '2021-07-10 03:50:14', 'User account 59 (cusInhBgZ) was created'),
(444, '2021-07-10 04:12:27', 'User account 60 (wdPumXSeaA) was created'),
(445, '2021-07-10 10:00:03', 'User account 61 (CaobJHSvX) was created'),
(446, '2021-07-10 11:23:47', 'User account 62 (OUdSCDtuyzQN) was created'),
(447, '2021-07-12 07:31:29', 'User account 63 (QLohufFkVD) was created'),
(448, '2021-07-12 15:52:15', 'User account 64 (Jannnes77) was created'),
(449, '2021-07-12 17:15:38', 'User account 65 (VypAqDrKiM) was created'),
(450, '2021-07-12 21:57:49', 'User account 66 (BNcAiahDMPZX) was created'),
(451, '2021-07-13 18:17:06', 'User account 67 (EIJVhbwFLtX) was created'),
(452, '2021-07-13 18:18:47', 'User account 68 (cYEuryIASTZK) was created'),
(453, '2021-07-14 15:14:13', 'Torrent 194 (Windows Applications 1) is geplaatst door Mr Torrent'),
(454, '2021-07-15 11:20:24', 'User account 69 (rkqzUOdA) was created'),
(455, '2021-07-15 11:56:42', 'Torrent 8 (Total Commander 10.00 FINAL x32 x64) is verwijderd door Mr Media, omdat dit een dode torrent was.'),
(456, '2021-07-15 11:56:46', 'Torrent 8 (Please Fuck My Wife  1080P) is verwijderd door Mr Media, omdat dit een dode torrent was.'),
(457, '2021-07-15 11:56:49', 'Torrent 8 (Aladdin (2019) 1080p NL gesproken) is verwijderd door Mr Media, omdat dit een dode torrent was.'),
(458, '2021-07-15 11:56:52', 'Torrent 8 (Bedknobs and Broomsticks  Heksen Bezemstelen NL SUB) is verwijderd door Mr Media, omdat dit een dode torrent was.'),
(459, '2021-07-15 11:56:55', 'Torrent 8 (Luca (2021) 1080p ENG+NL  (Retail NL Subs)) is verwijderd door Mr Media, omdat dit een dode torrent was.'),
(460, '2021-07-15 11:57:09', 'Torrent 8 (SamSam 2020 1080P ENG GESPROKEN) is verwijderd door Mr Media, omdat dit een dode torrent was.');
INSERT INTO `sitelog` (`id`, `added`, `txt`) VALUES
(461, '2021-07-15 11:57:12', 'Torrent 8 (Scoob (2020) 1080P Dutch & Dutch NL Sub) is verwijderd door Mr Media, omdat dit een dode torrent was.'),
(462, '2021-07-15 11:57:14', 'Torrent 8 (Disney NL Collectie Deel 1) is verwijderd door Mr Media, omdat dit een dode torrent was.'),
(463, '2021-07-15 11:57:17', 'Torrent 8 (Disney NL Collectie Deel 2) is verwijderd door Mr Media, omdat dit een dode torrent was.'),
(464, '2021-07-15 11:57:22', 'Torrent 8 (Disney NL Collectie Deel 3) is verwijderd door Mr Media, omdat dit een dode torrent was.'),
(465, '2021-07-15 11:57:24', 'Torrent 8 (Disney NL Collectie Deel 4) is verwijderd door Mr Media, omdat dit een dode torrent was.'),
(466, '2021-07-15 11:57:27', 'Torrent 8 (How Train The Dragon 3 Delen) is verwijderd door Mr Media, omdat dit een dode torrent was.'),
(467, '2021-07-15 11:57:29', 'Torrent 8 (Pokemon 4 Delen 1080P NL GESPROKEN) is verwijderd door Mr Media, omdat dit een dode torrent was.'),
(468, '2021-07-15 11:57:32', 'Torrent 8 (The Croods A New Age 2020 1080P NL GESPROKEN) is verwijderd door Mr Media, omdat dit een dode torrent was.'),
(469, '2021-07-15 11:58:08', 'Torrent 8 (Tom and Jerry 2021 1080p NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(470, '2021-07-15 11:58:10', 'Torrent 8 (Two by Two Overboard 2021 1080P NL GESPROKEN) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(471, '2021-07-15 11:58:13', 'Torrent 8 (Yakari  A Spectacular Journey 2021 NL GESPROKEN) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(472, '2021-07-15 11:58:16', 'Torrent 8 (100% Wolf (2021) 1080p NL GESPROKEN) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(473, '2021-07-15 11:58:19', 'Torrent 8 (Rango NL GESPROKEN Kids) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(474, '2021-07-15 11:58:22', 'Torrent 8 (Van God Los Seizoen 1 en 2) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(475, '2021-07-15 11:58:25', 'Torrent 8 (Marvel Spiderman 7 Delen Met NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(476, '2021-07-15 11:58:29', 'Torrent 8 (Django Unchained 1080p 5.1 NL Sub) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(477, '2021-07-15 11:58:31', 'Torrent 8 (It Deel 1 En 2 1080P NL SUBS) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(478, '2021-07-15 12:00:46', 'Torrent  (Zootopia NL GESPROKEN) is verwijderd door Mr Torrent, omdat deze niet goed was. Ratio correctie toegepast.'),
(479, '2021-07-15 12:00:57', 'Torrent  (The Nest 2021 1080p NL SUBS) is verwijderd door Mr Torrent, omdat deze niet goed was. Ratio correctie toegepast.'),
(480, '2021-07-15 12:04:55', 'Torrent  (Saw The Complete Collection 2004-2010 1080p BluRay) is verwijderd door Mr Torrent, omdat deze niet goed was. Ratio correctie toegepast.'),
(481, '2021-07-15 12:23:04', 'Torrent 8 (Spetters NL gesproken) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(482, '2021-07-15 12:23:06', 'Torrent 8 (Nederlandse Tijdschriften 18-06-2021) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(483, '2021-07-15 12:23:11', 'Torrent 8 (Plants vs Zombies GOTY | PC) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(484, '2021-07-15 12:23:14', 'Torrent 8 (Android Apps Pack Daily 11-05-2021 Paid) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(485, '2021-07-15 12:23:18', 'Torrent 8 (Rayman Legends  | PC) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(486, '2021-07-15 12:23:20', 'Torrent 8 (World of Goo | PC) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(487, '2021-07-15 12:23:24', 'Torrent 8 (Windows Laptop naar ChromeOS met Playstore 2021) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(488, '2021-07-15 12:23:27', 'Torrent 8 (Nylons World Photo - Volume 56 2021-TX) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(489, '2021-07-15 12:23:32', 'Torrent 8 (AutoCAD | ARCHITECTURE  2022  Windows) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(490, '2021-07-15 12:23:37', 'Torrent 8 (AutoCAD | MEP 2022 Windows  ) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(491, '2021-07-15 12:23:43', 'Torrent 8 (AutoCAD | RASTER DESIGN 2022 Windows  ) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(492, '2021-07-15 12:23:48', 'Torrent 8 (AutoCAD | V 2022 Windows ) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(493, '2021-07-15 12:23:51', 'Torrent 8 (IObit Driver Booster Pro Windows) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(494, '2021-07-15 12:23:54', 'Torrent 8 (Malwarebytes PREMIUM Windows) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(495, '2021-07-15 12:23:57', 'Torrent 8 (Microsoft Windows 10 (21H1) 32 en 64bit \"GiGA AiO\" NL) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(496, '2021-07-15 12:24:03', 'Torrent 8 (Virtueel OSX in WIndows) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(497, '2021-07-15 12:24:06', 'Torrent 8 (Rollback Rx Pro 11.3 + RebootRestore Rx Pro 11.3  Multi) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(498, '2021-07-15 12:24:11', 'Torrent 8 (WinRAR 6.02 FINAL NEDERLANDS x32/x64) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(499, '2021-07-15 12:24:18', 'Torrent 8 (Please Don) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(500, '2021-07-15 12:24:24', 'Torrent 8 (Fresh Shaven Pussy Dolls 1080P) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(501, '2021-07-15 12:24:28', 'Torrent 8 (BOX Teens Take It Big 1080P XXX) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(502, '2021-07-15 12:24:33', 'Torrent 8 (Evil MILFs 3 Slutty Stepmoms 720P XXX) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(503, '2021-07-15 12:24:36', 'Torrent 8 (X-Art Alecia Fox And Alexis Crystal Threesome 480P) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(504, '2021-07-15 12:24:41', 'Torrent 8 (Nikki Hill Hot Czech Blonde And Sex For Breakfast 480P) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(505, '2021-07-15 12:24:47', 'Torrent 8 (Dexter Seizoen 1 t/m 8 Geen NL SUBS) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(506, '2021-07-15 12:24:50', 'Torrent 8 (Mocro Maffia Seizoen 1 2 3 Top Serie 1080P) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(507, '2021-07-15 12:24:54', 'Torrent 8 (The Falcon and the Winter Soldier 1080p NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(508, '2021-07-15 12:24:57', 'Torrent 8 (The Act Mini Serie Eng SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(509, '2021-07-15 12:25:00', 'Torrent 8 (Gemiste uitzendingen downloader) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(510, '2021-07-15 12:25:07', 'Torrent 8 (Kluun - Help ik heb mijn vrouw zwanger gemaakt) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(511, '2021-07-15 12:25:13', 'Torrent 8 (Paw Patrol on a roll | PC) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(512, '2021-07-15 12:25:17', 'Torrent 8 (Striplv Kink Shaved Pussies Vol 1 - May 2021-TX) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(513, '2021-07-15 12:25:20', 'Torrent 8 (SuicideGirls com  Pictures From 29/05/2021 TX) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(514, '2021-07-15 12:25:23', 'Torrent 8 (Adobe Pack 2018/2019) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(515, '2021-07-15 12:25:27', 'Torrent 8 (AutoCAD | Mac 2019) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(516, '2021-07-15 12:25:35', 'Torrent 8 (Final Cut Pro 10.4.5 Mac) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(517, '2021-07-15 12:25:50', 'Torrent 8 (SketchUp Pro 2018 v18.0.16976 Mac) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(518, '2021-07-15 12:25:53', 'Torrent 8 (VMware Fusion Professional v11.5.5.MAC Incl Keygen) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(519, '2021-07-15 12:25:57', 'Torrent 8 (Any Video Converter Professional Windows) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(520, '2021-07-15 12:26:00', 'Torrent 8 (AutoCAD | ELECTRICAL 2022 Windows  ) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(521, '2021-07-15 12:26:03', 'Torrent 8 (AutoCAD | LT 2022 Windows  ) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(522, '2021-07-15 12:26:12', 'Torrent 8 (AutoCAD | MAP 3D 2022 Windows) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(523, '2021-07-15 12:26:16', 'Torrent 8 (AutoCAD | MECHANICAL 2022 Windows) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(524, '2021-07-15 12:26:19', 'Torrent 8 (AutoCAD | PLANT3D 2022 Windows   ) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(525, '2021-07-15 12:26:23', 'Torrent 8 (DVDFab 12.0.2.8 Windows) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(526, '2021-07-15 12:26:26', 'Torrent 8 (KLS Backup 2019 Professional v10.0.3.3 x64) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(527, '2021-07-15 12:26:29', 'Torrent 8 (Microsoft Office 2020 | Mac) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(528, '2021-07-15 12:26:32', 'Torrent 8 (Microsoft Office 2019 365 AiO nl-NL v16 0 13901 2040 ) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(529, '2021-07-15 12:26:35', 'Torrent 8 (Photoshop ACTIONS & PRESETS) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(530, '2021-07-15 12:26:38', 'Torrent 8 (Pliek Windows XP 3 06) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(531, '2021-07-15 12:26:41', 'Torrent 8 (VMware Workstation Pro 12.1.1 Build 3770994) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(532, '2021-07-15 12:26:44', 'Torrent 8 (PHOTOSHOP CC X64 MULTI x64) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(533, '2021-07-15 12:26:48', 'Torrent 8 (18+ Stripboeken) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(534, '2021-07-15 12:26:52', 'Torrent 8 (Grannys Little Secret Service 1080p) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(535, '2021-07-15 12:26:56', 'Torrent 8 (Girlcum Cecelia Taylor 1080p XXX) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(536, '2021-07-15 12:26:59', 'Torrent 8 (Avatar Serie NL GESPROKEN) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(537, '2021-07-15 12:27:01', 'Torrent 8 (Dragonball z Serie + Movies ) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(538, '2021-07-15 12:27:04', 'Torrent 8 (Loki 1080P NL Subs   2 AFLEVERINGEN) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(539, '2021-07-15 12:27:07', 'Torrent 8 (Marvel Film Collectie 25 Delig NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(540, '2021-07-15 12:27:10', 'Torrent 8 (The Lord of the Rings Collection  3 films NL SUBS ) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(541, '2021-07-15 12:27:14', 'Torrent 8 (A Perfect Enemy (2021) 1080p) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(542, '2021-07-15 12:27:17', 'Torrent 8 (All My Life (2020) 1080p) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(543, '2021-07-15 12:27:19', 'Torrent 8 (Becky (2020) 1080p BluRay NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(544, '2021-07-15 12:27:22', 'Torrent 8 (Birds of Prey (2020) 2160p NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(545, '2021-07-15 12:27:25', 'Torrent 8 (Braveheart (1995) 1080P NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(546, '2021-07-15 12:27:27', 'Torrent 8 (Childs Play Complete 7 Film Chucky Collection) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(547, '2021-07-15 12:27:30', 'Torrent 8 (Harry Potter 8 Film Collection NL Gesproken en Engels) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(548, '2021-07-15 12:27:33', 'Torrent 8 (Loki 1080P NL Subs S01 AFLEVERING 03) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(549, '2021-07-15 12:27:36', 'Torrent 8 (Baantjer Seizoen 1 t/m 11 Plus De Film) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(550, '2021-07-15 12:27:40', 'Torrent 8 (Alfred Jodocus Kwak 52 Afleveringen ) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(551, '2021-07-15 12:27:43', 'Torrent 8 (World Sex Tour 1-29) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(552, '2021-07-15 12:27:45', 'Torrent 8 (Terminator ALLE 6 DELEN  1080P NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(553, '2021-07-15 12:27:47', 'Torrent 8 (A Quiet Place Part II 1080P NL SUB  ) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(554, '2021-07-15 12:27:49', 'Torrent 8 (Rambo Film Collectie 5 Delen ENG SUB  ) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(555, '2021-07-15 12:27:51', 'Torrent 8 (Seductive Campus Coeds 2160p) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(556, '2021-07-15 12:27:53', 'Torrent 8 (Battle Royale 1 + 2 NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(557, '2021-07-15 12:27:55', 'Torrent 8 (Fast And The Furious Alle 8 Delen 1080p NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(558, '2021-07-15 12:27:57', 'Torrent 8 (Sir Alex Ferguson Never Give In 2021 1080p NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(559, '2021-07-15 12:27:59', 'Torrent 8 (  CC Cleaner Pro Download Altijd Laatste Versie	) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(560, '2021-07-15 12:28:01', 'Torrent 8 (EMBATTLED (2021) 4k NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(561, '2021-07-15 12:28:03', 'Torrent 8 (Run With The Hunted 2019 1080p NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(562, '2021-07-15 12:28:05', 'Torrent 8 (Peter Rabbit 2 2021 1080p) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(563, '2021-07-15 12:28:08', 'Torrent 8 (Spirit Untamed the Movie 2021 1080p NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(564, '2021-07-15 12:28:10', 'Torrent 8 ( Fifty Shades 3 Delig  1080p 7.1 NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(565, '2021-07-15 12:28:12', 'Torrent 8 (My Horny Japanese Grandma 1080p) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(566, '2021-07-15 12:28:14', 'Torrent 8 (Perfecte afdrukken maken NL-Talig VIDEOCURSUS) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(567, '2021-07-15 12:28:18', 'Torrent 8 (Bekende Stripboeken Hele Lijst Vol) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(568, '2021-07-15 12:28:21', 'Torrent 8 (Avatar 2009 1080P NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(569, '2021-07-15 12:28:23', 'Torrent 8 (Highlander Complete Collection 1986-2007 ENG SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(570, '2021-07-15 12:28:25', 'Torrent 8 (Willys Wonderland (2021) 1080p BluRay NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(571, '2021-07-15 12:28:27', 'Torrent 8 (The Final Destination Collection 1080P NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(572, '2021-07-15 12:28:29', 'Torrent 8 (John Wick Chapter 1  2  3  Trilogy 2014-2019 Eng SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(573, '2021-07-15 12:28:30', 'Torrent 8 (Halloween Complete Collection 1080p ENG SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(574, '2021-07-15 12:28:32', 'Torrent 8 ( Pirates Of The Carribeans ALLE 5 DELEN  NL SUB) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(575, '2021-07-15 12:28:34', 'Torrent 8 (The Hobbit The Motion Picture Trilogy EXTENDED 1080p) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(576, '2021-07-15 12:29:57', 'Torrent  (Windows Applications 1) is verwijderd door Mr Torrent, omdat deze niet goed was. Ratio correctie toegepast.'),
(577, '2021-07-15 12:32:57', 'Torrent 195 (Windows-applications-1) is geplaatst door Mr Torrent'),
(578, '2021-07-15 12:37:29', 'Torrent 195 (Windows-applications-1) is bewerkt door Mr Torrent'),
(579, '2021-07-15 12:38:56', 'Torrent  (Windows-applications-1) is verwijderd door Mr Torrent, omdat deze niet goed was. Ratio correctie toegepast.'),
(580, '2021-07-15 12:59:54', 'Torrent 196 (Death spank) is geplaatst door Mr Media'),
(581, '2021-07-15 13:30:53', 'Torrent 196 (Death spank) is bewerkt door Mr Media'),
(582, '2021-07-15 16:02:31', 'Torrent 197 (The.Hobbit.The.Motion.Picture.Trilogy.EXTENDED.1080p) is geplaatst door Mr Torrent'),
(583, '2021-07-15 19:09:50', 'Torrent  (Death spank) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(584, '2021-07-15 19:16:40', 'Torrent  (The.Hobbit.The.Motion.Picture.Trilogy.EXTENDED.1080p) is verwijderd door Mr Torrent, omdat deze niet goed was. Ratio correctie toegepast.'),
(585, '2021-07-15 19:17:07', 'Torrent 198 (The.Hobbit.The.Motion.Picture.Trilogy.EXTENDED.1080p) is geplaatst door Mr Torrent'),
(586, '2021-07-15 19:35:22', 'Torrent 199 (test) is geplaatst door Mr Torrent'),
(587, '2021-07-15 19:39:49', 'Torrent  (test) is verwijderd door Mr Torrent, omdat deze niet goed was. Ratio correctie toegepast.'),
(588, '2021-07-15 19:39:58', 'Torrent  (The.Hobbit.The.Motion.Picture.Trilogy.EXTENDED.1080p) is verwijderd door Mr Torrent, omdat deze niet goed was. Ratio correctie toegepast.'),
(589, '2021-07-15 19:56:17', 'Torrent 200 (CCleaner Pro Altijd laatste versie) is geplaatst door Mr Torrent'),
(590, '2021-07-15 20:00:37', 'Torrent 201 (any) is geplaatst door Mr Torrent'),
(591, '2021-07-15 20:03:08', 'Torrent 202 (iobit) is geplaatst door Mr Torrent'),
(592, '2021-07-15 20:58:52', 'User account 70 (JliKZQAur) was created'),
(593, '2021-07-16 13:16:02', 'Torrent 202 (iobit) is bewerkt door Mr Torrent'),
(594, '2021-07-16 19:24:01', 'User account 71 (nSkicvqIu) was created'),
(595, '2021-07-17 04:53:47', 'User account 72 (aVElXRqjeo) was created'),
(596, '2021-07-18 14:35:33', 'User account 73 (vIyrLFUj) was created'),
(597, '2021-07-18 18:03:37', 'User account 74 (fPZMrbOLzD) was created'),
(598, '2021-07-20 00:29:09', 'Torrent  (iobit) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(599, '2021-07-20 00:29:22', 'Torrent  (CCleaner Pro Altijd laatste versie) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(600, '2021-07-20 00:29:34', 'Torrent  (any) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(601, '2021-07-20 00:41:35', 'Torrent 203 (Ccleaner Pro altijd laatste versie) is geplaatst door Mr Media'),
(602, '2021-07-20 01:16:17', 'Torrent 203 (Ccleaner Pro altijd laatste versie) is bewerkt door Mr Media'),
(603, '2021-07-20 01:17:02', 'Torrent 203 (Ccleaner Pro altijd laatste versie) is bewerkt door Mr Media'),
(604, '2021-07-20 01:19:37', 'Torrent 203 (Ccleaner Pro altijd laatste versie) is bewerkt door Mr Media'),
(605, '2021-07-20 01:19:55', 'Torrent 203 (Ccleaner Pro altijd laatste versie) is bewerkt door Mr Media'),
(606, '2021-07-20 01:21:56', 'Torrent 203 (Ccleaner Pro altijd laatste versie) is bewerkt door Mr Media'),
(607, '2021-07-20 01:26:04', 'Torrent 203 (Ccleaner Pro altijd laatste versie) is bewerkt door Mr Media'),
(608, '2021-07-20 01:29:15', 'Torrent 203 (Ccleaner Pro altijd laatste versie) is bewerkt door Mr Media'),
(609, '2021-07-20 01:30:28', 'Torrent 203 (Ccleaner Pro altijd laatste versie) is bewerkt door Mr Media'),
(610, '2021-07-20 01:33:58', 'Torrent  (Ccleaner Pro altijd laatste versie) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(611, '2021-07-20 17:59:24', 'User account 75 (XoWYfIjz) was created'),
(612, '2021-07-20 19:02:49', 'Torrent 204 (CCleaner Pro Altijd laatste versie) is geplaatst door Mr Torrent'),
(613, '2021-07-20 19:36:50', 'Torrent  (CCleaner Pro Altijd laatste versie) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(614, '2021-07-20 19:38:12', 'Torrent 205 (Ccleaner Pro altijd laatste versie 2.0) is geplaatst door Mr Media'),
(615, '2021-07-20 21:42:47', 'Torrent  (Ccleaner Pro altijd laatste versie 2.0) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(616, '2021-07-20 21:44:04', 'Torrent 206 (Ccleaner Pro altijd laatste versie) is geplaatst door Mr Media'),
(617, '2021-07-20 21:59:08', 'Torrent  (Ccleaner Pro altijd laatste versie) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(618, '2021-07-20 22:00:31', 'Torrent 207 (Ccleaner Pro altijd laatste versie) is geplaatst door Mr Media'),
(619, '2021-07-20 22:10:30', 'Torrent 208 (DVDFab 9.2.3.9 Multilingual Nederlands) is geplaatst door Mr Torrent'),
(620, '2021-07-20 22:24:47', 'Torrent  (DVDFab 9.2.3.9 Multilingual Nederlands) is verwijderd door Mr Torrent, omdat deze niet goed was. Ratio correctie toegepast.'),
(621, '2021-07-20 22:24:57', 'Torrent  (Ccleaner Pro altijd laatste versie) is verwijderd door Mr Torrent, omdat deze niet goed was. Ratio correctie toegepast.'),
(622, '2021-07-20 22:31:27', 'Torrent 209 (Ccleaner Pro altijd laatste versie) is geplaatst door Mr Media'),
(623, '2021-07-21 03:29:34', 'Torrent  (Ccleaner Pro altijd laatste versie) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(624, '2021-07-21 03:30:38', 'Torrent 210 (Ccleaner Pro altijd laatste versie) is geplaatst door Mr Media'),
(625, '2021-07-21 04:47:13', 'User account 76 (QDhykYRWml) was created'),
(626, '2021-07-21 05:13:56', 'Torrent  (Ccleaner Pro altijd laatste versie) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(627, '2021-07-21 05:16:14', 'Torrent 211 (Ccleaner Pro altijd laatste versie) is geplaatst door Mr Media'),
(628, '2021-07-21 06:25:30', 'Torrent  (Ccleaner Pro altijd laatste versie) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(629, '2021-07-21 06:28:58', 'Torrent 212 (Ccleaner Pro altijd laatste versie) is geplaatst door TorrentMedia'),
(630, '2021-07-21 08:40:46', 'User account 77 (pNJKvrzXPH) was created'),
(631, '2021-07-21 10:55:04', 'Torrent  (Ccleaner Pro altijd laatste versie) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(632, '2021-07-21 11:07:31', 'User account 78 (poep) was created'),
(633, '2021-07-21 13:23:05', 'Torrent 213 (  Chernobyl 1986 (2021) 1080p BluRay DTS Retail NLSub  ) is geplaatst door Mr Torrent'),
(634, '2021-07-21 13:26:29', 'Torrent 214 ( CCleaner Pro Altijd laatste versie 2.0) is geplaatst door Mr Torrent'),
(635, '2021-07-21 13:29:42', 'Torrent 215 ( Windows 11 Version Dev Build Consumer Edition ) is geplaatst door Mr Torrent'),
(636, '2021-07-21 13:34:33', 'User account 79 (Extreme) was created'),
(637, '2021-07-21 13:53:35', 'Torrent 216 (Disney BOX,,alles NL Gesproken + alle Hoesjes  125 Film) is geplaatst door Mr Torrent'),
(638, '2021-07-21 13:57:37', 'Torrent 217 ( WinRAR 6.02 FINAL NEDERLANDS) is geplaatst door Mr Torrent'),
(639, '2021-07-21 14:03:36', 'Torrent 218 (girlcum cecelia taylor morning cums 720p.mp4) is geplaatst door Mr Torrent'),
(640, '2021-07-21 15:17:54', 'User account 80 (pvozfwxEgmy) was created'),
(641, '2021-07-21 15:43:32', 'User account 82 (poepe) was created'),
(642, '2021-07-21 19:44:12', 'User account 83 (iqOETGYd) was created'),
(643, '2021-07-21 20:14:31', 'Torrent  ( WinRAR 6.02 FINAL NEDERLANDS) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(644, '2021-07-21 20:14:53', 'Torrent  (Disney BOX,,alles NL Gesproken + alle Hoesjes  125 Film) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(645, '2021-07-21 20:15:06', 'Torrent  ( Windows 11 Version Dev Build Consumer Edition ) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(646, '2021-07-21 20:15:17', 'Torrent  (  Chernobyl 1986 (2021) 1080p BluRay DTS Retail NLSub  ) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(647, '2021-07-21 20:15:29', 'Torrent  ( CCleaner Pro Altijd laatste versie 2.0) is verwijderd door TorrentMedia, omdat deze niet goed was. Ratio correctie toegepast.'),
(648, '2021-07-21 21:43:26', 'Torrent  (girlcum cecelia taylor morning cums 720p.mp4) is verwijderd door Mr Torrent, omdat deze niet goed was. Ratio correctie toegepast.'),
(649, '2021-07-22 02:13:57', 'User account 84 (oXeHjCrm) was created'),
(650, '2021-07-22 12:24:14', 'User account 85 (qYlPTevWJwn) was created'),
(651, '2021-07-22 18:57:46', 'User account 86 (Nitram) was created'),
(652, '2021-07-22 19:02:02', 'User account 87 (Ambrosius) was created'),
(653, '2021-07-22 19:12:35', 'Torrent 219 (ChromeOS op elke Windows Laptop) is geplaatst door Mr Media'),
(654, '2021-07-22 20:44:46', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(655, '2021-07-22 20:45:10', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(656, '2021-07-22 20:45:21', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(657, '2021-07-22 20:45:32', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(658, '2021-07-22 20:45:44', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(659, '2021-07-22 20:45:52', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(660, '2021-07-22 20:45:59', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(661, '2021-07-22 20:46:06', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(662, '2021-07-22 20:46:18', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(663, '2021-07-22 20:55:58', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(664, '2021-07-22 20:56:10', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(665, '2021-07-22 20:56:22', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(666, '2021-07-22 20:56:28', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(667, '2021-07-22 20:56:36', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(668, '2021-07-22 20:56:40', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(669, '2021-07-22 20:56:44', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(670, '2021-07-22 20:56:48', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(671, '2021-07-22 20:56:53', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(672, '2021-07-22 20:57:01', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(673, '2021-07-22 20:57:07', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(674, '2021-07-22 20:57:12', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(675, '2021-07-22 20:57:31', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(676, '2021-07-22 20:57:48', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(677, '2021-07-22 20:58:05', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(678, '2021-07-22 20:58:18', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(679, '2021-07-22 20:58:27', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(680, '2021-07-22 20:58:34', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(681, '2021-07-22 21:00:59', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(682, '2021-07-22 21:01:09', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door TorrentMedia'),
(683, '2021-07-22 21:52:41', 'User account 88 (RVCYZWtckB) was created'),
(684, '2021-07-22 22:00:55', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door Mr Media'),
(685, '2021-07-22 22:01:01', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door Mr Media'),
(686, '2021-07-22 22:13:40', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door Mr Media'),
(687, '2021-07-22 22:15:16', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door Mr Media'),
(688, '2021-07-22 22:29:34', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door Mr Media'),
(689, '2021-07-22 22:29:42', 'Torrent 219 (ChromeOS op elke Windows Laptop) is bewerkt door Mr Media'),
(690, '2021-07-23 00:21:41', 'Torrent  (ChromeOS op elke Windows Laptop) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(691, '2021-07-23 00:21:46', 'Torrent 220 (cHROMEos) is geplaatst door Mr Torrent'),
(692, '2021-07-23 00:23:16', 'Torrent 220 (cHROMEos) is bewerkt door Mr Torrent'),
(693, '2021-07-23 00:26:03', 'Torrent  (cHROMEos) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(694, '2021-07-23 00:33:28', 'Torrent 221 (ChromeOS op elke Windows Laptop) is geplaatst door Mr Media'),
(695, '2021-07-23 00:39:09', 'Torrent  (ChromeOS op elke Windows Laptop) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(696, '2021-07-24 13:15:21', 'User account 89 (offenbergt) was created'),
(697, '2021-07-24 13:38:17', 'User account 90 (sgRHGHD) was created'),
(698, '2021-07-24 13:42:21', 'User account 91 (sgsgweewhg) was created'),
(699, '2021-07-24 20:17:10', 'User account 92 (torrent) was created'),
(700, '2021-07-24 22:32:13', 'User account 93 (mota77) was created'),
(701, '2021-07-24 22:37:19', 'User account 94 (12WERTF) was created'),
(702, '2021-07-24 22:41:29', 'User account 95 (teste123) was created'),
(703, '2021-07-24 22:42:22', 'User account 96 (teste12323) was created'),
(704, '2021-07-24 23:25:50', 'User account 97 (aaaaaaaa) was created'),
(705, '2021-07-24 23:28:27', 'User account 98 (SGgRFSSS) was created'),
(706, '2021-07-25 21:25:18', 'User account 99 (dropje) was created'),
(707, '2021-07-25 23:15:01', 'User account 100 (Bulldog1993) was created'),
(708, '2021-07-26 11:27:17', 'User account 102 (yFJxNviGle) was created'),
(709, '2021-07-26 13:12:28', 'User account 103 (AjOdoRXh) was created'),
(710, '2021-07-26 16:00:55', 'User account 104 (UtnizuhYOfEB) was created'),
(711, '2021-07-27 02:27:14', 'User account 105 (ajax1990) was created'),
(712, '2021-07-27 02:42:16', 'Torrent 222 (american) is geplaatst door ajax1990'),
(713, '2021-07-27 02:50:50', 'Torrent  (american) is verwijderd door ajax1990, omdat deze niet goed was. Ratio correctie toegepast.'),
(714, '2021-07-27 03:15:34', 'User account 106 (lWOLeMxUgD) was created'),
(715, '2021-07-27 03:30:35', 'Torrent 223 (sfsdfsf) is geplaatst door Mr Media'),
(716, '2021-07-27 09:09:46', 'User account 108 (tester) was created'),
(717, '2021-07-27 15:32:26', 'User account 109 (CSXwrHhMP) was created'),
(718, '2021-07-27 16:03:38', 'Torrent 224 (rrrweehye) is geplaatst door Mr Media'),
(719, '2021-07-27 16:19:37', 'Torrent  (rrrweehye) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(720, '2021-07-27 16:19:47', 'Torrent  (sfsdfsf) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(721, '2021-07-27 20:39:10', 'User account 110 (YFXJueDjHQx) was created'),
(722, '2021-07-27 20:56:09', 'User account 111 (Roel88) was created'),
(723, '2021-07-29 02:40:35', 'User account 112 (Qwizzle) was created'),
(724, '2021-07-30 00:38:23', 'User account 113 (pro) was created'),
(725, '2021-07-30 00:41:26', 'User account 114 (pro) was created'),
(726, '2021-07-30 00:44:18', 'User account 115 (pro) was created'),
(727, '2021-07-31 13:44:37', 'User account 116 (test) was created'),
(728, '2021-08-01 13:05:49', 'User account 117 (dropje) was created'),
(729, '2021-08-02 13:38:01', 'User account 118 (debora) was created'),
(730, '2021-08-02 13:38:41', 'User account 119 (sjaak5) was created'),
(731, '2021-08-02 14:41:41', 'User account 120 (stuntshop) was created'),
(732, '2021-08-02 14:51:14', 'User account 121 (mazda3f) was created'),
(733, '2021-08-02 15:31:46', 'User account 122 (zoefdehaas) was created'),
(734, '2021-08-02 15:39:40', 'User account 123 (Rendier) was created'),
(735, '2021-08-02 15:46:48', 'User account 124 (Banaan) was created'),
(736, '2021-08-02 15:48:39', 'User account 125 (Prozac) was created'),
(737, '2021-08-02 16:10:03', 'User account 126 (spijker) was created'),
(738, '2021-08-02 16:12:09', 'User account 127 (donald) was created'),
(739, '2021-08-02 16:32:49', 'User account 128 (zeehond) was created'),
(740, '2021-08-02 16:43:31', 'User account 129 (Id) was created'),
(741, '2021-08-02 18:15:47', 'User account 130 (MrBass) was created'),
(742, '2021-08-06 10:39:24', 'User account 131 (Avsdesign) was created'),
(743, '2021-08-15 12:59:22', 'User account 132 (zeehond) was created'),
(744, '2021-08-19 09:45:46', 'User account 133 (keesje) was created'),
(745, '2021-08-23 18:33:21', 'User account 134 (NTimHudakoV) was created'),
(746, '2021-08-30 19:44:35', 'User account 135 (Tattie23) was created'),
(747, '2021-09-22 21:37:19', 'User account 137 (TnLOGyvt) was created'),
(748, '2021-09-22 22:29:41', 'Torrent 225 (THE VIRTUOSO (2021) 1080P BLURAY DTS-HD MA5.1 NLsub) is geplaatst door Mr Media'),
(749, '2021-09-22 22:35:41', 'Torrent 226 (Snake Eyes G.I Joe Origins 2021 1080p NL Subs) is geplaatst door Mr Media'),
(750, '2021-09-22 22:39:24', 'Torrent 227 (MALIGNANT (2021) 1080P HMAX WEB-DL DD5.1 NL SUB) is geplaatst door Mr Media'),
(751, '2021-09-22 23:36:13', 'Torrent 228 (Escape Room Tournament of Champions 2021 1080P NLSub) is geplaatst door Mr Media'),
(752, '2021-09-22 23:46:21', 'Torrent 229 (HeavyOnHotties - Camila Palmer Injury Prone 1080p) is geplaatst door Mr Media'),
(753, '2021-09-23 00:00:49', 'Torrent 230 (Candyman (2021) 1080p DDP5.1 NLSub) is geplaatst door Mr Media'),
(754, '2021-09-23 00:02:15', 'Torrent 228 (Escape Room Tournament of Champions 2021 1080P NLSub) is bewerkt door Mr Media'),
(755, '2021-09-23 00:02:49', 'Torrent 227 (MALIGNANT (2021) 1080P HMAX WEB-DL DD5.1 NL SUB) is bewerkt door Mr Media'),
(756, '2021-09-23 00:03:39', 'Torrent 227 (MALIGNANT (2021) 1080P HMAX WEB-DL DD5.1 NL SUB) is bewerkt door Mr Media'),
(757, '2021-09-23 00:06:26', 'Torrent 227 (MALIGNANT (2021) 1080P HMAX WEB-DL DD5.1 NL SUB) is bewerkt door Mr Media'),
(758, '2021-09-23 00:08:20', 'Torrent 226 (Snake Eyes G.I Joe Origins 2021 1080p NL Subs) is bewerkt door Mr Media'),
(759, '2021-09-23 00:08:53', 'Torrent 225 (THE VIRTUOSO (2021) 1080P BLURAY DTS-HD MA5.1 NLsub) is bewerkt door Mr Media'),
(760, '2021-09-23 00:14:46', 'Torrent 231 (The Suicide Squad 2021 1080p DD5.1 NL SUBS) is geplaatst door Mr Media'),
(761, '2021-09-23 00:24:22', 'Torrent 232 (Windows Server 2021 Insider Preview) is geplaatst door Mr Media'),
(762, '2021-09-23 00:31:14', 'Torrent 233 (BLAZE  MONSTERWIELEN Nederlands Gesproken 3 Seizoenen) is geplaatst door Mr Media'),
(763, '2021-09-23 00:33:52', 'Torrent 233 (BLAZE  MONSTERWIELEN Nederlands Gesproken 3 Seizoenen) is bewerkt door Mr Media'),
(764, '2021-09-23 00:38:38', 'Torrent 234 (Tom En Jerry Nederlands Gesproken 12 seizoenen) is geplaatst door Mr Media'),
(765, '2021-09-23 00:38:58', 'Torrent 234 ([youtube=Tom En Jerry Nederlands Gesproken 12 seizoenen]) is bewerkt door Mr Media'),
(766, '2021-09-23 00:39:58', 'Torrent 234 (Tom En Jerry Nederlands Gesproken 12 seizoenen) is bewerkt door Mr Media'),
(767, '2021-09-23 00:40:13', 'Torrent 234 (Tom En Jerry Nederlands Gesproken 12 seizoenen) is bewerkt door Mr Media'),
(768, '2021-09-23 00:40:58', 'Torrent 234 (Tom En Jerry Nederlands Gesproken 12 seizoenen) is bewerkt door Mr Media'),
(769, '2021-09-23 00:41:22', 'Torrent 234 (Tom En Jerry Nederlands Gesproken 12 seizoenen) is bewerkt door Mr Media'),
(770, '2021-09-23 00:42:04', 'Torrent 234 (Tom En Jerry Nederlands Gesproken 12 seizoenen) is bewerkt door Mr Media'),
(771, '2021-09-23 00:51:02', 'Torrent 234 (Tom En Jerry Nederlands Gesproken 12 seizoenen) is bewerkt door Mr Media'),
(772, '2021-09-23 00:51:54', 'Torrent 234 (Tom En Jerry Nederlands Gesproken 12 seizoenen) is bewerkt door Mr Media'),
(773, '2021-09-23 00:52:37', 'Torrent 234 (Tom En Jerry Nederlands Gesproken 12 seizoenen) is bewerkt door Mr Media'),
(774, '2021-09-23 00:55:15', 'Torrent 234 (Tom En Jerry Nederlands Gesproken 12 seizoenen) is bewerkt door Mr Media'),
(775, '2021-09-23 00:57:07', 'Torrent 225 (THE VIRTUOSO (2021) 1080P BLURAY DTS-HD MA5.1 NLsub) is bewerkt door Mr Media'),
(776, '2021-09-23 00:57:14', 'Torrent 225 (THE VIRTUOSO (2021) 1080P BLURAY DTS-HD MA5.1 NLsub) is bewerkt door Mr Media'),
(777, '2021-09-23 00:57:28', 'Torrent 234 (Tom En Jerry Nederlands Gesproken 12 seizoenen) is bewerkt door Mr Media'),
(778, '2021-09-23 01:14:27', 'Torrent 234 (Tom En Jerry Nederlands Gesproken 12 seizoenen) is bewerkt door Mr Media'),
(779, '2021-09-23 01:33:49', 'Torrent 233 (BLAZE  MONSTERWIELEN Nederlands Gesproken 3 Seizoenen) is bewerkt door Mr Media'),
(780, '2021-09-23 01:34:25', 'Torrent 232 (Windows Server 2021 Insider Preview) is bewerkt door Mr Media'),
(781, '2021-09-23 01:34:54', 'Torrent 231 (The Suicide Squad 2021 1080p DD5.1 NL SUBS) is bewerkt door Mr Media'),
(782, '2021-09-23 01:35:20', 'Torrent 231 (The Suicide Squad 2021 1080p DD5.1 NL SUBS) is bewerkt door Mr Media'),
(783, '2021-09-23 01:35:48', 'Torrent 230 (Candyman (2021) 1080p DDP5.1 NLSub) is bewerkt door Mr Media'),
(784, '2021-09-23 01:36:15', 'Torrent 228 (Escape Room Tournament of Champions 2021 1080P NLSub) is bewerkt door Mr Media'),
(785, '2021-09-23 01:37:13', 'Torrent 227 (MALIGNANT (2021) 1080P HMAX WEB-DL DD5.1 NL SUB) is bewerkt door Mr Media'),
(786, '2021-09-23 01:37:36', 'Torrent 226 (Snake Eyes G.I Joe Origins 2021 1080p NL Subs) is bewerkt door Mr Media'),
(787, '2021-09-23 01:38:48', 'Torrent 231 (The Suicide Squad 2021 1080p DD5.1 NL SUBS) is bewerkt door Mr Media'),
(788, '2021-09-23 01:40:12', 'Ban 19 is verwijderd door 3 (TorrentMedia)'),
(789, '2021-09-23 01:40:16', 'Ban 20 is verwijderd door 3 (TorrentMedia)'),
(790, '2021-09-23 01:40:19', 'Ban 21 is verwijderd door 3 (TorrentMedia)'),
(791, '2021-09-23 01:40:22', 'Ban 22 is verwijderd door 3 (TorrentMedia)'),
(792, '2021-09-23 17:21:32', 'User account 138 (lwcFdCPE) was created'),
(793, '2021-09-23 19:47:57', 'User account 139 (SORrvZFbx) was created'),
(794, '2021-09-24 11:04:19', 'User account 140 (rlePmtyj) was created'),
(795, '2021-09-24 12:01:48', 'Torrent 235 (Free Guy (2021) 1080p BluRay NLSub) is geplaatst door Mr Media'),
(796, '2021-09-25 01:52:10', 'User account 141 (quKYQmiOv) was created'),
(797, '2021-09-25 07:20:41', 'User account 142 (XzCFMElk) was created'),
(798, '2021-09-25 10:13:50', 'User account 143 (EmngoXcdL) was created'),
(799, '2021-09-25 14:30:40', 'User account 144 (qRMUXDFtuWJp) was created'),
(800, '2021-09-26 03:27:58', 'User account 145 (DtMuBKvhNnY) was created'),
(801, '2021-09-26 04:20:28', 'User account 146 (cdAlvECVDOh) was created'),
(802, '2021-09-26 07:20:49', 'User account 147 (KTMLQIRfh) was created'),
(803, '2021-09-26 14:27:16', 'User account 148 (lgOzFWshe) was created'),
(804, '2021-09-26 18:46:31', 'User account 149 (IDOnelKamyE) was created'),
(805, '2021-09-27 00:23:03', 'Torrent 236 (De Zitting (2021) 1080p NL Gesproken) is geplaatst door Mr Media'),
(806, '2021-09-27 00:27:01', 'Torrent 237 (DVDFab All In One v 12.0.4.4 ) is geplaatst door Mr Media'),
(807, '2021-09-27 00:31:24', 'Torrent 238 (Most Dangerous Game (2021) NLsub) is geplaatst door Mr Media'),
(808, '2021-09-27 00:34:46', 'Torrent 239 (Stargirl Seizoen 1 1080P NLsub) is geplaatst door Mr Media'),
(809, '2021-09-27 06:34:19', 'User account 150 (EitoyICR) was created'),
(810, '2021-09-27 08:25:10', 'User account 151 (BqvuWPlmwid) was created'),
(811, '2021-09-27 09:04:14', 'User account 152 (nYtySJcXFpl) was created'),
(812, '2021-09-27 20:49:14', 'User account 153 (mJjyaksMd) was created'),
(813, '2021-09-27 23:59:13', 'User account 154 (ilcBkdrAg) was created'),
(814, '2021-09-28 11:42:07', 'User account 155 (lBoagYMvLTZz) was created'),
(815, '2021-09-29 04:31:44', 'User account 156 (Yuppie) was created'),
(816, '2021-09-29 08:51:20', 'User account 157 (rSIHoWADidw) was created'),
(817, '2021-09-29 09:53:50', 'User account 158 (zNIBSwOfyX) was created'),
(818, '2021-09-29 10:58:47', 'User account 159 (PCMQfTgBsh) was created'),
(819, '2021-09-29 14:55:54', 'Torrent 240 (DE STERFSHOW (2021) 1080p NL GESPROKEN) is geplaatst door Mr Media'),
(820, '2021-09-29 15:01:11', 'Torrent 241 (INDRINGER (2021) 1080p NL GESPROKEN) is geplaatst door Mr Media'),
(821, '2021-09-29 15:03:57', 'User account 160 (ajax1990) was created'),
(822, '2021-09-29 15:06:18', 'User account 161 (ajax19990) was created'),
(823, '2021-09-29 15:07:31', 'User account 162 (ajax19900) was created'),
(824, '2021-09-29 15:08:50', 'User account 163 (ajax1990000) was created'),
(825, '2021-09-29 15:32:52', 'Torrent 242 (NO ONE GETS OUT ALIVE (2021) 1080p NLSubs) is geplaatst door Mr Media'),
(826, '2021-09-29 15:35:15', 'Torrent 243 (  FRIENDZONE (2021) 1080p NLSub) is geplaatst door Mr Media'),
(827, '2021-09-29 15:38:17', 'Torrent 244 (JUNGLE CRUISE (2021) 1080p Bluray NLSub) is geplaatst door Mr Media'),
(828, '2021-09-29 18:38:46', 'User account 164 (ajax19990) was created'),
(829, '2021-09-29 18:47:11', 'User account 165 (dyudhszsssz) was created'),
(830, '2021-09-29 18:49:04', 'User account 166 (dyudhszssszs) was created'),
(831, '2021-09-29 20:11:04', 'User account 167 (TEST) was created'),
(832, '2021-09-29 20:20:11', 'User account 168 (HALLO) was created'),
(833, '2021-09-29 20:34:03', 'User account 169 (Toowise) was created'),
(834, '2021-09-30 01:20:10', 'Torrent 245 (Bangkok Breaking (2021) NLSub) is geplaatst door Mr Media'),
(835, '2021-09-30 03:38:41', 'User account 171 (gJbGYziurwe) was created'),
(836, '2021-09-30 04:07:22', 'User account 172 (bach) was created'),
(837, '2021-09-30 04:22:19', 'User account 173 (AXqDzvhcM) was created'),
(838, '2021-09-30 12:08:32', 'Torrent 225 (THE VIRTUOSO (2021) 1080P BLURAY DTS-HD MA5.1 NLsub) is verwijderd door Mr Media (Dood: geen delers/ontvangers meer)\n'),
(839, '2021-09-30 12:11:31', 'Torrent 227 (MALIGNANT (2021) 1080P HMAX WEB-DL DD5.1 NL SUB) is bewerkt door Mr Media'),
(840, '2021-09-30 12:12:30', 'Torrent 227 (MALIGNANT (2021) 1080P HMAX WEB-DL DD5.1 NL SUB) is verwijderd door Mr Media (Dood: geen delers/ontvangers meer)\n'),
(841, '2021-09-30 12:14:06', 'Torrent 238 (Most Dangerous Game (2021) NLsub) is verwijderd door Mr Media (Dood: geen delers/ontvangers meer)\n'),
(842, '2021-09-30 13:22:27', 'User account 174 (WLVlQxFSOCT) was created'),
(843, '2021-09-30 14:22:59', 'User account 175 (vfpwhsaJox) was created'),
(844, '2021-09-30 16:21:41', 'Torrent 245 (Bangkok Breaking (2021) NLSub) is bewerkt door Miro'),
(845, '2021-09-30 16:23:11', 'Torrent 245 (Bangkok Breaking (2021) NLSub) is bewerkt door Miro'),
(846, '2021-09-30 16:23:57', 'Torrent 245 (Bangkok Breaking (2021) NLSub) is bewerkt door Miro'),
(847, '2021-09-30 16:41:43', 'Torrent 245 (Bangkok Breaking (2021) NLSub) is bewerkt door Miro'),
(848, '2021-10-01 02:43:05', 'User account 176 (UpCgSmWlLrEG) was created'),
(849, '2021-10-01 09:32:18', 'User account 177 (DQrhNqgzTbJ) was created'),
(850, '2021-10-01 11:59:20', 'Torrent 246 (WinRAR 6.02 x86 x64 FINAL Nederlands) is geplaatst door Mr Media'),
(851, '2021-10-01 12:02:15', 'Torrent 247 (Ccleaner - Altijd de laatste Versie) is geplaatst door Mr Media'),
(852, '2021-10-01 12:05:47', 'Torrent 248 (Microsoft Windows 11 NL (21H2) x64 TPM Bypass) is geplaatst door Mr Media'),
(853, '2021-10-01 12:08:21', 'Torrent 248 (Microsoft Windows 11 NL (21H2) x64 TPM Bypass) is bewerkt door Mr Media'),
(854, '2021-10-01 12:09:00', 'User account 178 (PGLaApjtnf) was created'),
(855, '2021-10-01 12:09:39', 'Torrent 247 (Ccleaner - Altijd de laatste Versie) is bewerkt door Mr Media'),
(856, '2021-10-01 12:09:59', 'Torrent 247 (Ccleaner - Altijd de laatste Versie) is bewerkt door Mr Media'),
(857, '2021-10-01 12:10:40', 'Torrent 247 (Ccleaner - Altijd de laatste Versie) is bewerkt door Mr Media'),
(858, '2021-10-01 12:11:33', 'Torrent 247 (Ccleaner - Altijd de laatste Versie) is bewerkt door Mr Media'),
(859, '2021-10-01 12:17:30', 'Torrent 249 (FileZilla Pro v3.55.1 (x64)) is geplaatst door Mr Media'),
(860, '2021-10-01 12:25:41', 'Torrent 247 (Ccleaner - Altijd de laatste Versie) is bewerkt door Mr Media'),
(861, '2021-10-01 12:41:41', 'Torrent 247 (Ccleaner - Altijd de laatste Versie) is bewerkt door Mr Media'),
(862, '2021-10-01 12:42:12', 'Torrent 247 (Ccleaner - Altijd de laatste Versie) is bewerkt door Mr Media'),
(863, '2021-10-01 13:01:40', 'Torrent 247 (Ccleaner - Altijd de laatste Versie) is bewerkt door Mr Media'),
(864, '2021-10-01 16:26:04', 'Torrent 250 (Astro Boy (2009) 1080p NL Gesproken) is geplaatst door Mr Media'),
(865, '2021-10-01 16:27:33', 'Torrent 251 (Avatar - The Last Airbender) is geplaatst door Mr Media'),
(866, '2021-10-01 16:29:00', 'Torrent 252 (Avatar - The Legend of Korra) is geplaatst door Mr Media'),
(867, '2021-10-01 16:32:56', 'Torrent 253 (Bigfoot Familie 1+2) is geplaatst door Mr Media'),
(868, '2021-10-01 16:40:13', 'Torrent 254 (Dexter Alle 8 Seizoenen NLSub) is geplaatst door Mr Media'),
(869, '2021-10-01 16:52:06', 'Torrent 226 (Snake Eyes G.I Joe Origins 2021 1080p NL Subs) is bewerkt door Mr Media'),
(870, '2021-10-01 16:55:13', 'Torrent 255 (Dragonball Movies ) is geplaatst door Mr Media'),
(871, '2021-10-01 16:57:05', 'Torrent 226 (Snake Eyes G.I Joe Origins 2021 1080p NL Subs) is bewerkt door Mr Media'),
(872, '2021-10-01 17:00:46', 'Torrent 256 (Flikken Maastricht 14 Seizoenen) is geplaatst door Mr Media'),
(873, '2021-10-01 17:02:17', 'Torrent 257 (Flubber NL Gesproken) is geplaatst door Mr Media'),
(874, '2021-10-01 17:03:25', 'Torrent 258 (Free Willy Compleet NL Gesproken) is geplaatst door Mr Media'),
(875, '2021-10-01 17:05:50', 'Torrent 259 (The Good Doctor 4 Seizoenen  NLSub ) is geplaatst door Mr Media'),
(876, '2021-10-01 17:09:32', 'Torrent 260 (Dragonball Series Compleet) is geplaatst door Mr Media'),
(877, '2021-10-01 17:12:34', 'Torrent 226 (Snake Eyes G.I Joe Origins 2021 1080p NL Subs) is bewerkt door Mr Media'),
(878, '2021-10-01 17:17:36', 'Torrent 226 (Snake Eyes G.I Joe Origins 2021 1080p NL Subs) is bewerkt door Mr Media'),
(879, '2021-10-01 17:20:11', 'Torrent 261 (Hanekam, de Rocker (1991) NL Gesproken) is geplaatst door Mr Media'),
(880, '2021-10-01 17:22:09', 'Torrent 262 (Het Dappere Broodroostertje NL Gesproken) is geplaatst door Mr Media'),
(881, '2021-10-01 17:22:18', 'Torrent 262 (Het Dappere Broodroostertje NL Gesproken) is bewerkt door Mr Media'),
(882, '2021-10-01 17:23:52', 'Torrent 263 (How to train your dragon) is geplaatst door Mr Media'),
(883, '2021-10-01 17:25:11', 'Torrent 264 (Kung Fu Panda NL Gesproken) is geplaatst door Mr Media'),
(884, '2021-10-01 17:26:17', 'Torrent 237 (DVDFab All In One v 12.0.4.4 ) is bewerkt door Mr Media'),
(885, '2021-10-01 17:26:38', 'Torrent 265 (La Casa De Papel 5 Seizoenen NLSub) is geplaatst door Mr Media'),
(886, '2021-10-01 17:28:30', 'Torrent 266 (Loki Seizoen 1 en 6 Afleveringen NLSub) is geplaatst door Mr Media'),
(887, '2021-10-01 17:29:59', 'Torrent 267 (Luizenmoeder 2 seizoenen NL Gesproken) is geplaatst door Mr Media'),
(888, '2021-10-01 17:33:32', 'Torrent 268 (Marvel filmcollectie 25 films NLSub) is geplaatst door Mr Media'),
(889, '2021-10-01 17:35:19', 'Torrent 269 (Mr. Peabody & Sherman NL Gesproken) is geplaatst door Mr Media'),
(890, '2021-10-01 17:36:54', 'Torrent 270 (New Amsterdam 3 Seizoenen NLSub) is geplaatst door Mr Media'),
(891, '2021-10-01 17:38:30', 'Torrent 271 (Onward  NL Gesproken) is geplaatst door Mr Media'),
(892, '2021-10-01 17:40:08', 'Torrent 272 (Penoza 5 Seizoenen Compleet NL Gesproken) is geplaatst door Mr Media'),
(893, '2021-10-01 17:41:30', 'Torrent 273 (Pokenmon 23 Seizoenen NL Gesproken) is geplaatst door Mr Media'),
(894, '2021-10-01 18:00:07', 'User account 179 (rKPypisLcWS) was created'),
(895, '2021-10-01 23:05:15', 'User account 180 (ZxeBlwEX) was created'),
(896, '2021-10-02 01:46:16', 'User account 181 (UcvEqpOTm) was created'),
(897, '2021-10-02 02:57:18', 'User account 182 (QPExnbAGBeZI) was created'),
(898, '2021-10-02 15:05:30', 'User account 183 (gmcKqAep) was created'),
(899, '2021-10-02 16:04:41', 'User account 184 (tgpLAPXvY) was created'),
(900, '2021-10-02 16:19:46', 'User account 185 (shQtKMxealCT) was created'),
(901, '2021-10-02 19:32:51', 'Torrent 263 (How to train your dragon 1,2 en 3) is bewerkt door Mr Media'),
(902, '2021-10-02 19:41:22', 'User account 186 (WegNaUsO) was created'),
(903, '2021-10-02 21:46:51', 'User account 187 (zCxMvyFotBg) was created'),
(904, '2021-10-02 22:46:42', 'Torrent 263 (How to train your dragon 3 delen!!) is bewerkt door Mr Media'),
(905, '2021-10-02 22:49:16', 'Torrent  (How to train your dragon) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(906, '2021-10-02 22:50:21', 'Torrent 274 (How to train your dragon 3 delen!!) is geplaatst door Mr Media'),
(907, '2021-10-02 22:51:23', 'Torrent 264 (Kung Fu Panda NL Gesproken 3 DELEN) is bewerkt door Mr Media'),
(908, '2021-10-02 22:52:11', 'Torrent 264 (Kung Fu Panda NL Gesproken 3 DELEN) is bewerkt door Mr Media'),
(909, '2021-10-02 22:54:11', 'Torrent 275 (Raya en de Laatste Draak 1080p NL Gesproken) is geplaatst door Mr Media');
INSERT INTO `sitelog` (`id`, `added`, `txt`) VALUES
(910, '2021-10-02 22:56:24', 'Torrent 276 (Sonic The Hedgehog (2020) 1080p Nederlands Gesproken) is geplaatst door Mr Media'),
(911, '2021-10-02 22:57:51', 'Torrent 277 (Soul (2020) 1080p NL Gesproken) is geplaatst door Mr Media'),
(912, '2021-10-02 22:59:25', 'Torrent 278 (The Falcon and the Winter Soldier 1080p NLSub) is geplaatst door Mr Media'),
(913, '2021-10-02 23:00:54', 'Torrent 264 (Kung Fu Panda NL Gesproken 3 DELEN) is bewerkt door Mr Media'),
(914, '2021-10-02 23:01:42', 'Torrent 264 (Kung Fu Panda NL Gesproken 3 DELEN) is bewerkt door Mr Media'),
(915, '2021-10-02 23:02:38', 'Torrent 279 (The Purge 1080p Seizoen 1 NLSub) is geplaatst door Mr Media'),
(916, '2021-10-02 23:03:28', 'Torrent 279 (The Purge 1080p Seizoen 1 en 2 NLSub) is bewerkt door Mr Media'),
(917, '2021-10-02 23:11:33', 'Torrent 280 (The Croods 1080p 2 Delen NL GESPROKEN) is geplaatst door Mr Media'),
(918, '2021-10-02 23:13:40', 'Torrent 281 (TOM & JERRY (2021) 1080p NL Gesproken) is geplaatst door Mr Media'),
(919, '2021-10-02 23:15:27', 'Torrent 282 (Trolls Wereldtour (2020) 1080p NL GESPROKEN) is geplaatst door Mr Media'),
(920, '2021-10-02 23:17:20', 'Torrent 283 (Vet Hard (2005) 1080p NL Gesproken) is geplaatst door Mr Media'),
(921, '2021-10-02 23:19:02', 'Torrent 284 (Walking Dead 11 Seizoenen NLSub) is geplaatst door Mr Media'),
(922, '2021-10-02 23:20:22', 'Torrent 284 (Walking Dead 10 Seizoenen NLSub) is bewerkt door Mr Media'),
(923, '2021-10-02 23:29:50', 'Torrent 285 (Wonder Park (2019) 1080p NL Gesproken) is geplaatst door Mr Media'),
(924, '2021-10-02 23:31:53', 'Torrent 286 (YU-GI-OH Alle Seizoenen ENG Gesproken) is geplaatst door Mr Media'),
(925, '2021-10-02 23:35:04', 'Torrent 280 (The Croods 1080p 2 Delen NL GESPROKEN) is bewerkt door Mr Media'),
(926, '2021-10-02 23:35:38', 'Torrent 262 (Het Dappere Broodroostertje NL Gesproken) is bewerkt door Mr Media'),
(927, '2021-10-02 23:39:29', 'Torrent 270 (New Amsterdam 3 Seizoenen NLSub) is bewerkt door Mr Media'),
(928, '2021-10-02 23:41:18', 'Torrent 287 (Disney Box NL Gesproken) is geplaatst door Mr Media'),
(929, '2021-10-02 23:46:26', 'Torrent 270 (New Amsterdam 3 Seizoenen NLSub) is bewerkt door Mr Media'),
(930, '2021-10-02 23:47:08', 'Torrent 270 (New Amsterdam 3 Seizoenen NLSub) is bewerkt door Mr Media'),
(931, '2021-10-02 23:47:56', 'Torrent 281 (TOM & JERRY (2021) 1080p NL Gesproken) is bewerkt door Mr Media'),
(932, '2021-10-02 23:48:31', 'Torrent 261 (Hanekam, de Rocker (1991) NL Gesproken) is bewerkt door Mr Media'),
(933, '2021-10-02 23:49:57', 'Torrent  (TOM & JERRY (2021) 1080p NL Gesproken) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(934, '2021-10-02 23:50:12', 'Torrent  (Hanekam, de Rocker (1991) NL Gesproken) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(935, '2021-10-02 23:50:48', 'Torrent  (New Amsterdam 3 Seizoenen NLSub) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(936, '2021-10-02 23:55:57', 'Torrent 228 (Escape Room Tournament of Champions 2021 1080P NLSub) is bewerkt door Mr Media'),
(937, '2021-10-02 23:59:32', 'Torrent 288 (New Amsterdam Compleet NLSub) is geplaatst door Mr Media'),
(938, '2021-10-03 00:03:36', 'Torrent 228 (Escape Room Tournament of Champions 2021 1080P NLSub) is bewerkt door Mr Media'),
(939, '2021-10-03 01:31:48', 'Torrent 289 (The Addams Family 2 (2021) 1080p  NLSub) is geplaatst door Mr Media'),
(940, '2021-10-03 01:39:38', 'Torrent 289 (The Addams Family 2 (2021) 1080p  NLSub) is bewerkt door Mr Media'),
(941, '2021-10-03 01:39:50', 'Torrent 289 (The Addams Family 2 (2021) 1080p  NLSub) is bewerkt door Mr Media'),
(942, '2021-10-03 01:40:20', 'Torrent 289 (The Addams Family 2 (2021) 1080p  NLSub) is bewerkt door Mr Media'),
(943, '2021-10-03 01:40:36', 'Torrent 289 (The Addams Family 2 (2021) 1080p  NLSub) is bewerkt door Mr Media'),
(944, '2021-10-03 01:41:39', 'Torrent 289 (The Addams Family 2 (2021) 1080p  NLSub) is bewerkt door Mr Media'),
(945, '2021-10-03 01:42:00', 'Torrent 289 (The Addams Family 2 (2021) 1080p  NLSub) is bewerkt door Mr Media'),
(946, '2021-10-03 01:55:54', 'Torrent 290 (Dragon Ball Before) is geplaatst door Mr Media'),
(947, '2021-10-03 07:28:15', 'Torrent 291 (Squid Game S01 1080p x265 10bit Atmos Multi Subs) is geplaatst door Mr Media'),
(948, '2021-10-03 08:56:43', 'Torrent 292 (Queenpins 2021 1080p AMZN WEB-DL DDP5.1 NLSub) is geplaatst door Mr Media'),
(949, '2021-10-03 10:53:51', 'Torrent 293 (The Many Saints of Newark (2021) 1080p NLSub) is geplaatst door Mr Media'),
(950, '2021-10-03 11:49:45', 'User account 188 (DeamBoy) was created'),
(951, '2021-10-03 12:14:39', 'User account 189 (zunnebel) was created'),
(952, '2021-10-03 12:39:03', 'User account 190 (krone) was created'),
(953, '2021-10-03 12:49:22', 'User account 191 (esche008) was created'),
(954, '2021-10-03 15:00:29', 'User account 192 (corvette123) was created'),
(955, '2021-10-03 15:13:00', 'User account 193 (zaldiar) was created'),
(956, '2021-10-03 17:43:27', 'User account 194 (Henkske) was created'),
(957, '2021-10-03 19:46:21', 'User account 195 (pascal6) was created'),
(958, '2021-10-04 00:01:21', 'User account 196 (SwqZuPjJ) was created'),
(959, '2021-10-04 00:53:56', 'User account 197 (yEGeTkSX) was created'),
(960, '2021-10-04 01:53:19', 'Torrent 294 ( K3 Dans van de Farao (2020)) is geplaatst door Mr Media'),
(961, '2021-10-04 01:56:05', 'Torrent 295 (  Diana: The Musical (2021) 1080p NLSub) is geplaatst door Mr Media'),
(962, '2021-10-04 02:04:52', 'Torrent 296 (Mocro Maffia Backstories (2020) 1080p NL Gesproken) is geplaatst door Mr Media'),
(963, '2021-10-04 05:23:43', 'User account 198 (KZgGLWiAEj) was created'),
(964, '2021-10-04 07:03:35', 'User account 199 (FfhTXxyALEn) was created'),
(965, '2021-10-04 10:30:21', 'User account 200 (AzKVtxacdb) was created'),
(966, '2021-10-04 12:16:11', 'User account 201 (ayDXWjxsMbuN) was created'),
(967, '2021-10-04 17:07:29', 'User account 202 (MeLfwrvJ) was created'),
(968, '2021-10-05 05:44:08', 'User account 203 (ZwgCDuomnXN) was created'),
(969, '2021-10-05 07:23:17', 'User account 204 (GEPQZkdsJR) was created'),
(970, '2021-10-05 08:05:35', 'User account 205 (GRSldsZP) was created'),
(971, '2021-10-05 08:15:45', 'User account 206 (PetFxUWiKAXb) was created'),
(972, '2021-10-05 14:15:01', 'User account 207 (ErikH) was created'),
(973, '2021-10-05 16:16:27', 'User account 208 (jBYUopVch) was created'),
(974, '2021-10-06 05:27:54', 'User account 209 (EhsjORgQ) was created'),
(975, '2021-10-06 05:56:11', 'User account 210 (BlyakTJjfrp) was created'),
(976, '2021-10-06 17:34:51', 'User account 211 (JAMIN2223) was created'),
(977, '2021-10-06 20:31:53', 'User account 212 (PMIzegbj) was created'),
(978, '2021-10-07 00:51:05', 'User account 213 (PXnMeciVvY) was created'),
(979, '2021-10-07 08:13:00', 'Torrent  ( K3 Dans van de Farao (2020)) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(980, '2021-10-07 08:13:35', 'Torrent  (The Addams Family 2 (2021) 1080p  NLSub) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(981, '2021-10-07 08:13:48', 'Torrent  (The Many Saints of Newark (2021) 1080p NLSub) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(982, '2021-10-07 08:14:43', 'Torrent  (BLAZE  MONSTERWIELEN Nederlands Gesproken 3 Seizoenen) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(983, '2021-10-07 08:15:25', 'Torrent  (Windows Server 2021 Insider Preview) is verwijderd door Mr Media, omdat deze niet goed was. Ratio correctie toegepast.'),
(984, '2021-10-07 09:00:42', 'User account 214 (SPBjWtvmy) was created'),
(985, '2021-10-07 09:13:32', 'User account 215 (AljwGCTFn) was created'),
(986, '2021-10-07 15:44:39', 'User account 216 (ntefOovsI) was created'),
(987, '2021-10-07 17:41:01', 'User account 217 (Miro123) was created'),
(988, '2021-10-07 17:44:58', 'User account 218 (Miro1234) was created'),
(989, '2021-10-07 21:20:25', 'Torrent 280 (The Croods 1080p 2 Delen NL GESPROKEN) is bewerkt door Miro'),
(990, '2021-10-07 21:22:23', 'Torrent 280 (The Croods 1080p 2 Delen NL GESPROKEN) is verwijderd door Miro (Dubbel!)\n'),
(991, '2021-10-07 21:24:19', 'Torrent 297 (The Croods 1 + 2 NL Gesproken) is geplaatst door Miro'),
(992, '2021-10-07 21:39:40', 'Torrent 260 (Dragonball Series Compleet) is verwijderd door Miro (Dood: geen delers/ontvangers meer)\n'),
(993, '2021-10-07 22:17:34', 'Torrent 290 (Dragon Ball Before) is verwijderd door Mr Media (Dubbel!)\n'),
(994, '2021-10-07 22:20:38', 'Torrent 255 (Dragonball Movies ) is verwijderd door Mr Media (Dubbel!)\n'),
(995, '2021-10-07 22:27:15', 'Torrent 246 (WinRAR 6.02 x86 x64 FINAL Nederlands) is verwijderd door Mr Media (Dubbel!)\n'),
(996, '2021-10-07 23:44:43', 'Torrent  (The Croods 1 + 2 NL Gesproken) is verwijderd door Miro, omdat deze niet goed was. Ratio correctie toegepast.'),
(997, '2021-10-08 05:20:45', 'Torrent 286 (YU-GI-OH Alle Seizoenen ENG Gesproken) is bewerkt door Miro'),
(998, '2021-10-08 05:21:01', 'Torrent 273 (Pokenmon 23 Seizoenen NL Gesproken) is bewerkt door Miro'),
(999, '2021-10-08 05:21:18', 'Torrent 252 (Avatar - The Legend of Korra) is bewerkt door Miro'),
(1000, '2021-10-08 05:21:32', 'Torrent 251 (Avatar - The Last Airbender) is bewerkt door Miro'),
(1001, '2021-10-08 05:26:12', 'Torrent 298 (Winrar x64 Altijd de laatste Versie Unattended) is geplaatst door Mr Media'),
(1002, '2021-10-08 06:00:09', 'User account 219 (Miro12) was created'),
(1003, '2021-10-08 06:00:32', 'User account 220 (Miro123) was created'),
(1004, '2021-10-08 06:16:02', 'User account 221 (Miro12) was created'),
(1005, '2021-10-08 06:16:12', 'User account 222 (Miro123) was created'),
(1006, '2021-10-08 06:20:33', 'User account 223 (Miro12) was created'),
(1007, '2021-10-08 06:20:43', 'User account 224 (Miro123) was created'),
(1008, '2021-10-08 06:36:13', 'User account 225 (OZtFsXyud) was created'),
(1009, '2021-10-08 06:48:17', 'User account 226 (Miro12) was created'),
(1010, '2021-10-08 06:48:30', 'User account 227 (Miro123) was created'),
(1011, '2021-10-08 06:54:13', 'User account 228 (muDNbnAjLB) was created'),
(1012, '2021-10-08 06:59:12', 'User account 229 (jBmEPKTsfH) was created'),
(1013, '2021-10-08 07:01:39', 'Torrent 299 (Dragon Ball Series Kai  + Super Complete) is geplaatst door Mr Media'),
(1014, '2021-10-08 07:05:49', 'Torrent 300 (Dragon Ball Movies Complete) is geplaatst door Mr Media'),
(1015, '2021-10-08 07:08:52', 'Torrent 299 (Dragon Ball Series Kai  + Super Complete) is bewerkt door Mr Media'),
(1016, '2021-10-08 07:11:26', 'Torrent 299 (Dragon Ball Series Kai  + Super Complete) is verwijderd door Mr Media (Niet werkende uitgave!)\n'),
(1017, '2021-10-08 07:27:49', 'Torrent 301 (Dragon Ball Series Kid Goku) is geplaatst door Mr Media'),
(1018, '2021-10-08 08:08:27', 'Torrent 302 (Dragon Ball Series Kai  + Super Complete) is geplaatst door Mr Media'),
(1019, '2021-10-08 08:26:32', 'User account 230 (Miro12) was created'),
(1020, '2021-10-08 08:26:43', 'User account 231 (Miro123) was created'),
(1021, '2021-10-08 09:01:44', 'Torrent 302 (Dragon Ball Series Kai  + Super Complete) is verwijderd door Mr Media (Dubbel!)\n'),
(1022, '2021-10-08 09:05:59', 'Torrent 286 (YU-GI-OH Alle Seizoenen ENG Gesproken) is bewerkt door Mr Media'),
(1023, '2021-10-08 09:06:46', 'Torrent 295 (  Diana: The Musical (2021) 1080p NLSub) is verwijderd door Mr Media (Niet werkende uitgave!)\n'),
(1024, '2021-10-08 09:21:25', 'Torrent 229 (HeavyOnHotties - Camila Palmer Injury Prone 1080p) is verwijderd door Mr Media (Dubbel!)\n'),
(1025, '2021-10-08 09:31:07', 'Torrent 245 (Bangkok Breaking (2021) NLSub) is verwijderd door Mr Media (Dubbel!)\n'),
(1026, '2021-10-08 09:32:12', 'Torrent 296 (Mocro Maffia Backstories (2020) 1080p NL Gesproken) is verwijderd door Mr Media (Dubbel!)\n'),
(1027, '2021-10-08 09:34:23', 'Torrent 237 (DVDFab All In One v 12.0.4.4 ) is verwijderd door Mr Media (Dubbel!)\n'),
(1028, '2021-10-08 09:37:08', 'Torrent 234 (Tom En Jerry Nederlands Gesproken 12 seizoenen) is verwijderd door Mr Media (Dubbel!)\n'),
(1029, '2021-10-08 10:00:09', 'Torrent 241 (INDRINGER (2021) 1080p NL GESPROKEN) is verwijderd door Mr Media (Dubbel!)\n'),
(1030, '2021-10-08 10:02:58', 'Torrent 240 (DE STERFSHOW (2021) 1080p NL GESPROKEN) is verwijderd door Mr Media (Dubbel!)\n'),
(1031, '2021-10-08 10:05:12', 'Torrent 236 (De Zitting (2021) 1080p NL Gesproken) is verwijderd door Mr Media (Dubbel!)\n'),
(1032, '2021-10-08 10:06:31', 'Torrent 230 (Candyman (2021) 1080p DDP5.1 NLSub) is verwijderd door Mr Media (Dubbel!)\n'),
(1033, '2021-10-08 10:20:13', 'Torrent 303 (Dragon Ball Kai Complete Serie) is geplaatst door Mr Media'),
(1034, '2021-10-08 10:23:19', 'Torrent 304 (Dragon Ball Super Complete Serie) is geplaatst door Mr Media'),
(1035, '2021-10-08 13:39:11', 'Torrent 245 (Bangkok Breaking (2021) NLSub) is verwijderd door Miro (Dood: geen delers/ontvangers meer)\n'),
(1036, '2021-10-08 15:56:27', 'Torrent 304 (Dragon Ball Super Complete Serie) is verwijderd door TorrentMedia (Dood: geen delers/ontvangers meer)\n'),
(1037, '2021-10-08 17:46:10', 'Torrent 8 (Snake Eyes G.I Joe Origins 2021 1080p NL Subs) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1038, '2021-10-08 17:46:14', 'Torrent 8 (Escape Room Tournament of Champions 2021 1080P NLSub) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1039, '2021-10-08 17:46:17', 'Torrent 8 (The Suicide Squad 2021 1080p DD5.1 NL SUBS) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1040, '2021-10-08 17:46:20', 'Torrent 8 (Free Guy (2021) 1080p BluRay NLSub) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1041, '2021-10-08 17:46:24', 'Torrent 8 (Stargirl Seizoen 1 1080P NLsub) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1042, '2021-10-08 17:46:27', 'Torrent 8 (NO ONE GETS OUT ALIVE (2021) 1080p NLSubs) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1043, '2021-10-08 17:46:33', 'Torrent 8 (Dragon Ball Kai Complete Serie) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1044, '2021-10-08 17:46:37', 'Torrent 8 (Microsoft Windows 11 NL (21H2) x64 TPM Bypass) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1045, '2021-10-08 17:46:40', 'Torrent 8 (  FRIENDZONE (2021) 1080p NLSub) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1046, '2021-10-08 17:46:42', 'Torrent 8 (JUNGLE CRUISE (2021) 1080p Bluray NLSub) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1047, '2021-10-08 17:46:45', 'Torrent 8 (Bigfoot Familie 1+2) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1048, '2021-10-08 17:46:49', 'Torrent 8 (Dexter Alle 8 Seizoenen NLSub) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1049, '2021-10-08 17:46:52', 'Torrent 8 (Ccleaner - Altijd de laatste Versie) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1050, '2021-10-08 17:46:56', 'Torrent 8 (FileZilla Pro v3.55.1 (x64)) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1051, '2021-10-08 17:47:01', 'Torrent 8 (Astro Boy (2009) 1080p NL Gesproken) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1052, '2021-10-08 17:47:04', 'Torrent 8 (Avatar - The Last Airbender) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1053, '2021-10-08 17:47:07', 'Torrent 8 (Avatar - The Legend of Korra) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1054, '2021-10-08 17:47:10', 'Torrent 8 (Free Willy Compleet NL Gesproken) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1055, '2021-10-08 17:47:16', 'Torrent 8 (Dragon Ball Series Kid Goku) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1056, '2021-10-08 17:47:20', 'Torrent 8 (Dragon Ball Movies Complete) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1057, '2021-10-08 17:47:23', 'Torrent 8 (The Falcon and the Winter Soldier 1080p NLSub) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1058, '2021-10-08 17:47:25', 'Torrent 8 (Het Dappere Broodroostertje NL Gesproken) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1059, '2021-10-08 17:47:28', 'Torrent 8 (Penoza 5 Seizoenen Compleet NL Gesproken) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1060, '2021-10-08 17:47:30', 'Torrent 8 (Wonder Park (2019) 1080p NL Gesproken) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1061, '2021-10-08 17:47:33', 'Torrent 8 (Raya en de Laatste Draak 1080p NL Gesproken) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1062, '2021-10-08 17:47:35', 'Torrent 8 (Flikken Maastricht 14 Seizoenen) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1063, '2021-10-08 17:47:38', 'Torrent 8 (La Casa De Papel 5 Seizoenen NLSub) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1064, '2021-10-08 17:47:41', 'Torrent 8 (Flubber NL Gesproken) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1065, '2021-10-08 17:47:44', 'Torrent 8 (Marvel filmcollectie 25 films NLSub) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1066, '2021-10-08 17:47:47', 'Torrent 8 (The Good Doctor 4 Seizoenen  NLSub ) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1067, '2021-10-08 17:47:51', 'Torrent 8 (Luizenmoeder 2 seizoenen NL Gesproken) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1068, '2021-10-08 17:47:54', 'Torrent 8 (Kung Fu Panda NL Gesproken 3 DELEN) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1069, '2021-10-08 17:47:57', 'Torrent 8 (Loki Seizoen 1 en 6 Afleveringen NLSub) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1070, '2021-10-08 17:48:00', 'Torrent 8 (Mr. Peabody & Sherman NL Gesproken) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1071, '2021-10-08 17:48:03', 'Torrent 8 (How to train your dragon 3 delen!!) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1072, '2021-10-08 17:48:06', 'Torrent 8 (Onward  NL Gesproken) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1073, '2021-10-08 17:48:08', 'Torrent 8 (The Purge 1080p Seizoen 1 en 2 NLSub) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1074, '2021-10-08 17:48:11', 'Torrent 8 (Disney Box NL Gesproken) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1075, '2021-10-08 17:48:13', 'Torrent 8 (Winrar x64 Altijd de laatste Versie Unattended) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1076, '2021-10-08 17:48:16', 'Torrent 8 (YU-GI-OH Alle Seizoenen ENG Gesproken) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1077, '2021-10-08 17:48:19', 'Torrent 8 (Walking Dead 10 Seizoenen NLSub) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1078, '2021-10-08 17:48:21', 'Torrent 8 (Vet Hard (2005) 1080p NL Gesproken) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1079, '2021-10-08 17:48:23', 'Torrent 8 (Sonic The Hedgehog (2020) 1080p Nederlands Gesproken) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1080, '2021-10-08 17:48:25', 'Torrent 8 (Pokenmon 23 Seizoenen NL Gesproken) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1081, '2021-10-08 17:48:28', 'Torrent 8 (Trolls Wereldtour (2020) 1080p NL GESPROKEN) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1082, '2021-10-08 17:48:30', 'Torrent 8 (Soul (2020) 1080p NL Gesproken) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1083, '2021-10-08 17:48:33', 'Torrent 8 (Queenpins 2021 1080p AMZN WEB-DL DDP5.1 NLSub) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1084, '2021-10-08 17:48:36', 'Torrent 8 (Squid Game S01 1080p x265 10bit Atmos Multi Subs) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1085, '2021-10-08 17:48:38', 'Torrent 8 (New Amsterdam Compleet NLSub) is verwijderd door TorrentMedia, omdat dit een dode torrent was.'),
(1086, '2021-10-08 21:45:49', 'User account 232 (qYTLdKhXDS) was created'),
(1087, '2021-10-08 23:18:23', 'User account 233 (WDrmPBpo) was created'),
(1088, '2021-10-09 09:18:40', 'User account 234 (PmKBQFoZcjHg) was created'),
(1089, '2021-10-09 13:23:31', 'User account 235 (MmPfEDpB) was created'),
(1090, '2021-10-09 17:01:57', 'User account 236 (BPSeFgVDqXa) was created'),
(1091, '2021-10-10 02:32:44', 'User account 237 (zkovQwZabAG) was created'),
(1092, '2021-10-10 03:07:50', 'User account 238 (OfzKAkoJ) was created'),
(1093, '2021-10-10 05:52:49', 'User account 239 (MetFALPKw) was created'),
(1094, '2021-10-10 12:36:39', 'User account 240 (uXohJDRmsnc) was created'),
(1095, '2021-10-12 11:54:29', 'User account 241 (NTmBLCzq) was created'),
(1096, '2021-10-12 12:45:00', 'User account 242 (mcSAjQEgFde) was created'),
(1097, '2021-10-12 15:53:12', 'User account 243 (klQwmfeIJYK) was created'),
(1098, '2021-10-13 01:32:49', 'User account 244 (QFdrugCBU) was created'),
(1099, '2021-10-13 18:49:30', 'User account 245 (bQudfUXL) was created'),
(1100, '2021-10-14 01:32:07', 'User account 246 (BEhTIRNvo) was created'),
(1101, '2021-10-14 07:46:36', 'User account 247 (gAhKnjmMVea) was created'),
(1102, '2021-10-14 09:30:57', 'User account 248 (mnwWAexp) was created'),
(1103, '2021-10-14 17:57:04', 'User account 249 (LHQYqPpN) was created'),
(1104, '2021-10-15 08:27:12', 'User account 250 (xPhpVQvWkJNd) was created'),
(1105, '2021-10-15 15:05:31', 'User account 251 (sqOndUctPl) was created'),
(1106, '2021-10-15 19:11:04', 'User account 252 (hNqpjmQCxOG) was created'),
(1107, '2021-10-15 19:53:44', 'User account 253 (vfSwmMHFg) was created'),
(1108, '2021-10-15 20:51:42', 'User account 254 (TgDhkQBsxdU) was created'),
(1109, '2021-10-16 00:59:07', 'User account 255 (EorVnsLMTfI) was created'),
(1110, '2021-10-16 02:09:54', 'User account 256 (ymgOzGPto) was created'),
(1111, '2021-10-16 06:34:00', 'User account 257 (knVExCwhQ) was created'),
(1112, '2021-10-16 16:30:52', 'User account 258 (sAmEVSPFgYW) was created'),
(1113, '2021-10-17 00:27:02', 'User account 259 (byXdxoQJaYwF) was created'),
(1114, '2021-10-17 10:19:47', 'User account 260 (ZHhawzjlrke) was created'),
(1115, '2021-10-17 10:39:38', 'User account 261 (YAkOKSxcD) was created'),
(1116, '2021-10-17 13:03:16', 'User account 262 (cSIjZlqWkmty) was created'),
(1117, '2021-10-17 21:41:09', 'User account 263 (IODsbpPfCvB) was created'),
(1118, '2021-10-18 15:59:51', 'User account 264 (GRfvVnTYNhgM) was created'),
(1119, '2021-10-18 16:37:34', 'User account 265 (pyKSrDQY) was created'),
(1120, '2021-10-18 18:38:21', 'User account 266 (iOpMcfGH) was created'),
(1121, '2021-10-19 05:50:22', 'User account 267 (QrVNWCZhk) was created'),
(1122, '2021-10-19 06:19:33', 'User account 268 (PXTQpaWjYs) was created'),
(1123, '2021-10-19 11:23:34', 'User account 269 (YTZjNwkFBzHK) was created'),
(1124, '2021-10-19 12:43:25', 'User account 270 (SERrUTeJv) was created'),
(1125, '2021-10-19 15:40:28', 'User account 271 (NQzrlhXMZWfU) was created'),
(1126, '2021-10-20 03:53:29', 'User account 272 (TlgswHfIYCb) was created'),
(1127, '2021-10-20 07:46:26', 'User account 273 (cUrLTWBKfkZS) was created'),
(1128, '2021-10-20 13:58:39', 'User account 274 (luka1212) was created'),
(1129, '2021-10-20 15:26:00', 'User account 275 (luka121212) was created'),
(1130, '2021-10-20 15:40:35', 'User account 276 (luka1213) was created'),
(1131, '2021-10-20 18:33:41', 'User account 277 (qxLBrblADgf) was created'),
(1132, '2021-10-20 22:36:59', 'User account 278 (HERqXiFk) was created'),
(1133, '2021-10-21 06:15:58', 'User account 279 (rVbpCkgNYB) was created'),
(1134, '2021-10-21 06:21:27', 'User account 280 (cVafNUmp) was created'),
(1135, '2021-10-21 09:30:59', 'User account 281 (tRhgHMLn) was created'),
(1136, '2021-10-21 12:06:53', 'User account 282 (eECodSYUQ) was created'),
(1137, '2021-10-21 13:59:14', 'User account 283 (luka121312) was created'),
(1138, '2021-10-21 15:28:40', 'User account 284 (inZToVaIc) was created'),
(1139, '2021-10-21 23:52:27', 'User account 285 (xyJopKGnPMZi) was created'),
(1140, '2021-10-22 03:19:16', 'User account 286 (InjhiPHyED) was created'),
(1141, '2021-10-22 05:53:05', 'User account 287 (fYiRCoEaO) was created'),
(1142, '2021-10-22 15:39:30', 'User account 288 (DfHJypZstI) was created'),
(1143, '2021-10-23 02:09:19', 'User account 289 (VlcUTseY) was created'),
(1144, '2021-10-24 18:33:56', 'User account 290 (BgkEYFJnHyS) was created'),
(1145, '2021-10-28 00:08:39', 'User account 291 (iJDbGKSfMH) was created'),
(1146, '2021-11-02 10:47:55', 'User account 292 (ViMEGOrqyh) was created'),
(1147, '2021-11-03 18:11:14', 'User account 293 (drl) was created'),
(1148, '2021-11-03 23:13:31', 'User account 294 (XSrmcAxzLQik) was created'),
(1149, '2021-11-05 03:21:19', 'User account 295 (CmSapnkK) was created'),
(1150, '2021-11-07 00:10:34', 'User account 296 (KXByqLezRn) was created'),
(1151, '2021-11-13 09:27:53', 'User account 297 (chrlu01) was created'),
(1152, '2021-11-13 10:35:52', 'User account 298 (dijkrat) was created'),
(1153, '2021-11-13 13:38:34', 'User account 299 (Lieske) was created'),
(1154, '2021-11-13 17:07:56', 'User account 300 (onderdeel) was created'),
(1155, '2021-11-13 17:54:50', 'User account 301 (karpertje) was created'),
(1156, '2021-11-13 20:55:57', 'User account 302 (zoefdehaas) was created'),
(1157, '2021-11-14 01:54:22', 'User account 303 (bracco) was created'),
(1158, '2021-11-14 15:18:51', 'User account 304 (nathaliesch) was created'),
(1159, '2021-11-14 20:40:22', 'User account 305 (clown) was created'),
(1160, '2021-11-15 19:34:08', 'User account 306 (Mystica) was created'),
(1161, '2021-11-17 15:30:00', 'User account 307 (OpmawNKvLZ) was created'),
(1162, '2021-11-18 02:54:08', 'User account 308 (Derf48) was created'),
(1163, '2021-11-20 03:42:50', 'User account 309 (MyKAZDEuj) was created');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sitelogaccount`
--

CREATE TABLE `sitelogaccount` (
  `id` int(10) NOT NULL,
  `added` datetime DEFAULT '0000-00-00 00:00:00',
  `txt` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sitelogadmin`
--

CREATE TABLE `sitelogadmin` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` datetime DEFAULT NULL,
  `txt` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sitelogautoban`
--

CREATE TABLE `sitelogautoban` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` datetime DEFAULT NULL,
  `txt` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sitelogcheat`
--

CREATE TABLE `sitelogcheat` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` datetime DEFAULT NULL,
  `txt` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sitelogcontrole`
--

CREATE TABLE `sitelogcontrole` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` datetime DEFAULT NULL,
  `txt` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `siteloguseremail`
--

CREATE TABLE `siteloguseremail` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` datetime DEFAULT NULL,
  `txt` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `siteloguseremail`
--

INSERT INTO `siteloguseremail` (`id`, `added`, `txt`) VALUES
(1, '2021-06-16 21:02:05', 'Van TorrentMedia het e-mailadres gewijzigd in info@torrentmedia.nl door testaccount'),
(2, '2021-07-01 13:11:08', 'Van TM Admin het e-mailadres gewijzigd in info@torrentmedia.org door TorrentMedia'),
(3, '2021-07-01 13:11:38', 'Van Speedy het e-mailadres gewijzigd in admin@torrentmedia.org door TorrentMedia'),
(4, '2021-09-29 23:23:52', 'Van Mr Media het e-mailadres gewijzigd in mr.media@protonmail.ch door TorrentMedia'),
(5, '2021-09-29 23:24:16', 'Van Miro het e-mailadres gewijzigd in info@torrentmedia.org door TorrentMedia');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sitelogusername`
--

CREATE TABLE `sitelogusername` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` datetime DEFAULT NULL,
  `txt` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `sitelogusername`
--

INSERT INTO `sitelogusername` (`id`, `added`, `txt`) VALUES
(1, '2021-06-16 21:01:35', 'Gebruikersnaam MrFirst gewijzigd in TorrentMedia door testaccount'),
(2, '2021-06-18 13:33:37', 'Gebruikersnaam PCbakery gewijzigd in Speedy-G door TM Admin'),
(3, '2021-06-18 13:34:11', 'Gebruikersnaam Speedy-G gewijzigd in Speedy-M door TM Admin');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sitelogwarning`
--

CREATE TABLE `sitelogwarning` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` datetime DEFAULT NULL,
  `txt` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sitelog_login`
--

CREATE TABLE `sitelog_login` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` datetime DEFAULT NULL,
  `txt` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `sitelog_login`
--

INSERT INTO `sitelog_login` (`id`, `added`, `txt`) VALUES
(320, '2023-07-03 02:39:07', 'Have a member login with username TorrentMedia and IP 83.83.102.213'),
(321, '2023-07-03 02:39:39', 'Have a member login with username TorrentMedia and IP 83.83.102.213'),
(322, '2023-07-03 02:46:25', 'Have a member login with username TorrentMedia and IP 83.83.102.213'),
(323, '2023-07-03 02:51:35', 'Have a member login with username TorrentMedia and IP 83.83.102.213'),
(324, '2023-07-03 02:54:34', 'Have a member login with username TorrentMedia and IP 83.83.102.213'),
(325, '2023-07-03 02:59:41', 'Have a member login with username TorrentMedia and IP 83.83.102.213'),
(326, '2023-07-03 03:10:49', 'Have a member login with username TorrentMedia and IP 83.83.102.213'),
(327, '2023-07-03 03:12:04', 'Have a member login with username TorrentMedia and IP 83.83.102.213'),
(328, '2023-07-03 03:41:39', 'Have a member login with username ambre_leroux@mailrez.com and IP 156.146.63.138');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `site_acties`
--

CREATE TABLE `site_acties` (
  `id` int(10) NOT NULL,
  `message` text NOT NULL,
  `userid` int(10) NOT NULL,
  `actief` enum('ja','nee') NOT NULL DEFAULT 'nee',
  `ip` varchar(15) NOT NULL,
  `datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `var_data` enum('ja','nee') NOT NULL DEFAULT 'nee',
  `var_name` enum('ja','nee') NOT NULL DEFAULT 'nee'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `site_vars`
--

CREATE TABLE `site_vars` (
  `id` int(10) UNSIGNED NOT NULL,
  `var_name` varchar(255) NOT NULL DEFAULT '',
  `var_data` varchar(1500) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `site_vars`
--

INSERT INTO `site_vars` (`id`, `var_name`, `var_data`) VALUES
(1, 'service_text', ' Deze site is HACKED!!!'),
(2, 'service', 'nee'),
(3, 'promo_text', '&nbsp&nbsp&nbsp&nbsp Welkom op TorrentMedia.org &nbsp&nbsp&nbsp&nbsp | &nbsp&nbsp&nbsp&nbsp Wij werken met verzoekjes indien mogelijk worden deze binnen 24 uur voldaan &nbsp&nbsp&nbsp&nbsp | &nbsp&nbsp&nbsp&nbsp Genieten met TorrentMedia.org'),
(4, 'promo', 'nee'),
(9, 'autouploaders', 'uit'),
(5, 'autopending', 'uit'),
(7, 'autosystempm', 'uit'),
(13, 'autodelpm', 'uit'),
(11, 'autoinactive', 'uit'),
(14, 'autodelpm', 'uit'),
(15, 'autoHR', 'uit'),
(16, 'autocorrectie', 'aan'),
(18, 'autobaduser', 'uit');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `smsbalk`
--

CREATE TABLE `smsbalk` (
  `id` int(10) NOT NULL,
  `nummer` varchar(11) NOT NULL,
  `message` varchar(500) NOT NULL DEFAULT '',
  `smskey` varchar(20) NOT NULL,
  `userid` int(10) NOT NULL,
  `actief` enum('ja','nee') NOT NULL DEFAULT 'nee',
  `ip` varchar(15) NOT NULL,
  `datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `code` varchar(10) NOT NULL,
  `toegestaan` enum('ja','nee') NOT NULL DEFAULT 'ja',
  `aktie` enum('ja','nee') NOT NULL DEFAULT 'nee'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `stylesheets`
--

CREATE TABLE `stylesheets` (
  `id` int(10) UNSIGNED NOT NULL,
  `uri` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(64) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `teller`
--

CREATE TABLE `teller` (
  `datum` date NOT NULL,
  `ip` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `teller`
--

INSERT INTO `teller` (`datum`, `ip`) VALUES
('2021-04-30', '86.84.198.16'),
('2021-05-01', '86.84.198.16'),
('2021-05-01', '31.161.201.21'),
('2021-05-06', '86.84.198.16');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `thankyou`
--

CREATE TABLE `thankyou` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL DEFAULT 0,
  `torrent` varchar(255) NOT NULL DEFAULT '',
  `added` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `topics`
--

CREATE TABLE `topics` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `subject` varchar(40) DEFAULT NULL,
  `locked` enum('yes','no') NOT NULL DEFAULT 'no',
  `forumid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `lastpost` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sticky` enum('yes','no') NOT NULL DEFAULT 'no',
  `views` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `topics`
--

INSERT INTO `topics` (`id`, `userid`, `subject`, `locked`, `forumid`, `lastpost`, `sticky`, `views`) VALUES
(1, 3, 'test', 'no', 10, 1, 'no', 1),
(2, 3, 'test', 'no', 10, 2, 'yes', 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `torrents`
--

CREATE TABLE `torrents` (
  `id` int(10) UNSIGNED NOT NULL,
  `info_hash` varchar(20) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `filename` varchar(255) NOT NULL DEFAULT '',
  `save_as` varchar(255) NOT NULL DEFAULT '',
  `search_text` varchar(1500) NOT NULL DEFAULT '',
  `descr` varchar(10000) NOT NULL DEFAULT '',
  `imdb` varchar(250) NOT NULL DEFAULT '',
  `ori_descr` varchar(10000) NOT NULL DEFAULT '',
  `category` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `size` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` enum('single','multi') NOT NULL DEFAULT 'single',
  `numfiles` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `comments` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `views` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `times_completed` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `leechers` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `seeders` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `last_action` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `visible` enum('yes','no') NOT NULL DEFAULT 'yes',
  `banned` enum('yes','no') NOT NULL DEFAULT 'no',
  `owner` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `numratings` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `ratingsum` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `nfo` varchar(1000) NOT NULL DEFAULT '',
  `cover` varchar(255) NOT NULL DEFAULT '',
  `cover_by` varchar(255) NOT NULL DEFAULT '',
  `screen_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `screen` varchar(255) NOT NULL DEFAULT '',
  `freedlfsu` varchar(1000) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `uploadapp`
--

CREATE TABLE `uploadapp` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) NOT NULL DEFAULT 0,
  `applied` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `speed` varchar(20) NOT NULL DEFAULT '',
  `offer` longtext NOT NULL,
  `reason` longtext NOT NULL,
  `sites` enum('yes','no') NOT NULL DEFAULT 'no',
  `sitenames` varchar(150) NOT NULL DEFAULT '',
  `scene` enum('yes','no') NOT NULL DEFAULT 'no',
  `creating` enum('yes','no') NOT NULL DEFAULT 'no',
  `seeding` enum('yes','no') NOT NULL DEFAULT 'no',
  `connectable` enum('yes','no','pending') NOT NULL DEFAULT 'pending',
  `status` enum('accepted','rejected','pending') NOT NULL DEFAULT 'pending',
  `moderator` varchar(40) NOT NULL DEFAULT '',
  `comment` varchar(200) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `uploader_aanvraag`
--

CREATE TABLE `uploader_aanvraag` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `toegevoegd` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ervaring` enum('ja','nee') NOT NULL DEFAULT 'nee',
  `torrent_plaatsen` enum('ja','nee') NOT NULL DEFAULT 'nee',
  `dht` enum('ja','nee') NOT NULL DEFAULT 'nee',
  `uur` enum('ja','nee') NOT NULL DEFAULT 'nee',
  `upload_snelheid` varchar(12) NOT NULL DEFAULT '',
  `uploader` enum('ja','nee') NOT NULL DEFAULT 'nee',
  `uploader_sites` varchar(255) NOT NULL DEFAULT '',
  `staflid` enum('ja','nee') NOT NULL DEFAULT 'nee',
  `staflid_sites` varchar(255) NOT NULL DEFAULT '',
  `aantal_uploads` varchar(5) NOT NULL DEFAULT '',
  `upload_wat` varchar(255) NOT NULL DEFAULT '',
  `opmerking` varchar(255) NOT NULL DEFAULT '',
  `verwerkt` enum('ja','nee') NOT NULL DEFAULT 'nee',
  `verwerkt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `verwerkt_door` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `verwerkt_reden` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `uploader_aanvraag`
--

INSERT INTO `uploader_aanvraag` (`id`, `user_id`, `toegevoegd`, `ervaring`, `torrent_plaatsen`, `dht`, `uur`, `upload_snelheid`, `uploader`, `uploader_sites`, `staflid`, `staflid_sites`, `aantal_uploads`, `upload_wat`, `opmerking`, `verwerkt`, `verwerkt_datum`, `verwerkt_door`, `verwerkt_reden`) VALUES
(262, 20, '2021-07-02 10:02:44', 'ja', 'ja', 'ja', 'ja', '400000', 'nee', '', 'nee', '', '4', 'alles', 'nee', 'ja', '2021-07-02 10:04:46', 11, 'goedgekeurd'),
(263, 190, '2021-11-11 21:05:55', 'ja', 'ja', 'ja', 'ja', '100', 'nee', '', 'nee', '', '4', 'films zou ik graag willen uploaden ', '', 'nee', '0000-00-00 00:00:00', 0, '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `uploader_bonus`
--

CREATE TABLE `uploader_bonus` (
  `id` int(10) UNSIGNED NOT NULL,
  `torrent_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(40) NOT NULL DEFAULT '',
  `skype_name` varchar(40) NOT NULL DEFAULT '',
  `wickr_name` varchar(40) NOT NULL DEFAULT '',
  `old_password` varchar(40) NOT NULL DEFAULT '',
  `passhash` varchar(32) NOT NULL DEFAULT '',
  `passkey` varchar(32) NOT NULL DEFAULT '',
  `secret` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `email` varchar(80) NOT NULL DEFAULT '',
  `status` enum('pending','confirmed') NOT NULL DEFAULT 'pending',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_access` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_browse` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `editsecret` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `privacy` enum('strong','normal','low') NOT NULL DEFAULT 'normal',
  `stylesheet` int(10) DEFAULT 1,
  `info` text DEFAULT NULL,
  `blocked` enum('yes','no') NOT NULL DEFAULT 'no',
  `blocked_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `blocked_reason` varchar(255) NOT NULL DEFAULT '',
  `blocked_by` int(5) NOT NULL DEFAULT 0,
  `invites` smallint(4) NOT NULL DEFAULT 0,
  `invited_by` int(10) NOT NULL DEFAULT 0,
  `super_seeder` enum('yes','no') NOT NULL DEFAULT 'no',
  `credits` int(4) NOT NULL DEFAULT 0,
  `acceptpms` enum('yes','friends','no') NOT NULL DEFAULT 'yes',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `class` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `avatar` varchar(150) NOT NULL DEFAULT '',
  `uploaded` bigint(20) UNSIGNED NOT NULL DEFAULT 5368709120,
  `downloaded` bigint(20) UNSIGNED NOT NULL DEFAULT 1073741824,
  `title` varchar(30) NOT NULL DEFAULT '',
  `country` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `notifs` varchar(180) NOT NULL DEFAULT '[cat1][cat2][cat3][cat4][cat5][cat6][cat7][cat8][cat9][cat10][cat11][cat12][cat13][cat14][cat15][cat16][cat17][cat18][cat19][cat20][cat21][cat22][cat23][cat24]',
  `modcomment` varchar(15000) NOT NULL DEFAULT '',
  `enabled` enum('yes','no') NOT NULL DEFAULT 'yes',
  `avatars` enum('yes','no') NOT NULL DEFAULT 'yes',
  `donor` enum('yes','no') NOT NULL DEFAULT 'no',
  `warned` enum('yes','no') NOT NULL DEFAULT 'no',
  `warneduntil` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `torrentsperpage` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `topicsperpage` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `postsperpage` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `deletepms` enum('yes','no') NOT NULL DEFAULT 'yes',
  `savepms` enum('yes','no') NOT NULL DEFAULT 'no',
  `support` enum('yes','no') NOT NULL DEFAULT 'no',
  `betaald` enum('yes','no') NOT NULL DEFAULT 'no',
  `donor_until` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `warnedby` int(5) NOT NULL DEFAULT 0,
  `maxtorrents` int(6) NOT NULL DEFAULT 6,
  `vastmaxtor` enum('yes','no') NOT NULL DEFAULT 'no',
  `kliks` int(25) NOT NULL DEFAULT 0,
  `notifs_donor` varchar(255) NOT NULL DEFAULT '',
  `supportfor` varchar(255) NOT NULL DEFAULT '',
  `donorpm` enum('yes','no') NOT NULL DEFAULT 'no',
  `leechwarn` enum('yes','no') NOT NULL DEFAULT 'no',
  `leechwarnuntil` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `shout_access` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `latin1` tinyint(1) NOT NULL DEFAULT 0,
  `firstname` varchar(64) NOT NULL DEFAULT '',
  `lastname` varchar(64) NOT NULL DEFAULT '',
  `showemail` tinyint(1) NOT NULL DEFAULT 0,
  `perms` varchar(9) NOT NULL DEFAULT 'user',
  `rooms` varchar(128) NOT NULL DEFAULT '',
  `reg_time` int(11) NOT NULL DEFAULT 0,
  `gender` tinyint(1) NOT NULL DEFAULT 0,
  `bonus_punten` int(10) NOT NULL DEFAULT 200,
  `maxtorrents_extra` varchar(6) NOT NULL DEFAULT '0',
  `nzbsperpage` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `nzbretention` int(2) UNSIGNED NOT NULL DEFAULT 0,
  `nzbstodaydl` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `nzbunrestr` enum('yes','no') NOT NULL DEFAULT 'no',
  `last_nzbrowse` int(11) NOT NULL DEFAULT 0,
  `bedanktplaat` varchar(150) NOT NULL DEFAULT '',
  `seedblok` enum('yes','no') NOT NULL DEFAULT 'no',
  `shoutblok` enum('yes','no') NOT NULL DEFAULT 'no',
  `override_class` tinyint(3) UNSIGNED NOT NULL DEFAULT 255,
  `actieinfo` varchar(4000) NOT NULL DEFAULT '',
  `waarschuwing` enum('yes','no') NOT NULL DEFAULT 'no',
  `ratio` varchar(4000) NOT NULL DEFAULT '',
  `actieserver` varchar(4000) NOT NULL DEFAULT '',
  `actieadmin` varchar(4000) NOT NULL DEFAULT '',
  `actieuploader` varchar(1000) NOT NULL DEFAULT '',
  `actiemoderator` varchar(10) NOT NULL DEFAULT '"yes"',
  `doneer1` varchar(100) NOT NULL DEFAULT '',
  `doneer2` varchar(100) NOT NULL DEFAULT '',
  `doneer3` varchar(100) NOT NULL DEFAULT '',
  `XXX` varchar(100) NOT NULL DEFAULT '',
  `shoutbox` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `skype_name`, `wickr_name`, `old_password`, `passhash`, `passkey`, `secret`, `email`, `status`, `added`, `last_login`, `last_access`, `last_browse`, `editsecret`, `privacy`, `stylesheet`, `info`, `blocked`, `blocked_date`, `blocked_reason`, `blocked_by`, `invites`, `invited_by`, `super_seeder`, `credits`, `acceptpms`, `ip`, `class`, `avatar`, `uploaded`, `downloaded`, `title`, `country`, `notifs`, `modcomment`, `enabled`, `avatars`, `donor`, `warned`, `warneduntil`, `torrentsperpage`, `topicsperpage`, `postsperpage`, `deletepms`, `savepms`, `support`, `betaald`, `donor_until`, `warnedby`, `maxtorrents`, `vastmaxtor`, `kliks`, `notifs_donor`, `supportfor`, `donorpm`, `leechwarn`, `leechwarnuntil`, `shout_access`, `latin1`, `firstname`, `lastname`, `showemail`, `perms`, `rooms`, `reg_time`, `gender`, `bonus_punten`, `maxtorrents_extra`, `nzbsperpage`, `nzbretention`, `nzbstodaydl`, `nzbunrestr`, `last_nzbrowse`, `bedanktplaat`, `seedblok`, `shoutblok`, `override_class`, `actieinfo`, `waarschuwing`, `ratio`, `actieserver`, `actieadmin`, `actieuploader`, `actiemoderator`, `doneer1`, `doneer2`, `doneer3`, `XXX`, `shoutbox`) VALUES
(3, 'TorrentMedia', 'info@progoogle.nl', '', '', '48a02d4a1918a119ac976e257211316c', '', '5600BA1C24CB49B5D243F168D18AFCDBDB57B937', 'info@progoogle.nl', 'confirmed', '2021-04-18 10:42:02', '2023-07-03 03:50:50', '2023-07-03 03:50:50', '2023-07-03 03:33:25', '', 'normal', 1, '', 'no', '0000-00-00 00:00:00', '', 0, 0, 0, 'no', 1099, 'yes', '0.0.0.0', 255, '', 0, 0, '', 15, '[cat26][cat27][cat28][cat29][cat30][cat33][cat34][cat35][cat36][cat37][cat40][cat41][cat43][cat46]', '', 'yes', 'yes', 'yes', 'no', '0000-00-00 00:00:00', 0, 0, 0, 'no', 'yes', 'no', 'no', '2026-02-11 00:00:00', 0, 1000, 'no', 2215, '[cat26][cat27][cat28][cat29][cat30][cat33][cat34][cat35][cat36][cat37][cat40][cat41][cat43][cat46][cat26][cat27][cat28][cat29][cat30][cat33][cat34][cat35][cat36][cat37][cat40][cat41][cat43][cat46]', '', 'no', 'no', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', '', 0, 'user', '', 0, 0, 600, '0', 0, 0, 2, 'no', 1620916053, '', 'no', 'no', 255, 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', '', 'yes');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users_comment`
--

CREATE TABLE `users_comment` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `kind` varchar(20) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment` varchar(10000) NOT NULL DEFAULT '',
  `uploaded` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `downloaded` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `done_by` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users_credits`
--

CREATE TABLE `users_credits` (
  `id` int(11) NOT NULL,
  `user_id` int(8) NOT NULL DEFAULT 0,
  `descr` varchar(10000) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `users_credits`
--

INSERT INTO `users_credits` (`id`, `user_id`, `descr`, `added`) VALUES
(1, 1, 'Maand donateurschap tot 23 juni 2009 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 5.00 GB en na 12.50 GB.', '2009-05-23 16:31:49'),
(2, 3, 'Maand donateurschap tot 19 mei 2021 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 5.49 GB en na 12.99 GB.', '2021-04-19 16:15:49'),
(3, 3, 'Torrent ratio correctie voor torrent The Playah voor 1 punt. - Ratio was 0.00 en is nu 1.00.', '2021-05-03 17:18:14'),
(4, 3, 'Torrent ratio correctie voor torrent Alan Walker voor 1 punt. - Ratio was 0.00 en is nu 1.09.', '2021-05-03 17:18:15'),
(5, 3, 'Maand donateurschap tot 19 juni 2021 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 350.32 GB en na 357.82 GB.', '2021-05-13 12:57:04'),
(6, 3, 'RATIO CORRECTIE van 3.00 GB voor 1 punt - Totaal verzonden: voor = 357.82 GB en na 360.82 GB.', '2021-05-14 12:16:35'),
(7, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:33'),
(8, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:37'),
(9, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:39'),
(10, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:41'),
(11, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:42'),
(12, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:43'),
(13, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:46'),
(14, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:47'),
(15, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:48'),
(16, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:49'),
(17, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:50'),
(18, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:51'),
(19, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:53'),
(20, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:55'),
(21, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:56'),
(22, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:58'),
(23, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:58'),
(24, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:58'),
(25, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:58'),
(26, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:05:58'),
(27, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:00'),
(28, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:02'),
(29, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:04'),
(30, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:06'),
(31, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:09'),
(32, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:11'),
(33, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:12'),
(34, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:13'),
(35, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:14'),
(36, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:14'),
(37, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:15'),
(38, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:17'),
(39, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:18'),
(40, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:22'),
(41, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:24'),
(42, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:25'),
(43, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:26'),
(44, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:27'),
(45, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:30'),
(46, 8, '500 BP gekocht voor 4 kredietpunten.', '2021-06-17 01:06:31'),
(47, 8, 'Week donateurschap tot 24 juni 2021 voor 1 punt en een verhoging van  1.50 GB - Totaal verzonden: voor = 2,713.94 TB en na 2,713.94 TB.', '2021-06-17 11:29:11'),
(48, 8, 'RATIO CORRECTIE van 3.00 GB voor 1 punt - Totaal verzonden: voor = 2,713.94 TB en na 2,713.94 TB.', '2021-06-17 11:29:17'),
(49, 8, 'Maand donateurschap tot 24 juli 2021 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 2,713.94 TB en na 2,713.95 TB.', '2021-06-17 11:29:43'),
(50, 8, 'Maand donateurschap tot 24 augustus 2021 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 2,713.95 TB en na 2,713.95 TB.', '2021-06-17 11:29:45'),
(51, 8, 'Maand donateurschap tot 24 september 2021 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 2,713.95 TB en na 2,713.96 TB.', '2021-06-17 11:29:47'),
(52, 8, 'Maand donateurschap tot 24 oktober 2021 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 2,713.96 TB en na 2,713.97 TB.', '2021-06-17 11:29:48'),
(53, 8, 'Maand donateurschap tot 24 november 2021 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 2,713.97 TB en na 2,713.98 TB.', '2021-06-17 11:29:50'),
(54, 8, 'Maand donateurschap tot 24 december 2021 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 2,713.98 TB en na 2,713.98 TB.', '2021-06-17 11:29:53'),
(55, 8, 'Maand donateurschap tot 24 januari 2022 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 2,713.98 TB en na 2,713.99 TB.', '2021-06-17 11:29:55'),
(56, 8, '30 krediet weg gegeven aan testaccount.', '2021-06-17 11:35:18'),
(57, 8, 'Torrent ratio correctie voor torrent Dragonball z voor 1 punt. - Ratio was 0.00 en is nu 1.01.', '2021-06-18 00:13:02'),
(58, 8, 'Torrent ratio correctie voor torrent 100 Jaar Disney NL GESPROKEN voor 1 punt. - Ratio was 0.00 en is nu 1.09.', '2021-06-18 00:13:35'),
(59, 8, 'RATIO CORRECTIE van 3.00 GB voor 1 punt - Totaal verzonden: voor = 16,879.41 TB en na 16,879.41 TB.', '2021-06-18 12:12:26'),
(60, 3, 'RATIO CORRECTIE van 3.00 GB voor 1 punt - Totaal verzonden: voor = 361.07 GB en na 364.07 GB.', '2021-06-18 12:40:33'),
(61, 8, 'RATIO CORRECTIE van 3.00 GB voor 1 punt - Totaal verzonden: voor = 16,879.41 TB en na 16,879.42 TB.', '2021-06-18 13:19:05'),
(62, 8, 'RATIO CORRECTIE van 3.00 GB voor 1 punt - Totaal verzonden: voor = 16,879.42 TB en na 16,879.42 TB.', '2021-06-18 13:19:11'),
(63, 8, '500 krediet weg gegeven aan PCbakery.', '2021-06-18 13:20:37'),
(64, 8, '500 krediet weg gegeven aan PCbakery.', '2021-06-18 13:26:41'),
(65, 8, '500 krediet weg gegeven aan PCbakery.', '2021-06-18 13:26:54'),
(66, 8, '500 krediet weg gegeven aan PCbakery.', '2021-06-18 13:27:00'),
(67, 8, '500 krediet weg gegeven aan PCbakery.', '2021-06-18 13:27:06'),
(68, 10, 'Maand donateurschap tot 3 juni 2040 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 70.31 TB en na 70.32 TB.', '2021-06-18 14:27:33'),
(69, 8, '500 krediet weg gegeven aan Speedy.', '2021-06-19 00:35:50'),
(70, 8, '500 krediet weg gegeven aan Speedy.', '2021-06-19 00:35:56'),
(71, 8, '500 krediet weg gegeven aan Speedy.', '2021-06-19 00:36:02'),
(72, 8, '500 krediet weg gegeven aan Speedy.', '2021-06-19 00:36:09'),
(73, 11, 'Maand donateurschap tot 6 juni 2040 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 30.00 GB en na 37.50 GB.', '2021-06-19 00:37:43'),
(74, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 37.50 GB en na 52.50 GB.', '2021-06-19 00:37:58'),
(75, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 52.50 GB en na 67.50 GB.', '2021-06-19 00:38:03'),
(76, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 67.50 GB en na 82.50 GB.', '2021-06-19 00:38:05'),
(77, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 82.50 GB en na 97.50 GB.', '2021-06-19 00:38:07'),
(78, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 97.50 GB en na 112.50 GB.', '2021-06-19 00:38:10'),
(79, 11, 'Maand donateurschap tot 6 juli 2040 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 112.50 GB en na 120.00 GB.', '2021-06-19 00:38:12'),
(80, 11, 'Maand donateurschap tot 6 augustus 2040 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 120.00 GB en na 127.50 GB.', '2021-06-19 00:38:13'),
(81, 11, 'Maand donateurschap tot 6 september 2040 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 127.50 GB en na 135.00 GB.', '2021-06-19 00:38:13'),
(82, 11, 'Maand donateurschap tot 6 oktober 2040 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 135.00 GB en na 142.50 GB.', '2021-06-19 00:38:13'),
(83, 11, 'Maand donateurschap tot 6 november 2040 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 142.50 GB en na 150.00 GB.', '2021-06-19 00:38:13'),
(84, 11, 'Maand donateurschap tot 6 december 2040 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 150.00 GB en na 157.50 GB.', '2021-06-19 00:38:13'),
(85, 11, 'Maand donateurschap tot 6 januari 2041 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 157.50 GB en na 165.00 GB.', '2021-06-19 00:38:13'),
(86, 11, 'Maand donateurschap tot 6 februari 2041 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 165.00 GB en na 172.50 GB.', '2021-06-19 00:38:13'),
(87, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 172.50 GB en na 187.50 GB.', '2021-06-19 00:38:17'),
(88, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 187.50 GB en na 202.50 GB.', '2021-06-19 00:38:17'),
(89, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 202.50 GB en na 217.50 GB.', '2021-06-19 00:38:17'),
(90, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 217.50 GB en na 232.50 GB.', '2021-06-19 00:38:17'),
(91, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 232.50 GB en na 247.50 GB.', '2021-06-19 00:38:20'),
(92, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 247.50 GB en na 262.50 GB.', '2021-06-19 00:38:20'),
(93, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 262.50 GB en na 277.50 GB.', '2021-06-19 00:38:20'),
(94, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 277.50 GB en na 292.50 GB.', '2021-06-19 00:38:23'),
(95, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 292.50 GB en na 307.50 GB.', '2021-06-19 00:38:23'),
(96, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 307.50 GB en na 322.50 GB.', '2021-06-19 00:38:23'),
(97, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 322.50 GB en na 337.50 GB.', '2021-06-19 00:38:23'),
(98, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 337.50 GB en na 352.50 GB.', '2021-06-19 00:38:27'),
(99, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 352.50 GB en na 367.50 GB.', '2021-06-19 00:38:27'),
(100, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 367.50 GB en na 382.50 GB.', '2021-06-19 00:38:27'),
(101, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 382.50 GB en na 397.50 GB.', '2021-06-19 00:38:27'),
(102, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 397.50 GB en na 412.50 GB.', '2021-06-19 00:38:28'),
(103, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 412.50 GB en na 427.50 GB.', '2021-06-19 00:38:28'),
(104, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 427.50 GB en na 442.50 GB.', '2021-06-19 00:38:29'),
(105, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 442.50 GB en na 457.50 GB.', '2021-06-19 00:38:36'),
(106, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 457.50 GB en na 472.50 GB.', '2021-06-19 00:38:36'),
(107, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 472.50 GB en na 487.50 GB.', '2021-06-19 00:38:36'),
(108, 11, 'Maand donateurschap tot 6 maart 2041 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 487.50 GB en na 495.00 GB.', '2021-06-19 00:38:39'),
(109, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 495.00 GB en na 510.00 GB.', '2021-06-19 00:38:43'),
(110, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 510.00 GB en na 525.00 GB.', '2021-06-19 00:38:43'),
(111, 11, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 525.00 GB en na 540.00 GB.', '2021-06-19 00:38:46'),
(112, 8, '500 krediet weg gegeven aan Speedy.', '2021-06-19 00:51:15'),
(113, 8, '500 krediet weg gegeven aan Speedy.', '2021-06-19 00:51:22'),
(114, 8, '500 krediet weg gegeven aan Speedy.', '2021-06-19 00:51:29'),
(115, 8, '500 krediet weg gegeven aan Speedy.', '2021-06-19 00:51:36'),
(116, 3, 'Een extra torrent slot ontvangen voor 2 punten', '2021-06-19 02:08:46'),
(117, 3, 'Een extra torrent slot ontvangen voor 2 punten', '2021-06-19 02:08:56'),
(118, 3, 'Een extra torrent slot ontvangen voor 2 punten', '2021-06-19 02:10:54'),
(119, 3, 'Extra torrent slot voor 2 punten', '2021-06-19 19:56:24'),
(120, 3, 'Extra torrent slot voor 2 punten', '2021-06-19 19:56:29'),
(121, 8, 'Torrent ratio correctie voor torrent Kluun - Help ik heb mijn vrouw zwanger gemaakt voor 1 punt. - Ratio was 0.00 en is nu 1.07.', '2021-06-20 01:17:56'),
(122, 8, 'Extra torrent slot voor 2 punten', '2021-06-20 01:18:32'),
(123, 8, 'Extra torrent slot voor 2 punten', '2021-06-20 01:18:47'),
(124, 8, 'Torrent ratio correctie voor torrent Spetters NL gesproken voor 1 punt. - Ratio was 0.00 en is nu 1.07.', '2021-06-20 20:47:47'),
(125, 3, 'Extra torrent slot voor 2 punten', '2021-06-24 02:36:06'),
(126, 3, 'RATIO CORRECTIE van 3.00 GB voor 1 punt - Totaal verzonden: voor = 1.34 TB en na 1.34 TB.', '2021-06-24 02:36:21'),
(127, 3, 'Week donateurschap tot 7 oktober 2025 voor 1 punt en een verhoging van  1.50 GB - Totaal verzonden: voor = 1.34 TB en na 1.34 TB.', '2021-06-24 02:36:32'),
(128, 3, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 1.34 TB en na 1.35 TB.', '2021-06-24 02:36:38'),
(129, 3, 'Maand donateurschap tot 7 november 2025 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 1.35 TB en na 1.36 TB.', '2021-06-24 02:36:46'),
(130, 13, 'Torrent ratio correctie voor torrent WinRAR 6.02 FINAL NEDERLANDS x32/x64 voor 1 punt. - Ratio was 0.00 en is nu 1.08.', '2021-06-24 15:00:25'),
(131, 13, 'Week donateurschap tot 6 juni 2025 voor 1 punt en een verhoging van  1.50 GB - Totaal verzonden: voor = 58.59 TB en na 58.60 TB.', '2021-06-24 15:00:33'),
(132, 14, 'Week donateurschap tot 12 mei 2023 en een verhoging van  1.50 GB - Totaal verzonden: voor = 0.98 TB en na 0.98 TB.', '2021-06-24 22:25:44'),
(133, 11, 'Extra torrent slot voor 2 punten', '2021-06-24 23:28:54'),
(134, 11, 'Extra torrent slot voor 2 punten', '2021-06-24 23:29:04'),
(135, 8, 'Torrent ratio correctie voor torrent Django Unchained 1080p 5.1 NL Sub voor 1 punt. - Ratio was 0.00 en is nu 1.07.', '2021-06-25 08:47:39'),
(136, 3, 'RATIO CORRECTIE van 3.00 GB voor 1 punt - Totaal verzonden: voor = 1.36 TB en na 1.36 TB.', '2021-06-26 00:36:37'),
(137, 3, 'RATIO CORRECTIE van 3.00 GB voor 1 punt - Totaal verzonden: voor = 1.36 TB en na 1.37 TB.', '2021-06-26 00:36:39'),
(138, 3, 'RATIO CORRECTIE van 3.00 GB voor 1 punt - Totaal verzonden: voor = 1.37 TB en na 1.37 TB.', '2021-06-26 00:36:40'),
(139, 3, 'Week donateurschap tot 14 november 2025 voor 1 punt en een verhoging van  1.50 GB - Totaal verzonden: voor = 1.37 TB en na 1.37 TB.', '2021-06-26 00:36:42'),
(140, 3, 'Week donateurschap tot 21 november 2025 voor 1 punt en een verhoging van  1.50 GB - Totaal verzonden: voor = 1.37 TB en na 1.37 TB.', '2021-06-26 00:36:52'),
(141, 3, 'Maand donateurschap tot 21 december 2025 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 1.37 TB en na 1.38 TB.', '2021-06-26 00:36:56'),
(142, 3, 'Extra torrent slot voor 2 punten', '2021-06-26 00:37:01'),
(143, 3, 'Extra torrent slot voor 2 punten', '2021-06-26 00:37:05'),
(144, 3, '5 krediet weg gegeven aan TorrentMedia.', '2021-06-30 18:03:12'),
(145, 3, '5 krediet weg gegeven aan TorrentMedia.', '2021-06-30 18:03:34'),
(146, 3, 'Extra torrent slot voor 2 punten', '2021-07-01 02:52:29'),
(147, 11, 'RATIO CORRECTIE van 3.00 GB - Totaal verzonden: voor = 97.66 TB en na 97.66 TB.', '2021-07-01 13:23:50'),
(148, 3, 'RATIO CORRECTIE van 3.00 GB voor 1 punt - Totaal verzonden: voor = 1.38 TB en na 1.38 TB.', '2021-07-01 15:18:25'),
(149, 3, 'Week donateurschap tot 4 januari 2026 voor 1 punt en een verhoging van  1.50 GB - Totaal verzonden: voor = 1.38 TB en na 1.38 TB.', '2021-07-01 15:18:28'),
(150, 3, 'RATIO CORRECTIE van 15.00 GB voor 4 punten - Totaal verzonden: voor = 1.38 TB en na 1.40 TB.', '2021-07-01 15:18:30'),
(151, 3, 'Maand donateurschap tot 4 februari 2026 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 1.40 TB en na 1.41 TB.', '2021-07-01 15:18:32'),
(152, 3, 'Extra torrent slot voor 2 punten', '2021-07-01 15:18:35'),
(153, 3, '5 krediet weg gegeven aan Speedy.', '2021-07-01 15:18:46'),
(154, 8, 'Extra torrent slot voor 2 punten', '2021-07-03 11:16:26'),
(155, 3, 'Week donateurschap tot 11 februari 2026 voor 1 punt en een verhoging van  1.50 GB - Totaal verzonden: voor = 1.41 TB en na 1.41 TB.', '2021-07-04 18:57:54'),
(156, 11, 'Maand donateurschap tot 6 april 2041 voor 4 punten en een verhoging van  7.50 GB - Totaal verzonden: voor = 97.66 TB en na 97.67 TB.', '2021-07-20 22:27:23'),
(157, 3, 'RATIO CORRECTIE van 3.00 GB - Totaal verzonden: voor = 97.66 TB en na 97.66 TB.', '2021-11-17 04:28:38');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_ip`
--

CREATE TABLE `user_ip` (
  `ip` char(15) NOT NULL DEFAULT '',
  `userid` int(11) NOT NULL DEFAULT 0,
  `last_seen` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id` int(11) NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `user_ip`
--

INSERT INTO `user_ip` (`ip`, `userid`, `last_seen`, `id`, `added`) VALUES
('86.84.198.16', 3, '2021-05-14 17:01:19', 1, '2021-04-18 10:42:05'),
('145.133.22.26', 6, '2021-04-18 12:29:28', 4, '2021-04-18 12:28:40'),
('109.38.139.74', 3, '2021-06-17 21:21:28', 27, '2021-06-17 20:42:07'),
('84.107.127.72', 3, '2021-08-27 01:52:46', 25, '2021-06-17 12:14:56'),
('31.161.202.14', 3, '2021-05-07 17:00:04', 20, '2021-05-07 16:59:59'),
('31.161.200.144', 3, '2021-05-09 19:16:26', 21, '2021-05-09 16:00:26'),
('255.22.71.67', 3, '2021-07-27 04:07:57', 40, '2021-06-19 19:52:29'),
('252.237.208.146', 3, '2021-06-22 08:01:23', 44, '2021-06-22 08:01:23'),
('109.38.142.219', 3, '2021-06-24 06:43:30', 48, '2021-06-24 06:43:30'),
('249.110.6.73', 105, '2021-07-27 12:27:09', 113, '2021-07-27 02:27:26'),
('125.212.158.158', 15, '2021-06-26 04:06:21', 55, '2021-06-26 04:06:21'),
('125.212.158.122', 17, '2021-07-01 14:31:18', 60, '2021-07-01 15:55:59'),
('247.184.42.73', 21, '2021-07-02 09:30:55', 73, '2021-07-02 11:29:48'),
('109.38.132.182', 3, '2021-07-03 01:56:43', 78, '2021-07-03 03:56:21'),
('109.38.132.186', 3, '2021-07-03 17:27:48', 80, '2021-07-03 17:27:43'),
('125.212.158.92', 3, '2021-07-06 06:02:17', 81, '2021-07-03 17:29:40'),
('109.38.128.236', 3, '2021-07-08 16:28:57', 89, '2021-07-08 16:21:30'),
('250.253.204.1', 3, '2021-07-07 18:01:45', 84, '2021-07-04 16:19:08'),
('125.235.61.171', 3, '2021-07-06 05:34:24', 87, '2021-07-06 05:11:36'),
('125.212.158.77', 3, '2021-07-10 02:15:44', 88, '2021-07-06 09:01:22'),
('125.212.159.101', 3, '2021-07-13 02:33:24', 95, '2021-07-12 05:18:36'),
('125.212.159.176', 3, '2021-07-16 12:20:53', 98, '2021-07-14 09:33:08'),
('125.212.158.62', 3, '2021-07-21 09:58:24', 104, '2021-07-21 05:37:43'),
('95.211.235.7', 3, '2021-07-21 06:30:26', 106, '2021-07-21 06:07:03'),
('125.212.158.69', 3, '2021-09-10 11:45:50', 126, '2021-09-10 10:33:58'),
('185.132.132.136', 3, '2021-08-02 16:11:43', 118, '2021-08-02 15:56:22'),
('89.187.174.239', 207, '2021-10-06 08:33:03', 287, '2021-10-06 10:28:11'),
('84.106.3.83', 3, '2021-11-27 21:12:44', 124, '2021-08-30 05:29:21'),
('125.212.158.30', 3, '2021-09-11 04:16:43', 127, '2021-09-11 04:16:34'),
('125.212.159.76', 3, '2021-09-11 05:14:52', 128, '2021-09-11 05:09:39'),
('125.212.158.211', 3, '2021-09-14 14:45:00', 129, '2021-09-13 16:44:43'),
('37.48.74.19', 3, '2021-09-29 14:10:11', 197, '2021-09-29 19:07:16'),
('37.48.74.19', 156, '2021-09-29 13:26:18', 198, '2021-09-29 19:25:11'),
('127.0.0.1', 3, '2021-11-30 18:54:45', 305, '2021-11-30 18:52:16'),
('51.195.107.236', 3, '2021-11-28 00:47:32', 304, '2021-11-28 00:47:32'),
('195.78.54.239', 305, '2021-11-23 10:41:02', 303, '2021-11-23 10:39:02'),
('84.193.87.230', 190, '2021-11-26 19:19:44', 302, '2021-11-19 20:39:09'),
('45.141.154.30', 207, '2021-11-16 11:35:11', 301, '2021-11-16 11:34:28'),
('143.244.41.190', 3, '2021-11-14 23:45:27', 299, '2021-11-14 23:27:54'),
('83.149.92.238', 302, '2021-11-15 20:02:29', 300, '2021-11-15 19:56:53'),
('143.244.41.190', 302, '2021-11-15 19:45:35', 297, '2021-11-14 23:25:14'),
('163.158.56.71', 300, '2021-11-25 23:08:53', 296, '2021-11-13 23:11:59'),
('87.64.56.255', 190, '2021-10-19 17:54:23', 295, '2021-10-19 17:54:23'),
('84.193.87.230', 3, '2021-11-11 21:04:47', 294, '2021-10-15 20:43:51'),
('89.46.223.105', 207, '2021-10-11 09:21:00', 293, '2021-10-11 11:19:34'),
('83.83.102.213', 3, '2023-07-03 03:50:50', 306, '2023-07-03 03:33:25');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `verwacht`
--

CREATE TABLE `verwacht` (
  `id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL DEFAULT 0,
  `naam` varchar(255) NOT NULL DEFAULT '',
  `omschrijving` varchar(255) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cat` int(11) NOT NULL DEFAULT 0,
  `tijd` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `verwacht_id` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `verwacht_bericht`
--

CREATE TABLE `verwacht_bericht` (
  `id` int(11) NOT NULL,
  `verwacht_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `verzoekjes`
--

CREATE TABLE `verzoekjes` (
  `id` int(10) UNSIGNED NOT NULL,
  `requestid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `added_by` int(10) NOT NULL DEFAULT 0,
  `added_date` date NOT NULL DEFAULT '0000-00-00',
  `omschrijving` varchar(255) NOT NULL DEFAULT '',
  `categorie` int(10) NOT NULL DEFAULT 0,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `edit_by` int(10) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `verzoekjes_stemmen`
--

CREATE TABLE `verzoekjes_stemmen` (
  `verzoek_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `warnings`
--

CREATE TABLE `warnings` (
  `id` int(8) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `userid` int(11) NOT NULL DEFAULT 0,
  `warned_by` int(11) NOT NULL DEFAULT 0,
  `uploaded` int(20) NOT NULL DEFAULT 0,
  `downloaded` int(20) NOT NULL DEFAULT 0,
  `warned_for` varchar(255) NOT NULL DEFAULT '',
  `warned_time` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `warn_pm_gb`
--

CREATE TABLE `warn_pm_gb` (
  `id` int(8) NOT NULL,
  `added` int(11) NOT NULL DEFAULT 0,
  `sender` int(8) NOT NULL DEFAULT 0,
  `receiver` int(8) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `warn_pm_gb_last`
--

CREATE TABLE `warn_pm_gb_last` (
  `id` int(8) NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sender` int(8) NOT NULL DEFAULT 0,
  `receiver` int(8) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `warn_pm_seeding`
--

CREATE TABLE `warn_pm_seeding` (
  `id` int(8) NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sender` int(8) NOT NULL DEFAULT 0,
  `receiver` int(8) NOT NULL DEFAULT 0,
  `torrent` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `warn_pm_torrent`
--

CREATE TABLE `warn_pm_torrent` (
  `id` int(8) NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sender` int(8) NOT NULL DEFAULT 0,
  `receiver` int(8) NOT NULL DEFAULT 0,
  `torrent` int(10) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `aa_results`
--
ALTER TABLE `aa_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip` (`ip`);

--
-- Indexen voor tabel `addedrequests`
--
ALTER TABLE `addedrequests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `requestid_userid` (`requestid`,`userid`);

--
-- Indexen voor tabel `aktie`
--
ALTER TABLE `aktie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `datum` (`datum`);

--
-- Indexen voor tabel `aktie_donatie`
--
ALTER TABLE `aktie_donatie`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `antidos_logs`
--
ALTER TABLE `antidos_logs`
  ADD UNIQUE KEY `ip` (`ip`);

--
-- Indexen voor tabel `auto_warning`
--
ALTER TABLE `auto_warning`
  ADD PRIMARY KEY (`userid`);

--
-- Indexen voor tabel `avps`
--
ALTER TABLE `avps`
  ADD PRIMARY KEY (`arg`);

--
-- Indexen voor tabel `banned_agent`
--
ALTER TABLE `banned_agent`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `first_last` (`first`,`last`);

--
-- Indexen voor tabel `bans_special`
--
ALTER TABLE `bans_special`
  ADD PRIMARY KEY (`id`),
  ADD KEY `first_last` (`first`,`last`);

--
-- Indexen voor tabel `berichten`
--
ALTER TABLE `berichten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `to` (`receiver`);

--
-- Indexen voor tabel `berichten_box`
--
ALTER TABLE `berichten_box`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `berichten_sjabloon`
--
ALTER TABLE `berichten_sjabloon`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `berichten_subject`
--
ALTER TABLE `berichten_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userfriend` (`userid`,`blockid`);

--
-- Indexen voor tabel `bonus_punten`
--
ALTER TABLE `bonus_punten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `torrent_id` (`torrent_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `added` (`added`);

--
-- Indexen voor tabel `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `torrent` (`torrent`);

--
-- Indexen voor tabel `comments_uploader`
--
ALTER TABLE `comments_uploader`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `torrent` (`torrent`);

--
-- Indexen voor tabel `counter_casino`
--
ALTER TABLE `counter_casino`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `credits`
--
ALTER TABLE `credits`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `def_messages`
--
ALTER TABLE `def_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `dlfsuinstelingen`
--
ALTER TABLE `dlfsuinstelingen`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `donatieoverzicht`
--
ALTER TABLE `donatieoverzicht`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `donatie_ideal`
--
ALTER TABLE `donatie_ideal`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `donatie_ideal_claim_msg`
--
ALTER TABLE `donatie_ideal_claim_msg`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `donatie_ideal_del`
--
ALTER TABLE `donatie_ideal_del`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `donatie_sms`
--
ALTER TABLE `donatie_sms`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `donatie_sms_claim_msg`
--
ALTER TABLE `donatie_sms_claim_msg`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `donatie_sms_del`
--
ALTER TABLE `donatie_sms_del`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `donatie_telefoon`
--
ALTER TABLE `donatie_telefoon`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `donatie_telefoon_claim_msg`
--
ALTER TABLE `donatie_telefoon_claim_msg`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `donatie_telefoon_del`
--
ALTER TABLE `donatie_telefoon_del`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `donatie_users`
--
ALTER TABLE `donatie_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `donations_claim`
--
ALTER TABLE `donations_claim`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `donations_claim_del`
--
ALTER TABLE `donations_claim_del`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `donations_claim_msg`
--
ALTER TABLE `donations_claim_msg`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `donations_lotery`
--
ALTER TABLE `donations_lotery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `done` (`done`);

--
-- Indexen voor tabel `donations_message`
--
ALTER TABLE `donations_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tijd` (`tijd`);

--
-- Indexen voor tabel `donations_registratie`
--
ALTER TABLE `donations_registratie`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `donations_users`
--
ALTER TABLE `donations_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pincode` (`pincode`);

--
-- Indexen voor tabel `doss_logboek`
--
ALTER TABLE `doss_logboek`
  ADD KEY `ipnummer` (`ipnummer`);

--
-- Indexen voor tabel `downloaded`
--
ALTER TABLE `downloaded`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `downtotals`
--
ALTER TABLE `downtotals`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `downup`
--
ALTER TABLE `downup`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `dox`
--
ALTER TABLE `dox`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver` (`volgorde`);

--
-- Indexen voor tabel `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `torrent` (`torrent`);

--
-- Indexen voor tabel `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userfriend` (`userid`,`friendid`);

--
-- Indexen voor tabel `giro`
--
ALTER TABLE `giro`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `helpdesk`
--
ALTER TABLE `helpdesk`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexen voor tabel `hesk_attachments`
--
ALTER TABLE `hesk_attachments`
  ADD PRIMARY KEY (`att_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indexen voor tabel `hesk_banned_emails`
--
ALTER TABLE `hesk_banned_emails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indexen voor tabel `hesk_banned_ips`
--
ALTER TABLE `hesk_banned_ips`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `hesk_categories`
--
ALTER TABLE `hesk_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Indexen voor tabel `hesk_custom_fields`
--
ALTER TABLE `hesk_custom_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `useType` (`use`,`type`);

--
-- Indexen voor tabel `hesk_custom_statuses`
--
ALTER TABLE `hesk_custom_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `hesk_kb_articles`
--
ALTER TABLE `hesk_kb_articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `catid` (`catid`),
  ADD KEY `sticky` (`sticky`),
  ADD KEY `type` (`type`);
ALTER TABLE `hesk_kb_articles` ADD FULLTEXT KEY `subject` (`subject`,`content`,`keywords`);

--
-- Indexen voor tabel `hesk_kb_attachments`
--
ALTER TABLE `hesk_kb_attachments`
  ADD PRIMARY KEY (`att_id`);

--
-- Indexen voor tabel `hesk_kb_categories`
--
ALTER TABLE `hesk_kb_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `parent` (`parent`);

--
-- Indexen voor tabel `hesk_logins`
--
ALTER TABLE `hesk_logins`
  ADD UNIQUE KEY `ip` (`ip`);

--
-- Indexen voor tabel `hesk_log_overdue`
--
ALTER TABLE `hesk_log_overdue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket` (`ticket`),
  ADD KEY `category` (`category`),
  ADD KEY `priority` (`priority`),
  ADD KEY `status` (`status`),
  ADD KEY `owner` (`owner`);

--
-- Indexen voor tabel `hesk_mail`
--
ALTER TABLE `hesk_mail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from` (`from`),
  ADD KEY `to` (`to`,`read`,`deletedby`);

--
-- Indexen voor tabel `hesk_notes`
--
ALTER TABLE `hesk_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticketid` (`ticket`);

--
-- Indexen voor tabel `hesk_online`
--
ALTER TABLE `hesk_online`
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `dt` (`dt`);

--
-- Indexen voor tabel `hesk_pipe_loops`
--
ALTER TABLE `hesk_pipe_loops`
  ADD KEY `email` (`email`,`hits`);

--
-- Indexen voor tabel `hesk_replies`
--
ALTER TABLE `hesk_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `replyto` (`replyto`),
  ADD KEY `dt` (`dt`),
  ADD KEY `staffid` (`staffid`);

--
-- Indexen voor tabel `hesk_reply_drafts`
--
ALTER TABLE `hesk_reply_drafts`
  ADD KEY `owner` (`owner`),
  ADD KEY `ticket` (`ticket`);

--
-- Indexen voor tabel `hesk_reset_password`
--
ALTER TABLE `hesk_reset_password`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Indexen voor tabel `hesk_service_messages`
--
ALTER TABLE `hesk_service_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Indexen voor tabel `hesk_std_replies`
--
ALTER TABLE `hesk_std_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `hesk_tickets`
--
ALTER TABLE `hesk_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trackid` (`trackid`),
  ADD KEY `archive` (`archive`),
  ADD KEY `categories` (`category`),
  ADD KEY `statuses` (`status`),
  ADD KEY `owner` (`owner`),
  ADD KEY `openedby` (`openedby`,`firstreplyby`,`closedby`),
  ADD KEY `dt` (`dt`);

--
-- Indexen voor tabel `hesk_ticket_templates`
--
ALTER TABLE `hesk_ticket_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `hesk_users`
--
ALTER TABLE `hesk_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autoassign` (`autoassign`);

--
-- Indexen voor tabel `hits`
--
ALTER TABLE `hits`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `infolog`
--
ALTER TABLE `infolog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `datetime` (`datum`);

--
-- Indexen voor tabel `ip`
--
ALTER TABLE `ip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ips` (`ip`);

--
-- Indexen voor tabel `ip_logboek`
--
ALTER TABLE `ip_logboek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added` (`added`);

--
-- Indexen voor tabel `kijkwijzer`
--
ALTER TABLE `kijkwijzer`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `link_forum`
--
ALTER TABLE `link_forum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added` (`added`);

--
-- Indexen voor tabel `loginmessages`
--
ALTER TABLE `loginmessages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver` (`receiver`);

--
-- Indexen voor tabel `loterij`
--
ALTER TABLE `loterij`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexen voor tabel `massa_berichten`
--
ALTER TABLE `massa_berichten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver` (`aantal`),
  ADD KEY `sender` (`sender`),
  ADD KEY `added` (`added`);

--
-- Indexen voor tabel `massa_bericht_mods`
--
ALTER TABLE `massa_bericht_mods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver` (`aantal`),
  ADD KEY `sender` (`sender`),
  ADD KEY `added` (`added`);

--
-- Indexen voor tabel `massa_bericht_torrents`
--
ALTER TABLE `massa_bericht_torrents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver` (`aantal`),
  ADD KEY `sender` (`sender`),
  ADD KEY `added` (`added`);

--
-- Indexen voor tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver` (`receiver`);

--
-- Indexen voor tabel `messages_sjabloon`
--
ALTER TABLE `messages_sjabloon`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `moderators`
--
ALTER TABLE `moderators`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `mod_letters`
--
ALTER TABLE `mod_letters`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `mychat_c_users`
--
ALTER TABLE `mychat_c_users`
  ADD UNIQUE KEY `room` (`room`,`username`);

--
-- Indexen voor tabel `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added` (`added`);

--
-- Indexen voor tabel `news_staff`
--
ALTER TABLE `news_staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added` (`added`);

--
-- Indexen voor tabel `nzbcategories`
--
ALTER TABLE `nzbcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `nzbcomments`
--
ALTER TABLE `nzbcomments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `nzb` (`nzb`);

--
-- Indexen voor tabel `nzbdlstats`
--
ALTER TABLE `nzbdlstats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`,`number`);

--
-- Indexen voor tabel `nzbpiecelist`
--
ALTER TABLE `nzbpiecelist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nzb` (`nzb`),
  ADD KEY `nzb_piece` (`nzb_piece`);

--
-- Indexen voor tabel `nzbs`
--
ALTER TABLE `nzbs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`),
  ADD KEY `name_2` (`name`),
  ADD KEY `size` (`size`),
  ADD KEY `category` (`category`),
  ADD KEY `numfiles` (`numfiles`),
  ADD KEY `comments` (`comments`),
  ADD KEY `views` (`views`),
  ADD KEY `hits` (`hits`),
  ADD KEY `nzbvernum` (`nzbvernum`),
  ADD KEY `pars` (`pars`),
  ADD KEY `partotsize` (`partotsize`),
  ADD KEY `genre` (`genre`);
ALTER TABLE `nzbs` ADD FULLTEXT KEY `groups` (`groups`);
ALTER TABLE `nzbs` ADD FULLTEXT KEY `name` (`name`);
ALTER TABLE `nzbs` ADD FULLTEXT KEY `ori_descr` (`ori_descr`);
ALTER TABLE `nzbs` ADD FULLTEXT KEY `ft_search` (`search_text`,`name`,`ori_descr`);

--
-- Indexen voor tabel `opschonen`
--
ALTER TABLE `opschonen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tijd` (`tijd`);

--
-- Indexen voor tabel `opschonen_bad_gb`
--
ALTER TABLE `opschonen_bad_gb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tijd` (`tijd`);

--
-- Indexen voor tabel `opschonen_donations`
--
ALTER TABLE `opschonen_donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tijd` (`tijd`);

--
-- Indexen voor tabel `opschonen_messages`
--
ALTER TABLE `opschonen_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tijd` (`tijd`);

--
-- Indexen voor tabel `opschonen_torrents`
--
ALTER TABLE `opschonen_torrents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tijd` (`tijd`);

--
-- Indexen voor tabel `partner`
--
ALTER TABLE `partner`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `peers`
--
ALTER TABLE `peers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `torrent_seeder` (`torrent`,`seeder`),
  ADD KEY `last_action` (`last_action`),
  ADD KEY `connectable` (`connectable`),
  ADD KEY `userid` (`userid`),
  ADD KEY `passkey` (`passkey`),
  ADD KEY `peer_id` (`peer_id`);

--
-- Indexen voor tabel `peer_id`
--
ALTER TABLE `peer_id`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `poll`
--
ALTER TABLE `poll`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `pollanswers`
--
ALTER TABLE `pollanswers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pollid` (`pollid`),
  ADD KEY `selection` (`selection`),
  ADD KEY `userid` (`userid`);

--
-- Indexen voor tabel `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topicid` (`topicid`),
  ADD KEY `userid` (`userid`);
ALTER TABLE `posts` ADD FULLTEXT KEY `body` (`body`);

--
-- Indexen voor tabel `proxy_ip`
--
ALTER TABLE `proxy_ip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip` (`ip`),
  ADD KEY `userid` (`userid`);

--
-- Indexen voor tabel `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`torrent`,`user`),
  ADD KEY `users` (`user`);

--
-- Indexen voor tabel `readposts`
--
ALTER TABLE `readposts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topicid` (`topicid`);

--
-- Indexen voor tabel `regels`
--
ALTER TABLE `regels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver` (`volgorde`);

--
-- Indexen voor tabel `registratie`
--
ALTER TABLE `registratie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip` (`ip`),
  ADD KEY `added` (`added`);

--
-- Indexen voor tabel `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `report_user`
--
ALTER TABLE `report_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added` (`added`);

--
-- Indexen voor tabel `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexen voor tabel `shoutboxaktie`
--
ALTER TABLE `shoutboxaktie`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `shoutbox_extra`
--
ALTER TABLE `shoutbox_extra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `datum` (`datum`);

--
-- Indexen voor tabel `shouts`
--
ALTER TABLE `shouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `shouts_mod`
--
ALTER TABLE `shouts_mod`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `shouts_seen`
--
ALTER TABLE `shouts_seen`
  ADD PRIMARY KEY (`user`);

--
-- Indexen voor tabel `sitelog`
--
ALTER TABLE `sitelog`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `sitelogaccount`
--
ALTER TABLE `sitelogaccount`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `sitelogadmin`
--
ALTER TABLE `sitelogadmin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added` (`added`);

--
-- Indexen voor tabel `sitelogautoban`
--
ALTER TABLE `sitelogautoban`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added` (`added`);

--
-- Indexen voor tabel `sitelogcheat`
--
ALTER TABLE `sitelogcheat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added` (`added`);

--
-- Indexen voor tabel `sitelogcontrole`
--
ALTER TABLE `sitelogcontrole`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added` (`added`);

--
-- Indexen voor tabel `siteloguseremail`
--
ALTER TABLE `siteloguseremail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added` (`added`);

--
-- Indexen voor tabel `sitelogusername`
--
ALTER TABLE `sitelogusername`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added` (`added`);

--
-- Indexen voor tabel `sitelogwarning`
--
ALTER TABLE `sitelogwarning`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added` (`added`);

--
-- Indexen voor tabel `sitelog_login`
--
ALTER TABLE `sitelog_login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added` (`added`);

--
-- Indexen voor tabel `site_acties`
--
ALTER TABLE `site_acties`
  ADD KEY `id` (`id`);

--
-- Indexen voor tabel `site_vars`
--
ALTER TABLE `site_vars`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `smsbalk`
--
ALTER TABLE `smsbalk`
  ADD KEY `id` (`id`);

--
-- Indexen voor tabel `stylesheets`
--
ALTER TABLE `stylesheets`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `thankyou`
--
ALTER TABLE `thankyou`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `subject` (`subject`),
  ADD KEY `lastpost` (`lastpost`);

--
-- Indexen voor tabel `torrents`
--
ALTER TABLE `torrents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `info_hash` (`info_hash`),
  ADD KEY `owner` (`owner`),
  ADD KEY `visible` (`visible`),
  ADD KEY `category_visible` (`category`,`visible`);
ALTER TABLE `torrents` ADD FULLTEXT KEY `ft_search` (`search_text`,`ori_descr`);

--
-- Indexen voor tabel `uploadapp`
--
ALTER TABLE `uploadapp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users` (`userid`);

--
-- Indexen voor tabel `uploader_aanvraag`
--
ALTER TABLE `uploader_aanvraag`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `uploader_bonus`
--
ALTER TABLE `uploader_bonus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`torrent_id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `status_added` (`status`,`added`),
  ADD KEY `ip` (`ip`),
  ADD KEY `uploaded` (`uploaded`),
  ADD KEY `downloaded` (`downloaded`),
  ADD KEY `country` (`country`),
  ADD KEY `last_access` (`last_access`),
  ADD KEY `enabled` (`enabled`),
  ADD KEY `warned` (`warned`);

--
-- Indexen voor tabel `users_comment`
--
ALTER TABLE `users_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `done_by` (`done_by`);

--
-- Indexen voor tabel `users_credits`
--
ALTER TABLE `users_credits`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `user_ip`
--
ALTER TABLE `user_ip`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `verwacht`
--
ALTER TABLE `verwacht`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `verwacht_bericht`
--
ALTER TABLE `verwacht_bericht`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `verzoekjes`
--
ALTER TABLE `verzoekjes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexen voor tabel `verzoekjes_stemmen`
--
ALTER TABLE `verzoekjes_stemmen`
  ADD PRIMARY KEY (`verzoek_id`);

--
-- Indexen voor tabel `warnings`
--
ALTER TABLE `warnings`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `warn_pm_gb`
--
ALTER TABLE `warn_pm_gb`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `warn_pm_gb_last`
--
ALTER TABLE `warn_pm_gb_last`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `warn_pm_seeding`
--
ALTER TABLE `warn_pm_seeding`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `warn_pm_torrent`
--
ALTER TABLE `warn_pm_torrent`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `aa_results`
--
ALTER TABLE `aa_results`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `addedrequests`
--
ALTER TABLE `addedrequests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `aktie`
--
ALTER TABLE `aktie`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `aktie_donatie`
--
ALTER TABLE `aktie_donatie`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT voor een tabel `banned_agent`
--
ALTER TABLE `banned_agent`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `bans`
--
ALTER TABLE `bans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT voor een tabel `bans_special`
--
ALTER TABLE `bans_special`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `berichten`
--
ALTER TABLE `berichten`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `berichten_box`
--
ALTER TABLE `berichten_box`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `berichten_sjabloon`
--
ALTER TABLE `berichten_sjabloon`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `bonus_punten`
--
ALTER TABLE `bonus_punten`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=561;

--
-- AUTO_INCREMENT voor een tabel `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT voor een tabel `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT voor een tabel `comments_uploader`
--
ALTER TABLE `comments_uploader`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `counter_casino`
--
ALTER TABLE `counter_casino`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT voor een tabel `credits`
--
ALTER TABLE `credits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT voor een tabel `def_messages`
--
ALTER TABLE `def_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `dlfsuinstelingen`
--
ALTER TABLE `dlfsuinstelingen`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT voor een tabel `donatieoverzicht`
--
ALTER TABLE `donatieoverzicht`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `donatie_ideal`
--
ALTER TABLE `donatie_ideal`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `donatie_ideal_claim_msg`
--
ALTER TABLE `donatie_ideal_claim_msg`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `donatie_ideal_del`
--
ALTER TABLE `donatie_ideal_del`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `donatie_sms`
--
ALTER TABLE `donatie_sms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `donatie_sms_claim_msg`
--
ALTER TABLE `donatie_sms_claim_msg`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `donatie_sms_del`
--
ALTER TABLE `donatie_sms_del`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `donatie_telefoon`
--
ALTER TABLE `donatie_telefoon`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `donatie_telefoon_claim_msg`
--
ALTER TABLE `donatie_telefoon_claim_msg`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `donatie_telefoon_del`
--
ALTER TABLE `donatie_telefoon_del`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `donatie_users`
--
ALTER TABLE `donatie_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `donations_claim`
--
ALTER TABLE `donations_claim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT voor een tabel `donations_claim_msg`
--
ALTER TABLE `donations_claim_msg`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `donations_lotery`
--
ALTER TABLE `donations_lotery`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `donations_message`
--
ALTER TABLE `donations_message`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `donations_registratie`
--
ALTER TABLE `donations_registratie`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `donations_users`
--
ALTER TABLE `donations_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT voor een tabel `downloaded`
--
ALTER TABLE `downloaded`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT voor een tabel `downtotals`
--
ALTER TABLE `downtotals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `downup`
--
ALTER TABLE `downup`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT voor een tabel `dox`
--
ALTER TABLE `dox`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `files`
--
ALTER TABLE `files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23535;

--
-- AUTO_INCREMENT voor een tabel `forums`
--
ALTER TABLE `forums`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT voor een tabel `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT voor een tabel `giro`
--
ALTER TABLE `giro`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `helpdesk`
--
ALTER TABLE `helpdesk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `hesk_attachments`
--
ALTER TABLE `hesk_attachments`
  MODIFY `att_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `hesk_banned_emails`
--
ALTER TABLE `hesk_banned_emails`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `hesk_banned_ips`
--
ALTER TABLE `hesk_banned_ips`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `hesk_categories`
--
ALTER TABLE `hesk_categories`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `hesk_kb_articles`
--
ALTER TABLE `hesk_kb_articles`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `hesk_kb_attachments`
--
ALTER TABLE `hesk_kb_attachments`
  MODIFY `att_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `hesk_kb_categories`
--
ALTER TABLE `hesk_kb_categories`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `hesk_log_overdue`
--
ALTER TABLE `hesk_log_overdue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `hesk_mail`
--
ALTER TABLE `hesk_mail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `hesk_notes`
--
ALTER TABLE `hesk_notes`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `hesk_replies`
--
ALTER TABLE `hesk_replies`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `hesk_reset_password`
--
ALTER TABLE `hesk_reset_password`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `hesk_service_messages`
--
ALTER TABLE `hesk_service_messages`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `hesk_std_replies`
--
ALTER TABLE `hesk_std_replies`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `hesk_tickets`
--
ALTER TABLE `hesk_tickets`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `hesk_ticket_templates`
--
ALTER TABLE `hesk_ticket_templates`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `hesk_users`
--
ALTER TABLE `hesk_users`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `hits`
--
ALTER TABLE `hits`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=935;

--
-- AUTO_INCREMENT voor een tabel `infolog`
--
ALTER TABLE `infolog`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT voor een tabel `ip`
--
ALTER TABLE `ip`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `ip_logboek`
--
ALTER TABLE `ip_logboek`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=615;

--
-- AUTO_INCREMENT voor een tabel `kijkwijzer`
--
ALTER TABLE `kijkwijzer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `loginmessages`
--
ALTER TABLE `loginmessages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `loterij`
--
ALTER TABLE `loterij`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `massa_berichten`
--
ALTER TABLE `massa_berichten`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `massa_bericht_mods`
--
ALTER TABLE `massa_bericht_mods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `massa_bericht_torrents`
--
ALTER TABLE `massa_bericht_torrents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=658;

--
-- AUTO_INCREMENT voor een tabel `messages_sjabloon`
--
ALTER TABLE `messages_sjabloon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `moderators`
--
ALTER TABLE `moderators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `mod_letters`
--
ALTER TABLE `mod_letters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT voor een tabel `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `news_staff`
--
ALTER TABLE `news_staff`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `nzbcategories`
--
ALTER TABLE `nzbcategories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT voor een tabel `nzbcomments`
--
ALTER TABLE `nzbcomments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `nzbdlstats`
--
ALTER TABLE `nzbdlstats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `nzbpiecelist`
--
ALTER TABLE `nzbpiecelist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT voor een tabel `nzbs`
--
ALTER TABLE `nzbs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `opschonen`
--
ALTER TABLE `opschonen`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT voor een tabel `opschonen_bad_gb`
--
ALTER TABLE `opschonen_bad_gb`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `opschonen_donations`
--
ALTER TABLE `opschonen_donations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `opschonen_messages`
--
ALTER TABLE `opschonen_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `opschonen_torrents`
--
ALTER TABLE `opschonen_torrents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `partner`
--
ALTER TABLE `partner`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT voor een tabel `peers`
--
ALTER TABLE `peers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3132;

--
-- AUTO_INCREMENT voor een tabel `peer_id`
--
ALTER TABLE `peer_id`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `poll`
--
ALTER TABLE `poll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `pollanswers`
--
ALTER TABLE `pollanswers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `polls`
--
ALTER TABLE `polls`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `proxy_ip`
--
ALTER TABLE `proxy_ip`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `readposts`
--
ALTER TABLE `readposts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `regels`
--
ALTER TABLE `regels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `registratie`
--
ALTER TABLE `registratie`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `report_user`
--
ALTER TABLE `report_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `shoutboxaktie`
--
ALTER TABLE `shoutboxaktie`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `shoutbox_extra`
--
ALTER TABLE `shoutbox_extra`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `shouts`
--
ALTER TABLE `shouts`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT voor een tabel `shouts_mod`
--
ALTER TABLE `shouts_mod`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `sitelog`
--
ALTER TABLE `sitelog`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1164;

--
-- AUTO_INCREMENT voor een tabel `sitelogaccount`
--
ALTER TABLE `sitelogaccount`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1554;

--
-- AUTO_INCREMENT voor een tabel `sitelogadmin`
--
ALTER TABLE `sitelogadmin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `sitelogautoban`
--
ALTER TABLE `sitelogautoban`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `sitelogcheat`
--
ALTER TABLE `sitelogcheat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `sitelogcontrole`
--
ALTER TABLE `sitelogcontrole`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `siteloguseremail`
--
ALTER TABLE `siteloguseremail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `sitelogusername`
--
ALTER TABLE `sitelogusername`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `sitelogwarning`
--
ALTER TABLE `sitelogwarning`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `sitelog_login`
--
ALTER TABLE `sitelog_login`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=329;

--
-- AUTO_INCREMENT voor een tabel `site_acties`
--
ALTER TABLE `site_acties`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `site_vars`
--
ALTER TABLE `site_vars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT voor een tabel `smsbalk`
--
ALTER TABLE `smsbalk`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `stylesheets`
--
ALTER TABLE `stylesheets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `thankyou`
--
ALTER TABLE `thankyou`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `torrents`
--
ALTER TABLE `torrents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=305;

--
-- AUTO_INCREMENT voor een tabel `uploadapp`
--
ALTER TABLE `uploadapp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `uploader_aanvraag`
--
ALTER TABLE `uploader_aanvraag`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=264;

--
-- AUTO_INCREMENT voor een tabel `uploader_bonus`
--
ALTER TABLE `uploader_bonus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=310;

--
-- AUTO_INCREMENT voor een tabel `users_comment`
--
ALTER TABLE `users_comment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `users_credits`
--
ALTER TABLE `users_credits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT voor een tabel `user_ip`
--
ALTER TABLE `user_ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=307;

--
-- AUTO_INCREMENT voor een tabel `verwacht`
--
ALTER TABLE `verwacht`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `verwacht_bericht`
--
ALTER TABLE `verwacht_bericht`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `verzoekjes`
--
ALTER TABLE `verzoekjes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `verzoekjes_stemmen`
--
ALTER TABLE `verzoekjes_stemmen`
  MODIFY `verzoek_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `warnings`
--
ALTER TABLE `warnings`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `warn_pm_gb`
--
ALTER TABLE `warn_pm_gb`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT voor een tabel `warn_pm_gb_last`
--
ALTER TABLE `warn_pm_gb_last`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `warn_pm_seeding`
--
ALTER TABLE `warn_pm_seeding`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `warn_pm_torrent`
--
ALTER TABLE `warn_pm_torrent`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
