<?php defined('BASEPATH') || exit('no direct script access allowed');

class config_model extends CI_Model{

	public function __construct(){
		parent::__construct();

		$table = $this->config->item('table', 'snowConfig/admin');
		$this->table = $table['config']['table_name'];

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
		$where = array(
			'id' => $id,
			);

		$query = $this->db->where($where)->from($this->table)->get();
		$config = $query->row_array();
		return $config;
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
		if($this -> db -> delete($this->table)){
			return TRUE;
		}else{
			return FALSE;
		}

	}

	//create config
	public function create($config) {
		$this->db->insert($this->table, $config);
		$insert_id = $this->db->insert_id();

		if($insert_id) {
			return $insert_id;
		}else{
			return false;
		}
	}

	public function update($config, $id) {
		$where = array(
			'id' => $id
			);

		$this->db->where($where)->update($this->table, $config);

		$affected_rows = $this->db->affected_rows();
		return $affected_rows;
	}


	public function get_page($offset=0, $limit=20, $cond=array()) {

		$where = array();
		if(isset($cond['section'])) {
			$where['section'] = $cond['section'];
		}

		$this->db->start_cache();
		$this->db->from($this->table);
		$this->db->where($where);
		$this->db->stop_cache();

		$this->db->limit($offset, $limit);
		$this->db->order_by('id', 'desc');
		$data_list = $this->db->get()->result_array();
		$count = $this->db->count_all_results();

		$result = array(
			'data_list' => $data_list,
			'count' 	=> $count,
			);

		return $result;
	}

}