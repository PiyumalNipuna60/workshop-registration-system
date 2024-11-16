<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];

    try {
        $stmt = $conn->prepare("INSERT INTO workshops (Title, Date, Time, Location) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $date, $time, $location]);

        echo json_encode([
            'success' => true,
            'workshop' => [
                'Title' => $title,
                'Date' => $date,
                'Time' => $time,
                'Location' => $location,
            ],
        ]);
        header("Location: view/admin_dashboard_form_ui.php");
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        header("Location: view/admin_dashboard_form_ui.php");
    }

 
}
?>
