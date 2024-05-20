-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Gegenereerd op: 20 mei 2024 om 16:03
-- Serverversie: 5.7.24
-- PHP-versie: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `littlesun`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `clock_times`
--

CREATE TABLE `clock_times` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `clock_in_time` datetime NOT NULL,
  `clock_out_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `clock_times`
--

INSERT INTO `clock_times` (`id`, `user_id`, `clock_in_time`, `clock_out_time`) VALUES
(21, 24, '2024-05-12 16:38:16', '2024-05-12 16:38:41'),
(22, 28, '2024-05-12 18:16:54', '2024-05-12 18:41:07'),
(23, 28, '2024-05-12 18:17:46', '2024-05-12 18:41:07'),
(24, 28, '2024-05-12 18:34:58', '2024-05-12 18:41:07'),
(25, 28, '2024-05-12 18:35:02', '2024-05-12 18:41:07'),
(26, 28, '2024-05-12 18:36:08', '2024-05-12 18:41:07'),
(27, 28, '2024-05-12 18:36:16', '2024-05-12 18:41:07'),
(28, 28, '2024-05-12 18:37:28', '2024-05-12 18:41:07'),
(29, 28, '2024-05-12 18:38:19', '2024-05-12 18:41:07'),
(30, 28, '2024-05-12 18:40:12', '2024-05-12 18:41:07'),
(31, 28, '2024-05-12 18:40:19', '2024-05-12 18:41:07'),
(32, 28, '2024-05-12 18:40:21', '2024-05-12 18:41:07'),
(33, 28, '2024-05-12 18:40:43', '2024-05-12 18:41:07'),
(34, 28, '2024-05-12 18:41:05', '2024-05-12 18:41:07'),
(35, 28, '2024-05-12 18:41:09', '2024-05-12 18:46:48'),
(36, 28, '2024-05-12 18:41:57', '2024-05-12 18:46:48'),
(37, 28, '2024-05-12 18:44:07', '2024-05-12 18:46:48'),
(38, 28, '2024-05-12 18:45:10', '2024-05-12 18:46:48'),
(39, 28, '2024-05-12 18:45:16', '2024-05-12 18:46:48'),
(40, 28, '2024-05-12 18:45:35', '2024-05-12 18:46:48'),
(41, 28, '2024-05-12 18:46:42', '2024-05-12 18:46:48'),
(42, 28, '2024-05-12 18:47:54', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `location_name` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `location`
--

INSERT INTO `location` (`id`, `location_name`) VALUES
(14, 'Amsterdam'),
(15, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `taskId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `permission`
--

