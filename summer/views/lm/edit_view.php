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
    <li><a href="<?php echo site_url('admin/news/categoryList') ?>">栏目管理</a></li>
    <li><a href="#">栏目添加</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    <div class="formtitle"><span>栏目编辑</span></div>
    
    <form action="<?php echo site_url('admin/lm/doEdit') ?>" method="POST" />
    <ul class="forminfo">
    <li><label>选择本站分类</label><select name="cid" class="df-select">
        <option value="0">链接外站</option>
        <?php foreach($categoryList as $v){ ?>
            <option <?php echo ($lmInfo['cid'] == $v['id']) ? 'selected="selected"' : '' ?> value="<?php echo $v['id'] ?>"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', ($v['lev']-1)).$v['name'] ?></option>
        <?php } ?>
        </select></li>
        <li><label>栏目名称</label><input id="name" name="name" type="text" value="<?php echo $lmInfo['name'] ?>" class="dfinput" /><i>非外站链接勿用</i></li>
         <li><label>栏目链接</label><input id="link_src" name="link_src" type="text" value="<?php echo $lmInfo['link_src'] ?>" class="dfinput" /><i>非外站链接勿用</i></li>
    <li><label>&nbsp;</label><input id="btn" name="" type="submit" class="btn" value="确认保存"/></li>
    <li><label></label><input type="hidden" value="<?php echo $lmInfo['id']?>" name="id" /></li>
    </ul>
    </form>
    </div>
</body>

</html>
