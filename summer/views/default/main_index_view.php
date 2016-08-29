<?php

defined('APPPATH') OR exit('forbidden to access');
?>
<div class="admin-content">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg"><?php echo $module_name ?></strong> 
        </div>
    </div>
    <div class="am-g" >
        <div class="am-u-sm-6">
            <div class="am-panel am-panel-default">
              <div class="am-panel-hd">站点信息</div>
              <div class="am-panel-bd">
                <table class="am-table">
                    <tr>
                        <td>访问总量</td>
                        <td><?php echo $site['hits'] ?>次</td>
                    </tr>
                    <tr>
                        <td>访问总量</td>
                        <td><?php echo $site['hits'] ?>次</td>
                    </tr>
                </table>
              </div>
            </div>
        </div>
    </div>
</div>


<script>
</script>