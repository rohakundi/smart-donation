
<?php

session_start();

// Remove all session data
$_SESSION = [];

// Destroy the login session
session_destroy();

// Return user to login page
header("Location: login.php");
exit;

?>
