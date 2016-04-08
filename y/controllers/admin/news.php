<?php	defined('BASEPATH') || exit('no direct script access allowed');


class news extends Ykj_Controller{

	//construct function
	public function __construct(){
		parent::__construct();

		$this -> className = 'news';
		$this -> load -> model('news_model');
		$this -> load -> model('news_category_model');
		$this -> load -> model('file_model');
		$this -> load -> library('pagination');
		$this -> load -> library('upload');
		$this -> load -> library('session');
		$this -> load -> helper('url');
		$this -> load -> model('category_model');	

		$this -> judgeLogin();
	}

	//新闻分类添加页面
	public function categoryAdd($id = FALSE){
		if($id != FALSE){
			$data['id'] = intval($id);
		}else{
			$data['id'] = -1;
		}
		$data['categoryList'] = $this -> news_category_model -> getRecList();
		//var_dump($data);
		$this -> load -> view('news_category/add_view', $data);
	}

	//新闻分类添加动作
	public function doCategoryAdd(){
		$data = $this -> input -> post(NULL, TRUE);
		$categoryName = $data['name'];
		$describle = $data['describle'];
		$fid = $data['fid'];

		if(empty($categoryName)){
			$msg = '分类名不能为空';
			$href = site_url('admin/news/categoryAdd');
			$this -> yerror -> showYerror($msg, $href);
			exit(); 
		}
		
		$isHasName = $this -> news_category_model -> isHas($categoryName);
		if( ! empty($isHasName)){
			$msg = '分类名已经存在';
			$href = site_url('admin/news/categoryAdd');
			$this -> yerror -> showYerror($msg, $href);
			exit(); 
		}



		$data = array(
			'name' => 		$categoryName,
			'describle' => 	$describle,
			'alias' => $this -> input -> post('alias', TRUE),
			'add_time' => 	time(),
			'is_delete' => 	'0',
			'fid' => $fid,
			);

		if($this -> news_category_model -> hasAlias($data['alias'])){
			$msg = '别名已经存在，请更换别名';
			$href = site_url('admin/news/categoryadd');
			$this -> yerror -> showYerror($msg, $href);
			exit();
		}


		if($this -> news_category_model -> add($data)){
			$msg = '添加分类成功';
			$href = site_url('admin/news/categoryList');
			$this -> yerror -> showYerror($msg, $href);
			exit(); 
		}else{
			$msg = '未知错误，添加分类失败';
			$href = site_url('admin/news/categoryList');
			$this -> yerror -> showYerror($msg, $href);
			exit(); 
		}
	}

	//新闻分类列表
	public function categoryList(){
		$data['categories'] = $this -> news_category_model -> getRecList();

		$this -> load -> view('news_category/list_view', $data);
	}

	//新闻分类编辑
	public function categoryEdit($id){
		$data['categoryList'] = $this -> news_category_model -> getRecList();
		if($data['categoryInfo'] = $this -> news_category_model -> getById($id)){
			//var_dump($data['categoryInfo']);
			$this -> load -> view('news_category/edit_view', $data);
		}
	}

	//新闻分类编辑动作页面
	public function doCategoryEdit(){

		$a = $this -> input -> post();
		//var_dump($a);
		$id = $this -> input -> post('id', TRUE);
		//var_dump($id);
		$data['fid'] = 			$this -> input -> post('fid', TRUE);
		$data['describle'] = 	$this -> input -> post('describle', TRUE);
		$data['alias'] =  		$this -> input -> post('alias', TRUE);
		$data['name'] = 		$this -> input -> post('name', TRUE);

		$data['describle'] = addslashes($data['describle']);
		$data['alias'] = addslashes($data['alias']);
		$data['fid'] = intval($data['fid']);
		$id = intval($id);

/*
		if($this -> news_category_model -> hasAlias($data['alias'])){
			$msg = '别名已经存在，请更换别名';
			$href = site_url('admin/news/categoryEdit/'.$id);
			$this -> yerror -> showYerror($msg, $href);
			exit();
		}
*/
		if($data['fid'] == $id){
			$msg = '自己不能做自己的父类';
			$href = site_url('admin/news/categoryEdit/'.$id);
			$this -> yerror -> showYerror($msg, $href);
			exit();
		}


		if($this -> news_category_model -> update($data, $id)){
			$msg = '修改分类成功';
			$href = site_url('admin/news/categoryList');
		}else{
			$msg = '修改分类失败';
			$href = site_url('admin/news/categoryEdit/'.$id);
		}
		$this -> yerror -> showYerror($msg, $href);
	}



