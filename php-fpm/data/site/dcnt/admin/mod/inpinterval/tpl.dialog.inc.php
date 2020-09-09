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
	$lca = CEnv::locale("inpinterval/dlginterval");
?>
<div class="dlg dlginterval">
	<div class="dlg-heading"><?php echo $lca["title"]; ?> 
		<button type="button" class="close btn-close" aria-label="Close"
			title="<?php echo $lca["alt:close"]; ?>">
			<span aria-hidden="true">&times;</span></button>
	</div>

	<div class="dlg-body">
		<div class="tivl-ctar">
			<div class="form-group">
				<label><?php echo $lca["label:day"]; ?></label>
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-warning tivl-d-dec" type="button">
							<span class="glyphicon glyphicon glyphicon-minus"></span>
						</button>
					</span>
					<input class="form-control tivl-d" type="text" maxlength="8" />
					<span class="input-group-btn">
						<button class="btn btn-success tivl-d-inc" type="button">
							<span class="glyphicon glyphicon glyphicon-plus"></span>
						</button>
					</span>
				</div>
			</div>
			<div class="form-group">
				<label><?php echo $lca["label:hour"]; ?></label>
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-warning tivl-h-dec" type="button">
							<span class="glyphicon glyphicon glyphicon-minus"></span>
						</button>
					</span>
					<input class="form-control tivl-h" type="text" maxlength="2" />
					<span class="input-group-btn">
						<button class="btn btn-success tivl-h-inc" type="button">
							<span class="glyphicon glyphicon glyphicon-plus"></span>
						</button>
					</span>
				</div>
			</div>
			<div class="form-group">
				<label><?php echo $lca["label:minute"]; ?></label>
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-warning tivl-m-dec" type="button">
							<span class="glyphicon glyphicon glyphicon-minus"></span>
						</button>
					</span>
					<input class="form-control tivl-m" type="text" maxlength="2" />
					<span class="input-group-btn">
						<button class="btn btn-success tivl-m-inc" type="button">
							<span class="glyphicon glyphicon glyphicon-plus"></span>
						</button>
					</span>
				</div>
			</div>
			<div class="form-group">
				<label><?php echo $lca["label:second"]; ?></label>
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-warning tivl-s-dec" type="button">
							<span class="glyphicon glyphicon glyphicon-minus"></span>
						</button>
					</span>
					<input class="form-control tivl-s" type="text" maxlength="2" />
					<span class="input-group-btn">
						<button class="btn btn-success tivl-s-inc" type="button">
							<span class="glyphicon glyphicon glyphicon-plus"></span>
						</button>
					</span>
				</div>
			</div>
		</div>
	</div>

	<div class="dlg-footer">
		<button type="button" class="btn btn-primary btn-ok"><?php
			echo $lca["label:ok"]; ?></button>
		<button type="button" class="btn btn-default btn-cancel"><?php echo
			$lca["label:cancel"]; ?></button>
		<div class="clear:both"></div>
	</div>
</div><!-- /dlginterval -->

<?php // ?>