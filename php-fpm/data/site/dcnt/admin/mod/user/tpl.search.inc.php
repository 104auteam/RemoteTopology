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
?>
<div class="ctar-search ctar-user">
	<form class="ctar-criteria">
		<div class="criteria">
			<div class="input-group">
				<span class="input-group-btn">
					<div class="btn-group">
						<button type="button" class="btn btn-default dropdown-toggle"
						data-toggle="dropdown" aria-haspopup="true"
							aria-expanded="false">
						<span class="glyphicon glyphicon-ok-sign text-info"></span>
						<span class="caret"></span></button>
						<input class="_ffe_" type="hidden" name="status" value="1"/>
						<ul class="dropdown-menu select-status">
							<li><a href="#" data-value="1"><span
								class="glyphicon glyphicon-ok-circle text-info"
								title="<?php echo $lca[ "alt:active" ]; ?>"></span>
								<?php echo $lca[ "label:active" ]; ?></a></li>
							<li><a href="#" data-value="0"><span
								class="glyphicon glyphicon-ban-circle text-info"
								title="<?php echo $lca[ "alt:inactive" ]; ?>"></span>
								<?php echo $lca[ "label:inactive" ]; ?></a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#" data-value=""><span
								class="glyphicon glyphicon-certificate text-info"
								title="<?php echo $lca[ "alt:all" ]; ?>"></span>
								<?php echo $lca[ "label:all" ]; ?></a></li>

						</ul>
					</div>
				</span>
				<input type="text" size="48" class="form-control _ffe_"
					placeholder="<?php echo $lca["plh:keyword"]; ?>"
					name="keyword" value="" />
				<span class="input-group-btn">
					<button class="btn btn-primary" type="submit"
						title="<?php echo $lca["alt:search"]; ?>">
						<span class="glyphicon glyphicon-search"
							aria-hidden="true"></span>
					</button>
				</span>
			</div>
		</div>
	</form>
	<div class="ctar-dtable"></div>
</div><!-- /ctar-search -->

<?php // ?>