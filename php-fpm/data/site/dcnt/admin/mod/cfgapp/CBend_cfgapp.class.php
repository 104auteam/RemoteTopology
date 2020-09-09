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

class CBend_cfgapp extends CBend_crud {

	public function init() {
		$this->bind("hd_save");
	}

	private function validate( $data ) {

		//-- locale
		$lca_key = "cfgapp/validate";
		$lca = CEnv::locale( $lca_key );

		//-- vali macro
		CValiMacro::setup($data, $lca);
		CValiMacro::vInt("tbl:user:default-page-size");
		CValiMacro::vStr("tbl:user:default-sort-val");
		CValiMacro::vStr("tbl:user:default_time_zone");
		CValiMacro::vInt("app:first-dow");
		CValiMacro::vInt("tbl:dcount:default-page-size");
		CValiMacro::vStr("tbl:dcount:default-sort-val");
	}

	public function hd_save( $data ) {
		$data->vx = array();
		$data->fm = $data->requ["form"];

		//-- validate
		$this->validate( $data );
		if ( !CFRes::isValidated() ) {
			CFRes::ret($data);
			return;
		}

		//-- save to db
		CDb::open();
		CCfgDb::set( "cfgapp", $data->vx );

		//-- resp
		self::retUpdated( $data );
	}

}

?>