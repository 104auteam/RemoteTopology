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

CScrollBtn = {

	isIE7 : function() {
		return (navigator.appVersion.indexOf("MSIE 7.")!=-1);
	},

	isTouchDevice : function() {
		return (('ontouchstart' in window) ||
			(navigator.MaxTouchPoints > 0) ||
			(navigator.msMaxTouchPoints > 0));
	},

	setGlyphicon : function() {
		$('.glyphicon').css('margin','0 3px');
		$('.glyphicon').each(function() {
			var gly = {
				"circle-arrow-up":"&#xe133;",
				"circle-arrow-down":"&#xe134;"
			};

			var class_name = $(this).attr('class');
			var regExp = /glyphicon-([a-z\-]+)/;
			if ( mx = regExp.exec(class_name) ) {
				var n = mx[1];
				if ( n in gly ) {
					$(this).html(gly[n]);
				}
			}
		});
	},

	setup : function() {
		var txt = 
			"<div class='scrollbtn-cont'>"+
				"<div class='scrollbtn-btn scrollbtn-gotop'"+
					">"+
					"<span class='glyphicon glyphicon-circle-arrow-up'></span>"+
				"</div>"+
				"<div class='scrollbtn-btn scrollbtn-gobottom'"+
					">"+
					"<span class='glyphicon glyphicon-circle-arrow-down'></span>"+
				"</div>"+
			"</div>";
		$(txt).appendTo("body");

		if ( this.isIE7() ) {
			this.setGlyphicon();
		}

		function scrollToX( loc ) {
			var  y = 0;
			if ( loc == '@top' ) {
				y = 0;
			} else if ( loc == '@bottom' ) {
				var  viewport_height =
					Math.max(
						document.documentElement.clientHeight,
						window.innerHeight || 0);

				y =  $(document).height()-viewport_height;
			}

			var t = 1000;
			var dx = $(document).height() - $(window).height();
			if ( dx < 1000 ) {
				t = dx;
			}

			$('html, body').stop().animate({
				scrollTop: y
			}, t /*,'easeInOutExpo'*/);
		};

		$('.scrollbtn-gotop').click(function(e){
			e.preventDefault();
			scrollToX( "@top" );
		});

		$('.scrollbtn-gobottom').click(function(e){
			e.preventDefault();
			scrollToX( "@bottom" );
		});
	},

	update : function() {
		var jqo = $('.scrollbtn-cont');
		if ( jqo.length ) {
			setTimeout(function(){
				var b = ( $(document).height() > $(window).height() + 100 ) &&
					( $(document).width() > 800 );
				if ( b ) {
					jqo.show();
				} else {
					jqo.hide();
				}
			},800);
		}
	},

	init : function() {
		if ( !this.isTouchDevice() ) {
			this.setup();
			var _this = this;
			var resize_window = function() {
				_this.update();
			};
			resize_window();
			$( window ).bind( "resize", resize_window );
		}
	}

};

$(document).ready(function(){
	CScrollBtn.init();
});

}(jQuery));
