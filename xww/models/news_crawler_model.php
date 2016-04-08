<?php
/*
+-------------+--------------+------+-----+---------+-------+
| Field       | Type         | Null | Key | Default | Extra |
+-------------+--------------+------+-----+---------+-------+
| id          | int(11)      | NO   | PRI | NULL    |       |
| titile      | varchar(500) | NO   |     |         |       |
| category_id | int(11)      | NO   |     | 1       |       |
+-------------+--------------+------+-----+---------+-------+
*/

class news_crawler_model extends CI_Model{
	public $tableName = '';

	public function __construct(){
		$this -> tableName = 'new_crawler';
	}


	/*
		 21501 => 
    	array(
      'title' => string '四川工程职业技术学院来我院交流心理健康教育工作' (length=69)
      'category_id' => string '1') (length=1)
	*/
	public function update($crawlerArr){
		// var_dump($crawlerArr); 
		foreach ($crawlerArr as $key => $value) {
			$update = array(
				'id' => $key,
				'title' => $value['title'],
				'category_id' => $value['category_id'],
				'index_ctime' => $value['index_ctime']
				);
			$this -> db -> where(array('id' => $update['id']));
			$exist = $this -> db -> get($this -> tableName) -> row_array();
			// var_dump($exist);
			if($exist){
				$this -> db -> where(array('id' => $update['id']));
				$this -> db -> update($this -> tableName, $update);
			}else{
				$this -> db -> insert($this -> tableName, $update); 
			}
		}
	}

	public function get($limit, $offset, $cond){
		$this -> db -> order_by('index_ctime', 'desc') -> order_by('cur_order', 'asc');
		$this -> db -> where($cond);
		$result = $this -> db -> get($this -> tableName, $limit, $offset) -> result_array();
		return $result;
	}

}