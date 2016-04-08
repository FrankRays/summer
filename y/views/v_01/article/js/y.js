/**
 * Created by ykjverx on 2015/3/12.
 */

$(function(){
	var dd = $('#y-article-category').selected();
	dd.on('change', function(){
		var categoryId = $("option:selected", this).val();
		document.location.href = siteUlr + '&category_id=' + categoryId;
	});

	$("#y-article-list").on('click',".y-article-del-btn", function(){
		var newsId = $(this).siblings("input").val();
		console.log(newsId);
		$.ajax({
			type : 'post',
			url : delUrl,
			dataType : 'json',
			data : {newsId : newsId},
			success : function(data){
				if(data.result && data.result == 'success'){
					layer.msg(data.content.msg, 2, function(){
						location.reload();
					});
				}else{
					layer.msg(data.content.msg, 2, 1);
				}
			},
			error : function(xhr){
				console.log(xhr.responseText);
				$.layer({
					type : 1,
					page : {
						html : xhr.responseText
					}
				});
			}
		});
	});


	$("#y-article-list").on('click', ".y-article-status-btn", function(){
		var newsId = $(this).siblings("input").val();
		$.ajax({
			type : 'post',
			url : statusSiteUrl,
			dataType : 'json',
			data : {newsId : newsId},
			success : function(data){
				if(data.result && data.result == 'success'){
					layer.msg(data.content.msg, 2, function(){
						location.reload();
					});
				}else{
					layer.msg(data.content.msg, 2, 1);
				}
			},
			error : function(xhr){
				console.log(xhr.responseText);
				$.layer({
					type : 1,
					page : {
						html : xhr.responseText
					}
				});
			}
		});
	});

	$("#y-article-list").on('click', ".y-article-setTop-btn", function(){
		var newsId = $(this).siblings("input").val();
		$.ajax({
			type : 'post',
			url : setTopUrl,
			dataType : 'json',
			data : {newsID : newsId},
			success : function(data){
				console.log(data);
				if(data.result && data.result == 'success'){
					layer.msg(data.content.msg, 2, function(){
						location.reload();
					});
				}else{
					layer.msg(data.content.msg, 2, 1);
				}
			},
			error : function(xhr){
				console.log(xhr.responseText);
				$.layer({
					type : 1,
					page : {
						html : xhr.responseText
					}
				});
			}
		});
	});

});