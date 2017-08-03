-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 03, 2017 at 07:01 PM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpframework`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogcomments`
--

CREATE TABLE `blogcomments` (
  `id` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `parentid` int(11) DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `timeposted` int(32) NOT NULL,
  `timeedited` int(32) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `currentnestedlevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blogposts`
--

CREATE TABLE `blogposts` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `highlight` text NOT NULL,
  `body` text NOT NULL,
  `timestamp` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blogposts`
--

INSERT INTO `blogposts` (`id`, `title`, `highlight`, `body`, `timestamp`) VALUES
(1, 'Rmlyc3QgVGl0bGU=', '', 'VGhpcyBpcyBwcmV0dHkgYXdlc29tZS4NCg0KT2ggWWggOkQ=', 1482424591),
(2, 'VGhpcyBpcyB0aGUgc2Vjb25kIHBvc3Q=', '', 'TEVBVkUgTUUgQUxPTkcNCg0KPHN0cm9uZz5TVFJPTkcgVEVTVDwvc3Ryb25nPg==', 1482425042);

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
-- Table structure for table `facebookusers`
--

CREATE TABLE `facebookusers` (
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
(1, 'generaldiscussion', 'general', 'General Discussion', 'For everything that isn\'t a help request.'),
(2, 'askforfeatures', 'general', 'Ask For Features', 'If there is a feature that you desire then come on in and ask.'),
(3, 'bugs', 'general', 'Bugs', 'Found any problems whilst using Sonar Learning, then let us know.'),
(4, 'showcase', 'general', 'Showcase', 'Want to showcase something epic, this is the right place.'),
(5, 'competitions', 'general', 'Competitions/Giveaways', 'Stay tuned for new competitions and giveaways.'),
(6, 'generalhelp', 'help', 'General', 'If you have any general help requests but there isn\'t a specific section then ask it here.'),
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
(50, 2, 5, 1481479193, 'dislike'),
(52, 13, 5, 1481731841, 'like'),
(53, 15, 5, 1481731849, 'like'),
(54, 17, 6, 1481733131, 'like'),
(56, 18, 6, 1481733137, 'dislike');

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
(12, 11, 11, 5, 1480529158, 0, 'c2Rmc2Rm', 3),
(13, 8, 0, 5, 1481731831, 0, 'aGhqZ2hnamdoamdo', 1),
(14, 8, 13, 5, 1481731846, 0, 'ZnNkZHNm', 2),
(15, 8, 14, 5, 1481731847, 0, 'ZGZzZHNm', 3),
(16, 15, 0, 6, 1481733128, 0, 'ZHNkYXM=', 1),
(17, 15, 16, 6, 1481733130, 0, 'YWRzYXNk', 2),
(18, 15, 17, 6, 1481733133, 0, 'YXNkYXNk', 3);

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
(5, 5, 13, 1481480605),
(8, 6, 8, 1481732913);

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
(45, 11, 5, 1480529149, 'dislike'),
(47, 8, 5, 1481731867, 'like'),
(49, 14, 5, 1481732049, 'like'),
(51, 15, 6, 1481733112, 'dislike');

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
(14, 'askforfeatures', 5, 1481480725, 1481731917, 'VXBkYXRlZA==', 'SGVsbG8gV29ybGQ='),
(15, 'generaldiscussion', 6, 1481733109, 0, 'ZGFzZGFzZGFzZGFz', 'DQphZHMNCmFkcw0KDQphZHMNCmFzZA==');

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
-- Table structure for table `googleusers`
--

CREATE TABLE `googleusers` (
  `id` int(11) NOT NULL,
  `auth_id` varchar(767) NOT NULL,
  `email_address` varchar(767) NOT NULL,
  `joined` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `userid` int(11) NOT NULL,
  `title` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  `isviewed` tinyint(1) NOT NULL DEFAULT '0',
  `isopened` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `userid`, `title`, `timestamp`, `isviewed`, `isopened`) VALUES
(1, 'like', 8, 'Hello this is awesome', 1500585915, 1, 0),
(2, 'like', 10, 'SGVsbG8gdGhpcyBpcyBhd2Vzb21l', 1500586119, 0, 0),
(3, 'response', 10, 'SGVsbG8gdGhpcyBpcyBhd2Vzb21l', 1501001245, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notificationtypes`
--

CREATE TABLE `notificationtypes` (
  `id` int(11) NOT NULL,
  `type` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notificationtypes`
--

INSERT INTO `notificationtypes` (`id`, `type`) VALUES
(2, 'like'),
(1, 'response');

-- --------------------------------------------------------

--
-- Table structure for table `userprivileges`
--

CREATE TABLE `userprivileges` (
  `id` int(11) NOT NULL,
  `privilege` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userprivileges`
--

INSERT INTO `userprivileges` (`id`, `privilege`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `privilege` varchar(16) NOT NULL DEFAULT 'user',
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

INSERT INTO `users` (`id`, `privilege`, `username`, `password`, `email_address`, `salt`, `joined`, `activated`) VALUES
(8, 'user', 'frahaan', '$2y$10$7ldrcRrr14Sw7eHl8lXNGOaq6NjfcSl/79KX45GdnXnUzB.qX54B6', 'contact@contact.com', '6f5c788a96dd294289c5d855e57b6d15e93526236e6208e26d31acc6f1a3d15b9f66da67965eb9e7a88d10f7169c9b7c795068f008fa3942d6bc24d89407cbea88fb437b4a763dbd221c76ec861c8510e1a3fbf48c97d1c516c46111188766a454a00b9dadf14d28c7782d368b1d45fb5b9e05e3ff6f51ebd85456627754e2e0', 1498561308, 1),
(9, 'user', 'test12345', '$2y$10$fpk9XI5I.oz/yb90xD3mLOYtCG.TWHE85b3njfEpN8UKrkLdnvLv6', 'contact@contact.comm', 'f2028f76187a66087f6e9f34cd11afe9aee87a5b3a69387a1423c8300513d0ddbf040cee5ed4776767bba575b0c58e86d3f509ae9caf82cbfe6fa2f5e15076b20cf5250a878e2a4b4eac131f85596652eae4b2b8e08ec6d109db24c5f365da157d1762bfc778f736766ec2b46cd6cbee15cbf1f19212bc5cc663e1fe98a834b3', 1499188634, 0),
(10, 'user', 'iuhiuhihiuhui', '$2y$10$0nBqB8rokn2ke5K823wnfOKaOec79OPDjlsxeWkBwjXJit5uyFURm', 'ojsdiojfds@dsiofjiods.commm', 'b1bb835a4d1acfe19300be181211b3a87bba07d85eb62d2197f57c0c29a35ec195878e77b0bc31ff80c8fac87bf2cf63196c9d97b45575734709eed129ade7d2d289038f772daf666b09d5f982e756bf161e3a84289d049648a354de03341a7a42babce4b96c70d04d3995aff7ea09812114dda6e84738984b5076312ab7af42', 1499188793, 0);

-- --------------------------------------------------------

--
-- Table structure for table `userspasswordreset`
--

CREATE TABLE `userspasswordreset` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `salt` varchar(1024) NOT NULL,
  `starttime` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userspasswordreset`
--

INSERT INTO `userspasswordreset` (`id`, `username`, `salt`, `starttime`) VALUES
(8, 'frahaan', 'c79b0433241be95f44b2e5b9bd09158e0dd6e1ae8d56a15c3f3644e685b0cd075499c43dac05372d6868e725a53a69ad0b837b06d21534d20f0a4f445ae6755bfe17d966aa74dede18096b54e781a16292cfd97c9290d01c79e7321045679398f145f6360fccf08e5f8ebed55115e596c7e364a13bb587a2fabcfcf65c14ba3f', 1500038257);

-- --------------------------------------------------------

--
-- Table structure for table `userssessions`
--

CREATE TABLE `userssessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userssessions`
--

INSERT INTO `userssessions` (`id`, `user_id`, `hash`) VALUES
(10, 7, 'dcecbc7848a6c82098368161df2e5d77de043b3adf251b82e4131df2b0c228cf'),
(12, 8, '9a241ab88a40a070b26052e136eca0c25496be494ca072211373ff02c84322a6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogcomments`
--
ALTER TABLE `blogcomments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogposts`
--
ALTER TABLE `blogposts`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `facebookusers`
--
ALTER TABLE `facebookusers`
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
-- Indexes for table `googleusers`
--
ALTER TABLE `googleusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `auth_id` (`auth_id`),
  ADD UNIQUE KEY `email_address` (`email_address`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notificationtypes`
--
ALTER TABLE `notificationtypes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`type`);

--
-- Indexes for table `userprivileges`
--
ALTER TABLE `userprivileges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `privilege` (`privilege`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_address` (`email_address`);

--
-- Indexes for table `userspasswordreset`
--
ALTER TABLE `userspasswordreset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userssessions`
--
ALTER TABLE `userssessions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogposts`
--
ALTER TABLE `blogposts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
-- AUTO_INCREMENT for table `facebookusers`
--
ALTER TABLE `facebookusers`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `forumcomments`
--
ALTER TABLE `forumcomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `forumfavourites`
--
ALTER TABLE `forumfavourites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `forumquestionlikes`
--
ALTER TABLE `forumquestionlikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `forumquestions`
--
ALTER TABLE `forumquestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `forumsections`
--
ALTER TABLE `forumsections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `googleusers`
--
ALTER TABLE `googleusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `notificationtypes`
--
ALTER TABLE `notificationtypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `userprivileges`
--
ALTER TABLE `userprivileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `userspasswordreset`
--
ALTER TABLE `userspasswordreset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `userssessions`
--
ALTER TABLE `userssessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
