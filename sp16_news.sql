/*
sp16_news.sql
*/

SET foreign_key_checks = 0; #turn off constraints temporarily

-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `sp16_newsCategory`;
CREATE TABLE `sp16_newsCategory` (
  `CategoryID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Category` varchar(100) DEFAULT '',
  PRIMARY KEY (`CategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `sp16_newsCategory` (`CategoryID`, `Category`) VALUES
(1,	'World'),
(2,	'Science'),
(3,	'Sports'),
(4,	'Music'),
(5,	'Americas');

DROP TABLE IF EXISTS `sp16_newsFeed`;
CREATE TABLE `sp16_newsFeed` (
  `FeedID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FeedName` text,
  `CategoryID` int(10) unsigned DEFAULT '0',
  `Feed` text,
  `FullUrl` varchar(2083) DEFAULT NULL,
  PRIMARY KEY (`FeedID`),
  KEY `CategoryID` (`CategoryID`),
  CONSTRAINT `sp16_newsFeed_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `sp16_newsCategory` (`CategoryID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `sp16_newsFeed` (`FeedID`, `FeedName`, `CategoryID`, `Feed`, `FullUrl`) VALUES
(1,	'Mount Everest',	1,	'Mount+Everest',	'https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=\"Mount+Everest\"&output=rss'),
(2,	'Bangladesh',	1,	'Bangladesh',	'https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=\"Bangladesh\"&output=rss'),
(3,	'Taliban',	1,	'Taliban',	'https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=\"Taliban\"&output=rss'),
(4,	'Nasa',	2,	'NASA',	'https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=\"NASA\"&output=rss'),
(5,	'Maui',	2,	'Maui',	'https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=\"Maui\"&output=rss'),
(6,	'2020 Summer Olympics',	2,	'2020+Summer+Olympics',	'https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=\"2020+Summer+Olympics\"&output=rss'),
(7,	'Boston Red Sox',	3,	'Boston+Red+Sox',	'https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=\"Boston+Red+Sox\"&output=rss'),
(8,	'French Open',	3,	'French+Open',	'https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=\"French+Open\"&output=rss'),
(9,	'Cleveland Cavaliers',	3,	'Cleveland+Cavaliers',	'https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=\"Cleveland+Cavaliers\"&output=rss'),
(10,	'NYT Americas News',	5,	NULL,	'http://rss.nytimes.com/services/xml/rss/nyt/Americas.xml'),
(15,	'NYT International Sports',	3,	NULL,	'http://rss.nytimes.com/services/xml/rss/nyt/InternationalSports.xml');

SET foreign_key_checks = 1; #turn foreign key check back on
