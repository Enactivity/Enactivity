-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 10, 2011 at 01:22 PM
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
-- Table structure for table `activerecordlog`
--

CREATE TABLE IF NOT EXISTS `activerecordlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupId` int(11) NOT NULL,
  `model` varchar(45) NOT NULL,
  `modelId` int(11) DEFAULT NULL,
  `action` varchar(20) DEFAULT NULL,
  `modelAttribute` varchar(45) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `groupId` (`groupId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=95 ;

--
-- Dumping data for table `activerecordlog`
--

INSERT INTO `activerecordlog` (`id`, `groupId`, `model`, `modelId`, `action`, `modelAttribute`, `userId`, `created`, `modified`) VALUES
(1, 6, 'Event', 32, 'Update', 'name', 1, '2011-02-13 14:24:10', '2011-02-13 14:24:10'),
(2, 6, 'Event', 32, 'Update', 'modified', 1, '2011-02-13 14:24:10', '2011-02-13 14:24:10'),
(3, 6, 'Event', 32, 'Update', 'ends', 1, '2011-02-13 14:32:02', '2011-02-13 14:32:02'),
(4, 6, 'GroupBanter', 32, 'Create', '', 1, '2011-02-13 14:47:50', '2011-02-13 14:47:50'),
(5, 6, 'Event', 32, 'Delete', '', 1, '2011-02-13 14:51:45', '2011-02-13 14:51:45'),
(6, 6, 'GroupBanter', 33, 'Create', '', 1, '2011-02-13 14:54:10', '2011-02-13 14:54:10'),
(7, 5, 'GroupBanter', 34, 'Create', '', 1, '2011-02-13 15:37:21', '2011-02-13 15:37:21'),
(8, 5, 'GroupBanter', 34, 'Update', 'content', 1, '2011-02-13 15:37:48', '2011-02-13 15:37:48'),
(9, 6, 'GroupProfile', 6, 'Update', 'description', 1, '2011-02-13 19:34:47', '2011-02-13 19:34:47'),
(10, 6, 'Event', 30, 'Update', 'location', 1, '2011-02-13 20:03:36', '2011-02-13 20:03:36'),
(11, 5, 'GroupBanter', 35, 'Create', '', 1, '2011-02-13 20:06:43', '2011-02-13 20:06:43'),
(12, 5, 'GroupBanter', 35, 'Update', 'content', 1, '2011-02-16 20:36:27', '2011-02-16 20:36:27'),
(14, 6, 'Event', 16, 'Update', NULL, 1, '2011-02-20 14:53:39', '2011-02-20 14:53:39'),
(15, 6, 'Event', 16, 'Update', '', 1, '2011-02-20 14:54:34', '2011-02-20 14:54:34'),
(16, 6, 'Event', 16, 'replied to', '', 1, '2011-02-20 14:55:11', '2011-02-20 14:55:11'),
(17, 6, 'Event', 14, 'Update', 'starts', 1, '2011-02-20 15:03:45', '2011-02-20 15:03:45'),
(18, 6, 'Event', 14, 'Update', 'ends', 1, '2011-02-20 15:03:45', '2011-02-20 15:03:45'),
(19, 6, 'Event', 14, 'Update', 'location', 1, '2011-02-20 15:03:45', '2011-02-20 15:03:45'),
(20, 6, 'Event', 31, 'Create', '', 1, '2011-02-20 15:04:55', '2011-02-20 15:04:55'),
(21, 6, 'Event', 32, 'Create', '', 1, '2011-02-20 15:15:47', '2011-02-20 15:15:47'),
(22, 6, 'Event', 31, 'Update', 'location', 1, '2011-02-20 15:21:45', '2011-02-20 15:21:45'),
(23, 6, 'Event', 14, 'replied to', '', 1, '2011-02-20 15:35:21', '2011-02-20 15:35:21'),
(24, 6, 'Event', 14, 'replied to', '', 1, '2011-02-20 15:36:35', '2011-02-20 15:36:35'),
(25, 6, 'Event', 14, 'replied to', '', 1, '2011-02-20 15:36:36', '2011-02-20 15:36:36'),
(26, 6, 'Event', 14, 'is not attending', '', 1, '2011-02-20 15:47:36', '2011-02-20 15:47:36'),
(27, 6, 'Event', 14, 'updated', 'name', 1, '2011-02-20 15:49:44', '2011-02-20 15:49:44'),
(28, 6, 'Event', 14, 'updated', 'description', 1, '2011-02-20 15:49:44', '2011-02-20 15:49:44'),
(29, 6, 'Event', 14, 'updated', 'location', 1, '2011-02-20 15:49:44', '2011-02-20 15:49:44'),
(30, 6, 'Event', 28, 'replied to', '', 1, '2011-02-20 16:48:44', '2011-02-20 16:48:44'),
(31, 6, 'Event', 14, 'is not attending', '', 1, '2011-02-20 16:52:56', '2011-02-20 16:52:56'),
(33, 5, 'GroupBanter', 37, 'created', '', 1, '2011-02-20 17:24:06', '2011-02-20 17:24:06'),
(34, 5, 'GroupBanter', 34, 'replied to', '', 1, '2011-02-20 17:24:06', '2011-02-20 17:24:06'),
(35, 6, 'Event', 31, 'updated', 'name', 1, '2011-02-20 18:44:18', '2011-02-20 18:44:18'),
(36, 6, 'Event', 31, 'updated', 'description', 1, '2011-02-20 18:44:18', '2011-02-20 18:44:18'),
(37, 6, 'Event', 31, 'updated', 'location', 1, '2011-02-20 18:44:18', '2011-02-20 18:44:18'),
(38, 5, 'GroupBanter', 38, 'created', '', 1, '2011-02-20 18:54:33', '2011-02-20 18:54:33'),
(39, 6, 'Event', 14, 'replied to', '', 1, '2011-02-20 20:18:10', '2011-02-20 20:18:10'),
(40, 6, 'GroupBanter', 39, 'created', '', 1, '2011-02-20 20:33:39', '2011-02-20 20:33:39'),
(41, 6, 'GroupBanter', 40, 'created', '', 1, '2011-02-20 20:35:33', '2011-02-20 20:35:33'),
(42, 6, 'GroupBanter', 41, 'created', '', 1, '2011-02-20 20:35:54', '2011-02-20 20:35:54'),
(43, 6, 'GroupBanter', 42, 'created', '', 1, '2011-02-20 20:36:01', '2011-02-20 20:36:01'),
(44, 6, 'GroupBanter', 43, 'created', '', 1, '2011-02-20 20:36:11', '2011-02-20 20:36:11'),
(45, 6, 'GroupBanter', 44, 'created', '', 1, '2011-02-20 20:36:18', '2011-02-20 20:36:18'),
(46, 6, 'GroupBanter', 45, 'created', '', 1, '2011-02-20 20:36:29', '2011-02-20 20:36:29'),
(47, 6, 'GroupBanter', 46, 'created', '', 1, '2011-02-20 20:36:35', '2011-02-20 20:36:35'),
(48, 6, 'Event', 14, 'is not attending', '', 1, '2011-02-23 21:13:26', '2011-02-23 21:13:26'),
(49, 6, 'Event', 14, 'is not attending', '', 1, '2011-02-23 21:15:14', '2011-02-23 21:15:14'),
(50, 6, 'Event', 14, 'is not attending', '', 1, '2011-02-23 21:15:32', '2011-02-23 21:15:32'),
(51, 6, 'Event', 14, 'is not attending', '', 1, '2011-02-23 21:16:44', '2011-02-23 21:16:44'),
(52, 6, 'Event', 14, 'is not attending', '', 1, '2011-02-23 21:17:04', '2011-02-23 21:17:04'),
(53, 6, 'Event', 14, 'is not attending', '', 1, '2011-02-23 21:17:34', '2011-02-23 21:17:34'),
(54, 6, 'Event', 14, 'is not attending', '', 1, '2011-02-23 21:27:25', '2011-02-23 21:27:25'),
(55, 6, 'Event', 14, 'is not attending', '', 1, '2011-02-23 21:28:42', '2011-02-23 21:28:42'),
(56, 6, 'Event', 14, 'is not attending', '', 1, '2011-02-23 21:29:43', '2011-02-23 21:29:43'),
(57, 6, 'Event', 14, 'is attending', '', 1, '2011-02-23 21:30:55', '2011-02-23 21:30:55'),
(58, 6, 'Event', 28, 'updated', 'description', 1, '2011-02-24 01:25:33', '2011-02-24 01:25:33'),
(59, 6, 'Event', 28, 'updated', 'name', 1, '2011-02-24 21:40:33', '2011-02-24 21:40:33'),
(60, 6, 'Event', 28, 'updated', 'description', 1, '2011-02-24 21:40:33', '2011-02-24 21:40:33'),
(61, 6, 'Event', 28, 'updated', 'location', 1, '2011-02-24 21:40:33', '2011-02-24 21:40:33'),
(62, 6, 'Event', 14, 'updated', 'name', 1, '2011-02-24 21:42:08', '2011-02-24 21:42:08'),
(63, 6, 'Event', 14, 'updated', 'description', 1, '2011-02-24 21:42:08', '2011-02-24 21:42:08'),
(64, 6, 'Event', 16, 'updated', 'name', 1, '2011-02-24 21:42:57', '2011-02-24 21:42:57'),
(65, 6, 'Event', 16, 'updated', 'description', 1, '2011-02-24 21:42:57', '2011-02-24 21:42:57'),
(66, 6, 'Event', 31, 'updated', 'name', 1, '2011-02-24 21:43:53', '2011-02-24 21:43:53'),
(67, 6, 'Event', 31, 'updated', 'description', 1, '2011-02-24 21:43:53', '2011-02-24 21:43:53'),
(68, 6, 'Event', 31, 'updated', 'location', 1, '2011-02-24 21:43:53', '2011-02-24 21:43:53'),
(69, 6, 'Event', 28, 'updated', 'description', 1, '2011-02-24 21:47:43', '2011-02-24 21:47:43'),
(70, 6, 'Event', 14, 'is not attending', '', 1, '2011-02-25 21:23:02', '2011-02-25 21:23:02'),
(71, 6, 'Event', 14, 'is attending', '', 1, '2011-02-25 21:23:05', '2011-02-25 21:23:05'),
(72, 6, 'Event', 14, 'is not attending', '', 1, '2011-02-25 21:23:42', '2011-02-25 21:23:42'),
(73, 6, 'Event', 28, 'is attending', '', 1, '2011-02-27 12:01:40', '2011-02-27 12:01:40'),
(74, 6, 'GroupBanter', 41, 'updated', 'content', 1, '2011-03-01 22:34:36', '2011-03-01 22:34:36'),
(75, 2, 'Event', 33, 'posted', '', NULL, '2011-03-27 13:50:39', '2011-03-27 13:50:39'),
(76, 4, 'Event', 34, 'posted', '', NULL, '2011-03-27 13:50:39', '2011-03-27 13:50:39'),
(77, 2, 'Event', 35, 'posted', '', NULL, '2011-04-10 12:34:15', '2011-04-10 12:34:15'),
(78, 4, 'Event', 36, 'posted', '', NULL, '2011-04-10 12:34:15', '2011-04-10 12:34:15'),
(79, 2, 'Event', 37, 'posted', '', NULL, '2011-04-10 12:38:40', '2011-04-10 12:38:40'),
(80, 4, 'Event', 38, 'posted', '', NULL, '2011-04-10 12:38:41', '2011-04-10 12:38:41'),
(81, 2, 'Event', 39, 'posted', '', NULL, '2011-04-10 12:42:17', '2011-04-10 12:42:17'),
(82, 4, 'Event', 40, 'posted', '', NULL, '2011-04-10 12:42:17', '2011-04-10 12:42:17'),
(83, 2, 'Event', 41, 'posted', '', NULL, '2011-04-10 12:50:56', '2011-04-10 12:50:56'),
(84, 4, 'Event', 42, 'posted', '', NULL, '2011-04-10 12:50:57', '2011-04-10 12:50:57'),
(85, 2, 'Event', 43, 'posted', '', NULL, '2011-04-10 12:53:41', '2011-04-10 12:53:41'),
(86, 4, 'Event', 44, 'posted', '', NULL, '2011-04-10 12:53:41', '2011-04-10 12:53:41'),
(87, 2, 'Event', 45, 'posted', '', NULL, '2011-04-10 13:05:23', '2011-04-10 13:05:23'),
(88, 4, 'Event', 46, 'posted', '', NULL, '2011-04-10 13:05:23', '2011-04-10 13:05:23'),
(89, 2, 'Event', 47, 'posted', '', NULL, '2011-04-10 13:08:49', '2011-04-10 13:08:49'),
(90, 4, 'Event', 48, 'posted', '', NULL, '2011-04-10 13:08:49', '2011-04-10 13:08:49'),
(91, 2, 'Event', 49, 'posted', '', NULL, '2011-04-10 13:11:45', '2011-04-10 13:11:45'),
(92, 4, 'Event', 50, 'posted', '', NULL, '2011-04-10 13:11:45', '2011-04-10 13:11:45'),
(93, 2, 'Event', 51, 'posted', '', NULL, '2011-04-10 13:12:18', '2011-04-10 13:12:18'),
(94, 4, 'Event', 52, 'posted', '', NULL, '2011-04-10 13:12:18', '2011-04-10 13:12:18');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(75) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `name`, `description`, `creatorId`, `groupId`, `starts`, `ends`, `location`, `created`, `modified`) VALUES
(3, 'Another Testable Event', 'Just some filler for the awesomeness.', 1, 7, '2011-10-16 18:00:01', '2011-11-16 18:00:01', '', '2010-10-24 15:50:16', '2010-10-24 15:50:16'),
(5, 'Who likes to write code?', 'I do!', 25, 5, '2011-10-16 18:00:01', '2010-11-16 18:00:04', 'Any where that has a computer and an internet connection and some sort of thingy for writing code, like a printer.', '2010-11-07 17:04:06', '2010-11-07 17:04:06'),
(6, 'Another event yo', 'Needed more events', 1, 5, '2011-10-16 18:00:01', '2010-11-16 18:00:04', 'Any where that has a computer and an internet connection and some sort of thingy for writing code, like a printer.', '2010-11-21 15:05:28', '2010-11-21 15:05:28'),
(7, 'Proin leo odio, aliquam vitae semper non, tempus sed risus. In hac volutpat', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eleifend fermentum tortor nec lacinia. Mauris justo odio, posuere sit amet molestie in, vehicula sed nibh. \r\n\r\nSuspendisse porta nulla sagittis nisi lacinia a scelerisque metus iaculis. Vivamus eu massa gravida urna ultrices bibendum adipiscing ut purus. Ut vehicula placerat mi et euismod. Quisque pretium, leo in ullamcorper luctus, tortor sapien scelerisque risus, a ullamcorper mi ipsum quis sem. Nulla ac eros ipsum. Duis tincidunt tortor et diam tristique a commodo felis tempor. Nam bibendum sagittis tellus vitae tempor. Suspendisse ac turpis sed metus commodo consectetur in a nisi. Nulla vitae leo ac justo consectetur gravida. Maecenas placerat lobortis felis, quis tempus lectus viverra sit amet. Praesent nunc magna, commodo sit amet pulvinar quis, fringilla nec mi.  Quisque quis ipsum diam, nec pulvinar nisl. Cras in est est, et blandit massa. Morbi vitae turpis egestas mi consectetur vulputate. Morbi aliquam aliquam est, sed rutrum metus sollicitudin non. Nullam aliquet augue quis nibh malesuada et facilisis nisl pulvinar. Nunc mollis, quam ut commodo tempus, eros risus aliquam mi, nec fringilla diam felis et urna. Quisque risus ante, vestibulum eu dictum ut, tristique accumsan velit. In consectetur neque id nunc euismod feugiat. Duis eget tortor nunc. Suspendisse hendrerit lobortis consequat. Fusce eu dolor urna, quis rhoncus massa. Maecenas purus sapien, luctus ac vulputate nec, convallis at magna.  In luctus feugiat dolor, vel dictum ante sagittis non. Cras eu felis libero, vel elementum justo. Vivamus neque tellus, feugiat eu gravida bibendum, porttitor nec dolor. Suspendisse sit amet nisl nec diam pharetra volutpat. Proin lacinia, dui non vehicula porta, tellus libero aliquet tortor, at aliquet turpis odio non lacus. Cras consequat ornare nisi, eu dignissim augue ultricies ac. Ut cursus feugiat diam, ut pulvinar augue sagittis id. Etiam eleifend, libero posuere lobortis rhoncus, mauris diam adipiscing massa, quis tempor odio quam a leo. Cras purus justo, pharetra quis ultricies sit amet, pellentesque eu nisi. Vestibulum massa dolor, sagittis euismod venenatis ac, consectetur ac enim. Donec facilisis sem eget est porttitor sed dictum nisi sollicitudin. Nunc eu sapien eget elit elementum sollicitudin id laoreet velit. Nullam ullamcorper rutrum fringilla. Phasellus ante ipsum, aliquam sed molestie ut, lacinia ac felis. Quisque condimentum, nulla nec tempor accumsan, arcu metus sagittis urna, faucibus fringilla lorem orci et nisi. Cras ante ante, lacinia ullamcorper iaculis in, laoreet a erat. Vivamus vestibulum fringilla mollis.  Praesent dictum fermentum vestibulum. Vestibulum pretium erat sit amet sem molestie a viverra orci posuere. Fusce facilisis pulvinar gravida. Vivamus auctor gravida tincidunt. Proin hendrerit volutpat malesuada. Quisque volutpat, nisi eu pellentesque pharetra, ipsum ipsum faucibus felis, tristique tristique lacus quam ac turpis. Praesent laoreet suscipit enim quis sollicitudin. Nunc molestie augue nec massa congue lacinia. Nulla ut leo lacus, non sodales nulla. Nullam id vehicula tellus. Sed at nisl nec nisl feugiat rhoncus eu ut nisi. Etiam dui mi, eleifend in bibendum nec, pretium ut ipsum.  Donec ultrices gravida dui, et ornare dolor consequat et. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Maecenas pretium tellus id purus rutrum et mollis ipsum hendrerit. In eget elit vel urna ullamcorper semper. Donec auctor arcu ac felis consequat cursus. Aliquam erat volutpat. Vivamus accumsan massa nec urna bibendum eleifend. Aliquam quis vestibulum turpis. Suspendisse sed tellus non dui luctus fringilla. Mauris fringilla diam eu orci malesuada viverra. Suspendisse ac ipsum et magna tempor lacinia id non purus. Quisque in nibh et quam imperdiet venenatis. \r\n\r\nUt sit amet elit est, vitae gravida magna. Fusce adipiscing, neque id dapibus tincidunt, sem augue porta enim, at pulvinar massa tellus ac', 1, 6, '2011-07-11 18:00:00', '2011-11-16 19:00:00', 'Lorem ipsum dolor sit amet, _consectet_ adipiscing elit. Morbi *digniss*, lectus vel bibendum porttitor, magna mauris tempus turpis, ac ornare nunc eros at est. Phasellus ullamcorper libero ut justo mattis semper. Sed faucibus viverra ultrices massa nunc.', '2010-11-21 15:07:13', '2010-12-07 23:20:10'),
(8, 'Gonna drop some sweet YouTube up in this thing', 'You tooooooooooooob!!\r\n\r\n<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/lBw1qqDyWVQ?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/lBw1qqDyWVQ?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>', 1, 5, '2011-11-16 18:00:01', '2011-11-19 18:00:01', '', '2010-11-28 13:42:41', '2010-11-28 13:42:41'),
(9, 'Northside Community Center - Serving Lunch to Seniors', 'Serving lunch to seniors for the Nutrition Program which include: preparation; kitchen aid (3 volunteers) and Serving (7 volunteers); clean-up; and talking and dancing with seniors (great opportunity for nursing students and other related majors). \r\nAll volunteers will help with preparation and clean-up. ', 1, 5, '2011-01-13 11:00:01', '2011-01-13 13:00:01', 'Northside Community Center', '2010-12-02 22:20:49', '2010-12-02 22:20:54'),
(10, 'Test with Date Picker', '', 1, 5, '2010-12-09 00:00:00', '2010-12-12 15:40:00', '', '2010-12-05 14:39:08', '2010-12-05 15:57:04'),
(11, 'Testing events', '', 1, 5, '2010-12-07 00:00:00', '2010-12-07 16:41:00', '', '2010-12-07 00:45:02', '2010-12-07 00:45:02'),
(12, 'Superlongeventnameeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee', 'Loremipsumdolorsitamet,consecteturadipiscingelit.Donecrutrumnislinnisitinciduntfeugiat.Fuscemaurislectus,mollisneceuismodeu,volutpatetneque.Aliquamegetjustoelit.Aeneanlacusmi,hendreritsodalesplaceratac,sodalesasem.Sedvenenatisgravidaest.Praesentsemperfermentumleofermentumsollicitudin.Aliquameratvolutpat.Curabitursemperdolorvelnisleuismodacaccumsanlectusfermentum.Proincondimentum,semegetvestibulumcursus,esttortorconvallisurna,sedsemperduiligulaegetmauris.Fuscevenenatisnuncetnisihendrerittempor.VestibulumanteipsumprimisinfaucibusorciluctusetultricesposuerecubiliaCurae;Quisquelobortissapienacnunccursusnecbibendumloremvestibulum.Proinsitametimperdietmagna.Sedrisusipsum,laoreetnecelementumid,posuereultricieserat.Utetmetusametuseleifendornare.Donecquamtortor,egestassitametvehiculaeget,venenatisnectortor.Proindignissimpharetraaliquam.Vivamusaeliterat.Nullamornareelementumnunc,velcongueloremlobortisvitae.Doneceunequeatdolorporttitortincidunt.Pellentesquemalesuadaipsumaeratsodalespretium.Vestibulumpulvinartempusvehicula.Vivamusporttitornisldictumdolortemporvitaemollisurnacommodo.Morbiimperdietmisitametdolorcondimentumsitametconguenibhaccumsan.Duisdictumconvallistellusavestibulum.Aliquamsitametipsumaelitrhoncusporttitor.Aliquamsitametmiquisloremviverramollissedsedsapien.Insitametnisilacus,fermentumvehiculanulla.Vivamuseunullalectus.Maecenassednibhatestaliquamluctus.Curabiturtristiquepellentesquerisus,sedtempusdiamrutrumsed.Phasellusmalesuadamolestieduisedultrices.Duissagittis,nislbibendumpretiumtincidunt,massamassavulputateligula,vitaevulputatenibhtortorvitaemi.Aliquamligulaodio,luctusvitaerutrumeget,auctornecquam.Integerviverraquamvelsemeleifendscelerisque.Phasellusvehicula,eratvitaefringillafermentum,orcinisimollisleo,utluctuseratarcuidrisus.Morbialiqueturnanonleosodalesvitaeimperdiettortorconvallis.Maurisviverramagnaacmassadignissimetornaremetusullamcorper.Loremipsumdolorsitamet,consecteturadipiscingelit.Donecconsequatlectusutdiamaliquamtempus.Vivamusornareeratetipsumaccumsanquisinterdumenimfacilisis.Aeneannonquamquisipsumtemporblandit.Nullavehiculaleoatquamultricesetultriciesmagnasollicitudin.Praesentviverraipsumsapien,ettinciduntnibh.Insedlacuslacus.Quisquerhoncusplaceratbibendum.Sedfaucibusliberononnuncaccumsansedrutrumauguedignissim.Ininnisimi,eutempusneque.Donecveliaculismi.Quisquevenenatissuscipitmassa,necvolutpatvelitsagittisvel.Inacsapienligula,etcommodoelit.Quisqueviverra,erosnecmollissagittis,leonunccondimentumligula,velluctuserosauguerhoncuslorem.Nuncnisierat,dignissimeulaoreeteu,viverravitaeest.Namidduiurna,sedfeugiatjusto.Sedultriciesliberoinligulamolestienonelementummaurislacinia.Integereleifendinterdumlacus,idconsecteturmetuslobortisnec.Loremipsumdolorsitamet,consecteturadipiscingelit.Proinfringillafeugiatvolutpat.Etiametanteenim,sitametportasem.Sedscelerisquetellusveldiamconsecteturtempor.Integeranullaquisrisusconguedignissim.Donecmagnanunc,iaculisnonelementumid,sodalesatvelit.Donecindolortortor,atmalesuadaleo.Morbivehiculaerateusapienportaposuere.Namidtortororci,egettincidunterat.Etiamvestibulumporttitortempor.Nameuligularisus.Fuscetinciduntaliquamlorem,sitametultriciesturpisconsequatvitae.Cumsociisnatoquepenatibusetmagnisdisparturientmontes,nasceturridiculusmus.Curabituratantedolor.Aeneanleosem,ornareeuvenenatisquis,aliquetidmetus.Vivamusinterdum,doloracconvallispretium,puruseratmollislectus,inelementumanteenimnecante.Maurisvolutpat.', 1, 5, '2011-12-29 10:22:00', '2011-12-30 00:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec rutrum nisl in nisi tincidunt feugiat. Fusce mauris lectus, mollis nec euismod eu, volutpat et neque. Aliquam eget justo elit. Aenean lacus mi, hendrerit sodales placerat ac, sodales a sem. Se', '2010-12-07 21:33:53', '2010-12-29 14:57:20'),
(13, 'New Year''s Day', '', 1, 5, '2011-01-01 00:00:00', '2011-01-02 00:00:00', '', '2010-12-11 19:48:53', '2010-12-11 19:48:53'),
(14, 'Frozen Yogurt Observing Fellowship', 'Come out and meet the pledges! \r\nFrozen Yogurt (possibly at the new Frozen Yogurt place by Iguanas) @8pm', 1, 6, '2011-05-27 00:00:00', '2011-05-28 00:00:00', 'Chuckie Cheese', '2010-12-29 15:00:06', '2011-02-24 21:42:08'),
(16, 'SJSU Botany Garden', 'Working on the SJSU Botany Garden, helping out the Botany Club. \r\nThis is to give you guys a heads up about this project til I get this approved by the VP Service. \r\nAnd you can start early on your requirements for next semester.', 1, 6, '2011-05-27 08:30:00', '2011-05-27 15:15:00', '', '2010-12-29 15:02:06', '2011-02-24 21:42:57'),
(18, 'Summer', '', 1, 6, '2011-07-16 07:00:00', '2011-07-16 07:00:00', 'the beach', '2010-12-29 15:03:44', '2010-12-29 15:03:44'),
(19, 'Autumn times', '', 1, 6, '2011-10-14 09:00:00', '2011-10-14 10:00:00', '', '2010-12-29 15:04:14', '2010-12-29 15:04:14'),
(20, 'Student Organization Leadership Conference', 'Approved by Service VP Ashley \r\nName of Event: Student Organization Leadership Conference \r\nWhat "C" does it fall under: Campus \r\nDate: 9/25/2010 \r\nTime: 8am-4:30pm \r\nMeeting Location and Time: Meet at Clark Hall by 8am \r\nDress Code: Letters \r\nDrivers Credit: No \r\nNumber of people needed: :) lots \r\nLocation: \r\nClark Hall @ SJSU \r\n\r\nALSO: A huge part of the success of the conference depends on our volunteers! Volunteers with get the chance to meet and network with hundreds of student leaders on campus, get a free lunch, free t-shirt, and a fun experience! This opportunity is open to all San Jose State Students. This is a great opportunity if there are more than two members in your organization that would like to be a part of this year’s conference! \r\n\r\nRegister on this link if you would like to volunteer. \r\nhttp://www.sjsu.edu/getinvolved/soal/student_orgs/org_conference/volunteer_info/ \r\n\r\nContact Person and information: \r\nKaren Malm \r\nKaren.Malm@sjsu.edu \r\n\r\nProject Description: \r\n\r\nThe Student Organization Leadership Conference is held every Fall on campus for campus organizations. Two members of each organization must attend in order to gain recognition by the university. There are over 200 organizations on campus so this event will need help! \r\n\r\nWe will help with set up for the event, registration tables, set up for lunch and also be floaters for the event. There may be other tasks not listed, but essentially, we will support the coordinators of the event. \r\n\r\nRegister on this link if you would like to volunteer. \r\nhttp://www.sjsu.edu/getinvolved/soal/student_orgs/org_conference/volunteer_info/ \r\n', 1, 6, '2011-08-05 11:34:00', '2011-08-05 11:34:00', '', '2010-12-29 15:04:53', '2010-12-29 15:15:31'),
(21, 'Testing events with default behaviors', '', 25, 5, '2011-01-12 00:00:00', '2011-01-27 00:00:00', '', '2011-01-07 18:22:04', '2011-01-07 18:22:04'),
(22, 'heeeeeeeeeeeeeeey', '', 1, 7, '1969-12-31 16:00:00', '1969-12-31 16:00:00', '', '2011-01-25 22:47:55', '2011-01-25 22:47:55'),
(23, 'Datepicker test event', '', 1, 7, '2011-01-26 00:00:00', '2011-01-26 00:00:00', '', '2011-01-26 00:33:39', '2011-01-26 00:33:59'),
(24, 'Testing the new datepicker widget', '', 1, 7, '2011-01-28 11:45:00', '2011-01-28 12:00:00', '', '2011-01-27 21:24:32', '2011-01-27 21:24:32'),
(25, 'Testing scope today', '', 1, 7, '2011-01-30 08:15:00', '2011-01-31 14:15:00', '', '2011-01-30 14:01:28', '2011-01-30 14:01:28'),
(26, 'Scope Today Event', '', 1, 6, '2011-01-30 12:00:00', '2011-01-31 12:00:00', '', '2011-01-30 14:03:18', '2011-01-30 14:03:18'),
(27, 'test', '', 1, 6, '2011-02-07 12:00:00', '2011-02-07 12:00:00', '', '2011-02-06 13:07:57', '2011-02-06 13:07:57'),
(28, 'Trust Health Food Basket', '# of brothers needed: 3-6 \r\nDress Code: Letters/Pledge Uniform \r\nWear comfortable "work" clothes and closed-toed shoes (i.e., jeans, walking shorts, tennis shoes, etc.) Please do not wear sandals, halter or tank tops, short shorts, etc. \r\nDrivers Credit: Yes \r\nLocation: \r\n1043 Garland Avenue, \r\nSan Jose, CA 95126! \r\n\r\nContact Person and information: \r\nCindy Barboza \r\nCoordinator, AIDS Services Food Program \r\nA Program of The Health Trust \r\n1043 Garland Avenue \r\n\r\nSan Jose, CA 95126 \r\n408-297-1294 phone \r\n408-297-0584 fax \r\n\r\nProject Description: \r\nVolunteer will help pack and organize food for the public. \r\n\r\nChairs: \r\n1. \r\n2. \r\n3. \r\n4.', 1, 6, '2011-03-01 11:30:00', '2011-03-01 12:00:00', 'Meet at the DC 12:20pm', '2011-02-07 23:45:23', '2011-02-24 21:47:43'),
(30, 'Pizza Lunch', 'Fooooood is good.', 1, 6, '2011-02-15 12:00:00', '2011-02-15 12:15:00', 'Pizza Hut', '2011-02-13 12:18:23', '2011-02-13 20:03:36'),
(31, 'Rebuilding Together: Biennial Homeless Census', 'Volunteers will be paired up with a guide from Rebuilidng Together and sent to a certain location where homeless are present. The volunteer and the guide will count how many homeless people are in that location and build a census. There will be no interaction with the homeless just observations. Here is the link if you want to sign up http://www.surveymonkey.com/s.aspx?sm=344ItXQ6zs1l09YWY3IdQQ_3d_3d', 1, 6, '2011-03-16 11:30:00', '2011-03-17 12:30:00', 'Dining Common Steps', '2011-02-20 15:04:55', '2011-02-24 21:43:53'),
(32, 'babab', '', 1, 6, '1969-12-31 16:00:00', '1969-12-31 16:00:00', '', '2011-02-20 15:15:47', '2011-02-20 15:15:47'),
(33, 'Test Event', '', NULL, 2, '2011-03-28 12:00:00', '2011-03-28 12:00:00', '', '2011-03-27 13:50:38', '2011-03-27 13:50:38'),
(34, 'Test Event', '', NULL, 4, '2011-03-28 12:00:00', '2011-03-28 12:00:00', '', '2011-03-27 13:50:39', '2011-03-27 13:50:39'),
(35, 'Test Event', '', NULL, 2, '2011-04-11 12:00:00', '2011-04-11 12:00:00', '', '2011-04-10 12:34:15', '2011-04-10 12:34:15'),
(36, 'Test Event', '', NULL, 4, '2011-04-11 12:00:00', '2011-04-11 12:00:00', '', '2011-04-10 12:34:15', '2011-04-10 12:34:15'),
(37, 'Test Event', '', NULL, 2, '2011-04-11 12:00:00', '2011-04-11 12:00:00', '', '2011-04-10 12:38:40', '2011-04-10 12:38:40'),
(38, 'Test Event', '', NULL, 4, '2011-04-11 12:00:00', '2011-04-11 12:00:00', '', '2011-04-10 12:38:41', '2011-04-10 12:38:41'),
(39, 'Test Event', '', NULL, 2, '2011-04-11 12:00:00', '2011-04-11 12:00:00', '', '2011-04-10 12:42:17', '2011-04-10 12:42:17'),
(40, 'Test Event', '', NULL, 4, '2011-04-11 12:00:00', '2011-04-11 12:00:00', '', '2011-04-10 12:42:17', '2011-04-10 12:42:17'),
(41, 'Test Event', '', NULL, 2, '2011-04-11 12:00:00', '2011-04-11 12:00:00', '', '2011-04-10 12:50:56', '2011-04-10 12:50:56'),
(42, 'Test Event', '', NULL, 4, '2011-04-11 12:00:00', '2011-04-11 12:00:00', '', '2011-04-10 12:50:57', '2011-04-10 12:50:57'),
(43, 'Test Event', '', NULL, 2, '2011-04-11 12:00:00', '2011-04-11 12:00:00', '', '2011-04-10 12:53:41', '2011-04-10 12:53:41'),
(44, 'Test Event', '', NULL, 4, '2011-04-11 12:00:00', '2011-04-11 12:00:00', '', '2011-04-10 12:53:41', '2011-04-10 12:53:41'),
(45, 'Test Event', '', NULL, 2, '2011-04-11 12:00:00', '2011-04-11 12:00:00', '', '2011-04-10 13:05:23', '2011-04-10 13:05:23'),
(46, 'Test Event', '', NULL, 4, '2011-04-11 12:00:00', '2011-04-11 12:00:00', '', '2011-04-10 13:05:23', '2011-04-10 13:05:23'),
(47, 'Test Event', '', NULL, 2, '2011-04-11 12:00:00', '2011-04-11 12:00:00', '', '2011-04-10 13:08:48', '2011-04-10 13:08:48'),
(48, 'Test Event', '', NULL, 4, '2011-04-11 12:00:00', '2011-04-11 12:00:00', '', '2011-04-10 13:08:49', '2011-04-10 13:08:49'),
(49, 'Test Event', '', NULL, 2, '2011-04-11 12:00:00', '2011-04-11 12:00:00', '', '2011-04-10 13:11:45', '2011-04-10 13:11:45'),
(50, 'Test Event', '', NULL, 4, '2011-04-11 12:00:00', '2011-04-11 12:00:00', '', '2011-04-10 13:11:45', '2011-04-10 13:11:45'),
(51, 'Test Event', '', NULL, 2, '2011-04-11 12:00:00', '2011-04-11 12:00:00', '', '2011-04-10 13:12:18', '2011-04-10 13:12:18'),
(52, 'Test Event', '', NULL, 4, '2011-04-11 12:00:00', '2011-04-11 12:00:00', '', '2011-04-10 13:12:18', '2011-04-10 13:12:18');

-- --------------------------------------------------------

--
-- Table structure for table `event_banter`
--

CREATE TABLE IF NOT EXISTS `event_banter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creatorId` int(11) DEFAULT NULL,
  `eventId` int(11) NOT NULL COMMENT 'The event that this banter refers to',
  `content` varchar(4000) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `creatorId` (`creatorId`),
  KEY `parentId` (`eventId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `event_banter`
--

INSERT INTO `event_banter` (`id`, `creatorId`, `eventId`, `content`, `created`, `modified`) VALUES
(2, 1, 21, 'Yeah, pretty cool', '2011-01-19 22:30:18', '2011-01-19 22:30:18'),
(6, 1, 21, 'That comment makes no sense since you deleted the comments that came before it!', '2011-01-25 23:16:18', '2011-01-25 23:16:18'),
(7, 1, 24, 'Excellent.', '2011-01-27 21:24:40', '2011-01-27 21:24:40'),
(8, 1, 14, 'test', '2011-02-02 21:08:16', '2011-02-02 21:08:16'),
(10, 1, 27, 'sca', '2011-02-06 13:08:05', '2011-02-06 13:08:05'),
(11, 1, 30, 'Blarg, I ate pizza yesterday', '2011-02-13 14:52:31', '2011-02-13 14:52:31'),
(12, 1, 8, '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/lBw1qqDyWVQ?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/lBw1qqDyWVQ?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>', '2011-02-17 22:44:34', '2011-02-17 22:44:34'),
(13, 1, 28, '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/lBw1qqDyWVQ?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/lBw1qqDyWVQ?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>', '2011-02-17 22:45:56', '2011-02-17 22:45:56'),
(14, 1, 28, 'cool', '2011-02-20 16:48:44', '2011-02-20 16:48:44'),
(15, 1, 14, 'I want to go!', '2011-02-20 20:18:10', '2011-02-20 20:18:10');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `event_user`
--

INSERT INTO `event_user` (`id`, `eventId`, `userId`, `status`, `created`, `modified`) VALUES
(14, 5, 25, 'Attending', '2010-11-07 17:31:06', '2010-11-07 17:31:12'),
(15, 7, 1, 'Attending', '2010-11-28 14:17:52', '2010-12-05 19:15:46'),
(16, 9, 1, 'Not Attending', '2010-12-07 23:22:10', '2011-01-05 14:28:59'),
(17, 8, 1, 'Attending', '2010-12-08 23:30:34', '2010-12-08 23:30:34'),
(18, 10, 1, 'Not Attending', '2010-12-08 23:32:17', '2010-12-12 12:55:01'),
(19, 12, 1, 'Attending', '2010-12-21 19:02:49', '2010-12-21 19:02:49'),
(20, 16, 1, 'Not Attending', '2011-01-05 14:21:04', '2011-02-20 14:55:11'),
(22, 21, 1, 'Not Attending', '2011-01-07 20:29:27', '2011-01-19 21:37:01'),
(23, 8, 25, 'Attending', '2011-01-07 20:36:33', '2011-01-07 20:36:33'),
(24, 14, 1, 'Not Attending', '2011-02-20 15:35:21', '2011-02-25 21:23:42'),
(25, 28, 1, 'Attending', '2011-02-27 12:01:40', '2011-02-27 12:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `goal`
--

CREATE TABLE IF NOT EXISTS `goal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `groupId` int(11) NOT NULL,
  `ownerId` int(11) DEFAULT NULL,
  `isCompleted` tinyint(1) NOT NULL DEFAULT '0',
  `isTrash` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupId` (`groupId`),
  KEY `ownerId` (`ownerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `goal`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`, `slug`, `created`, `modified`) VALUES
(1, 'Test Group', 'test', '2011-04-10 12:17:45', '2011-04-10 12:17:45');

-- --------------------------------------------------------

--
-- Table structure for table `group_banter`
--

CREATE TABLE IF NOT EXISTS `group_banter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creatorId` int(11) DEFAULT NULL,
  `groupId` int(11) NOT NULL,
  `parentId` int(11) DEFAULT NULL,
  `content` varchar(4000) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `creatorId` (`creatorId`),
  KEY `groupId` (`groupId`),
  KEY `parentId` (`parentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `group_banter`
--


-- --------------------------------------------------------

--
-- Table structure for table `group_profile`
--

CREATE TABLE IF NOT EXISTS `group_profile` (
  `groupId` int(11) NOT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`groupId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `group_profile`
--

INSERT INTO `group_profile` (`groupId`, `description`, `created`, `modified`) VALUES
(5, 'Alpha Phi Omega National Service Fraternity (http://www.apo.org/) is an inclusive, coed, college-based organization with active chapters on over 350+ campuses across the United States. Members provide service to their communities and youth, the nation, their campuses, and each other. The organization is staffed by volunteers at all levels, including governance, advising, and program delivery.\r\n\r\nIn Alpha Phi Omega’s 75+ years of existence, more than 310,000 college men and women have dedicated themselves to the fraternity’s three cardinal principles: Leadership , Friendship and Service.\r\n\r\nOur chapter at San Jose State University strives to improve and grow by re-evaluating our goals and objectives after every college semester. Come and stay awhile to read about who we are and what we are about. If you have any comments or questions for us about the fraternity, chapter operations, or the website, please feel free to contact us.\r\n\r\nDeveloping Leadership, Promoting Friendship, and Providing Service\r\n\r\nRealistically, leadership is a matter of development. Alpha Phi Omega develops leaders, and we are very proud of that. As we grow, we seek qualities of leadership, and throughout our lives, we pursue the development of those qualities and the development of other ‘well-rounding’ qualities. Through our leadership development program in Alpha Phi Omega, we are able to develop ourselves. And, as we aspire to greater things in life, we become aware of limiting factors - which we can’t control, the external forces that shape our destiny until we control and develop what we have inside of us. We discover our own talents and strive to better our skills. We study, we learn, we practice.\r\n\r\nBrotherhood is the spirit of friendship. It implies respect, honesty and dependability. It means that we overlook differences and emphasize similarities as we join together in unselfish service. It means listening to Brothers whose views on issues might differ from our own. It means working closely with people whom under other circumstances we might not choose as our friends.\r\n\r\nOur Chapter service program provides many opportunities for the development of social awareness, friendships and leadership skills. Participation in our service program helps make Alpha Phi Omega the unique fraternal organization that it is.', NULL, '2011-01-25 22:21:24'),
(6, 'Gaaaaamma Beeeeeetaaa clap clap - clap clap claps', NULL, '2011-02-13 19:34:47'),
(7, NULL, NULL, NULL),
(8, NULL, NULL, NULL),
(9, NULL, NULL, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `group_user`
--


-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goalId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ownerId` int(11) DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `isCompleted` tinyint(1) NOT NULL DEFAULT '0',
  `isTrash` tinyint(1) NOT NULL DEFAULT '0',
  `starts` datetime DEFAULT NULL,
  `ends` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ownerId` (`ownerId`),
  KEY `goalId` (`goalId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `task`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_migration`
--

CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1297635236),
('m110207_023104_ActiveRecordLog', 1297635554),
('m110224_070250_drop_user_username_column', 1298531120);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `token`, `password`, `firstName`, `lastName`, `status`, `created`, `modified`, `lastLogin`) VALUES
(1, 'admin@poncla.com', '5d7f3e28571af8824a910e81996f409b8a6f5bd9', 'ac3642003276203b8ad9ceb60856fd9f7c3c286c', 'Poncla', 'Administrator', 'Active', '2011-04-10 12:17:45', '2011-04-10 12:17:45', NULL),
(2, 'user@poncla.com', '0865818293977c11289e0e0c33ccae70035399c3', '1800b237666e34ff1ab4e09d7343db2365d2ef23', 'Test', 'Registered', 'Active', '2011-04-10 12:17:45', '2011-04-10 12:17:45', '2011-04-10 12:17:45');

-- --------------------------------------------------------

--
-- Table structure for table `user_task`
--

CREATE TABLE IF NOT EXISTS `user_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `taskId` int(11) NOT NULL,
  `isCompleted` tinyint(1) NOT NULL DEFAULT '0',
  `isTrash` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `taskId` (`taskId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user_task`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `activerecordlog`
--
ALTER TABLE `activerecordlog`
  ADD CONSTRAINT `activerecordlog_ibfk_1` FOREIGN KEY (`groupId`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activerecordlog_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_3` FOREIGN KEY (`creatorId`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `event_ibfk_4` FOREIGN KEY (`groupId`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_banter`
--
ALTER TABLE `event_banter`
  ADD CONSTRAINT `event_banter_ibfk_1` FOREIGN KEY (`creatorId`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `event_banter_ibfk_2` FOREIGN KEY (`eventId`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_user`
--
ALTER TABLE `event_user`
  ADD CONSTRAINT `event_user_ibfk_3` FOREIGN KEY (`eventId`) REFERENCES `event` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `event_user_ibfk_4` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `goal`
--
ALTER TABLE `goal`
  ADD CONSTRAINT `goal_ibfk_1` FOREIGN KEY (`groupId`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `goal_ibfk_2` FOREIGN KEY (`ownerId`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `group_banter`
--
ALTER TABLE `group_banter`
  ADD CONSTRAINT `group_banter_ibfk_1` FOREIGN KEY (`groupId`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_banter_ibfk_2` FOREIGN KEY (`parentId`) REFERENCES `group_banter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_banter_ibfk_3` FOREIGN KEY (`creatorId`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `group_profile`
--
ALTER TABLE `group_profile`
  ADD CONSTRAINT `group_profile_ibfk_1` FOREIGN KEY (`groupId`) REFERENCES `group` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `group_user`
--
ALTER TABLE `group_user`
  ADD CONSTRAINT `group_user_ibfk_1` FOREIGN KEY (`groupId`) REFERENCES `group` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `group_user_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`ownerId`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`goalId`) REFERENCES `goal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_task`
--
ALTER TABLE `user_task`
  ADD CONSTRAINT `user_task_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_task_ibfk_2` FOREIGN KEY (`taskId`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
