<?php defined('BASEPATH') || exit('no direct script access allowed'); 

class upload_file extends Ykj_Controller {

	public $uploadDir = "";
	public $allowedTypes = "";

	public function __construct(){
		parent::__construct();
		$this->uploadDir = dirname(BASEPATH)."/static/".date("Y/m/d");
		if(!file_exists($this->uploadDir)){
			mkdir($this->uploadDir, 0777, true);
		}
		$this->allowedTypes = "jpg|png|gif";
		$this->load->library('upload');

	}

	public function upload(){
		var_dump($_FILES);
		$this->upload->initialize(array('upload_path'=>$this->uploadDir, 'allowed_types'=>$this->allowedTypes));
		$this->upload->do_upload("imgfile");

		if(count($this->upload->error_msg) > 0) {
			echo $this->upload->display_errors();
		}
		echo 'summer';
	}

	public function uploadPage(){

		echo $this->uploadDir;
		$this->load->view('v_01/upload/index');
	}
}