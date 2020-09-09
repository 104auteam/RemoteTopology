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

class CFRes {
	private static $b_validate = true;
	private static $fstate = array();
	private static $falert = array();
	private static $nmsg = "";
	private static $ntype = "";

	public static function setState( $field, $fs ) {
		// fs: error, success, warning
		self::$fstate[$field] = $fs;
		if ( $fs == "error" ) {
			self::$b_validate = false;
		}
	}

	public static function addAlert( $msg, $atype ) {
		// atype: error, success, info
		self::$falert[] = array(
			"atype"=>$atype,
			"msg"=>$msg,
		);
		if ( $atype == "error" ) {
			self::$b_validate = false;
		}
	}

	public static function setES( $field ) {
		self::setState( $field, "error" );
	}

	public static function addEA( $msg ) {
		self::addAlert( $msg, "error" );
	}

	public static function setNotice( $nmsg, $ntype ) {
		// ntype: error, success
		self::$nmsg = $nmsg;
		self::$ntype = $ntype;

		if ( $ntype == "error" ) {
			self::$b_validate = false;
		}
	}

	public static function setEN( $nmsg ) {
		self::setNotice( $nmsg, "error" );
	}

	public static function setSN( $nmsg ) {
		self::setNotice( $nmsg, "success" );
	}

	public static function isValidated() {
		return self::$b_validate;
	}

	public static function getFRes() {
		return array(
			"b_validated" => self::isValidated() ? 1 : 0,
			"fstate" => self::$fstate,
			"falert" => self::$falert,
			"nmsg" => self::$nmsg,
			"ntype" => self::$ntype,
		);
	}

	public static function ret( $data ) {
		$data->resp["fres"] = self::getFRes();
		$data->resp["result"] = "OK";
	}
}

?>