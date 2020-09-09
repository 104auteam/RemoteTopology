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

class CBend_crud extends CBend {

	public function init() {
	}

	public function hd_search( $data ) {

		//-- setup pin field
		$this->pin_field = $this->tbl_name . ".pinidx";

		//-- dtable
		CDTable::init($this->dirMod());

		//-- open database
		CDb::open();

		//-- build clauses
		$clx = array();
		$data->clx =& $clx;
		$this->pc_search($data);

		//-- start caching
		self::obStart();

		//-- search result
		$data->clx = $clx; 
		if ( $this->pin_field ) {
			$data->order_by = array($this->pin_field=>"desc");
		}
		$result = CDTable::process( $data );
		include( $this->pathMod() . "tpl.dtable.inc.php" );
		CDb::freeResult($result);

		//-- end caching
		$html = self::obEnd();

		//-- resp
		$data->resp["html"] = $html;
		$data->resp["dts"] = CDTable::getDts();
		$this->ret($data);
	}

	public function hd_edit_inp( $data ) {

		//-- record id
		$id = $data->requ["id"];

		//-- open database
		CDb::open();

		//-- build clauses
		$clx = array();

		//-- select clause
		$data->clx =& $clx;
		$this->pc_edit_inp( $data );

		//-- where clause
		$cond = array();
		$cond[] = CSql::clCond($this->id_name,"=",$id);
		$this->addGroupIdCond( $cond );
		if ( count($cond) > 0  ) {
			$clx[] = CSql::clWhere("AND",$cond);
		}

		//-- run query
		$result = CSql::query($clx);
		if ( CDb::getRowCount( $result ) == 0 ) {
			$this->retNotExist($data);
			return;
		}

		$rs = CDb::getRowA( $result );
		$this->setupRec( $rs );

		//-- open template
		self::obStart();
		include( $this->pathMod() . "tpl.edit.inc.php" );
		CDb::freeResult($result);
		$html = self::obEnd();

		//-- resp
		$data->resp["html"] = $html;
		$data->resp["id"] = $id;
		$this->ret($data);
	}

	public function hd_edit_done( $data ) {
		$data->vx = array();
		$data->fm = $data->requ["form"];
		$this->pc_edit_done_setup_form($data);

		//--id
		$id = $data->requ["id"];
		$data->id = $id;
		
		//-- open database
		CDb::open();

		//-- does record exist?
		if ( !$this->recExists( $id ) ) {
			$this->retNotExist($data);
			return;
		}

		//-- validate
		$this->validate( $data );
		if ( !CFRes::isValidated() ) {
			$this->ret($data);
			return;
		}

		//-- extra validation
		if ( !$this->pc_edit_done_validate($data) ) {
			$this->ret($data);
			return;
		}

		//-- build clauses
		$clx = array();

		//-- update clause
		$clx[] = CSql::clUpdate($this->tbl_name,$data->vx);

		//-- where clause
		$cond = array();
		$cond[] = CSql::clCond($this->id_name,"=",$id);
		$this->addGroupIdCond( $cond );
		if ( count($cond) > 0  ) {
			$clx[] = CSql::clWhere("AND",$cond);
		}

		//-- run query
		CSql::query($clx);

		//-- after save
		$this->pc_edit_done_after_save($data);

		//-- search
		if ( isset($data->requ["dts"]) ) {
			$this->hd_search( $data );
		}

		//-- resp
		$this->retUpdated($data);
	}

	public function pc_edit_done_setup_form( $data ) {
	}

	public function pc_edit_done_validate( $data ) {
		return true;
	}

	public function pc_edit_done_after_save( $data ) {
	}

	public function hd_reg_inp( $data ) {

		//-- start caching
		self::obStart();

		//-- template
		include( $this->pathMod() . "tpl.reg.inc.php" );

		//-- end caching
		$html = self::obEnd();

		//-- resp
		$data->resp["html"] = $html;
		$this->ret($data);
	}

	public function hd_reg_done( $data ) {
		$data->vx = array();
		$data->fm = $data->requ["form"];
		$this->pc_reg_done_setup_form($data);

		//-- validate
		$this->validate( $data );
		if ( !CFRes::isValidated() ) {
			$this->ret($data);
			return;
		}

		//-- setup fields
		if ( !$this->pc_reg_done_validate($data) ) {
			$this->ret($data);
			return;
		}

		//-- open database
		CDb::open();

		//-- insert a record
		$data->id = CTable::insertRec( $this->tbl_name, $data->vx );
		$data->resp["id"] = $data->id;

		//-- after save
		$this->pc_reg_done_after_save($data);

		//-- serach
		$this->hd_search($data);

		//-- resp
		$this->retSaved($data);
	}

	public function pc_reg_done_setup_form( $data ) {
	}

	public function pc_reg_done_validate( $data ) {
		return true;
	}

	public function pc_reg_done_after_save( $data ) {
	}

