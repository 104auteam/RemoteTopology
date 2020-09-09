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

var CAbout = {

	init : function( opt ) {
		for ( var key in opt ) { this[key] = opt[key]; }

		this.jqo_inner = this.jqo_ctar.find(".about-inner");
		this.jqo_bar_top = this.jqo_ctar.find(".about-bar-top");
		this.jqo_bar_bottom = this.jqo_ctar.find(".about-bar-bottom");

		if ( CDuan.canCssAnim() ) {
			this.jqo_inner.addClass("about-inner-show");
			this.jqo_bar_top.addClass("about-bar-top-down");
			this.jqo_bar_bottom.addClass("about-bar-bottom-up");
		} else {
			this.jqo_inner.animate({
				opacity:1
			},1000);
		}
	}
};

$(document).ready(function(){
	CAbout.init({jqo_ctar:$(".about")});
});

}(jQuery));
