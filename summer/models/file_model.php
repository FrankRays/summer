<?php defined('BASEPATH') || exit('no direct access script allowed');


class file_model extends CI_Model{

	//table name
	public $tableName = '';
	//filepaht
	public $filePath = '';
	//function __construct
	public function __construct(){
		parent::__construct();

		$this -> tableName = 'file';
		$this -> filePath = dirname(BASEPATH).'/ysource/';
	}


	/**
	*add 
	*@param array file data
	*@return int last insert id  
	**/

	public function add($data = ''){
		if(empty($data)) return FALSE;

		$this -> db -> insert($this -> tableName, $data);
		if($insertId = $this -> db -> insert_id()){
			return $insertId;
		}else{
			return FALSE;
		}
	}

	//v2 添加用户
	public function create($file) {
		$this->db->insert(TABLE_FILE, $file);
		return $this->db->insert_id();	
	}

	/**
	*getByObjId
	*@param int $objId 	id of the files
	*@param int $offset page begin
	*@param int $num 	num of the this page
	*@param string $order 	order of the list
	*@return array list of the file get 
	**/
	public function getByObjId($objId = '', $limit = null, $offset = null, $order = ''){
		if($objId == '') return FALSE;
		$objId = intval($objId);

		$this -> db -> where('ObjectId', $objId);
		$this -> db -> select('*');

		$query = $this -> db -> get($this -> tableName, $limit, $offset);
		$result = $query -> result_array();

		return $result;
	}


	/**
	*upload file add picture
	*@return array Info of upload data
	**/
	public function upload(){
		$filesInfo = $this -> uploadFile();
		if(empty($filesInfo)) return FALSE;

		//get userInfo
		$CLogin = $this -> session -> userdata('Clogin');
		if(empty($CLogin['username'])){
			$username = 'admin';
		}else{
			$username = $CLogin['username'];
		}

		//if is the image the deal it 
		if($this -> dealImage($filesInfo)) return FALSE;

		//get the newsid to Object Id
		$objId = $this -> input -> post('objId');

		//insert the upload file info to the database
		$addFileIds = array();
		if( ! $filesInfo){
			return FALSE;
		}
		foreach($filesInfo as $k => $v){
			$title = $this -> input -> post($k);
			if(empty($title)){
				$title = pathinfo($_FILES[$k]['name']);
				$title = $title['filename'];
			}
			

			$filesList = array(
				'pathname' 	=> 	'ysource/'.date('Ymd').'/'.$v['file_name'],
				'title'    	=>	$title,
				'extension' => 	$v['file_ext'],
				'size'		=>	$v['file_size'],
				'width'		=>	$v['image_width'],
				'height'	=>	$v['image_height'],
				'objectType' =>	'article',
				'objectID' 	=>	$objId,
				'addedDate'	=>	time(),
				'extra' 	=> 	'',
				'addedBy' 	=>	$username,
				);

			$addFileIds[$k] = $this -> add($filesList);
		}
		///var_dump($addFileIds);

		//return the info of the upload file  

		return $objId;
	}

	public function upload_img() {


	}

	/**
	*uploadfile
	*@return array the info list of the uploadfile
	**/
	public function uploadFile(){
		$this -> load -> library('upload');

		$uploadConf = array(
			'encrypt_name' => TRUE,
			);

		$files = $_FILES;
		$filesInfo = array();
		$this -> upload -> initialize($uploadConf);

		$this -> upload -> set_allowed_types('jpg|zip|png|gif|rar|doc|docx|htm');
		$upload_path = dirname(BASEPATH).'/ysource/';

		if(! file_exists($upload_path)){
			if( ! mkdir($upload_path)){
				return FALSE;
			}
		}

		$upload_path .= date('Ymd');
		if(! file_exists($upload_path)){
			if( ! mkdir($upload_path)){
				return FALSE;
			}
		}

		$this -> upload -> set_upload_path($upload_path);
		foreach ($files as $key => $value) {
			if( ! empty($files[$key]['name'])){
				if( ! $this -> upload -> do_upload($key)){
					return FALSE;
				}
				$filesInfo[$key] = $this -> upload -> data();
			}
		}
		echo $this -> upload -> display_errors();
		return $filesInfo;
	}

	/**
	*dealImage
	*@param array $filesInfo the info list of the image list
	*@return
	**/
	public function dealImage($filesInfo = ''){
		if( ! is_array($filesInfo)) return FALSE;

		foreach ($filesInfo as $key => $value) {
			if($value['is_image']){
				$this -> resizeImage($value);
				$this -> resizeImage($value, 200, 's_');
			}
		}
	}


	/**
	*resizeImage
	*@param $data array  array of the image info data
	*@param $size int 	the width of the resize image 
	*@param $prefix string the prefix of the resize image file 
	*@return boolean   stand resize if successful
	**/
	public function resizeImage($data = '', $size = 500, $prefix='m_'){
		if( ! is_array($data)) return FALSE;

		$this -> load -> library('image_lib');
		$imageConf = array(
			'source_image' 	=> $data['full_path'],
			'new_image' 	=> $prefix.$data['file_name'],
			);
		if($data['image_height'] > $size || $data['image_width'] > $size){
			if($data['image_height'] > $data['image_width']){
				$b = $data['image_width'] / $data['image_height'];
				$imageConf['width'] = $size * $b;
				$imageConf['height'] = $size;
			}else{
				$b = $data['image_height'] / $data['image_width'];
				$imageConf['width'] = $size;
				$imageConf['height'] = $size * $b;
			}
		}

		if( ! $this -> image_lib -> initialize($imageConf)){
			return FALSE;
		}

		if( ! $this -> image_lib -> resize()){
			return FALSE;
		}

		return TRUE;
	}


