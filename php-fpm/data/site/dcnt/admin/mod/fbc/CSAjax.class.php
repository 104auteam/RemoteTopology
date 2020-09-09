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

class CSAjax extends CObject {

	public function init() {

		$data = new stdClass();
		if ( isset($_REQUEST["requ"]) ) {
			$data->requ = CJson::decode($_REQUEST["requ"]);
		} else {
			$data->requ = array();
			foreach( $_REQUEST as $key => $val ) {
				$data->requ[$key] = $val;
			}
		}
		$cmd = self::getCmd( $data );
		$data->cmd = $cmd;
		$data->resp = array();
		$this->trigger( "hd_" . $cmd, $data );
		if ( !empty( $data->cancel ) ) {// cancel
			exit;
		} elseif ( $data->resp['result'] == null ) {
			$data->resp['result'] = "Unknown Command ({$cmd})";
		}
		self::returnAjax( $data->resp );
		exit;
	}

	protected static function getCmd( $data ) {
		return isset($data->requ["cmd"]) ? $data->requ["cmd"] : "";
	}

	protected static function returnAjax( &$resp ) {
		echo json_encode( $resp );
	}

}

?>