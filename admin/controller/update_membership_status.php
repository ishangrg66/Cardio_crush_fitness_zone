<?php
include_once "dbconnect.php";  // Include your DB connection

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $membership_id = $_POST['membership_id'];

    // Validate membership ID (ensure it's numeric)
    if (!is_numeric($membership_id)) {
        echo "<script>alert('Invalid membership ID.');</script>";
        echo "<script>window.location.href = '../index.php';</script>";
        exit();
    }

    if (isset($_POST['update_status'])) {
        $status = $_POST['update_status'];

        if ($status === 'active') {
            // Update payment status to 'verified' and membership status to 'active'
            $query = $conn->prepare("UPDATE memberships SET payment_status = ?, status = ? WHERE membership_id = ?");
            $payment_status = 'verified';
            $active_status = 'active';
            $query->bind_param("ssi", $payment_status, $active_status, $membership_id);

            if ($query->execute()) {
                echo "<script>alert('Membership activated successfully.');</script>";
            } else {
                echo "<script>alert('Failed to activate Membership.');</script>";
            }
        } elseif ($status === 'inactive') {
            // Update membership status to 'inactive'
            $query = $conn->prepare("UPDATE memberships SET status = ? WHERE membership_id = ?");
            $inactive_status = 'inactive';
            $query->bind_param("si", $inactive_status, $membership_id);

            if ($query->execute()) {
                echo "<script>alert('Membership marked as inactive.');</script>";
            } else {
                echo "<script>alert('Failed to mark Membership as inactive.');</script>";
            }
        } elseif ($status === 'rejected') {
            // Update membership status to 'rejected'
            $query = $conn->prepare("UPDATE memberships SET status = ? WHERE membership_id = ?");
            $rejected_status = 'rejected';
            $payment_status = 'rejected';
            $query->bind_param("si", $rejected_status, $membership_id);

            if ($query->execute()) {
                echo "<script>alert('Membership rejected successfully.');</script>";
            } else {
                echo "<script>alert('Failed to reject Membership.');</script>";
            }
        } elseif ($status === 'cancelled') {
            // Update membership status to 'canceled'
            $query = $conn->prepare("UPDATE memberships SET status = ? WHERE membership_id = ?");
            $canceled_status = 'cancelled';
            $payment_status = 'rejected';
            $query->bind_param("si", $canceled_status, $membership_id);

            if ($query->execute()) {
                echo "<script>alert('Membership cancelled successfully.');</script>";
            } else {
                echo "<script>alert('Failed to cancel Membership.');</script>";
            }
        }
    }

    // Redirect to prevent form resubmission
    echo "<script>window.location.href = '../index.php';</script>";
    exit();
}
