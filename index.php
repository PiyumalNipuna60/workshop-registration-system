<?php
include('db.php');

$stmt = $conn->prepare("SELECT MAX(RegistrationID) + 1 AS nextID FROM registrations");
$stmt->execute();
$nextRegistrationID = $stmt->fetchColumn();
if (!$nextRegistrationID) {
    $nextRegistrationID = 1;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshop Registration</title>
    <link rel="stylesheet" href="view/assets/style.css">

</head>

<body>
    <div class="form-container">
        <h1>Workshop Registration</h1>

        <form id="registrationForm" method="POST" action="register.php">
            <label for="registration_id">Registration ID:</label>
            <input type="text" id="registration_id" name="registration_id" value="<?php echo $nextRegistrationID; ?>"
                readonly>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="role">Select Role:</label>
            <select id="role" name="role" required>
                <option value="">-- Select Role --</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select><br>

            <label for="contact">Contact Information:</label>
            <input type="text" id="contact" name="contact" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="****" required><br><br>

            <label for="workshop_id">Select Workshop:</label>
            <select id="workshop_id" name="workshop_id" value="select" required>
                <?php
                $stmt = $conn->prepare("SELECT * FROM workshops");
                $stmt->execute();
                $workshops = $stmt->fetchAll();
                foreach ($workshops as $workshop) {
                    echo "<option value='{$workshop['WorkshopID']}'>{$workshop['Title']} - {$workshop['Date']} - {$workshop['Location']}</option>";
                }
                ?>
            </select><br><br>

            <div id="allButton">
                <button type="submit">Register</button>
                <div>
                    <a>Already have an account?</a>
                    <a href="view/login_form_ui.php"><button type="button">Login</button></a>
                </div>
            </div>
        </form>
        <div id="alertMessage" class="alert <?php echo $alert_type; ?>">
            <?php echo $message; ?>
        </div>
        <br>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            <?php if ($message): ?>
                var alertMessage = document.getElementById('alertMessage');
                alertMessage.style.display = 'block';
            <?php endif; ?>
        });
    </script>
</body>

</html>