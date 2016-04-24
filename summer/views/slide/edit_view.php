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
    <li><a href="#">展示图片管理</a></li>
    <li><a href="#">展示图片修改</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    <div class="formtitle"><span>展示图片修改</span></div>
    <form action="<?php echo site_url('admin/slide/doEdit') ?>" method="POST" onsubmit="return chkSub();">
    <ul class="forminfo">
    <li><label>展示图片名称</label><input value="<?php echo $slideInfo['value']['name'] ?>" id="name" name="name" type="text" class="dfinput" /><i>标题不能超过30个字符</i></li>
    <li><label>展示图片照片</label><input value="<?php echo $slideInfo['value']['picSrc'] ?>" id="pic-src" name="picSrc" type="text" class="dfinput" /><input id="pic-src-bt" type="button" value="上传图片" /><i>请保持图片分辨率为980*380</i></li>
    <li><label>&nbsp;</label><img style="width:200px;" src="<?php echo base_url($slideInfo['value']['picSrc']) ?>" /></li>
    <li><label>展示图片简介</label><textarea id="summary" name="summary" cols="" rows="" class="textinput"><?php echo $slideInfo['value']['summary'] ?></textarea></li>
    <li><label>链接地址</label><input value="<?php echo $slideInfo['value']['linkSrc'] ?>" id="desc" name="linkSrc" class="dfinput" type="text" /></li>
    <li><input type="hidden" value="<?php echo $slideInfo['id'] ?>" name="id" /></li>
    <li><label>&nbsp;</label><input id="btn" name="" type="submit" class="btn" value="确认保存"/></li>
    </ul>
    </form>
    </div>
<script>
    function chkSub(){
        var name = $("#name").val();
        var desc = $("#pic-src").val();

        if(name == '' || desc == ''){
            alert("填写表单不能为空");
            return false;
        }
        return true;
    }

    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="summary"]', {
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