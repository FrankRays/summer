<?php defined('BASEPATH') || exit('no direct script access allowed');

/**
*YYCMS
*manage the tree of the news category
*@author ykjver
*@time 2014-11-4
**/



class category extends Ykj_Controller{

	//tableName
	public $tableName = '';

	public function __construct(){
		parent::__construct();

		$this -> tableName = 'news_category';
	}

	public function index(){
		echo $this -> tableName;
	}
}