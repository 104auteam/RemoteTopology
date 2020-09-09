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

function CDatePicker( opt ) {
	for( var key in opt ) { this[key] = opt[key]; }
	this.setup();
};

CDatePicker.prototype = {

	drawDay : function( month, d ) {
		var cx = ["dtpk-day"];

		var ty = d.getFullYear();
		var tm = d.getMonth();
		var td = d.getDate();

		var b_in_y = ( ty == this.now_y );
		var b_tab = false;
		var b_in_m;
		if ( tm == month ) {
			cx.push("dtpk-inday");
			b_tab = true;
			b_in_m = true;
		} else {
			cx.push("dtpk-outday");
			b_in_m = false;
		}
		b_in_m &= ( tm == this.now_m );

		var n = d.getDay();
		if ( b_in_y && b_in_m &&
			( td == this.now_d ) ) {
			cx.push("dtpk-today");
		} else if (( n == 0 ) || ( n == 6 )) {
			cx.push("dtpk-wend");
		} else {
			cx.push("dtpk-wday");
		}

		if (( ty == this.sel_y ) &&
			( tm == this.sel_m ) &&
			( td == this.sel_d )) {
			cx.push("dtpk-selday");
		}

		var cls = cx.join(" ");
		return "<td class='" + cls + "' " +
			( b_tab ? "tabindex='0' " : "" ) +
			"data-date='" + td + "'>" +
			d.getDate() +
			"</td>";
	},

	drawWeek : function( s ) {
		return "<tr>" + s + "</tr>";
	},

	drawWeekOfDay : function( str ) {
		var cls = "dtpk-head";
		return "<td class='" + cls +"' width='14.29%'>" +
			str +
			"</td>";
	},

	drawHeading : function() {
		var fdow = this.cfg["first-dow"];
		var dowstr = this.lca["label:dow"].split("|");
		var sx = [];
		for( var i=0; i<7; i++ ) {
			var ii = (i+fdow) % 7;
			var str = dowstr[ii];
			sx.push(this.drawWeekOfDay(str));
		}
		return this.drawWeek(sx.join(""));
	},

	drawAllDays : function( year, month ) {
		var b_6rows = this.cfg["b-6rows"];
		var fdow = parseInt(this.cfg["first-dow"]);
		var d1 = new Date(year,month,1);
		var n = (d1.getDay()-fdow+7)%7;
		var d0 = new Date(d1);
		d0.setDate(d0.getDate() - n);

		var b_exit = false;
		var d = new Date(d0);
		var wx;
		var mx = [];
		var week = 0;
		while( !b_exit ) {
			var dow = d.getDay();
			var m = d.getMonth();
			if ( (dow-fdow) == 0 ) { wx = []; }
			wx.push( this.drawDay(month,d) );
			if ( (dow-fdow+7)%7 == 6 ) {
				mx.push( this.drawWeek( wx.join("") ) );
				week++;
				if ( week == 6 ) {
					b_exit = true;
				}
			}
			d.setDate(d.getDate()+1);
			if ( !b_6rows ) {
				if (( dow == fdow ) && ( m > month )) {
					b_exit = true;
				}
			}
		}
		return mx.join("");
	},

	drawMonth : function( year, month ) {
		return this.drawHeading()
			+ this.drawAllDays(year,month);
	},

	setupSelYM : function() {
		var sel_ym_format = this.lca["format:sel-ym"];
		switch ( sel_ym_format ) {
		case "y-m":
			var jqo_td1 = this.jqo_sel_ym.find("td").eq(1);
			jqo_td1.after(jqo_td1.prev("td"));
			jqo_td1.before(jqo_td1.next("td").next("td"));
			jqo_td1.next("td").attr("align","right");
			jqo_td1.prev("td").attr("align","left");
			break;
		case "m-y":
			break;
		}
	},

	calcY : function( y ) {
		var ch = y.substr(0,1);
		switch( ch ) {
		case "-": return this.now_y - parseInt(y.substr(1));
		case "+": return this.now_y + parseInt(y.substr(1));
		default: return parseInt(y);
		}
	},

	setupSelY : function() {
		var sel_y_format = this.lca["format:sel-y"];

		this.start_y = this.calcY(this.start_y);
		this.end_y = this.calcY(this.end_y);
		for( var y=this.start_y; y<=this.end_y; y++ ) {
			var str = sel_y_format.replace("%y%",y);
			var jqo = $("<option>")
				.val(y)
				.html(str);
			this.jqo_sel_y.append(jqo);
		}
		this.jqo_sel_y.val(this.sel_y);
	},

	setupSelM : function() {
		var sel_m_str = this.lca["label:sel-m"].split("|");
		for( var m=0; m<12; m++ ) {
			var str = sel_m_str[m];
			var jqo = $("<option>")
				.val(m)
				.html(str);
			this.jqo_sel_m.append(jqo);
		}
		this.jqo_sel_m.val(this.sel_m);
	},

	setup : function() {
		var _this = this;

		this.lca = CJRLdr.locale("inpdt/date-picker");
		this.cfg = CJRLdr.config("inpdt/date-picker");
		this.cfg_app = CJRLdr.config("cfgapp");
		if ( this.cfg_app["first-dow"] ) {
			this.cfg["first-dow"] = this.cfg_app["first-dow"];
		}

		this.start_y = this.cfg["start-y"];
		this.end_y = this.cfg["end-y"];

		this.now = new Date();
		this.now_y = this.now.getFullYear();
		this.now_m = this.now.getMonth();
		this.now_d = this.now.getDate();

		this.jqo_daytbl = this.jqo_ctar.find(".dtpk-daytbl");
		this.jqo_sel_ym = this.jqo_ctar.find(".dtpk-sel-ym");

		this.jqo_sel_y = this.jqo_sel_ym.find(".dtpk-sel-y");
		this.jqo_y_prev = this.jqo_sel_ym.find(".dtpk-y-prev");
		this.jqo_y_next = this.jqo_sel_ym.find(".dtpk-y-next");

		this.jqo_sel_m = this.jqo_sel_ym.find(".dtpk-sel-m");
		this.jqo_m_prev = this.jqo_sel_ym.find(".dtpk-m-prev");
		this.jqo_m_next = this.jqo_sel_ym.find(".dtpk-m-next");

		this.jqo_ym = this.jqo_ctar.find(".dtpk-ym");

		this.setupSelYM();
		this.setupSelY();
		this.setupSelM();

		this.jqo_sel_y.change(function(){
			_this.sel_y = parseInt($(this).find("option:selected").val());
			_this.update();
		});

		this.jqo_y_prev.click(function(){
			_this.moveYM("y","prev");
		});

		this.jqo_y_next.click(function(){
			_this.moveYM("y","next");
		});

		this.jqo_sel_m.change(function(){
			_this.sel_m = parseInt($(this).find("option:selected").val());
			_this.update();
		});

		this.jqo_m_prev.click(function(){
			_this.moveYM("m","prev");
		});

		this.jqo_m_next.click(function(){
			_this.moveYM("m","next");
		});

		if ( this.init_val ) {
			this.setVal(this.init_val);
		} else {
			this.setVal(this.now);
		}
	},

	moveYM : function( ym, dir ) {
		var jqo;
		switch( ym ) {
		case "y": jqo = this.jqo_sel_y; break;
		case "m": jqo = this.jqo_sel_m; break;
		}

		switch( dir ) {
		case "prev": jqo = jqo.find("option:selected").prev("option"); break;
		case "next": jqo = jqo.find("option:selected").next("option"); break;
		}

		if ( jqo.length ) {
			switch( ym ) {
			case "y":
				this.sel_y = parseInt(jqo.val());
				break;
			case "m":
				this.sel_m = parseInt(jqo.val());
				break;
			}
			this.update();
		} else {
			switch( ym ) {
			case "m":
				switch( dir ) {
				case "prev": this.sel_m = 11; break;
				case "next": this.sel_m = 0; break;
				}
				this.update();
				break;
			}
		}
	},

	updateSelYM : function() {
		this.jqo_sel_y.val(this.sel_y);
		this.jqo_sel_m.val(this.sel_m);
	},

	updateYM : function() {
		var ym_format = this.lca["format:ym"];
		var ym_m_str = this.lca["label:ym-m"].split("|");
		var s = ym_format;
		s = s.replace("%y%",this.sel_y);
		s = s.replace("%m%",ym_m_str[this.sel_m]);
		this.jqo_ym.html(s);
	},

	updateDayTbl : function() {
		var s = this.drawMonth(this.sel_y,this.sel_m);
		this.jqo_daytbl.html(s);

		var isCrSpace = function( evt ) {
			evt = (evt) ? evt : window.event;
			var cc = (evt.which) ? evt.which : evt.keyCode;
			return (
				( 13 == cc ) || //CR
				( 32 == cc )    //Space
			);
		};

		var _this = this;
		this.jqo_daytbl.find(".dtpk-inday").click(function(){
			_this.jqo_daytbl.find(".dtpk-inday").removeClass("dtpk-selday");
			$(this).addClass("dtpk-selday");
			_this.sel_d = parseInt($(this).attr("data-date"));
		})
		.keypress(function(e){
			if ( isCrSpace(e) ) {
				$(this).trigger("click");
			} else {
				e.preventDefault();
			}
		});
	},

	update : function( b_keep_sel_d ) {
		if ( !b_keep_sel_d ) {
			this.sel_d = null;
		}
		this.updateSelYM();
		this.updateYM();
		this.updateDayTbl();
	},

	setVal : function( d ) {
		this.sel_y = d.getFullYear();
		if ( this.sel_y < this.start_y ) {
			this.sel_y = this.start_y;
		}
		if ( this.sel_y > this.end_y ) {
			this.sel_y = this.end_y;
		}
		this.sel_m = d.getMonth();
		this.sel_d = d.getDate();
		this.update(true);
	},

	getVal : function() {
		if ( this.sel_d ) {
			var v = this.sel_y + "-" +
				(this.sel_m+1) + "-" +
				this.sel_d;
			return CDateTool.DateL(v)
		} else {
			return null;
		}
	}
};

window.CDatePicker = CDatePicker;

}(jQuery));
