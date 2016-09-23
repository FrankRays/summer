<?php  if(! defined('BASEPATH')) exit('no direct script access allowd');


class User_model extends MY_Model{

	private $tableName = 'user';

	private $salt = 'asdfg';

	//我为我自己代言
	const salty = 'Lasia';

	private $tokenEncryptyKey = 'asdfg';

	private $tokenCookieName = 'asdfg';

	private $tokenLife = 604800;

	public function __contruct(){
		parent::__contruct();

		$this->table_name = TABLE_USER;
	}

	public function _doSha1($password){
		return sha1($password . $this -> salt);
	}

	public function encryptToken($data, $key){
		$prep_code = serialize($data); 
		$block = mcrypt_get_block_size('des', 'ecb'); 
		if (($pad = $block - (strlen($prep_code) % $block)) < $block) { 
			$prep_code .= str_repeat(chr($pad), $pad); 
		} 
		$encrypt = mcrypt_encrypt(MCRYPT_DES, $key, $prep_code, MCRYPT_MODE_ECB); 
		return base64_encode($encrypt);
	}

	public function decryptToken($str, $key){
		$str = base64_decode($str); 
		$str = mcrypt_decrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB); 
		$block = mcrypt_get_block_size('des', 'ecb'); 
		$pad = ord($str[($len = strlen($str)) - 1]); 
		if ($pad && $pad < $block && preg_match('/' . chr($pad) . '{' . $pad . '}$/', $str)) { 
			$str = substr($str, 0, strlen($str) - $pad); 
		} 
		return unserialize($str);
	}

	public function signIn($username, $password){
		$isSuccess = 0;

		$data['account'] = addslashes($username);
		$data['password'] = addslashes($password);

		if(isset($data['account']) && !empty($data['account'])){
			$this -> db -> where(array(
				'username' => $data['account'],
				'password' => $this -> _doSha1($data['password'])
				));

			$user = $this -> db -> get($this -> tableName) -> row_array();
			if( $user ){
				//设置token cookie
				$token = $this -> encryptToken($data['account'] . '_' . (time() + $this -> tokenLife),
				 $this -> tokenEncryptyKey);
				setcookie($this -> tokenCookieName, $token);
				$this -> db -> where(array('username' => $user['username']));
				$this -> db -> update($this -> tableName, array('token' => $token));
				$this -> session -> set_userdata(array('user' => array(
					'username' => $user['username'],
					)));
				$_SESSION['user'] = $user['username'];
				return $user;
			}

			//设置session
			return false;
		}else{
			return false;
		}
	}

	public function hasAccount($account){
		if(empty($account)) return ;

		$account = addslashes($account);

		$this -> db -> where(array('username' => $account));
		$user = $this -> db -> get($this -> tableName) -> row_array();
		if( $user ){
			return true;
		}

		$this -> db -> where(array('email' => $account));
		$user = $this -> db -> get($this -> tableName) -> row_array();
		if( $user ){
			return true;
		}

		return false;
	}

	public function signup($username, $password){
		$update = array(
			'username' => $username,
			'password' => $this -> _doSha1($password),
			"email" => "admin@admin.com",
			);

		$this -> db -> insert($this -> tableName, $update);
		return $this->db->insert_id();
	}

	public function getUserByToken(){
		$token = get_cookie($this -> tokenCookieName);
		if (empty($token)) {
			return false;
		}
		$this -> db -> where(array('token' => $token));
		$user = $this -> db -> get($this -> tableName) -> row_array();

		if( ! $user ) return false;
		$token = $this -> decryptToken($user['token'], $this -> tokenEncryptyKey);
		$token = explode('_', $token);
		$username = $token[0];
		$tokenLife = $token[1];

		if(time() > $tokenLife){
			return false;
		}else{
			return true;
		}
	}

	public function signOut(){
		$this -> db -> where(array('token' => $token));
		$user = $this -> db -> update($this -> tableName, array('token' => ''));
		setcookie($this -> tokenCookieName, '');
		$this -> session -> unset_userdata('user');
		session_start();
		if (!empty($_SESSION['user'])) {
			unset($_SESSION['user']);
		}
		header('location:'.site_url('d=user&c=login&m=index'));
	}


	//v2,创建用户
	public function create() {
		//check form validation
		$this->load->library('form_validation');
		$this->config->load('s/form_config');
		$this->load->model('article_cat_model');
		$user_form_config = $this->config->item('user_form');
		$user_form_field_config = $user_form_config['fields'];

		foreach($user_form_field_config as $v) {
			if(isset($v['rules']) and isset($v['name']) and isset($v['rules'])) {
				$this->form_validation->set_rules($v['name'], $v['label'], $v['rules']);
			}
		}

		$is_success = $this->form_validation->run();
		if( ! $is_success) {
			return FALSE;
		}

		$account = $this->input->post('account', TRUE);
		$has_account = $this->db->from(TABLE_USER)->where(array('account'=>$account))->get()->row_array();
		if($has_account) {
			$this->form_validation->set_error_array(array('该账号已经存在'));
			return FALSE;
		}

		$password = $this->input->post('password');
		$password = $this->create_password($password, $account);
		$realname = $this->input->post('realname', TRUE);
		$nickname = $this->input->post('nickname', TRUE);
		$admin = 'common';
		$email = $this->input->post('email', TRUE);
		$mobile = $this->input->post('mobile', TRUE);
		$ip = $this->input->ip_address();
		$join_time = date(TIME_FORMAT);
		$join = $join_time;
		$last = $join_time;

		$user = array(
			'account'		=> $account,
			'password'		=> $password,
			'realname'		=> $realname,
			'nickname'		=> $nickname,
			'admin'			=> $admin,
			'email'			=> $email,
			'mobile'		=> $mobile,
			'ip'			=> $ip,
			'join'			=> $join,
			'last'			=> $join,
			);
		$this->db->insert(TABLE_USER, $user);
		return $this->db->insert_id();
	}

	//v2,创建密码
	public function create_password($password, $account) {
		return md5(md5($password . $account) . user_model::salty);
	}

	//得到用户分页数据
	public function get_page($limit, $offset, $cond=array()) {
		$where = array();

		$this->db->start_cache();
		$this->db->from(TABLE_USER);
		$this->db->where($where);
		$this->db->stop_cache();

		$users = $this->db->limit($limit)->offset($offset)->get()->result_array();
		$total_rows = $this->db->count_all_results();

		return array(
			'data_list'		=> $users,
			'total_rows'	=> $total_rows,
			);
	}

	public function get_by_id($user_id) {
		$where = array(
			'id'	=> $user_id,
			);
		$user = $this->db->where($where)->from(TABLE_USER)->get()->row_array();
		return $user;
	}

	//v2 通过用户名获取用户
	public function get_by_account($account) {
		$where = array(
			'account'	=> $account,
			);

		$user = $this->db->where($where)->from(TABLE_USER)->get()->row_array();
		return $user;
	}

	//v2 用户登录
	public function login($account, $password) {
		$password = $this->create_password($password, $account);
		$where = array(
			'account' => $account,
			'password'	=> $password,
			);

		$user = $this->db->where($where)->from(TABLE_USER)->get()->row_array();
		if(!empty($user)) {
			return $user;
		}

		$where = array(
			'email'	=> $account,
			'password'	=> $password,
			);
		$user = $this->db->where($where)->from(TABLE_USER)->get()->row_array();

		return $user;
	}


	//v2 根据id更新用户
	public function update_by_id($user, $user_id) {
		$where = array(
			'id'		=> $user_id,
			);
		$this->db->where($where)->update(TABLE_USER, $user);
		return $this->db->affected_rows();	
	}

	public function del_by_id($id) {
		$where = array(
			'id'	=> $id,
			);
		$this->db->where($where)->delete(TABLE_USER);
	}


	//v2判断是否为superadmin
	public function is_super() {
		$user = $this->session->userdata('user');
		if(empty($user) || $user['admin'] != 'super') {
			show_error('你的权限不够');
		}else{
			return TRUE;
		}
	}

	//v2 judge if it is a common admin.
	public function is_common() {
		$user = $this->session->userdata('user');
		if(is_array($user) && $user['admin'] == 'common') {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	//v2 judge if is a admin ,包括common and super administrator
	public function is_admin() {
		$user = $this->session->userdata('user');
		if(is_array($user) && ($user['admin'] == 'common' 
			|| $user['admin'] == 'super') and defined('ADMIN')) {
			return TRUE;
		}else{
			redirect(site_url('c=user&m=login'));
		}
	}

	//v2 judge if it is a login status
	public function verify() {
		$user = $this->session->userdata('user');
		if(empty($user) || ! is_array($user) || empty($user['account'])) {
			redirect(site_url('c=user&m=login'));
		}
		return TRUE;
	}
}