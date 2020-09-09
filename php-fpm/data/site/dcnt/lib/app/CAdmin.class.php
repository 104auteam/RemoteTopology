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

function autoloader_admin_base( $class ) {
	$path = CEnv::pathAdmin() . "mod/base/{$class}.class.php";
	if ( is_file( $path ) ) {
		require_once( $path );
	}
}
spl_autoload_register( "autoloader_admin_base" );

class CAdmin {

	public static function isAdmin() {
		return CUG::isAdmin();
	}

}

?>