<?php
// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();

$hour = time() - (3600 *24 * 30);
setcookie('id', $id, $hour);
setcookie('email', $email, $hour);
setcookie('active', 1, $hour);

// Redirect to login page
header("location: login.php");
exit;
?>