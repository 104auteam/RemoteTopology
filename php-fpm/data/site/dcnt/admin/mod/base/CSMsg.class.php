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

class CSMsg {

	private static $binding = array();

	public static function bind( $obj, $ename ) {
		if ( !isset(self::$binding[$ename]) ) {
			self::$binding[$ename] = array();
		}
		self::$binding[$ename][] = $obj;
	}

	public static function unbind( $cname, $ename ) {
		if ( isset(self::$binding[$ename]) ) {
			if ( $cname == "*" ) {
				self::$binding[$ename] = array();
			} else {
				foreach( self::$binding[$ename] as $key => $obj ) {
					if ( get_class($obj) == $cname ) {
						unset(self::$binding[$ename][$key]);
						break;
					}
				}
			}
		}
	}

	public static function trigger( $obj, $ename, $data ) {
		if ( isset(self::$binding[$ename]) ) {
			foreach( self::$binding[$ename] as $obj ) {
				if ( method_exists( $obj, $ename ) ) {
					call_user_func_array(
						array( $obj, $ename ), array( $data ) );
				}
			}
		}
	}

}

?>