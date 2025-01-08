<?php
include 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if all required fields are present
    if (!isset($_POST['plans_id'], $_POST['plan_name'], $_POST['description'], $_POST['duration'], $_POST['price'])) {
        echo "<script>alert('All fields are required. Please fill out the form correctly.'); window.history.back();</script>";
        exit;
    }

    // Sanitize inputs
    $plans_id = (int) $_POST['plans_id']; // plans_id is passed from the frontend
    $plan_name = trim($_POST['plan_name']);
    $description = trim($_POST['description']);
    $duration = filter_var($_POST['duration'], FILTER_VALIDATE_INT);
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);

    // Check if the sanitized values are valid
    if (!$plans_id || !$plan_name || !$description || !$duration || !$price) {
        echo "<script>alert('Invalid input. Please check the values and try again.'); window.history.back();</script>";
        exit;
    }

    // Proceed to update the database
    $sql = "UPDATE plans SET plan_name = ?, description = ?, duration = ?, price = ? WHERE plans_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssidi", $plan_name, $description, $duration, $price, $plans_id);

        if ($stmt->execute()) {
            echo "<script>alert('Plan updated successfully.'); window.location.href = '../index.php';</script>";
        } else {
            echo "<script>alert('Failed to update plan: " . $stmt->error . "'); window.history.back();</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Failed to prepare statement: " . $conn->error . "'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request method.'); window.history.back();</script>";
}

$conn->close();
?>
