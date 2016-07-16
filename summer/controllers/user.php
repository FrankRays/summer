<?php

defined('APPPATH') OR exit('forbbiden to access');

class User extends MY_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('user_model');
	}


	//添加用户
	public function create() {
		exit('create');
		$username = 'admin';
		$password = '123456';

		$this->user_model->signup($username, $password);
	}
}