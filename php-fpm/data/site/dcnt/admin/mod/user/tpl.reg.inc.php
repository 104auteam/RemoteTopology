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
	$cmd = "reg";
	$rs = array();
	$rs["user_id"] = 0;
	$rs["pinidx"] = 0;
	$rs["status"] = 1;
	$rs["b_admin"] = 0;
	$rs["username"] = "";
	$rs["password"] = "";
	$rs["password_conf"] = "";

	$rs["first_name"] = "";
	$rs["last_name"] = "";
	$rs["email"] = "";
	$rs["notes"] = "";

	$cfg = CCfgDb::get("cfgapp");
	$rs["time_zone"] = $cfg["tbl:user:default_time_zone"];

	include( dirname(__FILE__) . "/tpl.detail.inc.php" );
?>