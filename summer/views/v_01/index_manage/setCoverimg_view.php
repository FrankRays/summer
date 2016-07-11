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
            <strong class="am-text-primary am-text-lg"><?=$moduleName ?></strong> /
            <small><?=$moduleDesc ?></small>
        </div>
    </div>
    <div class="am-g" >
        <form id="articleForm" method="post" action="<?=site_url('d=indexArticle&c=y&m=setCoverImg')?>" class="am-form am-form-horizontal">
            <div class="am-form-group">
              <label class="am-u-sm-3">图片预览</label>
              <div  class="am-u-sm-9">
                <div>
                  <button type="button" id="summer-photo-upload-btn" class="am-btn am-btn-default am-btn-xs">上传图片</button>
                </div>
                <div>  
                  <img src="<?=set_value('cover_img', '')?>" style="width:100px" id="upload-img-view" />
                </div>
                <input type="hidden" name="coverImg" id="cover-img-src-input" value="<?=set_value('cover_img', '')?>" /> 
                <input type="hidden" name="id" value="<?=set_value('id', '') ?>" />
              </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label"></label>
                <div class="am-u-sm-6">
                    <button type="submit" class="am-btn am-btn-default am-radius" id="saveArticle">保存</button>
                </div>
                <div class="am-u-sm-4"></div>
            </div>
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
            alert('上传失败，重新上传');
            return ;
          }

          $('#upload-img-view').attr('src', response.file_uri);
          $('#cover-img-src-input').val(response.file_uri);
        });

    });
</script>