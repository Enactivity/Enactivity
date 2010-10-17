-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 16, 2010 at 07:02 PM
-- Server version: 5.1.33
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `poncla_yii`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `creatorId` int(11) NOT NULL COMMENT 'CONSTRAINT FOREIGN KEY (creatorId) REFERENCES User(id)',
  `groupId` int(11) NOT NULL COMMENT 'CONSTRAINT FOREIGN KEY (groupId) REFERENCES Group(id)',
  `starts` datetime NOT NULL,
  `ends` datetime NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `name`, `description`, `creatorId`, `groupId`, `starts`, `ends`, `location`, `created`, `modified`) VALUES
(1, 'MyEvent', 'The coolest thing ever!', 1, 6, '2011-10-16 18:00:01', '2011-11-16 18:00:01', 'Germany', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `event_user`
--

CREATE TABLE IF NOT EXISTS `event_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventId` int(11) NOT NULL COMMENT 'CONSTRAINT FOREIGN KEY (eventId) REFERENCES Event(id)',
  `userId` int(11) NOT NULL COMMENT 'CONSTRAINT FOREIGN KEY (userId) REFERENCES User(id)',
  `status` varchar(15) NOT NULL DEFAULT 'Pending',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `eventuser` (`eventId`,`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `event_user`
--


-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`, `slug`, `created`, `modified`) VALUES
(6, 'Alpha Phi Omega - Gamma Beta', 'apo-gb', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Alpha Phi Omega - Zeta', 'apo-zeta', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Alpha Phi Omega - Alpha Gamma Nu', 'apo-agn', '2010-10-16 18:00:01', '2010-10-16 18:00:01');

-- --------------------------------------------------------

--
-- Table structure for table `group_user`
--

CREATE TABLE IF NOT EXISTS `group_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupId` int(11) NOT NULL COMMENT 'CONSTRAINT FOREIGN KEY (groupId) REFERENCES Group(id)',
  `userId` int(11) NOT NULL COMMENT 'CONSTRAINT FOREIGN KEY (userId) REFERENCES User(id)',
  `status` varchar(15) NOT NULL DEFAULT 'Pending',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `groupuser` (`groupId`,`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `group_user`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `token` varchar(40) NOT NULL,
  `password` varchar(40) DEFAULT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'Pending',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `lastLogin` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `token`, `password`, `firstName`, `lastName`, `status`, `created`, `modified`, `lastLogin`) VALUES
(1, 'ajsharma', 'ajsharma@poncla.com', '', '603985faa270737299d8fe094db4533e14d0a089', 'Ajay', 'Sharma', 'Pending', '2010-10-10 00:00:00', '2010-10-10 00:00:00', NULL),
(4, '0865818293977c11289e0e0c33ccae70035399c3', 'test@poncla.com', '0865818293977c11289e0e0c33ccae70035399c3', '05a9beae965ac78613309639f774eb92c10cb017', NULL, NULL, 'Pending', '2010-10-16 18:07:59', '2010-10-16 18:07:59', NULL),
(5, '', 'f5554@test.com', '5d7f3e28571af8824a910e81996f409b8a6f5bd9', '05a9beae965ac78613309639f774eb92c10cb017', NULL, NULL, 'Pending', '2010-10-16 18:11:32', '2010-10-16 18:11:32', NULL);
