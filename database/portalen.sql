-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2015 at 04:00 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `portalen`
--

-- --------------------------------------------------------

--
-- Table structure for table `access`
--

CREATE TABLE IF NOT EXISTS `access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `access`
--

INSERT INTO `access` (`id`, `name`) VALUES
(1, 'admin'),
(7, 'bar'),
(2, 'dagsansvarig'),
(9, 'dj'),
(8, 'event'),
(3, 'hovmastare'),
(6, 'kock'),
(11, 'lol'),
(13, 'marknadsforing'),
(10, 'servering'),
(4, 'super_admin'),
(12, 'vard'),
(5, 'webb');

-- --------------------------------------------------------

--
-- Table structure for table `achievement`
--

CREATE TABLE IF NOT EXISTS `achievement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `icon` varchar(35) DEFAULT NULL,
  `points` int(11) NOT NULL DEFAULT '5',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `achievement`
--

INSERT INTO `achievement` (`id`, `name`, `description`, `icon`, `points`) VALUES
(1, 'Logga in', 'Logga in för första gången!', 'fa fa-unlock fa-fw fa-lg', 5),
(2, 'Ordinarie Bartender', 'Bli uppgraderad från Nybyggare - Bar!', 'fa fa-cloud fa-fw fa-lg', 5),
(3, 'För att du är värd det', 'Jobba värd 25 gånger', 'fa fa-user-secret fa-fw fa-lg', 15),
(4, 'Bartastic', 'Jobba bar 2 gånger', 'fa fa-glass fa-fw fa-lg', 5),
(5, 'Kocktastic', 'Jobba kock 2 gånger', 'fa fa-bug fa-fw fa-lg', 5),
(6, 'Winner winner Chicken Dinner', 'Jobba DA 2 gånger', 'fa fa-key fa-fw fa-lg', 5),
(7, 'Jack of all trades', 'Jobba minst 10 pass som bar, värd, kock, servering och alla', 'fa fa-bars fa-fw fa-lg', 25),
(8, 'Barlicious', 'Jobba bar 10 gånger', 'fa fa-glass fa-fw fa-lg', 10),
(9, 'Barbar', 'Jobba bar 25 gånger', 'fa fa-glass fa-fw fa-lg', 15),
(10, 'Barkungen', 'Jobba bar 50 gånger', 'fa fa-glass fa-fw fa-lg', 25),
(11, 'Kocky', 'Jobba kock 25 gånger', 'fa fa-bug fa-fw fa-lg', 15),
(12, 'Gordon Ramsay', 'Jobba kock 50 gånger', 'fa fa-bug fa-fw fa-lg', 25),
(13, 'Pommeskungen', 'Jobba kock 10 gånger', 'fa fa-bug fa-fw fa-lg', 10),
(14, 'Så jävla värt', 'Jobba värd 50 gånger', 'fa fa-user-secret fa-fw fa-lg', 25),
(15, 'Värdtastic', 'Jobba värd 2 gånger', 'fa fa-user-secret fa-fw fa-lg', 5),
(16, 'En värdig värd i en värd värld', 'Jobba värd 10 gånger', 'fa fa-user-secret fa-fw fa-lg', 10),
(17, 'Som en Chef', 'Jobba DA 10 gånger', 'fa fa-key fa-fw fa-lg', 10),
(18, 'DA#3', 'Jobba DA 25 gånger', 'fa fa-key fa-fw fa-lg', 15),
(19, 'DA#4', 'Jobba DA 50 gånger', 'fa fa-key fa-fw fa-lg', 25),
(20, 'Bara för att det är kul', 'Jobba minst 12p i en period', 'fa fa-bookmark fa-fw fa-lg', 10),
(21, 'Hardly working', 'Jobba minst 25p i en period', 'fa fa-bookmark fa-fw fa-lg', 20),
(22, '<3', 'Jobba 250p totalt', 'fa fa-university fa-fw fa-lg', 25),
(23, 'Dinner is served', 'Jobba servering 2 gånger', 'fa fa-cutlery fa-fw fa-lg', 5),
(24, 'Servering#2', 'Jobba servering 10 gånger', 'fa fa-cutlery fa-fw fa-lg', 10),
(25, 'Servering#3', 'Jobba servering 25 gånger', 'fa fa-cutlery fa-fw fa-lg', 15),
(26, 'Servering#4', 'Jobba servering 50 gånger', 'fa fa-cutlery fa-fw fa-lg', 25),
(27, 'Tallriksmodellen', 'Jobba minst 1 pass som bar, värd, kock, servering och alla', 'fa fa-bars fa-fw fa-lg', 5),
(28, 'Alla#1', 'Jobba alla 2 gånger', 'fa fa-star fa-fw fa-lg', 5),
(29, 'Alla#2', 'Jobba alla 8 gånger', 'fa fa-star fa-fw fa-lg', 10),
(30, 'Alla#3', 'Jobba alla 15 gånger', 'fa fa-star fa-fw fa-lg', 15),
(31, 'Alla#4', 'Jobba alla 25 gånger', 'fa fa-star fa-fw fa-lg', 25),
(32, 'Hovis#1', 'Jobba hovis 2 gånger', 'fa fa-female fa-fw fa-lg', 5),
(33, 'Hovis#2', 'Jobba hovis 8 gånger', 'fa fa-female fa-fw fa-lg', 10),
(34, 'Hovis#3', 'Jobba hovis 15 gånger', 'fa fa-female fa-fw fa-lg', 15),
(35, 'Hovis#4', 'Jobba hovis 25 gånger', 'fa fa-female fa-fw fa-lg', 25),
(36, 'BITCH I AM FABULOUS', 'Ladda upp en profilbild', 'fa fa-cloud fa-fw fa-lg', 5);

