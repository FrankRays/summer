<?php defined('BASEPATH') || exit('no direct script access allowed');

class Teacher extends Ykj_controller{

	protected $total_rows = '0';    // 新闻总记录数
	protected $per_page   = '2';   // 每页显示的记录数
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
		$this -> li();
	}
	/**取得新闻列表*/
	public function li(){
		$data['teacherList'] = $this -> teacher_model -> getList();

		$this -> load -> view('front/teacher/list.php', $data);
		$this -> loadFooter();
	}
	
	public function show($id = FALSE){
		if($id === ''){
			$this -> li();
		}


		$data['teacherInfo'] = $this -> teacher_model -> getById($id);

		$this -> load -> view('front/teacher/show.php', $data);
		$this -> loadFooter();
	}
}