<?php defined('BASEPATH') || exit('no direct script access allowed');

$adminConf = array();
$adminConf['topBtn'] = array(
	'0' => array(
		'name' 		=> 	'文章管理',
		'linkSrc'	=>	site_url('admin/main/articleNav.html'),
		),
	'1' => array(
		'name'		=>	'幻灯片管理',
		'linkSrc'	=> 	''
		),
	);