<?php

class news_index_model extends CI_Model{
	private $tableName;
	private $category1;
	private $category2;
	public function __construct(){
		parent::__construct();

		$this -> tableName = 'new_crawler';
		$this -> category1 = '学院新闻';
		$this -> category2 = '系部动态';
		$this -> load -> library('Crawler');
	}


	public function get($limit, $offset, $cond = null){
		if($cond != null){
			$this -> db -> where($cond);
		}

		$this -> db -> order_by('index_ctime', 'desc')
					->order_by("cur_order", "asc");
		$result = $this -> db -> get($this -> tableName, $limit, $offset) -> result_array();

		foreach ($result as $key => $value) {
			if($value['category_id'] == 1){
				$result[$key]['category_name'] = $this -> category1;
			}else if($value['category_id'] == 3){
				$result[$key]['category_name'] = $this -> category2;
			}

			$result[$key]["index_cmitime"] = $result[$key]["index_ctime"] = 
						date("Y-m-d", $value["index_ctime"]);
		}
		return $result;
	}

	public function getTotal($cond = null){
		if($cond != null){
			$this -> db -> where($cond);
		}

		$this -> db -> select('count(*)');
		$result = $this -> db -> get($this -> tableName) -> row_array();
		if(isset($result['count(*)'])){
			return $result['count(*)'];
		}else{
			return 0;
		}
	}

	/*
		返回1表示设置成功
		返回2表示没有设置图片之前不能设置为置顶信息，因为置顶信息必须有一张图片
	*/
	public function setTop($id){
		$result = $this -> get(1, 0, array('id' => $id));
		if(empty($result[0]['cover_img'])){
			return 2;
		}

		$this -> update(array('is_top' => 0), array('category_id' => $result[0]['category_id']));
		$this -> update(array('is_top' => 2), array('id' => $id));
		return 1;
	}

	public function update($data, $cond = null){
		if($cond != null){
			$this -> db -> where($cond);
		}
		$this -> db -> update($this -> tableName, $data);
	}

	public function setCoverImg($post){
		// $id = isset($post['id']) && is_numeric($post['id']) ?
		// 	intval($post['id']) : 0;

		$id = isset($post['id']) ? stripslashes($post['id']) : "-1";
		$coverImg = isset($post['coverImg']) ? $post['coverImg'] : '';

		$result = $this -> update(array('cover_img' => $coverImg), array('id' => $id));
		if(!$result){
			return true;
		}else{
			return false;
		}

	}

	public function doCrawl(){
		$this->doXyxwCrawl();
		$this->doXbxwCrawl();
	}


	public function doXyxwCrawl() {
		$uri = 'http://www.svtcc.edu.cn/front/list-11.html';
		$params = array("pageNo" => 1, "pageSize" => 100, "baseUrl" =>$uri);
		$d = new Crawler($params);
		$xyxwResult = $d -> getContent();
		$result= $this->parseNews($xyxwResult, "/right;\">(.*)<\/span>.*view-11-(.*)\.html.*>(.*)<\/a>/", $categoryId = 1);
		$this -> udpateWwwNewsData($result);
	}

	public function doXbxwCrawl() {
		$uri = 'http://www.svtcc.edu.cn/front/list-16.html';
		$params = array("pageNo" => 1, "pageSize" => 100, "baseUrl" =>$uri);
		$d = new Crawler($params);
		$xyxwResult = $d -> getContent();
		$result= $this->parseNews($xyxwResult, "/right;\">(.*)<\/span>.*view-16-(.*)\.html.*>(.*)<\/a>/", $categoryId = 3);
		$this -> udpateWwwNewsData($result);
	}


	public function parseNews($content = "", $preg = "", $categoryId = 1){
		preg_match_all($preg, $content, $matchResult);
		$resultArray = array();
		$index = 0;
		if(count($matchResult) == 4){
			foreach ($matchResult[0] as $key => $value) {
				array_push($resultArray, array(
					"title" => $matchResult[3][$key],
					"id" => $matchResult[2][$key],
					"index_ctime" => strtotime($matchResult[1][$key]),
					"category_id" => $categoryId,
					"index_cmitime" => strtotime($matchResult[1][$key]),
					"cur_order" => $index++,
					));
			}
		}
		return $resultArray;
	}


	public function udpateWwwNewsData($dataArray = array()) {

		// var_dump($dataArray);
		foreach ($dataArray as $key => $value) {
			$data = $this->db->where(array("id"=>$value['id']))
						->get($this->tableName)
						->result_array();

			if(count($data)>0){
				$this->db->where(array("id" => $data[0]['id']))->update($this->tableName, $value);
			}else{
				$this->db->insert($this->tableName, $value);
			} 
		}
	}

	public function updateData($data){

		foreach ($data as $key => $value) {
			$this -> db -> where(array('index_id' => $value['id']));
			$news = $this -> db -> get($this -> tableName) -> row_array();
			$insertData = array(
				'id' => $value['id'],
				'index_id' => $value['id'],
				'category_name' => $value['category_name'],
				'index_ctime'=> $value['index_ctime'],
				'category_id' => $value['category_id'],
				'title' => $value['title'],
				'index_cmitime'=> strtotime($value['index_ctime'])
				);
			if(!empty($news)){
				$this -> db -> where(array('id' => $news['id']));
				$this -> db -> update($this -> tableName, $insertData);
			}else{
				$this -> db -> insert($this -> tableName, $insertData);
			}
		}

	}

	public function getTotalByGroup(){
		$this -> db -> group_by('category_name');
		$this -> db -> select('count(*) as total, category_name');
		$news = $this -> db -> get($this -> tableName) -> result_array();
		return $news;
	}


	public function del($id){
		$id = stripslashes($id);
		$this->db->where(array("id"=>$id))->delete($this->tableName);
	}
}