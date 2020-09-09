<?php
  require_once('session.php');
  // If you are login -> redirect 
  if ($_SESSION['status']) {
    Redirect('choice.php');
  }
  // $dotenv = new \Dotenv\Dotenv(__DIR__);
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
    <main>
      <div class="center-div">
         <p>Welcome to <br>Remote Topology</p>
      </div>
      <form action="login.php" class="form" method="post">
        <p>Username:</p>
        <input type="text" name="username">
        <p>Password:</p>
        <input type="password" name="password">
        <p><input type="submit" value="Login"></p>
      </form>
      <?php if ($_SESSION["error"] == True): $_SESSION["error"] = False ?>
        <div class="login_error">
          <p>Something went wrong :(</p>
        </div>
      <?php endif; ?>
    </main>
    <footer>
      <p>
        Developed by 104auteam
        <a href='https://github.com/104auteam'><img src="images/github.png" alt="Github"></a>
      </p>
    </footer>
  </body>
</html>