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

class CXInterval {

	public static function getRemaining( $dcount_id, $b_autoloop, $autoloop, &$dt_end ) {
		$t_now = time();
		$t_end = CAppUTC::toUTCTimestamp( $dt_end );

		if ( $t_now >= $t_end ) {
			if ( $b_autoloop ) {
				if ( $autoloop > 0 ) {
					$diff = ( $t_now - $t_end );
					$n = floor( $diff / $autoloop );
					$t_end = $t_end + ($n+1) * $autoloop;
					$dt_end = CAppUTC::toLocal( gmdate("Y-m-d H:i:s", $t_end) );
					CTable::updateByID( "dcount", "dcount_id", $dcount_id, array(
						"dt_end"=>$dt_end,
					));
				}
			}
		}

		$t_remaining = $t_end - $t_now;
		return $t_remaining;
	}

}

?>