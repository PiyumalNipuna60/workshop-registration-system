<?php
session_start();
include('../db.php');

if (!isset($_SESSION['name'])) {
    header("Location: ../login.php");
    exit();
}

$name = $_SESSION['name'];

try {
    $stmt = $conn->prepare("SELECT * FROM registrations");
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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/DashBordStyle.css">
    
</head>

<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h2>Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
            <br><br>
            <nav>
                <ul>
                    <div class="navbar">
                        <li><a href="admin_dashboard_form_ui.php">Workshops</a></li>
                        <li><a href="">Users</a></li>
                    </div>
                    <div class="logout-btn">
                        <li><a href="login_form_ui.php">Logout</a></li>
                    </div>
                </ul>
            </nav>
        </div>

        <div class="main-content" method="GET" action="../adminDashboard.php">
            <h2>All Users</h2>
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user_workshops as $workshop): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($workshop['Title']); ?></td>
                                <td><?php echo htmlspecialchars($workshop['Date']); ?></td>
                                <td><?php echo htmlspecialchars($workshop['Time']); ?></td>
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
