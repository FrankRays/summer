<?php defined('BASEPATH') || exit('no direct script access allowed');

class Student extends Ykj_controller{

	protected $total_rows = '0';    // 新闻总记录数
	protected $per_page   = '3';   // 每页显示的记录数
	protected $lm_alias = '';     	// 栏目的别名
	/*构造方法*/
	public function __construct(){
		parent::__construct();
		$this -> load -> model('lm_model');
		$this -> load -> model('news_model');
		$this -> load -> model('news_category_model');
		$this -> load -> model('teacher_model');
		$this -> load -> model('student_model');
		$this -> load -> helper('url');
		$this -> load -> library('pagination');
		$this -> loadHeader();
	}
	/*前台主控制器*/
	public function index(){
		$data['lm_list'] = Student :: _lm('20','1');
		$this -> load -> view('front/student_view.php', $data);
	}
	/**取得新闻列表*/
	public function li(){
		$data['studentList'] = $this -> student_model -> getList();
		$this -> load -> view('front/student_view', $data);
		$this -> loadFooter();
	}

	public function show(){
		$data['lm_list'] = Student :: _lm('20','1');
		//$data['tz_list'] = $this -> _tz();
		$tz = Student :: _tz();
		$data['tzgg_link'] = $tz['tzgg_link'];
		$data['tz_list'] = $tz['tz_list'];
		$lm_tzgg = Student :: _lm_tzgg('tzgg', '0');

		$hidden_lm_list = Student :: _lm('20', '0');
		$hidden_lm_list_length = count($hidden_lm_list);
		for($h = 0; $h < $hidden_lm_list_length; $h++){
			if($hidden_lm_list[$h]['alias'] == 'tzgg'){
				$data['tzgg_link'] = $hidden_lm_list[$h]['link_src'];
			}else{
				$data['tzgg_link'] = 'http://rwx.svtcc.edu.cn/index.php/rw';
			}

		}
		//$data['tz_list'] = $this -> _tz();
		$this->lm_alias = $this -> uri -> segment(3);
		$lm_list_length = count($data['lm_list']);
		for($i = 0; $i < $lm_list_length; $i++){
			if($data['lm_list'][$i]['alias'] == $this ->lm_alias ){
				$data['lm_pic_src'] = $data['lm_list'][$i]['pic_src'];
				$data['lm_name'] = $data['lm_list'][$i]['name'];
				$data['lm_alias'] = $data['lm_list'][$i]['alias'];
			}
		}
		if(empty($data['lm_pic_src'])){
			$data['lm_pic_src'] = 'images/front/banner.jpg';
		}
		if(empty($data['lm_name'])){
			redirect(site_url('rw'));
		}
		$student_id = intval($this -> uri -> segment(4));
		$data['student_con'] = $this -> student_model -> getById($student_id);
		$this -> load -> view('front/s_show_view.php', $data);
	}
}