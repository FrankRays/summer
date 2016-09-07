<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<meta name="description" content="四川交通职业技术学院新闻网，校内网，通知，活动，公告，最新动态，校内服务。">
	<meta name="keywords" content="四川交通职业技术学院,新闻,交通,职业技术,大学,AtoB,summer">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta property="wb:webmaster" content="3047516a007d12b0" />
	<title>新闻网-news-四川交通职业技术学院新闻网</title>
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
	<!-- No Baidu Siteapp-->
	<meta http-equiv="Cache-Control" content="no-siteapp"/>
	<!-- common css -->
	<link rel="stylesheet" href="<?php echo base_url('/source/ft/xww/css/style_1018.css') ?>
	?version=summer_1101"  type"text/css" />
	<!-- common css -->
	<!--[if (gte IE 9)|!(IE)]>
	<!-->
	<script src="<?php echo base_url('/source/AmazeUI-2.1.0/assets/js/jquery.min.js') ?>"></script>
	<!--<![endif]-->
	<!--[if lte IE 8 ]>
	<script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
	<![endif]-->
	<script type="text/javascript" src="<?php echo base_url('/source/ft/xww/js/koala.min.1.5.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/source/layer/layer.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/source/layer/extend/layer.ext.js') ?>"></script>
	<!-- lightslider -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/statics/plugins/lightslider/css/lightslider.css") ?>">
	<!-- lightslider -->
	<!-- tab js -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/statics/plugins/tab/css/pignose.tab.css") ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/statics/plugins/xww-tab/css/xww.tab.css") ?>">
	<!-- tabjs -->
