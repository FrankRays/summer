<?php defined('BASEPATH') || exit('no direct script access allowed');


//v2 幻灯片控制器
class Slider extends MY_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('slider_model');
		$this->load->model('file_model');
		$this->load->model('user_model');
	}

	public function index() {
		echo 'slider index';
	}

	public function admin() {
		if(! defined('ADMIN') || $this->_verify()) redirect('c=user&m=login');
		$view_data['module_name'] = '幻灯片列表';
		$view_data['bread_path'] = get_module_path(array(
			array('幻灯片列表', site_url('c=slider&m=admin')),
		 	));

		$offset = $this->input->get('offset');
		if(empty($offset) || ! is_numeric($offset)) {
			$offset = 0;
		}else{
			$offset = intval($offset);
		}

		$page_config = $this->config->item('page_config');

		$page = $this->slider_model->get_page($page_config['per_page'], $offset);

		$page_config['base_url'] = deal_page_base_url();
		$page_config['total_rows'] = $page['total_rows'];
		$this->pagination->initialize($page_config);

		$page_links = $this->pagination->create_links();
		$view_data['data_list'] = $page['data_list'];
		$view_data['total_rows'] = $page['total_rows'];
		$view_data['page_links'] = $page_links;
		$this->_load_view('default/slider_browse_view.php', $view_data);

	}

	public function create() {
		if( ! defined('ADMIN') or ! $this->user_model->is_admin()) redirect('c=user&m=login');
		$view_data['module_name'] = '幻灯片添加';
		$view_data['bread_path'] = get_module_path(array(
			array('幻灯片列表', site_url('c=slider&m=admin')),
		 	array('添加幻灯片', '#')));
		$view_data['post_url'] = site_url('c=slider&m=create');

		if($_POST) {
			if($this->slider_model->create()) {
				redirect(site_url('c=slider&m=admin'));
			}else{
				$this->form_validation->set_error_array(array('新增幻灯片失败'));
			}
		}

		$this->_load_view('default/slider_form_view', $view_data);
	}

	public function edit() {
		$this->user_model->is_admin();
		$view_data['module_name'] = '幻灯片编辑';
		$view_data['bread_path'] = get_module_path(array(
			array('幻灯片列表', site_url('c=slider&m=admin')),
		 	array('编辑幻灯片', '#')));
		$view_data['post_url'] = site_url('c=slider&m=edit');


		$slider_id = $this->input->get('slider_id');
		if(empty($slider_id)) {
			$slider_id = $this->input->post('slider_id');
		}
		if(empty($slider_id)) {
			show_error('幻灯片ID错误');
		}

		$slider_id = intval($slider_id);

		if($_POST) {
			if($this->slider_model->update()) {
				set_flashalert('修改幻灯片成功');
				redirect('c=slider&m=admin');
			}
		}

		$where = array(
			'is_delete'		=> '0',
			'id'			=> $slider_id,
			);
		$slider = $this->db->from(TABLE_SLIDER)->where($where)->get()->row_array();
		if(empty($slider)) {
			show_error('幻灯片不存在');
		}

		$_POST = $slider;

		$this->_load_view('default/slider_form_view', $view_data);
	}

	public function del() {
		$slider_id = $this->input->get('slider_id');
		var_dump($slider_id);
		if(empty($slider_id) || ! is_numeric($slider_id)) {
			$slider_id = 0;
		}else{
			$slider_id = intval($slider_id);
		}


		$this->db->from(TABLE_SLIDER)->where(array('id'=>$slider_id))->delete();
		if($this->db->affected_rows()) {
			set_flashalert('删除幻灯片成功');
		}else{
			set_flashalert('删除幻灯片失败');
		}

		redirect(site_url('c=slider&m=admin'));
	}

	//v2 检查表单
	public function _check_form() {
		$this->form_validation->set_rules(
			array(
				array(
					'field'		=> 'title',
					'label'		=> '标题',
					'rules'		=> 'required',
					),
				array(
					'field'		=> 'href',
					'label'		=> '连接',
					'rules'		=> 'valid_url',
					),
				)
			);

		if($this->form_validation->run()) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

}