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
				->select('id, label, href')
				->where($where)
				->limit($limit, $offset)
				->order_by('list_order asc, id asc')
				->get()
				->result_array();

		return $navs;
	}

	public function get_mobile_nav($cat_id, $limit, $offset) {
		$navs = $this->get_list($cat_id, $limit, $offset);

		$i = 0;
		foreach($navs as &$v) {
			if(strpos($v['href'], '/l/')) {
				$v['href'] = str_replace('/l/', '/m/l/', $v['href']);
			}
		}

		$navs = array_merge(array_slice($navs, 0, 3),
		 array(array('label'=>'通知公告', 'href'=>site_url('m/l/collegenews'))),
		 array_slice($navs, 3, count($navs)));

		return $navs;
	}
}