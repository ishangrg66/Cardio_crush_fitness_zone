<?php
include('db.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    // Sanitize and validate inputs
    $plan_name = isset($_POST['plan_name']) ? $conn->real_escape_string($_POST['plan_name']) : null;
    $description = isset($_POST['description']) ? $conn->real_escape_string($_POST['description']) : null;
    $duration = isset($_POST['duration']) ? (int) $_POST['duration'] : null;
    $price = isset($_POST['price']) ? (float) $_POST['price'] : null;

    // Check if all fields are filled
    if ($plan_name && $description && $duration && $price) {
        // Insert query (Auto-increment will handle plan_id)
        $sql = "INSERT INTO plans (plan_name, description, duration, price) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Check for errors in prepare
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        // Bind parameters
        if (!$stmt->bind_param("ssdi", $plan_name, $description, $duration, $price)) {
            die("Bind failed: " . $stmt->error);
        }

        // Execute the query
        if ($stmt->execute()) {
            echo "Plan added successfully!";
            header("Location: add_plans.php?success=Plan added");
            exit;
        } else {
            die("Execute failed: " . $stmt->error);
        }

        // Close statement
        $stmt->close();
    } else {
        header("Location: add_plans.php?error=Please fill all fields correctly.");
        exit();
    }

    // Close the database connection
    $conn->close();
}
?>
