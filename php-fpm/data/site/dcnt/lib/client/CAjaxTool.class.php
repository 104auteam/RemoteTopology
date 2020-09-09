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

class CAjaxTool {

	public static function printHeader() {
		header("Content-Type: application/javascript");
	}

	public static function returnAjax( $json ) {
		if ( isset($_GET["callback"]) ) {
			echo $_GET["callback"] . "(" . json_encode( $json ) . ");";
		} else {
			echo json_encode( $json );
		}
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

	public static function getConfig( $px ) {
		return CJson::encode($px);
	}

	public static function includeJs( $path, $fn1, $fn2 ) {
		if ( file_exists( $path . $fn1 ) ) {
			include( $path . $fn1 );
		} else {
			include( $path . $fn2 );
		}
	}
}

?>