<?php

defined('APPPATH') || exit('forbidden to access');
?>

<div class="admin-content" style="min-height:1400px;">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg"><?php echo $module_name ?></strong> /
            <small>
            <?php echo get_module_path(
                array(
                    array('文章列表', site_url('c=post')),
                    array('图片管理', '#'),
                )
            ); 
            ?></small>
        </div>
    </div>

    <div class="am-g">
      <div class="am-u-sm-12 am-u-md-6">
        <div class="am-btn-toolbar">
          <div class="am-btn-group am-btn-group-xs">
                <button id="set-coverimg-btn" class="am-btn am-btn-default" ><span class="am-icon-plus"></span> 设置封面</button>
                <button id="summer-del-img-btn" type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除</button>
          </div>
        </div>
      </div>
      <div class="am-u-sm-12 am-u-md-3">
      </div>
    </div>
    <div class="am-g" >

        <div class="am-u-12">
            <table class="am-table am-table-striped am-table-hover table-main upload-img-table" id="y-article-list">
                <thead>
                    <tr>
                        <th><input type="checkbox" /></th>
                        <th>图片</th>
                        <th>标题</th>
                        <th>文字</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody id="article-tbody">
                <?php foreach($imgs as $v): ?>
                        <tr>
                        <td><input name="file_id" type="checkbox" value="<?php echo $v['id'] ?>" /></td>
                        <td><a target="blank" href="<?php echo resource_url($v['pathname']) ?>"><img style="width:200px;" src="<?php echo resource_url($v['pathname']) ?>" /></a></td>
                        <td><?php echo $v['title'] ?></td>
                        <td><?php echo $v['summary'] ?></td>
                        <td>
                        <div class="am-btn-toolbar">
                            <div class="am-btn-group am-btn-group-xs">
                                <a href="<?php echo site_url('c=post&m=imgs_edit&id=' . $v['id']) ?>" class="am-btn am-btn-xs" >编辑<?php echo $v['primary'] == 1 ? '(封面)' : ''; ?></a>

                            </div>
                        </div>
                        </td>
                        </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="am-u-12">
                <?php echo validation_errors() ?>
        </div>

        <?php echo form_open_multipart(site_url('c=post&m=imgs')); ?>

            <input type="hidden" name="object_id" value="<?php echo set_value('object_id')?>">
            
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">添加图片(2M以内)</label>   
                <div class="am-u-sm-10">
                    <table class="am-table am-table-striped am-table-hover table-main upload-img-table" id="y-article-list">
                        <thead>
                            <tr>
                                <th>图片</th>
                                <th>标题</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody id="img-form-tbody">
                                <tr>
                                    <td><input type="file" name="files[]" /></td>
                                    <td><input type="text" name="titles[]" /></td>
                                    <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                        <button type="button" class="am-btn am-btn-xs delete-image-btn" >删除</button>
                                        <button type="button" class="am-btn am-btn-xs add-image-btn" >添加</button>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                        </tbody>
                    </table>

                    <div style="display:none">
                        <script id="container" name="content" style="height:500px" type="text/plain"></script>
                    </div>

                    <input type="hidden" id="article-image-input" name="article_image" value="<?=set_value('article_image')?>"/>
                </div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label"></label>
                <div class="am-u-sm-6">
                    <button type="submit" class="am-btn am-btn-default am-radius" id="savePhoto">保存</button>
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <input type="hidden" id="newsId" name="id" value="<?=set_value('id') ?>" />
        </form>
    </div>
</div>

<script type="text/javascript" src="<?=base_url('statics/plugins/uploadimg/js/xww.uploadimg.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url('statics/plugins/uploadimg/css/xww.uploadimg.css')?>">
<script>

        //增加上传图片的表单一列 tr
    $('#img-form-tbody').on('click', '.add-image-btn', function(e){
        $("#img-form-tbody").append('<tr><td><input type="file" name="files[]" /></td><td><input type="text" name="titles[]" /></td>'
                + '<td><div class="am-btn-toolbar"><div class="am-btn-group am-btn-group-xs">'
                + ' <button type="button" class="am-btn am-btn-xs delete-image-btn" >删除</button>'
                + '<button type="button" class="am-btn am-btn-xs add-image-btn" >添加</button></div></div></td></tr>');

    });

    //删除图片事件
    $("#summer-del-img-btn").on('click', function(e){
      var articleIds = [];
      var checkbox = $("[name=file_id]:checked"); 
      if(checkbox.length == 0) {
        alert('请勾选删除图片');
        return ;
      }

      if(checkbox.length > 1) {
        alert('一次只能选择一个图片删除');
        return ;
      }

      alert('警告,是否删除张图片');
      var href = '<?=site_url('c=post&m=del_img')?>&file_id=' + checkbox.eq(0).val();
      document.location.href = href;
    });

    //设置分娩图片
    $("#set-coverimg-btn").on('click', function(e){
      var articleIds = [];
      var checkbox = $("[name=file_id]:checked"); 
      if(checkbox.length == 0) {
        alert('请勾选封面图片');
        return ;
      }

      if(checkbox.length > 1) {
        alert('只能设置一个封面图片');
        return ;
      }

      var href = '<?=site_url('c=post&m=set_cover_img')?>&file_id=' + checkbox.eq(0).val();
      document.location.href = href;
    });

</script>