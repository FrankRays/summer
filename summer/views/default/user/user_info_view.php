<?php defined('APPPATH') or exit('no access'); ?>
<div class="admin-content">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg"><?php echo $module_name ?></strong> 
        </div>
    </div>
    <div class="am-g" >
        <div class="am-u-sm-12">
            <div class="am-panel am-panel-default">
              <div class="am-panel-hd">用户信息</div>
              <div class="am-panel-bd">
                <table class="am-table">
                    <tr>
                        <td>帐号</td>
                        <td><?php echo $user['account'] ?></td>
                    </tr>	
                </table>
              </div>
            </div>
        </div>
    </div>
</div>
