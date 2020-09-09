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
	$lca = CEnv::locale( "dcount/search" );
?>
<div class="ctar-search ctar-dcount">
	<form class="ctar-criteria">
		<div class="criteria">
			<div class="input-group">
				<input type="text" class="form-control _ffe_"
					placeholder="<?php echo $lca["plh:keyword" .
						( CUG::isAdmin() ? "-admin" : "" )]; ?>"
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