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
	CDb::open();
	$rs = CCfgDb::get("cfgapp");

	$lca = CEnv::locale( "cfgapp/detail" );
	$req = _req();
?>
<?php function toolbar( $lca ) { ?>
		<div class="btn-group">
			<button type="button" class="btn btn-success btn-ok"><?php
				echo $lca["label:save"]; ?></button>
		</div>
<?php } ?>
<div class="psect ctar-detail">
	<div class="psect-toolbar psect-toolbar-top">
		<?php toolbar( $lca ); ?>
	</div>

	<div class="psect-body">
		<div class="ctar-form">
			<div class="ctar-falert"></div>

			<div class="psubs">
				<div class="psubs-heading">
					<label><?php echo $lca["label:tbl:dcount"]; ?></label>
				</div>

				<div class="psubs-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label><?php echo $lca["label:default-page-size"]; ?> 
									<?php echo $req; ?> 
									<?php CPopHelp::show($lca["help:default-page-size"]); ?>
								</label>
								<select class="form-control _ffe_" name="tbl:dcount:default-page-size">
								<?php CHtmlMacro::printOptions(
									CEnv::config("dtable/search"),
									"page-size-list", $rs["tbl:dcount:default-page-size"]); ?> 
								</select>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label><?php echo $lca["label:default-sort-dir"]; ?> 
									<?php echo $req; ?>
									<?php CPopHelp::show($lca["help:default-sort-dir"]); ?>
								</label>
								<select class="form-control _ffe_" name="tbl:dcount:default-sort-val">
								<?php CSortRec::printSortOptions("dcount",
									$rs["tbl:dcount:default-sort-val"]);
								?> 
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="psubs">
				<div class="psubs-heading">
					<label><?php echo $lca["label:tbl:user"]; ?></label>
				</div>

				<div class="psubs-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label><?php echo $lca["label:default-page-size"]; ?> 
									<?php echo $req; ?> 
									<?php CPopHelp::show($lca["help:default-page-size"]); ?>
								</label>
								<select class="form-control _ffe_" name="tbl:user:default-page-size">
								<?php CHtmlMacro::printOptions(
									CEnv::config("dtable/search"),
									"page-size-list", $rs["tbl:user:default-page-size"]); ?>
								</select>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label><?php echo $lca["label:default-sort-dir"]; ?> 
									<?php echo $req; ?> 
									<?php CPopHelp::show($lca["help:default-sort-dir"]); ?>
								</label>
								<select class="form-control _ffe_" name="tbl:user:default-sort-val">
								<?php CSortRec::printSortOptions("user",
									$rs["tbl:user:default-sort-val"]);
								?> 
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label><?php echo $lca["label:default_time_zone"]; ?>
									<?php echo $req; ?>
									<?php CPopHelp::show($lca["help:default_time_zone"]); ?>
								</label>
								<select class="form-control _ffe_" name="tbl:user:default_time_zone">
								<?php CHtmlMacro::printOptions(
									CEnv::locale("util/time-zone"),
									"time-zone", $rs["tbl:user:default_time_zone"]); ?>
								</select>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label><?php echo $lca["label:first-dow"]; ?>
									<?php echo $req; ?>
									<?php CPopHelp::show($lca["help:first-dow"]); ?>
								</label>
								<select class="form-control _ffe_" name="app:first-dow">
								<?php CHtmlMacro::printOptions(
									CEnv::locale("util/dow"),
									"dow", $rs["app:first-dow"]); ?>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="psect-toolbar psect-toolbar-bottom">
		<?php toolbar( $lca ); ?>
	</div>

	<?php CPopHelp::init(); ?>

</div><!-- /ctar-detail -->

<?php // ?>