<?php
/**
 * Created by PhpStorm.
 * User: ykjverx
 * Date: 2015/3/12
 * Time: 22:52
 */

$article = isset($content['article']) ? $content['article'] : array();
function echoArticle($name, $arr){
  echo isset($arr[$name]) ? $arr[$name] : '';
}
?>
<div class="admin-content" style="min-height:1400px;">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg"><?php echo $content['moduleName'] ?></strong> /
            <small><?php echo $content['moduleDesc'] ?></small>
        </div>
    </div>
    <div class="am-g" >
        <form id="articleForm" class="am-form am-form-horizontal">
            <div class="am-form-group">
              <label class="am-u-sm-2 am-form-label">视频标题</label>
              <div class="am-u-sm-6 am-u-end">
                <input  name="title" value="<?php echoArticle('title', $article) ?>" type="text" class="am-input-sm am-form-field" style="100%" />           
              </div>
            </div>
            <div id="upload-coverimg-group" class="am-form-group">
              <label class="am-u-sm-2 am-form-label">视频地址</label>
              <div class="am-u-sm-6">
                <input value="<?php echoArticle('video_src', $article) ?>" name="video_src" id="upload-video" value="" class="am-input-sm am-form-field"  type="text"/>
              </div>
              <div class="am-u-sm-3 am-u-end">
                <button type="button" class="am-btn am-btn-default am-btn-xs" id="y-ueditor-upload-video">上传视频</button>
              </div>
            </div>
            <div id="upload-coverimg-group" class="am-form-group">
              <label class="am-u-sm-2 am-form-label">视频封面图片</label>
              <div class="am-u-sm-6">
                <input value="<?php echoArticle('pic_src', $article) ?>" id="upload-coverimg" value="" class="am-input-sm am-form-field" type="text" name="pic_src"/>
              </div>
              <div class="am-u-sm-3">
                <button type="button" class="am-btn am-btn-default am-btn-xs" id="y-ueditor-upload-img">上传图片</button>
              </div>
              <script type="text/plain" id="coverimg-textarea" style="height:5px;display:none;" ></script>
            </div>  
            <div class="am-form-group">
              <label class="am-u-sm-2 am-form-label">图片预览</label>
              <div id="upload-img-view" class="am-u-sm-9">      
                  <?php if(isset($content['article']['pic_src']) && !empty($content['article']['pic_src'])){ ?>
                    <img src="<?php echo base_url($content['article']['pic_src']) ?>" style="width:160px;height:90px;" />
                  <?php } ?>       
              </div>
            </div>
            <div class="am-form-group">
              <label class="am-u-sm-2 am-form-label">视频简介</label>
              <div id="upload-img-view" class="am-u-sm-6 am-u-end">
                <textarea name="summary" class="am-input-sm" style="height:200px;"><?php echoArticle('summary', $article) ?></textarea>           
              </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">文章正文内容</label>
                <div class="am-u-sm-8">
                    <div>
                        <script id="container" name="content" style="height:500px" type="text/plain"></script>
                    </div>
                </div>
                <div class="am-u-sm-2"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">发布时间</label>
                <div class="am-u-sm-6">
                    <input type="text"  onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" placeholder="文章发布时间"  name="createTime"/>
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label"></label>
                <div class="am-u-sm-6">
                    <button type="button" class="am-btn am-btn-default am-radius" id="saveArticle">保存</button>
                    <a href="<?php echo site_url('d=article&c=video&m=index') ?>" class="am-btn am-btn-default am-radius">返回视频列表</a>
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <input type="hidden" id="newsId" name="id" value="<?php echoArticle('news_id', $article) ?>" />
        </form>
    </div>
</div>

<script>
    $(function(){
    var setCoverimgUrl = "<?php echo site_url('d=article&c=video&m=create') ?>" 
    //调用ueditor
    var coverimgEditor = UE.getEditor('coverimg-textarea', {
      autoHeightEnabled : false
    });

    coverimgEditor.ready(function(){
      coverimgEditor.hide();

      //监听图片上传
      coverimgEditor.addListener('beforeInsertImage', function (t,arg)
      {
        console.log(arg);
        // alert('这是图片地址：'+arg[0].src);
        $("#upload-coverimg").val(arg[0].src);
        $("#upload-img-view").html('');
        $("#upload-img-view").append('<img src="'+arg[0].src+'" style="width:160px;height:90px" />');
      });

      coverimgEditor.addListener('afterUpfile', function (t, arg)
      {
        // alert('这是文件地址：'+arg[0].url);
        $("#upload-video").val(arg[0].url);
      });

    });


    //弹出图片上传的对话框
    function upImage()
    {
      var myImage = coverimgEditor.getDialog("insertimage");
      myImage.open();
    }

    //弹出文件上传的对话框
    function upFiles()
    {
      var myFiles = coverimgEditor.getDialog("attachment");
      myFiles.open();
    } 

    $("#y-ueditor-upload-video").on('click', function(){
      upFiles();
    });

    $("#y-ueditor-upload-img").on('click', function(){
      upImage();
    });

    var ue = UE.getEditor('container');

    //保存监听事件
    $("#saveArticle").on('click', function(){
      var id = $("#newsId").val();
      var coverImg = $("#upload-coverimg").val();
      var formData = $("#articleForm").serializeArray();
      formData.push({name : 'content', value : UE.getEditor('container').getContent()});
      console.log(formData);
      $.ajax({
        type : 'post',
        url : setCoverimgUrl,
        dataType : 'json',
        data : formData,
        success : function(data){
          console.log(data);
          if(data.result && data.result == 'fail'){
            layer.alert(data.content.msg, 1);
          }else if(data.result == 'success'){
            $("#newsId").val(data.content.id);
            layer.alert (data.content.msg, 1);
          }else{
            layer.alert('系统出错了');
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
    });


    });
</script>