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

class CDTable {
	public static $page_idx;
	public static $page_size;
	public static $total_rec;
	public static $total_page;
	public static $rec_idx_s;
	public static $rec_idx_e;
	public static $sort_val;

	private static $cfg_d;
	private static $lca_d;
	private static $cfg_m;
	private static $lca_m;
	private static $offset;
	private static $limit;

	public static function getDts() {
		return array(
			"page_idx"=>self::$page_idx,
			"page_size"=>self::$page_size,
			"total_rec"=>self::$total_rec,
			"total_page"=>self::$total_page,
			"rec_idx_s"=>self::$rec_idx_s,
			"rec_idx_e"=>self::$rec_idx_e,
			"sort_val"=>self::$sort_val,
		);
	}

	public static function getPageTab( $w = 3, $flags = null ) {
		$page_tabs = "";
		if ( self::$total_page > 1 ) {
			$tpl = array(
				"link"=>"<li><a href='' class='btn-pagetab' " .
					"data-page-idx='%page-no%' title='%alt%'>%label%</a></li>",
				"sel"=>"<li class='active'><a href='' class='btn-pagetab' " .
					"data-page-idx='%page-no%' title='%alt%'>%label%</a></li>",
				"disabled"=>"<li class='disabled'><a>%label%</a></li>",
				"alt:first"=>self::$lca_d["alt:first"],
				"alt:prev"=>self::$lca_d["alt:prev"],
				"alt:next"=>self::$lca_d["alt:next"],
				"alt:last"=>self::$lca_d["alt:last"],
				"alt:page"=>self::$lca_d["alt:page"],
				"str:separator"=>self::$lca_d["str:separator"],
				"str:etc"=>self::$lca_d["str:etc"],
			);
			$page_tabs = 
				"<ul class='pagination' style='margin:0;'>" .
				CPageTab::getPageTabs( self::$total_page,
					self::$page_idx, $w, $flags, $tpl ) . 
				"</ul>";
		}
		return $page_tabs;
	}

	public static function printGotoPage() {
		$active_first = (self::$page_idx == 1) ? 0 : 1;
		$active_last = (self::$page_idx == self::$total_page) ? 0 : 1;
		$class_first = $active_first ? "page-navi-cell-active" : "page-navi-cell-inactive";
		$class_last = $active_last ? "page-navi-cell-active" : "page-navi-cell-inactive";
		$pageno_first = 1;
		$pageno_prev = max(1,self::$page_idx-1);
		$pageno_next = min(self::$total_page,self::$page_idx+1);
		$pageno_last = self::$total_page;
		$alt_first = str_replace("%page-no%",$pageno_first,self::$lca_d["alt:first"]);
		$alt_prev= str_replace("%page-no%",$pageno_prev,self::$lca_d["alt:prev"]);
		$alt_next = str_replace("%page-no%",$pageno_next,self::$lca_d["alt:next"]);
		$alt_last = str_replace("%page-no%",$pageno_last,self::$lca_d["alt:last"]);
?>
<div class="page-navi-box">
	<div class="page-navi-cell page-navi-btn-first <?php echo $class_first; ?>"
		data-active="<?php echo $active_first; ?>"
		data-pageno="<?php echo $pageno_first; ?>"
		title="<?php echo $alt_first; ?>"
		tabindex="0">
	<?php echo CPageTab::first_label; ?>
	</div><!--
	--><div class="page-navi-cell page-navi-btn-prev <?php echo $class_first; ?>"
		data-active="<?php echo $active_first; ?>"
		data-pageno="<?php echo $pageno_prev; ?>"
		title="<?php echo $alt_prev; ?>"
		tabindex="0">
	<?php echo CPageTab::prev_label; ?>
	</div><!--
	--><div class="page-navi-cell page-navi-inp">
		<input type="text" class="form-control page-navi-inp-pageno"
			title="<?php echo self::$lca_d["alt:goto-page"]; ?>"
			style="text-align:right;" value="<?php echo self::$page_idx; ?>" />
	</div><!--
	--><div class="page-navi-cell page-navi-btn-next <?php echo $class_last; ?>"
		data-active="<?php echo $active_last; ?>"
		data-pageno="<?php echo $pageno_next; ?>"
		title="<?php echo $alt_next; ?>"
		tabindex="0">
	<?php echo CPageTab::next_label; ?>
	</div><!--
	--><div class="page-navi-cell page-navi-btn-last  <?php echo $class_last; ?>"
		data-active="<?php echo $active_last; ?>"
		data-pageno="<?php echo $pageno_last; ?>"
		title="<?php echo $alt_last; ?>"
		tabindex="0">
	<?php echo CPageTab::last_label; ?>
	</div>
</div>
<?php }

