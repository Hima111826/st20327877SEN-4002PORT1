-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 01, 2025 at 04:07 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`) VALUES
(10, 'systemuser', '$2b$12$Bz213N.CH0jx02.TpubxGOcfjGwPRjDfwEihNqVMvWLc6DUAmVGJq', '2025-07-26 14:08:50');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `duration` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `fee`, `duration`) VALUES
(13, 'main|Bussiness Management', 45000.00, '6 month'),
(14, 'main|Computer Science', 50000.00, '1 year'),
(15, 'main|Markiting', 40000.00, '6 month'),
(16, 'main|Artificial Intelligence', 70000.00, '2 year'),
(17, 'main|Software Engineering', 65000.00, '2 year'),
(19, 'foundation|Basic IT Skills', 20000.00, '6 month'),
(20, 'foundation|Introduction To Business', 25000.00, '3month'),
(21, 'foundation|Communication Skills', 20000.00, '3month'),
(23, 'foundation|English', 20000.00, '3 month');

-- --------------------------------------------------------

--
-- Table structure for table `course_registrations`
--

DROP TABLE IF EXISTS `course_registrations`;
CREATE TABLE IF NOT EXISTS `course_registrations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `course_id` int NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `birthday` date NOT NULL,
  `age` int NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `level_result` varchar(50) NOT NULL,
  `english_result` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL,
  `subject_taken` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `course_registrations`
--

INSERT INTO `course_registrations` (`id`, `student_id`, `course_id`, `full_name`, `email`, `phone`, `birthday`, `age`, `gender`, `address`, `level_result`, `english_result`, `created_at`, `subject_taken`) VALUES
(10, 2, 14, 'Himasha Sathsarani Bandara', 'bandarahimasha6@gmail.com', '0705386063', '2004-04-28', 21, 'Female', 'Ratnapura', 'SSS', 'C', '0000-00-00 00:00:00', 'Maths'),
(11, 9, 13, 'Sasitha Sadaruwan Kumarathunge', 'sasitha@gmail.com', '0762905918', '2003-11-11', 22, 'Male', 'Ratnapura', 'SSS', 'A', '0000-00-00 00:00:00', 'Science'),
(12, 10, 15, 'Danusha dananjaya kumarathunge', 'danusha@gmail.com', '0714563369', '2006-10-10', 19, 'Male', 'ratnapura', 'SSS', 'B', '0000-00-00 00:00:00', 'Maths'),
(14, 13, 13, 'Maneesha nimsarani bandara', 'maneesha@gmail.com', '0719180005', '2012-12-04', 20, 'Female', 'pelmadulla', 'SSS', 'c', '2025-08-04 10:08:43', 'Science');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `receiver_id` int DEFAULT NULL,
  `role` enum('student','admin') NOT NULL,
  `content` text NOT NULL,
  `reply` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `role`, `content`, `reply`, `created_at`) VALUES
(3, 10, 0, 'student', 'i registed today', NULL, '2025-08-02 10:34:12'),
(4, 10, 10, 'admin', 'please register your course', NULL, '2025-08-02 10:35:24');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `course_id` int NOT NULL,
  `method` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) NOT NULL DEFAULT 'not',
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `student_id`, `amount`, `transaction_id`, `course_id`, `method`, `created_at`, `status`) VALUES
(13, 9, 45000.00, NULL, 13, 'Bank Transfer', '2025-07-27 13:38:37', 'Paid'),
(14, 10, 40000.00, NULL, 15, 'PayPal', '2025-08-02 10:33:52', 'Paid'),
(17, 9, 50000.00, NULL, 14, 'Bank Transfer', '2025-08-04 12:08:30', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `password`, `phone`, `created_at`) VALUES
(10, 'Danusha', 'danusha@gmail.com', '$2y$10$xyduMmXWamJKKbNDSmakoO0PYcucr0v1X7qOSOCc0RN7M1wQ83iAq', '0714566548', '2025-08-02 10:27:05'),
(13, 'Maneesha', 'maneesha@gmail.com', '$2y$10$9aIQkEZ3q/wgQtoclCbaFOLxz0pTRLxbVVd0hqeDzvrCKZA/VmK22', '0719180005', '2025-08-04 09:59:30'),
(9, 'Sasitha', 'sasitha@gmail.com', '$2y$10$JJkf0ammf6VzanBYx0JpTel0kb3sjVdixW4K.vIDDfR1tvOZfR8Da', '0762905918', '2025-07-27 13:25:42');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
