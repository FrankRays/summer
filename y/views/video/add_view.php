<?php defined('BASEPATH') || exit('no direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?php echo base_url('source/css/style.css') ?>" rel="stylesheet" type="text/css" />
<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
<script language="JavaScript" src="<?php echo base_url('source/js/ykjver.js') ?>"></script>
</head>

<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">Mg Video</a></li>
    <li><a href="#">Video Add</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    <div class="formtitle"><span>Video Add</span></div>
    <form action="<?php echo site_url('admin/student/doadd') ?>" method="POST" onsubmit="return chkSub();">
    <ul class="forminfo">
    <li><label>Video Name</label><input id="name" name="name" type="text" class="dfinput" /><i>标题不能超过30个字符</i></li>
    <li><label>Video Desc</label><textarea id="summary" name="summary" cols="" rows="" class="textinput"></textarea></li>
    <li><label>Video Src</label><input id="video-source" multiple type="file" data-url="/xww/third_party/blueimp/server/php/"/></li>
    <li><label>Video Cover</label><input id="video-cover" type="file" class="dfinput" /></li>
    <li><label>HomePage</label><input type="checkbox" id="is-homepage" class="dfradio" /></li>
    <li><label>&nbsp;</label><input id="btn" name="" type="button" class="btn" value="确认保存"/></li>
    </ul>
    </form>
<div id="progress">
    <div style="height:18px;background:green;width:0%;" class="bar" style="width: 0%;"></div>
</div>
    </div>


<script src="/xww/third_party/blueimp/js/vendor/jquery.ui.widget.js"></script>
<script src="/xww/third_party/blueimp/js/jquery.iframe-transport.js"></script>
<script src="/xww/third_party/blueimp/js/jquery.fileupload.js"></script>
<script>
    $(function(){
        $('#video-source').fileupload({

        dataType: 'json',

        // 上传完成后的执行逻辑
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                console.log(file);
                // $('<p/>').text(file.name).appendTo(document.body);

            });
        },

        // 上传过程中的回调函数
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $(".bar").text(progress + '%');
            $('#progress .bar').css(
                'width',
                progress + '%'
            );
        }
        });
        $('#btn').one('click', function(){
            var videoSource = $('#video-source');
            console.log(videoSource);
        });
    });
</script>

</body>

</html>
