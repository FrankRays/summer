<?php defined('APPPATH') or exit('no access');


/**
* base tree controller
*/
class Tree_Controller extends MY_Controller{

	protected $browse_view_path;

	protected $controller_name;

	//correspond tree model
	protected $main_model;

	function __construct(){
		parent::__construct();
	}


	public function browse() {
		$this->load->library('js_builder');
		$this->load->model('role_model');
		$children = $this->role_model->get_cascade_chidren('root');
		$this->js_builder->append_module_resource('ztree');
		$this->js_builder->append_module_resource('layer');
		$view_data['roletree'] = json_encode($children);
		$this->_load_view('default/user/privilege_view.php', $view_data);
	}

	public function create_child() {
		if($_POST) {
			$this->load->library('form_validation');
			$this->load->library('summer_view_message');
			$this->form_validation->set_rules('parent_name_hidden', '父节点名称', 'required|max_length[64]');
			$this->form_validation->set_rules('node_name', '节点名称', 'required|max_length[64]|is_unique['.$this->main_model->get_table_name().'.name]');

			if( ! $this->form_validation->run()) {
				$errors = $this->form_validation->error_array();
				$this->summer_view_message->set_flash_msg($errors, 'warning');
			} else {
				$parent_name = $this->input->post('parent_name_hidden', TRUE);
				$node_name = $this->input->post('node_name', TRUE);
				try {
					$node = new Tree_node();
					$node->name = stripslashes($node_name);

					$this->main_model->insert_child(stripcslashes($parent_name), $node);
					$this->summer_view_message->set_flash_msg('添加节点成功', 'success');
				} catch (Exception $e) {
					$this->summer_view_message->set_flash_msg($e->getMessage(), 'error');
				}
			}
		}

		redirect(site_url('c='.$this->controller_name.'&m=browse'));
	}

}