;(function($, window, document){
	"use strict";
	function Scroll(obj, options){
		this.options = options;
		this.obj = obj;
		this.i = 0;
		this.size = 0;
		this.init = function(){
			if(isNaN(options.width)){
				var a = options.width;
				var widthPer = parseFloat(a.substring(0,a.indexOf('%'))/100);
				options.width = obj.parent().innerWidth()*widthPer;
			}
			if(isNaN(options.height)){
				var b = options.height;
				var heightPer = parseFloat(b.substring(0,b.indexOf('%'))/100);
				options.height =  obj.parent().height()*heightPer;
			}
			this.initWrap(obj, options);
			this.initDot(obj);
			obj.find('.num li').first().addClass('on');
			if(options.showBtn){
				this.initBtn(obj);
			}
			this.lrEvent(obj, options);
			this.hoverMouse(obj, options);
			if(options.autoSlider){
				this.setTimeScroll(obj, options);
			}
		}
	};
	Scroll.prototype = {
		initWrap : function(){
			var that = this;
			if(!that.options.wReszie){
				var clone = that.obj.find('ul :first').find('li').first().clone();
				that.obj.children('ul').first().append(clone);
			}
			that.obj.css('width', that.options.width);
			that.obj.css('height', that.options.height);
			that.obj.find('ul img').css('width', that.options.width);
			that.obj.find('ul img').css('height', that.options.height);
			that.size = that.obj.find('ul').first().find('li').length;
		},
		initDot : function(){
			var that = this;
			that.obj.find('.num').remove();
			var ulWrap = '<ul class="num"></ul>';
			that.obj.children('ul').first().after(ulWrap);
			for(var j = 0; j < that.size-1; j++){
				that.obj.find('.num').append('<li></li');
			}
		},
		initBtn : function(){
			var that = this;
			that.obj.find('.btn').remove();
			var btnWrap = '<div class="btn btn_l">&lt;</div><div class="btn btn_r">&gt;</div>';
			that.obj.append(btnWrap);
		},
		lrEvent : function(){
			var that = this;
			that.obj.find('.btn_l').click(function(){
				that.i++;
				that.move();
			})
			that.obj.find('.btn_r').click(function(){
				that.i--;
				that.move();
			})
		},
		move : function(){
			var that = this;
			if(that.i == that.size){
				that.obj.children('ul').first().css({left:0})
				that.i = 1;
			}
			if(that.i == -1){
				if(that.options.direction != "fade"){
					that.obj.children('ul').first().css({left : -that.options.width*(that.size - 1)});
				}
				that.obj.children('ul').first().css({left : -that.options.width*(that.size - 1)})
				that.i = that.size -2;
			}
			if(that.options.direction == "fade"){
				that.jy(that.i);
			}else{
				that.obj.children('ul').first().stop().animate({left : -that.options.width*that.i},500);
			}
			if(that.i== that.size-1){
				that.obj.find('.num li').eq(0).addClass('on').siblings().removeClass('on');
			}else{
				that.obj.find('.num li').eq(that.i).addClass('on').siblings().removeClass('on');
			}
		},
		hoverMouse : function(){
			var that = this;
			that.obj.find('.num li').hover(function(){
				var index = $(this).index();
				that.i = index;
				if(that.options.direction == "fade"){
					that.jy(index);
				}else{
					that.obj.children('ul').first().stop().animate({left : -that.options.width*index},500);
				}
				$(this).addClass('on').siblings().removeClass('on');
			})
		},
		jy : function(index){
			var that = this;
			that.obj.children('ul').first().children().css({'float' : 'none', 'display' : 'block', 'position' : 'absolute', 'left' : '0', 'top' : '0'});
			that.obj.children('ul').first().children().siblings().stop().animate({'opacity':0},300).eq(index).stop().animate({'opacity':1},300);
		},
		setTimeScroll : function(){
			var that = this;
			/* 自动轮播*/
			var t = setInterval(function(){
				if(that.options.direction == "left"){
					that.i++;
				}else if(that.options.direction == "right"){
					that.i--;
				}else{
					that.i++;
				};
				if(that.size > 2){
					that.move();
				}
			},that.options.timeout);

			/* 对banner定时器的操作*/
			that.obj.hover(function(){
				clearInterval(t);
			},function(){
				t = setInterval(function(){
				if(that.options.direction == "left"){
					that.i++;
				}else if(that.options.direction == "right"){
					that.i--
				};
				if(that.size > 2){
					that.move();
				}
				},that.options.timeout);
			})
		}


	}


	/* 扩展jQuery的方法 图片轮播方法 */
	$.fn.daqScroll = function(options){
		var defaults = {
			direction : "left",
			timeout : 2000,
			autoSlider : true,
			showBtn : true,
			wReszie :false,
			width : $(this).width(),
			height : $(this).height()
		}
		var options = $.extend(defaults, options);
		var dscroll = new Scroll($(this), options);
		dscroll.init();
	}

})(jQuery, window, document);


;(function($, window, document){
	"use strict";
	function Scroll(obj, options){
		this.options = options;
		this.obj = obj;
		this.i = 0;
		this.size = 0;
		this.init = function(){
			this.initWrap(obj, options);
			this.lrEvent(obj, options);
			this.hoverMouse(obj, options);
			if(options.autoSlider){
				this.setTimeScroll(obj, options);
			}
		}
	};
	Scroll.prototype = {
		initWrap : function(){
			var that = this;
			var clone = that.obj.find('ul li:lt(5)').clone().addClass('clone');
			that.obj.children('ul').first().append(clone);
			that.size = that.obj.find('ul li').length;
		},
		lrEvent : function(){
			var that = this;
			$('.btn_left').click(function(){
				that.i++;
				that.move();
			})
			$('.btn_right').click(function(){
				that.i--;
				that.move();
			})
		},
		move : function(){
			var that = this;
			if(that.i == that.size - 4){
				that.obj.children('ul').first().css({left:0})
				that.i = 1;
			}
			if(that.i == -1){
				that.obj.children('ul').first().css({left : 0 -that.options.width*(that.size - 5)})
				that.i = that.size -6;
			}
			that.obj.children('ul').first().stop().animate({left : 0 -that.options.width*that.i},500);
			
		},
		hoverMouse : function(){
			var that = this;
			that.obj.find('.num li').hover(function(){
				var index = $(this).index();
				that.i = index;
				that.obj.children('ul').first().stop().animate({left : -that.options.width*index},500);
			})
		},
		setTimeScroll : function(){
			var that = this;
			/* 自动轮播*/
			var t = setInterval(function(){
				if(that.options.direction == "left"){
					that.i++;
				}else if(that.options.direction == "right"){
					that.i--;
				}else{
					that.i++;
				};
				if(that.size > 2){
					that.move();
				}
			},that.options.timeout);

			/* 对banner定时器的操作*/
			that.obj.hover(function(){
				clearInterval(t);
			},function(){
				t = setInterval(function(){
				if(that.options.direction == "left"){
					that.i++;
				}else if(that.options.direction == "right"){
					that.i--
				};
				if(that.size > 2){
					that.move();
				}
				},that.options.timeout);
			})
		}


	}


	/* 扩展jQuery的方法 左右图片轮播方法 */
	$.fn.hScroll = function(options){
		var defaults = {
			direction : "left",
			timeout : 2000,
			autoSlider : true,
			showBtn : true,
			width : 220
		}
		var options = $.extend(defaults, options);
		var dscroll = new Scroll($(this), options);
		dscroll.init();
	}

})(jQuery, window, document);