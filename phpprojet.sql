-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2023 at 09:33 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpprojet`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `description`, `user_id`, `photo`) VALUES
(5, 'Tiger', 'wow , i saw a tiger in my last trip to Africa ', 3, 'C:\\xampp\\htdocs\\BlogPhp/uploads//posts/640c70136e2c9_6aofsvaglm_Medium_WW226365.jpg'),
(9, 'Volcano', 'Volcanoes are the central agents of change on Earth. They create and modify the land, add gases to the atmosphere, and drive global climate, but also have the capacity to destroy life.', 5, 'C:\\xampp\\htdocs\\BlogPhp/uploads//posts/641200b3bdcb7_6aofsvaglm_Medium_WW226365.jpg'),
(10, 'Volcano', 'helloo', 653750, 'C:\\xampp\\htdocs\\BlogPhp/uploads//posts/6412014a28a8d_download.jfif');

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`id`, `user_id`, `post_id`, `created_at`) VALUES
(9, 3, 5, '2023-03-11 13:12:09'),
(13, 461, 5, '2023-03-13 11:18:02'),
(19, 5, 9, '2023-03-15 12:42:07');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reason` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `post_id`, `user_id`, `reason`, `timestamp`) VALUES
(2, 5, 461, 'tigers are bad', '2023-03-14 09:18:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `photo`) VALUES
(3, 'Samer', 'samerchebil2@gmail.com', 'sasa', 'C:\\xampp\\htdocs\\BlogPhp/uploads/640b1cf3b0e51_6aofsvaglm_Medium_WW226365.jpg'),
(5, 'samerchebil18@gmail.com', 'SamerCh', '$2y$10$hJtF.B1p4LzbybN4zlUKDu9sJidxfIXVDm4tT7uDCbVSx/VUEXDim', 'C:\\xampp\\htdocs\\BlogPhp/uploads/64103d1638f41_290030045_2013320505544877_6275422029402556495_n.jpg'),
(27, 'samerchebil182@gmail.com', 'Samer2', '$2y$10$bgzNZEJ2PsifUVR617iPLuCP5eNCwp5tj48kpsUQO.2mCWsDq6ew2', 'C:\\xampp\\htdocs\\BlogPhp/uploads/641200d064943_download.jfif'),
(461, 'aurorapassenger@gmail.com', 'Aurora', '$2y$10$mmVPuPVGD8wHyP4Ik7VWn.oKvxJflNsAAFQ5gDfTJO/Y8.i8lKAJ2', 'C:\\xampp\\htdocs\\BlogPhp/uploads/640ef822aab3b_2c38924eb3e007f0c7736d861bcec961.jpg'),
(653750, 'user2@gmail.com', 'user2', '$2y$10$fAM1jBVWk2z/J/8qJYXYZOddFj2sLSHxZZd9wNANCFmAyRrHGAn0m', 'C:\\xampp\\htdocs\\BlogPhp/uploads/64120114918b2_290030045_2013320505544877_6275422029402556495_n.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`user_id`,`post_id`),
  ADD KEY `fk_post_likes_post_id` (`post_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_report` (`post_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=653752;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `fk_post_likes_post_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_post_likes_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
