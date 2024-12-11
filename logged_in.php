<?php
require_once '../reg_conn.php';
session_start();
if (isset($_SESSION['firstname'])) {

    $message = "You have successfully logged in to the BananaTech Customer Portal, $firstname";
    $message2 = "You are now logged in. Please use the menu at the right to navigate the site.";
} else {
    $message = 'You have reached this page in error';
    $message2 = 'Please use the menu at the right';
}
require 'includes/header.php';
echo '<h2>' . $message . '</h2>';
echo '<h3>' . $message2 . '</h3>';
include('includes/footer.php');
