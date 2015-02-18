-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2015 at 07:17 PM
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
-- Table structure for table `application`
--

CREATE TABLE IF NOT EXISTS `application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `ssn` varchar(10) NOT NULL,
  `mail` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`id`, `name`, `last_name`, `ssn`, `mail`) VALUES
(1, 'Simon', '.', '120395y082', 'rw');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `application_group`
--

INSERT INTO `application_group` (`id`, `group_id`, `application_id`) VALUES
(2, 2, 1),
(1, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `da_note`
--

CREATE TABLE IF NOT EXISTS `da_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `sales_entry` int(11) NOT NULL,
  `sales_bar` int(11) NOT NULL,
  `cash` int(11) NOT NULL,
  `n_of_people` int(11) NOT NULL,
  `sales_spenta` int(11) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`event_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `da_note`
--

INSERT INTO `da_note` (`id`, `user_id`, `event_id`, `sales_entry`, `sales_bar`, `cash`, `n_of_people`, `sales_spenta`, `message`) VALUES
(1, 1, 35, 9001, 80085, 1337, 69, 420, 'fest'),
(2, 2, 32, 142, 2, 2, 2, 2, '2'),
(3, 2, 31, 2, 2, 2, 2, 2, '2'),
(4, 2, 30, 2, 2, 2, 2, 2, '2'),
(5, 2, 4, 40333, 1, 1, 1, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `period_id` int(11) NOT NULL,
  `event_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `period_id` (`period_id`),
  KEY `event_type_id` (`event_type_id`),
  KEY `name_3` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `name`, `start_time`, `end_time`, `period_id`, `event_type_id`) VALUES
