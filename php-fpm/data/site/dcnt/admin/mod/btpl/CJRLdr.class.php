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

class CJRLdr {

	public static function loadLocale( $key, $lca = null ) {
		if ( !$lca ) {
			$lca = CEnv::locale( $key );
		}
		echo "<script>";
		echo "CJRLdr.loadLocale('{$key}'," . 
			json_encode($lca) . ");";
		echo "</script>\r\n";
	}

	public static function loadConfig( $key, $cfg = null ) {
		if ( !$cfg ) {
			$cfg = CEnv::config( $key );
		}
		echo "<script>";
		echo "CJRLdr.loadConfig('{$key}'," . 
			json_encode($cfg) . ");";
		echo "</script>\r\n";
	}
}

?>