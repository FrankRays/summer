<?php
defined('BASEPATH') || exit('no direct script access allowed');

class Source_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function create($source) {
		$this->db->insert('summer_source', $source);
		return $this->db->insert_id();
	}
}