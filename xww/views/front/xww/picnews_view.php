<div id="recent-news-con">
		<div id="recent-news-left">
		<div id="location-bar">
			<p><i  class="fi-marker location-icon"></i>您的位置：<a id="pos1" href="<?php echo site_url() ?>" >交院新闻网</a> > 光影交院</p>
		</div>
			<!--瀑布流  start-->
			<div id="wrapper">
				<div id="container" style="width:660px;">
				<?php foreach($pics['img'] as $v){ ?>
					<div class="grid">
						<div class="imgholder">
							<img class="lazy thumb_photo"  src="<?php echo base_url('xww/third_party/floatpic/images/pixel.gif') ?>" data-original="<?php echo base_url($v) ?>" width="225" />
						</div>
					</div>
				<?php } ?>
				</div>
			</div>

			<!--瀑布流 end-->
		<!-- 	<div class="clear"></div>
			<div class="load_more">
				<span class="load_more_text">加载更多...</span>
			</div>
 -->

			<!--大图弹出层 start-->
			<div class="container">
				<div class="close_div">
					<img src="<?php echo base_url('xww/third_party/floatpic/images/closelabel.gif') ?>" class="close_pop" title="关闭" alt="关闭" style="cursor:pointer">　
				</div>
				<!-- 代码 开始 -->
				<div class="content">
					<span style="display:none"><img src="<?php echo base_url('xww/third_party/floatpic/images/load.gif') ?>" /></span>
					<div class="left"></div>
					<div class="right"></div>
					<img class="img" src="<?php echo base_url('xww/third_party/floatpic/images/1.jpg') ?>">
					<img class="img" src="<?php echo base_url('xww/third_party/floatpic/images/2.jpg') ?>">
					<img class="img" src="<?php echo base_url('xww/third_party/floatpic/images/3.jpg') ?>">
					<img class="img" src="<?php echo base_url('xww/third_party/floatpic/images/4.jpg') ?>">
				</div>
				<div class="bottom">共 <span id="img_count">x</span> 张 / 第 <span id="xz">x</span> 张</div>
				<!-- 代码 结束 -->
			</div><!--end-->

			<script type="text/javascript">
			$(document).ready(function(){

				var count = 14;
				// 点击加载更多
				$('.load_more').click(function(){
					//ajaxGetPhoto('')

					// var html = "";
					// var img = '';
					// for(var i = count; i < count+13; i++){
					// 	var n = Math.round(Math.random(1)*13);
					// 	var src = 'images/'+n+'.jpg';
					// 	html = html + "<div class='grid'>"+
					// 		"<div class='imgholder'>"+
					// 		"<img class='lazy thumb_photo' title='"+i+"' src='<?php echo base_url('xww/third_party/floatpic/images/pixel.gif') ?>' data-original='"+src+"' width='225' onclick='seeBig(this)'/>"+
					// 		"</div>"+
					// 		"</div>";
					// 	img = img + "<img class='img' src='"+src+"'>";
					// }
					// count = count + 13;
					// $('#container').append(html);
					// $('.content').append(img);
					// $('#container').BlocksIt({
					// 	numOfCol:4,  //每行显示数
					// 	offsetX: 5,  //图片的间隔
					// 	offsetY: 5   //图片的间隔
					// });
					// $("img.lazy").lazyload();
				});
			//load the big img
			layer.photosPage({
				'parent' : '#container',
				'start'  :  0,
				'title'  : 'guangyingjiaoyuan'
			});

			});

			</script>




		</div>
		<div id="recent-news-right">
			<div id="news-right-con">
				<div class="week-hot">
					<div class="week-hot-tit">
						<p class="hot-tit">一周热点</p>
					</div>
					<div class="hot-content">
						<a id="hot-link" href="<?php echo site_url('news/archive/'.$weekHot[0]['id']) ?>" >
							<img src="<?php echo  base_url('source/ft/xww/images/hot-01.jpg') ?>" />
							<p><?php echo $weekHot[0]['title'] ?></p>	
						</a>
						<a id="hot-link" href="<?php echo site_url('news/archive/'.$weekHot[1]['id']) ?>" >
							<img src="<?php echo  base_url('source/ft/xww/images/hot-02.jpg')?>" />
							<p><?php echo $weekHot[1]['title'] ?></p>	
						</a>
						<a id="hot-link" href="<?php echo site_url('news/archive/'.$weekHot[2]['id']) ?>" >
							<img src="<?php echo  base_url('source/ft/xww/images/hot-03.jpg') ?>" />
							<p><?php echo $weekHot[2]['title'] ?></p>	
						</a>
						<ul class="hot-ul">
							<li><a href="<?php echo site_url('news/archive/'.$weekHot[3]['id']) ?>"><?php echo $weekHot[3]['title'] ?></a></li>
							<li><a href="<?php echo site_url('news/archive/'.$weekHot[4]['id']) ?>"><?php echo $weekHot[4]['title'] ?></a></li>
						</ul>
					</div>
				</div>
				<div class="article-save">
					<div class="article-save-con">
						<div class="week-hot-tit">
							<p class="hot-tit">文章存档</p>
						</div>
						<div class="article-save-ul">
							<ul id="article-list">
								<li><a href="#">2014年12月</a></li>
								<li><a href="#">2015年1月</a></li>
							</ul>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

