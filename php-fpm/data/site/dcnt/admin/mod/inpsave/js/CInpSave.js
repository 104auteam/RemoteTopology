/*js
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// AjaxCountDown v1.02
// Copyright (c) phpkobo.com ( http://www.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : DCAET-102
// URL : http://www.phpkobo.com/ajax-countdown
//
// This software is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; version 2 of the
// License.
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<
*/

(function($){
/*
	# receive start event
	$(".selector").bind("start",function(){
		...............
		...............
		...............
	});

	# send end event
	$(".selector").trigger("end");
*/
function CInpSave( opt ) {
	for( var key in opt ) { this[key] = opt[key]; }

	var lca = CJRLdr.locale("inpsave/button");
	this.jqo_cont.html(lca["label:btn"]);
	this.str_progressing = lca["label:btn:progressing"];
	this.str_complete = lca["label:btn:complete"];
	this.str_error = lca["label:btn:error"];
	this.b_active = false;
	this.b_blinking = false;
	this.setup();
};

CInpSave.prototype = {

	blink : function( t ) {
		if ( !this.b_blinking ) { return; }

		var _this = this;
		this.cnt++;
		if ( ( this.cnt % 2 ) == 0 ) {
			var opa = 1;
		} else {
			var opa = 0;
		}
		this.jqo_cont.animate({
			opacity:opa
		},t,function(){
			setTimeout(function(){
				_this.blink();
			},0)
		});
	},

	timeout : function( t, func ) {
		var _this = this;
		setTimeout(function(){
			func.call(_this);
		},t);
	},

	scrollX : function( str, t, func ) {
		var _this = this;
		var w = this.jqo_cont.width();
		this.jqo_inner
		.animate({
			left:-w+"px"
		},t,function(){
			$(this)
			.css({
				left:w+"px"
			})
			.html(str)
			.animate({
				left:0
			},t,function(){
				func.call(_this);
			})
		});
	},

	scrollY : function( str, t, func ) {
		var _this = this;
		var h = this.jqo_cont.height();
		this.jqo_inner
		.animate({
			top:h+"px"
		},t,function(){
			$(this)
			.css({
				top:-h+"px"
			})
			.html(str)
			.animate({
				top:0
			},t,function(){
				func.call(_this);
			})
		});
	},

	onClick : function() {
		if ( this.b_active ) { return; }
		this.b_active = true;
		this.jqo_cont
			.removeClass("inpsave-hover")
			.css({
				cursor:"auto"
			});
			

		this.jqo_inner.html(this.str_progressing);

		this.cnt = 0;
		this.b_blinking = true;
		this.blink(400);
		this.jqo_cont.trigger("start");
	},

	onEnd : function( b ) {
		if ( !this.b_active ) { return; }
		this.b_blinking = false;

		this.jqo_cont
			.stop(true,true)
			.css("opacity",1);

		if ( b ) {
			var str = this.str_complete;
			var selector = "inpsave-complete";
		} else {
			var str = this.str_error;
			var selector = "inpsave-error";
		}

		this.scrollY(str,200,function(){
			this.jqo_cont.addClass(selector);
			this.timeout(2000,function(){
				this.scrollX(this.str_init,200,function(){
					this.jqo_cont
						.css({
							cursor:"pointer"
						})
						.removeClass(selector);
					this.b_active = false;
				});
			});
		});
	},

	setup : function() {
		var _this = this;

		this.str_init = this.jqo_cont.html();
		this.jqo_cont.wrapInner("<div class='inpsave-inner'></div>");
		this.jqo_inner = this.jqo_cont.find(".inpsave-inner");
		var w = this.jqo_inner.width();
		this.jqo_inner.css({
			position:"relative"
		});

		this.jqo_cont.bind("end",function(){
			_this.onEnd(true);
		});

		this.jqo_cont.bind("error",function(){
			_this.onEnd(false);
		});

		this.jqo_cont
		.mouseenter(function(e){
			if ( !_this.b_active ) {
				$(this).addClass("inpsave-hover");
			}
		})
		.mouseleave(function(e){
			$(this).removeClass("inpsave-hover");
		})
		.click(function(e){
			_this.onClick();
		})
		.keypress(function(e) {
			if (e.which == 13) {
				_this.onClick();
			}
		});

	}
};

window.initCInpSave = function() {
	$(".inpsave").each( function(){
		if ( !$(this).data("_obj_") ) {
			var obj = new CInpSave({jqo_cont:$(this)});
			//obj.setDataFromFFE();
			$(this).data("_obj_",obj);
		}
	});
};

}(jQuery));
