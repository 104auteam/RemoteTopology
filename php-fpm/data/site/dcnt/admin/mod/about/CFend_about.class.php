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

class CFend_about extends CObject {

	public function init() {
		$this->bind("hd_Content");
		$this->bind("hd_HtmlHead");
	}

	public function hd_HtmlHead() {
		$url_mod = $this->urlMod();
?>
<link href="<?php echo $url_mod; ?>css/CAbout.css" rel="stylesheet">
<script src="<?php echo $url_mod; ?>js/CAbout.js"></script>
<?php }

	public function hd_Content() {
		include( dirname(__FILE__) . "/tpl.main.inc.php" );
	}

}

?>