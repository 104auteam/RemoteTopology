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

function copyToClipboard(text) {
	try {
		if (window.clipboardData && window.clipboardData.setData) {
			// IE specific code path to prevent textarea being shown while dialog is visible.
			return clipboardData.setData("Text", text); 
		} else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
			var textarea = document.createElement("textarea");
			textarea.textContent = text;
			//-- Prevent scrolling to bottom of page in MS Edge.
			textarea.style.position = "fixed";  
			document.body.appendChild(textarea);
			textarea.select();
			try {
				return document.execCommand("copy");
			} catch(ex) {
				return false;
			} finally {
				document.body.removeChild(textarea);
			}
			return true;
		} else {
			return false;
		}
	} catch(ex) {
		return false;
	}
	return true;
};

function CInpCopy2Clip( opt ) {
	for( var key in opt ) { this[key] = opt[key]; }
	this.setup();
};

CInpCopy2Clip.prototype = {

	setup : function(){

		var _this = this;

		this.jqo_inp.click(function(e){
			e.preventDefault();
			var text = $(this).attr("data-text");
			if ( copyToClipboard(text) ) {
				var xy = $(this).offset();
				var w = $(this).outerWidth();
				var h = $(this).outerHeight();
				var lca = CJRLdr.locale("inpcopy2clip/inp");
				$("<div>")
					.attr("class","inpcopy2clip-copied")
					.html(lca["text:success"])
					.css({
						position:"absolute",
						left:xy.left+"px",
						top:xy.top+"px",
						width:w+"px",
						height:h+"px",
						"line-height":h+"px",
						"z-index":1000,
						opacity:0
						})
					.appendTo("body")
					.animate({
						opacity:1
					},500,function(){
						$(this).animate({
							top:"-="+50+"px",
							opacity:0
						},1500,function(){
							$(this).remove();
						});
					});
			} else {
				CDlgCopy2Clip.open({
					jqo_ctar:$(".dlgcopy2clip"),
					text:text
				});
			}
		});
	}

};

window.initCInpCopy2Clip = function() {
	$(".inpcopy2clip").each( function(){
		if ( !$(this).data("_obj_") ) {
			var obj = new CInpCopy2Clip({jqo_inp:$(this)});
			$(this).data("_obj_",obj);
		}
	});
};

}(jQuery));
