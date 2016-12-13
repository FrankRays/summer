<?php defined('APPPATH') OR exit('no access');


class Visitor_Model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function record_visitor($type, $value) {
		//record visitor to create a cookie to he
        $visitor_cookie_id = get_cookie("vci", true);
        if($visitor_cookie_id === NULL) {
            $visitor_cookie_id = base64_encode(microtime() . "_" . rand(0, 1000));
            set_cookie("vci", $visitor_cookie_id, time() + 315360000); //10 years expire
        }
        $insert_visitor_data = array(
            'vci'=>$visitor_cookie_id,
            'ip_addr'=>$this->input->ip_address(),
            'type'=>$type,
            'type_value'=>$type,
            );
        $this->db->insert(TABLE_VISITOR, $insert_visitor_data);
	}

	public function get_visitor_cookie_id() {
		return $visitor_cookie_id = get_cookie("vci", true);
	}
}