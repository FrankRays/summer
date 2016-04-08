
//提交数据，引用此类前必须进行
function doSub(data , subUrl, toUrl){
	$.post(subUrl, data, function(data, status){
		if(status == 'success'){
			data = JSON.parse(data);
			alert(data.msg);
			if(data.statusCode == 0){
				location.href = toUrl;
			}
		}else{
			alert("未知错误,操作位成功");
		}
	});
}