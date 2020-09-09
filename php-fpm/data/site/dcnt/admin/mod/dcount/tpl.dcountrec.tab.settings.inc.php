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
$lca = CEnv::locale("dcount/dcountrec.settings");
$req = _req();

$rs = array_merge($rs,CJson::decode($rs["idata"]));
CXInterval::getRemaining( $rs["dcount_id"],
	$rs["b_autoloop"], $rs["autoloop"], $rs["dt_end"] );
?>
<div class="ppart">
	<div class="ppart-heading">
		<div class="ppart-title"><?php echo $lca["ppart:title:settings"]; ?></div>
		<div class="btn-save inpsave pull-right" tabindex="0"></div>
		<div class="clear:both"></div>
	</div>
	<div class="ppart-body">
		<form class="form-settings">
			<div class="psect">
				<div class="psect-body">
					<div class="ctar-falert"></div>

					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label><?php echo $lca["label:title"]; ?> 
									<?php echo $req; ?></label>
								<input type="text"
									class="form-control _ffe_"
									name="title"
									value="<?php echo _hsc( $rs["title"] ); ?>"
									placeholder="<?php echo $lca["plh:title"]; ?>"
									maxlength="100"
								/>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label><?php echo $lca["label:dt_end"]; ?> 
									<?php echo $req; ?></label>
								<div class="input-group">
									<input type="text" class="form-control inpdt _ffe_"
										name="dt_end"
										value="<?php echo $rs["dt_end"]; ?>"
										placeholder="<?php echo $lca["plh:dt_end"]; ?>"
										data-time-format="HMS"
										data-dlg-title="<?php echo $lca["title:select-end-time-dlg"]; ?>"
									/>
								</div>
							</div>
						</div>
						<div class="col-sm-6">&nbsp;
						</div>
					</div>
				</div>
			</div>

			<div class="psect">
				<div class="psect-heading">
					<div class="psect-title"><?php echo $lca["text:when-finished"]; ?></div>
				</div>
				<div class="psect-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>
									<input type="checkbox"
										name="b_redirect"
										class="inpcb _ffe_"
										<?php CHtmlMacro::printChecked(
											$rs["b_redirect"]); ?>>
									<span class="checkbox-caption">
										<?php echo $lca["label:b_redirect"]; ?>
									</span>
								</label>
								<div class="area-url_redirect" style="margin:0 0 0 30px;">
									<div class="input-group">
										<span class="input-group-addon">
											<?php echo $lca["text:url"]; ?></span>
										<input type="text"
											class="form-control _ffe_"
											name="url_redirect"
											value="<?php echo _hsc( $rs["url_redirect"] ); ?>"
											placeholder="<?php echo $lca["plh:url_redirect"]; ?>"
											/>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>
									<input type="checkbox"
										name="b_autoloop"
										class="inpcb _ffe_"
										<?php CHtmlMacro::printChecked(
											$rs["b_autoloop"]); ?>>
									<span class="checkbox-caption">
										<?php echo $lca["label:b_autoloop"]; ?>
									</span>
								</label>
								<div class="area-autoloop" style="margin:0 0 0 30px;">
									<div class="input-group">
										<input type="text"
											class="form-control _ffe_ inpinterval"
											name="autoloop"
											data-val="<?php echo _hsc( $rs["autoloop"] ); ?>"
											/>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="psect">
				<div class="psect-heading">
					<div class="psect-title"><?php echo $lca["text:display-options"]; ?></div>
				</div>
				<div class="psect-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label><?php echo $lca["label:str_day"]; ?></label>
								<input type="text"
									class="form-control _ffe_"
									name="str_day"
									value="<?php echo _hsc( $rs["str_day"] ); ?>"
									placeholder="<?php echo $lca["plh:str_day"]; ?>"
								/>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label><?php echo $lca["label:str_hour"]; ?></label>
								<input type="text"
									class="form-control _ffe_"
									name="str_hour"
									value="<?php echo _hsc( $rs["str_hour"] ); ?>"
									placeholder="<?php echo $lca["plh:str_hour"]; ?>"
								/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label><?php echo $lca["label:str_min"]; ?></label>
								<input type="text"
									class="form-control _ffe_"
									name="str_min"
									value="<?php echo _hsc( $rs["str_min"] ); ?>"
									placeholder="<?php echo $lca["plh:str_min"]; ?>"
								/>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label><?php echo $lca["label:str_sec"]; ?></label>
								<input type="text"
									class="form-control _ffe_"
									name="str_sec"
									value="<?php echo _hsc( $rs["str_sec"] ); ?>"
									placeholder="<?php echo $lca["plh:str_sec"]; ?>"
								/>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="psect">
				<div class="psect-heading">
					<div class="psect-title"><?php echo $lca["text:notes"]; ?></div>
				</div>
				<div class="psect-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
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
		</form>
	</div>
</div>

<hr style="visibility:hidden;" />

<?php //CDebug::printJson($rs); ?>