<?php 
defined('APPPATH') or exit('no access');

//navigation form configuration
$config['nav_form'] = array(
	'class'		=> 'am-form am-form-horizontal',
	'action'	=> 'c=nav&m=create',
	);

$config['create_fields'] = array('id, cid, article_cid, target, label, href, status');
$config['update_fields'] = array('id, cid, article_cid, target, label, href, status');

$config['nav_form']['fields'] = array(
			"id"		=> array(
				"name"			=> "id",
				"type"			=> "int",
				"value"			=> "",
				"form_type"		=> "hiddeninput",
				),
			"cid"		=> array(
				"type"			=> "int",
				"name"			=> "cid",
				"form_type"		=> "select",
				"label"			=> "导航栏类别",
				"options"		=> array(),
				),
			"article_cid"	=> array(
				"name"			=> "article_cid",
				"label"			=> "文章分类",
				"type"			=> "char",
				"form_type"		=> 'select',
				"options"		=> array(
					),
				),
			"target"	=> array(
				"name"			=> "target",
				"type"			=> "char",
				"form_type"		=> "radio",
				"label"			=> "链接到",
				"default_value"	=> '1',
				"selects"			=> array(
					array("label"=>"站内", "value"=>'1', "default_checked"=>TRUE),
					array("label"=>"站外", "value"=>'0',)
					)
				),
			"label"		=> array(
				"type"			=> "string",
				"form_type"		=> "textinput",
				"label"			=> "标志",
				),
			"href"	=> array(
				"type"			=> "string",
				"form_type"		=> "textinput",
				"label"			=> "链接",
				),
			"status"	=> array(
				"name"			=> 'status',
				"type"			=> "char",
				"form_type"		=> "radio",
				"label"			=> "显示",
				"default_value"	=> '1',
				"selects"			=> array(
					array("label"=>"显示", "value"=>'1', "default_checked"=>TRUE),
					array("label"=>"隐藏", "value"=>'0',)
					)
				),
			);


//user form
$config['user_form'] = array(
	'class'		=> 'am-form am-form-horizontal',
	'action'	=> 'c=nav&m=create',
	);
$config['user_form']['fields'] = array(
	'id'		=> array('name'=>'id','type'=> 'int','value'=> '','form_type'=> 'hiddeninput',),
	'account'	=> array('name'=>'account', 'type'=>'string', 'value'=>'', 'form_type'=>'textinput', 'label'=>'账号'),
	'password1'	=> array('name'=>'password1', 'type'=>'password', 'value'=>'', 'form_type'=>'password', 'label'=>'密码'),
	'password2'	=> array('name'=>'password2', 'type'=>'password', 'value'=>'', 'form_type'=>'password', 'label'=>'重复密码'),
	'nickname'	=> array('name'=>'nickname', 'type'=>'string', 'value'=>'', 'form_type'=>'textinput', 'label'=>'昵称'),
	'realname'	=> array('name'=>'realname', 'type'=>'string', 'value'=>'', 'form_type'=>'textinput', 'label'=>'真实姓名'),
	'email'	=> array('name'=>'email', 'type'=>'string', 'value'=>'', 'form_type'=>'textinput', 'label'=>'邮箱'),
	'mobile'	=> array('name'=>'mobile', 'type'=>'string', 'value'=>'', 'form_type'=>'textinput', 'label'=>'电话'),
	);