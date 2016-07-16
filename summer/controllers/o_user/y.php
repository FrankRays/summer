<?php defined('BASEPATH') || exit('no direct script access allowed');

class y extends Ykj_Controller{
	
	public function __construct(){
		parent::__construct();

		$this -> load -> model('user_model');
	}

	//主页面
	public function index(){
		echo 'asdf';
	}

	public function add(){
		$this -> load -> view('user/add_view');
	}

	public function _doAdd(){
		$email = $this -> input -> post('email', TRUE);
		$name = $this -> input -> post('name', TRUE);
		$pwd = $this -> input -> post('pwd', TRUE);

		$data = array(
			'email' => $email,
			'name' => $name,
			'password' => $pwd,
			);
		$result = $this -> user_model -> add($data);
		var_dump($result);
	}

	public function login(){
		$this -> load -> view('user/login_view');
	}


	//登陆处理页面
	public function doLogin(){
		$username = $this -> input -> post('username', TRUE);
		$password = $this -> input -> post('password', TRUE);
		$subData['email'] = addslashes($username);
		$subData['password'] = addslashes($password);

		if($userInfo = $this -> user_model -> chkuser($subData)){
			//var_export($userInfo);
			$sessionData = array(
				'email' => $userInfo['email'],
				'life' => time() + 60 * 60 * 20,
				'username' => $userInfo['name']
				);	
			$this -> session -> set_userdata(array('Clogin' => $sessionData));
			$_SESSION['user'] = $sessionData;
			$jsonData = array(
				'error' => 0,
				'href' => site_url('admin/main'),
				);
			echo json_encode($jsonData);
			exit();
		}else{
			$jsonData = array(
				'error' => 1,
				'msg' => '登录失败，密码或者用户名错误',
				'href' => site_url('admin/user/login'),
				);
			echo json_encode($jsonData);
			exit();
		}

	}

	//退出动作页面
	public function loginOut(){
		if($userData = $this -> session -> userData('Clogin')){
			$this -> session -> unset_userdata('Clogin');
			$msg = '注销成功';
			$href = site_url('admin/main');
			$this -> yerror -> showYAdminError($msg, $href);
		}
	}

}