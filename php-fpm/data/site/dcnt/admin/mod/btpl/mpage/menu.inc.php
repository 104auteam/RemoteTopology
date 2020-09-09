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

$lca = CEnv::locale("app/menu");

$items1 = array();

$items1["dcount"] = array(
	"rtp"=>"dcount",
	"title"=>$lca["label:dcount"],
	"roll"=>array("regular"),
);

$items1["user"] = array(
	"rtp"=>"user",
	"title"=>$lca["label:user"],
	"roll"=>array("admin"),
);

$items1["cfgapp"] = array(
	"rtp"=>"cfgapp",
	"title"=>$lca["label:cfgapp"],
	"roll"=>array("admin"),
);

$items1["about"] = array(
	"rtp"=>"about",
	"title"=>$lca["label:about"],
	"roll"=>array("regular"),
);

//-- log out
$items1["logout"] = array(
	"rtp"=>"logout",
	"title"=>$lca["label:logout"],
	"roll"=>array("regular"),
);

//-- doc
$doc = array(
	"items"=>$items1,
);

?>