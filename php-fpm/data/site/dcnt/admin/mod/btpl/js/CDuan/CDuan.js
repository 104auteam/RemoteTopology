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

//-- pollyfill for "trim"
if (!String.prototype.trim) {
	String.prototype.trim = function () {
		return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
	};
}

//-- polyfill for JSON 
if (!window.JSON) {
	window.JSON = {
		parse: function(sJSON) { return eval('(' + sJSON + ')'); },
		stringify: (function () {
			var toString = Object.prototype.toString;
			var isArray = Array.isArray || function (a) { return toString.call(a) === '[object Array]'; };
			var escMap = {'"': '\\"', '\\': '\\\\', '\b': '\\b', '\f': '\\f', '\n': '\\n', '\r': '\\r', '\t': '\\t'};
			var escFunc = function (m) { return escMap[m] ||
				'\\u' + (m.charCodeAt(0) + 0x10000).toString(16).substr(1); };
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

CDuan = {

	getAttr : function ( jqo, key ) {
		if (
			( typeof( jqo.attr( key ) ) == 'undefined' ) || 
			( jqo.attr( key ) == '' ) // for Opera
		) return "";
		return jqo.attr( key );
	},

	isIE7 : function() {
		return (navigator.appVersion.indexOf("MSIE 7.")!=-1);
	},

	isIE8 : function() {
		return (navigator.appVersion.indexOf("MSIE 8.")!=-1);
	},

	isTouchDevice : function() {
		 return (('ontouchstart' in window)
			|| (navigator.MaxTouchPoints > 0)
			|| (navigator.msMaxTouchPoints > 0));
	},

	canCssAnim : function() {
		var b = false;
		elm = document.createElement('div');
		if (( elm.style["animation-name"] !== undefined ) &&
			( elm.style["transition"] !== undefined )) {
			b = true;
		}
		return b;
	},

	blink : function( jqo ) {
		jqo.addClass("duan-blink");
		setTimeout(function(){
			jqo.removeClass("duan-blink");
		},1000);
	},

	copyJsObject : function ( obj ) {
		return $.extend({}, obj);
	},

	setTimeout : function(obj,func,t) {
		setTimeout(function(){
			func.call(obj);
		},t);
	},

	kp_to_click : function(e){
		if ((e.which == 13) || (e.which == 32)) {
			e.preventDefault()
			$(this).trigger("click");
		}
	},

	charLimit : function( jqo_input, jqo_feedback, maxchar, tpl ) {
		var func = function() {
			var len = jqo_input.val().length;
			if ( maxchar < len ) {
				jqo_input.val(jqo_input.val().substring(0,maxchar));
				len = maxchar;
			}
			var s = tpl;
			var s = s.replace("%maxchar%",maxchar);
			var s = s.replace("%numofchar%",len);
			jqo_feedback.html(s);
		};
		jqo_input.bind("input cut paste keyup blur",func);
		func();
	},

	setupBtnAnchor : function( selector ) {

		$( selector ).click( function(e) {
			e.preventDefault();
			var href = $(this).attr('data-href');
			var target = $(this).attr('data-target');
			// For some browsers, `attr` is undefined; for others,
			// `attr` is false.  Check for both.
			if (
				( typeof target !== typeof undefined ) &&
				( target !== false ) &&
				( target == '_blank' )
			) {
				window.open(href);
			} else {
				window.location = href;
			}
		}).css("cursor","pointer");
	},

	setupHiddenArea : function() {
		if ( this.isIE7() ) {
			$(".hidden-ie7").hide();
		}
		if ( this.isIE8() ) {
			$(".hidden-ie8").hide();
		}
	}

};

(function($){

	$(document).ready(function(){
		CDuan.setupBtnAnchor( ".btn-a" );
		CDuan.setupHiddenArea();
	});

}(jQuery));

