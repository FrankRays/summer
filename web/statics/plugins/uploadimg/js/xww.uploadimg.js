(function($){
	$.fn.xwwUploadImg = function(options){
		var _this = this;

		if(!options.webuploader) {
			throw new Error("webuploader is not be setted");
			return ;
		}

		this.settings = $.extend({
			"deleteBtnSelect" : ".delete-image-btn",
			"upwardBtnSelect" : ".upward-image-btn",
			"downwardBtnSelect" : ".downward-image-btn"
		}, options);

		this.rendering = function(container){
			container.addClass('xww-uploadimg-container');
			var $tbody = container.find('tbody');
			$tbody.find('img').parent('td').addClass('xww-uploadimg-img-td')

			//create delete btn event
			_this.on('click', _this.settings.deleteBtnSelect, function(e){
				var tr = $(this).parents('tr').remove();
			});

			//create upward img tr event
			_this.on('click', _this.settings.upwardBtnSelect, function(e){
				var $thisTr = $(this).parents('tr');
				var $upwardTr = $thisTr.prev('tr');
				if($upwardTr.length != 0) {
					$upwardTr.before($thisTr);
				}
			});

			//create downward img tr event
			_this.on('click', _this.settings.downwardBtnSelect, function(e){
				var $thisTr = $(this).parents('tr');
				var $downwardTr = $thisTr.next('tr');
				if($downwardTr.length != 0) {
					$downwardTr.after($thisTr);
				}
			});

			//create webuploader event
			_this.settings.webuploader.on('uploadSuccess', function(file, response){
	            if(!response.file_uri) {
	                alert('上传失败');
	                return;
	            }
	            var btnStr = '<button type="button" class="am-btn am-btn-xs delete-image-btn" >删除</button>';
	            var upBtnStr = '<button type="button" class="am-btn am-btn-xs upward-image-btn" >上移</button>';
	            var downBtnStr = '<button type="button" class="am-btn am-btn-xs downward-image-btn" >下移</button>';
	            var btnGroup = '<div class="am-btn-toolbar"><div class="am-btn-group am-btn-group-xs">' + btnStr+upBtnStr+downBtnStr + '</div></div>';
	            $tbody.append("<tr><td><img src='"+response.file_uri+"' /></td><td><textarea></textarea></td><td>"+btnGroup+"</td></tr>");
	            //remove this upload file, then can upload it again
	            _this.settings.webuploader.removeFile(file);
			});

			return container;
		}


		return _this.rendering(this);
	}
})(jQuery);