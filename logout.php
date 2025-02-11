<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page
$baseUrl = '/~jastiebl/ITdescription/admin_login.php'; // Adjust to the correct login page
header("Location: $baseUrl");
exit();
?>
