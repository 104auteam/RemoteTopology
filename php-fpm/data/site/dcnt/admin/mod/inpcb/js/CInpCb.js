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

function CInpCb( opt ) {
	for( var key in opt ) { this[key] = opt[key]; }
	this.setup();
};

CInpCb.prototype = {

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

		//-- checkbox/radio button
		if ( this.leIE8() ) {
			this.jqo_inp.show();
		} else {
			this.jqo_inp.wrap("<div class='inpcb-ctar' tabindex='0'></div>");
			this.jqo_cont = this.jqo_inp.parents('.inpcb-ctar')
				.append($("<div>")
					.attr("class","inpcb-inner")
					.html($("<span>")
						.attr("class","glyphicon glyphicon-ok inpcb-mark")
					)
				);
			this.jqo_inp.hide();

			//-- select/deselect checkbox/radio button
			var b_multi = true;
			var func = function(){
				var jqo_cont = $(this).parents(".inpcb-ctar");
				if  ( !b_multi ) {
					jqo_cont.removeClass('inpcb-ctar-on');
					jqo_cont.find('.inpcb-inner').removeClass('inpcb-inner-on');
					jqo_cont.find('.inpcb-mark').removeClass('inpcb-mark-on');
				}
				var jqo_inner = jqo_cont.find('.inpcb-inner');
				var jqo_mark = jqo_cont.find('.inpcb-mark');
				if ( $(this).is(':checked') ) {
					jqo_cont.addClass('inpcb-ctar-on');
					jqo_inner.addClass('inpcb-inner-on');
					jqo_mark.addClass('inpcb-mark-on');
				} else {
					if  ( b_multi ) {
						jqo_cont.removeClass('inpcb-ctar-on');
						jqo_inner.removeClass('inpcb-inner-on');
						jqo_mark.removeClass('inpcb-mark-on');
					}
				}
			};
			this.jqo_inp.change(func);
			func.call(this.jqo_inp);

			var _this = this;
			this.jqo_cont.keypress(function (e) {
				if ((e.which == 13) || (e.which == 32)) {
					e.preventDefault()
					var jqo = $(this).find("input");
					_this.jqo_inp.prop("checked",!jqo.is(':checked'));
					_this.jqo_inp.trigger("change");
				}
			});
		}
	},

	setDataFromFFE : function() {
		// do nothing
	}
};

window.initCInpCb = function() {
	$(".inpcb").each( function(){
		if ( !$(this).data("_obj_") ) {
			var obj = new CInpCb({jqo_inp:$(this)});
			obj.setDataFromFFE();
			$(this).data("_obj_",obj);
		}
	});
};

}(jQuery));
