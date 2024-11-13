<?php
include('db.php');
$message = '';
$alert_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $registration_id = $_POST['registration_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $workshop_id = $_POST['workshop_id'];

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $conn->prepare("INSERT INTO registrations (RegistrationID, ParticipantName, Email, Contact, Password, WorkshopID, RegistrationDate) 
                                VALUES (:registration_id, :name, :email, :contact, :password, :workshop_id, NOW())");
        $stmt->bindParam(':registration_id', $registration_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':workshop_id', $workshop_id);

        
        $stmt->execute();
        $message = "Workshop added successfully!";
        header("Location: /view/login_form_ui.php");
        $alert_type = "success";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
        header("Location: index.php");
        $alert_type = "error"; 
    }
}
?>
