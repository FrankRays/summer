<?php defined('BASEPATH') || exit('no direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?php echo base_url('source/css/style.css') ?>" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="<?php echo base_url('source/js/jquery.js') ?>"></script>

<script type="text/javascript">
$(function(){	
	
	$('.title').click(function(){
		var $ul = $(this).next('ul');
		$('dd').find('ul').slideUp();
		if($ul.is(':visible')){
			$(this).next('ul').slideUp();
		}else{
			$(this).next('ul').slideDown();
		}
	});



});


</script>


</head>

<body style="background:#f0f9fd;">
	<div class="lefttop"><span></span>导航面板</div>
    
    <dl class="leftmenu">
        
    <dd>
    <div class="title">
    <span><img src="<?php echo base_url('source/images/leftico01.png') ?>" /></span>新闻管理
    </div>
    	<ul class="menuson">
        <?php foreach($categoryList as $v){ ?>
        <?php if($v['lev'] == 1){ ?>
        <li class="admin-parent"><cite></cite><a href="<?php echo site_url('admin/news/categoryLi/'.$v['id']) ?>" target="rightFrame"><?php echo $v['name'] ?></a><i></i>
        <?php }
        if( ! empty($v['child'])){
        ?>
            <ul class="admin-child menuson" style="">
            <?php foreach($v['child'] as $twok => $twov){ ?>
                     <li style="padding-left:10px;" ><cite></cite><a href="<?php echo site_url('admin/news/categoryLi/'.$v['id']) ?>" target="rightFrame"><?php echo $twov['name'] ?></a><i></i></li>
                
            <?php } ?>
            </ul>
        <?php } ?>
        </li>
        <?php } ?>
        <!--<li class="active"><cite></cite><a href="right.html" target="rightFrame">数据列表</a><i></i></li>-->
        </ul>    
    </dd>
        
    
    <dd>
    <div class="title">
    <span><img src="<?php echo base_url('source/images/leftico02.png') ?>" /></span>导航栏管理
    </div>
    <ul class="menuson">
        <li><cite></cite><a href="<?php echo site_url("admin/lm/add") ?>" target="rightFrame">添加导航栏</a><i></i></li>
        <li><cite></cite><a href="<?php echo site_url("admin/lm/li") ?>" target="rightFrame">导航栏列表</a><i></i></li>
        <!--<li><cite></cite><a href="#">档案列表显示</a><i></i></li>-->
        </ul>     
    </dd> 

    <dd>
    <div class="title">
    <span><img src="<?php echo base_url('source/images/leftico02.png') ?>" /></span>优秀学生
    </div>
    <ul class="menuson">
        <li><cite></cite><a href="<?php echo site_url("admin/student/add") ?>" target="rightFrame">添加学生</a><i></i></li>
        <li><cite></cite><a href="<?php echo site_url("admin/student/li") ?>" target="rightFrame">学生列表</a><i></i></li>
        <!--<li><cite></cite><a href="#">档案列表显示</a><i></i></li>-->
        </ul>     
    </dd> 
    
    <dd>
    <div class="title">
    <span><img src="<?php echo base_url('source/images/leftico02.png') ?>" /></span>友情链接
    </div>
    <ul class="menuson">
        <li><cite></cite><a href="<?php echo site_url("admin/friendlink/add") ?>" target="rightFrame">添加友情链接</a><i></i></li>
        <li><cite></cite><a href="<?php echo site_url("admin/friendlink/li") ?>" target="rightFrame">友情链接列表</a><i></i></li>
        <!--<li><cite></cite><a href="#">档案列表显示</a><i></i></li>-->
        </ul>     
    </dd>   

    <dd>
    <div class="title">
    <span><img src="<?php echo base_url('source/images/leftico02.png') ?>" /></span>Category Mg
    </div>
    <ul class="menuson">
        <li><cite></cite><a href="<?php echo site_url("admin/news/categoryAdd") ?>" target="rightFrame">Add Category</a><i></i></li>
        <li><cite></cite><a href="<?php echo site_url("admin/news/categoryList") ?>" target="rightFrame">Category List</a><i></i></li>
        <!--<li><cite></cite><a href="#">档案列表显示</a><i></i></li>-->
        </ul>     
    </dd>  

    <dd>
    <div class="title">
    <span><img src="<?php echo base_url('source/images/leftico02.png') ?>" /></span>Slide Mg
    </div>
    <ul class="menuson">
        <li><cite></cite><a href="<?php echo site_url("admin/slide/add") ?>" target="rightFrame">Add Slide</a><i></i></li>
        <li><cite></cite><a href="<?php echo site_url("admin/slide/li") ?>" target="rightFrame">Slide List</a><i></i></li>
        <!--<li><cite></cite><a href="#">档案列表显示</a><i></i></li>-->
        </ul>     
    </dd> 

    <dd>
    <div class="title">
    <span><img src="<?php echo base_url('source/images/leftico02.png') ?>" /></span>Video Mg
    </div>
    <ul class="menuson">
        <li><cite></cite><a href="<?php echo site_url("admin/video/add") ?>" target="rightFrame">add Add</a><i></i></li>
        <li><cite></cite><a href="<?php echo site_url("admin/video/li") ?>" target="rightFrame">Video List</a><i></i></li>
        <!--<li><cite></cite><a href="#">档案列表显示</a><i></i></li>-->
        </ul>     
    </dd> 

    </dd>  
    

    </dl>
    
</body>
</html>
