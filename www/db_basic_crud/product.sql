--
-- 資料表結構 `price`
--

CREATE TABLE `price` (
  `no` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `category` varchar(20) NOT NULL DEFAULT '',
  `brand` varchar(20) NOT NULL DEFAULT '',
  `specification` varchar(100) NOT NULL DEFAULT '',
  `price` int(11) NOT NULL DEFAULT 0,
  `date` date NOT NULL DEFAULT '2021-01-24',
  `url` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `price`
--

INSERT INTO `price` (`no`, `category`, `brand`, `specification`, `price`, `date`, `url`) VALUES
(1, '主機板', '華碩', 'P8B75-V', 2850, '2021-01-24', 'tw.asus.com'),
(2, '主機板', '微星', 'H87M-E33', 2450, '2021-01-24', 'tw.msi.com'),
(3, '主機板', '技嘉', 'Z87X-D3H', 4650, '2021-01-24', 'www.gigabyte.tw'),
(4, '主機板', '華碩', 'P8H77-V', 3550, '2021-01-24', 'tw.asus.com'),
(5, '主機板', '華碩', 'H61M-E', 1750, '2021-01-24', 'tw.asus.com'),
(6, '主機板', '微星', 'Z87-GD65 GAMING', 7950, '2021-01-24', 'tw.msi.com'),
(7, '主機板', '技嘉', 'B85M-D2V', 1950, '2021-01-24', 'www.gigabyte.tw'),
(8, '主機板', '微星', 'H87M-G43', 3050, '2021-01-24', 'tw.msi.com'),
(9, '主機板', '微星', 'B85-G43 GAMING', 3150, '2021-01-24', 'tw.msi.com'),
(10, '主機板', '技嘉', 'H81M-DS2', 1850, '2021-01-24', 'www.gigabyte.tw'),
(11, 'CPU', 'Intel', 'Core i7-4770K', 10330, '2021-01-24', 'www.intel.com.tw'),
(12, 'CPU', 'Intel', 'Core i7-4770', 9200, '2021-01-24', 'www.intel.com.tw'),
(13, 'CPU', 'Intel', 'Xeon E3-1230V3', 7500, '2021-01-24', 'www.intel.com.tw'),
(14, 'CPU', 'AMD', 'Piledriver FX-8320', 5000, '2021-01-24', 'www.amd.com/tw'),
(15, 'CPU', 'AMD', 'Piledriver FX-8350', 5800, '2021-01-24', 'www.amd.com/tw'),
(19, '記憶體', '創見', 'DDR3 1600 8G', 1900, '2021-01-24', 'tw.transcend-info.com'),
(18, '記憶體', '金士頓', 'DDR3 1600 4G', 1000, '2021-01-24', 'www.kingston.com/tw'),
(17, '記憶體', '金士頓', 'DDR3 1600 8G', 1900, '2021-01-24', 'www.kingston.com/tw'),
(16, '記憶體', '創見', 'DDR3 1333 8G', 2100, '2021-01-24', 'tw.transcend-info.com'),
(20, '記憶體', '創見', 'JetRam DDR2 800 2G', 850, '2021-01-24', 'tw.transcend-info.com'),
(21, '顯示卡', '微星', 'N780 3GD5', 17500, '2021-01-24', 'tw.msi.com'),
(22, '顯示卡', '華碩', 'GTX650 DCT-1GD5', 4000, '2021-01-24', 'tw.asus.com'),
(23, '顯示卡', '微星', 'N660-2GD5/OC', 5500, '2021-01-24', 'tw.msi.com'),
(25, '硬碟', 'WD', 'Blue 1TB 3.5 吋 7200 轉', 1900, '2021-01-24', 'www.wdc.com/ch'),
(24, '顯示卡', '華碩', 'GTX760-DC2OC-2GD5', 9500, '2021-01-24', 'tw.asus.com'),
(26, '硬碟', 'Seagate', '1TB 3.5 吋 7200 轉', 1900, '2020-01-24', 'www.seagate.com'),
(27, '硬碟', 'WD', 'Black 4TB 3.5 吋 7200 轉', 7900, '2020-01-24', 'www.wdc.com/ch'),
(28, '硬碟', 'WD', 'Black 500GB 3.5 吋 7200 轉', 2100, '2020-01-24', 'www.wdc.com/ch'),
(29, '硬碟', 'Seagate', '2TB 3.5 吋 7200 轉', 3800, '2020-01-24', 'www.seagate.com'),
(30, '螢幕', 'DELL', 'UltraSharp U2413 24\"', 17900, '2020-01-24', 'www.dell.com.tw'),
(31, '螢幕', 'DELL', 'UltraSharp U3014 30\"', 53500, '2020-01-24', 'www.dell.com.tw'),
(32, '螢幕', 'EIZO', 'ColorEdge CX240 24\"', 49500, '2020-01-24', 'www.eizo.com.tw'),
(33, '螢幕', 'EIZO', 'FlexScan EV2316W 23\"', 9800, '2020-01-24', 'www.eizo.com.tw'),
(34, '螢幕', '華碩', 'VS228NE 22\"', 3400, '2020-01-24', 'tw.asus.com'),
(35, '螢幕', '華碩', 'MX279H 27\"', 11200, '2020-01-24', 'tw.asus.com'),
(36, '平板電腦', 'Apple', 'iPad 4G+Wi-Fi 128G', 26800, '2020-01-24', 'www.apple.com/tw'),
(37, '平板電腦', 'Apple', 'iPad mini 4G+Wi-Fi 64G', 19800, '2020-01-24', 'www.apple.com/tw'),
(38, '平板電腦', 'Apple', 'iPad Wi-Fi 32G', 16800, '2020-01-24', 'www.apple.com/tw'),
(39, '平板電腦', '華碩', 'Transformer Pad ', 15800, '2020-01-24', 'tw.asus.com'),
(40, '平板電腦', '華碩', 'ME102A 16GB Wi-Fi', 8900, '2020-01-24', 'tw.asus.com');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`no`);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
