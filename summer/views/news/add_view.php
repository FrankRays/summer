<?php defined('BASEPATH') || exit('no direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?php echo base_url('source/css/style.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('source/css/news/jquery.datetimepicker.css') ?>" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="<?php echo base_url('source/js/news//jquery.js') ?>"></script>
<script language="JavaScript" src="<?php echo base_url('source/js/ykjver.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('source/editor/themes/default/default.css') ?>" />
<script charset="utf-8" src="<?php echo base_url('source/editor/kindeditor-min.js') ?>"></script>
<script charset="utf-8" src="<?php echo base_url('source/editor/lang/zh_CN.js') ?>"></script>

<style>
    select{border:#dadada solid 1px;height:35px; }
    select option{border:#dadada solid 1px;height:35px; }
</style>
</head>

<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">新闻管理</a></li>
    <li><a href="#">新闻添加</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    <div class="formtitle">
    <span>新闻添加</span>
    <a href="<?php echo site_url('admin/news/categoryLi/'.$categoryInfo['id'])?>" style="float:right;font-weight:bold;font-size:18px;">Return</a>
    </div>
        <form action="<?php echo site_url('admin/news/doadd') ?>" method="POST" onsubmit="return onsub()" enctype="multipart/form-data">
        <ul class="forminfo">
        <li><label>新闻标题</label><input placeholder="News Title" id="name" name="name" type="text" class="dfinput" /><i>标题不能超过30个字符</i></li>
        <li><label>新闻分类</label><select name="categoryId" id="bind-select">
                <option value="0">选择新闻分类</option>
            <?php foreach($data as $v){ ?>
                <option <?php echo ($v['id'] == $cId) ? 'selected="selected"' : '' ?> value="<?php echo $v['id'] ?>"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', ($v['lev'] - 1)).$v['name'] ?></option>
            <?php } ?>
        </select></li>
        <li><label>来稿</label><input placeholder="Come From" id="come-from" value="" name="come_from" type="text" class="dfinput" /><i></i></li>
        <li><label>新闻作者</label><input id="author" value="<?php echo $username ?>" name="author" type="text" class="dfinput" /><i></i></li>
        <li><label>新闻简介</label><textarea id="desc" name="desc" cols="" rows="" class="textinput"></textarea><i>新闻简介为列表显示简要内容，不填写默认为新闻内容前200字</i></li>
        <li><label>新闻内容</label><textarea style="height:500px;width:800px" id="content" name="content" ></textarea></li>
        <li><label>发布时间</label><input id="addDate" type="text" name="addDate" class="dfinput"/></li>
        <li><label>状态</label><input class="dfradio" type="radio" checked="checked" name="status" value="1"  />正常<input style="margin-left:20px;" type="radio" name="status" class="dfradio" value="0" />草稿</li>
        <li><label>&nbsp;</label><input id="btn"  type="submit" class="btn" value="确认保存"/></li>
        </ul>
        </form>
    </div>

<script charset="utf-8" src="<?php echo base_url('source/js/news/jquery.datetimepicker.js') ?>"></script>
<script>

    //date picker
    $('#addDate').datetimepicker();
    $('#addDate').datetimepicker({value:'<?php echo date('Y/m/d') ?>',step:10});

    //full text editor
	var editor;
	KindEditor.ready(function(K) {
		editor = K.create('textarea[name="content"]', {
			allowFileManager : true
		});
	});

    //submit check
	function onsub(){
		if($("#name").val() == ''){
			alert("新闻标题不能为空");
			return false;
		}
	}
</script>

</body>

</html>
