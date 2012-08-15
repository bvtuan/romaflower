-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 15, 2012 at 01:53 PM
-- Server version: 5.1.63
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `romaflow_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(256) DEFAULT NULL,
  `pwd` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `user_name`, `pwd`) VALUES
(1, 'admin', 'cbdec1c751d7f67aec252ba23fc54f59');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `feature_image` varchar(256) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `orders` int(11) NOT NULL DEFAULT '1',
  `status` enum('deactive','active') DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `title`, `feature_image`, `parent_id`, `orders`, `status`) VALUES
(1, 'Wedding ', '20120427191005_weeding.jpg', 0, 1, 'active'),
(2, 'Congratulation ', '20120427191017_chucmung.jpg', 0, 2, 'active'),
(3, 'Birthday ', '20120427191025_sinhnhat.jpg', 0, 3, 'active'),
(4, 'Love ', '20120427191034_love.jpg', 0, 4, 'active'),
(5, 'Funeral ', '20120427191043_chiabuon.jpg', 0, 5, 'active'),
(7, 'Bridal bouquets', '20120426231115_Hydrangeas.jpg', 1, 1, 'active'),
(8, 'weeding-vehicles', '20120427210952_xe hoa - civic.jpg', 1, 2, 'active'),
(9, 'Bridal Entrance', '20120427211107_cong hoa.jpg', 1, 3, 'active'),
(10, 'Weeding Reception', '20120427211157_hoa ban tiec.jpg', 1, 4, 'active'),
(11, 'Boutonaniere', '20120427211238_hoa cai ao.jpg', 1, 5, 'active'),
(26, 'Weddings & Events', '20120427211331_hoa su kien.jpg', 1, 6, 'active'),
(36, 'Holiday', '20120427191050_ngayle.jpg', 0, 6, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `flower`
--

CREATE TABLE IF NOT EXISTS `flower` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `date_modify` datetime DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `status` enum('deactive','active') NOT NULL DEFAULT 'active',
  `feature_image` varchar(256) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_flower_cat` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2626 ;

--
-- Dumping data for table `flower`
--

