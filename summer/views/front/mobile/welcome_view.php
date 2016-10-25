<?php defined('BASEPATH') || exit('no direct script access allowed'); 

require('header_view.php');
?>

	<div class="container">
	  	<div class="row top-slider">
	  		<div class="col-md-3 top-slider-container">
				<div class="clearfix imgag-gallery-wrapper" >
					<ul id="image-gallery" class="gallery list-unstyled cS-hidden">
						<?php foreach($sliders as $k => $v){ ?>
						<li data-thumb="<?php echo resource_url($v['img_path'])?> ">
							<a href="<?php echo $v['href']?>"><img style="width:100%;max-height:200px;"  src="<?php echo resource_url($v['img_path'])?>" /></a>
						</li>
						<?php } ?>
					</ul>
					<ul class="image-gallery-title">
						<?php foreach($sliders as $k=>$v) { ?>
						<li class="summer-hidden">
							<a href="<?php echo $v['href'] ?>"><?php echo $v['title']?></a>
						</li>
						<?php } ?>
					</ul>
				</div>
	  		</div>
	  	</div>

	    <div class="row">
	    	<div class="col-sm-12 summer-index-list-sm">
				<?php foreach($articles as &$v) { ?>
				<dl>
				    <dt class="artitle_author_date">
				        <div class="summer-index-cat"><?php echo $v['category_name'] ?></div>
				        <div class="summer-index-date"><?php echo substr($v['publish_date'], 0, 10) ?></div>

				    </dt>
				    <?php if( ! empty($v['coverimg_path'])) { ?>
						<dd class="m"><a href="<?php echo archive_url($v)?>"><img src="<?php echo resource_url($v['coverimg_path']) ?>" alt="<?php echo $v['title'] ?>"></a></dd>
				    <?php } ?>
				    <dt class="zjj_title"><a href="<?php echo archive_url($v)?>"><?=$v['title']?></a></dt>
				    <dd class="cr_summary"><?php echo $v['summary']?></dd>
				    <dd class="summer-index-tail">
				            <span class="summer-index-like"><?php echo $v['love']?></span>
				            <span class="summer-index-hits"><?php echo $v['hits']?></span>
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
<script type="text/javascript" src="<?php echo static_url("plugins/lightslider/js/lightslider.js") ?>"></script>

<!-- layer ui good luck -->
<script type="text/javascript" src="<?php echo static_url('plugins/layui/layui.js') ?>"></script>

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
				"url" 		: "<?php echo site_url('m/index/load_more_news')?>?offset=" + offset,
				"success" 	: function (data){
					$(".summer-index-list-sm").append(data);
					offset += 10;
					handling = 0;
				}
			});
		});
	});

	//layui
	layui.config({
		base : 'statics/js/modules/'
		,debug : true
	}).use('index');
</script>
</html>