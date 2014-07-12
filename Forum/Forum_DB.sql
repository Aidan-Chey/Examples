-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql310.freewebhost.co.nz
-- Generation Time: Jul 12, 2014 at 05:00 AM
-- Server version: 5.6.16-64.2-56
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `freew_13553164_94686`
--

-- --------------------------------------------------------

--
-- Table structure for table `Posts`
--

CREATE TABLE IF NOT EXISTS `Posts` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Contents` varchar(10000) NOT NULL,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatorID` int(11) NOT NULL,
  `ThreadID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=111 ;

--
-- Dumping data for table `Posts`
--

INSERT INTO `Posts` (`ID`, `Contents`, `Created`, `CreatorID`, `ThreadID`) VALUES
(29, 'post 9', '2014-05-04 23:05:20', 2, 2),
(19, 'iushefousheouhdrge edit', '2014-04-16 12:41:20', 1, 2),
(20, 'A edited post by basic user.', '2014-04-16 12:59:49', 2, 1),
(22, 'Post 2\r\n', '2014-05-04 23:04:40', 2, 2),
(24, 'post 4', '2014-05-04 23:04:52', 2, 2),
(77, 'rsgdzhdsth', '2014-05-05 04:00:11', 2, 2),
(27, 'post 7', '2014-05-04 23:05:07', 2, 2),
(28, 'post 8 ', '2014-05-04 23:05:14', 2, 2),
(30, 'post 10\r\n', '2014-05-04 23:05:27', 2, 2),
(31, 'post 11', '2014-05-04 23:05:41', 2, 2),
(32, 'post 12', '2014-05-04 23:05:46', 2, 2),
(33, 'post 13', '2014-05-04 23:05:52', 2, 2),
(34, 'post 14', '2014-05-04 23:05:57', 2, 2),
(35, 'post 15', '2014-05-04 23:06:02', 2, 2),
(36, 'post 16', '2014-05-04 23:06:07', 2, 2),
(37, 'okdinjorsngrs\r\n', '2014-05-05 01:32:39', 2, 2),
(38, 'lijenioniorsg', '2014-05-05 01:32:43', 2, 2),
(39, 'akljnforng', '2014-05-05 01:32:46', 2, 2),
(40, 'ikoahfuoasgo', '2014-05-05 01:32:49', 2, 2),
(41, 'awdeafijugfa\r\n', '2014-05-05 01:32:56', 2, 2),
(42, 'kjhijkszgfvr\r\n', '2014-05-05 01:33:07', 2, 2),
(43, 'amrsjkngsrg', '2014-05-05 01:33:11', 2, 2),
(44, 'khbvkshrbgv', '2014-05-05 01:33:22', 2, 2),
(45, 'kbiksbeksjrbgkjrs', '2014-05-05 01:33:27', 2, 2),
(46, 'rgkluxnhrkub', '2014-05-05 01:33:32', 2, 2),
(47, 'kesajubkbgksr', '2014-05-05 01:33:36', 2, 2),
(48, 'oklunrskjunbrs', '2014-05-05 01:33:40', 2, 2),
(49, 'dxhdthftjh', '2014-05-05 01:36:47', 2, 2),
(50, 'kjefbkehbfeg', '2014-05-05 01:36:52', 2, 2),
(51, 'kjajlnflgnslg', '2014-05-05 01:37:09', 2, 2),
(52, 'ipoueipouew', '2014-05-05 01:37:15', 2, 2),
(53, 'lskrejngjlsrg', '2014-05-05 01:37:30', 2, 2),
(54, 'lisanheflrg', '2014-05-05 01:37:37', 2, 2),
(55, 'lrjngjkdrngs', '2014-05-05 01:37:44', 2, 2),
(56, 'rsklgjnrdkjgr', '2014-05-05 01:37:49', 2, 2),
(57, 'ea fkea bfjkhef', '2014-05-05 01:37:59', 2, 2),
(58, 'uehfiuhekusregf', '2014-05-05 01:38:04', 2, 2),
(59, 'kjebfkebkesf', '2014-05-05 01:38:08', 2, 2),
(60, 'klsjrnjkrsngkjsrng', '2014-05-05 01:38:11', 2, 2),
(61, 'kesubhfksbgksg', '2014-05-05 01:38:15', 2, 2),
(62, 'kuabfbaeikjbjkfae', '2014-05-05 01:38:20', 2, 2),
(63, 'klejakljsrbvlrs', '2014-05-05 01:38:23', 2, 2),
(64, 'klubkjusbvksr', '2014-05-05 01:38:27', 2, 2),
(65, 'oeaihfeiuhf', '2014-05-05 01:38:30', 2, 2),
(66, 'iuaebfikuebf', '2014-05-05 01:38:34', 2, 2),
(67, 'loesajnosenbfo', '2014-05-05 01:38:40', 2, 2),
(73, 'kugkukukbk', '2014-05-05 02:57:15', 2, 2),
(75, 'sekugrhsgiuo', '2014-05-05 03:57:34', 2, 2),
(78, 'ksurbiuors', '2014-05-05 04:07:57', 2, 2),
(79, 'esaofoeh', '2014-05-05 04:08:02', 2, 2),
(80, 'ieajfoisrjngp', '2014-05-05 04:08:06', 2, 2),
(81, 'oeaihfoisvhg', '2014-05-05 04:08:10', 2, 2),
(82, 'oeaufoen', '2014-05-05 04:08:16', 2, 2),
(83, 'aokeuhiuohov', '2014-05-05 04:08:20', 2, 2),
(84, 'iesbfiyhsbvihekbik', '2014-05-05 04:08:23', 2, 2),
(85, 'dthdhdthkjnbijoono', '2014-05-05 04:08:32', 2, 2),
(89, 'fxkjbjkf vxdk jnbvxfb', '2014-05-05 04:41:43', 2, 2),
(88, 'eakleiu  okbsikobv', '2014-05-05 04:37:37', 2, 2),
(90, 'rdskjnbgskjrbg', '2014-05-05 04:48:30', 2, 2),
(91, 'jlesanfljenlv', '2014-05-05 04:48:35', 2, 2),
(92, 'fdkgbxkvjh', '2014-05-05 04:48:44', 2, 2),
(93, 'keajhbfkeajfb', '2014-05-05 04:50:27', 2, 2),
(94, 'lajwndljkn', '2014-05-05 04:50:32', 2, 2),
(95, 'wdkluafkjabnf', '2014-05-05 04:50:36', 2, 2),
(96, 'awdkajwbfkhajb', '2014-05-05 04:50:40', 2, 2),
(97, 'Pellentesque condimentum ornare libero, eu tristique odio interdum feugiat. Ut consequat vehicula urna, vitae luctus diam pretium ultrices.\r\n\r\nMaecenas tempus pulvinar nisi a.\r\n\r\nMaecenas tempus pulvinar nisi a.', '2014-05-07 04:58:05', 2, 9),
(104, 'Nunc id metus sit amet sem scelerisque placerat. Suspendisse potenti. Sed sed nulla nibh. Curabitur faucibus at metus et aliquet. Cras sed viverra massa. Praesent id erat id nulla venenatis feugiat. Curabitur lacinia in est non gravida. Maecenas at cursus sapien, sit amet molestie justo. Donec viverra adipiscing ipsum id consectetur. Vivamus nec ipsum aliquam, varius nibh id, sagittis eros.', '2014-05-17 03:49:07', 1, 13),
(105, 'Etiam vitae lobortis risus. Proin vel dolor ac dolor rutrum viverra. Nunc ac est et sapien lacinia accumsan non quis dui. Maecenas ac pharetra lectus.', '2014-05-17 03:51:34', 1, 13),
(110, 'Hi Tim\r\n', '2014-05-28 02:12:57', 25, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Sections`
--

