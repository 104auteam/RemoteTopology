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

class CAppUTC {

	private static $time_zone;

	public static function setup( $time_zone = null ) {
		if ( !$time_zone ) {
			$time_zone = "UTC";
		}
		self::$time_zone = $time_zone;
	}

	public static function toUTC( $local_tstr ) {
		$dt = new DateTime( $local_tstr, new DateTimeZone(self::$time_zone));
		$dt->setTimezone( new DateTimeZone("UTC") );
		return $dt->format("Y-m-d H:i:s");
	}

	public static function toUTCTimestamp( $local_tstr ) {
		$dt = new DateTime( $local_tstr, new DateTimeZone(self::$time_zone));
		return $dt->format("U");
	}

	public static function toLocal( $utc_tstr ) {
		$dt = new DateTime( $utc_tstr, new DateTimeZone("UTC"));
		$dt->setTimezone( new DateTimeZone(self::$time_zone) );
		return $dt->format("Y-m-d H:i:s");
	}

	public static function format( $patt, $utc_tstr ) {
		if ( $patt == "std" ) {
			$patt = "l, F j, Y h:ia (T)";
		}
		$dt = new DateTime( $utc_tstr, new DateTimeZone("UTC") );
		$dt->setTimezone( new DateTimeZone(self::$time_zone) );
		return $dt->format( $patt );
	}

	public static function utcTStrNow() {
		return gmdate("Y-m-d H:i:s");
	}

}

?>