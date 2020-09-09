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

function CInpInterval( opt ) {
	for( var key in opt ) { this[key] = opt[key]; }
	this.setup();
};

CInpInterval.prototype = {

	setup : function() {
		var _this = this;

		this.lca = CJRLdr.locale("inpinterval/inpinterval");

		this.jqo_inp
			.keypress(function(e) {
				e.preventDefault();
			});

		this.setupBtnOpen();
		this.setVal(parseInt(this.jqo_inp.attr("data-val")));
	},

	setupBtnOpen : function() {
		var _this = this;

		this.jqo_inp.before($("<span>")
			.attr("tabindex",0)
			.attr("class","input-group-addon inpdt-btn")
			.html($("<span>")
				.attr("class","glyphicon glyphicon-time")
			)
		);

		this.jqo_btn_open = this.jqo_inp.prev();
		this.jqo_btn_open
			.click(function(e){
				e.preventDefault();
				CDlgInterval.open({
					val:_this.getVal(),
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

		this.jqo_inp
			.click(function(e){
				e.preventDefault();
				_this.jqo_btn_open.click();
			})
			.keydown(function(e){
				e.preventDefault();
				$(this).click();
			});

	},

	getVal : function() {
		return parseInt(this.jqo_inp.attr("data-val"));
	},

	setVal : function( val ) {
		this.jqo_inp.attr("data-val",val)

		var n = val;
		var d = Math.floor(n / (60*60*24));
		n = n % (60*60*24);
		var h = Math.floor(n / (60*60));
		n = n % (60*60);
		var m = Math.floor(n / (60));
		var s = n % (60);

		var pat = this.lca["tpl:display-format"];
		var str = pat;
		str = str.replace("%d%",d);
		str = str.replace("%day-s%",(d==1)?"":"s");
		str = str.replace("%h%",("0"+h).slice(-2));
		str = str.replace("%m%",("0"+m).slice(-2));
		str = str.replace("%s%",("0"+s).slice(-2));

		this.jqo_inp.val(str);
	},

	getData : function() {
		return this.getVal();
	}

};

window.initCInpInterval = function() {
	$(".inpinterval").each( function(){
		if ( !$(this).data("_obj_") ) {
			var obj = new CInpInterval({jqo_inp:$(this)});
			$(this).data("_obj_",obj);
		}
	});
};

}(jQuery));
