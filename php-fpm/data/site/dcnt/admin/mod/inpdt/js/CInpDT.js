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

function CInpDT( opt ) {
	for( var key in opt ) { this[key] = opt[key]; }
	this.setup();
};

CInpDT.prototype = {

	setup : function() {
		var _this = this;

		var isCR = function( evt ) {
			evt = (evt) ? evt : window.event;
			var cc = (evt.which) ? evt.which : evt.keyCode;
			return ( 13 == cc ); //CR
		};

		var isDateTimeChar = function( evt ) {
			evt = (evt) ? evt : window.event;
			var cc = (evt.which) ? evt.which : evt.keyCode;
			return (( 48 <= cc ) && ( cc <= 57 )) || //0-9
				( 32 == cc ) || //space
				( 45 == cc ) || // -
				( 58 == cc ) || // :
				( 47 == cc ) || // /
				(( 8 == cc ) || ( cc == 46 )); //backspace. delete
		};

		this.time_format = this.jqo_inp.attr("data-time-format");
		if (!this.time_format) {
			this.time_format = "HM";
		}

		var maxlen = ( this.time_format == "HM" ? 16 : 19 );

		this.jqo_inp
			.attr("maxlength",maxlen)
			.keypress(function(e) {
				if ( isCR(e.originalEvent) ) {
					e.preventDefault();
					_this.setVal($(this).val());
				}
				if ( !isDateTimeChar(e.originalEvent) ) {
					e.preventDefault();
				}
			})
			.blur(function(){
				_this.setVal($(this).val());
			});

		this.dlg_title = this.jqo_inp.attr("data-dlg-title");

		this.setupBtnOpen();
	},

	setupBtnOpen : function() {
		var _this = this;

		this.jqo_inp.before($("<span>")
			.attr("tabindex",0)
			.attr("class","input-group-addon inpdt-btn")
			.html($("<span>")
				.attr("class","glyphicon glyphicon-calendar")
			)
		);

		this.jqo_btn_open = this.jqo_inp.prev();
		this.jqo_btn_open
			.click(function(e){
				e.preventDefault();
				CDlgDT.open({
					val:_this.getVal(),
					dlg_title:_this.dlg_title,
					time_format:_this.time_format,
					onOK:function( val ){
						_this.setVal(val);
						_this.jqo_btn_open.focus();
					},
					onCancel:function(){
						_this.jqo_btn_open.focus();
					}
				});
			})
			.keydown(function(e){
				var evt = e.originalEvent;
				evt = (evt) ? evt : window.event;
				var cc = (evt.which) ? evt.which : evt.keyCode;
				if (( cc == 13 ) || ( cc == 32 )) {
					e.preventDefault();
					$(this).click();
				}
			});
	},

	getVal : function( val ) {
		return this.jqo_inp.val();
	},

	setVal : function( val ) {
		if ( val ) {
			var d = CDateTool.DateL(val);
			if ( !isNaN(d) ) {
				val = CDateTool.format(d,"YMD"+this.time_format);
			}
		} else {
			val = "";
		}
		this.jqo_inp.val(val);
	}

};

window.initCInpDT = function() {
	$(".inpdt").each( function(){
		if ( !$(this).data("_obj_") ) {
			var obj = new CInpDT({jqo_inp:$(this)});
			$(this).data("_obj_",obj);
		}
	});
};

}(jQuery));
