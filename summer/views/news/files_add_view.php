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
    <li><a href="<?php echo site_url('admin/news/categoryli/'.$categoryId)?>">新闻管理</a></li>
    <li><a href="#">新闻附件</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    <div class="formtitle"><span>新闻附件</span><a href="<?php echo site_url('admin/news/categoryLi/'.$categoryId)?>" style="float:right;font-weight:bold;font-size:18px;">Return</a></div>
    	<table class="tablelist">
    		<thead>
    			<tr>
    				<th>编号</th>
    				<th>附件</th>
    				<th>类型</th>
    				<th>大小</th>
    				<th>上传者</th>
    				<th>上传日期</th>
    				<th>下载次数</th>
    				<th>操作</th>
    			</tr>
    		</thead>
    		<tbody>
    			<?php foreach($fileList as $v){ ?>
    				<tr>
    					<td><?php echo $v['id'] ?></td>
    					<td style="width:220px;"><?php echo $v['title'] ?></td>
    					<td><?php echo $v['extension'] ?></td>
    					<td><?php echo $v['size'] ?>KB</td>
    					<td><?php echo $v['addedBy'] ?></td>
    					<td><?php echo date('Y-m-d', $v['addedDate']) ?></td>
    					<td><?php echo $v['downloads'] ?></td>
    					<td><a href="#">编辑</a><a href="<?php echo site_url('admin/news/fileDelete/'.$v['id']) ?>">删除</a></td>
    				</tr>
    			<?php } ?>
    		</tbody>
    	</table>
    </div>

    <form action="<?php echo site_url('admin/news/doFilesAdd') ?>" method="POST" enctype="multipart/form-data"/>
	    <ul class="upload-wrap">
		   	<li id="upload-pic">
		        <label>图片文件上传</label>
		        <div>
		            <input class="df-file-first" name="asdf" type="file" />
		            标题：<input type="text" name="asdf" class="file-text" />
		        </div>
		    </li>
		    <li>
		    	<input type="submit" value="添加" class="btn" style="margin-top:20px;" />
		        <input type="button" value="增加附件数目" id="add-pic" class="btn"/>
		        <input type="hidden" value="<?php echo $objId ?>" name="objId" />
		    </li>
	    </ul>

    </form>

    <script>
    //file sumbit input add 
    $("#add-pic").click(function(){
        $("#add-pic").disabled = "disabled";
        var randomName = Math.random();
        appendStr = '<div><input name="'+randomName+'" class="df-file" type="file" />标题：<input class="file-text" name="'+randomName+'" type="text" /> </div>'
        $("#upload-pic").append(appendStr);
        $("#add-pic").disabled = "";
    });
    </script>
</body>

</html>
