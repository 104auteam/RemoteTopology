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

/*
-----------------------------------------
CPageTab
-----------------------------------------

        |<----w---->|
        |     |     |
< 1 ... 23|24|25|26|27 ... 46 >
  |     |     |     |      |
  |     |     |     |      $idx_e
  |     |     |     $idx_re
  |     |     $idx
  |     $idx_rf
  $idx_f

-----------------------------------------
*/  

class CPageTab {

	const prev_label = "&lsaquo;";
	const next_label = "&rsaquo;";
	const first_label = "&laquo;";
	const last_label = "&raquo;";

	private static $idx;
	private static $tpl_sel;
	private static $tpl_link;
	private static $tpl;
	private static $idx_f;
	private static $idx_e;

	public static function getPageTabs( $total, $idx, $w, $flags, $tpl ) {
		if ( $total == 0 ) return '';
		
		$w2 = floor( $w / 2 );

		self::$idx = $idx;
		self::$tpl = $tpl;
		self::$idx_f = 1;
		self::$idx_e = $total;

		if ( self::$idx_e - $idx > $idx - self::$idx_f ) {
			$idx_rf = $idx - $w2;
			if ( self::$idx_f > $idx_rf ) {
				$idx_rf = self::$idx_f;
			}
			$idx_re = $idx_rf + $w - 1;
			if ( self::$idx_e < $idx_re ) {
				$idx_re = self::$idx_e;
			}
		} else {
			$idx_re = $idx + $w2;
			if ( self::$idx_e < $idx_re ) {
				$idx_re = self::$idx_e;
			}
			$idx_rf = $idx_re - $w + 1;
			if ( self::$idx_f > $idx_rf ) {
				$idx_rf = self::$idx_f;
			}
		}

		//--- Init Buffer
		$s = "";
		$sepa = self::$tpl['str:separator'];

		// $flags = [F,P,B,M,E,N,L]
		// F:First Page
		// P:Prev Page
		// B:Beginning Pages
		// M:Middle Pages
		// E:Ending Pages
		// N:Next Page
		// L:Last Page
		if ( !$flags ) {
			$flags = "F,M,L";
		}

		//--- First & Prev Button
		if ( self::$idx_f < self::$idx ) {
			if ( strpos($flags,"F") !== FALSE ) {
				$s .= self::getFirst();
				$s .= $sepa;
			}
			if ( strpos($flags,"P") !== FALSE ) {
				$s .= self::getPrev();
				$s .= $sepa;
			}
		}

		//--- Beginning pages
		if ( strpos($flags,"B") !== FALSE ) {
			if ( self::$idx_f < $idx_rf ) {
				$s .= self::getTab( self::$idx_f );

				if ( self::$idx_f+1 == $idx_rf ) {
					$s .= $sepa;
				} else if ( self::$idx_f+2 == $idx_rf ) {
					$s .= $sepa;
					$s .= self::getTab( self::$idx_f+1 );
					$s .= $sepa;
				} else {
					$s .= self::getDots();
				}
			}
		}

		//--- Middle pages
		if ( strpos($flags,"M") !== FALSE ) {
			for ( $i = $idx_rf; $i <= $idx_re; $i++ ) {
				$s .= self::getTab( $i );
				if ( $i < $idx_re ) {
					$s .= $sepa;
				}
			}	
		}

		//--- ending pages
		if ( strpos($flags,"E") !== FALSE ) {
			if ( $idx_re < self::$idx_e ) {
				if ( $idx_re+1 == self::$idx_e ) {
					$s .= $sepa;
				} else if ( $idx_re+2 == self::$idx_e ) {
					$s .= $sepa;
					$s .= self::getTab( $idx_re+1 );
					$s .= $sepa;
				} else {
					$s .= self::getDots();
				}

				$s .= self::getTab( self::$idx_e );
			}
		}
		
		//--- Next & Last Button
		if ( self::$idx < self::$idx_e ) {
			if ( strpos($flags,"N") !== FALSE ) {
				$s .= $sepa;
				$s .= self::getNext();
			}
			if ( strpos($flags,"L") !== FALSE ) {
				$s .= $sepa;
				$s .= self::getLast();
			}
		}

		return $s;
	}

	private static function getPrev() {
		$s = str_replace( '%alt%', self::$tpl['alt:prev'], self::$tpl['link'] );
		$s = str_replace( '%page-no%', ( self::$idx - 1 ), $s );
		$s = str_replace( '%label%', self::prev_label, $s );
		return $s;
	}

	private static function getNext() {
		$s = str_replace( '%alt%', self::$tpl['alt:next'], self::$tpl['link'] );
		$s = str_replace( '%page-no%', ( self::$idx + 1 ), $s );
		$s = str_replace( '%label%', self::next_label, $s );
		return $s;
	}

	private static function getFirst() {
		$s = str_replace( '%alt%', self::$tpl['alt:first'], self::$tpl['link'] );
		$s = str_replace( '%page-no%', ( self::$idx_f ), $s );
		$s = str_replace( '%label%', self::first_label, $s );
		return $s;
	}

	private static function getLast() {
		$s = str_replace( '%alt%', self::$tpl['alt:last'], self::$tpl['link'] );
		$s = str_replace( '%page-no%', ( self::$idx_e ), $s );
		$s = str_replace( '%label%', self::last_label, $s );
		return $s;
	}

	private static function getTab( $i ) {
		if ( self::$idx == $i ) {
			$s = self::$tpl['sel'];
		} else {
			$s = self::$tpl['link'];
		}

		$s = str_replace( '%alt%', self::$tpl['alt:page'], $s );
		$s = str_replace( '%page-no%', $i, $s );
		$s = str_replace( '%label%', $i, $s );
		return $s;
	}

	private static function getSepa() {
		$s = ' ';
		return $s;
	}

	private static function getDots() {
		$s = self::$tpl['disabled'];
		$s = str_replace( '%label%', self::$tpl['str:etc'], $s );
		return $s;
	}

}

?>