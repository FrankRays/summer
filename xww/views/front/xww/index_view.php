<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<meta name="description" content="四川交通职业技术学院新闻网，校内网，通知，活动，公告，最新动态，校内服务。">
<meta name="keywords" content="四川交通职业技术学院,新闻,交通,职业技术,大学,AtoB,snow0x01">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta property="wb:webmaster" content="3047516a007d12b0" />
<title>新闻网-news-四川交通职业技术学院新闻网</title>
<!-- Set render engine for 360 browser -->
<meta name="renderer" content="webkit">
<!-- No Baidu Siteapp-->
<meta http-equiv="Cache-Control" content="no-siteapp"/>
<link rel="stylesheet" href="<?php echo base_url('/source/ft/xww/css/style_1018.css') ?>?version=summer_1101"  type"text/css" />

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="<?php echo base_url('/source/AmazeUI-2.1.0/assets/js/jquery.min.js') ?>"></script>
<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
<![endif]-->
<script type="text/javascript" src="<?php echo base_url('/source/ft/xww/js/koala.min.1.5.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('/source/layer/layer.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('/source/layer/extend/layer.ext.js') ?>"></script>
</head>
<body>
<div id="header">
	<div id="header-box">
		<h1><a href="<?php echo site_url() ?>"><img src="<?php echo base_url('/source/ft/xww/images/logo.jpg')?>" /></a></h1>
		<p>新闻网</p>
	</div>
</div>
<div id="nav">
	<div id="nav-box">
		<ul>
		<?php foreach($data['lmList'] as $v ){ ?>
			<li><a href="<?php echo $v['link_src'] ?>"><?php echo $v['name'] ?></a></li>
		<?php } ?>
		</ul>
	</div>
