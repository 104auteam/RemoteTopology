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

class CAction_cfgapp extends CAction {

	public function main() {

		if ( self::isFend() ) {
			self::load(array(
				"btpl/CBaseTpl",
				"fbc/CFend",
				"dtable/CFend_dtable",
				"~/CFend_cfgapp",
				"btpl/CMPage",
			));
		} else {
			self::load(array(
				"fbc",
				"~/CBend_cfgapp",
				"fbc/CSAjax",
			));
		}
	}

}

?>