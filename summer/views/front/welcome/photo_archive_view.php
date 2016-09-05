<?php defined('APPPATH') or exit('no access') ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>交院-新闻网</title>
	<link rel="stylesheet" href="<?php echo static_url('css/h/style.css') ?>">
	<link rel="stylesheet" href="<?php echo static_url('css/h/pic.css') ?>">
	<script src="<?php echo static_url('js/h/jquery-1.8.3.min.js') ?>"></script>
</head>
<body>
	<div class="top cf">
        <div class="thumb cf">
            <ul class="thumb-index"></ul>
        </div> 
        <div class="headline">
            <h1 title="<?php echo $article['title'] ?>"><?php echo $article['title'] ?></h1>
            <span><?php echo substr($article['publish_date'], 0, 10) ?> · 浏览：<?php echo $article['hits'] ?>次</span>
        </div>
        <div class="actions cf">
            <a href="javascript:;" hidefocus="true" class="vieworigin">赞</a>
            <div class="parting-line"></div>
            <a href="#" hidefocus="true" class="comment js-tielink">已有 <b><?php echo $article['love'] ?></b>人点赞</a>
        </div> 
	</div>
	<div class="f_scroll fl" style="margin-left:10%; margin-top:10px;">
		<ul>
		<?php foreach($photoes as $v){ ?>
	        <li>
	            <a href="javascript:;" class="fscroll_link"><img src="<?php echo resource_url($v['pathname']) ?>" onerror="errorImg(this);" alt="">
	            	<div class="fscroll_tit">
	                	<div class="progress"></div>
	            		<div class="fst_con"><?php echo $v['summary'] ?></div>
	            	</div>
	            </a>
	        </li>  

	    <?php } ?>
        </ul>
	</div>
	<div class="f_con fl">
		<p class="f_con_txt">
			<?php echo $article['content'] ?>
		</p>
	</div>
	<script src="<?php echo static_url('js/h/picscroll.js') ?>" ></script>
	<script type="text/javascript">

		$(function(){
			//点赞
			$(".vieworigin").on('click', function(e){
			$.ajax({
				'url' : "<?php echo site_url('welcome/do_like_ajax').'?article_id='.$article['id'] ?>",
				'type' : 'get',
				'dataType' : 'json',
				'success' : function(res, mes){
					if(mes == 'success') {
						alert(res.message);
					}else{
						alert('系统错误，请稍后重试');
					}
				}
				}
				)
			});

			$('.f_scroll').daqScroll({
			    direction : "left",
			    timeout : 5000,
			    width : $(window).width()*2/3,
			    height : $(window).height() - 100,
			    autoSlider : true,
			    showBtn : true,
			    direction : 'fade'
			});
		})
	</script>
</body>
</html>