<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once '../db.php';  

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tripName = trim($_POST['tripName'] ?? '');
    $destination = trim($_POST['destination'] ?? '');
    $start_date = $_POST['startDate'] ?? '';
    $end_date = $_POST['endDate'] ?? '';
    $notes = trim($_POST['notes'] ?? '');

    if ($tripName === '' || $destination === '' || $start_date === '' || $end_date === '') {
        die("Please fill in all required fields.");
    }

    $stmt = $conn->prepare("INSERT INTO trips (user_id, tripName, destination, start_date, end_date, notes) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("isssss", $user_id, $tripName, $destination, $start_date, $end_date, $notes);

    if ($stmt->execute()) {
        header("Location: tripPlanner.php?success=1");
        exit;
    } else {
        die("Execute failed: " . $stmt->error);
    }
}
?>
