<?php
include_once "dbconnect.php";

// Check if membership_id and action are passed via POST
if (isset($_POST['membership_id']) && isset($_POST['action'])) {
    $membership_id = (int) $_POST['membership_id'];
    $action = $_POST['action'];

    // If action is to accept, update the status to active
    if ($action == 'active') {
        $sql = "UPDATE memberships SET status = 'active' WHERE membership_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $membership_id);
            if ($stmt->execute()) {
                echo "Membership status updated to active.";
            } else {
                echo "Error updating membership status: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    }
    // If action is to reject, delete the membership from the database
    elseif ($action == 'reject') {
        $sql = "DELETE FROM memberships WHERE membership_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $membership_id);
            if ($stmt->execute()) {
                echo "Membership rejected and removed from the database.";
            } else {
                echo "Error rejecting membership: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "Invalid action.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
