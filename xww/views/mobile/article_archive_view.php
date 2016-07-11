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
		                ·  <?=$article['publisher']?> · <?=$article['create_date'] ?>
	                </div>
	                
	            </div>
				<div class="summer-content-view">
	                     <?=$article['content']?>
				</div>
				<div class="summer-m-like cl">
					<span class="summer-m-like-wrap">
					<a href="javascript:;" id="summer-like-btn">
						<i></i>
					</a>
				</span>
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
</html>