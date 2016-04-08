<?php defined('BASEPATH') || exit('no direct script access allowed');

class config_model extends CI_Model{


	//config
	//tableName
	public $tableName = '';
	//function __construct
	public function __construct(){
		parent::__construct();

		$this -> tableName = 'config';
	}


	//add
	public function add($data = FALSE){
		if($data == FALSE) return FALSE;

		$this -> db -> insert($this -> tableName, $data);
		if($this -> db -> affected_rows()){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	*get the list of the data user pagination
	*@param num int the amount of the data
	*@param offset int offset of start
	**/
	public function getList($num = 10, $offset = 0, $section = ''){
		$where = array();
		$section != '' && $where['section'] = $section;
		$this -> db -> where($where);
		$this -> db -> select('id, owner, module, section, key, value');
		return $this -> db -> get($this -> tableName, $num, $offset) -> result_array();
	}

	/**
	*get the slide data list
	*@name getSlide
	*@param num int the amount of the data
	*@param offset int offset fo the data start
	**/
	public function getSlide($num = 10, $offset = 0){
		$slides = $this -> getList($num, $offset, 'slides');
		foreach ($slides as $key => $value) {
			$slides[$key]['value'] = json_decode($value['value'], true);
			$curValue = $slides[$key]['value']['picSrc'];
			//Deal pictrue;
			// $picSrc = substr($curValue, 0 ,intval(strrpos($curValue, '/')) + 1);
			// $picSrc .= 'm_'.substr($curValue, intval(strrpos($curValue, '/')) + 1);
			// $slides[$key]['value']['picSrc'] = $picSrc;
			//Deal linkurl
			if(empty($slides[$key]['value']['linkSrc'])){
				$slides[$key]['value']['linkSrc'] = 'javascript:;';
			}
		}
		return $slides;
	} 

	/**
	*get amount of the list
	*@param $section string the type of the config link "slide" or "config"
	*@return int number of section type data
	**/
	public function getAmount($section = ''){
		$where = array();

		$section != '' && $where['section'] = $section;
		$this -> db -> where($where);
		$this -> db -> select('count(*) as count');
		return intval($this -> db -> get($this -> tableName) -> row() -> count);
	}

	/**
	*get the data by config id
	*@param $id int the id of the config
	*@return array of the id data
	**/
	public function getById($id){
		$id = intval($id);
		$where = array();

		$where['id'] = $id;
		$this -> db -> where($where);
		$this -> db -> select('id, owner, module, section, key, value');
		$result = $this -> db -> get($this -> tableName) -> result_array();
		if($result[0]){
			return $result[0];
		}else{
			return FALSE;
		}
	}

	/**
	*update data by id
	*@param $data array update data
	*@param $id the id of update data
	*@return boolean update if successful
	**/
	public function update($data, $id){
		$id = intval($id);

		$where = array(
			'id' => $id,
			);
		$this -> db -> where($where);
		if($this -> db -> update($this -> tableName, $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	*delete by id
	*@param $id int id of the data
	*@return boolean if delete successful
	**/
	public function del($id){
		$id = intval($id);
		$where = array(
			'id' => $id,
			);
		$this -> db -> where($where);
		if($this -> db -> delete($this -> tableName)){
			return TRUE;
		}else{
			return FALSE;
		}

	}

	public function create($post){
		//过滤数据
		$updateData = array();
		if(isset($post['name'])){
			$updateData['name'] = isset($post['name']) ? $post['name'] : '';
		}
		if(isset($post['picSrc'])){
			$updateData['picSrc'] = isset($post['picSrc']) ? $post['picSrc'] : '';
		}
		if(isset($post['linkSrc'])){
			$updateData['linkSrc'] = !empty($post['linkSrc']) ? $post['linkSrc'] : '';
		}
		$updateData['summary'] = isset($post['summary']) ? $post['summary'] : '';
		$section = isset($post['section']) ? $post['section'] : '';
		// var_dump($updateData);
		if (isset($post['id']) && !empty($post['id'])) {
			$id = is_numeric($post['id']) ? intval($post['id']) : 0;

			$this -> db -> where(array('id'=> $id));
			$this -> db -> update($this -> tableName, array('value' => json_encode($updateData)));
			return $id;
		}else{
			$this -> db -> insert($this -> tableName, array('value' => json_encode($updateData),
					'section' => $section));
			return $this -> db -> insert_id();
		}
	}

}