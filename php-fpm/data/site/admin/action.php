<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/site/session.php');
    // If you are login -> redirect 
    if (!$_SESSION['adminpriv']) {
        Redirect('');
    }
    $conn = ConnectToDB();
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'ChangeStateAll':
                // Change state for all ->
                $activate   = $_POST['activate'];
                $query      = $conn->query("UPDATE `currentstate` SET `State`=$activate WHERE `Username` IN (SELECT `Username` FROM `usersinfo`.`credentials` WHERE `adminpriv`=0)");
                $_SESSION["event"] = True;
                $_SESSION["event_description"] = "STATE ALL ---> $activate";
                break;
            case 'ChangeStateUser':
                // Change state for username ->
                $activate   = $_POST['activateUser'];
                $username   = $_POST['username'];
                $query      = $conn->query("UPDATE `currentstate` SET `State`=$activate WHERE `Username` IN (SELECT `Username` FROM `usersinfo`.`credentials` WHERE `adminpriv`=0 AND `Username`='$username')");  
                $_SESSION["event"] = True;
                $_SESSION["event_description"] = "STATE '$username' ---> $activate";
                break;
            case 'ChangeStateUsers':
                // Change state for user range ->
                $activate   = $_POST['activateUser'];
                $username1  = $_POST['username1'];
                $username2  = $_POST['username2'];
                $query      = $conn->query("UPDATE `currentstate` SET `State`=$activate 
                WHERE `Username` IN (
                    SELECT `Username` FROM `usersinfo`.`credentials` WHERE `Number` BETWEEN 
                    (SELECT `Number` FROM `usersinfo`.`credentials` WHERE `Username`='$username1')
                    AND
                    (SELECT `Number` FROM `usersinfo`.`credentials` WHERE `Username`='$username2')
                )
                ");
                $_SESSION["event"] = True;
                $_SESSION["event_description"] = "STATE USERS ---> $activate";
                break;
            case 'ChangePassUser':
                // Change password for username
                $username   = $_POST['username'];
                $password   = md5($_POST['password']);
                $query      = $conn->query("UPDATE `credentials` SET `Password`='$password' WHERE `adminpriv`=0 AND `Username`='$username'");  
                $_SESSION["event"] = True;
                $_SESSION["event_description"] = "NEW PASSWORD FOR '$username'";
                break;
            case 'ChangeModuleAll':
                // Change module for ALL
                $module = $_POST['module'];
                $query  = $conn->query("UPDATE `currentstate` SET `Module`='$module' WHERE `Username` IN (SELECT `Username` FROM `usersinfo`.`credentials` WHERE `adminpriv`=0)");  
                $_SESSION["event"] = True;
                $_SESSION["event_description"] = "NEW MODULE FOR ALL '$module'";
                break;
            case 'ChangeModuleUser':
                // Change module for user
                $module     = $_POST['module'];
                $username   = $_POST['username'];
                $query      = $conn->query("UPDATE `currentstate` SET `Module`='$module' WHERE `Username` IN (SELECT `Username` FROM `usersinfo`.`credentials` WHERE `adminpriv`=0 AND `Username`='$username')");  
                $_SESSION["event"] = True;
                $_SESSION["event_description"] = "USERNAME '$username' ---> MODULE '$module'  ";
                break;
            case 'ChangeModuleUsers':
                // Change module for users range
                $module     = $_POST['module'];
                $username1  = $_POST['username1'];
                $username2  = $_POST['username2'];
                $query = $conn->query("UPDATE `currentstate` SET `Module`='$module' 
                WHERE `Username` IN (
                    SELECT `Username` FROM `usersinfo`.`credentials` WHERE `Number` BETWEEN 
                    (SELECT `Number` FROM `usersinfo`.`credentials` WHERE `Username`='$username1')
                    AND
                    (SELECT `Number` FROM `usersinfo`.`credentials` WHERE `Username`='$username2')
                )
                ");  
                $_SESSION["event"] = True;
                $_SESSION["event_description"] = "USERNAME '$username1' - '$username2' ---> MODULE '$module'  ";
                break;
            case 'ChangeLinkUser':
                $module     = $_POST['module'];
                $username   = $_POST['username'];

                #### TMP VCENTER

                $vcenter_address    =   $_POST['v_address'];
                $vcenter_username   =   $username;
                $vcenter_password   =   $_POST['v_pass'];
                $vcenter_datacenter =   $_POST['v_dc'];

                
                try {
                    $query   = $conn->query("INSERT `championships`.vcenter (address,username,password,datacenter)
                            VALUES ('$vcenter_address','$vcenter_username','$vcenter_password','$vcenter_datacenter')");
                } catch (Exception $e) {
                    $query   = $conn->query("UPDATE `championships`.vcenter SET 
                                `address`='$vcenter_address',
                                `password`='$vcenter_password',
                                `datacenter`='$vcenter_datacenter'
                                WHERE `username` = '$vcenter_username'
                                ");
                }
                // UPDATE `currentstate` SET `Championship`='$champ' WHERE `Username` IN (SELECT `Username` FROM `usersinfo`.`credentials` WHERE `adminpriv`=0)");

                #### TMP VCENTER

                $query   = $conn->query("SELECT Championship FROM usersinfo.currentstate WHERE `Username` = '$username'");
                $champ   = $query->fetch(); $champ = $champ[0];

                // Set Device list in DEVICES_LIST:
                // $DEVICES_LIST[0] => 'L-CLI-A'
                // $DEVICES_LIST[1] => 'L-CLI-B'
                $query   = $conn->query("SELECT Complex FROM championships.champ_list WHERE `Event` = '$champ'");
                $complex_champ = $query->fetch(); $complex_champ = $complex_champ[0];
                if ($complex_champ == True) {
                    $query = $conn->query("SELECT Championship FROM usersinfo.currentstate WHERE `Username` = '$username'");
                    $champ = $query->fetch(); $champ = $champ[0];
                    $table = 'championships.`' . $champ .'`';
                    $sql            = "SELECT Complex FROM championships.Devices WHERE `Champ` = '$champ'";
                    $query          = $conn->query($sql);
                    $DEVICES        = $query->fetch(PDO::FETCH_ASSOC);
                    $DEVICES_LIST   = preg_split("/,/", $DEVICES['Complex']);

                    // Check available user on champ and create if no
                    $query   = $conn->query("SELECT Username FROM $table WHERE `Username` = '$username'");
                    $available = $query->fetch(); $available = $available[0];
                    if (!$available) $query   = $conn->query("INSERT $table (Username) VALUES ('$username')");

                    foreach ($DEVICES_LIST as $device) {
                        $link   = $_POST[$device];
                        try {
                            $query  = $conn->query("UPDATE $table SET `$device`='$link' WHERE `Username`='$username'");
                        }  catch (Exception $e) {
                            echo 'Exception: ',  $e->getMessage(), "\n";
                        } finally {
                            echo "NEXT\n";
                        }
                    }
                }
                else {
                    // For debug lol :))))
                    // echo $module;       $query   = $conn->query("SELECT Complex213 FROM championships.champ_list WHERE `Event` = '$champ'");$complex_champ = $query->fetch();
                    $sql        = "SELECT $module FROM championships.Devices WHERE `Champ` =
                    (SELECT Championship FROM usersinfo.currentstate WHERE `Username` = '$username')";
                    $query      = $conn->query($sql);
                    $DEVICES    = $query->fetch(PDO::FETCH_ASSOC);
                    $DEVICES_LIST = preg_split("/,/", $DEVICES[$module]);
                    
                    // Create table name
                    $query = $conn->query("SELECT Championship FROM usersinfo.currentstate WHERE `Username` = '$username'");
                    $champ = $query->fetch(); $champ = $champ[0];
                    $table = 'championships.`' . $champ . $module . '`';
                    
                    // Check available user on champ and create if no
                    $query   = $conn->query("SELECT Username FROM $table WHERE `Username` = '$username'");
                    $available = $query->fetch(); $available = $available[0];

                    if (!$available) $query   = $conn->query("INSERT $table (Username) VALUES ('$username')");
                    
                    foreach ($DEVICES_LIST as $device) {
                        $link   = $_POST[$device];
                        try {
                            $query  = $conn->query("UPDATE $table SET `$device`='$link' WHERE `Username`='$username'");
                        }  catch (Exception $e) {
                            echo 'Exception: ',  $e->getMessage(), "\n";
                        } finally {
                            echo "NEXT\n";
                        }
                    }
                }
                $_SESSION["event"] = True;
                $_SESSION["event_description"] = "USERNAME '$username' ---> NEW LINKS";
                break;
            case 'ChangeChampAll':
                // Change Championship for ALL
                $champ  = $_POST['champ'];
                $query  = $conn->query("UPDATE `currentstate` SET `Championship`='$champ' WHERE `Username` IN (SELECT `Username` FROM `usersinfo`.`credentials` WHERE `adminpriv`=0)");
                $_SESSION["event"] = True;
                $_SESSION["event_description"] = "CHAMP '$champ' ---> FOR ALL";
                break;
            case 'ChangeChampUser':
                // Change Championship for user
                $champ      = $_POST['champ'];
                $username   = $_POST['username'];
                // Drop user from old champ

                // $query  = $conn->query("SELECT Championship FROM usersinfo.currentstate WHERE `Username`='$username'");
                // $oldchamp  = $query->fetch(); $oldchamp = $oldchamp[0];
                // $query  = $conn->query("DELETE FROM championships.`$champ` WHERE Username='$username'");
                // Add user on new champ
                $query  = $conn->query("UPDATE `currentstate` SET `Championship`='$champ' WHERE `Username`='$username'");
                $_SESSION["event"] = True;
                $_SESSION["event_description"] = "CHAMP '$champ' ---> FOR '$username'";
                break;
            case 'ChangeChampUsers':
                // Change Championship for ALL
                $champ      = $_POST['champ'];
                $username1  = $_POST['username1'];
                $username2  = $_POST['username2'];
                // Drop users from old champ
                // $query  = $conn->query(
                //     "SELECT Championship FROM usersinfo.currentstate 
                //     WHERE `Username` BETWEEN '$username1' AND '$username2'
                //     ");
                // $champ  = $query->fetch(PDO::FETCH_ASSOC); 
                // print_r($champ);
                // $query  = $conn->query("DELETE FROM championships.`$champ` WHERE Username='$username'");
                // die();
                // Add users on new champ
                $query = $conn->query("UPDATE `currentstate` SET `Championship`='$champ' 
                WHERE `Username` IN (
                    SELECT `Username` FROM `usersinfo`.`credentials` WHERE `Number` BETWEEN 
                    (SELECT `Number` FROM `usersinfo`.`credentials` WHERE `Username`='$username1')
                    AND
                    (SELECT `Number` FROM `usersinfo`.`credentials` WHERE `Username`='$username2')
                )
                ");  
                $_SESSION["event"] = True;
                $_SESSION["event_description"] = "CHAMP '$champ' ---> FOR USERS";
                break;
            case 'ChangeTimerChamp':
                // Change Timer for Champ
                $champ  = $_POST['champ'];
                $timer  = $_POST['timer'];
                $query = $conn->query("UPDATE championships.champ_list SET `Timer`='$timer' WHERE `Event`='$champ'");  
                $_SESSION["event"] = True;
                $_SESSION["event_description"] = "CHAMP '$champ' ---> NEW TIMER";
                break;
            case 'AddUser':
                // Add new User to champ
                $number     = $_POST['number'];
                $username   = $_POST['user'];
                $password   = $_POST['pass'];
                $md5pass    = md5($_POST['pass']);
                $champ      = $_POST['champ'];
                if( isset($_POST['adminpriv']) ) $adminpriv = 1;
                else                             $adminpriv = 0;
                $module     = $_POST['module'];

                // Check username in DB
                $query   = $conn->query("SELECT Username FROM usersinfo.`credentials` WHERE `Username` = '$username'");
                $break = $query->fetch(); $break = $break[0];
                if($break) break;

                // Add into usersinfo
                $query = $conn->query(
                    "INSERT usersinfo.`credentials`(Number, Username, Password, adminpriv) 
                    VALUES ($number, '$username', '$md5pass', $adminpriv);                    
                    INSERT usersinfo.`currentstate`(Username, State, Module, Championship) 
                    VALUES ('$username', 1, '$module', '$champ');                    
                    -- ");
                
                // Write clean username and pass to file 
                $fp = fopen('data/9bc65c2abec141778ffaa729489f3e87.txt', 'a') or die("Unable to open file!");
                $string = "$username/$password\n";
                fwrite($fp, $string);
                fclose($fp);
                
                // Get `Complex` champ 
                $query   = $conn->query("SELECT Complex FROM championships.champ_list WHERE `Event` = '$champ'");
                $complex_champ = $query->fetch(); $complex_champ = $complex_champ[0];

                if ($complex_champ) {
                    $query = $conn->query(
                        "INSERT championships.`$champ` (Username) 
                        VALUES ('$username');                    
                        ");
                }
                else {
                    $modules = ['A', 'B', 'C']; 
                    foreach ( $modules  as $module) {
                        $table = $champ . $module;
                        // echo $table;
                        $query = $conn->query(
                            "INSERT championships.`$table` (Username) 
                            VALUES ('$username');                    
                            ");
                    }
                }
                // For debug lol :))))
                // $query   = $conn->query("SELECT Complex213 FROM championships.champ_list WHERE `Event` = '$champ'");$complex_champ = $query->fetch();
                $_SESSION["event"] = True;
                $_SESSION["event_description"] = "CREATE USER '$user'";
                break;
            case 'DropUser':
                // DROP USER
                $username   = $_POST['username'];
                // Drop from ALL Championships
                $query = $conn->query("SELECT `Event` FROM championships.champ_list");
                $champlist = $query->fetchAll(PDO::FETCH_COLUMN, 0);
                foreach ($champlist as $number => $champ) {
                    // Parse All championat
                    // Get `Complex` champ 
                    $query   = $conn->query("SELECT Complex FROM championships.champ_list WHERE `Event` = '$champ'");
                    $complex_champ = $query->fetch(); $complex_champ = $complex_champ[0];
                    if($complex_champ) {
                        // Drop from champ table if complex
                        try {
                            $query = $conn->query("DELETE FROM championships.`$champ` WHERE Username='$username'");
                        }  catch (Exception $e) {
                            echo 'Exception: ',  $e->getMessage(), "\n";
                        } finally {
                            echo "NEXT\n";
                        }
                    }
                    else {
                        // Or Drop from all module champ table if not complex
                        $modules = ['A', 'B', 'C']; 
                        foreach ( $modules  as $module) {
                            $table = $champ . $module;
                            try {   
                                $query = $conn->query("DELETE FROM championships.`$table` WHERE Username='$username'");
                            }  catch (Exception $e) {
                                echo 'Exception: ',  $e->getMessage(), "\n";
                            } finally {
                                echo "NEXT\n";
                            }
                        }
                    }
                }

                // Drop string from txt fiile
                $string=file_get_contents('data/9bc65c2abec141778ffaa729489f3e87.txt');
                $string=explode("\n",$string);
                foreach($string as $key=>$value)
                {
                    $line=explode("/",$value);
                    // $line[0] - username 
                    // $line[1] - password
                    if( $line[0] == $username ) {
                        unset($string[$key]);
                    }
                }
                $string=implode("\n",$string);
                file_put_contents('data/9bc65c2abec141778ffaa729489f3e87.txt', $string);
                // Drop from usersinfo
                $query      = $conn->query(
                    "DELETE FROM usersinfo.`credentials` WHERE Username='$username';
                    SET @i := 0;
                    UPDATE usersinfo.`credentials` SET  `Number` = (@i := @i + 1);
                    ALTER TABLE usersinfo.`credentials` AUTO_INCREMENT = 1;
                    DELETE FROM usersinfo.`currentstate` WHERE Username='$username';
                    ");
                $_SESSION["event"] = True;
                $_SESSION["event_description"] = "USERNAME '$username' ---> DROPED";
                break;
            case 'DropUsers':
                // Drop USERS
                $username1  = $_POST['username1'];
                $username2  = $_POST['username2'];
                // Drop from ALL Championships
                $query = $conn->query("SELECT `Event` FROM championships.champ_list");
                $champlist = $query->fetchAll(PDO::FETCH_COLUMN, 0);
                foreach ($champlist as $number => $champ) {
                    // Parse All championat
                    // Get `Complex` champ 
                    $query   = $conn->query("SELECT Complex FROM championships.champ_list WHERE `Event` = '$champ'");
                    $complex_champ = $query->fetch(); $complex_champ = $complex_champ[0];
                    if($complex_champ) {
                        // Drop from champ table if complex
                        try {   
                            $query = $conn->query("DELETE FROM championships.`$champ` WHERE `Username` IN (
                                SELECT `Username` FROM `usersinfo`.`credentials` WHERE `Number` BETWEEN 
                                (SELECT `Number` FROM `usersinfo`.`credentials` WHERE `Username`='$username1')
                                AND
                                (SELECT `Number` FROM `usersinfo`.`credentials` WHERE `Username`='$username2')
                            )");
                        }  catch (Exception $e) {
                            echo 'Exception: ',  $e->getMessage(), "\n";
                        } finally {
                            echo "NEXT\n";
                        }
                    }
                    else {
                        // Or Drop from all module champ table if not complex
                        $modules = ['A', 'B', 'C']; 
                        foreach ( $modules  as $module) {
                            $table = $champ . $module;
                            try {
                                $query = $conn->query("DELETE FROM championships.`$table` WHERE `Username` IN (
                                    SELECT `Username` FROM `usersinfo`.`credentials` WHERE `Number` BETWEEN 
                                    (SELECT `Number` FROM `usersinfo`.`credentials` WHERE `Username`='$username1')
                                    AND
                                    (SELECT `Number` FROM `usersinfo`.`credentials` WHERE `Username`='$username2')
                                )");
                            }  catch (Exception $e) {
                                echo 'Exception: ',  $e->getMessage(), "\n";
                            } finally {
                                echo "NEXT\n";
                            }
                        }
                    }
                }
                // Drop string from txt fiile
                $string=file_get_contents('data/9bc65c2abec141778ffaa729489f3e87.txt');
                $string=explode("\n",$string);
                // Query all user in range
                $query = $conn->query("SELECT `Username` FROM `usersinfo`.`credentials` WHERE `Number` BETWEEN 
                (SELECT `Number` FROM `usersinfo`.`credentials` WHERE `Username`='$username1')
                AND
                (SELECT `Number` FROM `usersinfo`.`credentials` WHERE `Username`='$username2')");
                $users = $query->fetchAll(PDO::FETCH_COLUMN, 0);

                //  Foreach all users and delete each from DB and file
                foreach ($users as $key => $username) {
                    $query      = $conn->query(
                        "DELETE FROM usersinfo.`credentials` WHERE Username='$username';
                        SET @i := 0;
                        UPDATE usersinfo.`credentials` SET  `Number` = (@i := @i + 1);
                        ALTER TABLE usersinfo.`credentials` AUTO_INCREMENT = 1;
                        DELETE FROM usersinfo.`currentstate` WHERE Username='$username';
                        ");
                    foreach($string as $key=>$value) {
                        $line=explode("/",$value);
                        // $line[0] - username 
                        // $line[1] - password
                        if( $line[0] == $username ) {
                            unset($string[$key]);
                        }
                    }
                }
                $string=implode("\n",$string);
                file_put_contents('data/9bc65c2abec141778ffaa729489f3e87.txt', $string);
                $_SESSION["event"] = True;
                $_SESSION["event_description"] = "USERNAME '$username1' - '$username2' ---> DROPED";
                break;
            case 'RenameUser':
                $username   = $_POST['username'];
                $newname    = $_POST['newname'];
                // Check that newname is not use
                $query  = $conn->query("SELECT EXISTS(SELECT Username FROM usersinfo.credentials WHERE Username = '$newname')");
                $check  = $query->fetch(); $check = $check[0];
                // If not available 
                if ($check) {
                    $_SESSION["error"] = True;
                    $_SESSION["error_description"] = "Username '$newname' is use";
                    break;
                }
                // Rename user in usersinfo
                $query = $conn->query(
                    "UPDATE `credentials` SET 
                    `Username`='$newname' WHERE `Username`='$username';
                    UPDATE `currentstate` SET 
                    `Username`='$newname' WHERE `Username`='$username';
                    "
                );
                // Change username in file
                
                // file_put_contents($path_to_file, $file_contents);

                // $string=file_get_contents('data/9bc65c2abec141778ffaa729489f3e87.txt');
                // $string=explode("\n",$string);
                // foreach($string as $key=>$value)
                // {
                //     // $line=explode("/",$value);
                //     // $line[0] - username 
                //     // $line[1] - password
                //     // if( $line[0] == $username ) {
                //         $file_contents = str_replace("$username", "$newname", $value);
                //     // }
                // }
                // $string=implode("\n",$string);
                // file_put_contents('data/9bc65c2abec141778ffaa729489f3e87.txt', $string);


                // Rename user in ALL championships
                $query = $conn->query("SELECT `Event` FROM championships.champ_list");
                $champlist = $query->fetchAll(PDO::FETCH_COLUMN, 0);
                foreach ($champlist as $number => $champ) {
                    // Parse All championat
                    // Get `Complex` champ 
                    $query   = $conn->query("SELECT Complex FROM championships.champ_list WHERE `Event` = '$champ'");
                    $complex_champ = $query->fetch(); $complex_champ = $complex_champ[0];
                    if($complex_champ) {
                        // Update from champ table if complex
                        try {
                            $query = $conn->query("UPDATE `championships`.`$champ` SET `Username`='$newname' WHERE `Username`='$username'");
                        }  catch (Exception $e) {
                            echo 'Exception: ',  $e->getMessage(), "\n";
                        } finally {
                            echo "NEXT\n";
                        }
                    }
                    else {
                        // Or Update from all module champ table if not complex
                        $modules = ['A', 'B', 'C']; 
                        foreach ( $modules  as $module) {
                            $table = $champ . $module;
                            try {
                                $query = $conn->query("UPDATE `championships`.`$table` SET `Username`='$newname' WHERE `Username`='$username'");
                            }  catch (Exception $e) {
                                echo 'Exception: ',  $e->getMessage(), "\n";
                            } finally {
                                echo "NEXT\n";
                            }
                        }
                    }
                }
                $_SESSION["event"] = True;
                $_SESSION["event_description"] = "$username ---> $newname";
                break;
            default: 
                break; 
        }
    }
    Redirect('admin/admin.php');
?>