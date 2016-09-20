<?php defined('BASEPATH') OR exit('No direct script access allowed');



class File extends MY_Controller {

	public $is_ajax = TRUE;

	public function __construct() {
		parent::__construct();

		$this->load->model('user_model');

		$this->load->library('upload');
		$this->load->library('image_lib');

	}


	public function articlePhoto() {

		//create upload file
		$this->config->load('snowConfig/admin');
		$fileCfg = $this->config->item('upload', 'snowConfig/admin');
		$resPath = date('Y/m');
		$resPath = trim($fileCfg['resource_path'], '/').'/'.$resPath.'/';
		$resPath = str_replace('\\', '/', $resPath);
		if( ! file_exists($resPath)) {
			mkdir($resPath, 0644, true);
		}

		//initialize upload model
		$uploadCfg = array(
			'upload_path' => $resPath,
			'allowed_types' => array('gif', 'png', 'jpg'),
			'max_size' => 20480,
			'encrypt_name' => true,
			);
		$this->upload->initialize($uploadCfg);
		if(!$this->upload->do_upload('file')) {
			//upload file error immediatly return;
			$error = $this->image_lib->display_errors();
			echo '{"status":404, "message" :"'.$error.'" }"';
			return ;
		}else{

			//get thumb image
			$file = $this->upload->data();

			//foreach for create thumb image
			$index = 0;
			$imagePathInfo = pathinfo($file['full_path']);
			$firstThumbPath = $file['full_path'];

			$thumbCfg['source_image'] = $file['full_path'];
			$thumbCfg['width'] = 960;
			$thumbCfg['height'] = 640;
			$thumbCfg['new_image'] = $imagePathInfo['dirname'] . '/' . $imagePathInfo['filename'] . '_';
			$thumbCfg['new_image'] .= $thumbCfg['width'] . 'x' . $thumbCfg['height'] . '.' . $imagePathInfo['extension'];
			$this->image_lib->initialize($thumbCfg);
			if( ! $this->image_lib->resize()) {
				$error = $this->image_lib->display_errors();
				echo '{"status":404, "message" :"'.$error.'" }"';
				return ;
			}else{
				$return['file_uri'] = str_replace(dirname(str_replace("\\", "/", APPPATH)), '', $thumbCfg['new_image']);
				$return['file_uri'] = base_url($return['file_uri']);
			}
			$return['file_name'] = $file['file_name'];
			$return['file_ext'] = $file['file_ext'];
			echo json_encode($return);
		}
		
	}


	function uEditorUpload(){
		$this->user_model->is_admin();
		//set utf8 http header
		header("Content-Type: text/html; charset=utf-8");

		//get backend config to frondend
		$UE_PATH = APPPATH.'third_party/ueditor/';
		$CONFIG = file_get_contents($UE_PATH.'config.json');
		$CONFIG = json_decode(preg_replace('/\/\*[\s\S]+?\*\//', '', $CONFIG), true);

		$action = $this->input->get('action');

		switch ($action) {
		    case 'config':
		        $result =  json_encode($CONFIG);
		        break;

		    /* 上传图片 */
		    case 'uploadimage':
		    /* 上传涂鸦 */
		    case 'uploadscrawl':
		    /* 上传视频 */
		    case 'uploadvideo':
		    /* 上传文件 */
		    case 'uploadfile':
		        $result = include($UE_PATH."action_upload.php");
		        break;

		    /* 列出图片 */
		    case 'listimage':
		        $result = include($UE_PATH."action_list.php");
		        break;
		    /* 列出文件 */
		    case 'listfile':
		        $result = include($UE_PATH."action_list.php");
		        break;

		    /* 抓取远程文件 */
		    case 'catchimage':
		        $result = include($UE_PATH."action_crawler.php");
		        break;

		    default:
		        $result = json_encode(array(
		            'state'=> '请求地址出错'
		        ));
		        break;
		}

		/* 输出结果 */
		if (isset($_GET["callback"])) {
		    if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
		        echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
		    } else {
		        echo json_encode(array(
		            'state'=> 'callback参数不合法'
		        ));
		    }
		} else {
		    echo $result;
		}
	}
	
}