	public static function printPageSizeSelect() {
		$sel = self::$page_size;

		$sx[] = "<select class='form-control select-page-size'>";
		foreach( self::$cfg_d["page-size-list"] as $key => $val ) {
			$sx[] = "<option value='{$key}'" . (( $sel == $key ) ? " selected" : "" ) .
				">{$val}</option>";
		}
		$sx[] = "</select>";
		echo implode( "\r\n", $sx );
	}

	public static function printPageSize() {
		if ( !self::$total_rec ) { return; }
?>
		<div class="input-group" title="<?php echo self::$lca_d["alt:rec-per-page"]; ?>">
			<span class="input-group-addon"><span class="glyphicon glyphicon-list-alt text-info"
				aria-hidden="true"></span></span>
			<?php self::printPageSizeSelect(); ?>
		</div>
<?php }

	public static function printSortSelect() {
		echo "<select class='form-control select-sort-option'>";
		CSortRec::_printSortOptions( self::$cfg_m, self::$lca_m, self::$lca_d,
			self::$sort_val );
		echo "</select>";
	}

	public static function printSort() {
		if ( !self::$total_rec ) { return; }
?>
		<div class="input-group" title="<?php echo self::$lca_d["alt:sort-rec"]; ?>">
			<span class="input-group-addon"><span class="glyphicon glyphicon-sort text-info"
				aria-hidden="true"></span></span>
			<?php self::printSortSelect(); ?>
		</div>
<?php }

	public static function printDlgDtcBtn() { ?>
		<button class="btn btn-primary dtbl-btn-dlgdtc"
			title="<?php echo self::$lca_d["alt:settings"]; ?>"
			><span class="glyphicon glyphicon-cog"
			></span></button>
<?php }

	public static function printDlgDtc() {
		if ( !self::$total_rec ) { return; }
?>
<div class="dlg dlgdtc">
	<div class="dlg-heading dlg-heading-g">
		<button type="button" class="close btn-close" aria-label="Close"
			title="<?php echo self::$lca_d["alt:close"]; ?>">
			<span aria-hidden="true">&times;</span></button>
	</div>

	<div class="dlg-body">
		<div class="dlgdtc-inner">
			<div class="form-group">
				<label><small><?php echo self::$lca_d["label:page-navi"]; ?></small></label>
				<?php self::printGotoPage(); ?>
			</div>

			<div class="form-group">
				<label><small><?php echo self::$lca_d["label:rec-per-page"]; ?></small></label>
				<?php self::printPageSize(); ?>
			</div>

			<div class="form-group">
				<label><small><?php echo self::$lca_d["label:sort-rec"]; ?></small></label>
				<?php self::printSort(); ?>
			</div>
		</div>
	</div>
</div>
<?php }

	public static function getStatsLine() {
		if ( self::$total_rec == 0 ) {
			$s = self::$lca_d["str:no-records"];
		} else {
			$s = self::$lca_d["str:stats-line"];
			$s = str_replace( "%rec_idx_s%", self::$rec_idx_s, $s );
			$s = str_replace( "%rec_idx_e%", self::$rec_idx_e, $s );
			$s = str_replace( "%total_rec%", self::$total_rec, $s );
		}
		return $s;
	}

	public static function printStatsLine() {
		echo self::getStatsLine();
	}

	private static function sortBtn( $sort_key, $sort_dir, $b ) {
		$sel = $b ? " btn-sort-sel" : "";
		echo "<a href='#' class='btn-sort{$sel}' " . 
			"data-sort-key='{$sort_key}' data-sort-dir='{$sort_dir}' " .
			"title='" . self::$lca_d["alt:" . $sort_dir ] . "'>";
		if ( $sort_dir == "asc" ) {
			$key = "chevron-up";
		}  else {
			$key = "chevron-down";
		}
		echo '<span class="glyphicon glyphicon-'.$key.'"></span>';
		echo "</a>";
	}