	/**
	*delete file
	**/
	public function deleteByFileId($fileId = ''){
		if($fileId == '') return FALSE;

		$FileId = intval($fileId);
		$fileInfo = $this -> getByFileId($fileId);
		//var_dump($fileInfo);

		$result = $this -> deleteFile($fileInfo);
		if($result != FALSE){
			echo 'successful';
		}else{
			echo 'fail';
		}

	}

	/**
	*delete file
	**/
	public function deleteFile($fileInfo = ''){

		if($fileInfo == '') return FALSE;
		$fileName = $fileInfo['pathname'];
		$baseName = dirname(BASEPATH).'/';
		$fileNameHead = substr($fileName, 0, strrpos($fileName, '/') + 1);
		$fileNameTail = substr($fileName, strrpos($fileName, '/') + 1);

		$bFileName = $baseName.$fileName;
		$mFileName = $baseName.$fileNameHead.'m_'.$fileNameTail;
		$sFileName = $baseName.$fileNameHead.'s_'.$fileNameTail;
		
		if( ! $this -> deleteInfoById($fileInfo['id'])){
			return FALSE;
		}

		if(is_file($bFileName)){
			if(!unlink($bFileName)){
				return FALSE;
			}
		}else{
			return FALSE;
		}

		//delete the m image
		if(is_file($mFileName)){
			if(!unlink($mFileName)){
				return FALSE;
			}
		}

		//delete the s image
		if(is_file($sFileName)){
			if(!unlink($sFileName)){
				return fALSE;
			}
		}
		echo 'asd';
		
		return TRUE;
	}

	/**
	*delete file Data
	*
	**/
	public function deleteInfoById($fileId = ''){
		if($fileId == '') return FALSE;

		$fileId = intval($fileId);
		$this -> db -> where('id', $fileId);
		if($this -> db -> delete($this -> tableName)){
			return TRUE;
		}else{
			return FALSE;
		}
	}


	/**
	*getByFileId
	**/
	public function getByFileId($FileId  = ''){
		if($FileId == '') return FALSE;

		$FileId = intval($FileId);
		$this -> db -> where('id', $FileId);
		$this -> db -> select('*');
		$query = $this -> db -> get($this -> tableName, 1);
		$result = $query -> row_array();
		if($result){
			return $result;
		}else{
			return FALSE;
		}
	}

	/**
	*getImageFromContent
	**/
	public function getImageFromContent($content = '', $objectId = ''){
		if($content == '' || $objectId == '') return FALSE;
		$objectId = intval($objectId);

		preg_match_all('/<img.+?src="(.+?)".+?\/>/i', $content, $match);

		if(isset($match[1]) && ! empty($match[1])){
			foreach ($match[1] as $key => $value) {
				if(!$this -> hasFile($value)){
					$this -> add(array(
						'pathname' => $value,
						'objectID' => $objectId,
						'objectType' => 'articleContent',
						'addedDate'	=>	time(),
						));
				}
			}
		}else{
			return FALSE;
		}
		
		return ture;
	}

	/**
	*hasFile
	**/
	public function hasFile($pathName = '', $objectId = ''){
		if($pathName == '' || $objectId == '') return FALSE;

		$where = array(
			'pathname' => $pathname,
			'objectId' => $objectId,
			);
		$this -> db -> where($objectId);
		$this -> db -> select('*');
		$result = $this -> db -> get($this -> tableName) -> row_array();
		if($result){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	//update file
	public function updateById($data, $id){
		$id = intval($id);
		$this -> db -> where(array('id' => $id));
		if($this -> db -> update($this->tableName, $data)){
			return $this -> getByFileId($id);
		}else{
			return false;
		}
	}

	//set default img By id 
	public function setDefaultImg($fileId, $objId){
		$fileId = intval($fileId);
		$objId = intval($objId);

		$fileList = $this -> getByObjId($objId);
		$notDefaultArr = array();
		foreach ($fileList as $key => $value) {
			if($value['id'] == $fileId){
				unset($fileList[$key]);
			}else{
				array_push($notDefaultArr, $value['id']);
			}
		}

		$this -> db -> where(array('id' => $fileId));
		$this -> db -> update($this -> tableName, array('primary' => '1'));

		$this -> db -> where_in('id', $notDefaultArr);
		$this -> db -> update($this -> tableName, array('primary' => '0'));

		$fileList = $this -> getByObjId($objId);
		return $fileList;
	}


	//v2 更具objectid获取图片
	public function get_imgs_by_object_id($object_id) {
		$where = array(
			'object_id'		=> $object_id,
			'object_type'	=> 'article',
			'width <>'		=> 0,
			);

		$files = $this->db->where($where)->from(TABLE_FILE)->get()->result_array();
		return $files;
	}

	//v2 
	public function get_by_id($id) {
		$where = array(
			'id'		=> $id,
			);

		$file = $this->db->where($where)->from(TABLE_FILE)->get()->row_array();
		return $file;
	}

	//v2 通过ID更新图片图片信息
	public function update_by_id($file, $id) {
		$where = array(
			'id'	=> $id,
			);

		$this->db->where($where)->update(TABLE_FILE, $file);
		return $this->db->affected_rows();
	}

	//v2 通过ID删除图片数据库信息
	public function del_by_id($file_id) {
		$where = array(
				'id'		=> $file_id,
			);

		$this->db->from(TABLE_FILE)->where($where)->delete();

		return $this->db->affected_rows();
	}

}