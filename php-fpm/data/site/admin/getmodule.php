<?php
  require_once($_SERVER['DOCUMENT_ROOT'].'/site/session.php');
    if (!$_SESSION['adminpriv']) {
        Redirect('');
    }
    // Just Get module table for username (for admin panel)
    // If not admin -> to home

    // INIT
    $q       = $_GET['q'];
    $module  = $_GET['m'];
    $conn    = ConnectToDB();
    $query   = $conn->query("SELECT Championship FROM usersinfo.currentstate WHERE `Username` = '$q'");
    $champ   = $query->fetch(); $champ = $champ[0];

    // Set Device list in DEVICES_LIST:
    // $DEVICES_LIST[0] => 'L-CLI-A'
    // $DEVICES_LIST[1] => 'L-CLI-B'
    $query   = $conn->query("SELECT Complex FROM championships.champ_list WHERE `Event` = '$champ'");
    $complex_champ = $query->fetch(); $complex_champ = $complex_champ[0];
    if ($complex_champ == True) {
        $table          = 'championships.`' . $champ . '`';
        $sql            = "SELECT Complex FROM championships.Devices WHERE `Champ` = '$champ'";
        $query          = $conn->query($sql);
        $DEVICES        = $query->fetch(PDO::FETCH_ASSOC);
        $DEVICES_LIST   = preg_split("/,/", $DEVICES['Complex']);
    }
    else {
        $table          = 'championships.`' . $champ . $module . '`';
        $sql            = "SELECT $module FROM championships.Devices WHERE `Champ` = '$champ'";
        $query          = $conn->query($sql);
        $DEVICES        = $query->fetch(PDO::FETCH_ASSOC);
        $DEVICES_LIST   = preg_split("/,/", $DEVICES[$module]);
    }


    $query = $conn->query("SELECT * FROM championships.vcenter WHERE `username`='$q'");
    $vcenter = $query->fetch();
    

    // For DEBUG
    // foreach ($DEVICES as $device) {
    //     echo $device;
    // }
    // Create Table with devices
    echo "<table class='admin-table-main'>
    <tr>
    <th>Device</th>
    <th>Link</th>
    </tr>";
    $query = $conn->query("SELECT * FROM $table WHERE `Username` = '$q'");
    $result = $query->fetch(PDO::FETCH_ASSOC);

    foreach ($DEVICES_LIST as $device) {
        echo "<tr>";
        echo "<td>" . $device . "</td>";
        echo "<td><input type='text' class='admin-get-link-input' value='" . $result[$device] . "' name='" . $device . "' </td>";
        echo "</tr>";
    }
    echo "</table>";

    echo "<input placeholder='address' value='" .  $vcenter['address'] . "'      name='v_address'>
        <input placeholder='password' value='" .   $vcenter['password'] . "'      name='v_pass'>
        <input placeholder='datacenter' value='" . $vcenter['datacenter'] . "'  name='v_dc'>";
    echo "<input type='submit' value='Update'>";
    // END
?>