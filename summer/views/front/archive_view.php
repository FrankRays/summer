<?php

defined('APPPATH') || exit('no access');

require 'header_view.php';
?>
<div id="recent-news-con" style="overflow: hidden;">
		<div id="recent-news-left">
			<div id="location-bar">
				<p><i  class="fi-marker location-icon"></i>您的位置：<?php echo $bread_path ?></p>
			</div>
			<div class="news-con-wrap">
				<div class="cur-news-tit">
					<h3><?php echo $article['title'] ?></h3>
					<p class="cur-news-info" style="font-size:13px;">
						<?php echo $article['publish_date'] ?>&nbsp; | &nbsp;发布人：<?php echo $article['publisher_name'] ?> &nbsp; | &nbsp; Hits:<?php echo $article['hits'] ?> &nbsp;| &nbsp;来稿：<?php echo $article['author_name'] ?>
					</p>
				</div>
				<div class="cur-news-article">
					<?php echo $article['content'] ?>
				</div>
				<div class="article-page">
					上一条：<?php echo $next_article ?><br/>
					下一条：<?php echo $prev_article ?>
				</div>
			</div>
		</div>
	</div>

<?php 
require 'footer_view.php';
?>