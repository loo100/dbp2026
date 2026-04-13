-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-09-30 05:12:46
-- 伺服器版本： 10.4.20-MariaDB
-- PHP 版本： 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


-- --------------------------------------------------------

--
-- 資料表結構 `album`
--

CREATE TABLE `album` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `owner` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `album`
--

INSERT INTO `album` (`id`, `name`, `owner`) VALUES
(2, '布拉格', 'jean'),
(1, '維也納', 'jean');

-- --------------------------------------------------------

--
-- 資料表結構 `photo`
--

CREATE TABLE `photo` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `filename` varchar(64) NOT NULL,
  `comment` varchar(512) DEFAULT NULL,
  `album_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `photo`
--

INSERT INTO `photo` (`id`, `name`, `filename`, `comment`, `album_id`) VALUES
(142, 'IMG_0084.JPG', '57be72b12fbb0.jpg', NULL, 1),
(141, 'IMG_0086.JPG', '57be71ce3b56c.jpg', '天文鐘', 2),
(140, 'IMG_0098 (3).JPG', '57be71cd6ddd7.jpg', NULL, 2),
(139, 'P_20160720_132256.jpg', '57be71ccbcb68.jpg', '布拉格查爾斯橋', 2),
(138, 'P_20160720_135641.jpg', '57be71cc1c0f3.jpg', NULL, 2),
(137, 'IMG_0152.JPG', '57be712335cc3.jpg', NULL, 1),
(136, 'IMG_0049 (2).JPG', '57be7122573b9.jpg', NULL, 1),
(135, 'IMG_0022.JPG', '57be71218d2d5.jpg', NULL, 1),
(134, 'IMG_0006.JPG', '57be71209a58f.jpg', NULL, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `account` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `user`
--

INSERT INTO `user` (`account`, `password`, `name`) VALUES
('jean', 'jean', 'Jean'),
('jerry', 'jerry', 'Jerry');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `album_id` (`album_id`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`account`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
