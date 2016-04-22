<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>新闻网后台登陆 | snowCMS</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="format-detection" content="telephone=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="alternate icon" type="image/png" href="assets/i/favicon.png">
  <link rel="stylesheet" href="<?php echo base_url('source/AmazeUI-2.1.0/assets/css/amazeui.min.css') ?>"/>
  <style>
    .header {
      text-align: center;
    }
    .header h1 {
      font-size: 200%;
      color: #333;
      margin-top: 30px;
    }
    .header p {
      font-size: 14px;
    }
  </style>
</head>
<body>
<div class="header">
  <div class="am-g">
    <h1>snow CMS</h1>
    <p>Be busy living or be busy dying</p>
  </div>
  <hr />
</div>
<div class="am-g">
  <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
    <h3>登录</h3>
    <hr>
    <div id="y-signin-alert" style="display:none;" class="am-alert am-alert-danger" data-am-alert>
 		
	</div>

    <?php echo validation_errors() ?>
    <form id="login-form" action="#" method="post" class="am-form" data-am-vaildator>
      <div class="am-form-group">
        <label for="account">账号:</label>
        <input class="am-form-field" type="text" name="username" id="username" value="<?php set_value('username') ?>"  required placeholder="输入用户名"/>
      </div>

      <div class="am-form-group">
        <label for="password">密码:</label>
        <input class="am-form-field"  type="password" name="password" id="password" value="" placeholder="输入密码" required/>
      </div>
      <div class="am-form-group">
        <label for="remember-me">
          <input id="remember-me" type="checkbox">
          记住密码
        </label>
      </div>

      <div class="am-cf">
        <input id="do-login" type="submit" name="" value="登 录" class="am-btn am-btn-primary am-btn-sm am-fl">
        <input type="submit" name="" value="忘记密码 ^_^? " class="am-btn am-btn-default am-btn-sm am-fr">
      </div>
    </form>
    <hr>
    <div id="debug"></div>
    <p>© 2014 copyright atob ykjver</p>
  </div>
</div>
<!-- 登陆模糊窗口 -->
<div class="am-modal am-modal-loading am-modal-no-btn" tabindex="-1" id="y-signin-loading">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">抢滩登陆中...</div>
    <div class="am-modal-bd">
      <span class="am-icon-spinner am-icon-spin"></span>
    </div>
  </div>
</div>
<!-- 登陆模糊窗口 -->
<script src="<?php echo base_url('source/AmazeUI-2.1.0/assets/js/jquery.min.js') ?>"></script>
<script src="<?php echo base_url('source/AmazeUI-2.1.0/assets/js/amazeui.min.js') ?>"></script>
</body>
</html>