<?php

defined('APPPATH') || exit('no access');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($title) ? $title : '' ?>四川交院新闻网</title>
    <link rel="stylesheet" href="<?php echo static_url('css/h/style.css') ?>?q=121212">
    <script src="<?php echo static_url('js/h/jquery-1.8.3.min.js') ?>"></script>
</head>
<body>
<div class="header ">
	<div class="wrap clearfix">
		<h1 class="logo"><a href="javascript:;"><img src="<?php echo static_url('/images/h/logo.jpg') ?>" alt="新闻网logo"></a></h1>
		<p class="site-name">新闻网</p>
	</div>
</div>
<div class="nav">
	<ul class="nav-list wrap clearfix">
    <?php foreach($navs as $v) { ?>
        <li class="nav-li"><a href="<?php echo $v['href'] ?>"><?php echo $v['label'] ?></a></li>
    <?php } ?>
	</ul>
</div>
<div class="main padtb20 wrap clearfix">
	<div class="list_left fl">
		<div class="fl getHeightLeft">
		   <div class="news-tit">
   				<h3 class="news-tit-name">一周热点</h3>
   				<a class="news-more" href="javascript:;">更多</a>
   			</div>
            <?php $i=-1; foreach($week_hot as $v) {$i++; ?>
            <?php if($i < 3){ ?>
   			<dl class="news_hot clearfix">
           			<dd class="news_hot_dd<?php echo $i ?>">
                    	<b>0<?php echo $i + 1 ?></b>
                	</dd>
                    <dt>
	                    <a href="<?php echo  archive_url($v)?>"><?php echo $v['title'] ?></a>
                	</dt>
            </dl>
            <?php }else{ ?>
                <?php if($i === 3) { ?>
                    <ul class="indbase_list indbase_list1 ">
                <?php } ?>

                <li>
                    <a href="<?php echo $archive_url($v) ?>" class="clearfix">
                        <span class="fl indbase_tit"><?php echo $v['title'] ?></span>
                    </a>
                </li>
            <?php }} ?>
	        </ul>
		</div>
		<div class="fl getHeightLeft getHeightLeft_top" >
   		   <div class="news-tit">
  				<h3 class="news-tit-name">文章存档</h3>
  				<a class="news-more" href="javascript:;">更多</a>
  			</div>
  			<ul class="article_list clearfix">
            <?php echo $date_archive_html ?>
			</ul>
		</div>
	</div>
    
    <div class="baselist fr getHeightRight">
        <div class="baselistTit clearfix">
            <div class="baselistTit_location">您当前的位置： <?php echo $bread_path ?></div>
        </div>
        <ul class="baselist_ul clearfix">
            <?php foreach($articles as $v) { ?>
            <li>
                <a class="fl" href="<?php echo archive_url($v) ?>"><?php echo $v['title'] ?></a>
                <span class="fr"><?php echo substr($v['publish_date'], 0, 11) ?></span>
            </li>
            <?php } ?>
        </ul>
        <p class="basePage">
            <?php echo $pager ?>
        </p>
    </div>
</div>	
<div class="footer">
	<div class="wrap">
		<p class="footer-top clearfix">
			<span class="footer-p fl">Copyright © 2013 SVTCC.EDU.CN(建议采用IE7.0及以上版本浏览器)</span>
			<span class="footer-p fr">联系我们：QQ:1206550156</span>
		</p>
		<p class="footer-bottom clearfix">
			<span class="footer-p fl">地址：四川省成都市温江区柳台大道东段208号 <i>邮编：611130</i></span>
			<span class="footer-p fr">Email：QQ:1206550156@qq.com</span>
		</p>
	</div>
</div>
</body>
</html>