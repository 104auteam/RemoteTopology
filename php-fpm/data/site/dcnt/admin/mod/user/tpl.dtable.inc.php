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
	$lca = CEnv::locale( "user/search" );
	$cfg_app = CEnv::config( "admin/app" );
?>
<div class="dtbl">
	<div class="dtbl-heading">
		<div class="dtbl-ctrl dtbl-selrec-main-ctar pull-left">
			<?php CDTable::selrecMain(); ?>
		</div>

		<div class="btn-group dtbl-ctrl pull-left">
			<button class="btn btn-success btn-reg"
				title="<?php echo $lca["alt:addnew"]; ?>"
				><span class="glyphicon glyphicon-plus"></span>
				<span class="hidden-xxs"><?php echo $lca["label:addnew"]; ?></span></button>
			<?php if ( CDTable::$total_rec ): ?>
			<button class="btn btn-warning btn-del-multi"
				title="<?php echo $lca["alt:delete"]; ?>"
				><span class="glyphicon glyphicon-remove"></span>
				<span class="hidden-xxs"><?php echo $lca["label:delete"]; ?></span>
				<span class="badge dtbl-selcnt"></span></button>
			<?php endif; ?>
		</div>

		<?php if ( CDTable::$total_rec ) { ?>
		<div class="btn-group dtbl-ctrl pull-right" role="group">
		<?php CDTable::printDlgDtcBtn(); ?>
		</div><?php } ?>

		<div style="clear:both;"></div>
	</div>

	<div class="dtbl-body">
		<div class="dtbl-ctbl">
			<?php while( $rs = CDb::getRowA( $result ) ): ?>
			<?php $this->setupRec($rs); ?>
			<div class="dtbl-row" data-id="<?php echo $rs["user_id"]; ?>">
				<div class="dtbl-row-body">
					<div class="dtbl-row-body-inner">
						<div class="dtbl-body-side">
							<div class="dtbl-body-side-inner">
								<div class="rtbtn-boxgroup">
									<div class="rtbtn-box">
									<?php CDTable::selrec($rs["user_id"]); ?>
									</div><!--
									--><div class="rtbtn-box">
										<div class="rtbtn btn-edit"
											title="<?php echo $lca["alt:edit"]; ?>"
											tabindex="0"
											><span class="glyphicon glyphicon-pencil"
											></span></div>
									</div><!--
									--><div class="rtbtn-box">
										<div class="rtbtn btn-pin<?php
											echo ($rs["pinidx"]?" btn-pin-sel":""); ?>"
											title="<?php echo $lca["alt:pin"]; ?>"
											tabindex="0"
											><span class="glyphicon glyphicon-pushpin"
											></span></div>
									</div>
								</div>

								<div class="nof-box">
									<div class="nof nof-dcount"
										title="<?php echo $lca["alt:nof_dcount"]; ?>">
										<?php echo $rs["nof_dcount"]; ?>
									</div>
								</div>

								<?php if ( $cfg_app["show-recid"] ): ?>
								<div class="dtbl-f-recid">
									<span class="label label-default"><?php
										echo "ID:" . $rs["user_id"]; ?></span>
								</div>
								<?php endif; ?>
							</div>
						</div>

						<div class="dtbl-body-main">
							<div class="dtbl-f dtbl-f-username">
								<div class="rtbar">
									<div class="rtbar-row">
										<div class="rtbar-cell rtbar-cell-icon">
											<div class="rtbtn btn-edit"
												tabindex="0"
											><span class="glyphicon glyphicon-<?php
											echo ($rs["b_admin"] ? "king":"user") ?>"></span>
											</div>
										</div>
										<div class="rtbar-cell">
											<span class="val"><?php
												echo _hsc($rs["username"]); ?></span>
										</div>
									</div>
								</div>
							</div>

							<?php if ( $s = CHtmlMacro::userinfo( $rs ) ): ?>
							<div class="dtbl-f dtbl-f-userinfo"><?php
								echo $s; ?></div>
							<?php endif; ?>

							<?php if ( $rs["notes"] ): ?>
							<div class="dtbl-f dtbl-f-notes"><?php
								echo _pre($rs["notes"]); ?></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<?php endwhile; ?>
		</div>
	</div>

	<div class="dtbl-footer">
		<?php if ( $page_tab = CDTable::getPageTab() ): ?>
		<div class="dtbl-page-tab dtbl-ctrl pull-left">
			<?php echo $page_tab; ?>
		</div>
		<?php endif; ?>

		<div class="dtbl-stats dtbl-ctrl text-primary pull-right">
			<?php echo CDTable::getStatsLine(); ?>
		</div>

		<div style="clear:both"></div>
	</div>

	<?php CDTable::printDlgDtc(); ?>
</div>
<?php // ?>