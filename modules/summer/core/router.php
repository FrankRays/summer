<?php

/**
 * summer rooter
 */

class Summer_Router extends CI_Router{

	public function _set_request($segment = array()) {
		// $this->directory = SUMMER_PATH . 'controllers/';
		// if(count($segment) == 0) {
		// 	$this->_set_default_controller();
		// }
		// $this->set_class($segment[0]);
		// if(isset($segment[1])) {
		// 	$this->set_method($segment[1]);
		// }else{
		// 	$segment[1] = 'index';
		// }

		// $this->uri->rsegments = $segment;
		parent::_set_request($segment);
	}
}