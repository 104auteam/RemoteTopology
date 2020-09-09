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

class CBend_login extends CBend {

	const TBL_NAME = "user";
	const ID_NAME = "user_id";

	public function init() {
		$this->bind("hd_login");
	}

	private function authenticate( $username, $password ) {

		//-- open database
		CDb::open();

		//-- build clauses
		$clx = array();

		//-- select clause
		$clx[] = CSql::clSelect(null);

		//-- from clause
		$clx[] = CSql::clFrom(self::TBL_NAME);

		//-- where clause
		$cond = array();
		$cond[] = CSql::clCond("status","=",1);
		$cond[] = CSql::clCond("username","=",$username);
		$clx[] = CSql::clWhere("AND",$cond);

		//-- find password
		$passkey = null;
		$result = CSql::query( $clx );
		if ( $rs = CDb::getRowA( $result ) ) {
			$passkey = $rs["passkey"];
		}
		CDb::freeResult($result);

		//-- check password
		$b = CCryptPass::test( $password, $passkey );

		if ( $b ) {
			CSess::setUserInfoArray($rs);
		}

		return $b;
	}

	private function validate( $data ) {

		//-- locale
		$lca = CEnv::locale( "auth/validate" );

		//-- vali macro
		CValiMacro::setup($data, $lca);
		CValiMacro::vStr("username");
		CValiMacro::vStr("password");
	}

	public function isEmergencyPassword( $data ) {
		$cfg = CEnv::config("auth/auth");
		if ( !empty($cfg["emergency-password"]) &&
			( $data->vx["username"] == $cfg["emergency-password"] ) &&
			( $data->vx["password"] == $cfg["emergency-password"] )
		) {
			$cfg_user = CEnv::config("user/root-admin");
			$rs = CTable::findByID(self::TBL_NAME,self::ID_NAME,
				$cfg_user["root-admin-id"],null);
			CSess::setUserInfoArray($rs);
			return true;
		}
		return false;
	}

	public function hd_login( $data ) {
		$data->vx = array();
		$data->fm = $data->requ["form"];

		//-- validate
		$this->validate( $data );
		if ( !CFRes::isValidated() ) {
			$data->resp["fres"] = CFRes::getFRes();
			$data->resp["result"] = "OK";
			return;
		}

		//-- emergency-password
		if ( !$this->isEmergencyPassword( $data ) ) {
			//-- authenticate
			if ( !$this->authenticate($data->vx["username"],$data->vx["password"]) ) {
				$lca = CEnv::locale("auth/validate");
				CFRes::addEA($lca["err:invalid"]);
				$data->resp["fres"] = CFRes::getFRes();
				$data->resp["result"] = "OK";
				return;
			}
		}

		$cfg = CEnv::config("auth/auth");

		//-- resp
		$data->resp["fres"] = CFRes::getFRes();
		$data->resp["url_success"] = CApp::vurl($cfg["entry-page"]);
		$data->resp["result"] = "OK";
	}

}

?>