CREATE TABLE IF NOT EXISTS `Sections` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(150) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `Sections`
--

INSERT INTO `Sections` (`ID`, `Name`, `Description`) VALUES
(1, 'General', 'General Section for off-topic conversation'),
(2, 'Specific', 'Specific Section for on-topic conversation adding stuff'),
(15, 'test', 'ufhgeaiufeg\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `Threads`
--

CREATE TABLE IF NOT EXISTS `Threads` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(50) NOT NULL,
  `Contents` varchar(10000) NOT NULL,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatorID` int(11) NOT NULL,
  `TopicID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Section` (`TopicID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `Threads`
--

INSERT INTO `Threads` (`ID`, `Title`, `Contents`, `Created`, `CreatorID`, `TopicID`) VALUES
(2, 'Specific Test', 'Specific Test Thread', '2014-04-04 15:05:13', 1, 2),
(1, 'General Test', 'General Test Thread', '2014-04-04 15:05:13', 1, 1),
(9, 'Cras suscipit ultricies condimentum.', 'Ut vel tristique arcu. Aenean lobortis, diam et facilisis convallis, eros ligula dignissim tellus, at euismod nulla libero eget ipsum. Suspendisse ut purus quis nulla ultrices aliquam. Nam pellentesque felis eu risus aliquam, quis tristique tellus tempus.', '2014-05-07 04:54:34', 1, 6),
(10, 'Maecenas tempus pulvinar nisi a.', 'Nullam ornare lacus quis orci viverra, vel condimentum dui porttitor. Etiam ut libero non nunc pulvinar lacinia quis sit amet tortor. Duis magna odio, tempor at odio ullamcorper, aliquam bibendum nisl. Ut libero eros, blandit at ligula id, ornare dictum purus. Sed non aliquam nunc, a pellentesque ante. In lacinia neque ultricies ante gravida, dictum egestas magna euismod. Suspendisse id ultrices justo, non rhoncus est.', '2014-05-07 05:04:13', 2, 6),
(11, 'Praesent sit amet leo sit.', 'Proin quis nunc ut ligula bibendum ornare. Quisque imperdiet ligula nisi, quis posuere elit placerat at. Morbi ut neque sed velit aliquet aliquet sed id urna. Donec dapibus, lorem sed porttitor porta, purus metus tempus libero, quis bibendum leo turpis eu purus. Proin id accumsan diam. Praesent et pretium metus.\r\n', '2014-05-07 05:05:27', 2, 1),
(12, 'Pellentesque et risus ornare, aliquet.', 'Integer eleifend eleifend orci, nec euismod metus molestie vel. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque eget nisl laoreet, consectetur dolor et, lacinia arcu. Suspendisse vehicula lacus non dapibus varius. Sed tempor mauris odio, sed laoreet velit ultricies quis. Maecenas luctus tincidunt urna, vitae porta sapien congue sed. Aenean posuere lacus ac diam molestie, non fringilla libero tincidunt. Sed vehicula nisl massa, nec ultrices erat aliquam ac. In quis lacinia lorem, in egestas nisi. Donec id leo scelerisque, pharetra est ut, iaculis sapien. Morbi vel laoreet mi.\r\nDonec urna purus, adipiscing id tincidunt vitae, volutpat sit amet ante. Maecenas scelerisque velit vitae vehicula fringilla. Vivamus eget ante eu tortor interdum bibendum. Praesent dapibus turpis libero, at pretium ante ornare id. Aliquam ut mauris consectetur, molestie nulla eu, iaculis elit. Quisque elementum ipsum ut velit volutpat, et cursus lectus tristique. Duis iaculis eu diam eget egestas. Suspendisse potenti. Nunc aliquet rhoncus augue at mollis. Mauris et orci ornare, elementum ligula nec, feugiat nisl. Fusce vitae nisl non justo facilisis tincidunt. Phasellus in justo quis quam ornare dictum venenatis eget ligula. Donec mi odio, molestie ut diam eu, faucibus fringilla massa. Curabitur elementum scelerisque felis, at condimentum elit congue sit amet. Maecenas laoreet, orci in condimentum porttitor, libero dolor aliquam sem, sit amet mollis massa augue quis tortor. Aenean commodo eget orci quis dapibus.\r\n', '2014-05-07 05:05:56', 2, 1),
(13, 'Donec dictum erat ligula, eu.', 'Praesent non augue arcu. Integer feugiat metus ipsum, eget placerat mi dictum vel. Etiam sodales, mauris facilisis congue pulvinar, augue neque cursus justo, sed posuere felis risus mollis nulla. Maecenas ultricies urna eu justo cursus, fermentum malesuada nisi tempus. Phasellus dictum, lorem eu euismod semper, urna neque rhoncus est, at vestibulum justo neque at tortor. Integer tempus, ipsum et gravida interdum, arcu enim lobortis purus, ullamcorper ornare augue massa ut arcu. Aliquam suscipit purus vitae lorem laoreet, vitae vulputate arcu laoreet. Morbi tempus tempor faucibus. Suspendisse et ullamcorper nunc. Vivamus volutpat hendrerit nibh, ornare ultricies sapien posuere eu. Vivamus sapien lorem, sollicitudin at elit ac, accumsan sodales mi. Etiam suscipit fermentum metus facilisis posuere.\r\n', '2014-05-07 05:08:01', 2, 2),
(20, 'Mikes Threadf', 'Stuff\r\n', '2014-05-22 05:53:59', 24, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Topics`
--

CREATE TABLE IF NOT EXISTS `Topics` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(150) NOT NULL,
  `SectionID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `Topics`
--

INSERT INTO `Topics` (`ID`, `Name`, `Description`, `SectionID`) VALUES
(1, 'General Test', 'Fusce eu sapien ut libero ullamcorper mattis. Proin aliquet lectus eu augue imperdiet consectetur. Integer congue urna in mollis porta. Nam nec erat l', 1),
(2, 'Specific Test', 'Fusce tortor neque, lacinia eget purus non, eleifend porttitor libero. Sed a nulla ipsum. Duis molestie faucibus elit a malesuada. skhbfsy', 2),
(6, 'Fusce tortor neque', 'Maecenas at purus porttitor, mollis ligula eu, pellentesque libero. Nulla iaculis justo eu interdum pulvinar.', 1),
(11, 'Test', 'agaregjkhbrg', 15);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(105) NOT NULL,
  `Role` varchar(200) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Email` (`Email`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`ID`, `Email`, `Password`, `Role`, `Name`, `Joined`) VALUES
(1, 'admin@email.com', '30a266f3f4ca60a7393ebdcfbc47143b', 'Admin', 'TestAdmin', '2014-05-07 04:16:09'),
(2, 'user@email.com', 'd5916e28214e5109067fbbe0dc52a4f5', 'Basic', 'TestBasic', '2014-05-07 04:16:09'),
(22, 'fake@email.com', '', '', '[Removed]', '2014-05-17 05:44:47'),
(23, 'test@email.com', '2fb438f61141150a484e894229a68526', 'Basic', 'TestAccount', '2014-05-18 20:59:12'),
(24, 'mike@email.com', '2fb438f61141150a484e894229a68526', 'Admin', 'mike', '2014-05-22 05:59:51'),
(25, 'aidan@email.com', '2fb438f61141150a484e894229a68526', 'Basic', 'adidan', '2014-05-28 02:11:26');

-- --------------------------------------------------------

--
-- Table structure for table `UsersRole`
--

CREATE TABLE IF NOT EXISTS `UsersRole` (
  `Name` varchar(20) NOT NULL,
  `Description` varchar(200) NOT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `UsersRole`
--

INSERT INTO `UsersRole` (`Name`, `Description`) VALUES
('Admin', 'Access to Everything.'),
('Basic', 'Able to create Threads and Post');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
