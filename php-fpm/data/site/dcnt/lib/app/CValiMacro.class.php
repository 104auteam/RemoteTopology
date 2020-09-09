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

class CValiMacro {

	private static $fm;
	private static $vx;
	private static $lca;
	public static function setup( &$data, &$lca ) {
		self::$fm =& $data->fm;
		self::$vx =& $data->vx;
		self::$lca =& $lca;
	}

	public static function setup2( &$fm, &$vx, &$lca ) {
		self::$fm =& $fm;
		self::$vx =& $vx;
		self::$lca =& $lca;
	}

	public static function isValidDateTime( $v ) {
		$t = strtotime($v);
		return !(( $t === false ) || ( strlen($v) <=1 ));
	}

	public static function isValidEmailAddr( $v ) {
		$s = trim( $v );
		if ( $s  != "" ) {
			$p1 = mb_strpos( $s, "@" );
			$p2 = mb_strrpos( $s, "." );
			if (
				( $p1  <= 0 )  ||
				( mb_strlen( $s )-1 <= $p2 ) ||
				( $p2  - $p1  <= 1 ) ||
				( mb_strpos($s ," " ) !== false )
			) {
				return false;
			}
		}
		return true;
	}

	public static function isValidInt( $v ) {
		return ( preg_match('/^[0-9]*$/', $v) == true );
	}

	public static function isValidFloat( $v ) {
		return ( preg_match('/^[0-9]*(\.[0-9]*)?$/', $v) == true );
	}

	public static function isValidURL( $v ) {
		return ( preg_match('/^(http:\/\/|https:\/\/).{1}/', $v) == true );
	}

	public static function copy( $key ) {
		if ( empty(self::$fm[$key]) ) {
			self::clear($key);
		} else {
			self::$vx[$key] = self::$fm[$key];
		}
	}

	public static function clear( $key ) {
		self::$vx[$key] = null;
	}

	public static function vCheckbox( $key, $b_assign = true ) {
		$val = ( intval(self::$fm[$key]) == 1 ) ? 1 : 0;
		if ( $b_assign ) {
			self::$vx[$key] = $val;
		}
		return $val;
	}

	public static function vStr( $key, $b_required = true, $b_assign = true ) {
		if ( empty(self::$fm[$key]) ) {
			if ( $b_required ) {
				CFRes::setES($key);
				CFRes::addEA(self::$lca["err:empty:{$key}"]);
			}
		}
		if ( $b_assign ) {
			self::copy($key);
		}
	}

	public static function vInt( $key, $b_required = true, $b_assign = true ) {
		if ( trim(self::$fm[$key]) == "" ) {
			if ( $b_required ) {
				CFRes::setES($key);
				CFRes::addEA(self::$lca["err:empty:{$key}"]);
			}
		} else if ( !self::isValidInt(self::$fm[$key]) ) {
			CFRes::setES($key);
			CFRes::addEA(self::$lca["err:invalid:{$key}"]);
		}
		if ( $b_assign ) {
			self::$vx[$key] = intval(trim(self::$fm[$key]));
		}
	}

	public static function vFloat( $key, $b_required = true, $b_assign = true ) {
		if ( trim(self::$fm[$key]) == "" ) {
			if ( $b_required ) {
				CFRes::setES($key);
				CFRes::addEA(self::$lca["err:empty:{$key}"]);
			}
		} else if ( !self::isValidFloat(self::$fm[$key]) ) {
			CFRes::setES($key);
			CFRes::addEA(self::$lca["err:invalid:{$key}"]);
		}
		if ( $b_assign ) {
			self::$vx[$key] = floatval(trim(self::$fm[$key]));
		}
	}

	public static function vDateTime( $key, $b_required = true, $b_assign = true ) {
		if ( empty(self::$fm[$key]) ) {
			if ( $b_required ) {
				CFRes::setES($key);
				CFRes::addEA(self::$lca["err:empty:{$key}"]);
			}
		} else if ( !self::isValidDateTime(self::$fm[$key]) ) {
			CFRes::setES($key);
			CFRes::addEA(self::$lca["err:invalid:{$key}"]);
		}
		if ( $b_assign ) {
			self::copy($key);
		}
	}

	public static function vEmail( $key, $b_required = true, $b_assign = true ) {
		if ( empty(self::$fm[$key]) ) {
			if ( $b_required ) {
				CFRes::setES($key);
				CFRes::addEA(self::$lca["err:empty:{$key}"]);
			}
		} else if ( !self::isValidEmailAddr(self::$fm[$key]) ) {
			CFRes::setES($key);
			CFRes::addEA(self::$lca["err:invalid:{$key}"]);
		}
		if ( $b_assign ) {
			self::copy($key);
		}
	}

	public static function vURL( $key, $b_required = true, $b_assign = true ) {

		if ( empty(self::$fm[$key]) ) {
			if ( $b_required ) {
				CFRes::setES($key);
				CFRes::addEA(self::$lca["err:empty:{$key}"]);
			}
		} else if ( !self::isValidURL(self::$fm[$key]) ) {
			CFRes::setES($key);
			CFRes::addEA(self::$lca["err:invalid:{$key}"]);
		}
		if ( $b_assign ) {
			self::copy($key);
		}
	}

	public static function v01( $key, $b_required = true, $b_assign = true ) {
		if ( isset(self::$fm[$key]) ) {
			$val = self::$fm[$key];
			if (( $val === "0" ) || ( $val === 0 )) {
				$val = 0;
			} else if (( $val === "1" ) || ( $val === 1 )) {
				$val = 1;
			} else {
				$val = null;
			}
		} else {
			$val = null;
		}

		if ( $b_required && ( is_null($val) )) {
			CFRes::setES($key);
			CFRes::addEA(self::$lca["err:empty:{$key}"]);
		}
		if ( $b_assign ) {
			self::$vx[$key] = $val;
		}
	}

	public static function vStrConf( $key ) {
		if ( empty(self::$fm["{$key}_conf"]) ) {
			//-- conf
			CFRes::setES("{$key}_conf");
			CFRes::addEA(self::$lca["err:empty:{$key}_conf"]);
		} else if ( self::$fm[$key] != self::$fm["{$key}_conf"] ) {
			//-- match
			CFRes::setES($key);
			CFRes::setES("{$key}_conf");
			CFRes::addEA(self::$lca["err:cannot-confirm:{$key}"]);
		}
	}

}

?>