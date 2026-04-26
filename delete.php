<?php
session_start();
require 'database.php';

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}

$studentId = $_SESSION['student_id'];

try {
    // Delete the student from the database
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([$studentId]);

    // Destroy session and redirect to homepage
    session_unset();
    session_destroy();

    header('Location: login.php');
    exit;

} catch (PDOException $e) {
    echo "<div class='container mt-5 alert alert-danger'>Error deleting profile: " . $e->getMessage() . "</div>";
}
?>