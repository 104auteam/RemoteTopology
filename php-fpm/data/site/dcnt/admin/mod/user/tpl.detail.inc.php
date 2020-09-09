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
	$lca = CEnv::locale( "user/detail" );
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
		<?php toolbar( $lca ); ?>
	</div>

	<div class="psect-body">
		<div class="ctar-form">
			<div class="ctar-falert"></div>

			<?php if ( CUG::isRootAdminId( $rs["user_id"] ) ): ?>
				<input class="_ffe_" type="hidden" name="status" value="1" />
				<input class="_ffe_" type="hidden" name="b_admin" value="1" />
			<?php else: ?>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label><?php echo $lca["label:status"]; ?>
							<?php echo $req; ?></label>
						<div>
							<label class="radio-inline"><input class="inprb _ffe_" type="radio"
								name="status" value="1"
								<?php echo ( $rs["status"] == 1 ) ? "checked" : ""; ?>>
								<span><?php echo $lca["label:active"]; ?></span>
							</label>
							<label class="radio-inline"><input class="inprb" type="radio"
								name="status" value="0"
								<?php echo ( $rs["status"] == 0 ) ? "checked" : ""; ?>>
								<span><?php echo $lca["label:inactive"]; ?></span>
							</label>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label class="hidden-xs">&nbsp;</label>
						<div>
						<label>
							<input type="checkbox" name="b_admin"
							class="_ffe_ inpcb"
							<?php echo ( $rs["b_admin"] == 1 ) ? "checked" : ""; ?>>
							<?php echo $lca["label:b_admin"]; ?>
						</label>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label><?php echo $lca["label:username"]; ?>
							<?php echo $req; ?></label>
						<input type="text" class="form-control _ffe_"
							name="username"
							maxlength="100"
							value="<?php echo _hsc( $rs["username"] ); ?>"
							placeholder="<?php echo $lca["plh:username"]; ?>">
					</div>
				</div>
				<div class="col-sm-6">
					<?php if ( $cmd == "edit" ): ?>
					<div class="form-group">
						<label class="hidden-xs">&nbsp;</label>
						<div>
						<label>
							<input type="checkbox" name="b_password" class="_ffe_ inpcb">
							<span class="checkbox-caption">
								<?php echo $lca["label:b_password"]; ?>
							</span>
						</label>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( $cmd == "edit" ): ?>
			<div class="area-password" style="display:none;">
			<div class="panel panel-info">
			<div class="panel-body bg-info" style="padding-bottom:0;">
			<?php endif; ?>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label><?php echo $lca["label:password"]; ?>
							<?php echo $req; ?></label>
						<input type="password"
							class="form-control _ffe_"
							name="password"
							maxlength="24"
							placeholder="<?php echo $lca["plh:password"]; ?>">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label><?php echo $lca["label:password_conf"]; ?>
							<?php echo $req; ?></label>
						<input type="password"
							class="form-control _ffe_"
							name="password_conf"
							maxlength="24"
							placeholder="<?php echo $lca["plh:password_conf"]; ?>">
					</div>
				</div>
			</div>
			<?php if ( $cmd == "edit" ): ?>
			</div>
			</div>
			</div>
			<?php endif; ?>

			<div class="row">
<?php CObject::obStart(); ?>
				<div class="col-sm-6">
					<div class="form-group">
						<label><?php echo $lca["label:first_name"]; ?></label>
						<input type="text" class="form-control _ffe_"
							name="first_name"
							maxlength="50"
							placeholder="<?php echo $lca["plh:first_name"]; ?>"
							value="<?php echo _hsc($rs["first_name"]); ?>"
						/>
					</div>
				</div>
<?php $code_first_name = CObject::obEnd(); ?>
<?php CObject::obStart(); ?>
				<div class="col-sm-6">
					<div class="form-group">
						<label><?php echo $lca["label:last_name"]; ?></label>
						<input type="text" class="form-control _ffe_"
							name="last_name"
							maxlength="50"
							placeholder="<?php echo $lca["plh:last_name"]; ?>"
							value="<?php echo _hsc($rs["last_name"]); ?>"
						/>
					</div>
				</div>
<?php $code_last_name = CObject::obEnd(); ?>
<?php 
	$cfg = CEnv::locale("app/format");
	$str = $cfg["tpl:name"];
	$str = str_replace("%first_name%",$code_first_name,$str);
	$str = str_replace("%last_name%",$code_last_name,$str);
	echo $str;
?>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label><?php echo $lca["label:email"]; ?></label>
						<input type="text" class="form-control _ffe_"
							name="email"
							maxlength="100"
							placeholder="<?php echo $lca["plh:email"]; ?>"
							value="<?php echo _hsc($rs["email"]); ?>"
						/>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label><?php echo $lca["label:time_zone"]; ?>
							<?php echo $req; ?></label>
						<select class="form-control _ffe_" name="time_zone">
						<?php CHtmlMacro::printOptions(
							CEnv::locale("util/time-zone"),
							"time-zone", $rs["time_zone"]); ?>
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label><?php echo $lca["label:notes"]; ?></label>
						<textarea class="form-control _ffe_"
							name="notes"
							rows="3"
							data-maxchar="200"
							placeholder="<?php echo $lca["plh:notes"]; ?>"
						><?php echo _hsc($rs["notes"]); ?></textarea>
						<div class="note-cnt-ctar">
							<span class="notes-cnt"></span>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>
							<input type="checkbox"
								name="pinidx"
								class="inpcb _ffe_"
								<?php CHtmlMacro::printChecked(
									$rs["pinidx"]); ?>>
							<span class="checkbox-caption">
								<?php echo $lca["label:pinidx"]; ?>
							</span>
						</label>
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