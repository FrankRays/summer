<?php

defined('APPPATH') OR exit('forbbiden to access');

class Main extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('site_model');
		$this->load->model('user_model');
	}

	public function index() {
		if( ! $this->user_model->verify()) redirect('c=user&m=login');
		$view_data['module_name'] = '主面板';
		$view_data['site'] = $this->site_model->get_one_by_id(1);

		$this->_load_view('default/main_index_view', $view_data);
	}


}