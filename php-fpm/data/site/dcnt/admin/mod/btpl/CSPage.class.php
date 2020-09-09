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

class CSPage extends CObject {

	public function init() {
		$this->trigger("hd_HtmlBegin"); ?>
<?php $this->trigger("hd_DocType"); ?>
<html>

<head>

<?php $this->trigger("hd_HtmlHead"); ?>

</head>

<body>

<?php $this->trigger("hd_BodyHeader"); ?>

<main>

<?php $this->trigger("hd_Body"); ?>

</main>

<?php $this->trigger("hd_BodyFooter"); ?>

</body>

</html>
<?php $this->trigger("hd_HtmlEnd");
	}

} ?>