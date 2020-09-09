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
        $device == 'CLI'        or  
        $device == 'FS'         or  
        $device == 'RDS'        or  
        $device == 'DC'         or  
        $device == 'Student'    or  
        $device == 'SRV1'       or  
        $device == 'SRV2'       or  
        $device == 'WEB'        or  
        $device == 'VPN'        or  
        $device == 'MON'        or  
        $device == 'Teacher'
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

        <!-- Left -->
        <div class="host CLI"
        onclick="callhost('<?php echo $links['CLI']; ?>');">
        </div>

        <div class="host Student"
        onclick="callhost('<?php echo $links['Student']; ?>');">
        </div>

        <div class="host DC"
        onclick="callhost('<?php echo $links['DC']; ?>');">
        </div>

        <div class="host FS"
        onclick="callhost('<?php echo $links['FS']; ?>');">
        </div>

        <div class="host RDS"
        onclick="callhost('<?php echo $links['RDS']; ?>');">
        </div>

        <div class="host RDS"
        onclick="callhost('<?php echo $links['RDS']; ?>');">
        </div>

        <div class="host SRV1"
        onclick="callhost('<?php echo $links['RDS']; ?>');">
        </div>

        <!-- Middle -->
        <div class="device S1"
        onclick="call('<?php echo $links['S1']; ?>');">
        </div>
        
        <div class="device S2"
        onclick="call('<?php echo $links['S2']; ?>');">
        </div>
        
        <div class="device S3"
        onclick="call('<?php echo $links['S3']; ?>');">
        </div>
        
        <div class="device R1"
        onclick="call('<?php echo $links['R1']; ?>');">
        </div>
        
        <div class="device R2"
        onclick="call('<?php echo $links['R2']; ?>');">
        </div>
        
        <div class="device ISP1"
        onclick="call('<?php echo $links['ISP1']; ?>');">
        </div>
        
        <div class="device ISP2"
        onclick="call('<?php echo $links['ISP2']; ?>');">
        </div>

        <!-- Right -->
        <div class="host SRV2"
        onclick="callhost('<?php echo $links['SRV2']; ?>');">
        </div>
        
        <div class="host WEB"
        onclick="callhost('<?php echo $links['WEB']; ?>');">
        </div>
        
        <div class="host VPN"
        onclick="callhost('<?php echo $links['VPN']; ?>');">
        </div>
        
        <div class="host MON"
        onclick="callhost('<?php echo $links['MON']; ?>');">
        </div>
        
        <div class="host Teacher"
        onclick="callhost('<?php echo $links['Teacher']; ?>');">
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
