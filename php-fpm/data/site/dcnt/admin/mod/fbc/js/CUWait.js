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

CUWait = {

	t_delay:1000,
	t_timeout:30*1000,

	b_waiting : 0,
	panel : null,
	overlay : null,
	timer_id : null,
	dice_id : 0,

	rand : function( min, max ) {
		return Math.floor((Math.random() * max) + min);
	},

	randColor : function() {
		var px = ["00","33","66","99","FF"];
		return "#" +
			px[this.rand(0,px.length)] +
			px[this.rand(0,px.length)] +
			px[this.rand(0,px.length)];
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

	onWindowResized : function() {
		this.overlay
			.css( "left", "0" )
			.css( "top", "0" )
			.css( "width", $(window).width() )
			.css( "height", $(window).height() );

		var vp = this.getViewport();

		var dp = {
			x:0,
			y:0,
			w:this.panel.outerWidth(),
			h:this.panel.outerHeight()
		}

		if ( vp.w <= dp.w ) {
			dp.x = vp.x;
		} else {
			dp.x = vp.x + ( vp.w - dp.w ) / 2;
		}

		if ( vp.h <= dp.h ) {
			dp.y = vp.y;
		} else {
			dp.y = vp.y + ( vp.h - dp.h ) / 2;
		}

		this.panel.css({
			"left" : dp.x + "px",
			"top" : dp.y + "px"
		})
	},

	createInner : function() {
		var nx = 2;
		var ny = 2;
		var dx = 20;
		var dy = 20;
		var w = 20-2;
		var h = 20-2;
		this.dice = [];
		for ( var y = 0; y < ny; y++ ) {
			for ( var x = 0; x < nx; x++ ) {
				this.dice.push(
					$("<div>")
					.css({
						position:"absolute",
						left:(x*dx)+"px",
						top:(y*dy)+"px",
						width:w+"px",
						height:h+"px"
					})
					.appendTo(this.panel)
				);
			}
		}
	},

	animateInner : function() {
		if ( this.dice_id >= this.dice.length ) {
			this.dice_id = 0;
		}
		var die = this.dice[this.dice_id];
		this.dice_id++;

		die.css({
			"background-color":this.randColor()
		});
	},

	create : function() {
		var z = CZIndex.currentZ()+100;

		//-- panel
		this.panel = $("<div>")
			.css({
				position:"absolute",
				left:"-10000px",
				top:"-10000px",
				width:"40px",
				height:"40px",
				margin:0,
				padding:0,
				opacity:0,
				filter:"alpha(opacity=0)",
				"z-index":z
			})
			.appendTo("body");

		//-- panel inner
		this.createInner();

		//-- overlay
		this.overlay = $("<div>")
			.css({
				position:"fixed",
				margin:0,
				padding:0,
				"background-color":"black",
				opacity:0,
				filter:"alpha(opacity=0)",
				"z-index":z-1
			})
			.appendTo('body');

		//-- resize handler
		var _this = this;
		this.resize_handler = function() {
			_this.onWindowResized();
		};
		this.resize_handler();
		$(window).bind( "resize", this.resize_handler );

		//-- show
		this.panel.show();
		this.overlay.show();

		//-- make it visible after t_delay
		var _this = this;
		setTimeout(function(){
			_this.visible();
		},this.t_delay);

		//-- stop it after timeout
		var _this = this;
		setTimeout(function(){
			_this.stop();
		},this.t_timeout);
	},

	visible : function() {
		if ( !this.b_waiting ) {
			return;
		}

		//-- panel
		this.panel
			.css({
				opacity:0.5,
				filter:"alpha(opacity=50)"
			});

		//-- panel inner
		var _this = this;
		this.timer_id = setInterval(function(){
			_this.animateInner();
		},100);

		//-- overlay
		this.overlay
			.css({
				opacity:0.2,
				filter:"alpha(opacity=20)"
			});
	},

	destroy : function() {
		if ( this.panel == null ) { return; }

		//-- panel inner
		if ( this.timer_id != null ) {
			clearInterval(this.timer_id);
			this.timer_id = null;
		}

		//-- resize handler
		$(window).unbind( "resize", this.resize_handler );

		//-- panel
		this.panel.fadeOut(function(){
			$(this).remove();
		});
		this.panel = null;

		//-- overlay
		this.overlay.fadeOut(function(){
			$(this).remove();
		});
		this.overlay = null;
	},

	start : function() {
		if ( !this.b_waiting ) {
			this.b_waiting = true;
			this.create();
		}
	},

	stop : function() {
		if ( this.b_waiting ) {
			this.destroy();
			this.b_waiting = false;
		}
	}

};

}(jQuery));
