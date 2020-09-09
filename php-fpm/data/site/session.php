<?php

// $_SESSION['username']          - save username
// $_SESSION['password']          - save password
// $_SESSION['status']            - check login status, true or false
// $_SESSION['adminpriv']         - admin privileges
// $_SESSION['champ']             - current championship for username
// $_SESSION['timer']             - current timer for champ
// $_SESSION['complex']           - True or False complex championship
// $_SESSION['error']             - Create error message
// $_SESSION["error_description"] - Description for errors
// $_SESSION["event"]             - Create event message
// $_SESSION["event_description"] - Description for events


@ob_start();
session_start();
error_reporting(0);

// Function for Redirect -> url
function Redirect($url)
{
	header('Location: http://' . $_SERVER['HTTP_HOST'] . '/' . $url);
	exit;
}

// Function for connect to Data
function ConnectToDB()
{
  $servername = "mysql:3306";
  $username   = "readonlyuser";
  $password   = "123#passwor#d321";
  $db         = "usersinfo";
  try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
  }
  catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
	}
	
}
 ?>
