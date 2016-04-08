<?php defined('BASEPATH') || exit('no direct script access allowed'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?php echo base_url('source/css/style.css') ?>" rel="stylesheet" type="text/css" />
<script src="http://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
<script language="JavaScript" src="<?php echo base_url('source/js/ykjver.js') ?>"></script>
<script src="<?php echo base_url('/source/layer/layer.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('/source/layer/extend/layer.ext.js') ?>"></script>
</head>

<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="<?php echo site_url('admin/news/categoryLi/'.$category_id)?>">新闻管理</a></li>
    <li><a href="#">新闻附件</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    <div class="formtitle"><span>新闻附件</span><a href="<?php echo site_url('admin/news/categoryLi/'.$category_id)?>" style="float:right;font-weight:bold;font-size:18px;">Return</a></div>
    	<table class="tablelist">
    		<thead>
    			<tr>
    				<th>附件</th>
                    <th>Describle</th>
    				<th>上传日期</th>
    				<th>下载次数</th>
                    <th>Default Pic</th>
    				<th>操作</th>
    			</tr>
    		</thead>
    		<tbody id="file-tbody">
    			<?php foreach($fileList as $v){ ?>
    				<tr>
                        <td style="display:none;"><input type="hidden" value="<?php echo  $v['id'] ?>" name="file-id" /></td>
    					<td style="width:220px;height:125px"><img style="width:220px;height:125px;cursor:pointer;"  src="<?php echo base_url($v['pathname']) ?>" alt="图片介绍" title="图片介绍" /></td>
                        <td><?php echo $v['title'] ?></td>
    					<td><?php echo date('Y-m-d', $v['addedDate']) ?></td>
    					<td><?php echo $v['downloads'] ?></td>
                        <td>
                        <?php if($v['primary']){ ?>
                            <a style="color:red;" class="set-default-img-btn" href="javascript:;" >封面</a></td>
                        <?php }else{ ?>
                            <a class="set-default-img-btn" href="javascript:;" >设为封面</a></td>
                        <?php } ?>
    					<td><input type="hidden" value="<?php echo $v['id'] ?>" /><a class="file-edit" href="javascript:;">编辑</a>&nbsp;&nbsp;<a href="<?php echo site_url('admin/news/fileDelete/'.$v['id']) ?>">删除</a></td>
    				</tr>
    			<?php } ?>
    		</tbody>
    	</table>
    </div>

    <form action="<?php echo site_url('admin/news/doFileAdd') ?>" method="POST" enctype="multipart/form-data"/>
	    <ul class="upload-wrap">
		   	<li id="upload-pic">
		        <label>图片文件上传</label>
		        <div class="file-upload-input">
		            <input class="df-file-first" name="asdf" type="file" />
		            标题：<input type="text" name="asdf" class="file-text" /><br />
		        </div>
		    </li>
		    <li>
		    	<input type="submit" value="添加" class="btn" style="margin-top:20px;" />
		        <input type="button" value="增加附件数目" id="add-pic" class="btn"/>
		        <input type="hidden" id="obj-id" value="<?php echo $objId ?>" name="objId" />
		    </li>
	    </ul>

    </form>

    <div id="file-edit-popup" style="display:none;">        
    <ul class="forminfo" style="margin-top:30px;">
        <li><label>Pic describle</label><input value="" id="file-pic-describle" name="name" type="text" class="dfinput" /><i>标题不能超过30个字符</i></li>
        <li><label>Is Default</label><input id="file-is-default" class="dfradio" type="checkbox" checked="checked" name="status" />
        <li><label>&nbsp;</label><input id="file-edit-btn"  type="button" class="btn file-edit-btn" value="确认保存"/></li>
        </ul>
    </div>

    <script>
    //file sumbit input add 
    $(function(){
        var fileTbody = $('#file-tbody');
        //set the default img
        fileTbody.on('click', '.set-default-img-btn', function(){
            var fileId = $(this).parents('tr').find('td').eq(0).find('input').val();
            var objId = $('#obj-id').val();

            $.post('<?php echo site_url('/admin/news/setDefaultImg') ?>', {fileId : fileId, objId : objId}, function(data){
                data = JSON.parse(data);
                if(data.err != -1){
                    layer.msg('设置成功',1, function(){
                        location.reload();
                    });
                }else{
                    layer.msg('设置失败')
                }
            });
        });

        //load the photo scan js
        layer.photosPage({
            parent : '#file-tbody',
            title : '<?php echo $newsInfo['title'] ?>'
        });
        //add the file input box
        var fileNum = 1;
        fileInputSource = $('#upload-pic').find('div').clone();
        $('#add-pic').on('click', function(){
            fileInputSource.find('input').eq(0).attr('name', 'uploadfile' + fileNum++);
            $('#upload-pic').append(fileInputSource.clone());
        });

        //edit the file infomation
        $('#file-tbody').on('click', '.file-edit', function(){
            var id = $(this).prev('input').val();
            $.post('<?php echo site_url('admin/news/fileGetById') ?>', {id:id}, function(data){
                if(data == -1){
                    layer.alert('Fail,Please Try Again');
                }else{
                    data = JSON.parse(data);
                    $('#file-pic-describle').attr('value', data.title);
                    if(data.primary == 1){
                        $('#file-is-default').attr('checked', true);
                    }else{
                        $('#file-is-default').attr('checked', false);
                    }
                    var pageii = $.layer({
                        type: 1,
                        title: false,
                        area: ['600', '200'],
                        page: {
                            html: $('#file-edit-popup').html()
                        }
                    });

                    //add update event
                    $('.xubox_main').on('click', '.file-edit-btn', function(){
                        var input = $('.xubox_main').find('input');
                        var upData = {};
                        input.each(function(i, ele){
                            upData[$(ele).attr('id')] = $(ele).val();
                        });
                        upData['file-is-default'] = $('.xubox_main').find('#file-is-default').get(0).checked;
                        upData['id'] = id;
                        $.post('<?php echo site_url('admin/news/fileEdit') ?>', upData, function(data){
                            data = JSON.parse(data);
                            if(data['err'] == 1){
                                alert('Edit Imgs Error, Please Try Again');
                                return false;
                            }

                            setTimeout(function(){
                                layer.close(pageii);
                                layer.alert('Edit Successfully', 1, function(){
                                    location.reload();
                                });
                            }, 200)
                        });
                    });
                }

            });
        });
    })
    </script>
</body>

</html>
