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
        $stmt = $conn->prepare("INSERT INTO participants VALUES (:registration_id, :name, :contact, :email, :password, NOW())");
        $stmt->bindParam(':registration_id', $registration_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        
            // $stmt = $conn->prepare("INSERT INTO registrations VALUES (:registration_id, :workshop_id, NOW())");
            // $stmt->bindParam(':registration_id', $registration_id);
            // $stmt->bindParam(':workshop_id', $workshop_id);
        

        
        $message = "Workshop added successfully!";
        $alert_type = "success";
        header("Location: view/login_form_ui.php");
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
        $alert_type = "error";
        header("Location: index.php");
    }
}
?>
