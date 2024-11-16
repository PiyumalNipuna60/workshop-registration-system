<?php
session_start();
include('../db.php');

if (!isset($_SESSION['name'])) {
    header("Location: ../login.php");
    exit();
}

$name = $_SESSION['name'];

try {
    $stmt = $conn->prepare("SELECT * FROM workshops");
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
                        <li><a href="all_users_form_ui.php">Users</a></li>
                    </div>
                    <div class="logout-btn">
                        <li><a href="login_form_ui.php">Logout</a></li>
                    </div>
                </ul>
            </nav>
        </div>

        <div class="main-content" method="GET" action="../adminDashboard.php">
            <h2>Workshops</h2>
            <br>
            <button id="addWorkshopBtn">Add Workshop</button>
            <br><br>
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
                                    <form method="POST" style="display:inline;" action="../adminDashboard.php" onsubmit="return confirm('Are you sure you want to delete this workshop?');">
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

    <div class="modal-overlay" id="modalOverlay"></div>
    <div class="modal-container" id="modalContainer">
        <button class="close-modal" id="closeModalBtn">&times;</button>
        <h1>Workshop Registration</h1>

        <form id="registrationForm" method="POST" action="../addWorkshop.php">
            <label for="title">Workshop Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <button type="submit" id="addButton">Add Workshop</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const addWorkshopBtn = document.getElementById('addWorkshopBtn');
            const modalOverlay = document.getElementById('modalOverlay');
            const modalContainer = document.getElementById('modalContainer');
            const closeModalBtn = document.getElementById('closeModalBtn');

            addWorkshopBtn.addEventListener('click', () => {
                modalOverlay.classList.add('show');
                modalContainer.classList.add('show');
            });

            closeModalBtn.addEventListener('click', () => {
                modalOverlay.classList.remove('show');
                modalContainer.classList.remove('show');
            });

            modalOverlay.addEventListener('click', () => {
                modalOverlay.classList.remove('show');
                modalContainer.classList.remove('show');
            });
        });
    </script>
</body>

</html>
