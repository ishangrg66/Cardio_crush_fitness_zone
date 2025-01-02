<?php
include('dbconnection.php');

// Set header to indicate that the response will be in JSON format
header('Content-Type: application/json');

// Query to fetch plans
$sql = "SELECT plans_id, plan_name, description, duration, price FROM plans";
$result = $conn->query($sql);

// Check if any plans were found
if ($result->num_rows > 0) {
    $plans = [];
    while ($row = $result->fetch_assoc()) {
        $plans[] = $row; // Add each plan to the $plans array
    }
    // Return the plans as a JSON response
    echo json_encode($plans);
} else {
    // Return an empty array if no plans are found
    echo json_encode([]);
}

$conn->close();
?>
