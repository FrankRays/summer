<?php defined('BASEPATH') || exit('no direct script access allowed');


class lm_model extends CI_Model{

	//construct function 
	public function __construct(){
		parent::__construct();

		$this -> tableName = 'lm';
	}

	/**
	*add
	**/
	public function add($data){
		$this -> db -> insert($this -> tableName, $data);
		if($this -> db -> affected_rows()){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	*得到栏目列表
	*@param num 取出列表的长度，默认为10个
	*@param is_nav 取出的是否为前台栏目项，1为是，0为不是，其它表示忽略这个条件
	**/
	public function getList($num = 10, $is_nav = 1){

		$where = array(
			'is_delete' => 0
			);

		$select = 'id, name, describle, is_nav, link_src, pic_src, add_time, sort, cid';

		$this -> db -> where($where);
		$this -> db -> select($select);
		$this -> db -> order_by('sort', 'ASC');
		$this -> db -> order_by('id', 'ASC');

		$query = $this -> db -> get($this -> tableName, $num);
		$result = $query -> result_array();
		
		return $result;
	}

	/**
	*通过id选出单条lm项
	*@param id 栏目的id
	*@param is_nav 为是否为前台导航栏
	**/
	public function getById($id, $is_nav = 1){
		$id = intval($id);
		if($id <= 0) return FALSE;

		$where = array(
			'id' => $id,
			'is_delete' => 0,
			);

		$select = 'id, name, describle, is_nav, link_src, pic_src, add_time, sort, cid';

		$this -> db -> where($where);
		$this -> db -> select($select);
		$query = $this -> db -> get($this -> tableName, 1);
		$result = $query -> result_array();

		return $result[0];
	}


	/**
	*update
	**/
	public function update($data = array(), $id = 0){
		$where = array(
			'id' => $id,
			'is_delete' => 0,
			);
		$this -> db -> where($where);
		if($this -> db -> update($this -> tableName, $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	*del
	**/
	public function del($id){
		$id = intval($id);

		$where = array(
			'id' => $id,
			'is_delete' => 0,
			);
		$data = array(
			'is_delete' => 1,
			);

		$this -> db -> where($where);
		if($this -> db -> update($this -> tableName, $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

}