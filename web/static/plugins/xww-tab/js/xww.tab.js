(function($){
	$.fn.xwwTab = function(options){
		var _this = this;

		this.settings = $.extend({
			"callback" : function(){},
			"animation" : "static",
			"animationTime" : 300
		}, options);

		this.rendering = function(container, flag) {
			container.each(function(idx, elem){
				var $elem = $(elem).addClass("xww-tab-wrapper");
				var $root = $elem.parents(".xww-tab-wrapper:last").addClass("xww-tab-wrapper-root");
				var $ul = $elem.children("ul").addClass("xww-tab-group");
				var $li = $ul.children("li").addClass("xww-tab-list");
				var $btn = $li.children("h2").addClass("xww-tab-btn");
				var $con = $li.children("div").addClass("xww-tab-container");

				$btn.bind("mouseover", function(even){
					if(!$(this).hasClass("active")) {
						$li.removeClass("active").children(".xww-tab-container, .xww-tab-btn").removeClass("active");
						$(this).parent(".xww-tab-list").addClass("active").children(".xww-tab-container, .xww-tab-btn").addClass("active");
					}
				});

				$li.filter(".active").find(".xww-tab-btn").triggerHandler("mouseover");
			});

			return container;
		}


		return _this.rendering(this, true);
	};
})(jQuery);