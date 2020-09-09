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

class CBend_dcount extends CBend_crud {

	public function init() {
		$this->tbl_name = "dcount";
		$this->id_name = "dcount_id";
		parent::init();

		$this->bind("hd_search");
		$this->bind("hd_edit_inp");
		$this->bind("hd_edit_done");
		$this->bind("hd_reg_inp");
		$this->bind("hd_reg_done");
		$this->bind("hd_del_multi");
		$this->bind("hd_pin");
		$this->bind("hd_copy");
	}

	public function setupRec( &$rs ) {
		if ( !isset($rs["gname"]) ) {
			$rs["gname"] = ( isset($rs["username"]) ) ?
				$rs["username"] : "";
		}
	}

	public function pc_search( $data ) {

		//-- select clause
		$sx = array(
			$this->id_name,
			"dcount.dt_create",
			"dcount.group_id",
			"dcount.pinidx",
			"dcount.title",
			"dcount.notes",
		);
		if ( CUG::isAdmin() ) {
			$sx[] = "user.username";
		}

		$data->clx[] = CSql::clSelect($sx);

		//-- from clause
		$fromx = array();
		$fromx[] = CSql::clFrom($this->tbl_name);
		$fromx[] = CSql::clLeftJoin("user","group_id",
			$this->tbl_name,"group_id");
		$data->clx[] = implode("\n",$fromx);

		//-- where clause
		$cond = array();

		//-- search criteria
		$criteria = $data->requ["criteria"];
		$keyword = $criteria["keyword"];

		if ( $keyword != "" ) {
			$cond2 = array();
			$cond2[] = CSql::clCond("dcount.title","L%%",$keyword);
			$cond2[] = CSql::clCond("dcount.notes","L%%",$keyword);
			if ( CUG::isAdmin() ) {
				$cond2[] = CSql::clCond("user.username","=",$keyword);
			}
			$cond[] = CSql::clCondOp("OR",$cond2);
		}
		$this->addGroupIdCond( $cond );
		if ( count($cond) > 0  ) {
			$data->clx[] = CSql::clWhere("AND",$cond);
		}
	}

	protected function validate( $data ) {

		//-- locale
		$lca = CEnv::locale( $this->tbl_name."/validate" );

		//-- vali macro
		CValiMacro::setup($data, $lca);
		if ( $data->cmd == "reg_done" ) {
			CValiMacro::vStr("title");
		} else {
			CValiMacro::vCheckbox("pinidx");
			CValiMacro::vStr("title");
			CValiMacro::vStr("notes",false);
			CValiMacro::vDateTime("dt_end");
			CValiMacro::vStr("url_redirect",CValiMacro::vCheckbox("b_redirect"));
			CValiMacro::vInt("autoloop",CValiMacro::vCheckbox("b_autoloop"));
			CValiMacro::vStr("str_day",false);
			CValiMacro::vStr("str_hour",false);
			CValiMacro::vStr("str_min",false);
			CValiMacro::vStr("str_sec",false);
		}
	}

	public function pc_edit_inp( $data ) {

		//-- select clause
		$sx = array(
			$this->id_name,
			"dcount.dt_create",
			"dcount.group_id",
			"dcount.pinidx",
			"dcount.title",
			"dcount.notes",
			"dcount.dt_end",
			"dcount.idata",
		);
		$data->clx[] = CSql::clSelect($sx);

		//-- from clause
		$fromx = array();
		$fromx[] = CSql::clFrom($this->tbl_name);
		$fromx[] = CSql::clLeftJoin("user","group_id",
			$this->tbl_name,"group_id");
		$data->clx[] = implode("\n",$fromx);

		//-- return subcmd
		$data->resp['subcmd'] = $data->requ["subcmd"];
	}

	public function pc_edit_done_validate( $data ) {
		//-- rearrange fields
		$ls = array(
			"b_redirect",
			"url_redirect",
			"b_autoloop",
			"autoloop",
			"str_day",
			"str_hour",
			"str_min",
			"str_sec",
		);
		$vx = array();
		foreach( $ls as $key ) {
			$vx[$key] = $data->vx[$key];
			unset($data->vx[$key]);
		}
		$data->vx["idata"] = CJson::encode($vx);

		return true;
	}

	public function pc_reg_done_validate( $data ) {

		//-- dt_create, user_id, group_id
		$data->vx["dt_create"] = gmdate("Y-m-d H:i:s");
		$data->vx["user_id"] = CSess::getUserInfo("user_id");
		$data->vx["group_id"] = CSess::getUserInfo("group_id");

		//-- dt_end
		$data->vx["dt_end"] = CAppUTC::format( "Y-m-d 00:00:00",
			gmdate("Y-m-d H:i:s",time()+(60*60*24)) );

		//-- other fields
		$lca = CEnv::locale($this->tbl_name."/reg.init");
		$data->vx = array_merge($data->vx,$lca["form"]);

		return true;
	}

	public function pc_copy( $data ) {

		//-- locale
		$lca = CEnv::locale( $this->tbl_name."/validate" );

		//-- vali macro
		CValiMacro::setup($data, $lca);
		CValiMacro::vStr("title");
		CValiMacro::vInt("group_id");
		if ( !CFRes::isValidated() ) {
			return false;
		}

		if (!($rs = $this->getRec($data))) {
			return false;
		}

		//-- rearrange data
		unset($rs["dcount_id"]);
		$rs["dt_create"] = gmdate("Y-m-d H:i:s");
		$rs["title"] = $data->vx["title"];
		$rs["user_id"] = CSess::getUserInfo("user_id");
		$rs["group_id"] = $data->vx["group_id"];
		$data->vx = $rs;

		return true;
	}

}

?>