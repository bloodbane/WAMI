-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 08, 2014 at 09:29 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `identity_profiler`
--

INSERT INTO `identity_profiler` (`identity_profiler_id`, `user_id`, `profile_id`, `category`, `media_type`, `file_type`, `profiler_url`, `title`, `file_name`, `description`, `delete_ind`, `create_date`, `modified_date`) VALUES
(1, 0, 0, 'Pictures', 'Picture', 'png', '/wami/profilerdata/rlanter/pic/pic1.png', '', 'My Parents', 'This is a picture of my parents', 0, '2014-07-10 10:53:13', '2014-07-10 10:53:13'),
(2, 0, 0, 'Pictures', 'Picture', 'png', '/wami/profilerdata/rlanter/pic/pic2.png', '', 'My Cat', '', 0, '2014-07-10 10:53:53', '2014-07-10 10:53:53'),
(3, 18, 0, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/pic/dog1.jpg', 'dog1', '', '', 0, '2014-07-10 15:05:34', '2014-07-10 15:05:34'),
(4, 18, 0, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/pic/dog2.jpg', '', '', '', 0, '2014-07-10 15:05:38', '2014-07-10 15:05:38'),
(5, 18, 0, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/pic/doge.jpg', '', '', '', 0, '2014-07-10 15:05:38', '2014-07-10 15:05:38'),
(6, 18, 0, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/pic/jb-dog.jpg', '', '', '', 0, '2014-07-10 15:05:38', '2014-07-10 15:05:38'),
(7, 18, 0, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/pic/mdog.jpg', 'mdog', '', '', 0, '2014-07-10 15:05:38', '2014-07-10 15:05:38'),
(8, 18, 0, 'Pictures', 'Picture', 'png', '/profilerdata/Tanis/pic/Cute-Dog-Wallpapers.jpg', '', '', '', 0, '2014-07-10 15:05:38', '2014-07-10 15:05:38'),
(9, 1, 1, 'Pictures', 'Picture', 'jpeg', 'profilerdata/jim/pic/dog.jpeg', '', 'Dog', 'A yellow dog.', 0, '2014-07-28 12:57:32', '2014-07-28 12:57:32'),
(10, 1, 1, 'Pictures', 'Picture', 'jpg', 'profilerdata/jim/pic/plant1.jpg', '', 'Plant 1', 'Plant 1 image.', 0, '2014-07-28 13:01:03', '2014-07-28 13:01:03'),
(11, 1, 1, 'Pictures', 'Picture', 'jpg', 'profilerdata/jim/pic/plant2.jpg', '', 'Plant 2', 'Plant 2 image.', 0, '2014-07-28 13:02:11', '2014-07-28 13:02:11'),
(12, 1, 1, 'Pictures', 'Picture', 'jpg', 'profilerdata/jim/pic/plant3.jpeg', '', 'Plant 3', 'Plant 3 image.', 0, '2014-07-28 13:03:30', '2014-07-28 13:03:30'),
(13, 1, 1, 'Pictures', 'Picture', 'jpg', 'profilerdata/jim/pic/plant4.jpg', '', 'Plant 4', 'Plant 4 image', 0, '2014-07-28 13:03:38', '2014-07-28 13:03:38'),
(14, 18, 1, 'Pictures', 'Pictures', 'png', '/profilerdata/Tanis/pic/FlowChart.png', '', '', '', 0, '2014-07-29 15:05:38', '2014-07-29 15:05:38');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(80) NOT NULL,
  `delete_ind` tinyint(1) NOT NULL,
  `create_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `delete_ind`, `create_date`, `modified_date`) VALUES
(18, 'Tanis', 0, '2014-07-30 00:00:00', '2014-08-02 00:00:00'),
(73, '', 0, '2014-07-10 10:49:28', '2014-07-10 10:49:28');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
