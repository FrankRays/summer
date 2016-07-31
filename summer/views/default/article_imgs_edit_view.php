<?php

defined('APPPATH') OR exit('forbidden to access');
?>
<div class="admin-content">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg"><?php echo $module_name ?></strong> /
            <small><?php echo $module_name ?></small>
        </div>
    </div>
    <div class="am-g" >
        <div class="am-u-12">
                <?php echo validation_errors() ?>
        </div>
        <?php echo form_open_multipart($post_url, array('class'=>'am-form am-form-horizontal')) ?>
            <input type="hidden" name="id" value="<?=set_value('id')?>" />
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">图片</label>
                <div class="am-u-sm-6">
                    <input name="file" type="file"  />
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">标题</label>
                <div class="am-u-sm-6">
                    <input name="title" type="text" value="<?=set_value('title') ?>" placeholder="图片标题" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">内容</label>
                <div class="am-u-sm-6">
                    <textarea name="summary"><?php echo set_value('summary') ?></textarea>
                </div>
                <div class="am-u-sm-4"></div>
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