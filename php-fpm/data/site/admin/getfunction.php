<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/site/session.php');
if (!$_SESSION['adminpriv']) {
    Redirect('');
}
// Just Get functions for action (for admin panel)
// If not admin -> to home
// INIT

// Save GET Params
$range  = $_GET['r'];
$action = $_GET['a'];

// Connect to DB
$conn = ConnectToDB();

// High user number in $MAX
$query = $conn->query("SELECT MAX(Number) FROM credentials"); $result = $query->fetch();
$MAX = $result[0];

// Select user list in $SELECT_USERS
// $SELECT_USERS_GET -> tempplate for get info from DB on Module
// An open tag is declared in the block where it is used.
$SELECT_USERS       = '<select name="username" class="admin-select">';
for ($userNumber = 1; $userNumber <= $MAX; $userNumber++) { 
    // Query Username
    $query = $conn->query("SELECT `Username` FROM `credentials` WHERE `Number`=$userNumber AND `adminpriv`=0");
    $username = $query->fetch();
    if(!$username[0]) {
        continue;
    }
    $SELECT_USERS        .= '<option value=' . $username[0] . ' class="admin-select" id="username">' . $username[0] . '</option>';    
    $SELECT_USERS_GET  .= '<option value=' . $username[0] . ' class="admin-select" id="username">' . $username[0] . '</option>';            
}
$SELECT_USERS       .= '</select>';
$SELECT_USERS_GET   .= '</select>';

// onchange="showUser(this.value)"
// Select modules in $SELECT_MODULES
$modules = array('A','B','C');
$SELECT_MODULES = '<select name="module" class="admin-select">';
foreach ($modules as $module) {
    $SELECT_MODULES .= '<option value=' . $module . ' class="admin-select">' . $module . '</option>';    
}
$SELECT_MODULES .= '</select>';

// Select Champ in $SELECT_CHAMP
$query = $conn->query("SELECT `Event` FROM championships.champ_list");
$championships = $query->fetchAll(PDO::FETCH_COLUMN, 0);
$SELECT_CHAMP = '<select name="champ" class="admin-select">';
foreach ($championships as $champ) {
    $SELECT_CHAMP .= '<option value=' . $champ . ' class="admin-select">' . $champ . '</option>';    
}
$SELECT_CHAMP .= '</select>';
// TODO: MAIN getfunction
switch ($action) {
    case 'TRY':
        // Code Block FOR TryState
        switch ($range) {
            case 'ALL':
                echo <<< EOT
                <br>
                <input type="radio" id="activate" name="activate" value="True">
                <label for="activate">Activate </label>
                <input type="radio" id="deactivate" name="activate" value="False">
                <label for="deactivate">Deactivate </label>
                <input type="hidden" name="action" value="ChangeStateAll">
                <input type="submit" value="Apply">
                EOT;
                break;
            case 'RANGE':
                echo <<< EOT
                <br>
                <input type="radio" id="activateUsers" name="activateUser" value="True">
                <label for="activateUsers">Activate</label>
                <input type="radio" id="deactivateUsers" name="activateUser" value="False">
                <label for="deactivateUsers">Deactivate</label>
                <select name="username1" class="admin-select">
                EOT;
                echo $SELECT_USERS_GET;
                echo '<select name="username2" class="admin-select">';
                echo $SELECT_USERS_GET;
                echo <<< EOT
                <input type="hidden" name="action" value="ChangeStateUsers">
                <input type="submit" value="Apply">
                EOT;
                break;
            case 'USER':
                echo <<< EOT
                <br>
                <input type="radio" id="activateUser" name="activateUser" value="True">
                <label for="activateUser">Activate</label>
                <input type="radio" id="deactivateUser" name="activateUser" value="False">
                <label for="deactivateUser">Deactivate</label>
                EOT;
                echo $SELECT_USERS;
                echo <<< EOT
                <input type="hidden" name="action" value="ChangeStateUser">
                <input type="submit" value="Apply">    
                EOT;
                break;
        }        
        break;
    case 'MODULE':
        // Code Block FOR Module
        switch ($range) {
            case 'ALL':
                echo '<br>';
                echo $SELECT_MODULES;
                echo <<< EOT
                <input type="hidden" name="action" value="ChangeModuleAll">
                <input type="submit" value="Apply">
                EOT;
                break;
            case 'RANGE':
                echo <<< EOT
                <br>
                <select name="username1" class="admin-select">
                EOT;
                echo $SELECT_USERS_GET;
                echo '<select name="username2" class="admin-select">';
                echo $SELECT_USERS_GET;
                echo $SELECT_MODULES;
                echo <<< EOT
                <input type="hidden" name="action" value="ChangeModuleUsers">
                <input type="submit" value="Apply">
                EOT;
                break;
            case 'USER':
                echo '<br>';
                echo $SELECT_USERS;
                echo $SELECT_MODULES;
                echo <<< EOT
                <input type="hidden" name="action" value="ChangeModuleUser">
                <input type="submit" value="Apply">
                EOT;
                break;
            }
        break;
    case 'CHAMP':
        // Code Block FOR Champs
        switch ($range) {
            case 'ALL':
                echo '<br>';
                echo $SELECT_CHAMP;
                echo <<< EOT
                <input type="hidden" name="action" value="ChangeChampAll">
                <input type="submit" value="Apply">   
                EOT;
                break;
            case 'RANGE':
                echo <<< EOT
                <br>
                <select name="username1" class="admin-select">
                EOT;
                echo $SELECT_USERS_GET;
                echo '<select name="username2" class="admin-select">';
                echo $SELECT_USERS_GET;
                echo $SELECT_CHAMP;
                echo <<< EOT
                <input type="hidden" name="action" value="ChangeChampUsers">
                <input type="submit" value="Apply">
                EOT;
                break;
            case 'USER':
                echo '<br>';
                echo $SELECT_USERS;
                echo $SELECT_CHAMP;
                echo <<< EOT
                <input type="hidden" name="action" value="ChangeChampUser">
                <input type="submit" value="Apply"> 
                EOT;
                break;
            }
        break;
    case 'DROP':
        // Code Block FOR DROP User(s)
        switch ($range) {
            case 'RANGE':
                echo <<< EOT
                <br>
                <select name="username1" class="admin-select">
                EOT;
                echo $SELECT_USERS_GET;
                echo '<select name="username2" class="admin-select">';
                echo $SELECT_USERS_GET;
                echo <<< EOT
                <input type="hidden" name="action" value="DropUsers">
                <input type="submit" value="Apply">
                EOT;
                break;
            case 'USER':
                echo '<br>';
                echo $SELECT_USERS;
                echo <<< EOT
                <input type="hidden" name="action" value="DropUser">
                <input type="submit" value="Apply">    
                EOT;
                break;
        }
        break;
    default:
        # code...
        break;
}


?>