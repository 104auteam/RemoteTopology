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

function CSelRec( opt ) {
	for( var key in opt ) { this[key] = opt[key]; }
	this.setup();
};

CSelRec.prototype = {

	isIE7 : function()  {
		return (navigator.appVersion.indexOf("MSIE 7.")!=-1);
	},

	isIE8 : function() {
		return (navigator.appVersion.indexOf("MSIE 8.")!=-1);
	},

	leIE8 : function() {
		return this.isIE7() || this.isIE8();
	},

	setup : function(){
		var _this = this;

		//-- checkbox/radio button
		if ( this.leIE8() ) {
			this.jqo_inp.show();
		} else {
			this.jqo_inp.wrap("<div class='dtbl-selrec-ctar' tabindex='0'></div>");
			this.jqo_ctar = this.jqo_inp.parents(".dtbl-selrec-ctar")
				.attr("title",this.jqo_inp.attr("title"))
				.append($("<div>")
					.attr("class","dtbl-selrec-inner")
					.html($("<span>")
						.attr("class","glyphicon glyphicon-ok dtbl-selrec-mark")
					)
				);
			this.jqo_inp.hide();

			//-- select/deselect checkbox/radio button
			var b_multi = true;
			var func = function(){
				_this.update();
				_this.jqo_ctar.focus();
			};
			this.jqo_inp.change(func);

			this.jqo_ctar
				.click(function (e) {
					e.preventDefault()
					var jqo = $(this).find("input");
					_this.jqo_inp.prop("checked",!jqo.is(":checked"));
					_this.jqo_inp.trigger("change");
				})
				.keypress(function (e) {
					if ((e.which == 13) || (e.which == 32)) {
						e.preventDefault()
						var jqo = $(this).find("input");
						_this.jqo_inp.prop("checked",!jqo.is(":checked"));
						_this.jqo_inp.trigger("change");
					}
				});
		}
	},

	update : function() {
		var jqo_inner = this.jqo_ctar.find(".dtbl-selrec-inner");
		var jqo_mark = this.jqo_ctar.find(".dtbl-selrec-mark");
		if ( this.jqo_inp.is(":checked") ) {
			this.jqo_ctar.addClass("dtbl-selrec-ctar-on");
			jqo_inner.addClass("dtbl-selrec-inner-on");
			jqo_mark.addClass("dtbl-selrec-mark-on");

			this.jqo_ctar.parents(".dtbl-tr").eq(0).addClass("sel");
			this.jqo_ctar.parents(".dtbl-row").eq(0).addClass("dtbl-row-sel");
		} else {
			this.jqo_ctar.removeClass("dtbl-selrec-ctar-on");
			jqo_inner.removeClass("dtbl-selrec-inner-on");
			jqo_mark.removeClass("dtbl-selrec-mark-on");

			this.jqo_ctar.parents(".dtbl-tr").eq(0).removeClass("sel");
			this.jqo_ctar.parents(".dtbl-row").eq(0).removeClass("dtbl-row-sel");
		}
	}
};

function CDTable( opt ) {
	// opt.jqo_ctar_dtable
	// opt.jms
	for ( var key in opt ) { this[key] = opt[key]; }

	this.setup();
};

