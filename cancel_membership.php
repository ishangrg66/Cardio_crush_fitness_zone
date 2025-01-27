<?php
session_start(); // Start the session
include_once "dbconnection.php";  // Include your DB connection

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $membership_id = $_POST['membership_id'];
    $user_id = $_SESSION['id']; // Assuming user is logged in and user_id is stored in session

    // Check if the membership exists for the user
    $query_check = $conn->prepare("SELECT * FROM memberships WHERE membership_id = ? AND id = ?");
    $query_check->bind_param("ii", $membership_id, $user_id);
    $query_check->execute();
    $result = $query_check->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('No matching membership found.');</script>";
        echo "<script>window.location.href = 'profile.php';</script>";
        exit();
    }

    // Update membership status to 'inactive'
    $query = $conn->prepare("UPDATE memberships SET status = ? WHERE membership_id = ? AND id = ?");
    $inactive_status = 'inactive';
    $query->bind_param("sii", $inactive_status, $membership_id, $user_id);

    if ($query->execute()) {
        echo "<script>alert('Your membership has been successfully cancelled and set to inactive.');</script>";
        echo "<script>window.location.href = 'profile.php';</script>";  // Redirect to profile page
    } else {
        echo "<script>alert('Failed to cancel membership. Please try again.');</script>";
        echo "<script>window.location.href = 'profile.php';</script>";  // Redirect to profile page
    }
}