INSERT INTO `flower` (`id`, `category_id`, `date_modify`, `date_created`, `status`, `feature_image`, `order`) VALUES
(2607, 7, '2012-04-26 21:47:14', '2012-04-25 22:32:00', 'active', '20120426214714_slider3.jpg', 0),
(2610, 7, NULL, '2012-04-27 21:15:40', 'active', '20120427211540_333_HTB00058_Cream Light Boutoniere_80k.jpg', 0),
(2611, 7, NULL, '2012-04-27 21:18:01', 'active', '20120427211801_hoa1.jpg', 0),
(2612, 7, NULL, '2012-04-27 21:19:09', 'active', '20120427211909_hoa2.jpg', 0),
(2613, 7, NULL, '2012-04-27 21:21:07', 'active', '20120427212107_hoa3.jpg', 0),
(2614, 7, NULL, '2012-04-27 21:21:22', 'active', '20120427212122_hoa4.jpg', 0),
(2615, 7, NULL, '2012-04-27 21:21:47', 'active', '20120427212147_hoa5.jpg', 0),
(2616, 7, NULL, '2012-04-27 21:22:10', 'active', '20120427212210_hoa6.jpg', 0),
(2617, 7, NULL, '2012-04-27 21:22:35', 'active', '20120427212235_hoa7.jpg', 0),
(2618, 7, NULL, '2012-04-27 21:22:52', 'active', '20120427212252_hoa8.jpg', 0),
(2619, 7, NULL, '2012-04-27 21:23:09', 'active', '20120427212309_hoa9.jpg', 0),
(2620, 7, NULL, '2012-04-27 21:23:32', 'active', '20120427212332_hoa10.jpg', 0),
(2621, 7, NULL, '2012-04-27 21:23:52', 'active', '20120427212352_hoa11.jpg', 0),
(2622, 7, NULL, '2012-04-27 21:25:17', 'active', '20120427212517_hoa12.jpg', 0),
(2623, 7, NULL, '2012-04-27 21:25:35', 'active', '20120427212535_hoa13.jpg', 0),
(2624, 7, NULL, '2012-04-27 21:25:56', 'active', '20120427212556_hoa14.jpg', 0),
(2625, 7, NULL, '2012-04-29 17:22:17', 'active', '20120429172217_Tupling_YellowWhiteWedding-1.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `flower_translator`
--

CREATE TABLE IF NOT EXISTS `flower_translator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` varchar(23) NOT NULL,
  `lang` enum('en','vn') NOT NULL,
  `title` varchar(256) NOT NULL,
  `source_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_this_flowr` (`source_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5224 ;

--
-- Dumping data for table `flower_translator`
--

INSERT INTO `flower_translator` (`id`, `price`, `lang`, `title`, `source_id`) VALUES
(5186, '34', 'vn', 'fsdf', 2607),
(5187, '43543535', 'en', 'sfdsdf sdf', 2607),
(5192, '230000', 'vn', 'hoa a', 2610),
(5193, '3', 'en', 'flower', 2610),
(5194, '230000', 'vn', 'sdfsdf', 2611),
(5195, '3', 'en', 'sdf', 2611),
(5196, '230000', 'vn', 'hoa', 2612),
(5197, '3', 'en', 'floer', 2612),
(5198, '230000', 'vn', 'sdfsdf', 2613),
(5199, '3', 'en', 'sdf', 2613),
(5200, '230000', 'vn', 'sdfsdf', 2614),
(5201, '3', 'en', 'sdf', 2614),
(5202, '230000', 'vn', 'sdf', 2615),
(5203, '3', 'en', 'sdfd', 2615),
(5204, '230000', 'vn', 'hoa6', 2616),
(5205, '3', 'en', 'flower 6', 2616),
(5206, '230000', 'vn', 'hoa 7', 2617),
(5207, '3', 'en', 'flower 7', 2617),
(5208, '230000', 'vn', 'hoa 8', 2618),
(5209, '3', 'en', 'flower 8', 2618),
(5210, '230000', 'vn', 'hoa 9', 2619),
(5211, '3', 'en', 'flower 9', 2619),
(5212, '4500000', 'vn', 'hoa 10', 2620),
(5213, '3', 'en', 'flower 10', 2620),
(5214, '560000', 'vn', 'hoa 11', 2621),
(5215, '2', 'en', 'flower 11', 2621),
(5216, '3400000', 'vn', 'hoa12', 2622),
(5217, '3', 'en', 'flower12', 2622),
(5218, '230000', 'vn', 'hoa 13', 2623),
(5219, '4', 'en', 'flower13', 2623),
(5220, '230000', 'vn', 'hoa 14', 2624),
(5221, '3', 'en', 'flower 14', 2624),
(5222, '200000', 'vn', 'Hoa cÃ´ dÃ¢u', 2625),
(5223, '10', 'en', 'Bridal bouquets', 2625);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) DEFAULT NULL,
  `content_en` text,
  `content_vn` text,
  `title_vn` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `title_en`, `content_en`, `content_vn`, `title_vn`) VALUES
(1, 'ROMA FLOWER SHOP d', 'Content introduce here d', 'Noi dung nam o day d', 'SHOP HOA ROMA ds');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_url` varchar(256) DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  `status` enum('deactive','active') DEFAULT NULL,
  `orders` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `image_url`, `title`, `status`, `orders`) VALUES
(2, '20120503171059_Slide01.jpg', NULL, 'active', 1),
(3, 'slider3.jpg', NULL, 'active', 1),
(4, 'slider4.jpg', NULL, 'active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `translator`
--

CREATE TABLE IF NOT EXISTS `translator` (
  `ipk` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `lang` enum('en','vn') DEFAULT NULL,
  `source_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ipk`),
  KEY `fk_translator_category` (`source_id`),
  KEY `fk_unie` (`lang`,`source_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `translator`
--

INSERT INTO `translator` (`ipk`, `name`, `lang`, `source_id`) VALUES
(1, 'Wedding', 'en', 1),
(2, 'Congratulation', 'en', 2),
(3, 'Birthday', 'en', 3),
(4, 'Love', 'en', 4),
(5, 'Funeral', 'en', 5),
(7, 'Bridal bouquets', 'en', 7),
(8, 'weeding-vehicles', 'en', 8),
(9, 'Bridal Entrance', 'en', 9),
(10, 'Weeding Reception', 'en', 10),
(11, 'Boutonaniere', 'en', 11),
(12, 'Weedings & Event', 'en', 26),
(13, 'ÄÃ¡m cÆ°á»›i', 'vn', 1),
(14, 'ChÃºc má»«ng', 'vn', 2),
(15, 'Sinh nháº­t', 'vn', 3),
(16, 'TÃ¬nh yÃªu', 'vn', 4),
(17, 'Chia buá»“n', 'vn', 5),
(19, 'Hoa cÃ´ dÃ¢u', 'vn', 7),
(20, 'Xe hoa', 'vn', 8),
(21, 'Cá»•ng hoa', 'vn', 9),
(22, 'Hoa bÃ n tiá»‡c', 'vn', 10),
(23, 'Hoa cÃ i Ã¡o', 'vn', 11),
(24, 'Tiá»‡c cÆ°á»›i  & Sá»± kiá»‡n', 'vn', 26),
(35, 'NgÃ y lá»…', 'vn', 36),
(36, 'Holiday', 'en', 36);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `flower`
--
ALTER TABLE `flower`
  ADD CONSTRAINT `fk_flower_cat` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `flower_translator`
--
ALTER TABLE `flower_translator`
  ADD CONSTRAINT `fk_this_flowr` FOREIGN KEY (`source_id`) REFERENCES `flower` (`id`);

--
-- Constraints for table `translator`
--
ALTER TABLE `translator`
  ADD CONSTRAINT `fk_translator_category` FOREIGN KEY (`source_id`) REFERENCES `category` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
