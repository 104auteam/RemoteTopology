<?php
  require_once($_SERVER['DOCUMENT_ROOT'].'/site/session.php');
  // If you are nog logged -> Home
  if(!$_SESSION['status']) {
    $_SESSION['error'] = True;
    Redirect('');
  }
  // ElseIF admin -> redirect to admin page
  elseif($_SESSION['adminpriv']) {
    Redirect('admin/admin.php');
  }
  // ElseIF champ dont mejvuz -> redirect to admin page
  elseif($_SESSION['champ'] != 'mejvuz') {
    Redirect('choice.php');
  }

  // TODO: Init stage

  $username         = $_SESSION['username'];
  $password         = $_SESSION['password'];
  $dir_images       = '/images/' . $_SESSION['champ'];
  $docker_address   = $_SERVER['HTTP_HOST'] . ':2222/ssh/host/';
  $champ            = $_SESSION['champ'];

  // Connect to DB
  $conn = ConnectToDB();

  // Get links for username from DB
  $table            = $_SESSION['champ'];
  $query            = $conn->query("SELECT *  FROM championships.`$table` WHERE `Username`='$username' "); 
  $links            = $query->fetch(PDO::FETCH_ASSOC);
  
  $query            = $conn->query("SELECT `Timer` FROM championships.champ_list WHERE `Event`='$champ'");
  $result           = $query->fetch(PDO::FETCH_ASSOC);
  $timer            = $_SESSION['timer']    = $result['Timer'];

  // TODO: Generate personal devices link
  // EXAMPLE
  // http:// $_SERVER['HTTP_HOST'] /ssh/host/10.11.8.4?header=Device&user=root&pass=toor
  
  $digi_address     = $links['DIGIAddress'];
  $sql              = "SELECT NETWORK FROM championships.Devices WHERE `Champ` = '$champ'";
  $query            = $conn->query($sql);
  $NET_DEVICES      = $query->fetch(PDO::FETCH_ASSOC);
  $NET_DEVICES_LIST = preg_split("/,/", $NET_DEVICES['NETWORK']);
  $net_links        = [];

  foreach ($links as $device => $link) {
    if (array_search($device, $NET_DEVICES_LIST) === False) {
      // Not edit hosts link, DB give us normal links so continue
      continue;
    }
    // For device $links[$device] -> port 
    $port = $link;
    // $links[$device] =
    $net_links[$device] =
    'http://'.$docker_address.$digi_address.'?'.
            'header='.$device.'&'.
            'port='.$port.'&'.
            'user='.$username.'&'.
            'pass='.$password;
  }
?>
<!DOCTYPE html>
<html lang="en">
 <head>
   <meta charset="utf-8">
   <link rel="icon" type="image/png" href="/images/favicon.ico">
   <link rel="stylesheet" type="text/css" href="/css/fonts.css">
   <link rel="stylesheet" type="text/css" href="/css/master.css">
   <link rel="stylesheet" type="text/css" href='/css/champs/<?php echo $_SESSION['champ']; ?>.css'>
   <script type="text/javascript" src="/scripts/function.js"></script>
   <title><?php echo $_SESSION['champ']; ?></title>
 </head>
 <body>
   <div class="top-panel">
    <div class="userinfo-top-panel">
        <?php
            echo 'You logged in as '.$username;
        ?>
    </div>
    <div class="logout-top-panel">
        <a href="/choice.php">Back</a>
    </div>
  </div>

  <div class="main-content">
    <div class="main-scheme">
        <img src=" <?php echo $dir_images . '/' . $_SESSION['champ'] . '.png' ; ?> " alt="Scheme" class="main-scheme-image">

        <?php
          // Init 
          $sql      = "SELECT Complex FROM championships.Devices WHERE `Champ` = '$champ'";
          $query    = $conn->query($sql);
          $DEVICES  = $query->fetch(PDO::FETCH_ASSOC);
          $DEVICES_LIST = preg_split("/,/", $DEVICES['Complex']);

          // Generate VM LIST
          $vm_list = '';
          foreach($DEVICES_LIST as $key => $vm) {
            if(!in_array($vm, $NET_DEVICES_LIST) and $vm != 'DIGIAddress') {
              $vm_list .= $vm.',';
            }
          }
          $vm_list = substr($vm_list, 0, -1);  

          $query = $conn->query("SELECT * FROM `championships`.vcenter WHERE `username`='$username'");
          $vcenter = $query->fetch();

          $query    = 'http://api:5000/get-links?a=' . $vcenter['address'] . '&u=rtserviceacc@vsphere.local&p=jYYFrkj~B8_-%2B.%5B%3F&d=' . $vcenter['datacenter'] . '&v=' . $vm_list;
          $tickets  = json_decode(file_get_contents($query));
          echo $query;
          // Create div with VM links
          foreach ($tickets as $vm => $ticket) {
            echo "<div class='host $vm' ";
            echo "onclick=callhost('".$ticket."')>";
            echo "</div>";
          }

          // Create div with NETWORK links
          foreach ($net_links as $device => $link) {
            echo "<div class='device $device' ";
            echo "onclick=call('".$link."')>";
            echo "</div>";
          }
        ?>  
    </div>    
    <div class="timer top-left">
      <?php echo $_SESSION['timer']; ?>
    </div>
  </div>
  <footer>
    <p>
      Developed by 104auteam
      <a href='https://github.com/104auteam'><img src="/images/github.png" alt="Github"></a>
    </p>
  </footer>
 </body>
</html>
