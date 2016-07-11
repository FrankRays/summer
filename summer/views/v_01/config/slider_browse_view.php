
<!-- content start -->
<div class="admin-content">
    <div class="am-cf am-padding">
      <div class="am-fl am-cf">
        <strong class="am-text-primary am-text-lg"><?=$module_name?></strong> /
        <small><?=$module_desc?></small>
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
              <td><input type="checkbox" /></td>
              <td><?=$slider['id'] ?></td>
              <td style="width:30%"><a href="#"><?=$slider['name'] ?></a></td>
              <td><img src="<?=$slider['pic_src'] ?>" style="width:160px;width:90px;" /></td>
              <td><?=$slider['link_src'] ?></td>
              <td>
                <div class="am-btn-toolbar">
                  <div class="am-btn-group am-btn-group-xs">
                    <input type="hidden" name="id" value="<?php echo $slider['id'] ?>" id="newsId" />
                    <a href="<?=site_url('d=config&c=slider&m=create&id='.$slider['id']) ?>" class="am-btn am-btn-xs am-text-secondary  am-btn-default"><span class="am-icon-pencil-square-o"></span>编辑</a>
                    <a href="<?=site_url('d=config&c=slider&m=del&id='.$slider['id'])?>" class="am-btn am-btn-default am-btn-xs am-text-danger y-settop-btn"><span class="am-icon-trash-o"></span> 删除</a>
                  </div>
                </div>
              </td>
            </tr>
          <?php } ?>
          </tbody>
        </table>

          <div class="am-cf">
  共 <?=$count?> 条记录
  <div class="am-fr">
    <?=$pagination?>
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