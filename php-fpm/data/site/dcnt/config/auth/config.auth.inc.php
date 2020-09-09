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

//-- If you lose the root admin's password,
//-- use "emergency-password" to log into the administrator account.
//--
//-- (1) Assign a string to "emergency-password"
//-- (2) Open the login page,
//-- (3) Enter "emergency-password" in the "username"
//--     "password" input boxes, and click "Login"
//-- (4) From the top menu, click "Users"
//-- (5) Click the edit button of the root admin.
//-- (6) Change the password and save the change.
//-- (7) Clear "emergency-password"
//--     ( Set it back to an empty string, "" )
$cfg["emergency-password"] = "";

//-- the entry page of admin panel
$cfg["entry-page"] = "dcount";

?>