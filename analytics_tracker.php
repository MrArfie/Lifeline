<?php
function get_client_ip() {
    return $_SERVER['HTTP_CLIENT_IP'] 
        ?? $_SERVER['HTTP_X_FORWARDED_FOR'] 
        ?? $_SERVER['REMOTE_ADDR'];
}

function get_user_agent_info() {
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $os = 'Unknown OS';
    $browser = 'Unknown Browser';
    $device = 'Unknown';

    if (preg_match('/windows nt 10/i', $agent)) $os = 'Windows 10';
    elseif (preg_match('/android/i', $agent)) $os = 'Android';
    elseif (preg_match('/iphone/i', $agent)) $os = 'iOS';
    elseif (preg_match('/macintosh/i', $agent)) $os = 'macOS';
    elseif (preg_match('/linux/i', $agent)) $os = 'Linux';

    if (preg_match('/chrome/i', $agent)) $browser = 'Chrome';
    elseif (preg_match('/firefox/i', $agent)) $browser = 'Firefox';
    elseif (preg_match('/safari/i', $agent) && !preg_match('/chrome/i', $agent)) $browser = 'Safari';
    elseif (preg_match('/edg/i', $agent)) $browser = 'Edge';

    $device = preg_match('/mobile/i', $agent) ? 'Mobile' : 'Desktop';

    return [$os, $browser, $device, $agent];
}

function track_user_analytics($conn, $user_id = null) {
    $ip = get_client_ip();
    list($os, $browser, $device, $user_agent) = get_user_agent_info();
    $location = ''; // optional: use geo-ip

    $stmt = $conn->prepare("INSERT INTO analytics (user_id, ip_address, user_agent, os, browser, device_type, location) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $user_id, $ip, $user_agent, $os, $browser, $device, $location);
    $stmt->execute();
}

?>