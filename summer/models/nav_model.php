<?php 

defined('APPPATH') || exit('no access');

class Nav_Model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function get_list($cat_id, $limit, $offset) {
		$where = array(
			'cid'		=> $cat_id,
			'is_delete'	=> 0,
			'status'	=> 1,
			);

		$navs = $this->db->from(TABLE_NAV)
				->where($where)
				->limit($limit, $offset)
				->order_by('list_order asc, id asc')
				->get()
				->result_array();

		return $navs;
	}
}