	//Json新闻分类列表
	public function jsonCategoryList(){
		$result = $this -> news_category_model -> getRecList();
		$jsonData = json_encode($result);
		echo $jsonData;
		//var_dump($result);
	}

	//新闻添加页面
	public function add($cId = FALSE){
		//judge the category id if empty
		if($cId != FALSE){
			$cId = is_numeric($cId) && $cId > 0 ? intval($cId) : 0;
		}else{
			$cId = -1;
		}

		//judge the author session
		$Clogin = $this -> session -> userdata('Clogin');
		if( ! empty($Clogin['username'])){
			$username = $Clogin['username'];
		}else{
			$username = '管理员';
		}

		$newsCategoryList = $this -> news_category_model -> getRecList();
		$categoryInfo = $this -> category_model -> getById($cId);

		$data = array(
			'data' => 		$newsCategoryList,
			'cId'=> 		$cId,
			'username' =>	$username,
			'categoryInfo' => $categoryInfo,
			);

		$this -> load -> view('news/add_view', $data);
	}

	//附件添加
	public function filesAdd($newsId = ''){
		if($newsId == '') return FALSE;
		$newsId == intval($newsId);
		$allowedType = array('.jpg', '.gif', '.png');
		$news = $this -> news_model -> getById($newsId);

		$fileList = $this -> file_model -> getByObjId($newsId);
		foreach ($fileList as $key => $value) {
			if( in_array(strtolower($value['extension']), $allowedType)){
				unset($fileList[$key]);
			}
		}

		$data = array(
			'fileList' => $fileList,
			'objId' => $newsId,
			'categoryId' => $news['category_id'],
			);

		$this -> load -> view('news/files_add_view', $data);
	}

	//dofilesaddpage
	public function doFilesAdd(){
		if($objId = $this -> file_model ->upload()){
			$msg = '添加文件附件成功';
			$href = site_url('admin/news/filesAdd/'.$objId);
		}else{
			$msg = '添加文件附件失败';
			$href = site_url('admin/news/filesAdd/'.$objId);
		}
		$this -> yerror -> showYError($msg, $href);
	}

	//附件图片添加
	public function fileAdd($newsId = ''){
		if($newsId == '') return FALSE;
		$newsId = intval($newsId);	
		$allowedType = array('.jpg', '.gif', '.png');

		$fileList = $this -> file_model -> getByObjId($newsId);
		$news = $this -> news_model -> getById($newsId);

		foreach ($fileList as $key => $value) {
			if($value['objectType'] == 'article'){
				$tempTail = substr($value['pathname'],strrpos($value['pathname'], '/') + 1);
				$tempHead = substr($value['pathname'],0,strrpos($value['pathname'], '/') + 1);

				$fileList[$key]['pathname'] = $tempHead . 'm_' . $tempTail;
			}else{
				unset($fileList[$key]);
			}

			if( ! in_array(strtolower($value['extension']), $allowedType)){
				unset($fileList[$key]);
			}
		}

		$data = array(
			'objId' 	=> $newsId,
			'fileList'	=> $fileList,
			'category_id' => $news['category_id'],
			'newsInfo'   => $news,
			);
		
		$this -> load -> view('news/file_add_view', $data);
	}

	//set the default img of article
	public function setDefaultImg(){
		$post = $this -> input -> post();
		$fileId = isset($post['fileId']) ? intval($post['fileId']) : 0;
		$objId = isset($post['objId']) ? intval($post['objId']) : 0;
		
		if($fileList = $this -> file_model -> setDefaultImg($fileId, $objId)){
			echo json_encode(array('err' => 0));
		}else{
			echo json_encode(array('err' => -1));
		}
	}

	//fileadd action page
	public function doFileAdd(){
		$id = $this -> input -> post('objId');	

		if($objId = $this -> file_model ->upload()){
			$msg = '添加图片附件成功';
			$href = site_url('admin/news/fileAdd/'.$id);
		}else{
			$msg = '添加图片附件失败';
			$href = site_url('admin/news/fileAdd/'.$id);
		}
		$this -> yerror -> showYError($msg, $href);
	}

