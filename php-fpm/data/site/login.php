<?php
  require_once('session.php');
  // Redirect if logged
  if ($_SESSION['status']) {
    Redirect('choice.php');
  }
  // Init
  // Save user and password info
  $username = $_SESSION['username'] = $_POST['username'];
  $password = $_SESSION['password'] = $_POST['password'];
  
  // Connect to DB
  $conn = ConnectToDB();
  
  // Query Username
  $query = $conn->query("SELECT `Username` FROM `credentials` WHERE `Username`='$username' ");
  $usernameFromBD = $query->fetch();

  // Query Password
  $query = $conn->query("SELECT `Password` FROM `credentials` WHERE `Username`='$username' ");
  $passwordFromBD = $query->fetch();

  // AdminStatus
  $query = $conn->query("SELECT `adminpriv` FROM `credentials` WHERE `Username`='$username' ");
  $adminpriv = $query->fetch();
  $_SESSION['adminpriv'] = $adminpriv[0];
  
  // Query Try State
  $query = $conn->query("SELECT State FROM `currentstate` WHERE `Username`='$usernameFromBD[0]'");
  $trystate = $query->fetch();
 
  // Check that username and MD5 password are matched with DataBase
  // And check TryState
  if ($usernameFromBD[0] == $_SESSION['username'] and $passwordFromBD[0] == md5($_SESSION['password']) and $trystate[0] == True ) {
    $_SESSION['status'] = True;
    $_SESSION['error']  = False;
    // If Admin redirect to choice.php
    if ($_SESSION['adminpriv']) {
      Redirect('admin/admin.php');
    } 
    else {
      // If not Admin redirect to choice.php
      Redirect('choice.php');
    }
  }
  // If match DB parameters or trystate give false result 
  else {
    $_SESSION['status'] = False;
    $_SESSION['error']  = True;
    Redirect('');
  }
?>