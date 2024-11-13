<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "workshop_system";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, 1234);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
