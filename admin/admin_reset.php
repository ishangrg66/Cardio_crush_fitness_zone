<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'cardiocrush';

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the actions
if (isset($_POST['action'])) {
    // Delete Trainer
    if ($_POST['action'] == 'delete' && isset($_POST['trainer_name']) && isset($_POST['phone_number'])) {
        $trainer_name = $_POST['trainer_name'];
        $phone_number = $_POST['phone_number'];

        // Use trainer name and phone number to delete
        $stmt = $conn->prepare("DELETE FROM trainers WHERE trainer_name = ? AND phone_number = ?");
        $stmt->bind_param("ss", $trainer_name, $phone_number);

        if ($stmt->execute()) {
            echo "Trainer with name $trainer_name and phone number $phone_number deleted successfully.";
        } else {
            echo "Error deleting trainer: " . $conn->error;
        }

        // After deletion, reset the AUTO_INCREMENT if the table is empty
        $result = $conn->query("SELECT COUNT(*) AS count FROM trainers");
        $row = $result->fetch_assoc();
        $conn->query("ALTER TABLE trainers AUTO_INCREMENT = 1");

    // Update Trainer
    } elseif ($_POST['action'] == 'update' && isset($_POST['trainer_id'])) {
        $trainer_id = intval($_POST['trainer_id']);
        $trainer_name = $_POST['trainer_name'];
        $image = $_FILES['image']['name'];
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($image);

        // Move the uploaded file to the server
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            // Update trainer details in the database
            $sql = "UPDATE trainers SET trainer_name = '$trainer_name', image = '$uploadFile' WHERE trainer_id = $trainer_id";
            if ($conn->query($sql) === TRUE) {
                echo "Trainer with ID $trainer_id updated successfully.";
            } else {
                echo "Error updating trainer: " . $conn->error;
            }
        } else {
            echo "Failed to upload the image.";
        }

    } else {
        echo "Invalid action or missing parameters.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Trainer Management</title>
</head>
<body>
    <h2>Admin Panel - Manage Trainers</h2>

    <!-- Form to Delete Trainer -->
    <h3>Delete Trainer</h3>
    <form method="POST" action="admin_reset.php">
        <input type="hidden" name="action" value="delete">
        
        <label for="trainer_name">Trainer Name to Delete:</label>
        <input type="text" name="trainer_name" required><br>
        
        <label for="phone_number">Trainer Phone Number:</label>
        <input type="text" name="phone_number" required><br>

        <button type="submit">Delete Trainer</button>
    </form>

</body>
</html>