	public static function sortBtns( $sort_key ) {
		$dsv = explode(":",self::$sort_val);
		self::sortBtn( $sort_key, "asc",
			( $dsv[0] == $sort_key ) &&
			( $dsv[1] == "asc" ));
		self::sortBtn( $sort_key, "desc",
			( $dsv[0] == $sort_key ) &&
			( $dsv[1] == "desc" ));
	}

	public static function selrecMain() { ?>
<input type="checkbox" class="dtbl-selrec-main"
	title="<?php echo self::$lca_d["alt:selrec-main"]; ?>">
<?php }

	public static function selrec( $id ) { ?>
<input type="checkbox" class="dtbl-selrec"
	data-id="<?php echo $id; ?>" title="<?php echo self::$lca_d["alt:selrec"]; ?>">
<?php }

	public static function init( $mod_name ) {
		self::$cfg_d = CEnv::config("dtable/search");
		self::$lca_d = CEnv::locale("dtable/search");
		self::$cfg_m = CEnv::config("{$mod_name}/search");
		self::$lca_m = CEnv::locale("{$mod_name}/search");

		//-- config
		$cfg_a = CCfgDb::get("cfgapp");
		if ( !isset(self::$cfg_m["default-page-size"]) ) {
			self::$cfg_m["default-page-size"] = $cfg_a["tbl:{$mod_name}:default-page-size"];
		}
		if ( !isset(self::$cfg_m["default-sort-val"]) ) {
			self::$cfg_m["default-sort-val"] = $cfg_a["tbl:{$mod_name}:default-sort-val"];
		}
	}

	public static function calc( $data, $total_rec ) {

		//-- total rec
		self::$total_rec = $total_rec;

		//-- request
		$dts = $data->requ["dts"];
		self::$page_idx = $dts["page_idx"];
		self::$page_size = $dts["page_size"];

		$sort_val = $dts["sort_val"];
		$dsv = explode(":",$sort_val);
		$sort_key = ( isset($dsv[0]) ) ? $dsv[0] : "";
		$sort_dir = ( isset($dsv[1]) ) ? $dsv[1] : "";

		//-- sort key
		if ( !in_array($sort_key,self::$cfg_m["sort-key-list"]) ) {
			$dsv = explode(":",self::$cfg_m["default-sort-val"]);
			$sort_key = $dsv[0];
		}

		//-- sort dir
		if ( !in_array($sort_dir,array("asc","desc")) ) {
			$dsv = explode(":",self::$cfg_m["default-sort-val"]);
			$sort_dir = $dsv[1];
		}

		//-- sort val
		self::$sort_val = $sort_key . ":" . $sort_dir;

		//-- page idx
		self::$page_idx = intval(self::$page_idx);
		if ( self::$page_idx <= 0  ) {
			self::$page_idx = 1;
		}

		//-- page size
		self::$page_size = intval(self::$page_size);
		if ( self::$page_size == 0  ) {
			self::$page_size = self::$cfg_m["default-page-size"];
		}

		//-- total page
		self::$total_page = floor( self::$total_rec / self::$page_size );

		if ( self::$total_rec % self::$page_size > 0 ) {
			self::$total_page++;
		}

		//-- page idx
		if ( self::$page_idx > self::$total_page ) {
			self::$page_idx = self::$total_page;
		}

		//-- rec_idx_s rec_idx_e
		self::$rec_idx_s = ((self::$page_idx-1) * self::$page_size) + 1;
		self::$rec_idx_e = self::$rec_idx_s + self::$page_size - 1;
		if ( self::$rec_idx_e > self::$total_rec ) {
			self::$rec_idx_e = self::$total_rec;
		}

		//-- offset & limit
		self::$offset = (self::$page_idx-1) * self::$page_size;
		self::$limit = self::$page_size;

		if ( $total_rec ) {
			$ob = "ORDER BY ";
			if ( !isset($data->order_by) ) {
				$data->order_by = array();
			}
			$dsv = explode(":",self::$sort_val);
			$data->order_by[$dsv[0]] = $dsv[1];
			$data->clx[] = "ORDER BY " . CSql::expOrderBy( $data->order_by );

			$data->clx[] = "LIMIT " . self::$limit;
			$data->clx[] = "OFFSET " . self::$offset;
		}
	}

	public static function process( $data ) {
		//-- count rows
		$total_rec = CSql::getTotalRec($data->clx);

		//-- setup
		self::calc( $data, $total_rec );

		//-- build final sql
		return CSql::query($data->clx);
	}
}

?>