<?php defined('BASEPATH') || exit('no direct script access allowed') ?>
<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YYCMS</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url('source/ft/tw/bootstrap/css/bootstrap.css') ?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
		.ul-grade-2{margin-left:30px;}
		.ul-grade-3{margin-left:60px;}
    </style>
  </head>
  <body>
  <!--代码-->
  	<div class="head">
		<div class="navbar navbar-default" role="navigation">
		  <div class="navbar-header">
		       <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-responsive-collapse">
		         <span class="sr-only">Toggle Navigation</span>
		         <span class="icon-bar"></span>
		         <span class="icon-bar"></span>
		         <span class="icon-bar"></span>
		       </button>
		       <a href="##" class="navbar-brand">YYCMS</a>
		  </div>

		  <div class="collapse navbar-collapse navbar-responsive-collapse">
		    	<ul class="nav navbar-nav">
		      		<li class="active"><a href="##">文章管理</a></li>
		      		<li><a href="##">图片管理</a></li>
		      		<li><a href="##">单页管理</a></li>
		      		<li><a href="##">配置</a></li>
		      		<li><a href="##">网站信息</a></li>
			 	</ul>
		  </div>
		</div>
	</div>
	<div class="col-sm-2 admin-left" style="border:solid 1px red;">111</div>

	<div class="col-sm-10 admin-right">
	<div style="display:none">
		<li id="li-1-source" >
			<select name="nav-type" class="form-control" id="nav-type">
				<option value="system">系统</option>
				<option value="archive">文章</option>
				<option value="article">单页</option>
			</select>
			<select class="form-control" name="nav-archive-url" id="nav-archive-url">
				<option value="4">/php/源码分析</option>
				<option value="6">/php/ci框架源码分析</option>
			</select>
			<select class="form-control" id="nav-article-url" name="nav-article-url" class="display:none">
				<option value="1">单页测试</option>
			</select>
			<select class="form-control" name="nav-system-url" id="nav-system-url">
				<option value="1">首页</option>
			</select>
			<input type="text" class="form-control" placeholder="导航名称" id="nav-name" name="nav-name" value="/php" />
			<label class="checkbox">
				<input type="checkbox" class="form-control" />新开窗口
			</label>
			<a href="javascript:;" class="plus1">添加</a>
			<a href="javascript:;" class="plus2">添加子导航栏</a>
			<a href="javascript:;" class="del">删除</a>
			<input type="hidden" name="key" value="0" />
		</li>
		<li id="li-2-source" >
			<select name="" class="form-control">
				<option value="system">系统</option>
				<option value="article">文章</option>
				<option value="page">单页</option>
			</select>
			<select class="form-control">
				<option value="3">/php</option>
				<option value="4">/php/源码分析</option>
				<option value="6">/php/ci框架源码分析</option>
			</select>
			<input type="text" class="form-control" value="/php" />
			<label class="checkbox">
				<input type="checkbox" class="form-control" />新开窗口
			</label>
			<a href="javascript:;" class="plus2">添加</a>
			<a href="javascript:;" class="plus3">添加子导航栏</a>
			<a href="javascript:;" class="del">删除</a>
			<input type="hidden" name="key" value="0" />
			<input type="hidden" name="parent" value="-1" /> 
		</li>
	</div>
	<div class="panel">
		<h2>导航栏设置</h2>
		<form class="form-inline " role="form" method="post">
			<ul class="list-unstyled ul-grade-1" id="ulcontainer">
			<!--
				<li class="li-grade-1">
					<select name="type" class="form-control">
						<option value="system">系统</option>
						<option value="article">文章</option>
						<option value="page">单页</option>
					</select>
					<select name="url" class="form-control">
						<option value="1">首页</option>
					</select>

					<input name="name" type="text" class="form-control" value="首页" />
					<label class="checkbox">
						<input name="isblank" type="checkbox" class="form-control" />新开窗口
					</label>
					<a href="javascript:;" class="plus1">添加</a>
					<a href="javascript:;" class="plus2">添加子导航栏</a>
					<a href="javascript:;">删除</a>
					<input type="hidden" name="key" value="0" />
					<input type="hidden" name="parent" value="-1" /> 
				</li>
				-->
			</ul>
			<input id="submit-btn" type="button"  class="btn btn-primary" value="添加" />
		</form>
			<div id="debug"></div>
	</div>
	</div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url('source/ft/tw/bootstrap/js/jquery.js') ?>"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url('source/ft/tw/bootstrap/js/bootstrap.js') ?>"></script>

	<script>
	$(function(){
		var ligrade1Source = $('#li-1-source');
		var ligrade2Source = $('#li-2-source');
		var container = $('#ulcontainer');

		function ul(){
			var ligrade1Source = $('#li-1-source');
			var ligrade2Source = $('#li-2-source');
			var container = $('#ulcontainer');
			var showData = JSON.parse('[<?php echo json_encode($data)?>]')[0];

			var html = '';

			return {
				iniUl : function(){
					var navs = showData.navs;
					var navs2;
					$(navs).each(function(i, ele){
						var cloneLi = $("#li-1-source");
						if(ele.type == 'system'){
							cloneLi.children('#nav-article-url').css({'display':'none'});
							cloneLi.children('#nav-archive-url').css({'display':'none'});
							cloneLi.children('#nav-system-url').css({'display':'inline'});
						}else if(ele.type == 'article'){
							cloneLi.children('#nav-system-url').css({'display':'none'});
							cloneLi.children('#nav-archive-url').css({'display':'none'})
							cloneLi.children('#nav-article-url').css({'display':'inline'});
						}else if(ele.type == 'archive'){
							cloneLi.children('#nav-article-url').css({'display':'none'});
							cloneLi.children('#nav-system-url').css({'display':'none'});
							cloneLi.children('#nav-archive-url').css({'display':'inline'});
						}
						html += '<li class="li-grade-1">' + $("#li-1-source").html();
						if(ele['children']){
							console.log(ele['children'])
							html += '<ul class="list-unstyled ul-grade-2">';
							$(ele['children']).each(function(i2, ele2){
								html += '<li class="li-grade-2">' + $("#li-1-source").html() + '</li>';
							});
							html += '</ul>';
						}
						html += '</li>';
					});
					container.html(html);
				}
			};
		}

		var ulObj = ul();
		ulObj.iniUl();

		$("#submit-btn").click(function(){

			var data = {};
			var ligrade1 = $('.li-grade-1');
			ligrade1.each(function(i,ele){
				var curInput = $(':input', ele);
				data[i] = {};
				data[i]['type'] = curInput.eq(0).val();
				data[i]['url'] = curInput.eq(1).val();
				data[i]['name'] = curInput.eq(2).val();
				data[i]['isblank'] = curInput.eq(3).val();

				if(0 != $('ul', ele).size()){
					data[i]['children'] = {};
					var curligrade2 = $('li', ele);
					curligrade2.each(function(i2, ele2){
						var curInput2 = $(':input', ele2);
						data[i]['children'][i2] = {};
						data[i]['children'][i2]['type'] = curInput2.eq(0).val();
						data[i]['children'][i2]['url'] = curInput2.eq(1).val();
						data[i]['children'][i2]['name'] = curInput2.eq(1).val();
						data[i]['children'][i2]['isblank'] = curInput2.eq(1).val();
					});
				}
			});
			console.log(data);
			$.ajax({
				type : 'POST',
				url : '<?php echo site_url('admin/lm_new/admin')?>',
				data : data,
				success : function(msg){
					$('#debug').html(msg);
				}
			});
		});

		var index = 0;

		$(".form-inline").on('click', '.plus1', function(){
			var cloneLi = $('#li-1-source').clone();
			cloneLi.addClass('li-grade-1');
			if($(this).parent().next().children().is('ul')){
				$(this).parent().next().after(cloneLi);
			}else{
				$(this).parent().after(cloneLi);
			}

		});



		$(".form-inline").on('click', '.plus2', function(){
			var cloneLi = $('#li-2-source').clone();
			cloneLi.children(':input[name=parent]').val(cloneLi.children(':input[name=key]').val())
			cloneLi.children(':input[name=key]').val(1000+index++);
			var container = $(this).parents('.li-grade-2');

			//判断判断是在li-grade-1添加还是在li-grade-2添加
			//如果是在li-grade-1中添加的话，就找不到li-grade-2
			if(0 == container.size()){
				//如果是第一次添加的就先创建ul
				if($(this).parents('.li-grade-1').find('ul').size() == 0){
					var temp = '<ul class="ul-grade-2 list-unstyled"><li class="li-grade-2">' + cloneLi.html() + '</li></ul>';
					$(this).parents('.li-grade-1').append(temp);
				}else{
					cloneLi.removeAttr('id');
					cloneLi.addClass('li-grade-2');
					$(this).siblings('ul').append(cloneLi);
				}
			}else{
				$(this).parent().append(cloneLi.wrap('<ul class="ul-grade-2"></ul>'));
			}
		});

		$('.form-inline').on('click', '.del', function(e){
			$(e.target).parent('li').remove();
		});
	});
	</script>
  </body>
</html>