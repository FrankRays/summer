<?php defined('APPPATH') or exit('no access');

class Tree_model extends MY_Model {

	const PATH_SEPARTATE = '/';

	public function __construct() {
	 	parent::__construct();

	}

	public function insert_child($parent_id, $node) {
		$parent_node = $this->db->from($this->table_name)->where('id', $parent_id)->get()->row();

		if(empty($parent_node)) {
			return FALSE;
		}

		$this->name_has_exist($node->name);

		$this->db->trans_start();
		$this->db->query("UPDATE {$this->table_name} SET rgt=rgt+2 WHERE rgt>=?", array($parent_node->rgt));
		$this->db->query("UPDATE {$this->table_name} SET lft=lft+2 WHERE lft>?", array($parent_node->rgt));

		$node->rgt = $parent_node->rgt + 1;
		$node->lft = $parent_node->rgt;
		$node->path = $parent_node->path . self::PATH_SEPARTATE . $node->name;
		$node->level = $parent_node->level + 1;

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

		$this->name_has_exist($node->name);

		$this->db->trans_start();
		$this->db->query("UPDATE {$this->table_name} SET rgt=rgt+2 WHERE rgt>?", array($sibling_node->rgt));
		$this->db->query("UPDATE {$this->table_name} SET lft=lft+2 where lft>?", array($sibling_node->rgt));

		$node = new Tree_node();
		$node->lft 	= $sibling_node->rgt + 1;
		$node->rgt 	= $sibling_node->rgt+2;
		$node->path = substr($sibling_node->path, 0, strrpos($sibling_node->path, self::PATH_SEPARTATE)) . self::PATH_SEPARTATE . $node->name;
		$node->name = $node->name;
		$node->level= $sibling_node->level;

		$this->db->insert($this->table_name, $node);
		$this->db->trans_complete();
		return $this->db->insert_id();
	}



	private function name_has_exist($node_name) {
		$name_has_exist_node = $this->db->from($this->table_name)->where('name', $node_name)->get()->row();
		if($name_has_exist_node != NULL) {
			throw new Exception("this node name has been insert", 1);
		}
	}

}

class Tree_node {

	public $lft;

	public $rgt;

	public $path;

	public $name;

	public $level;

	public function __construct() {
	}

}