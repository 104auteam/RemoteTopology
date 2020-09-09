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

var CUser = {

	init : function( opt ) {
		for ( var key in opt ) { this[key] = opt[key]; }

		var _this = this;
		this.b_load = false;

		this.jqo_ctar_criteria = this.jqo_ctar.find(".ctar-criteria");
		this.jqo_ctar_dtable = this.jqo_ctar.find(".ctar-dtable");

		this.cajax = new CCAjax();
		this.jms = new CJMS();
		this.dtable = new CDTable({jms:this.jms,
			jqo_ctar_dtable:this.jqo_ctar_dtable});

		this.jqo_ctar_criteria.submit(function(e){
			e.preventDefault();
			_this.jms.trigger("do_search",true);
		});

		CStatusSelector.setup(this.jqo_ctar_criteria, function(){
			_this.jms.trigger("do_search",true);
		});

		this.jms.bind("pp_search", this, function( requ ){
			requ.criteria = CForm.get(this.jqo_ctar_criteria);
		});

		this.jms.bind("do_search", this, function( b_new ){
			var requ = {cmd:"search",b_new:b_new};
			this.jms.trigger("pp_search",requ);
			this.cajax.send(requ,this,function(resp){
				this.jms.trigger("rp_search",resp);
			});
		});

		this.jms.bind( "rp_search", this, function( resp ) {

			var _this = this;

			//-- page init
			var lca = CJRLdr.locale("user/bcrumb");
			CPageStack.init(lca["bcrumb:search"]);

			//-- table control
			var jqo_ctrl = this.jqo_ctar_dtable.find(".dtbl-ctrl");

			jqo_ctrl.find(".btn-reg").click(function(e){
				e.preventDefault();
				_this.pc_reg_inp();
			});

			jqo_ctrl.find(".btn-del-multi").click(function(e){
				e.preventDefault();
				_this.pc_del_multi();
			});

			//-- sub column
			this.jqo_ctar_dtable.find(".btn-edit").click(function(e){
				e.preventDefault();
				_this.pc_edit_inp($(this));
			})
			.bind("keypress",CDuan.kp_to_click);

			this.jqo_ctar_dtable.find(".btn-pin").click(function(e){
				e.stopPropagation();
				e.preventDefault();
				_this.pc_pin($(this));
			})
			.bind("keypress",CDuan.kp_to_click);

			//-- main column

			//-- activate
			CScrollBtn.update();

			if ( "CIE7" in window ) {
				CIE7.setGlyphicon();
			}
		});

		this.jms.bind( "rp_edit_inp", this, function( resp ) {
			if ( CFRes.execute(resp) ) {
				this.setupDetailPage("edit", resp);
			}
		});

		this.jms.bind( "rp_edit_done", this, function( resp ) {
			if ( CFRes.execute(resp,this.jqo_ctar_form) ) {
				CPageStack.popPage();
				this.jms.trigger("rp_search",resp);
			}
		});

		this.jms.bind( "rp_reg_inp", this, function( resp ) {
			this.setupDetailPage("reg", resp);
		});

		this.jms.bind( "rp_reg_done", this, function( resp ) {
			if ( CFRes.execute(resp,this.jqo_ctar_form) ) {
				CPageStack.popPage();
				this.jms.trigger("rp_search",resp);
			}
		});

		this.jms.bind("rp_del_multi", this, function( resp ) {
			if ( CFRes.execute(resp) ) {
				this.jms.trigger("rp_search",resp);
			}
		});
	},

	setupDetailPage : function( cmd, resp ) {

		var _this = this;

		var lca = CJRLdr.locale("user/bcrumb");
		var jqo = CPageStack.pushPage( this.jqo_ctar, resp.html, lca["bcrumb:" + cmd] );
		this.jqo_ctar_form = jqo.find(".ctar-form");

		initCInpCb();
		initCInpRb();

		this.toggleArea(
			jqo.find('input:checkbox[name="b_password"]'),
			jqo.find(".area-password")
		);

		jqo.find(".btn-cancel").click(function(e){
			e.preventDefault();
			CPageStack.popPage();
		});

		if ( cmd == "reg" ) {
			jqo.find(".btn-ok").click(function(e){
				e.preventDefault();
				_this.pc_reg_done();
			});
		} else {
			jqo.find(".btn-ok").click(function(e){
				e.preventDefault();
				_this.pc_edit_done();
			});
		}

		//-- disable enter key in input
		jqo.find("input").keypress(function(e) {
			if (e.which == 13) {
				e.preventDefault()
			}
		});

		//-- limit # of chars on 'notes'
		var jqo_notes = jqo.find('textarea[name="notes"]');
		var jqo_notes_cnt = jqo.find(".notes-cnt");
		CDuan.charLimit(
			jqo_notes,
			jqo_notes_cnt,
			jqo_notes.attr("data-maxchar"),
			"%numofchar%/%maxchar%"
		);

		//-- focus fisrt input
		jqo.find("input[name='title']").select();

		//-- update scroll btn
		CScrollBtn.update();
	},

	activate : function( opt ) {
		for ( var key in opt ) { this[key] = opt[key]; }

		if ( !this.b_load || this.b_reload ) {
			this.b_load = true;
			this.jms.trigger("do_search",true);
		}
	},

	toggleArea : function( jqo_switch, jqo_area ) {
		jqo_switch.change(function(e){
			jqo_area.toggle( $(this).is(":checked") );
		});
		jqo_area.toggle( jqo_switch.is(":checked") );
	},

	pc_edit_inp : function( jqo ) {
		this.id = jqo.parents(".dtbl-row").attr("data-id");
		var requ = {
			cmd:"edit_inp",
			id:this.id
		};
		this.cajax.send(requ,this,function(resp){
			this.jms.trigger("rp_edit_inp",resp);
		});
	},

	pc_edit_done : function() {
		var form = CForm.get(this.jqo_ctar_form);
		var requ = {
			cmd:"edit_done",
			id:this.id,
			form:form
		};
		this.jms.trigger("pp_search",requ);
		this.cajax.send(requ,this,function(resp){
			this.jms.trigger("rp_edit_done",resp);
		});
	},

	pc_reg_inp : function() {
		var requ = {
			cmd:"reg_inp"
		};
		this.cajax.send(requ,this,function(resp){
			this.jms.trigger("rp_reg_inp",resp);
		});
	},

	pc_reg_done : function() {
		var form = CForm.get(this.jqo_ctar_form);
		var requ = {
			cmd:"reg_done",
			form:form
		};
		this.jms.trigger("pp_search",requ);
		this.cajax.send(requ,this,function(resp){
			this.jms.trigger("rp_reg_done",resp);
		});
	},

	pc_del_multi : function() {
		var requ = {
			cmd:"del_multi",
			b_new:false
		};
		this.jms.trigger("pp_selrec",requ);
		this.jms.trigger("pp_search",requ);

		var lca = CJRLdr.locale("user/del-multi");
		var cfg = CJRLdr.config("user/root-admin");

		if ( requ.selrec.length == 0 ) {
			CMsgBox.show(lca["err:select-at-least-one"],lca["title:dialog"],"ok warning");
		} else if ( $.inArray(cfg["root-admin-id"],requ.selrec) != -1 ) {
			CMsgBox.show(lca["err:can-not-delete-root"],lca["title:dialog"],"ok warning");
		} else {
			var msg = lca["text:confirm"];
			msg = msg.replace("%cnt%",requ.selrec.length);
			msg = msg.replace("%s%",requ.selrec.length==1?"":"s");
			CMsgBox.show(msg,lca["title:dialog"],"yes no warning",this,function(resp){
				if ( resp == "yes" ) {
					this.cajax.send(requ,this,function(resp){
						this.jms.trigger("rp_del_multi",resp);
					});
				}
			});
		}
	},

	pc_pin : function( jqo ) {
		var requ = {
			cmd:"pin",
			id:jqo.parents(".dtbl-row").attr("data-id")
		};
		this.jms.trigger("pp_search",requ);
		this.cajax.send(requ,this,function(resp){
			this.jms.trigger("rp_search",resp);
		});
	}

};

$(document).ready(function(){
	CUser.init({jqo_ctar:$(".ctar-user")});
	CUser.activate();
});

}(jQuery));
