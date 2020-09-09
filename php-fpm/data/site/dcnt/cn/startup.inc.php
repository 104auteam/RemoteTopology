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

include_once( dirname(dirname(__FILE__)) . "/config/config.env.inc.php" );
include_once( dirname(dirname(__FILE__)) . "/lib/sys/index.inc.php" );
include_once( dirname(__FILE__) . "/include/index.inc.php" );

CEnv::useLib("app");
CEnv::useLib("client");
CEnv::useLib("db");

CPreProc::reverseMagicQuote();
CEnv::setUrlRoot( dirname(dirname(CPreProc::getCurrentPageUrl())) . "/" );

?>