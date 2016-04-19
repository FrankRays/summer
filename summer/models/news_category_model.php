<?php defined('BASEPATH') || exit('no direct script access allowed');

/**
*new_category data class to mamage news category table
*所有到本类实例的数据都被认作是安全过滤过的可用
*@author ykvjer
*@date 2014/09/24
**/

class news_category_model extends CI_Model{

	//construct function 
	public function __construct(){
		parent::__construct();

		$this -> RecList = array();
		$this -> tableName = 'news_category';
	}

	//插入新闻分类表
	public function add($data){
		if(empty($data)) return FALSE;

		$this -> db -> insert($this -> tableName, $data);
		$result = $this -> db -> affected_rows();

		return $result;
	}

	//检查新闻分类是否有相同的值
	public function isHas($name){
		if(empty($name)) return FALSE;

		$this -> db -> where('name', $name);
		$this -> db -> select('id');

		$query = $this -> db -> get($this -> tableName);
		$result = $query -> result_array();
		return $result;
	}

	/**
	*取得新闻分类列表
	*@param num 取得的数量
	**/
	public function getList($num = 10){
		$this -> db -> where('is_delete', 0);
		$this -> db -> select('id, name, describle, add_time, alias, fid');
		$this -> db -> order_by('id', 'DESC');

		$query = $this -> db -> get($this -> tableName, $num);
		$result = $query -> result_array();
		return $result;
	}

	/**
	 * 通过类型查找分类
	 * @param  string $type [description]
	 * @return [type]       [description]
	 */
	public function find_by_type($type="article"){
		$this->db->where(array("is_delete"=>0, "type"=>$type));
		$this->db->order_by("id", "DESC");

		$result = $this->db->get($this->tableName)->result_array();
		if(!empty($result)) {
			return $result;
		}else{
			return array();
		}
	}


	public function getRecList($fid = 0){
		$categoryList = $this -> getList(null);
		$this -> RecList = array();
		$this -> _getRecList($categoryList, $fid);
		return $this -> RecList;
	}

	public function _getRecList($data, $fid = 0, $lev = 1){
		foreach ($data as $key => $value) {
			if($value['fid'] == $fid){
				$value['lev'] = $lev;
				$this -> RecList[] = $value;
				$this -> _getRecList($data, $value['id'], $lev + 1);
			}
		}
	}


	/**
	*通过id取得分类信息
	*@param id 分类表的主键
	**/
	public function getById($id = ''){
		if($id == '') return FALSE;

		$id = is_numeric($id) && $id > 0 ? intval($id) : 0;

		$where = array(
			'id' => $id,
			'is_delete' => 0,
			);
		$this -> db -> where($where);
		$this -> db -> select('id, name, describle, add_time, alias, fid');

		$query = $this -> db -> get($this -> tableName);
		$result = $query -> result_array();

		return $result[0];
	}

	//根据别名取得数据
	public function getByAlias($alias){
		$this -> db -> where('alias', $alias);
		$this -> db -> where('is_delete', 0);
		$this -> db -> select('id, name, alias, describle');
		$result = $this -> db -> get($this -> tableName) -> row_array();
		return $result;
	}

	//repeat Alias
	public function hasAlias($alias){

		if($alias == ''){
			return FALSE;
		}
		$this -> db -> where('is_delete', 0);
		$this -> db -> where('alias', $alias);
		$this -> db -> select('count(*) as count');
		$result = $this -> db -> get($this -> tableName) -> row_array();
		if($result['count'] != 0){
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

}