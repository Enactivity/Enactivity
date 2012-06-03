-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 07, 2010 at 03:39 PM
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
  `creatorId` int(11) DEFAULT NULL,
  `groupId` int(11) NOT NULL,
  `starts` datetime NOT NULL,
  `ends` datetime NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `creatorId` (`creatorId`),
  KEY `groupId` (`groupId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `name`, `description`, `creatorId`, `groupId`, `starts`, `ends`, `location`, `created`, `modified`) VALUES
(1, 'MyEvent', 'The coolest thing ever!', 1, 5, '2011-10-16 18:00:01', '2011-11-16 18:00:01', 'Germany', '0000-00-00 00:00:00', '2010-10-31 14:16:04'),
(2, 'SuperEvent', 'Superman in town', 1, 6, '2011-10-13 18:00:01', '2011-11-16 18:00:01', 'Metropolis', '2010-10-16 20:32:21', '2010-10-16 20:32:21'),
(3, 'Another Testable Event', 'Just some filler for the awesomeness.', 1, 7, '2011-10-16 18:00:01', '2011-11-16 18:00:01', '', '2010-10-24 15:50:16', '2010-10-24 15:50:16'),
(4, 'Old Event', 'This event has expired', 1, 5, '2009-10-16 18:00:01', '2009-11-16 18:00:04', 'Back in time!', '2009-10-31 15:25:48', '2009-10-31 15:25:48');

-- --------------------------------------------------------

--
-- Table structure for table `event_user`
--

CREATE TABLE IF NOT EXISTS `event_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'Pending',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `eventId_2` (`eventId`,`userId`),
  KEY `eventId` (`eventId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `event_user`
--

INSERT INTO `event_user` (`id`, `eventId`, `userId`, `status`, `created`, `modified`) VALUES
(2, 1, 4, 'Attending', '2010-10-23 15:27:12', '2010-10-23 15:27:16'),
(11, 2, 1, 'Attending', '2010-11-06 19:51:00', '2010-11-07 12:28:37'),
(12, 1, 1, 'Attending', '2010-11-06 21:51:12', '2010-11-06 22:11:19'),
(13, 1, 25, 'Not Attending', '2010-11-07 14:50:58', '2010-11-07 14:51:04');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`, `slug`, `created`, `modified`) VALUES
(5, 'Alpha Phi Omega - Zeta', 'apo-zeta', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Alpha Phi Omega - Gamma Beta', 'apo-gb', '0000-00-00 00:00:00', '2010-10-16 22:32:40'),
(7, 'Alpha Phi Omega - Alpha Gamma Nu', 'apo-agn', '2010-10-16 18:00:01', '2010-10-16 18:00:01');

-- --------------------------------------------------------

--
-- Table structure for table `group_user`
--

CREATE TABLE IF NOT EXISTS `group_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'Pending',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `groupId_2` (`groupId`,`userId`),
  KEY `groupId` (`groupId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `group_user`
--

INSERT INTO `group_user` (`id`, `groupId`, `userId`, `status`, `created`, `modified`) VALUES
(1, 6, 1, 'Active', NULL, NULL),
(2, 5, 1, 'Active', '2010-10-17 13:31:51', '2010-10-17 13:31:51'),
(4, 5, 4, 'Active', '2010-10-17 13:52:35', '2010-10-17 13:52:35'),
(5, 5, 16, 'Pending', '2010-10-17 14:30:19', '2010-10-17 14:30:19'),
(6, 6, 4, 'Pending', '2010-10-17 14:52:55', '2010-10-17 14:52:55'),
(7, 5, 14, 'Pending', '2010-10-17 14:54:42', '2010-10-17 14:54:42'),
(9, 5, 25, 'Pending', '2010-10-17 14:55:25', '2010-10-17 14:55:25');

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
  UNIQUE KEY `token` (`token`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `token`, `password`, `firstName`, `lastName`, `status`, `created`, `modified`, `lastLogin`) VALUES
(1, 'admin', 'admin@poncla.com', '', '603985faa270737299d8fe094db4533e14d0a089', 'Poncla', 'Administrator', 'Active', '2010-10-10 00:00:00', '2010-10-10 00:00:00', NULL),
(4, 'tester', 'test@poncla.com', '0865818293977c11289e0e0c33ccae70035399c3', 'test', 'Veronica', 'Jones', 'Active', '2010-10-16 18:07:59', '2010-10-16 19:43:15', NULL),
(5, NULL, 'f5554@test.com', '5d7f3e28571af8824a910e81996f409b8a6f5bd9', '05a9beae965ac78613309639f774eb92c10cb017', NULL, NULL, 'Pending', '2010-10-16 18:11:32', '2010-10-16 18:11:32', NULL),
(6, NULL, 'test7@poncla.com', '3026c7aba32f8ef1bc234f7e8d4ab932008e4ec4', '05a9beae965ac78613309639f774eb92c10cb017', NULL, NULL, 'Pending', '2010-10-16 23:10:27', '2010-10-16 23:10:27', NULL),
(7, NULL, 'test8@poncla.com', '736ee60eac821167231de24ba04b6a775ef9bb36', '05a9beae965ac78613309639f774eb92c10cb017', NULL, NULL, 'Pending', '2010-10-16 23:10:44', '2010-10-16 23:10:44', NULL),
(14, NULL, 'test53@test.com', '8f8f2c17877ff581aa1db54ec3ca2b462937e9f2', '05a9beae965ac78613309639f774eb92c10cb017', NULL, NULL, 'Pending', '2010-10-16 23:43:16', '2010-10-16 23:43:16', NULL),
(15, NULL, 'test54@test.com', '50f255c3b18883fab1f9a7f97bf607dd8f3844aa', '05a9beae965ac78613309639f774eb92c10cb017', NULL, NULL, 'Pending', '2010-10-16 23:48:07', '2010-10-16 23:48:07', NULL),
(16, NULL, 'test55@test.com', '0e6030361256e442e4fdf252acfb4ce3ebf9d699', '05a9beae965ac78613309639f774eb92c10cb017', NULL, NULL, 'Pending', '2010-10-16 23:50:06', '2010-10-16 23:50:06', NULL),
(17, NULL, 'test57@test.com', 'ba90d97b00b74b1b16683b88cb3395afac38ef59', '05a9beae965ac78613309639f774eb92c10cb017', NULL, NULL, 'Pending', '2010-10-16 23:50:41', '2010-10-16 23:50:41', NULL),
(18, NULL, 'test58@test.com', 'f3160d5c35b54941071cf4c1e76378199bfdf8af', '05a9beae965ac78613309639f774eb92c10cb017', NULL, NULL, 'Pending', '2010-10-16 23:51:26', '2010-10-16 23:51:26', NULL),
(19, NULL, 'test52@test.com', '3f485c72d9d18709747932ca8328bfdf4d351d21', '05a9beae965ac78613309639f774eb92c10cb017', NULL, NULL, 'Pending', '2010-10-16 23:52:32', '2010-10-16 23:52:32', NULL),
(20, NULL, 'test56@test.com', '148f68fd4c09780c8a5f7e2cbae5e4f99f5e6b04', '05a9beae965ac78613309639f774eb92c10cb017', NULL, NULL, 'Pending', '2010-10-16 23:59:13', '2010-10-16 23:59:13', NULL),
(21, NULL, 'test68@test.com', '0af9af731a7254ef16914c9bebe1147ed07b50ef', '05a9beae965ac78613309639f774eb92c10cb017', NULL, NULL, 'Pending', '2010-10-17 00:11:10', '2010-10-17 00:11:10', NULL),
(22, NULL, 'test88@test.com', '9900327df5cfa9f4c0482482a171df0b0945311f', '05a9beae965ac78613309639f774eb92c10cb017', NULL, NULL, 'Pending', '2010-10-17 00:16:11', '2010-10-17 00:16:11', NULL),
(23, NULL, 'test98@test.com', '35c5e4a1d0d9e6ba791c478fb2b7f704f1a9abd4', '05a9beae965ac78613309639f774eb92c10cb017', NULL, NULL, 'Pending', '2010-10-17 00:22:14', '2010-10-17 00:22:14', NULL),
(25, 'joethesmo', 'newuser@poncla.com', '15739124e6aa9f603e5ca46a9b7ef2ff9ca160d0', '9e5ee4077d11e2212d24f2c127399c5099fef578', 'Joe', 'Smo', 'Active', '2010-10-17 14:55:25', '2010-11-07 14:39:48', NULL),
(35, NULL, 'ajsharma@poncla.com', '597ca79dcf019d90cac300e71f2bd4c5426cdf9c', NULL, NULL, NULL, 'Pending', '2010-11-07 14:56:29', '2010-11-07 14:56:29', NULL),
(36, NULL, 'ajsharma@localhost.com', '7485382ac9c667fadf9f6e7fc61485dfbe5e6ac6', NULL, NULL, NULL, 'Pending', '2010-11-07 14:58:02', '2010-11-07 14:58:02', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_3` FOREIGN KEY (`creatorId`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `event_ibfk_4` FOREIGN KEY (`groupId`) REFERENCES `group` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `event_user`
--
ALTER TABLE `event_user`
  ADD CONSTRAINT `event_user_ibfk_3` FOREIGN KEY (`eventId`) REFERENCES `event` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `event_user_ibfk_4` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `group_user`
--
ALTER TABLE `group_user`
  ADD CONSTRAINT `group_user_ibfk_1` FOREIGN KEY (`groupId`) REFERENCES `group` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `group_user_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON UPDATE CASCADE;
