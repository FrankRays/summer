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

	public $front_select = 'id, title, category_name, category_id, index_id, is_redirect,  publish_date, summary, coverimg_path, hits, love, come_from, come_from_url, author_name, status, is_top';
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
		$where = array(
			'is_delete'		=> NO,
			);
		$like = array();


		$category_id = $this->input->get('category_id');
		if( ! empty($category_id)) {
			$where['category_id'] = intval($category_id);
		}

		if(isset($cond['is_top'])) {
			$where['is_top'] = $cond['is_top'];
		}

		$wq = $this->input->get('wq');
		if(!empty($wq)) {
			$like['title'] = $wq;
		}

		$this->db->start_cache();
		$this->db->from('summer_article')
			->select('id, title, category_name, category_id, publish_date, summary '
					. ', coverimg_path, hits, love, author_name, status, is_top')
			->where($where)
			->like($like)
			->order_by('publish_date desc, id desc');

		if(isset($cond['article_cate_access'])) {
			$this->db->where_in('category_id', $cond['article_cate_access']);
		}
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

	public function get_admin_page($offset=0, $limit=20, $cond=array()) {
		$this->load->model('user_model');

		$cond = array();
		$user = $this->user_model->get_cur_user();
		if( ! $this->user_model->_is_super()) {
			$user = $this->session->userdata('user');
			$cond['article_cate_access'] = $user['article_cate_access'];
		}

		return $this->get_pages($offset, $limit, $cond);
	}

	//v2获取前端文章列表分页
	public function get_front_pages($limit = 20, $offset=0, $cond=array()) {
		$where = array(
			'is_delete'			=> NO,
			'status'			=> YES,
			'publish_date <'	=> date(TIME_FORMAT),
			);

		if(isset($cond['is_top'])) {
			$where['is_top'] = $cond['is_top'];
		}

		if(isset($cond['category_id'])) {
			$where['category_id'] = $cond['category_id'];
		}

		if(isset($cond['start_date'])) {
			$where['publish_date >'] = $cond['start_date'];
		}

		if(isset($cond['end_date'])) {
			$where['publish_date <'] = $cond['end_date'];
		}

		$like = array();
		$this->db->start_cache();
		$this->db->from(TABLE_ARTICLE)->where($where);
		$this->db->stop_cache();

		$this->db->limit($limit, $offset)->order_by('publish_date desc, id desc');

		$data_list = $this->db->select($this->front_select)
		->get()->result_array();
		$total_rows = $this->db->count_all_results();
		$this->db->flush_cache();

		$this->_deal_front_list($data_list);

		return array(
			'data_list'		=> $data_list,
			'total_rows'	=> $total_rows,
			);
	}

	//v2 get front list by category id
	public function get_front_list($limit, $offset, $cid, $is_top=0) {
		$cond = array('category_id'=> $cid);
		if($is_top !== FALSE) {
			$cond['is_top'] = $is_top;
		}
		$page = $this->get_front_pages($limit, $offset, $cond);
		return $page['data_list'];
	}

	//v2 get hot
	public function get_top_list($limit, $offset, $cid=0) {
		$cond = array(
			'is_top'		=> YES,
			);

		if($cid != 0) {
			$cond['category_id'] = $cid;
		}
		$page = $this->get_front_pages($limit, $offset, $cond);
		$data_list = $page['data_list'];

		if(count($data_list) == 0) {
			$where = array(
				'category_id'		=> $cid,
				'is_delete'			=> NO,
				'status'			=>YES,
				'publish_date <'	=> date(TIME_FORMAT),
				);
			$data_list = $this->db->from(TABLE_ARTICLE)
						->select($this->front_select)
						->where($where)
						->limit($limit, $offset)
						->order_by('publish_date desc, id desc')
						->get()
						->result_array();
		}

		$this->_deal_front_list($data_list);
		return $data_list;
	}

	public function get_admin_top() {
		$where = array(
			'is_top'	=> '1',
			);

		$category_id = $this->input->get('category_id');
		if(! empty($category_id)) {
			$where['category_id'] = intval($category_id);
		}

		if( ! $this->user_model->_is_super()) {
			$user = $this->user_model->get_cur_user();
			$this->db->where_in('category_id', $user['article_cate_access']);
		}

		$top_articles = $this->db->from(TABLE_ARTICLE)->select($this->front_select)->where($where)
					->order_by('publish_date desc, id desc')->get()->result_array();

		return $top_articles;
	}

	public function _deal_front_list(&$data_list) {
		foreach($data_list as &$v) {

			//list a tag
			$a_tag = '<a ';
			if($v['is_redirect'] == 1) {
				$a_tag .= 'target="blank" '. 'href="' . $v['come_from_url'] . '" ';
			} else {
				$a_tag .= 'href="' . archive_url($v) . '" ';
			}
			$a_tag .= ' title="' .$v['title'].'">' . $v['title'] . '</a>';
			$v['a_tag'] = $a_tag;

			//show_date
			$v['show_date'] = substr($v['publish_date'], 5, 5);
		}
	}


	//v2 根据首页ID获取文章
	public function get_by_index_id($index_id) {
		$where = array(
			'index_id'	=> $index_id,
			'is_delete' => NO,
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
		$this->load->library('rbac');
		$allowed_categories = $this->rbac->get_allowed_categories();

		foreach($ids as $id) {
			$article = $this->db->from(TABLE_ARTICLE)->where('id', $id)->get()->row_array();
			if(empty($article)) {
				continue;
			}

			if(isset($allowed_categories[$article['category_id']])) {
				$this->db->where('id', $article['id'])->update(TABLE_ARTICLE, array('is_delete'=>'1'));
			}
		}
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
		$this->load->model('user_model');
		if($this->user_model->_is_super()) {
			$user = $this->user_model->get_cur_user();
			if( ! in_array($article['category_id'], $user['article_cate_access'])) {
				show_error('权限不够');
			}
		}
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
	public function get_next_article($article_id, $param = array()) {
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

		$a_str = '<a ';
		if(isset($param['class'])) {
			$a_str .= ' class="' . $param['class'] . '" ';
		}
		if(empty($article)) {
			$a_str .= ' href="#" >最后一篇了</a>';
		}else{
			$a_str .= ' href="'.site_url('archive/' . $article['category_id'] . '-' . $article['id']).'" >下一篇：' .$article['title']. '</a>';
		}

		return $a_str;
	}

	//v2 得到上一篇地址a标签
	public function get_prev_article($article_id, $param = array()) {
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

		$a_str = '<a ';
		if(isset($param['class'])) {
			$a_str .= ' class="' . $param['class'] . '" ';
		}
		if(empty($article)) {
			$a_str .= ' href="#" >第一篇咯</a>';
		}else{
			$a_str .= 'href="'.site_url('archive/' . $article['category_id'] . '-' . $article['id']).'" >上一篇：' .$article['title']. '</a>';
		}

		return $a_str;
	}

	public function get_week_hot() {

		$where = array(
			'is_delete'			=> NO,
			'status'			=> YES,
			'publish_date >'	=> date(DATE_FORMAT, time() - 24 * 3600 * 7),
			'publish_date <'	=> date(TIME_FORMAT),
			);

		$articles = $this->db->select('title, id, category_id, category_name, is_redirect, come_from, come_from_url')
						->from(TABLE_ARTICLE)
						->where($where)
						->order_by('hits desc')
						->limit(5)
						->get()
						->result_array();

		return $articles;
	}

	public function create_index_article($href) {
        $this->load->model('article_cat_model');
		$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $href);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    	$output = curl_exec($ch);
    	curl_close($ch);

    	//fetch page html fail
    	if(empty($output)) {
    		return FALSE;
    	}

    	preg_match('/<h3.*?>(.*?)<\/h3>/', $output, $title);
        preg_match('/发布者：(.*?) &/', $output, $author_name);
        preg_match('/点击数：(.*?) &/', $output, $hits);
        preg_match('/发布时间：(\d{4}-\d{2}-\d{2})/', $output, $publish_date);
        preg_match('/25px;">(.*?)<\/form>/is', $output, $content);
        $content = isset($content[1]) ? $content[1] : '';
        $content = preg_replace('/style="[\s\S]+?"/', '', $content);
        $content = preg_replace('/<span\s*>/', '', $content);
        $content = str_replace('</span>', '', $content);
        $content = str_replace('<div>', '', $content);
        $content = str_replace('</div>', '', $content);
        $preged_num = 0;
        if(! empty($content)) {
        	$is_success = preg_match_all('<img.*?src="(.*?)".*?>', $content, $article_imgs);
        }

        if(isset($article_imgs[1])) {
        	$article_imgs = $article_imgs[1];
        } else {
        	$article_imgs = array();
        }

        $index_category_id = 0;
        $index_id = 0;
        //view-11-96b6014b6e0543ffa477a48e0b4baba9.html
        if(strpos($href, '-') !== FALSE) {
        	$href_arr = explode('-', $href);
        	if(is_array($href_arr) and count($href_arr) === 3) {
        		$index_category_id 	= $href_arr[1];
        		$index_id 			= substr($href_arr[2], 0, strpos($href_arr[2], '.'));
        	}
        }

        $summary = '';
        if(mb_strlen($content) > 80) {
        	$summary = mb_substr($content, 0, 80);
        	$summary = strip_tags($summary);
        }

        $category = $this->article_cat_model->get_by_cat_id($index_category_id);
        $user = cur_user();
        $create_time = date(TIME_FORMAT);

        $index_article = array(
        	'title'			=> isset($title[1]) ? $title[1] : '',
        	'category_id'	=> ! empty($category) ? $category['id'] : 9999,
        	'category_name'	=> ! empty($category) ? $category['name'] : '首页未找到分类',
        	'publish_date'	=> isset($publish_date[1]) ? $publish_date[1] : $create_time,
        	'author_name'	=> isset($author_name[1]) ? $author_name[1] : '',
        	'author_id'		=> 1,
        	'publisher_id'	=> $user['id'],
        	'publisher_name'=> $user['realname'],
        	'summary'		=> $summary,
        	'keywords'		=> '',
        	'content'		=> $content,
        	'status'		=> YES,
        	);


        $old_index_artcile = $this->get_by_index_id($index_id);

        if(empty($old_index_artcile)) {
        	$index_article['create_time'] 	= $create_time;
        	$index_article['hits']			= isset($hits[1]) ? $hits[1] : 0;
        	$index_article['index_id']		= $index_id;
        	$this->db->insert(TABLE_ARTICLE, $index_article);
        	$object_id = $this->db->insert_id();
        }else{
        	$index_article['edit_time']		= $create_time;
        	$this->db->where(array('id'=>$old_index_artcile['id']))
        	->update(TABLE_ARTICLE, $index_article);
        	$object_id = $old_index_artcile['id'];
        }

        if(empty($object_id)) {
        	return FALSE;
        }

		$this->load->library('image_lib');
		$this->load->model('file_model');
		$should_down_image_url = array();
		$has_down_img = array();

		//check if image has been download in this article\
		foreach($article_imgs as $v) {
			$old_file = $this->file_model->has_download($object_id, $v);

			if($old_file === FALSE) {
				$should_down_image_url[] = 'http://www.svtcc.edu.cn' . $v;
			}else{
				$has_down_img[] = $old_file;
			}
		}

		//download image
		$this->load->library('Crawler');
		$responses = $this->crawler->asyn_request($should_down_image_url);

		//save download image
		foreach($responses as $url => $response) {
			$file = $this->_save_download_image($url, $response, $object_id);

			if($file !== FALSE) {
				$index_content_image_url = $file["index_url"];
				$content  = str_replace($index_content_image_url
					, resource_url($file["pathname"]), $content);
			}else{
				continue;
			}
		}

		foreach($has_down_img as $v) {
			$content = str_replace($v['index_url'], resource_url($v['pathname']), $content);
		}

		$this->db->where('id', $object_id)
			          ->update(TABLE_ARTICLE, array('content' => $content));
       
        return TRUE;
	}

	private function _save_download_image($curl_url, $curl_response, $object_id) {
		if(empty($curl_response)) {
			return FALSE;
		}
	   
	   	//save download image
		$resource_upload_path = $this->config->item('resource_upload_path');
		$save_dir_path = make_upload_dir();

        if($i = strrpos($curl_url, '.')) {
        	$extension = strtolower(substr(trim($curl_url, '"'), $i));
        }else{
        	return FALSE;
        }

        $filepath = $save_dir_path . get_random_file_name() . $extension;
        if($fp = fopen($filepath, 'a')) {
	        fwrite($fp, $curl_response);
	        fclose($fp);
        }

        //resize image
 		$resize_img_config = $this->config->item('resize_img_config');
		$resize_img_config['source_image'] 	= $filepath;
		$this->image_lib->initialize($resize_img_config);
		$this->image_lib->resize();

		$pathname = str_replace($resource_upload_path, '', $this->_get_thumb_path($filepath));
		$index_content_image_url = str_replace('http://www.svtcc.edu.cn', '', $curl_url);
		$insert_file = array(
			'pathname'		=> $pathname,
			'index_url'		=> $index_content_image_url,
			'extension'		=> $extension,
			'object_id'		=> $object_id,
			'added_by'		=> cur_user_id(),
			'added_time'	=> date(TIME_FORMAT),
			'public'		=> '1',
			"object_type"	=> "article",
			"primary"		=> '0',
			);

		$this->db->insert(TABLE_FILE, $insert_file);

		return $insert_file;
	}

	public function get_index_artcile_list($href) {
		$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $href);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    	$output = curl_exec($ch);
    	curl_close($ch);

        $list_preg_str  = '/newlist.png[\s\S]+?<\/a>/';

        ///front/view-11-8693c5197cb64db9ac50cfa14acc6249.html
        $href_preg_str 	= '/front\/view\-\d{2}\-(.*)\.html/';

        $is_match = preg_match_all($list_preg_str, $output, $matches);

        foreach($matches[0] as $v) {
        	$is_match = preg_match($href_preg_str, $v, $href);
        	$url = 'http://www.svtcc.edu.cn/' . $href[0];
        	// var_dump($url);
        	$this->create_index_article($url);
        }
	}

	public function get_archive_html() {
		$start_year = 2015;

		$end_year = intval(date('Y'));
		$end_month = intval(date('m'));

		$archive_html = '';
		for($i = $start_year; $i <= $end_year; $i++) {
			if($i === $end_year) {
				$end_month = intval(date('m'));
			}else{
				$end_month = 12;
			}
			for($j = 1; $j <= $end_month; $j++) {
				$year_month = $i . '-' . sprintf('%02d', $j);
				$archive_html .= '<li><a href="' . site_url('welcome/date_archive/' . $year_month) . '">'.$year_month.'</a></li>';
			}
		}

		return $archive_html;
	}

	public function save_article_images() {

		$object_id = $this->input->post('object_id');
		if(empty($object_id)) {
			show_error('保存图片ID不存在');
		}

		if(isset($_FILES['files']) and is_array($_FILES['files']['name'])
				and count($_FILES['files']) > 0) {
            $upload_config 			= $this->config->item('upload_config');
            $resource_upload_path 	= $this->config->item('resource_upload_path');
            $upload_path 			=make_upload_dir();
            $upload_config['upload_path'] = $upload_path;
            $this->load->library('upload', $upload_config);

            $resize_img_config = $this->config->item('resize_img_config');
			$this->load->library('image_lib');

            $i = 0;
            for($i = 0; $i < count($_FILES['files']['name']); $i++) {
                $_FILES['file' . $i] = array(
                    'name'      => $_FILES['files']['name'][$i],
                    'type'      => $_FILES['files']['type'][$i],
                    'tmp_name'  => $_FILES['files']['tmp_name'][$i],
                    'error'     => $_FILES['files']['error'][$i],
                    'size'      => $_FILES['files']['size'][$i],
                    );
            }

            unset($_FILES['files']);

			$titles 	= isset($_POST['titles']) ? $_POST['titles'] : array();
            $summaries 	= isset($_POST['summaries']) ? $_POST['summaries'] : array();

            foreach($_FILES as $k=>$v) {
            	if($this->upload->do_upload($k)) {
            		$upload_data = $this->upload->data();

            		$resize_img_config['source_image'] = $upload_data['full_path'];
            		$this->image_lib->initialize($resize_img_config);
            		$this->image_lib->resize();

            		$pathname 	= str_replace($resource_upload_path, '', $upload_data['full_path']);
            		$pathname 	= str_replace($upload_data['file_ext'], '_thumb' . $upload_data['file_ext'], $pathname); 
            		$title 		= isset($titles[$i]) && ! empty($title[$i]) ? $titles[$i] : $upload_data['file_name'];
	                $summary 	= isset($summaries[$i]) ? $summaries[$i] : '';
	                $added_by 	= cur_user_account();
	                $added_time = date(TIME_FORMAT);

	                $insert_file = array(
	                    'pathname'      => $pathname,
	                    'title'         => $title,
	                    'summary'       => $summary,
	                    'extension'     => $upload_data['file_ext'],
	                    'size'          => $upload_data['file_size'],
	                    'width'         => $upload_data['image_width'],
	                    'height'        => $upload_data['image_height'],
	                    'object_type'   => 'article',
	                    'object_id'     => $object_id,
	                    'added_by'      => $added_by,
	                    'added_time'    => $added_time,
	                    );
	                $this->db->insert(TABLE_FILE, $insert_file);

	                $i += 1;
            	}else{
            		 $this->form_validation->set_error_array(array($this->upload->display_errors()));
            		 return FALSE;
            	}
            }
		}

		return TRUE;
	}

	//return the file array if success update
	public function update_article() {
		$file_id = $this->input->post('id');
		if(empty($file_id)) {
			show_error('文件ID不存在');
		}

		$where = array(
			'id'			=> $file_id,
			);
		$old_file = $this->db->from(TABLE_FILE)->where($where)->get()->row_array();
		if($old_file === NULL) {
			show_error('修改文件不存在');
		}

		$this->form_validation->set_rules('title', '标题', 'required');

		if(! $this->form_validation->run()) {
			return FALSE;
		}

		$update_file['title'] 		= $this->input->post('title');
		$update_file['summary']	= $this->input->post('summary');
		if(empty($update_file['summary'])) {
			$update_file['summary'] = '';
		}
		if(isset($_FILES['file']) and ! empty($_FILES['file']['name'])) {

            $upload_config 			= $this->config->item('upload_config');
            $resource_upload_path 	= $this->config->item('resource_upload_path');
            $upload_path 			=make_upload_dir();
            $upload_config['upload_path'] = $upload_path;
            $this->load->library('upload', $upload_config);

            if($this->upload->do_upload('file')) {
            	$upload_data = $this->upload->data();

	            $resize_img_config = $this->config->item('resize_img_config');
	            $resize_img_config['source_image'] = $upload_data['full_path'];
				$this->load->library('image_lib', $resize_img_config);
				$this->image_lib->resize();

				$pathname 	= str_replace($resource_upload_path, '', $upload_data['full_path']);
            	$pathname 	= str_replace($upload_data['file_ext'], '_thumb' . $upload_data['file_ext'], $pathname);
            	$update_file['pathname'] = $pathname;
            }
		}

		$this->db->where('id', $old_file['id'])->update(TABLE_FILE, $update_file);
		return $old_file;
	}


	public function increase_hit($article_id) {
		$this->db->query('update ' . TABLE_ARTICLE .
		 ' set `hits`=`hits`+1 where `id`=' . intval($article_id));
	}




	private function _get_thumb_path($origin_path) {
		$index = strrpos($origin_path, '.');
		if($index !== FALSE) {
			return substr($origin_path, 0, $index) . '_thumb' . substr($origin_path, $index);
		}else{
			return '';
		}
	}

}
