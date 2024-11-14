<?php
session_start();
include('../db.php');

if (!isset($_SESSION['user_email'])) {
    header("Location: ../login.php");
    exit();
}

$user_email = $_SESSION['user_email'];

try {
    $stmt = $conn->prepare("SELECT workshops.Title, workshops.Date, workshops.Location 
                            FROM workshops 
                            JOIN registrations ON workshops.WorkshopID = registrations.WorkshopID 
                            WHERE registrations.RegistrationID = :RegistrationID");
    $stmt->bindParam(':RegistrationID', $_SESSION['user_id']);
    $stmt->execute();
    $user_workshops = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if (!isset($user_workshops) || empty($user_workshops)) {
    $user_workshops = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="assets/DashBordStyle.css">
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Welcome, <?php echo htmlspecialchars($user_email); ?>!</h2>
            <br>
            <br>
            <nav>
                <ul>
                    <div class="navbar">
                        <li><a href="user_dashboard_form_ui.php">My Workshops</a></li>
                        <li><a href="register.php">Register for Workshop</a></li>
                    </div>
                    <div class="logout-btn">
                        <li><a href="login_form_ui.php">Logout</a></li>
                    </div>
                </ul>
            </nav>
        </div>

        <!-- Main content displaying workshops -->
        <div class="main-content">
            <h2>Your Workshops</h2>
            <br>
            <br>
            <?php if (!empty($user_workshops)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Workshop Title</th>
                            <th>Date</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user_workshops as $workshop): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($workshop['Title']); ?></td>
                                <td><?php echo htmlspecialchars($workshop['Date']); ?></td>
                                <td><?php echo htmlspecialchars($workshop['Location']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No workshops registered yet..!</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>