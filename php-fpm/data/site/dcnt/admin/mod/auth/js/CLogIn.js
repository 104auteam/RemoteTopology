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

CLogIn = {

	init : function( opt ) {
		for ( var key in opt ) { this[key] = opt[key]; }

		var _this = this;

		this.cajax = new CCAjax();
		this.jms = new CJMS();

		this.jqo_ctar_form.submit(function(e){
			e.preventDefault();
			_this.pc_login();
		});

		this.jms.bind("rp_login", this, function( resp ) {
			CForm.setFRes(this.jqo_ctar_form,resp.fres);
			if ( resp.fres.b_validated ) {
				$("body").css("background-color","white");
				this.jqo_ctar_form.fadeOut(300,function(){
					document.location = resp.url_success;
				});
			}
		});

		this.jqo_ctar_form.find("input[name='username']").focus();
	},

	pc_login : function() {
		var form = CForm.get(this.jqo_ctar_form,[
				"username",
				"password"
			]);
		var requ = {
			cmd:"login",
			form:form
		};
		this.cajax.send(requ,this,function(resp){
			this.jms.trigger("rp_login",resp);
		});
	}

};

$(document).ready(function(){
	CLogIn.init({jqo_ctar_form:$(".ctar-form")});
});

}(jQuery));
