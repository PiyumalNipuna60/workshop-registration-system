<?php
session_start();
include(__DIR__ . '/../db.php');

if (!isset($_SESSION['name'])) {
    header("Location: ../login.php");
    exit();
}

$name = $_SESSION['name'];
$user_id = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("SELECT workshops.WorkshopID, workshops.Title, workshops.Date, workshops.Time, workshops.Location 
                            FROM workshops 
                            JOIN registrations ON workshops.WorkshopID = registrations.WorkshopID 
                            WHERE registrations.ParticipantID = :RegistrationID  
                            ORDER BY registrations.RegistrationDate ASC");
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
            <h2>Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
            <br>
            <br>
            <nav>
                <ul>
                    <div class="navbar">
                        <li><a href="user_dashboard_form_ui.php">My Workshops</a></li>
                        <li><a href="register_workshop_form_ui.php">Register for Workshop</a></li>
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
                            <th>Time</th>
                            <th>Location</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user_workshops as $workshop): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($workshop['Title']); ?></td>
                                <td><?php echo htmlspecialchars($workshop['Date']); ?></td>
                                <td><?php echo htmlspecialchars($workshop['Time']); ?></td>
                                <td><?php echo htmlspecialchars($workshop['Location']); ?></td>
                                <td>
                                    <form method="POST" style="display:inline;" action="../userDashboard.php" onsubmit="return confirm('Are you sure you want to delete this workshop?');">
                                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                        <input type="hidden" name="delete_id" value="<?php echo $workshop['WorkshopID']; ?>">
                                        <button type="submit" class="delete-btn" id="tableDeleteBtn"> <img src="assets/image/delete-icon.png" alt="Delete" width="20"></button>
                                    </form>
                                </td>
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