<?php defined('BASEPATH') || exit('no direct script access allowed');
/**
*news data class to manage the news table
*@author ykjver
*@lastEdit 2014/09/22
**/


class news_model extends CI_Model{
	private $tableName = '';

	//construct function 
	public function __construct(){
		parent::__construct();


		$this -> tableName = 'news';
	}

	//common add news
	public function add($data = ''){
		if( ! is_array($data)){
			return FALSE;
		}

		$this -> db -> insert($this -> tableName, $data);
		if($this -> db -> affected_rows()){
			return $this -> db -> insert_id();
		}else{
			return FALSE;
		}
	}

	//common edit news
	public function update($newsIds, $data){
		if( ! isset($newsIds) || ! is_array($data) ){
			return FALSE;
		}

		if(strpos($newsIds, ',')){
			$this -> db -> where_in('id', $newsIds);
		}else{
			$this -> db -> where('id', $newsIds);
		}

		if($result = $this -> db -> update($this -> tableName, $data)){
			$result = $this -> getById($newsIds);
		}

		return $result;
	}

	//ajax update function only accept the post parameter
	public function update1($post){
		if(!is_array($post)) return false;

		$data = array(
			'summary' => isset($post['summary']) ? $post['summary'] : '',
			'content' => isset($post['content']) ? $post['content'] : '',
			'category_id' => isset($post['categoryId']) ? intval($post['categoryId']) : 0,
			'title' => isset($post['name']) ? $post['name'] : 0,
			'come_from' => isset($post['come_from']) ? $post['come_from'] : '',
			'author' => isset($post['author']) ? $post['author'] : '',
			'add_time' => isset($post['addDate']) ? strtotime($post['addDate']) : 0
			);
		$id = isset($post['id']) ? intval($post['id']) : 0;
		$this -> db -> where('id', $id);

		if($this -> db -> update($this -> tableName, $data)){
			return true;
		}else{
			return false;
		}
	}

	//xww index getNews model
	public function getIndexModel($cId = null, $num = 10){
		$dataList = $this -> fgetByCId($cId, $num);
		$dataFirst = array();
		foreach ($dataList as $key => $value) {
			if(mb_strlen($value['title']) > 15){
				$dataList[$key]['title'] = mb_substr($value['title'], 0, 15) . '...';	
			}
			if(isset($value['defaultImg']) && empty($dataFirst)){
				$dataFirst = $value;
				unset($dataList[$key]);
			}
		}
		//Deal dataFirst
		if(mb_strlen($dataFirst['describle']) > 75){
			$dataFirst['describle'] = mb_substr($dataFirst['describle'], 0, 75);
		}

		return array('dataList' => $dataList, 'dataFirst' => $dataFirst);
	}

	//xww index getnews By Id
	public function fgetByCId($cId = null, $num = 10, $start = 0){
		$newsList = $this -> getListByCId($cId, $num, $start);
		$allowedArray = array('.jpg', '.gif', '.png');

		foreach ($newsList as $key => $value) {
			//Deal File
			$files = $this -> file_model -> getByObjId($value['news_id']);
			$newsList[$key]['img'] = array();
			$newsList[$key]['img'] = array();
			$imgs = array();
			$mimgs = array();
			foreach ($files as $key1 => $value1) {
				if(in_array(strtolower($value1['extension']), $allowedArray)){
					$imgs[] = $value1['pathname'];
					$mimg = substr($value1['pathname'], 0, intval(strrpos($value1['pathname'], '/')) + 1);
					$mimg .= 'm_'.substr($value1['pathname'], intval(strrpos($value1['pathname'], '/')) + 1);
					$mimgs[] = $mimg;
				}				
			}
			$newsList[$key]['img'] = $imgs;
			$newsList[$key]['mimg'] = $mimgs;
			if(isset($newsList[$key]['mimg'][0])){
				$newsList[$key]['defaultImg'] = $newsList[$key]['mimg'][0];
			}
		
			//Deal Describle
			$newsList[$key]['describle'] = strip_tags($value['content']);
			if(empty($value['describle']) && mb_strlen(strip_tags($value['content'])) > 200){
				$deleteArray = array(" ", "	", "\t", "\n", "\r");
				$replaceArray = array('', '', '', '', '');
				$newsList[$key]['describle'] = mb_substr(str_replace($deleteArray, $replaceArray, strip_tags($value['content'])), 0, 200);
			}

			//Deal Date
			$newsList[$key]['add_time'] = date('Y-m-d', $value['add_time']);
		}

		return $newsList;
	}