	public function hd_del_multi( $data ) {

		//-- selrec
		$selrec_param = ( isset($data->requ["selrec"]) ) ?
			$data->requ["selrec"] : array();

		$selrec = array();
		foreach( $selrec_param as $id ) {
			$selrec[] = intval($id);
		}

		$data->selrec =& $selrec;
		if ( !$this->pc_del_multi_validate( $data ) ) {
			$this->ret($data);
			return;
		}

		//-- open database
		CDb::open();

		//-- where clause
		$cond = array();

		$cond2 = array();
		foreach( $selrec as $id ) {
			$cond2[] = CSql::clCond($this->id_name,"=",$id);
		}
		$cond[] = CSql::clCondOp("OR",$cond2);

		//-- add group id to condition
		$this->addGroupIdCond( $cond );

		//-- delete child resource
		$data->cond =& $cond;
		$this->pc_del_multi_delete_child($data);

		//-- delete records
		$clx = array();
		$clx[] = CSql::clDelete($this->tbl_name);
		$clx[] = CSql::clWhere("AND",$cond);
		CSql::query($clx);

		//-- do search
		$this->hd_search( $data );

		//-- resp
		$this->retDeleted($data);
	}

	public function pc_del_multi_validate( $data ) {
		return ( count($data->selrec) > 0 );
	}

	public function pc_del_multi_delete_child( $data ) {
	}

	public function hd_pin( $data ) {
		$data->vx = array();

		//--id
		$id = $data->requ["id"];
		$data->vx = array("`pinidx`=1-`pinidx`");

		//-- open database
		CDb::open();

		//-- does record exist?
		if ( !$this->recExists( $id ) ) {
			$this->retNotExist($data);
			return;
		}

		//-- build clauses
		$clx = array();

		//-- update clause
		$clx[] = CSql::clUpdate($this->tbl_name,$data->vx);

		//-- where clause
		$cond = array();
		$cond[] = CSql::clCond($this->id_name,"=",$id);
		$this->addGroupIdCond( $cond );
		if ( count($cond) > 0  ) {
			$clx[] = CSql::clWhere("AND",$cond);
		}

		//-- run query
		CSql::query($clx);

		//-- search
		$this->hd_search( $data );

		//-- resp
		$this->ret($data);
	}

	public function hd_copy( $data ) {
		$data->vx = array();
		$data->fm = $data->requ["form"];

		if ( !( false && CUG::isAdmin() ) ) {
			$data->fm["group_id"] = CSess::getUserInfo("group_id");
		}

		//-- open database
		CDb::open();

		//-- validate & rearrange
		if ( $this->pc_copy( $data ) ) {

			//-- insert a record
			$data->new_id = CTable::insertRec( $this->tbl_name, $data->vx );
			$this->pc_copy_child( $data );

			//-- resp
			$this->retCopied($data);
		} else {
			$this->ret($data);
		}
	}

	public function pc_copy_child( $data ) {
	}

	public function recExists( $id ) {

		//-- find record
		$clx = array();
		$clx[] = CSql::clSelect(array($this->id_name));
		$clx[] = CSql::clFrom($this->tbl_name);
		$cond = array();
		$cond[] = CSql::clCond($this->id_name,"=",$id);
		$this->addGroupIdCond($cond);
		if ( count($cond) > 0  ) {
			$clx[] = CSql::clWhere("AND",$cond);
		}
		$result = CSql::query($clx);
		if (!( $rs = CDb::getRowA( $result ) )) {
			$rs = null;
		}
		CDb::freeResult( $result );

		return !is_null($rs);
	}

	public function getRec( $data ) {

		//--id
		$id = $data->requ["id"];

		//-- find record
		$clx = array();
		$clx[] = CSql::clSelect(null);
		$clx[] = CSql::clFrom($this->tbl_name);
		$cond = array();
		$cond[] = CSql::clCond($this->id_name,"=",$id);
		$this->addGroupIdCond( $cond );
		if ( count($cond) > 0  ) {
			$clx[] = CSql::clWhere("AND",$cond);
		}
		$result = CSql::query($clx);
		if (!( $rs = CDb::getRowA( $result ) )) {
			$rs = null;
		}
		CDb::freeResult( $result );

		if ( !$rs ) {
			$this->retNotExist($data);
			return null;
		}

		return $rs;
	}

	public function addGroupIdCond( &$cond ) {
		if ( !CUG::isAdmin() ) {
			$cond[] = CSql::clCond(
				$this->tbl_name . ".group_id","=",
				CSess::getUserInfo("group_id"));
		}
	}

	public function ret( $data ) {
		CFRes::ret($data);
	}

	public function retNotExist( $data ) {
		$lca = CEnv::locale("fbc/crud");
		CFRes::setEN($lca["nmsg:not-exist"]);
		CFRes::ret($data);
	}

	public function retSaved( $data ) {
		$lca = CEnv::locale("fbc/crud");
		CFRes::setSN($lca["nmsg:saved"]);
		CFRes::ret($data);
	}

	public function retUpdated( $data ) {
		$lca = CEnv::locale("fbc/crud");
		CFRes::setSN($lca["nmsg:updated"]);
		CFRes::ret($data);
	}

	public function retDeleted( $data ) {
		$lca = CEnv::locale("fbc/crud");
		CFRes::setSN($lca["nmsg:deleted"]);
		CFRes::ret($data);
	}

	public function retCopied( $data ) {
		$lca = CEnv::locale("fbc/crud");
		CFRes::setSN($lca["nmsg:copied"]);
		CFRes::ret($data);
	}
}

?>