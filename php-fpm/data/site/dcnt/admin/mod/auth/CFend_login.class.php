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

class CFend_login extends CObject {

	public function init() {
		$this->bind( "hd_HtmlHead" );
		$this->bind( "hd_Body" );
		$this->unbind( "CBaseTpl", "hd_BodyHeader" );
		$this->unbind( "CBaseTpl", "hd_BodyFooter" );
	}

	public function hd_HtmlHead() {
		$url_mod = $this->urlMod();
?>

<link href="<?php echo $url_mod; ?>css/CLogIn.css" rel="stylesheet">
<script src="<?php echo $url_mod; ?>js/CLogIn.js"></script>

<?php }

	public function hd_Body() {

		if ( !CAppReq::check() ) {
			echo "<style>body > main {max-width:none;}</style>";
			CAppReq::showErrMsgBox();
			exit;
		}

		include( dirname(__FILE__) . "/tpl.login.inc.php" );
	}

}

?>