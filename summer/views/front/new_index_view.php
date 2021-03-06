<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<title>交院-新闻网</title>
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
<div class="content wrap">
	<div class="section clearfix">
		<div class="news-recent ma-r10">
			<div class="news-tit">
				<h3 class="news-tit-name">近期要闻</h3>
				<a class="news-more" href="<?php echo site_url('/collegenews') ?>">更多</a>
			</div>
			<div class="news-re-con clearfix">
				<div class="f_scroll fl">
					<ul>

					<?php foreach($sliders as $v) { ?>
			            <li>
			                <a href="<?php echo $v['href'] ?>" class="fscroll_link"><img src="<?php echo resource_url($v['img_path']) ?>" onerror="errorImg(this);" alt="">
			                	<span class="fscroll_tit"><?php echo $v['title'] ?></span>
			                </a>
			            </li> 
					<?php } ?>
		            </ul>
				</div>
				<div class="news-re-article fr">
				<?php foreach($college_news_top as $v) { ?>
					<div class="indnews_news">
                        <a class="indnews_bt" href="<?php echo archive_url($v['id'], $v['category_id']) ?>"><?php echo $v['title'] ?></a>
                        <p class="indnews_p"><?php echo sub_text_mb($v['summary'], 50) ?><a href="<?php echo archive_url($v['id'], $v['category_id']) ?>">[查看全文]</a></p>
                    </div>
                 <?php } ?>
                    <ul class="indbaselist clearfix">

                    <?php foreach($college_news as $v) { ?>
                        <li>
                            <a href="<?php echo archive_url($v['id'], $v['category_id']) ?>">
                                <span class="fl indbase_tit"><?php echo $v['title'] ?></span>
                                <span class="fr"><?php echo $v['publish_date'] ?></span>
                            </a>
                        </li>
                    <?php } ?>
                    </ul>
				</div>
			</div>
		</div>
		<div class="new-indnotice bo-no">
			<div class="news-tit bo-tit">
				<h3 class="news-tit-name">通知公告</h3>
				<a class="news-more" href="<?php echo site_url('notice') ?>">更多</a>
			</div>
			<ul class="indnotice_cont">
				<?php foreach($notice as $v) { ?>
	            <li><a href="<?php echo archive_url($v['id'], $v['category_id']) ?>"><?php echo $v['title'] ?></a></li>
	            <?php } ?>
	        </ul>
	        <div class="indno_btn clearfix">
	        	<a href="http://www.svtcc.edu.cn" target="blank" title="学院首页" class="indnotice_btn indnotice_btn01"></a>
	        	<a href="javascript:;" class="indnotice_btn indnotice_btn02"></a>
	        	<a href="javascript:;" class="indnotice_btn indnotice_btn03"></a>
	        	<a href="javascript:;" class="indnotice_btn indnotice_btn04"></a>
	        </div>
		</div>
	</div>
	<div class="section indarticle clearfix h454">
        <!--系部动态 S-->
        <div class="indart_item fl w370">
            <p class="indbase_tit02">系部动态</p>
            <div class="indbase_artcont w368">
            <?php foreach($departnotice_top as $v) { ?>
                <div class="indbase_art clearfix w348">
                    <a href="<?php echo archive_url($v['id'], $v['category_id']) ?>" class="fl">
                    <img src="<?php echo resource_url($v['coverimg_path']) ?>"></a>
                    <div class="mt5 fr">
                        <a href="javascript:;" class="indbase_artT"><?php echo $v['title'] ?></a>
                        <p class="indbase_artP">
                            <?php echo sub_text_mb($v['summary'], 40) ?><a href="<?php echo archive_url($v['id'], $v['category_id']) ?>">[查看全文]</a>
                        </p>
                    </div>
                </div>
            <?php } ?>
                <div class="w348 padlr10">
                    <ul class="indbase_list h225">
                    <?php foreach($departnotice as $v) { ?>
                        <li>
                        	<a href="<?php echo archive_url($v['id'], $v['category_id']) ?>" class="clearfix">
                        		<span class="fl indbase_tit"><?php echo $v['title'] ?></span>
                        		<span class="fr"><?php echo $v['publish_date'] ?></span>
                        	</a>
                        </li>
                    <?php } ?>
                    </ul>
                    <a class="indmore lh41" href="<?php echo site_url('l/departnotice') ?>">查看更多信息</a>
                </div>
            </div>
        </div>
        <!--系部动态 E-->
        <!--聚焦热点 S-->
        <div class="indart_item fl w370">
            <p class="indbase_tit02">聚焦热点</p>
			<div class="indbase_artcont w368">
			<?php foreach($focushot_top as $v) { ?>
			    <div class="indbase_art clearfix w348">
			        <a href="<?php echo archive_url($v['id'], $v['category_id']) ?>" class="fl">
			        <img src="<?php echo resource_url($v['coverimg_path']) ?>"></a>
			        <div class="mt5 fr">
			            <a href="javascript:;" class="indbase_artT"><?php echo $v['title'] ?></a>
			            <p class="indbase_artP">
			                <?php echo sub_text_mb($v['summary'], 40) ?>
			                <a href="<?php echo archive_url($v['id'], $v['category_id']) ?>">[查看全文]</a>
			            </p>
			        </div>
			    </div>
			<?php } ?>
			    <div class="w348 padlr10">
			        <ul class="indbase_list h225">
                    <?php foreach($focushot as $v) { ?>
                        <li>
                        	<a href="<?php echo archive_url($v['id'], $v['category_id']) ?>" class="clearfix">
                        		<span class="fl indbase_tit"><?php echo $v['title'] ?></span>
                        		<span class="fr"><?php echo $v['publish_date'] ?></span>
                        	</a>
                        </li>
                    <?php } ?>
			        </ul>
			        <a class="indmore lh41" href="<?php echo site_url('l/focushot') ?>">查看更多信息</a>
			    </div>
			</div>
        </div>
        <!--聚焦热点 E-->
        <!--媒体交院 S-->
        <div class="indart_item fl w370 last">
            <p class="indbase_tit02">耕读交院</p>
			<div class="indbase_artcont w368">
			<?php foreach($read_top as $v) { ?>
			    <div class="indbase_art clearfix w348">
			        <a href="<?php echo archive_url($v['id'], $v['category_id']) ?>" class="fl">
			        <img src="<?php echo resource_url($v['coverimg_path']) ?>"></a>
			        <div class="mt5 fr">
			            <a href="javascript:;" class="indbase_artT"><?php echo $v['title'] ?></a>
			            <p class="indbase_artP">
			                <?php echo sub_text_mb($v['summary'], 40) ?>
			                <a href="<?php echo archive_url($v['id'], $v['category_id']) ?>">[查看全文]</a>
			            </p>
			        </div>
			    </div>
			<?php } ?>
			    <div class="w348 padlr10">
			        <ul class="indbase_list h225">
                    <?php foreach($read as $v) { ?>
                        <li>
                        	<a href="<?php echo archive_url($v['id'], $v['category_id']) ?>" class="clearfix">
                        		<span class="fl indbase_tit"><?php echo $v['title'] ?></span>
                        		<span class="fr"><?php echo $v['publish_date'] ?></span>
                        	</a>
                        </li>
                    <?php } ?>
			        </ul>
			        <a class="indmore lh41" href="<?php echo site_url('l/read') ?>">查看更多信息</a>
			    </div>
			</div>
        </div>
        <!--媒体交院 E-->
    </div>	
    <div class="section clearfix">
    	<div class="w567 fl">
    		<div class="news-tit bo-tit">
    			<ul class="news-tab fl clearfix" id="newTab1">
    				<li class="news-tab-li curr"><a href="<?php echo site_url('l/photo') ?>">图说交院</a></li>
    				<li class="news-tab-li"><a href="javascript:;">写意交院</a></li>
    			</ul>
    			<a class="news-more" href="javascript:;">更多</a>
    		</div>
    		<div class="dt_wrap" id="dt_wrap1">
    			<ul class="dt-list-wrap clearfix">
    			<?php $i=-1; foreach($photo as $v) {$i++; ?>
    				<li class="dt-li dt-li<?php echo $i ?>">
	    				<div class="mask_wrp">
		    				<img src="<?php echo resource_url($v['coverimg_path']) ?>" alt="<?php echo $v['title'] ?>">
		    				<a href="<?php echo archive_url($v['id'], $v['category_id']) ?>" class="mask_04"></a>
	    				</div>
	    				<a href="<?php echo archive_url($v['id'], $v['category_id']) ?>" class="dt-li-txt">
	    				<?php echo $v['title'] ?>
	    				</a>
    				</li>
    			<?php } ?>
    			</ul>
    			<ul class="dt-list-wrap clearfix none">
    				<li class="dt-li dt-li0">
	    				<div class="mask_wrp">
		    				<img src="./images/upload/sc0.jpg" alt="">
		    				<a href="javascript:;" class="mask_04"></a>
	    				</div>
	    				<a href="javascript:;" class="dt-li-txt">四川交通职业学院延时拍摄2222</a>
    				</li>
    				<li class="dt-li dt-li1">
	    				<div class="mask_wrp">
		    				<img src="./images/upload/sc0.jpg" alt="">
		    				<a href="javascript:;" class="mask_04"></a>
	    				</div>
	    				<a href="javascript:;" class="dt-li-txt">四川交通2222</a>
    				</li>
    				<li class="dt-li dt-li2">
	    				<div class="mask_wrp">
		    				<img src="./images/upload/sc0.jpg" alt="">
		    				<a href="javascript:;" class="mask_04"></a>
	    				</div>
	    				<a href="javascript:;" class="dt-li-txt">教学楼里22222</a>
    				</li>		    				</li>
    			</ul>		    			</ul>
    		</div>
    	</div>
    	<div class="w567 ts_wrap fr">
    		<div class="news-tit bo-tit">
    			<ul class="news-tab fl clearfix" id="newTab2">
    				<li class="news-tab-li curr"><a href="javascript:;">影像交院</a></li>
    				<li class="news-tab-li"><a href="javascript:;">微电台</a></li>
    			</ul>
    			<a class="news-more" href="javascript:;">更多</a>
    		</div>
			<div class="dt_wrap" id="dt_wrap2">
				<ul class="dt-list-wrap clearfix">
					<li class="dt-li dt-li0">
	    				<div class="mask_wrp">
		    				<img src="./images/upload/g0.jpg" alt="">
		    				<a href="javascript:;" class="mask_04"></a>
	    				</div>
	    				<a href="javascript:;" class="dt-li-txt">四川交通职业学院延时拍摄1</a>
					</li>
					<li class="dt-li dt-li1">
	    				<div class="mask_wrp">
		    				<img src="./images/upload/g1.jpg" alt="">
		    				<a href="javascript:;" class="mask_04"></a>
	    				</div>
	    				<a href="javascript:;" class="dt-li-txt">无军训，不大学111</a>
					</li>
					<li class="dt-li dt-li2">
	    				<div class="mask_wrp">
		    				<img src="./images/upload/g2.jpg" alt="">
		    				<a href="javascript:;" class="mask_04"></a>
	    				</div>
	    				<a href="javascript:;" class="dt-li-txt">花絮111</a>
					</li>
				</ul>
				<ul class="dt-list-wrap clearfix none">
					<li class="dt-li dt-li0">
	    				<div class="mask_wrp">
		    				<img src="./images/upload/g0.jpg" alt="">
		    				<a href="javascript:;" class="mask_04"></a>
	    				</div>
	    				<a href="javascript:;" class="dt-li-txt">四川交通职业学院延时拍摄2</a>
					</li>
					<li class="dt-li dt-li1">
	    				<div class="mask_wrp">
		    				<img src="./images/upload/g1.jpg" alt="">
		    				<a href="javascript:;" class="mask_04"></a>
	    				</div>
	    				<a href="javascript:;" class="dt-li-txt">无军训，不大学222</a>
					</li>
					<li class="dt-li dt-li2">
	    				<div class="mask_wrp">
		    				<img src="./images/upload/g2.jpg" alt="">
		    				<a href="javascript:;" class="mask_04"></a>
	    				</div>
	    				<a href="javascript:;" class="dt-li-txt">花絮222</a>
					</li>
				</ul>
			</div>
    	</div>
    </div>
    <div class="section mb20">
    	<div class="new-pic">
	    	<div class="news-tit">
	    		<h3 class="news-tit-name">光影交院</h3>
	    		<a class="news-more" href="<?php echo site_url('l/photolight') ?>">更多</a>
	    	</div>
	    	<div class="s-pic-wrap s_scroll">
	    		<div class="btn btn_l btn_left">&lt;</div>
	    		<div class="btn btn_r btn_right">&gt;</div>
	    		<div class="s-pic-con">
		    		<ul class="s-pic-list clearfix">
		    		<?php foreach($photolight as $v) { ?>
		    			<li class="s-pic-li">
		    				<div class="mask_wrp s-picli-wrap">
			    				<img src="<?php echo resource_url($v['coverimg_path']) ?>" alt="">
			    				<a href="<?php echo archive_url($v['id'], $v['category_id']) ?>" class="s-pic-tit">
			    				<?php echo $v['title'] ?></a>
		    				</div>
		    			</li>
		    		<?php } ?>
		    		</ul>
	    		</div>
	    	</div>
    	</div>
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
<script src="<?php echo static_url('js/h/scroll.js') ?>"></script>
<script src="<?php echo static_url('js/h/main.js') ?>"></script>
<script type="text/javascript">
	$(function(){
			//近期要闻
		   $('.f_scroll').daqScroll({
		       direction : "left",
		       timeout : 5000,
		       width : 420,
		       height : 320,
		       autoSlider : true,
		       showBtn : true
		   });

		   $('.s-pic-con').hScroll({
		   	   direction : "left",
		       timeout : 3000,
		       autoSlider : true
		   });

	})
</script>
</body>
</html>