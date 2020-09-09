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

class CFend_inpdt extends CObject {

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
<?php CJRLdr::loadLocale("inpdt/date-picker"); ?>
<?php CJRLdr::loadConfig("inpdt/date-picker"); ?>

<script type="text/javascript" src="<?php echo $url_mod; ?>js/CDateTool.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $url_mod; ?>css/CDatePicker.css" />
<script type="text/javascript" src="<?php echo $url_mod; ?>js/CDatePicker.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $url_mod; ?>css/CTimePicker.css" />
<script type="text/javascript" src="<?php echo $url_mod; ?>js/CTimePicker.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $url_mod; ?>css/CDlgDT.css" />
<script type="text/javascript" src="<?php echo $url_mod; ?>js/CDlgDT.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $url_mod; ?>css/CInpDT.css" />
<script type="text/javascript" src="<?php echo $url_mod; ?>js/CInpDT.js"></script>

<?php }

	public function hd_Content() {
		include( dirname(__FILE__) . "/tpl.dialog.inc.php" );
	}

}

?>