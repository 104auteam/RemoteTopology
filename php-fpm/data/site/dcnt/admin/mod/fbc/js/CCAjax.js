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

var err_display = "console";

function CCAjax( opt ){
	// opt.url_be : backend entry url
	for ( var key in opt ) { this[key] = opt[key]; }

	if ( !this.url_be ) {
		this.url_be = window.url_be_entry;
	}
};

CCAjax.prototype = {

	printError : function( msg ) {
		switch ( err_display ) {
		case 'alert':
			alert(msg);
			break;
		case 'console':
			console.log(msg);
			break;
		}
	},

	send : function( requ, obj, func ) {
		CUWait.start();

		var _this = this;
		$.ajax({
			url:this.url_be,
			data:"requ="+encodeURIComponent(JSON.stringify(requ)),
			dataType: 'json',
			type:'POST',
			success:function(resp){
				CUWait.stop();

				_this.process( resp, obj, func );
			},
			error:function( jqXHR, textStatus, errorThrown ){
				CUWait.stop();

				var s = '[$.ajax.error]\n';
				s += jqXHR.responseText+'\n';
				s += textStatus+'\n';
				s += errorThrown;
				_this.printError( s );
			}
		});
	},

	onError : function( resp ) {
		this.printError( resp.result );
	},

	process : function( resp, obj, func ) {
		if ( resp.result == 'OK' ) {
			func.call(obj,resp);
		} else {
			var sig = "@redirect@:";
			if ( resp.result.substr(0,sig.length) == sig ) {
				var url = resp.result.substr(sig.length);
				document.location.href = url;
			} else {
				this.onError( resp );
			}
		}
	}

};

window.CCAjax = CCAjax;

}(jQuery));
