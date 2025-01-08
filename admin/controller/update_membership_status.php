<?php
include_once "dbconnect.php";  // Include your DB connection

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $membership_id = $_POST['membership_id'];

    if (isset($_POST['update_status'])) {
        $status = $_POST['update_status'];

        if ($status === 'active') {
            // Update payment status and membership status to active
            $update_payment_query = $conn->prepare("UPDATE memberships SET payment_status = ?, status = ? WHERE membership_id = ?");
            $active_status = 'active';
            $update_payment_query->bind_param("ssi", $status, $active_status, $membership_id);

            if ($update_payment_query->execute()) {
                echo "<script>alert('Membership activated successfully.');</script>";
                echo "<script>window.location.href = '../index.php';</script>";
                exit();
            } else {
                echo "<script>alert('Failed to activate membership.');</script>";
                echo "<script>window.location.href = '../index.php';</script>";
                exit();
            }
        } elseif ($status === 'rejected') {
            // Delete membership record when status is rejected
            $delete_query = $conn->prepare("DELETE FROM memberships WHERE membership_id = ?");
            $delete_query->bind_param("i", $membership_id);

            if ($delete_query->execute()) {
                echo "<script>alert('Membership successfully rejected and deleted.');</script>";
                echo "<script>window.location.href = '../index.php';</script>";
                exit();
            } else {
                echo "<script>alert('Failed to delete rejected membership.');</script>";
                echo "<script>window.location.href = '../index.php';</script>";
                exit();
            }
        }
    } elseif (isset($_POST['cancel_membership'])) {
        // Delete membership record when admin cancels it
        $cancel_query = $conn->prepare("DELETE FROM memberships WHERE membership_id = ?");
        $cancel_query->bind_param("i", $membership_id);

        if ($cancel_query->execute()) {
            echo "<script>alert('Membership successfully cancelled.');</script>";
            echo "<script>window.location.href = '../index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to cancel membership.');</script>";
            echo "<script>window.location.href = '../index.php';</script>";
            exit();
        }
    }
}
?>