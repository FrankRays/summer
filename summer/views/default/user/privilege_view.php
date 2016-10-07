<?php defined('APPPATH') or exit('no access'); ?>
<div class="admin-content">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg"></strong> 
        </div>
    </div>
    <div class="am-g" >
        <div class="am-u-sm-12">
            <div class="am-panel am-panel-default">
              <div class="am-panel-hd">用户角色</div>
              <div class="am-panel-bd"><ul id="roletree" class="ztree"></ul>
              </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
	var setting = {	
		"callback" : {
			"beforeRename" : function(treeId, treeNode, newName, isCancel) {
				if(!isCancel) {
					var data = {
						"treeNode" 	: treeNode.name,
						"newName"	: newName
					};
					$.post("<?php echo site_url('c=user&m=rename_role_name') ?>", data, function(data, status, xh){
						console.log(data);
					});
				}
			},
			"onRename" : function(event, treeId, treeNode, isCancel) {
			}
		},
		"edit" : {
			"enable" : true,
			"renameTitle" : "重命名", 
			"removeTitle" : "删除节点",
		}
	};
	var zNodes = <?php echo $roletree ?>;
		$(document).ready(function(){
			$.fn.zTree.init($("#roletree"), setting, zNodes);
		});
</script>