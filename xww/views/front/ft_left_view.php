
<div style="clear:both;" class="list-content">
	<div class="list-left">
	 <div class="index-block" id="left-notice">
  			<h2><a class="index-title">通知公告</a><a class="more" href="<?php echo site_url('news/archive/3') ?>">更多>></a></h2>
  			<ul>
  				  <?php  if(!empty($tzgg))  {?>
  				  <?php  foreach($tzgg['newsList'] as $v) { ?>
  					<li><a href="<?php echo site_url('news/archive/'.$v['news_id']) ?>" title="<?php echo $v['title'] ?>"> <?php echo mb_strlen($v['title']) > 15 ? mb_substr($v['title'], 0, 15).' . . .' : $v['title']?></a></li>
  				  <?php } } ?>
  			</ul>
  </div>
                    
</div>
