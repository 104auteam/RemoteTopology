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

CSideMenu = {

	getAttr : function ( jqo, key ) {
		if (
			( typeof( jqo.attr( key ) ) == 'undefined' ) || 
			( jqo.attr( key ) == '' ) // for Opera
		) return "";
		return jqo.attr( key );
	},

	submenu : function( jqo_cont, b_open ) {
		b_open = b_open || !( this.getAttr(jqo_cont,"data-submenu") == "t" );

		var jqo = jqo_cont
			.eq(0)
			.find(".sidemenu-lvl2");

		if ( b_open ) {
			jqo.show();
			jqo_cont.attr("data-submenu","t");
		} else {
			jqo.hide();
			jqo_cont.attr("data-submenu","f");
		}
	},

	init : function() {
		$(".sidemenu-lvl2-sel")
			.parent(".sidemenu-lvl1-container")
			.find(".sidemenu-lvl2")
			.show();
		var _this = this;
		$(".sidemenu-lvl1").click(function(){
			var jqo_cont = $(this).parents(".sidemenu-lvl1-container");
			_this.submenu(jqo_cont);
		});
	}

};

$(document).ready(function(){
	CSideMenu.init();
});

}(jQuery));
