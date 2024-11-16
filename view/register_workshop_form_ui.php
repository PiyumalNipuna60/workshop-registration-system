<?php
session_start();
include('../db.php');

if (!isset($_SESSION['name'])) {
    header("Location: ../login.php");
    exit();
}

$participantID = $_SESSION['user_id'];
$name = $_SESSION['name'];

try {
    $stmt = $conn->prepare("SELECT * FROM workshops");
    $stmt->execute();
    $workshops = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $workshopID = $_POST['workshop_id'] ?? null;

    if ($workshopID) {
        try {
            $stmt = $conn->prepare("INSERT INTO registrations (ParticipantID, WorkshopID, RegistrationDate) VALUES (:participantID, :workshopID, Now())");
            $stmt->bindParam(':participantID', $participantID, PDO::PARAM_INT);
            $stmt->bindParam(':workshopID', $workshopID, PDO::PARAM_INT);
            $stmt->execute();
            $message = "Workshop registered successfully!";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    } else {
        $message = "Please select a workshop to register.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Workshop</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="form-container">
        <h1>Register for a Workshop</h1>
        <?php if (isset($message)): ?>
            <p id="alert"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="POST" action="register_workshop_form_ui.php">
            <label for="workshop_id">Select Workshop:</label>
            <select id="workshop_id" name="workshop_id" required>
                <option value="">-- Select Workshop --</option>
                <?php foreach ($workshops as $workshop): ?>
                    <option value="<?php echo $workshop['WorkshopID']; ?>">
                        <?php echo htmlspecialchars("{$workshop['Title']} - {$workshop['Date']} - {$workshop['Location']}"); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br><br>
            <button type="submit">Register</button>
        </form>
    </div>
</body>

</html>
