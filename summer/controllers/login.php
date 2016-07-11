<?php defined('BASEPATH') || exit('no direct script access allowed');

/**
 * login controller
 */

class login extends MY_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('user_model');
	}

	public function index() {
		
		$this->login();
	}

	public function login() {

		
		$this->load->library('form_validation');

		if(isset($_POST['username'])) {
			//post request
			$this->form_validation->set_rules('username', '用户名', 'trim|required|min_length[1]|max_length[16]|callback__hasUsername');
			$this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]|max_length[32]|callback__checkPassword');

			if($this->form_validation->run()) {
				redirect(site_url('c=post'));
			}
		}else{
			//get request
		}

		$this->load->view("v_01/user/login_view");
	}

	public function _hasUsername($username='') {
		if($this->user_model->hasAccount($username)) {
			return TRUE;
		}else{

			$this->form_validation->set_message('_hasUsername', '用户名不存在');
			return FALSE;
		}
	}

	public function _checkPassword($password='', $val) {
		$username = $this->input->post('username', TRUE);

		if($this->user_model->signIn($username, $password)) {
			return TRUE;
		}else{
			$this->form_validation->set_message('_checkPassword', '密码错误');
			return FALSE;
		}

	}

}