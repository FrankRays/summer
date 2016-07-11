
<!-- content start -->
<div class="admin-content">
    <div class="am-cf am-padding">
      <div class="am-fl am-cf">
        <strong class="am-text-primary am-text-lg"><?=$moduleName ?></strong> /
        <small><?=$moduleDesc ?></small>
      </div>
    </div>
    <div class="am-g">
      <div class="am-u-sm-12 am-u-md-6">
        <div class="am-btn-toolbar">
          <div class="am-btn-group am-btn-group-xs">
            <a type="button" class="am-btn am-btn-default"  href="<?php echo site_url('d=article&c=y&m=create') ?>"><span class="am-icon-plus"></span> 新增</a>
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
                <th class="table-title">标题</th>
                <th class="table-type">类别</th>
                <th>发布日期</th>
                <th>操作</th>
              </tr>
          </thead>
          <tbody>
          <?php foreach($page['data_list'] as $article){ ?>
            <tr>
              <td><input type="checkbox" /></td>
              <td style="width:40%"><a target="blank" href="<?=$article['view_link']?>"><?php echo $article['title'] ?></a></td>
              <td><?php echo $article['category_name'] ?></td>
              <td><?php echo $article['create_date'] ?></td>
              <td>
                <div class="am-btn-toolbar">
                  <div class="am-btn-group am-btn-group-xs">
                    <input type="hidden" name="id" value="<?php echo $article['id'] ?>" id="newsId" />
                    <?php if($article['is_top'] == 0){ ?>
                        <button type="button" class="am-btn am-btn-default am-btn-xs am-text-secondary y-settop-btn"><span class="am-icon-pencil-square-o"></span> 置顶</button>
                    <?php }else{  ?>
                        <button type="button" class="am-btn am-btn-xs am-text-secondary am-btn-success  y-settop-btn"><span class="am-icon-pencil-square-o"></span> 置顶中</button>
                    <?php } ?>
                    <?php if(!empty($article['cover_img'])){ ?>
                      <a href="<?php echo site_url('d=indexArticle&c=y&m=setCoverImg&id='.$article['id']) ?>" class="am-btn am-btn-default am-btn-xs am-text-danger"><span class="am-icon-trash-o"></span>已添加封面</a>
                    <?php }else{ ?>
                      <a href="<?php echo site_url('d=indexArticle&c=y&m=setCoverImg&id='.$article['id']) ?>" class="am-btn am-btn-default am-btn-xs am-text-danger"><span class="am-icon-trash-o"></span>添加封面</a>
                    <?php } ?> 

                    <a href="<?php echo site_url('d=indexArticle&c=y&m=del&id='.$article['id']) ?>" class="am-btn am-btn-default am-btn-xs am-text-danger news-delete-btn"><span class="am-icon-trash-o"></span> 删除</a>
                  </div>
                </div>
              </td>
            </tr>
          <?php } ?>
          </tbody>
        </table>

          <div class="am-cf">
  共 <?=$page['count']?> 条记录
  <div class="am-fr">
    <?=$pagination ?>
  </div>
</div>
          <hr />
          <p>注：.....</p>
        </form>
      </div>

    </div>
  </div>
<!-- content end -->
<?=getFlashAlert()?>
<script>
$(function(){
  var setTopUrl = "<?php echo site_url('d=indexArticle&c=y&m=setTop') ?>";
  var setCoverImgUrl = "<?php echo site_url('d=indexArticle&c=y&m=setCoverImg') ?>";
  //设置置顶按钮
  $("#y-article-list").on('click', '.y-settop-btn', function(){
    var id = $(this).siblings('input').val();
    console.log(id);
    $.ajax({
      type : 'post',
      url : setTopUrl,
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

  $(".news-delete-btn").on("click", function(ce){
    ce.preventDefault()
    ce.stopPropagation()

    var href = $(this).attr("href");
    layer.confirm('确认删除新闻?', function(index){
      document.location.href=href;
    });
    return false;
  });

});
</script>