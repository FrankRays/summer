<?php defined('APPPATH') or exit('no access'); ?>
<div class="admin-content">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg"></strong> 
        </div>
    </div>

    <div class="am-g">
      <div class="am-u-sm-12 am-u-md-6">
        <div class="am-btn-toolbar">
          <div class="am-btn-group am-btn-group-xs">
            <button id="create-child-btn" type="button" class="am-btn am-btn-default"><span class="am-icon-plus"></span>新增节点</button>
            <!-- <button type="button" class="am-btn am-btn-default"><span class="am-icon-save"></span> 保存</button>
            <button type="button" class="am-btn am-btn-default"><span class="am-icon-archive"></span> 审核</button> -->
            <button id="slider-del-article-btn" type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除</button>
          </div>
        </div>
      </div>
      <div class="am-u-sm-12 am-u-md-3">
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

<div id="create-child-form" class="am-g" style="display: none;">
	<div class="am-u-sm-12">
		<form action="" method="post" id="articleForm" class="am-form">
		    <div class="am-form-group">
				<label for="doc-ipt-email-1">父节点</label>
				<input type="email" class="" id="doc-ipt-email-1" placeholder="输入电子邮件">
			</div>
	        <div class="am-form-group">
	    		<label for="doc-ipt-email-1">几点名称</label>
	    		<input type="email" class="" id="doc-ipt-email-1" placeholder="输入电子邮件">
	    	</div>
	    	<p><button type="submit" class="am-btn am-btn-default">提交</button></p>
		</form>
	</div>
</div>


<script type="text/javascript">
	var setting = {	
		"callback" : {
			"beforeRename" : function(treeId, treeNode, newName, isCancel) {
				if(!isCancel) {
					var data = {
						"old_name" 	: treeNode.name,
						"new_name"	: newName
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
		},
		view : {
			selectedMulti : false,

		}
	};
	var zNodes = <?php echo $roletree ?>;
		$(document).ready(function(){
			var treeObj = $.fn.zTree.init($("#roletree"), setting, zNodes);

			function add(e) {
				//var treeObj = $.fn.zTree.getZTreeObj('roletree'),
				// is_parent = $treeObj.data.isParent,
				// notes = $treeObj.getSelectedNotes(),
				// treeNode = notes[0];

				// if(treeNode) {
				// 	$treeObj.addNodes(treeNode);
				// }
			}


			//new child node
			$("#create-child-btn").on('click', function(e){
				layer.open({
					title : "增加子节点"
					,type : 1
					,content : $("#create-child-form")
				});
			});
		});
</script>