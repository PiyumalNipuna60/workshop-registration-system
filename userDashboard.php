<?php
include('db.php');


// Handle deletion request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $user_id = $_POST['user_id'];

    try {
        $stmt = $conn->prepare("DELETE FROM registrations WHERE WorkshopID = :delete_id AND ParticipantID = :user_id");
        $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $message = "Workshop successfully deleted.";
    } catch (PDOException $e) {
        $message = "Error deleting workshop: " . $e->getMessage();
    }
    header("Location: view/user_dashboard_form_ui.php");
}
?>
