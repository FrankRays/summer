<?php defined('BASEPATH') || exit('no direct script access allowed');


//v2 幻灯片model类
//
class Slider_Model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}
	
	//获取列表
	public function get_list($limit, $offset, $cond=array()) {
		$where = array(
			'is_delete'		=> '0',
			);
		$sliders = $this->db->from(TABLE_SLIDER)->where($where)->limit($limit, $offset)->get()->result_array();
		return $sliders;
	}

	//获取分页
	public function get_page($limit, $offset, $cond=array()) {
		$where = array(
			'is_delete'		=> '0',
			);

		$this->db->start_cache();
		$this->db->from(TABLE_SLIDER)->where($where);
		$this->db->stop_cache();

		$this->db->limit($limit, $offset);
		$data_list = $this->db->order_by('order_id asc, id desc')->get()->result_array();
		$total_rows = $this->db->count_all_results();

		return array(
			'data_list'		=> $data_list,
			'total_rows'	=> $total_rows,
			);
	}

	public function create() {
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
					'rules'		=> 'required|valid_url',
					),
				)
			);

		if(! $this->form_validation->run()) {
			return FALSE;
		}

		if(! isset($_FILES['img_path']) or empty($_FILES['img_path'])) {
			$this->form_validation->set_error_array(array('上传图片不能为空'));
			return FALSE;
		}

		$upload_config = $this->config->item('upload_config');
		$resource_upload_path = $this->config->item('resource_upload_path');
		$upload_config['upload_path'] = make_upload_dir();

		$this->load->library('upload', $upload_config);
		if($this->upload->do_upload('img_path')) {
			$upload_data = $this->upload->data();

			$source_image = $upload_data['full_path'];

			$resize_img_config = $this->config->item('resize_img_config');
			$resize_img_config['source_image'] = $source_image;
			$this->load->library('image_lib', $resize_img_config);
			$this->image_lib->resize();

			$relative_path = str_replace($resource_upload_path, '', $source_image);
			$relative_path = 
			str_replace($upload_data['file_ext'], '_thumb' . $upload_data['file_ext'], $relative_path);

			$insert_slider = array(
				'title' 		=> $this->input->post('title', TRUE),
				'href'			=> $this->input->post('href'),
				'img_path'		=> $relative_path,
				'create_time'	=> date(TIME_FORMAT),
				'cat_id'		=> 1,
				'is_delete'		=> '0',
				);

			$this->db->insert(TABLE_SLIDER, $insert_slider);
			return $this->db->insert_id();
		}

		return FALSE;
	}

	public function update() {

		$slider_id = $this->input->post('slider_id');
		if(empty($slider_id)) {
			show_404();
		}else{
			$slider_id = intval($slider_id);
		}
		
		if( ! $this->_check_slide_form()) {
			return FALSE;
		}

		$update_slider = array(
			'title' 		=> $this->input->post('title', TRUE),
			'href'			=> $this->input->post('href'),
			);

		if(isset($_FILES['img_path']) and ! empty($_FILES['img_path'])) {
			//update image
			$relative_path = $this->_upload_slide_img();
			if($relative_path !== FALSE) {
				$update_slider['img_path'] = $relative_path;
			}
		}

		$this->db->where('id', $slider_id)->update(TABLE_SLIDER, $update_slider);
		return TRUE;

	}

	private function _check_slide_form() {
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
					'rules'		=> 'required|valid_url',
					),
				)
			);

		if(! $this->form_validation->run()) {
			return FALSE;
		}else{
			return TRUE;
		}
	}

	private function _upload_slide_img() {		

		$upload_config = $this->config->item('upload_config');
		$resource_upload_path = $this->config->item('resource_upload_path');
		$upload_config['upload_path'] = make_upload_dir();

		$this->load->library('upload', $upload_config);
		if($this->upload->do_upload('img_path')) {
			$upload_data = $this->upload->data();

			$source_image = $upload_data['full_path'];

			$resize_img_config = $this->config->item('resize_img_config');
			$resize_img_config['source_image'] = $source_image;

			$this->load->library('image_lib', $resize_img_config);


			$relative_path = str_replace($resource_upload_path, '', $source_image);
			if($this->image_lib->resize()) {
				$relative_path = 
				str_replace($upload_data['file_ext'], '_thumb' . $upload_data['file_ext'], $relative_path);
			}
			return $relative_path;
		}
		return FALSE;
	}

}