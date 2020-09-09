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

CDlgInterval = {

	setup : function() {
		if ( this.b_setup ) { return; }
		this.b_setup = true;

		var _this = this;

		if ( !this.jqo_ctar ) {
			this.jqo_ctar = $(".dlginterval");
		}

		this.tivl = new CTimeInterval({
			jqo_ctar:this.jqo_ctar.find(".tivl-ctar")
		});

		this.jqo_ctar.find(".btn-ok")
			.click( function(e){
				e.preventDefault();
				_this.pc_ok();
			});

		this.jqo_ctar.find(".btn-cancel,.btn-close")
			.click( function(e){
				e.preventDefault();
				_this.pc_cancel();
			});
	},

	open : function( opt ) {
		for( var key in opt ) { this[key] = opt[key]; }
		this.setup( opt );

		//-- rwindow
		this.rwin = new CRWindow({
			cwin:this,
			min_w:300,
			max_w:300
		});

		//-- set init val
		var d;
		if ( this.val ) {
			this.tivl.setVal(this.val);
		}

		//-- open
		this.rwin.open();
	},

	pc_ok : function() {
		this.rwin.close();

		if ( this.onOK ) {
			this.onOK( this.tivl.getVal() );
		}
	},

	pc_cancel : function() {
		this.rwin.close();

		if ( this.onCancel ) {
			this.onCancel();
		}
	}

};

}(jQuery));
