-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 20, 2020 at 03:39 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `forms`
--
CREATE DATABASE IF NOT EXISTS `forms` DEFAULT CHARACTER SET utf32 COLLATE utf32_bin;
USE `forms`;

-- --------------------------------------------------------

--
-- Table structure for table `auth_table`
--

CREATE TABLE IF NOT EXISTS `auth_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form` varchar(50) COLLATE utf32_bin NOT NULL,
  `mail` varchar(50) COLLATE utf32_bin NOT NULL,
  `otp` varchar(50) COLLATE utf32_bin NOT NULL,
  `expiry` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_bin AUTO_INCREMENT=19 ;

--
-- Dumping data for table `auth_table`
--

INSERT INTO `auth_table` (`id`, `form`, `mail`, `otp`, `expiry`, `status`) VALUES
(1, 'hi2H0pSfN65K6vS', 'bala@gmail.com', 'kawshik', '2020-08-20 00:00:00', 1),
(3, 'hi2H0pSfN65K6vS', 'bala@yahoo.com', 'kawshik', '2020-08-29 00:00:00', 0),
(4, '0EN8borW29qZMMJ', 'bala@yahoo.com', 'kawshik', '2020-08-29 00:00:00', 1),
(5, 'HF8buNKoRrvJNa7', 'balakawshik2000@gmail.com', 'Es8hhKkp6u5azPk', '0000-00-00 00:00:00', 0),
(6, 'HF8buNKoRrvJNa7', 'murali@yahoo.com', 'U9AMAhNK7ei6FSV', '0000-00-00 00:00:00', 0),
(7, 'HF8buNKoRrvJNa7', 'balamurali@yahoo.com', 'NoaAfJICXXundefinedP1tX', '9999-12-31 23:59:59', 0),
(8, 'HF8buNKoRrvJNa7', 'ambi@ggmail.com', 'RwX8JaKgYNyS1Ue', '0000-00-00 00:00:00', 0),
(9, 'HF8buNKoRrvJNa7', 'ambi@ggmail.com', 'xafntzLEoMLpbeP', '0000-00-00 00:00:00', 0),
(10, 'HF8buNKoRrvJNa7', 'balakawshikb@gmail.com', 'Fb4Fyb6yzwO6e8Y', '0000-00-00 00:00:00', 0),
(11, 'HF8buNKoRrvJNa7', 'balakawshikb@gmail.com', 'tsXSTVS7wAYrfaa', '2020-08-29 00:00:00', 0),
(12, 'HF8buNKoRrvJNa7', 'balakawshikb@gmail.com', 'yk0tMGINxqNhuIb', '2020-08-29 00:00:00', 0),
(13, 'HF8buNKoRrvJNa7', 'balakawshikb@gmail.com', 'oLundefined7g35OuMU5muB', '2020-08-29 23:59:59', 0),
(14, 'HF8buNKoRrvJNa7', 'balakawshikb@gmail.com', '6ipBRhDPQ05QEMW', '2020-08-29 10:34:00', 0),
(15, 'HF8buNKoRrvJNa7', 'balakawshikb@gmail.com', 'SaJJTtiX0EooO5u', '2020-08-29 22:34:00', 0),
(16, '6Own0VD9UPyAhCu', '221027024@sastra.ac.in', 'cYSf350EundefinedPq8jpK', '2020-08-29 10:00:00', 1),
(17, '6Own0VD9UPyAhCu', '221027024@sastra.ac.in', 'RurVB1Tox8wWrbd', '2020-08-29 10:00:00', 1),
(18, 'BlJpnAvkNsmQygJ', '221207024@sastra.ac.in', 'Yu1BNwq8A2Xsvfn', '9999-12-31 23:59:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE IF NOT EXISTS `form` (
  `name` varchar(50) COLLATE utf32_bin NOT NULL,
  `user_id` int(11) NOT NULL,
  `expiry` datetime NOT NULL DEFAULT '9999-12-31 23:56:00',
  `secured` bit(1) NOT NULL DEFAULT b'0',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(100) COLLATE utf32_bin NOT NULL DEFAULT 'untitled form',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`name`, `user_id`, `expiry`, `secured`, `created_date`, `last_edited`, `title`) VALUES
('0EN8borW29qZMMJ', 2, '2020-08-29 00:00:00', b'1', '2020-08-15 22:42:48', '2020-08-19 09:28:59', 'untitled form'),
('6Own0VD9UPyAhCu', 3, '9990-12-31 23:59:00', b'1', '2020-08-20 18:48:06', '2020-08-20 21:05:20', 'WI'),
('BlJpnAvkNsmQygJ', 3, '9999-12-31 23:56:00', b'0', '2020-08-20 18:48:36', '2020-08-20 21:02:19', 'SCHOOLS'),
('MZWRXXiXLZfpwyT', 1, '9999-12-31 23:56:00', b'0', '2020-08-20 12:25:28', '2020-08-20 12:25:28', 'untitled form'),
('Nt4nqq6Jh0TkkOa', 1, '9999-12-31 23:56:00', b'0', '2020-08-20 12:24:32', '2020-08-20 12:24:32', 'untitled form'),
('Q5lcKdYV3hSeTsT', 3, '9999-12-31 23:56:00', b'0', '2020-08-20 18:47:25', '2020-08-20 18:47:25', 'SASTRA'),
('Q8aYf21nR9mm7Ao', 1, '9999-12-31 23:56:00', b'0', '2020-08-20 12:25:05', '2020-08-20 12:25:05', 'untitled form'),
('hi2H0pSfN65K6vS', 1, '2020-08-20 11:47:44', b'1', '2020-08-15 22:42:48', '2020-08-20 11:47:44', 'untitled form'),
('r5CPMMD9CuBrGwX', 1, '9999-12-31 23:56:00', b'0', '2020-08-20 12:25:37', '2020-08-20 12:25:37', 'untitled form'),
('u1W96kZxtJ1AscF', 1, '9999-12-31 23:56:00', b'0', '2020-08-20 12:34:00', '2020-08-20 12:34:00', 'WI task Status'),
('ulHi8WRE02AEcPL', 1, '0000-00-00 00:00:00', b'0', '2020-08-15 22:42:48', '2020-08-15 22:42:48', 'untitled form'),
('wL6NCJPhlaqMA1u', 1, '2020-08-29 00:00:00', b'0', '2020-08-15 22:42:48', '2020-08-20 13:41:18', 'untitled form');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(50) COLLATE utf32_bin NOT NULL,
  `name` varchar(25) COLLATE utf32_bin NOT NULL,
  `password` varchar(25) COLLATE utf32_bin NOT NULL,
  `number` text COLLATE utf32_bin NOT NULL,
  `image` varchar(200) COLLATE utf32_bin NOT NULL,
  `dob` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_bin AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `mail`, `name`, `password`, `number`, `image`, `dob`) VALUES
(1, 'balakawshik2000@gmail.com', 'Balakawshik', 'kawshik', '0', 'images/blacka.jpeg', '0000-00-00'),
(2, 'bala@gmail.com', 'Raj', 'Kawshik123$', '9009909090', 'images/blacka.jpeg', '2001-06-12'),
(3, 'raja@yahoo.com', 'Raja', 'Kawshik123', '9090909090', 'profile/wp_ss_20190102_0003.png', '2000-06-12');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
