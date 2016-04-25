<?php
/**
 * Created by PhpStorm.
 * User: ykjverx
 * Date: 2015/3/23
 * Time: 20:32
 */
$article = isset($article) ? $article : array();
function outValue($name, $arr){

    if($name == 'content' && isset($arr[$name])){
        $photoesArr = json_decode($arr[$name]); 
        if(!$photoesArr){
            return ;
        }
        $photoesStr = '';
        foreach($photoesArr as $k => $v){
            $photoesStr .= '<tr><td><img style="width:160px;height:90px" src="'. $v -> src . '"</td>';
            $photoesStr .= '<td><textarea>'.$v -> desc .'</textarea></td>';
            $photoesStr .= '<td><button type="button" class="am-btn am-btn-default y-photo-del-btn">删除</button><button type="button" class="am-btn am-btn-default y-photo-up-btn">上移</button><button type="button" class="am-btn am-btn-default y-photo-down-btn">下移</button></td></tr>';
        }
        echo $photoesStr;
        return ;
    }

    if($name == 'add_time'){
        echo isset($arr[$name]) ? date('Y-m-d H:i:s', $arr[$name]) : '';
        return ;    
    }   
    echo isset($arr[$name]) ? $arr[$name] : '';
}

function outSelected($name, $arr, $categoryId){
    if($name = 'category_id' && isset($arr['category_id']) && $arr['category_id'] == $categoryId){
        echo 'selected="selected"';
    }
}
?>

<div class="admin-content" style="min-height:1400px;">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg"><?php echo $moduleName ?></strong> /
            <small><?php echo $moduleDesc ?></small>
        </div>
    </div>
    <div class="am-g" >
        <form id="photoForm" action="#" method="post" class="am-form am-form-horizontal">
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">文章标题</label>
                <div class="am-u-sm-6">
                    <input name="title" value="<?php outValue('title', $article) ?>" type="text" placeholder="请输入文章标题" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">文章类别</label>
                <div class="am-u-sm-6">
                    <select name="category_id">
                        <option value="0">文章类别</option>
                        <?php foreach($categories as $category){ ?>
                            <option <?php echo set_select('category_id', $category['id']) ?> value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="am-u-sm-4"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">来稿</label>
                <div class="am-u-sm-6">
                    <input type="text" value="<?php outValue('come_from', $article) ?>" name="comefrom" placeholder="请输入来稿消息" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">作者</label>
                <div class="am-u-sm-6">
                    <input name="author" value="<?php outValue('author', $article) ?>" type="text" placeholder="请输入作者" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">关键字</label>
                <div class="am-u-sm-6">
                    <input name="keywords" value="<?php outValue('keywords', $article) ?>" type="text" placeholder="请输入关键字，用逗号分开" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">文章简介</label>
                <div class="am-u-sm-6">
                    <textarea style="height:150px" name="summary"><?php outValue('summary', $article)?></textarea>
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">图片列表</label>   
                <div class="am-u-sm-10">                 
                    <div class="am-btn-toolbar">
                            <div class="am-btn-group">
                                <button type="button"  class="am-btn am-btn-default am-btn-sm" id="y-photo-create-btn"><span class="am-icon-save"></span>添加图片</button>
                            </div>
                    </div>
                    <table class="am-table am-table-striped am-table-hover table-main" id="y-article-list">
                        <thead>
                            <tr>
                                <th>图片</th>
                                <th>简介</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php outValue('content', $article) ?>
                            
                        </tbody>
                    </table>

                    <div style="display:none">
                        <script id="container" name="content" style="height:500px" type="text/plain"></script>
                    </div>
                </div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">发布时间</label>
                <div class="am-u-sm-6">
                    <input type="text" value="<?php outValue('add_time', $article) ?>"  onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" placeholder="文章发布时间"  name="createTime"/>
                </div>
                <div class="am-u-sm-4"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">文章状态</label>
                <div class="am-u-sm-8">
                    <div class="checkbox">
                        <label>
                        <?php if(isset($article['status'])){ ?>
                            <?php if($article['status'] == 1){ ?>
                                <input type="radio" checked="checked" value="1" name="status" /> 发布
                                <input type="radio" value="2" name="status" /> 草稿
                            <?php }else{  ?>
                                <input type="radio"  value="1" name="status" /> 发布
                                <input type="radio" checked="checked" value="2" name="status" /> 草稿
                            <?php } ?>
                        <?php }else{ ?>
                            <input type="radio" checked="checked" value="1" name="status" /> 发布
                            <input type="radio" value="2" name="status" /> 草稿
                        <?php } ?>
                        </label>
                    </div>
                </div>
                <div class="am-u-sm-2"></div>
            </div>


            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label"></label>
                <div class="am-u-sm-6">
                    <button type="button" class="am-btn am-btn-default am-radius" id="savePhoto">保存</button>
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <input type="hidden" id="newsId" name="id" value="<?php outValue('news_id', $article) ?>" />
        </form>
    </div>
</div>

<script>
    $(function(){
        var createPhotoUrl = "<?php echo site_url('d=article&c=photo&m=create') ?>";
    //调用ueditor
    var coverimgEditor = UE.getEditor('container', {
      autoHeightEnabled : false
    });

    coverimgEditor.ready(function(){
      coverimgEditor.hide();
    });

    //监听图片上传
    coverimgEditor.addListener('beforeInsertImage', function (t,arg)
    {
      console.log(arg);
      // alert('这是图片地址：'+arg[0].src);
      $.each(arg, function(i, e){
        var html = '<tr><td><img style="width:160px;height:90px" src="'+e.src+'"</td>';
        html += '<td><textarea></textarea></td>';
        html += '<td><button type="button" class="am-btn am-btn-default y-photo-del-btn">删除</button><button type="button" class="am-btn am-btn-default y-photo-del-btn">上移</button><button type="button" class="am-btn am-btn-default y-photo-del-btn">下移</button></tr>';
        $("#y-article-list").find("tbody").append($(html));
      });
    });

    //弹出图片上传的对话框
    function upImage()
    {
      var myImage = coverimgEditor.getDialog("insertimage");
      myImage.open();
    }

    $("#y-photo-create-btn").on('click', function(){
      upImage();
    });
    $("#y-article-list").on('click', '.y-photo-del-btn', function(){
        $(this).parents('tr').remove();
    });

    $('#y-article-list').on('click', '.y-photo-up-btn', function(){
        $(this).parents('tr').after($(this).parents('tr').prev());
    });

    $('#y-article-list').on('click', '.y-photo-down-btn', function(){
        $(this).parents('tr').before($(this).parents('tr').next());
    });

    //保存图片新闻
    $("#savePhoto").on('click', function(){
        var postData = $('#photoForm').serializeArray();
        var photoArr = [];
        $.each($("#y-article-list tbody tr"),function(i, e){
            var src = $(this).find("img").attr("src");
            var desc = $(this).find("textarea").val();
            photoArr.push({"src" : src, "desc" : desc});
        });

        postData.push({"name" : "photoes" , "value" : JSON.stringify(photoArr)});

        console.log(postData);
        $.ajax({
            url : createPhotoUrl,
            type : 'post',
            dataType : 'json',
            data : postData,
            success : function(data){
                if(data.result && data.result == "success"){
                    $("#newsId").val(data.content.lastInsertId);
                    layer.msg(data.content.msg, 2, 1);
                }else{
                    layer.msg(data.content.msg);
                }
            },
            error : function(xhr){
                $.layer({
                    type : 1,
                    page : {
                        html : xhr.responseText
                    }
                });
            }
        });
        // console.log(postData);
    });
});
</script>