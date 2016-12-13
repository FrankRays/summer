
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


-------------------------------------- 2.01 --------------------------------------

--增加用户文章访问权限字段
ALTER TABLE `summer_user` ADD `article_cate_access` varchar(255) NOT NULL DEFAULT '';

-- 角色表
CREATE TABLE `xww`.`summer_role` ( 
  `id` INT NOT NULL AUTO_INCREMENT , 
  `rolename` VARCHAR(255) NOT NULL , 
  PRIMARY KEY (`id`)) 
ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

-- 角色用户映射表
CREATE TABLE `xww`.`summer_roleuser` ( 
  `id` INT NOT NULL AUTO_INCREMENT , 
  `role_id` INT NOT NULL , `user_id` INT NOT NULL , 
  `create_time` DATETIME NOT NULL , PRIMARY KEY (`id`)) 
)ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

-- 权限表
CREATE TABLE `xww`.`summer_module` ( 
  `id` INT NOT NULL AUTO_INCREMENT , 
  `modulename` VARCHAR(255) NOT NULL , 
  `mvc_url` VARCHAR(255) NOT NULL , 
  `extra` VARCHAR(255) NOT NULL , 
  PRIMARY KEY (`id`)) 
ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

--权限映射表
CREATE TABLE `xww`.`summer_access` ( 
  `id` INT NOT NULL AUTO_INCREMENT , 
  `roleid` INT NOT NULL , 
  `moduleid` INT NOT NULL , 
  PRIMARY KEY (`id`), 
  INDEX (`roleid`), 
  INDEX (`moduleid`)) 
ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;


ALTER TABLE `summer_article_category` ADD `is_img` TINYINT NOT NULL DEFAULT '0' AFTER `is_delete`;

ALTER TABLE `summer_article_index` ADD `www_href` VARCHAR(255) NOT NULL AFTER `fingerprint`;


-- 12.13 creat a new table `summer_visitor` 记录访客行文
CREATE TABLE `summer_visitor` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `vci` char(36) NOT NULL COMMENT '生成的base64cookie',
 `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `ip_addr` char(15) NOT NULL DEFAULT '' COMMENT 'IP地址',
 `type` varchar(20) NOT NULL,
 `type_value` varchar(20) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `vci` (`vci`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8