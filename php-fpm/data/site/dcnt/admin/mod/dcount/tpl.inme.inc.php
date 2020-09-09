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
	$lca = CEnv::locale("dcount/inme");
?>
<div class="inme-ctar">
	<div class="inme-content">
		<div class="inme-tab-content inme-tab-content-scripttag">
			<?php
				$key = "scripttag";
				$obj = new CInstCode_scripttag();
				$obj->setup($id);
				include("tpl.inme.tab.inc.php");
			?>
		</div>
	</div>
</div>
<?php // ?>