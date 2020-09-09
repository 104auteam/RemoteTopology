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

CDlgDT = {

	setup : function() {
		if ( this.b_setup ) { return; }
		this.b_setup = true;

		var _this = this;

		if ( !this.jqo_ctar ) {
			this.jqo_ctar = $(".dlgdt");
		}

		this.dp = new CDatePicker({
			jqo_ctar:this.jqo_ctar.find(".dtpk-ctar")
		});

		this.tp = new CTimePicker({
			jqo_ctar:this.jqo_ctar.find(".tipk-ctar")
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

		var w;
		switch ( this.time_format ) {
		case "HM":
			this.jqo_ctar.find(".tipk-s-ctar,.tipk-s-sepa").hide();
			w = 300;
			break;
		case "HMS":
			this.jqo_ctar.find(".tipk-s-ctar,.tipk-s-sepa").show();
			w = 410;
			break;
		}

		//-- rwindow
		this.rwin = new CRWindow({
			cwin:this,
			min_w:300,
			max_w:w
		});

		//-- set title
		if ( this.dlg_title ) {
			this.jqo_ctar.find(".dlg-heading-title")
				.html(this.dlg_title);
		}

		//-- set init val
		var d;
		if ( this.val ) {
			d = CDateTool.DateL(this.val);
		}

		if ( !d || isNaN(d) ) {
			d = new Date();
		}

		this.dp.setVal(d);
		this.tp.setVal(d);

		//-- open
		this.rwin.open();
	},

	pc_ok : function() {
		this.rwin.close();

		var ret = "";

		var dt_ymd = this.dp.getVal();
		if ( dt_ymd ) {
			var y = dt_ymd.getFullYear();
			var m = dt_ymd.getMonth();
			var d = dt_ymd.getDate();
			ret = y + "-" +
				("0"+(m+1)).slice(-2) + "-" +
				("0"+d).slice(-2);

			var dt_hms = this.tp.getVal();
			if ( dt_hms ) {
				var h = dt_hms.getHours();
				var m = dt_hms.getMinutes();
				var s = dt_hms.getSeconds();
				ret += " " +
					("0"+h).slice(-2) + ":" +
					("0"+m).slice(-2) + ":" +
					("0"+s).slice(-2);
			}
		}

		if ( this.onOK ) {
			this.onOK( ret );
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
