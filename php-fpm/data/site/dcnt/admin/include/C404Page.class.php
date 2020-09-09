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

class C404Page {

	public static function main() { ?>
<!doctype html>
<html>
<head>

<meta charset="utf-8">
<title>404 Page Not Found</title>

<style>
html {
	position: relative;
	min-height: 100%;
	*min-height:auto;
}
body {
	margin:0;
	padding:0;
	background: #feffff; /* Old browsers */
	background: -moz-linear-gradient(top, #feffff 0%, #ddf1f9 35%, #a0d8ef 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top, #feffff 0%,#ddf1f9 35%,#a0d8ef 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom, #feffff 0%,#ddf1f9 35%,#a0d8ef 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#feffff', endColorstr='#a0d8ef',GradientType=0 ); /* IE6-9 */
}
.container {
	margin:100px auto;
}
.title1,
.title2 {
	text-align:center;
	color:#448;
	font-family:"Times New Roman", Georgia, Serif;
	text-shadow:1px 1px 5px #888;
}
.title1 {
	font-size:80px;
}
.title2 {
	font-size:60px;
}
</style>

</head>

<body>

<div class='container'>
<div class='title1'>404</div>
<div class='title2'>Page Not Found</div>
</div>

</body>

</html><?php
	}
}

?>