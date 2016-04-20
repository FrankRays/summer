<?php
defined('BASEPATH') || exit('no direct access');
/**
 * Created by PhpStorm.
 * User: ykjverx
 * Date: 2015/1/25
 * Time: 14:50
 */

class y extends MY_Controller{

    //模板
    private $tpl;
    //分页信息
    private $page;
    private $pageNum;


    public function __construct(){
        parent::__construct();

        $this -> tpl = array(
            'browse'    =>  'v_01/article/browse_view',
            'create'    =>  'v_01/article/create_view',
            'edit'      =>  'v_01/article/edit_view',
            'setCoverImg' => 'v_01/article/set_coverimg_view'
            );

        //初始化分页信息
        $this -> pageNum = 15;
        //分页类载入
        $this -> load -> library('pagination');
        $this -> load -> library('JsonOutUtil');
        $this -> load -> model('news_category_model');
        $this -> load -> model('file_model');
        $this -> jsonOutUtil = new JsonOutUtil();

        //potal
        $this -> yPotal();
    }

    /**
     *文章管理首页
     */
    public function index() {
        $data['moduleName']= '文章管理';
        $data['moduleDesc'] = '管理多媒体文章信息';
//      var_dump($this -> article_model -> getTotal());
        $data['pagination'] = $this -> _getPaginationStr($this -> article_model -> getTotal());

        $category_id = $this->input->get("category_id", true);
        $_POST["category_id"] = $category_id;

        $data['articles'] = $this -> article_model -> getNormalList();
        $data['categories'] = $this -> news_category_model -> getRecList();

        $paginationConfig = $this->config->item("snowConfig/admin");
        $paginationConfig = $paginationConfig['paginationConfig'];
        var_dump($paginationConfig);

        $this->_loadView('v_01/article/browse_view', $data);
    }

    /**
     *文章添加接口
     */
    public function create(){
        $this -> _data['content']['moduleName'] = "文章添加";
        $this -> _data['content']['moduleDesc'] = "站点所有文章添加页面";

        $post = $this -> input -> post();
        if(!empty($post)){
            //如果带分类的话
            if($newsId = $this -> article_model -> create($post)){
                $this -> jsonOutUtil -> resultOutString(true, array('msg' => '保存成功',
                    'newsId' => $newsId));
            }else{
                $this -> jsonOutUtil -> resultOutString(false, '保存失败');
            }
            return ;
        }else{
            $this -> _data['content']['categories'] = $this -> news_category_model -> getRecList();
        }
        $this -> _view($this -> tpl['create']);
    }

    /*
    *文章编辑页面
    */
    public function edit(){
        $this -> _data['content']['moduleName'] = "文章编辑";
        $this -> _data['content']['moduleDesc'] = "编辑站点文章页面";

        $get = $this -> input -> get();
        $post = $this -> input -> post();

        if(isset($get['newsId'])){
            $newsId = intval($get['newsId']);
            if($article = $this -> article_model -> getOneById($newsId)){
                $article['add_time'] = date('Y-m-d H:i:s', $article['add_time']);
                $this -> _data['content']['categories'] = $this -> news_category_model -> getRecList();
                $this -> _data['content']['article'] = $article;
                $this -> _data['content']['news_id'] = $article['news_id'];
                $this -> _view($this -> tpl['edit']);
            }
        }
    }

    //set top article
    public function setTopByID(){
        $post = $this -> input -> post();

        if(isset($post['newsID'])){
            $newsID = intval($post['newsID']);
            $this -> article_model -> setTop($newsID);
            $this -> jsonOutUtil -> resultOutString(true, array('msg' => '设置置顶成功'));
        }
    }

    //文章删除
    public function del(){
        $post = $this -> input -> post();
        if(isset($post['newsId'])){
            $newsId = intval($post['newsId']);
            if($this -> article_model -> delOneById($newsId)){
                $this -> jsonOutUtil -> resultOutString(true, array('msg' => '删除成功'));
            }else{
                $this -> jsonOutUtil -> resultOutString(false, array('msg' => '删除失败'));
            }
        }else{
            $this -> jsonOutUtil -> resultOutString(false, array('msg' => '删除失败,没有ID值'));
        }
    }

    //更改文章状态
    public function changeStatus(){
        $post = $this -> input -> post();

        if(isset($post['newsId'])){
            $newsId = intval($post['newsId']);
            $article = $this -> article_model -> getOneById($newsId);
            $status = $article['status'] == 1 ? 0 : 1;
            if($this -> article_model -> create(array('id' => $newsId, 'status' => $status))){
                $this -> jsonOutUtil -> resultOutString(true, array('msg' => '更改文章状态成功'));
            }else{
                $this -> jsonOutUtil -> resultOutString(false, array('msg' => '更改文章状态失败'));
            }
        }
    }

    //设置封面图片
    public function setCoverImg(){
        $this -> _data['content']['moduleName']
            = $this -> _data['head']['title'] = '置顶文章设置';
        $this -> _data['content']['moduleDesc'] = '置顶文章设置';
        $this -> _data['sidebar'] = array();
        $this -> _data['foot'] = array();

        $get = $this -> input -> get();
        $post = $this -> input -> post();

        if(isset($post['id'])){
            $this -> article_model -> create($post);
            echo $this -> jsonOutUtil -> resultOutString(true, array('msg' => '保存成功'));
            return ;
        }

        if(isset($get['id'])){
            $id = intval($get['id']);
            $article = $this -> article_model -> getOneById($id);
            $this -> _data['content']['article'] = $article;
            $this -> _view($this -> tpl['setCoverImg']);
        }
    }

}
