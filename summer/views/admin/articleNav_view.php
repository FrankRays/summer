<?php defined('BASEPATH') || exit('no direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?php echo base_url('source/css/style.css') ?>" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="<?php echo base_url('source/js/jquery.js') ?>"></script>
<script>
/*
    $('document').ready(function(){
        $('li').click(function(){
            console.log($(this).children());
            $(this).children('ul').css('display', 'block');
        });
    });
*/
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
        <li class="admin-parent"><cite></cite><a href="<?php echo site_url('admin/news/categoryLi/'.$v['id']) ?>" target="rightFrame"><?php echo $v['name'] ?></a>
        <?php }
        if( ! empty($v['child'])){
        ?>
            <ul class="admin-child menuson" style="">
            <?php foreach($v['child'] as $twok => $twov){ ?>
                     <li style="padding-left:10px;" ><cite></cite><a href="<?php echo site_url('admin/news/categoryLi/'.$v['id']) ?>" target="rightFrame"><?php echo $twov['name'] ?></a></li>
                
            <?php } ?>
            </ul>
        <?php } ?>
        </li>
        <?php } ?>
        <!--<li class="active"><cite></cite><a href="right.html" target="rightFrame">数据列表</a><i></i></li>-->
        </ul>    
    </dd>
    </dl>
    
</body>
</html>
