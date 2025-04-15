-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 16 Nis 2025, 00:40:00
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
(1, 'Biz Kimiz', 'İstanbul Ticaret Üniversitesi - Siber Güvenlik Topluluğu', 'İstanbul Ticaret Üniversitesi Siber Güvenlik Topluluğu, teknolojiye ve bilgi güvenliğine ilgi duyan öğrencilerin bir araya geldiği bir platformdur. Topluluk, siber güvenlik alanında farkındalık yaratmak, üyelerinin bilgi ve becerilerini geliştirmek ve kariyer hedeflerine katkı sağlamak amacıyla çeşitli etkinlikler ve eğitimler düzenlemektedir. Etik hacking, ağ güvenliği, yazılım güvenliği, tersine mühendislik ve siber tehdit analizi gibi konular topluluğun temel çalışma alanları arasında yer alır.\r\n\r\nTopluluğumuz, sektördeki profesyonellerle öğrenciler arasında bir köprü kurarak, alanında uzman isimlerin katıldığı seminerler, sertifikalı eğitimler ve uygulamalı atölyeler organize etmektedir. Bu etkinlikler, üyelerin teorik bilgilerini pratiğe dökmelerine olanak tanırken, aynı zamanda ekip çalışması ve problem çözme becerilerini de geliştirmektedir.\r\n\r\nAyrıca düzenlediğimiz yarışmalar ve projeler, üyelerimizin gerçek dünya problemlerine yönelik çözümler geliştirme yeteneğini artırmayı hedeflemektedir. İstanbul Ticaret Üniversitesi Siber Güvenlik Topluluğu, sadece bir öğrenci grubu değil, aynı zamanda güvenli bir dijital geleceği inşa etmek için bir araya gelen bireylerin oluşturduğu güçlü bir ağdır.\r\n\r\nTopluluğumuz, teknolojinin hızla değiştiği ve siber tehditlerin arttığı bu dönemde, bilinçli ve yetkin bireyler yetiştirerek, güvenlik sektöründe fark yaratmayı misyon edinmiştir. Amacımız, bilgi güvenliği konusundaki farkındalığı artırmak, üyelerimizi donanımlı bir şekilde mezun etmek ve siber güvenlik dünyasında kalıcı bir etki bırakmaktır.', '2025-03-17 08:45:57', '2025-04-15 20:53:40');

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
(1, 'https://google.com', 'https://ticaret.edu.tr/', '2025-03-22 22:08:06', '2025-04-15 20:54:05');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `hero_content`
--

