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

class CSortRec {

	public static function printSortOptions( $mod_name, $sel_sort_val ) {
		$cfg_m = CEnv::config("{$mod_name}/search");
		$lca_m = CEnv::locale("{$mod_name}/search");
		$lca_d = CEnv::locale("dtable/search");
		self::_printSortOptions( $cfg_m, $lca_m, $lca_d, $sel_sort_val );
	}

	public static function _printSortOptions( $cfg_m, $lca_m, $lca_d, $sel_sort_val ) {
		$sx = array();
		foreach( $cfg_m["sort-key-list"] as $sort_key ) {
			$caption = $lca_m["sort:".$sort_key];

			$sort_dir = "asc";
			$sort_val = $sort_key . ":" . $sort_dir;
			$sx[] = "<option" . (
					( $sel_sort_val == $sort_val )
					? " selected" : "" ) . " " .
				"value='{$sort_val}' " .
				"title='" . $lca_d["alt:{$sort_dir}"] . "'" .
				">▲ {$caption}</option>";

			$sort_dir = "desc";
			$sort_val = $sort_key . ":" . $sort_dir;
			$sx[] = "<option" . (
				( $sel_sort_val == $sort_val )
				? " selected" : "" ) . " " .
				"value='{$sort_val}' " .
				"title='" . $lca_d["alt:{$sort_dir}"] . "'" .
				">▼ {$caption}</option>";
		}
		echo implode( "\r\n", $sx );
	}

}

?>