</div>
<div id="content">
	<div id="recent-im-news">
		<div id="recent-im-news-t">
			<h2><a href="#">近期要闻</a></h2>
			<!-- <div id="more-wrap">
				<a href="javascript:;">更多<img src="<?php echo base_url('/source/ft/xww/images/triangle.jpg')?>"></a>
			</div> -->
		</div>
		<div id="recent-im-news-video">
			<!--近期要闻图片轮播开始-->
			<div id="fsD1" class="focus">

					<div id="D1pic1" class="fPic">
						<?php foreach($data['slide'] as $v){ ?>
						<div class="fcon">
							<a href="<?php echo $v['value']['linkSrc'] ?>"><img src="<?php echo base_url($v['value']['picSrc'])?>" /></a>
							<span class="shadow"><a href="<?php echo $v['value']['linkSrc'] ?>"><?php echo $v['value']['name'] ?></a></span>
						</div>
						<?php } ?>
					</div>
					
					<div class="fbg">
						<div class="D1fBt" id="D1fBt">
							<?php foreach($data['slide'] as $k => $v){ ?>
							<?php if($k == 0){ ?>
								<a href="javascript:void(0)" class="current"><i>1</i></a>
							<?php }else{ ?>
								<a href="javascript:void(0)" class="current"><i><?php echo (intval($k) + 1) ?></i></a>
							<?php } ?>
							<?php } ?>
						</div>
					</div>
					
					<span class="prev"></span>
					<span class="next"></span>
					
				</div>
			</div>
			<!--近期要闻图片轮播结束-->
	</div>
	<div id="institute-news">
		<div id="institute-news-t">
			<h2><a target="_blank" href="http://www.svtcc.edu.cn/front/list-11.html" >学院新闻</a></h2>
			<div id="more-wrap">
				<a target="_blank" href="http://www.svtcc.edu.cn/front/list-11.html">更多<img src="<?php echo base_url('/source/ft/xww/images/triangle.jpg')?>"></a>
			</div>
		</div>
		<div id="institute-news-con">
			<div id="home-col">
				<a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/front/view-11-".$data['xyxwFirst']['id'].".html" ?>" class="pic" >
					<img src="<?php echo base_url($data['xyxwFirst']['cover_img'])?>" >
				</a>
				<a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/front/view-11-".$data['xyxwFirst']['id'].".html" ?>" class="headline" >
					<p><?php echo $data['xyxwFirst']['title'] ?></p>
				</a>
				<a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/front/view-11-".$data['xyxwFirst']['id'].".html" ?>" class="desc" >
					<p>
						<span>&nbsp;</span>
					</p>
				</a>
			</div>
			<ul class="institute-list">
				<?php foreach($data['xyxw'] as $v){ ?>
					<li><a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/front/view-11-".$v['id'].".html" ?>" ><?php echo $v['title'] ?></a><span><?php echo $v['index_ctime'] ?></span></li>
				<?php } ?>			
			</ul>
		</div>
	</div>
	<div id="left-wrap">
		<div id="department-news">
			<div id="department-news-t">
				<h2><a target="_blank" href="http://www.svtcc.edu.cn/front/list-16.html" >系部动态</a></h2>
				<div id="more-wrap">
					<a target="_blank" href="http://www.svtcc.edu.cn/front/list-16.html">更多<img src="<?php echo base_url('/source/ft/xww/images/triangle.jpg')?>"></a>
				</div>
			</div>
			<div id="home-col">
				<a href="<?php echo "http://www.svtcc.edu.cn/front/view-16-".$data['xbdtFirst']['id'].".html" ?>" class="pic" >
					<img src="<?php echo base_url($data['xbdtFirst']['cover_img']) ?>" >
				</a>
				<a href="<?php echo "http://www.svtcc.edu.cn/front/view-16-".$data['xbdtFirst']['id'].".html" ?>" class="headline" >
					<p><?php echo $data['xbdtFirst']['title'] ?></p>
				</a>
				<a href="<?php echo "http://www.svtcc.edu.cn/front/view-16-".$data['xbdtFirst']['id'].".html" ?>" class="desc" >
					<p>
						<span>&nbsp;</span>
					</p>
				</a>
			</div>
			<ul class="institute-list">
			<?php foreach($data['xbdt'] as $v){ ?>
				<li><a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/front/view-16-".$v['id'].".html" ?>" ><?php echo $v['title'] ?></a><span><?php echo $v['index_ctime'] ?></span></li>
			<?php } ?>
			</ul>
		</div>
		<div id="society-news">
			<div id="society-news-t">
				<h2><a target="_blank" href="<?php echo site_url('news/li/3') ?>" >聚焦热点</a></h2>
				<div id="more-wrap">
					<a href="<?php echo site_url('news/li/3') ?>">更多<img src="<?php echo base_url('/source/ft/xww/images/triangle.jpg')?>"></a>
				</div>
			</div>
			<div id="home-col">
				<a href="<?php echo site_url('news/archive/'.$data['firstJjrd']['newsID']) ?>" class="pic" >
					<img src="<?php echo base_url($data['firstJjrd']['pic_src']) ?>" >
				</a>
				<a href="<?php echo site_url('news/archive/'.$data['firstJjrd']['newsID']) ?>" class="headline" >
					<p><?php echo $data['firstJjrd']['title'] ?></p>
				</a>
				<a href="<?php echo site_url('news/archive/'.$data['firstJjrd']['newsID']) ?>" class="desc" >
					<p>
						<span>&nbsp;</span>
					</p>
				</a>
			</div>
			<ul class="institute-list">
			<?php foreach($data['bellowJjrd'] as $v){ ?>
				<li><a href="<?php echo site_url('news/archive/'.$v['newsID']) ?>" ><?php echo $v['title'] ?></a><span><?php echo $v['addTime'] ?></span></li>
			<?php } ?>
			</ul>
		</div>
		<div id="media">
			<div id="video-show">
				<div id="video-t">
					<h2><a target="_blank" href="<?php echo site_url('video/') ?>" >视频展播</a></h2>
					<div id="more-wrap">
						<a href="<?php echo site_url('video/') ?>">更多<img src="<?php echo base_url('/source/ft/xww/images/triangle.jpg')?>"></a>
					</div>
				</div>
				<div id="video-con">
					<div class="video1">
						<a title="<?php echo $data['spzb'][0]['title'] ?>" href="<?php echo site_url("video/archive/".$data['spzb'][0]['news_id']) ?>"><img src="<?php echo base_url($data['spzb'][0]['pic_src'])?>" /></a>
					</div>
					<div class="video2">
						<a title="<?php echo $data['spzb'][1]['title'] ?>" href="<?php echo site_url("video/archive/".$data['spzb'][1]['news_id']) ?>"><img src="<?php echo base_url($data['spzb'][1]['pic_src'])?>" /></a>
					</div>
					<div class="video3">
						<a title="<?php echo $data['spzb'][2]['title'] ?>" href="<?php echo site_url("video/archive/".$data['spzb'][2]['news_id']) ?>"><img src="<?php echo base_url($data['spzb'][2]['pic_src'])?>" /></a>
					</div>
				</div>
			</div>

			<div id="link">
				<div id="link-t">
					<h2 id="summer-tzgg"><a target="_blank" href="<?php echo site_url('news/li/10') ?>" >通知公告</a></h2>
					<h2 id="summer-jygy" style="background:none;"><a target="_blank" href="<?php echo site_url('news/li/11') ?>" >交院光荫</a></h2>
					<div id="more-wrap">
						<a id="tzgg-jygy-more" href="<?php echo site_url('news/li/10') ?>">更多<img src="<?php echo base_url('/source/ft/xww/images/triangle.jpg') ?>"></a>
					</div>
				</div>
				<div class="link-and-notice">
					<ul id="tzgg-wrapper" class="notice institute-list">
						<?php foreach ($data['tzgg'] as $v) {?>
						<li><a target="_blank" href="<?php echo site_url('news/archive/' . $v['news_id']) ?>"><?php echo $v['title'] ?></a><span><?php echo $v['add_time'] ?></span></li>
						<?php }
