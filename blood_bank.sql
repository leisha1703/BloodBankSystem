-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 15, 2024 at 11:32 AM
-- Server version: 8.0.36
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `blood_samples`
--

DROP TABLE IF EXISTS `blood_samples`;
CREATE TABLE IF NOT EXISTS `blood_samples` (
  `id` int NOT NULL AUTO_INCREMENT,
  `blood_type` varchar(5) NOT NULL,
  `quantity` int NOT NULL,
  `hospital_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `hospital_id` (`hospital_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `blood_samples`
--

INSERT INTO `blood_samples` (`id`, `blood_type`, `quantity`, `hospital_id`, `created_at`) VALUES
(1, 'A+', 8, 1, '2024-06-13 18:12:37'),
(2, 'A+', 8, 1, '2024-06-13 18:12:43'),
(3, 'O+', 9, 1, '2024-06-13 19:05:37'),
(4, 'AB-', 10, 1, '2024-06-15 03:37:30');

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

DROP TABLE IF EXISTS `hospitals`;
CREATE TABLE IF NOT EXISTS `hospitals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hospitalName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`id`, `hospitalName`, `email`, `password`) VALUES
(1, 'ABC', 'leisha1703@gmail.com', '$2y$10$Z.MVQDDLZ28LLV.n/yXVjOHjLM1Oq2dVXBiOy3fyyHRHYJpa3AsQ2');

-- --------------------------------------------------------

--
-- Table structure for table `receivers`
--

DROP TABLE IF EXISTS `receivers`;
CREATE TABLE IF NOT EXISTS `receivers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `bloodGroup` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `receivers`
--

INSERT INTO `receivers` (`id`, `name`, `email`, `password`, `bloodGroup`) VALUES
(1, 'Leisha', 'poonamlakhanpal901@gmail.com', '$2y$10$gRzaxHR5IzgB3l2mMga8h.miUhDxUyMyTJvFEM6zJ.kSv.hEZWsiK', 'A+'),
(2, 'Poonam', 'poonamlakhanpal9@gmail.com', '$2y$10$SgK7weKeIh9jndxRp/hu5eIJg0MuaS2c5Plc/kG5iUVXulFiVwvim', 'O+'),
(3, 'Lovely', 'leisha1950@gmail.com', '$2y$10$JQx8ez1zQOtAUyDS1hjEmezcX.RqK7EW.mF2R784V7zjwxP6.NxKW', 'AB-');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
CREATE TABLE IF NOT EXISTS `requests` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `receiver_id` int NOT NULL,
  `blood_sample_id` int NOT NULL,
  `request_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`request_id`),
  KEY `receiver_id` (`receiver_id`),
  KEY `blood_sample_id` (`blood_sample_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`request_id`, `receiver_id`, `blood_sample_id`, `request_date`) VALUES
(1, 1, 1, '2024-06-14 00:27:37'),
(2, 3, 4, '2024-06-15 16:55:21');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood_samples`
--
ALTER TABLE `blood_samples`
  ADD CONSTRAINT `blood_samples_ibfk_1` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`receiver_id`) REFERENCES `receivers` (`id`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`blood_sample_id`) REFERENCES `blood_samples` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
