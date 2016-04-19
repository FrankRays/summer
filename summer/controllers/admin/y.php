<?php
defined('BASEPATH') || exit('no direct access');
/**
 * Created by PhpStorm.
 * User: ykjverx
 * Date: 2015/1/25
 * Time: 14:50
 */

class y extends Ykj_Controller{
    public function __construct(){
        parent::__construct();


    }

    public function index(){
        $userinfo = $this -> session -> userdata('userinfo');
        $this->_view('v_01/admin/main_view');
    }
}
