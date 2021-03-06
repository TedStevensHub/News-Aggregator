/*
sp16_news.sql
*/

SET foreign_key_checks = 0; #turn off constraints temporarily

#since constraints cause problems, drop tables first, working backward
DROP TABLE IF EXISTS sp16_newsFeed;
DROP TABLE IF EXISTS sp16_newsCategory;
  
#all tables must be of type InnoDB to do transactions, foreign key constraints
CREATE TABLE sp16_newsFeed(
FeedID INT UNSIGNED NOT NULL AUTO_INCREMENT,
FeedName TEXT DEFAULT '',
CategoryID INT UNSIGNED DEFAULT 0,
Feed TEXT DEFAULT '',
PRIMARY KEY (FeedID),
FOREIGN KEY (CategoryID) REFERENCES sp16_newsCategory(CategoryID) ON DELETE CASCADE
)ENGINE=INNODB; 

INSERT INTO sp16_newsFeed VALUES (NULL,'Mount Everest',1,'Mount+Everest');
INSERT INTO sp16_newsFeed VALUES (NULL,'Bangladesh',1,'Bangladesh');
INSERT INTO sp16_newsFeed VALUES (NULL,'Taliban',1,'Taliban');
INSERT INTO sp16_newsFeed VALUES (NULL,'Nasa',2,'NASA'); 
INSERT INTO sp16_newsFeed VALUES (NULL,'Maui',2,'Maui'); 
INSERT INTO sp16_newsFeed VALUES (NULL,'2020 Summer Olympics',2,'2020+Summer+Olympics'); 
INSERT INTO sp16_newsFeed VALUES (NULL,'Boston Red Sox',3,'Boston+Red+Sox'); 
INSERT INTO sp16_newsFeed VALUES (NULL,'French Open',3,'French+Open'); 
INSERT INTO sp16_newsFeed VALUES (NULL,'Cleveland Cavaliers',3,'Cleveland+Cavaliers'); 


#--URL's to make dynamic--#
#https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Olympic+Games&output=rss


CREATE TABLE sp16_newsCategory(
CategoryID INT UNSIGNED NOT NULL AUTO_INCREMENT,
Category VARCHAR(100) DEFAULT '',
PRIMARY KEY (CategoryID)    
)ENGINE=INNODB;

INSERT INTO sp16_newsCategory VALUES (NULL,'World');
INSERT INTO sp16_newsCategory VALUES (NULL,'Science');
INSERT INTO sp16_newsCategory VALUES (NULL,'Sports');

SET foreign_key_checks = 1; #turn foreign key check back on
