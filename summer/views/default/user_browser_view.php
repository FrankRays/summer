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
            <button type="button" class="am-btn am-btn-default" id="locked-user-btn"><span class="am-icon-save"></span> 锁定用户</button>
            <button id="summer-unlock-user-btn" class="am-btn am-btn-default"><span class="am-icon-archive"></span>解锁用户</button>
            <button id="summer-default-pwd-btn" type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 重置密码</button>
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
                <th class="table-type">状态</th>
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
              <td><?php echo (strtotime($user['locked']) < 0 ) ? '正常' : '锁定' ?></td>
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
      var params = {
        'zeroAlert' : '至少选择一个用户',
        'isMultipleCheck' : true,
        'confirmAlert' : '确认是否要删除用户',
        'ajax' : {
          'url' : '<?php echo site_url("c=user&m=del") ?>',
          'successCallback' : function(data, textStatus, jqXHR) {
            // alert(data.message);
            if(data.status == 300) {
              window.location.href=data.message;
            }
            console.log(jqXHR);
          },
          'dataType' : 'json'
        }
      }
      click_action(params);
    });

    /*
  zeroAlert, ç,
    */
    function click_action(params) {
      var articleIds = [];
      var checkbox = $('[name=user_id]:checked');

      if(checkbox.length === 0) {
        alert(params.zeroAlert);
        return false;
      }

      if( ! params.isMultipleCheck) {
        alert(params.multipleCheckAlert);
        return false;
      }

      var ids = [];
      checkbox.each(function(){
        ids.push($(this).val());
      });

      var c = confirm(params.confirmAlert);
      if(!c) {
        return false;
      }

      $.post(params.ajax.url, {'ids' : ids}, params.ajax.successCallback, params.ajax.dataType); 
    }

    $('#locked-user-btn').on('click', function(e){
      var params = {
        'zeroAlert' : '至少选择一个用户',
        'isMultipleCheck' : true,
        'confirmAlert' : '确认是否要锁定改用户',
        'ajax' : {
          'url' : '<?php echo site_url("c=user&m=lock_user") ?>',
          'successCallback' : function(data, textStatus, jqXHR) {
            // alert(data.message);
            if(data.status == 300) {
              window.location.href=data.message;
            }
            console.log(jqXHR);
          },
          'dataType' : 'json'
        }
      }
      click_action(params);
    });

    $("#summer-unlock-user-btn").on('click', function(e){
      var params = {
        'zeroAlert' : '至少选择一个用户',
        'isMultipleCheck' : true,
        'confirmAlert' : '确认是否要解锁用户',
        'ajax' : {
          'url' : '<?php echo site_url("c=user&m=unlock_user") ?>',
          'successCallback' : function(data, textStatus, jqXHR) {
            // alert(data.message);
            if(data.status == 300) {
              window.location.href=data.message;
            }
            console.log(jqXHR);
          },
          'dataType' : 'json'
        }
      }
      click_action(params);
    });

    $('#summer-default-pwd-btn').on('click', function(e){
      var params = {
        'zeroAlert' : '至少选择一个用户',
        'isMultipleCheck' : true,
        'confirmAlert' : '确认是否要重置该用户密码',
        'ajax' : {
          'url' : '<?php echo site_url("c=user&m=set_default_password") ?>',
          'successCallback' : function(data, textStatus, jqXHR) {
            // alert(data.message);
            if(data.status == 300) {
              window.location.href=data.message;
            }

            if(data.status == 500) {
              alert(data.message);
            }
          },
          'dataType' : 'json'
        }
      }
      click_action(params);
    });

});
</script>