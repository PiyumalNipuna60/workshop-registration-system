<?php
session_start();
include('db.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $participantID = $_POST['registration_id'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    try {
        if ($role == 'admin') {
            $stmt = $conn->prepare("SELECT * FROM admin WHERE AdminId = :participantID");
            $stmt->bindParam(':participantID', $participantID);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // if (password_verify($password, $user['Password'])) {
                    if ($password == $user['Password']) {
                    $message = "Login successful!";
                    $alert_type = "success";

                    session_start();
                    $_SESSION['user_id'] = $user['AdminId'];
                    $_SESSION['name'] = $user['Name'];
                    header("Location: view/admin_dashboard_form_ui.php");
                    exit();
                } else {
                    $message = "Incorrect password.";
                    $alert_type = "error";
                    header("Location: view/login_form_ui.php?error=Invalid credentials");
                }
            } else {
                $message = "Registration ID not found.";
                $alert_type = "error";
                header("Location: view/login_form_ui.php?error=Invalid credentials");
                exit();
            }

        } else {
            $stmt = $conn->prepare("SELECT * FROM participants WHERE ParticipantID = :registration_id");
            $stmt->bindParam(':registration_id', $participantID);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password, $user['Password'])) {
                    $message = "Login successful!";
                    $alert_type = "success";

                    session_start();
                    $_SESSION['user_id'] = $user['ParticipantID'];
                    $_SESSION['name'] = $user['ParticipantName'];
                    header("Location: view/user_dashboard_form_ui.php");
                    exit();
                } else {
                    $message = "Incorrect password.";
                    $alert_type = "error";
                    header("Location: view/login_form_ui.php?error=Invalid credentials");
                }
            } else {
                $message = "Registration ID not found.";
                $alert_type = "error";
                header("Location: view/login_form_ui.php?error=Invalid credentials2");
                exit();
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>