<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $link = "https";
else
    $link = "http";
$link .= "://";
$link .= $_SERVER['HTTP_HOST'];
$link .= $_SERVER['REQUEST_URI'];
if (!isset($_SESSION['userdata']) && !strpos($link, 'login.php')) {
    redirect('bpi/login.php');
}
if (isset($_SESSION['userdata']) && strpos($link, 'login.php')) {
    redirect('bpi/index.php');
}
$module = array('', 'bpi', 'faculty', 'student');
if (isset($_SESSION['userdata']) && (strpos($link, 'index.php') || strpos($link, 'bpi/')) && $_SESSION['userdata']['login_type'] !=  4) {
    echo "<script>alert('Access Denied!');locbpion.replace('" . base_url . $module[$_SESSION['userdata']['login_type']] . "');</script>";
    exit;
}
