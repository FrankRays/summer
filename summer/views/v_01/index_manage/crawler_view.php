<?php
/**
 * Created by PhpStorm.
 * User: ykjverx
 * Date: 2015/3/12
 * Time: 22:52
 */
?>
<div class="admin-content" style="min-height:1400px;">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg"><?php echo $content['moduleName'] ?></strong> /
            <small><?php echo $content['moduleDesc'] ?></small>
        </div>
    </div>
    <div class="am-g" >
       <blockquote id="y-crawler-bq">
        <h2>抓取首页新闻中, 请等待......</h2>
      </blockquote>
    </div>
</div>

<script>
  $(function(){
    $.ajax({
      type : 'get',
      url : '/y.php?d=indexArticle&c=y&m=doCrawlerNew',
      success : function(){
        $("#y-crawler-bq").fadeOut();
        $("#y-crawler-bq h2").html('抓取首页新闻成功');
        $("#y-crawler-bq").fadeIn();
      },
      error : function(){
        alert('挖掘失败');
      }
    });
  });
</script>