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

class CMPage extends CSPage {

	public function findItemByRtp( &$items, $vrtp, &$key, &$item,
			&$key_prev, &$item_prev,
			&$key_next, &$item_next ) {
		$key = null;
		$key_prev = null;
		$key_next = null;
		$item = null;
		foreach( $items as $key1 => $item1 ) {
			if ( isset($item1['rtp']) ) {
				if ( !is_null($key) ) {
					$key_next = $key1;
					$item_next = $item1;
					return;
				}
				if ( $item1['rtp'] == $vrtp ) {
					$key = $key1;
					$item = $item1;
				} else {
					$key_prev = $key1;
					$item_prev = $item1;
				}
			}
			if ( isset($item1["items"]) ) {
				foreach( $item1['items'] as $key2 => $item2 ) {
					if ( isset($item2['rtp']) ) {
						if ( !is_null($key) ) {
							$key_next = $key2;
							$item_next = $item2;
							return;
						}
						if ( $item2['rtp'] == $vrtp ) {
							$key = $key2;
							$item = $item2;
						} else {
							$key_prev = $key2;
							$item_prev = $item2;
						}
					}
				}
			}
		}
	}

	public function init() {
		$this->bind("hd_HtmlHead");
		$this->bind("hd_Body");

		include_once(dirname(__FILE__).'/mpage/menu.inc.php');

		CApp::set( "doc", $doc );

		$vrtp = CApp::$_rtc['vrtp'];
		if ( $vrtp == "" ) {
			$vrtp = "index";
		}

		$this->findItemByRtp( $doc['items'], $vrtp,
			$this->key, $this->item,
			$this->key_prev, $this->item_prev,
			$this->key_next, $this->item_next );

		CApp::set( "page-title", $this->item['title'] );

		parent::init();
	}

	public function hd_HtmlHead() {
		$url_mod = $this->urlMod();
?>
<link href="<?php echo $url_mod; ?>js/CSideMenu/CSideMenu.css" rel="stylesheet"/>
<script src="<?php echo $url_mod; ?>js/CSideMenu/CSideMenu.js"></script>
<?php }

	public function hd_Body() { ?>
<div class="ctar-bcrumb ctar-bcrumb-top"></div>

<div class="container main-container">
	<div class="row">

<div class="col-md-3 hidden-sm hidden-xs hidden-ie7 sidemenu">
	<div class="sidemenu-inner">
		<?php CSideMenu::printMenu(CApp::get( "doc" ),$this->key); ?> 
	</div>
</div><!-- /sidemenu -->

<div class="col-md-9 main-content">

	<div class="ctar-bcrumb"></div>

<?php $this->trigger("hd_Content"); ?>
</div><!-- /main-content -->

	</div>
</div><!-- /main-container -->
<?php }

} ?>