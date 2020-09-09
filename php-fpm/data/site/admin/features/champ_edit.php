<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/site/session.php');
    // If you are not admin -> redirect to home
    if (!$_SESSION['adminpriv']) {
        Redirect('');
    }
    // ElseIF admin -> redirect to admin page
    
    // Init
    $username = $_SESSION['username'];
    // Connect to DB
    $conn = ConnectToDB();
    // Query module, champ and timer information
    
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="/css/fonts.css">
    <link rel="stylesheet" type="text/css" href="/css/master.css">
    <script type="text/javascript" src="/scripts/function.js"></script>
    <title>RemoteTopology</title>
  </head>
  <body>
  <div class="top-panel">
     <div class="userinfo-top-panel">
         <?
         echo 'You logged in as '.$username;
          ?>
     </div>
     <div class="logout-top-panel">
        <a href="/session_destroy.php">Logout</a>
     </div>
   </div>
    <div class="choice-main">
        
    </div>
    <footer>
      <p>
        Developed by 104auteam
        <a href='https://github.com/104auteam'><img src="/images/github.png" alt="Github"></a>
      </p>
    </footer>
  </body>
</html>
