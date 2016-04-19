<?php defined('BASEPATH') || exit('no direct script access allowed');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta charset="utf-8">
<title>人文系后台登陆</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="viewport" content="width=device-width">
<link href="<?php echo base_url('source/css/login.css') ?>" rel="stylesheet" type="text/css">
<script src="<?php echo base_url('source/js/jquery.js') ?>"></script>
</head>
<body>

<div class="login">
<form action="" method="post" id="form">
	<div class="logo"></div>
    <div class="login_form">
    	<div class="user">
        	<input class="text_value" value="" name="username" type="text" id="username">
            <input class="text_value" value="" name="password" type="password" id="password">
        </div>
        <button class="button" id="submit" type="button" style="cursor:pointer">登录</button>
    </div>
    
    <div id="tip"></div>
    <div class="foot">
	Copyright &copy; 2014.Company name All rights reserved.
    </div>
    </form>
</div>
<script>
var userAddUrl = '<?php echo site_url('admin/user/doLogin') ?>';
$('document').ready(function(){
	$('#submit').click(function(){
		var username = $("#username").val();
		var password = $("#password").val();
		if(username == '' || password == ''){
			alert('用户名和密码不能为空');
		}else{
			var subData = {
				'username' : username,
				'password' : password
			}
			$.post(userAddUrl, subData, function(data, msg){
				data = JSON.parse(data);
				if(data == '' || msg != 'success' || data.error != '0'){
					alert(data.msg);
				}else if( data != '' && msg == 'success' && data.error == '0'){
					alert('Login Success!');
					location.href = data.href;
				}else{
					alert('未知错误，请尝试重新登陆');
				}
			});
		}
	});
});

</script>
</body>
</html>