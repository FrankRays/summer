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
}

// $url = "http://www.svtcc.edu.cn/newslist.jsp?cate=3";
// $c = new Crawler($url);
// $result = $c -> doCrawler($url);
// var_dump($result);