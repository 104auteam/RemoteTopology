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
	$lca = CEnv::locale("inpdt/dlgdt");
?>
<div class="dlg dlgdt">
	<div class="dlg-heading"><span class="dlg-heading-title"><?php echo $lca["title"]; ?></span>
		<button type="button" class="close btn-close" aria-label="Close"
			title="<?php echo $lca["alt:close"]; ?>">
			<span aria-hidden="true">&times;</span></button>
	</div>

	<div class="dlg-body">
		<div class="dtpk-ctar">
			<div class="dtpk-sel-ym">
				<table>
				<tr>
				<td align="left">
					<div class="input-group dtpk-sel-m-ctar">
						<span class="input-group-btn">
							<button class="btn btn-warning dtpk-m-prev" type="button">
								<span class="glyphicon glyphicon-chevron-left"></span>
							</button>
						</span>
						<select class="form-control dtpk-sel-m"></select>
						<span class="input-group-btn">
							<button class="btn btn-success dtpk-m-next" type="button">
								<span class="glyphicon glyphicon-chevron-right"></span>
							</button>
						</span>
					</div>
				</td>
				<td>&nbsp;</td>
				<td align="right">
					<div class="input-group dtpk-sel-y-ctar">
						<span class="input-group-btn">
							<button class="btn btn-warning dtpk-y-prev" type="button">
								<span class="glyphicon glyphicon-chevron-left"></span>
							</button>
						</span>
						<select class="form-control dtpk-sel-y"></select>
						<span class="input-group-btn">
							<button class="btn btn-success dtpk-y-next" type="button">
								<span class="glyphicon glyphicon-chevron-right"></span>
							</button>
						</span>
					</div>
				</td>
				</tr>
				</table>
			</div>
			<div class="dtpk-ym"></div>
			<table class="dtpk-daytbl"></table>
		</div>

		<div class="form-inline tipk-ctar">
			<div>
				<div class="tipk-hms-label"><?php echo $lca["label:hour"]; ?></div>
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-warning tipk-h-dec" type="button">
							<span class="glyphicon glyphicon glyphicon-minus"></span>
						</button>
					</span>
					<input class="form-control tipk-h" type="text" maxlength="2" />
					<span class="input-group-btn">
						<button class="btn btn-success tipk-h-inc" type="button">
							<span class="glyphicon glyphicon glyphicon-plus"></span>
						</button>
					</span>
				</div>
			</div>
			<span>:</span>
			<div>
				<div class="tipk-hms-label"><?php echo $lca["label:minute"]; ?></div>
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-warning tipk-m-dec" type="button">
							<span class="glyphicon glyphicon glyphicon-minus"></span>
						</button>
					</span>
					<input class="form-control tipk-m" type="text" maxlength="2" />
					<span class="input-group-btn">
						<button class="btn btn-success tipk-m-inc" type="button">
							<span class="glyphicon glyphicon glyphicon-plus"></span>
						</button>
					</span>
				</div>
			</div>
			<span class="tipk-s-sepa">:</span>
			<div class="tipk-s-ctar">
				<div class="tipk-hms-label"><?php echo $lca["label:second"]; ?></div>
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-warning tipk-s-dec" type="button">
							<span class="glyphicon glyphicon glyphicon-minus"></span>
						</button>
					</span>
					<input class="form-control tipk-s" type="text" maxlength="2" />
					<span class="input-group-btn">
						<button class="btn btn-success tipk-s-inc" type="button">
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
</div><!-- /dlgdt -->

<?php // ?>