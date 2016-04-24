<?php
	
class y extends MY_Controller{
	//模板数组
	private $tpl;

	public function __construct(){
		parent::__construct();

		$this -> tpl = array(
			'browse' => 'v_01/config/browse_view',
			'setCoverimg' => 'v_01/config/create_views'
			);

		//初始化分页信息
		$this -> pageNum = 15;
		//载入工具类
		$this -> load -> library('pagination');
		$this -> load -> model('config_model');
		$this -> load -> library('JsonOutUtil');
		$this -> jsonOutUtil = new JsonOutUtil();

		//tocal
		$this -> yPotal();
	}

	public function create(){
		$this -> _data['content']['moduleName'] = '幻灯片添加';
		$this -> _data['content']['moduleDesc'] = '首页幻灯片管理添加';
		$this -> _data['sidebar'] = array();
		$this -> _data['foot'] = array();

		$post = $this -> input -> post();
		$get = $this -> input -> get();

		if($post){

		}

		if(isset($get['id'])){
			
			
		}

	}


}