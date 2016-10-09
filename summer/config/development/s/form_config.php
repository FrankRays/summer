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
	'article_cate_access'	=> array('name'=>'article_cate_access', 'type'=>'string', 'form_type'=>'multiselect', 'label'=>'文章分类权限', 'attr'=>array('mutiple', 'data-am-selected')),
	'account'	=> array('name'=>'account', 'type'=>'string', 'value'=>'', 'form_type'=>'textinput', 'label'=>'账号'
		, 'rules'=>'required|min_length[4]|max_length[16]'),
	'password'	=> array('name'=>'password', 'type'=>'string', 'value'=>'', 'form_type'=>'textinput', 'label'=>'密码'
		, 'rules'=>'required|min_length[6]|max_length[32]'),
	'repassword'=> array('name'=>'repassword', 'type'=>'string', 'value'=>'', 'form_type'=>'textinput', 'label'=>'重复密码'
		, 'rules'=>'matches[password]'),
	'nickname'	=> array('name'=>'nickname', 'type'=>'string', 'value'=>'', 'form_type'=>'textinput', 'label'=>'昵称'
		,'rules'=>'required'),
	'realname'	=> array('name'=>'realname', 'type'=>'string', 'value'=>'', 'form_type'=>'textinput', 'label'=>'真实姓名'
		, 'rules'=>'required'),
	'email'	=> array('name'=>'email', 'type'=>'string', 'value'=>'', 'form_type'=>'textinput', 'label'=>'邮箱'
		, 'rules'=>'required|valid_email'),
	'mobile'	=> array('name'=>'mobile', 'type'=>'string', 'value'=>'', 'form_type'=>'textinput', 'label'=>'电话'
		, 'rules'=>'required|is_natural'),
	);

//change user password form config
$config['change_password_form'] = array(
	'class' 	=>'am-form am-form-horizontal',
	'action'	=> 'c=user&m=change_password',
	'fields'	=> array(
		'old_password'	=> array('name'=>'old_password', 'form_type'=>'password', 'value'=>'', 'label'=>'旧密码', 
			'rules'=>'required|min_length[4]|max_length[16]'),
		'new_password'	=> array('name'=>'new_password', 'form_type'=>'password', 'value'=>'', 'label'=>'新密码',
			'rules'=>'required|min_length[4]|max_length[16]'),
		're_new_passowrd'=> array('name'=>'re_new_passowrd', 'form_type'=>'password', 'value'=>'', 'label'=>'重复新密码',
			'rules'=>'required|min_length[4]|max_length[16]'),
		),
	);