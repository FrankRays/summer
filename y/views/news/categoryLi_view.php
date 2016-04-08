<?php defined('BASEPATH') || exit('no direct script access allowed') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?php echo base_url('source/css/style.css') ?>" rel="stylesheet" type="text/css" />
<script src="http://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
<script language="JavaScript" src="<?php echo base_url('source/js/ykjver.js') ?>"></script>
<script src="<?php echo base_url('/source/layer/layer.min.js') ?>"></script>
<style>
    
    .sort-input-wrap{width:50px;}
    .sort-input-wrap input{border:#dadada solid 1px;width:35px; height:24px;}
</style>
</head>


<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="<?php echo site_url('admin/news/categoryLi/'.$categoryInfo['id']) ?>"><?php echo $categoryInfo['name'] ?></a></li>
    </ul>
    </div>
    
    <div class="rightinfo">
    
    <div class="tools">
    
    	<ul class="toolbar">
        <li class="click"><a href="<?php echo site_url('admin/news/add/'.$cId) ?>"><span><img src="<?php echo base_url('source/images/t01.png') ?>" /></span>添加</a></li>
        <!--<li class="click"><span><img src="<?php echo base_url('source/images/t02.png') ?>" /></span>修改</li>
        <li><span><img src="<?php echo base_url('source/images/t03.png') ?>" /></span>删除</li>-->
        <li id="change-sort"><span><img src="<?php echo base_url('source/images/t04.png') ?>" /></span>修改排序</li>
        </ul>
        
        
       <!-- <ul class="toolbar1">
        <li><span><img src="<?php echo base_url('source/images/t05.png') ?>" /></span>设置</li>
        </ul>-->
    
    </div>
    
    
    <table class="tablelist" >
    	<thead>
    	<tr>
        <th><input name="" type="checkbox" value="" checked="checked"/></th>
        <th>排序<i class="sort"><img src="<?php echo base_url('source/images/px.gif') ?>" /></i></th>

        <th>分类名称</th>
        <th>新闻标题</th>
        <th>Hits</th>
        <th>Public Time</th>
        <th>Status</th>
        <th>操作</th>
        </tr>
        </thead>
        <tbody id="bind-data">  
            <?php foreach($data as $v){ ?> 
            <tr>  
                <td><input name="" type="checkbox" value="<?php echo $v['news_id'] ?>" /></td>
                <td class="sort-input-wrap"><input name="<?php echo $v['news_id'] ?>" type="text" id="sort" value="<?php echo $v['sort'] ?>" /></td>
                <td><?php echo $v['category_name'] ?></td>
                <td><a target="_blank" href="<?php echo site_url('/news/archive/'.$v['news_id']) ?>"><?php echo $v['title'] ?></a></td>
                <td><?php echo $v['hits'] ?></td>
                <td><?php echo date('Y-m-d', $v['add_time']) ?></td>
                <td class="news-status" style="cursor:pointer">
                    <?php if($v['status'] == 1){ ?>
                        <a alt="<?php echo $v['news_id'] ?>" style="color:#22dd22" href="javascript:;" >Public</a>
                    <?php }else{ ?>
                        <a alt="<?php echo $v['news_id'] ?>"  style="color:#dd2222;font-weigth:bold;" href="javascript:;" >Draft</a>
                    <?php } ?>

                </td>
                <td><a href="<?php echo site_url('admin/news/edit/'.$v['news_id']) ?>" >编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="<?php echo site_url('admin/news/fileAdd/'.$v['news_id']) ?>">照片</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="<?php echo site_url('admin/news/filesAdd/'.$v['news_id']) ?>">附件</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a target="_blank" href="<?php echo site_url('/news/archive/'.$v['news_id']) ?>">预览</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="<?php echo site_url('admin/news/del/'.$v['news_id']) ?>">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>  
            <?php } ?>
        </tbody>
    </table>
    
   
    <div class="pagin">
    	<div class="message">共<i class="blue"><?php echo $totalRows ?></i>条记录，当前显示第&nbsp;<i class="blue"><?php echo $curPage ?>&nbsp;</i>页</div>
       
        <?php echo $pagination ?>
    </div>
    
    <div class="debug"></div>
    
    </div>
    
    <script type="text/javascript">

    $('#bind-data').on('click', '.news-status', function(){
        var curNewsA = $(this).find('a');
        var newsid = curNewsA.attr('alt');
        $.post('<?php echo site_url('admin/news/changeStatus') ?>', {newsid : newsid}, function(data){
            data = parseInt(data);
            if(data == 1){ 
                curNewsA.css({color:'#11dd11'});
                curNewsA.text('Public');
            }else if(data == 0){
                curNewsA.css({color:'#dd1111'});
                curNewsA.text('Draft');
            }
        });
    });

    //    $.layer({
    // type: 1,
    // title: false,
    // area: ['auto', 'auto'],
    // border: [1], //去掉默认边框
    // shade: [1], //去掉遮罩
    // shift: 'left', //从左动画弹出
    // page: {
    //     html: '<div style="width:420px; height:260px; padding:20px; border:1px solid #ccc; background-color:#eee;"><p>我从左边来，我自定了风格。</p><button id="pagebtn" class="btns" onclick="">关闭</button></div>'
    // }
    // });



		$('.tablelist tbody tr:odd').addClass('odd');

		$(document).ready(function(){
            $("#change-sort").click(function(){
                var sortGroup = $('#bind-data');
                var sgLength = $('#bind-data').children('tr').length;
                var subSort = new Object();
                var temp;
                for(var i = 0; i < sgLength; i++){
                    temp = sortGroup.children('tr:nth-child('+(i+1)+')').children('td:nth-child(2)').children('input');
                    subSort[temp.attr('name')] = temp.attr('value');
                }

                $.post('<?php echo site_url('admin/news/changeSort') ?>', subSort,function(data, status){
                    if(status == 'success' && data != ''){
                        alert("修改排序成功");
                        window.location.href="<?php echo site_url('admin/news/categoryLi/'.$cId) ?>"
                    }else{
                        alert("修改排序失败");
                    }
                });
            });
		});

	</script>

</body>

</html>
