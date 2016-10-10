<?php defined('APPPATH') or exit('no access');

require APPPATH.'core'.DIRECTORY_SEPARATOR.'Tree_Controller.php';

class Role extends Tree_Controller {

	public function __construct() {
		parent::__construct();
		$this->browse_view_path = 'default/user/privilege_view';

		$this->controller_name = strtolower(__CLASS__);
		$this->load->model('role_model');
		$this->main_model = &$this->role_model;
		$this->load->vars('controller_name', $this->controller_name);
		$this->browse_url = site_url('c='.$this->controller_name.'&m=browse');
	}

}