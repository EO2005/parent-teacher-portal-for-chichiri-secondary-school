-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 06, 2023 at 12:32 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parent_teacher_portal_chichiri`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `student_id` varchar(9) DEFAULT NULL,
  `DateTaken` date DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `class_id` int DEFAULT NULL,
  KEY `student_id` (`student_id`),
  KEY `class_id` (`class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`student_id`, `DateTaken`, `status`, `class_id`) VALUES
('P00195102', '2023-10-06', 'Present', 5),
('P01195102', '2023-10-06', 'Present', 6);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `class_id` int NOT NULL AUTO_INCREMENT,
  `class_name` varchar(30) DEFAULT NULL,
  `date_enrolled` date DEFAULT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `date_enrolled`) VALUES
(4, 'Form 1', '2023-06-16'),
(5, 'Form 2', '2023-10-11'),
(6, 'Form 3', '2023-09-07');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `start`, `end`) VALUES
(29, 'Submission Date', 'Today is the day of submission', '2023-10-06', '2023-10-07');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
CREATE TABLE IF NOT EXISTS `grades` (
  `student_id` varchar(10) DEFAULT NULL,
  `subject_id` int DEFAULT NULL,
  `grade_value` int DEFAULT NULL,
  `type_of_assessment` varchar(30) DEFAULT NULL,
  `comments` varchar(150) DEFAULT NULL,
  `grade_id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`grade_id`),
  KEY `subject_id` (`subject_id`),
  KEY `student_id` (`student_id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`student_id`, `subject_id`, `grade_value`, `type_of_assessment`, `comments`, `grade_id`) VALUES
('P00195102', 19, 90, 'Weekly-Test', 'This student did good', 51),
('P00195102', 24, 40, 'Weekly-Test', 'This student did very good', 52),
('P00195102', 20, 80, 'Weekly-Test', 'This student did very well', 53),
('P01195102', 19, 90, 'Weekly-Test', 'This student did very good', 54),
('P01195102', 23, 90, 'Homework', 'This student did good', 55),
('P01195102', 19, 50, 'Weekly-Test', 'This student did good', 56),
('P01195102', 24, 20, 'Weekly-Test', 'This student did good', 57);

-- --------------------------------------------------------

--
-- Table structure for table `message_teacher`
--

DROP TABLE IF EXISTS `message_teacher`;
CREATE TABLE IF NOT EXISTS `message_teacher` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` varchar(10) NOT NULL,
  `receiver_id` varchar(10) NOT NULL,
  `message_text` varchar(1000) DEFAULT NULL,
  `time_sent` time DEFAULT NULL,
  `date_sent` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`)
) ENGINE=MyISAM AUTO_INCREMENT=177 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `message_teacher`
--

INSERT INTO `message_teacher` (`id`, `sender_id`, `receiver_id`, `message_text`, `time_sent`, `date_sent`) VALUES
(175, 'T10000101', 'P00195120', 'Hello John', '13:22:00', '2023-10-06'),
(176, 'P00195120', 'T10000101', 'Hello John', '13:22:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
CREATE TABLE IF NOT EXISTS `notification` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `reciver_id` varchar(12) DEFAULT NULL,
  `read_status` tinyint DEFAULT '0',
  `created_date` date DEFAULT NULL,
  `created_time` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reciver_id` (`reciver_id`)
) ENGINE=MyISAM AUTO_INCREMENT=164 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `title`, `description`, `reciver_id`, `read_status`, `created_date`, `created_time`) VALUES
(162, 'New Message', 'Hello John', 'P00195120', 0, '2023-10-06', '13:22:00'),
(163, 'New Message', 'Hello John', 'T10000101', 0, '2023-10-06', '13:22:37');

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

DROP TABLE IF EXISTS `parents`;
CREATE TABLE IF NOT EXISTS `parents` (
  `parent_id` varchar(10) NOT NULL,
  `password` varchar(20) DEFAULT NULL,
  `first_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `email_address` varchar(60) DEFAULT NULL,
  `address` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`parent_id`, `password`, `first_name`, `last_name`, `phone_number`, `email_address`, `address`) VALUES
('P000000000', '1234', 'Eugene', 'Onions', '0998666666', 'eugeneonions8@gmail.com', 'New York'),
('P100200300', '1234', 'Steve', 'Doe', '0998676756', 'JohnDoe@gmail.com', 'New York'),
('P123123121', '1234', 'Emmie', 'Shaibu', '0880758964', 'sha@gmail.com', 'Chileka'),
('P00195120', '1234', 'John', 'Doe', '0998666623', 'JohnDoe@mail.com', 'New York, Nashvile');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `student_id` varchar(9) NOT NULL,
  `first_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `address` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `date_of_birth`, `gender`, `address`) VALUES
('P00879124', 'Eugene', 'Onions', '2023-10-06', 'Male', 'New York'),
('P00879165', 'Eugene', 'Logan', '2006-03-08', 'Male', 'New York, Nashvile example'),
('P00195102', 'Snork', 'Doe', '2006-09-11', 'Male', 'Chileka'),
('P01195102', 'Eugene', 'Fergenson', '2005-05-17', 'Male', 'Chileka');

-- --------------------------------------------------------

--
-- Table structure for table `student_classes`
--

DROP TABLE IF EXISTS `student_classes`;
CREATE TABLE IF NOT EXISTS `student_classes` (
  `student_id` varchar(9) DEFAULT NULL,
  `class_id` int DEFAULT NULL,
  KEY `student_id` (`student_id`),
  KEY `class_id` (`class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student_classes`
--

INSERT INTO `student_classes` (`student_id`, `class_id`) VALUES
('P00195102', 5),
('P01195102', 6);

-- --------------------------------------------------------

--
-- Table structure for table `student_parents`
--

DROP TABLE IF EXISTS `student_parents`;
CREATE TABLE IF NOT EXISTS `student_parents` (
  `student_id` varchar(9) DEFAULT NULL,
  `parent_id` varchar(10) DEFAULT NULL,
  KEY `student_id` (`student_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student_parents`
--

INSERT INTO `student_parents` (`student_id`, `parent_id`) VALUES
('P00879124', 'P000000000'),
('P00879124', 'P000000000'),
('P00879165', 'P000000000'),
('P00195102', 'P100200300'),
('P01195102', 'P00195120');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE IF NOT EXISTS `subjects` (
  `subject_id` int NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`) VALUES
(19, 'English'),
(20, 'ICT'),
(21, 'Math'),
(22, 'Science'),
(23, 'Geography'),
(24, 'Physics'),
(25, 'Chemistry'),
(26, 'Chichewa'),
(27, 'History');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE IF NOT EXISTS `teachers` (
  `teacher_id` varchar(10) NOT NULL,
  `password` varchar(20) DEFAULT NULL,
  `first_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`teacher_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `password`, `first_name`, `last_name`, `gender`) VALUES
('T10000101', '1234', 'Eugene', 'Onions', 'Male');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
