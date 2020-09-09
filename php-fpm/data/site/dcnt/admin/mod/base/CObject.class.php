<?php
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

function _hsc( $s ) {
	return htmlspecialchars($s);
}

function _pre( $s ) {
	$s = str_replace("\r","",$s);
	$tx = explode("\n",$s);
	foreach( $tx as &$ln ) {
		$ln = htmlspecialchars($ln);
	}
	return implode("<br/>",$tx);
}

function _req() {
	return '<span class="glyphicon glyphicon-star text-danger" ' . 
		'style="font-size:80%;"></span>';
}

class CObject {

	private static $loadhist = array();

	private function loadProc( $path, $data ) {
		$px = explode( "/", $path );
		if ( count($px) == 1 ) {
			list( $mname ) = $px;
			CModule::connect( $mname );
		} else if ( count($px) == 2 ) {
			list( $mname, $cls ) = $px;
			if ( $mname == "~" ) {
				$mname = $this->mname;
			} else {
				CModule::connect( $mname );
			}
			$p = $mname . "/" . $cls;
			if ( !isset(self::$loadhist[$p]) ) {
				$obj = new $cls;
				self::$loadhist[$p] = $obj;

				$obj->mname = $mname;
				$obj->mod =& CModule::$mods[$mname];
				$obj->init( $data );
			}
		}
	}

	public function load( $ls, $data = null ) {
		if ( is_array( $ls ) ) {
			foreach( $ls as $path ) {
				$this->loadProc( $path, $data );
			}
		} else {
			$this->loadProc( $ls, $data );
		}
	}

	public function bind( $ename ) {
		CSMsg::bind( $this, $ename );
	}

	public function unbind( $cname, $ename ) {
		CSMsg::unbind( $cname, $ename );
	}

	public function trigger( $ename, $data = null ) {
		CSMsg::trigger( $this, $ename, $data );
	}

	public function dirMod() {
		return $this->mod["dir"];
	}

	public function pathMod() {
		return CApp::normPath( CApp::$_rtc["path-entity"] . $this->mod["dir"] . "/" );
	}

	public function urlMod() {
		return CApp::normPath( CApp::$_rtc["url-entity"] . $this->mod["dir"] . "/" );
	}

	public static function obStart() {
		ob_start();
	}

	public static function obEnd() {
		$html = ob_get_contents();
		if ( !empty($html) ) {
			ob_end_clean();
		}
		return $html;
	}

}

?>