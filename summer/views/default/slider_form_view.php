<?php defined('BASEPATH') || exit('no direct script access allowed');

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
            <strong class="am-text-primary am-text-lg"><?php echo $module_name ?></strong> /
            <small><?php echo $bread_path ?></small>
        </div>
    </div>
    <div class="am-g" >
        <div class="am-u-12">
                <?php echo validation_errors() ?>
        </div>
        <?php echo form_open_multipart($post_url, array('class'=>'am-form am-form-horizontal')) ?>
            <div class="am-form-group">
              <label class="am-u-sm-3 am-form-label">图片名称</label>
              <div class="am-u-sm-6 am-u-end">
                <input name="title"  value="<?=set_value('title')?>" placeholder="幻灯片标题" class="am-g am-input-sm am-form-field" style="width:100%" type="test" name="coverImg"/>
              </div>
            </div>

            <div class="am-form-group">
              <label class="am-u-sm-3 am-form-label">链接地址</label>
              <div class="am-u-sm-6 am-u-end">
                <input name="href" type="text" placeholder="http://www.baidu.com" value="<?php echo set_value('href')?>" class="am-g am-input-sm am-form-field" style="width:100%" />
              </div>
            </div> 

            <div class="am-form-group">
              <label class="am-u-sm-3 am-form-label">图片预览</label>
              <div id="upload-img-view" class="am-u-sm-9">
                <input type="file" name="img_path" />
                <div>
                  <img style="width:200px" id="img-review" src="<?php echo resource_url(set_value('img_path'))?>">
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
            <input type="hidden" id="newsId" name="slider_id" value="<?php echo set_value('id')?>" />
        </form>
    </div>
</div>