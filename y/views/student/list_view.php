<?php defined('BASEPATH') || exit('no direct script access allowed') ?>
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
    <li><a href="#">数据表</a></li>
    <li><a href="#">基本内容</a></li>
    </ul>
    </div>
    
    <div class="rightinfo">
    
    <div class="tools">
    
    	<ul class="toolbar">
        <li class="click"><a href="<?php echo site_url('admin/student/add') ?>"><span><img src="<?php echo base_url('source/images/t01.png') ?>" /></span>添加</a></li>
        <li class="click"><span><img src="<?php echo base_url('source/images/t02.png') ?>" /></span>修改</li>
        <li><span><img src="<?php echo base_url('source/images/t03.png') ?>" /></span>删除</li>
        <li><span><img src="<?php echo base_url('source/images/t04.png') ?>" /></span>统计</li>
        </ul>
        
        
        <ul class="toolbar1">
        <li><span><img src="<?php echo base_url('source/images/t05.png') ?>" /></span>设置</li>
        </ul>
    
    </div>
    
    
    <table class="tablelist" >
    	<thead>
    	<tr>
        <th><input name="" type="checkbox" value="" checked="checked"/></th>
        <th>编号<i class="sort"><img src="<?php echo base_url('source/images/px.gif') ?>" /></i></th>
        <th>学生名称</th>
        <th>学生简介</th>
        <th>毕业时间</th>
        <th>操作</th>
        </tr>
        </thead>
        <tbody id="bind-data">
        <tr>
        <td><input name="" type="checkbox" value="" /></td>
        <td>20130908</td>
        <td>王金平幕僚：马英九声明字字见血 人活着没意思</td>
        <td>admin</td>
        <td>江苏南京</td>
        <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink"> 删除</a></td>
        </tr> 
        
        <tr><td><input name="" type="checkbox" value="" /></td>
        <td>20130907</td>
        <td>温州19名小学生中毒流鼻血续：周边部分企业关停</td>
        <td>uimaker</td>
        <td>山东济南</td>
        <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
        </tr>        
        </tbody>
    </table>
    
   
    <div class="pagin">
    	<div class="message">共<i class="blue"><?php echo $totalRows ?></i>条记录，当前显示第&nbsp;<i class="blue"><?php echo $curPage ?>&nbsp;</i>页</div>
       
        <?php echo $pagination ?>
    </div>
    
    
    <div class="tip">
    	<div class="tiptop"><span>提示信息</span><a></a></div>
        
      <div class="tipinfo">
        <span><img src="<?php echo base_url('source/images/ticon.png') ?>" /></span>
        <div class="tipright">
        <p>是否确认对信息的修改 ？</p>
        <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
        </div>
        </div>
        
        <div class="tipbtn">
        <input name="" type="button"  class="sure" value="确定" />&nbsp;
        <input name="" type="button"  class="cancel" value="取消" />
        </div>
    
    </div>
    
    
    
    
    </div>
    
    <script type="text/javascript">
		$('.tablelist tbody tr:odd').addClass('odd');

		$(document).ready(function(){
			var editUrl = "<?php echo base_url('admin/student/edit') ?>";
            var delUrl = "<?php echo base_url('admin/student/del') ?>";
            var data = JSON.parse('<?php echo json_encode($data) ?>');
            var dataLength = data.length;
            var bindData = document.getElementById('bind-data');
            var bindStr = '';
            for(var i = 0; i < dataLength; i++){
                bindStr += '<tr>';
                bindStr += '<td><input name="" type="checkbox" value="'+data[i]['id']+'" /></td>';
                bindStr += '<td>'+data[i]['id']+'</td>';
                bindStr += '<td>'+data[i]['name']+'</td>';
                bindStr += '<td>'+data[i]['summary']+'</td>';
                bindStr += '<td>'+new Date(parseInt(data[i]['add_time']) * 1000).toLocaleString().substr(0,10)+'</td>';
                bindStr += '<td><a href="'+ editUrl + '/' +data[i]['id'] + '" >编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'+ delUrl + '/' +data[i]['id'] + '">删除</a></td>';
                bindStr += '</tr>'
            }
            bindData.innerHTML = bindStr;

		});

	</script>

</body>

</html>
