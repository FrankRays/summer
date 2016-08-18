<?php defined('BASEPATH') || exit('no script direct');

class article_model extends CI_Model {

	//数据库表明
	public $tableName;
	//别名
	private $tableAlias = 't1';
	//分类表表名
	private $categoryName = 'news_category';
	//分类表别名
	private $categoryAlias = 't2';
	//数据库字段
	private $tableFiled = array('id', 'alias', 'category_id',
		'title', 'author', 'editor', 'summary', 'keywords',
		'content', 'pic_src', 'url_src', 'come_from', 'file_src',
		'add_time', 'edit_time', 'hits', 'status', 'sort', 'is_delete', 'link', 'json_data');
	/**
	 *构造方法
	 */
	public function __construct() {
		parent::__construct();

		$this->tableName = 'news';
		$this->table_name = 'summer_article';

	}

	/**
	 * @param $categoryId   分类ID
	 * @param $limit        去除条数
	 * @param $offset       取数据起点
	 * @param $condition    其他的条件
	 */
	private function _getListByPage($cond, $limit, $offset) {

		$this->db->where($cond);

		$this->selectCondition();

//        var_dump($limit);
		//        var_dump($offset);
		$result = $this->db->get($this->tableName . ' as t1', $limit, $offset)->result_array();
		if ($result) {
			return $result;
		} else {
			return array();
		}
	}

	//select条件设置
	public function selectCondition() {

		$this->db->where(array('t1.is_delete' => 0));
		$this->db->join('news_category as t2',
			't1.category_id = t2.id',
			'cross');
		$this->db->order_by($this->tableAlias . '.add_time', 'desc');

		$select = 't1.id as news_id, content, ';
		$select .= 't1.hits,t2.id as category_id, t1.status, ';
		$select .= 't2.name as category_name, ';
		$select .= 't2.describle,t1.edit_time,video_src, t1.is_top, ';
		$select .= 'title, author, summary, keywords, t1.pic_src, url_src, ';
		$select .= 'come_from, hits, file_src, t1.add_time, sort, t2.pic_src as category_pic_src';
		$this->db->select($select);
	}

	/**
	 * @return array
	 */
	public function getNormalList() {

		$cond = array(
			$this->tableAlias . '.is_delete' => 0,
			$this->categoryAlias . '.is_delete' => 0,
		);

		//获取分页配置文件
		$paginationConfig = $this->config->item('paginationConfig', 'snowConfig/admin');

		$page = $this->getPage();
		$cond = array_merge($cond, $this->_getGetValue());
		$result = $this->_getListByPage($cond, $paginationConfig['per_page'],
			$page * $paginationConfig['per_page']);

		return $result;
		//return $this -> _getListByPage($categoryId, $limit, $offset, $condition);
	}

	private function _getGetValue() {
		$getArr = array();
		$get = $this->input->get();
		if (isset($get['category_id'])) {
			$getArr['category_id'] = intval($get['category_id']);
		}
		return $getArr;
	}

	public function getTotal() {
		$cond = $this->_getGetValue();
		$cond = array_merge($cond, array('t1.is_delete' => 0, 't2.is_delete' => 0));
		$this->db->where($cond);
		$this->db->join($this->categoryName . ' as ' . $this->categoryAlias,
			$this->tableAlias . '.category_id=' . $this->categoryAlias . '.id',
			'LEFT');
		$this->db->select('count(*)');
		$result = $this->db->get($this->tableName . ' as t1')->row_array();
		if (isset($result['count(*)'])) {
			return intval($result['count(*)']);
		} else {
			return 0;
		}
	}

	//得到当前从数据库总取数据的起始点
	public function getPage() {
		$page = $this->input->get('page');
		if (empty($page)) {
			$page = 1;
		} else {
			$page = intval($page);
		}
		return $page - 1;
	}

	//获取单条信息
	public function getOne($cond) {
		$this->db->where($cond);
		$this->selectCondition();
		if ($result = $this->db->get($this->tableName . ' as ' . $this->tableAlias)->row_array()) {
			return $result;
		} else {
			return false;
		}
	}

	//根据id获得单个文章信息
	public function getOneById($id) {
		$where = array();
		$where[$this->tableAlias . '.id'] = $id;
		if ($result = $this->getOne($where)) {
			return $result;
		} else {
			return FALSE;
		}
	}

