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

CPageStack = {

	stack : [],
	b_full : false,
	b_pop_on_next_push : false,

	init : function( breadcrumb ) {
		this.breadcrumb = breadcrumb;
		if ( this.breadcrumb ) {
			CBreadcrumb.write(this.breadcrumb);
		}
	},

	pushPage : function( jqo_frame, html, breadcrumb ) {
		if ( this.b_pop_on_next_push ) {
			this.popPage();
			this.b_pop_on_next_push = false;
		}

		if ( jqo_frame == null ) {
			jqo_frame = $(".main-container");
			this.b_full = true;
		}

		var rec = {};
		rec.breadcrumb = this.breadcrumb;
		rec.jqo_focus = $(document.activeElement);
		rec.jqo_frame = jqo_frame;

		rec.jqo_frame.before(html);
		rec.jqo_active = rec.jqo_frame.prev();
		rec.jqo_active.show();
		if ( this.b_full ) {
			// show top breadcrumb 
			rec.jqo_active.prev().show();
		}

		this.stack.push(rec);

		window.scrollTo(0,0);
		this.breadcrumb = breadcrumb;
		if ( this.breadcrumb ) {
			CBreadcrumb.write(this.breadcrumb);
		}

		rec.jqo_frame.hide();

		return rec.jqo_active;
	},

	popPageOnNextPush : function() {
		this.b_pop_on_next_push = true;
	},

	popPage : function() {
		var rec = this.stack.pop();
		if ( this.b_full ) {
			// hide top breadcrumb 
			rec.jqo_active.prev().hide();
			this.b_full = false;
		}
		rec.jqo_active.remove();
		rec.jqo_frame.show();
		this.breadcrumb = rec.breadcrumb;

		if ( this.breadcrumb ) {
			CBreadcrumb.write(this.breadcrumb);
		}
		rec.jqo_focus.focus();

		CScrollBtn.update();
	}

};

}(jQuery));
