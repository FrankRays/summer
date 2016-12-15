<?php defined('BASEPATH') || exit('no direct script access allowed');

class User extends MY_Controller {

	public function __construct(){
		parent::__construct();

		$this -> load -> model('user_model');
	}

	public function index() {
		echo 'index';
	}

	public function login() {

		if($_POST) {
			var_dump($_POST);
		}
		$this->load->view('admin/login_view');
	}
}