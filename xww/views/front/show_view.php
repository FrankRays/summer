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


  <div class="content-wrap">
      <h3><?php echo $content['title'] ?></h3>
      <p class="news-info"><i></i>发布时间：<?php echo date('Y年m月d日', $content['add_time']) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="hits-icon"></i>阅读量：<?php echo $content['hits'] ?></p>
      <div class="news-content"><?php echo $content['content'] ?></div>
      <div id="imgs" class="imgs" >
          <?php foreach($content['imgs'] as $img){ ?>
            <img src="<?php echo '/'.$img ?>" />
          <?php } ?>
      </div>
      <div id="files">
        <?php foreach($content['downloadfile'] as $file){ ?>
        <h2>Download File</h2>
          <ul>
            <li><a href="<?php echo base_url($file['url']) ?>"><?php echo $file['title'] ?></a></li>
          </ul>
        <?php } ?>
      </div>
      <div class="pre-next">
        <p>上一页：<a href="<?php echo site_url('news/archive/'.$PreNext['Pre']['id']) ?>"><?php echo $PreNext['Pre']['title'] ?></a></p>
        <p>下一页：<a href="<?php echo site_url('news/archive/'.$PreNext['Next']['id']) ?>"><?php echo $PreNext['Next']['title'] ?></a></p>
      </div>
  </div>
</div>


<script>
  // layer.use('extend/layer.ext.js', function(){
  //     //初始加载即调用，所以需放在ext回调里
  //     layer.ext = function(){
  //         layer.photosPage({
  //             html: '<div style="padding:20px;">这里传入自定义的html<p>相册支持左右方向键，支持Esc关闭</p><p>另外还可以通过异步返回json实现相册。更多用法详见官网。</p><p>'+ unescape("%u8FD8%u6709%u5E0C%u671B%u5927%u5BB6%u5E73%u65F6%u6709%u7A7A%u70B9%u4E0B%u5B98%u7F51%u7684%u5E7F%u544A%u54C8%uFF0C%u4E00%u5929%u4E0D%u8981%u8D85%u8FC7%u4E00%u6B21%uFF0C%u8C22%u8C22%u62C9") +'</p><p id="change"></p></div>',
  //             title: '快捷模式-获取页面元素包含的所有图片',
  //             id: 112, //相册id，可选
  //             parent: '#imgs'
  //         });
  //     };
  // });
</script>