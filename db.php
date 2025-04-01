<?php
// $host = "localhost";
// $user = "root";
// $pass = "";
// $dbname = "lifeline";

$host = 'lifelinedb.cb8ms8yg8ue3.ap-southeast-1.rds.amazonaws.com';
$dbname = 'lifeline'; 
$user = 'lifelineuser';
$pass = 'lifeline';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
