-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017 年 8 月 14 日 10:56
-- サーバのバージョン： 5.6.34
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cost`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `holiday`
--

CREATE TABLE `holiday` (
  `date` date NOT NULL,
  `is_holiday` tinyint(1) DEFAULT '0',
  `name` varchar(256) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `holiday`
--

INSERT INTO `holiday` (`date`, `is_holiday`, `name`, `created_at`, `updated_at`) VALUES
('2017-08-01', 1, NULL, '2017-08-07 07:23:24', '2017-08-07 08:41:24'),
('2017-08-02', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-03', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-04', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-05', 1, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-06', 1, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-07', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-08', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-09', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-10', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-11', 1, '山の日', '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-12', 1, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-13', 1, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-14', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-15', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-16', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-17', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-18', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-19', 1, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-20', 1, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-21', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-22', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-23', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-24', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-25', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-26', 1, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-27', 1, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-28', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-29', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-30', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24'),
('2017-08-31', 0, NULL, '2017-08-07 07:23:24', '2017-08-07 07:23:24');

-- --------------------------------------------------------

--
-- テーブルの構造 `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `session`
--

CREATE TABLE `session` (
  `id` int(2) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `is_deleted` bit(1) NOT NULL DEFAULT b'0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `session`
--

INSERT INTO `session` (`id`, `name`, `is_deleted`, `updated_at`, `created_at`) VALUES
(1, 'IT事業部', b'0', '2017-08-10 05:44:26', '2017-07-04 15:00:00'),
(2, '事業部', b'0', '2017-08-10 05:44:31', '2017-07-04 15:00:00'),
(3, '葬祭事業本部', b'0', '2017-08-10 05:50:05', '2017-07-20 06:07:34'),
(4, '葬祭サービス部', b'0', '2017-08-10 05:44:06', '2017-07-20 06:07:59'),
(5, '人事部', b'1', '2017-08-14 01:07:33', '2017-07-20 06:08:52'),
(8, '削除', b'1', '2017-08-07 09:32:20', '2017-08-07 09:28:06');

-- --------------------------------------------------------

--
-- テーブルの構造 `task`
--

CREATE TABLE `task` (
  `id` int(3) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `is_off_task` tinyint(1) DEFAULT '0',
  `is_deleted` bit(1) NOT NULL DEFAULT b'0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `task`
--

INSERT INTO `task` (`id`, `name`, `is_off_task`, `is_deleted`, `updated_at`, `created_at`) VALUES
(1, 'MUSUBYSβ', 0, b'0', '2017-08-14 00:46:02', '2017-08-14 00:45:21'),
(2, 'MUSUBYS NOTES', 0, b'0', '2017-08-14 00:59:49', '2017-08-14 00:59:49'),
(3, 'お昼休憩', 1, b'0', '2017-08-14 01:18:07', '2017-08-14 01:02:08'),
(4, 'MUSUBYS Order', 0, b'0', '2017-08-14 01:04:03', '2017-08-14 01:04:03'),
(5, 'CROW-天国社', 0, b'0', '2017-08-14 01:06:01', '2017-08-14 01:04:32'),
(6, 'CROW-自社', 0, b'0', '2017-08-14 01:05:01', '2017-08-14 01:05:01'),
(7, 'コストコントロールシステム', 0, b'0', '2017-08-14 01:18:07', '2017-08-14 01:17:41');

-- --------------------------------------------------------

--
-- テーブルの構造 `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(256) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `session_id` int(2) DEFAULT '1',
  `session_is_manager` enum('Member','Manager') NOT NULL DEFAULT 'Member',
  `remember_token` varchar(100) DEFAULT NULL,
  `is_deleted` bit(1) NOT NULL DEFAULT b'0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `name`, `session_id`, `session_is_manager`, `remember_token`, `is_deleted`, `updated_at`, `created_at`) VALUES
(1, 'nguyen.nam@urban-funes.co.jp', '$2y$10$LEwhUGu89VuwZRms4AF2oOqZBp3iu/TcvEeszp2k8TsoCPBm3fIh2', 'グエン・ナム', 1, 'Manager', 'LJbVfwacldubvNkbpZbEWpUR4kaDLiAmcbQqbKf7c262imDkcSCSjlcaoezl', b'0', '2017-07-18 21:56:40', '2017-07-05 17:46:47'),
(2, 'oshima@urban-funes.co.jp', '$2y$10$ENlxRR2uxQV4YnieUf/6lu24WXfB1XYFRQWFHGsk2x5N0PPnbB5hm', '大嶋 沙莉', 1, 'Manager', 'g3OmF6yyr7M0w37kccSsJiRpjKckFhK1d3wWMaCEVnieeIn5DDDFSB9XIFz5', b'0', '2017-08-14 01:54:06', '2017-07-05 22:26:35'),
(3, 'akira.aizawa@urban-funes.co.jp', '$2y$10$VldJ.XR0nMkknXuSoJOcTu/95los110e1ynpiim8hIIuPz2eIbuk2', 'Akira Aizawa', 1, 'Manager', 'vWdCKE99QAhXPn0UlxXs4AmTHuoOMY3nidlSTvZQuAKgVHYp22i7v9FZIOLD', b'0', '2017-08-14 00:58:39', '2017-08-14 00:57:35'),
(4, 'ryota.miyatake@urban-funes.co.jp', '$2y$10$IvlLMjevUtVfi44yme4Npua08vyP4BQLAjsKB0OCOWwZNxunCtTVu', '宮武　良好', 1, 'Manager', NULL, b'0', '2017-08-14 01:54:23', '2017-08-14 01:15:41'),
(5, 'a-fukutomi@urban-funes.co.jp', '$2y$10$4PwZXfzWQOyPt2368TZfa.O9Rq.7BFhyTe3DnqyfngJFf9.DeokpG', '福冨 昭憲', 1, 'Manager', NULL, b'0', '2017-08-14 01:55:48', '2017-08-14 01:53:47');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `password` varchar(256) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `session_id` int(2) DEFAULT '1',
  `session_is_manager` enum('Member','Manager') NOT NULL DEFAULT 'Member',
  `remember_token` varchar(100) DEFAULT NULL,
  `is_deleted` bit(1) NOT NULL DEFAULT b'0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `user_task`
--

CREATE TABLE `user_task` (
  `user_id` int(10) NOT NULL,
  `task_id` int(3) NOT NULL,
  `task_priority` enum('Normal','Priority') DEFAULT 'Normal',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `user_task`
--

INSERT INTO `user_task` (`user_id`, `task_id`, `task_priority`, `updated_at`, `created_at`) VALUES
(1, 3, 'Normal', '2017-08-14 01:18:07', '2017-08-14 01:18:07'),
(1, 5, 'Normal', '2017-08-14 01:18:07', '2017-08-14 01:18:07'),
(1, 6, 'Normal', '2017-08-14 01:18:07', '2017-08-14 01:18:07'),
(1, 7, 'Normal', '2017-08-14 01:18:07', '2017-08-14 01:18:07'),
(2, 1, 'Normal', '2017-08-14 01:06:25', '2017-08-14 01:06:25'),
(2, 2, 'Normal', '2017-08-14 01:06:25', '2017-08-14 01:06:25'),
(2, 3, 'Normal', '2017-08-14 01:06:25', '2017-08-14 01:06:25'),
(2, 4, 'Normal', '2017-08-14 01:06:25', '2017-08-14 01:06:25'),
(2, 5, 'Normal', '2017-08-14 01:06:25', '2017-08-14 01:06:25'),
(2, 6, 'Normal', '2017-08-14 01:06:25', '2017-08-14 01:06:25'),
(3, 2, 'Normal', '2017-08-14 01:06:14', '2017-08-14 01:06:14'),
(3, 3, 'Normal', '2017-08-14 01:06:14', '2017-08-14 01:06:14');

-- --------------------------------------------------------

--
-- テーブルの構造 `working_date`
--

CREATE TABLE `working_date` (
  `date` date NOT NULL,
  `user_id` int(10) NOT NULL,
  `task_id` int(3) NOT NULL,
  `user_approved_id` int(10) DEFAULT NULL,
  `working_minutes` int(10) DEFAULT '0',
  `off_minutes` int(10) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `working_date`
--

INSERT INTO `working_date` (`date`, `user_id`, `task_id`, `user_approved_id`, `working_minutes`, `off_minutes`, `created_at`, `updated_at`) VALUES
('2017-08-14', 1, 3, NULL, 0, 0, '2017-08-14 01:18:31', '2017-08-14 01:18:31'),
('2017-08-14', 1, 5, NULL, 0, 0, '2017-08-14 01:18:31', '2017-08-14 01:18:31'),
('2017-08-14', 1, 6, NULL, 0, 0, '2017-08-14 01:18:31', '2017-08-14 01:18:31'),
('2017-08-14', 1, 7, NULL, 60, 0, '2017-08-14 01:18:31', '2017-08-14 01:18:31'),
('2017-08-14', 3, 2, NULL, 90, 0, '2017-08-14 01:50:50', '2017-08-14 01:50:50'),
('2017-08-14', 3, 3, NULL, 0, 0, '2017-08-14 01:50:50', '2017-08-14 01:50:50');

-- --------------------------------------------------------

--
-- テーブルの構造 `working_time`
--

CREATE TABLE `working_time` (
  `user_id` int(10) NOT NULL,
  `task_id` int(3) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `working_time`
--

INSERT INTO `working_time` (`user_id`, `task_id`, `date`, `time`, `updated_at`, `created_at`) VALUES
(1, 7, '2017-08-14', '09:00:00', '2017-08-14 01:18:31', '2017-08-14 01:18:31'),
(1, 7, '2017-08-14', '09:30:00', '2017-08-14 01:18:31', '2017-08-14 01:18:31'),
(3, 2, '2017-08-14', '09:30:00', '2017-08-14 01:50:50', '2017-08-14 01:50:50'),
(3, 2, '2017-08-14', '10:00:00', '2017-08-14 01:50:50', '2017-08-14 01:50:50'),
(3, 2, '2017-08-14', '10:30:00', '2017-08-14 01:50:50', '2017-08-14 01:50:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`date`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
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
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_task`
--
ALTER TABLE `user_task`
  ADD PRIMARY KEY (`user_id`,`task_id`);

--
-- Indexes for table `working_date`
--
ALTER TABLE `working_date`
  ADD PRIMARY KEY (`date`,`user_id`,`task_id`);

--
-- Indexes for table `working_time`
--
ALTER TABLE `working_time`
  ADD PRIMARY KEY (`user_id`,`task_id`,`date`,`time`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
