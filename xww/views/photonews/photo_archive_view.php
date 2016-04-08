<div id="recent-news-con">
		<div id="pic-container">
		<div id="location-bar">
			<p>
			<i  class="fi-marker location-icon"></i>您的位置：
			<a id="pos1" href="<?php echo site_url() ?>" >交院新闻网</a> > 
			<a href="<?php echo site_url('photo/index/'.$data['article']['category_id']) ?>">
			<?php echo $data['article']['category_name'] ?></a></p>
		</div>
			<!--瀑布流  start-->

			<div class="summer_pic_tit">
				<h2><?php echo $data['article']['title'] ?></h2>
				<p class="cur-news-info" style="font-size:13px;">
					<?php echo date('Y-m-d', $data['article']['add_time']) ?>&nbsp; | &nbsp;发布人：宣传统战部 &nbsp; | &nbsp; 点击:<?php echo $data['article']['hits'] ?> &nbsp;| &nbsp;来稿：<?php echo $data['article']['come_from'] ?>


					<a class="summer_pic_zan"><i class="fi-like"></i>赞(<span><?php echo $data['article']['zan'] ?></span>)</a>
				</p>
			</div>

			<div class="slider summer-big-pic-wrapper" id="slider">
				<ul class="sliderbox">
					<li class=""><img src="<?php echo base_url($data['curPic']['src'])?> " alt="<?php echo $data['curPic']['desc']?>">
					</li>
				</ul>
				<div class="prev" style="display:none"><a href="<?php echo $data['prePic'] ?>"></a></div>
				<div class="next" style="display:none"><a href="<?php echo $data['nextPic'] ?>"></a></div>
			</div>


			<p class="per_pic_desc"><?php echo $data['curPic']['desc'] ?></p>

			<div class="slider" id="summer_more">
				<ul class="sliderbox summer_more_sliderbox_ul">
				<?php foreach($data['article']['photoes'] as $k=>$v) { ?>
					<li class="<?php echo $k==$data['cur_pic_index'] ? 'current first' : ''; ?>">
						<div><a href="<?php echo site_url('/photo/archive/'.$data['article']['news_id'].'/'.$k) ?>"><img src="<?php echo base_url($v->src) ?>" alt="HTML代码"/></a></div>
					</li>

				<?php } ?>
				</ul>
				<ul class="slidernav"></ul>
				<div class="prev" style="display:none">&lt;</div>
				<div class="next" style="display:none">&gt;</div>
			</div>
			<p class="all_pic_desc"><?php echo $data['article']['summary'] ?></p>		

			<div class="slider summer_pic_best_wrapper" id="slider">
				<h2 class="summer-pic-best-tit">最新图片<a href="<?php echo site_url('photo/index/'.$data['article']['category_id']) ?>" class="summer-pic-best-tit-right">更多>></a></h2>
				<ul class="sliderbox summer_pic_best">
				<?php foreach($data['articles'] as $k=>$v) { ?>
					<li class="">
					<a href="<?php echo site_url('photo/archive/'.$v['id']) ?>"><img src="<?php echo base_url($v['photoes']['0']->src)?> ">
					</a>
						<p><a href="<?php echo site_url('photo/archive/'.$v['id']) ?>"> <?php echo $v['title'] ?></a></p>
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
				$.ajax('<?php echo site_url('zan/add_zan/'.$data['article']['news_id']) ?>').then(function(){
					var s = $(".summer_pic_zan").css('cursor', 'default').css('color', '#ff822d');
					s.find('span').html(parseInt(s.find('span').html()) + 1);
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
	</script>