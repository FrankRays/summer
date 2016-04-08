<?php defined('BASEPATH') || exit('no direct script access allowed') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?php echo base_url('source/css/style.css') ?>" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="<?php echo base_url('source/js/jquery.js') ?>"></script>
<script language="JavaScript" src="<?php echo base_url('source/js/ykjver.js') ?>"></script>


</head>


<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">数据表</a></li>
    <li><a href="#">基本内容</a></li>
    </ul>
    </div>
    
    <div class="rightinfo">
    
    <div class="tools">
    
    	<ul class="toolbar">
        <li class="click"><a href ="<?php echo site_url('admin/lm/add') ?>"><span><img src="<?php echo base_url('source/images/t01.png') ?>" /></span>添加</a></li>
        <li class="click"><span><img src="<?php echo base_url('source/images/t02.png') ?>" /></span>修改</li>
        <li><span><img src="<?php echo base_url('source/images/t03.png') ?>" /></span>批量删除</li>
        <li><span><img src="<?php echo base_url('source/images/t04.png') ?>" /></span>统计</li>
        </ul>
        
        
        <ul class="toolbar1">
        <li><span><img src="<?php echo base_url('source/images/t05.png') ?>" /></span>设置</li>
        </ul>
    
    </div>
    
    
    <table class="tablelist">
    	<thead>
    	<tr>
        <th><input name="" type="checkbox" value="" /></th>
        <th>排序<i class="sort"><img src="<?php echo base_url('source/images/px.gif') ?>" /></i></th>
        <th>栏目名称</th>
        <th>外站链接</th>
        <th>操作</th>
        </tr>
        </thead>
        <tbody id="bind-data">    
        <?php foreach($lmList as $v){ ?>
        <tr>
                <td><input type="checkbox" class="checkid" value="<?php echo $v['id'] ?>" /></td>
                <td style="width:50px;"><input style="width:50px;" type="test" name="sort"  value="<?php echo $v['sort'] ?>"/></td>
                <td><?php echo $v['name'] ?></td>
                <td><?php echo $v['link_src'] ?></td>
                <td><a href="<?php echo site_url('admin/lm/edit/'.$v['id']) ?>" class="tablelink">编辑</a>     <a href="<?php echo site_url('admin/lm/del/'.$v['id']) ?>" class="tablelink">删除</a></td>
        </tr>   
        <?php } ?>
        </tbody>
    </table>
    
   
    <div class="pagin">
    	<div class="message">共<i class="blue">1256</i>条记录，当前显示第&nbsp;<i class="blue">2&nbsp;</i>页</div>
        <ul class="paginList">
        <li class="paginItem"><a href="javascript:;"><span class="pagepre"></span></a></li>
        <li class="paginItem"><a href="javascript:;">1</a></li>
        <li class="paginItem current"><a href="javascript:;">2</a></li>
        <li class="paginItem"><a href="javascript:;">3</a></li>
        <li class="paginItem"><a href="javascript:;">4</a></li>
        <li class="paginItem"><a href="javascript:;">5</a></li>
        <li class="paginItem more"><a href="javascript:;">...</a></li>
        <li class="paginItem"><a href="javascript:;">10</a></li>
        <li class="paginItem"><a href="javascript:;"><span class="pagenxt"></span></a></li>
        </ul>
    </div>
    
    </div>

</body>

</html>
