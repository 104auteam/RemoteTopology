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

class CUG {

	private static $root_admin_id = null;

	private static function loadRootAdminId() {
		$cfg = CEnv::config( "user/root-admin" );
		self::$root_admin_id = $cfg["root-admin-id"];
	}

	public static function rootAdminId() {
		if ( is_null(self::$root_admin_id) ) {
			self::loadRootAdminId();
		}
		return self::$root_admin_id;
	}

	public static function isRootAdminId( $user_id ) {
		if ( is_null(self::$root_admin_id) ) {
			self::loadRootAdminId();
		}
		return $user_id == self::$root_admin_id;
	}

	public static function isAdmin() {
		return ( CSess::getUserInfo("b_admin") == 1 );
	}
}

?>