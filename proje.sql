-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 09 Ara 2021, 17:04:50
-- Sunucu sürümü: 10.4.21-MariaDB
-- PHP Sürümü: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `proje`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `calisanlar`
--

CREATE TABLE `calisanlar` (
  `id` int(20) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL,
  `surname` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL,
  `tel` int(12) NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `tc_number` int(12) NOT NULL,
  `department` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL,
  `duty` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL,
  `wage` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `calisanlar`
--

INSERT INTO `calisanlar` (`id`, `name`, `surname`, `tel`, `email`, `tc_number`, `department`, `duty`, `wage`, `reg_date`) VALUES
(2, 'taha', 'aslan', 1, '1', 1, '1', '1', '1', '2021-11-17 11:51:13'),
(4, 'sevval', 'ural', 854545, 'wewewe@gmail.com', 7468757, 'çene', '5000tl', 'dolgu', '2021-11-19 07:38:25'),
(5, 'guncellendı', 'guncel', 4566, 'lusıdt7ftgs@gmail.com', 7468498, 'çene', '5000tl', 'dolgu', '2021-11-19 07:19:00'),
(6, 'şevvalll', 'ural', 45123166, 'fgh1fgh@gmail.com', 74168498, 'çene', '50000tl', 'dolgu', '2021-11-22 07:28:13');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `doktorlar`
--

CREATE TABLE `doktorlar` (
  `id` int(12) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL,
  `surname` int(20) NOT NULL,
  `tel` int(12) NOT NULL,
  `email` int(50) NOT NULL,
  `tc_number` int(12) NOT NULL,
  `department` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL,
  `duty` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL,
  `wage` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `hasta_bilgileri`
--

CREATE TABLE `hasta_bilgileri` (
  `id` int(20) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL,
  `surname` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL,
  `tel` int(12) NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `tc_number` int(12) NOT NULL,
  `password` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL,
  `date_birth` date NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `hasta_bilgileri`
--

INSERT INTO `hasta_bilgileri` (`id`, `name`, `surname`, `tel`, `email`, `tc_number`, `password`, `date_birth`, `reg_date`) VALUES
(4, 'şevvalll', 'ural', 45123166, 'fgh1fgh@gmail.com', 74168498, '', '2000-01-01', '2021-11-22 07:40:51');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `hasta_kayitlari`
--

CREATE TABLE `hasta_kayitlari` (
  `id` int(100) NOT NULL,
  `hasta_id` int(100) NOT NULL,
  `ucret_id` int(100) NOT NULL,
  `doktor_id` int(100) NOT NULL,
  `aciklama` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `bakiye_id` int(100) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `hasta_kayitlari`
--

INSERT INTO `hasta_kayitlari` (`id`, `hasta_id`, `ucret_id`, `doktor_id`, `aciklama`, `bakiye_id`, `reg_date`) VALUES
(1, 5, 5, 5, '5', 5, '2021-11-22 07:59:25');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanıcılar`
--

CREATE TABLE `kullanıcılar` (
  `id` int(20) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL,
  `surname` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL,
  `tel` int(12) NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `kullanıcılar`
--

INSERT INTO `kullanıcılar` (`id`, `name`, `surname`, `tel`, `email`, `password`, `token`, `reg_date`) VALUES
(1, 'koray', 'aslan', 2147483647, 'koray.aslan.44@gmail.com', '1234', '1', '2021-11-17 11:37:47'),
(2, 'şevval', 'ural', 2147483647, 'sevvalural@gmail.com', '1234', '1', '2021-11-17 11:38:11'),
(3, 'sdfsdf', 'sdfsdf', 2, '2', 'c81e728d9d4c2f636f067f89cc14862c', 'fd33f43095e159e553ada423749401a3', '2021-12-09 15:50:58'),
(5, '2', '2', 2, '2', 'c81e728d9d4c2f636f067f89cc14862c', '08e5e58a0ec0d2ee032d3da51b23ce06', '2021-12-09 16:00:28'),
(6, 'sdfsdf', 'sdfsdf', 0, 'dfgdfg', 'c81e728d9d4c2f636f067f89cc14862c', 'e7fa95d08d3ece9e61c02b6d9a55d4e1', '2021-12-09 16:00:55');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `randevu`
--

CREATE TABLE `randevu` (
  `id` int(20) NOT NULL,
  `hasta_id` int(20) NOT NULL,
  `doktor_id` int(20) NOT NULL,
  `randevu_tarih` date NOT NULL,
  `randevu_saat` time NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ücret`
--

CREATE TABLE `ücret` (
  `id` int(20) NOT NULL,
  `islem` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `tutar` int(10) NOT NULL,
  `aciklama` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `calisanlar`
--
ALTER TABLE `calisanlar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tel` (`tel`,`email`,`tc_number`);

--
-- Tablo için indeksler `doktorlar`
--
ALTER TABLE `doktorlar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tel` (`tel`,`email`,`tc_number`);

--
-- Tablo için indeksler `hasta_bilgileri`
--
ALTER TABLE `hasta_bilgileri`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tel` (`tel`,`email`,`tc_number`);

--
-- Tablo için indeksler `hasta_kayitlari`
--
ALTER TABLE `hasta_kayitlari`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanıcılar`
--
ALTER TABLE `kullanıcılar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `randevu`
--
ALTER TABLE `randevu`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ücret`
--
ALTER TABLE `ücret`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `calisanlar`
--
ALTER TABLE `calisanlar`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `doktorlar`
--
ALTER TABLE `doktorlar`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `hasta_bilgileri`
--
ALTER TABLE `hasta_bilgileri`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `hasta_kayitlari`
--
ALTER TABLE `hasta_kayitlari`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `kullanıcılar`
--
ALTER TABLE `kullanıcılar`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `randevu`
--
ALTER TABLE `randevu`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `ücret`
--
ALTER TABLE `ücret`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
