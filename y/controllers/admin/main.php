<?php defined('BASEPATH') || exit('no direct script access allowed');


class main extends Ykj_Controller{

	//construct function
	public function __construct(){
		parent::__construct();

		$this -> load -> model('news_category_model');
		$this -> judgeLogin();
	}

	//框架页面
	public function index(){
		$this -> load -> view('admin/frame_view');
	}

	//后台头部
	public function top(){
		$username = $this -> session -> userdata('Clogin');
		$this -> load -> view('admin/top_view', $username); 
	}

	//后台的左边导航栏
	public function left(){
		$categoryList = $this -> news_category_model -> getRecList();
		$temp = array();
		foreach($categoryList as $k => $v){
			if($v['lev'] == 1){
				$parent = $k;
				$childNum = 0;
			}

			if($v['lev'] == 2){
				$categoryList[$parent]['child'][$childNum++] = $v;
				unset($categoryList[$k]);
			}
		}

		
		$data = array(
			'categoryList' => $categoryList,
			);
		$this -> load -> view('admin/left_view', $data);
	}

	public function right(){
		$this -> load -> view('admin/main_view');
	}

	//article navigation
	public function  articleNav(){
		$categoryList = $this -> news_category_model -> getRecList();
		$temp = array();
		foreach($categoryList as $k => $v){
			if($v['lev'] == 1){
				$parent = $k;
				$childNum = 0;
			}

			if($v['lev'] == 2){
				$categoryList[$parent]['child'][$childNum++] = $v;
				unset($categoryList[$k]);
			}
		}

		
		$data = array(
			'categoryList' => $categoryList,
			);
		$this -> load -> view('admin/articleNav_view', $data);
	}
}