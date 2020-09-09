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

(function(){

function CJMS(){
	this.binding = {};
};

CJMS.prototype = {

	trigger : function( ename, data ) {
		if ( ename in this.binding ) {
			var ls = this.binding[ename];
			for( ele in ls ) {
				var rec = ls[ele];
				rec.func.call(rec.obj,data);
			}
		}
	},

	bind : function( ename, obj, func ) {
		if (!( ename in this.binding )) {
			this.binding[ename] = [];
		}
		this.binding[ename].push({
			obj:obj,
			func:func
		});
	}

};

window.CJMS = CJMS;

}());
