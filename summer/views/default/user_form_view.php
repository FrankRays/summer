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
            <?php echo $form_generate ?>


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
</script>