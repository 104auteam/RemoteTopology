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
CDateTool = {

	// alternate method for "new Date" to ensure the str
	// is interpreted as a local date string
	DateL : function( str ) {
		var d = this.parseDate( str, "iso" );
		if ( isNaN(d) ) {
			d = this.parseDate( str, "short" );
		}
		return d;
	},

	parseDate : function( str, dtype ) {
		var pat;
		switch( dtype ) {
		case "iso":
			//-- YYYY-MM-DD HH:MM
			pat1 = /^(\d{4})-(\d{1,2})-(\d{1,2})(?: (\d{1,2}):(\d{1,2}))?$/;
			//-- YYYY-MM-DD HH:MM:SS
			pat2 = /^(\d{4})-(\d{1,2})-(\d{1,2})(?: (\d{1,2}):(\d{1,2}):(\d{1,2}))?$/;
			break;
		case "short":
			//-- YYYY-MM-DD HH:MM
			pat1 = /^(\d{1,2})\/(\d{1,2})\/(\d{4})(?: (\d{1,2}):(\d{1,2}))?$/;
			//-- YYYY-MM-DD HH:MM:SS
			pat2 = /^(\d{1,2})\/(\d{1,2})\/(\d{4})(?: (\d{1,2}):(\d{1,2}):(\d{1,2}))?$/;
			break;
		}

		var mx = str.match(pat1);
		if ( !mx ) {
			mx = str.match(pat2);
			if ( !mx ) { return NaN; }
		}

		switch( dtype ) {
			case "short":
			var m = mx[1];
			var d = mx[2];
			var y = mx[3];
			mx[1] = y;
			mx[2] = m;
			mx[3] = d;
			break;
		}

		if ( !mx[4] ) { mx[4] = 0; }
		if ( !mx[5] ) { mx[5] = 0; }
		if ( !mx[6] ) { mx[6] = 0; }
		if (
			(( 1 <= mx[2] ) && ( mx[2] <= 12 )) &&
			(( 1 <= mx[3] ) && ( mx[3] <= 31 )) &&
			(( 0 <= mx[4] ) && ( mx[4] < 24 )) &&
			(( 0 <= mx[5] ) && ( mx[5] < 60 )) &&
			(( 0 <= mx[6] ) && ( mx[6] < 60 ))
		) {
			return new Date(mx[1],mx[2]-1,mx[3],mx[4],mx[5],mx[6]);
		}

		return NaN;
	},

	format : function( date, format ) {
		if ( !isNaN(date) ) {
			var y = date.getFullYear();
			var m = date.getMonth();
			var d = date.getDate();
			ret = y + "-" +
				("0"+(m+1)).slice(-2) + "-" +
				("0"+d).slice(-2);

			var h = date.getHours();
			var m = date.getMinutes();
			var s = date.getSeconds();
			ret += " " +
				("0"+h).slice(-2) + ":" +
				("0"+m).slice(-2);
			if ( format == "YMDHMS" ) {
				ret += ":" + ("0"+s).slice(-2);
			}

			return ret;
		}

		return "";
	}
};
