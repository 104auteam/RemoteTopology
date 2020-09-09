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
	$lca = CEnv::locale("dlgcopydcount/dlg");
?>
<div class="dlg dlgcopydcount">
	<div class="dlg-heading">
		<span class="dlg-title">
			<span class="glyphicon glyphicon-duplicate"></span>
			<?php echo $lca["title"]; ?></span>
		<button type="button" class="close btn-close" aria-label="Close"
			title="<?php echo $lca["alt:close"]; ?>">
			<span aria-hidden="true">&times;</span></button>
	</div>

	<div class="dlg-body">
		<div class="ctar-form">
			<div class="ctar-falert"></div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>
							<?php echo $lca["label:title"]; ?> 
						</label>
						<input type="text"
							class="form-control _ffe_"
							style="width:100%;max-width:100%;"
							name="title"
							value=""
							maxlength="100" />
					</div>
				</div>
				<?php if ( false && CUG::isAdmin() ): ?>
				<div class="col-sm-12">
					<div class="form-group" style="margin-bottom:0;height:70px;">
						<label>Copy to</label>
						<textarea class="inpgroup _ffe_"
							style="display:none;"
							name="group_id"
							data-gname="<?php echo CSess::getUserInfo("username"); ?>"
						><?php echo CSess::getUserInfo("group_id"); ?></textarea>
					</div>
				</div>
				<?php endif; ?> 
			</div>
		</div>
	</div>

	<div class="dlg-footer">
		<button type="button" class="btn btn-primary btn-ok"><?php
			echo $lca["label:ok"]; ?></button>
		<button type="button" class="btn btn-default btn-cancel"><?php
			echo $lca["label:cancel"]; ?></button>
		<div class="clear:both"></div>
	</div>
</div><!-- /dlgcopydcount -->

<?php // ?>