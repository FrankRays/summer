<?php
	
class Slider extends MY_Controller{
	//模板数组
	private $tpl;

	public function __construct(){
		parent::__construct();

		$this -> tpl = array(
			'browse' => '',
			'create' => ''
			);

		//初始化分页信息
		$this -> pageNum = 15;
		//载入工具类
		$this -> load -> library('pagination');
		$this -> load -> model('config_model');
		$this->load->helper('summer_view');
	}

	public function index(){

		$p_cfg = $this->config->item('paginationConfig', 'snowConfig/admin');

		$get = $this->input->get();
		$offset = isset($get['offset']) && is_numeric($get['offset']) ? intval($get['offset']) : 0;
		$limit = isset($get['limit']) && is_numeric($get['limit']) ? intval($get['limit']) : $p_cfg['per_page'];

		$cond = array(
		// 	'section' => 'sliders',
			);

		$page = $this->config_model->get_page($offset, $limit, $cond);

		//create pagination links
		$base_url = array();
		if(isset($get['offset'])) {
			unset($get['offset']);
		}
		foreach($get as $k => $v) {
			$base_url[] = $k . '=' . $v;
		}

		$p_cfg['base_url'] = site_url(implode($base_url, '&'));
		$p_cfg['total_rows'] = $page['count'];
		$this->pagination->initialize($p_cfg);

		//{'picSrc', 'linkSrc', 'summary'}
		$view_data_list = array();
		foreach($page['data_list'] as $v) {
			if(isset($v['value'])) {
				$value = json_decode($v['value'], true);
				if( ! is_array($value)) {
					break;
				}

				$view_data_list[] = array(
					'id'		=> $v['id'],
					'section'	=> $v['section'],
					'name'		=> isset($value['name']) ? $value['name'] : '',
					'pic_src'	=> isset($value['picSrc']) ? $value['picSrc'] : '',
					'link_src'	=> isset($value['linkSrc']) ? $value['linkSrc'] : '',
					'summary'	=> isset($value['summary']) ? $value['summary'] : '',
					);
			}
		}

		$data = array(
			'module_name' 	=> '幻灯片管理',
			'module_desc'	=> '首页幻灯片管理',
			'data_list'		=> $view_data_list,
			'count'			=> $page['count'],
			'pagination'	=> $this->pagination->create_links(),
			);

		$this->_loadView('v_01/config/slider_browse_view', $data);
	}


	public function create(){

		$post = $this->input->post();
		if($post){
			//save the slider img
			$this->config->load('snowConfig/form_validation', TRUE);
			$form_validation_config = $this->config->item('form_validation', 'snowConfig/form_validation');
			$this->load->library('form_validation', $form_validation_config);
			$this->form_validation->set_rules('name', '图片名称', 'required');
			$this->form_validation->set_rules('picSrc', '上传图片', 'required');

			if( ! $this->form_validation->run()) {
				$data = array(
					'moduleName' => '幻灯片添加',
					'moduleDesc' => '首页幻灯片添加',
					);
				$this->_load_view('v_01/config/slider_create_view', $data);
				return ;
			}

			$module = $this->input->post('module', TRUE);
			if(empty($module)) {
				$module = 'default';
			}

			$id = $this->input->post('id');
			$id = intval($id);
			$name 		= $this->input->post('name', TRUE);
			$link_src 	= $this->input->post('linkSrc', TRUE);
			$pic_src 	= $this->input->post('picSrc', TRUE);

			$value = array(
				'name'		=> $name,
				'linkSrc'	=> $link_src,
				'picSrc'	=> $pic_src,
				'summary'	=> '',
				);

			//update slider
			if(isset($post['id']) && ! empty($post['id'])) {

				$slider = array(
					'value' => json_encode($value)
					);

				var_dump($value);
				$affected_rows = $this->config_model->update($slider, $id);

				setFlashAlert(200, $this->lang->line('slider_save_success'));
			}else{
				//insert new slider
				$slider = array(
					'owner'		=> 'ykjver',
					'section'	=> 'sliders',
					'module'	=> 'default',
					'value'	=> json_encode($value),
					);
				$this->config_model->create($slider);

				setFlashAlert(200, $this->lang->line('slider_save_success'));
			}
			redirect(site_url('d=config&c=slider&m=index'));
			return ;
		}else{
			//slider img page
			$id = $this->input->get('id');
			if(empty($id)) {
				$data = array(
					'moduleName'	=> '幻灯片添加',
					'moduleDesc'	=>	'首页幻灯片添加',
					);
				$this->_load_view('v_01/config/slider_create_view', $data);
				return ;
			}else{
				$id = intval($id);
			}

			//get the slider by id
			$slider = $this->config_model->getById($id);
			if(!empty($slider)) {
				$slider['value'] = json_decode($slider['value'], TRUE);

				$inputData = array(
					'id' => $slider['id'],
					'name' => $slider['value']['name'],
					'picSrc' => $slider['value']['picSrc'],
					'linkSrc' => $slider['value']['linkSrc'],
					'summary' => isset($slider['value']['summary']) ? $slider['value']['summary'] : '',
					);

				$_POST = array_merge($inputData, $_POST);
			}
		}

		$data = array(
			'inputData' => $inputData,
			'moduleName' => '幻灯片管理',
			'moduleDesc' => '首页幻灯片管理',
			);

		$this->_loadView('v_01/config/slider_create_view', $data);
	}

	public function del(){
		$get = $this -> input -> get();
		if(isset($get['id'])){
			$this -> config_model -> del($get['id']);
			setFlashAlert(200, $this->lang->line('slider_delete_success'));
		}else{
			setFlashAlert(500, $this->lang->line('slider_delete_fail'));
		}
		redirect(site_url('d=config&c=slider&m=index'));
	}

}