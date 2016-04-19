<?php defined('BASEPATH') || exit('no direct script access allowed'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?php echo base_url('source/css/style.css') ?>" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="<?php echo base_url('source/js/jquery.js') ?>"></script>
<script language="JavaScript" src="<?php echo base_url('source/js/ykjver.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('source/editor/themes/default/default.css') ?>" />
<script charset="utf-8" src="<?php echo base_url('source/editor/kindeditor-min.js') ?>"></script>
<script charset="utf-8" src="<?php echo base_url('source/editor/lang/zh_CN.js') ?>"></script>
</head>

<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">教师管理</a></li>
    <li><a href="#">教师添加</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    <div class="formtitle"><span>教师添加</span></div>
    <form action="<?php echo site_url('admin/teacher/doadd') ?>" method="POST" onsubmit="return chkSub();">
    <ul class="forminfo">
    <li><label>教师名称</label><input id="name" name="name" type="text" class="dfinput" /><i>标题不能超过30个字符</i></li>
    <li><label>教师照片</label><input id="pic-src" name="picSrc" type="text" class="dfinput" /><input id="pic-src-bt" type="button" value="上传图片" /><i></i></li>
    <li><label>教师简介</label><textarea id="summary" name="summary" cols="" rows="" class="textinput"></textarea></li>
    <li><label>详细介绍</label><textarea style="height:400px;" id="desc" name="desc" cols="" rows="" class="textinput"></textarea></li>
    <li><label>&nbsp;</label><input id="btn" name="" type="submit" class="btn" value="确认保存"/></li>
    </ul>
    </form>
    </div>
<script>
	function chkSub(){
		var name = $("#name").val();
		var desc = $("#summary").val();

		if(name == '' || desc == ''){
			alert("填写表单不能为空");
			return false;
		}
		return true;
	}

    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="desc"]', {
            allowFileManager : true
        });

        //上传图片
        K('#pic-src-bt').click(function() {
            editor.loadPlugin('image', function() {
                editor.plugin.imageDialog({
                    imageUrl : K('#pic-src').val(),
                    clickFn : function(url, title, width, height, border, align) {
                        K('#pic-src').val(url);
                        editor.hideDialog();
                    }
                });
            });
        });



    });
</script>

</body>

</html>
