<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "dbconnection.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT trainer_name, image FROM trainers";
$result = $conn->query($sql);

if (!$result) {
    die("Error in query: " . $conn->error);
}

$trainers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $trainers[] = $row;
    }
} else {
    die("No trainers found in the database.");
}

header('Content-Type: application/json');
echo json_encode($trainers, JSON_PRETTY_PRINT); // Add JSON_PRETTY_PRINT for better readability

$conn->close();

?>
