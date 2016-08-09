
DROP TABLE IF EXISTS `summer_file`;
CREATE TABLE `summer_file` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `pathname` char(200) NOT NULL,
  `title` char(90) NOT NULL,
  `summary` text,
  `extension` char(30) NOT NULL,
  `size` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `width` smallint(5) unsigned NOT NULL DEFAULT '0',
  `height` smallint(5) unsigned NOT NULL DEFAULT '0',
  `object_type` char(20) NOT NULL,
  `object_id` char(50) NOT NULL,
  `added_by` char(30) NOT NULL DEFAULT '',
  `added_time` datetime NOT NULL,
  `public` enum('1','0') NOT NULL DEFAULT '1',
  `score` smallint(5) unsigned NOT NULL DEFAULT '0',
  `downloads` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `extra` varchar(255) NOT NULL,
  `primary` enum('1','0') DEFAULT '0',
  `editor` enum('1','0') NOT NULL DEFAULT '0',
  `lang` char(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`),
  KEY `object` (`object_type`,`object_id`),
  KEY `extension` (`extension`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


-- 8-4

DROP TABLE IF EXISTS `summer_site`;
CREATE TABLE `summer_site` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `hits` int unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;
insert into summer_site values (null, 0);


-- 给site 添加站点名字字段
ALTER TABLE `summer_site` ADD `name` varchar(255) NOT NULL DEFAULT '';
UPDATE `summer_site` set `name`='四川交通职业技术学院新闻网';