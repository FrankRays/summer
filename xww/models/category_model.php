<?php defined('BASEPATH') || exit('no direct script access allowed');

/**
*tree table
*@author ykjver
*@time 20141104
**/

class category_model extends CI_Model{

	//tableName
	public $tableName = '';

	//construct function
	public function __construct(){
		parent::__construct();

		$this -> tableName = 'news_category';
	}

	/**
	*Get category info by id
	*
	*@param   int|string  $categoryID
	*@param   string 	  $type
	*@access  public
	*@return  bool|array();
	**/
	public function getById($categoryID, $type = 'article'){

		//find by alias at first
		$where = array(
			'alias' => $categoryID,
			'type' 	=> $type,
			);
		$this -> db -> where($where);
		$this -> db -> select('*');
		$category = $this -> db -> get($this -> tableName) -> result_array();

		if( ! $category){
			$where =  array(
				'id' => 	$categoryID,
				'type' => 	$type,
				);

			$this -> db -> where($where);
			$this -> db -> select('*');
			$category = $this -> db -> get($this -> tableName) -> row_array();
		} 

		//if type quite forum the deal it
		return $category;
	}


	/**
	*Get category alias by id.
	*
	*@param   int 		$categoryID
	*@access  public
	*@return  string
	**/
	public function getAliasByID($categoryID){

	}

	/**
	*Get the first category
	*
	*@param   string   $type
	*@access  public
	*@return  array|boolean
	**/
	public function getFirst($type = 'article'){
		$this -> db -> select('*');
		$this -> db -> where('type', $type);
		$this -> db -> order_by('id');
		$result = $this -> db -> get($this -> tableName, 1) -> row_array();

		return $result;
	}

	/**
	*Get the id => name pairs of some categories
	*
	*@param   array   $categories   the category list
	*@param   string   $type         the type
	*@access  public
	*@return  array
	**/
	public function getPairs($categories = array(), $type = 'article'){
		$this -> db -> where('type', $type);
		if( ! empty($categories)){
			$this -> db -> where_in('id', $categories);
		}
		$this -> db -> select('id, name');

		return $this -> db -> get($this -> tableName) -> result_array();
	}

	/**
	*Get origin of the category
	*@param   int  $categoryID
	*@access  public 
	*@return  array
	**/
	public function getOrigin($categoryID){
		 if($categoryID == 0)  return array();

		 $this -> db -> where('id', $categoryID);
		 $this -> db -> select('path');
		 $path = $this -> db -> get($this -> tableName) -> row_array();
		 $path = $path['path'];
		 $path = trim($path, ',');
		 if( ! $path) return array();

		 $path = explode(',', $path);

		 $this -> db -> where_in('id', $path);
		 $this -> db -> select('id');
		 $categoryids = $this -> db -> get($this -> tableName) -> result_array();
		 

		 return $categoryids;
	}

	/**
	*Get id list of a family
	*
	*@param   int     	$categoryID
	*@param   string  	$type
	*@access  public
	*@return  array
	**/
	public function getFamily($categoryID, $type=''){
		if($categoryID == 0 || empty($type)) return array();
		$category = $this -> getById($categoryID);

		if($category){
			$this -> db -> like('path', $category['path'], 'after');
			$this -> db -> select('id');
			return $this -> db -> get($this -> tableName) -> result_array();
		}else{

			$this -> db -> where('type', $type);
			$this -> db -> select('id');
			return $this -> db -> get($this -> tableName) -> result_array();
		}
	}

	/**
	*Get children cateogries of one cateogry
	*@param   int 		$cateogryID
	*@param   string 	$type
	*@access  public
	*@return array
	*
	**/
	public function getChildren($categoryID, $type=''){
		$this -> db -> select('*');
		$where = array(
			'fid' => intval($cateogryID),
			'type' => $type,
			);
		$this -> db -> where($categoryID);
		$this -> db -> order_by('sort');
		return $this -> db -> get($this -> tableName) -> result_array();
	}


}