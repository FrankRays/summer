<?php defined('APPPATH') or exit('no access');?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>SNOW登陆</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

  <link rel="stylesheet" href="/static/css/all.css">
  <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
</head>

<body>
	<div class="header">
		<a class="logo" href="/" title="四川交院新闻网">四川交院新闻网</a>
	</div>
	<div class="main layui-clear">
		<h2 class="page-title">登陆</h2>
		<div class="layui-form layui-form-pane">
			<form method="post">
				<div class="layui-form-item">
					<label for="L_account" class="layui-form-label">帐号</label>
					<div class="layui-input-inline">
						<input type="text" id="L_account" name="account" required lay-verify="required" autocomplete="off" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label for="L_password" class="layui-form-label">密码</label>
					<div class="layui-input-inline">
						<input type="password" id="L_password" name="password" required lay-verify="required" autocomplete="off" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label for="L_security" class="layui-form-label">安全马</label>
					<div class="layui-input-inline">
						<input type="text" id="L_security" name="security" required lay-verify="required" autocomplete="off" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<button class="layui-btn" lay-filter="*" lay-submit="">立即登录</button>
					<span style="padding-left:20px;">忘记密码找管理员</span>
				</div>
			</form>
		</div>
	</div>
  	<script src="/static/plugins/layui/layui.js"></script>
</body>
</html>