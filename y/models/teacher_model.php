<?php defined('BASEPATH') || exit('no direct scirpt access allowed');

class teacher_model extends CI_Model{

	//function __construct
	public function __construct(){
		parent::__construct();

		$this -> tableName = 'teacher';
	}


	/**
	*添加类
	**/
	public function add($data){
		if(empty($data)) return FALSE;

		$this -> db -> insert($this -> tableName, $data);
		$result = $this -> db -> affected_rows();

		return $result;
	}

	/**
	*取得教师列表
	**/
	public function getList($num = 10, $offset = 0){
		$this -> db -> where('is_delete', 0);
		$this -> db -> select('id, name, introl, add_time, summary, pic_src');
		$this -> db -> order_by('id', 'DESC');

		$query = $this -> db -> get($this -> tableName, $num, $offset);
		$result = $query -> result_array();
		return $result;
	}

	/**
	*得到news的rownum没有被删除的数据条目
	**/
	public function getRowNum(){
		$this -> db -> where('is_delete', 0);
		$this -> db -> select('count(*)');
		$query = $this -> db -> get($this -> tableName);
		$result = $query -> row_array();
		return intval(array_pop($result));
	}	

	/**
	*通过教师id得到单个教师信息
	**/
	public function getById($id){
		$id = ($id != FALSE) && is_numeric($id) && $id > 0 ? intval($id) : 0;

		$where = array(
			'is_delete' => 0,
			'id' => $id,
		);	
		$this -> db -> where($where);
		$this -> db -> select('id, name, introl, add_time, summary, pic_src');
		$query = $this -> db -> get($this -> tableName);
		$result = $query -> row_array();
		return $result;
	}

	/**
	*更新教师信息，单个，根据teacherid
	**/
	public function update($data = FALSE, $id = FALSE){
		if($data == FALSE || !is_array($data) || $id == FALSE) return FALSE;
		$id = is_numeric($id) && $id > 0 ? intval($id) : 0;

		$where = array(
			'is_delete' => 0,
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
	*逻辑删除新闻表中的单个数据也可做批量删除
	*
	**/
	public function delByIds($ids = ''){
		if(empty($ids)) return FALSE;

		if(is_array($ids)){
			$ids = implode($ids, ',');
		}

		$this -> db -> where_in('id', $ids);
		$this -> db -> where('is_delete', 0);
		$this -> db -> update($this -> tableName, array('is_delete' => 1));
		if($this -> db -> affected_rows()){
			return TRUE;
		}else{
			return FALSE;
		}
	}

}