<?php
require_once '../reg_conn.php';
session_start();
if (isset($_SESSION['firstname'])) {
    $message = "Thank you for using the BananaTech Customer Portal";
    $message2 = "See you next time!";
} else {
    $message = 'You have reached this page in error.';
    $message2 = 'Please use the menu at the right.';
}

$_SESSION = array();
session_destroy();
setcookie('PHPSESSID', '', time() - 3600, '/');

require 'includes/header.php';
echo '<h2>' . $message . '</h2>';
echo '<h3>' . $message2 . '</h3>';
include('includes/footer.php');
