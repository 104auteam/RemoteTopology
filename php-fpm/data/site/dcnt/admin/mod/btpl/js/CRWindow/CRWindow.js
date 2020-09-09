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

function CRWindow( opt ) {
	for ( var key in opt ) { this[key] = opt[key]; }
	this.class_rwindow = "rwindow";
	this.class_overlay = "roverlay";
	if ( !this.pos ) {
		this.pos = "middle";
	}
};

CRWindow.prototype = {

	b_open : false,
	setup : function() {
		if ( this.b_setup ) { return; }
		this.b_setup = true;

		var _this = this;

		this.cwin.jqo_ctar.appendTo("body");

		this.jqo_overlay = $( "<div>" )
			.attr( "class", this.class_overlay )
			.click( function(e) {
				_this.close();
			})
			.appendTo( $('body') );

		this.jqo_rwin = $( "<div>" )
			.attr( "class", this.class_rwindow )
			.click( function(e){
				//-- prevent clicks from
				//-- going down to overlay
				e.stopPropagation();
			})
			.html( this.cwin.jqo_ctar )
			.appendTo( this.jqo_overlay );

		//-- border
		switch(this.pos) {
		case "middle":
			this.border_w = 10;
			this.jqo_rwin.addClass("rwindow-border-d");
			break;

		default:
			this.border_w = 0;
			this.jqo_rwin.addClass("rwindow-border-0");
			break;
		}

		this.cwin.jqo_ctar.show();

		this.resize_handler = function() {
			_this.redraw();
		};
	},

	getViewport : function() {
		var win = $(window);
		return {
			'x':win.scrollLeft(),
			'y':win.scrollTop(),
			'w':win.width(),
			'h':win.height()
		};
	},

	redraw : function() {

		//-- calc min, max 
		this.size = {
			min_w:this.min_w,
			max_w:this.max_w,
			min_h:this.min_h,
			max_h:this.max_h
		};

		//-- overlay
		this.jqo_overlay
			.css( "left", "0" )
			.css( "top", "0" )
			.css( "width", $(window).width() )
			.css( "height", $(window).height() );

		var vp = this.getViewport();

		//-- padding between rwindow and viewport
		var dw = ( vp.w <= 600 ) ? 0 : 10;
		var dh = ( vp.h <= 600 ) ? 0 : 10;

		//-- initial rwindow widht and height
		var dp = {
			w:vp.w - dw*2,
			h:vp.h - dh*2
		};

		//-- calc width from min & max width
		if ( this.size.min_w ) {
			if ( dp.w < this.size.min_w ) {
				dp.w = this.size.min_w;
			}
		}

		if ( this.size.max_w  ) {
			if ( this.size.max_w == -1 ) {
				dp.w = vp.w;
			} else if ( dp.w > this.size.max_w ) {
				dp.w = this.size.max_w;
			}
		}

		//-- calc x-position
		dp.x = vp.x + ( vp.w - dp.w ) / 2;

		//-- calc min & max height
		if ( !this.min_h && !this.max_h ) {

			this.jqo_rwin.css({
				width:dp.w+"px"
			});

			this.cwin.jqo_ctar.addClass("dlg-rel");

			this.size.min_h = this.size.max_h =
				this.cwin.jqo_ctar.outerHeight(true)+(this.border_w*2);
 		}

		//-- calc height from min & max height
		if ( this.size.min_h  ) {
			if ( dp.h < this.size.min_h ) {
				dp.h = this.size.min_h;
			}
		}

		if ( this.size.max_h ) {
			if ( dp.h > this.size.max_h ) {
				dp.h = this.size.max_h;
			}
		}

		switch(this.pos) {
		case "top":
		case "bottom":
			dp.y = 0;
			break;

		case "left":
		case "right":
			dp.y = 50;
			if ( this.max_h == -1 ) {
				dp.h = vp.h - dp.y;
			}
			break;

		default:
			//-- calc y-position
			var n = 3;// 2,3,4...
			dp.y = ( vp.h - dp.h ) / n;
			break;
		}

		//-- set rwindow's width, height, x&y positions
		switch(this.pos) {
		case "top":
			this.rect = {
				top : 0,
				left : dp.x + "px",
				width : dp.w + "px",
				height : dp.h + "px"
			};
			break;

		case "bottom":
			this.rect = {
				bottom : 0,
				left : dp.x + "px",
				width : dp.w + "px",
				height : dp.h + "px"
			};
			break;

		case "right":
			this.rect = {
				right : 0,
				top : dp.y + "px",
				width : dp.w + "px",
				height : dp.h + "px"
			};
			break;

		case "left":
			this.rect = {
				left : 0,
				top : dp.y + "px",
				width : dp.w + "px",
				height : dp.h + "px"
			};
			break;

		default:
			this.rect = {
				left : dp.x + "px",
				top : dp.y + "px",
				width : dp.w + "px",
				height : dp.h + "px"
			};
			break;
		}

		this.jqo_rwin.css(this.rect);

		//-- call callback function
		if ( this.cwin.onRedraw ) {
			this.cwin.onRedraw();
		}
	},

	open : function() {
		this.setup();

		this.jqo_overlay.css({"z-index":CZIndex.capture()});
		$( window ).bind( "resize", this.resize_handler );
		this.jqo_overlay.show();

		this.redraw();

		var css_rec;
		var ani_rec;
		switch(this.pos) {
		case "top":
			css_rec = {
				top:"-="+this.rect.height,
				opacity:0
			};
			ani_rec = {
				top:"+="+this.rect.height,
				opacity:1
			};
			break;

		case "bottom":
			css_rec = {
				bottom:"-="+this.rect.height,
				opacity:0
			};
			ani_rec = {
				bottom:"+="+this.rect.height,
				opacity:1
			};
			break;

		case "right":
			css_rec = {
				right:"-="+this.rect.width,
				opacity:0
			};
			ani_rec = {
				right:"+="+this.rect.width,
				opacity:1
			};
			break;

		case "left":
			css_rec = {
				left:"-="+this.rect.width,
				opacity:0
			};
			ani_rec = {
				left:"+="+this.rect.width,
				opacity:1
			};
			break;

		default:
			css_rec = {
				top:"-=30px",
				opacity:0
			};
			ani_rec = {
				top:"+=30px",
				opacity:1
			};
			break;
		}

		this.jqo_rwin
			.css(css_rec)
			.animate(ani_rec,300);

		this.b_open = true;
	},

	close : function( b_quick ) {
		if ( !this.b_open ) { return; }

		b_quick = b_quick || false;
		var t_close = b_quick ? 0 : 300;

		var _this = this;

		var ani_rec;
		switch(this.pos) {
		case "top":
			ani_rec = {
				top:"-="+this.rect.height,
				opacity:0
			};
			break;

		case "bottom":
			ani_rec = {
				bottom:"-="+this.rect.height,
				opacity:0
			};
			break;

		case "right":
			ani_rec = {
				right:"-="+this.rect.width,
				opacity:0
			};
			break;

		case "left":
			ani_rec = {
				left:"-="+this.rect.width,
				opacity:0
			};
			break;

		default:
			ani_rec = {
				top:"-=30px",
				opacity:0
			};
			break;
		}

		this.jqo_rwin
			.animate(ani_rec,t_close,function(){
				_this.jqo_overlay.hide();
				_this.b_open = false;
			});

		$( window ).unbind( "resize", this.resize_handler );
		CZIndex.release();
	}

};

window.CRWindow = CRWindow;

}(jQuery));
