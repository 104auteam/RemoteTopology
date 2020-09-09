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

$lca["form"] = array(
	"pinidx"=>0,
	"idata"=>CJson::encode(array(
		"b_redirect"=> 0,
		"url_redirect"=> null,
		"b_autoloop"=> 0,
		"autoloop"=> (60*60*24),
		"str_day"=> " day%s% ",
		"str_hour"=> " hour%s% ",
		"str_min"=> " minute%s% ",
		"str_sec"=> " second%s% ",
	))
);

?>