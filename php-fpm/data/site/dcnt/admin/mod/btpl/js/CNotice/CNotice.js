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

CNotice = {

	t_show: 2,
	jqo_ctar : null,

	show : function( opt ) {
		for ( var key in opt ) { this[key] = opt[key]; }
		var _this = this;

		this.destroy();

		var icon;
		switch( this.ntype ) {
		case "success":
			icon = "blackboard";
			break;
		case "error":
			icon = "alert";
			break;
		}

		this.jqo_ctar = $("<div>")
			.attr("class","notice notice-"+this.ntype)
			.append('<span class="glyphicon glyphicon-'+icon+'"></span> ' +
				this.nmsg)
			.append($("<button>")
				.attr("class","close")
				.attr("type","button")
				.html($("<span>")
					.html("&times;")
				)
			)
			.append($("<div>")
				.attr("class","notice-pbar")
				.html($("<div>")
					.attr("class","notice-pbar-bar")
				)
			)
			.appendTo("body");

		this.b_anim_css3 = CDuan.canCssAnim();

		if ( this.b_anim_css3 ) {
			this.setup_anim_css3();
		} else {
			this.setup_anim_jq();
		}

		this.jqo_ctar
			.click(function(e){
				_this.hide();
			});
	},

	setup_anim_css3 : function() {
		var _this = this;

		this.jqo_ctar
			.addClass("notice-open")
			.one("animationend",function(){
				var me = $(this);
				$(this).find(".notice-pbar-bar")
					.css("animation-duration",_this.t_show+"s")
					.addClass("notice-pbar-bar-anim")
					.one("animationend",function(e){
						setTimeout(function(){
							_this.hide();
						},0);
					});
			});
	},

	setup_anim_jq : function() {
		var _this = this;

		this.jqo_ctar
			.hover(function(){
				$(this).find(".notice-pbar-bar").stop();
			},function(){
				//-- can't resume animation in jquery 
				_this.hide();
			})
			.css({
				bottom:"-50px"
			})
			.animate({
				bottom:0,
			},500,function(){
				$(this).find(".notice-pbar-bar")
				.animate({
					width:"100%",
				},_this.t_show*1000,function(){
					_this.hide();
				});
			});
	},

	hide : function() {
		var _this = this;

		if ( this.jqo_ctar != null ) {
			if ( this.b_anim_css3 ) {
				this.jqo_ctar
					.removeClass("notice-open")
					.addClass("notice-close")
					.one("animationend",function(e){
						_this.destroy();
					});
			} else {
				this.jqo_ctar
					.animate({
						opacity:0,
						bottom:"-50px"
					},1000,function(){
						_this.destroy();
					});
			}
		}
	},

	destroy : function() {
		if ( this.jqo_ctar != null ) {
			this.jqo_ctar.remove();
			this.jqo_ctar = null;
		}
	}

};

}(jQuery));
