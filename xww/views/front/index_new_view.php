<!DOCTYPE html>
<html>
<head>
<title>tw</title>
<link rel="sheetstyle" href="/source/ft/tw/main.new.css" />
<script src="http://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
<script src="<?php echo base_url('/source/ckplayer/ckplayer.js') ?>"></script>
<script src="<?php echo base_url('/source/layer/layer.min.js') ?>"></script>
<style>
  *{margin:0;padding:0}
  body{background-color:#eaeaea;}
  a{text-decoration:none;color:#414141;}
  ul{list-style: none;}
  #header{width:100%;height:120px;background:#fff;border-bottom:2px solid #11dd11;}
  #top{width:1020px;margin:0 auto;position:relative;height:120px;}
  #logo{width:230px;height:120px;position:absolute;}
  #nav{width:750px;height:65px;position:absolute;right:0;bottom:5px;}
  #nav ul{margin-left:80px;}
  #container{position:relative;width:1020px;margin:15px auto;height:1175px;}
  #container>div{overflow:hidden;position:absolute;background:#fff;border-radius:2px;border:solid 1px #d1d1d1;box-shadow:0px 0px 2px 1px #dfdfdf;}
  #wdqc{width:65%;height:400px;}
  #container>div a:hover{color:#ff5555;text-decoration:underline;}
  #icon-board{width:65%;height:80px;top:415px;left:0;}
  #tqkd{width:33%;height:300px;right:0;top:0;}
  #sztz{width:33%;height:280px;right:0;top:315px;}
  #video{width:27%;height:400px;top:510px;left:0;}
  #notice{width:36%;height:400px;left:29%;top:510px;}
  #shsj{width:33%;height:300px;right:0;top:610px;}
  #gyjy{width:100%;height:174px;top:925px;}
  #footer{height:100px;width:100%;background:#dd1111;}


  .tit1-wrap{height:30px;padding-top:5px;padding-left: 15px;padding-right: 15px;}
  .tit1-in-wrap{border-bottom:2px #dd1111 solid;height:30px;position: relative;}
  .tit1-wrap h2{position:absolute;left:0px;bottom:4px;font-size:22px;}
  .tit1-wrap h2 a{color:#dd1111;}
  .tit1-wrap .more{position:absolute;right:0px;bottom:4px;font-size:16px;}

  .wdqc-left{width:340px;padding-top:15px;margin-left:15px;}
  .wdqc-big-img img{top:15px;width:340px;height:225px;border:1px solid #ff9999;}
  .wdqc-lit-img{bottom: 0px;padding:0;list-style: none;margin-top:10px;}
  .wdqc-lit-img li{width:33%;float:left;height:80px;}
  .wdqc-lit-img img{width:100%;border:3px solid #dd1111;height:80px;}
  .wdqc-right{width:275px;height:400px;position: absolute;top:50px;right:0;}
  .wdqc-right i{width:3.5px;height:3.5px;margin-left:-12px;margin-top:10px;position: absolute;background:#dd1111;display: block;}
  .wdqc-right li{padding-top:7px;padding-bottom:7px;border-bottom: dotted 1px #dddddd;}
  .wdqc-right a{font-size:17px;}
  .tqkd-ul-wrap{padding-left:15px;padding-right: 15px;margin-top:15px;}
  .tqkd-ul-wrap li{padding-top:5px;padding-bottom: 5px;}
  #notice ul, #shsj ul, #sztz ul{padding-left:15px;padding-right:15px;margin-top:15px;}
  #notice ul li, #shsj ul li, #sztz ul li{padding-top:6px;padding-bottom: 6px;}
  #notice ul li span{float: right;}
  .gyjy-img-wrap{width:10000px;position: absolute;left:0;}
  .gyjy-img-wrap ul{float: left;position: absolute;left:0;}
  .gyjy-img-wrap ul li{width:255px;float: left;}
  .gyjy-img-wrap li img{width:100%;height:170px;}
  #gyjy-pre{width:30px;height:60px;display: block;position: absolute;left:-10px;top:60px;}
  #gyjy-next{width: 30px;height:60px;display: block;position: absolute;;right:10px;top:60px;}
  #nav ul li{float:left;padding-left:5px;padding-right:5px;}
  #nav ul li a{line-height: 45px;padding-left:5px;padding-right:5px;border-radius:5px;font-size: 17px;float:left;}
  #nav ul li a:hover{background: #dd1111;color: #fff;}
  #nav ul{padding-top:20px;}
  #logo img{height:120px;}
  #friendlink {position:absolute;bottom: 0px;height:60px;width:100%;}
  #friendlink ul{float:left;padding-left:20px;}
  #friendlink h2{float:left;line-height: 60px;padding-left:15px;}
  #friendlink li{float:left;line-height:60px;padding-left:10px;padding-right:10px;}
  #footer-wrap{width:1020px;margin:0 auto;}
  #footer-wrap p{text-align:right;padding-top:30px;padding-right:15px;color:#ffdddd;font-size:14px;}
  #video ul li img{width:90%;margin-top:15px;height:100px;}
  #video ul li{text-align:center;}
  #icon-board ul li{margin-top:6px;padding-left:6px;padding-right:6px;float:left;}
  #icon-board ul li img{width:70px;height:70px;}
  #wstx-icon{line-height: 70px;}
</style>
</head>
<body>
<div id="header">
    <div id="top">
	    <div id="logo"><a href="<?php echo site_url() ?>"><img src="/source/ft/tw/image/head_bg.png"/></a></div>
	    <div id="nav">
        <ul>
          <?php foreach($lmList as $k=>$v){ ?>
            <li class="active"><a href="<?php echo $v['link_src'] ?>"><?php echo $v['name'] ?></a></li>
          <?php } ?>
        </ul> 
      </div>
    </div>
</div>

<div id="container">
    <div id="wdqc">
        <div class="tit1-wrap">
          <div class="tit1-in-wrap">
             <h2><a href="#">wdqc</a></h2>
             <a class="more" href="#">More>></a> 
           </div>
        </div>

        <div class="wdqc-left">
          <div id="big-img" class="wdqc-big-img">
            <img src="./ysource/20141125/m_5e53ee5d66ebf8f04364eba7dc7f9efc.JPG" />
          </div>
          <ul id="li-img" class="wdqc-lit-img">
            <li><a href="#"><img src="./ysource/20141125/m_5e53ee5d66ebf8f04364eba7dc7f9efc.JPG" /></a></li>
            <li><a href="#"><img src="./ysource/20141124/m_d148cf5ed4e42730ceb1c4e80fb10707.JPG" /></a></li>
            <li><a href="#"><img src="./ysource/20141124/m_fb152bc523c0ccdcdd21624dfd460821.JPG" /></a></li>
          </ul>
        </div> 
        <div class="wdqc-right">
          <ul>
          <?php foreach($tqkd as $v){ ?>
            <li><i></i><a href="<?php echo site_url('news/archive/'.$v['news_id']) ?>"><?php echo $v['title'] ?></a></li>
          <?php } ?>
          </ul>
        </div>
    </div>
    <div id="tqkd">
      <div class="tit1-wrap">
        <div class="tit1-in-wrap">
           <h2><a href="#">wdqc</a></h2>
           <a class="more" href="#">More>></a> 
        </div>
      </div>

      <div>
        <ul class="tqkd-ul-wrap">
          <?php foreach($xbdt as $k=>$v){ ?>
            <li>
              <a href="<?php echo site_url('news/archive/'.$v['news_id']) ?>"><?php echo $v['title'] ?></a>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <div id="icon-board">
      <ul>
        <li><a href="#"><img src="<?php echo base_url('/source/ft/tw/image/weixin.jpg') ?>" /></a></li>
        <li><a href="#"><img src="<?php echo base_url('/source/ft/tw/image/weibo.jpg') ?>" /></a></li>
        <li><a href="#"><img src="<?php echo base_url('/source/ft/tw/image/chuangye.png') ?>" /></a></li>
        <li><a href="#"><img src="<?php echo base_url('/source/ft/tw/image/xinxiang.png') ?>" /></a></li>
        <li><a href="#"><img src="<?php echo base_url('/source/ft/tw/image/zhiyuan.png') ?>" /></a></li>
        <li><a href="#" id="wstx-icon">WSTX</a></li>
      </ul>
    </div>
    <div id="sztz">
      <div class="tit1-wrap">
        <div class="tit1-in-wrap">
           <h2><a href="#">wdqc</a></h2>
           <a class="more" href="#">More>></a> 
        </div>
      </div>

      <ul>
        <?php foreach($zyz as $k=>$v){ ?>
          <li><a href="<?php echo site_url('news/archive/'.$v['news_id']) ?>"><?php echo $v['title'] ?></a></li>
        <?php } ?>
      </ul>
    </div>
    <div id="notice">
      <div class="tit1-wrap">
        <div class="tit1-in-wrap">
           <h2><a href="#">wdqc</a></h2>
           <a class="more" href="#">More>></a> 
        </div>
      </div>

      <ul>
        <?php foreach($tzgg as $k => $v){ ?>
          <li><a href="<?php echo site_url('news/archive/'.$v['news_id']) ?>"><?php echo $v['title'] ?></a><span><?php echo date('Y-m-d', $v['add_time']) ?></span></li>
        <?php } ?>
      </ul>
    </div>
    <div id="video">
      <div class="tit1-wrap">
        <div class="tit1-in-wrap">
           <h2><a href="#">wdqc</a></h2>
           <a class="more" href="#">More>></a> 
        </div>
      </div>

      <div class="vedio-wrap">

      <ul>
        <li><img src="/source/ft/tw/image/1.png" /></li>
        <li><img src="/source/ft/tw/image/1.png" /></li>
        <li><img src="/source/ft/tw/image/1.png" /></li>
      </ul>

      <div id="a1" style="display:none;"></div>
        <script type="text/javascript">
            var flashvars={
                f:'http://movie.ks.js.cn/flv/other/1_0.mp4',
                c:0,
                loaded:'loadedHandler'
            };
            var video=['http://movie.ks.js.cn/flv/other/1_0.mp4->video/mp4'];
            CKobject.embed('ckplayer/ckplayer.swf','a1','ckplayer_a1','600','400',false,flashvars,video);
        </script>
      </div>
      
    </div>
    <div id="shsj">
      <div class="tit1-wrap">
        <div class="tit1-in-wrap">
           <h2><a href="#">wdqc</a></h2>
           <a class="more" href="#">More>></a> 
        </div>
      </div>

      <ul>
        <?php foreach($zt as $k=>$v){ ?>
          <li><a href="<?php echo site_url('news/archive/'.$v['news_id']) ?>"><?php echo $v['title'] ?></a></li>
        <?php } ?>
      </ul>
      
    </div>
    <div id="gyjy">
      <div  class="gyjy-img-wrap">
          <ul id="gyjy-ul">
            <?php foreach($gyjyPic as $k=>$v){ ?>
            <li>
              <a href="#"><img src="<?php echo base_url($v['file']['pathname']) ?>" /></a>
            </li>
            <li>
              <a href="#"><img src="<?php echo base_url($v['file']['pathname']) ?>" /></a>
            </li>
            <?php } ?>
          </ul>
      </div>

      <a id="gyjy-pre" href="javascript:;"><img src="<?php echo  base_url('source/ft/tw/css/prev.png') ?>"/></a>
      <a id="gyjy-next" href="javascript:;"><img src="<?php echo base_url('source/ft/tw/css/next.png') ?>"/></a>
    </div>

    <div id="friendlink">
      <h2>Frient</h2>
      <ul>
      <?php foreach($friendLink as $v){ ?>
        <li><a href="<?php echo 'http://'.$v['link_url'] ?>"><?php echo $v['name'] ?></a></li>
      <?php } ?>
      </ul>
    </div>
</div>
<div id="footer">
  <div id="footer-wrap">
    <p>createBy ykjver</p>
  </div>
</div>

<script>
	$(function(){ 
    function wdqcSlide(){
      var bigImg = $('#big-img').find('img');
      var liImg = $('#li-img').find('img');
      var curImg = 0;
      var numImg = liImg.length;
      var timer = setInterval(function(){
        bigImg.fadeOut(0);
        curImg ++;
        if(curImg >= numImg){
          curImg = 0;
        }
        bigImg.fadeIn(100);        
        bigImg.attr('src', liImg.eq(curImg).attr('src'));
      }, 3000);

      liImg.hover(
        function(){
          curImg = $(this).index();
          bigImg.attr('src', $(this).eq(curImg).attr('src'));
          clearInterval(timer);
        },
        function(){
          timer = setInterval(function(){
          bigImg.fadeOut(0);
          curImg ++;
          if(curImg >= numImg){
            curImg = 0;
          }
          bigImg.fadeIn(100);        
          bigImg.attr('src', liImg.eq(curImg).attr('src'));
      }, 3000);

        }
        );
    }

    wdqcSlide();

    $('#video').on('click', function(){
      $.layer({
          type: 1,
          title: false,
          area: ['auto', 'auto'],
          border: [1], //去掉默认边框
          shade: [1], //去掉遮罩
          shift: 'left', //从左动画弹出
          page: {
              html: function(){console.log($('#a1').html());return $('#a1').html()}()
          }
      });
    });




    var gyjyUl = $('#gyjy-ul');
    var gyjyUlLength = parseInt(gyjyUl.css('width'));
    var gyjyLiLength = parseInt(gyjyUl.find('li').eq(0).css('width'));
    var gyjyUlLeft = 0;
    $('#gyjy-next').on('click', function(){
      if(gyjyUlLeft < 0){
        gyjyUlLeft = gyjyUlLeft + gyjyLiLength;
      }else{
        gyjyUlLeft = 4*gyjyLiLength - gyjyUlLength;
      }
      gyjyUl.animate({left : gyjyUlLeft + 'px'}, 300);
    });
    $('#gyjy-pre').on('click', function(){
      if(gyjyUlLeft > (4*gyjyLiLength - gyjyUlLength)){
        gyjyUlLeft = gyjyUlLeft - gyjyLiLength;
      }else{
        gyjyUlLeft = 0;
      }
      gyjyUl.animate({left : gyjyUlLeft + 'px'}, 300);  
    });
    gyjyTimer = setInterval(function(){
      if(gyjyUlLeft < 0){
        gyjyUlLeft = gyjyUlLeft + gyjyLiLength;
      }else{
        gyjyUlLeft = 4*gyjyLiLength - gyjyUlLength;
      }
      gyjyUl.animate({left : gyjyUlLeft + 'px'}, 300);
    }, 3000);

	})
</script>
</body>
</html>
