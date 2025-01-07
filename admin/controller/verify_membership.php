<?php
include_once "dbconnect.php";  // Include your DB connection

if (isset($_GET['membership_id']) && isset($_GET['action'])) {
    $membership_id = $_GET['membership_id'];
    $action = $_GET['action'];

    if ($action === 'accept') {
        $status = 'accepted';  // Update the status to accepted
    } elseif ($action === 'reject') {
        $status = 'rejected';  // Update the status to rejected
    } else {
        echo json_encode(['success' => false]);
        exit;
    }

    // Update the membership status
    $sql = "UPDATE memberships SET status = ? WHERE membership_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $membership_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false]);
}
?>
