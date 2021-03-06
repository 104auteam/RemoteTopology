/*css
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

function runCAjaxCountDown( $, appcfg ) {

//-- [polyfill] trim
if (!String.prototype.trim) {
	String.prototype.trim = function () {
		return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
	};
};

//-- [polyfill] JSON
if (!window.JSON) {
	window.JSON = {
		parse: function(sJSON) { return eval('(' + sJSON + ')'); },
		stringify: (function () {
			var toString = Object.prototype.toString;
			var isArray = Array.isArray || function (a) { return toString.call(a) === '[object Array]'; };
			var escMap = {'"': '\\"', '\\': '\\\\', '\b': '\\b', '\f': '\\f', '\n': '\\n', '\r': '\\r', '\t': '\\t'};
			var escFunc = function (m) { return escMap[m] || '\\u' + (m.charCodeAt(0) + 0x10000).toString(16).substr(1); };
			var escRE = /[\\"\u0000-\u001F\u2028\u2029]/g;
			return function stringify(value) {
				if (value == null) {
					return 'null';
				} else if (typeof value === 'number') {
					return isFinite(value) ? value.toString() : 'null';
				} else if (typeof value === 'boolean') {
					return value.toString();
				} else if (typeof value === 'object') {
					if (typeof value.toJSON === 'function') {
						return stringify(value.toJSON());
					} else if (isArray(value)) {
						var res = '[';
						for (var i = 0; i < value.length; i++) {
							res += (i ? ', ' : '') + stringify(value[i]);
						}
						return res + ']';
					} else if (toString.call(value) === '[object Object]') {
						var tmp = [];
						for (var k in value) {
							if (value.hasOwnProperty(k)) {
								tmp.push(stringify(k) + ': ' + stringify(value[k]));
							}
						}
						return '{' + tmp.join(', ') + '}';
					}
				}
				return '"' + value.toString().replace(escRE, escFunc) + '"';
			};
		})()
	};
};

function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for(var i = 0; i <ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
};

function printError( msg ) {
	console.log( msg );
};

function CAjaxCountDown( opt ) {
	for( var key in opt ) { this[key] = opt[key]; }
	this.timer_id = null;
	this.setup();
};

CAjaxCountDown.prototype = {

	send : function( requ, func ) {
		var _this = this;
		$.ajax({
			url:appcfg.url_server,
			data:"requ="+encodeURIComponent(JSON.stringify(requ)),
			dataType:"jsonp",
			success:function(resp) {
				_this.process( resp, func );
			},
			error:function( jqXHR, textStatus, errorThrown ) {
				var s = "[$.ajax.error]\n";
				s += jqXHR.responseText+"\n";
				s += textStatus+"\n";
				s += errorThrown;
				printError( s );
			}
		});
	},

	onError : function( resp ) {
		var err_prefix = "@ERR:";
		if ( resp.result.substr(0,err_prefix.length) == err_prefix ) {
			alert(resp.result);
		} else {
			printError(resp.result);
		}
	},

	process : function( resp, func ) {
		if ( resp.result == "OK" ) {
			func.call( this, resp );
		} else {
			this.onError( resp );
		}
	},

	setup : function() {
		var _this = this;

		//-- jQuery version info
		if ( appcfg.info ) {
			console.log("INFO","[jQuery version]",$.fn.jquery);
		}

		var t_remaining = appcfg.rec.t_remaining;
		this.b_done = this.isDone();
		if ( this.b_done ) {
			t_remaining = 0;
		}

		this.t_end = appcfg.dt_init + t_remaining * 1000;

		var _this = this;
		this.onTick();
		this.timer_id = setInterval(function(){
			_this.onTick();
		}, 1000);
	},

	padZero : function( num ){
		var s = num.toString();
		while ( s.length < 2 ) {
			s = '0' + s;
		}
		return s;
	},

	renderItem : function( key, val, str ) {
		return "<span class='acdown-"+key+"'>" +
			"<span class='acdown-"+key+"-val'>" +
			val +
			"</span>" +
			"<span class='acdown-"+key+"-str'>" +
			str +
			"</span>" +
			"</span>";
	},

	getCountDownStr : function( total ) {

		if ( total < 0 ) {
			total = 0;
		}
		var min = parseInt(total / 60);
		sec = total % 60;
		var hour = parseInt(min / 60);
		min = min % 60;
		var day = parseInt(hour / 24);
		hour = hour % 24;

		var sx = [];

		var pat = appcfg.rec.str_day;
		pat = pat || "";
		pat = pat.replace(/%s%/,(day != 1) ? "s" : "", pat);
		var s = this.renderItem("day",day.toString(),pat);
		sx.push(s);

		var pat = appcfg.rec.str_hour;
		pat = pat || "";
		pat = pat.replace(/%s%/,(hour != 1) ? "s" : "", pat);
		var s = this.renderItem("hour",this.padZero(hour.toString()),pat);
		sx.push(s);

		var pat = appcfg.rec.str_min;
		pat = pat || "";
		pat = pat.replace(/%s%/,(min != 1) ? "s" : "", pat);
		var s = this.renderItem("min",this.padZero(min.toString()),pat);
		sx.push(s);

		var pat = appcfg.rec.str_sec;
		pat = pat || "";
		pat = pat.replace(/%s%/,(sec != 1) ? "s" : "", pat);
		var s = this.renderItem("sec",this.padZero(sec.toString()),pat);
		sx.push(s);

		var str = "<span class='acdown' data-id='"+this.id+"'>" +
			sx.join("") +
			"</span>";

		return str;
	},

	getRemainingTime : function() {
		return Math.floor(( this.t_end - Date.now() ) / 1000);
	},

	getCookieKey : function() {
		return "ajaxcountdown_"+this.id;
	},

	setDone : function() {
		document.cookie = this.getCookieKey() + "=" + appcfg.rec.t_remaining;
	},

	isDone : function() {
		var val = parseInt(getCookie(this.getCookieKey()));
		return ( val == appcfg.rec.t_remaining );
	},

	onZero : function() {
		if ( !this.b_done ) {
			this.setDone();
			if ( appcfg.rec.b_redirect ) {
				window.location = appcfg.rec.url_redirect;
			}
		}
	},

	onUpdate : function( rtime ) {
		var s = this.getCountDownStr(rtime);
		this.jqo_ctar.html(s);
	},

	onTick : function() {
		if ( this.timer_id == null ) {
			return;
		}

		var rtime = this.getRemainingTime();
		this.onUpdate(rtime);
		if ( rtime <= 0 ) {
			clearInterval(this.timer_id);
			this.onZero();
		}
	}

};

$("."+appcfg.selector).each(function(){
	new CAjaxCountDown({
		id:appcfg.id,
		jqo_ctar:$(this)
	});
});

};
