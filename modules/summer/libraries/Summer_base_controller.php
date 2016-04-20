<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* summer base controller
*/
class Summer_base_controller extends CI_Controller
{
	
	function __construct(argument)
	{
		parent::__construct();

		if(function_exists($this, '_init')) {
			$this->_init();
		}
	}
}