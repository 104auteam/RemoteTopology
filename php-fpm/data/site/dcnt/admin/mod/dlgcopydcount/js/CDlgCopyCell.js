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

CDlgCopyCell = {

	setup : function() {
		if ( this.b_setup ) { return; }
		this.b_setup = true;

		var _this = this;

		if ( !this.jqo_ctar ) {
			this.jqo_ctar = $(".dlgcopydcount");
		}
		this.jqo_ctar_form = this.jqo_ctar.find(".ctar-form");

		//initCInpGroup();

		this.jqo_ctar
			.keydown(function(e){
				if ( e.which == 27 ) {
					e.preventDefault();
					_this.pc_cancel();
				}
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

		this.rwin = new CRWindow({
			cwin:this,
			min_w:200,
			max_w:500
		});
	},

	open : function( opt ) {
		for ( var key in opt ) { this[key] = opt[key]; }
		this.setup( opt );

		//-- setup instance data 
		CForm.setFRes(this.jqo_ctar_form);

		var lca = CJRLdr.locale("dlgcopydcount/dlg");
		CForm.set(this.jqo_ctar_form,{
			"title":lca["text:title-prefix"] + this.title,
			"group_id":undefined
		});

		//-- open
		this.rwin.open();

		//-- activate
		this.jqo_ctar_form.find("input[name='title']")
			.select()
	},

	pc_ok : function() {
		var form = CForm.get(this.jqo_ctar_form);
		var requ = {
			cmd:"copy",
			id:this.id,
			form:form
		};
		this.cajax.send(requ,this,function(resp){
			var b = CFRes.execute(resp,this.jqo_ctar_form);
			this.rwin.redraw();
			if ( b ) {
				this.rwin.close();
				if ( this.onOK ) {
					this.onOK();
				}
			}
		});
	},

	pc_cancel : function() {
		this.rwin.close();
		if ( this.onCancel ) {
			this.onCancel();
		}
	}

};

}(jQuery));
