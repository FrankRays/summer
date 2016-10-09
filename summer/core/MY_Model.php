<?php

defined("APPPATH") or exit("no access");

class MY_Model extends CI_Model {

	public $table_name;

	public function __construct() {
		parent::__construct();
	}

	public function get_by_id($id) {
		$where = array(
			'id'		=> $id,
			'is_delete'	=> '0',
			);

		if(empty($this->table_name)) {
			show_error("未指定数据库表名");
		}

		return $this->db->from($this->table_name)
				->where($where)->get()->row_array();
	}

	public function del() {
		$id_str = $this->input->get("ids", TRUE);
		if(strpos($id_str, '_')) {
			$ids = explode('_', $id_str);
		} else {
			if(is_numeric($id_str)) {
				$ids = array(intval($id_str));
			}else{
				show_error("The Delete ID is error");
			}
		}

		$udpate_data = array(
			"is_delete"	=> '1',
			);
		$this->db->where_in("id", $ids, TRUE)->update($this->table_name, $udpate_data);

		return $this->db->affected_rows();
	}

	public function get_table_name() {
		return $this->table_name;
	}

}