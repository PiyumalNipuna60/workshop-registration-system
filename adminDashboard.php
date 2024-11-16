<?php
session_start();
include('db.php');

// Handle deletion request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    try {
        $stmt = $conn->prepare("DELETE FROM registrations WHERE WorkshopID = :delete_id");
        $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $conn->prepare("DELETE FROM workshops WHERE WorkshopID = :delete_id");
        $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
        $stmt->execute();
        $message = "Workshop successfully deleted.";
    } catch (PDOException $e) {
        $message = "Error deleting workshop: " . $e->getMessage();
    }
    header("Location: view/admin_dashboard_form_ui.php");
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['ParticipantName'];
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $stmt = $conn->prepare("SELECT * from workshops");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user_workshops = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}



include 'view/admin_dashboard_form_ui.php';
?>
