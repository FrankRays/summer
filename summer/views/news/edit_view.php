<?php defined('BASEPATH') || exit('no direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?php echo base_url('source/css/style.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('source/css/news/jquery.datetimepicker.css') ?>" rel="stylesheet" type="text/css" />
<script src="http://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
<script language="JavaScript" src="<?php echo base_url('source/js/ykjver.js') ?>"></script>
<script src="<?php echo base_url('/source/layer/layer.min.js') ?>"></script>

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
    <li><a href="#">新闻修改</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    <div class="formtitle">
    <span>新闻修改</span>
    <a href="<?php echo site_url('admin/news/categoryLi/'.$data['newsData']['category_id'])?>" style="float:right;font-weight:bold;font-size:18px;">Return</a>
    </div>
        <form id="post-form" action="<?php echo site_url('admin/news/doedit') ?>" method="POST" onsubmit="return onsub()" enctype="multipart/form-data">
        <ul class="forminfo">
        <li><label>新闻标题</label><input placeholder="News Title" id="name" name="name" value="<?php echo $data['newsData']['title'] ?>" type="text" class="dfinput" /><i>标题不能超过30个字符</i></li>
        <li><label>新闻分类</label><select name="categoryId" id="bind-select">
                <option value="0">选择新闻分类</option>
            <?php foreach($data['newsCategoryData'] as $v){ ?>
                <option <?php echo ($v['id'] == $data['newsData']['category_id']) ? 'selected="selected"' : '' ?> value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
            <?php } ?>
        </select></li>
        <li><label>来稿</label><input placeholder="Come From" id="come-from" value="<?php echo $data['newsData']['come_from'] ?>" name="come_from" type="text" class="dfinput" /><i></i></li>
        <li><label>新闻作者</label><input id="author" value="<?php echo $data['newsData']['author'] ?>" name="author" type="text" class="dfinput" /><i></i></li>
        <li><label>新闻简介</label><textarea id="summary" name="summary" cols="" rows="" class="textinput"><?php echo $data['newsData']['summary'] ?></textarea><i>新闻简介为列表显示简要内容，不填写默认为新闻内容前200字</i></li>
        <li><label>新闻内容</label><textarea style="height:500px;width:800px" id="content" name="content" ><?php echo $data['newsData']['content'] ?></textarea></li>
        <li><label>发布时间</label><input id="addDate" type="text" name="addDate" class="dfinput"/></li>
        <li><label>&nbsp;</label><input id="newsid"  type="hidden" name="newsid" value="<?php echo $data['newsData']['news_id'] ?>"/></li>
        </ul>
        </form>
    </div>
    <div style="position: fixed;left: 900px;top: 40%;box-shadow: 0 0 10px 1px #666;" ><input id="btn"  type="button" name="btn" class="btn" value="确认保存"/></div>

<script charset="utf-8" src="<?php echo base_url('source/js/news/jquery.datetimepicker.js') ?>"></script>
<script charset="utf-8" src="<?php echo base_url('xww/third_party/ueditor/ueditor.config.js') ?>"></script>
<script charset="utf-8" src="<?php echo base_url('xww/third_party/ueditor/ueditor.all.js') ?>"></script>

<script>
    //submit check
    $(function(){    //date picker
        $('#addDate').datetimepicker();
        $('#addDate').datetimepicker({value:'<?php echo date('Y/m/d', $data['newsData']['add_time']) ?>',step:10});

        //full text editor
        var ue = UE.getEditor('content');

        //click the btn then post the data to server
        $('#btn').click(function(){
            var self = this
            var layerLoading = layer.load('更新中', 1000);
            self.disabled = true;
            var postForm = $('#post-form')
            var inputs = postForm.find('input');
            var upData = {};
            inputs.each(function(i, ele){
                upData[$(ele).attr('name')] = $(ele).val();
            });
            upData['desc'] = $('#desc', postForm).val();
            upData['content'] = ue.getContent();
            upData['categoryId'] = $('#bind-select', postForm).val();
            upData['id'] = $('#newsid').val();
            upData['summary'] = $('#summary').val();
            // console.log(upData);
            $.ajax({
                type : 'POST',
                url : '<?php echo site_url('admin/news/doEdit') ?>',
                data : upData,
                dataType : 'json',
                success : function(data, textStatus, jqHXR){
                    if(data.error == 0){
                        layer.close(layerLoading);
                        $.layer({
                            type : 0,
                            title : false,
                            time : 1,
                            btns : 0,
                            closeBtn : false,
                            dialog : {
                                type : 1,
                                msg : '修改成功'
                            },
                            end : function(){
                                location.href="<?php echo site_url('admin/news/categoryLi/'.$data['newsData']['category_id'])?>";
                            }
                        });
                        self.disabled = false;
                    }else{

                    }
                },
                error : function(xr, ts, et){
                    console.log(xr.responseText);
                    console.log(ts);
                    console.log(et);
                }

            });
        });
    });
</script>

</body>

</html>
