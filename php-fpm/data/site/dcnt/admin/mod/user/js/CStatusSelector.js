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

CStatusSelector = {

	setup : function( jqo_form, funcSearch ) {
		var _this = this;
		this.jqo_form = jqo_form;
		this.jqo_form.find(".select-status a").click(function(e){
			e.preventDefault();
			_this.procStatus($(this));
			funcSearch();
		});
		this.procStatus();
	},

	procStatus : function( jqo ) {
		jqo = jqo || null;
		if ( jqo == null ) {
			jqo = this.jqo_form.find('.select-status a[data-value="' +
			this.jqo_form.find('input[name="status"]').val() + '"]')
		}
		this.jqo_form.find('input[name="status"]').val(jqo.attr("data-value"));
		var jqo_btn = jqo.parents(".select-status").prevAll("button").eq(0)
		jqo_btn.find("span").eq(0).remove();
		jqo_btn.prepend(jqo.find("span").eq(0).clone());
	}

};

}(jQuery));
