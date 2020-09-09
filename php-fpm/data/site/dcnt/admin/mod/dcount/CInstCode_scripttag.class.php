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

class CInstCode_scripttag extends CInstCode {

	protected function getCodeTpl() {
		$url = $this->urlScriptTag();
		$txt=<<<_EOM_
[span class='code-hl']<script type="text/javascript" src="{$url}"></script>[/span]
_EOM_;
		return $txt;
	}

	protected function getHtmlTpl() {
		$code = $this->getCodeTpl();
		$txt=<<<_EOM_
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

{$code}

</body>
</html>
_EOM_;
		return $txt;
	}

}

?>