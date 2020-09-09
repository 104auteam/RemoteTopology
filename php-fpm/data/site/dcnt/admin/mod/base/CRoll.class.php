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

//[!VT][2016-12-31][v2.0]
class CRoll {

	public static $rolls = null;

	public static function setup( $_rtc ) {
		$path = $_rtc["path-entity"] . "/roll.inc.php";
		if ( file_exists($path) ) {
			$rolls =& self::$rolls;
			include_once($path);
		}
	}

	public static function getAllRolls() {
		$rx = array("public");
		if ( !is_null(self::$rolls) ) {
			if ( CSess::userID() ) {
				array_push($rx,"regular");
				if ( CSess::getUserInfo("b_admin") ) {
					array_push($rx,"admin");
				}
			}
		}
		return $rx;
	}

	public static function hasRoll( $rolls ) {
		if ( !is_array($rolls) ) {
			$rolls = array($rolls);
		}
		$rx = self::getAllRolls();
		foreach( $rolls as $roll ) {
			if ( in_array($roll,$rx) ) {
				return true;
			}
		}
		return false;
	}

	public static function hasAccess( $mname ) {
		if ( is_null(self::$rolls) ) { return true; }

		$rx = self::getAllRolls();
		foreach( $rx as $roll ) {
			if ( isset(self::$rolls[$roll]) ) {
				if ( is_array(self::$rolls[$roll]) ) {
					if ( in_array($mname,self::$rolls[$roll]) ) {
						return true;
					}
				} else {
					if ( self::$rolls[$roll] == "*" ) {
						return true;
					}
				}
			}
		}
		return false;
	}

	public static function checkAccess( $mname ) {
		if ( is_null(self::$rolls) ) { return; }

		if ( !self::hasAccess($mname) ) {
			CSess::exitSess();
		}
	}
}

?>