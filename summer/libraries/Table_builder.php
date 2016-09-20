<?php

defined("APPPATH") or exit("no access");


/**
* 
*/
class Table_Builder {

	public $CI;

	public $primary_index = "id";

	public $del_btn_id = "#del_btn";

	public $table_name = "";

	public $controller_name = "";
	
	public function __construct($argument=array()){
		
		$this->CI = &get_instance();

		if( ! isset($this->CI->js_builder) or is_null($this->CI->js_builder)) {
			$this->CI->load->library('js_builder');
			$this->js_builder = &$this->CI->js_builder;
		}

		$this->controller_name = $argument['controller_name'];
	}


	public function display() {

		$this->_create_table_del_js_code();
	}


	public function initialize($argument=array()) {

	}


	/*
	 //删除文章事件
    $("#summer-del-article-btn").on('click', function(e){
      var articleIds = [];
      var checkbox = $("[name=article_id]:checked"); 
      if(checkbox.length == 0) {
        alert('请勾选删除文章');
        return ;
      }
      checkbox.each(function(){
        articleIds.push(this.value);
      });

      var href = '<?=site_url('c=post&m=del')?>&article_ids=' + articleIds.join('_');
      document.location.href = href;
    });
	 */
	public function _create_table_del_js_code() {
		$js_code = '$("' . $this->del_btn_id . '").on("click", function(e){';
		$js_code .= 'var articleIds = [];var checkbox = $("[name=' . $this->primary_index .']:checked");';
		$js_code .= 'if(checkbox.length == 0) {alert(" Please select the delete entity !");return ;}';
		$js_code .= 'checkbox.each(function(){articleIds.push(this.value);});';
		$js_code .= 'var href = "' . site_url("c=" . $this->controller_name. "&m=del") . '&ids=" + articleIds.join("_");';
		$js_code .= 'document.location.href = href;});';

		$this->js_builder->append_source_code($js_code);
	}
}
