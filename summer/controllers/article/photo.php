<?php

/**
 * 图片控制器
 */

class photo extends MY_Controller {

	public function __construct() {
		parent::__construct();

		$this->tpl = array(
			'browse' => 'v_01/article/photo_browse_view',
			'create' => 'v_01/article/photo_create_view',
		);

		$this->load->model('article_model');

		//初始化分页信息
		$this->pageNum = 15;
		//分页类载入
		$this->load->library('pagination');
		$this->load->library('JsonOutUtil');
		$this->load->model('news_category_model');
		$this->load->model('file_model');
		$this->jsonOutUtil = new JsonOutUtil();

		//potal
		$this->yPotal();
	}

	public function index() {
		$data['moduleName'] = '图片管理';
		$data['moduleDesc'] = '图片相关管理';

		$get = $this->input->get(NULL, TRUE);
        
		if(isset($get["category_id"])) {
			$cond["category_id"] = $get["category_id"];
        	$_POST["category_id"] = $get["category_id"];
		}
		if(isset($get["title"])) {
			$seach = trim($get["title"]);
			if($seach != "") {
				$cond["title"] = $get["title"];
	        	$_POST["title"] = $get["title"];
			}
		}

		$data["page"] = $this->article_model->getPages(0, 20, $cond);
        $data["categories"] = $this->news_category_model->find_by_type("image");

		$this->loadView("v_01/article/photo_browse_view", $data);
	}

	public function create() {
		$this->_data['content']['moduleName'] = '图片管理';
		$this->_data['content']['moduleDesc'] = '图片类管理';
		$post = $this->input->post();
		$get = $this->input->get();
		if ($post) {
			if ($lastInsertId = $this->article_model->create($post)) {
				$this->jsonOutUtil->resultOutString(true,
					array('msg' => '保存成功',
						'lastInsertId' => $lastInsertId));
				return;
			} else {
				$this->jsonOutUtil->resultOutString(false,
					array('msg' => '保存失败'));
			}
		} else {
			if (isset($get['id'])) {
				$this->_data['content']['article'] =
				$this->article_model->getOneById(intval($get['id']));
			}
			$this->_data['content']['categories'] = $this->news_category_model->getRecList();
			$this->_view($this->tpl['create']);
		}
	}

}