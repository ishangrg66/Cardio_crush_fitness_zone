<?php
include_once "dbconnect.php";

if (isset($_POST['plan_submit'])) {
    $plan_name = $_POST['plan_name'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];

    // Use prepared statement to insert data
    $query = "INSERT INTO plans (plan_name, description, duration, price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ssii", $plan_name, $description, $duration, $price);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('New plan added successfully');</script>";
            echo "<script>window.location.href = '../index.php?plan=success';</script>";
        } else {
            echo "<script>alert('Error adding plan: " . $stmt->error . "');</script>";
            echo "<script>window.location.href = '../index.php?plan=error';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error preparing statement: " . $conn->error . "');</script>";
        echo "<script>window.location.href = '../index.php?plan=error';</script>";
    }
}

$conn->close();
?>
