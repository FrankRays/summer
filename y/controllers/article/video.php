<?php

class Video extends Ykj_Controller{

	public function __construct(){
		parent::__construct();

		$this -> tpl = array(
			'browse' => 'v_01/article/video_browse_view',
            'create' => 'v_01/article/video_create_view'
			);

		$this -> load -> model('article_model');

        //初始化分页信息
        $this -> pageNum = 15;
        //分页类载入
        $this -> load -> library('pagination');
        $this -> load -> library('JsonOutUtil');
        $this -> load -> model('news_category_model');
        $this -> load -> model('file_model');
        $this -> jsonOutUtil = new JsonOutUtil();

        //potal
        $this -> yPotal();
	}


	public function index(){
		$this -> _data['content']['moduleName'] = '视频管理';
		$this -> _data['content']['moduleDesc'] = '视频相关的模块管理';
        $this -> _data['sidebar'] = array();
        $this -> _data['foot'] = array();

        $get = $this -> input -> get();

        $category_id = 6;
        $page = isset($get['page']) && is_numeric($get['page']) ?
        	(intval($get['page']) - 1) : 0;
        $this -> _data['content']['pagination']
            = $this -> _getPaginationStr($this -> article_model -> 
            	getTotalByCond(array('category_id' => $category_id)));

		$paginationConfig = $this -> config -> item('paginationConfig', 'snowConfig/admin');
        $this -> _data['content']['articles'] = 
        	$this -> article_model -> getByCond($paginationConfig['per_page'],
        		($page * $paginationConfig['per_page']),
        		array(
        			'category_id' => $category_id
        			));

        $this -> _view($this -> tpl['browse']);
	}

	public function create(){
        $this -> _data['content']['moduleName'] = '图片管理';
        $this -> _data['content']['moduleDesc'] = '图片类管理';
        $this -> _data['sidebar'] = array();
        $this -> _data['foot'] = array();

		$post = $this -> input -> post();
        $get = $this -> input -> get();
        if($post){
        $post['category'] = 6;
        $post['is_video'] = 1;
        	if(isset($post['id']) && !empty($post['id'])){
        		$lastInsertId = $this -> article_model -> create($post);
        		if($lastInsertId){
		            $this -> jsonOutUtil -> resultOutString(true,
		                array('msg' => '保存成功', 'id' => $lastInsertId));
		        }else{
		            $this -> jsonOutUtil -> resultOutString(true,
		                array('msg' => '保存失败'));
		        }
        	}else{
       			$post['status'] = 1;
        		$lastInsertId = $this -> article_model -> create($post);
        		if($lastInsertId){
		            $this -> jsonOutUtil -> resultOutString(true,
		                array('msg' => '保存成功', 'id' => $lastInsertId));
		        }else{
		            $this -> jsonOutUtil -> resultOutString(true,
		                array('msg' => '保存失败'));
		        }
        	}
        	return ;
        }
        if(isset($get['id'])){
			$id = intval($get['id']);
			$article = $this -> article_model -> getOneById($id);
			$this -> _data['content']['article'] = $article;
        }

        $this -> _view($this -> tpl['create']);
	}
}