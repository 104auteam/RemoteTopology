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

$mods = array();

//-- default entry
$mods["main"] = array(
	"vrtp"=>"/^$/",
);

//-- bootstrap template
$mods["btpl"] = null;

//-- login & out
$mods["login"] = array(
	"dir"=>"auth"
);
$mods["logout"] = array(
	"dir"=>"auth"
);

//-- application pages
$mods["dcount"] = null;
$mods["run-preview"] = array(
	"dir"=>"dcount"
);
$mods["about"] = null;

$mods["user"] = null;
$mods["cfgapp"] = null;
$mods["inpinterval"] = null;

?>