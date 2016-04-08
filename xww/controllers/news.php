<?php defined('BASEPATH') || exit('no direct script access allowed');

class  News extends Ykj_controller{

	protected $total_rows = '0';    // 新闻总记录数
	protected $per_page   = '10';   // 每页显示的记录数
	protected $lm_alias = '';     	// 栏目的别名


	/*构造方法*/
	public function __construct(){
		parent::__construct();
		$this -> load -> model('news_model');
		$this -> load -> model('news_category_model');
		$this -> load -> model('student_model');
		$this -> load -> model('file_model');

		$this -> load -> helper('url');
		$this -> load -> library('pagination');
		$this -> load -> model('news_crawler_model');
	}


	/*前台主控制器*/
	public function index(){
		exit('error');
	}
	/**取得新闻列表*/
	public function li($id){
		$head['basepath'] = 'xww/third_party/floatpic/';
		$head['js'] = array(
			'js/jquery-1.9.1.min.js'
			);
		$this -> loadHeader(array('head' => $head));
		$id = intval($id);
		$nowPage = $this -> uri -> segment(4);
		if( ! $nowPage) $nowPage = 1;
		$nowPage = intval($nowPage);
		$offset = ($nowPage - 1) * 15;
		$limit = 15;
		$data['newsList'] = $this -> news_model -> getByCPagin($id, $limit, $offset);
		foreach ($data['newsList']  as $key => $value) {
			if(mb_strlen($value['title']) > 30){
				$data['newsList'] [$key]['title'] = mb_substr($value['title'], 0, 30) . "..";
			}
		}
		foreach ($data['newsList'] as $key => $value) {
			$data['newsList'][$key]['add_time'] = date('Y-m-d', $value['add_time']);
			$stripTagsContent = strip_tags($value['content']);
			if(empty($value['summary']) && mb_strlen($stripTagsContent) > 110){
				$data['newsList'][$key]['summary'] = mb_substr($stripTagsContent, 0, 110);
			}else if(empty($value['summary']) && mb_strlen($stripTagsContent) <= 110){
				$data['newsList'][$key]['summary'] = $stripTagsContent;
			}
		}
		//weekHot
		$data['categoryList'] = $this -> news_category_model -> getById($id);
		
		$recentList = $this -> news_crawler_model -> get(5, 0, 
			array('category_id' => 1,
					'is_top <>' => 2));

		foreach ($recentList as $key => $value) {
			if(mb_strlen($value['title']) > 20){
				$recentList[$key]['title'] = mb_substr($value['title'], 0, 20) . "..";
			}
		}

		$pageSize = 15;
		$rowNum = $this -> news_model -> getRowNum($id);

		$pageConfig = array(
			'base_url' => base_url() . 'index.php/news/li/'.$id.'/',
			'total_rows' => $rowNum,
			'per_page' => 15,
			'uri_segment'=> 4,
			'num_links' => 4,
			'use_page_numbers' => true,
			'full_tag_open' => '<div class="manu">',
			'full_tag_close'=> ' </div> ',
			'prev_tag_open' => '',
			'prev_tag_close'=> '',
			'next_tag_open' => '',
			'next_tag_close'=> '',
			'num_tag_open'  => '',
			'num_tag_close' => '',
			'cur_tag_open'  => '<span class="current">',
			'cur_tag_close' => '</span>',
			'prev_link'     => '&lt; 上一页',
			'next_link'     => '下一页 &gt;'
			);
		$this -> pagination -> initialize($pageConfig);
		$pageLink = $this -> pagination -> create_links();

		$data['pageLink'] = $pageLink;
		$data['recentList'] = $recentList;
		$this -> load -> view('front/xww/news_list_view', $data);
		$this -> loadFooter();
	}
	/**取得新闻列表*/
	public function mtjy($id){
		$head['basepath'] = 'xww/third_party/floatpic/';
		$head['js'] = array(
			'js/jquery-1.9.1.min.js'
			);
		$this -> loadHeader(array('head' => $head));

		$id = intval($id);
		$nowPage = $this -> uri -> segment(4);
		if( ! $nowPage) $nowPage = 1;
		$nowPage = intval($nowPage);
		$offset = ($nowPage - 1) * 15;
		$limit = 15;
		$data['newsList'] = $this -> news_model -> getByCPagin($id, $limit, $offset);

		foreach ($data['newsList']  as $key => $value) {
			if(mb_strlen($value['title']) > 30){
				$data['newsList'] [$key]['title'] = mb_substr($value['title'], 0, 30) . "..";
			}
		}
		foreach ($data['newsList'] as $key => $value) {
			$data['newsList'][$key]['add_time'] = date('Y-m-d', $value['add_time']);
			$stripTagsContent = strip_tags($value['content']);
			if(empty($value['summary']) && mb_strlen($stripTagsContent) > 110){
				$data['newsList'][$key]['summary'] = mb_substr($stripTagsContent, 0, 110);
			}else if(empty($value['summary']) && mb_strlen($stripTagsContent) <= 110){
				$data['newsList'][$key]['summary'] = $stripTagsContent;
			}
		}
		//weekHot
		$data['categoryList'] = $this -> news_category_model -> getById($id);
		
		$recentList = $this -> news_crawler_model -> get(5, 0, 
			array('category_id' => 1,
					'is_top <>' => 2));

		foreach ($recentList as $key => $value) {
			if(mb_strlen($value['title']) > 20){
				$recentList[$key]['title'] = mb_substr($value['title'], 0, 20) . "..";
			}
		}

		
		$pageSize = 15;
		$rowNum = $this -> news_model -> getRowNum($id);

		$pageConfig = array(
			'base_url' => base_url() . 'index.php/news/mtjy/'.$id.'/',
			'total_rows' => $rowNum,
			'per_page' => 15,
			'uri_segment'=> 4,
			'num_links' => 4,
			'use_page_numbers' => true,
			'full_tag_open' => '<div class="manu">',
			'full_tag_close'=> ' </div> ',
			'prev_tag_open' => '',
			'prev_tag_close'=> '',
			'next_tag_open' => '',
			'next_tag_close'=> '',
			'num_tag_open'  => '',
			'num_tag_close' => '',
			'cur_tag_open'  => '<span class="current">',
			'cur_tag_close' => '</span>',
			'prev_link'     => '&lt; 上一页',
			'next_link'     => '下一页 &gt;'
			);
		$this -> pagination -> initialize($pageConfig);
		$pageLink = $this -> pagination -> create_links();

		$data['pageLink'] = $pageLink;
		
		$data['recentList'] = $recentList;
		$this -> load -> view('front/xww/mtjy_list_view', $data);
		$this -> loadFooter();
	}
	
