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

class CInstCode {

	public static function obStart() {
		ob_start();
	}

	public static function obEnd() {
		$html = ob_get_contents();
		if ( !empty($html) ) {
			ob_end_clean();
		}
		return $html;
	}

	public function urlScriptTag() {
		return CEnv::urlClient() . "cn.php?id=" . $this->id;
	}

	public function setup( $id ) {
		$this->id = $id;
	}

	protected function printSourceCode( $txt ) {
		$conv = array(
			"<"=>"&lt;",
			">"=>"&gt;",
			"["=>"<",
			"]"=>">",

		);
		foreach( $conv as $key => $val ) {
			$txt = str_replace( $key, $val, $txt );
		}
		echo "<pre class='code-box'>{$txt}</pre>";
	}

	protected function removeTags( $s ) {
		$s = str_replace( "[span class='code-hl']", "", $s );
		$s = str_replace( "[/span]", "", $s );
		return $s;
	}

	public function getCodeSrc() {
		return $this->removeTags( $this->getCodeTpl() );
	}

	public function printCode() {
		self::printSourceCode( $this->getCodeTpl() );
	}

	public function getHtmlSrc() {
		return $this->removeTags( $this->getHtmlTpl() );
	}

	public function printHtml() {
		$this->printSourceCode( $this->getHtmlTpl() );
	}

}

?>