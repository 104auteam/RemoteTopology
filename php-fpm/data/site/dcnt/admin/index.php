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

include_once( dirname(__FILE__) . "/startup.inc.php" );

//-- routing
$_rtc = array();
CSRouter::setupRtc($_rtc,__FILE__);

if ( !CSRouter::main($_rtc) ) {
	C404Page::main();
	header("HTTP/1.0 404 Not Found");
	exit();
}

?>