</head>
<body>
	<div id="header">
		<div id="header-box">
			<h1>
				<a href="<?php echo site_url() ?>
					">
					<img src="<?php echo base_url('/source/ft/xww/images/logo.jpg')?>" /></a>
			</h1>
			<p>新闻网</p>
		</div>
	</div>
	<div id="nav">
		<div id="nav-box">
			<ul>
				<?php foreach($navs as $v ){ ?>
				<li>
					<a href="<?php echo $v['href'] ?> ">
						<?php echo $v['label'] ?></a>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="content">


		<div id="recent-im-news">
			<div id="recent-im-news-t">
				<h2>
					<a href="#">近期要闻</a>
				</h2>
			</div>
			<div class="clearfix imgag-gallery-wrapper" style="max-width:667px;margin-top: 10px;padding-left: 5px;">
				<!--近期要闻图片轮播开始-->
				<ul id="image-gallery" class="gallery list-unstyled cS-hidden">
					<?php foreach($sliders as $k => $v){ ?>
					<li data-thumb="<?php echo resource_url($v['img_path'])?> ">
						<img style="width:670px;height:360px;" src="<?php echo resource_url($v['img_path'])?>" />
					</li>
					<?php } ?>
				</ul>
				<ul class="image-gallery-title">
					<?php foreach($sliders as $k => $v){  ?>
					<li class="cS-hidden">
						<a href="#"><?php echo $v["title"] ?></a>
					</li>
					<?php } ?>
				</ul>
			</div>
			<!--近期要闻图片轮播结束-->
		</div>


		<div id="institute-news">
			<div id="institute-news-t">
				<h2>
					<a target="_blank" href="http://www.svtcc.edu.cn/front/list-11.html" >学院新闻</a>
				</h2>
				<div id="more-wrap">
					<a target="_blank" href="http://www.svtcc.edu.cn/front/list-11.html">
						更多
						<img src="<?php echo base_url('/source/ft/xww/images/triangle.jpg')?>"></a>
				</div>
			</div>
			<div id="institute-news-con">
			<?php foreach($college_news_top as $v): ?>
				<div id="home-col">
					<a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/front/view-11-".$v['index_id'].".html" ?>
						" class="pic" >
						<img src="<?php echo resource_url($v['coverimg_path'])?>" ></a>
					<a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/front/view-11-".$v['index_id'].".html" ?>
						" class="headline" >
						<p>
							<?php echo $v['title'] ?></p>
					</a>
					<a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/front/view-11-".$v['index_id'].".html" ?>
						" class="desc" >
						<p>
							<span>&nbsp;</span>
						</p>
					</a>
				</div>
			<?php endforeach ?>
				<ul class="institute-list">
					<?php foreach($college_news as $v):?>
					<li>
						<a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/front/view-11-".$v['index_id'].".html" ?>
							" >
							<?php echo $v['title'] ?></a>
						<span>
							<?php echo substr($v['publish_date'],0,10) ?></span>
					</li>
					<?php endforeach ?>
				</ul>
			</div>
		</div>
		<div id="left-wrap">
			<div id="department-news">
				<div id="department-news-t">
					<h2>
						<a target="_blank" href="http://www.svtcc.edu.cn/front/list-16.html" >系部动态</a>
					</h2>
					<div id="more-wrap">
						<a target="_blank" href="http://www.svtcc.edu.cn/front/list-16.html">
							更多
							<img src="<?php echo base_url('/source/ft/xww/images/triangle.jpg')?>"></a>
					</div>
				</div>
				<?php foreach($departnotice_top as $v): ?>
				<div id="home-col">
					<a href="<?php echo "http://www.svtcc.edu.cn/front/view-16-".$v['index_id'].".html" ?>
						" class="pic" >
						<img src="<?php echo resource_url($v['coverimg_path']) ?>" ></a>
					<a href="<?php echo "http://www.svtcc.edu.cn/front/view-16-".$v['index_id'].".html" ?>
						" class="headline" >
						<p>
							<?php echo $v['title'] ?></p>
					</a>
					<a href="<?php echo "http://www.svtcc.edu.cn/front/view-16-".$v['index_id'].".html" ?>
						" class="desc" >
						<p>
							<span>&nbsp;</span>
						</p>
					</a>
				</div>
			<?php endforeach ?>
				<ul class="institute-list">
					<?php foreach($departnotice as $v){ ?>
					<li>
						<a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/front/view-16-".$v['index_id'].".html" ?>">
							<?php echo $v['title'] ?></a>
						<span>
							<?php echo substr($v['publish_date'],0,10) ?></span>
					</li>
					<?php } ?></ul>
			</div>
			<div id="society-news">
				<div id="society-news-t">
					<h2>
						<a target="_blank" href="<?php echo site_url('l/focushot') ?>" >热点交院</a>
					</h2>
					<div id="more-wrap">
						<a href="<?php echo site_url('l/focushot') ?>">更多
							<img src="<?php echo base_url('/source/ft/xww/images/triangle.jpg')?>"></a>
					</div>
				</div>
				<?php foreach($focushot_top as $v): ?>
				<div id="home-col">
					<a href="<?php echo archive_url($v['id'], $v['category_id']) ?>
						" class="pic" >
						<img src="<?php echo base_url($v['pic_src']) ?>" ></a>
					<a href="<?php echo archive_url($v['id'], $v['category_id']) ?>
						" class="headline" >
						<p>
							<?php echo $v['title'] ?></p>
					</a>
					<a href="<?php echo archive_url($v['id'], $v['category_id']) ?>
						" class="desc" >
						<p>
							<span>&nbsp;</span>
						</p>
					</a>
				</div>
			<?php endforeach ?>
				<ul class="institute-list">
					<?php foreach($focushot as $v){ ?>
					<li>
						<a href="<?php echo archive_url($v['id'], $v['category_id']) ?>
							" >
							<?php echo $v['title'] ?></a>
						<span>
							<?php echo substr($v['publish_date'],0,10) ?></span>
					</li>
					<?php } ?></ul>
			</div>
			<div id="media">
				<div id="video-show">
					<div class="xww-tab xww-tab-wrapper" style="height:152px;margin: 20px 0 0 0;">
						<ul>
							<li class="active">
								<h2><a target="_blank" href="<?php echo site_url('l/video') ?>" >影像交院</a></h2>
								<div class="video-con">
								<?php $i=-1;foreach($video as $v):$i++; ?>
									<div class="video<?php echo $i ?>">
										<a title="<?php echo $v['title'] ?>
											" href="
											<?php echo archive_url($v['id'], $v['category_id']) ?>
											">
											<img src="<?php echo resource_url($v['coverimg_path'])?>" /></a>
									</div>
								<?php endforeach ?>
								</div>
							</li>
							<li>
								<h2><a target="_blank" href="<?php echo site_url('l/radio') ?>" >微电台</a></h2>
								<div>
									<div class="video-con">
								<?php $i=-1;foreach($radio as $v):$i++; ?>
									<div class="video<?php echo $i ?>">
										<a title="<?php echo $v['title'] ?>
											" href="
											<?php echo archive_url($v['id'], $v['category_id']) ?>
											">
											<img src="<?php echo resource_url($v['coverimg_path'])?>" /></a>
									</div>
								<?php endforeach ?>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div id="link">
					<div class="xww-tab xww-tab-wrapper" style="height:152px;margin: 20px 0 0 30px;padding:0 5px;">
						<ul>
							<li class="active">
								<h2>
									<a href="<?php echo site_url('l/notice')?>" >通知公告</a>
								</h2>
								<div>
									<ul id="tzgg-wrapper" class="notice institute-list">
										<?php foreach ($notice as $v) {?>
										<li>
											<a target="_blank" href="<?php echo archive_url($v['id'], $v['category_id']) ?>
												">
												<?php echo $v['title'] ?></a>
											<span>
												<?php echo substr($v['publish_date'],0,10) ?></span>
										</li>
										<?php } ?>
									</ul>
								</div>
							</li>
							<li>
								<h2 >
									<a href="<?php echo site_url('l/collegemedia') ?>">媒体交院</a>
								</h2>
								<div>
									<ul id="jygy-wrapper" class="notice institute-list">
										<?php foreach ($college_media as $v) {?>
										<li>
											<a target="_blank" href="<?php echo archive_url($v['id'], $v['category_id']) ?>">
												<?php echo $v['title'] ?></a>
											<span><?php echo substr($v['publish_date'],0,10) ?></span>
										</li>
										<?php } ?>
									</ul>
								</div>
							</li>
						</ul>
					</div>
					<div id="link-con">
							<a href="http://www.svtcc.edu.cn" target="_blank">
								<img src="<?php echo base_url('/source/ft/xww/images/school_home.jpg')?>" /></a>
							<a href="http://scjyyb.svtcc.edu.cn" target="_blank">
								<img src="<?php echo base_url('/source/ft/xww/images/yb.jpg')?>" /></a>
							<a href="http://weibo.com/u/5168125807" target="_blank">
								<img src="<?php echo base_url('/source/ft/xww/images/weibo.jpg')?>" /></a>
							<a target="blank" href="<?php echo base_url('/source/erwima.jpg') ?>">
							<img src="<?php echo base_url('/source/ft/xww/images/weixin.jpg')?>" /></a>
					</div>
				</div>
			</div>
		</div>
		<div id="right-wrap">
			<!--图片新闻-->
			<div id="pic-news">
				<div class="xww-tab" style="height:152px;margin:20px 0 0 0;">
					<ul>
						<li class="active">
							<h2>
								<a href="<?php echo site_url('l/photo') ?>">图说交院</a>
							</h2>
							<div>
								<div id="pic-news-con">
								<?php $i=0;foreach($photo as $v){if($i>1)break;$i++ ?>
									<div id="pic1">
										<a href="<?php echo archive_url($v['id'], $v['category_id']) ?>
											">
											<img src="<?php echo resource_url($v['coverimg_path'])?>" /></a>
										<a href="<?php echo archive_url($v['id'], $v['category_id']) ?>
											">
											<p  style="margin-top:5px;text-align:center;">
												<?php echo $data['picnews'][0]['title']?></p>
										</a>
									</div>
								<?php } ?>
									<?php if(isset($photo[2])){ foreach($data['picnews'] as $v){ ?>
									<div id="pic2">
										<a href="<?php echo archive_url($v['id'], $v['category_id']) ?>
											">
											<img src="<?php echo resource_url($v['coverimg_path'])?>" /></a>
									</div>
									<?php }} ?>
								</div> 
							</div>
						</li>
						<li>
							<h2><a href="<?php echo site_url('l/reading') ?>">写意交院</a></h2>
							<div>
								<div id="pic-news-con">
									<?php $i=0;foreach($reading as $v){if($i>1)break;$i++ ?>
									<div id="pic1">
										<a href="<?php echo archive_url($v['id'], $v['category_id']) ?>
											">
											<img src="<?php echo resource_url($v['coverimg_path'])?>" /></a>
										<a href="<?php echo archive_url($v['id'], $v['category_id']) ?>
											">
											<p  style="margin-top:5px;text-align:center;">
												<?php echo $data['picnews'][0]['title']?></p>
										</a>
									</div>
								<?php } ?>
									<?php if(isset($reading[2])){ foreach($data['picnews'] as $v){ ?>
									<div id="pic2">
										<a href="<?php echo archive_url($v['id'], $v['category_id']) ?>
											">
											<img src="<?php echo resource_url($v['coverimg_path'])?>" /></a>
									</div>
									<?php }} ?>
								</div> 
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div id="media-jy">
				<div id="media-jy-t" style="margin-bottom:15px;">
					<h2>
						<a href="<?php echo site_url('l/read')?>" >耕读交院</a>
					</h2>
					<div id="more-wrap">
						<a href="<?php echo site_url('l/read') ?>
							">更多
							<img src="<?php echo base_url('/source/ft/xww/images/triangle.jpg')?>"></a>
					</div>
				</div>
				<div id="media-jy-list" >
					<ul class="hot-newspaper-pic">
					<?php $i=0;foreach($read as $v){ if($i>1)break;$i++ ?>
						<li>
							<div class="newspaper">
								<img src="<?php echo base_url('/source/mtjylogo.jpg')?>" /></div>
							<a target="blank" href="<?php echo archive_url($v['id'], $v['category_id']) ?>
								">
								<?php echo $v['title'] ?>
								(
								<?php echo substr($v['publish_date'], 0, 10)  ?>)</a>
						</li>
					<?php } ?>
					</ul>
					<?php
					if(count($read) > 2) {
						$read = array_slice($read, 2);
					?>
					<ul style="clear:both" class="hot-newspaper">
						<?php foreach($read as $v) { ?>
						<li>
							<a target="blank" href="<?php echo $v['link_url'] ?>
								">
								<?php echo $v['title'] ?></a>
							<span>
								(
								<?php echo substr($v['publish_date'], 0, 10) ?>)</span>
						</li>
						<?php }} ?></ul>
				</div>
			</div>
		</div>
	</div>
	<div id="roll-pic">
		<div id="roll-pic-t">
			<h2>
				<a href="<?php echo  site_url('l/photolight') ?>" >视觉交院</a>
			</h2>
			<div id="more-wrap">
				<a href="<?php echo site_url('l/photolight') ?>
					">更多
					<img src="<?php echo base_url('/source/ft/xww/images/triangle.jpg')?>"></a>
			</div>
		</div>
		<div id="roll-pic-con">
			<table border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<?php foreach($photolight as $v ) {?>
					<td valign="top" class="pic-td" >
						<a class="y-gyjy-img-wrap" href="<?php echo site_url('photo/archive/'.$v['news_id']) ?>
							">
							<img alt="<?php echo $v['title'] ?>
							" src="
							<?php echo resource_url($v["coverimg_path"])?>" /></a>
					</td>
					<?php } ?></tr>
			</table>
		</div>
	</div>
<div id="footer">
	<div id="footer-con">
		<div class="footer-left">
			<p>Copyright © 2013 SVTCC.EDU.CN(建议采用IE7.0及以上版本浏览器)</p>
			<p>地址：四川省成都市温江区柳台大道东段208号 邮编：611130</p>
		</div>
		<div class="footer-right">
			<p>联系我们：QQ:1206550156</p>
			<p>Email:1206550156@qq.com</p>
		</div>
	</div>
</div>
<!-- foot js -->
<!-- lightslider -->
<script type="text/javascript" src="<?php echo base_url("/statics/plugins/lightslider/js/lightslider.js") ?>"></script>
<!-- lightslider -->
<!-- tab js -->
<script type="text/javascript" src="<?php echo base_url("/statics/plugins/tab/js/pignose.tab.js") ?>"></script>
<script type="text/javascript" src="<?php echo base_url("/statics/plugins/xww-tab/js/xww.tab.js") ?>"></script>
<!-- tab js -->
<!-- foot js -->
<!-- lightslider set -->
<script>
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
					galleryTitles.eq(i).removeClass("cS-hidden");
					galleryTitles.eq(i).siblings().addClass("cS-hidden");
				}
			},
			onBeforeSlide : function($el, scene) {
				var i = $el.getCurrentSlideCount() - 1;
				if(i >= 0) {
					galleryTitles.eq(i).removeClass("cS-hidden");
					galleryTitles.eq(i).siblings().addClass("cS-hidden");
				}
			}
		});

		//init tabs
		$('.tab').pignoseTab({
			animation: true,
			children: '.tab'
		});

		//init xww tabs
		$(".xww-tab").xwwTab({

		});
	});
</script>
<!-- lightslider set -->
<!-- baidu hr -->
<script>
			var _hmt = _hmt || [];
			(function() {
			var hm = document.createElement("script");
			hm.src = "//hm.baidu.com/hm.js?c200de71d236dd222d1b3fb1bf7264d0";
			var s = document.getElementsByTagName("script")[0];
			s.parentNode.insertBefore(hm, s);
			})();
		</script>
<!-- baidu hr -->
</body>
</html>