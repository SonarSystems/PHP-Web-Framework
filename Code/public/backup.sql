CREATE DATABASE phpframework;

--CREATING TABLE blogcomments
CREATE TABLE `blogcomments` (
  `id` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `parentid` int(11) DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `timeposted` int(32) NOT NULL,
  `timeedited` int(32) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `currentnestedlevel` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO blogcomments



--CREATING TABLE blogposts
CREATE TABLE `blogposts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `highlight` text NOT NULL,
  `body` text NOT NULL,
  `timestamp` int(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO blogposts
INSERT INTO blogposts VALUES ('1','Rmlyc3QgVGl0bGU=','','VGhpcyBpcyBwcmV0dHkgYXdlc29tZS4NCg0KT2ggWWggOkQ=','1482424591');
INSERT INTO blogposts VALUES ('2','VGhpcyBpcyB0aGUgc2Vjb25kIHBvc3Q=','','TEVBVkUgTUUgQUxPTkcNCg0KPHN0cm9uZz5TVFJPTkcgVEVTVDwvc3Ryb25nPg==','1482425042');



--CREATING TABLE commentlikes
CREATE TABLE `commentlikes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commentid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `timestamp` int(32) NOT NULL,
  `type` varchar(8) DEFAULT 'like',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO commentlikes
INSERT INTO commentlikes VALUES ('24','2','6','1480525757','like');
INSERT INTO commentlikes VALUES ('35','2','5','1480526101','dislike');
INSERT INTO commentlikes VALUES ('37','1','5','1480528118','dislike');



--CREATING TABLE comments
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postid` int(11) NOT NULL,
  `parentid` int(11) DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `timeposted` int(32) NOT NULL,
  `timeedited` int(32) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `currentnestedlevel` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO comments
INSERT INTO comments VALUES ('1','3','0','5','1478708503','0','ZWxsb28=','1');
INSERT INTO comments VALUES ('2','3','1','5','1478708505','0','YXNzYWRzYQ==','2');
INSERT INTO comments VALUES ('3','3','2','5','1478708507','0','YWRzYXNk','3');
INSERT INTO comments VALUES ('4','3','1','5','1478708511','0','ZHNhYWRz','2');
INSERT INTO comments VALUES ('5','3','4','5','1478708515','0','YWRhc2Rh','3');
INSERT INTO comments VALUES ('6','3','4','5','1478708521','0','YXNkYWRzYXNk','3');
INSERT INTO comments VALUES ('7','3','1','5','1478708525','0','YXNkYXNk','2');
INSERT INTO comments VALUES ('8','3','0','5','1478795072','0','c2Rkc2Zkc2Zkc2Y=','1');
INSERT INTO comments VALUES ('9','3','8','5','1478795075','0','c2Rm','2');
INSERT INTO comments VALUES ('10','3','9','5','1478795082','0','c2RmZHNmZHMNCnNkDQoNCmRzZg0KDQoNCmRzZg0KZHMNCg0KDQo6RA==','3');
INSERT INTO comments VALUES ('11','3','0','5','1478798914','0','QXJ1dG9zaA==','1');
INSERT INTO comments VALUES ('12','3','11','5','1478798926','0','SGUgaXMgc21hbGw=','2');
INSERT INTO comments VALUES ('13','3','11','5','1478798936','0','aGVsbG8=','2');
INSERT INTO comments VALUES ('14','3','12','5','1478798948','0','bGllcyBsaWVzIGxpZXM=','3');
INSERT INTO comments VALUES ('15','3','1','5','1480005568','0','aGVsbG8gd29ybGQ=','2');
INSERT INTO comments VALUES ('16','3','0','5','1480528123','0','ZGZzZnNmc2RmZHNmIGhlbGxv','1');



--CREATING TABLE facebookusers
CREATE TABLE `facebookusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auth_id` varchar(767) NOT NULL,
  `email_address` varchar(767) NOT NULL,
  `joined` int(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_id` (`auth_id`),
  UNIQUE KEY `email_address` (`email_address`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO facebookusers



--CREATING TABLE forumcategories
CREATE TABLE `forumcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` varchar(32) NOT NULL,
  `sectionid` varchar(32) NOT NULL,
  `title` varchar(32) NOT NULL,
  `description` varchar(512) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categoryid` (`categoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO forumcategories
INSERT INTO forumcategories VALUES ('1','generaldiscussion','general','General Discussion','For everything that isn\'t a help request.');
INSERT INTO forumcategories VALUES ('2','askforfeatures','general','Ask For Features','If there is a feature that you desire then come on in and ask.');
INSERT INTO forumcategories VALUES ('3','bugs','general','Bugs','Found any problems whilst using Sonar Learning, then let us know.');
INSERT INTO forumcategories VALUES ('4','showcase','general','Showcase','Want to showcase something epic, this is the right place.');
INSERT INTO forumcategories VALUES ('5','competitions','general','Competitions/Giveaways','Stay tuned for new competitions and giveaways.');
INSERT INTO forumcategories VALUES ('6','generalhelp','help','General','If you have any general help requests but there isn\'t a specific section then ask it here.');
INSERT INTO forumcategories VALUES ('7','programming','help','Programming','Help with programming/coding.');
INSERT INTO forumcategories VALUES ('8','science','help','Science','Help with science.');
INSERT INTO forumcategories VALUES ('9','computerscience','help','Computer Science','Help with computer science.');
INSERT INTO forumcategories VALUES ('10','maths','help','Maths','Help with mathematics.');
INSERT INTO forumcategories VALUES ('11','history','help','History','Help with history.');



--CREATING TABLE forumcommentlikes
CREATE TABLE `forumcommentlikes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commentid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `timestamp` int(32) NOT NULL,
  `type` varchar(8) DEFAULT 'like',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO forumcommentlikes
INSERT INTO forumcommentlikes VALUES ('38','1','5','1480526545','like');
INSERT INTO forumcommentlikes VALUES ('43','10','5','1480529141','like');
INSERT INTO forumcommentlikes VALUES ('47','12','5','1480529161','like');
INSERT INTO forumcommentlikes VALUES ('48','6','5','1480529190','dislike');
INSERT INTO forumcommentlikes VALUES ('50','2','5','1481479193','dislike');
INSERT INTO forumcommentlikes VALUES ('52','13','5','1481731841','like');
INSERT INTO forumcommentlikes VALUES ('53','15','5','1481731849','like');
INSERT INTO forumcommentlikes VALUES ('54','17','6','1481733131','like');
INSERT INTO forumcommentlikes VALUES ('56','18','6','1481733137','dislike');



--CREATING TABLE forumcomments
CREATE TABLE `forumcomments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postid` int(11) NOT NULL,
  `parentid` int(11) DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `timeposted` int(32) NOT NULL,
  `timeedited` int(32) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `currentnestedlevel` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO forumcomments
INSERT INTO forumcomments VALUES ('1','10','0','5','1479404614','0','VGhpcyBpcyBhbiBhd2Vzb21lIHF1ZXN0aW9ucw==','1');
INSERT INTO forumcomments VALUES ('2','10','1','5','1479404654','0','ZHNmc2RmZHNm','2');
INSERT INTO forumcomments VALUES ('3','10','2','5','1479404656','0','ZGZzZHNmZHNm','3');
INSERT INTO forumcomments VALUES ('4','10','1','5','1479404659','0','c2Rmc2Rmc2Rm','2');
INSERT INTO forumcomments VALUES ('5','10','0','5','1479404667','0','ZHNmZHNmZHNmIHNkZiBkc2YgZA0KDQoNCnNkZg0KDQpkc2Y=','1');
INSERT INTO forumcomments VALUES ('6','11','0','5','1479405298','0','ZHM=','1');
INSERT INTO forumcomments VALUES ('7','12','0','5','1480005000','0','ZXdycnc=','1');
INSERT INTO forumcomments VALUES ('8','12','7','5','1480005002','0','d2Vy','2');
INSERT INTO forumcomments VALUES ('9','12','0','5','1480005004','0','cndld2VyZXc=','1');
INSERT INTO forumcomments VALUES ('10','11','0','5','1480529139','0','ZHNmc2Rm','1');
INSERT INTO forumcomments VALUES ('11','11','6','5','1480529156','0','c2RmZHNm','2');
INSERT INTO forumcomments VALUES ('12','11','11','5','1480529158','0','c2Rmc2Rm','3');
INSERT INTO forumcomments VALUES ('13','8','0','5','1481731831','0','aGhqZ2hnamdoamdo','1');
INSERT INTO forumcomments VALUES ('14','8','13','5','1481731846','0','ZnNkZHNm','2');
INSERT INTO forumcomments VALUES ('15','8','14','5','1481731847','0','ZGZzZHNm','3');
INSERT INTO forumcomments VALUES ('16','15','0','6','1481733128','0','ZHNkYXM=','1');
INSERT INTO forumcomments VALUES ('17','15','16','6','1481733130','0','YWRzYXNk','2');
INSERT INTO forumcomments VALUES ('18','15','17','6','1481733133','0','YXNkYXNk','3');



--CREATING TABLE forumfavourites
CREATE TABLE `forumfavourites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `questionid` int(11) NOT NULL,
  `timestamp` int(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO forumfavourites
INSERT INTO forumfavourites VALUES ('5','5','13','1481480605');
INSERT INTO forumfavourites VALUES ('8','6','8','1481732913');



--CREATING TABLE forumquestionlikes
CREATE TABLE `forumquestionlikes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `questionid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `timestamp` int(32) NOT NULL,
  `type` varchar(8) DEFAULT 'like',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO forumquestionlikes
INSERT INTO forumquestionlikes VALUES ('41','10','5','1480527886','like');
INSERT INTO forumquestionlikes VALUES ('45','11','5','1480529149','dislike');
INSERT INTO forumquestionlikes VALUES ('47','8','5','1481731867','like');
INSERT INTO forumquestionlikes VALUES ('49','14','5','1481732049','like');
INSERT INTO forumquestionlikes VALUES ('51','15','6','1481733112','dislike');



--CREATING TABLE forumquestions
CREATE TABLE `forumquestions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` varchar(32) NOT NULL,
  `userid` int(11) NOT NULL,
  `timeposted` int(32) NOT NULL,
  `timeedited` int(32) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO forumquestions
INSERT INTO forumquestions VALUES ('1','generaldiscussion','5','1479305454','0','SGVsbG8gV29ybGQ=','Rmlyc3QgUG9zdA==');
INSERT INTO forumquestions VALUES ('3','generaldiscussion','5','1479305749','0','c2Rmc2Rmc2RmIC4gIGZz','ZGZzZCAuICAgICAgICAgICAgICAgICAgICAgZHNmc2RmZHNmc2Rmc2Rmc2Rmc2QNCg0KDQpzZGYNCg0KDQpzZGZkc2ZkZnNkZnMNCg0KZHNmZHNm');
INSERT INTO forumquestions VALUES ('4','generaldiscussion','5','1479305816','0','ZHNmc2RmZHNmZHM=','ZmRzZmRzZnNkZnNkZnNkZmRz');
INSERT INTO forumquestions VALUES ('5','generaldiscussion','5','1479306284','0','c2Rmc2RmZHNmc2Q=','ZmRzZnNmc2ZzZnNmc2Zkc2Y=');
INSERT INTO forumquestions VALUES ('6','generaldiscussion','5','1479306318','0','ZHNmZHNmZHNmZGZz','c2RmZHNmZHNmc2Rmc2RmZHNm');
INSERT INTO forumquestions VALUES ('7','generaldiscussion','5','1479306336','0','ZHNmb3Bkc2Zwb2twc2Rwb2ZrcA==','ZG9wc2trc2Zwb2twb2Rza3Bva3BvZHNrcG9ma3Bvc2RrZm9w');
INSERT INTO forumquestions VALUES ('8','generaldiscussion','5','1479306714','0','Y2Rzb2lqampv','am9pamlvampvam9qam9qaW9qb2k=');
INSERT INTO forumquestions VALUES ('9','generaldiscussion','5','1479403982','0','SGVsbG8=','SGVsbG8gV29ybGQNCg0KZA0Kcw0KZHMNCmQNCnMNCg0KDQoNCmRzZHM=');
INSERT INTO forumquestions VALUES ('10','generaldiscussion','5','1479404013','1479402013','SGVsbG8=','PHN0cm9uZz5IZWxsbyBXb3JsZDwvc3Ryb25nPg0KDQpkDQpzDQpkcw0KZA0Kcw0KDQoNCg0KZHNkcw==');
INSERT INTO forumquestions VALUES ('11','programming','5','1479404645','0','QysrIEhlbHA=','U0ZNTCBpcyBub3Qgd29ya2luZyBwbGVhc2UgaGVscC4=');
INSERT INTO forumquestions VALUES ('12','science','5','1480004997','0','OTc5MzI5Nzk0ODkyMw==','c2Rmc2RmDQpzZGYNCmRzDQpm');
INSERT INTO forumquestions VALUES ('13','showcase','5','1481480604','0','ZGZmc2Zkcw==','ZnNkZnNkZnNmc2ZzZA0Kc2QNCmYNCnNkZg0K');
INSERT INTO forumquestions VALUES ('14','askforfeatures','5','1481480725','1481731917','VXBkYXRlZA==','SGVsbG8gV29ybGQ=');
INSERT INTO forumquestions VALUES ('15','generaldiscussion','6','1481733109','0','ZGFzZGFzZGFzZGFz','DQphZHMNCmFkcw0KDQphZHMNCmFzZA==');



--CREATING TABLE forumsections
CREATE TABLE `forumsections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sectionid` varchar(32) NOT NULL,
  `title` varchar(32) NOT NULL,
  `description` varchar(512) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sectionid` (`sectionid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO forumsections
INSERT INTO forumsections VALUES ('1','general','General','This is for general requests/posts.');
INSERT INTO forumsections VALUES ('2','help','Help','For all help requests and questions.');



--CREATING TABLE googleusers
CREATE TABLE `googleusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auth_id` varchar(767) NOT NULL,
  `email_address` varchar(767) NOT NULL,
  `joined` int(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_id` (`auth_id`),
  UNIQUE KEY `email_address` (`email_address`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO googleusers



--CREATING TABLE notifications
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(32) NOT NULL,
  `userid` int(11) NOT NULL,
  `title` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  `isviewed` tinyint(1) NOT NULL DEFAULT '0',
  `isopened` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO notifications
INSERT INTO notifications VALUES ('1','like','8','Hello this is awesome','1500585915','1','0');
INSERT INTO notifications VALUES ('2','like','10','SGVsbG8gdGhpcyBpcyBhd2Vzb21l','1500586119','0','0');
INSERT INTO notifications VALUES ('3','response','10','SGVsbG8gdGhpcyBpcyBhd2Vzb21l','1501001245','0','0');



--CREATING TABLE notificationtypes
CREATE TABLE `notificationtypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO notificationtypes
INSERT INTO notificationtypes VALUES ('2','like');
INSERT INTO notificationtypes VALUES ('1','response');



--CREATING TABLE userprivileges
CREATE TABLE `userprivileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `privilege` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `privilege` (`privilege`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO userprivileges
INSERT INTO userprivileges VALUES ('1','admin');
INSERT INTO userprivileges VALUES ('2','user');



--CREATING TABLE users
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `privilege` varchar(16) NOT NULL DEFAULT 'user',
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `email_address` varchar(767) NOT NULL,
  `salt` varchar(1024) NOT NULL,
  `joined` int(32) NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_address` (`email_address`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO users
INSERT INTO users VALUES ('8','admin','frahaan','$2y$10$7ldrcRrr14Sw7eHl8lXNGOaq6NjfcSl/79KX45GdnXnUzB.qX54B6','contact@contact.com','6f5c788a96dd294289c5d855e57b6d15e93526236e6208e26d31acc6f1a3d15b9f66da67965eb9e7a88d10f7169c9b7c795068f008fa3942d6bc24d89407cbea88fb437b4a763dbd221c76ec861c8510e1a3fbf48c97d1c516c46111188766a454a00b9dadf14d28c7782d368b1d45fb5b9e05e3ff6f51ebd85456627754e2e0','1498561308','1');
INSERT INTO users VALUES ('9','user','test12345','$2y$10$fpk9XI5I.oz/yb90xD3mLOYtCG.TWHE85b3njfEpN8UKrkLdnvLv6','contact@contact.comm','f2028f76187a66087f6e9f34cd11afe9aee87a5b3a69387a1423c8300513d0ddbf040cee5ed4776767bba575b0c58e86d3f509ae9caf82cbfe6fa2f5e15076b20cf5250a878e2a4b4eac131f85596652eae4b2b8e08ec6d109db24c5f365da157d1762bfc778f736766ec2b46cd6cbee15cbf1f19212bc5cc663e1fe98a834b3','1499188634','0');
INSERT INTO users VALUES ('10','user','iuhiuhihiuhui','$2y$10$0nBqB8rokn2ke5K823wnfOKaOec79OPDjlsxeWkBwjXJit5uyFURm','ojsdiojfds@dsiofjiods.commm','b1bb835a4d1acfe19300be181211b3a87bba07d85eb62d2197f57c0c29a35ec195878e77b0bc31ff80c8fac87bf2cf63196c9d97b45575734709eed129ade7d2d289038f772daf666b09d5f982e756bf161e3a84289d049648a354de03341a7a42babce4b96c70d04d3995aff7ea09812114dda6e84738984b5076312ab7af42','1499188793','0');



--CREATING TABLE userspasswordreset
CREATE TABLE `userspasswordreset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `salt` varchar(1024) NOT NULL,
  `starttime` int(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO userspasswordreset
INSERT INTO userspasswordreset VALUES ('8','frahaan','c79b0433241be95f44b2e5b9bd09158e0dd6e1ae8d56a15c3f3644e685b0cd075499c43dac05372d6868e725a53a69ad0b837b06d21534d20f0a4f445ae6755bfe17d966aa74dede18096b54e781a16292cfd97c9290d01c79e7321045679398f145f6360fccf08e5f8ebed55115e596c7e364a13bb587a2fabcfcf65c14ba3f','1500038257');



--CREATING TABLE userssessions
CREATE TABLE `userssessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `hash` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--INSERTING DATA INTO userssessions
INSERT INTO userssessions VALUES ('10','7','dcecbc7848a6c82098368161df2e5d77de043b3adf251b82e4131df2b0c228cf');
INSERT INTO userssessions VALUES ('12','8','9a241ab88a40a070b26052e136eca0c25496be494ca072211373ff02c84322a6');



-- THE END