-- --------------------------------------------------------

--
-- Table structure for table `achievement_unlocked`
--

CREATE TABLE IF NOT EXISTS `achievement_unlocked` (
  `user_id` int(11) NOT NULL,
  `achievement_id` int(11) NOT NULL,
  `date_unlocked` date NOT NULL,
  KEY `user_id` (`user_id`,`achievement_id`),
  KEY `achievement_id` (`achievement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `achievement_unlocked`
--

INSERT INTO `achievement_unlocked` (`user_id`, `achievement_id`, `date_unlocked`) VALUES
(2, 1, '0000-00-00'),
(2, 3, '0000-00-00'),
(2, 6, '0000-00-00'),
(2, 15, '2015-03-15'),
(2, 23, '2015-03-15'),
(8, 1, '2015-03-15'),
(8, 20, '2015-03-15'),
(8, 21, '2015-03-15'),
(1, 20, '2015-03-15'),
(1, 21, '2015-03-15'),
(2, 20, '2015-03-15'),
(2, 21, '2015-03-15'),
(3, 20, '2015-03-15'),
(3, 1, '2015-03-17'),
(8, 36, '2015-03-17');

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE IF NOT EXISTS `application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `ssn` varchar(10) NOT NULL,
  `mail` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `application_group`
--

CREATE TABLE IF NOT EXISTS `application_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`,`application_id`),
  KEY `application_id` (`application_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `da_note`
--

CREATE TABLE IF NOT EXISTS `da_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `sales_total` int(11) NOT NULL,
  `sales_entry` int(11) NOT NULL,
  `sales_bar` int(11) NOT NULL,
  `cash` int(11) NOT NULL,
  `n_of_people` int(11) NOT NULL,
  `sales_spenta` int(11) NOT NULL,
  `message` varchar(4000) NOT NULL,
  `date_written` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`event_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `da_note`
--

INSERT INTO `da_note` (`id`, `user_id`, `event_id`, `sales_total`, `sales_entry`, `sales_bar`, `cash`, `n_of_people`, `sales_spenta`, `message`, `date_written`) VALUES
(1, 1, 35, 0, 9001, 80085, 1337, 69, 420, 'fest', '0000-00-00'),
(27, 2, 36, 0, 1, 2, 23, 2342, 242, '42', '2015-02-19');

-- --------------------------------------------------------

--
-- Table structure for table `da_note_comments`
--

CREATE TABLE IF NOT EXISTS `da_note_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `da_note_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date_written` date NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`da_note_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `da_note_comments`
--

INSERT INTO `da_note_comments` (`id`, `da_note_id`, `comment`, `date_written`, `user_id`) VALUES
(1, 1, 'bleep', '2015-02-19', 2),
(2, 1, 'wrr', '2015-02-19', 2),
(4, 27, 'top lel\r\n', '2015-02-19', 2);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `info` text NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `period_id` int(11) NOT NULL,
  `event_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `period_id` (`period_id`),
  KEY `event_type_id` (`event_type_id`),
  KEY `name_3` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `name`, `info`, `start_time`, `end_time`, `period_id`, `event_type_id`) VALUES
(1, 'Pizzaonsdag', '', '2014-02-19 18:00:00', '2014-02-19 22:00:00', 1, 1),
(2, 'Vårkravallen', '', '2014-03-08 22:00:00', '2014-03-09 03:00:00', 2, 2),
(4, 'Sittning', '', '2014-02-14 17:00:00', '2014-02-14 23:00:00', 1, 3),
(5, 'Personalfest', '', '2014-03-09 18:30:00', '2014-03-10 03:00:00', 2, 4),
(7, 'MT <3 GDK', '', '2014-02-22 18:00:00', '2014-02-22 22:00:00', 1, 3),
(10, 'Fotbollstisdag', '', '2014-02-25 20:00:00', '2014-02-25 22:00:00', 1, 1),
(11, 'Onsdagspub', '', '2014-02-26 18:00:00', '2014-02-26 22:00:00', 1, 1),
(26, 'Rockfesten', '', '2014-03-01 22:00:00', '2014-03-02 03:00:00', 2, 2),
(27, 'Kravallpub', '', '2014-02-27 18:00:00', '2014-02-28 01:00:00', 1, 1),
(29, 'nuu', '', '2014-03-06 18:00:00', '2014-03-06 22:00:00', 2, 1),
(30, 'Eventet', '', '2014-04-21 08:00:00', '2014-04-21 17:00:00', 3, 1),
(31, 'Puuhben', '', '2014-04-28 18:00:00', '2014-04-28 22:00:00', 3, 1),
(32, 'Le puub', '', '2014-04-28 18:00:00', '2014-04-28 22:00:00', 3, 1),
(34, 'Poop', '', '2014-10-27 18:00:00', '2014-10-28 01:00:00', 5, 1),
(35, 'Bleep', '', '2015-02-14 00:00:00', '2015-02-15 00:00:00', 2, 1),
(36, 'TORSDAG, FUCK YEAH', '', '2015-02-19 00:00:00', '2015-02-20 00:00:00', 2, 1),
(37, 'Beepity Bapeti', '', '2015-02-22 00:00:00', '2015-02-23 00:00:00', 2, 2),
(38, 'GAMMALT SKIT', '', '2015-02-18 18:00:00', '2015-02-18 22:00:00', 2, 1),
(48, 'GAMMALT SKIT 13', 'Fan rätt fräscht asså', '2015-02-18 18:00:00', '2015-02-18 22:00:00', 2, 1),
(49, 'Webbmöte', 'Webbmöte jao', '2015-02-18 17:15:00', '2015-02-18 19:00:00', 2, 5),
(50, 'Passtest', 'Fan svårt att få det att funka', '2015-02-19 17:15:00', '2015-03-25 19:00:00', 2, 3),
(51, 'Test wage', 'Yep', '2015-02-25 22:00:00', '2015-02-26 03:00:00', 2, 2),
(52, 'Test wage #2', 'mhm', '2015-02-25 22:00:00', '2015-02-26 03:00:00', 2, 2),
(53, 'Testpub', 'Tesssssssssssssst', '2015-03-12 00:00:00', '2015-03-13 00:00:00', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_comments`
--

CREATE TABLE IF NOT EXISTS `event_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(500) NOT NULL,
  `date_written` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `event_comments`
--

INSERT INTO `event_comments` (`id`, `comment`, `date_written`, `user_id`, `event_id`) VALUES
(1, '*måste fixa lite', '2015-02-26', 2, 50),
(2, '*lol', '2015-02-26', 2, 37),
(3, '*typ css på dessa', '2015-02-26', 2, 50);

-- --------------------------------------------------------

--
-- Table structure for table `event_template`
--

CREATE TABLE IF NOT EXISTS `event_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `event_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `event_type_id` (`event_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `event_template`
--

INSERT INTO `event_template` (`id`, `name`, `start_time`, `end_time`, `event_type_id`) VALUES
(5, 'Onsdagspub', '18:00:00', '23:01:00', 1),
(6, 'Vanlig nattklubb', '22:00:00', '03:00:00', 2),
(7, 'Vanlig pub', '18:00:00', '01:00:00', 1),
(9, 'Webbmöte', '17:15:00', '19:00:00', 5),
(10, 'Test', '13:37:00', '13:37:00', 1),
(12, 'Obestämd', '13:37:00', '13:37:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_template_group`
--

CREATE TABLE IF NOT EXISTS `event_template_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `points` int(11) NOT NULL,
  `event_template_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_template_id` (`event_template_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `event_template_group`
--

INSERT INTO `event_template_group` (`id`, `start_time`, `end_time`, `points`, `event_template_id`, `group_id`) VALUES
(1, '2014-03-06 17:00:00', '2014-03-07 00:00:00', 3, 5, 5),
(2, '2015-02-25 17:15:00', '2015-02-25 19:00:00', 0, 9, 2);

-- --------------------------------------------------------

--
-- Table structure for table `event_type`
--

CREATE TABLE IF NOT EXISTS `event_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `event_type`
--

INSERT INTO `event_type` (`id`, `name`) VALUES
(5, 'Möte'),
(2, 'Nattklubb'),
(4, 'Personalaktivitet'),
(1, 'Pub'),
(3, 'Sittning');

-- --------------------------------------------------------

--
-- Table structure for table `group_access`
--

CREATE TABLE IF NOT EXISTS `group_access` (
  `access_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`access_id`,`group_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_access`
--

INSERT INTO `group_access` (`access_id`, `group_id`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `group_member`
--

CREATE TABLE IF NOT EXISTS `group_member` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_leader` int(11) NOT NULL DEFAULT '0',
  `member_since` date NOT NULL,
  PRIMARY KEY (`group_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_member`
--

INSERT INTO `group_member` (`group_id`, `user_id`, `group_leader`, `member_since`) VALUES
(1, 1, 0, '0000-00-00'),
(1, 2, 0, '2015-03-04'),
(2, 1, 0, '0000-00-00'),
(2, 2, 0, '2015-02-05'),
(4, 1, 0, '0000-00-00'),
(7, 1, 0, '0000-00-00'),
(7, 2, 0, '2014-00-00'),
(9, 2, 0, '2013-00-00'),
(11, 1, 0, '0000-00-00'),
(13, 2, 0, '2015-03-17');

-- --------------------------------------------------------

--
-- Table structure for table `headwaiter_note`
--

CREATE TABLE IF NOT EXISTS `headwaiter_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `n_of_sitting` int(11) NOT NULL,
  `food` varchar(200) NOT NULL,
  `invoice_drinks` varchar(200) NOT NULL,
  `n_of_waiting_stair` int(11) NOT NULL,
  `n_of_waiting_organizers` int(11) NOT NULL,
  `toast` varchar(200) NOT NULL,
  `organizers` varchar(200) NOT NULL,
  `stair_staff` varchar(200) NOT NULL,
  `organizers_staff` varchar(300) NOT NULL,
  `swine` varchar(200) NOT NULL,
  `message` varchar(3000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`event_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `headwaiter_note`
--

INSERT INTO `headwaiter_note` (`id`, `user_id`, `event_id`, `n_of_sitting`, `food`, `invoice_drinks`, `n_of_waiting_stair`, `n_of_waiting_organizers`, `toast`, `organizers`, `stair_staff`, `organizers_staff`, `swine`, `message`) VALUES
(5, 2, 2, 1, '1', '1', 0, 1, '1', '1', '1', '1', '1', '1'),
(6, 2, 7, 112, 'Björn knows his shit!!!!', '13 läsk\r\n37 Spenta\r\n69 briska', 0, 6, 'Oförsiktiga med utrustningen men nämnde nödutgångarna!', 'De glömde nämna att man inte får ha mat med sig..', 'Baren svinnade som FAN, men servering var KUNG', 'Det viktiga är att man försöker', '2cl Sourz Raspberry - dålig bartender', 'Det var en lugn sittning, ingen GaSSKAT'),
(7, 2, 30, 12, 'B', '13 spenta', 2, 6, 'of', 'e', 'wq', 'we', 'we', 'wewqewrqwraowaojfajo');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `message` varchar(3000) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `message`, `date`, `user_id`) VALUES
(1, 'Hej', 'Då', '2015-02-12 14:53:09', 2),
(2, 'Nya pass och personalfest!', 'Hej!  Nu har det kommit upp nya pass för mars månad! så nu är det bara att börja boka upp sig. Glöm inte att boka upp er till personalfesten den 8:e mars. För att gå ska du ha jobbat 8 poäng i dec/jan och 8 poäng i februari eller motsvarande för poängbefriat lag. Du får även gå om du är nybyggare och aldrig har gått på en personalfest innan!  Glöm inte att skriva in eventuella allergier eller specialkost om ni har på portalen.  Ha det bra!', '2015-02-27 11:20:14', 2),
(3, 'Nyhetsbrev', 'Hej! \r\nNu har det kommit upp nya pass för mars månad! så nu är det bara att börja boka upp sig. Glöm inte att boka upp er till personalfesten den 8:e mars. För att gå ska du ha jobbat 8 poäng i dec/jan och 8 poäng i februari eller motsvarande för poängbefriat lag. Du får även gå om du är nybyggare och aldrig har gått på en personalfest innan! \r\n\r\nGlöm inte att skriva in eventuella allergier eller specialkost om ni har på portalen. \r\n\r\nHa det bra!', '2015-02-27 11:40:17', 2);

-- --------------------------------------------------------

--
-- Table structure for table `partyries`
--

CREATE TABLE IF NOT EXISTS `partyries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `partyries`
--

INSERT INTO `partyries` (`id`, `name`) VALUES
(1, '3Cant'),
(2, 'Tryckbar'),
(3, 'Escort'),
(4, 'Helgrymt'),
(5, 'LATex'),
(6, 'Skandal'),
(7, 'SSKadat'),
(8, 'Fest-N'),
(9, 'Max'),
(10, 'Skumpa'),
(11, 'SoCeR');

-- --------------------------------------------------------

--
-- Table structure for table `partyries_arrange`
--

CREATE TABLE IF NOT EXISTS `partyries_arrange` (
  `event_id` int(11) NOT NULL,
  `partyries_id` int(11) NOT NULL,
  PRIMARY KEY (`partyries_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `partyries_arrange`
--

INSERT INTO `partyries_arrange` (`event_id`, `partyries_id`) VALUES
(36, 1),
(36, 11);

-- --------------------------------------------------------

--
-- Table structure for table `partyries_work`
--

CREATE TABLE IF NOT EXISTS `partyries_work` (
  `event_id` int(11) NOT NULL,
  `partyries_id` int(11) NOT NULL,
  PRIMARY KEY (`partyries_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `partyries_work`
--

INSERT INTO `partyries_work` (`event_id`, `partyries_id`) VALUES
(36, 1),
(36, 9),
(36, 10);

-- --------------------------------------------------------

--
-- Table structure for table `period`
--

CREATE TABLE IF NOT EXISTS `period` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `period`
--

INSERT INTO `period` (`id`, `name`, `start_date`, `end_date`) VALUES
(1, 'December/Januari 2015', '2014-12-02', '2015-01-31'),
(2, 'Februari 2015', '2015-02-01', '2015-02-28'),
(3, 'Mars 2015', '2015-03-01', '2015-03-31'),
(4, 'April 2015', '2015-04-01', '2015-04-30'),
(5, 'Maj/Juni 2015', '2015-05-01', '2015-06-13'),
(6, 'Oktober 2015', '2015-10-01', '2015-11-01'),
(7, 'November 2015', '2015-11-01', '2015-12-01');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `ssn` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `major` varchar(60) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `zip` varchar(5) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `latest_session` date NOT NULL,
  `number_of_sessions` int(11) NOT NULL DEFAULT '0',
  `achievement_points` int(11) NOT NULL DEFAULT '0',
  `bank_account` varchar(50) DEFAULT NULL,
  `special_food` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`user_name`,`mail`,`ssn`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `mail`, `ssn`, `password`, `name`, `last_name`, `phone_number`, `description`, `major`, `address`, `zip`, `city`, `avatar`, `date_created`, `latest_session`, `number_of_sessions`, `achievement_points`, `bank_account`, `special_food`) VALUES
(1, 'Valross', 'valross@mail.com', '111111-123', '9b8c524273eaeab794fdd09a36f26e81', 'Hampus', 'Axelsson', '123456789', 'Jag är så cool!', 'MT', 'DK', '60333', 'Norrpan', 'portalen_bild.jpg', '2014-01-31 23:00:00', '2015-02-27', 0, 30, '1337-000000000', 'Ja'),
(2, 'test', 'ankan@mail.com', '9901011245', 'cb15ee3da60f51d1f8cb94652b1539f3', 'Herpa', 'Derp', '123654879', 'WOPP', 'MT', 'Ankeborgsvägen 2', NULL, NULL, 'dancing-banana.gif', '0000-00-00 00:00:00', '2015-03-17', 11, 65, NULL, NULL),
(3, 'test2', '1111@mail.com', '1111111111', 'cb15ee3da60f51d1f8cb94652b1539f3', 'Testarn', 'Testsson', '', NULL, '', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '2015-03-17', 1, 15, NULL, NULL),
(5, 'Trappan', '2222@mail.com', '2222222222', 'cb15ee3da60f51d1f8cb94652b1539f3', 'Harry', 'Gluten', '', NULL, '', NULL, NULL, NULL, NULL, '2014-02-19 14:00:19', '0000-00-00', 0, 0, NULL, NULL),
(6, 'Bajs', 'hej@mail.com', 'ssssssssss', '711284ca87ba99f7c8198840f5dc607c', 'Bajs', 'o kiss', '', NULL, '', NULL, NULL, NULL, NULL, '2014-02-19 15:24:25', '0000-00-00', 0, 0, NULL, NULL),
(7, 'HEEEJ', 'jjasdj', 'asdfsfs', '640702a7a1279095e6da83ba8f768cbf', 'dsads', 'MDMASDSD', '', NULL, '', NULL, NULL, NULL, NULL, '2014-10-22 15:41:02', '0000-00-00', 0, 0, NULL, NULL),
(8, 'Test2', 'test', '9999999999', '9163b11327d5001b62d94c2ba978a262', 'Tess', 'Två', '', NULL, '', NULL, NULL, NULL, 'Tess8.gif', '2015-03-15 21:23:41', '2015-03-17', 6, 40, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_access`
--

CREATE TABLE IF NOT EXISTS `user_access` (
  `access_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`access_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_work`
--

CREATE TABLE IF NOT EXISTS `user_work` (
  `work_slot_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `checked` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`work_slot_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_work`
--

INSERT INTO `user_work` (`work_slot_id`, `user_id`, `checked`) VALUES
(89, 1, 1),
(90, 2, 1),
(91, 2, 1),
(93, 3, 1),
(94, 2, 1),
(95, 2, 1),
(96, 2, 1),
(99, 2, 1),
(100, 1, 1),
(102, 7, 0),
(111, 8, 1),
(112, 2, 1),
(113, 2, 1),
(114, 2, 1),
(115, 2, 1),
(116, 2, 1),
(117, 2, 1),
(118, 2, 1),
(119, 1, 1),
(120, 2, 1),
(121, 2, 1),
(122, 2, 1),
(123, 2, 1),
(124, 2, 1),
(125, 2, 1),
(126, 2, 1),
(134, 2, 0),
(135, 1, 0),
(137, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `work_group`
--

CREATE TABLE IF NOT EXISTS `work_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `facebook_group` text,
  `icon` text NOT NULL,
  `hex` varchar(6) NOT NULL,
  `sub_group` int(11) DEFAULT NULL,
  `main_group` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `name_2` (`name`),
  KEY `main_group` (`main_group`),
  KEY `sub_group` (`sub_group`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `work_group`
--

INSERT INTO `work_group` (`id`, `name`, `description`, `facebook_group`, `icon`, `hex`, `sub_group`, `main_group`) VALUES
(1, 'Driftgruppen', '', '', '', '', NULL, NULL),
(2, 'Webb', '', '', '', '', NULL, NULL),
(3, 'Kock', '', '', 'fa fa-bug fa-fw fa-lg', '', 16, NULL),
(4, 'Bar', 'YEAH BAR', 'www.facebook.com', 'fa fa-glass fa-fw fa-lg', '', 15, NULL),
(5, 'DJ', '', '', '', '', 28, NULL),
(6, 'Värd', '', '', '', '', 25, NULL),
(7, 'Dagsansvarig', '', '', '', '', NULL, NULL),
(8, 'Event', '', '', '', '', NULL, NULL),
(9, 'Marknadsföring', '', '', '', '', NULL, NULL),
(10, 'Ljud & Ljus', '', '', '', '', 26, NULL),
(11, 'Servering', '', '', 'fa fa-cutlery fa-fw fa-lg', '', 17, NULL),
(12, 'Hovmästare', '', '', 'fa fa-cutlery fa-fw fa-lg', '', 27, NULL),
(13, 'Alla', 'Typ', '', 'fa fa-diamond fa-fw fa-lg', 'ffffff', NULL, NULL),
(14, 'Vimmel', 'vimmel yeah!', 'www.facebook.com', 'fa fa-camera-retro fa-fw fa-lg', '', NULL, NULL),
(15, 'Bar - Nybyggare', '', '', 'fa fa-glass fa-fw fa-lg', '', NULL, 4),
(16, 'Kock - Nybyggare', '', '', 'fa fa-bug fa-fw fa-lg', '', NULL, 3),
(17, 'Servering - Nybyggare', '', '', 'fa fa-cutlery fa-fw fa-lg', '', NULL, 11),
(25, 'Värd - Nybyggare', '', '', '', '', NULL, 6),
(26, 'Ljud & Ljus - Lärling', '', '', '', '', NULL, 10),
(27, 'Pingu', '', '', '', '', NULL, 12),
(28, 'DJ - Nybyggare', '', '', '', '', NULL, 5),
(29, 'Nybyggare', '', '', '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `work_group_leaders`
--

CREATE TABLE IF NOT EXISTS `work_group_leaders` (
  `work_group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `work_group_id` (`work_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `work_group_leaders`
--

INSERT INTO `work_group_leaders` (`work_group_id`, `user_id`) VALUES
(2, 2),
(5, 1),
(7, 2),
(7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `work_slot`
--

CREATE TABLE IF NOT EXISTS `work_slot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `wage` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=141 ;

--
-- Dumping data for table `work_slot`
--

INSERT INTO `work_slot` (`id`, `group_id`, `event_id`, `points`, `wage`, `start_time`, `end_time`) VALUES
(4, 2, 1, 3, 0, '2014-02-19 17:00:00', '2014-02-19 23:00:00'),
(5, 2, 4, 4, 0, '2014-02-14 16:00:00', '2014-02-15 00:00:00'),
(6, 2, 1, 3, 0, '2014-02-19 17:00:00', '2014-02-19 23:00:00'),
(7, 2, 2, 6, 0, '2014-03-08 19:00:00', '2014-03-09 05:00:00'),
(8, 2, 2, 6, 0, '2014-03-08 19:00:00', '2014-03-09 05:00:00'),
(9, 6, 5, 0, 0, '2014-03-09 18:00:00', '2014-03-10 03:00:00'),
(10, 10, 5, 0, 0, '2014-03-09 18:00:00', '2014-02-10 03:00:00'),
(11, 6, 10, 2, 0, '2014-02-25 19:00:00', '2014-02-25 23:00:00'),
(35, 4, 26, 6, 0, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(36, 4, 26, 6, 0, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(37, 4, 26, 6, 0, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(38, 4, 26, 6, 0, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(39, 4, 26, 6, 0, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(40, 7, 26, 6, 0, '2014-03-01 16:00:00', '2014-03-02 05:00:00'),
(41, 5, 26, 0, 0, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(42, 5, 26, 0, 0, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(43, 6, 26, 6, 0, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(44, 6, 26, 6, 0, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(45, 6, 26, 6, 0, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(46, 6, 26, 6, 0, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(47, 10, 26, 0, 0, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(48, 10, 26, 0, 0, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(49, 4, 27, 4, 0, '2014-02-27 17:00:00', '2014-02-28 02:00:00'),
(50, 4, 27, 4, 0, '2014-02-27 17:00:00', '2014-02-28 02:00:00'),
(51, 4, 27, 4, 0, '2014-02-27 17:00:00', '2014-02-28 02:00:00'),
(52, 8, 27, 0, 0, '2014-02-27 17:00:00', '2014-02-28 02:00:00'),
(53, 8, 27, 0, 0, '2014-02-27 17:00:00', '2014-02-28 02:00:00'),
(54, 7, 27, 4, 0, '2014-02-27 16:00:00', '2014-02-28 02:00:00'),
(55, 6, 27, 4, 0, '2014-02-27 17:00:00', '2014-02-28 02:00:00'),
(56, 6, 27, 4, 0, '2014-02-27 17:00:00', '2014-02-28 02:00:00'),
(57, 3, 27, 4, 0, '2014-02-27 17:00:00', '2014-02-28 00:00:00'),
(58, 3, 27, 4, 0, '2014-02-27 17:00:00', '2014-02-28 00:00:00'),
(59, 3, 27, 4, 0, '2014-02-27 17:00:00', '2014-02-28 00:00:00'),
(61, 5, 29, 3, 0, '2014-03-06 17:00:00', '2014-03-06 00:00:00'),
(62, 13, 30, 2, 0, '2014-04-21 07:00:00', '2014-04-21 18:00:00'),
(63, 13, 30, 2, 0, '2014-04-21 07:00:00', '2014-04-21 18:00:00'),
(64, 5, 31, 3, 0, '2014-04-28 17:00:00', '2014-04-29 00:00:00'),
(65, 5, 32, 3, 0, '2014-04-28 17:00:00', '2014-04-29 00:00:00'),
(66, 13, 32, 4, 0, '2014-04-28 17:00:00', '2014-04-29 02:00:00'),
(67, 13, 32, 4, 0, '2014-04-28 17:00:00', '2014-04-29 02:00:00'),
(71, 4, 34, 4, 0, '2014-10-27 17:00:00', '2014-10-28 02:00:00'),
(72, 4, 34, 4, 0, '2014-10-27 17:00:00', '2014-10-28 02:00:00'),
(73, 3, 34, 3, 0, '2014-10-27 17:00:00', '2014-10-28 00:00:00'),
(74, 3, 34, 3, 0, '2014-10-27 17:00:00', '2014-10-28 00:00:00'),
(75, 7, 34, 4, 0, '2014-10-27 16:00:00', '2014-10-28 02:00:00'),
(76, 5, 38, 3, 0, '2015-02-18 17:00:00', '2015-02-19 00:00:00'),
(77, 13, 38, 15, 0, '2015-02-18 00:00:00', '2015-02-18 00:00:00'),
(86, 5, 48, 3, 0, '2015-02-18 17:00:00', '2015-02-19 00:00:00'),
(87, 13, 48, 0, 0, '2015-02-18 00:00:00', '2015-02-18 00:00:00'),
(88, 2, 49, 0, 0, '2015-02-18 17:15:00', '2015-02-18 19:00:00'),
(89, 2, 50, 0, 0, '2015-02-18 17:15:00', '2015-02-18 19:00:00'),
(90, 13, 50, 68, 0, '2015-02-19 16:00:00', '2015-02-20 05:00:00'),
(91, 6, 50, 0, 0, '2015-02-18 19:00:00', '2015-02-19 05:00:00'),
(93, 7, 50, 13, 40, '2015-02-18 00:00:00', '2015-02-18 00:00:00'),
(94, 7, 50, 13, 0, '2015-02-18 00:00:00', '2015-02-18 00:00:00'),
(95, 7, 51, 4, 40, '2015-02-18 16:00:00', '2015-02-19 04:00:00'),
(96, 7, 52, 5, 86, '2015-02-25 19:00:00', '2015-02-26 05:15:00'),
(99, 13, 50, 0, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00'),
(100, 13, 50, 0, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00'),
(101, 13, 50, 0, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00'),
(102, 13, 50, 0, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00'),
(106, 5, 50, 0, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00'),
(107, 5, 50, 0, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00'),
(108, 5, 50, 0, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00'),
(109, 5, 50, 0, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00'),
(111, 13, 50, 24, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00'),
(112, 6, 53, 0, 0, '2015-03-12 00:00:00', '2015-03-13 00:00:00'),
(113, 6, 53, 0, 0, '2015-03-12 00:00:00', '2015-03-13 00:00:00'),
(114, 6, 53, 0, 0, '2015-03-12 00:00:00', '2015-03-13 00:00:00'),
(115, 6, 53, 0, 0, '2015-03-12 00:00:00', '2015-03-13 00:00:00'),
(116, 6, 53, 0, 0, '2015-03-12 00:00:00', '2015-03-13 00:00:00'),
(117, 6, 53, 0, 0, '2015-03-12 00:00:00', '2015-03-13 00:00:00'),
(118, 6, 53, 0, 0, '2015-03-12 00:00:00', '2015-03-13 00:00:00'),
(119, 6, 53, 0, 0, '2015-03-12 00:00:00', '2015-03-13 00:00:00'),
(120, 6, 53, 0, 0, '2015-03-12 00:00:00', '2015-03-13 00:00:00'),
(121, 6, 53, 0, 0, '2015-03-12 00:00:00', '2015-03-13 00:00:00'),
(122, 7, 53, 0, 0, '2015-03-12 00:00:00', '2015-03-13 00:00:00'),
(123, 11, 50, 0, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00'),
(124, 11, 50, 0, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00'),
(125, 11, 50, 0, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00'),
(126, 11, 53, 0, 0, '2015-03-12 00:00:00', '2015-03-13 00:00:00'),
(134, 15, 50, 0, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00'),
(135, 15, 50, 0, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00'),
(136, 4, 50, 0, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00'),
(137, 4, 50, 0, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00'),
(138, 15, 50, 0, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00'),
(139, 17, 50, 0, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00'),
(140, 17, 50, 0, 0, '2015-02-19 17:15:00', '2015-03-25 19:00:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `achievement_unlocked`
--
ALTER TABLE `achievement_unlocked`
  ADD CONSTRAINT `achievement_unlocked_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `achievement_unlocked_ibfk_2` FOREIGN KEY (`achievement_id`) REFERENCES `achievement` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `application_group`
--
ALTER TABLE `application_group`
  ADD CONSTRAINT `application_group_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `work_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `application_group_ibfk_2` FOREIGN KEY (`application_id`) REFERENCES `application` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `da_note`
--
ALTER TABLE `da_note`
  ADD CONSTRAINT `da_note_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `da_note_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `da_note_comments`
--
ALTER TABLE `da_note_comments`
  ADD CONSTRAINT `da_note_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `da_note_comments_ibfk_3` FOREIGN KEY (`da_note_id`) REFERENCES `da_note` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`period_id`) REFERENCES `period` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`event_type_id`) REFERENCES `event_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_comments`
--
ALTER TABLE `event_comments`
  ADD CONSTRAINT `event_comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_comments_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_template`
--
ALTER TABLE `event_template`
  ADD CONSTRAINT `event_template_ibfk_1` FOREIGN KEY (`event_type_id`) REFERENCES `event_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_template_group`
--
ALTER TABLE `event_template_group`
  ADD CONSTRAINT `event_template_group_ibfk_1` FOREIGN KEY (`event_template_id`) REFERENCES `event_template` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_template_group_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `work_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `group_access`
--
ALTER TABLE `group_access`
  ADD CONSTRAINT `group_access_ibfk_1` FOREIGN KEY (`access_id`) REFERENCES `access` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_access_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `work_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `group_member`
--
ALTER TABLE `group_member`
  ADD CONSTRAINT `group_member_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `work_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_member_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `headwaiter_note`
--
ALTER TABLE `headwaiter_note`
  ADD CONSTRAINT `headwaiter_note_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `headwaiter_note_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `partyries_arrange`
--
ALTER TABLE `partyries_arrange`
  ADD CONSTRAINT `partyries_arrange_ibfk_2` FOREIGN KEY (`partyries_id`) REFERENCES `partyries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `partyries_arrange_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `da_note` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `partyries_work`
--
ALTER TABLE `partyries_work`
  ADD CONSTRAINT `partyries_work_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `da_note` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `partyries_work_ibfk_2` FOREIGN KEY (`partyries_id`) REFERENCES `partyries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_access`
--
ALTER TABLE `user_access`
  ADD CONSTRAINT `user_access_ibfk_1` FOREIGN KEY (`access_id`) REFERENCES `access` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_access_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_work`
--
ALTER TABLE `user_work`
  ADD CONSTRAINT `user_work_ibfk_1` FOREIGN KEY (`work_slot_id`) REFERENCES `work_slot` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_work_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `work_group`
--
ALTER TABLE `work_group`
  ADD CONSTRAINT `work_group_ibfk_2` FOREIGN KEY (`sub_group`) REFERENCES `work_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `work_group_ibfk_1` FOREIGN KEY (`main_group`) REFERENCES `work_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `work_group_leaders`
--
ALTER TABLE `work_group_leaders`
  ADD CONSTRAINT `work_group_leaders_ibfk_1` FOREIGN KEY (`work_group_id`) REFERENCES `work_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `work_group_leaders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `work_slot`
--
ALTER TABLE `work_slot`
  ADD CONSTRAINT `work_slot_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `work_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `work_slot_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
