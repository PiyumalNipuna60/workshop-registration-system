<?php
include('db.php');
$message = '';
$alert_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $registration_id = $_POST['registration_id'];
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT * FROM registrations WHERE RegistrationID = :registration_id");
        $stmt->bindParam(':registration_id', $registration_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['Password'])) {
                $message = "Login successful!";
                $alert_type = "success";
                
                session_start();
                $_SESSION['user_id'] = $user['ParticipantID'];
                $_SESSION['name'] = $user['ParticipantName'];

                header("Location: dashboard.php");
                exit();
            } else {
                $message = "Incorrect password.";
                $alert_type = "error";
            }
        } else {
            $message = "Registration ID not found.";
            $alert_type = "error";
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
        $alert_type = "error"; 
    }
}
?>
