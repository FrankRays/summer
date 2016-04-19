<?php
/**
 * Created by PhpStorm.
 * User: ykjverx
 * Date: 2015/3/12
 * Time: 22:52
 */
?>
<div class="admin-content" style="min-height:1500px;">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg"><?php echo $content['moduleName'] ?></strong> /
            <small><?php echo $content['moduleDesc'] ?></small>
        </div>
    </div>
    <h2 class="am-u-sm-8">抓取总数:<?php echo $content['total'] ?>(限2015年1月1日开始)</h2>
    <div class="am-g" >
    <div class="am-u-sm-2"></div>
    <div class="am-u-sm-8">
      <table class="am-table am-table-bordered am-table-striped am-table-hover am-table-compact">
      <thead>
        <tr>
          <th>部门名称</th>
          <th>文章数量</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($content['groupTotal'] as $k => $v){ ?>
          <tr>
            <td><?php echo $v['category_name'] ?></td>
            <td><?php echo $v['total'] ?></td>
          </tr>
        <?php } ?>
      </tbody>
      </table>
    </div>
    <div class="am-u-sm-2"></div>
    </div>
</div>

<script>
</script>