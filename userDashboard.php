<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['user_email'];
$user_id = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("SELECT w.Title, w.Date, w.Location FROM registrations r JOIN workshops w ON r.WorkshopID = w.WorkshopID WHERE r.RegistrationID = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user_workshops = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

include 'view/user_dashboard_form_ui.php';
?>
