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

	public function create($post) {

		/*Array
		(
		[title] =>
		[category] => 文章类别
		[comefrom] =>
		[author] =>
		[keywords] =>
		[summary] =>
		[createTime] =>
		[status] => 1
		[content] => <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;这里写你的初始化内容
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
		)       */
		//表单处理
		// var_dump($post);
		$updateData = array();
//        var_dump($post);
		if (isset($post['title'])) {
			$updateData['title'] = !empty($post['title']) ? $post['title'] : '';
		}
		if (isset($post['comefrom'])) {
			$updateData['come_from'] = !empty($post['comefrom']) ? $post['comefrom'] : '';
		}
		if (isset($post['author'])) {
			$updateData['author'] = !empty($post['author']) ? $post['author'] : '';
		}
		if (isset($post['keywords'])) {
			$updateData['keywords'] = !empty($post['keywords']) ? $post['keywords'] : '';
		}
		if (isset($post['summary'])) {
			$updateData['summary'] = !empty($post['summary']) ? $post['summary'] : '';
		}
		if (isset($post['createTime'])) {
			$updateData['add_time'] = !empty($post['createTime'])
			? strtotime($post['createTime']) : time();
		}
		if (isset($post['status'])) {
			$updateData['status'] = !empty($post['status']) && intval($post['status']) == 1 ? 1 : 0;
		}
		if (isset($post['content'])) {
			$updateData['content'] = !empty($post['content']) ? $post['content'] : '';
		}
		if (isset($post['category'])) {
			$updateData['category_id'] = !empty($post['category']) ? intval($post['category']) : 0;
		}
		if (isset($post['pic_src'])) {
			$updateData['pic_src'] = !empty($post['pic_src']) ? $post['pic_src'] : '';
		}
		if (isset($post['file_src'])) {
			$updateData['file_src'] = !empty($post['file_src']) ? $post['file_src'] : '';
		}
		if (isset($post['video_src'])) {
			$updateData['video_src'] = !empty($post['video_src']) ? $post['video_src'] : '';
		}
		if (isset($post['is_video'])) {
			$updateData['is_video'] = $post['is_video'];
		}


        $updateData["alias"] = isset($post["alias"]) ? $post["alias"] : "";
        $updateData["json_data"] = isset($post["json_data"]) ? $post["json_data"] : "";


		//处理图片时
		if (isset($post['photoes'])) {
			$updateData['content'] = $post['photoes'];
		} else {
			if (isset($updateData['content']) && empty($updateData['summary'])) {
				$content = strip_tags($updateData['content']);
				if (mb_strlen($content) > 200) {
					$updateData['summary'] = mb_substr($content, 0, 200);
				} else {
					$updateData['summary'] = $content;
				}
			}
		}
		$updateData['edit_time'] = time();

		$id = isset($post['id']) ? intval($post['id']) : 0;

		// var_dump($updateData);
		// return ;
		if ($id) {
			$this->db->where('id', $id);
			$this->db->update($this->tableName, $updateData);
			return $id;
		} else {
			$this->db->insert($this->tableName, $updateData);
			if ($this->db->affected_rows()) {
				$lastId = $this->db->insert_id();
				return $lastId;
			} else {
				return false;
			}
		}
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
			return false;
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


}
