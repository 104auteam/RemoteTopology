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

class CPreProc {

	public static function getCurrentPageUrl( $http = true ) {
		$url = "";

		if ( $http ) {
			$url .= "http";

			$b_https = (( isset( $_SERVER["HTTPS"] ) ) && ( $_SERVER["HTTPS"] == "on" ));
			if ( $b_https ) {
				$url .= "s";
			}

			$url .= "://" . $_SERVER['HTTP_HOST'];

			if (( $_SERVER["SERVER_PORT"] != "80" ) && !$b_https ) {
				$url .= ":" . $_SERVER["SERVER_PORT"];
			}
		}

		//-- $_SERVER["SCRIPT_NAME"] trancates GET params and PathInfo.
		$url .= $_SERVER["SCRIPT_NAME"];

		return $url;
	}

	public static function reverseMagicQuote() {
		$func = "reverseMagicQuote_stripslashes_deep";
		if ( !function_exists( $func ) && get_magic_quotes_gpc() ) {
			define( 'REVERSE_MAGIC_QUOTE', $func );
			function reverseMagicQuote_stripslashes_deep( $value ) {
				$value = is_array( $value ) ?
					array_map( REVERSE_MAGIC_QUOTE, $value ) :
					stripslashes( $value );
				return $value;
			}
			$_POST = array_map( $func, $_POST );
			$_GET = array_map( $func, $_GET );
			$_COOKIE = array_map( $func, $_COOKIE );
			$_REQUEST = array_map( $func, $_REQUEST );
		}
	}

	public static function checkPhpVersion() {
		$ver_req = "5.2";
		$ver_cur = phpversion();
		if ( strnatcmp( $ver_cur, $ver_req ) >= 0 ) { 
			# equal or newer 
		} else {
			$err = 
				"<div style='margin:20px auto;padding:20px;width:400px;color:red;border:1px solid red;'>" .
				"This script requires PHP v%ver_req% or later. " .
				"Unfortunately, your PHP version is %ver_cur%. " . 
				"Please upgrade your PHP and try again!" .
				"</div>";
			$err = str_replace("%ver_req%", $ver_req, $err);
			$err = str_replace("%ver_cur%", $ver_cur, $err);
			echo $err;
			exit;
		}

		return true;
	}
}

?>