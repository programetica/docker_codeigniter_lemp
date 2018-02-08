-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Feb 06, 2018 at 06:33 PM
-- Server version: 10.1.30-MariaDB-1~jessie
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `docker_codeigniter_lemp`
--

-- --------------------------------------------------------

--
-- Table structure for table `PEOPLE`
--

CREATE TABLE `PEOPLE` (
  `PERSON_ID` int(11) NOT NULL,
  `LAST_NAME` varchar(100) NOT NULL,
  `FIRST_NAME` varchar(100) NOT NULL,
  `PHONE_NUMBER` varchar(12) NOT NULL,
  `EMAIL` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `PEOPLE`
--

INSERT INTO `PEOPLE` (`PERSON_ID`, `LAST_NAME`, `FIRST_NAME`, `PHONE_NUMBER`, `EMAIL`) VALUES
(1, 'Johnson', 'Johnny', '222-2222', 'johnny.johnson');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `PEOPLE`
--
ALTER TABLE `PEOPLE`
  ADD PRIMARY KEY (`PERSON_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `PEOPLE`
--
ALTER TABLE `PEOPLE`
  MODIFY `PERSON_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
