<?php
/**
 * Created by PhpStorm.
 * User: ykjverx
 * Date: 2015/3/12
 * Time: 22:52
 */

$value = isset($content['slider']) && isset($content['slider']['value']) ? $content['slider']['value'] : array();
function sayValue($name , $arr){
  if(isset($arr[$name])){
    echo $arr[$name];
  }else{
    echo '';
  }
}
?>
<div class="admin-content" style="min-height:1400px;">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg"><?=$moduleName ?></strong> /
            <small><?p=$moduleDesc ?></small>
        </div>
    </div>
    <div class="am-g" >
        <div class="am-u-12">
                <?php echo validation_errors() ?>
        </div>
        <form id="articleForm" action="<?=site_url('d=config&c=slider&m=create')?>" method="post" class="am-form am-form-horizontal">
            <div class="am-form-group">
              <label class="am-u-sm-3 am-form-label">图片名称</label>
              <div class="am-u-sm-6 am-u-end">
                <input name="name"  value="<?=set_value('name')?>" class="am-g am-input-sm am-form-field" style="width:100%" type="test" name="coverImg"/>
              </div>
            </div>

            <div class="am-form-group">
              <label class="am-u-sm-3 am-form-label">链接地址</label>
              <div class="am-u-sm-6 am-u-end">
                <input name="linkSrc"  value="<?=set_value('linkSrc')?>" class="am-g am-input-sm am-form-field" style="width:100%" type="test" name="coverImg"/>
              </div>
            </div> 

            <div class="am-form-group">
              <label class="am-u-sm-3 am-form-label">图片预览</label>
              <div id="upload-img-view" class="am-u-sm-9">
                <div>
                  <button type="button" id="summer-photo-upload-btn" class="am-btn am-btn-default am-btn-xs" >上传图片</button>
                </div>
                <div>
                  <img style="width:200px" id="img-review" src="<?=set_value('picSrc')?>">
                  <input id="picSrc" name="picSrc" type="hidden" value="<?=set_value('picSrc')?>" />
                </div>
              </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label"></label>
                <div class="am-u-sm-6">
                    <button type="submit" class="am-btn am-btn-default am-radius" id="saveArticle">保存</button>
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <input type="hidden" id="newsId" name="id" value="<?=set_value('id')?>" />
        </form>
    </div>
</div>

<script>
    $(function(){

      var imageUploader = WebUploader.create({
          "server" : "<?=site_url('c=file&m=articlePhoto') ?>",
          "swf" : "<?=base_url('static/plugins/webuploader/Uploader.swf') ?>",
          "resize" : false,
          "accept" : {
              "title" : "Images",
              "extensions" : "gif,jpg,jpeg,bmp,png",
              "mimeTypes" : "image/*"
          },
          "pick" : {
              "id" : "#summer-photo-upload-btn",
              "style" : ""
          },
          "auto" : true
      });

      imageUploader.on('uploadSuccess', function(file, response){
        if(!response.file_uri) {
          alert('上传失败');
          return ;
        }

        $("#img-review").attr('src', response.file_uri);
        $("#picSrc").val(response.file_uri);
      });
    });
</script>