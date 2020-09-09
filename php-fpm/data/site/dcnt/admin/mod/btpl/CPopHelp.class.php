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

class CPopHelp {

	public static function init() { ?>
<script>$(".pover").popover({container:"body",trigger:"click hover"});</script>
<?php }

	public static function show( $msg ) { ?>
<a tabindex="0" class="pover" data-toggle="popover" data-trigger="focus"
	data-content="<?php echo _hsc($msg); ?>"><span
	class="glyphicon glyphicon-question-sign"></span></a>
<?php }

}

?>