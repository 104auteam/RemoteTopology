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

CJRLdr = {

	dx_locale : {},
	dx_config : {},

	loadLocale : function( key, dx ) {
		this.dx_locale[key] = dx;
	},

	locale : function( key ) {
		return this.dx_locale[key];
	},

	loadConfig : function( key, dx ) {
		this.dx_config[key] = dx;
	},

	config : function( key ) {
		return this.dx_config[key];
	}

};

}());
