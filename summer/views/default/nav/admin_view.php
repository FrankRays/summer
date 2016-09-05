<?php defined('BASEPATH') || exit('no direct script access allowed');
?>
<!-- content start -->
<div class="admin-content" style="min-height: 400px;">
    <div class="am-cf am-padding">
      <div class="am-fl am-cf">
        <strong class="am-text-primary am-text-lg"><?php echo $module_name; ?></strong> /
        <small><?php echo $module_path; ?></small>
      </div>
    </div>
    <div class="am-g">
      <div class="am-u-sm-12 am-u-md-6">
        <div class="am-btn-toolbar">
          <div class="am-btn-group am-btn-group-xs">
            <a class="am-btn am-btn-default" href="<?php echo site_url('c=nav&m=create') ?>"><span class="am-icon-plus"></span> 新增</a>
<!--             <a class="am-btn am-btn-default" href="<?php echo site_url('c=article_index&m=create_index_article') ?>"><span class="am-icon-plus"></span> 新增首页</a>
            <a class="am-btn am-btn-default" href="<?php echo site_url('c=article_index&m=batch_fetch_index_article') ?>"><span class="am-icon-archive"></span> 批量新增首页</a> -->
            <button id="del_btn" type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除</button>
          </div>
        </div>
      </div>
      <div class="am-u-sm-12 am-u-md-3">
        <div class="am-form-group">
          <select name="category_id" id="y-article-category" class="category-select" style="width:250px;">
            <option value="option1">所有类别</option>
            <?php foreach ($categories as $category) {?>
              <option value="<?php echo $category['id']; ?>" <?php echo set_select('category_id', $category['id']); ?>><?php echo $category['name']; ?></option>
            <?php }?>
          </select>
        </div>
      </div>
      <!-- <div class="am-u-sm-12 am-u-md-3">
        <div class="am-input-group am-input-group-sm">
          <input type="text" value="" name="wq" class="am-form-field">
          <span class="am-input-group-btn">
            <button id="article-search-btn" class="am-btn am-btn-default" type="button">搜索</button>
          </span>
        </div>
      </div> -->
    </div>

    <div class="am-g">
      <div class="am-u-sm-12">
        <form class="am-form">
          <table class="am-table am-table-striped am-table-hover table-main" id="y-article-list">
            <thead>
              <tr>
                <th class="table-check"><input type="checkbox" /></th>
                <th class="table-title">ID</th>
                <th>标签</th>
                <th class="table-type">链接</th>
                <th>目标</th>
                <th>状态</th>
                <th>操作</th>
              </tr>
          </thead>
          <tbody>
          <?php foreach ($page['data_list'] as $v) {?>
            <tr>
              <td><input type="checkbox" value="<?=$v['id']?>" name="id" /></td>
              <td><?php $v['id'] ?></td>
              <td><?php echo $v['label']; ?></td>
              <td><?php echo $v['href'] ?></td>
              <td><?php echo $v['target'] == '1' ? "站内" : "站外"; ?></td>
              <td><?php echo $v['status'] == '1' ? "显示" : "隐藏";  ?></td>
              <td>
                <div class="am-btn-toolbar">
                  <div class="am-btn-group am-btn-group-xs">
                    <a href="<?php echo site_url('c=nav&m=edit&id=' . $v['id']) ?>" class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 编辑</a>
                  </div>
                </div>
              </td>
            </tr>
          <?php }?>
          </tbody>
        </table>

          <div class="am-cf">
  共 <?=$page['total_rows']?> 条记录
  <div class="am-fr">
    <?php echo $page['page_links']; ?>
  </div>
</div>
          <hr />
        </form>
      </div>

    </div>
  </div>
<!-- content end -->
<script type="text/javascript">
$(function(){
    var cateSelect = $('.category-select').chosen({
      max_selected_options: 1
    });
    cateSelect.change(function(e, k){
      if(!!k.selected) {
        document.location.href="<?php echo site_url("c=post") . '&category_id='; ?>" + k.selected;
      }
    });

    $("#article-search-btn").on('click', function(e){
      var wq = $("[name='wq']").get(0).value;
      document.location.href= "<?php echo site_url('c=post&m=index') ?>" + "&wq=" + wq ;
    });

   <?php echo get_flash_alert() ?>
});
</script>

<?php echo $js_source_code ?>
