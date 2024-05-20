-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2024 at 02:36 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

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
-- Table structure for table `clock_times`
--

CREATE TABLE `clock_times` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `clock_in_time` datetime NOT NULL,
  `clock_out_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clock_times`
--

INSERT INTO `clock_times` (`id`, `user_id`, `clock_in_time`, `clock_out_time`) VALUES
(4, 24, '2024-05-12 20:36:58', '2024-05-12 20:37:08');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `location_name` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `location_name`) VALUES
(14, 'Amsterdam'),
(15, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `taskId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sick`
--

CREATE TABLE `sick` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sick`
--

INSERT INTO `sick` (`id`, `userId`, `start_date`, `end_date`) VALUES
(1, 24, '2024-05-20', '2024-05-23'),
(2, 28, '2024-05-24', '2024-05-28');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `type` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `type`) VALUES
(1, 'office duty'),
(2, 'cleaning');

-- --------------------------------------------------------

--
-- Table structure for table `time_off`
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

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `type` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `name` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_picture` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no_picture.png',
  `location_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `type`, `name`, `username`, `email`, `password`, `profile_picture`, `location_id`, `task_id`) VALUES
(5, 'Admin', 'Admin Sun', 'AdminLilSun', 'admin.sun@gmail.com', '$2y$12$Or1IVWUQJ79G/q3PyL.xOOd8hOcrIZE2B5MWfRwQXs.osyJ3HZdFS', 'no_picture.png', 14, NULL),
(18, 'Manager', 'Zayd Maadal', 'ZaydWolf', 'zaydmaadal@gmail.com', '$2y$12$Q34664dVAEtaNXrr7uVQWeqxDkxF4Nq3y2r15n3oMrYSIAcXxWFCu', '4kk0f3ld 1.png', 14, NULL),
(20, 'Manager', 'test', 'Test', 'test@gmail.com', '$2y$12$SaC0hgk3osl8pizTDcFQGuMXLmvqyAyhOKO87C.ebUnwUwVOGpKX6', 'ptpq6zs0 1.png', 14, NULL),
(21, 'User', 'Ben Tennyson', 'BenOmni', 'ben@gmail.com', '$2y$12$6c.COHpfqTGOfXbBmEQx7OioaVu0S.If2HTUrGtWarHT25dD9wTAe', 'v0idzxtl 1.png', 14, 1),
(22, 'Manager', 'Bechamel', 'BechamelSaus', 'becha@gmail.com', '$2y$12$dqBQXaIg86r/ANjE2v8Slu.Z1fbtxrHt2R/BC7ypRo7eJ5n3B8eBG', 'Simplification.png', 15, NULL),
(23, 'User', 'Gwen', 'GwenTennyson', 'gwen@gmail.com', '$2y$12$R0/qh5hMKWXaX0kgWFDXCuYHsvkI3NMUKJMNlgPV8eC7rttW1RpkC', 'vi6rpqq5 1.png', 15, 2),
(24, 'User', 'yup', 'yupidie', 'yup@gmail.com', '$2y$12$Yg4B4nC/G8qzcfV.OM5rf./E93/C.y54O1Q8bGia9bKP7BapHllQ6', 'Group 2.png', 14, 2),
(25, 'User', 'Oki Doki', 'Okidoki', 'oki@gmail.com', '$2y$12$5p87lLYlg0.EyyPjw6EHG.SElNbjLq0HGKIuQhZ6iJ7hQo/iiuVJ2', '66379825c362b_Group 7.png', 14, 1),
(28, 'User', 'Jan', 'Jannetje', 'jan@gmail.com', '$2y$12$r3PahZ88zuWjgIXAwYfzXusTUlMRO9y2hUmOBswE3Zjda2s1fGjey', '6637a4e90eb33_Group 10.png', 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_task`
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
-- Dumping data for table `user_task`
--

INSERT INTO `user_task` (`id`, `userId`, `taskId`, `date`, `start_time`, `end_time`) VALUES
(28, 5, 1, '2027-04-02', '03:02', '07:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clock_times`
--
ALTER TABLE `clock_times`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sick`
--
ALTER TABLE `sick`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_location_id` (`location_id`),
  ADD KEY `fk_task_id` (`task_id`);

--
-- Indexes for table `user_task`
--
ALTER TABLE `user_task`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clock_times`
--
ALTER TABLE `clock_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sick`
--
ALTER TABLE `sick`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user_task`
--
ALTER TABLE `user_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clock_times`
--
ALTER TABLE `clock_times`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_location_id` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`),
  ADD CONSTRAINT `fk_task_id` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
