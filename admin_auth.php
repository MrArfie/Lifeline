<?php
session_start();

function isValidAdminIP($ip, $allowedOctets) {
    $firstOctet = explode('.', $ip)[0]; // Get the first octet of user's IP
    return in_array($firstOctet, $allowedOctets);
}

$adminIP = $_SERVER['REMOTE_ADDR']; // Get the user's IP
$allowedOctets = [51, 94];

if (isValidAdminIP($adminIP, $allowedOctets) == false) {
    http_response_code(403);
    die("Access denied: You must be connected to the VPN. Your IP: " . $adminIP);
}


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