	/**
	*取得新闻列表按分类
	*@param cId  分类的id
	*@param num  获取的数量
	**/
	public function getListByCId($cId = null, $num = 10, $start = 0){
		$where = array(
			'news.is_delete' => 0,
			'news_category.is_delete' => 0,
			);
		if($cId != null){
			$where['category_id'] = $cId;
		}

		$select = 'news.id as news_id, content, ';
		$select .= 'news.hits,news_category.id as category_id, news.status, ';
		$select .= 'news_category.name as category_name, ';
		$select .= 'news_category.describle, ';
		$select .= 'title, author, summary, keywords, news.pic_src, url_src, ';
		$select .= 'come_from, hits, file_src, news.add_time, sort, news_category.pic_src as category_pic_src';

		$join = array(
			'table' => 'news_category',
			'cond' => 'news_category.id = news.category_id',
			'type' => 'LEFT',
			);

		$this -> db -> where($where);
		$this -> db -> join($join['table'], $join['cond'], $join['type']);
		$this -> db -> select($select);
		$this -> db -> order_by('news.sort', 'DESC');
		$query = $this -> db -> get($this -> tableName, $num, $start);
		$result = $query -> result_array();
		foreach ($result as $key => $value) {
			$imgs = $this -> file_model -> getByObjId($value['news_id']);
			if(empty($imgs)){
				$imgs[0] = array(
					'pathname' => 'source/ft/xww/images/news-wrap-img.jpg',
					'title'    => 'defaultImg',
					'primary'  => 1
					);
			}
			$result[$key]['imgs'] = $imgs;
			$result[$key]['primaryimgs'] = 0;
			foreach ($imgs as $key1 => $value1) {
				if($value1['primary'] == 1){
					$result[$key]['primaryimgs'] = $key1;
					break;
				}
			}
		}

		return $result;
	}

	/**
	*根据id获得新闻信息
	*@param id 新闻的id
	**/

	public function getById($id){
		$id = intval($id);
		if($id < 0) return FALSE;

		$where = array(
			'news.id' => $id,
			'news.is_delete' => 0,
			'news_category.is_delete'=> 0,
			);

		$select = 'news.id as news_id, ';
		$select .= 'news.hits, news_category.id as category_id, news.status,';
		$select .= 'news_category.name as category_name, ';
		$select .= 'news_category.describle, ';
		$select .= 'title, author, summary, keywords, news.pic_src, url_src, news_category.pic_src as category_pic_src, ';
		$select .= 'come_from, file_src, news.add_time, sort, content, news_category.alias';

		$join = array(
			'table' => 'news_category',
			'cond' => 'news_category.id = news.category_id',
			'type' => 'LEFT',
			);

		$this -> db -> where($where);
		$this -> db -> select($select);
		$this -> db -> join($join['table'], $join['cond'], $join['type']);

		$query = $this -> db -> get($this -> tableName, 1);
		$result = $query -> result_array();
		$result = $result[0];
		$result['files'] =  $this -> file_model -> getByObjId($result['news_id']);
		if($result['files']){
			$imgFliter = array('.gif', '.jpg', '.png');
			foreach ($result['files'] as $key => $value) {
				if(in_array(strtolower($value['extension']), $imgFliter)){
					$result['imgs'][] =  substr($value['pathname'], 0,strrpos($value['pathname'], '/') + 1).'m_'.substr($value['pathname'], strrpos($value['pathname'], '/') + 1);
				}else{
					$result['downloadfile'][] = array('url' => $value['pathname'], 'title' => $value['title']);
				}
			}
		}else{
			$result['imgs'] = array();
			$result['downloadfile'] = array();
		}
		return $result;
	}

	/**
	*得到上一页和下一页
	**/

