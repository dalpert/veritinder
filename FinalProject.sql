-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 07, 2014 at 02:03 AM
-- Server version: 5.5.40-0ubuntu0.14.04.1-log
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `FinalProject`
--

-- --------------------------------------------------------

--
-- Table structure for table `crushes`
--

CREATE TABLE IF NOT EXISTS `crushes` (
  `id` int(11) NOT NULL,
  `crush1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `crush2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `crush3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `matchstatus1` tinyint(1) NOT NULL,
  `matchstatus2` tinyint(1) NOT NULL,
  `matchstatus3` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `crushes`
--

INSERT INTO `crushes` (`id`, `crush1`, `crush2`, `crush3`, `matchstatus1`, `matchstatus2`, `matchstatus3`) VALUES
(34, 'daniel.alpert', 'patrick.kelley', 'rachel.black', 1, 0, 0),
(35, 'rachel.black', '', '', 0, 0, 0),
(36, 'dylan.farrell', '', '', 1, 0, 0),
(37, 'leah.alpert', 'patrick.kelley', '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `times`
--

CREATE TABLE IF NOT EXISTS `times` (
  `id` int(11) NOT NULL,
  `sunStart` int(11) NOT NULL,
  `sunEnd` int(11) NOT NULL,
  `monStart` int(11) NOT NULL,
  `monEnd` int(11) NOT NULL,
  `tuesStart` int(11) NOT NULL,
  `tuesEnd` int(11) NOT NULL,
  `wedStart` int(11) NOT NULL,
  `wedEnd` int(11) NOT NULL,
  `thursStart` int(11) NOT NULL,
  `thursEnd` int(11) NOT NULL,
  `friStart` int(11) NOT NULL,
  `friEnd` int(11) NOT NULL,
  `satStart` int(11) NOT NULL,
  `satEnd` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `times`
--

INSERT INTO `times` (`id`, `sunStart`, `sunEnd`, `monStart`, `monEnd`, `tuesStart`, `tuesEnd`, `wedStart`, `wedEnd`, `thursStart`, `thursEnd`, `friStart`, `friEnd`, `satStart`, `satEnd`) VALUES
(35, 0, 0, 8, 19, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(36, 7, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(37, 8, 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `formattedname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=38 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`firstname`, `lastname`, `formattedname`, `id`, `email`, `hash`) VALUES
('dylan', 'Farrell', 'dylan.farrell', 34, 'dylan', '$1$0wp8LDtC$EdK1PwP7G.Aj35z7HXzfP/'),
('Patrick', 'Kelley', 'patrick.kelley', 35, 'patrick', '$1$m6RNaGPt$cDbxenA9lGq3hVaPhN3hM1'),
('Daniel', 'Alpert', 'daniel.alpert', 36, 'daniel', '$1$qbH/Slu/$TMV9FQcKMW4FwOFEw7IMO0'),
('Russell', 'Cohen', 'russell.cohen', 37, 'russell', '$1$HR3EIrDM$a9u2VqSr0g0zf48fCJxTK0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
