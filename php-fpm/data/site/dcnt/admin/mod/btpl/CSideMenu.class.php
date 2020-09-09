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

//[!VT][2017-01-02][v2.1]
class CSideMenu {

	private static $key_sel = '';
	public static function printLevel1Box( $key, $item ) {
		$cls = "sidemenu-lvl1";
		$params = '';
		if ( $key == self::$key_sel ) {
			$cls .= " sidemenu-lvl1-sel";
		}
		if ( isset($item["rtp"]) ) {
			$cls .= " sidemenu-lvl1-a btn-a";
			$params = ' data-href="'.CApp::vurl($item['rtp']).'"';
		}
		if ( isset($item["target"]) ) {
			$params .= ' data-target="'.$item["target"].'"';
		}
		echo "<div class='{$cls}'{$params}>" .
			'<span class="glyphicon glyphicon-th-large" style="font-size:90%;"></span>&nbsp;' . 
			$item["title"] . "</div>";
	}

	public static function printLevel2Box( $key, $item ) {
		$cls = "sidemenu-lvl2";
		$params = '';
		if ( $item['rtp'] == null ) {
			$cls .= " divider";
			$label = "";
		} else {
			if ( $key == self::$key_sel ) {
				$cls .= " sidemenu-lvl2-sel";
			}
			if ( isset($item["rtp"]) ) {
				$cls .= " sidemenu-lvl2-a btn-a";
				$params .= ' data-href="'.CApp::vurl($item['rtp']).'"';
			}
			if ( isset($item["target"]) ) {
				$params .= ' data-target="'.$item["target"].'"';
			}
			$label = $item["title"];
		}
		echo "<div class='{$cls}'{$params}>" .
			$label . "</div>";
	}

	public static function printLevel1( $key1, $item1 ) {
		echo '<div class="sidemenu-lvl1-container">';
		self::printLevel1Box( $key1, $item1 );
		if ( isset($item1["items"]) ) {
			foreach( $item1["items"] as $key2 => $item2 ) {
				if (!( isset($item2['hidden']) && $item2['hidden'] )) {
					self::printLevel2( $key2, $item2 );
				}
			}
		}
		echo '</div>';
	}

	public static function printLevel2( $key2, $item2 ) {
		self::printLevel2Box( $key2, $item2 );
	}

	public static function printMenu( $doc, $key_sel = null ) {
		self::$key_sel = $key_sel;
		if ( !isset($doc["items"]) ) { return; }
		foreach( $doc["items"] as $key => $item ) {
			if (( $key != "index" ) && ( CRoll::hasRoll($item["roll"]) )) {
				self::printLevel1( $key, $item );
			}
		}
	}

}

?>