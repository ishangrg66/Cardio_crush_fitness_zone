<?php
include('dbconnection.php');
session_start();

// Check if the admin is logged in
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");  // Redirect if not an admin
    exit;
}
!
<h2>Pending Payments</h2>
<table>
    <tr>
        <th>User</th>
        <th>Plan</th>
        <th>Amount Paid</th>
        <th>Payment Screenshot</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

// Fetch all pending payments
$payments_query = "SELECT p.payment_id, p.membership_id, m.id AS user_id, m.start_date, m.end_date, p.amount, p.payment_proof, p.status AS payment_status
                   FROM payments p
                   JOIN memberships m ON p.membership_id = m.membership_id
                   WHERE p.status = 'pending'";

$payments_result = $conn->query($payments_query);

if ($payments_result->num_rows > 0) {
    while ($payment = $payments_result->fetch_assoc()) {
        echo "<div>";
        echo "<p>User ID: {$payment['user_id']}</p>";
        echo "<p>Start Date: {$payment['start_date']}</p>";
        echo "<p>End Date: {$payment['end_date']}</p>";
        echo "<p>Amount: {$payment['amount']}</p>";
        echo "<p>Status: {$payment['payment_status']}</p>";
        echo "<p><a href='verify_payment.php?payment_id={$payment['payment_id']}'>Verify Payment</a> | 
                  <a href='reject_payment.php?payment_id={$payment['payment_id']}'>Reject Payment</a></p>";
        echo "</div>";
    }
} else {
    echo "No pending payments.";
}
?>
