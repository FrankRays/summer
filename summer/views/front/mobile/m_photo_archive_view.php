<?php defined('BASEPATH') || exit('no direct script access allowed'); 

require('header_view.php');
?>
	
	<div style="height:20px;background-color: rgb(238, 238, 238);width:100%">
		
	</div>
	<div class="container summer-article-container">
		<div class="row">
			<div class="col-sm-12 viewbox">
				<h1 class="summer-article-archive-title">
                	<?=$article['title']?>
                </h1>
				<div class="summer-article-archive-subtitle" style="padding-left:0px">
	                <div class="summer-article-archive-subtitle-a">
		                ·  <?php echo $article['author_name']?> · <?php echo substr($article['publish_date'], 5, 5) ?>
		                · <?php echo $article['hits'] == 0 ? 3 : $article['hits'] ?>次阅读 ·
	                </div>
	            </div>
				<div class="summer-content-view">
				<?php foreach($photoes as $v) { ?>
					<img src="<?php echo resource_url($v['pathname']) ?>" alt="<?php echo $v['title'] ?>" />
					<p><?php echo $v['summary'] ?></p>
				<?php } ?>
				</div>
				<div class="summer-m-like cl">
					<span class="summer-m-like-wrap">
						<a href="javascript:;" id="summer-like-btn">
							<i></i>
						</a>
					</span>
				</div>
				<p class="summer-m-like-num cl">
				已经有<?php echo $article['love'] == 0 ? 1 : $article['love'] ?>人点赞。
				</p>
			</div>
		</div>
	</div>


	<!-- //引入footer -->
	<?php require('footer_view.php') ?>
	<!-- //引入footer -->


 <!-- jQuery -->
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<!-- Bootstrap  -->
<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script type="text/javascript">

	$(function(){
		$("#summer-like-btn").on('click', function(e){
			$.post("<?php echo site_url('welcome/do_like_ajax')?>", {article : <?php echo $article['id']?>}, function(data, xhr){
				console.log(xhr);
				if(data == 'success') {
					alert(data.message);
				}else{
					alert('系统错误，请稍后重试');
				}

			});
		});
	});
</script>

</body>

</html>