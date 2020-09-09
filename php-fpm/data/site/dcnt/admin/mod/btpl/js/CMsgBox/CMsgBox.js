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

CMsgBox = {

	addBtn : function( lca, opt, key, type, jqo_footer ) {
		if ( opt.indexOf(key) != -1 ) {
			$("<button>")
				.attr("class","btn btn-"+type)
				.attr("data-id",key)
				.css({
					"margin-left":"5px",
					"width":"100px"
				})
				.html(lca["label:"+key])
				.appendTo(jqo_footer);
		}
	},

	show : function( msg, title, opt, obj, func ) {
		title = title || null;
		opt = opt || "[ok]";
		obj = obj || window;
		func = func || null;

		var _this = this;
		var lca = CJRLdr.locale("btpl/msgbox");

		//-- setup msg
		if ( opt.indexOf("warning") != -1 ) {
			msg = $("<table>")
				.html($("<tr>")
					.append($("<td>")
						.append($("<span>")
							.attr("class","glyphicon " +
								"glyphicon-exclamation-sign " +
								"text-warning")
							.css("font-size","400%")
						)
					)
					.append($("<td>")
						.css("width","15px")
					)
					.append($("<td>")
						.html(msg)
					)
				);
		}

		this.jqo_ctar = $("<div>")
			.attr("class","dlg dlgmsgbox");

		if ( title ) {
			$("<div>")
				.attr("class","dlg-heading")
				.append(title)
				.append( $("<button>")
					.attr("class","close btn-close")
					.attr("title",lca["alt:close"])
					.html( $("<span>")
						.html("&times;")
					)
				)
				.appendTo(this.jqo_ctar);
		}

		$("<div>")
			.attr("class","dlg-body")
			.css({
				"padding":"20px"
			})
			.html(msg)
			.appendTo(this.jqo_ctar);

		var jqo_footer = $("<div>")
			.attr("class","dlg-footer")
			.appendTo(this.jqo_ctar);
		
		this.addBtn(lca,opt,"ok","primary",jqo_footer);
		this.addBtn(lca,opt,"yes","primary",jqo_footer);
		this.addBtn(lca,opt,"cancel","default",jqo_footer);
		this.addBtn(lca,opt,"no","default",jqo_footer);

		$("<div>")
			.css("clear","both")
			.appendTo(jqo_footer);

		var rwin = new CRWindow({
			cwin:this,
			min_w:200,
			max_w:500
		});

		//-- open
		rwin.open();

		//-- close
		this.jqo_ctar.find("button").click(function(e){
			e.preventDefault();
			rwin.close();
			if ( func != null ) {
				func.call(obj,$(this).attr("data-id"));
			}
		});

		this.jqo_ctar.find(".btn-close").click( function(e){
			e.preventDefault();
			rwin.close();
			if ( func != null ) {
				func.call(obj,"");
			}
		});
	}

};

}(jQuery));
