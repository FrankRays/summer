<?php defined('APPPATH') or exit('no access');

class Summer_ztree {

	public $CI;

	public $tree_list_data;

	public $tree_cascade_data;

	public function __construct() {
		if($this->CI === null) {
			$this->CI = &get_instance();
		}

	}

	public tree_normal_data($parent_id = 0) {

	}

	public function set_tree_list_data($tree_list_data) {

		if( is_array($tree_list_data)) {
			$this->tree_list_data = $tree_list_data;

			foreach($tree_list_data as $node) {

			}
		}
	}

	public _create_tree_data($list_data, &$tree_data, $parent_id) {
		
		foreach($list_data as $node) {

		}
	}


}