	//
	public function setTop($id) {
		$article = $this->getOneById($id);
		$isTop = $article['is_top'] == 0 ? 1 : 0;
		$this->db->where(array(
			'category_id' => $article['category_id'],
		));
		$this->db->update($this->tableName, array('is_top' => 0));
		$this->db->where(array(
			'id' => $id,
		));
		$this->db->update($this->tableName, array('is_top' => 1));
	}

	//删除id信息
	public function delOneById($id) {
		$where['id'] = intval($id);
		$this->db->where($where);
		$updateData['is_delete'] = 1;
		$this->db->update($this->tableName, $updateData);
		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}



	//得到总数新接口，直接传入get或者post参数
	public function getTotalByCond($cond) {
		$this->db->where($cond);
		$this->db->select('count(*)');

		$result = $this->db->get($this->tableName)->row_array();
		if ($result) {
			return $result['count(*)'];
		} else {
			return 0;
		}
	}

	//取出数据新接口，传入开始，结束，条件，返回得到的数组
	/**
	 * @deprecated [<version>] [<description>]
	 * @param  [type] $limit  [description]
	 * @param  [type] $offset [description]
	 * @param  [type] $cond   [description]
	 * @return [type]         [description]
	 */
	public function getByCond($offset, $limit, $cond) {
		$where = array();
		if(isset($cond["category_id"])) {
			$where["category_id"] = $cond["category_id"];
		}
		if(isset($cond["title"])) {
			$this->db->like("title", $cond["title"], "both");
		}
		$this->db->where($where);
		$this->selectCondition();
		$result = $this->db->get($this->tableName . ' as ' . $this->tableAlias,
			$limit, $offset)->result_array();

		return $result;
	}

	//v2 获取分页
	public function get_pages($offset=0, $limit=20, $cond=array()) {
		$where = array();
		$like = array();

		$where['is_delete'] = NO;

		$this->db->start_cache();
		$this->db->from('summer_article')
			->where($where)
			->like($like)
			->order_by('create_time desc, sort asc');
		$this->db->stop_cache();

		$this->db->limit($limit, $offset);
		$data_list = $this->db->get()->result_array();
		$count = $this->db->count_all_results();

		$this->db->flush_cache();
		return array(
			'data_list'		=> $data_list,
			'total_rows'	=> $count,
			);
	}

	//v2获取前端文章列表分页
	public function get_front_pages($limit = 20, $offset=0, $cond=array()) {
		$where = array(
			'is_delete'			=> NO,
			'status'			=> YES,
			);

		if(isset($cond['is_top'])) {
			$where['is_top'] = $cond['is_top'];
		}

		if(isset($cond['category_id'])) {
			$where['category_id'] = $cond['category_id'];
		}

		$like = array();
		$this->db->start_cache();
		$this->db->from(TABLE_ARTICLE)->where($where);
		$this->db->stop_cache();

		$this->db->limit($limit, $offset)->order_by('publish_date desc, id asc');

		$data_list = $this->db->get()->result_array();
		$total_rows = $this->db->count_all_results();
		$this->db->flush_cache();

		return array(
			'data_list'		=> $data_list,
			'total_rows'	=> $total_rows,
			);
	}

	//v2 get front list by category id
	public function get_front_list($list, $offset, $cid) {
		$cond = array(
			'category_id' 	=> $cid,
			'is_top'		=> NO,
			);
		$page = $this->get_front_pages($list, $offset, $cond);
		return $page['data_list'];
	}

	//v2 get front 

	//v2 get hot
	public function get_top_list($limit, $offset, $cid) {
		$cond = array(
			'category_id' 	=> $cid,
			'is_top'		=> YES,
			);
		$page = $this->get_front_pages($limit, $offset, $cond);
		$data_list = $page['data_list'];

		if(count($data_list) == 0) {
			$where = array(
				'category_id'		=> $cid,
				'is_delete'			=> NO,
				'status'			=>YES,
				);
			$data_list = $this->db->from(TABLE_ARTICLE)
						->select('id, title, category_name, category_id, publish_date, summary')
						->where($where)
						->limit($limit, $offset)
						->order_by('publish_date desc, id asc')
						->get()
						->result_array();
		}
		return $data_list;
	}


	//v2 根据首页ID获取文章
	public function get_by_index_id($index_id) {
		$where = array(
			'index_id'	=> $index_id,
			'is_delete' => 0,
			'type'		=> ARTICLE_TYPE_INDEX,
			);
		$this->db->from('summer_article')
			->where($where);

		$article = $this->db->get()->row_array();
		return $article;
	}

