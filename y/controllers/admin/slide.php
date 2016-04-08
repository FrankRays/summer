<?php defined('BASEPATH') || exit('no direct script access allowed');
/**
*@deal nav 
*@author ykjver
*@time 2014-10-26
*
**/

class slide extends Ykj_Controller{

	//controller name
	public $className = '';
	//construct function 
	public function __construct(){
		parent::__construct();

		$this -> className = 'slide';
		$this -> load -> model('config_model');
		$this -> load -> library('uri');
	}


	//add
	public function add(){
		$this -> load -> view($this -> className.'/add_view');
	}

	//doadd
	public function doAdd(){

		$name = $this -> input -> post('name', TRUE);
		$picSrc = $this -> input -> post('picSrc', TRUE);
		$summary = $this -> input -> post('summary', TRUE);
		$linkSrc = $this -> input -> post('linkSrc', TRUE);

		$data = array();
		$data['owner'] = 'system';
		$data['module'] = 'common';
		$data['section'] = 'slides';
		$value = array();
		$value['name'] = empty($name) ? '' : $name;
		$value['picSrc'] = empty($picSrc) ? '' : $picSrc;
		$value['summary'] = empty($summary) ? '' : $summary;
		$value['linkSrc'] = empty($linkSrc) ? '' : $linkSrc;
		$data['value'] = json_encode($value);

		if($this -> config_model -> add($data)){
			$msg = '添加图片展示成果';
			$href = site_url('admin/slide/li');
		}else{
			$msg = '添加图片展示失败';
			$href = site_url('admin/slide/add');
		}
		$this -> yerror -> showYError($msg, $href);
	}

	//list
	public function li(){
		$perPage = 10;
		$count = $this -> config_model -> getAmount();
		$data['count'] = $count;

		$data['pageLinks'] = $this -> _pagination2(base_url('admin/slide/li'), $count, $perPage);

		$curPage = $this -> uri -> segment(4) ? $this -> uri -> segment(4) : 0;
		$data['curPage'] = $curPage + 1;

		$data['slidesList'] = $this -> config_model -> getSlide($perPage, $curPage * $perPage);
		var_dump($data['slidesList']);
		exit();
		$this -> load -> view('slide/list_view', $data);
	}

	//editpage
	public function edit(){
		$id = $this -> uri -> segment(4);
		$id = intval($id);

		$slideInfo = $this -> config_model -> getById($id);
		$slideInfo['value'] = json_decode($slideInfo['value'], TRUE);

		$data = array();
		$data['slideInfo'] = $slideInfo;
		$this -> load -> view('slide/edit_view', $data);
	}

	//doeditpage
	public function doEdit(){
		$id = $this -> input -> post('id', TRUE);
		$id = intval($id);

		$value['name'] = $this -> input -> post('name', TRUE);
		$value['picSrc'] = $this -> input -> post('picSrc', TRUE);
		$value['summary'] = $this -> input -> post('summary' , TRUE);
		$value['linkSrc'] = $this -> input -> post('linkSrc', TRUE);
		$data['value'] = json_encode($value);

		if($this -> config_model -> update($data, $id)){
			$msg = '修改图片展示成功';
			$href = site_url('admin/slide/li');
		}else{
			$msg = '修改图片展示失败';
			$href = site_url('admin/slide/edit/'.$id);
		}

		$this -> yerror -> showYError($msg, $href);

	}

	//dodelpage
	public function del(){
		$id = $this -> uri -> segment(4);
		$id = intval($id);

		if($this -> config_model -> del($id)){
			$msg = '删除图片展示成功';
			$href = site_url('admin/slide/li');
		}else{
			$msg = '删除图片展示失败';
			$href = site_url('admin/slide/edit/'.$id);
		}

		$this -> yerror -> showYError($msg, $href);
	}
}