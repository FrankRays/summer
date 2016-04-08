<?php
/**
 * Created by PhpStorm.
 * User: ykjverx
 * Date: 2015/3/12
 * Time: 22:52
 */
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
            <div id="upload-coverimg-group" class="am-form-group">
              <label class="am-u-sm-3">图片地址</label>
              <div class="am-u-sm-6">
                <input id="upload-coverimg" value="<?php echo $content['article']['pic_src'] ?>" class="am-g am-input-sm am-form-field" style="width:100%" type="test" name="coverImg"/>
              </div>
              <div class="am-u-sm-3">
                <button type="button" id="upload-coverimg-btn" class="am-btn am-btn-default am-btn-xs" id="y-ueditor-upload-img">上传图片</button>
              </div>
              <script type="text/plain" id="coverimg-textarea" style="height:5px;display:none;" ></script>
            </div>  
            <div class="am-form-group">
              <label class="am-u-sm-3">图片预览</label>
              <div id="upload-img-view" class="am-u-sm-9">
                  <?php if(isset($content['article']['pic_src']) && !empty($content['article']['pic_src'])){ ?>
                    <img src="<?php echo base_url($content['article']['pic_src']) ?>" style="width:160px;height:90px;" />
                  <?php } ?>            
              </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label"></label>
                <div class="am-u-sm-6">
                    <button type="button" class="am-btn am-btn-default am-radius" id="saveArticle">保存</button>
                    <a href="<?php echo site_url('d=article&c=y&m=index&category_id='.$content['article']['category_id']) ?>" class="am-btn am-btn-default am-radius">返回首页新闻列表</a>
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <input type="hidden" id="newsId" name="id" value="<?php echo isset($content['article']['news_id']) ? $content['article']['news_id'] : '' ?>" />
        </form>
    </div>
</div>

<script>
    $(function(){
    var setCoverimgUrl = "<?php echo site_url('d=article&c=y&m=setCoverImg') ?>" 
    //调用ueditor
    var coverimgEditor = UE.getEditor('coverimg-textarea', {
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
      $("#upload-coverimg").val(arg[0].src);
      $("#upload-img-view").html('');
      $("#upload-img-view").append('<img src="'+arg[0].src+'" style="width:160px;height:90px" />');
    });

    //弹出图片上传的对话框
    function upImage()
    {
      var myImage = coverimgEditor.getDialog("insertimage");
      myImage.open();
    }

    $("#upload-coverimg-btn").on('click', function(){
      upImage();
    });

    //保存监听事件
    $("#saveArticle").on('click', function(){
      var id = $("#newsId").val();
      var coverImg = $("#upload-coverimg").val();
      $.ajax({
        type : 'post',
        url : setCoverimgUrl,
        dataType : 'json',
        data : {'id' : id, 'pic_src' : coverImg},
        success : function(data){
          console.log(data);
          if(data.result && data.result == 'fail'){
            layer.alert(data.content.msg, 1);
          }else if(data.result == 'success'){
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