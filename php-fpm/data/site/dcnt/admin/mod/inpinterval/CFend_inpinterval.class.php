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

class CFend_inpinterval extends CObject {

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
<?php CJRLdr::loadLocale("inpinterval/inpinterval"); ?>

<link rel="stylesheet" type="text/css" href="<?php echo $url_mod; ?>css/CTimeInterval.css" />
<script type="text/javascript" src="<?php echo $url_mod; ?>js/CTimeInterval.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $url_mod; ?>css/CDlgInterval.css" />
<script type="text/javascript" src="<?php echo $url_mod; ?>js/CDlgInterval.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $url_mod; ?>css/CInpInterval.css" />
<script type="text/javascript" src="<?php echo $url_mod; ?>js/CInpInterval.js"></script>

<?php }

	public function hd_Content() {
		include( dirname(__FILE__) . "/tpl.dialog.inc.php" );
	}

}

?>