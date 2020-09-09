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

$lca["err:empty:db-hostname"] = "<b>Hostname</b> is required";
$lca["err:empty:db-database"] = "<b>Database Name</b> is required";
$lca["err:empty:db-username"] = "<b>Username</b> is required";
$lca["err:empty:db-password"] = "<b>Password</b> is required";

$lca["err:cannot-connect-to-db"] = "Can not connect to database server [%hostname%]";
$lca["err:table-already-exists"] = "Table already exists";

$lca["err:can-not-write-config-db-file"] =<<<_EOM_
Could not read and/or write <b>config/config.db.inc.php</b><br/>
<br/>
Please give READ & WRITE permissions to <b>config/config.db.inc.php</b>
and try again.
_EOM_;

$lca["err:invalid-config-db-file"] =
	"Malformed configuration file : <b>config/config.db.inc.php</b><br/>" .
	"The file could be corrupted.";

?>