CDTable.prototype = {

	isNumeric : function( e ) {
		var cc = e.which;
		return (( 48 <= cc ) && ( cc <= 57 )) || //0-9
			//(( 97 <= cc ) && ( cc <= 122 )) ||  //a-z
			(( 8 == cc ) || ( cc == 46 ));//backspace. delete
	},

	isCR : function( e ) {
		var cc = e.which;
		return ( cc == 13 );
	},

	isCRSP : function( e ) {
		var cc = e.which;
		return (( cc == 13 ) || ( cc == 32 ));
	},

	setup : function() {

		//-- data table state
		this.dts = {
			page_idx:null,
			page_size:null,
			sort_val:null
		};

		this.jms.bind( "pp_search", this, function( data ){
			if ( data.b_new ) {
				this.dts.page_idx = 1;
			}
			data.dts = this.dts;
		});

		this.jms.bind( "rp_search", this, function( resp ) {

			var _this = this;

			this.dts = resp.dts;

			//-- scroll to the top only when it's not in rwindow
			if ( !this.jqo_ctar_dtable.parents(".rwindow").length ) {
				window.scrollTo(0,0);
			}

			this.jqo_ctar_dtable.hide();

			this.jqo_ctar_dtable.html(resp.html);
			this.jqo_dtbl = this.jqo_ctar_dtable.find(".dtbl");

			//-- jqo_dtble shared
			this.jqo_selrec = this.jqo_dtbl.find( ".dtbl-selrec" );
			this.jqo_selrec_main = this.jqo_dtbl.find( ".dtbl-selrec-main" );
			this.jqo_selcnt = this.jqo_dtbl.find( ".dtbl-selcnt" );
			this.jqo_selcnt.html("0");
			this.jqo_heading = this.jqo_dtbl.find( ".dtbl-heading" );
			this.jqo_ctrl_btnbox = this.jqo_heading.find( ".dtbl-ctrl-btnbox" );

			//-- jqo_htbl
			this.jqo_htbl = this.jqo_dtbl.find(".dtbl-body > .dtbl-htbl");
			if ( this.jqo_htbl.length ) {
				var mbm_breakpoint = this.jqo_htbl.attr("data-mbm-breakpoint");
				if ( mbm_breakpoint ) { this.mbm_breakpoint = mbm_breakpoint; }
				var mbm_label_width = this.jqo_htbl.attr("data-mbm-label-width");
				if ( mbm_label_width ) { this.mbm_label_width = mbm_label_width; }
				this.jqo_thead = this.jqo_htbl.children("thead");
				this.jqo_tbody = this.jqo_htbl.children("tbody");
				this.jqo_tbody.children("tr").attr("class","dtbl-tr");
				this.jqo_tbody_br = this.jqo_tbody.find( ".dtbl-br" );
				this.setupMbmInfo();
				this.setupValAlign();
				this.changeLine();

				this.jqo_dtbl.find(".btn-sort").click(function(e){
					e.preventDefault();
					_this.pc_sort($(this));
					_this.jms.trigger("do_search",true);
				});
			}

			//-- jqo_ctbl
			this.jqo_ctbl = this.jqo_dtbl.find(".dtbl-body > .dtbl-ctbl");
			if ( this.jqo_ctbl.length ) {
				//
			}

			//-- dlgdtc
			this.jqo_btn_dlgdtc = this.jqo_dtbl.find(".dtbl-btn-dlgdtc");
			if ( this.jqo_btn_dlgdtc.length ) {

				this.jqo_dlgdtc = $(".dlgdtc");
				CDlgDtc.setup({
					jqo_ctar:this.jqo_dlgdtc,
					onCancel:function(){
						_this.jqo_btn_dlgdtc.focus();
					}
				});

				//-- btn_dlgdtc
				this.jqo_btn_dlgdtc
					.attr("tabindex",0)
					.click(function(e){
						e.preventDefault();
						CDlgDtc.open();
					})
					.keydown(function(e){
						if ( _this.isCRSP(e) ) {
							e.preventDefault();
							$(this).click();
						}
					});

				//-- page-navi
				var setup_navi_btn = function(jqo) {
					if ( parseInt(jqo.attr("data-active")) ) {
						jqo.click(function(e){
							e.preventDefault();
							CDlgDtc.close(true);
							_this.pc_goto_pageno(jqo.attr("data-pageno"));
							_this.jms.trigger("do_search",false);
						})
						.keydown(function(e){
							if ( _this.isCRSP(e) ) {
								e.preventDefault();
								$(this).click();
							}
						})
						.hover(function(){
							$(this).addClass("page-navi-cell-hover");
						},function(){
							$(this).removeClass("page-navi-cell-hover");
						});
					}
				};
				setup_navi_btn(this.jqo_dlgdtc.find(".page-navi-btn-first"));
				setup_navi_btn(this.jqo_dlgdtc.find(".page-navi-btn-prev"));
				setup_navi_btn(this.jqo_dlgdtc.find(".page-navi-btn-next"));
				setup_navi_btn(this.jqo_dlgdtc.find(".page-navi-btn-last"));

				//-- inp-pageno
				this.jqo_dlgdtc.find(".page-navi-inp-pageno").keypress(function(e){
					if ( _this.isCR(e) ) {
						_this.pc_goto_pageno($(this).val());
						CDlgDtc.close(true);
						_this.jms.trigger("do_search",false);
					} else if ( !_this.isNumeric(e) ) {
						e.preventDefault();
					}
				});

				//-- page-size
				this.jqo_dlgdtc.find(".select-page-size").change(function(e){
					e.preventDefault();
					CDlgDtc.close(true);
					_this.pc_pagesize($(this));
					_this.jms.trigger("do_search",true);
				});

				//-- sort records
				this.jqo_dlgdtc.find(".select-sort-option").change(function(e){
					e.preventDefault();
					CDlgDtc.close(true);
					_this.pc_sort($(this).find("option:selected"));
					_this.jms.trigger("do_search",true);
				});
			}

			//-- show dtable
			this.jqo_ctar_dtable.show();

			//-- pagetab
			this.jqo_dtbl.find(".btn-pagetab").click(function(e){
				e.preventDefault();
				CDlgDtc.close(true);
				_this.pc_pagetab($(this));
				_this.jms.trigger("do_search",false);
			});

			//-- selrec
			this.jqo_selrec_main.change( function() {
				_this.jqo_selrec.prop( "checked", $(this).is( ":checked" ) );
				_this.jqo_selrec.each(function(){
					$(this).data("_obj_").update();
				});
				var selcnt = _this.jqo_selrec.filter( ":checked" ).length;
				_this.jqo_selcnt.html(selcnt);
			});

			this.jqo_selrec.change( function() {
				var total = _this.jqo_selrec.length;
				var selcnt = _this.jqo_selrec.filter( ":checked" ).length;
				if ( selcnt == total ) {
					_this.jqo_selrec_main
						.prop( "checked", true )
						.data("_obj_").update();
				}
				if ( selcnt == 0 ) {
					_this.jqo_selrec_main
						.prop( "checked", false )
						.data("_obj_").update();
				}
				_this.jqo_selcnt.html(selcnt);
			});

			this.jqo_selrec.add(this.jqo_selrec_main).each( function(){
				if ( !$(this).data("_obj_") ) {
					var obj = new CSelRec({jqo_inp:$(this)});
					$(this).data("_obj_",obj);
				}
			});

			if ( this.jqo_htbl.length ) {
				this.setupResizeHandler();
			}

		});

		this.jms.bind( "pp_selrec", this, function( data ) {
			var selrec = [];
			this.jqo_selrec.each( function() {
				if ( $(this).is( ":checked" ) ) {
					selrec.push(parseInt($(this).attr("data-id")));
				}
			});
			data.selrec = selrec;
		});
	},

	pc_pagetab : function( jqo ) {
		this.dts.page_idx = jqo.attr("data-page-idx");
	},

	pc_goto_pageno : function( pageno ) {
		this.dts.page_idx = pageno;
	},

	pc_sort : function( jqo ) {
		if ( jqo.val() ) {
			this.dts.sort_val = jqo.val();
		} else {
			this.dts.sort_val =
				jqo.attr("data-sort-key") + ":" +
				jqo.attr("data-sort-dir");
		}
	},

	pc_pagesize : function( jqo ) {
		this.dts.page_size = jqo.find("option:selected").text();
	},

	//-- responsive methods
	getLabel : function( jqo ) {
		var jqo_label = jqo.find(".dtbl-label");
		if ( !jqo_label.length ) { return ""; }
		var label = jqo_label.attr("data-mbm-label");
		if ( !label || (label=="") ) {
			label = jqo.find(".dtbl-label").html();
		}
		return label;
	},

	setupMbmInfo : function() {
		var _this = this;
		this.mbm_info = [];
		this.jqo_thead.find("th").each(function(){
			_this.mbm_info.push({
				width:$(this).attr("width"),
				tn:$(this).attr("data-mbm-tn"),
				label:_this.getLabel($(this)),
				val_align:$(this).attr("data-val-align")
			});
		});
	},

	setupValAlign : function() {
		var _this = this;
		for( var i=0; i<this.mbm_info.length; i++ ) {
			var rec = this.mbm_info[i];
			this.jqo_tbody.find("tr>td:nth-child("+(i+1)+")")
				.css({
					"text-align":rec.val_align
				});
		}
	},

	handler_resize : null,
	setupResizeHandler : function() {
		var _this = this;
		if ( this.handler_resize ) {
			$( window ).unbind( "resize", this.handler_resize );
		}
		this.handler_resize = function() {
			setTimeout(function(){
				_this.onResized();
			},100);
		};
		this.handler_resize();
		$( window ).bind( "resize", this.handler_resize );
	},

	onResized : function() {
		this.changeLine();
	},

	mbm_breakpoint : 500,
	mbm_label_width : 120,
	getChangeLineMode : function() {
		var b_new = ( $(window).width() >= this.mbm_breakpoint ) &&
			( this.mbm_breakpoint >= 0 );
		var b_curr = ( this.jqo_htbl.attr("data-mode") == "1" );

		if ( b_new && !b_curr ) {//=>change to 1 line
			return 1;
		}
		if ( !b_new && b_curr ) {//=>change to 2 lines
			return 2;
		}
		return 0;
	},

	change1Line_thead : function() {
		var jqo_tr = this.jqo_thead.children("tr").eq(0);
		var jqo_th1 = jqo_tr.children("th").eq(0);
		var jqo_t1_tr1 = jqo_th1.children("table")
			.eq(0).find("tr").eq(0);

		var jqo_btnbox = jqo_t1_tr1.find(".dtbl-ctrl-btnbox");
		var jqo_btnbox_parent = jqo_btnbox.parent("th");
		jqo_btnbox.prependTo(this.jqo_heading);
		jqo_btnbox_parent.remove();

		jqo_t1_tr1.children("th").each(function(){
			$(this)
				.show()
				.appendTo(jqo_tr);
		});

		jqo_th1.remove();
	},

	change1Line_tbody : function( jqo_tr ) {
		var jqo_td1 = jqo_tr.children("td").eq(0);
		var jqo_t = jqo_td1.children("table");
		var jqo_t1 = jqo_t.eq(0);
		var jqo_t1_tr = jqo_t1.find("tr");
		var jqo_t2 = jqo_t.eq(1);
		var jqo_t2_tbody = jqo_t2.find("tbody");

		for( var i=0; i<this.mbm_info.length; i++ ) {
			var rec = this.mbm_info[i];
			if ( rec.tn == "t1" ) {
				jqo_t1_tr.children("td").eq(0).appendTo(jqo_tr);
			} else {
				var jqo_tr_x = jqo_t2_tbody.children("tr").eq(0);
				jqo_tr_x.children("td").eq(1)
					.css("text-align",rec.val_align)
					.appendTo(jqo_tr);
				jqo_tr_x.remove();
			}
		}

		jqo_td1.remove();

		this.jqo_tbody_br.show();
	},

	change2Lines_thead : function() {
		var jqo_t1 = $("<table>")
			.attr("class","dtbl-subtbl")
			.append($("<thead>")
				.append($("<tr>"))
			);
		var jqo_t1_tr = jqo_t1.find("tr");

		this.jqo_thead.find("th").each(function(){
			$(this).appendTo(jqo_t1_tr);
			if ( $(this).attr("data-ftype") == "selrec" ) {
				$(this).show();
			} else {
				$(this).hide();
			}
		});

		$("<th>")
			.append(this.jqo_ctrl_btnbox)
			.appendTo(jqo_t1_tr);

		$("<th>")
			.attr("class","dtbl-2l-th")
			.append(jqo_t1)
			.prependTo(this.jqo_thead.find("tr"));

		this.jqo_tbody_br.hide();
	},

	change2Lines_tbody : function( jqo_tr ) {
		var jqo_t1 = $("<table>")
			.attr("class","dtbl-subtbl")
			.append($("<tbody>")
				.append($("<tr>"))
			);
		var jqo_t1_tr = jqo_t1.find("tr");

		var jqo_t2 = $("<table width='100%'>")
			.attr("class","dtbl-subtbl")
			.append($("<tbody>"));
		var jqo_t2_tbody = jqo_t2.find("tbody");

		for( var i=0; i<this.mbm_info.length; i++ ) {
			var rec = this.mbm_info[i];
			if ( rec.tn == "t1" ) {
				jqo_t1_tr.append(jqo_tr.children("td").eq(0));
			} else {
				jqo_t2_tbody.append($("<tr>")
					.append($("<td class='dtbl-label'>")
						.css({
							"width":this.mbm_label_width+"px",
							"min-width":this.mbm_label_width+"px",
							"max-width":this.mbm_label_width+"px"
						})
						.html(rec.label)
					)
					.append(jqo_tr.children("td").eq(0)
						.css("text-align","left")
					)
				);
			}
		}

		$("<td>")
			.attr("class","dtbl-2l-td")
			.append(jqo_t1)
			.append(jqo_t2)
			.prependTo(jqo_tr);
	},

	changeLine : function() {
		var _this = this;
		switch( this.getChangeLineMode() ) {
		case 1:
			this.change1Line_thead();
			this.jqo_tbody.children("tr").each(function(){
				_this.change1Line_tbody($(this));
			});
			this.jqo_htbl.attr("data-mode",1);
			break;

		case 2:
			this.change2Lines_thead();
			this.jqo_tbody.children("tr").each(function(){
				_this.change2Lines_tbody($(this));
			});
			this.jqo_htbl.attr("data-mode",2);
			break;
		}
	}

};

window.CDTable = CDTable;

}(jQuery));
