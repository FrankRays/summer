<?php defined('BASEPATH') || exit('no direct script access allowed');

class lm_new extends Ykj_Controller{

	//construct function 
	public function __construct(){
		parent::__construct();
		
		$this -> load -> model('lm_new_model');
		$this -> load -> model('category_model');
	}

	public function index(){

	}

	public function admin(){
		$navs = $this -> input -> post();
		$data = array();
		$data['articleCategoryArr'] = $this -> category_model -> getPairs();
		$data['navs'] = $this -> lm_new_model -> getNavs();
		var_dump($data['navs']);
		if(!empty($navs)){
			$this -> lm_new_model -> add($navs);
			var_dump($navs);
			exit();
		}

		//使用同一名称data方便前端直接用data就能得到值
		$this -> load -> view('lm_new/admin_view', array('data' => $data));
	}


	public function add(){
		$navs = $this -> lm_new_model -> add();
		var_dump($navs);
		echo 'i can progame when leaf start snow';
	}
}