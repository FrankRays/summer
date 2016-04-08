-- MySQL dump 10.13  Distrib 5.5.37, for Linux (x86_64)
--
-- Host: localhost    Database: xww
-- ------------------------------------------------------
-- Server version	5.5.37-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `owner` char(30) NOT NULL DEFAULT '',
  `module` varchar(30) NOT NULL,
  `section` char(30) NOT NULL DEFAULT '',
  `key` char(30) DEFAULT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`owner`,`module`,`section`,`key`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (20,'system','common','slides',NULL,'{\"name\":\"\\u8fce\\u65b0\\u665a\\u4f1a\\u821e\\u8e48\",\"picSrc\":\"\\/source\\/editor\\/attached\\/image\\/20141124\\/20141124081102_54431.jpg\",\"summary\":\"\",\"linkSrc\":\"\"}'),(21,'system','common','slides',NULL,'{\"name\":\"\\u4ea4\\u9662\\u781a\\u6c60\",\"picSrc\":\"\\/source\\/editor\\/attached\\/image\\/20141124\\/20141124081646_18451.jpg\",\"summary\":\"\",\"linkSrc\":\"\"}');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file`
--

DROP TABLE IF EXISTS `file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pathname` char(150) NOT NULL,
  `title` char(90) NOT NULL,
  `extension` char(30) NOT NULL,
  `size` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `width` smallint(5) unsigned NOT NULL DEFAULT '0',
  `height` smallint(5) unsigned NOT NULL DEFAULT '0',
  `objectType` char(20) NOT NULL,
  `objectID` mediumint(9) NOT NULL,
  `addedBy` char(30) NOT NULL DEFAULT '',
  `addedDate` int(11) NOT NULL,
  `public` enum('1','0') NOT NULL DEFAULT '1',
  `downloads` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `extra` varchar(255) NOT NULL,
  `primary` enum('1','0') DEFAULT '0',
  `editor` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `object` (`objectType`,`objectID`)
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file`
--

