<?php defined('APPPATH') or exit('no access');

class Tree_model extends MY_Model {

	public function __construct() {
	 	parent::__construct();

	}

	public function create_child($parent_id, $node) {
		$parent_node = $this->db->from($this->table_name)->where('id', $parent_id)->get()->row_array();
		if(empty($parent_node)) {
			return FALSE;
		}

		$this->db->query('UPDATE ' . $this->table_name . ' SET rgt=rgt+2 WHERE rgt>=?', array($parent_node['rgt']));
		$this->db->query('UPDATE ' . $this->table_name . ' SET lft=lft+2 WHERE lft>?', array($parent_node['rgt']));

		$node['rgt'] = $parent_node['rgt'] + 1;
		$node['lft'] = $parent_node['rgt'];
		$node['path'] = $parent_node['path'] . '/' . $node['name'];
		$node['level'] = $parent_node['level'] + 1;

		$this->db->insert($this->table_name, $node);
		return $this->db->insert_id();
	}






}