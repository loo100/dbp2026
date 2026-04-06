-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20251116.dfcf3dd949
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 06, 2026 at 01:10 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `card_message`
--

CREATE TABLE `card_message` (
  `id` int UNSIGNED NOT NULL,
  `card_id` varchar(20) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `from_name` varchar(100) NOT NULL,
  `from_email` varchar(255) NOT NULL,
  `to_name` varchar(100) NOT NULL,
  `to_email` varchar(255) NOT NULL,
  `music` varchar(50) NOT NULL,
  `style` varchar(20) NOT NULL,
  `size` varchar(20) NOT NULL,
  `color` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `card_message`
--

INSERT INTO `card_message` (`id`, `card_id`, `subject`, `from_name`, `from_email`, `to_name`, `to_email`, `music`, `style`, `size`, `color`, `message`, `date`) VALUES
(1, '1.jpg', '生日快樂', '小明', 'ming@example.com', '小華', 'hua@example.com', 'music_01.mid', 'normal', '12 pt', '#000000', '祝你生日快樂，天天開心！', '2026-04-06 10:00:00'),
(2, '3.jpg', '母親節快樂', '阿志', 'zhi@example.com', '媽媽', 'mom@example.com', 'music_02.mid', 'italic', '14 pt', '#FF0000', '謝謝您一直以來的照顧，母親節快樂！', '2026-04-06 10:05:00'),
(3, '6.jpg', '平安夜祝福', 'Kevin', 'kevin@example.com', 'Amy', 'amy@example.com', 'music_04.mid', 'normal', '16 pt', '#333399', '願你有個溫暖又平安的夜晚。', '2026-04-06 10:10:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card_message`
--
ALTER TABLE `card_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_subject_date` (`subject`,`date`),
  ADD KEY `idx_to_email` (`to_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `card_message`
--
ALTER TABLE `card_message`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