	public function archive($id){
		$head['basepath'] = 'xww/third_party/floatpic/';
		$head['js'] = array(
			'js/jquery-1.9.1.min.js'
			);
		$this -> loadHeader(array('head' => $head));

		//get the article archie
		//$this -> news_model -> getArticleArchive();
		//set the Hits every body
		$hits = $this -> session -> userdata('hits');
		$this->news_model->add_hit(intval($id));
		// if(empty($hits)){
		// 	$hits = array();
		// 	array_push($hits, $id);
		// 	$this -> news_model -> hits($id);
		// 	$this -> session -> set_userdata('hits', $hits);
		// }else{
		// 	if(!in_array($id, $hits)){
		// 		array_push($hits, $id);
		// 		$this -> news_model -> hits($id);
		// 		$this -> session -> set_userdata('hits', $hits);
		// 	}
		// }

		//更具id取出数据
		$data['content'] = $this -> news_model -> getById($id);

		//weekHot
		
		$recentList = $this -> news_crawler_model -> get(5, 0, 
			array('category_id' => 1,
					'is_top <>' => 2));

		foreach ($recentList as $key => $value) {
			if(mb_strlen($value['title']) > 20){
				$recentList[$key]['title'] = mb_substr($value['title'], 0, 20) . "..";
			}
		}
		
		$data['recentList'] = $recentList;
		//加载上一页
		$data['PreNext'] = $this -> news_model -> getPreNext($data['content']['news_id'], $data['content']['category_id']);
		// var_dump($data['content']);
		$this -> load -> view('front/xww/news_archive_view', $data);
		$this -> loadFooter();
	}

	//newspic page
	public function newspic($id = ''){
		//css
		$head = array();
		$head['basepath'] = 'xww/third_party/floatpic/';
		$head['css'] = array('css/bigimg.css', 'css/pubu.css');
		$head['js'] = array(
			'js/jquery-1.9.1.min.js',
			'js/notification.js',
			'js/jquery.lazyload.min.js',
			'js/blocksit.min.js',
			'js/pubu.js'
			);
		$this -> loadHeader(array('head' => $head));

		//get the first img
		$data['pics']['img'] = array();
		$data['pics']['mimg'] = array();
		$pics = $this -> news_model -> fgetByCId(7, 3);
		foreach ($pics as $key => $value) {
			if (isset($value['img']) && !empty($value['img'])) {
				foreach ($value['img'] as $key1 => $value1) {
					$data['pics']['img'][] = $value1;
				}
				foreach ($value['mimg'] as $key2 => $value2) {
					$data['pics']['mimg'][] = $value2;
				}
			}
		}


		$recentList = $this -> news_crawler_model -> get(5, 0, 
			array('category_id' => 1,
					'is_top <>' => 2));
		
		$data['recentList'] = $recentList;

		if(empty($id)){
			//li newspic
			$this -> load -> view('front/xww/picnews_view', $data);
		}else{
			//archive of the new pic 
			$newsid = intval($id);

		}
		$this ->loadFooter();
	}

	public function wstx(){
		$this -> loadHeader();
		$this -> load -> view('front/wstx_view');
		$this -> loadFooter();
	}

	//wagnshagn tuanxiao
	public function wstxData(){
		$num = 20;
		$post = $this -> input -> post();

		if(!empty($post)){
			$start = intval($post['page']);
		}else{
			$start = 0;
		}
		$wstxList = $this -> news_model -> getListByCId(7);
		echo json_encode($wstxList);
	}

	//wstx login
	public function wstxLogin(){
		$this -> load -> model('user_model');
		$post = $this -> input -> post();
		if(!empty($post)){
			$data['email'] = addslashes($post['username']);
			$data['password'] = addslashes($post['password']);
			$data['type'] = 1;
			$userinfo = $this -> user_model -> wxtxLogin($data);
		}

		echo 1;
	}

	public function wstxSignin(){
		$this -> load -> model('user_model');
		$post = $this -> input -> post();
		if(!empty($post['username']) && !empty($post['password'])){
			$upData = array(
					'email' => $post['username'],
					'password' => $post['password'],
					'type' => 1
				);

			if($userinfo = $this -> user_model -> chkWstxUser($upData)){
				$this -> session -> set_userdata('wstxUserinfo', $userinfo);
			}
		}
	}

	//Ajax Get Photo
	public function AjaxGetPhoto(){
		$post = $this -> input -> post();

		if(empty($post)){
			echo json_encode(array('err' => 0));
			exit();
		}

		$lastId = isset($post['lastId']) ? intval($post['lastId']) : 0;
		$category_id = 7;
		
	}
}