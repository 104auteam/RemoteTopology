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

CDlgDtc = {

	isESC : function( e ) {
		var cc = e.which;
		return ( cc == 27 );
	},

	setup : function( opt ) {
		for ( var key in opt ) { this[key] = opt[key]; }

		var _this = this;

		this.jqo_inner = this.jqo_ctar.find(".dlgdtc-inner");
		this.jqo_btn_ok = this.jqo_ctar.find(".btn-ok");
		this.jqo_btn_cancel = this.jqo_ctar.find(".btn-cancel");

		this.jqo_ctar
			.keydown(function(e){
				if ( _this.isESC(e) ) {
					e.preventDefault();
					_this.pc_cancel();
				}
			});

		this.jqo_ctar.find(".btn-cancel,.btn-close")
			.click( function(e){
				e.preventDefault();
				_this.pc_cancel();
			});

		this.rwin = new CRWindow({
			pos:"right",
			cwin:this,
			min_w:280,
			max_w:280,
			min_h:200,
			max_h:-1,
		});
	},

	open : function() {
		//-- open
		this.rwin.open();

		//-- focus
		this.jqo_ctar.find(".page-navi-inp-pageno")
			.select();
	},

	close : function( b_quick ) {
		this.rwin.close(b_quick);
		this.jqo_ctar.remove();
	},

	pc_cancel : function() {
		this.rwin.close();
		if ( this.onCancel ) {
			this.onCancel();
		}
	},

	onRedraw : function() {
		this.jqo_ctar.css({
			width:this.rwin.jqo_rwin.width() + "px",
			height:this.rwin.jqo_rwin.height() + "px"
		});

		// 50 for heading, 10 for padding, 50 for footer 
		var heading = 50;
		var padding = 10;
		var footer = 0;
		var h = (this.jqo_ctar.height()-
			(heading + padding*2 + footer));
		this.jqo_inner.css({
			height:h + "px"
		});
	}
};

}(jQuery));
