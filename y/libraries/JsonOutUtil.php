<?php
/**
 * Created by PhpStorm.
 * User: ykjverx
 * Date: 2015/3/16
 * Time: 21:44
 */

class JsonOutUtil {

    public function resultOutString($result, $content){
        if($result){
            echo json_encode(array('result' => 'success','content' => $content));
        }else{
            echo json_encode(array('result' => 'fail', 'content' => $content));
        }
    }
}