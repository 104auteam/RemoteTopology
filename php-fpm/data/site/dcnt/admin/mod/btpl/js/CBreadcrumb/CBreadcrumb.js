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

CBreadcrumb = {

	bc : [],

	getJqo : function () {
		return $(".ctar-bcrumb");
	},

	findBreakIdx : function ( bc ) {
		for ( var i=0; i<bc.length; i++ ) {
			if (( i >= this.bc.length ) ||
				( bc[i] != this.bc[i] )) {
				return i;
			}
		}
		return i;
	},

	getDrops : function ( jqo_bc, idx ) {
		var i = idx;
		var jqo_total = $();
		do {
			var jqo = jqo_bc.find(".bcrumb-item[data-id='"+i+"']");
			if ( jqo.length ) {
				if ( i > 0 ) {
					jqo_total = jqo_total.add(jqo_bc
						.find(".bcrumb-item[data-id='"+i+"a']"));
					jqo_total = jqo_total.add(jqo);
				}
				i++;
			}
		} while( jqo.length );

		return jqo_total;
	},

	getAddNew : function ( idx, bc ) {
		var jqo_total = $();
		for ( var i=idx; i<bc.length; i++ ) {
			if ( i > 0 ) {
				jqo_total = jqo_total.add($("<div>")
					.attr("class","bcrumb-item")
					.attr("data-id",i+"a")
					.html($("<span>")
						.attr("class","glyphicon glyphicon-play " +
							"bcrumb-arrow")
					)
				);
			}
			jqo_total = jqo_total.add($("<div>")
				.attr("class","bcrumb-item")
				.attr("data-id",i)
				.html(bc[i])
			);
		}

		return jqo_total;
	},

	write : function ( bc ) {
		if ( typeof bc === "string" ) {
			bc = bc.split("\/");
		}
		var bidx = this.findBreakIdx(bc);

		var jqo_bc = this.getJqo();
		this._write( jqo_bc.eq(0), bidx, bc );
		this._write( jqo_bc.eq(1), bidx, bc );
		this.bc = bc;
	},

	_write : function ( jqo_bc, bidx, bc ) {

		var jqo_drops = null;
		var jqo_addnew = null;

		if ( bidx < this.bc.length ) {
			jqo_drops = this.getDrops(jqo_bc,bidx);
		}
		if ( bidx < bc.length ) {
			jqo_addnew = this.getAddNew(bidx,bc);
		}

		var t_init = 100;
		var t_move1 = 200;
		var t_move2 = 500;
		var t_addnew = 500;

		setTimeout(function(){
			if ( jqo_drops ) {
				jqo_drops.each(function(){
					$(this)
						.animate({
							opacity:0,
							top:"-=50px"
						},t_move1,function(){
							$(this).remove();
						});
				});
			}

			if ( jqo_addnew ) {
				setTimeout(function(){
					jqo_addnew.each(function(){
						$(this).appendTo(jqo_bc)
						$(this)
							.css({
								opacity:0,
								position:"relative",
								top:"-=50px"
							})
							.animate({
								opacity:1,
								top:"+=50px"
							},t_move2);
					});
				},t_addnew);
			}
		},t_init);
	}

};

