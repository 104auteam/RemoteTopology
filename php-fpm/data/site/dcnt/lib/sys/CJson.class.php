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

class CJson {

	private static function dq( $txt ) {
		if ( empty($txt) ) {
			return "null";
		}

		# \b  Backspace (ascii code 08)
		# \f  Form feed (ascii code 0C)
		# \n  New line
		# \r  Carriage return
		# \t  Tab
		# \"  Double quote
		# \\  Backslash character
		$conv = array(
			"\\"=>"\\\\",
			"\b"=>"\\b",
			"\f"=>"\\f",
			"\r"=>"\\r",
			"\n"=>"\\n",
			"\t"=>"\\t",
			"\""=>"\\\"",
		);
		foreach( $conv as $key => $val ) {	
			$txt = str_replace( $key, $val, $txt );
		}

		return '"' . $txt . '"';
	}

	public static function isList( $ax ) {
		$i = 0;
		foreach( $ax as $key => $val ) {
			if ( is_int( $key ) && ( $key == $i ) ) {
				$i++;
			} else {
				return false;
			}
		}
		return true;
	}

	private static function json_encode_uu( $ax ) {

		$b_list = self::isList( $ax );

		$rx = array();
		foreach( $ax as $key => $val ) {
			$s = $b_list ? "" : ( self::dq( $key ) . ":" );
			if ( is_array( $val ) ) {
				$s .= self::json_encode_uu( $val );
			} else if ( is_int( $val ) || is_float( $val ) ) {
				$s .= $val;
			} else if ( is_bool( $val ) ) {
				$s .= $val ? "true" : "false";
			} else {
				$s .= self::dq( $val );
			}
			$rx[] = $s;
		}

		$s = implode( ",", $rx );
		if ( $b_list ) {
			$s = "[" . $s . "]";
		} else {
			$s = "{" . $s . "}";
		}

		return $s;
	}

	public static function encode( $x ) {
		if ( defined( 'JSON_UNESCAPED_UNICODE' ) ) {
			return json_encode( $x, JSON_UNESCAPED_UNICODE );
		} else {
			return self::json_encode_uu( $x );
		}
	}

	public static function decode( $json ) {
		return json_decode( $json, true );
	}

}

?>