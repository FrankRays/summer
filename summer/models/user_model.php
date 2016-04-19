<?php  if(! defined('BASEPATH')) exit('no direct script access allowd');


class User_model extends CI_Model{
	private $tableName = 'user';
	private $salt = 'yexuewoaini';
	private $tokenEncryptyKey = 'yexuenih';
	private $tokenCookieName = 'see_you_again';
	private $tokenLife = 604800;
	public function __contruct(){
		parent::__contruct();
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

	public function signIn($data){
		$isSuccess = 0;

		$data['account'] = addslashes($data['account']);
		$data['password'] = addslashes($data['password']);

		if(isset($data['account']) && !empty($data['account'])){
			$this -> db -> where(array(
				'username' => $data['account'],
				'password' => $this -> _doSha1($data['password'])
				));

			$user = $this -> db -> get($this -> tableName) -> row_array();
			// var_dump($user);
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
			"email" => "summer@summer.com",
			);

		$this -> db -> insert($this -> tableName, $update);
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
}