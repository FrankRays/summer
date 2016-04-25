<?php defined('BASEPATH') || exit('no direct script access allowed');


class Yerror{

	//后台没有普通提醒方法
	public function showYError($msg, $href = '#'){
		$errorStr = <<<EOF
		<!DOCTYPE html>
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Error</title>
		<body>
			<script>alert("{$msg}");location.href="{$href}";</script>
		</body>
		</head>
		</html>

EOF;
 echo $errorStr;
	}

	public function showYAdminError($msg, $href = '#'){
		$errorStr = <<<EOF
		<!DOCTYPE html>
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Error</title>
		<body>
			<script>alert("{$msg}");parent.location.href="{$href}";</script>
		</body>
		</head>
		</html>

EOF;
 echo $errorStr;	
	}
}