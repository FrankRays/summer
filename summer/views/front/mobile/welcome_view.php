<?php defined('BASEPATH') || exit('no direct script access allowed'); 

require('header_view.php');
?>

	<div class="container">
	  	<div class="row top-slider">
	  		<div class="col-md-3 top-slider-container">
				<div class="clearfix imgag-gallery-wrapper" >
					<ul id="image-gallery" class="gallery list-unstyled cS-hidden">
						<?php foreach($sliders as $k => $v){ ?>
						<li data-thumb="<?=resource_url($v['value']['picSrc'])?> ">
							<a href="<?=$v['value']['linkSrc']?>"><img style="width:100%"  src="<?=resource_url($v['value']['picSrc'])?>" /></a>
						</li>
						<?php } ?>
					</ul>
					<ul class="image-gallery-title">
						<?php foreach($sliders as $k=>$v) { ?>
						<li class="summer-hidden">
									<a href="<?=$v['value']['linkSrc']?>"><?=$v['value']['name']?></a>
						</li>
						<?php } ?>
					</ul>
				</div>
	  			
	  		</div>
	  	</div>


	    <div class="row">
	    	<div class="col-sm-12 summer-index-list-sm">
				<!-- <dl>
				    <dt class="artitle_author_date">
				        <div class="summer-index-cat">umylxy</div>
				        <div class="summer-index-date">4 小时前</div>
				    </dt>
				    <dd class="m summer-index-img"><a href="article-14742-1.html"><img src="http://img.dgtle.com/portal/201606/11/101021cjhdeqgghd5jt5mk.jpg?szhdl=imageview/2/w/680" alt="这个夏天最开始的礼物也是一场猝不及防的暴雨"></a></dd>
				    <dt class="zjj_title"><a href="article-14742-1.html">这个夏天最开始的礼物也是一场猝不及防的暴雨</a></dt>
				    <dd class="cr_summary">厦门的天气说变就变，早上还是蓝天白云，下午就突然乌云密布，风雨大作。幸亏，在这个地方 ...</dd>
				    <dd class="summer-index-tail">
				            <span class="summer-index-like">42</span>
				    </dd>
				</dl> -->

				<?php foreach($xyxw_news as &$v) { ?>
				<dl>
				    <dt class="artitle_author_date">
				        <div class="summer-index-cat"><?=$v['category_name'] ?></div>
				        <div class="summer-index-date"><?=$v['create_date'] ?></div>

				    </dt>
				    <?php if( ! empty($cover_img)) { ?>
						<dd class="m"><a href="<?=site_url('m/archive/'.$v['id'])?>"><img src="http://img.dgtle.com/portal/201606/11/101021cjhdeqgghd5jt5mk.jpg?szhdl=imageview/2/w/680" alt="这个夏天最开始的礼物也是一场猝不及防的暴雨"></a></dd>
				    <?php } ?>
				    <dt class="zjj_title"><a href="<?=site_url('m/archive/'.$v['id'])?>"><?=$v['title']?></a></dt>
				    <dd class="cr_summary"><?=$v['summary']?></dd>
				    <dd class="summer-index-tail">
				            <span class="summer-index-like"><?=$v['approve_times']?></span>
				            <span class="summer-index-hits"><?=$v['hits']?></span>
				    </dd>
				</dl>
				<?php } ?>
	    	</div>

			<div class="col-sm-12 summer-index-loadmore">
		        <a id="load-more-news" href="javascript:;"><img src="<?=static_url('images/loadmore.gif')?>" alt="">加载更多</a>
		        <div class="spinner">
		          <div class="double-bounce1"></div>
		          <div class="double-bounce2"></div>
		        </div>
		    </div>
	    </div>


    </div>

	<!-- //引入footer -->
	<?php require('footer_view.php') ?>
	<!-- //引入footer -->
  </body>

 <!-- jQuery -->
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>

<!-- Bootstrap  -->
<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<!-- light slider js -->
<script type="text/javascript" src="<?=static_url("plugins/lightslider/js/lightslider.js") ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {

		//init slider
		var galleryTitles =  $(".image-gallery-title").find("li");
		$('#image-gallery').lightSlider({
			gallery:false,
			item:1,
			thumbItem:9,
			slideMargin: 0,
			speed:500,
			auto:true,
			loop:true,
			pause:4000,
			onBeforeStart : function($el) {
			},
			onSliderLoad: function($el) {
				$('#image-gallery').removeClass('cS-hidden');
				var i = $el.getCurrentSlideCount() - 1;
				if(i >= 0) {
					galleryTitles.eq(i).removeClass("summer-hidden");
					galleryTitles.eq(i).siblings().addClass("summer-hidden");
				}
			},
			onBeforeSlide : function($el, scene) {
				var i = $el.getCurrentSlideCount() - 1;
				if(i >= 0) {
					galleryTitles.eq(i).removeClass("summer-hidden");
					galleryTitles.eq(i).siblings().addClass("summer-hidden");
				}
			}
		});


		//load more news handle
		var handling = 0;
		var offset = 10;
		$("#load-more-news").on('click', function(e){

			if(handling == 1) {
				return ;
			}
			handling = 1;
			$.ajax({
				"type" 		: "get",
				"url" 		: "<?=site_url('welcome/load_more_news')?>?offset=" + offset,
				"success" 	: function (data){
					$(".summer-index-list-sm").append(data);
					offset += 10;
					handling = 0;
				}
			});
		});
	});
</script>
</html>