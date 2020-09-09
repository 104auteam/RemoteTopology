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

class CFend_DTable extends CObject {

	public function init () {
		$this->bind("hd_HtmlHead");
	}

	public function hd_HtmlHead() {
		$url_mod = $this->urlMod();
?>
<?php CJRLdr::loadConfig("user/root-admin"); ?> 
<link href="<?php echo $url_mod; ?>css/CDTable.css" rel="stylesheet">
<script src="<?php echo $url_mod; ?>js/CDTable.js"></script>

<link href="<?php echo $url_mod; ?>css/CDlgDtc.css" rel="stylesheet">
<script src="<?php echo $url_mod; ?>js/CDlgDtc.js"></script>
<?php }

}

?>