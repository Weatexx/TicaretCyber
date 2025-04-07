-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 07 Nis 2025, 12:56:02
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `ticaretcyber`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `about_us`
--

CREATE TABLE `about_us` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `about_us`
--

INSERT INTO `about_us` (`id`, `title`, `subtitle`, `content`, `created_at`, `updated_at`) VALUES
(1, 'Biz Kimiz', 'İstanbul Ticaret Üniversitesi - Siber Güvenlik Topluluğu', 'İstanbul Ticaret Üniversitesi Siber Güvenlik Topluluğu, teknolojiye ve bilgi güvenliğine ilgi duyan öğrencilerin bir araya geldiği bir platformdur. Topluluk, siber güvenlik alanında farkındalık yaratmak, üyelerinin bilgi ve becerilerini geliştirmek ve kariyer hedeflerine katkı sağlamak amacıyla çeşitli etkinlikler ve eğitimler düzenlemektedir. Etik hacking, ağ güvenliği, yazılım güvenliği, tersine mühendislik ve siber tehdit analizi gibi konular topluluğun temel çalışma alanları arasında yer alır.\r\n\r\nTopluluğumuz, sektördeki profesyonellerle öğrenciler arasında bir köprü kurarak, alanında uzman isimlerin katıldığı seminerler, sertifikalı eğitimler ve uygulamalı atölyeler organize etmektedir. Bu etkinlikler, üyelerin teorik bilgilerini pratiğe dökmelerine olanak tanırken, aynı zamanda ekip çalışması ve problem çözme becerilerini de geliştirmektedir.\r\n\r\nAyrıca düzenlediğimiz yarışmalar ve projeler, üyelerimizin gerçek dünya problemlerine yönelik çözümler geliştirme yeteneğini artırmayı hedeflemektedir. İstanbul Ticaret Üniversitesi Siber Güvenlik Topluluğu, sadece bir öğrenci grubu değil, aynı zamanda güvenli bir dijital geleceği inşa etmek için bir araya gelen bireylerin oluşturduğu güçlü bir ağdır.\r\n\r\nTopluluğumuz, teknolojinin hızla değiştiği ve siber tehditlerin arttığı bu dönemde, bilinçli ve yetkin bireyler yetiştirerek, güvenlik sektöründe fark yaratmayı misyon edinmiştir. Amacımız, bilgi güvenliği konusundaki farkındalığı artırmak, üyelerimizi donanımlı bir şekilde mezun etmek ve siber güvenlik dünyasında kalıcı bir etki bırakmaktır.', '2025-03-17 08:45:57', '2025-04-06 18:31:11');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(7, 'icusgt2025', 'ticaretcyber', 'ardakoraykartal@gmail.com', '2025-04-07 10:55:15');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `apply`
--

CREATE TABLE `apply` (
  `id` int(11) NOT NULL,
  `button_url` varchar(255) NOT NULL DEFAULT '#',
  `contact_url` varchar(255) NOT NULL DEFAULT '#',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `apply`
--

INSERT INTO `apply` (`id`, `button_url`, `contact_url`, `created_at`, `updated_at`) VALUES
(1, 'https://x.com', 'https://www.youtube.com', '2025-03-22 22:08:06', '2025-04-06 17:19:06');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `instructors`
--

CREATE TABLE `instructors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `expertise` varchar(100) NOT NULL,
  `profile_url` varchar(255) DEFAULT '#',
  `photo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `instructors`
--

INSERT INTO `instructors` (`id`, `name`, `expertise`, `profile_url`, `photo`, `created_at`) VALUES
(10, 'İbrahim Gündüzgil', 'Siber Güvenlik', 'https://www.linkedin.com/in/ibrahim-gündüzgil-007b01184/', 'uploads/1742765387_IbrahimGunduzgil.jpg', '2025-03-04 13:38:19'),
(11, 'Sabri Erdemir', 'Adli Bilişim', 'https://www.linkedin.com/in/sabri-erdemir-451405157/', 'uploads/1742765424_SabriErdemir.jpg', '2025-03-04 13:50:19');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `trainings`
--

CREATE TABLE `trainings` (
  `id` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `header` varchar(650) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `trainings`
--

INSERT INTO `trainings` (`id`, `photo`, `title`, `description`, `date`, `created_at`, `header`) VALUES
(2, 'uploads/cyber-security1.jpg', 'Siber Güvenlik Eğitimi', 'Siber tehditlere karşı korunmayı öğrenin, güvenliği en üst düzeye çıkarın!', '2025-03-17', '2025-03-17 07:49:50', 'Siber Güvenlik Eğitimi'),
(3, 'uploads/adli-bilisim-inceleme-sureci.jpg', 'Adli Bilişim Eğitimi', 'Dijital delilleri analiz edin, siber suçları aydınlatın ve adli bilişim tekniklerini ustalıkla öğrenin!', '2025-03-17', '2025-03-17 08:19:32', 'Adli bilişim Eğitimi');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Tablo için indeksler `apply`
--
ALTER TABLE `apply`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `about_us`
--
ALTER TABLE `about_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `apply`
--
ALTER TABLE `apply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `instructors`
--
ALTER TABLE `instructors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tablo için AUTO_INCREMENT değeri `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
