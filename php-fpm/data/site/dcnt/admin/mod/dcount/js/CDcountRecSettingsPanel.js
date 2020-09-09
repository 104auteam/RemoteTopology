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

CDcountRecSettingsPanel = {

	b_first_time : true,

	onSave : function() {
		var form = CForm.get(this.jqo_form);
		var requ = {
			cmd:"edit_done",
			id:this.id,
			form:form
		};
		this.cajax.send(requ,this,function(resp){
			if ( CFRes.execute(resp,this.jqo_form) ) {
				CForm.sendMsg(this.jqo_form,{
					"event":"saved",
					"resp":resp
				});
				CDcountRecPreviewPanel.redraw( form.preview, form.txt );
				this.jqo_btn_save.trigger("end");
			} else {
				CForm.sendMsg(this.jqo_form,{
					"event":"error",
					"resp":resp
				});
				this.jqo_btn_save.trigger("error");
			}
		});
	},

	init : function( opt ) {
		for ( var key in opt ) { this[key] = opt[key]; }

		var _this = this;
		this.cajax = new CCAjax();

		//-- setup jqo variables
		this.jqo_btn_save = this.jqo_ctar.find(".btn-save");
		this.jqo_form = this.jqo_ctar.find(".form-settings");

		//-- init components
		initCInpInterval();

		//-- save button
		this.jqo_btn_save
			.unbind("start")
			.bind("start",function(e){
				e.preventDefault();
				_this.onSave();
			});

		//-- disable enter key in input
		this.jqo_form.find("input").keypress(function(e) {
			if (e.which == 13) {
				e.preventDefault()
			}
		});

		//-- limit # of chars on 'notes'
		var jqo_notes = this.jqo_form.find('textarea[name="notes"]');
		var jqo_notes_cnt = this.jqo_form.find(".notes-cnt");
		CDuan.charLimit(
			jqo_notes,
			jqo_notes_cnt,
			jqo_notes.attr("data-maxchar"),
			"%numofchar%/%maxchar%"
		);

		//-- checkbox toggle
		this.toggleArea(
			this.jqo_form.find('input:checkbox[name="b_redirect"]'),
			this.jqo_form.find(".area-url_redirect")
		);
		this.toggleArea(
			this.jqo_form.find('input:checkbox[name="b_autoloop"]'),
			this.jqo_form.find(".area-autoloop")
		);

		//-- first time
		this.b_first_time = true;
	},

	activate : function( opt ) {
		for ( var key in opt ) { this[key] = opt[key]; }

		//-- focus title field
		if ( this.b_first_time ) {
			this.b_first_time = false;

			var jqo = this.jqo_form.find("input[name='title']");
			jqo.select();
		}
	},

	toggleArea : function( jqo_switch, jqo_area ) {
		jqo_switch.change(function(e){
			jqo_area.toggle( $(this).is(":checked") );
		});
		jqo_area.toggle( jqo_switch.is(":checked") );
	}

};

}(jQuery));
