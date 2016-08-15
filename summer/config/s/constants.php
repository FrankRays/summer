<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//通用 common
defined('YES') 	OR define('YES', 1);
defined('NO')	OR define('NO', 0);
//时间格式通用
defined('TIME_FORMAT') OR define('TIME_FORMAT', 'Y-m-d H:i:s');
defined('DATE_FORMAT') OR define('DATE_FORMAT', 'Y-m-d');


//aritlce type constants 标志位
defined('ARTICLE_TYPE_INDEX') OR define('ARTICLE_TYPE_INDEX', 0);
defined('ARTICLE_TYPE_LOCAL') OR define('ARTICLE_TYPE_LOCAL', 1);

//文章状态 status 
defined('ARTICLE_STATUS_DRUFT')		OR define('ARTICLE_STATUS_DRUFT', 0);
defined('ARTICLE_STATUS_PUBLIC') 	OR define('ARTICLE_STATUS_PUBLIC', 1);

//首页www文章文章 index article category name
//学院新闻
defined('INDEX_CNAME_COLLEGE_NEWS') OR define('INDEX_CNAME_COLLEGE_NEWS', '学院新闻');
defined('INDEX_CNAME_DEPART_NEWS') 	OR define('INDEX_CNAME_DEPART_NEWS', '系部动态');
defined('INDEX_CNAME_NOTATION')		OR define('INDEX_CNAME_NOTATION', '通知公告');

//index article category id
defined('INDEX_CID_COLLEGE_NEWS') 	OR define('INDEX_CID_COLLEGE_NEWS', 11);
defined('INDEX_CID_DEPART_NEWS') 	OR define('INDEX_CID_DEPART_NEWS', 16);
defined('INDEX_CID_NOTATION') 		OR define('INDEX_CID_NOTATION', 12);

//管理员基本类型
defined('ADMIN_NO') 				OR define('ADMIN_NO', 'no');
defined('ADMIN_COMMON')				OR define('ADMIN_COMMON', 'common');
defined('ADMIN_SUPER')				OR define('ADMIN_SUPER', 'super');


//表名称
defined('TABLE_USER')				OR define('TABLE_USER', 'summer_user');
defined('TABLE_FILE')				OR define('TABLE_FILE', 'summer_file');
defined('TABLE_SITE')				OR define('TABLE_SITE', 'summer_site');
defined('TABLE_NAV')				OR define('TABLE_NAV', 'summer_nav');
defined('TABLE_NAV_CAT')			OR define('TABLE_NAV_CAT', 'summer_nav_cat');
defined('TABLE_ARTICLE_CAT')		OR define('TABLE_ARTICLE_CAT', 'summer_article_category');
defined('TABLE_ARTICLE')			OR define('TABLE_ARTICLE', 'summer_article');
defined('TABLE_ARTICLE_LOVE')		OR define('TABLE_ARTICLE_LOVE', 'summer_article_love');
defined('TABLE_SLIDER')				OR define('TABLE_SLIDER', 'summer_slider');