CREATE TABLE `hero_content` (
  `id` int(11) NOT NULL,
  `top_title` varchar(255) NOT NULL COMMENT 'Üst başlık metni',
  `main_title` text NOT NULL COMMENT 'Ana başlık metni',
  `description` text NOT NULL COMMENT 'Açıklama metni',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `top_title_size` int(11) DEFAULT 14,
  `main_title_size` int(11) DEFAULT 36,
  `description_size` int(11) DEFAULT 16
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `hero_content`
--

INSERT INTO `hero_content` (`id`, `top_title`, `main_title`, `description`, `updated_at`, `top_title_size`, `main_title_size`, `description_size`) VALUES
(1, 'İ s t a n b u l   T i c a r e t   Ü n i v e r s i t e s i', 'IoT Zirvesi<br>ve Eğitimleri', 'Temel amacımız siber güvenlik alanında eğitimler, <br class=\"d-none d-md-inline\"> seminerler ve tanıtım içerikleri üreterek bu alana ilgisi olan kişileri <br class=\"d-none d-md-inline\"> geliştirmektir.', '2025-04-15 19:35:10', 14, 36, 16);

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
(10, 'İbrahim Gündüzgil', 'Siber Güvenlik & Adli Bilişim', 'https://www.linkedin.com/in/ibrahim-gündüzgil-007b01184/', 'uploads/1742765387_IbrahimGunduzgil.jpg', '2025-03-04 13:38:19'),
(11, 'Sabri Erdemir', 'Siber Güvenlik & Adli Bilişim', 'https://www.linkedin.com/in/sabri-erdemir-451405157/', 'uploads/1742765424_SabriErdemir.jpg', '2025-03-04 13:50:19'),
(20, 'Besim ALTINOK', 'Siber Güvenlik', 'https://tr.linkedin.com/in/besimaltinok', 'uploads/besim.jpg', '2025-04-15 16:43:34');

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
(3, 'uploads/adli-bilisim-inceleme-sureci.jpg', 'IoT Adli Bilişim: Cihazlardan Delil Toplama ve İnceleme Yöntemleri', 'Bu eğitimde, IoT cihazlarından dijital delil toplama, koruma ve analiz süreçleri detaylandırılacaktır. Katılımcılar, bir olay sonrasında IoT cihazlarından mantıklı ve hukuka uygun şekilde veri elde etme, bu verilerin zincirini koruma ve adli analiz raporu oluşturma adımlarını uygulamalı olarak gerçekleştireceklerdir. Eğitimin sonunda temel adli bilişim metodolojisi çerçevesinde olay yeri simülasyonu yapılacaktır.', '2025-05-15', '2025-03-17 08:19:32', 'IoT Adli Bilişim: Cihazlardan Delil Toplama ve İnceleme Yöntemleri'),
(6, 'uploads/1_egitim.png', 'IoT Cihazların Güvenlik Açıkları ve Gerçek Zamanlı Sızma Testi Eğitimi', 'Bu eğitimde, akıllı ev cihazları, giyilebilir teknolojiler ve endüstriyel IoT bileşenleri üzerinde yapılan yaygın güvenlik açıkları detaylandırılacaktır. Katılımcılar, temel IoT mimarisi üzerinden saldırı yüzeylerini analiz edecek ve pratik olarak zafiyet tarama araçlarını kullanarak gerçek zamanlı sızma testleri gerçekleştireceklerdir. Eğitim boyunca hem teorik hem uygulamalı bölümlerle katılımcıların aktif şekilde sürece dahil olması sağlanacaktır.', '2025-05-15', '2025-04-15 16:46:51', 'Akıllı Cihazların Anatomisi: IoT Sistemlerinin Güvenlik Analizi'),
(7, 'uploads/4_egitim.png', 'IoT Olay Müdahale Senaryoları ve Kriz Anı Yönetimi', 'Bu eğitim kapsamında bir IoT güvenlik ihlali senaryosu üzerinden olay müdahale adımları canlandırılacaktır. Katılımcılar, bir IoT ağında gerçekleşen saldırıya karşı log analizi, olay günlüğü değerlendirmesi ve hızlı yanıt stratejilerini uygulamalı şekilde gerçekleştireceklerdir. Bu eğitimde ayrıca kriz anı iletişimi ve paydaşlarla koordinasyon süreçleri de ele alınacaktır.', '2025-05-15', '2025-04-15 16:47:45', 'IoT Olay Müdahale Senaryoları ve Kriz Anı Yönetimi'),
(8, 'uploads/3_egitim.png', 'Zararlı Yazılımlar ve IoT Üzerinde Ağ Tabanlı Tehdit Avı Eğitimi', 'Bu eğitimde IoT ekosisteminde karşılaşılan kötü amaçlı yazılımların davranışları, bulaşma yöntemleri ve ağ üzerinde bıraktıkları dijital izler analiz edilecektir. Katılımcılar, IoT cihazları üzerinden gelen ağ trafiğini analiz ederek şüpheli aktiviteleri tespit etmeye yönelik \"threat hunting\" tekniklerini uygulamalı olarak gerçekleştireceklerdir. Bu eğitimde açık kaynaklı analiz araçlarının kullanımı da gösterilecektir.', '2025-05-15', '2025-04-15 16:48:25', 'Zararlı Yazılımlar ve IoT Üzerinde Ağ Tabanlı Tehdit Avı Eğitimi');

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
-- Tablo için indeksler `hero_content`
--
ALTER TABLE `hero_content`
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
-- Tablo için AUTO_INCREMENT değeri `hero_content`
--
ALTER TABLE `hero_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `instructors`
--
ALTER TABLE `instructors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Tablo için AUTO_INCREMENT değeri `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
