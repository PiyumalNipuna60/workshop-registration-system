<?php
session_start();
include('../db.php');

if (!isset($_SESSION['name'])) {
    header("Location: ../login.php");
    exit();
}

$name = $_SESSION['name'];

try {
    $stmt = $conn->prepare("SELECT ParticipantID,ParticipantName,Contact,Email,RegistrationDate FROM participants");
    $stmt->execute();
    $users= $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if (!isset($users) || empty($users)) {
    $users = [];
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

        <div class="main-content">
            <h2>All Users</h2>
            <br>
            <br>
            <?php if (!empty($users)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ParticipantID</th>
                            <th>ParticipantName</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>RegistrationDate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $allUsers): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($allUsers['ParticipantID']); ?></td>
                                <td><?php echo htmlspecialchars($allUsers['ParticipantName']); ?></td>
                                <td><?php echo htmlspecialchars($allUsers['Contact']); ?></td>
                                <td><?php echo htmlspecialchars($allUsers['Email']); ?></td>
                                <td><?php echo htmlspecialchars($allUsers['RegistrationDate']); ?></td>
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
