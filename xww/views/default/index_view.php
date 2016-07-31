<?php

defined('APPPATH') OR  exit('forbbiden for access');
?>

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
				<?php foreach($nav as $v ){ ?>
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
					<li data-thumb="<?php echo $v['value']['picSrc']?> ">
						<img style="width:670px;height:360px;" src="<?php echo $v['value']['picSrc']?>" />
					</li>
					<?php } ?>
				</ul>
				<ul class="image-gallery-title">
					<?php foreach($sliders as $k => $v){  ?>
					<li class="cS-hidden">
						<?php if(empty($v["value"]["linkSrc"])) { ?>
						<a href="#"><?php echo $v["value"]["name"] ?></a>
						<?php }else{  ?>
							<a href="<?php echo $v["value"]["linkSrc"] ?>"><?php echo $v["value"]["name"] ?></a>
						<?php } ?>
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
				<div id="home-col">
					<a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/front/view-11-".$top_college_news['index_id'].".html" ?>
						" class="pic" >
						<img src="<?=resource_url($top_college_news['coverimg_path'])?>" ></a>
					<a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/front/view-11-".$top_college_news['index_id'].".html" ?>
						" class="headline" >
						<p>
							<?=$top_college_news['title'] ?></p>
					</a>
					<a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/front/view-11-".$top_college_news['title'].".html" ?>
						" class="desc" >
						<p>
							<span>&nbsp;</span>
						</p>
					</a>
				</div>
				<ul class="institute-list college-news">
					<?php foreach($college_news as $v){ ?>
					<li>
						<a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/front/view-11-".$v['id'].".html" ?>
							" >
							<?php echo $v['title'] ?></a>
						<span>
							<?php echo $v['publish_date'] ?></span>
					</li>
					<?php } ?></ul>
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
				<div id="home-col">
				<?php if(isset($top_depart_news)) { ?>
					<a href="<?php echo "http://www.svtcc.edu.cn/front/view-16-".$top_depart_news['id'].".html" ?>
						" class="pic" >
						<img src="<?php echo base_url($top_depart_news['coverimg_path']) ?>" ></a>
					<a href="<?php echo "http://www.svtcc.edu.cn/front/view-16-".$top_depart_news['id'].".html" ?>
						" class="headline" >
						<p>
							<?php echo $top_depart_news['title'] ?></p>
					</a>
					<a href="<?php echo "http://www.svtcc.edu.cn/front/view-16-".$top_depart_news['id'].".html" ?>
						" class="desc" >
						<p>
							<span>&nbsp;</span>
						</p>
					</a>

					<?php } ?>
				</div>
				<ul class="institute-list">
					<?php foreach($depart_news as $v){ ?>
					<li>
						<a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/front/view-16-".$v['id'].".html" ?>">
							<?php echo $v['title'] ?></a>
						<span>
							<?php echo $v['publish_date'] ?></span>
					</li>
					<?php } ?></ul>
			</div>
			<div id="society-news">
				<div id="society-news-t">
					<h2>
						<a target="_blank" href="<?php echo site_url('news/li/3') ?>" >聚焦热点</a>
					</h2>
					<div id="more-wrap">
						<a href="<?php echo site_url('news/li/3') ?>
							">更多
							<img src="<?php echo base_url('/source/ft/xww/images/triangle.jpg')?>"></a>
					</div>
				</div>

				<div id="home-col">
					<?php foreach(darticle(array('category_id'=>1, 'is_top'=>1,'limit'=>1)) as $v) { ?>
					<a href="<?php echo site_url('news/archive/'.$v['id']) ?>
						" class="pic" >
						<img src="<?php echo base_url($v['coverimg_path']) ?>" ></a>
					<a href="<?=$v['href']?>
						" class="headline" >
						<p>
							<?php echo $v['title'] ?></p>
					</a>
					<a href="<?php echo site_url('news/archive/'.$v['id']) ?>
						" class="desc" >
						<p>
							<span>&nbsp;</span>
						</p>
					</a>
					<?php } ?>
				</div>
				<ul class="institute-list">
					<?php foreach(darticle(array('category_id'=>1,'limit'=>5)) as $v){ ?>
					<li>
						<a href="<?=$v['href']?>
							" >
							<?php echo $v['title'] ?></a>
						<span>
							<?php echo $v['publish_date'] ?></span>
					</li>
					<?php } ?></ul>
			</div>
			<div id="media">
				<div id="video-show">
					<div class="xww-tab xww-tab-wrapper" style="height:152px;margin: 20px 0 0 0;">
						<ul>
							<li class="active">
								<h2><a target="_blank" href="<?php echo site_url('video/') ?>" >影像交院</a></h2>
								
								<div class="video-con">

								<?php 

									$video = darticle(array('category_id'=>3, 'limit'=>3, 'offset'=>0));
									if(isset($video[0])) {
								 ?>
									<div class="video1">
										<a title="<?=$video[0]['title'] ?>
											" href="
											<?=$video[0]['href'] ?>
											">
											<img src="<?=$video[0]['coverimg_path']?>" /></a>
									</div>
								<?php }
									if(isset($video[1])) {
								 ?>
									<div class="video2">
										<a title="<?=$video[1]['title'] ?>" href="<?=$video[1]['href'] ?>">
											<img src="<?=$video[1]['coverimg_path']?>" />
										</a>
									</div>

									<?php 
										
									}

									if(isset($video[2])) {

									?>
									<div class="video3">
										<a title="<?=$video[2]['title']?>">
											<img src="<?=$video[2]['coverimg_path']?>" />
										</a>
									</div>

									<?php 
										}
									?>
								</div>
							</li>
							<li>
								<h2><a target="_blank" href="<?php echo site_url('news/li/13') ?>" >微电台</a></h2>
								<div>
									<div class="video-con">
									<?php $wei_radio = darticle(array('category_id'=>8, 'limit'=>3, 'offset'=>0));
									 if(isset($wei_radio[0])) { ?>
											<div class="video1">
												<a title="<?=$wei_radio[0]['title'] ?>" href="<?=$wei_radio[0]['href'] ?>">
													<img src="<?=$wei_radio[0]['coverimg_path']?>" /></a>
											</div>
										<?php	} 
										if(isset($wei_radio[1])) { ?>
											<div class="video2">
												<a title="" href="<?=$wei_radio[1]['href'] ?>">
													<img src="<?=$wei_radio[1]['coverimg_path']?>" /></a>
											</div>
										<?php	} ?>
										<?php if(isset($wei_radio[2])) { ?>
											<div class="video3">
												<a title="<?=$wei_radio[2]['title'] ?>" href="<?=$wei_radio[2]['href'] ?>">
													<img src="<?=$wei_radio[2]['pic_src']?>" /></a>
											</div>
										<?php	} ?>
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
									<a href="<?php echo site_url('news/li/10')?>" >通知公告</a>
								</h2>
								<div>
									<ul id="tzgg-wrapper" class="notice institute-list">
										<?php foreach (darticle(array('category_id'=>12, 'limit'=>5, 'offset'=>0))as $v) {?>
										<li>
											<a target="_blank" href="<?=$v['href'] ?>">
												<?php echo $v['title'] ?>
											</a>
											<span><?php echo $v['publish_date'] ?></span>
										</li>
										<?php } ?>
									</ul>
								</div>
							</li>
							<li>
								<h2 >
									<a href="<?php echo site_url('news/li/11')?>" >耕读交院</a>
								</h2>
								<div>
									<ul id="jygy-wrapper" class="notice institute-list">
										<?php foreach (darticle(array('category_id'=>6, 'limit'=>5, 'offset'=>0))as $v) {?>
										<li>
											<a target="_blank" href="<?=$v['href'] ?>">
												<?php echo $v['title'] ?>
											</a>
											<span><?php echo $v['publish_date'] ?></span>
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
								<a href="<?php echo site_url('photo/index/8') ?>">图片新闻</a>
							</h2>
							<div>
								<div id="pic-news-con">
										<?php $college_imgs = darticle(array('category_id'=>2, 'limit'=>3)); 
										if(isset($college_imgs[0])) { ?>
									<div id="pic1">
										<a href="<?=$college_imgs[0]['href']?>">
											<img src="<?=$college_imgs[0]['coverimg_path']?>" /></a>
										<a href="<?=$college_imgs[0]['href'] ?>">
											<p  style="margin-top:5px;text-align:center;">
												<?=$college_imgs[0]['title']?></p>
										</a>
									</div>
									<?php } 
									 if(isset($college_imgs[0])) unset($data['picnews'][0]);
									 foreach($college_imgs as $v){ 
									 ?>
									<div id="pic2">
										<a href="<?=$v['href'] ?>">
											<img src="<?=$v['coverimg_path']?>" />
										</a>
									</div>
									<?php } ?>
								</div> 
							</div>
						</li>
						<li>
							<h2><a href="<?php echo site_url('photo/index/12') ?>">校园写意</a></h2>
							<div>
								<div id="pic-news-con">
										<?php $college_pics = darticle(array('category_id'=>7, 'limit'=>3)); 
										if(isset($college_pics[0])) { ?>
									<div id="pic1">
										<a href="<?=$college_pics[0]['href']?>">
											<img src="<?=$college_pics[0]['coverimg_path']?>" /></a>
										<a href="<?=$college_pics[0]['href'] ?>">
											<p  style="margin-top:5px;text-align:center;">
												<?=$college_pics[0]['title']?></p>
										</a>
									</div>
									<?php } ?>


									<?php 
									 if(isset($college_pics[0])) unset($data['picnews'][0]);
									 foreach($college_pics as $v){ 
									 ?>
									<div id="pic2">
										<a href="<?=$v['href'] ?>">
											<img src="<?=$v['coverimg_path']?>" />
										</a>
									</div>
									<?php } ?>
								</div> 
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div id="media-jy">
				<div id="media-jy-t" style="margin-bottom:15px;">
					<h2>
						<a href="<?php echo site_url('news/mtjy/2.html') ?>">媒体交院</a>
					</h2>
					<div id="more-wrap">
						<a href="<?php echo site_url('news/mtjy/2.html') ?>
							">更多
							<img src="<?php echo base_url('/source/ft/xww/images/triangle.jpg')?>"></a>
					</div>
				</div>
				<div id="media-jy-list" >
					<ul class="hot-newspaper-pic">
					<?php foreach(darticle(array('category_id'=>9, 'limit'=>2)) as $v) ?>
						<li>
							<div class="newspaper"><img src="<?php echo base_url('/source/mtjylogo.jpg')?>" /></div>
							<a target="blank" href="<?=$v['href'] ?>"><?=$v['title']?>(<?=$v['publish_date'] ?>)</a>
						</li>
					</ul>
					<ul style="clear:both" class="hot-newspaper">
					<?php foreach(darticle(array('category_id'=>9, 'limit'=>3, 'offset'=>2)) as $v) {?>
						<li>
							<a target="blank" href="<?php echo $v['come_from_url'] ?>"> <?php echo $v['title'] ?></a>
							<span>(<?=$v['publish_date']?>)</span>
						</li>
					<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div id="roll-pic">
		<div id="roll-pic-t">
			<h2>
				<a href="<?php echo  site_url('photo/index/7') ?>" >光影交院</a>
			</h2>
			<div id="more-wrap">
				<a href="<?php echo site_url('photo/index/7') ?>
					">更多
					<img src="<?php echo base_url('/source/ft/xww/images/triangle.jpg')?>"></a>
			</div>
		</div>
		<div id="roll-pic-con">
			<table border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<?php foreach(darticle(array('category_id'=>5, 'limit'=>4)) as $v ) {?>
					<td valign="top" class="pic-td" >
						<a class="y-gyjy-img-wrap" href="<?=$v['href'] ?>">
							<img alt="<?=v['title'] ?>" src="<?=$v['coverimg_path']?>" />
						</a>
					</td>
					<?php } ?></tr>
			</table>
		</div>
	</div>
	<!--
		<div id="friend-link">
	<ul>
		<li class="first">链接：</li>
		<li>
			<a href="javascript:;">人民网</a>
		</li>
		<li>
			<a href="javascript:;">新华网</a>
		</li>
		<li>
			<a href="javascript:;">光明网</a>
		</li>
		<li>
			<a href="javascript:;">教育新闻网</a>
		</li>
	</ul>
</div>
-->
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