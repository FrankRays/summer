<?php
/*
+---------------+--------------+------+-----+---------+-------+
| Field         | Type         | Null | Key | Default | Extra |
+---------------+--------------+------+-----+---------+-------+
| id            | varchar(50)  | NO   | PRI | NULL    |       |
| title         | varchar(500) | YES  |     | NULL    |       |
| category_id   | int(11)      | NO   |     | 1       |       |
| is_top        | char(1)      | NO   |     | 0       |       |
| cover_img     | varchar(200) | NO   |     |         |       |
| index_ctime   | varchar(20)  | YES  |     | NULL    |       |
| index_id      | int(11)      | NO   |     | 0       |       |
| category_name | varchar(50)  | NO   |     |         |       |
| index_cmitime | int(11)      | NO   |     | 0       |       |
| cur_order     | int(11)      | NO   |     | NULL    |       |
+---------------+--------------+------+-----+---------+-------+
*/

class news_crawler_model extends CI_Model{
	public $table_name = '';

	public $xyxw_cid = 1;

	public $xyxw_cname = '学院新闻';

	public $xbxw_cid = 2;

	public $xbxw_cname = '系部新闻';

	public $notice_cname = '通知公告';

	public function __construct(){
		$this -> table_name = 'summer_index_article';
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
			$exist = $this -> db -> get($this -> table_name) -> row_array();
			// var_dump($exist);
			if($exist){
				$this -> db -> where(array('id' => $update['id']));
				$this -> db -> update($this -> table_name, $update);
			}else{
				$this -> db -> insert($this -> table_name, $update); 
			}
		}
	}

	public function get($limit, $offset, $cond){
		$this -> db -> order_by('index_ctime', 'desc') -> order_by('cur_order', 'asc');
		$this -> db -> where($cond);
		$result = $this -> db -> get($this -> table_name, $limit, $offset) -> result_array();
		return $result;
	}

	public function get_by_id($id) {
		$where = array(
			'id'		=> $id,
			'is_delete'	=> 0,
			);
		$article = $this->db->from($this->table_name)
			->where($where)
		    ->get()
		    ->row_array();

		return $article;
	}

	//get index xyxw_news
	public function get_xyxw_news_mobile($limit=5, $offset=0, $cond=array()) {

		$where = array();
		if(isset($cond['category_id'])) {
			$where['category_id'] = $cond['category_name'];
		}

		if(isset($cond['is_top'])) {
			if($cond['is_top'] == TRUE) {
				$where['is_top'] = 2;
			}else{
				$where['is_top <>'] = 2;
			}
		}

		$this->db
			->from($this->table_name)
			->where($where)
			->order_by('create_date desc, cur_order asc')
			->limit($limit, $offset);

		$xyxw_news = $this->db->get()->result_array();

		foreach($xyxw_news as &$v) {
			$v['index_ctime'] = date('Y-m-d', $v['index_ctime']);
			switch ($v['category_id']) {
				//学院新闻
				case '11':
					$v['category_name'] = $this->xyxw_cname;
					break;
				//系部新闻
				case '16':
					$v['category_name'] = $this->xbxw_cname;
					break;
				//通知公告
				case '12':
					$v['category_name'] = $this->notice_cname;
					break;
				default:
					$v['category_name'] = $this->xyxw_cname;
					break;
			}
		}

		if(empty($xyxw_news)) {
			return FALSE;
		}else{
			return $xyxw_news;
		}
	}

}