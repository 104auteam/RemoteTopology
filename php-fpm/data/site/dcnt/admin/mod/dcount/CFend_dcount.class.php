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

class CFend_dcount extends CObject {

	public function init() {
		$this->bind("hd_HtmlHead");
		$this->bind("hd_Content");
	}

	public function hd_HtmlHead() {
		$url_mod = $this->urlMod();
?>
<?php CJRLdr::loadLocale("dcount/bcrumb"); ?>
<?php CJRLdr::loadLocale("dcount/del-multi"); ?>

<link href="<?php echo $url_mod; ?>css/CDcount.css" rel="stylesheet">
<script src="<?php echo $url_mod; ?>js/CDcount.js"></script>

<link href="<?php echo $url_mod; ?>css/CDcountRec.css" rel="stylesheet">
<script src="<?php echo $url_mod; ?>js/CDcountRec.js"></script>

<link href="<?php echo $url_mod; ?>css/CInstCode.css" rel="stylesheet">
<script src="<?php echo $url_mod; ?>js/CDcountRecSettingsPanel.js"></script>
<script src="<?php echo $url_mod; ?>js/CDcountRecPreviewPanel.js"></script>
<?php }

	public function hd_Content() {
		include( dirname(__FILE__) . "/tpl.search.inc.php" );
?>
<?php }

}

?>