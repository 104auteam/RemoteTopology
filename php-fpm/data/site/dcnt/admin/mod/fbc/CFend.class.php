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

class CFend extends CObject {

	public function init() {
		$this->bind("hd_HtmlHead");
	}

	public function hd_HtmlHead() {
		$url_mod = $this->urlMod();
?>
<script>var url_be_entry = "<?php echo CApp::vself("_be=1"); ?>";</script>
<?php CJRLdr::loadLocale("fbc/crud"); ?>

<link href="<?php echo $url_mod; ?>css/CForm.css" rel="stylesheet">
<script src="<?php echo $url_mod; ?>js/CJMS.js"></script>
<script src="<?php echo $url_mod; ?>js/CUWait.js"></script>
<script src="<?php echo $url_mod; ?>js/CPageStack.js"></script>
<script src="<?php echo $url_mod; ?>js/CCAjax.js"></script>
<script src="<?php echo $url_mod; ?>js/CForm.js"></script>
<script src="<?php echo $url_mod; ?>js/CFRes.js"></script>

<?php }

}

?>