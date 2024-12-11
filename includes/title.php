<?php
$title = basename($_SERVER['SCRIPT_FILENAME'], '.php');
$title = str_replace('_', ' ', $title);
if ($title == 'index') {
    $title = 'home';
}
if ($title == 'logged out') {
    $title = 'logout';
}
if ($title == 'sign up') {
    $title = 'register';
}
if ($title == 'login') {
    $title = 'login';
}
if ($title == 'logged in') {
    $title = 'welcome';
}
$title = ucwords($title);
echo $title;
