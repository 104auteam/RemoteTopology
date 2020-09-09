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

class CEnv {

	private static $url_root = null;
	private static $cfg_app = null;
	private static $mx_locale = array();
	private static $mx_config = array();

	//-- app config
	public static function get( $key ) {
		if ( !self::$cfg_app ) {
			self::$cfg_app = &self::config( "app/app" );
		}
		return self::$cfg_app[$key];
	}

	//-- lib
	public static function useLib( $lib ) {
		include_once( self::pathLib( $lib ) . "index.inc.php" );
	}

	//-- locale & config files
	public static function explodePath( $cname, &$fn, &$path ) {
		$px = explode("/",$cname);
		if ( count($px) == 1 ) {
			$fn = $cname;
			$path = "";
		} else {
			$fn = $px[count($px)-1];
			$path = substr($cname,0,-strlen($fn));
		}
	}

	public static function &locale( $lname ) {
		if ( isset(self::$mx_locale[$lname]) ) {
			return self::$mx_locale[$lname];
		} else {
			self::$mx_locale[$lname] = array();
			$lca =& self::$mx_locale[$lname]; 
			self::explodePath( $lname, $fn, $path );
			include( self::pathLocale() . self::get("lc") . "/{$path}locale.{$fn}.inc.php" );
			return self::$mx_locale[$lname];
		}
	}

	public static function &config( $cname ) {
		if ( isset(self::$mx_config[$cname]) ) {
			return self::$mx_config[$cname];
		} else {
			self::$mx_config[$cname] = array();
			$cfg =& self::$mx_config[$cname]; 
			self::explodePath( $cname, $fn, $path );
			include( self::pathConfig() . "{$path}config.{$fn}.inc.php" );
			return self::$mx_config[$cname];
		}
	}

	//-- path
	public static function pathRoot() {
		return dirname(dirname(dirname(__FILE__))) . "/";
	}

	public static function pathConfig() {
		return self::pathRoot() . "config/";
	}

	public static function pathLocale() {
		return self::pathRoot() . "locale/";
	}

	public static function pathLib( $lib = null ) {
		$path = self::pathRoot() . "lib/";
		if ( !is_null( $lib ) ) {
			$path .= $lib . "/";
		}
		return $path;
	}

	public static function pathAdmin( $fn = null ) {
		$path = self::pathRoot() . self::get("dir-admin") . "/";
		if ( !is_null($fn) ) {
			$path .= $fn;
		}
		return $path;
	}

	public static function pathClient( $fn = null ) {
		$path = self::pathRoot() . self::get("dir-client") . "/";
		if ( !is_null($fn) ) {
			$path .= $fn;
		}
		return $path;
	}

	//-- url
	public static function setUrlRoot( $url_root ) {
		return self::$url_root = $url_root;
	}

	public static function urlRoot() {
		return self::$url_root;
	}

	public static function urlAdmin() {
		return self::urlRoot() . self::get("dir-admin") . "/";
	}

	public static function urlClient() {
		return self::urlRoot() . self::get("dir-client") . "/";
	}

}

?>