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
        <form action="<?=$post_url?>" method="post" id="articleForm" class="am-form am-form-horizontal">
            <input type="hidden" name="id" value="<?=set_value('id')?>" />
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">分类ID</label>
                <div class="am-u-sm-6">
                    <input name="cat_id" type="text" value="<?=set_value('cat_id') ?>" placeholder="分类ID" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">分类名称</label>
                <div class="am-u-sm-6">
                    <input name="name" type="text" value="<?php echo set_value('name') ?>" placeholder="分类名称" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">父级分类</label>
                <div class="am-u-sm-6">
                    <select name="fid" class="category-select">
                        <option value="0">根分类</option>
                        <?php foreach($parents as $category){ ?>
                            <option value="<?php echo $category['id'] ?>" <?php echo set_select('category_id', $category['id']) ?>><?php echo $category['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">分类简介</label>
                <div class="am-u-sm-6">
                    <textarea style="height:150px" name="summary"><?php echo set_value('summary') ?></textarea>
                </div>
                <div class="am-u-sm-4"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">分类状态</label>
                <div class="am-u-sm-8">
                    <div class="checkbox">
                        <label>
                            <input type="radio" value="<?=ARTICLE_STATUS_PUBLIC?>" <?php echo set_radio('status', ARTICLE_STATUS_PUBLIC, true) ?>  name="status" /> 发布
                            <input type="radio" value="<?=ARTICLE_STATUS_PUBLIC?>" <?php echo set_radio('status', ARTICLE_STATUS_DRUFT) ?> name="status" /> 草稿
                        </label>
                    </div>
                </div>
                <div class="am-u-sm-2"></div>
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
        var ue = UE.getEditor('container', 
            {
                'serverUrl': "<?=site_url('c=file&m=uEditorUpload')?>"
            });
        var cateSelect = $('.category-select').chosen({
                max_selected_options: 1
            });
    });
</script>