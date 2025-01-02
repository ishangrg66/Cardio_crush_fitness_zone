<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'cardiocrush';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['trainer_id']; // Trainer ID
    $name = $_POST['trainer_name']; // New name
    $image = $_FILES['image']['trainer_name']; // New image name
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['image']['trainer_name']);

    // Move the uploaded file to the server
    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
        // Update trainer data in the database
        $sql = "UPDATE trainers SET trainer_name = '$trainer_name', image = '$uploadFile' WHERE id = $trainer_id";
        if ($conn->query($sql) === TRUE) {
            header("Location: add_traines_form.php?success=Trainer added");
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "File upload error.";
    }
}

$conn->close();
?>
