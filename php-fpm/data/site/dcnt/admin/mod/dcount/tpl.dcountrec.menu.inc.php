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

	$mod_name = "dcountrec";
	$lca = CEnv::locale("dcount/dcountrec.menu");
	$str_action = $lca["action"];

	$mx = array(
		"settings",
		"preview",
	);

?>
	<div class="pull-left">
		<ul class="nav nav-pills hidden-xs">
		<?php foreach( $mx as $menu ): ?>
		<li class="<?php echo $mod_name; ?>-tab-btn-<?php echo $menu; ?>"><a href="#"><?php
			echo $lca["lable:page:{$menu}"]; ?></a></li>
		<?php endforeach; ?>
		</ul>
		<div class="btn-group hidden-sm hidden-md hidden-lg" role="group">
			<button type="button" class="btn btn-default dropdown-toggle"
				data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php echo $str_action; ?>
				<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<?php foreach( $mx as $menu ): ?>
					<li><a href='#' class="<?php echo $mod_name; ?>-tab-btn-<?php
						echo $menu; ?>"><?php
						echo $lca["lable:page:{$menu}"]; ?></a></li>
					<?php endforeach; ?>
				</ul>
		</div>
	</div>

	<div class="pull-right">
		<button type="button" class="btn btn-default btn-close"
			title="<?php echo $lca["alt:close"]; ?>"
			><?php echo $lca["label:close"]; ?></button>
	</div>

	<div style="clear:both;"></div>

<?php // ?>