-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2022 at 05:00 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `2FA_code` varchar(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `bgColor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `firstname`, `lastname`, `birthdate`, `password`, `email`, `2FA_code`, `created_at`, `bgColor`) VALUES
(1, 'admin', 'Richard', 'Sunga', '2012-01-03', 'password', 'richardandrei.sunga@tup.edu.ph', '031220', '2022-01-02 06:55:47', ''),
(2, 'admin1', '', '0', '0000-00-00', 'password', 'arishavelle18@yahoo.com', '017422', '2022-01-14 07:35:58', '');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_post_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `created_at`, `category_post_count`) VALUES
(1, 'Business', '2021-12-08 07:06:01', 3),
(2, 'Technology', '2021-12-08 07:06:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `discussion`
--

CREATE TABLE `discussion` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `react_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `upvote` int(11) NOT NULL,
  `downvote` int(11) NOT NULL,
  `subcomment_count` int(11) NOT NULL,
  `comment_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `discussion`
--

INSERT INTO `discussion` (`comment_id`, `post_id`, `user_id`, `react_id`, `content`, `upvote`, `downvote`, `subcomment_count`, `comment_created_at`) VALUES
(334, 137, 6, 724, 'asdasdsa', 0, 0, 0, '2022-02-10 15:54:50');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notif_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `type_of_notif` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `subcomment_id` int(11) DEFAULT NULL,
  `read_status` int(2) NOT NULL DEFAULT 0,
  `notif_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notif_id`, `action_id`, `type_of_notif`, `user_id`, `owner_id`, `post_id`, `comment_id`, `subcomment_id`, `read_status`, `notif_created_at`) VALUES
(451, 309, 'reply', 7, 6, NULL, NULL, 166, 1, '2022-02-08 12:26:33'),
(453, 311, 'reply', 7, 6, NULL, NULL, 167, 1, '2022-02-09 10:02:13');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `react_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `post_image` varchar(255) NOT NULL,
  `upvote` int(11) NOT NULL,
  `downvote` int(11) NOT NULL,
  `post_comment_count` int(11) NOT NULL,
  `reports_count` int(6) NOT NULL,
  `post_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `category_id`, `user_id`, `react_id`, `title`, `slug`, `body`, `post_image`, `upvote`, `downvote`, `post_comment_count`, `reports_count`, `post_created_at`) VALUES
(135, 2, 6, 698, 'dasdsadsada', 'dasdsadsada', '<p>asdsadasdas</p>\r\n', '', 0, 0, 0, 0, '2022-02-09 17:21:36'),
(137, 1, 6, 700, 'asdsadsadasda', 'asdsadsadasda', '<p><strong>asdsadas</strong></p>\r\n\r\n<p><strong>asdasdasdsad</strong></p>\r\n\r\n<p><strong>asdasdsad</strong></p>\r\n', '', 0, 1, 1, 1, '2022-02-09 17:21:51'),
(138, 1, 6, 701, 'asdasdasda', 'asdasdasda', '<p>asdasdasd</p>\r\n', 'assets/images/post/mycode.png', 0, 0, 0, 0, '2022-02-09 17:23:06'),
(139, 1, 7, 714, 'kentsadasd', 'kentsadasd', '<p>asdsadsaad</p>\r\n', '', 0, 0, 0, 0, '2022-02-10 07:43:33');

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `react_id` int(11) NOT NULL,
  `react_log` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reactions`
--

INSERT INTO `reactions` (`react_id`, `react_log`) VALUES
(672, '{\"up_react\":\"upvote\",\"up_user_id\":[\"7\"],\"down_react\":\"downvote\",\"down_user_id\":[]}'),
(673, '{\"up_react\":\"upvote\",\"up_user_id\":[],\"down_react\":\"downvote\",\"down_user_id\":[]}'),
(674, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(675, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(676, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(677, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(678, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(679, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(680, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(681, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(682, '{\"up_react\":\"upvote\",\"up_user_id\":[],\"down_react\":\"downvote\",\"down_user_id\":[]}'),
(683, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(684, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(685, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(686, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(687, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(688, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(689, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(690, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(691, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(692, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(693, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(694, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(695, '{\"up_react\":\"upvote\",\"up_user_id\":[],\"down_react\":\"downvote\",\"down_user_id\":[]}'),
(696, '{\"up_react\":\"upvote\",\"up_user_id\":[],\"down_react\":\"downvote\",\"down_user_id\":[\"6\"]}'),
(697, '{\"up_react\":\"upvote\",\"up_user_id\":[],\"down_react\":\"downvote\",\"down_user_id\":[]}'),
(698, '{\"up_react\":\"upvote\",\"up_user_id\":[],\"down_react\":\"downvote\",\"down_user_id\":[]}'),
(699, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(700, '{\"up_react\":\"upvote\",\"up_user_id\":[],\"down_react\":\"downvote\",\"down_user_id\":[\"6\"]}'),
(701, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(707, '{\"up_react\":\"upvote\",\"up_user_id\":[\"6\"],\"down_react\":\"downvote\",\"down_user_id\":[]}'),
(711, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(714, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(715, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(716, '{\r\n	\"up_react\":\"upvote\",\r\n	\"up_user_id\" :[],\r\n	\"down_react\":\"downvote\",\r\n	\"down_user_id\" :[] \r\n}'),
(724, '{\"up_react\":\"upvote\",\"up_user_id\":[],\"down_react\":\"downvote\",\"down_user_id\":[]}');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `subcomment_id` int(11) DEFAULT NULL,
  `complainant_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `post_id`, `comment_id`, `subcomment_id`, `complainant_id`, `reason`, `created_at`) VALUES
(48, 137, NULL, NULL, 7, 'asdsa', '2022-02-10 04:02:57');

-- --------------------------------------------------------

--
-- Table structure for table `subcomment`
--

CREATE TABLE `subcomment` (
  `subcomment_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `react_id` int(11) NOT NULL,
  `reply` text NOT NULL,
  `sub_upvote` int(11) NOT NULL,
  `sub_downvote` int(11) NOT NULL,
  `sub_create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `verified` tinyint(1) NOT NULL,
  `passcode` varchar(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_cover_photo` varchar(255) NOT NULL,
  `user_profile_photo` varchar(255) NOT NULL,
  `isLogin` int(11) NOT NULL DEFAULT 0,
  `bgColor` varchar(255) NOT NULL,
  `resumeDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `firstname`, `lastname`, `birthdate`, `email`, `password`, `code`, `verified`, `passcode`, `created_at`, `user_cover_photo`, `user_profile_photo`, `isLogin`, `bgColor`, `resumeDate`) VALUES
(6, 'arishavelle18', 'a', 'villaneuva', '2000-02-22', 'arishavellekarl.villanueva@tup.edu.ph', '$2y$10$sIQunrR/4D4z5nzuP1XAZek7oGAcAP7t9/Qt7auo/yriL2mhxmfhu', '221641', 1, '670457', '2021-12-17 14:24:03', 'assets/images/post/what-is-hashing.jpg', 'assets/images/post/terminal.png', 1, 'rgba(214.53369140625, 181.9472589967477, 181.9472589967477, 1)', '0000-00-00 00:00:00'),
(7, 'kentkent18', 'gegege', 'dasdadsaasdsadsad', '2000-02-22', 'varishavelle@gmail.com', '$2y$10$V1DkS7/H.5F47pIHtIinfeeQJJqoEm6l1VLvq7F30YSvrwIJy9SU2', '709127', 1, '042539', '2021-12-24 17:46:32', '', 'assets/images/post/a.jpg', 0, 'rgba(71.905517578125, 64.04573604531957, 64.04573604531957, 1)', '2022-02-04 15:18:55'),
(9, 'richard18', 'Richard', 'Suñga', '2000-02-22', 'khielle06@gmail.com', '$2y$10$nfzP8tVslIDmnieDhXQYduRVuq/fETM6C6gbc4LXEesQSzmzHQlUm', 'dce7996480fe', 1, '926505', '2021-12-26 08:47:21', '', '', 0, '', '2022-02-04 15:18:55'),
(10, 'asd', 'Mark', 'Real', '2002-03-13', 'richardandrei.sunga@tup.edu.ph', '$2y$10$t56t92NpHbPG3Vemt2i./uO10UixYNVniyx7Yf55pUm6UMY2DedaS', '720b8468e700', 1, '', '2022-01-01 05:34:54', 'assets/images/post/spenser-sembrat-BuP-FvjfAFk-unsplash.jpg', 'assets/images/post/indicator_circle_thickbox.gif', 0, '', '2022-02-04 15:18:55'),
(11, 'krz', 'Kyle', 'Ramon', '1993-01-29', 'rasunga30@gmail.com', '$2y$10$9Qi4LycDfZHDWsN/M4YWZupA/uQbCgYW/x1J1DXQ0v1ziL7rfFJse', '0a72a4c48fbc', 1, '', '2022-01-01 05:53:29', '', '', 1, '', '2022-02-04 15:18:55'),
(12, 'asd18', 'arishavell', 'asdasd', '2000-02-22', 'asddassda@gmail.com', '$2y$10$09SsXJQMDerjffRQn5h9uuzOzikCdapHOnLFQ4imijAXdGWqssiNS', 'dc973639905d', 1, '', '2022-02-04 07:23:33', '', '', 0, 'rgba(255, 255, 255, 1)', '2022-02-04 15:23:33'),
(14, 'karl123', 'arishavell', 'asdsad', '2000-02-22', 'arishavelle18@gmail.com', '$2y$10$LegRzES5sc9x8fn5Qx/mfOjoTmRmW6/Z48GQ5EM933KUHElCzFg5i', '308993', 1, '', '2022-02-09 17:58:39', '', '', 0, 'rgba(255, 255, 255, 1)', '2022-02-10 01:58:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `discussion`
--
ALTER TABLE `discussion`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `react_id` (`react_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notif_id`),
  ADD KEY `notification_ibfk_1` (`owner_id`),
  ADD KEY `notification_ibfk_2` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `react_id` (`react_id`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`react_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`complainant_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `subcomment_id` (`subcomment_id`);

--
-- Indexes for table `subcomment`
--
ALTER TABLE `subcomment`
  ADD PRIMARY KEY (`subcomment_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `react_id` (`react_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `discussion`
--
ALTER TABLE `discussion`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=335;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=458;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `react_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=725;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `subcomment`
--
ALTER TABLE `subcomment`
  MODIFY `subcomment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `discussion`
--
ALTER TABLE `discussion`
  ADD CONSTRAINT `discussion_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `discussion_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `discussion_ibfk_3` FOREIGN KEY (`react_id`) REFERENCES `reactions` (`react_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_3` FOREIGN KEY (`react_id`) REFERENCES `reactions` (`react_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`complainant_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`comment_id`) REFERENCES `discussion` (`comment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_ibfk_4` FOREIGN KEY (`subcomment_id`) REFERENCES `subcomment` (`subcomment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subcomment`
--
ALTER TABLE `subcomment`
  ADD CONSTRAINT `subcomment_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `discussion` (`comment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subcomment_ibfk_2` FOREIGN KEY (`react_id`) REFERENCES `reactions` (`react_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subcomment_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;