-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 10, 2016 at 05:43 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `PHPWebFramework`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `parentid` int(11) DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `timeposted` int(32) NOT NULL,
  `timeedited` int(32) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `currentnestedlevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `postid`, `parentid`, `userid`, `timeposted`, `timeedited`, `description`, `currentnestedlevel`) VALUES
(1, 3, 0, 5, 1478708503, 0, 'ZWxsb28=', 1),
(2, 3, 1, 5, 1478708505, 0, 'YXNzYWRzYQ==', 2),
(3, 3, 2, 5, 1478708507, 0, 'YWRzYXNk', 3),
(4, 3, 1, 5, 1478708511, 0, 'ZHNhYWRz', 2),
(5, 3, 4, 5, 1478708515, 0, 'YWRhc2Rh', 3),
(6, 3, 4, 5, 1478708521, 0, 'YXNkYWRzYXNk', 3),
(7, 3, 1, 5, 1478708525, 0, 'YXNkYXNk', 2),
(8, 3, 0, 5, 1478795072, 0, 'c2Rkc2Zkc2Zkc2Y=', 1),
(9, 3, 8, 5, 1478795075, 0, 'c2Rm', 2),
(10, 3, 9, 5, 1478795082, 0, 'c2RmZHNmZHMNCnNkDQoNCmRzZg0KDQoNCmRzZg0KZHMNCg0KDQo6RA==', 3);

-- --------------------------------------------------------

--
-- Table structure for table `facebook_users`
--

CREATE TABLE `facebook_users` (
  `id` int(11) NOT NULL,
  `auth_id` varchar(767) NOT NULL,
  `email_address` varchar(767) NOT NULL,
  `joined` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `forumcategories`
--

CREATE TABLE `forumcategories` (
  `id` int(11) NOT NULL,
  `sectionid` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `description` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `forumquestions`
--

CREATE TABLE `forumquestions` (
  `id` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `timeposted` int(32) NOT NULL,
  `timeedited` int(32) NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `forumsections`
--

CREATE TABLE `forumsections` (
  `id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `description` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forumsections`
--

INSERT INTO `forumsections` (`id`, `title`, `description`) VALUES
(1, 'General', 'This is for general requests/posts.'),
(2, 'Help', 'For all help requests and questions.');

-- --------------------------------------------------------

--
-- Table structure for table `google_users`
--

CREATE TABLE `google_users` (
  `id` int(11) NOT NULL,
  `auth_id` varchar(767) NOT NULL,
  `email_address` varchar(767) NOT NULL,
  `joined` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `email_address` varchar(767) NOT NULL,
  `salt` varchar(1024) NOT NULL,
  `joined` int(32) NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email_address`, `salt`, `joined`, `activated`) VALUES
(5, 'Frajaam', '$2y$10$Rwe0BJyCB3wL/e7IAZaFM.lkl3ggLitoOcPMYZliIOy4/U6YZ6tPC', 'contact@contact.com', '2b38ac1f5814ab5f3899cce8442302a775ca2cb27b7aee10d6c801b82bb3c23da323c5377ad87b3f08e69b5189901a552ae343d6eccf91e71fa96b47bba3b0cc696b3b60ce45a65185570f21b47772679c9998f189f8f1d068737da7e019953083a152a14e8387d47b5d5941991629d0cb640bdc34b25bdba1149c20b434ba2c', 1478708441, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_password_reset`
--

CREATE TABLE `users_password_reset` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `salt` varchar(1024) NOT NULL,
  `starttime` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users_sessions`
--

CREATE TABLE `users_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_sessions`
--

INSERT INTO `users_sessions` (`id`, `user_id`, `hash`) VALUES
(8, 5, 'b12170b8e21d4aed8a63ae163c809978743c7e4cb70c0cb74d33252fb1ffdd19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facebook_users`
--
ALTER TABLE `facebook_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `auth_id` (`auth_id`),
  ADD UNIQUE KEY `email_address` (`email_address`);

--
-- Indexes for table `forumcategories`
--
ALTER TABLE `forumcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forumquestions`
--
ALTER TABLE `forumquestions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forumsections`
--
ALTER TABLE `forumsections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `google_users`
--
ALTER TABLE `google_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `auth_id` (`auth_id`),
  ADD UNIQUE KEY `email_address` (`email_address`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_address` (`email_address`);

--
-- Indexes for table `users_password_reset`
--
ALTER TABLE `users_password_reset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_sessions`
--
ALTER TABLE `users_sessions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `facebook_users`
--
ALTER TABLE `facebook_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `forumcategories`
--
ALTER TABLE `forumcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `forumquestions`
--
ALTER TABLE `forumquestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `forumsections`
--
ALTER TABLE `forumsections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `google_users`
--
ALTER TABLE `google_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users_password_reset`
--
ALTER TABLE `users_password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_sessions`
--
ALTER TABLE `users_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