?>
					</ul>
					<ul id="jygy-wrapper" style="display:none;" class="notice institute-list">
						<?php foreach ($data['jygy'] as $v) {?>
						<li><a target="_blank" href="<?php echo site_url('news/archive/' . $v['news_id']) ?>"><?php echo $v['title'] ?></a><span><?php echo $v['add_time'] ?></span></li>
						<?php }
?>
					</ul>
					<div id="link-con">
						<a href="http://www.svtcc.edu.cn" target="_blank">
							<img src="<?php echo base_url('/source/ft/xww/images/school_home.jpg')?>" />
						</a>
						<a href="http://scjyyb.svtcc.edu.cn" target="_blank">
							<img src="<?php echo base_url('/source/ft/xww/images/yb.jpg')?>" />
						</a>
						<a href="http://weibo.com/u/5168125807" target="_blank">
							<img src="<?php echo base_url('/source/ft/xww/images/weibo.jpg')?>" />
						</a>
						<a target="blank" href="<?php echo base_url('/source/erwima.jpg') ?>">
							<img src="<?php echo base_url('/source/ft/xww/images/weixin.jpg')?>" />
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="right-wrap">
		<!--图片新闻-->
		<div id="pic-news">
			<div id="pic-news-t">
				<h2><a target="_blank" href="<?php echo site_url('photo/index/8') ?>" >图片新闻</a></h2>
				<div id="more-wrap">
					<a href="<?php echo site_url('photo/index/8') ?>">更多<img src="<?php echo base_url('/source/ft/xww/images/triangle.jpg')?>"></a>
				</div>
			</div>
			<div id="pic-news-con">
				<div id="pic1">
					<a href="<?php echo site_url('/photo/archive/'.$data['picnews'][0]['id']) ?>"><img src="<?php echo base_url($data['picnews'][0]['src'] )?>" /></a>
					<a href="<?php echo site_url('/photo/archive/'.$data['picnews'][0]['id']) ?>"><p  style="margin-top:5px;text-align:center;"><?php echo $data['picnews'][0]['title']?></p></a>
				</div>
				<?php unset($data['picnews'][0]) ?>
				<?php foreach($data['picnews'] as $v){ ?>
				<div id="pic2">
					<a href="<?php echo site_url('/photo/archive/'.$v['id']) ?>"><img src="<?php echo base_url($v['src'])?>" /></a>
				</div>
				<?php } ?>
			</div>
		</div>
		<div id="media-jy">
			<div id="media-jy-t" style="margin-bottom:15px;">
				<h2><a href="<?php echo site_url('news/mtjy/2.html') ?>">媒体交院</a></h2>
				<div id="more-wrap">
					<a href="<?php echo site_url('news/mtjy/2.html') ?>">更多<img src="<?php echo base_url('/source/ft/xww/images/triangle.jpg')?>"></a>
				</div>
			</div>
			<div id="media-jy-list" >
				<ul class="hot-newspaper-pic">
					<li>
						<div class="newspaper">
							<img src="<?php echo base_url('/source/mtjylogo.jpg')?>" />
						</div>
						<a target="blank" href="<?php echo $data['mtjy'][0]['come_from'] ?>"><?php echo $data['mtjy'][0]['title'] ?> (<?php echo date('Y-m-d', $data['mtjy'][0]['add_time'])  ?>)</a>
					</li>
					<li>
						<div class="newspaper">
							<img src="<?php echo base_url('/source/mtjylogo.jpg')?>" />
						</div>
						<a target="blank" href="<?php echo $data['mtjy'][1]['come_from'] ?>"><?php echo $data['mtjy'][1]['title'] ?> (<?php echo date('Y-m-d', $data['mtjy'][1]['add_time'])  ?>)</a>
					</li>
				</ul>
				<ul style="clear:both" class="hot-newspaper">
				<?php unset($data['mtjy'][0]) ?>
				<?php unset($data['mtjy'][1]) ?>
				<?php foreach($data['mtjy'] as $v) { ?>
					<li>
						<a target="blank" href="<?php echo $v['come_from'] ?>"><?php echo $v['title'] ?></a><span>(<?php echo date('Y-m-d', $v['add_time']) ?>)</span>
					</li>
				<?php } ?>
				</ul>
			</div>
		</div>
	</div>

