<?php
/**
 * Created by PhpStorm. 不支持多线程
 * User: ykjverx
 * Date: 2015/3/19
 * Time: 22:13
 */

class Crawler {

    public $baseUrl = "";           //基本路径

    public $pageNo = 1;
    public $pageSize = 1000;

    public function __construct($params = array()) {
        if(count($params) > 0) {
            foreach ($params as $key => $value) {
                if(isset($this->$key)){
                    $this->$key = $value;
                }
            }
        }
    }

    public function _getUrlContent($url){
        $handle = fopen($url, "r");
        if($handle){
            $content = stream_get_contents($handle, 1024 * 1024);
            return $content;
        }else{
            return false;
        }
    }

    public function getUrlContent($url){
    	// var_dump($post);
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    	$output = curl_exec($ch);
    	curl_close($ch);

    	return $output;
    }

    public function _filterUrl($web_content){
        // echo $web_content;
	    $reg_tag_a = '/<span.*<[a|A].*?href=[\'\"]{0,1}([^>\'\"\ ]*).*?>(.*)<\/[a|A]>.*<span style=\'float:right;width:90px;border:0px solid black;\'>(.*)<\/span>/';
	    $result = preg_match_all($reg_tag_a, $web_content, $match_result);
	    if ($result) {
	        return $match_result;
	    } 
    }

    public function regexContent($str, $reg){
        $result = preg_match_all($reg, $str, $matchResult);
        if($matchResult){
            return $matchResult;
        }else{
            return false;
        }
    }


    public function getContent() {
        $requestUrl = $this->baseUrl."?pageSize=".$this->pageSize."&pageNo=".$this->pageNo; 
        $content = $this->getUrlContent($requestUrl) ;
        return $content;
    }


    public function doCrawler(){
        var_dump($this->parseContent($this->getContent()));

	    $result = array();
    	$post = 'a51158actiontype=&a51158o=desc&a51158k=wbtop&current=';
    	for($i = 1 ; $i <= 1 ; $i ++){
	        $web_content = $this -> getUrlContent($uri, $post . $i);
	        $match_result = $this -> _filterUrl($web_content);
	        // var_dump($match_result);
	        foreach ($match_result[1] as $key => $value) {
	            // var_dump($value);
	            $isSuccess = preg_match_all('/cate=(.*)&id=(.*)/', $value, $idResult);

                // var_dump($match_result[2][$key]);

                if(strtotime($match_result[3][$key]) < strtotime('2015-1-1')){
                    return $result;
                }

                $currentContent = $this -> getUrlContent('http://www.svtcc.edu.cn/newscontent.jsp?id='.$idResult[2][0].'&cate='.$idResult[1][0], array());
                // var_dump($currentContent);
                $matchResult = $this -> regexContent($currentContent, "/<span.*稿.*<\/span/");
                // var_dump($matchResult);
                if(! $matchResult[0]){
                    $matchResult = $this -> regexContent($currentContent, "/sans-serif\">\(.*\)<\/span/");

                }
                if(! $matchResult[0]){
                    $matchResult = $this -> regexContent($currentContent, "/align=\"right\">[\s\S]*?<div style=\'clear: both\'><\/div>/");
                }
                if( ! $matchResult[0]){
                    $matchResult = $this -> regexContent($currentContent, "/<p style=\"text-align: right\">[\s\S]*?style=\'clear: both\'/");
                }

                // var_dump($matchResult);
                $matchResult = $matchResult[0];
                if(count($matchResult) == 0){
                        array_push($result, array(
                            'title' => $match_result[2][$key], 
                            'category_id' => $idResult[1][0],
                            'index_ctime' => $match_result[3][$key],
                            'id' => $idResult[2][0],
                            'category_name' => '未识别'
                            ));
                            continue;
                }
                $matchResult = $matchResult[count($matchResult) - 1];
                $matchResult = $this -> regexContent($matchResult, '/汽车系|后勤\(基建\)处|机电系|航运系|航运工程系|建筑工程系|四川高等职业教育研究中心|成人与继续教育中心|道桥系|自动化工程系|交苑公司|道路桥梁工程系|机电工程系|综改办|行政办公室|宿管中心|党委办公室|后勤处|四川交职校|宣传部|人事处|科技教育研究发展中心|公共课教学部|汽车工程系|图书馆|党委行政办|宣传统战部|招生就业处|教务处|运输工程系|人文艺术系|学生工作部|思政部|学工部|信息工程系|国际部|成人继续教育部|信息工程系|科教研发中心|工会办公室|院团委|管理学校|道路与桥梁工程系|后勤（基建）处|四川跃通公路工程监理有限公司|学院工会|科研处|国际部/');
                $matchResult = $matchResult[0];
                if(!isset($matchResult[0]) || ! $matchResult[0]){
                }else{
                    // var_dump($matchResult);
                    foreach ($matchResult as $key1 => $value1) {
                        array_push($result, array(
                            'title' => $match_result[2][$key], 
                            'category_id' => $idResult[1][0],
                            'index_ctime' => $match_result[3][$key],
                            'id' => $idResult[2][0],
                            'category_name' => $value1
                            ));
                        // var_dump($value);
                    }
                }
	        }

    	}

    	return $result;
        /*
        create table new_crawler(
        id int primary key,
        titile varchar(500) not null default '',
        category_id int not null default 1
        )charset utf8
        */
    }



