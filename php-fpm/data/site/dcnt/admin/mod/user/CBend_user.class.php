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

class CBend_user extends CBend_crud {

	public function init() {
		$this->tbl_name = "user";
		$this->id_name = "user_id";
		parent::init();

		$this->bind("hd_search");
		$this->bind("hd_reg_inp");
		$this->bind("hd_reg_done");
		$this->bind("hd_edit_inp");
		$this->bind("hd_edit_done");
		$this->bind("hd_del_multi");
		$this->bind("hd_pin");
	}

	public function printStatus( $status ) {

		//-- locale
		$lca = CEnv::locale( $this->tbl_name . "/search" );

		$key = "";
		switch ( $status ) {
		case 0:
			$key = "ban-circle";
			$title = $lca[ "alt:inactive" ];
			break;
		case 1:
			$key = "ok-circle";
			$title = $lca[ "alt:active" ];
			break;
		}
		echo '<span class="glyphicon glyphicon-' .
			$key . '" title="' . $title . '" style="font-size:130%;"></span>';
	}

	public function setupRec( &$rs ) {
	}

	public function pc_search( $data ) {

		//-- select clause
		$sx = array(
			"user.".$this->id_name,
			"user.pinidx",
			"user.status",
			"user.b_admin",
			"user.username",
			"user.first_name",
			"user.last_name",
			"user.email",
			"user.time_zone",
			"user.notes",
			CSql::clSubQuery("COUNT(*)","dcount","group_id",
				$this->tbl_name,"group_id")=>"nof_dcount",
		);
		$data->clx[] = CSql::clSelect($sx);

		//-- from clause
		$data->clx[] = CSql::clFrom($this->tbl_name);

		//-- where clause
		$cond = array();

		//-- search criteria
		$criteria = $data->requ["criteria"];
		$status = $criteria["status"];
		$keyword = $criteria["keyword"];

		if ( $status != "" ) {
			$cond[] = CSql::clCond("status","=",$status);
		}

		if ( $keyword != "" ) {
			$cond2 = array();
			$cond2[] = CSql::clCond("user.username","L%%",$keyword);
			$cond2[] = CSql::clCond("user.first_name","L%%",$keyword);
			$cond2[] = CSql::clCond("user.last_name","L%%",$keyword);
			$cond2[] = CSql::clCond("user.email","L%%",$keyword);
			$cond2[] = CSql::clCond("user.notes","L%%",$keyword);
			$cond[] = CSql::clCondOp( "OR", $cond2 );
		}

		if ( count($cond) > 0  ) {
			$data->clx[] = CSql::clWhere("AND",$cond);
		}
	}

	private function usernameExists( $data, $id ) {

		//-- open database
		CDb::open();

		$cond = array();
		$cond[] = CSql::clCond("username","=",$data->fm["username"]);

		if ( $id ) {
			$cond[] = CSql::clCond("user_id","!=",$id);
		}

		$rsx = CTable::selectRec( $this->tbl_name, array($this->id_name), $cond );

		//-- record exists?
		if ( count($rsx) ) {
			$lca = CEnv::locale( "user/validate" );
			CFRes::setES("username");
			CFRes::addEA($lca["err:already-exists:username"]);
			return true;
		}

		return false;
	}

	private  function createPassKey( $data ) {
		$cfg = CEnv::config( "passkey/passkey" );
		$data->vx["passkey"] = CCryptPass::createPassKey(
			$data->fm["password"], $cfg["cver"] );
	}

	protected function validate( $data ) {

		//-- locale
		$lca = CEnv::locale( $this->tbl_name . "/validate" );

		//-- vali macro
		CValiMacro::setup($data, $lca);
		CValiMacro::vCheckbox("pinidx");
		CValiMacro::v01("status");
		CValiMacro::vCheckbox("b_admin");
		CValiMacro::vStr("username");
		if ( CValiMacro::vCheckbox("b_password",false) ) {
			CValiMacro::vStr("password",true,false);
			CValiMacro::vStrConf("password");
			if ( CFRes::isValidated() ) {
				$this->createPassKey($data);
			}
		}
		CValiMacro::vStr("first_name",false);
		CValiMacro::vStr("last_name",false);
		CValiMacro::vEmail("email",false);
		CValiMacro::vStr("time_zone");
		CValiMacro::vStr("notes",false);
	}

	public function pc_edit_inp( $data ) {

		//-- select clause
		$data->clx[] = CSql::clSelect(array(
			$this->id_name,
			"pinidx",
			"status",
			"b_admin",
			"username",
			"first_name",
			"last_name",
			"email",
			"time_zone",
			"notes",
		));

		$data->clx[] = CSql::clFrom($this->tbl_name);
	}

	public function pc_edit_done_validate( $data ) {

		//-- prevent username duplication
		if ( $this->usernameExists( $data, $data->id ) ) {
			return false;
		}

		//-- don't edit 'status' & 'b_admin' for the root admin
		if ( CUG::isRootAdminId( intval($data->id) ) ) {
			unset($data->vx["status"]);
			unset($data->vx["b_admin"]);
		}

		return true;
	}

	public function pc_reg_done_setup_form( $data ) {
		$data->fm["b_password"] = 1;
	}

	public function pc_reg_done_validate( $data ) {

		//-- prevent username duplication
		if ( $this->usernameExists( $data, 0 ) ) {
			return false;
		}

		$data->vx["dt_create"] = gmdate("Y-m-d H:i:s");
		$data->vx["group_id"] = -1;

		return true;
	}

	public function pc_reg_done_after_save( $data ) {
		$user_id = $data->id;
		$group_id = $user_id;
		CTable::updateByID( $this->tbl_name, $this->id_name, $user_id,
			array("group_id"=>$group_id) );
	}

	public function pc_del_multi_validate( $data ) {
		if ( in_array( CUG::rootAdminId(), $data->selrec ) ) {
			$lca = CEnv::locale( $this->tbl_name . "/validate" );
			CFRes::setEN($lca["err:can-not-delete-root"]);
			return false;
		}

		return true;
	}

}

?>