INSERT INTO `permission` (`id`, `userId`, `taskId`) VALUES
(1, 21, 1),
(3, 21, 2),
(4, 21, 3),
(5, 24, 1),
(6, 25, 1),
(7, 25, 2),
(8, 25, 3),
(9, 25, 4);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sick`
--

CREATE TABLE `sick` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `sick`
--

INSERT INTO `sick` (`id`, `userId`, `start_date`, `end_date`) VALUES
(1, 28, '2024-05-18', '2024-05-19'),
(2, 29, '2024-05-19', '2024-05-30');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `type` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `task`
--

INSERT INTO `task` (`id`, `type`) VALUES
(1, 'Office Duty'),
(2, 'Cleaning'),
(3, 'dancing'),
(4, 'Yapping');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `time_off`
--

CREATE TABLE `time_off` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `reason` varchar(300) NOT NULL,
  `start_time` date NOT NULL,
  `end_time` date NOT NULL,
  `day_type` varchar(300) NOT NULL,
  `status` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `time_off`
--

INSERT INTO `time_off` (`id`, `userId`, `reason`, `start_time`, `end_time`, `day_type`, `status`) VALUES
(1, 27, 'birthdays', '2024-05-05', '2024-05-05', 'Half', 'Accepted'),
(2, 27, 'maternity', '2024-05-09', '2024-05-17', 'Half', 'Accepted'),
(3, 27, 'maternity', '2024-05-09', '2024-05-17', 'Half', 'Accepted'),
(4, 28, 'birthdays', '2024-05-05', '2024-05-11', 'Full', 'Declined'),
(5, 28, 'vacation', '2024-05-09', '2024-05-23', 'Half', NULL),
(6, 28, 'maternity', '2024-05-30', '2024-05-09', 'Half', NULL),
(7, 27, 'birthdays', '2024-05-08', '2024-05-31', 'More', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `type` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `name` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_picture` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT 'no_picture.png',
  `location_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `type`, `name`, `username`, `email`, `password`, `profile_picture`, `location_id`, `task_id`) VALUES
(5, 'Admin', 'Rayen Chebbai', 'Raybay', 'rayenchebbai@gmail.com', '$2y$12$Or1IVWUQJ79G/q3PyL.xOOd8hOcrIZE2B5MWfRwQXs.osyJ3HZdFS', 'no_picture.png', 14, NULL),
(18, 'Manager', 'Zayd Maadal', 'ZaydWolf', 'zaydmaadal@gmail.com', '$2y$12$Q34664dVAEtaNXrr7uVQWeqxDkxF4Nq3y2r15n3oMrYSIAcXxWFCu', '4kk0f3ld 1.png', 14, NULL),
(20, 'Manager', 'test', 'TestBro', 'test@gmail.com', '$2y$12$SaC0hgk3osl8pizTDcFQGuMXLmvqyAyhOKO87C.ebUnwUwVOGpKX6', 'ptpq6zs0 1.png', 14, NULL),
(21, 'User', 'Ben Tennyson', 'BenOmni', 'ben@gmail.com', '$2y$12$SaC0hgk3osl8pizTDcFQGuMXLmvqyAyhOKO87C.ebUnwUwVOGpKX6', 'v0idzxtl 1.png', 14, 1),
(22, 'Manager', 'Bechamel', 'BechamelSaus', 'becha@gmail.com', '$2y$12$dqBQXaIg86r/ANjE2v8Slu.Z1fbtxrHt2R/BC7ypRo7eJ5n3B8eBG', 'Simplification.png', 15, NULL),
(23, 'User', 'Gwen', 'GwenTennyson', 'gwen@gmail.com', '$2y$12$R0/qh5hMKWXaX0kgWFDXCuYHsvkI3NMUKJMNlgPV8eC7rttW1RpkC', 'vi6rpqq5 1.png', 15, 2),
(24, 'User', 'yup', 'yupidie', 'yup@gmail.com', '$2y$12$Yg4B4nC/G8qzcfV.OM5rf./E93/C.y54O1Q8bGia9bKP7BapHllQ6', 'Group 2.png', 14, 2),
(25, 'User', 'Oki Doki', 'Okidoki', 'oki@gmail.com', '$2y$12$5p87lLYlg0.EyyPjw6EHG.SElNbjLq0HGKIuQhZ6iJ7hQo/iiuVJ2', '66379825c362b_Group 7.png', 14, 1),
(27, 'Manager', 'Amine', 'zaydolas', 'amine@hotmail.com', '$2y$12$meMtoR4gcm/RhBR2sEkxEewxR059IyKGRNMF.Ogs/VeFYLBiNzi.6', '6638004cb934b_2186569.png', 14, NULL),
(28, 'User', 'zayd', 'zaydolas', 'zayd.maadal@hotmail.com', '$2y$12$meMtoR4gcm/RhBR2sEkxEewxR059IyKGRNMF.Ogs/VeFYLBiNzi.6', '6638004cb934b_2186569.png', 14, NULL),
(29, 'User', 'jan', 'jan', 'jan@gmail.com', '$2y$12$A9tn5Zfs21lfbf5BkzLa5usLISeWqT2SHIHzj8YM8fTi5HS0vK3Ny', NULL, NULL, NULL),
(30, 'User', 'peter', 'peter', 'peter@gmail.com', '$2y$12$U3xnfzITdcH0eTDSJTFoC.oB/BTj.T3HMMcDUksHcf2D1RUEPVjwS', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_task`
--

CREATE TABLE `user_task` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `taskId` int(11) NOT NULL,
  `date` varchar(300) NOT NULL,
  `start_time` varchar(300) NOT NULL,
  `end_time` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `user_task`
--

INSERT INTO `user_task` (`id`, `userId`, `taskId`, `date`, `start_time`, `end_time`) VALUES
(28, 21, 1, '2027-04-02', '03:02', '07:01'),
(29, 24, 1, '2024-06-06', '13:02', '18:01'),
(32, 28, 1, '2024-06-06', '13:02', '18:01'),
(33, 30, 2, '2024-04-02', '01:00', '02:30'),
(34, 30, 2, '2024-04-02', '01:00', '02:30');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `clock_times`
--
ALTER TABLE `clock_times`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexen voor tabel `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `sick`
--
ALTER TABLE `sick`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `time_off`
--
ALTER TABLE `time_off`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_location_id` (`location_id`),
  ADD KEY `fk_task_id` (`task_id`);

--
-- Indexen voor tabel `user_task`
--
ALTER TABLE `user_task`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `clock_times`
--
ALTER TABLE `clock_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT voor een tabel `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT voor een tabel `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `sick`
--
ALTER TABLE `sick`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `time_off`
--
ALTER TABLE `time_off`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT voor een tabel `user_task`
--
ALTER TABLE `user_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `clock_times`
--
ALTER TABLE `clock_times`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Beperkingen voor tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_location_id` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`),
  ADD CONSTRAINT `fk_task_id` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
