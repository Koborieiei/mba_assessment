-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 19, 2021 at 08:52 AM
-- Server version: 5.6.36
-- PHP Version: 7.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_utccmba`
--

-- --------------------------------------------------------

--
-- Table structure for table `asm_assetmentform`
--

CREATE TABLE `asm_term` (
  `id` int(11) NOT NULL,
  `term` varchar(50) NOT NULL,
  `year` varchar(4) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `asm_term`
--

INSERT INTO `asm_term` (`id`, `term`, `year`, `created_at`, `deleted_at`) VALUES
(1, 'ภาคต้น', '2021', '2021-03-24 15:17:17', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asm_term`
--
ALTER TABLE `asm_term`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asm_term`
--
ALTER TABLE `asm_term`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


CREATE TABLE `asm_assetmentform` (
  `id` int(11) NOT NULL,
  `course_id` varchar(100) DEFAULT NULL,
  `question_id` varchar(255) NOT NULL,
  `teacher_id` varchar(255) NOT NULL,
  `user_created` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `startdate` datetime NOT NULL,
  `enddate` datetime NOT NULL,
  `is_visible` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `asm_assetmentform`
--

INSERT INTO `asm_assetmentform` (`id`, `course_id`, `question_id`, `teacher_id`, `user_created`, `term_id`, `startdate`, `enddate`, `is_visible`, `created_at`, `deleted_at`) VALUES
(3, '60', '1,2,3,4,5', '3', 11, 1, '2021-03-02 00:00:00', '2021-03-01 00:00:00', 1, '2021-03-24 15:17:23', NULL),
(4, '53', '1,2,3,4,5', '4', 11, 1, '2021-03-02 00:00:00', '2021-03-01 00:00:00', 1, '2021-03-24 15:17:23', NULL),
(5, '60', '1,2,3,4,5', '5', 11, 1, '2021-03-02 00:00:00', '2021-03-01 00:00:00', 1, '2021-03-24 15:17:23', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asm_assetmentform`
--
ALTER TABLE `asm_assetmentform`
  ADD PRIMARY KEY (`id`),
  ADD KEY `term_id` (`term_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asm_assetmentform`
--
ALTER TABLE `asm_assetmentform`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asm_assetmentform`
--
ALTER TABLE `asm_assetmentform`
  ADD CONSTRAINT `asm_assetmentform_ibfk_1` FOREIGN KEY (`term_id`) REFERENCES `asm_term` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


--
-- Table structure for table `asm_transection`
--

CREATE TABLE `asm_transection` (
  `id` int(11) NOT NULL,
  `assetmentform_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `asm_transection`
--

INSERT INTO `asm_transection` (`id`, `assetmentform_id`, `created_at`, `deleted_at`, `user_id`, `teacher_id`) VALUES
(6, 3, '2021-04-12 10:47:55', NULL, 2, 313),
(19, 4, '2021-04-12 10:42:46', NULL, 2, 22),
(26, 5, '2021-04-11 14:52:53', NULL, 2, 89),
(29, 3, '2021-04-12 10:50:45', NULL, 2, 515),
(30, 3, '2021-04-12 20:02:59', NULL, 2, 0),
(31, 3, '2021-04-12 20:03:55', NULL, 2, 0),
(32, 3, '2021-04-12 20:04:02', NULL, 2, 515),
(33, 4, '2021-04-12 20:10:33', NULL, 2, 515),
(34, 4, '2021-04-12 21:01:11', NULL, 2, 515);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asm_transection`
--
ALTER TABLE `asm_transection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assetmentform_id` (`assetmentform_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asm_transection`
--
ALTER TABLE `asm_transection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asm_transection`
--
ALTER TABLE `asm_transection`
  ADD CONSTRAINT `asm_transection_ibfk_1` FOREIGN KEY (`assetmentform_id`) REFERENCES `asm_assetmentform` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- --------------------------------------------------------

--
-- Table structure for table `asm_rating`
--

CREATE TABLE `asm_rating` (
  `id` int(11) NOT NULL,
  `question_id` varchar(255) NOT NULL,
  `score` int(1) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `transection_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `asm_rating`
--

INSERT INTO `asm_rating` (`id`, `question_id`, `score`, `created_at`, `deleted_at`, `transection_id`) VALUES
(65, '1', 4, '2021-04-10 09:56:22', NULL, 6),
(66, '2', 5, '2021-04-10 09:56:22', NULL, 6),
(67, '5', 1, '2021-04-10 09:56:22', NULL, 6),
(68, '6', 2, '2021-04-10 09:56:22', NULL, 6),
(69, '7', 4, '2021-04-10 09:56:22', NULL, 6),
(70, '1', 2, '2021-04-11 11:21:28', NULL, 19),
(71, '2', 2, '2021-04-11 11:21:28', NULL, 19),
(72, '5', 2, '2021-04-11 11:21:28', NULL, 19),
(73, '6', 2, '2021-04-11 11:21:28', NULL, 19),
(74, '7', 3, '2021-04-11 11:21:28', NULL, 19),
(100, '1', 2, '2021-04-11 14:52:53', NULL, 26),
(101, '2', 2, '2021-04-11 14:52:53', NULL, 26),
(102, '5', 3, '2021-04-11 14:52:53', NULL, 26),
(103, '6', 2, '2021-04-11 14:52:53', NULL, 26),
(104, '7', 1, '2021-04-11 14:52:53', NULL, 26);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asm_rating`
--
ALTER TABLE `asm_rating`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asm_rating`
--
ALTER TABLE `asm_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



CREATE TABLE `asm_questions` (
  `id` int(11) NOT NULL,
  `assetmentform_id` int(11) NOT NULL,
  `question_text` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `question_type` int(1) NOT NULL COMMENT '1 = Multiple Choice 2 = True / False'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `asm_questions`
--

INSERT INTO `asm_questions` (`id`, `assetmentform_id`, `question_text`, `created_at`, `deleted_at`, `question_type`) VALUES
(1, 3, 'อาจารย์อธิบายวัตถุประสงค์ เค้าโครงวิชาที่จะศึกษา', '2021-03-24 15:20:15', NULL, 1),
(2, 3, 'อาจารย์สอนตรงตามวัตถุประสงค์ และครบถ้วนตามเค้าโครงวิชาที่ได้อธิบายไว้', '2021-03-24 15:20:15', NULL, 1),
(5, 3, 'Question Three', '2021-03-18 00:00:00', NULL, 1),
(6, 3, 'Question Four', '2021-03-18 00:00:00', NULL, 2),
(7, 3, 'Question Five', '2021-03-18 00:00:00', NULL, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asm_questions`
--
ALTER TABLE `asm_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assetmentform_id` (`assetmentform_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asm_questions`
--
ALTER TABLE `asm_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asm_questions`
--
ALTER TABLE `asm_questions`
  ADD CONSTRAINT `asm_questions_ibfk_1` FOREIGN KEY (`assetmentform_id`) REFERENCES `asm_assetmentform` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


--
-- Table structure for table `asm_comment`
--

CREATE TABLE `asm_comment` (
  `id` int(11) NOT NULL,
  `comment_message` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `transection_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `asm_comment`
--

INSERT INTO `asm_comment` (`id`, `comment_message`, `created_at`, `deleted_at`, `transection_id`) VALUES
(15, 'sdsd', '2021-04-06 06:59:31', NULL, 6),
(16, '', '2021-04-06 07:01:11', NULL, 6),
(17, '', '2021-04-06 07:01:20', NULL, 6),
(18, '', '2021-04-06 07:01:41', NULL, 6),
(19, '', '2021-04-06 07:02:05', NULL, 6),
(20, '', '2021-04-06 07:02:09', NULL, 6),
(21, 'sdfsdf', '2021-04-10 09:56:22', NULL, 6),
(22, 'sdfsdf', '2021-04-11 14:52:34', NULL, 19),
(23, 'sdfsdf', '2021-04-11 14:52:53', NULL, 26),
(24, ' ', '2021-04-12 10:42:46', NULL, 26),
(25, ' ', '2021-04-12 10:47:55', NULL, 26),
(26, 'asdasd', '2021-04-12 10:50:45', NULL, 26),
(27, 'sdf', '2021-04-12 20:02:59', NULL, 26),
(28, 'dfsfd', '2021-04-12 20:03:55', NULL, 26),
(29, 'dfsfd', '2021-04-12 20:04:02', NULL, 26),
(30, 'dfsfd', '2021-04-12 20:10:33', NULL, 26),
(31, 'sdfsdf', '2021-04-12 21:01:11', NULL, 26);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asm_comment`
--
ALTER TABLE `asm_comment`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asm_comment`
--
ALTER TABLE `asm_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
