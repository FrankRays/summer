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
		if($node['id'] == 1) {
			throw new Exception("不能删除根节点", 1);
		}
		$where = array(
			'lft >='	=> $node['lft'],
			'rgt <='	=> $node['rgt'],
			);

		$close_up = $node['rgt'] - $node['lft'] + 1;
		$this->db->trans_start();
		$this->db->where($where)->delete($this->table_name);
		$this->db->query('UPDATE ' . $this->table_name . ' SET rgt = (rgt - '.$close_up.') where rgt > ?', array($node['rgt']));
		$this->db->query('UPDATE ' . $this->table_name . ' SET lft = (lft - '.$close_up.') where lft > ?', array($node['rgt']));
		$this->db->trans_complete();
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

	public function update_node_name($old_name, $new_name) {
		$old_node = $this->db->from($this->table_name)->where('name', $old_name)->get()->row_array();
		if(empty($old_node)) {
			throw new Exception("更新节点不存在", 1);
		}

		if($this->name_has_exist($new_name)) {
			throw new Exception("节点名字已存在", 1);
		}

		$this->db->where('id', $old_node['id'])->update($this->table_name, array('name'=>$new_name));
		return $this->db->affected_rows();
	}

	public function move_subtree_inner($move_node_name, $target_node_name) {

		//if the same node, do not move
		if($move_node_name === $target_node_name) {
			return FALSE;
		}

		//find two node from database
		$move_target_nodes = $this->db->from($this->table_name)->or_where('name', $move_node_name)
									->or_where('name', $target_node_name)
									->get()
									->result_array();

		//check one of two does not exist
		if(count($move_target_nodes) !== 2) {
			return FALSE;
		}

		if($move_node_name === $move_target_nodes[0]['name']) {
			$move_node = $move_target_nodes[0];
			$target_node = $move_target_nodes[1];
		} else {
			$move_node = $move_target_nodes[1];
			$target_node = $move_target_nodes[0];
		}

		$move_node_size = $move_node['rgt'] - $move_node['lft'] + 1;

		$this->db->trans_start(TRUE);
		//temporary save move_node
		$sql = 'UPDATE '.$this->table_name.'
					SET lft = 0 -lft
						,rgt = 0 - rgt
						,level = level + (?)
					WHERE lft >= ? AND rgt <= ?';
		$this->db->query($sql, array($target_node['level'] - $move_node['level'] + 1, 
							$move_node['lft'], $move_node['rgt']));

		//decrease right / left position for parent of move node
		$sql = 'UPDATE '.$this->table_name.'
						SET rgt = rgt - (?)
						WHERE rgt >= ?';
		$this->db->query($sql, array($move_node_size, $move_node['rgt']));

		$sql = 'UPDATE '.$this->table_name.'
						SET lft = lft - (?)
						WHERE lft >= ?';
		$this->db->query($sql, array($move_node_size, $move_node['rgt']));

		//increase right / left position for parent of target node
		$sql = 'UPDATE '.$this->table_name.'
						SET rgt = rgt + (?)
						WHERE rgt >= ?';
		$this->db->query($sql, array($move_node_size, $target_node['rgt'] > $move_node['rgt'] ? $target_node['rgt'] - $move_node_size : $target_node['rgt']));

		$sql = 'UPDATE '.$this->table_name.'
						SET lft = lft + (?)
						WHERE lft >= ?';
		$this->db->query($sql, array($move_node_size, $target_node['rgt'] > $move_node['rgt'] ? $target_node['rgt'] - $move_node_size : $target_node['rgt']));

		//move node to target position
		$sql = 'UPDATE '.$this->table_name.'
					SET lft = 0 - lft + (?)
					,rgt = 0 - rgt + (?)
					WHERE lft <= ? AND rgt >= ?';
		$this->db->query($sql, array(
				$target_node['rgt'] > $move_node['rgt'] ? $target_node['rgt'] - $move_node['rgt'] - 1 : $target_node['rgt'] - $move_node['rgt'] - 1 + $move_node_size,
				$target_node['rgt'] > $move_node['rgt'] ? $target_node['rgt'] - $move_node['rgt'] - 1 : $target_node['rgt'] - $move_node['rgt'] - 1 + $move_node_size,
				0 - $move_node['lft'], 0 - $move_node['rgt']));

		var_dump($target_node['rgt']);
		var_dump($move_node['rgt']);

		//update parent id
		$this->db->where('id', $move_node['id'])->update($this->table_name, array(
					'parent_id'		=> $target_node['id'],
					'path'			=> $target_node['path'] . '/' . $move_node['name'],
					));
		$this->db->trans_complete();
		return TRUE;
	}

	public function move_subtree_before($move_node_name, $target_node_name) {
		//can not move self position
		if($move_node_name == $target_node_name) {
			return FALSE;	
		}

		//find move and target node from database
		$move_target_nodes = $this->db->from($this->table_name)
									->or_where('name', $move_node_name)
									->or_where('name', $target_node_name)
									->get()
									->result_array();
		if(count($move_target_nodes) != 2) {
			return FALSE;
		}

		if($move_target_nodes[0]['name'] == $move_node_name) {
			$move_node = $move_target_nodes[0];
			$target_node = $move_target_nodes[1];
		} else {
			$move_node = $move_target_nodes[1];
			$target_node = $move_target_nodes[0];
		}
		
		//if is not at the same level, put it at the same level
		if($move_node['level'] != $target_node['level']) {
			$target_parent_node = $this->db->from($this->table_name)->where('id', $target_node['parent_id'])
										->get()->row_array();
			if(empty($target_parent_node)) {
				return FALSE;
			}

			$this->move_subtree_inner($move_node['name'], $target_node['name']);
			return $this->move_subtree_before($move_node['name'], $target_node['name']);
		}

		
		//same level, put move node before target node
		$move_node_size = $move_node['rgt'] - $move_node['lft'] + 1;
		$target_node_size = $target_node['rgt'] - $target_node['lft'] + 1;

		$this->db->trans_start();

		//temporary save move node
		$sql = 'UPDATE '.$this->table_name.'
					SET lft = 0 - lft
					,rgt = 0 - rgt
					WHERE lft >= ? AND rgt <= ?';
		$this->db->query($sql, array($move_node['lft'], $move_node['rgt']));

		//shift node
		if($move_node['rgt'] > $target_node['rgt']) {
			//shift left
			$sql = 'UPDATE '.$this->table_name.'
						SET lft = lft + ?
						WHERE lft >= ? and lft <= ?';
			$this->db->query($sql, array($move_node_size, $target_node['lft'], $move_node['rgt']));

			$sql = 'UPDATE '.$this->table_name.'
						SET rgt = rgt + ?
						WHERE rgt >= ? and rgt <= ?';
			$this->db->query($sql, array($move_node_size, $target_node['rgt'], $move_node['rgt']));

			//move node to target node before
			$sql = 'UPDATE '.$this->table_name.'
						SET lft = 0 - lft + (?)
						,rgt = 0 - rgt + (?)
						WHERE lft <= ? AND rgt >= ?';
			$this->db->query($sql, array($target_node['lft'] - $move_node['lft'], $target_node['lft'] - $move_node['lft']
										, 0 - $move_node['lft'], 0 - $move_node['rgt']));
		} else {
			//shift right
			$sql = 'UPDATE '.$this->table_name.'
						SET lft = lft - ?
						WHERE lft >= ? AND lft <= ?';
			$this->db->query($sql, array($move_node_size, $move_node['rgt'], $target_node['lft'] - 1));

			$sql = 'UPDATE '.$this->table_name.'
						SET rgt = rgt - ?
						WHERE rgt >= ? AND rgt <= ?';
			$this->db->query($sql, array($move_node_size, $move_node['rgt'], $target_node['lft'] - 1));

			//move node to target node before
			$sql = 'UPDATE '.$this->table_name.'
						SET lft = 0 - lft + (?)
						, rgt = 0 - rgt + (?)
						WHERE lft <= ? AND rgt >= ?';
			$this->db->query($sql, array($target_node['lft'] - $move_node['rgt'] - 1, $target_node['lft'] - $move_node['rgt'] - 1
											, 0 - $move_node['lft'], 0 - $move_node['rgt']));
		}

		$this->db->trans_complete();
		return TRUE;
	}

	public function move_subtree_after($move_node_name, $target_node_name) {
		//same node, do not move
		if($move_node_name == $target_node_name) {
			return FALSE;
		}

		//chekc if move node and target node is exist
		$move_target_nodes = $this->db->from($this->table_name)->or_where('name', $move_node_name)
									->or_where('name',, $target_node_name)
									->get()
									->result_array();
		if(count($move_target_nodes) != 2) {
			return FALSE;
		}

		if($move_target_nodes[0]['name'] == $move_node_name) {
			$move_node = $move_target_nodes[0];
			$target_node = $move_target_nodes[1];
		} else {
			$move_node = $move_target_nodes[1];
			$target_node = $move_target_nodes[0];
		}

		//now, move node is the first node after target node, do not move
		if(($move_node['rgt'] > $target['rgt'] and $move_node['rgt'] + 1 = $target['lft'])
					or ($move_node['rgt'] < $target_node))

	}

	public function reset_tree() {
		$this->db->trans_start();
		$this->db->truncate($this->table_name);
		$this->db->query("INSERT INTO `{$this->table_name}` (`id`, `lft`, `rgt`, `level`, `path`, `name`, `parent_id`) 
			VALUES (NULL, '1', '2', '1', 'root', 'root', '0')");
		$this->db->trans_complete();
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