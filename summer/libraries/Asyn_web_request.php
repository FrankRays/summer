<?php defined('APPPATH') or exit('no access');

class Asyn_web_request extends Thread {
	public $url;
	public $data;

	public function __construct($url) {
		$this->url = $url;
	}

	public function run() {
		if($url = $this->url){
			$CI = &get_instance();
			$CI->article_model->create_index_article($url);
		}else{
			printf('Thread #%ul was not provided a URL \n', $this->getThreadId());
		}
	}
}