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

class CSess {

	private static $b_started = false;
	const LOGIN_PAGE = "login";

	public static function startSession() {
		if ( !self::$b_started ) {
			@session_start();
			self::$b_started = true;
			CLongSess::startSession();
			CApp::exproc("session:start");
		}
	}

	public static function getSessKey() {
		return base64_encode( __FILE__ );
	}

	public static function setUserInfoArray( $rs, $b_by_login = true ) {
		self::startSession();
		if ( $b_by_login ) {
			CLongSess::setup( $rs );
		}
		$sesskey = self::getSessKey();
		$_SESSION[$sesskey] = $rs;
		session_commit();
	}

	public static function getUserInfo( $key ) {
		self::startSession();
		$sesskey = self::getSessKey();
		return ( isset($_SESSION[$sesskey][$key]) ) ?
			$_SESSION[$sesskey][$key] : null;
	}

	public static function userID() {
		return self::getUserInfo( "user_id" );
	}

	public static function terminate() {
		CLongSess::terminate( self::getUserInfo( "user_id" ) );

		self::startSession();
		$sesskey = self::getSessKey();
		if ( isset($_SESSION[$sesskey]) ) {
			unset($_SESSION[$sesskey]);
			@session_commit();
		}
	}

	public static function exitSess() {
		$url = CApp::vurl(self::LOGIN_PAGE);
		if ( self::isBend() ) {
			$resp = array();
			$resp['result'] = "@redirect@:{$url}";
			self::returnAjax( $resp );
			exit;
		} else {
			header("Location:{$url}");
		}
	}

	private static function isBend() {
		return isset($_GET["_be"]);
	}

	private static function returnAjax( &$resp ) {
		echo json_encode( $resp );
	}
}

?>