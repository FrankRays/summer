<?php
	
class Slider extends Ykj_Controller{
	//模板数组
	private $tpl;

	public function __construct(){
		parent::__construct();

		$this -> tpl = array(
			'browse' => 'v_01/config/slider_browse_view',
			'create' => 'v_01/config/slider_create_view'
			);

		//初始化分页信息
		$this -> pageNum = 15;
		//载入工具类
		$this -> load -> library('pagination');
		$this -> load -> model('config_model');
		$this -> load -> library('JsonOutUtil');
		$this -> jsonOutUtil = new JsonOutUtil();

		//potal
		$this -> yPotal();
	}

	public function index(){
		$this -> _data['content']['moduleName'] = '幻灯片管理';
		$this -> _data['content']['moduleDesc'] = '首页幻灯片管理';
		$this -> _data['sidebar'] = array();
		$this -> _data['foot'] = array();

		$this -> _data['content']['articles'] = $this -> config_model -> getSlide(10);
		// var_dump($this -> _data['content']['articles']);
		$this -> _view($this -> tpl['browse']);


	}

	public function create(){
		$this -> _data['content']['moduleName'] = '幻灯片管理';
		$this -> _data['content']['moduleDesc'] = '首页幻灯片管理';
		$this -> _data['sidebar'] = array();
		$this -> _data['foot'] = array();

		$post = $this -> input -> post();
		$get = $this -> input -> get();

		if($post){
			$post['section'] = 'slides';
			if($lastInsertId = $this -> config_model -> create($post)){
				$this -> jsonOutUtil -> resultOutString(true,
					array('msg' => '保存成功', 'id'=> $lastInsertId));
			}else{
				$this -> jsonOutUtil -> resultOutString(false,
					array('msg' => '保存失败'));
			}
			return ;
		}

		if(isset($get['id'])){
			$id = intval($get['id']);
			$article = $this -> config_model -> getById($id);
			$article['value'] = json_decode($article['value'], true);
			$this -> _data['content']['slider'] = $article;
		}

		$this -> _view($this -> tpl['create']);
	}

	public function del(){
		$post = $this -> input -> post();

		if(isset($post['id'])){
			$this -> config_model -> del($post['id']);
			$this -> jsonOutUtil -> resultOutString(true, array(
				'msg' => '删除成功'));
		}else{
			$this -> jsonOutUtil -> resultOutString(false, array(
				'msg' => '删除失败'));
		}
	}

}