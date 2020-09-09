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

//[!VT][2016-12-24][v2.2]
(function($){

//-- isArray
if (!Array.isArray) {
	Array.isArray = function(arg) {
		return Object.prototype.toString.call(arg) === '[object Array]';
	};
}

CForm = {

	sendMsg : function( form, msg ) {
		form.find("._ffe_").each(function(){
			var jqo = $(this);
			if ( jqo.data("_obj_") ) {
				if ( jqo.data("_obj_").msgProc ) {
					jqo.data("_obj_").msgProc( msg );
				}
			}
		});
	},

	getJqo : function( form, nm ) {
		var jqo = form.find('input[name="'+nm+'"]');
		if ( jqo.length ) {
			return jqo;
		}
		var jqo = form.find('select[name="'+nm+'"]');
		if ( jqo.length ) {
			return jqo;
		}
		var jqo = form.find('textarea[name="'+nm+'"]');
		if ( jqo.length ) {
			return jqo;
		}

		return null;
	},

	getData : function( jqo ) {
		if (
			( jqo != null ) &&
			( jqo.length >= 1 ) &&
			( jqo.hasClass("_ffe_") ) &&
			( jqo.data("_obj_") ) ) {

			//if ( jqo.data("_obj_").saveData ) {//Commit
			//	jqo.data("_obj_").saveData();
			//}

			if ( jqo.data("_obj_").getData ) {
				//-- JSON
				v = jqo.data("_obj_").getData();
			} else {
				v = jqo.val();
			}
		} else {
			v = jqo.val();
		}

		return v;
	},

	getType : function( form, nm ) {
		var jqo = form.find('input[name="'+nm+'"]');
		if ( jqo.length ) {
			return jqo.attr("type");
		}
		var jqo = form.find('select[name="'+nm+'"]');
		if ( jqo.length ) {
			return "select";
		}
		var jqo = form.find('textarea[name="'+nm+'"]');
		if ( jqo.length ) {
			return "textarea";
		}
	},

	get : function( form, ls ) {
		if ( ls === undefined ) {
			var _this = this;
			var px = {};
			form.find("._ffe_").each(function(){
				var nm = $(this).attr("name");
				px[nm] = _this._get( form, nm );
			});
		} else if ( Array.isArray(ls) ) {
			var px = {};
			for( var i=0; i<ls.length; i++ ) {
				var nm = ls[i];
				px[nm] = this._get( form, nm );
			}
		} else {
			var px = this._get( form, ls );
		}

		return px;
	},

	_get : function( form, nm ) {

		var type = this.getType(form,nm);

		var v = '';
		switch( type ) {

		default:
			var jqo = form.find('input[name="'+nm+'"]');
			v = this.getData(jqo);
			break;

		case "radio":
			v = form
				.find('input:radio[name="'+nm+'"]:checked')
				.val();
			if ( !v ) { v = ""; }
			break;

		case "checkbox":
			var jqo = form.find('input:checkbox[name="'+nm+'"]');
			if ( jqo.length == 1 ) {
				v = jqo.is(':checked') ? 1 : 0;
			} else {
				var rx = [];
				jqo.each(function(){
					if ( $(this).is(':checked') ) {
						rx.push($(this).val());
					}
				});
				v = rx.join(',');
			}
			break;

		case "select":
			v = form
				.find('select[name="'+nm+'"] option:selected')
				.val();
			break;

		case "textarea":
			var jqo = form.find('textarea[name="'+nm+'"]');
			v = this.getData(jqo);
			break;
		}

		return v;
	},

	set : function( form, nv, val ) {
		if ( val == undefined ) {
			for( var nm in nv ) {
				this._set(form,nm,nv[nm]);
			}
		} else {
			this._set(form,nv,val);
		}
	},

	_set : function( form, nm, val ) {

		var type = this.getType(form,nm);
		var jqo = null;

		switch( type ) {

		default:
			jqo = form.find('input[name="'+nm+'"]');
			if ( val != undefined ) {
				jqo.val(val);
			}
			break;

		case "radio":
			jqo = form.find('input:radio[name="'+nm+'"][value="' + val + '"]');
			if ( val != undefined ) {
				jqo.attr('checked', 'checked');
			}
			break;

		case "checkbox":
			jqo = form.find('input:checkbox[name="'+nm+'"]');
			if ( val != undefined ) {
				if ( jqo.length == 1 ) {
					jqo.prop('checked',val);
				} else {
					var rx = val.split(",");
					jqo.each(function(){
						var b = $.inArray($(this).val(),rx) == -1 ? 0 : 1;
						$(this).prop('checked',b);
					});
				}
			}
			break;

		case "select":
			jqo = form.find('select[name="'+nm+'"]');
			if ( val != undefined ) {
				jqo.val(val);
			}
			break;

		case "textarea":
			jqo = form.find('textarea[name="'+nm+'"]');
			if ( val != undefined ) {
				jqo.val(val);
			}
			break;
		}

		//-- load data from FFE(Form Field Element)
		if (
			( jqo != null ) &&
			( jqo.length >= 1 ) &&
			( jqo.hasClass("_ffe_") ) &&
			( jqo.data("_obj_") ) &&
			( jqo.data("_obj_").loadData ) ) {
			jqo.data("_obj_").loadData();
		}

	},

	setup : function( form, nv ) {
		for( var nm in nv ) {
			this._setup(form,nm,nv[nm]);
		}
	},

	_setup : function( form, nm, val ) {

		var type = this.getType(form,nm);

		switch( type ) {

		case "select":
			// {options:...,selected:...}
			var select = form.find('select[name="'+nm+'"]');
			select.html("");
			var sel = ( "selected" in val ) ? val.selected : '';
			$.each(val.options, function(key, value) {
				var data = {value:key,text:value};
				if ( key == sel ) {
					data.selected = "selected";
				}
				select.append($("<option/>", data));
			});
			break;

		}
	},

	setFRes : function( jqo_form, fres ) {
		//-- reset field status
		jqo_form
			.find("input,select,textarea")
			.parents(".form-group")
			.removeClass("has-error")
			.removeClass("has-success")
			.removeClass("has-warning");

		//-- reset form alert
		var jqo_falert = jqo_form.find(".ctar-falert");
		jqo_falert.html("");

		if ( fres ) {
			//-- set field status
			if ( fres.fstate ) {
				for ( var nm in fres.fstate ) {
					// fs: success, wanring, error
					var fs = fres.fstate[nm];
					jqo_form.find(
						"input[name='"+nm+"'],"+
						"select[name='"+nm+"'],"+
						"textarea[name='"+nm+"']")
					.parents(".form-group")
					.addClass("has-"+fs);
				}
			}

			//-- write field alert
			if ( fres.falert ) {
				var ss = "";
				for ( var i=0; i<fres.falert.length; i++ ) {
					var rec = fres.falert[i];

					//-- setup class and icon
					var cls;
					var icon = null;
					switch( rec.atype ) {
					case "error":
						cls = "danger";
						icon = "exclamation-sign";
						break;
					case "success":
						cls = "success";
						icon = "ok-sign";
						break;
					case "info":
						cls = "info";
						icon = "info-sign";
						break;
					}

					//-- setup icon html
					var icon_html = "";
					if ( icon ) {
						icon_html = '<span class="glyphicon glyphicon-' + icon + '" ' +
						'style="vertical-align:middle;font-size:120%;"></span>';
					}

					//-- create an alert
					var s = '<div class="alert alert-' + cls + '" role="alert">' +
						icon_html +
						'&nbsp;&nbsp;<span style="vertical-align:middle;">' +
						rec.msg + '</span></div>';

					ss += s;
				}

				var mode = jqo_falert.attr("data-display-mode");
				if ( mode && ( mode == "dialog" ) ) {
					if ( ss ) {
						CMsgBox.show( ss );
					}
				} else {
					jqo_falert.append(ss);
				}
			}
		}
	}
};

}(jQuery));
