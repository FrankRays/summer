<?php defined('APPPATH') or exit('no access');

class Tree_model extends MY_Model {

	const PATH_SEPARTATE = '/';

	public function __construct() {
	 	parent::__construct();

	}

	public function insert_child($parent_name, $node) {
		$parent_node = $this->db->from($this->table_name)->where('name', $parent_name)->get()->row();

		if(empty($parent_node)) {
			throw new Exception("父节点不存在", 1);
		}

		$this->db->trans_start();
		$this->db->query("UPDATE {$this->table_name} SET rgt=rgt+2 WHERE rgt>=?", array($parent_node->rgt));
		$this->db->query("UPDATE {$this->table_name} SET lft=lft+2 WHERE lft>?", array($parent_node->rgt));

		$node->rgt 	= $parent_node->rgt + 1;
		$node->lft 	= $parent_node->rgt;
		$node->path = $parent_node->path . self::PATH_SEPARTATE . $node->name;
		$node->level= $parent_node->level + 1;
		$node->parent_id = $parent_node->id;

		$this->db->insert($this->table_name, $node);
		$this->db->trans_complete();
		return $this->db->insert_id();
	}

	public function insert_after($sibling_id, $node) {
		$sibling_id = intval($sibling_id);

		$sibling_node = $this->db->from($this->table_name)->where('id', $sibling_id)->get()->row();

		if(empty($sibling_node) or $sibling_node->lft <= 0) {
			throw new Exception("can not insert sibling on the root", 1);
		}

		if($this->name_has_exist($node->name)) {
			throw new Exception("节点名字已经存在", 1);
		}

		$this->db->trans_start();
		$this->db->query("UPDATE {$this->table_name} SET rgt=rgt+2 WHERE rgt>?", array($sibling_node->rgt));
		$this->db->query("UPDATE {$this->table_name} SET lft=lft+2 WHERE lft>?", array($sibling_node->rgt));

		$node = new Tree_node();
		$node->lft 	= $sibling_node->rgt + 1;
		$node->rgt 	= $sibling_node->rgt+2;
		$node->path = substr($sibling_node->path, 0, strrpos($sibling_node->path, self::PATH_SEPARTATE)) . self::PATH_SEPARTATE . $node->name;
		$node->name = $node->name;
		$node->level= $sibling_node->level;
		$node->parent_id = $sibling_node->parent_id;

		$this->db->insert($this->table_name, $node);
		$this->db->trans_complete();
		return $this->db->insert_id();
	}

	public function delete_node($node_name) {
		$node = $this->db->from($this->table_name)->where('name', $node_name)->get()->row_array();
		if(empty($node)) {
			throw new Exception("删除节点不存在", 1);
		}

		$where = array(
			'lft >='	=> $node['lft'],
			'rgt <='	=> $node['rgt'],
			);
		$this->db->where($where)->delete($this->table_name);
	}

	public function get_children($parent_name) {
		$parent_node = $this->db->from($this->table_name)->where('name', $parent_name)->get()->row();
		if($parent_node === null) {
			throw new Exception("parent node is not exist, where parent name = {$parent_name}", 1);;	
		}

		$children = $this->db->query("	SELECT node.* 
										FROM {$this->table_name} AS node 
										WHERE node.lft BETWEEN ? AND ? 
										ORDER BY node.lft",
							array($parent_node->lft, $parent_node->rgt))->result();

		return $children;
	}

	public function get_cascade_chidren($parent_name) {
		$children = $this->get_children($parent_name);

		$new = array();
		foreach ($children as $node) {
			$new[$node->parent_id][] = $node;
		}

		$tree = $this->_create_tree($new, array($children[0]));
		return $tree;
	}

	private function _create_tree(&$list, $parents) {
		$tree = array();
		foreach ($parents as $node) {
			$new_node = array('name'=>$node->name, 'open'=>TRUE);
			if(isset($list[$node->id])) {
				$new_node['children'] = $this->_create_tree($list, $list[$node->id]);
			}
			$tree[] = $new_node;
		}

		return $tree;
	}

	public function udpate_node_name($old_name, $new_name) {
		$old_node = $this->db->from($this->table_name)->where('name', $old_name)->get()->row_array();
		if(empty($old_node)) {
			$this->summer_view_message->append_error('更新节点不存在');
			return FALSE;
		}

		if($this->name_has_exist($new_name)) {
			$this->summer_view_message->append_error('节点名字已存在');
			return FALSE;
		}

		$this->db->where('name', $old_name)->update($this->table_name, array('name'=>$new_name));
		return $this->db->affected_rows();
	}

	private function name_has_exist($node_name) {
		$name_has_exist_node = $this->db->from($this->table_name)->where('name', $node_name)->get()->row();
		if($name_has_exist_node != NULL) {
			return TRUE;
		} else{
			return FALSE;
		}
	}
}

class Tree_node {

	public $lft;

	public $rgt;

	public $path;

	public $name;

	public $level;

	public $parent_id;

	public function __construct() {
	}

}