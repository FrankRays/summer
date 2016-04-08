<?php
/**
 * Created by PhpStorm.
 * User: ykjverx
 * Date: 2015/3/19
 * Time: 22:13
 */

class Crawler {

    public function _getUrlContent($url){
        $handle = fopen($url, "r");
        if($handle){
            $content = stream_get_contents($handle, 1024 * 1024);
            return $content;
        }else{
            return false;
        }
    }

    public function _filterUrl($web_content){
        // echo $web_content;
	    $reg_tag_a = '/<span.*<[a|A].*?href=[\'\"]{0,1}([^>\'\"\ ]*).*?>(.*)<\/[a|A]>.*<span style=\'float:right;width:90px;border:0px solid black;\'>(.*)<\/span>/';
	    $result = preg_match_all($reg_tag_a, $web_content, $match_result);
	    if ($result) {
	        return $match_result;
	    } 
    }

    public function doCrawler($url){
        $web_content = $this -> _getUrlContent($url);
        $match_result = $this -> _filterUrl($web_content);
        // var_dump($match_result);
        $result = array();
        foreach ($match_result[1] as $key => $value) {
            // var_dump($value);
            $isSuccess = preg_match_all('/cate=(.*)&id=(.*)/', $value, $idResult);
            // var_dump($idResult);
            $result[$idResult[2][0]] = array(
                'title' => $match_result[2][$key], 
                'category_id' => $idResult[1][0],
                'index_ctime' => $match_result[3][$key],
                );
        }
        // var_dump($result);
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