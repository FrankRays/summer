<?php  if(! defined('BASEPATH')) exit('no direct script access allowd');


class User_model extends CI_Model{

	private $SALTY = 'ykjver';

	private $table_name = "user";

	public function __contruct(){
		parent::__contruct();
	}

	//添加用户
	public function add(array $data){
		if(empty($data) || $this -> dohasuser($data['email']))	return FALSE;
		
		$data['password'] = $this -> domd5($data['password']);
		$result = $this -> db -> insert($this -> table_name, $data);

		return $result;
	}

	//用户密码加密
	public function domd5($str){
		return md5(md5($str).md5($this->SALTY));
	}

	//wstx
	public function wxtxLogin($data){
		$data['password'] = $this -> domd5($data['password']);
		$this -> db -> where($data);
		$this -> db -> select('*');
		$result = $this -> db -> get($this -> table_name) -> result_array();
		return $result;
	}

	//检查数据库是否有此用户
	public function dohasuser($username){
		if(empty($username)) return FALSE;

		$arr_where = array("email" => $username);
		$str_select = "email";

		$this -> db -> where($arr_where);
		$this -> db -> select($str_select);
		$query = $this ->db -> get($this->table_name);

		return $query->result();
	}

	/**
	*检查用户和密码
	*@param array $arr_user 登陆信息数组
	*@param $arr_user['email'] 邮箱
	*@param $arr_user['password'] 密码 明文
	*@return array 查出的数据格式
	**/
	public function chkuser($arr_user){
		if(empty($arr_user))	return FALSE;

		$arr_user['password'] = $this -> domd5($arr_user['password']);
		$arr_where = array(
				"email"		=>		$arr_user['email'],
				"password"	=>		$arr_user['password']
			);
		$arr_select = array("email", "name");

		$this -> db -> where($arr_where);
		$this -> db -> select($arr_select);
		$query = $this -> db -> get($this->table_name);
		$result = $query->result_array();
		if( !empty($result[0]) ){
			return $result[0];
		}else{
			return FALSE;
		}
	}


	public function chkWstxUser($userData){
		if(empty($userData)) return false;

		$userData['password'] = $this -> domd5($userData['password']);
		$this -> db -> where($userData);
		$this -> db -> select('*');
		$result = $this -> db -> get($this -> table_name) -> result_array();
		if(isset($result[0])){
			return $result[0];
		}else{
			return false;
		}
	}
}