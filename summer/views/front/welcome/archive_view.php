<?php defined('APPPATH') or exit('no access'); ?>
<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<title><?php echo isset($title) ? $title : '' ?>交院新闻网</title>
	<link rel="stylesheet" href="<?php echo static_url('css/h/style.css') ?>">
	<script src="<?php echo static_url('js/h/jquery-1.8.3.min.js') ?>"></script>
</head>
<body>
<div class="header ">
	<div class="wrap clearfix">
		<h1 class="logo"><a href="<?php echo site_url() ?>"><img src="<?php echo static_url('/images/h/logo.jpg') ?>" alt="新闻网logo"/></a></h1>
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
	                    <a href="<?php echo archive_url($v['id'], $v['category_id']) ?>"><?php echo $v['title'] ?></a>
                	</dt>
            </dl>
            <?php }else{ ?>
                <?php if($i === 3) { ?>
                    <ul class="indbase_list indbase_list1 ">
                <?php } ?>

                <li>
                    <a href="<?php echo archive_url($v['id'], $v['category_id']) ?>" class="clearfix">
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
            <div class="baselistTit_location">您当前的位置：<?php echo $bread_path ?></div>
        </div>
           <div class="particular noMargin">
               <h2 class="noBorder"><?php echo $article['title'] ?></h2>
               <div class="particular_wrap">
	               <span class="art_source">来源：本站原创</span>  
	               <span class="art_author">作者：<?php echo $article['author_name'] ?></span> 
	               <span class="art_view">阅读：<?php echo $article['hits'] ?> </span> 
	               <span class="art_publish">发布：<?php echo substr($article['publish_date'], 0, 10) ?></span>
	            </div>
           </div>
           <div class="art_summary">
                <span class="zy">摘要：</span><?php echo $article['summary'] ?>
            </div>
           <div class="atr_con">
               <?php echo $article['content'] ?>
           </div>
           <div class="newsMore clearfix">
               <p class="pagingP clearfix">
                    <?php echo $prev_article ?>                    
                    <?php echo $next_article ?>
               </p>
               <div class="bdsharebuttonbox shareAtticle clearfix bdshare-button-style0-16" data-bd-bind="1471754517465">
                   <a class="bds_more" data-cmd="more">分享到：</a>
                   <a class="bds_qzone" data-cmd="qzone" title="分享到QQ空间">QQ空间</a>
                   <a class="bds_tsina" data-cmd="tsina" title="分享到新浪微博">新浪微博</a>
                   <a class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博">腾讯微博</a>
                   <a class="bds_weixin" data-cmd="weixin" title="分享到微信">微信</a>
                   <a class="bds_sqq" data-cmd="sqq" title="分享到QQ好友">QQ好友</a>
               </div>
           </div>
        </div>
    </div>
  </body>

<?php require 'footer_view.php'; ?>
<script>
    window._bd_share_config = {
        "common": {
            "bdSnsKey": {},
            "bdText": "",
            "bdMini": "2",
            "bdMiniList": false,
            "bdPic": "",
            "bdStyle": "0",
            "bdSize": "16"
        }, "share": {}
    };
    with (document)0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];

</script>
</body>
</html>