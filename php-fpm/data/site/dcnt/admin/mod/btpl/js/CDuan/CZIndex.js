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

CZIndex = {

	stack : [0],
	inc_first : 10000,
	inc_other : 1,

	currentZ : function() {
		return this.stack[this.stack.length-1];
	},

	capture : function() {
		var inc = this.inc_other;
		if ( this.stack.length == 1 ) {
			inc = this.inc_first;
		}
		var z_index = this.stack[this.stack.length-1]+inc;
		this.stack.push(z_index);
		return z_index;
	},

	release : function() {
		this.stack.pop();
	}
};
