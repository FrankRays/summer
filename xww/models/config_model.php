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

}