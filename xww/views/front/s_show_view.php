<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>四川交院人文艺术系</title>
<link href="<?php echo base_url('css/front/share.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/front/teacher_show.css'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('js/front/up2.js'); ?>" ></script>
</head>

<body>

<div class="header">
	<div class="header_box">
    	<div class="logo"></div>
        <div class="menu">
        	<ul>
              <?php foreach($lm_list as $v)  { ?>
                <li><a href="<?php echo $v['link_src']  ?>"><?php echo  $v['name'] ?></a></li>
              <?php } ?>
            </ul>
        </div>
    </div>
</div>
<div class="content">
	<div class="banner"><img src="<?php echo base_url($lm_pic_src) ?>"/></div>
	<div class="left">
    
    	<div class="box04" >
						<div class="part02">
							<div class="breakNewsblock">
								<div id="breakNews">
								<h5>通知公告<span><a href="<?php echo $tzgg_link; ?>">更多>></a></span></h5>
									<ol>
                                        <?php foreach ($tz_list as $v) {  ?>       
										<li><a href="<?php echo site_url('index.php/news/show/'.'tzgg'.'/'.$v['news_id']) ?>"><?php echo $v['title'] ?></a></li>
                                        <?php } ?>
									</ol>
								</div>
							</div>
						</div>
                    </div>
                    
    </div>
    <div class="right">
    	<h4>当前位置：<a href="<?php echo site_url('index.php/rw') ?>">首页</a> >><a href="<?php echo site_url('index.php/student/li/'.$lm_alias) ?>"><?php echo $lm_name; ?></a> >> 学生详情</h4>
      <h2><?php echo $student_con['name'] ?></h2>
        <div class="p" >
              <div class="con"><?php echo $student_con['content'] ?></div>
              <div class="pic"><img src="<?php echo base_url($student_con['pic_src']) ?>"></div>
        </div>        
    </div>
</div>


<div class="footer">
	   <div class="footer_top">
      <div class="download">
        <h1>文件下载</h1>
        <ul>
            <li><a href="#">常用文档</a> </li>
            <li><a href="#">常用表格</a> </li>
            <li><a href="#">常用表格</a> </li>
      	</ul>
      </div>
      <div class="contact">
        <h1>联系我们</h1>
        <ul>
            <li><a href="#">主任邮箱</a> </li>
            <li><a href="#">书记邮箱</a> </li>
            <li><a href="#">学生工作邮箱</a></li>
      	</ul>
      </div>
 	  <div class="friend">
    	<h1>友情链接</h1>
        <ul>
            <li><a href="http://www.moc.gov.cn/">中华人民共和国交通运输部</a></li>
            <li><a href="http://www.scjt.gov.cn/">四川省交通运输厅</a></li>
            <li><a href="http://www.scedu.net/">四川省教育厅</a></li>
            <li><a href="http://www.moc.gov.cn/">中华人民共和国交通运输部</a></li>
            <li><a href="http://www.scjt.gov.cn/">四川省交通运输厅</a></li>
            <li><a href="http://www.scedu.net/">四川省教育厅</a></li>
            <li><a href="http://www.moc.gov.cn/">中华人民共和国交通运输部</a></li>
            <li><a href="http://www.scjt.gov.cn/">四川省交通运输厅</a></li>
            <li><a href="http://www.scedu.net/">四川省教育厅</a></li>
            <li><a href="http://www.moc.gov.cn/">中华人民共和国交通运输部</a></li>
            <li><a href="http://www.scjt.gov.cn/">四川省交通运输厅</a></li>
            <li><a href="http://www.scedu.net/">四川省教育厅</a></li>
         
        </ul>
    </div> 
   </div>
   <div class="footer_bottom">
   <p>地址：四川省成都市温江区柳台大道东段208号 | 邮编：611130 | 电话号码：| 传真：    </p>
   <p>Copyright©zhp_2014四川交通职业技术学院 版权所有</p>
   </div>
</div>
</body>
</html>
