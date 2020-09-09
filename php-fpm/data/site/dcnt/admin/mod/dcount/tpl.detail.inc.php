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
	$lca = CEnv::locale( "dcount/detail" );
	$rs["title"] = $lca["init:title"];
	$req = _req();
?>
<?php function toolbar( $lca ) { ?>
		<div class="btn-group">
			<button type="button" class="btn btn-success btn-ok"
				><?php echo $lca["label:save"]; ?></button>
			<button type="button" class="btn btn-default btn-cancel"
				><?php echo $lca["label:cancel"]; ?></button>
		</div>
<?php } ?>
<div class="psect ctar-detail">
	<div class="psect-toolbar psect-toolbar-top">
		<?php //toolbar( $lca ); ?>
	</div>

	<div class="psect-body">
		<div class="ctar-form">
			<div class="ctar-falert"></div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label><?php echo $lca["label:title"]; ?></label>
						<input type="text" class="form-control _ffe_"
							name="title"
							placeholder="<?php echo $lca["plh:title"]; ?>"
							value="<?php echo $rs["title"]; ?>"
							maxlength="100"
						/>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="psect-toolbar psect-toolbar-bottom">
		<?php toolbar( $lca ); ?>
	</div>
</div>
<?php // ?>