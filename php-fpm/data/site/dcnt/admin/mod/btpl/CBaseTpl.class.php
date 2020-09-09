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

class CBaseTpl extends CObject {

	public function init () {
		$this->bind("hd_DocType");
		$this->bind("hd_HtmlBegin");
		$this->bind("hd_HtmlHead");
		$this->bind("hd_BodyHeader");
		$this->bind("hd_Body");
		$this->bind("hd_BodyFooter");
	}

	public function hd_DocType() {
		echo "<!DOCTYPE html>\r\n";
	}

	public function hd_HtmlBegin( $data ) {
	}

	public function hd_HtmlHead( $data ) {
		$url_mod = $this->urlMod();

		//-- breadcrumbs
		$bx = array();

		$this->cfg_admin = CEnv::config("admin/app");

		$this->lca_app = CEnv::locale("app/info");
		if ( !empty($this->lca_app[ "app:name" ]) ) {
			$bx[] = htmlspecialchars($this->lca_app[ "app:name" ]);
		}

		$page_title = CApp::get( "page-title" );
		if ( !empty($page_title) ) {
			$bx[] = htmlspecialchars($page_title);
		}

		$this->breadcrumbs = implode(" : ",$bx);

		include( dirname(__FILE__) . "/tpl.html.head.inc.php" );

		CApp::exproc("htmlhead:cfg");
	}

	public function hd_BodyHeader( $data ) {
		include( dirname(__FILE__) . "/tpl.body.header.inc.php" );
	}

	public function hd_Body( $data ) {
	}

	public function hd_BodyFooter() {
		include( dirname(__FILE__) . "/tpl.body.footer.inc.php" );
	}

}

?>