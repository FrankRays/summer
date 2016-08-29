<?php 
defined('APPPATH') OR exit('forbidden to access');
?>

<!-- content start -->
<div class="admin-content">
    <div class="am-cf am-padding">
      <div class="am-fl am-cf">
        <strong class="am-text-primary am-text-lg"><?php echo $module_name ?></strong> /
        <small><?php echo $module_desc ?></small>
      </div>
    </div>
    <div class="am-g">
      <div class="am-u-sm-12 am-u-md-6">
        <div class="am-btn-toolbar">
          <div class="am-btn-group am-btn-group-xs">
            <a class="am-btn am-btn-default"  href="<?php echo site_url('c=user&m=create') ?>"><span class="am-icon-plus"></span> 新增</a>
          <!--   <button type="button" class="am-btn am-btn-default"><span class="am-icon-save"></span> 保存</button>
            <a class="am-btn am-btn-default" href="<?=site_url('c=article_index&m=crawl_index_news')?>"><span class="am-icon-archive"></span>更新</a> -->
            <button id="summer-del-article-btn" type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除</button>
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
          <table class="am-table am-table-striped am-table-hover table-main" id="y-article-list">
            <thead>
              <tr>
                <th class="table-check"><input type="checkbox" /></th>
                <th class="table-title">ID</th>
                <th class="table-type">账号</th>
                <th class="table-type">账号类型</th>
                <th>操作</th>
              </tr>
          </thead>
          <tbody>
          <?php foreach($users as $user){ ?>
            <tr>
              <td><input type="checkbox" name='user_id' value="<?=$user['id']?>" /></td>
              <td><?php echo $user['id'] ?></td>
              <td><?php echo $user['account'] ?></td>
              <td><?php echo $user['admin'] ?></td>
              <td>
                <div class="am-btn-toolbar">
                  <div class="am-btn-group am-btn-group-xs">
                    <a href="<?php echo site_url('c=user&m=edit&id='.$user['id']) ?>" class="am-btn am-btn-default am-btn-xs am-text-default"><span class="am-icon-pencil-square-o"></span> 编辑</a>
                  </div>
                </div>
              </td>
            </tr>
          <?php } ?>
          </tbody>
        </table>

          <hr />
          <!-- <p>注：.....</p> -->
        </form>
      </div>

    </div>
  </div>
<!-- content end -->
<?=getFlashAlert()?>
<script>
$(function(){

    //删除文章事件
    $("#summer-del-article-btn").on('click', function(e){
      var articleIds = [];
      var checkbox = $("[name=user_id]:checked"); 
      if(checkbox.length == 0) {
        alert('请勾选删除文章');
        return ;
      }

      if(checkbox.length > 1) {
        alert('一次只能选择一个分类删除');
        return ;
      }

      var c = confirm('警告！！请确认你是否删除节点【' + checkbox.eq(0).parents('tr').find('a').text() + '】及其子节点，和所属该节点的文章！！！');
      if(!c) return ;
      var href = '<?=site_url('c=user&m=del')?>&id=' + checkbox.eq(0).val();
      document.location.href = href;
    });

});
</script>