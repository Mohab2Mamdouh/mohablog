-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2022 at 02:46 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mohablog`
--

-- --------------------------------------------------------

--
-- Drop existing tables
--

DROP TABLE IF EXISTS `extensions`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `feed_backs`;
DROP TABLE IF EXISTS `migrations`;
DROP TABLE IF EXISTS `password_resets`;
DROP TABLE IF EXISTS `personal_access_tokens`;
DROP TABLE IF EXISTS `projects`;
DROP TABLE IF EXISTS `seeders`;
DROP TABLE IF EXISTS `site_details`;
DROP TABLE IF EXISTS `skills`;
DROP TABLE IF EXISTS `speaking_languages`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `work_exps`;

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feed_backs`
--

CREATE TABLE `feed_backs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stars` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(15, '2022_09_05_110948_drop_extensions_table', 1),
(34, '2014_10_12_000000_create_users_table', 2),
(35, '2014_10_12_100000_create_password_resets_table', 2),
(36, '2019_08_19_000000_create_failed_jobs_table', 2),
(37, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(38, '2022_06_14_092653_create_skills_table', 2),
(39, '2022_06_14_092851_create_speaking_languages_table', 2),
(40, '2022_06_14_093337_create_projects_table', 2),
(41, '2022_06_14_093634_create_work_exps_table', 2),
(42, '2022_06_14_093843_create_feed_backs_table', 2),
(43, '2022_06_17_114347_create_site_details_table', 2),
(44, '2022_06_17_194944_create_extensions_table', 2),
(45, '2022_08_04_124046_add_links_to_users_table', 2),
(46, '2022_09_04_114558_add_app_u_r_l_to_projects_table', 2),
(47, '2022_09_05_082650_add_type_to_skills_table', 2),
(48, '2022_09_05_112302_drop_percentage_from_skills', 2),
(49, '2022_09_30_180211_add_behance_to_users_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_',
  `caption` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `techmologyStack` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `endDate` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `appURL` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `url`, `caption`, `techmologyStack`, `endDate`, `created_at`, `updated_at`, `appURL`) VALUES
(1, 'Gym', 'http://shurlort.herokuapp.com/sq', 'It is a blog about gym, the admin could post offers and manage coashes.', 'PHP, Bootstrap, HTML, CSS, Jquery, AJAX', '2021-03-10', '2022-10-02 15:54:14', '2022-10-04 18:23:22', 'http://shurlort.herokuapp.com/sq'),
(2, 'Pharmacy', 'http://shurlort.herokuapp.com/sg', 'Created to make the admin able to manage Orders from the patient and keep tracking his medicines.', 'PHP, Bootstrap, HTML, CSS, Jquery, AJAX', '2021-06-24', '2022-10-02 15:55:03', '2022-10-02 15:55:03', 'http://shurlort.herokuapp.com/sg'),
(3, 'Amireta', 'http://shurlort.herokuapp.com/t0', 'It is a blog about women and it has it\'s Mobile application', 'Wordpress, PHP, Bootstrap, HTML, CSS', '2021-08-30', '2022-10-02 15:56:17', '2022-10-02 15:59:13', 'http://shurlort.herokuapp.com/t0'),
(4, 'Freezing', 'http://shurlort.herokuapp.com/s6', 'Admin Dashboard.  Allow to add requests to the admin and the admin assign it to the employers.', 'Laravel, Bootstrap, HTML, CSS', '2022-06-15', '2022-10-02 15:57:24', '2022-10-04 22:02:45', 'http://shurlort.herokuapp.com/s6'),
(5, 'ShURLort', 'http://shurlort.herokuapp.com/uy', 'Laravel Project to Short URL', 'Laravel, PHP, Tailwind css', '2022-09-03', '2022-10-02 15:58:18', '2022-10-02 16:00:37', 'http://shurlort.herokuapp.com/uo'),
(6, 'MohaBlog', 'http://mohablog.herokuapp.com/user/portfolio', 'Portfolio Site To present skills and projects and experience', 'Laravel, PHP, Bootstrap, HTML, CSS', '2022-09-08', '2022-10-02 15:59:02', '2022-10-02 15:59:02', 'http://mohablog.herokuapp.com/user/portfolio');

-- --------------------------------------------------------

--
-- Table structure for table `site_details`
--

CREATE TABLE `site_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `favicon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `colorCode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_details`
--

INSERT INTO `site_details` (`id`, `favicon`, `colorCode`, `created_at`, `updated_at`) VALUES
(1, 'favicon.png', '#F16269', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `languageName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `languageName`, `main`, `created_at`, `updated_at`, `type`) VALUES
(1, 'PHP', 'primary', '2022-10-02 15:45:04', '2022-10-04 18:23:10', 'Backend'),
(2, 'Laravel', 'primary', '2022-10-02 15:45:14', '2022-10-02 15:45:14', 'Backend'),
(3, 'WordPress', 'null', '2022-10-02 15:45:40', '2022-10-02 15:45:40', 'Little Knowledge'),
(4, 'MYSQL', 'null', '2022-10-02 15:46:07', '2022-10-02 15:46:07', 'Database'),
(5, 'JavaScript', 'null', '2022-10-02 15:46:23', '2022-10-02 15:46:23', 'Little Knowledge'),
(6, 'JQuery', 'null', '2022-10-02 15:46:37', '2022-10-02 15:46:37', 'Little Knowledge'),
(7, 'HTML', 'null', '2022-10-02 15:46:48', '2022-10-02 15:46:48', 'Fontend'),
(8, 'CSS', 'null', '2022-10-02 15:47:01', '2022-10-02 15:47:01', 'Fontend'),
(9, 'Bootstrap', 'null', '2022-10-02 15:47:12', '2022-10-02 15:47:12', 'Fontend'),
(10, 'Tailwindcss', 'null', '2022-10-02 15:47:28', '2022-10-02 15:47:28', 'Fontend'),
(11, 'Python', 'null', '2022-10-02 15:47:41', '2022-10-02 15:47:41', 'Prior Knowledge'),
(12, 'Java', 'null', '2022-10-02 15:47:49', '2022-10-02 15:47:49', 'Prior Knowledge'),
(13, 'OOP', 'null', '2022-10-02 15:47:58', '2022-10-02 15:47:58', 'Other Skills'),
(14, 'MVC', 'null', '2022-10-02 15:48:20', '2022-10-02 15:48:20', 'Other Skills'),
(15, 'Ajax', 'null', '2022-10-02 15:48:33', '2022-10-02 15:48:33', 'Other Skills'),
(16, 'JSON', 'null', '2022-10-02 15:48:46', '2022-10-02 15:48:46', 'Other Skills'),
(17, 'Git', 'null', '2022-10-02 15:48:57', '2022-10-02 15:48:57', 'Other Skills');

-- --------------------------------------------------------

--
-- Table structure for table `speaking_languages`
--

CREATE TABLE `speaking_languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `languageName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `speaking_languages`
--

INSERT INTO `speaking_languages` (`id`, `languageName`, `level`, `created_at`, `updated_at`) VALUES
(1, 'English', 'Level 3', '2022-10-04 18:24:01', '2022-10-04 18:24:23'),
(2, 'Arabic', 'Level 5', '2022-10-04 18:24:09', '2022-10-04 18:24:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `profileImage` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expYear` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currentPosition` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `github` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `linked_in` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `my_site` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `behance` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullName`, `username`, `title`, `email`, `email_verified_at`, `address`, `phone`, `profile`, `profileImage`, `password`, `expYear`, `currentPosition`, `remember_token`, `created_at`, `updated_at`, `github`, `linked_in`, `my_site`, `behance`) VALUES
(1, 'Mohab Mamdouh Abd El-Twab', 'mohablog', 'Backend Developer PHP / Laravel', 'mohabmamdouh22@gmail.com', NULL, 'El Slam, Cairo, Egypt', '01156047032', 'I\'m a backend developer of PHP/Laravel. Focused on expanding knowledge and abilities in website development, programming, and quality assurance. Seeking a position of increased responsibility with a growing team.', 'mohablog-1664732651.jpg', '$2y$10$v6Hs.fpyVBXkda2S5aAOg.FcvPtjRKBCwvWXKT2F3s2pKKg8uc2iu', '1', 'Backend Developer PHP/Laravel', 'mfOPvgCNZV1kYVBIXpwqbgvxPiYnrwyXmbKwxStIMt5nvrhytERFQOM3SxXu', NULL, '2022-10-25 22:43:14', 'https://github.com/MohabsMamdouh', 'https://linkedin.com/in/mohab-mamdouh-9307a57b/', 'https://mohablog.herokuapp.com/', 'https://www.behance.net/mohabmamdouh22');

-- --------------------------------------------------------

--
-- Table structure for table `work_exps`
--

CREATE TABLE `work_exps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `companyName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date DEFAULT NULL,
  `current` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caption` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `environment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_exps`
--

INSERT INTO `work_exps` (`id`, `companyName`, `startDate`, `endDate`, `current`, `caption`, `environment`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Icouna', '2020-09-26', '2020-11-26', NULL, 'Learned some technical skills like: (planning to start project - Designing Database)', 'PHP, Bootstrap, HTML, CSS, Javascript', 'Internee Backend Developer PHP', '2022-10-02 16:03:16', '2022-10-02 16:03:16'),
(2, 'Caian Technology', '2021-07-16', '2021-09-30', NULL, 'Work on AMIRETA.COM with WordPress and PHP', 'Wordpress, PHP, Bootstrap, HTML, CSS', 'Internee Backend Developer PHP', '2022-10-02 16:04:39', '2022-10-02 16:04:39'),
(3, 'Freelances Sites', '2022-04-01', NULL, 'present', 'Seeking for Opportunity to develop my skill into the next level', 'Laravel, PHP, Bootstrap, Basic Frontend', 'Backend Developer PHP / Laravel', '2022-10-02 16:05:59', '2022-10-25 22:44:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feed_backs`
--
ALTER TABLE `feed_backs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_details`
--
ALTER TABLE `site_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `speaking_languages`
--
ALTER TABLE `speaking_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `work_exps`
--
ALTER TABLE `work_exps`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feed_backs`
--
ALTER TABLE `feed_backs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `site_details`
--
ALTER TABLE `site_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `speaking_languages`
--
ALTER TABLE `speaking_languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `work_exps`
--
ALTER TABLE `work_exps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- --------------------------------------------------------

--
-- Table structure for table `seeders`
--

CREATE TABLE `seeders` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `seeder` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seeders`
--

INSERT INTO `seeders` (`id`, `seeder`) VALUES
(1, '1768602887_SiteDetails'),
(2, '1768602889_User');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
