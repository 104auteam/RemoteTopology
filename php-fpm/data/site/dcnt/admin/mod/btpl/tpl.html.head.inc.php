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
<!--[BEGIN] site meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--[END] site meta -->

<!--[BEGIN] title -->
<?php if ( $this->breadcrumbs ) {
	echo "<title>" . $this->breadcrumbs . "</title>";
}
?> 
<!--[END] title -->

<!--[BEGIN] jQuery -->
<script src="<?php echo $url_mod; ?>js/jquery/jquery-1.11.1.min.js"></script>
<!-- enable background color animation -->
<script src="<?php echo $url_mod; ?>js/jquery/jquery.color.js"></script>
<!--[END] jQuery -->

<!-- [BEGIN] html5shiv (semantic elements) & respond.js(media queries) -->
<!--[if lt IE 9]>
<script src="<?php echo $url_mod; ?>js/iefix/html5shiv.min.js"></script>
<script src="<?php echo $url_mod; ?>js/iefix/respond.min.js"></script>
<![endif]-->
<!-- [END] html5shiv (semantic elements) & respond.js(media queries) -->

<!--[BEGIN] bootstrap -->
<link href="<?php echo $url_mod; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $url_mod; ?>bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
<script src="<?php echo $url_mod; ?>bootstrap/js/bootstrap.min.js"></script>
<!--[END] bootstrap -->

<!--[BEGIN] app -->
<script src="<?php echo $url_mod; ?>js/CDuan/CZIndex.js"></script>
<style>
<?php $lca = CEnv::locale("app/css"); echo $lca["global-css"]; ?>
</style>
<link href="<?php echo $url_mod; ?>js/CDuan/CDuan.css" rel="stylesheet"/>
<link href="<?php echo $url_mod; ?>js/CDuan/CPageStruct.css" rel="stylesheet"/>
<script src="<?php echo $url_mod; ?>js/CDuan/CDuan.js"></script>
<!--[END] app -->

<!--[BEGIN] CFooter, sticky-footer -->
<link href="<?php echo $url_mod; ?>js/CFooter/CFooter.css" rel="stylesheet"/>
<!--[END] CFooter, sticky-footer -->

<!--[BEGIN] ie fix -->
<link href="<?php echo $url_mod; ?>js/iefix/gte-ie10.css" rel="stylesheet"/>
<!--[if IE]>
<link href="<?php echo $url_mod; ?>js/iefix/lte-ie9.css" rel="stylesheet"/>
<![endif]-->
<!--[if lte IE 7]>
<link href="<?php echo $url_mod; ?>js/iefix/lte-ie7.css" rel="stylesheet"/>
<script src="<?php echo $url_mod; ?>js/iefix/lte-ie7.js"></script>
<![endif]-->
<!--[END] ie fix -->

<!--[BEGIN] javascript resource loader -->
<script src="<?php echo $url_mod; ?>js/CJRLdr/CJRLdr.js"></script>
<!--[END] javascript resource loader -->

<!--[BEGIN] rwindow -->
<link rel="stylesheet" href="<?php echo $url_mod; ?>js/CRWindow/CRWindow.css">
<script type="text/javascript" src="<?php echo $url_mod; ?>js/CRWindow/CRWindow.js"></script>
<!--[END] rwindow -->

<!--[BEGIN] msgbox -->
<script src="<?php echo $url_mod; ?>js/CMsgBox/CMsgBox.js"></script>
<?php CJRLdr::loadLocale("btpl/msgbox"); ?>
<!--[END] msgbox -->

<!--[BEGIN] notice -->
<link href="<?php echo $url_mod; ?>js/CNotice/CNotice.css" rel="stylesheet"/>
<script src="<?php echo $url_mod; ?>js/CNotice/CNotice.js"></script>
<!--[END] notice -->

<!--[BEGIN] breadcrumb -->
<link href="<?php echo $url_mod; ?>js/CBreadcrumb/CBreadcrumb.css" rel="stylesheet"/>
<script src="<?php echo $url_mod; ?>js/CBreadcrumb/CBreadcrumb.js"></script>
<!--[END] breadcrumb -->

<!--[BEGIN] scrollbtn -->
<link href="<?php echo $url_mod; ?>js/CScrollBtn/CScrollBtn.css" rel="stylesheet"/>
<script src="<?php echo $url_mod; ?>js/CScrollBtn/CScrollBtn.js"></script>
<!--[END] scrollbtn -->

<!--[BEGIN] rtbtn -->
<link href="<?php echo $url_mod; ?>js/CRtBtn/CRtBtn.css" rel="stylesheet"/>
<!--[END] rtbtn -->

<!--[BEGIN] navbar addon -->
<link href="<?php echo $url_mod; ?>js/navbar/navbar.css" rel="stylesheet"/>
<!--[END] navbar addon -->

<?php if (0): ?>
<!--[BEGIN] collapse-navbar -->
<link href="<?php echo $url_mod; ?>js/navbar/collapse-navbar.css" rel="stylesheet"/>
<!--[END] collapse-navbar -->
<?php endif; ?>

<?php // ?>