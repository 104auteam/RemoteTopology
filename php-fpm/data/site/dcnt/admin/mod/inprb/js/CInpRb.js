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

function CInpRb( opt ) {
	for( var key in opt ) { this[key] = opt[key]; }
	this.setup();
};

CInpRb.prototype = {

	isIE7 : function()  {
		return (navigator.appVersion.indexOf("MSIE 7.")!=-1);
	},

	isIE8 : function() {
		return (navigator.appVersion.indexOf("MSIE 8.")!=-1);
	},

	leIE8 : function() {
		return this.isIE7() || this.isIE8();
	},

	setup : function(){

		//-- radio button
		if ( this.leIE8() ) {
			this.jqo_inp.show();
		} else {
			this.jqo_inp.wrap("<div class='inprb-ctar' tabindex='0'></div>");
			this.jqo_ctar = this.jqo_inp.parents('.inprb-ctar');
			this.jqo_inp.hide();

			//-- select radio button
			var func_update = function(){
				var jqo_prt = $(this).parents(".form-group");
				var nm = $(this).attr("name");
				jqo_prt.find('input:radio[name="'+nm+'"]').each(function(){
					var jqo_ctar = $(this).parents(".inprb-ctar");
					if ( $(this).is(':checked') ) {
						jqo_ctar.addClass('inprb-ctar-on');
						jqo_ctar.focus();
					} else {
						jqo_ctar.removeClass('inprb-ctar-on');
					}
				});
			};
			this.jqo_inp.change(func_update);
			func_update.call(this.jqo_inp);

			var _this = this;
			this.jqo_ctar.keypress(function (e) {
				if ((e.which == 13) || (e.which == 32)) {
					e.preventDefault()
					var jqo = $(this).find("input");
					if ( !jqo.is(':checked') ) {
						_this.jqo_inp.prop("checked",true);
						_this.jqo_inp.trigger("change");
					}
				}
			});
		}
	},

	setDataFromFFE : function() {
		// do nothing
	}
};

window.initCInpRb = function() {
	$(".inprb").each( function(){
		if ( !$(this).data("_obj_") ) {
			var obj = new CInpRb({jqo_inp:$(this)});
			obj.setDataFromFFE();
			$(this).data("_obj_",obj);
		}
	});
};

}(jQuery));
