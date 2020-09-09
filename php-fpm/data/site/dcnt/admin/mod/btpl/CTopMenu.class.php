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

class CTopMenu {

	public static function printLevel2( $item ) {
		if ( !isset($item["items"]) ) { return; }
		foreach( $item["items"] as $key2=>$item2 ) {
			if ( $item2['rtp'] == null ) {
?>
					<li role="separator" class="divider"></li>
<?php
				
			} else {
				$url = CApp::vurl($item2['rtp']);

				$params = '';
				if ( isset($item2["target"]) ) {
					$params .= ' target="'.$item2["target"].'"';
				}
?>

					<li>
						<a href="<?php echo $url; ?>"<?php echo $params; ?>>
						<?php echo htmlspecialchars($item2['title']); ?> 
						</a>
					</li>
<?php
			}
		}
	}

	public static function printLevel1( $key, $item ) { ?>
		<?php if ( !empty($item["items"]) ): ?> 
			<li>
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<?php echo htmlspecialchars($item['title']); ?> <span class="caret"></span>
				</a>
				<ul class="dropdown-menu" role="menu">
				<?php self::printLevel2( $item ); ?> 
				</ul>
			</li>
		<?php else:
			$url = CApp::vurl($item['rtp']);

			$params = '';
			if ( isset($item["target"]) ) {
				$params .= ' target="'.$item["target"].'"';
			}
		?> 
			<li>
				<a href="<?php echo $url; ?>"<?php echo $params; ?>>
				<?php echo htmlspecialchars($item['title']); ?> 
				</a>
			</li>
		<?php endif; ?>
	<?php }

	public static function printMenu( $doc ) {
		if ( !isset($doc["items"]) ) { return; }
		foreach( $doc["items"] as $key => $item ) {
			if (( $key != "index" ) && ( CRoll::hasRoll($item["roll"]) )) {
				self::printLevel1( $key, $item );
			}
		}
	}

}

?>