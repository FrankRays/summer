<?php defined('BASEPATH') || exit('no direct script access allowed');

class login extends MY_Controller{

	public function __construct(){
		parent::__construct();

		$this -> load -> model('user_model');
		$this -> load -> library('JsonOutUtil');
		$this -> jsonOutUtil = new JsonOutUtil();
	}


	public function index()
	{
		$this -> ySignPotal();
		$post = $this -> input -> post();
		$this -> load -> view("v_01/user/login_view");
	}

	//登陆处理接口
	public function doLogin(){
		$post = $this -> input -> post();
		if( $post ){
			//查看账号是否已经被使用
			if( ! $this -> user_model -> hasAccount($post['account'])){
				$this -> jsonOutUtil -> resultOutString(false, 
					array('msg' => '账号不存在哦', 'type' => '1'));
				return ;
			}

			if( $this -> user_model -> signIn($post) ){
				$this -> jsonOutUtil -> resultOutString(true, array('msg' => '登陆成功'));
				return;
			}else{
				$this -> jsonOutUtil -> resultOutString(false,
					array('msg' => '密码有错误', 'type' => '2')); 
			}
		}
	}


	public function signUp(){
		$username = "summer";
		$password = "123456";
		$this -> user_model -> signUp($username, $password);
	}

	public function signOut(){
		$this -> user_model -> signOut();
	}
}