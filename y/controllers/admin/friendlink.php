<?php defined('BASEPATH') || exit('no direct script access allowed');

class friendlink extends Ykj_Controller{

	//__construct function
	public function __construct(){
		parent::__construct();

		$this -> load -> model('friendlink_model');
		$this -> load -> library('pagination');
		$this -> judgeLogin();
	}


	public function add(){
		$this -> load -> view('friendlink/add_view');
	}


	public function doAdd(){
		$name = $this -> input -> post('name', TRUE);
		$url = $this -> input -> post('url', TRUE);

		if(empty($name)){
			$msg = '链接名字不能为空';
			$href = site_url('admin/friendlink/add');
			$this -> yerror -> showYerror($msg, $href);
			exit();
		}
		if(empty($url)){
			$msg = '链接不能为空';
			$href = site_url('admin/friendlink/add');
			$this -> yerror -> showYerror($msg, $href);
			exit();
		}

		$data = array(
			'name' => $name,
			'link_url'=> $url
			);

		$this -> friendlink_model -> add($data);

		$msg = '添加友情链接成功';
		$href = site_url('admin/friendlink/li');
		$this -> yerror -> showYerror($msg, $href);
	}

	//列表页面
	public function li($offset = 0){
		$config = array(
			'base_url' => 		base_url('admin/friendlink/li'),
			'total_rows'=> 		$this -> friendlink_model -> getRowNum(),
			'per_page' => 		5,
			'uri_segment' => 	4,
			'num_links' => 		7,
			'full_tag_open' => 	'<ul class="paginList">',
			'full_tag_close' => '</ul>',
			'next_link' => 		'<span class="pagenxt"></span>',
			'next_tag_open' => 	'<li class="paginItem">',
			'next_tag_close' => '</li>',
			'prev_link' => 		'<span class="pagepre"></span>',
			'prev_tag_open' => 	'<li class="paginItem">',
			'prev_tag_close' => '</li>',
			'cur_tag_open'=> 	'<li class="paginItem current"><li class="paginItem current"><a href="javascript:;">',
			'cur_tag_close' => 	'</a></li>',
			'num_tag_open' =>	'<li class="paginItem">',
			'num_tag_close' => 	'</li>',
			);
		$this -> pagination -> initialize($config);
		$pagination = $this -> pagination -> create_links();

		$result = $this -> friendlink_model -> getList($config['per_page'], $this -> uri -> segment(4));
		if($offset == 0){
			$offset = 1;
		}else{
			$offset = $this -> pagination -> cur_page;
		}
		$data = array(
			'pagination' => $pagination,
			'data' => $result,
			'totalRows' => $config['total_rows'],
			'curPage' => $offset,
			);

		$this -> load -> view('friendlink/list_view', $data);
	}

	//编辑界面
	public function edit($id = FALSE){

		$result = $this -> friendlink_model -> getById($id);
		$data = array(
			'data' => $result,
			);

		$this -> load -> view('friendlink/edit_view', $data);
	}

	//编辑动作页面
	public function doEdit(){
		$id = $this -> input -> post('id', TRUE);
		$id = intval($id);
		$name = $this -> input -> post('name', TRUE);
		$link_url = $this -> input -> post('url', TRUE);

		$subData = array(
			'name' => $name,
			'link_url' => $link_url,
			);

		if($this -> friendlink_model -> update($subData, $id)){
			$msg = '友情链接更新成功';
			$href = site_url('admin/friendlink/li');
			$this -> yerror -> showYerror($msg, $href);
		}else{
			$msg = '未知错误，更新友情链接失败';
			$href = site_url('admin/friendlink/edit/'.$id);
			$this -> yerror -> showYerror($msg, $href);
		}
	}

	//友情链接删除动作页面
	public function del($id){
		if($this -> friendlink_model -> delByIds($id)){
			$msg = '删除友情链接信息成功';
			$href = site_url('admin/friendlink/li');
		}else{
			$msg = '错误，删除友情链接信息失败';
			$href = site_url('admin/friendlink/li');
		}
		$this -> yerror -> showYerror($msg, $href);
	}



}