(1, 'Pizzaonsdag', '2014-02-19 18:00:00', '2014-02-19 22:00:00', 1, 1),
(2, 'Vårkravallen', '2014-03-08 22:00:00', '2014-03-09 03:00:00', 2, 2),
(4, 'Sittning', '2014-02-14 17:00:00', '2014-02-14 23:00:00', 1, 3),
(5, 'Personalfest', '2014-03-09 18:30:00', '2014-03-10 03:00:00', 2, 4),
(7, 'MT <3 GDK', '2014-02-22 18:00:00', '2014-02-22 22:00:00', 1, 3),
(10, 'Fotbollstisdag', '2014-02-25 20:00:00', '2014-02-25 22:00:00', 1, 1),
(11, 'Onsdagspub', '2014-02-26 18:00:00', '2014-02-26 22:00:00', 1, 1),
(26, 'Rockfesten', '2014-03-01 22:00:00', '2014-03-02 03:00:00', 2, 2),
(27, 'Kravallpub', '2014-02-27 18:00:00', '2014-02-28 01:00:00', 1, 1),
(29, 'nuu', '2014-03-06 18:00:00', '2014-03-06 22:00:00', 2, 1),
(30, 'Eventet', '2014-04-21 08:00:00', '2014-04-21 17:00:00', 3, 1),
(31, 'Puuhben', '2014-04-28 18:00:00', '2014-04-28 22:00:00', 3, 1),
(32, 'Le puub', '2014-04-28 18:00:00', '2014-04-28 22:00:00', 3, 1),
(34, 'Poop', '2014-10-27 18:00:00', '2014-10-28 01:00:00', 5, 1),
(35, 'Bleep', '2015-02-14 00:00:00', '2015-02-15 00:00:00', 2, 1),
(36, 'TORSDAG, FUCK YEAH', '2015-02-19 00:00:00', '2015-02-20 00:00:00', 2, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `event_template`
--

INSERT INTO `event_template` (`id`, `name`, `start_time`, `end_time`, `event_type_id`) VALUES
(5, 'Onsdagspub', '18:00:00', '22:00:00', 1),
(6, 'Vanlig nattklubb', '22:00:00', '03:00:00', 2),
(7, 'Vanlig pub', '18:00:00', '01:00:00', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `event_template_group`
--

INSERT INTO `event_template_group` (`id`, `start_time`, `end_time`, `points`, `event_template_id`, `group_id`) VALUES
(1, '2014-03-06 17:00:00', '2014-03-07 00:00:00', 3, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `event_type`
--

CREATE TABLE IF NOT EXISTS `event_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `event_type`
--

INSERT INTO `event_type` (`id`, `name`) VALUES
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

-- --------------------------------------------------------

--
-- Table structure for table `group_member`
--

CREATE TABLE IF NOT EXISTS `group_member` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_leader` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_member`
--

INSERT INTO `group_member` (`group_id`, `user_id`, `group_leader`) VALUES
(2, 1, 0),
(2, 2, 0),
(4, 1, 0),
(7, 1, 0),
(7, 2, 0),
(9, 2, 0),
(11, 1, 0),
(13, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `headwaiter_note`
--

CREATE TABLE IF NOT EXISTS `headwaiter_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `n_of_sitting` int(11) NOT NULL,
  `food` text NOT NULL,
  `invoice_drinks` text NOT NULL,
  `n_of_waiting_stair` int(11) NOT NULL,
  `n_of_waiting_organizers` int(11) NOT NULL,
  `toast` text NOT NULL,
  `organizers` text NOT NULL,
  `stair_staff` text NOT NULL,
  `organizers_staff` text NOT NULL,
  `swine` text NOT NULL,
  `message` text NOT NULL,
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
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `message`, `date`, `user_id`) VALUES
(1, 'Hej', 'Då', '2015-02-12 14:53:09', 2);

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
  `address` varchar(100) DEFAULT NULL,
  `zip` varchar(5) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bank_account` varchar(50) DEFAULT NULL,
  `special_food` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`user_name`,`mail`,`ssn`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `mail`, `ssn`, `password`, `name`, `last_name`, `phone_number`, `description`, `address`, `zip`, `city`, `avatar`, `date_created`, `bank_account`, `special_food`) VALUES
(1, 'Valross', 'valross@mail.com', '1111111234', '9b8c524273eaeab794fdd09a36f26e81', 'Hampus', 'Axelsson', '123456789', 'Jag är så cool!', NULL, NULL, NULL, 'portalen_bild.jpg', '0000-00-00 00:00:00', NULL, NULL),
(2, 'test', 'ankan@mail.com', '9901011245', 'cb15ee3da60f51d1f8cb94652b1539f3', 'Herpa', 'Derp', '123654879', NULL, NULL, NULL, NULL, 'rikge099.gif', '0000-00-00 00:00:00', NULL, NULL),
(3, 'test2', '1111@mail.com', '1111111111', 'cb15ee3da60f51d1f8cb94652b1539f3', 'Testarn', 'Testsson', '', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL),
(5, 'Trappan', '2222@mail.com', '2222222222', 'cb15ee3da60f51d1f8cb94652b1539f3', 'Harry', 'Gluten', '', NULL, NULL, NULL, NULL, NULL, '2014-02-19 14:00:19', NULL, NULL),
(6, 'Bajs', 'hej@mail.com', 'ssssssssss', '711284ca87ba99f7c8198840f5dc607c', 'Bajs', 'o kiss', '', NULL, NULL, NULL, NULL, NULL, '2014-02-19 15:24:25', NULL, NULL),
(7, 'HEEEJ', 'jjasdj', 'asdfsfs', '640702a7a1279095e6da83ba8f768cbf', 'dsads', 'MDMASDSD', '', NULL, NULL, NULL, NULL, NULL, '2014-10-22 15:41:02', NULL, NULL);

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
(4, 1, 1),
(5, 1, 1),
(6, 2, 1),
(7, 1, 1),
(62, 1, 1),
(75, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `work_group`
--

CREATE TABLE IF NOT EXISTS `work_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `name_2` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `work_group`
--

INSERT INTO `work_group` (`id`, `name`) VALUES
(13, 'Alla'),
(4, 'Bar'),
(7, 'Dagsansvarig'),
(5, 'DJ'),
(8, 'Event'),
(12, 'Hovmästare'),
(3, 'Kock'),
(10, 'Ljud & Ljus'),
(9, 'Marknadsföring'),
(11, 'Servering'),
(6, 'Värd'),
(2, 'Webb');

-- --------------------------------------------------------

--
-- Table structure for table `work_slot`
--

CREATE TABLE IF NOT EXISTS `work_slot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `work_slot`
--

INSERT INTO `work_slot` (`id`, `group_id`, `event_id`, `points`, `start_time`, `end_time`) VALUES
(4, 2, 1, 3, '2014-02-19 17:00:00', '2014-02-19 23:00:00'),
(5, 2, 4, 4, '2014-02-14 16:00:00', '2014-02-15 00:00:00'),
(6, 2, 1, 3, '2014-02-19 17:00:00', '2014-02-19 23:00:00'),
(7, 2, 2, 6, '2014-03-08 19:00:00', '2014-03-09 05:00:00'),
(8, 2, 2, 6, '2014-03-08 19:00:00', '2014-03-09 05:00:00'),
(9, 6, 5, 0, '2014-03-09 18:00:00', '2014-03-10 03:00:00'),
(10, 10, 5, 0, '2014-03-09 18:00:00', '2014-02-10 03:00:00'),
(11, 6, 10, 2, '2014-02-25 19:00:00', '2014-02-25 23:00:00'),
(35, 4, 26, 6, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(36, 4, 26, 6, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(37, 4, 26, 6, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(38, 4, 26, 6, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(39, 4, 26, 6, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(40, 7, 26, 6, '2014-03-01 16:00:00', '2014-03-02 05:00:00'),
(41, 5, 26, 0, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(42, 5, 26, 0, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(43, 6, 26, 6, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(44, 6, 26, 6, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(45, 6, 26, 6, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(46, 6, 26, 6, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(47, 10, 26, 0, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(48, 10, 26, 0, '2014-03-01 19:00:00', '2014-03-02 05:00:00'),
(49, 4, 27, 4, '2014-02-27 17:00:00', '2014-02-28 02:00:00'),
(50, 4, 27, 4, '2014-02-27 17:00:00', '2014-02-28 02:00:00'),
(51, 4, 27, 4, '2014-02-27 17:00:00', '2014-02-28 02:00:00'),
(52, 8, 27, 0, '2014-02-27 17:00:00', '2014-02-28 02:00:00'),
(53, 8, 27, 0, '2014-02-27 17:00:00', '2014-02-28 02:00:00'),
(54, 7, 27, 4, '2014-02-27 16:00:00', '2014-02-28 02:00:00'),
(55, 6, 27, 4, '2014-02-27 17:00:00', '2014-02-28 02:00:00'),
(56, 6, 27, 4, '2014-02-27 17:00:00', '2014-02-28 02:00:00'),
(57, 3, 27, 4, '2014-02-27 17:00:00', '2014-02-28 00:00:00'),
(58, 3, 27, 4, '2014-02-27 17:00:00', '2014-02-28 00:00:00'),
(59, 3, 27, 4, '2014-02-27 17:00:00', '2014-02-28 00:00:00'),
(61, 5, 29, 3, '2014-03-06 17:00:00', '2014-03-06 00:00:00'),
(62, 13, 30, 2, '2014-04-21 07:00:00', '2014-04-21 18:00:00'),
(63, 13, 30, 2, '2014-04-21 07:00:00', '2014-04-21 18:00:00'),
(64, 5, 31, 3, '2014-04-28 17:00:00', '2014-04-29 00:00:00'),
(65, 5, 32, 3, '2014-04-28 17:00:00', '2014-04-29 00:00:00'),
(66, 13, 32, 4, '2014-04-28 17:00:00', '2014-04-29 02:00:00'),
(67, 13, 32, 4, '2014-04-28 17:00:00', '2014-04-29 02:00:00'),
(71, 4, 34, 4, '2014-10-27 17:00:00', '2014-10-28 02:00:00'),
(72, 4, 34, 4, '2014-10-27 17:00:00', '2014-10-28 02:00:00'),
(73, 3, 34, 3, '2014-10-27 17:00:00', '2014-10-28 00:00:00'),
(74, 3, 34, 3, '2014-10-27 17:00:00', '2014-10-28 00:00:00'),
(75, 7, 34, 4, '2014-10-27 16:00:00', '2014-10-28 02:00:00');

--
-- Constraints for dumped tables
--

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
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`period_id`) REFERENCES `period` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`event_type_id`) REFERENCES `event_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `work_slot`
--
ALTER TABLE `work_slot`
  ADD CONSTRAINT `work_slot_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `work_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `work_slot_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
