<?php
  require_once($_SERVER['DOCUMENT_ROOT'].'/site/session.php');
  // If you are not logged -> Home
  if(!$_SESSION['status']) {
    $_SESSION['error'] = True;
    Redirect('');
  }
  // ElseIF admin -> redirect to admin page
  elseif($_SESSION['adminpriv']) {
    Redirect('admin/admin.php');
  }
  // ElseIF champ dont demo2020c1.2 -> redirect to admin page
  elseif($_SESSION['champ'] != 'demo2020c1.2') {
    Redirect('choice.php');
  }

  // TODO: Init stage
  
  $username = $_SESSION['username'];
  $password = $_SESSION['password'];
  $docker_address = $_SERVER['HTTP_HOST'] . ':2222/ssh/host/';
  $dir_images = '/images/' . $_SESSION['champ'];
  $champ    = $_SESSION['champ'];

  // Connect to DB
  $conn = ConnectToDB();

  // Get current module for user
  $query = $conn->query("SELECT Module FROM currentstate WHERE Username='$username'");
  $module = $query->fetch(); $module = $module[0];
  // If module not windows, redirect to choice
  if ($module != 'A') {
    Redirect('choice.php');
  }
  
  // Get links for username from DB
  $table = 'championships.`' . $_SESSION['champ'].$module.'`'; 
  $query = $conn->query("SELECT * FROM $table WHERE `Username`='$username' "); 
  $links = $query->fetch(PDO::FETCH_ASSOC);
  // TODO: Generate personal devices link
  // EXAMPLE
  // http:// $_SERVER['HTTP_HOST'] /ssh/host/10.11.8.4?header=Device&user=root&pass=toor
  
  $digi_address = $links['DIGIAddress'];
  $sql          = "SELECT NETWORK FROM championships.Devices WHERE `Champ` = '$champ'";
  $query        = $conn->query($sql);
  $NET_DEVICES      = $query->fetch(PDO::FETCH_ASSOC);
  $NET_DEVICES_LIST = preg_split("/,/", $NET_DEVICES['NETWORK']);
  foreach ($links as $device => $link) {
    if (array_search($device, $NET_DEVICES_LIST) === False) {
      // Not edit hosts link, DB give us normal links so continue
      continue;
    }
    // For device $links[$device] -> port 
    $port = $links[$device];
    $links[$device] =
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
   <link rel="stylesheet" type="text/css" href='/css/fonts.css'>
   <link rel="stylesheet" type="text/css" href='/css/master.css'>
   <link rel="stylesheet" type="text/css" href='/css/champs/<?php echo $_SESSION['champ']; ?>.css'>
   <script type="text/javascript" src="/scripts/function.js"></script>
   <title> <?php echo $_SESSION['champ'] ?> </title>
 </head>
 <body>
   <div class="top-panel">
     <div class="userinfo-top-panel">
        <?php
          echo 'You logged in as '.$_SESSION['username'];
        ?>
     </div>
     <div class="logout-top-panel">
        <a href="/choice.php">Back</a>
     </div>
   </div>
   <div class="main-content">
    <div class="main-scheme">
      <img src=" <?php echo $dir_images . '/' . $module . 'scheme.png'; ?>" alt="Scheme" class="main-scheme-image">
      <!-- Additionals -->
      <div class="additionals ESXi-L"
      onclick="callhost('<?php echo $links['ESXi']; ?>');">
      </div>
      <!-- Hosts -->
      <div class="host WinSRV1"
      onclick="callhost('<?php echo $links['WinSRV1']; ?>');">
      </div>
      <div class="host WinSRV2"
      onclick="callhost('<?php echo $links['WinSRV2']; ?>');">
      </div>
      <div class="host WinSRV3"
      onclick="callhost('<?php echo $links['WinSRV3']; ?>');">
      </div>
      <div class="host LinSRV2"
      onclick="callhost('<?php echo $links['LinSRV2']; ?>');">
      </div>
      <div class="host LinSRV1"
      onclick="callhost('<?php echo $links['LinSRV1']; ?>');">
      </div>
      <div class="host ISPl"
      onclick="callhost('<?php echo $links['ISPl']; ?>');">
      </div>
      <div class="host MagicMirror"
      onclick="callhost('<?php echo $links['MagicMirror']; ?>');">
      </div>
      <div class="host Remote-W"
      onclick="callhost('<?php echo $links['Remote-W']; ?>');">
      </div>
      <div class="host Remote-L"
      onclick="callhost('<?php echo $links['Remote-L']; ?>');">
      </div>
      
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
