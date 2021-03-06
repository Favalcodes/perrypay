<?php
// Initialize the session
session_start();

require_once "config.php";
$client->revokeToken();
 
// Unset all of the session variables
$_SESSION = array();

$hour = time() - (3600 *24 * 30);
// setcookie('id', $id, $hour);
setcookie('email', $email, $hour);
setcookie('active', 1, $hour);

// Destroy the session.
session_destroy();

// Redirect to login page
header("location: login.php");
exit;
?>