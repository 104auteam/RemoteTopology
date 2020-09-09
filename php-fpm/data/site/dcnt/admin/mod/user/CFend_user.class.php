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

class CFend_user extends CObject {

	public function init() {
		self::load(array(
			"inpcb/CFend_inpcb",
			"inprb/CFend_inprb",
		));

		$this->bind("hd_HtmlHead");
		$this->bind("hd_Content");
	}

	public function hd_HtmlHead() {
		$url_mod = $this->urlMod();
?>
<?php CJRLdr::loadLocale("user/bcrumb"); ?>
<?php CJRLdr::loadLocale("user/del-multi"); ?>
<link href="<?php echo $url_mod; ?>css/CUser.css" rel="stylesheet">
<script src="<?php echo $url_mod; ?>js/CUser.js"></script>
<script src="<?php echo $url_mod; ?>js/CStatusSelector.js"></script>

<?php }

	public function hd_Content() {
		include( dirname(__FILE__) . "/tpl.search.inc.php" );
	}

}

?>