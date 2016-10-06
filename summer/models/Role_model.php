<?php defined('APPPATH') || exit('no access');

get_instance()->load->model('Tree_model');

class Role_model extends Tree_model {

	public function __construct() {
		parent::__construct();

		$this->table_name = TABLE_ROLE;
	}

	public function create_node($parent_id, $node) {
		$parent_node = $this->db->from(TABLE_ROLE)->where('id', $parent_id)->get()->row_array();
		if(empty($parent_node)) {
			$this->form_validation->set_error_array(array('父节点不存在'));
			return FALSE;
		}
		$this->db->query('UPDATE ' . TABLE_ROLE . ' set rgt = rgt + 2 where rgt >= ?', array($parent_node['rgt']));
		$this->db->query('UPDATE ' . TABLE_ROLE . ' set lft = lft + 2 where lft > ?', array($parent_node['rgt']));

		$node['lft'] = $parent_node['rgt'];
		$node['rgt'] = $parent_node['rgt'] + 1;
		$node['level'] = $parent_node['level'] + 1;
		$node['path'] = $parent_node['path'] . '/' . $node['rolename'];

		$this->db->insert(TABLE_ROLE, $node);

		return $this->db->insert_id();
	}

	public function delete_node($node_id) {
		$delete_node = $this->db->from(TABLE_ROLE)->where('id', $node_id)->get()->row_array();
		if(empty($delete_node)) {
			show_error('删除节点不存在');
		}

		$this->db->query('UPDATE ' . TABLE_ROLE . ' set rgt = rgt - 2 where rgt >= ?', array($delete_node['rgt']));
		$this->db->query('UPDATE ' . TABLE_ROLE . ' set lft = lft - 2 where lft > ?', array($delete_node['rgt']));

		$this->db->from(TABLE_ROLE)->where('id', $node_id)->delete();
	}
}