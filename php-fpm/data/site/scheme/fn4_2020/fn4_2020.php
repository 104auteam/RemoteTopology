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
  elseif($_SESSION['champ'] != 'fn4_2020') {
    Redirect('choice.php');
  }

  // TODO: Init stage

  $username = $_SESSION['username'];
  $password = $_SESSION['password'];
  $dir_images = '/images/' . $_SESSION['champ'];
  $docker_address = $_SERVER['HTTP_HOST'] . ':2222/ssh/host/';

  // Connect to DB
  $conn = ConnectToDB();

  // Get links for username from DB
  $table  = $_SESSION['champ'];
  $query  = $conn->query("SELECT *  FROM championships.`$table` WHERE `Username`='$username' "); 
  $links  = $query->fetch(PDO::FETCH_ASSOC);

  // TODO: Generate personal devices link
  // EXAMPLE
  // http:// $_SERVER['HTTP_HOST'] /ssh/host/10.11.8.4?header=Device&user=root&pass=toor
  $digi_address = $links['DIGIAddress'];
  
  foreach ($links as $device => $link) {
    if ( 
        $device != 'FW'         or  
        $device != 'RTR'        or  
        $device != 'BRANCH'     or  
        $device != 'SW1'        or  
        $device != 'SW2'        or  
        $device != 'SW3'
    ) 
    {
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
        
        <!-- Network -->

        <div class="device FW"
        onclick="call('<?php echo $links['FW']; ?>');">
        </div>
        <div class="device RTR"
        onclick="call('<?php echo $links['RTR']; ?>');">
        </div>
        <div class="device BRANCH"
        onclick="call('<?php echo $links['BRANCH']; ?>');">
        </div>
        <div class="device SW1"
        onclick="call('<?php echo $links['SW1']; ?>');">
        </div>
        <div class="device SW2"
        onclick="call('<?php echo $links['SW2']; ?>');">
        </div>
        <div class="device SW3"
        onclick="call('<?php echo $links['SW3']; ?>');">
        </div>

        <!-- VM -->

        <div class="host LIN-RTR"
        onclick="callhost('<?php echo $links['LIN-RTR']; ?>');">
        </div>
        <div class="host CLI1-L"
        onclick="callhost('<?php echo $links['CLI1-L']; ?>');">
        </div>
        <div class="host CLI2-L"
        onclick="callhost('<?php echo $links['CLI2-L']; ?>');">
        </div>
        <div class="host CLI1-W"
        onclick="callhost('<?php echo $links['CLI1-W']; ?>');">
        </div>
        <div class="host CLI2-W"
        onclick="callhost('<?php echo $links['CLI2-W']; ?>');">
        </div>
        <div class="host DS-W"
        onclick="callhost('<?php echo $links['DS-W']; ?>');">
        </div>
        <div class="host CS"
        onclick="callhost('<?php echo $links['CS']; ?>');">
        </div>
        <div class="host FS-W"
        onclick="callhost('<?php echo $links['FS-W']; ?>');">
        </div>
        <div class="host FS-L"
        onclick="callhost('<?php echo $links['FS-L']; ?>');">
        </div>
        <div class="host RAD-L"
        onclick="callhost('<?php echo $links['RAD-L']; ?>');">
        </div>
        <div class="host DMZ-W"
        onclick="callhost('<?php echo $links['DMZ-W']; ?>');">
        </div>
        <div class="host BRANCH-DC-W"
        onclick="callhost('<?php echo $links['BRANCH-DC-W']; ?>');">
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
