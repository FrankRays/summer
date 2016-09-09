<?php

defined("APPPATH") or exit("no access");
require("old_header_view.php");

?>
<div id="recent-news-con">
		<div id="pic-container">
		<div id="location-bar">
			<p>
			<i  class="fi-marker location-icon"></i>您的位置：
			<?php echo $bread_path ?>
		</div>

			<div class="summer_pic_tit">
				<h2><?php echo $article['title'] ?></h2>
				<p class="cur-news-info" style="font-size:13px;">
					<?php echo substr($article['publish_date'], 5, 5) ?>&nbsp; | &nbsp; 点击:<?php echo $article['hits'] ?> &nbsp;| &nbsp;来稿：<?php echo $article['author_name'] ?>


					<a class="summer_pic_zan"><i class="fi-like"></i>赞(<span><?php echo $article['love'] ?></span>)</a>
				</p>
			</div>

			<div class="slider summer-big-pic-wrapper" id="slider">
				<ul class="sliderbox">
					<li class=""><img src="<?php echo resource_url($cur_image['pathname'])?> " alt="<?php echo $cur_image['summary']?>">
					</li>
				</ul>
				<div class="prev" style="display:none"><a href="<?php echo $pre_pic ?>"></a></div>
				<div class="next" style="display:none"><a href="<?php echo $next_pic ?>"></a></div>
			</div>


			<p class="per_pic_desc"><?php echo $cur_image['summary'] ?></p>

			<div class="slider" id="summer_more">
				<ul class="sliderbox summer_more_sliderbox_ul">
				<?php foreach($photoes as $k=>$v) { ?>
					<li class="<?php echo $k==$cur_image_index ? 'current first' : ''; ?>">
						<div><a href="<?php echo site_url('photo_archive/'.$article['id'].'/'.$k) ?>"><img src="<?php echo resource_url($v['pathname']) ?>" alt="<?php $v['title'] ?>"/></a></div>
					</li>
				<?php } ?>
				</ul>
				<ul class="slidernav"></ul>
				<div class="prev" style="display:none">&lt;</div>
				<div class="next" style="display:none">&gt;</div>
			</div>

				<p class="all_pic_desc"><?php echo $article['summary'] ?></p>
				<div style="padding:0 20px;">	
			
				<div class="bdsharebuttonbox shareAtticle clearfix bdshare-button-style0-16" data-bd-bind="1471754517465">
	                   <a class="bds_more" data-cmd="more">分享到：</a>
	                   <a class="bds_qzone" data-cmd="qzone" title="分享到QQ空间">QQ空间</a>
	                   <a class="bds_tsina" data-cmd="tsina" title="分享到新浪微博">新浪微博</a>
	                   <a class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博">腾讯微博</a>
	                   <a class="bds_weixin" data-cmd="weixin" title="分享到微信">微信</a>
	                   <a class="bds_sqq" data-cmd="sqq" title="分享到QQ好友">QQ好友</a>
	            </div>	
	        	</div>
			<div class="slider summer_pic_best_wrapper" id="slider">
				<h2 class="summer-pic-best-tit">最新图片<a href="<?php echo site_url('l/'.$article['category_id']) ?>" class="summer-pic-best-tit-right">更多>></a></h2>
				<ul class="sliderbox summer_pic_best">
				<?php foreach($latest_images as $k=>$v) { ?>
					<li class="">
					<a href="<?php echo site_url('photo_archive/'.$v['id']) ?>"><img src="<?php echo resource_url($v['coverimg_path'])?> ">
					</a>
						<p><a href="<?php echo site_url('photo_archive/'.$v['id']) ?>"> <?php echo $v['title'] ?></a></p>
					</li>
				<?php } ?>
				</ul>
			</div>

		</div>
	</div>

	<script type="text/javascript" src="<?php echo base_url('source/ft/xww/js/power-slider.min.js') ?>"></script>
	<script type="">
		$(function(){
			$("#summer_more").powerSlider({sliderNum:4, handle:"left", delayTime:99999999, Nav:false});

			$(".summer_pic_zan").one('click', function(){
				$.ajax('<?php echo site_url('welcome/do_like_ajax') . '?article_id=' . $article['id'] ?>')
				.then(function(response, message){
					alert(response.message);
					if(response.status == 200) {
						var s = $(".summer_pic_zan")
						.css('cursor', 'default')
						.css('color', '#ff822d');
						s.find('span').html(parseInt(s.find('span').html()) + 1);
					}
				});
			});

			// setTimeout(function(){alert('xxxx')}, 1000);
			var timer = null;
			$(".summer-big-pic-wrapper").hover(
					function(){
						clearTimeout(timer);
						timer = null;
						$(this).find('.prev').show();
						$(this).find('.next').show();
					},
					function(){
						var self = $(this);
						timer = setTimeout(function(){
							self.find('.prev').fadeOut();
							self.find('.next').fadeOut();
						}, 500);
					}
				);

			var timer2 = null;
			$("#summer_more").hover(
					function(){
						clearTimeout(timer2);
						timer2 = null;
						$(this).find('.prev').show();
						$(this).find('.next').show();
					},
					function(){
						var self = $(this);
						timer2 = setTimeout(function(){
							self.find('.prev').fadeOut();
							self.find('.next').fadeOut();
						}, 500);
					}
				);
		});

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

	<?php require("old_footer_view.php"); ?>