<?php defined('BASEPATH') || exit('no direct script access allowed'); 

/**
*学生管理控制器类
**/

class student extends Ykj_Controller{

	//construct function
	function __construct(){
		parent::__construct();

		$this -> load -> model('student_model');
		//$this -> load -> library('url');
		$this -> load -> library('pagination');
		$this -> judgeLogin();
	}


	//添加页面
	public function add(){
		$this -> load -> view('student/add_view');
	}

	//添加动作页面
	public function doAdd(){
		$msg = $this -> _chkSub();

		if($msg['error'] == 1){
			$this -> yerror -> showYerror($msg['msg'], $msg['href']);
			exit();
		}

		if($this -> student_model -> add($msg['data'])){
			$msg = '添加学生信息成功';
			$href = site_url('admin/student/li');
			$this -> yerror -> showYerror($msg, $href);
		}else{
			$msg = '未知错误，添加学生信息失败';
			$href = site_url('admin/student	/add');
			$this -> yerror -> showYerror($msg, $href);
		}
	}

	//学生列表页面
	public function li($offset = 0){
		$config = array(
			'base_url' => 		base_url('admin/student/li'),
			'total_rows'=> 		$this -> student_model -> getRowNum(),
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

		$result = $this -> student_model -> getList($config['per_page'], $this -> uri -> segment(4));
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
		$this -> load -> view('student/list_view', $data);
	}

	//编辑界面
	public function edit($id = FALSE){

		$result = $this -> student_model -> getById($id);
		$data = array(
			'data' => $result,
			);

		$this -> load -> view('student/edit_view', $data);
	}

	//编辑动作页面
	public function doEdit(){
		$id = $this -> input -> post('id', TRUE);
		$subData = $this -> _chkSub('edit/' . $id);

		if($subData['error'] == 1){
			$this -> yerror -> showYerror($subData['msg'], $subData['href']);
			exit();
		}else{
			$subData = $subData['data'];
		}

		if($this -> student_model -> update($subData, $id)){
			$msg = '学生信息更新成功';
			$href = site_url('admin/student/li');
			$this -> yerror -> showYerror($msg, $href);
		}else{
			$msg = '未知错误，更新学生信息失败';
			$href = site_url('admin/student/edit/'.$id);
			$this -> yerror -> showYerror($msg, $href);
		}
	}

	//学生删除动作页面
	public function del($id){
		if($this -> student_model -> delByIds($id)){
			$msg = '删除学生信息成功';
			$href = site_url('admin/student/li');
		}else{
			$msg = '错误，删除学生信息失败';
			$href = site_url('admin/student/li');
		}
		$this -> yerror -> showYerror($msg, $href);
	}

	//检查学生提交表单是否正确
	public function _chkSub($type = 'add'){
		$name = $this -> input -> post('name', TRUE);
		$picSrc = $this -> input -> post('picSrc', TRUE);
		$summary = $this -> input -> post('summary', TRUE);
		$desc = $this -> input -> post('desc', TRUE);
		$graduateTime = $this -> input -> post('graduateTime', TRUE);
		$profession = $this -> input -> post('major', TRUE);

		if(empty($name)){
			$msg = array(
				'error' => 1,
				'msg' => '学生名称不能为空',
				'href' => site_url('admin/student/'.$type),
				);
			return $error;
		}

		if(empty($summary)){
			$msg = array(
				'error' => 1,
				'msg' => '学生简介不能为空',
				'href' => site_url('admin/student/'.$type),
				);
			return $msg;
		}

		if(empty($graduateTime)){
			$msg = array(
				'error' => 1,
				'msg' => '学生毕业时间不能为空',
				'href'=> site_url('admin/student/'.$type),
				);
			return $msg;
		}

		if(empty($profession)){
			$msg = array(
				'error' => 1,
				'msg' => '学生专业不能为空',
				'href' => site_url('admin/student/'.$type),
				);
			return $msg;
		}

		$msg = array(
			'error' => 0,
			'data' => array(
				'name' => $name,
				'pic_src' => $picSrc,
				'summary' => $summary,
				'introl' => $desc,
				'add_time' => time(),
				'profession' => $profession,
				'graduate_time' => $graduateTime,
				),
			);
		return $msg;

	}
}