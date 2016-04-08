<div class="content-main-wrap">
  <div class="content-right-wrap">
    <div class="yw-notice-wrap">
        <div class="col-xs-12" style="border-bottom:2px #cc0000 solid;">
          <h3 class="col-xs-8" style="padding-left:0;">通知公告</h3>
          <a class="col-xs-4" href="<?php echo site_url('news/li/3') ?>">更多>></a>
        </div>
        <ul class="col-xs-12">
        <?php foreach($tzgg as $k => $v){ ?>
          <li><a href="<?php echo site_url('news/archive/'.$v['news_id']) ?>"><?php echo $v['title'] ?></a><span><?php echo date('Y-m-d', $v['add_time']) ?></span></li>
        <?php } ?>
        </ul>
      </div>
  </div>


  <div class="content-wrap content-list-wrap">
      <div class="right-tit-wrap">
          <p><span class="ahead" >当前位置：<a href="<?php echo site_url(); ?>">首页</a> >> <?php echo $categoryList['name'] ?></span></p>
      </div>
      <ul>  
        <?php foreach($newsList as $v){ ?>
          <li><i></i><a href="<?php echo site_url('news/archive/'.$v['news_id']) ?>"><?php echo $v['title'] ?></a><span><?php echo date('Y-m-d', $v['add_time']) ?></span></li>
        <?php } ?>
      </ul>
  </div>
</div>