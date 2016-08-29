<?php defined('APPPATH') or exit("no access"); ?>
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
				<a class="news-more" href="<?php echo site_url('l/collegenews') ?>">更多</a>
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
                                <span class="fr"><?php echo substr($v['publish_date'], 0, 10) ?></span>
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
				<a class="news-more" href="<?php echo site_url('l/notice') ?>">更多</a>
			</div>
			<ul class="indnotice_cont">
				<?php foreach($notice as $v) { ?>
	            <li><a href="<?php echo archive_url($v['id'], $v['category_id']) ?>"><?php echo $v['title'] ?></a></li>
	            <?php } ?>
	        </ul>
	        <div class="indno_btn clearfix">
	        	<a target="blank" href="http://www.svtcc.edu.cn/" class="indnotice_btn indnotice_btn01"></a>
	        	<a target="blank" href="http://scjyyb.svtcc.edu.cn/" class="indnotice_btn indnotice_btn02"></a>
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
                        		<span class="fr"><?php echo substr($v['publish_date'], 0, 10)  ?></span>
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
                        		<span class="fr"><?php echo substr($v['publish_date'], 0, 10)  ?></span>
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
                        		<span class="fr"><?php echo substr($v['publish_date'], 0, 10)  ?></span>
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
    				<li class="news-tab-li curr"><a href="javascript:;">图说交院</a></li>
    				<li class="news-tab-li"><a href="javascript:;">写意交院</a></li>
    			</ul>
    			<a class="news-more" href="<?php echo site_url('l/photo') ?>">更多</a>
    		</div>
    		<div class="dt_wrap" id="dt_wrap1">
    			<ul class="dt-list-wrap clearfix">
    			<?php $i=-1; foreach($photo as $v) {$i++; ?>
    				<li class="dt-li dt-li<?php echo $i ?>">
	    				<div class="mask_wrp">
		    				<img src="<?php echo resource_url($v['coverimg_path']) ?>" alt="<?php echo $v['title'] ?>">
		    				<a  target="blank" href="<?php echo site_url('photo_archive/' . $v['id']) ?>" class="mask_04"></a>
	    				</div>
	    				<a  target="blank" href="<?php echo site_url('photo_archive/' . $v['id']) ?>"  class="dt-li-txt">
	    				<?php echo $v['title'] ?>
	    				</a>
    				</li>
    			<?php } ?>
    			</ul>
    			<ul class="dt-list-wrap clearfix none">
    			<?php $i=-1; foreach($reading as $v) {$i++; ?>
    				<li class="dt-li dt-li<?php echo $i ?>">
	    				<div class="mask_wrp">
		    				<img src="<?php echo resource_url($v['coverimg_path']) ?>" alt="<?php echo $v['title'] ?>">
		    				<a  target="blank" href="<?php echo site_url('photo_archive/' . $v['id']) ?>"  class="mask_04"></a>
	    				</div>
	    				<a  target="blank" href="<?php echo site_url('photo_archive/' . $v['id']) ?>"  class="dt-li-txt">
	    				<?php echo $v['title'] ?>
	    				</a>
    				</li>
    			<?php } ?>
    			</ul>
    		</div>
    	</div>
    	<div class="w567 ts_wrap fr">
    		<div class="news-tit bo-tit">
    			<ul class="news-tab fl clearfix" id="newTab2">
    				<li class="news-tab-li curr"><a href="javascript:;">影像交院</a></li>
    				<li class="news-tab-li"><a href="javascript:;">微电台</a></li>
    			</ul>
    			<a class="news-more" href="<?php echo site_url('l/video') ?>">更多</a>
    		</div>
			<div class="dt_wrap" id="dt_wrap2">
				<ul class="dt-list-wrap clearfix">
    			<?php $i=-1; foreach($video as $v) {$i++; ?>
    				<li class="dt-li dt-li<?php echo $i ?>">
	    				<div class="mask_wrp">
		    				<img src="<?php echo resource_url($v['coverimg_path']) ?>" alt="<?php echo $v['title'] ?>">
		    				<a  target="blank" href="<?php echo site_url('photo_archive/' . $v['id']) ?>"  class="mask_04"></a>
	    				</div>
	    				<a  target="blank" href="<?php echo site_url('photo_archive/' . $v['id']) ?>"  class="dt-li-txt">
	    				<?php echo $v['title'] ?>
	    				</a>
    				</li>
    			<?php } ?>
				</ul>
				<ul class="dt-list-wrap clearfix none">
    			<?php $i=-1; foreach($radio as $v) {$i++; ?>
    				<li class="dt-li dt-li<?php echo $i ?>">
	    				<div class="mask_wrp">
		    				<img src="<?php echo resource_url($v['coverimg_path']) ?>" alt="<?php echo $v['title'] ?>">
		    				<a  target="blank" href="<?php echo site_url('photo_archive/' . $v['id']) ?>" class="mask_04"></a>
	    				</div>
	    				<a  target="blank" href="<?php echo site_url('photo_archive/' . $v['id']) ?>"  class="dt-li-txt">
	    				<?php echo $v['title'] ?>
	    				</a>
    				</li>
    			<?php } ?>
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
			    				<a target="blank" href="<?php echo site_url('photo_archive/' . $v['id']) ?>" class="s-pic-tit">
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
<?php require 'footer_view.php' ?>
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
		   // tab切换
		   tab($('#newTab1'), $('#dt_wrap1'));
		   tab($('#newTab2'), $('#dt_wrap2'));

	})
	// tab
	function tab($tab, $con){
		$tab.on('click', '.news-tab-li', function(){
				var i = $(this).index();
				if(!$(this).hasClass('curr')){
					$(this).addClass('curr').siblings().removeClass('curr');
					$con.find('.dt-list-wrap').eq(i).removeClass('none').siblings().addClass('none');
				}
		})
	}
</script>
</body>
</html>