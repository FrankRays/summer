<?php defined('BASEPATH') || exit('no direct script access allowed');


//v2 幻灯片model类
//
class Slider_Model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}
	
	//获取列表
	public function get_list($limit, $offset, $cond=array()) {
		$where = array(
			'is_delete'		=> NO,
			);
		$sliders = $this->db->from(TABLE_SLIDER)->where($where)->limit($limit, $offset)->get()->result_array();
		return $sliders;
	}

	//获取分页
	public function get_page($limit, $offset, $cond=array()) {
		$where = array(
			'is_delete'		=> NO,
			);

		$this->db->start_cache();
		$this->db->from(TABLE_SLIDER)->where($where);
		$this->db->stop_cache();

		$this->db->limit($limit, $offset);
		$data_list = $this->db->order_by('order_id asc, id desc')->get()->result_array();
		$total_rows = $this->db->count_all_results();

		return array(
			'data_list'		=> $data_list,
			'total_rows'	=> $total_rows,
			);
	}
}