<?php 

defined('APPPATH') OR exit('forbbiden to access');

//模块名称
$config['user_config']['module_name'] = array(
	'index'		=> '用户列表',
	'edit'		=> '修改用户',
	'create'	=> '添加用户',
	);


$config['user_config']['form_generate'] = array(
	'id'	=> array(
		'form_type' => 'input',
		'label'		=> 'ID',
		'attr'		=> array(
				'name'	=> 'id',
				'value'	=> set_value('id'),
				'type'	=> 'hidden',
				),
		'rules'		=> 'numeric',
		),
	'account'	=> array(
		'form_type' => 'input',
		'label'		=> '账号',
		'attr'		=> array(
				'name'	=> 'account',
				'value'	=> set_value('account'),
				'type'	=> 'text',
				),
		'rules'		=> 'min_length[4]|max_length[16]alpha_numeric_spaces',
		),
	'password1'	=> array(
		'form_type' => 'password',
		'label'		=> '密码',
		'attr'		=> array(
				'name'	=> 'password1',
				'value'	=> set_value('password1'),
				'type'	=> 'password',
			),
		'rules'		=> 'min_length[6]|max_length[16]|alpha_numeric_spaces',
		),
	'password2'	=> array(
		'form_type'	=> 'password',
		'label'		=> '重复密码',
		'attr'		=> array(
				'name'	=> 'password2',
				'value'	=> set_value('password2'),
				'type'	=> 'password',
			),
		'rules'		=> 'matches[password1]',
		),
	'nickname'	=> array(
		'form_type'	=> 'input',
		'label'		=> '昵称',
		'attr'		=> array(
				'name'	=> 'nickname',
				'value'	=> set_value('nickname'),
				'type'	=> 'text',
			),
		'rules'		=> 'required'
		),
	'realname'	=> array(
		'form_type'	=> 'input',
		'label'		=> '真实姓名',
		'attr'		=> array(
				'name'	=> 'realname',
				'value'	=> set_value('realname'),
				'type'	=> 'text',
			),
		'rules'		=> 'required',
		),
	'email'	=> array(
		'form_type'	=> 'input',
		'label'		=> '邮箱',
		'attr'		=> array(
				'name'	=> 'email',
				'value'	=> set_value('email'),
				'type'	=> 'text',
			),
		'rules'		=> 'required|valid_email',
		),
	'mobile'	=> array(
		'form_type'	=> 'input',
		'label'		=> '电话',
		'attr'		=> array(
				'name'	=> 'mobile',
				'value'	=> set_value('mobile'),
				'type'	=> 'text',
			),
		),
	);