	//file delete action page
	public function fileDelete($fileId = ''){
		$this -> file_model -> deleteByFileId($fileId);
	}

	//新闻添加动作页面
	public function doAdd(){

		//deal the file add pictrue
		$filesInfo = $this -> news_model -> newsUpload();

		$name = 	$this -> input -> post('name', TRUE);
		$desc = 	$this -> input -> post('desc', TRUE);
		$content = 	$this -> input -> post('content');
		$picSrc = 	$this -> input -> post('picsrc', TRUE);
		$categoryId = intval($this -> input -> post('categoryId', TRUE));
		$author = 	$this -> input -> post('author', TRUE);
		$addDate = 	strtotime($this -> input -> post('addDate', TRUE));
		$status = 	$this -> input -> post('status' , TRUE);
		$come_from = $this -> input -> post('come_from',TRUE);

		if(empty($name)){
			$msg = "新闻标题能为空";
			$href = site_url('admin/news/add');
			$this -> Yerror -> showYerror($msg, $href);
			exit();
		}

		//转义处理
		$name = addslashes($name);
			
		$data = array(
			'title' 	=> $name,
			'summary' 	=> $desc,
			'content' 	=> $content,
			'pic_src' 	=> $picSrc,
			'category_id' => $categoryId,
			'add_time' 	=> $addDate,
			'sort' 		=> $this -> news_model -> getMaxSort($categoryId),
			'status'	=> $status,
			'author'	=> $author,
			'come_from' => $come_from
			);
		if( !$insertId = $this -> news_model -> add($data)){
			$msg ="未知错误";
			$href = site_url('admin/news/add');
			$this -> Yerror -> showYerror($msg, $href);
			exit();
		}
		
		//提取content中的img信息到img去
		$this -> file_model -> getImageFromContent($content, $insertId);	

		$msg = "添加新闻成功";
		$href = site_url('admin/news/categoryLi/' . $categoryId);
		$this -> yerror -> showYerror($msg, $href);
	}

	//新闻编辑页面
	public function edit($id = ''){
		if(empty($id)){
			$msg = "未知错误";
			$href = site_url('admin/news/');
			$this -> yerror -> showYerror($msg, $href);
		}

		$data = array(
			'newsData' => $this -> news_model -> getById($id),
			'newsCategoryData'=> $this -> news_category_model -> getList(null),
			);
		// var_dump($data['newsData']);
		//var_dump($data);
		$this -> load -> view('news/edit_view', array('data' => $data));
	}

	//新闻编辑动作页面
	public function doEdit(){
		$post = $this -> input -> post();
		$issc = $this -> news_model -> update1($post);
		//echo json_encode($post);
		if($issc){
			echo json_encode(array('error' => 0));
		}else{
			echo json_encode(array('error' => 1));
		}
	}

	//新闻删除界面
	public function del($id = ''){
		$id = ((! empty($id)) && is_numeric($id) && $id > 0 ? intval($id) : 0);

		if(! ($data = $this -> news_model -> getById($id))){
			$msg = '未知错误，删除失败';
		}else{
			if($this -> news_model -> delByIds($id)){
				$msg = '删除成功';
			}else{
				$msg = '删除失败';
			}

		}
		
		$href = site_url('admin/news/categoryLi/' . $data['category_id']);
		$this -> yerror -> showYerror($msg, $href);

	}

	//新闻列表页面
	public function li($page = 0){
		$config = array(
			'base_url' => 		base_url('admin/news/li'),
			'total_rows'=> 		$this -> news_model -> getRowNum(),
			'per_page' => 		5,
			'uri_segment' => 	4,
			'num_links' => 		7,
			'full_tag_open' => 	'<ul class="paginList">',
			'full_tag_close' => '</ul>',
			'next_link' => 		'<span class="pagenxt"></span>',
			'next_tag_open' => 	'<li class="paginItem">',
			'next_tag_close' => '</li>',
			'prev_link' => 		'<span class="pagepre"></span>',
			'prev_tag_open' => 	'<li class="paginItem">',
			'prev_tag_close' => '</li>',
			'cur_tag_open'=> 	'<li class="paginItem current"><li class="paginItem current"><a href="javascript:;">',
			'cur_tag_close' => 	'</a></li>',
			'num_tag_open' =>	'<li class="paginItem">',
			'num_tag_close' => 	'</li>',
			);
		$this -> pagination -> initialize($config);
		$pagination = $this -> pagination -> create_links();

		$data = $this -> news_model -> getByPagin($config['per_page'], $page);
		$this -> load -> view('news/list_view', array('data' => $data, 'pagination' => $pagination));

	}

