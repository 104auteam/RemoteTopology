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

class CAppReq {

	public static $msg;

	public static function checkPhpVersion() {
		$ver_req = "5.2";
		$ver_cur = phpversion();
		if ( strnatcmp( $ver_cur, $ver_req ) >= 0 ) { 
			# equal or newer 
		} else {
			$lca = CEnv::locale( "app/req" );
			$msg = $lca[ "err:php-version" ];
			$msg = str_replace( "%ver_req%", $ver_req, $msg );
			$msg = str_replace( "%ver_cur%", $ver_cur, $msg );
			self::$msg = $msg;
			return false;
		}

		return true;
	}

	public static function checkMbString() {
		if ( !function_exists( "mb_strlen" ) ) { 
			$lca = CEnv::locale( "app/req" );
			$msg = $lca[ "err:mb-string" ];
			self::$msg = $msg;
			return false;
		}

		return true;
	}

	public static function checkGD() {
		if ( !function_exists( "imagecreatefromstring" ) ) { 
			$lca = CEnv::locale( "app/req" );
			$msg = $lca[ "err:gd" ];
			self::$msg = $msg;
			return false;
		}

		return true;
	}

	public static function checkPermission( $ptype, $path ) {
		$msg = array();

		if ( strpos( $ptype, "r" ) !== false ) {
			if ( !is_readable( $path ) ) {
				$lca = CEnv::locale( "app/req" );
				$msg[] = $lca[ "err:cannot-read" ] . " ( {$path} ).";
			}
		}

		if ( strpos( $ptype, "w" ) !== false ) {
			if ( !is_writeable( $path ) ) {
				$lca = CEnv::locale( "app/req" );
				$msg[] = $lca[ "err:cannot-write" ] . " ( {$path} ).";
			}
		}

		if ( count( $msg ) > 0 ) {
			$lca = CEnv::locale( "app/req" );
			$msg[] = $lca[ "err:fix-permission" ];
			self::$msg = implode("<br/>",$msg);
			return false;
		}

		return true;
	}

	public static function checkBrowserVersion() {
		if ( preg_match('/MSIE (.*?);/', $_SERVER["HTTP_USER_AGENT"], $matches) ) {
			$ver = $matches[1];
			if ( $ver < 9 ) {
				$lca = CEnv::locale("app/req");
				self::$msg = str_replace("%ie-ver%",$ver,$lca["err:old-ie"]);
				return false;
			}
		}

		return true;
	}

	public static function check() {
		return
			self::checkPhpVersion() &&
			self::checkMbString() &&
			self::checkBrowserVersion();
	}

	public static function showErrMsgBox() {
		echo "<div style='margin:30px;padding:20px;" .
			"color:red;font-size:120%;font-weight:bold;" . 
			"text-align:left;border:1px solid red;'>";
		echo self::$msg;
		echo "</div>";
	}

}

?>