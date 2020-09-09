<?php
require_once('session.php');
$vpn_destroy = $_GET['vpnd'];
if ($vpn_destroy) {
  // If admin -> not disconnect 
  if ($_SESSION['adminpriv']) Redirect('admin/admin.php');

  // Init
  $host    = "10.11.8.250";
  $name    = "ded";
  $pass    = "P@ssw0rd";
  $methods = array(
    'kex' => 'diffie-hellman-group14-sha1',
    'client_to_server' => array(
      'crypt' => 'aes256-ctr',
      'mac'   => 'hmac-sha1',
      'comp'  => 'none'),
    'server_to_client' => array(
      'crypt' => 'aes256-ctr',
      'mac'   => 'hmac-sha1',
      'comp'  => 'none'));
  $callbacks = array('disconnect' => 'my_ssh_disconnect');
  
  // Connect and auth on Cisco ASA
  $conn = ssh2_connect($host, 22, $methods, $callbacks);
  if (!$conn) die('Failed');
  ssh2_auth_password($conn, $name, $pass);  
  
  // Write to stdio disconnect command
  $stdio_stream = ssh2_shell($conn);
  fwrite($stdio_stream,'vpn-sessiondb logoff name '. $_SESSION['username'] .' noconfirm'."\n");
  sleep(1);
  // Get contents and execute command :)
  stream_get_contents($stdio_stream); 

  // Destroy all variable
  fclose($stream);
  ssh2_disconnect($conn);
  unset($conn);

  // Deactivate session
  session_destroy();
  Redirect('');
} else {
  // Just logout :)
  session_destroy();
  Redirect('');
}
 ?>
