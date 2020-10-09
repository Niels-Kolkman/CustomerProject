-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 08, 2020 at 09:44 AM
-- Server version: 10.3.22-MariaDB-cll-lve
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u71481p69034_custpro`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `created`) VALUES
(1, 'Mooi', '2020-09-22 09:10:51'),
(2, 'Reee', '2020-09-25 07:45:21'),
(4, 'Test', '2020-09-25 07:47:51'),
(5, 'VcIT2a4', '2020-09-25 11:45:12'),
(6, 'Buurhub gang', '2020-10-07 07:51:44');

-- --------------------------------------------------------

--
-- Table structure for table `groups_has_users`
--

CREATE TABLE `groups_has_users` (
  `id` int(11) NOT NULL,
  `groups_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `groups_has_users`
--

INSERT INTO `groups_has_users` (`id`, `groups_id`, `users_id`) VALUES
(36, 2, 7),
(37, 4, 3),
(38, 4, 7),
(39, 2, 1),
(40, 2, 7),
(41, 5, 1),
(42, 5, 3),
(43, 5, 5),
(44, 5, 7),
(45, 5, 9),
(50, 3, 9),
(51, 3, 1),
(52, 3, 3),
(53, 6, 1),
(54, 6, 3),
(55, 6, 5),
(56, 6, 7),
(57, 6, 9);

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `name`, `subject`, `date`, `start_time`, `end_time`, `created`) VALUES
(32, 'Test Test', 'Test', '2020-10-06', '10:41:58', '16:37:01', '2020-10-06 08:37:09'),
(37, 'Test123', 'Nederlands', '2020-10-15', '05:08:08', '22:07:11', '2020-10-06 12:07:15'),
(38, 'Buurhub Quiz', 'Basiskennis', '2020-10-07', '08:00:56', '15:08:11', '2020-10-07 08:01:03');

-- --------------------------------------------------------

--
-- Table structure for table `test_has_group`
--

CREATE TABLE `test_has_group` (
  `id` int(11) NOT NULL,
  `tests_id` int(11) NOT NULL,
  `groups_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `test_has_user`
--

CREATE TABLE `test_has_user` (
  `id` int(11) NOT NULL,
  `tests_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test_has_user`
--

INSERT INTO `test_has_user` (`id`, `tests_id`, `users_id`) VALUES
(21, 32, 3),
(22, 32, 5),
(23, 34, 3),
(24, 34, 7),
(25, 36, 3),
(26, 37, 7),
(27, 37, 7),
(28, 37, 7),
(29, 37, 7),
(30, 37, 7),
(31, 37, 7),
(32, 37, 1),
(33, 32, 3),
(34, 32, 5),
(35, 32, 7),
(36, 32, 9),
(37, 38, 1),
(38, 38, 3),
(39, 38, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `role` enum('docent','student') NOT NULL DEFAULT 'student',
  `class` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `password`, `mail`, `role`, `class`, `created`) VALUES
(1, 'Niels', 'Kolkman', '$2y$10$kYRbZUNNcCG0HTKAqAW7guJWOIHBT3etgPyJlNT6zDOaHp.y6vDH.', 'niels.kolkman6@gmail.com', 'docent', 'Ochten', '2020-09-22 07:33:02'),
(2, 'Henk', 'Hermans', '$2y$10$A0DxDyInonV.8m0ah1z/v.BLQrpnYBgQ5Q0ERhmyCZXR04YJL9jxm', 'henk@mail.com', 'docent', 'Ochten', '2020-09-22 08:03:11'),
(3, 'test', 'test', '$2y$10$J.0YmnY0xTLhe4zVKWwyUumR//2fQRpVKiSMrLqgQgpUGO4L8ciM.', 'test@test.com', 'student', NULL, '2020-09-22 08:07:20'),
(4, 'docent', 'docent', '$2y$10$3Rab.Ye6I1J4JYuevhYO1O2ETVxvACcbdS2EXuf3mJ3ZwZ2RSeyUq', 'docent@mail.com', 'docent', NULL, '2020-09-22 09:32:27'),
(5, 'student', 'student', '$2y$10$YbZ2OAMN8ysQoNvYnrgQbey/CE5FCAK3dYrhN3f30bBB42fr2XXT6', 'student@mail.com', 'student', NULL, '2020-09-22 09:32:48'),
(7, 'Niet', 'Niels', '$2y$10$0UwONRGhp.3C1gGgmPeOJ.nf49Yh2RX2GXLFCu95RUIzPQuVpBzf2', 'niels@mail.com', 'student', '3D', '2020-09-25 07:42:11'),
(8, 'Stephan', 'Huts', '$2y$10$6pJXZ18PLMbaob8ez/zBuuA/7Qt72MnaWb38GjCGVRYyNpWgariUS', 'stephanhuts@gmail.com', 'docent', 'HUTS', '2020-09-25 11:28:06'),
(9, 'Sjaak', 'Trekhaak', '$2y$10$d.a/OmGaTOiTZ5To/CqHzeHHR4kcbpfgG8st/D8tu.uTYeR8vTl1q', 'Sjaak@mail.com', 'student', '16a', '2020-09-25 11:39:56'),
(11, 'Jeroen', 'de Nijs', '$2y$10$H17LhqBXoN/Ng7ACjuvQS.vXkvtiFEhNR9vDdR1Ebz1xJdgxEbR6G', 'jeroen@mail.com', 'docent', 'TEC VCIT3G4', '2020-10-01 09:17:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups_has_users`
--
ALTER TABLE `groups_has_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`users_id`),
  ADD KEY `groups_id` (`groups_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `test_has_group`
--
ALTER TABLE `test_has_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tests_id` (`tests_id`),
  ADD KEY `groups` (`groups_id`);

--
-- Indexes for table `test_has_user`
--
ALTER TABLE `test_has_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tests` (`tests_id`),
  ADD KEY `users` (`users_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `groups_has_users`
--
ALTER TABLE `groups_has_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `test_has_group`
--
ALTER TABLE `test_has_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `test_has_user`
--
ALTER TABLE `test_has_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
