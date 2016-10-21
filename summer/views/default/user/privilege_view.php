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
            <button id="edit-child-btn" type="button" class="am-btn am-btn-default"><span class="am-icon-edit"></span>修改节点</button>
            <!-- <button type="button" class="am-btn am-btn-default"><span class="am-icon-save"></span> 保存</button>
            <button type="button" class="am-btn am-btn-default"><span class="am-icon-archive"></span> 审核</button> -->
            <button id="delete-node-btn" type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除</button>
            <button id="reset-tree-btn" type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> Reset</button>
          </div>
        </div>
      </div>
      <div class="am-u-sm-12 am-u-md-3">
      </div>
    </div>

     <div class="am-g">
          <div class="am-u-sm-12">
    		<?php echo flash_msg()  ?>
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


<!-- hidden form -->
<div id="create-child-form" class="am-g" style="display: none;">
	<div class="am-u-sm-12">
	<?php echo form_open(site_url('c='.$controller_name.'&m=create_child'), array('class'=>'am-form', 'method'=>'post')) ?>
		    <div class="am-form-group">
				<label for="parent-name">父节点</label>
				<input type="text" id="parent-name" disabled="disabled" />
				<input type="hidden" name="parent_name_hidden" id="parent-name-hidden" />
			</div>
	        <div class="am-form-group">
	    		<label for="node-name">节点名称</label>
	    		<input type="text" name="node_name" id="node-name" placeholder="请输入节点名称">
	    	</div>
	    	<p><button type="submit" class="am-btn am-btn-default">提交</button></p>
		</form>
	</div>
</div>
<?php echo form_open(site_url('c='.$controller_name.'&m=delete_node'), array('id'=>'delete-node-form', 'method'=>'post')) ?>
	<input type="hidden" name="node_name" />
</form>
<div id="edit-node-form" class="am-g" style="display: none;">
	<div class="am-u-sm-12">
	<?php echo form_open(site_url('c='.$controller_name.'&m=edit_node'), array('class'=>'am-form', 'method'=>'post')) ?>
			<input type="hidden" name="node_name_hidden" id="node-name-hidden" />
	        <div class="am-form-group">
	    		<label for="node-name">节点名称</label>
	    		<input type="text" name="node_name" id="node-name" placeholder="请输入节点名称">
	    	</div>
		</form>
	</div>
</div>
<?php echo form_open(site_url('c='.$controller_name.'&m=reset_tree'), array('id'=>'reset-tree-form', 'method'=>'post')) ?>
	<input type="hidden" name="reset_tree" value="true" />
</form>
<!-- hidden form -->

<script type="text/javascript">

	var beforeDrop = function(treeId, treeNodes, targetNode, moveType) {
		console.log(treeNodes.name, targetNode.name, moveType);
		return !(targetNode == null || (moveType != "inner" && !targetNode.parentTId));
	}
	var setting = {	
		"callback" : {
			beforeDrop : beforeDrop
		},
		view : {
			selectedMulti : false,
		},
		edit : {
			enable : true
		}
	};
	var zNodes = <?php echo $roletree ?>;
		$(document).ready(function(){
			var treeObj = $.fn.zTree.init($("#roletree"), setting, zNodes);

			//new child node
			$("#create-child-btn").on('click', function(e){
				var treeNodes = treeObj.getSelectedNodes(),
				treeNode = treeNodes[0];
				if(treeNode) {
					layer.open({
						title : "增加子节点"
						,type : 1
						,content : $("#create-child-form")
						,success : createChildSuccess
					});
				} else {
					layer.msg('请选择需要添加子节点的父节点');
				}
			});

			var createChildSuccess = function(layero, index) {
				treeObj = $.fn.zTree.getZTreeObj('roletree'),
				treeNodes = treeObj.getSelectedNodes(),
				treeNode = treeNodes[0];
				layero.find("#parent-name").val(treeNode.name);
				layero.find("#parent-name-hidden").val(treeNode.name);
			}

			//delete node
			$("#delete-node-btn").on('click', function(e){
				var treeNodes = treeObj.getSelectedNodes(),
				treeNode = treeNodes[0];
				if(treeNode) {
					layer.open({
						title : '删除节点'
						,content : '是否要删除节点【' + treeNode.name + '】及其子节点'
						,icon : 3
						,yes : deleteNodeYes
					});
				} else {
					layer.msg("请选择需要删除的节点");
				}
			});

			var deleteNodeYes = function(index, layero) {
				treeObj = $.fn.zTree.getZTreeObj('roletree'),
				treeNodes = treeObj.getSelectedNodes(),
				treeNode = treeNodes[0];
				var hasSendRequest = -1;
				$("#delete-node-form").find("[name='node_name']").val(treeNode.name);
				$("#delete-node-form").trigger('submit');
			}

			//edit node 
			$('#edit-child-btn').on('click', function(e){
				var treeNodes = treeObj.getSelectedNodes(),
				treeNode = treeNodes[0];
				if(treeNode) {
					$("#edit-node-form").find("[name='node_name_hidden']").val(treeNode.name);
					layer.open({
						title : '修改节点'
						,type : 1
						,btn : ['确定', '取消']
						,content : $('#edit-node-form')
						,yes : editNodeYes
					});
				} else {
					layer.msg("请选择需要修改的节点");
				}
			});

			var editNodeYes = function(index, layero) {
				$("#edit-node-form form").trigger('submit');
			}

			//reset the tree
			$('#reset-tree-btn').on('click', function(e){
				layer.open({
					title : '确认是否要重置树'
					,type : 0
					,btn : ['确定', '取消']
					,content : '是否要重置树'
					,yes : function(index, layero) {
						$('#reset-tree-form').trigger('submit');
					}
				});
			});
		});
</script>