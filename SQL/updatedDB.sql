CREATE DATABASE  IF NOT EXISTS `pandaexpress` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `pandaexpress`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: pandaexpress
-- ------------------------------------------------------
-- Server version	5.6.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `advpurchasediscount`
--

DROP TABLE IF EXISTS `advpurchasediscount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advpurchasediscount` (
  `AirlineID` char(2) NOT NULL DEFAULT '',
  `Days` int(11) NOT NULL,
  `DiscountRate` decimal(10,2) NOT NULL,
  PRIMARY KEY (`AirlineID`,`Days`),
  CONSTRAINT `advpurchasediscount_ibfk_1` FOREIGN KEY (`AirlineID`) REFERENCES `airline` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `advpurchasediscount`
--

LOCK TABLES `advpurchasediscount` WRITE;
/*!40000 ALTER TABLE `advpurchasediscount` DISABLE KEYS */;
INSERT INTO `advpurchasediscount` VALUES ('AA',7,2.50),('AA',14,5.00),('AA',30,7.50),('AM',60,10.00),('JB',7,3.00),('JB',14,6.50);
/*!40000 ALTER TABLE `advpurchasediscount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `airline`
--

DROP TABLE IF EXISTS `airline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `airline` (
  `Id` char(2) NOT NULL DEFAULT '',
  `Name` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `airline`
--

LOCK TABLES `airline` WRITE;
/*!40000 ALTER TABLE `airline` DISABLE KEYS */;
INSERT INTO `airline` VALUES ('AA','American Airlines'),('AB','Air Berlin'),('AJ','Air Japan'),('AM','Air Madagascar'),('BA','British Airways'),('DA','Delta Airlines'),('JB','JetBlue Airways'),('LA','Lufthansa'),('SA','Southwest Airlines'),('UA','United Airlines');
/*!40000 ALTER TABLE `airline` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `airport`
--

DROP TABLE IF EXISTS `airport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `airport` (
  `Id` char(3) NOT NULL DEFAULT '',
  `Name` varchar(100) NOT NULL,
  `City` varchar(50) NOT NULL,
  `Country` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `airport`
--

LOCK TABLES `airport` WRITE;
/*!40000 ALTER TABLE `airport` DISABLE KEYS */;
INSERT INTO `airport` VALUES ('BOS','General Edward Lawrence Logan International','Boston','United States of America'),('BTA','Berlin Tegel','Berlin','Germany'),('COI','Chicago O\'Hare International','Chicago','Illinois'),('HJA','Hartsfield-Jackson Atlanta Int','Atlanta','United States of America'),('IIA','Ivato International','Antananarivo','Madagascar'),('JFK','John F. Kennedy International','New York','United States of America'),('LAX','Los Angeles International','Los Angeles','United States of America'),('LGA','LaGuardia','New York','United States of America'),('LHR','London Heathrow','London','United Kingdom'),('LIA','Logan International','Boston','United States of America'),('NRT','Narita International Airport','Tokyo','Japan'),('SFO','San Francisco International','San Francisco','United States of America'),('TIA','Tokyo International','Tokyo','Japan'),('TNR','Ivato Airport','Antananarivo','Madagascar');
/*!40000 ALTER TABLE `airport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auctions`
--

DROP TABLE IF EXISTS `auctions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auctions` (
  `AccountNo` int(11) NOT NULL DEFAULT '0',
  `AirlineID` char(2) NOT NULL DEFAULT '',
  `FlightNo` int(11) NOT NULL DEFAULT '0',
  `Class` varchar(20) NOT NULL DEFAULT '',
  `Date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `NYOP` decimal(10,2) NOT NULL,
  `Accepted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`AccountNo`,`AirlineID`,`FlightNo`,`Class`,`Date`),
  KEY `AirlineID` (`AirlineID`,`FlightNo`),
  CONSTRAINT `auctions_ibfk_1` FOREIGN KEY (`AccountNo`) REFERENCES `customer` (`AccountNo`),
  CONSTRAINT `auctions_ibfk_2` FOREIGN KEY (`AirlineID`, `FlightNo`) REFERENCES `flight` (`AirlineID`, `FlightNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auctions`
--

LOCK TABLES `auctions` WRITE;
/*!40000 ALTER TABLE `auctions` DISABLE KEYS */;
INSERT INTO `auctions` VALUES (1008,'AA',111,'Economy','2011-09-09 12:14:15',500.00,1);
/*!40000 ALTER TABLE `auctions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `Id` int(11) NOT NULL,
  `AccountNo` int(11) NOT NULL DEFAULT '0',
  `CreditCardNo` char(16) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `CreationDate` datetime NOT NULL,
  `Rating` int(11) DEFAULT NULL,
  PRIMARY KEY (`AccountNo`),
  KEY `Id` (`Id`),
  CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`Id`) REFERENCES `person` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,1008,'5133982398470294','awesomejane@ftw.com','2014-03-09 15:04:05',6),(2,1009,'6011858729579922','jdoe@woot.com','2014-03-10 23:40:11',4),(3,1010,'3847019385729475','rickroller@rolld.com','2014-03-11 10:19:29',10);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customerpreferences`
--

DROP TABLE IF EXISTS `customerpreferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customerpreferences` (
  `AccountNo` int(11) NOT NULL,
  `Preference` varchar(50) NOT NULL,
  PRIMARY KEY (`AccountNo`,`Preference`),
  CONSTRAINT `customerpreferences_ibfk_1` FOREIGN KEY (`AccountNo`) REFERENCES `customer` (`AccountNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customerpreferences`
--

LOCK TABLES `customerpreferences` WRITE;
/*!40000 ALTER TABLE `customerpreferences` DISABLE KEYS */;
INSERT INTO `customerpreferences` VALUES (1008,'Window Seat'),(1009,'Aisle Seat');
/*!40000 ALTER TABLE `customerpreferences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee` (
  `Id` int(11) NOT NULL,
  `SSN` int(11) NOT NULL DEFAULT '0',
  `IsManager` tinyint(1) NOT NULL,
  `StartDate` date NOT NULL,
  `HourlyRate` decimal(10,2) NOT NULL,
  PRIMARY KEY (`SSN`),
  UNIQUE KEY `Id` (`Id`),
  CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`Id`) REFERENCES `person` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES (4,198498472,0,'2009-02-27',12.00),(5,968727462,1,'2010-03-12',14.00);
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fare`
--

DROP TABLE IF EXISTS `fare`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fare` (
  `AirlineID` char(2) NOT NULL,
  `FlightNo` int(11) NOT NULL,
  `FareType` varchar(20) NOT NULL,
  `Class` varchar(20) NOT NULL,
  `Fare` decimal(10,2) NOT NULL,
  PRIMARY KEY (`AirlineID`,`FlightNo`,`FareType`,`Class`),
  CONSTRAINT `fare_ibfk_1` FOREIGN KEY (`AirlineID`, `FlightNo`) REFERENCES `flight` (`AirlineID`, `FlightNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fare`
--

LOCK TABLES `fare` WRITE;
/*!40000 ALTER TABLE `fare` DISABLE KEYS */;
INSERT INTO `fare` VALUES ('AA',111,'ONEWAY','Economy',1200.00),('AM',1337,'ONEWAY','First',3333.33),('JB',111,'ONEWAY','First',500.00);
/*!40000 ALTER TABLE `fare` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flight`
--

DROP TABLE IF EXISTS `flight`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flight` (
  `AirlineID` char(2) NOT NULL DEFAULT '',
  `FlightNo` int(11) NOT NULL,
  `NoOfSeats` int(11) NOT NULL,
  `DaysOperating` char(7) NOT NULL,
  `MinLengthOfStay` int(11) NOT NULL,
  `MaxLengthOfStay` int(11) NOT NULL,
  PRIMARY KEY (`AirlineID`,`FlightNo`),
  CONSTRAINT `flight_ibfk_1` FOREIGN KEY (`AirlineID`) REFERENCES `airline` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flight`
--

LOCK TABLES `flight` WRITE;
/*!40000 ALTER TABLE `flight` DISABLE KEYS */;
INSERT INTO `flight` VALUES ('AA',111,100,'1010100',1,30),('AM',1337,33,'0000011',2,15),('JB',111,150,'1111111',1,45);
/*!40000 ALTER TABLE `flight` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `includes`
--

DROP TABLE IF EXISTS `includes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `includes` (
  `ResrNo` int(11) NOT NULL DEFAULT '0',
  `AirlineID` char(2) NOT NULL DEFAULT '',
  `FlightNo` int(11) NOT NULL DEFAULT '0',
  `LegNo` int(11) NOT NULL DEFAULT '0',
  `Date` date NOT NULL,
  PRIMARY KEY (`ResrNo`,`AirlineID`,`FlightNo`,`LegNo`),
  KEY `AirlineID` (`AirlineID`,`FlightNo`,`LegNo`),
  CONSTRAINT `includes_ibfk_1` FOREIGN KEY (`ResrNo`) REFERENCES `reservation` (`ResrNo`),
  CONSTRAINT `includes_ibfk_2` FOREIGN KEY (`AirlineID`, `FlightNo`, `LegNo`) REFERENCES `leg` (`AirlineID`, `FlightNo`, `LegNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `includes`
--

LOCK TABLES `includes` WRITE;
/*!40000 ALTER TABLE `includes` DISABLE KEYS */;
INSERT INTO `includes` VALUES (111,'AA',111,1,'2011-01-05'),(111,'AA',111,2,'2011-01-05'),(222,'JB',111,2,'2011-01-14'),(333,'AM',1337,1,'2011-01-13');
/*!40000 ALTER TABLE `includes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leg`
--

DROP TABLE IF EXISTS `leg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leg` (
  `AirlineID` char(2) NOT NULL DEFAULT '',
  `FlightNo` int(11) NOT NULL,
  `LegNo` int(11) NOT NULL,
  `DepAirportID` char(3) NOT NULL,
  `ArrAirportID` char(3) NOT NULL,
  `ArrTime` datetime NOT NULL,
  `DepTime` datetime NOT NULL,
  `ActualDepTime` datetime DEFAULT NULL,
  `ActualArrTime` datetime DEFAULT NULL,
  PRIMARY KEY (`AirlineID`,`FlightNo`,`LegNo`),
  UNIQUE KEY `AirlineID` (`AirlineID`,`FlightNo`,`DepAirportID`),
  KEY `DepAirportID` (`DepAirportID`),
  KEY `ArrAirportID` (`ArrAirportID`),
  CONSTRAINT `leg_ibfk_1` FOREIGN KEY (`AirlineID`, `FlightNo`) REFERENCES `flight` (`AirlineID`, `FlightNo`),
  CONSTRAINT `leg_ibfk_2` FOREIGN KEY (`DepAirportID`) REFERENCES `airport` (`Id`),
  CONSTRAINT `leg_ibfk_3` FOREIGN KEY (`ArrAirportID`) REFERENCES `airport` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leg`
--

LOCK TABLES `leg` WRITE;
/*!40000 ALTER TABLE `leg` DISABLE KEYS */;
INSERT INTO `leg` VALUES ('AA',111,1,'LGA','LAX','2011-01-05 17:00:00','2011-01-05 11:00:00','2011-01-05 11:00:00','2011-01-05 16:55:00'),('AA',111,2,'LAX','NRT','2011-01-06 07:30:00','2011-01-05 19:00:00','2011-01-05 19:08:00','2011-01-06 07:32:00'),('AM',1337,1,'JFK','TNR','2011-01-13 23:00:00','2011-01-13 07:00:00','2011-01-13 06:55:00','2011-01-13 22:58:00'),('JB',111,1,'SFO','BOS','2011-01-10 19:30:00','2011-01-10 14:00:00','2011-01-10 14:10:00','2011-01-10 19:25:00'),('JB',111,2,'BOS','LHR','2011-01-11 05:00:00','2011-01-10 22:30:00','2011-01-10 22:30:00','2011-01-11 05:40:00');
/*!40000 ALTER TABLE `leg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `passenger`
--

DROP TABLE IF EXISTS `passenger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `passenger` (
  `Id` int(11) NOT NULL DEFAULT '0',
  `AccountNo` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`,`AccountNo`),
  KEY `AccountNo` (`AccountNo`),
  CONSTRAINT `passenger_ibfk_1` FOREIGN KEY (`Id`) REFERENCES `person` (`Id`),
  CONSTRAINT `passenger_ibfk_2` FOREIGN KEY (`AccountNo`) REFERENCES `customer` (`AccountNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `passenger`
--

LOCK TABLES `passenger` WRITE;
/*!40000 ALTER TABLE `passenger` DISABLE KEYS */;
INSERT INTO `passenger` VALUES (1,1008),(2,1009),(3,1010);
/*!40000 ALTER TABLE `passenger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person` (
  `Id` int(11) NOT NULL DEFAULT '0',
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `City` varchar(50) NOT NULL,
  `State` varchar(50) NOT NULL,
  `ZipCode` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person`
--

LOCK TABLES `person` WRITE;
/*!40000 ALTER TABLE `person` DISABLE KEYS */;
INSERT INTO `person` VALUES (1,'Jane','Smith','100 Nicolls Rd','Stony Brook','New York',11790),(2,'John','Doe','123 N Fake Street','New York','New York',10001),(3,'Rick','Astley','1337 Internet Lane','Los Angeles','California',90001),(4,'Anna','Mavel','23 May Ave','Stony Brook','New York',11790),(5,'Pattrick','Vierra','12 Book Cr','Stony Brook','New York',11790);
/*!40000 ALTER TABLE `person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation` (
  `ResrNo` int(11) NOT NULL DEFAULT '0',
  `ResrDate` datetime NOT NULL,
  `BookingFee` decimal(10,2) NOT NULL,
  `TotalFare` decimal(10,2) NOT NULL,
  `RepSSN` int(11) DEFAULT NULL,
  `AccountNo` int(11) NOT NULL,
  PRIMARY KEY (`ResrNo`),
  KEY `RepSSN` (`RepSSN`),
  KEY `AccountNo` (`AccountNo`),
  CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`RepSSN`) REFERENCES `employee` (`SSN`),
  CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`AccountNo`) REFERENCES `customer` (`AccountNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation`
--

LOCK TABLES `reservation` WRITE;
/*!40000 ALTER TABLE `reservation` DISABLE KEYS */;
INSERT INTO `reservation` VALUES (111,'2011-01-04 00:00:00',120.00,1200.00,198498472,1009),(222,'2010-11-11 00:00:00',50.00,500.00,968727462,1008),(333,'2011-01-10 00:00:00',333.33,3333.33,198498472,1010);
/*!40000 ALTER TABLE `reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservationpassenger`
--

DROP TABLE IF EXISTS `reservationpassenger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservationpassenger` (
  `ResrNo` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL DEFAULT '0',
  `AccountNo` int(11) NOT NULL DEFAULT '0',
  `SeatNo` char(5) NOT NULL,
  `Class` varchar(20) NOT NULL,
  `Meal` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ResrNo`,`Id`,`AccountNo`),
  KEY `Id` (`Id`,`AccountNo`),
  CONSTRAINT `reservationpassenger_ibfk_1` FOREIGN KEY (`ResrNo`) REFERENCES `reservation` (`ResrNo`),
  CONSTRAINT `reservationpassenger_ibfk_2` FOREIGN KEY (`Id`, `AccountNo`) REFERENCES `passenger` (`Id`, `AccountNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservationpassenger`
--

LOCK TABLES `reservationpassenger` WRITE;
/*!40000 ALTER TABLE `reservationpassenger` DISABLE KEYS */;
INSERT INTO `reservationpassenger` VALUES (111,2,1009,'33F','Economy','Chips'),(222,1,1008,'13A','First','Fish and Chips'),(333,3,1010,'1A','First','Sushi');
/*!40000 ALTER TABLE `reservationpassenger` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-26 21:32:27
