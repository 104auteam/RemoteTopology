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

CCfgApp = {

	init : function( opt ) {
		for ( var key in opt ) { this[key] = opt[key]; }

		var _this = this;

		this.jqo_ctar_form = this.jqo_ctar_detail.find(".ctar-form");
		this.jqo_btn_ok = this.jqo_ctar_detail.find(".btn-ok");

		this.cajax = new CCAjax();
		this.jms = new CJMS();

		var lca = CJRLdr.locale("cfgapp/bcrumb");
		CBreadcrumb.write(lca["edit"]);

		initCInpCb();

		//-- save
		this.jqo_btn_ok.click(function(e){
			e.preventDefault();
			_this.pc_save();
		});

		this.jms.bind( "rp_save", this, function( resp ) {
			if ( CFRes.execute(resp,this.jqo_ctar_form) ) {
				CDuan.blink(this.jqo_btn_ok);
			}
		});

	},

	pc_save : function() {
		var form = CForm.get(this.jqo_ctar_form);
		var requ = {
			cmd:"save",
			form:form
		};
		this.cajax.send(requ,this,function(resp){
			this.jms.trigger("rp_save",resp);
		});
	}

};

$(document).ready(function(){
	CCfgApp.init({jqo_ctar_detail:$(".ctar-detail")});
});

}(jQuery));
