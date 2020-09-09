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
	$lca = CEnv::locale("inpcopy2clip/dlg");
?>
<div class="dlg dlgcopy2clip">
	<div class="dlg-heading">
		<span class="dlg-title">
			<span class="glyphicon glyphicon-copy"></span>
			<span class="title"><?php echo $lca["title:dialog"]; ?></span>
		</span>
		<button type="button" class="close btn-close" aria-label="Close"
			title="<?php echo $lca["alt:close"]; ?>">
			<span aria-hidden="true">&times;</span></button>
	</div>

	<div class="dlg-body">
		<div class="ctar-form">
			<div class="ctar-falert"></div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group" style="margin-bottom:0;">
						<p class="text-primary"><?php echo $lca["text:how-to-copy"]; ?> 
						<div class="dlgcopy2clip-data-area"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="dlg-footer">
		<button type="button" class="btn btn-default btn-close"><?php
			echo $lca["label:close"]; ?></button>
		<div class="clear:both"></div>
	</div>
</div><!-- /dlgcopy2clip -->

<?php // ?>