</div>	
<div id="roll-pic">
	<div id="roll-pic-t">
		<h2><a href="<?php echo  site_url('photo/index/7') ?>" >光影交院</a></h2>
		<div id="more-wrap">
			<a href="<?php echo site_url('photo/index/7') ?>">更多<img src="<?php echo base_url('/source/ft/xww/images/triangle.jpg')?>"></a>
		</div>
	</div>
	<div id="roll-pic-con">
		<table border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<?php foreach($data['gyjy'] as $v ) {?>
					<td valign="top" class="pic-td" >
						<a class="y-gyjy-img-wrap" href="<?php echo site_url('photo/archive/'.$v['news_id']) ?>">
							<img alt="<?php echo $v['title'] ?>" src="<?php echo base_url($v['photoes'][0] -> src)?>" />
						</a>
					</td>
				<?php } ?>
			</tr>
		</table>
	</div>
</div><!-- 
<div id="friend-link">
	<ul>
		<li class="first">链接：</li>
		<li><a href="javascript:;">人民网</a></li>
		<li><a href="javascript:;">新华网</a></li>
		<li><a href="javascript:;">光明网</a></li>
		<li><a href="javascript:;">教育新闻网</a></li>
	</ul>
</div> -->
<div id="footer">
	<div id="footer-con">
		<div class="footer-left">
			<p>Copyright © 2013 SVTCC.EDU.CN(建议采用IE7.0及以上版本浏览器)</p>
			<p>地址：四川省成都市温江区柳台大道东段208号 邮编：611130 </p>
		</div>
		<div class="footer-right">
			<p>联系我们：QQ:1206550156</p>
			<p>Email：QQ:1206550156@qq.com</p>
		</div>
	</div>
</div>


<script type="text/javascript">
Qfast.add('widgets', { path: "<?php echo base_url('/source/ft/xww/js/terminator2.2.min.js') ?>", type: "js", requires: ['fx'] });  
Qfast(false, 'widgets', function () {
	K.tabs({
		id: 'fsD1',   //焦点图包裹id  
		conId: "D1pic1",  //** 大图域包裹id  
		tabId:"D1fBt",  
		tabTn:"a",
		conCn: '.fcon', //** 大图域配置class       
		auto: 1,   //自动播放 1或0
		effect: 'fade',   //效果配置
		eType: 'click', //** 鼠标事件
		pageBt:true,//是否有按钮切换页码
		bns: ['.prev', '.next'],//** 前后按钮配置class                          
		interval: 4000  //** 停顿时间  
	}) 
	
});  

$(function(){
	var tzgg = $("#summer-tzgg");
	var jygy = $("#summer-jygy");
	var taggW = $("#tzgg-wrapper");
	var jygyW = $("#jygy-wrapper");
	var more = $("#tzgg-jygy-more");
	var tzggUrl = "<?php echo site_url('news/li/10') ?>";
	var jygyUrl = "<?php echo site_url('news/li/11') ?>";
	tzgg.on("mouseover", function(){
		tzgg.css('background-color', '#f2f2f2');
		jygy.css('background-color', '#fff');
		taggW.show();
		jygyW.hide();
		more.attr("href", tzggUrl);
	});

	jygy.on("mouseover", function(){
		jygy.css('background-color', '#f2f2f2');
		tzgg.css('background-color', '#fff');
		jygyW.show();
		taggW.hide();
		more.attr("href", jygyUrl);
	});

});
</script>

<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?c200de71d236dd222d1b3fb1bf7264d0";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

</body>
</html>
