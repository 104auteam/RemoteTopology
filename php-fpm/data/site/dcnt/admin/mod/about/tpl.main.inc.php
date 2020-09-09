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
	$lca_bcrumb = CEnv::locale( "about/bcrumb" );
	$lca = CEnv::locale( "app/info" );
?>
<script>CBreadcrumb.write("<?php echo $lca_bcrumb["bcrumb:about"]; ?>");</script>

<div class="about">
	<div class="about-bar-top"></div>
	<div class="about-inner">
		<div class="about-name">
			<?php echo $lca["app:name"]; ?>
		</div>
		<div class="about-version">
			<?php echo $lca["app:version"]; ?>
		</div>
		<div class="about-link">
			<a href="<?php echo $lca["app:home:url"]; ?>" target="_blank"><?php
				echo $lca["app:home:name"]; ?></a>
		</div>
	</div>
	<div class="about-bar-bottom"></div>
</div><!-- /about -->

<?php // ?>