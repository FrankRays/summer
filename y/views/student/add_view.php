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
    <li><a href="#">学生管理</a></li>
    <li><a href="#">学生添加</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    <div class="formtitle"><span>学生添加</span></div>
    <form action="<?php echo site_url('admin/student/doadd') ?>" method="POST" onsubmit="return chkSub();">
    <ul class="forminfo">
    <li><label>学生名称</label><input id="name" name="name" type="text" class="dfinput" /><i>标题不能超过30个字符</i></li>
    <li><label>专业</label><input id="major" name="major" type="text" class="dfinput" /></li>
    <li><label>毕业时间</label><input id="graduate-time" name="graduateTime" type="text" class="dfinput" /></li>
    <li><label>学生照片</label><input id="" name="picSrc" type="text" class="dfinput" /><i></i></li>
    <li><label>学生简介</label><textarea id="summary" name="summary" cols="" rows="" class="textinput"></textarea></li>
    <li><label>详细介绍</label><textarea id="desc" name="desc" cols="" rows="" class="textinput"></textarea></li>
    <li><label>&nbsp;</label><input id="btn" name="" type="submit" class="btn" value="确认保存"/></li>
    </ul>
    </form>
    </div>
<script>
	function chkSub(){
		var name = $("#name").val();
		var desc = $("#summary").val();
        var major = $("#major").val();
        var graduateTime = $("#graduate-time");

		if(name == '' || desc == '' || major == '' || graduateTime == ''){
			alert("填写表单不能为空");
			return false;
		}
		return true;
	}
</script>

</body>

</html>
