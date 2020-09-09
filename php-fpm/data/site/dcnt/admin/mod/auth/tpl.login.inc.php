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
	$lca = CEnv::locale("auth/login");
	$lca_app = CEnv::locale("app/info");
?>
<form class="ctar-form">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="title"><?php echo $lca_app["app:name"]; ?></div>
			<div class="version"><?php echo $lca_app["app:version"]; ?></div>
			<div><?php echo $lca["label:subtitle"]; ?></div>
		</div>

		<div class="panel-body">
			<div class="ctar-falert"></div>

			<div class="form-group">
				<div class="left-inner-addon">
					<span class="glyphicon glyphicon-user"></span>
					<input type="text"
						placeholder="<?php echo $lca["plh:username"]; ?>"
						class="form-control input-lg"
						name="username"
						value=""
						maxlength="100" />
				</div>
			</div>

			<div class="form-group">
				<div class="left-inner-addon">
					<span class="glyphicon glyphicon-lock"></span>
					<input type="password"
						placeholder="<?php echo $lca["plh:password"]; ?>"
						class="form-control input-lg"
						name="password"
						value=""
						maxlength="100" />
				</div>
			</div>
		</div>

		<div class="panel-footer">
			<div class="form-group">
				<button class="btn btn-success btn-lg btn-block"
					type="submit"><b><?php echo $lca["label:enter"]; ?></b>
					<span class="glyphicon glyphicon-play" style="font-size:80%;"></span>
				</button>
			</div>
		</div>
	</div>

	<?php if ( !empty($lca_app[ "site:name" ]) ): ?>
	<p style="text-align:center;"><a class="site-link"
		href="<?php echo $lca_app["site:url"]; ?>"
	><?php echo $lca_app["site:name"]; ?></a></p>
	<?php endif; ?>
</form>
<?php // ?>