<?php defined('BASEPATH') || exit('no direct script access allowed');

class lm extends Ykj_Controller {


	//construct function
	public function __construct(){
		parent::__construct();

		$this -> load -> model('lm_model');
		$this -> load -> model('news_category_model');

		$this -> judgeLogin();
	}


	//add
	public function add(){
		$data['categoryList'] = $this -> news_category_model -> getRecList();
		$this -> load -> view('lm/add_view', $data);
	}

	//doAdd
	public function doAdd(){
		$cid = $this -> input -> post('cid', TRUE);
		$name = $this -> input -> post('name', TRUE);
		$link_src = $this -> input -> post('link_src', TRUE);

		$data['cid'] = intval($cid);
		if( ! empty($name)){
			$data['name'] = addslashes($name);
		}else{
			$data['name'] = $this -> news_category_model -> getById($data['cid']);
			$data['name'] = $data['name']['name'];
		}


		if($this -> lm_model -> add($data)){
			$msg = '添加栏目成功';
			$href = site_url('admin/lm/li');
			$this -> yerror -> showYError($msg, $href);
			exit();
		}else{
			$msg = '添加栏目失败';
			$href = site_url('admin/lm/add');
			$this -> yerror -> showYError($msg, $href);
			exit();
		}
	}

	//List
	public function li(){
		$data['lmList'] = $this -> lm_model -> getList(null);
		//var_dump($data);
		$this -> load -> view('lm/list_view', $data);
	}

	//Edit
	public function edit($id = FALSE){
		if($id == FALSE){
			$msg = '编辑栏目失败';
			$href = site_url('admin/lm/li');
			$this -> yerror -> showYError($msg, $href);
			exit();
		}

		$id = intval($id);

		if( ! $data['lmInfo'] = $this -> lm_model -> getById($id)){
			$msg = '编辑栏目失败';
			$href = site_url('admin/lm/li');
			$this -> yerror -> showYError($msg, $href);
			exit();
		}

		if( ! $data['categoryList'] = $this -> news_category_model -> getRecList()){
			$msg = '编辑栏目失败';
			$href = site_url('admin/lm/li');
			$this -> yerror -> ShowYError($msg, $href);
			exit();
		}

		$this -> load -> view('lm/edit_view', $data);
	}

	public function doEdit(){
		$id = $this -> input -> post('id');
		$cid = $this -> input -> post('cid');
		$name = $this -> input -> post('name');
		$link_src = $this -> input -> post('link_src');

		$id = intval($id);
		$lmInfo['cid'] = intval($cid);
		$lmInfo['name'] = addslashes($name);
		$lmInfo['link_src'] = addslashes($link_src);
		if(empty($name)){
			$category = $this -> news_category_model -> getById($cid);
			$lmInfo['name'] = $category['name'];
		}

		if($this -> lm_model -> update($lmInfo, $id)){
			$msg = '修改栏目成功';
			$href = site_url('admin/lm/li');
			$this -> yerror -> showYError($msg, $href);
			exit();
		}else{
			$msg = '修改栏目失败';
			$href = site_url('admin/lm/edit/'.$id);
			$this -> yerror -> showYError($msg, $href);
			exit();
		}
	}


	//delete
	public function del($id){
		$id = intval($id);

		if($this -> lm_model -> del($id)){
			$msg = '删除栏目成功';
		}else{
			$msg = '删除栏目失败';
		}
		$href = site_url('admin/lm/li');

		$this -> yerror -> showYError($msg, $href);
	}

}