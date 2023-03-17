-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 13, 2023 at 02:24 PM
-- Server version: 8.0.32-0ubuntu0.22.04.2
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `folder_id` int DEFAULT '0',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `type` enum('dir','file') NOT NULL DEFAULT 'dir',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `folders`
--

INSERT INTO `folders` (`id`, `user_id`, `folder_id`, `name`, `type`, `created_at`) VALUES
(16, 1, 0, 'Test Folder 1', 'dir', '2023-03-13 07:37:46'),
(17, 1, 0, '16786930747536controls.png', 'file', '2023-03-13 07:37:54'),
(18, 1, 0, '16786930855806all.gif', 'file', '2023-03-13 07:38:05'),
(19, 1, 0, 'Test Folder 2', 'dir', '2023-03-13 07:38:17'),
(20, 1, 0, 'Test Folder 3', 'dir', '2023-03-13 07:39:03'),
(21, 1, 0, '16786931521776icon-32.png', 'file', '2023-03-13 07:39:12'),
(22, 1, 16, 'Test Folder 1 inside update', 'dir', '2023-03-13 07:39:30'),
(23, 1, 16, '16786931751947controls.png', 'file', '2023-03-13 07:39:35'),
(24, 1, 16, 'Test Folder 2 inside', 'dir', '2023-03-13 08:47:20'),
(25, 1, 16, '1678697252167216786915341855controls.png', 'file', '2023-03-13 08:47:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'aashish', 'bytes123', '2023-03-07 09:49:42'),
(2, 'kanu', 'bytes123', '2023-03-07 09:49:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
