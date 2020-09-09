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
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="glyphicon glyphicon-flash"></span>
		<b><?php echo $lca["title:{$key}"]; ?></b>
	</div>

	<div class="panel-body">
		<div class="row">
			<div class="col-sm-12">
				<p><?php echo $lca["text:put-line-html"]; ?></p>
				<?php $obj->printCode(); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="inme-ctrl">
					<a class="btn btn-default inpcopy2clip _ffe_" href="#"
						data-text="<?php echo _hsc($obj->getCodeSrc()); ?>"
					><?php echo $lca["label:copy-to-clip"]; ?></a>

					<a class="btn btn-default" target="_blank"
						href="<?php echo CApp::vurl('run-preview','id='.$id.'&inme='.$key); ?>">
					<?php echo $lca["label:run-preview"]; ?></a>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php if ( !empty($lca["text:footer:{$key}"]) ): ?>
	<div class="panel-footer">
		<?php echo $lca["text:footer:{$key}"]; ?>
	</div>
	<?php endif; ?>
</div>
<?php // ?>