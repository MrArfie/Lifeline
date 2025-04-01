<?php

session_start();
require 'db.php';
require 'audit_logger.php';

if (isset($_SESSION['user_id'])) {
    log_action($conn, $_SESSION['user_id'], 'logout', "User {$_SESSION['name']} logged out");
}

session_unset();
session_destroy();
header("Location: login.php");
exit();

?>
