<?php defined('BASEPATH') || exit('no direct script access allowed');
?>
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
           <!--  <button type="button" class="am-btn am-btn-default"><span class="am-icon-save"></span> 保存</button>
            <button type="button" class="am-btn am-btn-default"><span class="am-icon-archive"></span> 审核</button> -->
            <button id="summer-del-article-btn" type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除</button>
          </div>
        </div>
      </div>
      <div class="am-u-sm-12 am-u-md-3">
        <div class="am-form-group">
          <select name="category_id" id="y-article-category" class="category-select" style="width:250px;">
            <option value="option1">所有类别</option>
            <?php foreach ($categories as $category) {?>
              <option value="<?php echo $category['cat_id']; ?>" <?php echo set_select('category_id', $category['cat_id']); ?>><?php echo $category['name']; ?></option>
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
                <th class="table-title">标题</th>
                <th>封面</th>
                <th class="table-type">类别</th>
                <th>作者</th>
                <th>发布日期</th>
                <th>操作</th>
              </tr>
          </thead>
          <tbody>
          <?php foreach ($data_list as $article) {?>
            <tr>
              <td><input type="checkbox" value="<?=$article['id']?>" name="article_id" /></td>
              <td><a href="#"><?php echo $article['title']; ?></a></td>
              <td>
                <?php if( ! empty($article['coverimg_path'])) { ?>
                  <a target="blank" href="<?=base_url($article['coverimg_path'])?>" >
                    <img src="<?=base_url($article['coverimg_path'])?>" style="width:100px;" />
                  </a>
                <?php }else{ ?>

                  <a href="<?php echo site_url('c=post&m=set_coverimg&id=' . $article['id']); ?>">添加</a>
                  <?php } ?>
              </td>
              <td><?php echo $article['category_name']; ?></td>
              <td><?php echo $article['author_name']; ?></td>
              <td><?=$article['publish_date']; ?></td>
              <td>
                <div class="am-btn-toolbar">
                  <div class="am-btn-group am-btn-group-xs">
                    <a href="<?php echo site_url('c=post&m=save&id=' . $article['id']) ?>" class="am-btn am-btn-default am-btn-xs am-text-secondary y-edit-article-btn"><span class="am-icon-pencil-square-o"></span> 编辑</a>
                    <?php if ($article['status'] == 1) {?>
                      <a href="<?php echo site_url('c=post&m=changeStatus&id='.$article['id']) ?>" class="am-btn am-btn-default am-btn-xs am-text-success y-article-status-btn"><span class="am-icon-copy"></span> 发布</a>
                    <?php } else {?>
                      <a href="<?php echo site_url('c=post&m=changeStatus&id='.$article['id']) ?>"  class="am-btn am-btn-default am-btn-xs am-text-danger y-article-status-btn"><span class="am-icon-copy"></span> 草稿</a>
                    <?php }?>
                    <?php if ($article['is_top'] == 1) {?>
                       <a href="<?php echo site_url('c=post&m=setTop&id='.$article['id']) ?>" class="am-btn am-btn-default am-btn-xs am-text-danger y-article-nowtop-btn"><span class="am-icon-copy"></span> 置顶中</a>
                    <?php } else {?>
                      <a href="<?php echo site_url('c=post&m=setTop&id='.$article['id']) ?>"  class="am-btn am-btn-default am-btn-xs am-text-success y-article-setTop-btn"><span class="am-icon-copy"></span> 置顶</a>
                    <?php }?>

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
    <?php echo $pagination; ?>
  </div>
</div>
          <hr />
         <!--  <p>注：.....</p> -->
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

    //删除文章事件
    $("#summer-del-article-btn").on('click', function(e){
      var articleIds = [];
      var checkbox = $("[name=article_id]:checked"); 
      if(checkbox.length == 0) {
        alert('请勾选删除文章');
        return ;
      }
      checkbox.each(function(){
        articleIds.push(this.value);
      });

      var href = '<?=site_url('c=post&m=del')?>&article_ids=' + articleIds.join('_');
      document.location.href = href;
    });

    var saveStatus = <?php echo $save_status ?>;
    if(!!saveStatus) {
      alert("<?php echo $save_message ?>");
    }
})
</script>
<script type="text/javascript"></script>