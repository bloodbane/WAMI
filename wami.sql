-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 13, 2014 at 09:30 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wami`
--

-- --------------------------------------------------------

--
-- Table structure for table `identity_profiler`
--

CREATE TABLE IF NOT EXISTS `identity_profiler` (
  `identity_profiler_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `media_type` varchar(20) NOT NULL DEFAULT '',
  `file_type` varchar(5) NOT NULL DEFAULT '',
  `profiler_url` varchar(100) DEFAULT '',
  `title` varchar(30) DEFAULT '',
  `file_name` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(200) DEFAULT '',
  `delete_ind` tinyint(1) NOT NULL,
  `create_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`identity_profiler_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `identity_profiler`
--

INSERT INTO `identity_profiler` (`identity_profiler_id`, `user_id`, `profile_id`, `category`, `media_type`, `file_type`, `profiler_url`, `title`, `file_name`, `description`, `delete_ind`, `create_date`, `modified_date`) VALUES
(1, 0, 0, 'Pictures', 'Picture', 'png', '/wami/profilerdata/rlanter/pic/pic1.png', '', 'My Parents', 'This is a picture of my parents', 0, '2014-07-10 10:53:13', '2014-07-10 10:53:13'),
(2, 0, 0, 'Pictures', 'Picture', 'png', '/wami/profilerdata/rlanter/pic/pic2.png', '', 'My Cat', '', 0, '2014-07-10 10:53:53', '2014-07-10 10:53:53'),
(3, 18, 0, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/0/pic/dog1.jpg', 'dog1', '', 'This is a picture of my dog', 0, '2014-07-10 15:05:34', '2014-07-10 15:05:34'),
(4, 18, 0, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/0/pic/dog2.jpg', '', '', '', 0, '2014-07-10 15:05:38', '2014-07-10 15:05:38'),
(5, 18, 0, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/0/pic/doge.jpg', '', '', '', 0, '2014-07-10 15:05:38', '2014-07-10 15:05:38'),
(6, 18, 0, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/0/pic/jb-dog.jpg', '', '', '', 0, '2014-07-10 15:05:38', '2014-07-10 15:05:38'),
(7, 18, 0, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/0/pic/mdog.jpg', 'mdog', '', '', 0, '2014-07-10 15:05:38', '2014-07-10 15:05:38'),
(8, 18, 0, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/0/pic/Cute-Dog-Wallpapers.jpg', '', '', '', 0, '2014-07-10 15:05:38', '2014-07-10 15:05:38'),
(14, 18, 1, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/1/pic/FlowChart.png', '', 'FlowChart.png', '', 0, '2014-07-28 13:03:38', '2014-07-28 13:03:38'),
(24, 18, 1, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/1/pic/flowbreeze-order-flowchart.png', 'afsda', 'flowbreeze-order-flowchart.png', 'asdgadg', 0, '2014-08-08 23:26:59', '2014-08-08 23:26:59'),
(25, 18, 1, 'Pictures', 'Picture', 'jpeg', '/profilerdata/Tanis/1/pic/Darth.png', 'darth', 'Darth.png', 'adfasdf', 2, '2014-08-08 23:27:59', '2014-08-08 23:27:59'),
(28, 18, 1, 'Pictures', 'Picture', 'jpg', '/profilerdata/Tanis/1/pic/m-sd_f.jpg', 'Chart', 'm-sd_f.jpg', 'Just\nA\nChart', 0, '2014-08-09 00:15:36', '2014-08-09 00:15:36'),
(29, 18, 1, 'Pictures', 'Picture', 'jpg', '/profilerdata/Tanis/1/pic/figure1.jpg', 'ta', 'figure1.jpg', 'asd', 1, '2014-08-09 02:15:04', '2014-08-09 02:15:04'),
(34, 18, 1, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/1/pic/Darth.png', 'Darth', 'Darth.png', '', 2, '2014-08-12 05:02:16', '2014-08-12 05:02:16'),
(44, 18, 0, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/0/pic/Darth.png', '', 'Darth.png', '', 1, '2014-08-12 07:42:03', '2014-08-12 07:42:03'),
(45, 18, 1, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/1/pic/Darth.png', '', 'Darth.png', '', 2, '2014-08-12 07:42:50', '2014-08-12 07:42:50'),
(46, 18, 1, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/1/pic/Darth.png', '', 'Darth.png', '', 2, '2014-08-12 07:44:03', '2014-08-12 07:44:03'),
(47, 18, 1, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/1/pic/Darth.png', '', 'Darth.png', '', 2, '2014-08-12 07:44:50', '2014-08-12 07:44:50'),
(48, 18, 1, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/1/pic/Darth.png', '', 'Darth.png', '', 2, '2014-08-12 07:46:20', '2014-08-12 07:46:20'),
(49, 18, 2, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/2/pic/Plain_White_Ts-Hey_There_Delilah-AGuitar.png', '', 'Plain_White_Ts-Hey_There_Delilah-AGuitar.png', '', 0, '2014-08-12 23:35:30', '2014-08-12 23:35:30'),
(50, 18, 1, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/1/pic/Darth.png', '', 'Darth.png', '', 1, '2014-08-13 03:35:04', '2014-08-13 03:35:04');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
