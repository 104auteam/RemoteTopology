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

//-- v4.00
class CSRouter {

	public static function getCurrentPageUrl( $http = true ) {
		$url = "";

		if ( $http ) {
			$url .= "http";

			$b_https = (( isset( $_SERVER["HTTPS"] ) ) && ( $_SERVER["HTTPS"] == "on" ));
			if ( $b_https ) {
				$url .= "s";
			}

			$url .= "://" . $_SERVER['HTTP_HOST'];

			if (( $_SERVER["SERVER_PORT"] != "80" ) && !$b_https ) {
				$url .= ":" . $_SERVER["SERVER_PORT"];
			}
		}

		//-- $_SERVER["SCRIPT_NAME"] trancates GET params and PathInfo.
		$url .= $_SERVER["SCRIPT_NAME"];

		return $url;
	}

	public static function setupRtc( &$_rtc, $path_this ) {

		if ( !isset($_rtc["cca"]) ) {
			$_rtc["cca"] = false;
		}

		//-- rtp
		$_rtc["rtp"] = ( isset( $_GET["_rtp"] ) ? $_GET["_rtp"] : "" );
		$_rtc["vrtp"] = $_rtc["rtp"];

		//-- startup config
		$_rtc["path-entity"] = dirname($path_this) . "/";
		$_rtc["url-entity"] = dirname(self::getCurrentPageUrl()) . "/";
		$_rtc["url-vroot"] = $_rtc["url-entity"];
	}

	private static function printRtCfg( $loc, &$_rtc ) {
		echo "<i>{$loc}</i><br/>";
		foreach( $_rtc as $key => $val ) {
			if (is_array($val)) {
				echo "<b>{$key}</b>=<br/>";
				foreach( $val as $k => $v ) {
					echo "&nbsp;&nbsp;&nbsp;<b>{$k}</b>={$v}<br/>";
				}
			} else {
				echo "<b>{$key}</b>={$val}<br/>";
			}
		}
		echo "<hr/>";
	}

	private function process( &$_rtc ) {

		$_rtc["b-processed"] = true;

		$_rtc["vrtp"] = substr($this->_rtc["vrtp"],strlen($_rtc["rte"]["rel_url"]));
		$_rtc["path-entity"] = $this->_rtc["path-entity"] . $_rtc["rte"]["rel_path"];
		$_rtc["url-entity"] = $this->_rtc["url-entity"] . $_rtc["rte"]["rel_path"];
		$_rtc["url-vroot"] = $this->_rtc["url-vroot"] . $_rtc["rte"]["rel_url"];

		if ( isset($_rtc["b-print-rtc"]) && $_rtc["b-print-rtc"] ) {
			CSRouter::printRtCfg( $this->_rtc["path-entity"], $_rtc) ;
		}

		if ( empty($_rtc["rte"]["index"]) ) {
			$_rtc["b-processed"] = CSRouter::main( $_rtc );
		} else {
			include( $_rtc["path-entity"] . $_rtc["rte"]["index"] );
		}

		return $_rtc["b-processed"];
	}

	private function route( &$_rtc ) {

		$rtes = array();

		$path = $_rtc["path-entity"] . "config/route.inc.php";
		include_once( $path );

		foreach( $rtes as $rtpat => $rte ) {
			if ( preg_match( $rtpat, $this->_rtc["vrtp"], $_matches ) ) {
				$_rtc["rte"] = $rte;
				$_rtc["matches"] = $_matches;
				if ( $this->process( $_rtc ) ) {
					$this->_rtc["cca"] = $_rtc["cca"] &&
						( isset($rte["cca"]) ? $rte["cca"] : false );
					return true;
				}
				return false;
			}
		}
		return false;
	}

	public function run( &$_rtc ) {
		$this->_rtc = $_rtc;
		$ret = $this->route( $_rtc );
		$_rtc = $this->_rtc;
		return $ret;
	}

	public static function main( &$_rtc ) {
		$obj = new CSRouter();
		return $obj->run($_rtc);
	}

}

?>