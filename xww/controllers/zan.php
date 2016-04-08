<?php 

class zan extends Ykj_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('news_model');
	}


	public function add_zan($id) {
		$this->news_model->add_zan($id);
	}
}