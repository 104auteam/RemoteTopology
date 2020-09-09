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

class CLongSess {

	private static function createRandomString( $n ) {
		$s = '';
		for ( $i = 0; $i < $n; $i++ ) {
			$s .= chr(rand(97, 122));
		}
		return $s;
	}

	private static function getSigCookieKey() {
		return 'sess-sig';
	}

	private static function getNewExpTime() {
		$cfg = CEnv::config("sess/sess");
		$sess_period = $cfg["sess-period"];
		return time() + $sess_period;
	}

	private static function getUrlCookie() {
		return dirname(dirname($_SERVER["SCRIPT_NAME"]));
	}
	
	private static function setSigCookie( $exp_time, $sess_sig ) {
		setcookie(
			self::getSigCookieKey(),
			$sess_sig,
			$exp_time,
			self::getUrlCookie()
		);
	}

	private static function getNewSessExp( $exp_time ) {
		return date("Y-m-d H:i:s", $exp_time );
	}

	private static function getNewSessSig() {
		return self::createRandomString(50);
	}

	public static function startSession() {
		if ( !CSess::getUserInfo( "user_id" ) ) {

			$ckey = self::getSigCookieKey();
			if ( !isset( $_COOKIE[$ckey] ) ) {
				return;
			}
			$sess_sig = $_COOKIE[$ckey];

			CDb::open();
			$rs = CTable::findByID( "user", "sess_sig", $sess_sig, null );
			if ( !$rs ) {
				return;
			}

			if ( $rs["sess_exp"] < date("Y-m-d H:i:s") ) {
				return;
			}

			$exp_time = self::getNewExpTime();
			$rs["sess_exp"] = self::getNewSessExp( $exp_time );
			CTable::updateByID( "user", "user_id", $rs["user_id"], array(
				"sess_exp"=>$rs["sess_exp"],
			));

			self::setSigCookie( $exp_time, $sess_sig );

			CSess::setUserInfoArray( $rs, false );
		}
	}

	public static function setup( &$rs ) {
		$user_id = $rs["user_id"];
		$exp_time = self::getNewExpTime();
		$sess_exp = self::getNewSessExp( $exp_time );
		$sess_sig = self::getNewSessSig();

		CTable::updateByID( "user", "user_id", $user_id, array(
			"sess_exp"=>$sess_exp,
			"sess_sig"=>$sess_sig,
		));
		$rs["sess_exp"] = $sess_exp;
		$rs["sess_sig"] = $sess_sig;

		self::setSigCookie( $exp_time, $sess_sig );
	}

	public static function terminate( $user_id ) {
		if ( !$user_id ) {
			return;
		}

		CDb::open();
		CTable::updateByID( "user", "user_id", $user_id, array(
			"sess_exp"=>null,
			"sess_sig"=>null,
		));
	}
}

?>