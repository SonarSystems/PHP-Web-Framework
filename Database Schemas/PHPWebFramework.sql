-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 11, 2016 at 07:42 PM
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
-- Table structure for table `commentlikes`
--

CREATE TABLE `commentlikes` (
  `id` int(11) NOT NULL,
  `commentid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `timestamp` int(32) NOT NULL,
  `type` varchar(8) DEFAULT 'like'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `commentlikes`
--

INSERT INTO `commentlikes` (`id`, `commentid`, `userid`, `timestamp`, `type`) VALUES
(24, 2, 6, 1480525757, 'like'),
(35, 2, 5, 1480526101, 'dislike'),
(37, 1, 5, 1480528118, 'dislike');

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
(10, 3, 9, 5, 1478795082, 0, 'c2RmZHNmZHMNCnNkDQoNCmRzZg0KDQoNCmRzZg0KZHMNCg0KDQo6RA==', 3),
(11, 3, 0, 5, 1478798914, 0, 'QXJ1dG9zaA==', 1),
(12, 3, 11, 5, 1478798926, 0, 'SGUgaXMgc21hbGw=', 2),
(13, 3, 11, 5, 1478798936, 0, 'aGVsbG8=', 2),
(14, 3, 12, 5, 1478798948, 0, 'bGllcyBsaWVzIGxpZXM=', 3),
(15, 3, 1, 5, 1480005568, 0, 'aGVsbG8gd29ybGQ=', 2),
(16, 3, 0, 5, 1480528123, 0, 'ZGZzZnNmc2RmZHNmIGhlbGxv', 1);

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
  `categoryid` varchar(32) NOT NULL,
  `sectionid` varchar(32) NOT NULL,
  `title` varchar(32) NOT NULL,
  `description` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forumcategories`
--

INSERT INTO `forumcategories` (`id`, `categoryid`, `sectionid`, `title`, `description`) VALUES
(1, 'generaldiscussion', 'general', 'General Discussion', 'For everything that isn''t a help request.'),
(2, 'askforfeatures', 'general', 'Ask For Features', 'If there is a feature that you desire then come on in and ask.'),
(3, 'bugs', 'general', 'Bugs', 'Found any problems whilst using Sonar Learning, then let us know.'),
(4, 'showcase', 'general', 'Showcase', 'Want to showcase something epic, this is the right place.'),
(5, 'competitions', 'general', 'Competitions/Giveaways', 'Stay tuned for new competitions and giveaways.'),
(6, 'generalhelp', 'help', 'General', 'If you have any general help requests but there isn''t a specific section then ask it here.'),
(7, 'programming', 'help', 'Programming', 'Help with programming/coding.'),
(8, 'science', 'help', 'Science', 'Help with science.'),
(9, 'computerscience', 'help', 'Computer Science', 'Help with computer science.'),
(10, 'maths', 'help', 'Maths', 'Help with mathematics.'),
(11, 'history', 'help', 'History', 'Help with history.');

-- --------------------------------------------------------

--
-- Table structure for table `forumcommentlikes`
--

CREATE TABLE `forumcommentlikes` (
  `id` int(11) NOT NULL,
  `commentid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `timestamp` int(32) NOT NULL,
  `type` varchar(8) DEFAULT 'like'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forumcommentlikes`
--

INSERT INTO `forumcommentlikes` (`id`, `commentid`, `userid`, `timestamp`, `type`) VALUES
(38, 1, 5, 1480526545, 'like'),
(43, 10, 5, 1480529141, 'like'),
(47, 12, 5, 1480529161, 'like'),
(48, 6, 5, 1480529190, 'dislike'),
(50, 2, 5, 1481479193, 'dislike');

-- --------------------------------------------------------

--
-- Table structure for table `forumcomments`
--

CREATE TABLE `forumcomments` (
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
-- Dumping data for table `forumcomments`
--

INSERT INTO `forumcomments` (`id`, `postid`, `parentid`, `userid`, `timeposted`, `timeedited`, `description`, `currentnestedlevel`) VALUES
(1, 10, 0, 5, 1479404614, 0, 'VGhpcyBpcyBhbiBhd2Vzb21lIHF1ZXN0aW9ucw==', 1),
(2, 10, 1, 5, 1479404654, 0, 'ZHNmc2RmZHNm', 2),
(3, 10, 2, 5, 1479404656, 0, 'ZGZzZHNmZHNm', 3),
(4, 10, 1, 5, 1479404659, 0, 'c2Rmc2Rmc2Rm', 2),
(5, 10, 0, 5, 1479404667, 0, 'ZHNmZHNmZHNmIHNkZiBkc2YgZA0KDQoNCnNkZg0KDQpkc2Y=', 1),
(6, 11, 0, 5, 1479405298, 0, 'ZHM=', 1),
(7, 12, 0, 5, 1480005000, 0, 'ZXdycnc=', 1),
(8, 12, 7, 5, 1480005002, 0, 'd2Vy', 2),
(9, 12, 0, 5, 1480005004, 0, 'cndld2VyZXc=', 1),
(10, 11, 0, 5, 1480529139, 0, 'ZHNmc2Rm', 1),
(11, 11, 6, 5, 1480529156, 0, 'c2RmZHNm', 2),
(12, 11, 11, 5, 1480529158, 0, 'c2Rmc2Rm', 3);

-- --------------------------------------------------------

--
-- Table structure for table `forumfavourites`
--

CREATE TABLE `forumfavourites` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `questionid` int(11) NOT NULL,
  `timestamp` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forumfavourites`
--

INSERT INTO `forumfavourites` (`id`, `userid`, `questionid`, `timestamp`) VALUES
(4, 5, 8, 1481480039),
(5, 5, 13, 1481480605),
(6, 5, 14, 1481480726);

-- --------------------------------------------------------

--
-- Table structure for table `forumquestionlikes`
--

CREATE TABLE `forumquestionlikes` (
  `id` int(11) NOT NULL,
  `questionid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `timestamp` int(32) NOT NULL,
  `type` varchar(8) DEFAULT 'like'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forumquestionlikes`
--

INSERT INTO `forumquestionlikes` (`id`, `questionid`, `userid`, `timestamp`, `type`) VALUES
(41, 10, 5, 1480527886, 'like'),
(45, 11, 5, 1480529149, 'dislike');

-- --------------------------------------------------------

--
-- Table structure for table `forumquestions`
--

CREATE TABLE `forumquestions` (
  `id` int(11) NOT NULL,
  `categoryid` varchar(32) NOT NULL,
  `userid` int(11) NOT NULL,
  `timeposted` int(32) NOT NULL,
  `timeedited` int(32) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forumquestions`
--

INSERT INTO `forumquestions` (`id`, `categoryid`, `userid`, `timeposted`, `timeedited`, `title`, `description`) VALUES
(1, 'generaldiscussion', 5, 1479305454, 0, 'SGVsbG8gV29ybGQ=', 'Rmlyc3QgUG9zdA=='),
(3, 'generaldiscussion', 5, 1479305749, 0, 'c2Rmc2Rmc2RmIC4gIGZz', 'ZGZzZCAuICAgICAgICAgICAgICAgICAgICAgZHNmc2RmZHNmc2Rmc2Rmc2Rmc2QNCg0KDQpzZGYNCg0KDQpzZGZkc2ZkZnNkZnMNCg0KZHNmZHNm'),
(4, 'generaldiscussion', 5, 1479305816, 0, 'ZHNmc2RmZHNmZHM=', 'ZmRzZmRzZnNkZnNkZnNkZmRz'),
(5, 'generaldiscussion', 5, 1479306284, 0, 'c2Rmc2RmZHNmc2Q=', 'ZmRzZnNmc2ZzZnNmc2Zkc2Y='),
(6, 'generaldiscussion', 5, 1479306318, 0, 'ZHNmZHNmZHNmZGZz', 'c2RmZHNmZHNmc2Rmc2RmZHNm'),
(7, 'generaldiscussion', 5, 1479306336, 0, 'ZHNmb3Bkc2Zwb2twc2Rwb2ZrcA==', 'ZG9wc2trc2Zwb2twb2Rza3Bva3BvZHNrcG9ma3Bvc2RrZm9w'),
(8, 'generaldiscussion', 5, 1479306714, 0, 'Y2Rzb2lqampv', 'am9pamlvampvam9qam9qaW9qb2k='),
(9, 'generaldiscussion', 5, 1479403982, 0, 'SGVsbG8=', 'SGVsbG8gV29ybGQNCg0KZA0Kcw0KZHMNCmQNCnMNCg0KDQoNCmRzZHM='),
(10, 'generaldiscussion', 5, 1479404013, 1479402013, 'SGVsbG8=', 'PHN0cm9uZz5IZWxsbyBXb3JsZDwvc3Ryb25nPg0KDQpkDQpzDQpkcw0KZA0Kcw0KDQoNCg0KZHNkcw=='),
(11, 'programming', 5, 1479404645, 0, 'QysrIEhlbHA=', 'U0ZNTCBpcyBub3Qgd29ya2luZyBwbGVhc2UgaGVscC4='),
(12, 'science', 5, 1480004997, 0, 'OTc5MzI5Nzk0ODkyMw==', 'c2Rmc2RmDQpzZGYNCmRzDQpm'),
(13, 'showcase', 5, 1481480604, 0, 'ZGZmc2Zkcw==', 'ZnNkZnNkZnNmc2ZzZA0Kc2QNCmYNCnNkZg0K'),
(14, 'askforfeatures', 5, 1481480725, 1481481251, 'VXBkYXRlZA==', 'SGVsbG8gV29ybGQ=');

-- --------------------------------------------------------

--
-- Table structure for table `forumsections`
--

CREATE TABLE `forumsections` (
  `id` int(11) NOT NULL,
  `sectionid` varchar(32) NOT NULL,
  `title` varchar(32) NOT NULL,
  `description` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forumsections`
--

INSERT INTO `forumsections` (`id`, `sectionid`, `title`, `description`) VALUES
(1, 'general', 'General', 'This is for general requests/posts.'),
(2, 'help', 'Help', 'For all help requests and questions.');

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
-- Indexes for table `commentlikes`
--
ALTER TABLE `commentlikes`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categoryid` (`categoryid`);

--
-- Indexes for table `forumcommentlikes`
--
ALTER TABLE `forumcommentlikes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forumcomments`
--
ALTER TABLE `forumcomments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forumfavourites`
--
ALTER TABLE `forumfavourites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forumquestionlikes`
--
ALTER TABLE `forumquestionlikes`
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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sectionid` (`sectionid`);

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
-- AUTO_INCREMENT for table `commentlikes`
--
ALTER TABLE `commentlikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `facebook_users`
--
ALTER TABLE `facebook_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `forumcategories`
--
ALTER TABLE `forumcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `forumcommentlikes`
--
ALTER TABLE `forumcommentlikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `forumcomments`
--
ALTER TABLE `forumcomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `forumfavourites`
--
ALTER TABLE `forumfavourites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `forumquestionlikes`
--
ALTER TABLE `forumquestionlikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `forumquestions`
--
ALTER TABLE `forumquestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
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
