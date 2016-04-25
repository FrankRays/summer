<?php defined('BASEPATH') || exit('no direct script access allowed'); ?>

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
    <li><a href="<?php echo site_url('admin/news/categoryList')?>">分类管理</a></li>
    <li><a href="#">分类添加</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    <div class="formtitle"><span>分类添加</span></div>
    <form action="<?php echo site_url('admin/news/docategoryadd') ?>" method="POST" />
	    <ul class="forminfo">
	    <li><label>分类名称</label><input id="name" name="name" type="text" class="dfinput" /><i>标题不能超过30个字符</i></li>
	    <li><label>分类别名</label><input id="alias" name="alias" type="text" class="dfinput" /><i>标题不能超过30个字符</i></li>
	    <li><label>选择父类</label><select name="fid" class="df-select">
	    <option value="0">根分类</option>
	    <?php foreach($categoryList as $v){ ?>
	    	<option <?php echo ($v['id'] == $id) ? 'selected="selected"' : '' ?> value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
	    <?php } ?>
	    </select></li>
	    <li><label>分类简介</label><textarea id="desc" name="describle" cols="" rows="" class="textinput"></textarea></li>
	    <li><label>&nbsp;</label><input id="btn" name="" type="submit" class="btn" value="确认保存"/></li>
	    </ul>
    </form>
    </div>
</body>

</html>