    //get content of the url
    public function get_content($url, $overtime = 60) {
        if(empty($url)) {
            return '';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $overtime);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }


    public function download_img($url, $dir_path, $permit_ext, $overtime=120) {
        $img_path_info = pathinfo($url);
        $extension = strtolower($img_path_info['extension']);
        if( ! in_array($extension, $permit_ext)) {
            return false;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $overtime);
        $res = curl_exec($ch);
        curl_close($ch);

        $filename = date('Y/m') . '/' . time() . '_' . rand(0, 9999) . '.' . $extension;
        $fp = fopen($dir_path . $filename, 'a');
        fwrite($fp, $res);
        fclose($fp);


        return array(
            'filename'  => $filename,
            'file_path' => $dir_path . $filename,
            );
    }

    public function handle_view_li_page($content) {
        $list_preg_str  = '/newlist.png[\s\S]+?<\/a>/';
        //view-11-7b0ecd941b0040d785286ccc0e6103fc.html
        $href_preg_str = '/view\-(\d{2})\-(.*)\.html/';
        $cid_id_preg_str = '/(\d{2})-([\s\S]+?)\./';
        $date_preg_str = '/\d{4}-\d{2}-\d{2}/';

        $is_match = preg_match_all($list_preg_str, $content, $matches);

        $url_array = array();
        $date_flag = FALSE;
        if($is_match > 0 && is_array($matches)){
            foreach($matches[0] as $v) {
                $is_match = preg_match($date_preg_str, $v, $create_date);
                if( ! $is_match) {
                    return FALSE;
                }
                $create_date = $create_date[0];

                $is_match = preg_match($href_preg_str, $v, $article_href);
                if($is_match > 0) {
                    $is_match_a = preg_match($cid_id_preg_str, $article_href[0], $cid_id);
                    if($is_match_a > 0) {
                        if(empty($date_flag) || strcmp($date_flag, $create_date) !== 0) {
                            $date_flag = $create_date;
                            $index_sort = 0;
                        }else{
                            $index_sort += 1;
                        }
                        $url_array[] = array(
                            'http://www.svtcc.edu.cn/front/'. $article_href[0],
                            $cid_id[1],
                            $cid_id[2],
                            $index_sort,
                            $create_date,
                            );
                    }
                }
            }
        }

        return $url_array;
    }


    public function handle_view_content_page($article_content) {

        $title_success = preg_match('/<h3.*?>(.*?)<\/h3>/', $article_content, $article_title);
        $publisher_success = preg_match('/发布者：(.*?) &/', $article_content, $article_publisher);
        $hits_success = preg_match('/点击数：(.*?) &/', $article_content, $article_hits);
        $date_success = preg_match('/发布时间：(\d{4}-\d{2}-\d{2})/', $article_content, $date_str);
        $content_success = preg_match('/25px;">(.*?)<\/form>/is', $article_content, $article);

        if( ! $title_success || ! $publisher_success || ! $hits_success || ! $date_success 
            || ! $content_success) {
            return false;
        }

        $preged_num = preg_match_all('<img.*?src="(.*?)".*?>', $article[1], $article_imgs);

        $article = preg_replace('/style="[\s\S]+?"/', '', $article);
        $cur_news = array(
            'title'         => $article_title[1],
            'publisher'     => $article_publisher[1],
            'article_hits'  => $article_hits[1],
            'create_date'   => $date_str[1],
            'content'       => $article[1],
            );

        if($preged_num > 0) {
            $cur_news['imgs'] = $article_imgs[1];
        }

        return $cur_news;
    }

}
