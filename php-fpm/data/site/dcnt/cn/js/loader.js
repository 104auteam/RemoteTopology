
//-- [BEGIN] CAjaxCountDown specific
//-- pollyfill for Date.now()
if (!Date.now) {
	Date.now = function now() {
		return new Date().getTime();
	};
}

cfg.appcfg["dt_init"] = Date.now();
//-- [END] CAjaxCountDown specific

if (!document.getElementsByClassName) {
	document.getElementsByClassName = function(cname) {
		var rx = [];
		var eles = document.getElementsByTagName("*");
		var pat = new RegExp("(^|\\s)" + cname + "(\\s|$)");
		for (var i=0; i<eles.length; i++) {
			if (pat.test(eles[i].className)) {
				rx.push(eles[i]);
			}
		}
		return rx;
	};
}

function insertInstaTag() {
	var cname = cfg.appcfg.selector;
	var eles = document.getElementsByClassName(cname);
	if ( !eles.length ) {
		document.write("<div class='"+cname+"'></div>");
	}
};

function getVerN( ver ){
	var vx = ver.split(".");
	var cof = 1.0;
	var total = 0.0;
	for( var i=0; i<vx.length; i++ ) {
		total += parseInt(vx[i]) * cof;
		cof = cof / 100;
	}
	return total;
};

function shouldLoadJq( cfg ) {
	var b_load_jq = true;
	if ( window.jQuery ) {
		b_load_jq = false;
		var jq_vn = getVerN(window.jQuery.fn.jquery);
		if ( cfg.jq_min_ver ) {
			if ( jq_vn < getVerN(cfg.jq_min_ver) ) {
				b_load_jq = true;
			}
		}
		if ( cfg.jq_max_ver ) {
			if ( jq_vn >= getVerN(cfg.jq_max_ver) ) {
				b_load_jq = true;
			}
		}
	}
	return b_load_jq;
};

function loadScript(url, callback){
	if ( !url ) {
		callback( false );
		return;
	}

	var script = document.createElement("script");
	script.type = "text/javascript";

	if (script.readyState){/*IE*/
		script.onreadystatechange = function(){
			if (script.readyState == "loaded" ||
				script.readyState == "complete"){
				script.onreadystatechange = null;
				callback( true );
			}
		};
	} else {/*Others*/
		script.onload = function(){
			callback( true );
		};
	}

	script.src = url;

	/*-- document.head.appendChild(script); --*/
	/*-- document.head isn't available to IE<9. Just use  --*/
	document.getElementsByTagName("head")[0].appendChild(script);
};

var b_done = false;
function runApp(loader) {
	if ( !b_done && loader.jQuery && loader.app_main) {
		b_done = true;
		loader.app_main(loader.jQuery,cfg.appcfg);
	}
};

function main() {
	insertInstaTag();

	if (!(cfg.loader_sig in window)) {
		window[cfg.loader_sig] = {
			jQuery:null,
			app_main:null
		};
	}
	var loader = window[cfg.loader_sig];

	runApp(loader);

	if (!b_done) {
		/*-- load jQuery --*/
		if (!loader.jQuery) {
			var url_js1 = shouldLoadJq(cfg) ? cfg.url_js1 : null;
			loadScript(url_js1,function(b_loaded){
				loader.jQuery = window.jQuery;
				if (b_loaded) {
					window.jQuery.noConflict(true);
				}
				runApp(loader);
			});
		}

		/*-- load App --*/
		if (!loader.app_main) {
			loadScript(cfg.url_js2,function(b_loaded){
				loader.app_main = window[cfg.app_main];
				runApp(loader);
			});
		}
	}
};

main();
