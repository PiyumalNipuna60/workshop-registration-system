<?php
session_start();
include('db.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $registration_id = $_POST['registration_id'];
    $password = $_POST['password'];
    $role = $_POST['role'];

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
                        $_SESSION['user_id'] = $user['RegistrationID'];
                        $_SESSION['name'] = $user['ParticipantName'];
                        header("Location: view/user_dashboard_form_ui.php");
                if ($role != $user['role']) {
                    $message = "Invalid role selected.";
                    $alert_type = "error";
                    header("Location: view/login_form_ui.php?error=Invalid Role");
                    exit();
                } else {
                    $message = "Login successful!";
                        $alert_type = "success";

                        session_start();
                        $_SESSION['user_id'] = $user['RegistrationID'];
                        $_SESSION['name'] = $user['ParticipantName'];
                        $_SESSION['user_email'] = $user['Email'];
                    if ($role == 'admin') {
                       header("Location: view/admin_dashboard_form_ui.php");
                    }else{
                        header("Location: view/user_dashboard_form_ui.php");
                    }
                }

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
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>