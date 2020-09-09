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

$cfg["loader_sig"] = "sig-CAjaxCountDownV102";
//$cfg["cls_selector"] = "";
//$cfg["url_js1"] = "http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js";
$cfg["url_js1"] = CEnv::urlClient() . "js/jquery-1.2.6.js";
$cfg["jq_min_ver"] = "1.2.6";
$cfg["jq_max_ver"] = "3.2.2";
$cfg["url_js2"] = CEnv::urlClient() . "js/CAjaxCountDown.js";

$cfg["app_selector_prefix"] = "ajaxcountdown-ctar-";
$cfg["app_main"] = "runCAjaxCountDown";

?>