	public function getPreNext($newsId, $categoryId){
		$where = array(
			'category_id' => $categoryId,
			);
		$this -> db -> where($where);
		$this -> db -> select('id, title');
		$categories = $this -> db -> get($this -> tableName) -> result_array();

		$returnData = array();
		$flag = 0;
		foreach ($categories as $key => $value) {
			if($value['id'] == $newsId){
				$flag = 1;
				continue;
			}
			if($flag == 1){
				$returnData['Next'] = $value;
				break;	
			} 
			if($flag == 0) $returnData['Pre'] = $value;
		}


		if(!isset($returnData['Pre']['title'])){
			$returnData['Pre']['title'] = '没有了';
			$returnData['Pre']['id'] = $newsId;
		}

		if(!isset($returnData['Next']['title'])){
			$returnData['Next']['title'] = '没有了';
			$returnData['Next']['id'] = $newsId;
		}

		return $returnData;
	}

	/**
	*逻辑删除新闻表中的单个数据也可做批量删除
	*
	**/
	public function delByIds($ids = ''){
		if(empty($ids)) return FALSE;

		if(is_array($ids)){
			$ids = implode($ids, ',');
		}

		$this -> db -> where_in('id', $ids);
		$this -> db -> where('is_delete', 0);
		$this -> db -> update($this -> tableName, array('is_delete' => 1));
		if($this -> db -> affected_rows()){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	*得到news的rownum没有被删除的数据条目
	**/
	public function getRowNum($cId = FALSE){
		if($cId != FALSE){
			$cId = is_numeric($cId) && $cId > 0 ? intval($cId) : 0;
			$this -> db -> where('category_id', $cId);
		}
		$this -> db -> where('is_delete', 0);
		$this -> db -> select('count(*)');
		$query = $this -> db -> get($this -> tableName);
		$result = $query -> row_array();
		return intval(array_pop($result));
	}	

	/**
	*分页类取得news数据
	**/
	public function getByPagin($step, $start){
		return $this -> getListByCId(null, $step, $start);
	}

	/**
	*取得分类分页数据
	**/
	public function getByCPagin($cId, $step, $start){
		return $this -> getListByCId($cId, $step, $start);
	}

	/**
	*取得最大排序值
	**/
	public function getMaxSort($cId = FALSE){
		$cId = ($cId != FALSE) && is_numeric($cId) && $cId > 0 ? intval($cId) : 1;

		$join = array(
			'table' => 'news_category',
			'cond' => 'news_category.id = news.category_id',
			'type' => 'LEFT',
			);

		$where = array(
			'news_category.id' => $cId,
			'news_category.is_delete' => 0,
			'news.is_delete' => 0,
			);

		$this -> db -> where($where);
		$this -> db -> select('sort');
		$this -> db -> order_by('sort', 'DESC');
		$this -> db -> join($join['table'], $join['cond'], $join['type']);
		$query = $this -> db -> get($this -> tableName, 1);
		$result = $query -> row_array();
		if( ! $result){
			return 1;
		}else{
			return $result['sort'] + 1;
		}
	}

	//重新排序
	public function reSort($data){
		if( ! is_array($data)|| empty($data)){
			return FALSE;
		}

		foreach ($data as $key => $value) {
			if( ! empty($value)){
				$this -> reSortById($key, $value);
			}
		}
	}

	//重新排序，单个
	public function reSortById($id, $sort){
		$id = isset($id) && is_numeric($id) && $id > 0 ? intval($id) : 0;
		$sort = isset($sort) && is_numeric($sort) && $sort > 0 ? intval($sort) : 0;
		$this -> db -> where('is_delete', 0);
		$this -> db -> where('id', $id);
		$this -> db -> select('sort, category_id');
		$preData = $this -> db -> get($this -> tableName) -> row_array();
		$preSort = $preData['sort'];
		$preCategoryId = $preData['category_id'];
		if($preSort == $sort){
			return FALSE;
		}
/*
		$sqlStr = "select news.id as id, sort from news ";
		$sqlStr .= "left join news_category on news_category.id = news.category_id ";
		$sqlStr .= "where sort >= '".$preSort."' and news.is_delete = 0 and news.category_id='".$preCategoryId."'";

		$query = $this -> db -> query($sqlStr);
		$result = $query -> result_array();

		var_dump($result);
		foreach ($result as $key => $value) {
			$this -> update($value['id'], array('sort' => $value['sort'] + 1));
		}*/
		$this -> update($id, array('sort' => $sort));
	}



	/**
	*upload file add picture
	*@return array Info of upload data
	**/
	public function newsUpload(){
		$this -> load -> library('upload');

		$uploadConf = array(
			'encrypt_name' => TRUE,
			);

		$files = $_FILES;
		$filesInfo = array();
		$this -> upload -> initialize($uploadConf);
		$this -> upload -> set_allowed_types('jpg');
		$upload_path = dirname(BASEPATH).'/ysource/';

		if(! file_exists($upload_path)){
			if( ! mkdir($upload_path)){
				return FALSE;
			}
		}

		$upload_path .= date('Ymd');
		if(! file_exists($upload_path)){
			if( ! mkdir($upload_path)){
				return FALSE;
			}
		}

		$this -> upload -> set_upload_path($upload_path);
		foreach ($files as $key => $value) {
			if( ! empty($files[$key]['name'])){
				$this -> upload -> do_upload($key);
				$filesInfo[$key] = $this -> upload -> data();
			}
		}
		echo $this -> upload -> display_errors();


		$this -> load -> library('image_lib');
		foreach ($filesInfo as $key => $value) {
			$filename = pathinfo($value['file_name']);
			$filename = $filename['filename'].'m.'.$filename['extension'];
			$imageConf = array(
				'source_image' 	=> $value['full_path'],
				'new_image' 	=> $upload_path.'/'.$filename,
				);

			if($value['image_height'] > 500 || $value['image_width'] > 500){
				if($value['image_height'] > $value['image_width']){
					$b = $value['image_width'] / $value['image_height'];
					$imageConf['width'] = 500 * $b;
					$imageConf['height'] = 500;
				}else{
					$b = $value['image_height'] / $value['image_width'];
					$imageConf['width'] = 500;
					$imageConf['height'] = 500 * $b;
				}
			}
			$this -> image_lib -> initialize($imageConf);
			$this -> image_lib -> resize();



			$filename = pathinfo($value['file_name']);
			$filename = $filename['filename'].'s.'.$filename['extension'];
			$imageConf = array(
				'source_image' 	=> $value['full_path'],
				'new_image'		=> $upload_path.'/'.$filename,
				);

			if($value['image_height'] > 200 || $value['image_width']){
				if($value['image_height'] > $value['image_width']){
					$b = $value['image_width'] / $value['image_height'];
					$imageConf['width'] = 200 * $b;
					$imageConf['height'] = 200;
				}else{
					$b = $value['image_height'] / $value['image_width'];
					$imageConf['width'] = 200;
					$imageConf['height'] = 200 * $b;
				}
			}
			$this -> image_lib -> initialize($imageConf);
			$this -> image_lib -> resize();
		}

		return $filesInfo;
	}

	public function hits($id){

		$id = intval($id);
		$this -> db -> where('id', $id);
		$this -> db -> select('hits');
		$hits = $this -> db -> get($this -> tableName) -> row_array();
		$hits = $hits['hits'];
		$hits++;

		$this -> db -> where('id', $id);
		$update = array('hits' => $hits);
		$this -> db -> update($this -> tableName, $update);
	}

	//get the week hot article
	public function getWeekHotAriticle(){
		$endTime = time();
		$startTime = $endTime - 86400*10;
		$where = array(
			'add_time >' => $startTime,
			'add_time <' => $endTime,
			'category_id !=' => 8,
			'category_id <>' => 7,
			);
		$this -> db -> where($where);
		$this -> db -> select('*');
		$this -> db -> order_by('hits','DESC');
		$result = $this -> db -> get($this -> tableName,5) -> result_array();
		//if before 10 days has not 5 article the should get more to 5

		if(count($result) < 5){
			$rest = 5 - count($result);
			$where = array(
				'add_time >' => $startTime - 86400 * 20,
				'add_time <' => $startTime
				);
			$this -> db -> where($where);
			$this -> db -> select('*');
			$this -> db -> order_by('hits', 'DESC');
			$mergeResult = $this -> db -> get($this -> tableName, $rest) -> result_array();
		}
		$result = array_merge($result, $mergeResult);
		return $result;
	}
	

}