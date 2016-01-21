-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Host: mysql.kovachev.dreamhosters.com
-- Generation Time: Apr 12, 2012 at 01:39 AM
-- Server version: 5.1.39
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `kovachev_dreamhosters_co`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `addressID` smallint(6) NOT NULL AUTO_INCREMENT,
  `addressName` varchar(100) DEFAULT NULL,
  `addressLine1` varchar(255) DEFAULT NULL,
  `addressLine2` varchar(255) DEFAULT NULL,
  `postCode` varchar(30) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`addressID`),
  UNIQUE KEY `addressID` (`addressID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `addresses`
--


-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `loginDate` date DEFAULT NULL,
  `adminType` enum('admin','manager','staff') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `loginDate`, `adminType`) VALUES
(1, 'Yordan', 'admin', '2005-04-03', 'admin'),
(2, 'Tina', 'staff', '2012-01-11', 'staff'),
(3, 'Stuart', 'manager', '2012-02-11', 'manager');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE IF NOT EXISTS `discounts` (
  `discountID` smallint(6) NOT NULL AUTO_INCREMENT,
  `discount` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`discountID`),
  UNIQUE KEY `discountID` (`discountID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `discounts`
--


-- --------------------------------------------------------

--
-- Table structure for table `discounts2Products`
--

CREATE TABLE IF NOT EXISTS `discounts2Products` (
  `productID` bigint(20) DEFAULT NULL,
  `discountID` smallint(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `discounts2Products`
--


-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `imageID` smallint(6) NOT NULL AUTO_INCREMENT,
  `imageName` varchar(100) DEFAULT NULL,
  `imageLocation` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`imageID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `images`
--


-- --------------------------------------------------------

--
-- Table structure for table `images2Products`
--

CREATE TABLE IF NOT EXISTS `images2Products` (
  `imageID` smallint(6) DEFAULT NULL,
  `productID` bigint(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images2Products`
--


-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `orderNumber` smallint(6) NOT NULL AUTO_INCREMENT,
  `orderStatus` enum('In Process','Shipped','Delivered') DEFAULT NULL,
  `orderNote` text,
  PRIMARY KEY (`orderNumber`),
  UNIQUE KEY `orderNumber` (`orderNumber`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `orders`
--


-- --------------------------------------------------------

--
-- Table structure for table `orders2users`
--

CREATE TABLE IF NOT EXISTS `orders2users` (
  `orderNumber` smallint(6) DEFAULT NULL,
  `userID` bigint(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders2users`
--


-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(125) NOT NULL AUTO_INCREMENT,
  `productName` varchar(125) NOT NULL,
  `productPrice` float NOT NULL,
  `productCategory` varchar(100) NOT NULL,
  `productSubcategory` varchar(100) NOT NULL,
  `productDescription` text,
  `productQuantity` bigint(20) NOT NULL,
  `productDateAdded` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `productName` (`productName`),
  KEY `id` (`id`,`productName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `productName`, `productPrice`, `productCategory`, `productSubcategory`, `productDescription`, `productQuantity`, `productDateAdded`) VALUES
(1, 'Boy LITTLE STAR', 12.95, 'Boy', 'BoxSets', 'Beautiful handmade blue keepsake box with integrated photo frame,\r\nStar hat and booties, Soft blue fleece blanket, key style teething ring.', 1, '2012-01-30'),
(2, 'Girl LITTLE STAR', 12.95, 'Girl', 'BoxSets', 'This set comes complete with - Beautiful handmade pink keepsake box with integrated photo frame,\r\nStar hat and booties, Soft pink fleece blanket, key style teething ring.', 1, '2012-01-30'),
(3, 'NEUTRAL ', 10, 'Girl', 'NappyCake', '    A beautiful white presentation box, \r\n    Small soft white teddy\r\n    Soft white scratch mitts,\r\n', 4, '2012-04-08');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `transactionID` int(11) NOT NULL AUTO_INCREMENT,
  `productIDarray` varchar(255) NOT NULL,
  `payerEmail` varchar(255) NOT NULL,
  `payerStatus` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `paymentDate` varchar(255) NOT NULL,
  `merchantGross` varchar(255) NOT NULL,
  `paymentCurrency` varchar(255) NOT NULL,
  `taxNumberID` varchar(255) NOT NULL,
  `taxType` varchar(255) NOT NULL,
  `receiverEmail` varchar(255) NOT NULL,
  `paymentType` varchar(255) NOT NULL,
  `paymentStatus` varchar(255) NOT NULL,
  `addressStreet` varchar(255) NOT NULL,
  `addressCity` varchar(255) NOT NULL,
  `addressTown` varchar(255) NOT NULL,
  `addressPosrtCode` varchar(255) NOT NULL,
  `addressCountry` varchar(255) NOT NULL,
  `addressStatus` varchar(255) NOT NULL,
  `notifyVersion` varchar(255) NOT NULL,
  `verifySign` varchar(255) NOT NULL,
  `playerID` varchar(255) NOT NULL,
  `merchantCurrency` varchar(255) NOT NULL,
  `merchantFee` varchar(255) NOT NULL,
  PRIMARY KEY (`transactionID`),
  UNIQUE KEY `taxNumberID` (`taxNumberID`),
  KEY `transactionID` (`transactionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `transactions`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(20) DEFAULT NULL,
  `lastName` varchar(20) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `gender` enum('m','f') DEFAULT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `email` (`email`,`firstName`,`lastName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `customers` (`id`, `firstName`, `lastName`, `DOB`, `gender`, `phone`, `email`, `username`, `password`, `userAvatar`) VALUES
(1, 'Johnathan', 'Swiftt', '1994-04-27', NULL, 07727456233, 'customer01@gmail.com', 'customer01@gmail.com', 'customer01', NULL),
(2, 'Martin', 'Wellss', '2005-03-11', NULL, 07727212233, 'customer02@gmail.com', 'customer02@gmail.com', 'customer02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users2addresses`
--

CREATE TABLE IF NOT EXISTS `customers2addresses` (
  `userID` bigint(20) DEFAULT NULL,
  `addressID` smallint(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users2addresses`
--

