
<!-- content start -->
<div class="admin-content">
    <div class="am-cf am-padding">
      <div class="am-fl am-cf">
        <strong class="am-text-primary am-text-lg"><?php echo $content['moduleName'] ?></strong> /
        <small><?php echo $content['moduleDesc'] ?></small>
      </div>
    </div>
    <div class="am-g">
      <div class="am-u-sm-12 am-u-md-6">
        <div class="am-btn-toolbar">
          <div class="am-btn-group am-btn-group-xs">
            <a type="button" class="am-btn am-btn-default"  href="<?php echo site_url('d=config&c=slider&m=create') ?>"><span class="am-icon-plus"></span> 新增</a>
            <button type="button" class="am-btn am-btn-default"><span class="am-icon-save"></span> 保存</button>
            <button type="button" class="am-btn am-btn-default"><span class="am-icon-archive"></span> 审核</button>
            <button type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除</button>
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
                <th class="table-id">ID</th>
                <th class="table-title">标题</th>
                <th class="table-type">类别</th>
                <th>链接</th>
                <th>操作</th>
              </tr>
          </thead>
          <tbody>
          <?php foreach($content['articles'] as $article){ ?>
            <tr>
              <td><input type="checkbox" /></td>
              <td><?php echo $article['id'] ?></td>
              <td style="width:30%"><a href="#"><?php echo $article['value']['name'] ?></a></td>
              <td><img src="<?php echo $article['value']['picSrc'] ?>" style="width:160px;width:90px;" /></td>
              <td><?php echo $article['value']['linkSrc'] ?></td>
              <td>
                <div class="am-btn-toolbar">
                  <div class="am-btn-group am-btn-group-xs">
                    <input type="hidden" name="id" value="<?php echo $article['id'] ?>" id="newsId" />
                    <a href="<?php echo site_url('d=config&c=slider&m=create&id='.$article['id']) ?>" class="am-btn am-btn-xs am-text-secondary  am-btn-default"><span class="am-icon-pencil-square-o"></span>编辑</a>
                    <button type="button" class="am-btn am-btn-default am-btn-xs am-text-danger y-settop-btn"><span class="am-icon-trash-o"></span> 删除</button>
                  </div>
                </div>
              </td>
            </tr>
          <?php } ?>
          </tbody>
        </table>

          <div class="am-cf">
  共 15 条记录
  <div class="am-fr">
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
$(function(){
  var deleteSliderUrl = "<?php echo site_url('d=config&c=slider&m=del') ?>";
  //设置置顶按钮
  $("#y-article-list").on('click', '.y-settop-btn', function(){
    var id = $(this).siblings('input').val();
    console.log(id);
    $.ajax({
      type : 'post',
      url : deleteSliderUrl,
      dataType : 'json',
      data : {'id' : id},
      success : function(data){
        console.log(data);
        if(data.result && data.result == 'fail'){
          layer.alert(data.content.msg, 1);
        }else if(data.result == 'success'){
          layer.alert(data.content.msg, 1, function(){
            document.location.reload();
          });
        }
      },
      error :function(xhr){
        $.layer({
          type : 1,
          page : {
            html : xhr.responseText
          }
        });
      }
    });
  });
  
});
</script>