	//v2 根据ID获取文章
	public function get_by_id($article_id) {
		$where = array(
			'id' => $article_id
			);
		$article = $this->db
					->where($where)
					->from('summer_article')
					->get()
					->row_array();					

		return $article;
	}

	//v2 根据首页ID更新文章内容
	public function update_by_index_id($article, $index_id) {
		$where = array(
			'index_id'	=> $index_id,
			'type'		=> ARTICLE_TYPE_INDEX,
			);
		$this->db->where($where)->update('summer_article', $article);
		return $this->db->affected_rows();
	}

	//v2 根据主键ID更行文章内容
	public function update_by_id($article, $id) {
		$where = array(
			'id'	=> $id,
			);
		$this->db->where($where)->update('summer_article', $article);
		return $this->db->affected_rows();
	}


	// v2 批量更新
	public function update_by_ids($article, $ids) {
		$this->db->or_where_in('id', $ids)->update('summer_article', $article);
		return $this->db->affected_rows();
	}

	public function getPages($offset=0, $limit=20, $cond=array()) {
		$where = array();
		$like = array();
		if(isset($cond["category_id"])) {
			$where["category_id"] = $cond["category_id"];
		}
		if(isset($cond["title"])) {
			$like["title"] = $cond["title"];
		}
		$where["t1.is_delete"] = 0;

		$this->db->start_cache();
		$this->db->from($this->tableName . " as t1")
				->join("news_category as t2", "t1.category_id=t2.id")
				->where($where)
				->like($like)
				->order_by('t1.add_time', 'desc');
		$this->db->stop_cache();

		$this->db->limit($limit, $offset);

		$select = array(
			"t1.id as news_id",
			"t1.content",
			"t1.hits",
			"t1.category_id",
			"t1.status",
			"t1.edit_time",
			"t1.add_time",
			"t1.video_src",
			"t1.is_top",
			"t1.title",
			"t1.author",
			"t1.summary",
			"t1.keywords",
			"t1.pic_src",
			"t1.url_src",
			"t1.come_from",
			"t1.hits",
			"t1.file_src",
			"t1.sort",
			"t2.pic_src as category_pic_src",
			"t2.name as category_name",
			"t2.describle",
			);
		$this->db->select($select);

		$dataList = $this->db->get()->result_array();
		$count = $this->db->count_all_results();
		$result = array(
			"dataList" => $dataList,
			"count" => $count
			);
		$this->db->flush_cache();

		return $result;
	}


	public function getById($id='0') {
		$id = isset($id) && is_numeric($id) ? $id : 0;

		$where['id'] = $id;
		$where['is_delete'] = 0;
		$article = $this->db->from($this->tableName)->where($where)->get()->row_array();
		return $article;
	}

	public function createArticle($article) {
		$this->db->insert($this->tableName, $article);
		return $this->db->insert_id();
	}

	public function create($article) {
		$this->db->insert($this->table_name, $article);
		return $this->db->insert_id();
	}

	public function create_article_index($article_index) {
		$this->db->insert('summer_article_index', $article_index);
	}

	public function updateArticle($article, $cond) {
		$where = array();
		if(isset($cond['id'])) {
			$where['id'] = $cond['id'];
		}
		$this->db->where($where)->update($this->tableName, $article);
		return $this->db->affected_rows();
	}

	public function createPhoto($photo) {
		return $this->createArticle($photo);
	}

	public function updatePhoto($photo, $cond) {
		return $this->updateArticle($photo, $cond);
	}



	//v2 得到下一篇地址
	public function get_next_article($article_id) {
		$where = array(
			'id > ' 				=> $article_id,
			'is_delete'				=> NO,
			'status'				=> YES,
			);

		$article = $this->db->where($where)
			->from(TABLE_ARTICLE)
			->limit(1)
			->order_by('id asc')
			->get()
			->row_array();

		if(empty($article)) {
			return '<a href="#" >最后一篇了</a>';
		}else{
			return '<a href="'.site_url('archive/' . $article['id']).'" >' .$article['title']. '</a>';
		}
	}

	//v2 得到上一篇地址a标签
	public function get_prev_article($article_id) {
		$where = array(
			'id < '					=> $article_id,
			'is_delete'				=> NO,
			'status'				=> YES,
			);

		$article = $this->db->where($where)
			->from(TABLE_ARTICLE)
			->limit(1)
			->order_by('id desc')
			->get()
			->row_array();


		if(empty($article)) {
			return '<a href="#" >这是第一篇咯</a>';
		}else{
			return '<a href="'.site_url('archive/' . $article['id']).'" >' .$article['title']. '</a>';
		}

	}


}
