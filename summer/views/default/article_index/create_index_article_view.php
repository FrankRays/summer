<?php defined('BASEPATH') || exit('no direct script access allowed');?>
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
        <?php echo form_open($post_url, array('class'=>'am-form am-form-horizontal')) ?>
            <div class="am-form-group">
              <label class="am-u-sm-3 am-form-label">新闻连接</label>
              <div class="am-u-sm-6 am-u-end">
                <input name="href"  value="<?=set_value('href')?>" placeholder="http://www.svtcc.edu.cn/front/view-11-96b6014b6e0543ffa477a48e0b4baba9.html" class="am-g am-input-sm am-form-field" type="text"/><span>输入需要新增的新闻连接</span>
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