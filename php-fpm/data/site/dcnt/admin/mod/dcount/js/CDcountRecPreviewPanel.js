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

CDcountRecPreviewPanel = {

	redraw : function( preview, txt ) {
		// no need to update preview
	},

	init : function( opt ) {
		for ( var key in opt ) { this[key] = opt[key]; }

		var _this = this;
		this.cajax = new CCAjax();

		//-- setup jqo variables
		this.jqo_ctar_preview = this.jqo_ctar.find(".ctar-preview");
//		this.jqo_ctar_preview_disabled = this.jqo_ctar.find(".ctar-preview-disabled");
//		this.jqo_ctar_preview_jsblocked = this.jqo_ctar.find(".ctar-preview-jsblocked");

		initCInpCopy2Clip();
	},

	activate : function( opt ) {
		for ( var key in opt ) { this[key] = opt[key]; }
	}

};

}(jQuery));
