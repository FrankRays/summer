
<!-- content start -->
<div class="admin-content" style="min-height: 400px;">
    <div class="am-cf am-padding">
      <div class="am-fl am-cf">
        <strong class="am-text-primary am-text-lg"><?php echo $moduleName; ?></strong> /
        <small><?php echo $moduleDesc; ?></small>
      </div>
    </div>
    <div class="am-g">
      <div class="am-u-sm-12 am-u-md-6">
        <div class="am-btn-toolbar">
          <div class="am-btn-group am-btn-group-xs">
            <a type="button" class="am-btn am-btn-default"  href="<?php echo site_url('c=post&m=save&category_id='. set_value('category_id', 0)); ?>"><span class="am-icon-plus"></span> 新增</a>
            <button type="button" class="am-btn am-btn-default"><span class="am-icon-save"></span> 保存</button>
            <button type="button" class="am-btn am-btn-default"><span class="am-icon-archive"></span> 审核</button>
            <button type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除</button>
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
          <table class="am-table am-table-striped am-table-hover table-main" id="y-article-list">
            <thead>
              <tr>
                <th class="table-check"><input type="checkbox" /></th>
                <th class="table-id">ID</th>
                <th class="table-title">标题</th>
                <th class="table-type">类别</th>
                <th>作者</th>
                <th>修改日期</th>
                <th>操作</th>
              </tr>
          </thead>
          <tbody>
          <?php foreach ($dataList as $article) {?>
            <tr>
              <td><input type="checkbox" /></td>
              <td><?php echo $article['news_id']; ?></td>
              <td style="width:30%"><a href="#"><?php echo $article['title']; ?></a></td>
              <td><?php echo $article['category_name']; ?></td>
              <td><?php echo $article['author']; ?></td>
              <td><?php echo date("Y-m-d H:i:s", intval($article['edit_time'])); ?></td>
              <td>
                <div class="am-btn-toolbar">
                  <div class="am-btn-group am-btn-group-xs">
                    <input type="hidden" name="id" value="<?php echo $article['news_id']; ?>" id="newsId" />
                    <a href="<?php echo site_url('c=post&m=save&news_id=' . $article['news_id']) ?>" class="am-btn am-btn-default am-btn-xs am-text-secondary y-edit-article-btn"><span class="am-icon-pencil-square-o"></span> 编辑</a>
                    <?php if ($article['status'] == 1) {?>
                      <a href="<?php echo site_url('c=post&m=changeStatus&id='.$article['news_id']) ?>" class="am-btn am-btn-default am-btn-xs am-text-success y-article-status-btn"><span class="am-icon-copy"></span> 发布</a>
                    <?php } else {?>
                      <a href="<?php echo site_url('c=post&m=changeStatus&id='.$article['news_id']) ?>"  class="am-btn am-btn-default am-btn-xs am-text-danger y-article-status-btn"><span class="am-icon-copy"></span> 草稿</a>
                    <?php }?>
                    <a href="<?php echo site_url('c=post&m=del&id='.$article['news_id']) ?>" class="am-btn am-btn-default am-btn-xs am-text-danger  y-article-del-btn"><span class="am-icon-trash-o"></span> 删除</a>
                    <a  href="<?php echo site_url('d=article&c=y&m=setCoverImg&id=' . $article['news_id']); ?>" class="am-btn am-btn-default am-btn-xs am-text-success"><span class="am-icon-trash-o"></span> 置顶图片</a>
                    <?php if ($article['is_top'] == 1) {?>
                       <a href="<?php echo site_url('c=post&m=setTop&id='.$article['news_id']) ?>" class="am-btn am-btn-default am-btn-xs am-text-danger y-article-nowtop-btn"><span class="am-icon-copy"></span> 置顶中</a>
                    <?php } else {?>
                      <a href="<?php echo site_url('c=post&m=setTop&id='.$article['news_id']) ?>"  class="am-btn am-btn-default am-btn-xs am-text-danger y-article-setTop-btn"><span class="am-icon-copy"></span> 置顶</a>
                    <?php }?>

                  </div>
                </div>
              </td>
            </tr>
          <?php }?>
          </tbody>
        </table>

          <div class="am-cf">
  共 15 条记录
  <div class="am-fr">
    <?php echo $pagination; ?>
  </div>
</div>
          <hr />
          <p>注：.....</p>
        </form>
      </div>

    </div>
  </div>
<!-- content end -->
<script>
  var siteUlr = "<?php echo site_url('d=article&c=y&m=index'); ?>";
  var editSiteUrl = "<?php echo site_url('d=article&c=y&m=del'); ?>";
  var statusSiteUrl = "<?php echo site_url('d=article&c=y&m=changeStatus'); ?>";
  var setTopUrl = "<?php echo site_url('d=article&c=y&m=setTopByID'); ?>";
  var delUrl = "<?php echo site_url('d=article&c=y&m=del'); ?>";
</script>
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

    var saveStatus = <?php echo $save_status ?>;
    if(!!saveStatus) {
      alert("<?php echo $save_message ?>");
    }
})
</script>
<script type="text/javascript"></script>