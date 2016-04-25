<?php defined('BASEPATH') || exit('no direct script access allowed');

class lm_new_model extends CI_Model{

	//table Name
	protected $tableName = '';

	//constrcut function
	public function __construct(){
		parent::__construct();


		$this -> tableName = 'config'; 
	}

	public function add($navs = ''){
		//得到数据	
		//得到文章文类的信息
		// var_dump($navs);
		if($navs == ''){
			$navs = array(
				'name' 	=> 	'首页',
				'url' 	=>	'#',
				'isBlank'=>	false,
				'type'	=> 'system'
				);

		}
		//check if has nav section
		$this -> db -> where('section', 'nav');
		$this -> db -> select('*');
		$result = $this -> db -> get($this -> tableName) -> row_array();
		if(empty($result)){
			$insertData = array(
				'owner'	=>	'system',
				'module'=>	'common',
				'section'=>	'nav',
				'key' 	=>	'0',
				'value'	=> 	json_encode($navs)
				);
			$this -> db -> insert($this -> tableName, $insertData);
		}else{
			$this -> db -> where('section', 'nav');
			$updateData = array(
				'value'	=>	json_encode($navs)
				);
			$this -> db -> update($this -> tableName, $updateData);
		}

		return $navs;
		//处理数据
		//更新数据
		
	}

	public function formatNavs($navs){

	}

	//得到navs数据
	public function getNavs(){

		$this -> db -> where('section', 'nav');
		$this -> db -> select('*');
		$navs = $this -> db -> get($this -> tableName) -> row_array();
		if(empty($navs)){
			array_push($navs, array(
					'type' => 'system',
					'name' => '首页',
					'url' => site_url(),
					'urlKey' => 1,
					'isblank' => true
					)
			);
		}

		$navs = json_decode($navs['value']);
		return $navs;
	}
}