LOCK TABLES `file` WRITE;
/*!40000 ALTER TABLE `file` DISABLE KEYS */;
INSERT INTO `file` VALUES (4,'a3a81fbec986fb7fa5a65d923a089d31.jpg','Penguins.jpg','jpeg',760,1024,768,'article',117,'',1414599641,'1',0,'','0',''),(5,'5b59d493c7514c22c0c3693fd0cf33d0.jpg','Penguins','jpeg',760,1024,768,'article',118,'',1414600058,'1',0,'','0',''),(6,'4ccd75a7a5f022469e3c8007051d505b.jpg','Penguins','jpeg',760,1024,768,'article',119,'',1414600144,'1',0,'','0',''),(7,'833a33de946b7f3f85c15c3c8d700f85.jpg','Penguins','jpeg',760,1024,768,'article',120,'',1414600177,'1',0,'','0',''),(8,'4fc3b6fe75bfb5539e730af036ad2e76.jpg','Penguins','.jpg',760,1024,768,'article',121,'',1414600207,'1',0,'','0',''),(9,'3','','3',3,3,3,'article',133,'',1414631804,'1',0,'','0',''),(10,'i','','i',0,0,0,'article',133,'',1414631804,'1',0,'','0',''),(11,'C','','C',0,0,0,'article',133,'',1414631804,'1',0,'','0',''),(12,'C','','C',0,0,0,'article',133,'',1414631804,'1',0,'','0',''),(13,'3','','3',3,3,3,'article',133,'',1414631804,'1',0,'','0',''),(14,'L','','L',0,0,0,'article',133,'',1414631804,'1',0,'','0',''),(15,'L','','L',0,0,0,'article',133,'',1414631804,'1',0,'','0',''),(16,'.','','.',0,0,0,'article',133,'',1414631804,'1',0,'','0',''),(17,'467bdbbce8ff0bffc235eb86e282ac7e.jpg','','.jpg',548,1024,768,'article',134,'',1414631838,'1',0,'','0',''),(18,'436b7a56c7f6d05be550a10107aa4a53.jpg','sds','.jpg',548,1024,768,'article',135,'',1414631855,'1',0,'','0',''),(19,'81699fca6f852b831d5917d59bd14b90.jpg','sds','.jpg',548,1024,768,'article',136,'',1414631875,'1',0,'','0',''),(20,'7a54cde8e68772afc815fca6933d8c1c.jpg','sds','.jpg',548,1024,768,'article',137,'',1414631957,'1',0,'','0',''),(21,'7b980bba21894f29232e2626ef151c30.jpg','sds','.jpg',548,1024,768,'article',138,'',1414632028,'1',0,'','0',''),(22,'ec33039a4ba69090b52a673d174a72af.jpg','Chrysanthemum','.jpg',859,1024,768,'article',142,'',1414745096,'1',0,'','0',''),(23,'f6412e4f4e221e05b241bf50944a5c7e.jpg','Lighthouse','.jpg',548,1024,768,'article',142,'',1414745987,'1',0,'','0',''),(24,'b310c9060481c117a9a31b580beb026c.jpg','Koala','.jpg',763,1024,768,'article',142,'',1414753009,'1',0,'','0',''),(37,'/source/editor/attached/image/20141027/20141027085','','',0,0,0,'',0,'',0,'1',0,'','0','0'),(38,'/source/editor/attached/image/20141027/20141027085','','',0,0,0,'',0,'',0,'1',0,'','0','0'),(39,'/source/editor/attached/image/20141027/20141027085','','',0,0,0,'',0,'',0,'1',0,'','0','0'),(40,'/source/editor/attached/image/20141027/20141027084620_64505.jpg','','',0,0,0,'articleContent',143,'',0,'1',0,'','0','0'),(41,'/source/editor/attached/image/20141027/20141027085009_30945.jpg','','',0,0,0,'articleContent',143,'',0,'1',0,'','0','0'),(42,'9f42b17b170b6375274a9ba578ecfe2a.jpg','Koala','.jpg',763,1024,768,'article',143,'杨科',1414925289,'1',0,'','0','0'),(43,'ysource/20141102/1b18d65d815ca2cb88f96f8a1f816b31.jpg','Koala','.jpg',763,1024,768,'article',143,'杨科',1414925475,'1',0,'','0','0'),(72,'ysource/20141120/978bedda34612ff4a0a27403f8cf5fbb.jpg','Penguins','.jpg',760,1024,768,'article',159,'杨科',1416454225,'1',0,'','0','0'),(73,'ysource/20141121/962dd01e8e25f864e718fcc34aaf7099.jpg','Tulips','.jpg',606,1024,768,'article',21,'杨科',1416553627,'1',0,'','0','0'),(71,'ysource/20141120/23e1ebfc36248f200455a21129795a40.jpg','IMG_20140530_103253','.jpg',197,600,338,'article',159,'杨科',1416454225,'1',0,'','0','0'),(65,'ysource/20141104/354bafcad170227210a32145ad0ca84c.JPG','DSC_0025','.JPG',550,1440,460,'article',144,'杨科',1415067759,'1',0,'','0','0'),(66,'ysource/20141104/a1b08a23c8f7e4909f9ad174518727dd.jpg','lan','.jpg',121,429,600,'article',144,'杨科',1415068038,'1',0,'','0','0'),(67,'ysource/20141104/a8081289f0895262d695131b30b75865.jpg','2013112121441555','.jpg',92,960,720,'article',144,'杨科',1415068080,'1',0,'','0','0'),(68,'ysource/20141104/55efc05e2993744e4d88858c3f6dfd13.png','QQ截图20141014201644','.png',18,606,234,'article',144,'杨科',1415068474,'1',0,'','0','0'),(69,'ysource/20141104/1d4305cb464edf7db839dafe94726420.htm','2 Git 基础 - Pro Git','.htm',160,0,0,'article',144,'杨科',1415068600,'1',0,'','0','0'),(70,'ysource/20141120/308695ef6cc4b7e72ece051bcdb3d23c.jpg','fb54a23aae8824f68f088bbfca56a526','.jpg',537,1024,685,'article',152,'杨科',1416449274,'1',0,'','0','0'),(74,'ysource/20141121/72b42e2d7b237fd36da61ba76c044044.jpg','Penguins','.jpg',760,1024,768,'article',21,'杨科',1416553643,'1',0,'','0','0'),(75,'ysource/20141121/1d90773adbc9236fb02b83c19e4958a6.jpg','Lighthouse','.jpg',548,1024,768,'article',150,'杨科',1416569894,'1',0,'','0','0'),(76,'ysource/20141124/8bac0265c8e2df2d71660639b566557f.JPG','IMG_0020','.JPG',453,600,800,'article',31,'杨科',1416819823,'1',0,'','0','0'),(77,'ysource/20141124/2e13a7cb4cbbf49d62b65d436999cb9b.JPG','IMG_0024 - 副本','.JPG',350,600,800,'article',31,'杨科',1416819823,'1',0,'','0','0'),(78,'ysource/20141124/d887185410efec31eae8a753cb915cfb.JPG','IMG_0025','.JPG',230,600,450,'article',31,'杨科',1416819823,'1',0,'','0','0'),(79,'ysource/20141124/942ab1fee43470f280d9d18c7c903cec.JPG','IMG_0030','.JPG',392,600,800,'article',31,'杨科',1416819823,'1',0,'','0','0'),(80,'ysource/20141124/fb152bc523c0ccdcdd21624dfd460821.JPG','IMG_0033','.JPG',331,600,800,'article',31,'杨科',1416819823,'1',0,'','0','0'),(81,'ysource/20141124/cc3857b57c8953a17cca146e234f3e5a.JPG','IMG_5963','.JPG',204,600,400,'article',33,'杨科',1416820192,'1',0,'','0','0'),(82,'ysource/20141124/bd602ac1ca96ff9952d22a935d94100f.JPG','IMG_5969','.JPG',211,600,400,'article',33,'杨科',1416820192,'1',0,'','0','0'),(83,'ysource/20141124/d148cf5ed4e42730ceb1c4e80fb10707.JPG','IMG_6140','.JPG',221,600,400,'article',33,'杨科',1416820192,'1',0,'','0','0'),(84,'ysource/20141124/9940f897673d95ed12e8c4bb7fc2b808.JPG','IMG_6164','.JPG',215,600,400,'article',33,'杨科',1416820192,'1',0,'','0','0'),(85,'ysource/20141124/7aea0c03668103cb01d78e2bb24baca6.JPG','IMG_6188','.JPG',265,600,400,'article',33,'杨科',1416820192,'1',0,'','0','0'),(86,'ysource/20141124/d709b5ee30b73c82ebb55a2fa4bd1c46.jpg','IMG_20140530_105651','.jpg',217,600,338,'article',33,'杨科',1416820192,'1',0,'','0','0'),(87,'ysource/20141124/46089c281e4d86a4513838ed754b0a6c.JPG','IMG_6299','.JPG',195,600,400,'article',33,'杨科',1416820192,'1',0,'','0','0'),(88,'ysource/20141124/1a16a5732dd0a56667a59f8ea08f8ba6.jpg','bg1','.jpg',262,829,455,'article',34,'杨科',1416820275,'1',0,'','0','0'),(89,'ysource/20141124/fd26f83ebd7c1cb7521618389f033f75.jpg','bg11 (1)','.jpg',1663,4256,2722,'article',35,'杨科',1416820312,'1',0,'','0','0'),(90,'file://C:/Users/ADMINI~1/AppData/Local/Temp/msohtml1/01/clip_image001.gif','','',0,0,0,'articleContent',27,'',1416906572,'1',0,'','0','0'),(91,'file://C:/Users/ADMINI~1/AppData/Local/Temp/msohtml1/01/clip_image002.gif','','',0,0,0,'articleContent',27,'',1416906572,'1',0,'','0','0'),(92,'ysource/20141125/5e53ee5d66ebf8f04364eba7dc7f9efc.JPG',' (10)','.JPG',250,600,400,'article',36,'杨科',1416906971,'1',0,'','0','0'),(93,'ysource/20141223/d410bf4712ec954bbcb28f9cba2fa2fe.jpg','u=1328658531,1869722661&fm=11&gp=0','.jpg',7,400,300,'article',4,'杨科',1419349264,'1',0,'','0','0'),(94,'ysource/20141223/9e03a6706aeb1e163e2b5c29bac6582a.jpg','u=3233655666,3597052780&fm=23&gp=0','.jpg',13,450,300,'article',4,'杨科',1419349288,'1',0,'','0','0'),(95,'ysource/20141224/ab6e64041482dab29782b5342ba24236.jpg','u=3233655666,3597052780&fm=23&gp=0','.jpg',13,450,300,'article',9,'杨科',1419431245,'1',0,'','0','0'),(96,'ysource/20141224/ebd89bcf461bc50d8a1242b7b931fd43.jpg','u=2243032953,22564323&fm=11&gp=0','.jpg',10,238,300,'article',13,'杨科',1419435257,'1',0,'','0','0');
/*!40000 ALTER TABLE `file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friend_link`
--

DROP TABLE IF EXISTS `friend_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friend_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `link_url` varchar(250) NOT NULL,
  `is_delete` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friend_link`
--

LOCK TABLES `friend_link` WRITE;
/*!40000 ALTER TABLE `friend_link` DISABLE KEYS */;
INSERT INTO `friend_link` VALUES (1,'无奈长','http://weibo.com/ajaxlogin.php?framelogin=1&callback=parent.sinaSSOController.feedBackUrlCallBack','1'),(2,'无奈长','http://weibo.com/ajaxlogin.php?framelogin=1&callback=parent.sinaSSOController.feedBackUrlCallBack','1'),(3,'无奈长','http://weibo.com/ajaxlogin.php?framelogin=1&callback=parent.sinaSSOController.feedBackUrlCallBack','1'),(4,'中国共青团','www.ccyl.org.cn','0'),(5,'中国青年志愿者','www.zgzyz.org.cn','0'),(6,'中青网','www.youth.cn','0'),(7,'四川省学生联合会','www.sichuanxuelian.com','0'),(8,'中青在线','www.cyol.net','0'),(9,'四川共青团','www.scgqt.org.cn/home','0');
/*!40000 ALTER TABLE `friend_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lm`
--

DROP TABLE IF EXISTS `lm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lm` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `describle` varchar(200) NOT NULL DEFAULT '',
  `is_nav` char(1) NOT NULL DEFAULT '0',
  `link_src` varchar(200) NOT NULL DEFAULT '',
  `pic_src` varchar(200) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `is_delete` char(1) NOT NULL DEFAULT '0',
  `cid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lm`
--

LOCK TABLES `lm` WRITE;
/*!40000 ALTER TABLE `lm` DISABLE KEYS */;
INSERT INTO `lm` VALUES (1,'学院主页','杨科的分类','1','http://www.svtcc.edu.cn','俺的沙发斯蒂芬',4534442,41,'0',0),(2,'首  页','asdf','1','http://tw.svtcc.edu.cn/new','asdf',0,0,'0',0),(3,'规章制度','专业建设','1','','',0,0,'0',9),(4,'机构设置','','1','','',0,0,'0',10),(5,'师资队伍','','1','http://rwx.svtcc.edu.cn/news/li/szdw','',0,0,'1',0),(6,'荣誉表彰','','1','','',0,0,'0',11),(7,'网上团校','','1','','',0,0,'0',7),(8,'光影交院','','1','','',0,0,'0',8),(9,'校企合作','','1','','',0,0,'1',10),(10,'党团建设','','0','','',0,0,'1',15),(11,'学生工作','','0','','',0,0,'1',16),(12,'测试一下下','','0','','',0,0,'1',0),(13,'招生就业','','0','','',0,0,'1',54),(14,'师生风采','','0','','',0,0,'1',57);
/*!40000 ALTER TABLE `lm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `alias` varchar(150) NOT NULL,
  `category_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL DEFAULT '',
  `author` varchar(40) NOT NULL DEFAULT '',
  `editor` varchar(60) DEFAULT NULL,
  `summary` varchar(400) NOT NULL DEFAULT '',
  `keywords` varchar(200) NOT NULL DEFAULT '',
  `content` text,
  `pic_src` varchar(200) NOT NULL DEFAULT '',
  `url_src` varchar(200) NOT NULL DEFAULT '',
  `come_from` varchar(200) NOT NULL DEFAULT '',
  `file_src` varchar(200) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `edit_time` int(11) DEFAULT NULL,
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `status` varchar(20) DEFAULT NULL,
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `is_delete` char(1) NOT NULL DEFAULT '0',
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'',5,'榜样传递正能量 模范引领新风尚','杨科',NULL,'','','<p style=\"text-indent:2em;\">\n	11月25日上午，学院2013—2014学年学生奖励评审会议在博学馆一楼会议室召开，学院副院长彭谦，学工部、教务处、团委负责人及各系党总支书记出席并担任本次评审会的评委，全院70名学生陪审团全程观看，整个评审工作在学院纪委的监审下顺利完成。\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	图为十佳评选会现场\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	今年各系共推荐15名品学兼优的学生参加“十佳学生标兵”评选。评选会上，15名候选人分别进行了个人先进事迹演讲，用PPT展示了自己的学习生活、班团活动、社会实践、科研创新、专业竞赛等方面的傲人成绩和优秀风采，分享了校园生活的感悟。经过激烈角逐，最终评选出侯建平等10名同学成为2013-2014学年“十佳学生标兵”获得者。\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	台上同学声情并茂、热情洋溢的演讲感染了在场的每一位同学，台下掌声不断。陪审团的同学表示：“要向优秀进军，向榜样学习，展现出交院学子真风采”。\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	评审会还审核通过了2013-2014年度各系推荐的174名院优毕业生、41名省优毕业生；1个先进集体和4个文明园区；315名优秀学生干部；6名道德风尚奖；504名学生进步奖；28个团体和26项个人创新竞赛奖及616名的学院奖学金获得者。\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	(来稿:学生工作部)\n</p>','0','','','',1419264000,NULL,0,'1',1,'0',NULL),(2,'',9,'农村公路养护管理培训班在管理学校举行','杨科',NULL,'','','<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;11月25日，全省农村公路养护管理培训班在管理学校开班，全省涉及重点城镇建设的县（区、市）交通运输局的农村公路养护负责人共200余人参加了培训。此次培训邀请了行业内的知名专家，从农村公路的养护技术、质量管理、路政管理、安全管理、建设政策及组织管理程序等方面进行了讲授。</span></span>\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;厅科教处副处长权全作开班动员讲话。他指出：长期以来省厅重视行业干部职工队伍建设，把教育培训视为提升干部职工文化素质、业务能力、管理水平的重要手段。结合今年行业的主要任务、重点工作，厅委托四川省交通管理学校承办农村公路养护管理培训班。他要求参训学员珍惜机会，遵守纪律、学有所获、学以致用、争创佳绩。</span></span>\n</p>','0','','','',1419264000,NULL,0,'1',1,'0',NULL),(3,'',9,'我院成功承办2014全国职业院校宣传部长联席会','杨科',NULL,'','','<p style=\"text-indent:2em;\">\n	面对新媒体时代的到来，高职院校将如何做好宣传，如何服务于广大青年学子，如何谋求内涵式发展？11月24日—25日，在四川交通职业技术学院举行的2014全国职业院校宣传部长联席会议上，来自全国137所职业院校的260余名代表共商新出路。\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	图为会议现场\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	此次会议由中国青年报社主办，由四川交通职业技术学院承办。教育部职成司副司长刘建同，省教育厅副厅长王康，省交通运输厅副巡视员寇小兵，共青团四川省委党组成员王军，中国青年报社编委、共青团新闻中心主任黄勇，中国青年报社经管会成员、新闻事业部主任乔建宾，省教育厅宣思处处长陈小红，省交通运输厅科教处处长黄浩，共青团四川省委宣传部副部长杜一三、四川交职院党委书记王东平、院长魏庆曜等领导出席会议。\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	中山大学原校长黄达人教授以“高职院校内涵建设的一些思考”、中国青年政治学院原党委书记常务副院长陆士桢教授，以“领会中央精神，研究学生特点，做好社会主义核心价值观教育”、四川省教育厅副巡视员周雪峰以“我国职业教育改革的前景与困局”、中国青年报社官微运营室主任叶铁桥以“中国高职院校官微排行榜及高校官微运营策略”、 腾讯大成网副总编辑付强以“高校如何迎接95后的到来——中国青年研究报告”等主题，与参会人员进行了交流与分享。\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	图为分组讨论现场\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	同时，参会人员还以“全媒体时代，宣传工作如何创新”、“互联网青年有何特点，该如何服务”、“ 高职院校如何建立舆情应对机制”等互动话题，展开讨论。\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	(来稿:宣传统战部)\n</p>','0','','','',1419264000,NULL,0,'1',2,'0',NULL),(4,'',9,' 学院召开土木工程专业（道路与桥梁工程方向）高端技术技能型2014级本科班培养交流会','杨科',NULL,'','','<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;11月27日，学院副院长李全文带队，学工部、教务处、道路与桥梁工程系负责人、土木工程2013级1班学生代表一行十人到西南科技大学参加了2014级土木工程专业（道路与桥梁工程方向）高端技术技能型本科班培养交流会。西南科技大学土木工程与建筑学院有关负责人和2014级土木工程专业（道路与桥梁工程方向）高端技术技能型试点本科班的同学们参会。</span></span>\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;西南科技大学土木工程专业（道路与桥梁工程方向）高端技术技能型本科是我院与西南科技大学、四川公路桥梁建设集团有限公司，采取本科院校、国家示范高职院校和企业三方合作培养的方式，开展高端技术技能型本科人才培养改革的试点工作。该专业从2013年开始，今年第二届招生共计录取48名学生，培养模式仍然采用“1+2+1”的方式，即学生第一学年在西南科技大学学习专业基础理论知识，第二、三学年在我院道路与桥梁系学习专业理论知识和专业实践技能，第四学年到四川公路桥梁建设集团有限公司对口顶岗实习。通过四年的学习，获得西南科技大学颁发的毕业证书和学位证书以及相应的职业资格证书，进而成为“三证”在手的新型大学毕业生。</span></span>\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;</span></span><span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">交流会上，李全文介绍了2013级土木工程高职本科班的试点建设概况，对2014级同学表示热烈欢迎，希望2014级的同学们养成好的学习习惯，培育优良学风，掌握扎实的专业理论基础，同时刻苦训练，在专业技能方面狠下功夫，努力把自己培养成理论知识和专业技能都过硬的新型大学生。土木工程2013级学生代表给2014级的同学介绍了本学期在我院的学习、生活、实习情况，2014级的同学们也在会上就关注的问题与各方负责人进行了沟通交流。</span></span>\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;交流会让2014级土木工程高职本科试点班的同学们对专业建设、培养模式、学生管理、毕业去向、个人发展等关心的问题有了清楚明晰的认识，大家积极表示，明年回到我院后会加强专业知识、实践技能的学习，成为“会设计、强施工、善管理、后劲足”的高职本科毕业生。</span></span>\n</p>\n<p align=\"right\" style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">(来稿:道路与桥梁工程系)</span></span>\n</p>','0','','','',1419264000,NULL,0,'1',3,'0',NULL),(5,'',9,'我院2014年下半年英语级考工作顺利完成','杨科',NULL,'','','12月20日，随着全国大学生四、六级考试的圆满结束，我院2014年下半年英语等级考试全部顺利完成。<br />\n<br />\n&nbsp;本学期共有4614人次报考英语等级考试，其中二级564人，三级2758人，四级1183人，六级109人。从9月份开始，公共课教学部对各系学生进行宣传动员，按时完成考生报名、数据整理、修改和上报工作。根据省教育厅、省考试院相关要求，公共课教学部在考前组织了工作人员测试语音室听力设备、落实考场等后勤工作，组织相关人员培训，强调考试工作要点和操作规程，严格执行试卷保密制度，确保考试的顺利进行。正是有了考前的精心组织和周密安排，加上考试过程中的严格管理，考试已顺利完成。<br />\n<br />\n（来稿:公共课教学部）<br />','0','','','',1419350400,NULL,0,'1',4,'0',NULL),(6,'',4,'离退休党支部召开党员大会认真学习十八届四中全会精神','杨科',NULL,'','','<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">近日，我院离退休党支部召开全体党员大会，认真学习党的十八届四中全会精神。</span></span>\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;会议邀请了思政部徐文教授为全体离退休老党员作十八届四中全会专题辅导报告。徐文教授围绕《决定》具体内容进行了深入解读，引导老同志准确把握、深刻领会其科学内涵和精神实质。报告深入浅出，通俗易懂，受到老同志好评。</span></span>\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;会后，老党员们纷纷表示，要全面落实全会精神，发挥余热，身体力行，尽己所能，做更多对社会有意义的事情，做到“离职不离党、退休不褪色”，切实把思想和行动统一到全会精神上来，为依法治国实现“中国梦”做出应有的贡献。</span></span><span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;</span></span>\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;text-align:right;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">（来稿：离退休人员工作处）</span></span>\n</p>','0','','','',1419350400,NULL,0,'1',1,'0',NULL),(7,'',4,'暖冬行动 让爱延续','杨科',NULL,'','','<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;12月19日，汽车工程系、建筑工程系、信息工程系三系学生党支部在博学馆二楼多功能厅共同举办了暖冬行动公益募捐晚会，为贫困山区小朋友献爱心。</span></span>\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;晚会由回忆去年暖冬行动视频切入，通过街舞、民族舞、歌曲串烧、小品等形式多样、风采各异的节目形式赢得了观众的喝彩。小品《常回家看看》更以幽默的方式触动了在场同学的心。</span></span>\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;晚会结束前，汽车系学生党支部代表将募捐的整个流程做了详细的介绍，感谢来参加此次晚会的人员，感谢同学们纷纷献出自己的爱心，尽自己的绵薄之力，真心希望贫困山区小朋友的冬天能更加温暖，让小爱聚成大爱，让这个冬天不再寒冷。</span></span>\n</p>\n<p align=\"right\" style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">(来稿:汽车工程系)</span></span>\n</p>','0','','','',1419350400,NULL,0,'1',2,'0',NULL),(8,'',4,'情系贫困生 冬季送温暖','杨科',NULL,'','','<p style=\"text-indent:2em;\">\n	冬季来临，气温逐渐下降，家庭经济困难的同学在校生活状况，牵动着学院领导和老师的心。在这个寒冷的冬天，学院开展“暖冬活动”，为孤残学生、家庭经济困难学生、特困生发放困难补助并为他们送去一箱牛奶等慰问品，让我院609名家庭经济困难的同学感受到了学院的关怀和温暖。\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	图为学工部资助中心老师给同学们发放慰问品\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	活动开展以来，学生工作部的老师们经常会收到同学们悄悄放在办公桌上的感恩小卡片，他们用留言表达对学院的感谢，对老师们的祝福。同学们的感恩和懂事，也给从事学生工作的老师带来了感动和温暖。\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	在与勤工助学学生召开的座谈会上，学院资助管理中心的老师们给同学们提出了鼓励与建议：一是生活中要“坚持”，要相信困难都是暂时的，没有迈不过去的沟与坎；二是摆正心态，积极融入校园生活，乐观应对问题；三是提高学习效率，积极思考，多和老师、同学交流，找到适合自己的学习方法；四是做好职业生涯规划，确定目标，找准自己的人生方向。\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	在鼓励下同学们一改往日的羞涩，相互交流内心想法，有的同学说“一箱牛奶，收获的是学院的满满的温暖，这个冬天，我不再寒冷！”。他们纷纷对国家、学院的帮助表示感谢，表示将以积极、乐观的态度面对暂时的困难，用努力改变人生，回报社会。\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	（来稿:学生工作部）\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>','0','','','',1419350400,NULL,0,'1',3,'0',NULL),(9,'',4,'无社团、不大学','杨科',NULL,'','','<p style=\"text-indent:2em;\">\n	12月19日晚，学院社团联合会40个综合性社团在综合楼二楼报告厅，举行了第三届“文争武斗”社团联展。道路与桥梁工程系、建筑工程系、人文艺术系、运输工程系、航运工程系团总支及700余名师生现场观看了晚会，微博协会在新浪微博开通了全程转播，近500余名同学通过微博观看晚会并参与互动,当天微博阅读量达到89000多次。\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	社团联展是由学院团委社团联合会组织策划，向全院师生汇报本年社团活动开展情况，展现社团精神、风貌、特色，彰显我院大学生风采，进一步扩大我院综合性社团校内外知名度与影响力的汇报晚会。\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	晚会在“学院综合性社团风采”献礼视频之后，以劲爆的热舞《cry cry》开场，太极拳协会的太极拳表演展示出我国博大精深、兼收并蓄的传统文化；书画协会的《韵》带大家体会古典韵味；心语手语协会的手语表演《时间都去哪了》唤起了台下每一个观众的爱心；ADD街舞酷炫的舞蹈、话剧社的《放下你的鞭子》、跆拳道协会的跆拳道表演让观众感受到无限的青春与活力；武术、双节棍协会、羽毛球协会、吉他协会、魔术协会及晨曦微笑公社等都给现场观众带来了精彩的节目。\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	此次晚会不仅有本院各社团的精彩演出，也吸引了周边院校社联、学生会嘉宾的友情出演。\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	(来稿:学院团委)\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>','0','','','',1419350400,NULL,0,'1',4,'0',NULL),(10,'',4,'寒冬中为读者打造“温暖图书馆”','杨科',NULL,'','','<p style=\"text-indent:2em;\">\n	正值寒冬时节，期末考试也日益临近，为了给广大读者提供一个温暖的自习环境，我馆开展了一系列“温暖服务”，空调吹着暖风，出门走几步就能接到热水……。自活动开展以来，图书馆人气十足，早上刚开馆，同学们纷纷涌向温暖的阅览室埋头遨游在书海之中，整个阅览室从早到晚都座无虚席，广大学生纷纷表示图书馆是他们的第二课堂，“温暖图书馆”活动让他们感受到了学院的温暖。\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	我馆将持续推出更多“温暖服务”，也将进一步强化安全防范和文明阅读，着力营造一个更加温馨、舒适的读书环境，让读者们在愉快阅读的过程中，体验到图书馆、学院的温暖。\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	<br />\n</p>\n<p style=\"text-indent:2em;\">\n	(来稿:图书馆)\n</p>','0','','','',1419350400,NULL,0,'1',5,'0',NULL),(11,'',3,'《学生手册》动漫画活动圆满结束','杨科',NULL,'','','<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;12月8日下午，由学院党委宣传统战部主办、人文艺术系承办的《学生手册》动漫画活动决赛在人文艺术系系会议室正式举行。学院党委宣传统战部、教务处、人文艺术系相关老师，成都瓦克文化传播有限公司负责人参与了决赛作品的评选工作。</span></span>\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;《学生手册》动漫化活动旨在把学生手册中的规章制度以有趣有意义、幽默诙谐的动漫画形式展示出来，让同学们从轻松愉快的环境中学会学院管理制度、自觉遵守学院的规章制度。</span></span>\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;活动自2014年11月启动以来，共收到了漫画作品32件，动画作品18件，通过初选最终有漫画作品16件，动画作品10件进入了决赛。通过学生现场作品介绍和展示，由评委现场打分，最终动漫2012级2班刘力等同学的动画作品《交院生存法则》、动漫2014级1班王瑞雪、罗梅同学的漫画作品《剑三日常之学生手册》获得一等奖。</span></span>\n</p>\n<p align=\"right\" style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">（来稿:人文艺术系）</span></span>\n</p>','0','','','',1419350400,NULL,0,'1',1,'0',NULL),(12,'',3,'道路与桥梁工程系CAD制图大赛圆满结束','杨科',NULL,'','','<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;12月4日，由道路与桥梁工程系主办的第三届“心领神绘，潮起道桥”CAD制图大赛决赛在思行楼214机房顺利举办。</span></span>\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;从10月23日开赛以来，共有324名同学报名参加，通过初赛的选拔，评委会最终遴选出60名优秀参赛选手晋级决赛。此次大赛包括理论竞赛和实际操作竞赛两项内容，理论竞赛以闭卷笔试的方式进行，实际操作竞赛选手按照题目要求在电脑上完成作答和制图。通过激烈地比赛，最终产生获奖者15名，其中道路与桥梁专业徐淼、李葛、李洁三位同学获得一等奖。</span></span>\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;此次CAD制图大赛本着“服务道桥、服务社会”原则，旨在通过举办大赛，进一步调动学生学习的积极性，提高学生专业学习兴趣、动手能力，增强学生创新意识及技术应用能力，营造优良学风。</span></span>\n</p>\n<p align=\"right\" style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">(来稿:道路与桥梁工程系)</span></span>\n</p>','0','','','',1419350400,NULL,0,'1',2,'0',NULL),(13,'',3,'机电工程系举办学生干部座谈会','杨科',NULL,'','','<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;12月8日下午，机电工程系举行2014年学生干部座谈会。机电工程系党总支副书记、团总支书记、学生会干部代表、各班班长、团支部书记、学习委员共60余人参加了座谈会。</span></span>\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;会上，同学们围绕班级建设、团学活动、学生日常管理工作，学生组织、学生社团如何在人才培养方面发挥作用，如何通过“三自”教育锻炼能力、服务同学等议题，积极发言，畅谈自身感受、交流成功经验，为我系进一步做好学生工作提出了宝贵的意见和建议。机电工程系党总支副书记认真听取发言并不时与大家交流看法，充分肯定了学生干部在共青团工作、学生管理工作领域中所做的实践探索以及凝练的成功经验，认为学生干部代表提出了很多好的建议和意见，帮助我们开拓思路，更好地服务学生，希望大家要继续努力、不断进步，积极发挥团学组织的作用，精心设计好的活动，吸引更多地学生参与，锻炼自己、提高能力。为把我校建设成“特色鲜明、国际一流、人人成才、美丽和谐”的高职院校做出贡献。</span></span>\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">&nbsp;此次座谈会加深了学生干部之间的交流，有效地激发了学生干部的工作热情，促进了学生自我管理水平的提升。</span></span>\n</p>\n<p align=\"right\" style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-size:14px;\"><span style=\"font-family:arial, helvetica, sans-serif;\">(来稿:机电工程系)</span></span>\n</p>','0','','','',1419350400,NULL,0,'1',3,'0',NULL),(14,'',3,'道路与桥梁工程系2014年“迎新杯”篮球赛圆满落幕','杨科',NULL,'','','<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-family:仿宋_GB2312;font-size:16pt;\"><span style=\"background-color:#CCEDCF;\">&nbsp;</span><span style=\"font-family:Arial;font-size:14px;\">为全面贯彻“德智体美”全面发展精神，丰富</span><span style=\"font-family:Arial;color:windowtext;font-size:14px;\">同学</span><span style=\"font-family:Arial;font-size:14px;\">课余生活，增强同学身体素质，我系于近期举办了</span><span style=\"font-family:Arial;font-size:14px;\">2014</span><span style=\"font-family:Arial;font-size:14px;\">年“迎新杯”篮球赛，来自我系</span><span style=\"font-family:Arial;font-size:14px;\">2013</span><span style=\"font-family:Arial;font-size:14px;\">级、</span><span style=\"font-family:Arial;font-size:14px;\">2014</span><span style=\"font-family:Arial;font-size:14px;\">级的</span><span style=\"font-family:Arial;font-size:14px;\">39</span><span style=\"font-family:Arial;font-size:14px;\">支班级篮球队参加了此次比赛。</span></span>\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	&nbsp;\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-family:Arial;font-size:14px;\">&nbsp;</span><span style=\"font-family:仿宋_GB2312;font-size:16pt;\"><span style=\"font-family:Arial;font-size:14px;\">此次“迎新杯”篮球赛历时两个月，经过两轮约战，</span><span style=\"font-family:Arial;font-size:14px;\">70</span><span style=\"font-family:Arial;font-size:14px;\">余场激烈对决，</span><span style=\"font-family:Arial;font-size:14px;\">12</span><span style=\"font-family:Arial;font-size:14px;\">月</span><span style=\"font-family:Arial;font-size:14px;\">5</span><span style=\"font-family:Arial;font-size:14px;\">日中午，</span><span style=\"font-family:Arial;font-size:14px;\">2014</span><span style=\"font-family:Arial;font-size:14px;\">年“迎新杯”篮球赛冠、亚军争夺赛落下帷幕，监理</span><span style=\"font-family:Arial;font-size:14px;\">2013</span><span style=\"font-family:Arial;font-size:14px;\">级</span><span style=\"font-family:Arial;font-size:14px;\">2</span><span style=\"font-family:Arial;font-size:14px;\">班篮球队、道桥</span><span style=\"font-family:Arial;font-size:14px;\">2013</span><span style=\"font-family:Arial;font-size:14px;\">级</span><span style=\"font-family:Arial;font-size:14px;\">4</span><span style=\"font-family:Arial;font-size:14px;\">班篮球队分别荣获冠、亚军。同学们在比赛中表现出的“自强不息，勇争第一”精神，充分展现了我系学生的青春活力和昂扬向上的精神风貌，同时为广大爱好篮球的同学们提供了展示和交流的平台，增强了同学们的集体荣誉感，增进各班之间的友谊。</span></span>\n</p>\n<p align=\"right\" style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-family:Arial;font-size:14px;\">(</span><span style=\"font-family:仿宋_GB2312;font-size:16pt;\"><span style=\"font-family:Arial;font-size:14px;\">来稿</span><span style=\"font-family:Arial;font-size:14px;\">:</span><span style=\"font-family:Arial;font-size:14px;\">道路与桥梁工程系</span><span style=\"font-family:Arial;font-size:14px;\">)</span></span><span style=\"font-size:12pt;\"></span>\n</p>\n<div>\n	<br />\n</div>','0','','','',1419350400,NULL,0,'1',4,'0',NULL),(15,'',3,'信息工程系开展2014级新生素质拓展训练','杨科',NULL,'','','<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-family:仿宋_GB2312;font-size:16pt;\"><span style=\"font-family:Arial;font-size:14px;\">&nbsp;近日，信息工程系开展了</span><span style=\"font-family:Arial;font-size:14px;\">2014</span><span style=\"font-family:Arial;font-size:14px;\">级新生素质拓展训练，旨在通过训练，培养学生团队协作精神、增强其集体荣誉感。</span></span>\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-family:仿宋_GB2312;font-size:16pt;\"></span><span style=\"font-family:仿宋_GB2312;font-size:16pt;\"><span style=\"font-family:Arial;font-size:14px;\">&nbsp;</span><span style=\"font-family:Arial;font-size:14px;\">160</span></span><span style=\"font-family:仿宋_GB2312;font-size:16pt;\"><span style=\"font-family:Arial;font-size:14px;\">位同学参加了在此次训练，训练内容包含破冰、驿站传书、竞速</span><span style=\"font-family:Arial;font-size:14px;\">90</span><span style=\"font-family:Arial;font-size:14px;\">秒等，同学们精神饱满、积极配合、充满活力。</span></span>\n</p>\n<p style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-family:Arial;font-size:14px;\">&nbsp;</span><span style=\"font-family:仿宋_GB2312;font-size:16pt;\"><span style=\"font-family:Arial;font-size:14px;\">近年来，信息工程系重视学生团队协作能力、乐于奉献精神的培养，大力发展志愿者服务队伍的建设，多次开展校园卫生清理等志愿者活动，得到多方关注、取得了良好的反响。</span></span>\n</p>\n<p align=\"right\" style=\"color:#161718;font-family:宋体;text-indent:24px;background-color:#FFFFFF;\">\n	<span style=\"font-family:Arial;font-size:14px;\">(来稿：</span><span style=\"font-family:仿宋_GB2312;font-size:16pt;\"><span style=\"font-family:Arial;font-size:14px;\">信息工程系</span><span style=\"font-family:Arial;font-size:14px;\">)</span></span>\n</p>','0','','','',1419350400,NULL,0,'1',5,'0',NULL);
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_category`
--

DROP TABLE IF EXISTS `news_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `describle` varchar(200) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `is_delete` char(1) NOT NULL DEFAULT '0',
  `alias` varchar(50) NOT NULL,
  `pic_src` varchar(500) NOT NULL,
  `grade` int(11) DEFAULT NULL,
  `type` char(30) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `fid` int(11) NOT NULL DEFAULT '0',
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_category`
--

LOCK TABLES `news_category` WRITE;
/*!40000 ALTER TABLE `news_category` DISABLE KEYS */;
INSERT INTO `news_category` VALUES (1,'近期要闻','',1419344880,'0','jqxw','',NULL,NULL,NULL,0,NULL),(2,'媒体交院','',1419344906,'0','mtjy','',NULL,NULL,NULL,0,NULL),(3,'聚焦热点','',1419344922,'0','jjrd','',NULL,NULL,NULL,0,NULL),(4,'系部动态','',1419344944,'0','xbdt','',NULL,NULL,NULL,0,NULL),(5,'专题新闻','',1419344967,'0','ztxw','',NULL,NULL,NULL,0,NULL),(6,'视频展播','',1419344992,'0','spzb','',NULL,NULL,NULL,0,NULL),(7,'观影交院','',1419345012,'0','gyjy','',NULL,NULL,NULL,0,NULL),(8,'图片新闻','',1419345029,'0','tpxw','',NULL,NULL,NULL,0,NULL),(9,'学院新闻','',1419345092,'0','xyxw','',NULL,NULL,NULL,0,NULL);
/*!40000 ALTER TABLE `news_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `introl` text,
  `summary` varchar(400) NOT NULL DEFAULT '',
  `pic_src` varchar(200) NOT NULL DEFAULT '',
  `graduate_time` int(10) unsigned NOT NULL DEFAULT '0',
  `profession` varchar(40) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `is_delete` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (1,'杨科','杨科的简历','杨科','杨科',0,'杨科',0,'1'),(2,'忆江南-怎不忆江南','杨科的照片是这样的杨科的照片是这样的杨科的照片是这样的杨科的照片是这样的杨科的照片是这样的','杨科的照片是这样的杨科的照片是这样的杨科的照片是这样的v','杨科的照片是这样的',2012,'爱的色放',1412391810,'0'),(3,'杨科','请叫我杨科请叫我杨科请叫我杨科','请叫我杨科','请叫我杨科',0,'请叫我杨科',1412647331,'0');
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teacher`
--

DROP TABLE IF EXISTS `teacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teacher` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `introl` text,
  `summary` varchar(400) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `is_delete` char(1) NOT NULL DEFAULT '0',
  `edit_time` int(11) NOT NULL,
  `pic_src` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher`
--

LOCK TABLES `teacher` WRITE;
/*!40000 ALTER TABLE `teacher` DISABLE KEYS */;
INSERT INTO `teacher` VALUES (1,'曾浩然','教师介绍详细介绍<span>教师介绍详细介绍<span>教师介绍详细介绍<span>教师介绍详细介绍<span>教师介绍详细介绍<span>教师介绍详细介绍<span>教师介绍详细介绍<span>教师介绍详细介绍<span>教师介绍详细介绍<span>教师介绍详细介绍<span>教师介绍详细介绍<span>教师介绍详细介绍<span>教师介绍详细介绍<span>教师介绍详细介绍</span></span></span></span></span></span></span></span></span></span></span></span></span>','教师介绍',1414041999,'0',0,'/source/editor/attached/image/20141023/20141023052622_62879.jpg'),(2,'邓溱','简介简介简介简介简介简介简介简介简介简介简介简介简介简介','简介',1414046809,'0',0,'/source/editor/attached/image/20141023/20141023064638_60924.jpg'),(3,'asdf','0','adsfasdf',1414301102,'0',0,'adsfasdf');
/*!40000 ALTER TABLE `teacher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL DEFAULT '',
  `name` varchar(40) NOT NULL DEFAULT '',
  `password` varchar(200) NOT NULL DEFAULT '',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login_ip` char(40) NOT NULL DEFAULT '0',
  `last_attempt_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `password` (`password`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'ykjver@163.com','杨科','22ff5c131bdeda4adddd1703656092f3',0,'0',0),(2,'atob','atob','247dacdd00857f460cf1bb63233c78f0',0,'0',0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-12-25  1:45:40
