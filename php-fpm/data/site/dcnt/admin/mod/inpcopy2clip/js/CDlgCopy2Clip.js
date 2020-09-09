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

function selectText( jqo ) {
	var text = jqo.get(0);
	var range;
	var selection;
	if (document.body.createTextRange) {
		range = document.body.createTextRange();
		range.moveToElementText(text);
		range.select();
	} else if (window.getSelection) {
		selection = window.getSelection();        
		range = document.createRange();
		range.selectNodeContents(text);
		selection.removeAllRanges();
		selection.addRange(range);
	}
};

CDlgCopy2Clip = {

	setup : function() {
		if ( this.b_setup ) { return; }
		this.b_setup = true;

		var _this = this;

		this.jqo_ctar_form = this.jqo_ctar.find(".ctar-form");
		this.jqo_data_area = this.jqo_ctar_form.find(".dlgcopy2clip-data-area");

		this.jqo_ctar.find(".btn-cancel,.btn-close")
			.click( function(e){
				e.preventDefault();
				_this.pc_cancel();
			});

		this.rwin = new CRWindow({
			cwin:this,
			min_w:200,
			max_w:500
		});
	},

	open : function( opt ) {
		for ( var key in opt ) { this[key] = opt[key]; }
		this.setup( opt );

		//-- open
		this.rwin.open();

		//-- activate
		this.jqo_data_area.html($("<div>").text(this.text).html());
		selectText(this.jqo_data_area);
		this.rwin.redraw();
	},

	pc_cancel : function() {
		this.rwin.close();
		if ( this.onCancel ) {
			this.onCancel();
		}
	}

};

}(jQuery));
