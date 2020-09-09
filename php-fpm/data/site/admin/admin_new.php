<?php
    require_once('../session.php');
    // If you are not admin -> redirect to home
    if (!$_SESSION['adminpriv']) {
        Redirect('');
    }
    // Init

    // Connect to DB
    $conn = ConnectToDB();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="/css/fonts.css">
    <link rel="stylesheet" type="text/css" href="/css/master.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery.accordion.css">
    <link rel="stylesheet" type="text/css" href="/css/admin.css">
    <script src="/scripts/jquery-3.5.0.min.js"></script>
    <script src="/scripts/jquery.accordion.js"></script>
    <script src="/scripts/function.js"></script>
    <title>RemoteTopology</title>
    <style>
        html {
            -moz-user-select: auto;
            -khtml-user-select: auto;
            user-select: auto;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            showRecords(25, 1);
        });
    </script>
  </head>
  <body>
    <div class="admin-top-panel">
        <div class="admin-top-panel-functionblock">
            <div class="admin-top-panel-functionblock-function">
                <img src="/images/admin/users.png" alt="users">
                USERS
            </div>
            <div class="admin-top-panel-functionblock-function">
                <img src="/images/admin/stands.png" alt="stands">
                STANDS
            </div>
            <div class="admin-top-panel-functionblock-function">
                <img src="/images/admin/championships.png" alt="championships">
                CHAMPIONSHIPS
            </div>
            <div class="admin-top-panel-functionblock-function">
                <img src="/images/admin/servers.png" alt="servers">
                SERVERS
            </div>
            <div class="admin-top-panel-functionblock-function">
                <img src="/images/admin/report.png" alt="report">
                REPORT
            </div>
        </div>
        <div class="admin-top-panel-usersinfo">
            <a href="/session_destroy.php">
                <img src="/images/admin/signout.png" alt="Logout">
            </a>
        </div>
    </div>
    <div class="admin-info">
        <div class="loader"></div>
        <div id="results"></div>
    </div>
    <footer>
      <p>
        Developed by 104auteam
        <a href='https://github.com/104auteam'><img src="/images/github.png" alt="Github"></a>
      </p>
    </footer>
  </body>
</html>
