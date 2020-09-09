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

class CClient {

	public static function printLoader( $cfg ) {
		echo "(function( cfg ){";
		CAjaxTool::includeJs(
			dirname(dirname(__FILE__)) . "/js/",
			"loader.min.js",
			"loader.js"
		);
		echo "}(" . CAjaxTool::getConfig($cfg) . "));";
	}

	private static function getRec( $id ) {

		CDb::open();

		$rec = array();

		$rs = CTable::findByID( "dcount", "dcount_id", $id, array(
			"dcount_id","user_id","dt_end","idata",
		));

		if ( !$rs ) {
			return null;
		}

		$rs = array_merge($rs,CJson::decode($rs["idata"]));

		if ( !$rs["dt_end"] ) {
			return null;
		}

		//-- strings
		$rec["str_day"] = $rs["str_day"];
		$rec["str_hour"] = $rs["str_hour"];
		$rec["str_min"] = $rs["str_min"];
		$rec["str_sec"] = $rs["str_sec"];

		//-- redirect
		$rec["b_redirect"] = $rs["b_redirect"];
		$rec["url_redirect"] = $rs["url_redirect"];

		//-- remaining time
		$rs_user = CTable::findByID( "user", "user_id", $rs["user_id"], array(
			"time_zone",
		));
		CAppUTC::setup($rs_user["time_zone"]);

		$rec["t_remaining"] = CXInterval::getRemaining(
			$id, $rs["b_autoloop"], $rs["autoloop"], $rs["dt_end"] );

		return $rec;
	}

	public static function run() {
		$id = isset( $_REQUEST["id"] ) ? intval($_REQUEST["id"]) : 0;
		$info = isset( $_REQUEST["info"] ) ? intval($_REQUEST["info"]) : 0;
		$cfg = CEnv::config("client/ajax");
		$rec = self::getRec( $id );

		CAjaxTool::printHeader();
		if ( !$rec ) {
			echo "console.log('invalid id:'+$id);";
			return;
		}

		//-- build params for appcfg
		$cfg["appcfg"] = array(
			"info"=>$info,
			"id"=>$id,
			"selector"=>$cfg["app_selector_prefix"] . $id,
			"loading_threshold"=>100,
			"rec"=>$rec,
		);

		self::printLoader($cfg);
	}
}

?>