	//新闻列表有分类情况
	public function categoryLi($cId = 0, $cur_page = 0){
		$config = array(
			'base_url' => 		base_url('admin/news/categoryLi/' . $cId),
			'total_rows'=> 		$this -> news_model -> getRowNum($cId),
			'per_page' => 		20,
			'uri_segment' => 	5,
			'num_links' => 		7,
			'full_tag_open' => 	'<ul class="paginList">',
			'full_tag_close' => '</ul>',
			'next_link' => 		'<span class="pagenxt"></span>',
			'next_tag_open' => 	'<li class="paginItem">',
			'next_tag_close' => '</li>',
			'prev_link' => 		'<span class="pagepre"></span>',
			'prev_tag_open' => 	'<li class="paginItem">',
			'prev_tag_close' => '</li>',
			'cur_tag_open'=> 	'<li class="paginItem current"><li class="paginItem current"><a href="javascript:;">',
			'cur_tag_close' => 	'</a></li>',
			'num_tag_open' =>	'<li class="paginItem">',
			'num_tag_close' => 	'</li>',
			);
		$this -> pagination -> initialize($config);
		$pagination = $this -> pagination -> create_links();

		//get the category info
		$data = $this -> news_model -> getByCPagin($cId, $config['per_page'], $cur_page);

		if($this -> pagination -> cur_page == 0){
			$cur_page = 1;
		}else{
			$cur_page = $this -> pagination -> cur_page;
		}
		$data = array(
			'data' => 		$data,
			'pagination' => $pagination,
			'curPage' => 	$cur_page,
			'totalRows' => 	$config['total_rows'],
			'cId' =>		$cId,
			);

		//get category info 
		$cId = intval($cId);
		$data['categoryInfo'] = $this -> category_model -> getById($cId);

		$this -> load -> view('news/categoryLi_view', $data);
	}

	//新闻分类删除动作页面
	public function categoryDel($id){
		if($this -> news_category_model -> delByIds($id)){
			$msg = '删除新闻分类成功';
			$href = site_url('admin/news/categoryList');
		}else{
			$msg = '错误，删除新闻分类失败';
			$href = site_url('admin/news/categoryList');
		}
		$this -> yerror -> showYerror($msg, $href);
	}

	//新闻模块默认页面
	public function index(){
		$this -> load -> view('admin/frame_view');
	}

	//排序更改
	public function changeSort(){
		$sortArr = $this -> input -> post(null, TRUE);
		$this -> news_model -> reSort($sortArr);
		var_dump($sortArr);
	}

	//chage the satus of the news
	public function changeStatus(){
		$post = $this -> input -> post();
		if(!isset($post['newsid'])){
			exit(-1);
		}
		$newsId = intval($post['newsid']);
		$curNews = $this ->	news_model -> getById($newsId);
		// if(this -> )
		if($curNews['status'] == 1){
			$curNews = array('status' => 0);
		}else{
			$curNews = array('status' => 1);
		}
		if($this -> news_model -> update($newsId, $curNews)){
			echo $curNews['status'];
		}else{
			echo -1;
		}

	}

	//fileEdit
	public function fileEdit(){
		$post = $this -> input -> post();

		// $post['file-pic-describle'] = 'aligaduo';
		// $post['file-is-default'] = true;
		// $post['id'] = 1;
		$updata['title'] = isset($post['file-pic-describle']) ? $post['file-pic-describle'] : '';
		$updata['primary'] = isset($post['file-is-default']) && $post['file-is-default'] == 'true' ? 1 : 0;
		$id = isset($post['id']) ? $post['id'] : 0;

		if($updateResult = $this -> file_model -> updateById($updata, $id)){
			$updateResult['err'] = 0;
			echo json_encode($updateResult);
		}else{
			echo json_encode(array('err' => 1));
		}
	}

	//fileEdit get by Id
	public function fileGetById(){
		$post = $this -> input -> post();

		if(isset($post['id'])){
			$id = intval($post['id']);
		}else{
			exit(-1);
		}

		$result = $this -> file_model -> getByFileId($id);
		if($result){
			echo json_encode($result);
		}else{
			exit(-1);
		}
	}
}