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

class CHtmlMacro {

	public static function printOptions( $lca, $nm, $sel ) {
		$sx = array();
		foreach( $lca[$nm] as $key => $val ) {
			$selected = ( $key == $sel ) ? " selected" : "";
			$s = "<option value='" . $key . "'{$selected}>" .
				$val .
				"</option>";
			$sx[] = $s;
		}
		echo implode("\r\n",$sx);
	}

	public static function printChecked( $val ) {
		if ( intval($val) == 1 ) {
			echo " checked";
		}
	}

	public static function userinfo( $rs, $b_html = true ) {
		$cfg = CEnv::locale("app/format");
		$pat = $cfg["tpl:name"];
		$str = $pat;
		$str = str_replace("%first_name%",
			isset($rs["first_name"]) ? _hsc($rs["first_name"]) : "",
			$str);
		$str = str_replace("%last_name%",
			isset($rs["last_name"]) ? _hsc($rs["last_name"]) : "",
			$str);
		$str = trim($str);

		if ( isset($rs["email"]) ) {
			$str = ( $str == "" ) ? "" : ($str . " ");
			$str .= "&lt;";
			if ( $b_html ) {
				$str .= "<a href='mailto:" . $rs["email"] . "' target='_blank'>";
			}
			$str .= _hsc($rs["email"]);
			if ( $b_html ) {
				$str .= "</a>";
			}
			$str .= "&gt;";
		}
		return $str;
	}

}

?>