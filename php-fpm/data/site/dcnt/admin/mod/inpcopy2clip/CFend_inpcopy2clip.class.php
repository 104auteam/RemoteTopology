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

class CFend_inpcopy2clip extends CObject {

	public function init () {
		self::load(array(
			"fbc/CFend",
		));

		$this->bind("hd_HtmlHead");
		$this->bind("hd_Content");
	}

	public function hd_HtmlHead() {
		$url_mod = $this->urlMod();
?>
<?php CJRLdr::loadLocale("inpcopy2clip/inp"); ?>

<link rel="stylesheet" href="<?php echo $url_mod; ?>css/CDlgCopy2Clip.css">
<script src="<?php echo $url_mod; ?>js/CDlgCopy2Clip.js"></script>

<link rel="stylesheet" href="<?php echo $url_mod; ?>css/CInpCopy2Clip.css">
<script src="<?php echo $url_mod; ?>js/CInpCopy2Clip.js"></script>
<?php }

	public function hd_Content() {
		include( dirname(__FILE__) . "/tpl.dialog.inc.php" );
	}

}

?>