<?php  if(! defined('BASEPATH')) exit('no direct script access allowd');


class User_model extends MY_Model{

	private $tableName = 'user';

	private $salt = 'asdfg';

	public $login_url;

	//我为我自己代言
	const salty = 'Lasia';

	private $tokenEncryptyKey = 'asdfg';

	private $tokenCookieName = 'asdfg';

	private $tokenLife = 604800;

	public function __contruct(){
		parent::__contruct();

		$this->table_name = TABLE_USER;

		$this->login_url = site_url('c=user&m=login');
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

		$article_cate_access = $this->input->post('article_cate_access');
		if( ! is_array($article_cate_access)) {
			$this->form_validation->set_error_array(array('未选择帐号管理文章类别'));
			return ;
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
			'article_cate_access'=> json_encode($article_cate_access),
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

	public function check_account_password($account, $password) {
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

	public function update_user() {
		$this->load->library('form_validation');
		$this->config->load('s/form_config');
		$this->load->model('article_cat_model');

		$user_form_config = $this->config->item('user_form');
		$user_form_field_config = $user_form_config['fields'];
		unset($user_form_field_config['account']);
		unset($user_form_field_config['password']);
		unset($user_form_field_config['repassword']);

		$this->form_validation->set_rules('id', '文章ID', 'required');
		foreach($user_form_field_config as $v) {
			if(isset($v['rules']) and isset($v['name']) and isset($v['rules'])) {
				$this->form_validation->set_rules($v['name'], $v['label'], $v['rules']);
			}
		}

		$is_success = $this->form_validation->run();
		if( ! $is_success) {
			return FALSE;
		}


		$id = $this->input->post('id');
		$user = $this->get_by_id(intval($id));
		if(empty($user)) {
			$this->form_validation->set_error_array(array('用户不存在'));
			return FALSE;
		}

		$article_cate_access = $this->input->post('article_cate_access');
		if( ! is_array($article_cate_access)) {
			$this->form_validation->set_error_array(array('未选择帐号管理文章类别'));
			return ;
		}


		$nickname = $this->input->post('nickname', TRUE);
		$realname = $this->input->post('realname', TRUE);
		$email = $this->input->post('email', TRUE);
		$mobile = $this->input->post('mobile', TRUE);
		$article_cate_access = json_encode($article_cate_access);

		$update_user = array(
			'nickname'	=> $nickname,
			'realname'	=> $realname,
			'email'		=> $email,
			'mobile'	=> $mobile,
			'article_cate_access'=>$article_cate_access,
			);

		$this->db->where('id', intval($id))->update(TABLE_USER, $update_user);
		return TRUE;
	}

	public function delete_user() {
		$ids = $this->input->post('ids');
		if(is_null($ids) or ! is_array($ids) or count($ids) <= 0) {
			echo json_encode(array('status'=>500, 'message'=>'未选择要重置密码的用户'));
			return FALSE; 
		}

		foreach($ids as $id) {
			$cur_user = $this->get_by_id(intval($id));

			if($cur_user['admin'] == 'super') {
				continue;
			}

			$this->db->where('account', $cur_user['account'])->delete(TABLE_USER);
		}

		return TRUE;
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

	public function _is_super() {
		$user = $this->session->userdata['user'];
		if(empty($user) or $user['admin'] != 'super') {
			return FALSE;
		} else {
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

	public function is_admin_redirect($redirect_url='') {
		$user = $this->session->userdata('user');
		if( ! empty($user) and is_array($user) and ($user['admin'] == 'common' 
			or $user['admin'] == 'super') and defined('ADMIN')) {
			return TRUE;
		} else {
			if($redirect_url == '') {
				$redirect_url = site_url('c=user&m=login');
			}
			redirect($redirect_url);
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

	public function get_cur_user() {
		$user = $this->session->userdata('user');
		if(empty($user)) {
			return FALSE;
		} else {
			return $user;
		}
	}

	public function has_article_privilege($category_id) {
		if($this->user_model->_is_super()) {
			return TRUE;
		} else {
			$user = $this->user_model->get_cur_user();
			if(in_array($category_id, $user['article_cate_access'])) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}

	public function lock_user() {
		$ids = $this->input->post('ids');
		if($ids == null or ! is_array($ids) or count($ids) <= 0) {
			echo json_encode(array('status'=>500, 'message'=>'未选择要锁定的用户'));
			return ;
		}

		$update_user = array(
			'locked'	=> '2300-01-01 00:00:00',
			);

		foreach($ids as $v) {
			$this->db->where('id', intval($v))->update(TABLE_USER, $update_user);
		}
	}

	public function unlock_user() {
		$ids = $this->input->post('ids');
		if($ids == null or ! is_array($ids) or count($ids) <= 0) {
			echo json_encode(array('status'=>500, 'message'=>'未选择要解锁的用户'));
			return ;
		}

		$update_user = array(
			'locked'	=> '0000-00-00 00:00:00',
			);

		foreach($ids as $v) {
			$this->db->where('id', intval($v))->update(TABLE_USER, $update_user);
		}
	}

	public function change_password() {
		$old_password = $this->input->post('old_password');
		$new_password = $this->input->post('new_password');
		$re_new_passowrd = $this->input->post('re_new_passowrd');

		$this->config->load('s/form_config');
		$change_password_form_config = $this->config->item('change_password_form');

		foreach($change_password_form_config['fields'] as $v) {
			if(isset($v['rules'])) {
				$this->form_validation->set_rules($v['name'], $v['label'], $v['rules']);
			}
		}

		if(! $this->form_validation->run()) {
			return FALSE;
		}

		$user = $this->get_cur_user();
		if(empty($user)) {
			$this->form_validation->set_error_array(array('未登陆'));
			redirect('c=user&m=login');
		}

		$is_success = $this->check_account_password($user['account'], $old_password);
		if(empty($is_success)) {
			$this->form_validation->set_error_array(array('密码错误'));
			return FALSE;
		}


		$update_user = array(
			'password'	=> $this->create_password($new_password, $user['account']),
			);

		$this->db->where('id', $user['id'])->update(TABLE_USER, $update_user);
		return TRUE;
	}


	public function logout() {
		session_destroy();
		$referer = $this->input->server('HTTP_REFERER');
		if(!empty($referer)) {
			redirect(site_url('c=user&m=login&referer=' . urlencode($referer)));
		}else{
			redirect(site_url('c=user&m=login'));
		}
	}

	public function set_default_password() {
		$ids = $this->input->post('ids');
		if($ids == null or ! is_array($ids) or count($ids) <= 0) {
			echo json_encode(array('status'=>500, 'message'=>'未选择要重置密码的用户'));
			return FALSE;
		}

		foreach($ids as $id) {
			$cur_user = $this->get_by_id(intval($id));
			if(empty($cur_user)) {
				continue;
			}

			if($cur_user['admin'] == 'super') {
				continue;
			}

			$update_user = array(
				'password'	=> $this->create_password('123456', $cur_user['account']),
				);

			$this->db->where('account', $cur_user['account'])->update(TABLE_USER, $update_user);
		}
		return TRUE;
	}

    public function get_v_user_id() {
        $v_user_id = $this->session->userdata('v_user_id');
        //if session not ,get it form cookie
        if(empty($v_user_id)) {
            $v_user_id = get_cookie('v_user_id');
            if(empty($v_user_id)) {
                //session cookie not has, then create a new virtual user id
                $v_user_id = md5(time() . 'summer') . rand(0, 999);
                $cookie = array(
                    'name'=>'v_user_id',
                    'value'=>$v_user_id,
                    'expire'=>time() + 315360000, //10 years expire
                );
                set_cookie($cookie);
            }
            $this->session->set_userdata('v_user_id', $v_user_id);
        }
        return $v_user_id;
    }
}
