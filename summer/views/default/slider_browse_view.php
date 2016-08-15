<?php defined('BASEPATH') || exit('no direct script access allowed');

?>


<!-- content start -->
<div class="admin-content">
    <div class="am-cf am-padding">
      <div class="am-fl am-cf">
        <strong class="am-text-primary am-text-lg"><?=$module_name?></strong> /
        <small><?php echo $bread_path?></small>
      </div>
    </div>
    <div class="am-g">
      <div class="am-u-sm-12 am-u-md-6">
        <div class="am-btn-toolbar">
          <div class="am-btn-group am-btn-group-xs">
            <a type="button" class="am-btn am-btn-default"  href="<?php echo site_url('d=config&c=slider&m=create') ?>"><span class="am-icon-plus"></span> 新增</a>
            <button type="button" class="am-btn am-btn-default"><span class="am-icon-save"></span> 保存</button>
            <button type="button" class="am-btn am-btn-default"><span class="am-icon-archive"></span> 审核</button>
            <button id="slider-del-article-btn" type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除</button>
          </div>
        </div>
      </div>
      <div class="am-u-sm-12 am-u-md-3">
      </div>
      <div class="am-u-sm-12 am-u-md-3">
        <div class="am-input-group am-input-group-sm">
          <input type="text" class="am-form-field">
          <span class="am-input-group-btn">
            <button class="am-btn am-btn-default" type="button">搜索</button>
          </span>
        </div>
      </div>
    </div>

    <div class="am-g">
      <div class="am-u-sm-12">
        <form class="am-form">
          <table class="am-table am-table-striped am-table-hover table-main" id="y-slider-list">
            <thead>
              <tr>
                <th class="table-check"><input type="checkbox" /></th>
                <th class="table-id">ID</th>
                <th class="table-title">标题</th>
                <th class="table-type">类别</th>
                <th>链接</th>
                <th>操作</th>
              </tr>
          </thead>
          <tbody>
          <?php foreach($data_list as $slider){ ?>
            <tr>
              <td><input type="checkbox" name="slider_id" value="<?php echo $slider['id']?> " /></td>
              <td><?=$slider['id'] ?></td>
              <td style="width:30%"><a href="#"><?php echo $slider['title'] ?></a></td>
              <td><img src="<?php echo resource_url($slider['img_path']) ?>" style="width:160px;width:90px;" /></td>
              <td><?=$slider['href'] ?></td>
              <td>
                <div class="am-btn-toolbar">
                  <div class="am-btn-group am-btn-group-xs">
                    <input type="hidden" name="id" value="<?php echo $slider['id'] ?>" id="newsId" />
                    <a href="<?php echo site_url('c=slider&m=edit&slider_id='.$slider['id']) ?>" class="am-btn am-btn-xs am-text-secondary  am-btn-default"><span class="am-icon-pencil-square-o"></span>编辑</a>
                  </div>
                </div>
              </td>
            </tr>
          <?php } ?>
          </tbody>
        </table>

          <div class="am-cf">
  共 <?php echo $total_rows ?> 条记录
  <div class="am-fr">
    <?php echo $page_links ?>
  </div>
</div>
          <hr />
          <p>注：.....</p>
        </form>
      </div>

    </div>
  </div>
<!-- content end -->
<?=get_flash_alert() ?>
<script>
$(function(){

    //删除文章事件
    $("#slider-del-article-btn").on('click', function(e){
      var articleIds = [];
      var checkbox = $("[name=slider_id]:checked"); 
      if(checkbox.length == 0) {
        alert('请勾选删除文章');
        return ;
      }

      if(checkbox.length > 1) {
        alert('一次只能选择一个分类删除');
        return ;
      }

      var c = confirm('警告！请确认是否删除该幻灯片!');
      if(!c) return ;
      var href = '<?=site_url('c=slider&m=del')?>&slider_id=' + checkbox.eq(0).val();
      document.location.href = href;
    });

});
</script>